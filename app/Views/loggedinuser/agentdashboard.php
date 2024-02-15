<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title"><?php

                                        use App\Models\UsersModel;

                                        echo $_SESSION['agentdetails']->name . " " ?>Dashboard <span style="float:right;"></span>
                                          
                                        </h2>

                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                             
                                <div class="col-md-3">
                                    <a href="<?php echo base_url('agentdashboard/Applications');?>">
                                    <div class="panel panel-default">
                                        <div class="panel-body bk-primary text-light">
                                            <div class="stat-panel text-center">
                                                <?php
                                                 if( $_SESSION['agentdetails']->roleid ==3){
                                                $db = db_connect();
                                                $query = $db->query("SELECT applicationid from applications where  reservationstatusid=1 and branchid in ({$_SESSION['agentdetails']->branchid}) and batchid IN ({$_SESSION['activebatch']})");
                                                $results = $query->getResult();
                                                $bg = count($results);
                                                $db->close();
                                                 }else if($_SESSION['agentdetails']->roleid == 15)
                                                 {
                                                      $db = db_connect();
                                                $query = $db->query("SELECT applicationid from applications where reservationstatusid=1 and created_by ={$_SESSION['agentdetails']->userid} and batchid IN ({$_SESSION['activebatch']})");
                                                $results = $query->getResult();
                                                $bg = count($results);
                                                $db->close();
                                                 }
                                                  elseif($_SESSION['agentdetails']->roleid == 1)
                                                  {
                                                      $db = db_connect();
                                                $query = $db->query("SELECT applicationid from applications where batchid IN ({$_SESSION['activebatch']})");
                                                $results = $query->getResult();
                                                $bg = count($results);
                                                $db->close();
                                                  }
                                                  elseif($_SESSION['agentdetails']->userid == 7181)
                                                  {
                                                      $db = db_connect();
                                                $query = $db->query("SELECT applicationid from applications where batchid IN ({$_SESSION['activebatch']})");
                                                $results = $query->getResult();
                                                $bg = count($results);
                                                $db->close();
                                                  }
                                                 else
                                                 {
                                                      $db = db_connect();
                                                $query = $db->query("SELECT applicationid from applications where  reservationstatusid=1 and transferemployee ={$_SESSION['agentdetails']->userid} and batchid IN ({$_SESSION['activebatch']})");
                                                $results = $query->getResult();
                                                $bg = count($results);
                                                $db->close();
                                                 }
                                                ?>
                                                <div class="stat-panel-number h1 "><?php echo htmlentities($bg); ?></div>
                                                <div class="stat-panel-title text-uppercase">Total Applications</div>
                                            </div>
                                        </div>
                                    </div>
                                    </a>
                                </div>
                                
                                  <div class="col-md-3">
                                    <a href="<?php echo base_url('agentdashboard/RetApplications');?>">
                                    <div class="panel panel-default">
                                        <div class="panel-body bk-primary text-light">
                                            <div class="stat-panel text-center">
                                                <?php
                                                 if( $_SESSION['agentdetails']->roleid ==3){
                                                $db = db_connect();
                                                $query = $db->query("SELECT applicationid from applications where   reservationstatusid=6 and branchid in ({$_SESSION['agentdetails']->branchid}) and batchid IN ({$_SESSION['activebatch']})");
                                                $results = $query->getResult();
                                                $bg = count($results);
                                                $db->close();
                                                 }else if($_SESSION['agentdetails']->roleid == 15)
                                                 {
                                                      $db = db_connect();
                                                $query = $db->query("SELECT applicationid from applications where reservationstatusid=6 and created_by ={$_SESSION['agentdetails']->userid} and batchid IN ({$_SESSION['activebatch']})");
                                                $results = $query->getResult();
                                                $bg = count($results);
                                                $db->close();
                                                 }
                                                  elseif($_SESSION['agentdetails']->roleid == 1)
                                                  {
                                                      $db = db_connect();
                                                $query = $db->query("SELECT applicationid from applications where batchid IN ({$_SESSION['activebatch']}) and reservationstatusid=6");
                                                $results = $query->getResult();
                                                $bg = count($results);
                                                $db->close();
                                                  }
                                                  elseif($_SESSION['agentdetails']->userid == 7181)
                                                  {
                                                      $db = db_connect();
                                                $query = $db->query("SELECT applicationid from applications where batchid IN ({$_SESSION['activebatch']}) and reservationstatusid=6");
                                                $results = $query->getResult();
                                                $bg = count($results);
                                                $db->close();
                                                  }
                                                 else
                                                 {
                                                      $db = db_connect();
                                                $query = $db->query("SELECT applicationid from applications where reservationstatusid=6 and transferemployee ={$_SESSION['agentdetails']->userid} and batchid IN ({$_SESSION['activebatch']})");
                                                $results = $query->getResult();
                                                $bg = count($results);
                                                $db->close();
                                                 }
                                                ?>
                                                <div class="stat-panel-number h1 "><?php echo htmlentities($bg); ?></div>
                                                <div class="stat-panel-title text-uppercase">Total RET Eligible Leads</div>
                                            </div>
                                        </div>
                                    </div>
                                    </a>
                                </div>
                                
                                <div class="col-md-3">
                                    <a href="<?php echo base_url('agentdashboard/Applications');?>">
                                    <div class="panel panel-default">
                                        <div class="panel-body bk-primary text-light">
                                            <div class="stat-panel text-center">
                                                <?php
                            if($_SESSION['agentdetails']->roleid == 1)
                                                  {
                                                      $db = db_connect();
                                                $query = $db->query("SELECT applicationid from applications where is_migrate=1 and batchid IN ({$_SESSION['activebatch']})");
                                                $results = $query->getResult();
                                                $migrate = count($results);
                                                $db->close();
                                                  }
                                                  ?>
                            <div class="stat-panel-number h1 "><?php echo htmlentities($migrate); ?></div>
                                                <div class="stat-panel-title text-uppercase">Total Migrated Applications</div>
                                            </div>
                                        </div>
                                    </div>
                                    </a>
                                </div>
                            
                           <?php
                           if( $_SESSION['agentdetails']->roleid != 15 &&  $_SESSION['agentdetails']->roleid != 1){
                           ?>
                           
                                <div class="col-md-3">
                                    <a  href="<?php echo base_url('agentdashboard/applications?reservationstatusid=5') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <?php
                                                     if( $_SESSION['agentdetails']->roleid ==3){
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT * from applications
                                                                         WHERE reservationstatusid IN (5) 
                                                                         and branchid IN ({$_SESSION['agentdetails']->branchid})
                                                                         and batchid IN ({$_SESSION['activebatch']})");
                                                    $results = $query->getResult();
                                                    $bg = count($results);
                                                    $db->close();
                                                     }else
                                                     {
                                                         $db = db_connect();
                                                    $query = $db->query("SELECT * from applications
                                                                         WHERE reservationstatusid IN (5) 
                                                                         and transferemployee = {$_SESSION['agentdetails']->userid}
                                                                         and batchid IN ({$_SESSION['activebatch']})");
                                                    $results = $query->getResult();
                                                    $bg = count($results);
                                                    $db->close();
                                                     }
                                                    ?>
                                                    <div class="stat-panel-number h1 "><?php echo htmlentities($bg); ?></div>
                                                    <div class="stat-panel-title text-uppercase">Confirmed Applications</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a  href="<?php echo base_url('agentdashboard/applications?reservationstatusid=4') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <?php
                                                     if( $_SESSION['agentdetails']->roleid ==3){
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT * from applications
                                                                         WHERE reservationstatusid IN (4) 
                                                                         and branchid IN ({$_SESSION['agentdetails']->branchid})
                                                                         and batchid IN ({$_SESSION['activebatch']})");
                                                    $results = $query->getResult();
                                                    $bg = count($results);
                                                    $db->close();
                                                     }else
                                                     {
                                                         $db = db_connect();
                                                    $query = $db->query("SELECT * from applications
                                                                         WHERE reservationstatusid IN (4) 
                                                                         and transferemployee = {$_SESSION['agentdetails']->userid}
                                                                         and batchid IN ({$_SESSION['activebatch']})");
                                                    $results = $query->getResult();
                                                    $bg = count($results);
                                                    $db->close();
                                                     }
                                                    ?>
                                                    <div class="stat-panel-number h1 "><?php echo htmlentities($bg); ?></div>
                                                    <div class="stat-panel-title text-uppercase">Approved Applications</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                        
                           
                                <div class="col-md-3">
                                    <a  href="<?php echo base_url('agentdashboard/applications?reservationstatusid=1') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <?php
                                                    if( $_SESSION['agentdetails']->roleid ==3){
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT * from applications
                                                                         WHERE reservationstatusid IN (1, 2) 
                                                                         and branchid IN ({$_SESSION['agentdetails']->branchid})
                                                                         and batchid IN ({$_SESSION['activebatch']})");
                                                    $results = $query->getResult();
                                                    $bg = count($results);
                                                    $db->close();
                                                    }else
                                                     {
                                                         $db = db_connect();
                                                    $query = $db->query("SELECT * from applications
                                                                         WHERE reservationstatusid IN (1,2) 
                                                                         and transferemployee = {$_SESSION['agentdetails']->userid}
                                                                         and batchid IN ({$_SESSION['activebatch']})");
                                                    $results = $query->getResult();
                                                    $bg = count($results);
                                                    $db->close();
                                                     }
                                                    ?>
                                                    <div class="stat-panel-number h1 "><?php echo htmlentities($bg); ?></div>
                                                    <div class="stat-panel-title text-uppercase">Pending Applications</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                          
                                <div class="col-md-3">
                                    <a target="_blank" href="<?php echo base_url('agentdashboard/applications?reservationstatusid=3') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT * from applications
                                                                         WHERE reservationstatusid IN (3) 
                                                                         and branchid IN ({$_SESSION['agentdetails']->branchid})
                                                                         and applications.batchid IN ({$_SESSION['activebatch']})");
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
                          
<?php } ?>
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>