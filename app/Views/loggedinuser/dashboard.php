<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title"><?php
                            use App\Models\FormsModel;
                            use App\Models\UsersModel;
                            echo $_SESSION['userdetails']->name . " " ?>Dashboard <span style="float:right;">Current ERP Version : <a target="_blank" href="<?php echo base_url('dashboard/version') ?>">20.6</a></span></h2>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <?php if ($_SESSION['rights'][array_search('Parent Concerns', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                                <div class="col-md-3">
                                    <div class="panel panel-default">
                                        <div class="panel-body bk-primary text-light">
                                            <div class="stat-panel text-center">
                                                <?php
                                                $db = db_connect();
                                                $query = $db->query("SELECT * from concerns");
                                                $results = $query->getResult();
                                                $bg = count($results);
                                                $db->close();
                                                ?>
                                                <div class="stat-panel-number h1 "><?php echo htmlentities($bg); ?></div>
                                                <div class="stat-panel-title text-uppercase"><a href='admin/concerns'>Total Concerns</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if ($_SESSION['rights'][array_search('TotalBranches', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                                <div class="col-md-3">
                                    <div class="panel panel-default">
                                        <div class="panel-body bk-primary text-light">
                                            <div class="stat-panel text-center">
                                                <?php
                                                $db = db_connect();
                                                $query = $db->query("SELECT branchid from branchlookup where branchid in ({$_SESSION['userdetails']->branchid})");
                                                $results = $query->getResult();
                                                $bg = count($results);
                                                $db->close();
                                                ?>
                                                <div class="stat-panel-number h1 "><?php echo htmlentities($bg); ?></div>
                                                <div class="stat-panel-title text-uppercase">Branches</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if ($_SESSION['rights'][array_search('TotalUsers', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                               <div class="col-md-3">
                                    <div class="panel panel-default">
                                        <div class="panel-body bk-primary text-light">
                                            <div class="stat-panel text-center">
                                                <?php
                                                $db = db_connect();
                                                $query = $db->query("SELECT SUM(total) As Total
                                                                     FROM 
                                                                        (SELECT COUNT(*) as total from users 
                                                                         join student_class_relation on users.userid = student_class_relation.studentid
                                                                         WHERE student_class_relation.batchid IN ({$_SESSION['activebatch']})
                                                                         UNION
                                                                         SELECT  COUNT(*)  as total FROM users where roleid <> 5) A");
                                                $results = $query->getResult();
                                                $bg = $results[0]->Total;
                                                $db->close();
                                                ?>
                                                <div class="stat-panel-number h1 "><?php echo htmlentities($bg); ?></div>
                                                <div class="stat-panel-title text-uppercase">Users</div>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            <?php endif; ?>
                            <?php if ($_SESSION['rights'][array_search('TotalSuperAdmins', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                                <div class="col-md-3">
                                    <div class="panel panel-default">
                                        <div class="panel-body bk-primary text-light">
                                            <div class="stat-panel text-center">
                                                <?php
                                                $db = db_connect();
                                                $query = $db->query("SELECT userid from users where roleid = 1");
                                                $results = $query->getResult();
                                                $bg = count($results);
                                                $db->close();
                                                ?>
                                                <div class="stat-panel-number h1 "><?php echo htmlentities($bg); ?></div>
                                                <div class="stat-panel-title text-uppercase">Super Admins</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if ($_SESSION['rights'][array_search('TotalSeniorManagement', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                                <div class="col-md-3">
                                    <a target="_blank" href="<?php echo base_url('users/employee') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT userid from users where roleid = 2");
                                                    $results = $query->getResult();
                                                    $bg = count($results);
                                                    $db->close();
                                                    ?>
                                                    <div class="stat-panel-number h1 "><?php echo htmlentities($bg); ?></div>
                                                    <div class="stat-panel-title text-uppercase">Senior Management</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <?php if ($_SESSION['rights'][array_search('TotalCenterHeads', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                                <div class="col-md-3">
                                    <a target="_blank" href="<?php echo base_url('users/employee') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT users.userid from users 
                                                                         join employeedetails E on users.userid = E.userid 
                                                                         WHERE roleid = 3 and branchid IN ({$_SESSION['userdetails']->branchid})");
                                                    $results = $query->getResult();
                                                    $bg = count($results);
                                                    $db->close();
                                                    ?>
                                                    <div class="stat-panel-number h1 "><?php echo htmlentities($bg); ?></div>
                                                    <div class="stat-panel-title text-uppercase">Center Heads</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <?php if ($_SESSION['rights'][array_search('TotalAdministrators', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                                <div class="col-md-3">
                                    <a target="_blank" href="<?php echo base_url('users/employee') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT users.userid from users 
                                                                         join employeedetails E on users.userid = E.userid 
                                                                         WHERE roleid = 4 and branchid IN ({$_SESSION['userdetails']->branchid})");
                                                    $results = $query->getResult();
                                                    $bg = count($results);
                                                    $db->close();
                                                    ?>
                                                    <div class="stat-panel-number h1 "><?php echo htmlentities($bg); ?></div>
                                                    <div class="stat-panel-title text-uppercase">Administrators</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <?php if ($_SESSION['rights'][array_search('TotalStudents', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                                <div class="col-md-3">
                                    <a target="_blank" href="<?php echo base_url('users/student') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <?php
                                                     if ($_SESSION['userdetails']->roleid != 12) {
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT users.userid from users 
                                                                         join studentdetails S on users.userid = S.userid 
                                                                         join student_class_relation on S.userid = student_class_relation.studentid
                                                                         WHERE roleid = 5 and applicationstatusid = 4 and studentstatus=1
                                                                                          and student_class_relation.branchid IN ({$_SESSION['userdetails']->branchid})
                                                                                          and student_class_relation.batchid IN ({$_SESSION['activebatch']})");
                                                    $results = $query->getResult();
                                                    $bg = count($results);
                                                    $db->close();
                                                     }else
                                                     {
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT * from tc_table where 
                                                                                           college_code IN ({$_SESSION['college_code']})");
                                                    $results = $query->getResult();
                                                    $bg = count($results);
                                                    $db->close();
                                                     }
                                                    ?>
                                                    <div class="stat-panel-number h1 "><?php echo htmlentities($bg); ?></div>
                                                    <div class="stat-panel-title text-uppercase">Total Students</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <?php if ($_SESSION['rights'][array_search('ViewPendingApprovals', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                                <div class="col-md-3">
                                    <a target="_blank" href="<?php echo base_url('users/approval') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT users.userid from users 
                                                                         join studentdetails S on users.userid = S.userid 
                                                                         join student_class_relation on S.userid = student_class_relation.studentid
                                                                         WHERE applicationstatusid IN (1, 3) 
                                                                         and branchid IN ({$_SESSION['userdetails']->branchid})
                                                                         and student_class_relation.batchid IN ({$_SESSION['activebatch']})");
                                                    $results = $query->getResult();
                                                    $bg = count($results);
                                                    $db->close();
                                                    ?>
                                                    <div class="stat-panel-number h1 "><?php echo htmlentities($bg); ?></div>
                                                    <div class="stat-panel-title text-uppercase">Pending Student Approvals</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <?php if ($_SESSION['rights'][array_search('ViewRejectedStudents', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                                <div class="col-md-3">
                                    <a target="_blank" href="<?php echo base_url('users/student?applicationstatusid=2') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT users.userid from users 
                                                                         join studentdetails S on users.userid = S.userid 
                                                                         join student_class_relation on S.userid = student_class_relation.studentid
                                                                         WHERE applicationstatusid IN (2) 
                                                                         and branchid IN ({$_SESSION['userdetails']->branchid})
                                                                         and student_class_relation.batchid IN ({$_SESSION['activebatch']})");
                                                    $results = $query->getResult();
                                                    $bg = count($results);
                                                    $db->close();
                                                    ?>
                                                    <div class="stat-panel-number h1 "><?php echo htmlentities($bg); ?></div>
                                                    <div class="stat-panel-title text-uppercase">Declined Applications</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <?php if ($_SESSION['rights'][array_search('ViewWaitingPaymentApprovals', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                                <div class="col-md-3">
                                    <a target="_blank" href="<?php echo base_url('payments/approval') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT paymentid from payments 
                                                                         JOIN users ON users.userid = payments.userid 
                                                                         join studentdetails S on users.userid = S.userid 
                                                                         join student_class_relation on S.userid = student_class_relation.studentid
                                                                         WHERE paymentstatusid = 1 and branchid IN ({$_SESSION['userdetails']->branchid})
                                                                         and student_class_relation.batchid IN ({$_SESSION['activebatch']})");
                                                    $results = $query->getResult();
                                                    $bg = count($results);
                                                    $db->close();
                                                    ?>
                                                    <div class="stat-panel-number h1 "><?php echo htmlentities($bg); ?></div>
                                                    <div class="stat-panel-title text-uppercase">Pending Payment Approvals</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <?php if ($_SESSION['rights'][array_search('TotalStudents', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : 
                               if ($_SESSION['userdetails']->roleid != 12) {
                            ?>
                               <div class="col-md-3">
                                    <a target="_blank" href="<?php echo base_url('users/reservations?reservationstatusid=4') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT * from reservation
                                                                         WHERE reservationstatusid IN (4) 
                                                                         and branchid IN ({$_SESSION['userdetails']->branchid})
                                                                         and batchid IN ({$_SESSION['activebatch']})");
                                                    $results = $query->getResult();
                                                    $bg = count($results);
                                                    $db->close();
                                                    ?>
                                                    <div class="stat-panel-number h1 "><?php echo htmlentities($bg); ?></div>
                                                    <div class="stat-panel-title text-uppercase">Approved Reservations</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div> 
                            <?php } endif; ?>
                            <?php if ($_SESSION['rights'][array_search('ViewPendingApprovals', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                                <div class="col-md-3">
                                    <a target="_blank" href="<?php echo base_url('users/reservationApproval?reservationstatusid=2') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT * from reservation
                                                                         WHERE reservationstatusid IN (1, 2) 
                                                                         and branchid IN ({$_SESSION['userdetails']->branchid})
                                                                         and batchid IN ({$_SESSION['activebatch']})");
                                                    $results = $query->getResult();
                                                    $bg = count($results);
                                                    $db->close();
                                                    ?>
                                                    <div class="stat-panel-number h1 "><?php echo htmlentities($bg); ?></div>
                                                    <div class="stat-panel-title text-uppercase">Pending Reservation Approvals</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div> 
                            <?php endif; ?>
                            <?php if ($_SESSION['rights'][array_search('ViewRejectedStudents', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                                <div class="col-md-3">
                                    <a target="_blank" href="<?php echo base_url('users/reservations?reservationstatusid=4') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT * from reservation
                                                                         WHERE reservationstatusid IN (3) 
                                                                         and branchid IN ({$_SESSION['userdetails']->branchid})
                                                                         and reservation.batchid IN ({$_SESSION['activebatch']})");
                                                    $results = $query->getResult();
                                                    $bg = count($results);
                                                    $db->close();
                                                    ?>
                                                    <div class="stat-panel-number h1 "><?php echo htmlentities($bg); ?></div>
                                                    <div class="stat-panel-title text-uppercase">Declined Reservations</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div> 
                            <?php endif; ?>
                            <?php if ($_SESSION['rights'][array_search('ViewWaitingPaymentApprovals', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                                <div class="col-md-3">
                                    <a target="_blank" href="<?php echo base_url('payments/reservationPaymentapproval') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT * from reservation_payments 
                                                                         join reservation ON reservation_payments.reservationid = reservation.reservationid
                                                                         WHERE paymentstatusid = 1 and branchid IN ({$_SESSION['userdetails']->branchid})
                                                                         and reservation.batchid IN ({$_SESSION['activebatch']})");
                                                    $results = $query->getResult();
                                                    $bg = count($results);
                                                    $db->close();
                                                    ?>
                                                    <div class="stat-panel-number h1 "><?php echo htmlentities($bg); ?></div>
                                                    <div class="stat-panel-title text-uppercase">Pending Reservation Payment Approvals</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div> 
                            <?php endif; ?>
                            <?php if ($_SESSION['rights'][array_search('ViewTotalCollected', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                                <div class="col-md-3">
                                    <a target="_blank" href="<?php echo base_url('payments/payment') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT SUM(paymentamount) AS TotalCollected from payments 
                                                                         JOIN users ON payments.userid = users.userid 
                                                                         join studentdetails S on users.userid = S.userid 
                                                                         join student_class_relation on S.userid = student_class_relation.studentid
                                                                         WHERE branchid IN ({$_SESSION['userdetails']->branchid}) 
                                                                         and payments.paymentstatusid = 3
                                                                         and student_class_relation.batchid IN ({$_SESSION['activebatch']})");
                                                    $results = $query->getResult();
                                                    $bg = count($results);
                                                    $db->close();

                                                    function count_digit($number)
                                                    {
                                                        return strlen($number);
                                                    }

                                                    function divider($number_of_digits)
                                                    {
                                                        $tens = "1";

                                                        if ($number_of_digits > 8)
                                                            return 10000000;

                                                        while (($number_of_digits - 1) > 0) {
                                                            $tens .= "0";
                                                            $number_of_digits--;
                                                        }
                                                        return $tens;
                                                    }


                                                    ?>
                                                    <div class="stat-panel-number h1 "><?php
                                                                                        $num = htmlentities($results[0]->TotalCollected == null ? "0.00" : $results[0]->TotalCollected);
                                                                                        $ext = "";

                                                                                        $number_of_digits = count_digit($num);
                                                                                        if ($number_of_digits > 3) {
                                                                                            if ($number_of_digits % 2 != 0)
                                                                                                $divider = divider($number_of_digits - 1);
                                                                                            else
                                                                                                $divider = divider($number_of_digits);
                                                                                        } else
                                                                                            $divider = 1;

                                                                                        $fraction = $num / $divider;
                                                                                        $fraction = number_format($fraction, 2);
                                                                                        if ($number_of_digits == 4 || $number_of_digits == 5)
                                                                                            $ext = "k";
                                                                                        if ($number_of_digits == 6 || $number_of_digits == 7)
                                                                                            $ext = "Lac";
                                                                                        if ($number_of_digits >= 8)
                                                                                            $ext = "Cr";
                                                                                        echo $fraction . " " . $ext;
                                                                                        ?></div>
                                                    <div class="stat-panel-title text-uppercase">Total Collected</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div> 
                            <?php endif; ?>
                            <?php if ($_SESSION['rights'][array_search('ViewTotalCollected', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                                <div class="col-md-3">
                                    <a target="_blank" href="<?php echo base_url('payments/invoice') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT SUM(paymentamount) AS TotalCollected from payments 
                                                                         JOIN users ON payments.userid = users.userid 
                                                                         join studentdetails S on users.userid = S.userid 
                                                                         join student_class_relation on S.userid = student_class_relation.studentid
                                                                         WHERE branchid IN ({$_SESSION['userdetails']->branchid}) 
                                                                         and payments.paymentstatusid = 1
                                                                         and student_class_relation.batchid IN ({$_SESSION['activebatch']})");
                                                    $results = $query->getResult();
                                                    $bg = count($results);
                                                    $db->close();
                                                    ?>
                                                    <div class="stat-panel-number h1 "><?php
                                                                                        $num = htmlentities($results[0]->TotalCollected == null ? "0.00" : $results[0]->TotalCollected);
                                                                                        $ext = "";

                                                                                        $number_of_digits = count_digit($num);
                                                                                        if ($number_of_digits > 3) {
                                                                                            if ($number_of_digits % 2 != 0)
                                                                                                $divider = divider($number_of_digits - 1);
                                                                                            else
                                                                                                $divider = divider($number_of_digits);
                                                                                        } else
                                                                                            $divider = 1;

                                                                                        $fraction = $num / $divider;
                                                                                        $fraction = number_format($fraction, 2);
                                                                                        if ($number_of_digits == 4 || $number_of_digits == 5)
                                                                                            $ext = "k";
                                                                                        if ($number_of_digits == 6 || $number_of_digits == 7)
                                                                                            $ext = "Lac";
                                                                                        if ($number_of_digits >= 8)
                                                                                            $ext = "Cr";
                                                                                        echo $fraction . " " . $ext;
                                                                                        ?></div>
                                                    <div class="stat-panel-title text-uppercase">Pending Payment Amount</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div> 
                            <?php endif; ?>
                            <?php if ($_SESSION['rights'][array_search('LeaveRequests', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                                <div class="col-md-3">
                                    <a target="_blank" target="_blank" href="<?php echo base_url('admin/leave_requests') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <?php
                                                    $usersModel = new UsersModel();
                                                    $count = COUNT($usersModel->get_employee_leaveRequests());
                                                    ?>
                                                    <div class="stat-panel-number h1 "><?php echo htmlentities($count); ?></div>
                                                    <div class="stat-panel-title text-uppercase">Leave Requests</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <?php if ($_SESSION['rights'][array_search('LateRegularizations', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                                <div class="col-md-3">
                                    <a target="_blank" target="_blank" href="<?php echo base_url('admin/regularizations') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <?php
                                                    $usersModel = new UsersModel();
                                                    $count = COUNT($usersModel->get_employee_to_loginregularize());
                                                    ?>
                                                    <div class="stat-panel-number h1 "><?php echo htmlentities($count); ?></div>
                                                    <div class="stat-panel-title text-uppercase">Regularizations</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <?php if ($_SESSION['rights'][array_search('TotalPendingMaterialRequisitionRequests', array_column($_SESSION['rights'], 'operationname'))]->_view == 1 && $_SESSION['userdetails']->roleid != 12) :
                           
                            ?>
                                <div class="col-md-3">
                                    <a target="_blank" target="_blank" href="<?php echo base_url('forms/MaterialformApprovals') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <?php
                                                    $formsModel = new FormsModel();
                                                    $count = COUNT($formsModel->get_TotalPendingMaterialRequisitionRequests());
                                                    ?>
                                                    <div class="stat-panel-number h1 "><?php echo htmlentities($count); ?></div>
                                                    <div class="stat-panel-title text-uppercase">Pending Material Requisitions</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php  endif; ?>
                            <?php if ($_SESSION['rights'][array_search('ViewTotalCollectedByBranch', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                                <div class="col-md-6">
                                    <div class="panel panel-default">
                                        <div class="panel-body bk-primary text-light">
                                            <div class="stat-panel text-center">
                                                <?php
                                                $db = db_connect();
                                                $query = $db->query("SELECT SUM(Derieved.amount) as TotalAmount, BL.branchname FROM 
                                                                        (SELECT SUM(paymentamount) as amount, branchid FROM payments P 
                                                                         JOIN users U ON P.paymentcollectedby = U.userid 
                                                                         join studentdetails S on U.userid = S.userid 
                                                                         join student_class_relation on S.userid = student_class_relation.studentid
                                                                         WHERE student_class_relation.batchid IN ({$_SESSION['activebatch']})
                                                                         GROUP BY branchid) Derieved 
                                                                    JOIN branchlookup BL on Derieved.branchid = BL.branchid GROUP BY Derieved.branchid");
                                                $results = $query->getResult();
                                                $db->close();
                                                ?>
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                <center>Branch</center>
                                                            </th>
                                                            <th>
                                                                <center>Total Collected</center>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($results as $result) : ?>
                                                            <tr>
                                                                <td><?php echo $result->branchname ?></td>
                                                                <td><?php echo $result->TotalAmount ?></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                                <div class="stat-panel-title text-uppercase">Total Collected By Branch</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if ($_SESSION['rights'][array_search('ViewTotalCollectedByBranch', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                                <div class="col-md-6">
                                    <div class="panel panel-default">
                                        <div class="panel-body bk-primary text-light">
                                            <div class="stat-panel text-center">
                                                <?php
                                                $db = db_connect();
                                                $query = $db->query("SELECT SUM(Derieved.amount) as TotalAmount, BL.branchname FROM 
                                                                        (SELECT SUM(paymentamount) as amount, branchid FROM payments P 
                                                                         JOIN users U ON P.paymentcollectedby = U.userid 
                                                                         join studentdetails S on U.userid = S.userid 
                                                                         join student_class_relation on S.userid = student_class_relation.studentid
                                                                         where P.paymentdate = CURDATE() 
                                                                         AND student_class_relation.batchid IN ({$_SESSION['activebatch']})
                                                                         GROUP BY branchid) Derieved 
                                                                    JOIN branchlookup BL on Derieved.branchid = BL.branchid GROUP BY Derieved.branchid");
                                                $results = $query->getResult();
                                                $db->close();
                                                ?>
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                <center>Branch</center>
                                                            </th>
                                                            <th>
                                                                <center>Total Collected</center>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($results as $result) : ?>
                                                            <tr>
                                                                <td><?php echo $result->branchname ?></td>
                                                                <td><?php echo $result->TotalAmount ?></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                                <div class="stat-panel-title text-uppercase">Total Collected By Branch Today</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if ($_SESSION['userdetails']->rolename == "Warehouse Manager" || $_SESSION['userdetails']->rolename == "Inventory Manager") : ?>
                                <div class="col-md-6">
                                    <a target="_blank" href="<?php echo base_url('Inventory/details') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <div class="stat-panel-title text-uppercase">Go to Inventory</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>