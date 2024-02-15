<?php
 use App\Models\UsersModel;
 ?>
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Reservation Voucher Discount Report
                </h2>
            </div>
        </div>
        <!--<form id="filterForm">
            <div class="row">
                <div class="col-md-3">
                    <label class="text-uppercase text-sm">Branch</label>
                    <select name="branchid" id="branchid" onchange="filter(0)" style="width: 100%;" class="form-control mb">
                        <option value="">Select</option>
                        <?php
                        foreach ($lookups['branchlookup'] as $result) :
                        ?>
                            <option value="<?php echo $result->branchid; ?>" <?php echo (isset($_GET['branchid']) && $_GET['branchid'] != "" && $_GET['branchid'] == $result->branchid) ? "selected" : "" ?>><?php echo $result->branchname; ?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="text-uppercase text-sm">Wallet Type</label>
                    <select name="wallettypeid" id="wallettypeid" onchange="filter(0)" style="width: 100%;" class="form-control mb">
                        <option value="">Select</option>
                        <?php
                        foreach ($lookups['wallettypelookup'] as $result) :
                        ?>
                            <option value="<?php echo $result->wallettypeid; ?>" <?php echo (isset($_GET['wallettypeid']) && $_GET['wallettypeid'] != "" && $_GET['wallettypeid'] == $result->wallettypeid) ? "selected" : "" ?>><?php echo $result->wallettypename; ?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </div>
            </div>
        </form> -->
        <a class="btn btn-primary" onclick="filter(1)">Download</a>
        <br />
        <br />
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <style>
                            table,
                            th,
                            td {
                                border: 1px solid black;
                                border-collapse: collapse;
                            }
                        </style>
                        <table class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>Reservation/Application Details</th>
                                    <th>Created By</th>
                                    <th>Status</th>
                                    <th>Approved By</th>
                                    <th>Approved Date</th>
                                    <th>Created Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($report_discount != null) :
                                    foreach ($report_discount as $result) :
                                ?>
                                        <tr>
                                            <td>
                                                <b>Reservation/Application Number:</b> <?php echo $result->reservation_ukey ?><br />
                                                <b>Name:</b> <?php echo $result->name ?><br />
                                                 <b>Requested First Year Amount:</b> <?php echo $result->firstyearamount ?><br />
                                                 <b>Requested Second Year Amount:</b> <?php echo $result->secondyearamount ?><br />
                                                 <?php if($result->status==1)
                                                 {
                                                     ?>
                                                     <b>Approved First Year Amount:</b> <?php echo $result->approvedfirstyearamount ?><br />
                                                    <b>Approved Second Year Amount:</b> <?php echo $result->approvedsecondyearamount ?><br />
                                                     <?php
                                                     
                                                 }
                                                 ?>
                                                 <b>Comments:</b> <?php echo $result->reason ?><br />
                                                 <b>Voucher Type</b> <?php echo $result->vouchertype;?>
                                            </td>
                                             <td>
                                                <?php echo $result->createdby ?>
                                            </td>
                                             <td>
                                                <?php
                                                if($result->status==0){
                                                    echo "Pending";
                                                }else{
                                                    echo "Approved";
                                                }?>
                                            </td>
                                            <td>
                                                <?php echo $result->approvedby ?>
                                            </td>
                                            <td>
                                                <?php echo $result->approved_date;?>
                                            </td>
                                            <td>
                                                <?php echo $result->date ?>
                                            </td>
                                           
                                        </tr>
                                <?php endforeach;
                                endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function filter(download = 0) {
        var URL = "<?php echo base_url('reports/report_reservationdiscount') ?>" + "?" + $('#filterForm').serialize();

        if (download == 1) {
            URL = URL + "&download=1";
        }

        window.location.href = URL;
    }
</script>