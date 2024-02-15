// <?php
if ($_SESSION['rights'] != null) : ?>
    <nav class="ts-sidebar">
        <ul class="ts-sidebar-menu">
         
      <li><a href="<?php echo base_url('agentdashboard') ?>"><i class="fa fa-dashboard"></i>&nbsp;Dashboard</a></li>
           <li data-toggle="collapse" data-target="#Application" class="collapsed active">
                    <a href="#"><i class="fa fa-calendar"></i>Applications</a><i class="fa fa-angle-double-right" hidden></i>
                </li>
                <ul class="sub-menu collapse" id="Application">
                    
                    <!--<li style="margin-left: 30px;"><a href="<?php echo base_url('agentdashboard/addApplicant') ?>"><i class="fa fa-calendar"></i>Add Application</a></li>-->
                   <!--<li style="margin-left: 30px;"><a href="<?php echo base_url('agentdashboard/RetApplications') ?>"><i class="fa fa-calendar"></i>View RET Eligible Leads</a></li>-->
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('agentdashboard/Applications') ?>"><i class="fa fa-calendar"></i>View Applications</a></li>

                </ul>
          
                
           
           
<li><a href="<?php echo base_url('home/changeapplicationpassword') ?>"><i class="fa fa-key"></i> &nbsp;Change Password</a></li>
            <li><a href="<?php echo base_url('home/applicationlogout') ?>"><i class="fa fa-sign-out"></i> &nbsp;Logout</a></li>
        </ul>
    </nav>
<?php
endif; ?>