<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Daily Concern Summary Report
                </h2>
            </div>
        </div>
        <form id="filterForm">
            <div class="row">
                <div class="col-md-3">
                    <label class="text-uppercase text-sm"> Date From</label>
                    <input type="text" onchange="filter(0)" placeholder="Date From" name="DateFrom" class="datepicker form-control mb" value="<?php echo (isset($_GET['DateFrom']) && $_GET['DateFrom'] != "") ? $_GET['DateFrom'] : "" ?>">
                </div>
                <div class="col-md-3">
                    <label class="text-uppercase text-sm"> Date To</label>
                    <input type="text" onchange="filter(0)" placeholder="Date To" name="DateTo" class="datepicker form-control mb" value="<?php echo (isset($_GET['DateTo']) && $_GET['DateTo'] != "") ? $_GET['DateTo'] : "" ?>">
                </div>
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
                              $arrTotalAmount2 = [];
                               $arrTotalAmount3 = [];

                            $totalTotalTrasactions = 0;
                            $totalTotalAmount = 0;
                            $totalTotalAmount1 = 0;
                            $totalTotalAmount2 = 0;
                            $totalTotalAmount3 = 0;

                            ?>
                            <thead>
                                <tr>
                                    <th rowspan="2">Branch</th>

                                    <?php
                                    foreach ($lookups['courselookup'] as $res) {
                                        $arrTotalTransactions[$res->courseid] = 0;
                                        $arrTotalAmount[$res->courseid] = 0;
                                        $arrTotalAmount1[$res->courseid] = 0;
                                         $arrTotalAmount2[$res->courseid] = 0;
                                          $arrTotalAmount3[$res->courseid] = 0;
                                    ?>
                                        <th colspan="5"><?php echo $res->coursename; ?></th>
                                        
                                    <?php } ?>
                                    <th colspan="3">Total</th>
                                    
                                </tr>
                                <tr>
                                    <?php
                                    foreach ($lookups['courselookup'] as $res) {
                                    ?>
                                        <th>Total</th>
                                        <th>Pending</th>
                                        <th>Progress</th>
                                        <th>Resolved</th>
                                        <th>Re-Open</th>
                                    <?php } ?>
                                    <th>Total</th>
                                    <th>Pending</th>
                                    <th>In progress</th>
                                    <th>Resolved</th>
                                    <th>Re-Open</th>
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
                                    $Branchconcerns =0;
                                    $BranchPendingconcerns =0;
                                    $BranchProgressconcerns =0;
                                    $BranchResolvedconcerns =0;
                                    $BranchReopenconcerns =0;
                                        foreach ($lookups['courselookup'] as $res) {
                                            
                                                 $Totalconcerns = 0;
                                        $TotalPendingconcerns = 0;
                                        $TotalAbsentstudents = 0;
                                        $concerns = 0;
                                        $Pendingconcerns =0;
                                        $Progressconcerns = 0;
                                        $Resolvedconcerns = 0;
                                        $Reopenconcerns = 0;
                                        ?>
                                            <td>
                                                <?php foreach ($report_concernsummarydetails as $result) {
                                                    $Totalconcerns++;
                                                    if ($result->courseid == $res->courseid && $result->branchid == $branch->branchid) {
                                                         $concerns++;
                                                         
                                                        if($result->status == 'Pending')
                                                        {
                                                            $Pendingconcerns++;
                                                            $TotalPendingconcerns++;
                                                            $BranchPendingconcerns++;
                                                        }elseif($result->status == 'In Progress')
                                                        {
                                                            $Progressconcerns++;
                                                            $TotalProgressconcerns++;
                                                            $BranchProgressconcerns++;
                                                        }
                                                        elseif($result->status == 'Resolved')
                                                        {
                                                            $Resolvedconcerns++;
                                                            $TotalResolvedconcerns++;
                                                            $BranchResolvedconcerns++;
                                                        }
                                                        elseif($result->status == 'Re-Open')
                                                        {
                                                            $Reopenconcerns++;
                                                            $TotalReopenconcerns++;
                                                            $BranchReopenconcerns++;
                                                        }else
                                                        {
                                                            
                                                        }
                                                    }
                                                    
                                                }
                                                $Branchconcerns += $concerns;
                                                $arrTotalTransactions[$res->courseid] += $concerns;
                                                 $arrTotalAmount[$res->courseid] += $Pendingconcerns;
                                                  $arrTotalAmount1[$res->courseid] += $Progressconcerns;
                                                  $arrTotalAmount2[$res->courseid] += $Resolvedconcerns;
                                                  $arrTotalAmount2[$res->courseid] += $Reopenconcerns;
                                                 echo $concerns;
                                                ?>
                                            </td>
                                            <td>
                                                <?php 
                                               echo $Pendingconcerns;
                                                ?>
                                            </td>
                                            <td>
                                                <?php 
                                               echo $Progressconcerns;
                                                ?>
                                            </td>
                                             <td>
                                                <?php 
                                               echo $Resolvedconcerns;
                                                ?>
                                            </td>
                                             <td>
                                                <?php 
                                               echo $Reopenconcerns;
                                                ?>
                                            </td>
                                        <?php
                                        }
                                        ?>
                                        <td><b>
                                                <?php
                                                $totalTotalTrasactions += $Branchconcerns;
                                                echo $Branchconcerns;
                                                ?></b>
                                        </td>
                                         <td><b>
                                                <?php
                                                $totalTotalAmount += $BranchPendingconcerns;
                                                echo $BranchPendingconcerns;
                                                ?></b>
                                        </td>
                                        <td><b>
                                                <?php
                                                $totalTotalAmount1 += $BranchProgressconcerns;
                                                echo $BranchProgressconcerns;
                                                ?></b>
                                        </td>
                                         <td><b>
                                                <?php
                                                $totalTotalAmount2 += $BranchResolvedconcerns;
                                                echo $BranchResolvedconcerns;
                                                ?></b>
                                        </td>
                                         <td><b>
                                                <?php
                                                $totalTotalAmount3 += $BranchReopenconcerns;
                                                echo $BranchReopenconcerns;
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
                                        <td><b>
                                                <?php
                                                echo $arrTotalAmount2[$res->courseid];
                                                ?></b>
                                        </td>
                                        <td><b>
                                                <?php
                                                echo $arrTotalAmount3[$res->courseid];
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
                                     <td><b>
                                            <?php
                                            echo $totalTotalAmount2;
                                            ?></b>
                                    </td>
                                     <td><b>
                                            <?php
                                            echo $totalTotalAmount3;
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
        var URL = "<?php echo base_url('reports/report_concernsummarydetails') ?>" + "?" + $('#filterForm').serialize();

        if (download == 1) {
            URL = URL + "&download=1";
        }

        window.location.href = URL;
    }
</script>