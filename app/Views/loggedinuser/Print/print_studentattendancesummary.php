     <head> 
     
     
    


     
     <style>
     
     .content-wrapper {
   
        background-color: #84adea17;
}
.logo.d-flex.justify-content-center {
    text-align: center;
}

.table {
    width: 100%;
    max-width: 90%;
    margin-bottom: 1rem;
    color: #212529;
    margin: auto;
    font-size: 14px;
    border: 1.5px solid black;
    background-color: #fff !important;
   

}

.table thead th {
    vertical-align: bottom;
    border-bottom: 2px solid #dee2e6;
    text-align: center;
    padding:2px 2px;
}
                         
 table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
 padding:2px 2px;
}

 table, td {
    border: 1px solid black;
    border-collapse: collapse;
 padding:3px 5px !important;
}
      
                            
                            
                            
    .content-wrapper h4 {
    text-align: center;
    
    padding: 0px;
    text-transform: uppercase;
    font-weight: bolder;
    margin:5px 0px;
    color: #000000;
    font-family: 'Poppins', sans-serif;
    text-shadow: 1px 1px 20px #bfd22f;
}


table tr td:not(:first-child) {
  /* Center-align the <td> elements within those <tr> */
  text-align: center;
}

.branch{
        text-align: center;
    font-size: 14px;
    color: #000;
    /* color: #192f59; */
}




.table-striped tbody tr:nth-of-type(odd) {
     background-color: rgb(0 82 202);
    background-color: rgb(0 82 202 / 25%);
    /* color: #fff; */
}

.total{
    
        background-color: #bfd22f;
    /* color: #fff; */
    font-weight: 900;
}



                        </style>




</head>




<div class="content-wrapper">
    
    <div class="logo d-flex justify-content-center">
    
    
    <img src="https://maidendropgroup.com/public/images/logo1.png" alt="logo" style="width:140px; margin:auto;">
    
</div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4 class="page-title hea">Daily Attendance Summary Report
                </h4>
            </div>
        </div>
       
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                
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
                                    <th colspan="3">Total</th>
                                </tr>
                                <tr>
                                    <th>Total </th>
                                    <th>Present </th>
                                    <th>Absent </th>
                                    <th>Late </th>
                                    <th>Present % </th>
                                    <th>Late % </th>
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
                                    $Branchlatestudents =0;
                                        foreach ($lookups['courselookup'] as $res) {
                                            
                                                 $Totalstudents = 0;
                                        $TotalPresentstudents = 0;
                                        $Totallatestudents =0;
                                        $TotalAbsentstudents = 0;
                                        $students = 0;
                                        $Presentstudents = 0;
                                        $Absentstudents = 0;
                                        $lateestudents =0;
                                        ?>
                                            
                                                <?php foreach ($report_attendancesummarydetails as $result) {
                                                    $Totalstudents++;
                                                    if ($result->courseid == $res->courseid && $result->branchid == $branch->branchid) {
                                                         $students++;
                                                         
                                                        if($result->status == 1 && $result->is_latelogin==NULL)
                                                        {
                                                            $Presentstudents++;
                                                            $TotalPresentstudents++;
                                                            $BranchPresentstudents++;
                                                        }elseif($result->status == 1 && $result->is_latelogin==1)
                                                        {
                                                            $lateestudents++;
                                                            $Totallatestudents++;
                                                            $Branchlatestudents++;
                                                        }
                                                        else
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
                                                // echo $students;
                                                ?>
                                            
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
                                        <td><b>
                                                <?php
                                                $totalTotalAmount2 += $Branchlatestudents;
                                                echo $Branchlatestudents;
                                                ?></b>
                                        </td>
                                         <td><b>
                                                <?php
                                                if($Branchstudents != 0){
                                                $per = ($BranchPresentstudents * 100) / $Branchstudents ;
                                                }else
                                                {
                                                    $per = 0;
                                                }
                                                echo round($per,2);
                                                ?></b>
                                        </td>
                                         <td><b>
                                                <?php
                                                if($Branchlatestudents != 0){
                                                $per = ($Branchlatestudents * 100) / $Branchstudents ;
                                                }else
                                                {
                                                    $per = 0;
                                                }
                                                echo round($per,2);
                                                ?></b>
                                        </td>
                                    </tr>
                                <?php endforeach;
                                ?>
                                <tr class="total">
                                    <td>
                                        <b>Total</b>
                                    </td>
                                  
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
                                                $per = ($totalTotalAmount * 100) / $totalTotalTrasactions ;
                                                echo round($per,2).' %';
                                                ?></b>
                                        </td>
                                         <td><b>
                                                <?php
                                                if($totalTotalAmount1 != 0){
                                                $per = ($totalTotalAmount1 * 100) / $totalTotalTrasactions ;
                                                }else
                                                {
                                                    $per = 0;
                                                }
                                                echo round($per,2).' %';
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


<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>