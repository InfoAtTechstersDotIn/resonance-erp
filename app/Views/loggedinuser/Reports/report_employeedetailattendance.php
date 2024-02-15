<?php
use App\Models\UsersModel;
?>
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Attendance Details Report
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
                    <label class="text-uppercase text-sm">Attendance Date From</label>
                    <input type="text" onchange="filter(0)" placeholder="From Date" name="FromDate" class="datepicker form-control mb" value="<?php echo (isset($_GET['FromDate']) && $_GET['FromDate'] != "") ? $_GET['FromDate'] : "" ?>">
                </div>
                <div class="col-md-3">
                    <label class="text-uppercase text-sm">Attendance Date To</label>
                    <input type="text" onchange="filter(0)" placeholder="To Date" name="ToDate" class="datepicker form-control mb" value="<?php echo (isset($_GET['ToDate']) && $_GET['ToDate'] != "") ? $_GET['ToDate'] : "" ?>">
                </div>
                
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
                                    <th>Employee Name</th>
                                  
                                         <?php
                                         
                                       // $DateFrom = date_create_from_format("d/m/Y", $_GET['FromDate']) != false ? date_format(date_create_from_format("d/m/Y", $_GET['FromDate']), 'Y-m-d') : date('Y-m-d');
                                        $DateFrom = date_create_from_format("d/m/Y", $_GET['FromDate']) != false ? date_format(date_create_from_format("d/m/Y", $_GET['FromDate']), 'Y-m-d') : date('Y-m-d');
                                       // $DateTo = date_format(date_create_from_format("d/m/Y", $_GET['ToDate']), 'Y-m-d')  : date('Y-m-d');
                                       $DateTo = date_create_from_format("d/m/Y", $_GET['ToDate']) != false ? date_format(date_create_from_format("d/m/Y", $_GET['ToDate']), 'Y-m-d') :  date('Y-m-d');
                                        $startDate = strtotime($DateFrom);
                                        $endDate = strtotime($DateTo);
                             
                                for ($currentDate = $startDate; $currentDate <= $endDate; $currentDate += (86400)) {
                                    $date = date('M-d D', $currentDate);
                                    ?>
                                    <th>
                                    <?php
                                    echo $date;
                                    ?>
                                    </th>
                                    <?php
                                }
                                ?>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                               
                                foreach ($Employeeattendance as $employee) :
                                ?>
                                    <tr>
                                        <td>
                                            <b><?php echo $employee->name ; ?></b>
                                        </td>
                                        <?php
                                        $usersModel = new UsersModel();
                            $attendance = $usersModel->getattendanceByUserId($employee->userid,$DateFrom,$DateTo);
                            
                            foreach($attendance as $payment)
                            {
                               $orgDate = $payment->loginTime;  
                               if(!empty($orgDate)){
                                $login =     date("H:i", strtotime($orgDate)); 
                               }
                               else
                               {
                                   $login='';
                               }
                                $orgDate1 = $payment->logoutTime;  
                                if(!empty($orgDate1)){
                                $logout =     date("H:i", strtotime($orgDate1));
                                }else
                                {
                                    $logout = '';
                                }
                                ?>
                                 <td style='width:179px !important'>
                                 <?php
                                 if($payment->status==1){
                                    $value = "<b>Present</b></br>Login : " . $login . "<br>Late Login :". $payment->isLatelogin . " </br> Logout : ". $logout. "<br>Early Logout :". $payment->isEarlyLogout."";
                                    echo $value;
                                 }else
                                 {
                                     echo "<b>Absent</b>";
                                 }
                                    ?></td>
                                    <?php
                            }
                            ?>
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
        var URL = "<?php echo base_url('reports/report_employeedetailattendance') ?>" + "?" + $('#filterForm').serialize();

        if (download == 1) {
            URL = URL + "&download=1";
        }

        window.location.href = URL;
    }
</script>