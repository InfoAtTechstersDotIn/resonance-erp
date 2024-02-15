<?php
use App\Models\WalletModel;
?>
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Noc
                    <?php

                    use App\Models\HelperModel;
                    use App\Models\PaymentsModel;
                    ?>
                </h2>
                <form>
                    <div class="row">
                        <div class="col-md-3">
                            <select name="branchid" style="width: 100%;" class="form-control">
                                <option value="">Select Branch</option>
                                <?php
                                foreach ($lookups['branchlookup'] as $branch) :
                                ?>
                                    <option value="<?php echo $branch->branchid; ?>" <?php echo isset($_GET['branchid']) && $_GET['branchid'] == $branch->branchid ? "selected" : "" ?>><?php echo $branch->branchname; ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="courseid" style="width: 100%;" class="form-control">
                                <option value="">Select Course</option>
                                <?php
                                foreach ($lookups['courselookup'] as $course) :
                                ?>
                                    <option value="<?php echo $course->courseid; ?>" <?php echo isset($_GET['courseid']) && $_GET['courseid'] == $course->courseid ? "selected" : "" ?>><?php echo $course->coursename; ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="sectionid" style="width: 100%;" class="form-control mb">
                                <option value="">Select Section</option>
                                <?php
                                foreach ($lookups['sectionlookup'] as $section) :
                                ?>
                                    <option value="<?php echo $section->sectionid; ?>"><?php echo $section->sectionname; ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </div>

                </form>
                <br />
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblStudents" class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>Application Number</th>
                                    <th>Student Name</th>
                                    <th>Noc Status</th>
                                    <th>Print</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($invoiceDetails as $result) :
                                    if (isset($_GET['branchid'])) {
                                        if ($_GET['branchid'] == "" || $result->branchid == $_GET['branchid']) {
                                        } else {
                                            continue;
                                        }
                                    }
                                    if (isset($_GET['courseid'])) {
                                        if ($_GET['courseid'] == "" || $result->courseid == $_GET['courseid']) {
                                        } else {
                                            continue;
                                        }
                                    }
                                    if (isset($_GET['sectionid'])) {
                                        if ($_GET['sectionid'] == "" || $result->sectionid == $_GET['sectionid']) {
                                        } else {
                                            continue;
                                        }
                                    }
                                ?>
                                    <tr>
                                        <?php

                                        ?>
                                        <td><?php echo $result->applicationnumber ?>
                                        </td>
                                        <?php
                                        if ($_SESSION['rights'][array_search('Student', array_column($_SESSION['rights'], 'operationname'))]->_edit == 1 || $result->applicationstatusname == "Declined") : ?>
                                            <td>
                                                <a target="_blank" href="<?php echo base_url('users/studentdetails') ?>?id=<?php echo $result->userid; ?>"><?php echo $result->name ?></a>
                                            </td>
                                        <?php
                                        else :
                                        ?>
                                            <td><?php echo $result->name ?></td>
                                        <?php
                                        endif;
                                        ?>
                                        <td>
                                            <?php
                                             $walletModel = new WalletModel();
                                             $walletData = $walletModel->getWalletDetails($result->userid, 6);
                                             $Laundry = COUNT($walletData) > 0 ? $walletData[0]->amount : 0;
                                             if($result->admissiontypeid==1){
                                                if ($result->TotalPaid >= $result->TotalValue && $Laundry>0) {
                                                    echo "Yes";
                                                } else {
                                                    echo "No";
                                                }
                                            }else
                                            {
                                                if ($result->TotalPaid >= $result->TotalValue) {
                                                    echo "Yes";
                                                } else {
                                                    echo "No";
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <a class="btn btn-success" 
                                            <?php 
                                            if($result->admissiontypeid==1){
                                            if ($result->TotalPaid >= $result->TotalValue &&  $Laundry>0) : ?> href="<?php echo base_url('forms/noDueCertificate?userId=') . $result->userid ?>" <?php else : ?> disabled <?php endif; 
                                            }else
                                            {
                                                if ($result->TotalPaid >= $result->TotalValue ) : ?> href="<?php echo base_url('forms/noDueCertificate?userId=') . $result->userid ?>" <?php else : ?> disabled <?php endif; 
                                            }?>
                                            onclick="printDiv('div')">Print</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="modal fade" id="Resofast" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document" style="width: 80vw">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title">Load Student Details From Resofast</h2>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="get" action="<?php echo base_url('users/addstudent') ?>">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="text-uppercase text-sm">Reso Fast Hallticket Number</label>
                                            <input type="text" placeholder="Reso Fast Hallticket Number" name="resofast" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <br />
                                            <button type="submit" class="btn btn-primary">Load</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="Registration" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document" style="width: 80vw">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title">Load Student Details From Registrations</h2>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="get" action="<?php echo base_url('users/addstudent') ?>">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="text-uppercase text-sm">Registration Id</label>
                                            <input type="text" placeholder="Registration Id" name="registration" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <br />
                                            <button type="submit" class="btn btn-primary">Load</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.btn-del').on('click', function(e) {
        e.preventDefault();
        const href = $(this).attr('href')
        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this Data!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    document.location.href = href;
                }
            })

    })
</script>