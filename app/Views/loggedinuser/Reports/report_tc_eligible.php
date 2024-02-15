<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Tc Eligible Report
                </h2>
            </div>
        </div>
         <form id="filterForm">
            <div class="row">
                 <div class="col-md-3">
                    <label class="text-uppercase text-sm">Course</label>
                    <select name="courseid" id="courseid" onchange="filter(0)" style="width: 100%;" class="form-control mb">
                        <option value="">Select</option>
                        <?php
                        foreach ($lookups['courselookup'] as $result) :
                        ?>
                            <option value="<?php echo $result->courseid; ?>" <?php echo (isset($_GET['courseid']) && $_GET['courseid'] != "" && $_GET['courseid'] == $result->courseid) ? "selected" : "" ?>><?php echo $result->coursename; ?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </div>
          
            </div>
        </form>
        <br>
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
                             $Totalstudents = 0;
                            $TotalPresentstudents = 0;
                            $TotalAbsentstudents = 0;
                            $Totaltcstudents = 0;
                            
                            ?>
                            <thead>
                                <tr>
                                     <th>Branch Name</th>
                                    <th>Total Students</th>
                                    <th>Eligible Students</th>
                                    <th>Non-Eligible Students</th>
                                    <th>Tc Issued Students</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($report_tc_eligible != null) :
                                    foreach ($lookups['branchlookup'] as $branch) :
                                        $students = 0;
                                                $Presentstudents = 0;
                                                $Absentstudents = 0;
                                                 $tcstudents = 0;
                                    foreach ($report_tc_eligible as $result) :
                                        $Totalstudents++;
                                    if ($result->branchid == $branch->branchid) {
                                       $students++;
                                        if($result->TotalPaid >= $result->TotalValue)
                                        {
                                            $Presentstudents++;
                                            $TotalPresentstudents++;
                                        }else
                                        {
                                            $Absentstudents++;
                                            $TotalAbsentstudents++;
                                        }
                                    }
                                    
                                    endforeach;
                                    
                                 foreach ($report_tc_given as $result) :
                                     if ($result->branchid == $branch->branchid) {
                                         $tcstudents++;
                                         $Totaltcstudents++;
                                     }
                                    endforeach; 
                                ?>
                                        <tr>
                                            <td>
                                                <b><?php echo $branch->branchname ?></b>
                                            </td>
                                            <td>
                                                <?php echo $students ?>
                                            </td>
                                            <td>
                                                <?php echo $Presentstudents ?>
                                            </td>
                                            <td>
                                                <?php echo $Absentstudents ?>
                                            </td>
                                            <td><?php echo $tcstudents;?></td>
                                            
                                            
                                        </tr>
                                <?php endforeach;
                                endif; ?>
                                <?php

                                if ($report_tc_eligible != null) :
                                ?>
                                    <tr style="font-weight:bold">
                                        <td>
                                            Total
                                        </td>
                                        <td>
                                            <?php echo count($report_tc_eligible); ?>
                                        </td>
                                        <td>
                                            <?php echo $TotalPresentstudents; ?>
                                        </td>
                                        <td>
                                            <?php echo $TotalAbsentstudents; ?>
                                        </td>
                                        <td>
                                            <?php echo $Totaltcstudents;?>
                                        </td>
                                        
                                    </tr>
                                <?php
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
        var URL = "<?php echo base_url('reports/report_tc_eligible') ?>" + "?" + $('#filterForm').serialize();

        if (download == 1) {
            URL = URL + "&download=1";
        }

        window.location.href = URL;
    }
</script>