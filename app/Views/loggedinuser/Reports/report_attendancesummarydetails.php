<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Daily Attendance Summary Report
                </h2>
            </div>
        </div>
        <form id="filterForm">
            <div class="row">
                <div class="col-md-3">
                    <label class="text-uppercase text-sm"> Date From</label>
                    <input type="text" onchange="filter(0)" placeholder="Date From" name="DateFrom" class="datepicker form-control mb" value="<?php echo (isset($_GET['DateFrom']) && $_GET['DateFrom'] != "") ? $_GET['DateFrom'] : "" ?>">
                </div>
                <!--<div class="col-md-3">-->
                <!--    <label class="text-uppercase text-sm"> Date To</label>-->
                <!--    <input type="text" onchange="filter(0)" placeholder="Date To" name="DateTo" class="datepicker form-control mb" value="<?php echo (isset($_GET['DateTo']) && $_GET['DateTo'] != "") ? $_GET['DateTo'] : "" ?>">-->
                <!--</div>-->
            </div>
        </form>
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
                        <table class="table table-striped">
                            <?php
                            $arrTotalTransactions = [];
                            $arrTotalAmount = [];
                             $arrTotalAmount1 = [];

                            $totalTotalTrasactions = 0;
                            $totalTotalAmount = 0;
                             $totalTotalAmount1 = 0;

                            ?>
                            <thead>
                                <tr>
                                    <th rowspan="2">Branch</th>

                                    <?php
                                    foreach ($lookups['courselookup'] as $res) {
                                        $arrTotalTransactions[$res->courseid] = 0;
                                        $arrTotalAmount[$res->courseid] = 0;
                                        $arrTotalAmount1[$res->courseid] = 0;
                                    ?>
                                        <th colspan="3"><?php echo $res->coursename; ?></th>
                                        
                                    <?php } ?>
                                    <th colspan="3">Total</th>
                                </tr>
                                <tr>
                                    <?php
                                    foreach ($lookups['courselookup'] as $res) {
                                    ?>
                                        <th>Total</th>
                                        <th>Present</th>
                                        <th>Absent</th>
                                    <?php } ?>
                                    <th>Total</th>
                                    <th>Present</th>
                                    <th>Absent</th>
                                </tr>
                            </thead>
                            <?php
                            ?>
                            <tbody>
                                <?php
                               
                                foreach ($lookups['branchlookup'] as $branch) :
                                ?>
                                    <tr>
                                        <td>
                                            <b><?php echo $branch->branchname ?></b>
                                        </td>
                                        <?php
                                    $Branchstudents =0;
                                    $BranchPresentstudents =0;
                                    $BranchAbsentstudents =0;
                                        foreach ($lookups['courselookup'] as $res) {
                                            
                                                 $Totalstudents = 0;
                                        $TotalPresentstudents = 0;
                                        $TotalAbsentstudents = 0;
                                        $students = 0;
                                        $Presentstudents = 0;
                                        $Absentstudents = 0;
                                        ?>
                                            <td>
                                                <?php foreach ($report_attendancesummarydetails as $result) {
                                                    $Totalstudents++;
                                                    if ($result->courseid == $res->courseid && $result->branchid == $branch->branchid) {
                                                         $students++;
                                                         
                                                        if($result->status == 1)
                                                        {
                                                            $Presentstudents++;
                                                            $TotalPresentstudents++;
                                                            $BranchPresentstudents++;
                                                        }else
                                                        {
                                                            $Absentstudents++;
                                                            $TotalAbsentstudents++;
                                                            $BranchAbsentstudents++;
                                                        }
                                                    }
                                                    
                                                }
                                                $Branchstudents += $students;
                                                $arrTotalTransactions[$res->courseid] += $students;
                                                 $arrTotalAmount[$res->courseid] += $Presentstudents;
                                                  $arrTotalAmount1[$res->courseid] += $Absentstudents;
                                                 echo $students;
                                                ?>
                                            </td>
                                            <td>
                                                <?php 
                                               echo $Presentstudents;
                                                ?>
                                            </td>
                                            <td>
                                                <?php 
                                               echo $Absentstudents;
                                                ?>
                                            </td>
                                        <?php
                                        }
                                        ?>
                                        <td><b>
                                                <?php
                                                $totalTotalTrasactions += $Branchstudents;
                                                echo $Branchstudents;
                                                ?></b>
                                        </td>
                                         <td><b>
                                                <?php
                                                $totalTotalAmount += $BranchPresentstudents;
                                                echo $BranchPresentstudents;
                                                ?></b>
                                        </td>
                                        <td><b>
                                                <?php
                                                $totalTotalAmount1 += $BranchAbsentstudents;
                                                echo $BranchAbsentstudents;
                                                ?></b>
                                        </td>
                                    </tr>
                                <?php endforeach;
                                ?>
                                <tr>
                                    <td>
                                        <b>Total</b>
                                    </td>
                                    <?php
                                    foreach ($lookups['courselookup'] as $res) {
                                    ?>
                                        <td><b>
                                                <?php
                                                echo $arrTotalTransactions[$res->courseid];
                                                ?></b>
                                        </td>
                                        <td><b>
                                                <?php
                                                echo $arrTotalAmount[$res->courseid];
                                                ?></b>
                                        </td>
                                        <td><b>
                                                <?php
                                                echo $arrTotalAmount1[$res->courseid];
                                                ?></b>
                                        </td>
                                    <?php
                                    }
                                    ?>
                                    <td><b>
                                            <?php
                                            echo $totalTotalTrasactions;
                                            ?></b>
                                    </td>
                                    <td><b>
                                            <?php
                                            echo $totalTotalAmount;
                                            ?></b>
                                    </td>
                                     <td><b>
                                            <?php
                                            echo $totalTotalAmount1;
                                            ?></b>
                                    </td>
                                </tr>
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
        var URL = "<?php echo base_url('reports/report_attendancesummarydetails') ?>" + "?" + $('#filterForm').serialize();

        if (download == 1) {
            URL = URL + "&download=1";
        }

        window.location.href = URL;
    }
</script>