<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Reports</h2>
                <?php
                if($_SESSION['userdetails']->rolename=="Attendance")
                {
                    ?>
                    <div class="col-md-4">
                                    <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_studentattendance') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <div class="stat-panel-title text-uppercase">Student Attendance Report</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_attendancesummarydetails') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <div class="stat-panel-title text-uppercase">Student Summary Attendance Report</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                        <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_employeeattendance') ?>">
                                            <div class="panel panel-default">
                                                <div class="panel-body bk-primary text-light">
                                                    <div class="stat-panel text-center">
                                                        <div class="stat-panel-title text-uppercase">Employee Attendance Report</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                     <div class="col-md-4">
                                    <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_outpass') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <div class="stat-panel-title text-uppercase">Student Out Pass Report</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                 <div class="col-md-4">
                                    <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_outpasssummery') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <div class="stat-panel-title text-uppercase">Student Summary Out Pass Report</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                    <?php
                }elseif($_SESSION['userdetails']->rolename=="Parent Help Desk")
                {
                    ?>
                     <div class="col-md-4">
                                    <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_concerns') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <div class="stat-panel-title text-uppercase">Parent Concerns Report</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                     <div class="col-md-4">
                                    <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_concernsummarydetails') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <div class="stat-panel-title text-uppercase">Parent Concerns Summary Report</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                  <div class="col-md-4">
                                    <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_absentlog') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <div class="stat-panel-title text-uppercase">Absent Message Log Report</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_admissiondetails') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <div class="stat-panel-title text-uppercase">Admission Report</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <!-- <div class="col-md-4">-->
                                <!--    <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_discount') ?>">-->
                                <!--        <div class="panel panel-default">-->
                                <!--            <div class="panel-body bk-primary text-light">-->
                                <!--                <div class="stat-panel text-center">-->
                                <!--                    <div class="stat-panel-title text-uppercase">Student Discount Report</div>-->
                                <!--                </div>-->
                                <!--            </div>-->
                                <!--        </div>-->
                                <!--    </a>-->
                                <!--</div>-->
                                 <div class="col-md-4">
                                    <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_reservationdiscount') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <div class="stat-panel-title text-uppercase">Reservation Voucher Discount Report</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                 <div class="col-md-4">
                                    <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_reservationbudget') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <div class="stat-panel-title text-uppercase">Reservation Budget Report</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                        <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_reservationadmission') ?>">
                                            <div class="panel panel-default">
                                                <div class="panel-body bk-primary text-light">
                                                    <div class="stat-panel text-center">
                                                        <div class="stat-panel-title text-uppercase">Reservation Admission Report</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                     <div class="col-md-4">
                                        <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_reservationdetails') ?>">
                                            <div class="panel panel-default">
                                                <div class="panel-body bk-primary text-light">
                                                    <div class="stat-panel text-center">
                                                        <div class="stat-panel-title text-uppercase">Reservation Report</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                    <?php
                }
                
                else
                {
                ?>
                <h4 class="page-title">Students</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_studentdetails') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <div class="stat-panel-title text-uppercase">Students Report</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_dropstudents') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <div class="stat-panel-title text-uppercase">Dropped out Students Report</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_admissiondetails') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <div class="stat-panel-title text-uppercase">Admission Report</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_studentattendance') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <div class="stat-panel-title text-uppercase">Student Attendance Report</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                 <div class="col-md-4">
                                    <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_attendancesummarydetails') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <div class="stat-panel-title text-uppercase">Student Summary Attendance Report</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_outpass') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <div class="stat-panel-title text-uppercase">Student Out Pass Report</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                 <div class="col-md-4">
                                    <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_outpasssummery') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <div class="stat-panel-title text-uppercase">Student Summary Out Pass Report</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                 <div class="col-md-4">
                                    <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_concerns') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <div class="stat-panel-title text-uppercase">Parent Concerns Report</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                 <div class="col-md-4">
                                    <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_concernsummarydetails') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <div class="stat-panel-title text-uppercase">Parent Concerns Summary Report</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                 <div class="col-md-4">
                                    <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_tc') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <div class="stat-panel-title text-uppercase">Tc Report</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                 <div class="col-md-4">
                                    <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_tc_eligible') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <div class="stat-panel-title text-uppercase">Tc Eligible Report</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <!-- <div class="col-md-4">-->
                                <!--    <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_discount') ?>">-->
                                <!--        <div class="panel panel-default">-->
                                <!--            <div class="panel-body bk-primary text-light">-->
                                <!--                <div class="stat-panel text-center">-->
                                <!--                    <div class="stat-panel-title text-uppercase">Discount Report</div>-->
                                <!--                </div>-->
                                <!--            </div>-->
                                <!--        </div>-->
                                <!--    </a>-->
                                <!--</div>-->
                                 <div class="col-md-4">
                                    <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_studentdiscount') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <div class="stat-panel-title text-uppercase">Student Voucher Discount Report</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                  <div class="col-md-4">
                                    <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_absentlog') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <div class="stat-panel-title text-uppercase">Absent Message Log Report</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                     <h4 class="page-title">Employee</h2>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_employeeattendance') ?>">
                                            <div class="panel panel-default">
                                                <div class="panel-body bk-primary text-light">
                                                    <div class="stat-panel text-center">
                                                        <div class="stat-panel-title text-uppercase">Employee Attendance Report</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-4">
                                        <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_employeedetailattendance') ?>">
                                            <div class="panel panel-default">
                                                <div class="panel-body bk-primary text-light">
                                                    <div class="stat-panel text-center">
                                                        <div class="stat-panel-title text-uppercase">Employee Detail Attendance Report</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-4">
                                        <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_employeeleaves') ?>">
                                            <div class="panel panel-default">
                                                <div class="panel-body bk-primary text-light">
                                                    <div class="stat-panel text-center">
                                                        <div class="stat-panel-title text-uppercase">Employee Leave Report</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                     <div class="col-md-4">
                                            <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_employeepaysheet') ?>">
                                                <div class="panel panel-default">
                                                    <div class="panel-body bk-primary text-light">
                                                        <div class="stat-panel text-center">
                                                            <div class="stat-panel-title text-uppercase">Employee Pay Sheet Report</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    <div class="col-md-4">
                                        <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_employeebudget') ?>">
                                            <div class="panel panel-default">
                                                <div class="panel-body bk-primary text-light">
                                                    <div class="stat-panel text-center">
                                                        <div class="stat-panel-title text-uppercase">Employee Budget Report</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                         
                    <h4 class="page-title">Reservations</h2>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_reservationdetails') ?>">
                                            <div class="panel panel-default">
                                                <div class="panel-body bk-primary text-light">
                                                    <div class="stat-panel text-center">
                                                        <div class="stat-panel-title text-uppercase">Reservation Report</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-4">
                                        <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_reservationsummary') ?>">
                                            <div class="panel panel-default">
                                                <div class="panel-body bk-primary text-light">
                                                    <div class="stat-panel text-center">
                                                        <div class="stat-panel-title text-uppercase">Reservation Summary Report</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-4">
                                        <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_reservationadmission') ?>">
                                            <div class="panel panel-default">
                                                <div class="panel-body bk-primary text-light">
                                                    <div class="stat-panel text-center">
                                                        <div class="stat-panel-title text-uppercase">Reservation Admission Report</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-4">
                                        <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_profileimage') ?>">
                                            <div class="panel panel-default">
                                                <div class="panel-body bk-primary text-light">
                                                    <div class="stat-panel text-center">
                                                        <div class="stat-panel-title text-uppercase">Reservation Pending Profile Image Report</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                     <div class="col-md-4">
                                    <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_reservationdiscount') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <div class="stat-panel-title text-uppercase">Reservation Voucher Discount Report</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                 <div class="col-md-4">
                                    <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_reservationbudget') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <div class="stat-panel-title text-uppercase">Reservation Budget Report</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                </div>
                            </div>
                        </div>
                        <h4 class="page-title">Applications</h2>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_applicationdetails') ?>">
                                            <div class="panel panel-default">
                                                <div class="panel-body bk-primary text-light">
                                                    <div class="stat-panel text-center">
                                                        <div class="stat-panel-title text-uppercase">Application Report</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                     <div class="col-md-4">
                                        <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_applicationsummary') ?>">
                                            <div class="panel panel-default">
                                                <div class="panel-body bk-primary text-light">
                                                    <div class="stat-panel text-center">
                                                        <div class="stat-panel-title text-uppercase">Application Summary Report</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-4">
                                        <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_applicationadmission') ?>">
                                            <div class="panel panel-default">
                                                <div class="panel-body bk-primary text-light">
                                                    <div class="stat-panel text-center">
                                                        <div class="stat-panel-title text-uppercase">Application Admission Report</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                        <h4 class="page-title">Revenue</h2>
                            <h6 class="page-title">Finance</h2>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_collectionsummarydetails') ?>">
                                                    <div class="panel panel-default">
                                                        <div class="panel-body bk-primary text-light">
                                                            <div class="stat-panel text-center">
                                                                <div class="stat-panel-title text-uppercase">Collection Summary Report</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-md-4">
                                                <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_collectiondetails') ?>">
                                                    <div class="panel panel-default">
                                                        <div class="panel-body bk-primary text-light">
                                                            <div class="stat-panel text-center">
                                                                <div class="stat-panel-title text-uppercase">Collection Report</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-md-4">
                                                <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_reservationcollectiondetails') ?>">
                                                    <div class="panel panel-default">
                                                        <div class="panel-body bk-primary text-light">
                                                            <div class="stat-panel text-center">
                                                                <div class="stat-panel-title text-uppercase">Reservation Collection Report</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-md-4">
                                                <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_revenue') ?>">
                                                    <div class="panel panel-default">
                                                        <div class="panel-body bk-primary text-light">
                                                            <div class="stat-panel text-center">
                                                                <div class="stat-panel-title text-uppercase">Revenue Report</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-md-4">
                                                <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_noc') ?>">
                                                    <div class="panel panel-default">
                                                        <div class="panel-body bk-primary text-light">
                                                            <div class="stat-panel text-center">
                                                                <div class="stat-panel-title text-uppercase">NOC Report</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h6 class="page-title">Wallet</h2>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_wallet') ?>">
                                                        <div class="panel panel-default">
                                                            <div class="panel-body bk-primary text-light">
                                                                <div class="stat-panel text-center">
                                                                    <div class="stat-panel-title text-uppercase">Wallet Report</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="col-md-4">
                                                    <a target="_blank" target="_blank" href="<?php echo base_url('reports/report_wallettransactions') ?>">
                                                        <div class="panel panel-default">
                                                            <div class="panel-body bk-primary text-light">
                                                                <div class="stat-panel text-center">
                                                                    <div class="stat-panel-title text-uppercase">Wallet Transaction Admission Report</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
            </div>
        </div>
    </div>
</div>