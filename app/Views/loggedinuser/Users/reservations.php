<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Reservations
                    <?php

                    use App\Models\HelperModel;
                    use App\Models\ReservationModel;
                    if ($_SESSION['rights'][array_search('Student', array_column($_SESSION['rights'], 'operationname'))]->_add == 1) : ?>
                        <a target="_blank" class="btn btn-default" href="<?php echo base_url("users/addReservation") ?>" style="float: right;">Add Reservation</a>
                    <?php endif; ?>
                </h2>
                <form>
                    <div class="row">
                        <div class="col-md-4">
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
                        <div class="col-md-4">
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
                        <div class="col-md-4">
                            <select name="admissiontypeid" style="width: 100%;" class="form-control">
                                <option value="">Select Admission Type</option>
                                <?php
                                foreach ($lookups['admissiontypelookup'] as $admissiontype) :
                                ?>
                                    <option value="<?php echo $admissiontype->admissiontypeid; ?>" <?php echo isset($_GET['admissiontypeid']) && $_GET['admissiontypeid'] == $admissiontype->admissiontypeid ? "selected" : "" ?>><?php echo $admissiontype->admissiontypename; ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                            <br />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <select name="reservationstatusid" style="width: 100%;" class="form-control">
                                <option value="">Select Reservation Status</option>
                                <?php
                                foreach ($lookups['reservationstatuslookup'] as $reservationstatus) :
                                ?>
                                    <option value="<?php echo $reservationstatus->reservationstatusid; ?>" <?php echo isset($_GET['reservationstatusid']) && $_GET['reservationstatusid'] == $reservationstatus->reservationstatusid ? "selected" : "" ?>><?php echo $reservationstatus->reservationstatusname; ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select name="secondlanguageid" style="width: 100%;" class="form-control">
                                <option value="">Select Second Language</option>
                                <?php
                                foreach ($lookups['secondlanguagelookup'] as $secondlanguage) :
                                ?>
                                    <option value="<?php echo $secondlanguage->secondlanguageid; ?>" <?php echo isset($_GET['secondlanguageid']) && $_GET['secondlanguageid'] == $secondlanguage->secondlanguageid ? "selected" : "" ?>><?php echo $secondlanguage->secondlanguagename; ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4">
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
                                    <th>Reservation Id</th>
                                    <th>Student Name</th>
                                    <th>Reservation Status</th>
                                    <th>Gender</th>
                                    <th>Branch - Cource - Admission Type</th>
                                    <th>Mobile/ Email</th>
                                    <th>Comments</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                foreach ($reservations as $result) :
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
                                    if (isset($_GET['admissiontypeid'])) {
                                        if ($_GET['admissiontypeid'] == "" || $result->admissiontypeid == $_GET['admissiontypeid']) {
                                        } else {
                                            continue;
                                        }
                                    }
                                    if (isset($_GET['reservationstatusid'])) {
                                        if ($_GET['reservationstatusid'] == "" || $result->reservationstatusid == $_GET['reservationstatusid']) {
                                        } else {
                                            continue;
                                        }
                                    }
                                    if (isset($_GET['secondlanguageid'])) {
                                        if ($_GET['secondlanguageid'] == "" || $result->secondlanguageid == $_GET['secondlanguageid']) {
                                        } else {
                                            continue;
                                        }
                                    }
                                ?>
                                    <tr>
                                        <td><a target="_blank" href="<?php echo base_url('users/reservationDetails?id=' . $result->reservationid ) ?>"><?php echo $result->reservation_ukey ?></a>
                                         <?php if($result->is_profile_uploaded == 1){
                                         ?>
                                         Image <i class="fa fa-check" aria-hidden="true" style="color: green;font-size: 25px;"></i>
                                         <?php
                                     }
                                     ?>
                                        <?php
                                     $reservationModel = new ReservationModel();
                                   $PaymentDetail = $reservationModel->getReservationPaymentDetailsByReservationId($result->reservationid);
                                   $totalPayment=0;
                                   foreach ($PaymentDetail as $payment) :
                                       $totalPayment = $totalPayment+$payment->paymentamount;
                                    //if( $payment->paymentstatusid == 3)
                                   // {
                                        
                                    //}
                                   endforeach;
                                   $helperModel = new HelperModel();
                                  $ipe =  $helperModel->get_fees_from_lookup($result->courseid, $result->admissiontypeid, $result->batchid, 'Intermediate Fee');
                                   $tution =  $helperModel->get_fees_from_lookup($result->courseid, $result->admissiontypeid, $result->batchid, 'Tuition Fee');
                                    $hostel =  $helperModel->get_fees_from_lookup($result->courseid, $result->admissiontypeid, $result->batchid, 'Hostel Fee');
                                     $laundry =  $helperModel->get_fees_from_lookup($result->courseid, $result->admissiontypeid, $result->batchid, 'Laundry');
                                     $uniform =  $helperModel->get_fees_from_lookup($result->courseid, $result->admissiontypeid, $result->batchid, 'Uniform');
                                      $books =  $helperModel->get_fees_from_lookup($result->courseid, $result->admissiontypeid, $result->batchid, 'Books');
                                       $caution =  $helperModel->get_fees_from_lookup($result->courseid, $result->admissiontypeid, $result->batchid, 'Caution Deposit');
                                   $finalfee = ($tution + $hostel + $ipe + $laundry + $books + $caution + $uniform)- $result->discountgiven;
                                  // echo $result->tuition_discount;
                                   //echo $finalfee;
                                  $halffee = (40 / 100) * $finalfee;
                                  $halffee = $finalfee/2;
                                    if($result->reservationstatusname=="Approved" && $totalPayment >= 12500 &&  $result->is_migrate==0)
                                    {
                                        echo "<a href='" . base_url('users/migratestudent?id=') . $result->reservationid . "' class='btn btn-success'>Migrate</a>";
                                    }
                                    if($result->is_migrate==1)
                                    {
                                        echo "<a class='btn btn-success'>Migrated</a>";
                                    }
                                    ?>
                                        </td>
                                        <td><?php echo $result->name ?></td>
                                        <td><?php echo $result->reservationstatusname ?></td>
                                        <td><?php echo $result->gendername ?></td>
                                        <td><?php echo $result->branchname . "<br />" . $result->coursename . "<br />" . $result->admissiontypename ?></td>
                                        <td><?php echo $result->mobile1 . "<br />" . $result->mobile2 . "<br />" . $result->email ?></td>
                                        <td><?php echo $result->comments; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
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