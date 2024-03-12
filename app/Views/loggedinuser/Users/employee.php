<style>
        .accordion {
            border: 1px solid #ccc;
            margin-bottom: 20px;
        }
        
        .accordion-item {
            border-bottom: 1px solid #ccc;
        }
        
        .accordion-header {
            background-color: #f5f5f5;
            padding: 10px;
            font-weight: bold;
            cursor: pointer;
            text-align: right;
        }
        
        .accordion-content {
            padding: 10px;
            display: none;
        }
    </style>
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">List of Employees
                <a class="btn btn-success" style="float: right;margin-left:10px;" data-toggle="modal" data-target="#addonboardusers">Create Employee On Boarding</a> <a class="btn btn-success" style="float: right;" data-toggle="modal" data-target="#addotherusers">Add Employee</a>
                </h2>
                <br />
                <form id="filterForm" >
                    <div class="row">
                        <div class="col-md-3">
                            <select name="branchid" style="width: 100%;" class="form-control mb">
                                <option value="">Select Branch</option>
                                <?php
                                foreach ($lookups['branchlookup'] as $branch) :
                                ?>
                                    <option value="<?php echo $branch->branchid; ?>" <?php echo isset($_GET['branchid']) && $_GET['branchid'] == $branch->branchid ? "selected" : "" ?>><?php echo $branch->branchname; ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="roleid" style="width: 100%;" class="form-control mb">
                                <option value="">Select Role</option>
                                <?php
                                foreach ($lookups['roleslookup'] as $role) :
                                ?>
                                    <option value="<?php echo $role->roleid; ?>" <?php echo isset($_GET['roleid']) && $_GET['roleid'] == $role->roleid ? "selected" : "" ?>><?php echo $role->rolename; ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                         <div class="col-md-3">
                            <select name="active" style="width: 100%;" class="form-control mb">
                                <option value="">Select Active</option>
                               <option value="1" <?php echo isset($_GET['active']) && $_GET['active'] == 1 ? "selected" : "" ?>>Active</option>
                               <option value="0" <?php echo isset($_GET['active']) && $_GET['active'] == 0 ? "selected" : "" ?>>In-Active</option>

                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </form>
                <a class="btn btn-primary" onclick="filter(1)">Download Excel</a>
                <br />
                 <br />
                 
                 <div class="accordion">
        <div class="accordion-item">
            <div class="accordion-header"><i class="fa fa-caret-down" aria-hidden="true"></i></div>
            <div class="accordion-content">
                 <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                             
                                <div class="col-md-4">
                                    <a href="<?php echo base_url('agentdashboard/Applications');?>">
                                    <div class="panel panel-default">
                                        <div class="panel-body bk-primary text-light">
                                            <div class="stat-panel text-center">
                                                <div class="stat-panel-number h1 "><?php
                                                $db = db_connect();
                                                $query = $db->query("SELECT employeeid from employeedetails");
                                                $results = $query->getResult();
                                                $bg = count($results);
                                                $db->close();
                                                     echo $bg;?></div>
                                                <div class="stat-panel-title text-uppercase">Total Employees</div>
                                            </div>
                                        </div>
                                    </div>
                                    </a>
                                </div>
                                 <div class="col-md-4">
                                    <a href="<?php echo base_url('agentdashboard/Applications');?>">
                                    <div class="panel panel-default">
                                        <div class="panel-body bk-primary text-light">
                                            <div class="stat-panel text-center">
                                                <div class="stat-panel-number h1 "><?php
                                                $db = db_connect();
                                                $query = $db->query("SELECT employeeid from employeedetails where active=1");
                                                $results = $query->getResult();
                                                $bg = count($results);
                                                $db->close();
                                                     echo $bg;?></div>
                                                <div class="stat-panel-title text-uppercase">Active Employees</div>
                                            </div>
                                        </div>
                                    </div>
                                    </a>
                                </div>
                                 <div class="col-md-4">
                                    <a href="<?php echo base_url('agentdashboard/Applications');?>">
                                    <div class="panel panel-default">
                                        <div class="panel-body bk-primary text-light">
                                            <div class="stat-panel text-center">
                                                <div class="stat-panel-number h1 "><?php
                                                 $db = db_connect();
                                                $query = $db->query("SELECT employeeid from employeedetails where active=0");
                                                $results = $query->getResult();
                                                $bg = count($results);
                                                $db->close();
                                                     echo $bg;?></div>
                                                <div class="stat-panel-title text-uppercase">In-active Employees</div>
                                            </div>
                                        </div>
                                    </div>
                                    </a>
                                </div>
                                </div>
                                </div>
                                </div>
                <p></p>
            </div>
        </div>
    </div>

                <div class="row">
                    <div class="col-md-12">
                        <table id="tblotherusers" class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>Employee Id</th>
                                    <th>Contact</th>
                                    <th>Name</th>
                                    <th>Branch Name</th>
                                    <th>Role Name</th>
                                    <th>Status</th>
                                    <th>Two Step Verification status</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                foreach ($EmployeeDetails as $result) :

                                    $branchids = explode(',', $result->branchid ?? '');
                                    

                                    if (isset($_GET['branchid'])) {
                                        if ($_GET['branchid'] == "" || in_array($_GET['branchid'], $branchids)) {
                                        } else {
                                            continue;
                                        }
                                    }
                                    if (isset($_GET['roleid'])) {
                                        if ($_GET['roleid'] == "" || $result->roleid == $_GET['roleid']) {
                                        } else {
                                            continue;
                                        }
                                    }
                                    $branches = "";
                                    if ($result->branchid != null) {
                                        foreach ($branchids as $branchid) {
                                            foreach ($lookups['branchlookup'] as $branch) {
                                                if ($branch->branchid == $branchid) {
                                                    $branches .= $branch->branchname . ', ';
                                                    break;
                                                }
                                            }
                                        }
                                    }

                                ?>
                                    <tr>
                                        <td><a target="_blank" href="<?php echo base_url('users/employeedetails') . '/' . $result->userid ?>"><?php echo $result->employeeid ?></a></td>
                                        <td><?php echo $result->mobile ?></td>
                                        <td><?php echo $result->name ?></td>
                                        <td><?php echo rtrim($branches, ', '); ?></td>
                                        <td><?php echo $result->rolename ?></td>
                                        <td>
  				<?php if($result->active == '1'){ ?>

  					<button class="btn btn-success user_status" uid="<?php echo $result->userid; ?>"  ustatus="<?php echo $result->active; ?>">Active</button>
                    
  				<?php }else{ ?>

  					<button class="btn btn-primary user_status" uid="<?php echo $result->userid; ?>"  ustatus="<?php echo $result->active; ?>">Inactive</button>

  				<?php } ?>
  			</td>
  			<td>
  				<?php if($result->twostep_verification == 1){ ?>

  					<button class="btn btn-success user_twostepstatus" uid="<?php echo $result->userid; ?>"  ustatus="<?php echo $result->twostep_verification; ?>">Active</button>
                    
  				<?php }else{ ?>

  					<button class="btn btn-primary user_twostepstatus" uid="<?php echo $result->userid; ?>"  ustatus="<?php echo $result->twostep_verification; ?>">Inactive</button>

  				<?php } ?>
  			</td>
                                        <td><a target='_blank' href="<?php echo base_url('users/employeedetails') . '/' . $result->userid ?>"><i class="fa fa-pencil-square-o editbtn"></i></a></td>
                                        <td><?php
                                            $html = "<a href='" . base_url('users/deleteemployee') . "?id=" . $result->userid . "' class='btn-del'><i class='fa fa-trash'></i></a>";
                                            echo $html; ?></i></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
     <div class="modal fade" id="addonboardusers" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title">Add On Board Employee</h2>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" enctype="multipart/form-data" action="<?php echo base_url('users/createonboardemployee') ?>">
                                    <br>
                                    <div class="row">
                                        <!-- <div class="col-md-6">
                                            <label class="text-uppercase text-sm">Employee Id</label>
                                            <input type="text" value="MDG0<?php echo $nextemployeeid; ?>" placeholder="Employee Id" disabled class="form-control mb" required>
                                            <input type="hidden" name="employee_id" value="MDG0<?php echo $nextemployeeid; ?>" id="reservationid" class="form-control formfield" required>
    
                                        </div> -->
                                        <div class="col-md-6">
                                            <label class="text-uppercase text-sm">Mobile</label>
                                            <input type="number" placeholder="Mobile" name="mobile" class="form-control mb" required>
    
                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-primary">Create</button>
                                        </div>
                                    </div>
    
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="modal fade" id="addotherusers" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title">Add Employee</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="<?php echo base_url('users/createemployee') ?>">
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Name</label>
                                        <input type="text" placeholder="Name" name="name" class="form-control mb" required>
                                    </div>
                                    <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Profile Image</label>
                                    <input accept="image/*" onchange="preview_image(event)" type="file" id="profile_image" name="profile_image" class="form-control mb" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Branch</label>
                                        <select name="branchid[]" style="width: 100%;" class="select2 form-control mb" multiple>
                                            <?php
                                            foreach ($lookups['branchlookup'] as $branch) :
                                            ?>
                                                <option value="<?php echo $branch->branchid; ?>"><?php echo $branch->branchname; ?></option>
                                            <?php
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Role</label>
                                        <select name="roleid" style="width: 100%;" class="select2 form-control mb" required>
                                            <option value="">Select Role</option>
                                            <?php
                                            foreach ($lookups['roleslookup'] as $role) :
                                            ?>
                                                <option value="<?php echo $role->roleid; ?>"><?php echo $role->rolename; ?></option>
                                            <?php
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Username</label>
                                        <input type="text" placeholder="Username" name="username" class="form-control mb" required>

                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Password</label>
                                        <input type="text" placeholder="Password" name="password" class="form-control mb" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Designation</label>
                                        <input type="text" placeholder="Designation" name="designation" class="form-control mb" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Employee Id</label>
                                        <input type="text" value="MDG0<?php echo $nextemployeeid;?>" placeholder="Employee Id" disabled class="form-control mb" required>
                                                    <input type="hidden" name="employee_id" value="MDG0<?php echo $nextemployeeid;?>" id="reservationid" class="form-control formfield" required>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Mobile</label>
                                        <input type="number" placeholder="Mobile" name="mobile" class="form-control mb" required>

                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">E-Mail</label>
                                        <input type="email" placeholder="Email ID" name="email" class="form-control mb" required>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Date of Joining</label>
                                        <input type="date" placeholder="Date of Joining" name="joiningdate" class="form-control mb" required>
                                    </div>
                                    <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Total Leaves</label>
                                    <input id="totalleaves" type="number" placeholder="Leaves" name="totalleaves" class="form-control mb" required>
                                 </div>
                                </div>
                                <div class="row">
                                   
                                  <div class="col-md-6">
                                       <label class="text-uppercase text-sm">Reporting Employee(Leaves)</label>
                                    <select onchange="this.classList.remove('error')" name="reportperson" style="width: 100%;" class="select2 form-control mb">
                                        <option value="">Select Reporting Employee(Leaves)</option>
                                        <?php
                                        foreach ($EmployeeDetails as $reference) :
                                        ?>
                                            <option value="<?php echo $reference->userid ?>"><?php echo $reference->employeeid . " - " . $reference->name; ?></option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Gender</label>
                                        <select name="genderid" style="width: 100%;" class="select2 form-control mb" required>
                                            <option value="">Select Gender</option>
                                            <?php
                                            foreach ($lookups['genderlookup'] as $role) :
                                            ?>
                                                <option value="<?php echo $role->genderid; ?>"><?php echo $role->gendername; ?></option>
                                            <?php
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                 <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Login Time</label>
                                    <input id="logintime" type="time" placeholder="Login Time" name="logintime" class="form-control mb"  required>

                                 </div>
                                 <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Logout Time</label>
                                    <input id="logouttime" type="time" placeholder="Logout Time"  class="form-control mb"  name="logouttime">
                                 </div>
                              </div>
                                     <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Pan card</label>
                                        <input type="text" placeholder="Pancard" name="pancard" class="form-control mb" required>
                                    </div> 
                                    <br>
                                     <div class="row">
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary">Create Employee</button>
                                    </div>
                                    </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal modal-danger fade" id="modal_popup">

    <div class="modal-dialog modal-sm">

        
    	<form action="<?php echo base_url(); ?>/users/employee_status_changed" method="post"> 
	     	 <div class="modal-content">

		        <div class="modal-header" style="height: 150px;">

		          	<h4 style="margin-top: 50px;text-align: center;">Are you sure, do you change user status?</h4>

                  
					<input type="hidden" name="id" id="user_id" value="">
					<input type="hidden" name="status" id="user_status" value="">

		        </div>

		        <div class="modal-footer">

		            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">No</button>

		            <button type="submit" name="submit" class="btn btn-success">Yes</button>

		        </div>

	        </div>

        </form>

    </div>

 </div>
 
 <div class="modal modal-danger fade" id="modal_popup1">

    <div class="modal-dialog modal-sm">

        
    	<form action="<?php echo base_url(); ?>/users/employee_two_step_status_changed" method="post"> 
	     	 <div class="modal-content">

		        <div class="modal-header" style="height: 150px;">

		          	<h4 style="margin-top: 50px;text-align: center;">Are you sure, do you change Two Step verification status?</h4>

                  
					<input type="hidden" name="id" id="user_id1" value="">
					<input type="hidden" name="status" id="user_two_step_status" value="">

		        </div>

		        <div class="modal-footer">

		            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">No</button>

		            <button type="submit" name="submit" class="btn btn-success">Yes</button>

		        </div>

	        </div>

        </form>

    </div>

 </div>

<script type="text/javascript">
	$(document).on('click','.user_status',function(){

		var id = $(this).attr('uid'); //get attribute value in variable
		
		var status = $(this).attr('ustatus'); //get attribute value in variable

		$('#user_id').val(id); //pass attribute value in ID
		$('#user_status').val(status);  //pass attribute value in ID

		$('#modal_popup').modal({backdrop: 'static', keyboard: true, show: true}); //show modal popup

	});
</script>
<script type="text/javascript">
	$(document).on('click','.user_twostepstatus',function(){

		var id = $(this).attr('uid'); //get attribute value in variable
		
		var status = $(this).attr('ustatus'); //get attribute value in variable

		$('#user_id1').val(id); //pass attribute value in ID
		$('#user_two_step_status').val(status);  //pass attribute value in ID

		$('#modal_popup1').modal({backdrop: 'static', keyboard: true, show: true}); //show modal popup

	});
</script>
<script>
    function filter(download = 0) {
        var URL = "<?php echo base_url('users/employee') ?>" + "?" + $('#filterForm').serialize();
        if (download == 1) {
            URL = URL + "&download=1";
        }

        window.location.href = URL;
    }
</script>
 <script>
        const accordionItems = document.querySelectorAll('.accordion-item');

        accordionItems.forEach((item) => {
            const header = item.querySelector('.accordion-header');
            const content = item.querySelector('.accordion-content');

            header.addEventListener('click', () => {
                content.style.display = content.style.display === 'none' ? 'block' : 'none';
            });
        });
    </script>
<script>
    $('.btn-del').on('click', function(e) {
        e.preventDefault();
        const href = $(this).attr('href')
        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this Data!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    document.location.href = href;
                }
            })

    })
</script>
