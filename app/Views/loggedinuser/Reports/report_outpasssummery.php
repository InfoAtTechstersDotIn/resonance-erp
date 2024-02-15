<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Out Pass Summary Report
                </h2>
            </div>
        </div>
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
                            <thead>
                                <tr>
                                    <th>Branch Name</th>
                                    <th>Total Students</th>
                                    <th>Total Out Students</th>
                                    <th>Today Total Out Students</th>
                                    <th>Today Total In Students</th>
                                    <th>Today Entry Pending Students</th>
                                    <th>Total Entry Pending Students</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                
                                foreach ($lookups['branchlookup'] as $branch) :
                                ?>
                                    <tr>
                                        <td>
                                            <b><?php echo $branch->branchname ?></b>
                                        </td>
                                        <td>
                                                <?php
                                                foreach ($report_getoutpasssummery as $result) {
                                                    if ($result->branchid == $branch->branchid) {
                                                       echo $result->TotalStudents;
                                                    }
                                                    
                                                }
                                                if(count($report_getoutpasssummery) == 0)
                                                {
                                                    
                                                }
                                                
                                                 
                                                ?>
                                        </td>
                                         <td>
                                                <?php
                                                
                                                foreach ($report_getoutpassout as $result) {
                                                   
                                                    if ($result->branchid == $branch->branchid) {
                                                      echo $result->outtotal;
                                                    }else
                                                    {
                                                        
                                                    }
                                                }
                                                 if(count($report_getoutpassout) == 0)
                                                {
                                                   
                                                }
                                                ?>
                                        </td>
                                        
                                         <td>
                                                <?php
                                                
                                                foreach ($report_getoutpassouttoday as $result) {
                                                 
                                                    if ($result->branchid == $branch->branchid) {
                                                      echo $result->outtotal;
                                                    }else
                                                    {
                                                       
                                                    }
                                                }
                                                if(count($report_getoutpassouttoday) == 0)
                                                {
                                                   
                                                }
                                                ?>
                                        </td>
                                        <td>
                                                <?php
                                                
                                                foreach ($report_getoutpassoutintoday as $result) {
                                                 
                                                    if ($result->branchid == $branch->branchid) {
                                                      echo $result->outtotal;
                                                    }else
                                                    {
                                                        
                                                    }
                                                    
                                                }
                                                if(count($report_getoutpassoutintoday) == 0)
                                                {
                                                    
                                                }
                                                ?>
                                        </td>
                                         <td>
                                                <?php
                                                
                                                foreach ($report_getoutpassoutin as $result) {
                                               
                                                    if ($result->branchid == $branch->branchid) {
                                                      echo $result->outtotal;
                                                    }
                                                    else
                                                    {
                                                        
                                                    }
                                                }
                                                if(count($report_getoutpassoutin) == 0)
                                                {
                                                    
                                                }
                                                ?>
                                        </td>
                                        <td>
                                            
                                             <?php
                                                
                                                foreach ($report_getoutpassouttotalin as $result) {
                                               
                                                    if ($result->branchid == $branch->branchid) {
                                                      echo $result->outtotal;
                                                    }
                                                    else
                                                    {
                                                        
                                                    }
                                                }
                                                if(count($report_getoutpassoutin) == 0)
                                                {
                                                    
                                                }
                                                ?>
                                        </td>
                                        </tr>
                                <?php  endforeach;
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
        var URL = "<?php echo base_url('reports/report_revenue') ?>" + "?" + $('#filterForm').serialize();

        if (download == 1) {
            URL = URL + "&download=1";
        }

        window.location.href = URL;
    }
</script>