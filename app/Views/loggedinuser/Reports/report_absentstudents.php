<?php
use App\Models\UsersModel;
?>
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Student Absent Report
                </h2>
            </div>
        </div>
        <form id="filterForm">
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
                    <label class="text-uppercase text-sm">Date</label>
                    <input type="text" onchange="filter(0)" placeholder="From Date" name="FromDate" class="datepicker form-control mb" value="<?php echo (isset($_GET['FromDate']) && $_GET['FromDate'] != "") ? $_GET['FromDate'] : "" ?>">
                </div>
                <!--<div class="col-md-3">-->
                <!--    <label class="text-uppercase text-sm">Attendance Date To</label>-->
                <!--    <input type="text" onchange="filter(0)" placeholder="To Date" name="ToDate" class="datepicker form-control mb" value="<?php echo (isset($_GET['ToDate']) && $_GET['ToDate'] != "") ? $_GET['ToDate'] : "" ?>">-->
                <!--</div>-->
                
            </div>
        </form>
        <br>
        <a class="btn btn-primary" onclick="filter(1)">Download</a>
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
                                    <th>Student Name</th>
                                    <th>Application Number</th>
                                     <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                               
                                foreach ($absentlog as $employee) :
                                ?>
                                    <tr>
                                        <td>
                                            <b><?php echo $employee->name ; ?></b>
                                        </td>
                                        <td>
                                            <b><?php echo $employee->applicationnumber ; ?></b>
                                        </td>
                                        <td>
                                            <?php echo $employee->date ; ?>
                                        </td>
                                    </tr>
                                <?php endforeach;
                                ?>
                                
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
        var URL = "<?php echo base_url('reports/report_absentlog') ?>" + "?" + $('#filterForm').serialize();

        if (download == 1) {
            URL = URL + "&download=1";
        }

        window.location.href = URL;
    }
</script>