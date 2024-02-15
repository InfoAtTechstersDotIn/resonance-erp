<div class="content-wrapper">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-12">
            <h2 class="page-title">Employee Details
               <a class="btn btn-success" style="float: right;" href="<?php echo base_url('users/resetphone?id=') . $EmployeeDetails->userid ?>">Reset Phone</a>
            </h2>
            <div class="row">
               <div class="col-md-12">
                  <ul class="nav nav-pills red">
                    <li class="nav-item active"><a class="nav-link active" data-toggle="tab" href="#profile">Profile</a></li>
                     <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#inventory">Inventory</a></li>

                     <?php if ($_SESSION['rights'][array_search('Attendance', array_column($_SESSION['rights'], 'operationname'))]->_add == 1) : ?>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#attendance">Attendance</a></li>
                     <?php endif; ?>
                     <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#financetab">Finance</a></li>
                     <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#idcard">Issue Id Card</a></li>
                  </ul>
                  <div class="tab-content">
                     <div id="profile" class="tab-pane fade in active">
                        <br />
                        <div class="col-md-12">
                           <form method="post" action="<?php echo base_url('users/updateemployee') ?>">
                              <br>
                              <div class="row">
                                 <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Name</label>
                                    <input id="name" type="text" placeholder="Name" name="name" class="form-control mb" value="<?php echo $EmployeeDetails->name; ?>" required>
                                 </div>
                                 <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Designation</label>
                                    <input id="designation" type="text" placeholder="Designation" name="designation" class="form-control mb" value="<?php echo $EmployeeDetails->designation; ?>" required>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Mobile</label>
                                    <input id="mobile" type="number" placeholder="Mobile" name="mobile" class="form-control mb" value="<?php echo $EmployeeDetails->mobile; ?>" required>
                                    <input type="text" name="id" id="id" value="<?php echo $EmployeeDetails->userid; ?>" hidden>
                                 </div>
                                 <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Email</label>
                                    <input id="email" type="email" placeholder="Email Address" name="email" class="form-control mb" value="<?php echo $EmployeeDetails->email; ?>" required>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Branch</label>
                                    <?php

                                    ?>
                                    <select id="branchid" name="branchid[]" style="width: 100%;" class="select2 form-control mb" multiple>
                                       <option value=""></option>
                                       <?php
                                       $branchids = explode(',', $EmployeeDetails->branchid);

                                       foreach ($lookups['branchlookup'] as $branch) :
                                       ?>
                                          <option <?php echo in_array($branch->branchid,  $branchids) ? "selected" : "" ?> value="<?php echo $branch->branchid; ?>"><?php echo $branch->branchname; ?></option>
                                       <?php
                                       endforeach;
                                       ?>
                                    </select>
                                 </div>
                                 <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Role</label>
                                    <select id="roleid" name="roleid" style="width: 100%;" class="select2 form-control mb">
                                       <option value=""></option>

                                       <?php
                                       foreach ($lookups['roleslookup'] as $role) :
                                       ?>
                                          <option <?php echo $EmployeeDetails->roleid == $role->roleid ? "selected" : "" ?> value="<?php echo $role->roleid; ?>"><?php echo $role->rolename; ?></option>
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
                                    <input id="username" type="text" placeholder="Username" name="username" class="form-control mb" value="<?php echo $EmployeeDetails->username; ?>" required>

                                 </div>
                                 <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Password</label>
                                    <input type="text" placeholder="Password" name="password" class="form-control mb">
                                    <input id="password" type="hidden" placeholder="Password" value="<?php echo $EmployeeDetails->password ?>" name="password_hidden">
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Leaves Allowed Per Month</label>
                                    <input id="leavespermonth" type="number" placeholder="Leaves" name="leavespermonth" class="form-control mb" required value="<?php echo $EmployeeDetails->leavespermonth ?>">
                                 </div>
                                 <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Is Marketing</label>
                                    <input id="marketing" type="checkbox" placeholder="marketing" name="marketing" class="form-control mb" <?php if( $EmployeeDetails->is_marketing==1){ echo "checked"; }else{ ""; } ?>>
                                 </div>
                              </div>
                               <div class="row">
                                 <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Login Time</label>
                                    <input id="logintime" type="time" placeholder="Login Time" name="logintime" class="form-control mb" value="<?php echo $EmployeeDetails->login_time; ?>" required>

                                 </div>
                                 <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Logout Time</label>
                                    <input id="logouttime" type="time" placeholder="Logout Time"  class="form-control mb"  value="<?php echo $EmployeeDetails->logout_time ?>" name="logouttime">
                                 </div>
                              </div>
                              <div class="row">
                               <div class="col-md-6">
                                    <select onchange="this.classList.remove('error')" name="reportperson" style="width: 100%;" class="select2 form-control mb">
                                        <option value="">Select Reporting Employee(Leaves)</option>
                                        <?php
                                       // echo $StudentDetail->referredby;
                                            
                                        foreach ($EmployeeDetail as $reference) :
                                           // echo $reference->userid
                                        ?>
                                            <option value="<?php echo $reference->userid ?>" <?php echo $EmployeeDetails->report_person == $reference->userid ? "selected" : "" ?>><?php echo $reference->employeeid . " - " . $reference->name; ?></option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                                 <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Total Leaves</label>
                                    <input id="totalleaves" type="number" placeholder="Leaves" name="totalleaves" class="form-control mb" required value="<?php echo $EmployeeDetails->totalleaves ?>">
                                 </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                    <label class="text-uppercase text-sm">My Reporting Employee </label>
                                    <br>
                                <?php foreach($ReportingEmployees as $emp)
                                {
                                    ?>
                                    <?php echo $emp->name;?> <a  onclick="myFunction(<?php echo $emp->userid;?>,<?php echo $EmployeeDetails->userid;?>)" ><i class="fa fa-remove"></i></a>
                                    <?php
                                    echo "<br>";
                                } ?>
                                 </div>
                                  <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Add Reporting Employee </label>
                                     <select id="report_employee" name="report_employee[]" style="width: 100%;" class="select2 form-control mb" multiple>
                                          <option value="">Add Employees</option>
                                <?php foreach($NonReportEmployees as $emp)
                                {
                                    ?>
                                  <option value="<?php echo $emp->userid; ?>"><?php echo $emp->name; ?></option>

                                    <?php
                                } ?>
                                </select>
                                 </div>
                              </div>
                              <div class="row">

                              </div>
                              <?php
                              if ($_SESSION['rights'][array_search('Employee', array_column($_SESSION['rights'], 'operationname'))]->_edit == 1) : ?>
                                 <button type="submit" name="update_otherusers" class="btn btn-primary">Update Employee</button>
                              <?php
                              endif;
                              ?>
                           </form>
                        </div>
                     </div>

                     <div id="inventory" class="tab-pane fade">
                        <br />
                        <div class="col-md-12">
                           <table id="tblotherusers" class="DataTable table table-striped">
                              <thead>
                                 <tr>
                                    <th>Employee Name</th>
                                    <th>Distributed</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php foreach ($Inventory as $inv) :
                                    if ($inv->branchid == 0 || in_array($inv->branchid, explode(",", $EmployeeDetails->branchid))) :
                                 ?>
                                       <tr>
                                          <td>
                                             <?php echo $inv->productname ?>
                                          </td>
                                          <td>
                                             <input type="checkbox" disabled <?php echo $inv->givenby != "" ? 'checked' : '' ?> />
                                             <?php echo ($inv->date != "" ? " - " . date_format(date_create($employee->date), 'd/m/Y') : "") ?>
                                          </td>
                                       </tr>
                                 <?php
                                    endif;
                                 endforeach
                                 ?>
                              </tbody>
                           </table>
                        </div>
                     </div>

                     <?php if ($_SESSION['rights'][array_search('Attendance', array_column($_SESSION['rights'], 'operationname'))]->_add == 1) : ?>
                        <div id="attendance" class="tab-pane fade">
                           <br />
                           <table id="tblotherusers" class="DataTable table table-striped " style="width: 100%;">
                              <thead>
                                 <tr>
                                    <th hidden></th>
                                    <th>Date</th>
                                    <th>Action</th>
                                    <th>Time</th>
                                    <th>Other Details</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php
                                 if ($EmployeeAttendance != null) :
                                    foreach ($EmployeeAttendance as $result) :
                                 ?>
                                       <tr>
                                          <td hidden></td>
                                          <td style="color: white;background-color: <?php echo $result->is_employee_workingday == 1 ? 'green' : 'red' ?>"><b><?php echo date_format(date_create($result->date), 'd/m/Y') . " - {$result->comment}" ?></b><br /><?php echo $result->day ?></td>
                                          <td style="color: white;background-color: <?php echo $result->status == 1 ? 'green' : ($result->status == 0 ? 'red' : 'orange') ?>">
                                             Present: <input type="radio" <?php echo $result->status == 1 ? 'checked' : '' ?> name="attendance_<?php echo $result->date ?>" onclick="recordAttendance('<?php echo base_url('users/update_employee_attendance') . '/' . $result->date . '/' . $EmployeeDetails->userid . '/' . 1 ?>')" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                             Absent: <input type="radio" <?php echo $result->status == 0 ? 'checked' : '' ?> name="attendance_<?php echo $result->date ?>" onclick="recordAttendance('<?php echo base_url('users/update_employee_attendance') . '/' . $result->date . '/' . $EmployeeDetails->userid . '/' . 0 ?>')" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                             <!--Late: <input type="radio" <?php echo $result->status == 2 ? 'checked' : '' ?> name="attendance_<?php echo $result->date ?>" onclick="recordAttendance('<?php echo base_url('users/update_employee_attendance') . '/' . $result->date . '/' . $EmployeeDetails->userid . '/' . 2 ?>')" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
                                          </td>
                                          <td>
                                             <?php
                                             if ($result->status == 1) {
                                                echo "Login Time: " . $result->loginTime . "<br />";
                                                echo "Logout Time: " . $result->logoutTime . "<br />";
                                             }
                                             ?>
                                          </td>
                                          <td>
                                             Late Reason: <?php echo $result->reason; ?><br />
                                             Late Regularised: <?php echo $result->regularised == 1 ? "Yes" : "No"; ?><br />
                                             Early Logout: <?php echo $result->isEarlyLogout == 1 ? "Yes" : "No"; ?><br />
                                             Early Logout: <?php echo $result->earlyLogoutReason; ?><br />
                                          </td>
                                       </tr>
                                 <?php endforeach;
                                 endif; ?>
                              </tbody>
                           </table>
                        </div>
                     <?php endif; ?>
                     <div id="financetab" class="tab-pane fade">
                        <br>
                        <div class="col-md-12">
                           <ul class="nav nav-pills red">
                              <li class="nav-item active"><a class="nav-link active" data-toggle="tab" href="#package">Package</a></li>
                              <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#accounts">Bank Accounts</a></li>
                              <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#salarystructure">Salary Structure</a></li>
                              <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#loans">Advance Payments</a></li>
                              <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#insurance">Insurance</a></li>
                              <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#salary">Payslips</a></li>
                           </ul>
                           <div class="tab-content">

                              <div id="package" class="tab-pane fade in active">
                                 <br>
                                 <a class="btn btn-success" style="background-color: #00203d;" data-toggle="modal" data-target="#addpackage">Add Package</a>
                                 <br><br>
                                 <table id="tblenrollments" class="DataTable table table-striped" style="width: 100% !important;">
                                    <thead>
                                       <tr>
                                          <th>Package</th>
                                          <th>TDS Applicable</th>
                                          <th>Status</th>
                                          <th>Date</th>
                                          <th>Actions</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php
                                       if (!empty($Packages)) {
                                          foreach ($Packages as $Package) {
                                       ?>
                                             <tr>

                                                <td> <?php echo $Package->package ?>
                                                </td>
                                                <td> <?php if ($Package->is_tds == 1) {
                                                         echo "Yes";
                                                      } else {
                                                         echo "No";
                                                      } ?>
                                                </td>
                                                <td> <?php if ($Package->status == 1) {
                                                         echo "Active";
                                                      } else {
                                                         echo "In-active";
                                                      } ?>
                                                </td>
                                                <td> <?php echo $Package->created_at ?>
                                                <td>
                                                   <a class="btn btn-success" style="background-color: #00203d;" data-toggle="modal" data-target="#editpackage_<?php echo $Package->id ?>"> <i class='fa fa-pencil'></i></ </td>
                                             </tr>

                                             <div class="modal fade" id="editpackage_<?php echo $Package->id ?>" tabindex="-1" role="dialog">
                                                <div class="modal-dialog" role="document">
                                                   <div class="modal-content">
                                                      <div class="modal-header">
                                                         <h2 class="modal-title">Edit Package</h2>
                                                         <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -45px;">
                                                            <span>&times;</span>
                                                         </button>
                                                      </div>
                                                      <div class="modal-body">
                                                         <form method="post" action="<?php echo base_url('users/editpackage') ?>">
                                                            <br>
                                                            <div class="row">
                                                               <div class="col-md-6">
                                                                  <input type="hidden" name="userid" value="<?php echo $EmployeeDetails->userid; ?>" />
                                                                  <input type="hidden" name="returnURL" value="users/employeedetails/<?php echo $EmployeeDetails->userid ?>" />
                                                                  <input type="hidden" name="packageid" value="<?php echo $Package->id; ?>" />
                                                                  <label class="text-uppercase text-sm">Package</label>
                                                                  <input type="text" placeholder="Package" name="package" class="form-control mb" value="<?php echo $Package->package; ?>" required>
                                                               </div>
                                                               <div class="col-md-6">
                                                                  <label class="text-uppercase text-sm">Is Tds(Check if TDS is applicable)</label>
                                                                  <input id="is_active" type="checkbox" placeholder="tds" name="is_tds" class="form-control mb" <?php if ($Package->is_tds == 1) {
                                                                                                                                                                     echo "checked";
                                                                                                                                                                  } else {
                                                                                                                                                                     "";
                                                                                                                                                                  } ?>>
                                                               </div>
                                                               <div class="col-md-6">
                                                                  <label class="text-uppercase text-sm">Is Active</label>
                                                                  <input id="is_active" type="checkbox" placeholder="marketing" name="status" class="form-control mb" <?php if ($Package->status == 1) {
                                                                                                                                                                           echo "checked";
                                                                                                                                                                        } else {
                                                                                                                                                                           "";
                                                                                                                                                                        } ?>>
                                                               </div>
                                                               <br />
                                                               <br />
                                                               <br />
                                                               <br />

                                                            </div>
                                                            <div>&nbsp;</div>
                                                            <button type="submit" name="addInvoice" class="btn btn-primary" style="margin-left: 236px;">Submit</button>
                                                         </form>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>

                                       <?php
                                          }
                                       }
                                       ?>
                                    </tbody>
                                 </table>
                              </div>

                              <div id="accounts" class="tab-pane fade">
                                 <br>
                                 <a class="btn btn-success" style="background-color: #00203d;" data-toggle="modal" data-target="#addaccount">Add Bank Account</a>
                                 <br><br>
                                 <table id="tblenrollments" class="DataTable table table-striped" style="width: 100% !important;">
                                    <thead>
                                       <tr>

                                          <th>Branch Name</th>
                                          <th>Bank Name</th>
                                          <th>Account Number</th>
                                          <th>IFSC Code</th>
                                          <th>Status</th>
                                          <th>Actions</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php
                                       if (!empty($Accounts)) {
                                          foreach ($Accounts as $account) {
                                       ?>
                                             <tr>

                                                <td> <?php echo $account->branch_name ?>
                                                </td>
                                                <td> <?php echo $account->bank_name ?>
                                                </td>
                                                <td> <?php echo $account->account_no ?>
                                                </td>
                                                <td> <?php echo $account->ifsc_code ?>
                                                </td>
                                                <td> <?php if ($account->is_active == 1) {
                                                         echo "Active";
                                                      } else {
                                                         echo "In-active";
                                                      } ?>
                                                </td>
                                                <td>
                                                   <a class="btn btn-success" style="background-color: #00203d;" data-toggle="modal" data-target="#editaccount_<?php echo $account->id ?>"> <i class='fa fa-pencil'></i></ </td>
                                             </tr>

                                             <div class="modal fade" id="editaccount_<?php echo $account->id ?>" tabindex="-1" role="dialog">
                                                <div class="modal-dialog" role="document">
                                                   <div class="modal-content">
                                                      <div class="modal-header">
                                                         <h2 class="modal-title">Edit Bank Account</h2>
                                                         <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -45px;">
                                                            <span>&times;</span>
                                                         </button>
                                                      </div>
                                                      <div class="modal-body">
                                                         <form method="post" action="<?php echo base_url('users/editaccount') ?>">
                                                            <br>
                                                            <div class="row">
                                                               <div class="col-md-6">
                                                                  <input type="hidden" name="userid" value="<?php echo $EmployeeDetails->userid; ?>" />
                                                                  <input type="hidden" name="returnURL" value="users/employeedetails/<?php echo $EmployeeDetails->userid ?>" />
                                                                  <input type="hidden" name="accountid" value="<?php echo $account->id; ?>" />
                                                                  <label class="text-uppercase text-sm">Bank Name</label>
                                                                  <input type="text" placeholder="Bank Name" name="bank_name" class="form-control mb" value="<?php echo $account->bank_name; ?>" required>
                                                               </div>
                                                               <div class="col-md-6">
                                                                  <label class="text-uppercase text-sm">Branch Name</label>
                                                                  <input type="text" placeholder="Branch Name" name="branch_name" class="form-control mb" value="<?php echo $account->branch_name; ?>" required>
                                                               </div>
                                                               <div class="col-md-6">
                                                                  <label class="text-uppercase text-sm">Account Number</label>
                                                                  <input type="text" placeholder="Account Number" name="account_no" class="form-control mb" value="<?php echo $account->account_no; ?>" required>
                                                               </div>
                                                               <div class="col-md-6">
                                                                  <label class="text-uppercase text-sm">IFSC Code</label>
                                                                  <input type="text" placeholder="IFSC Code" name="ifsc_code" class="form-control mb" value="<?php echo $account->ifsc_code; ?>" required>
                                                               </div>
                                                               <div class="col-md-6">
                                                                  <label class="text-uppercase text-sm">Is Active</label>
                                                                  <input id="is_active" type="checkbox" placeholder="marketing" name="is_active" class="form-control mb" <?php if ($account->is_active == 1) {
                                                                                                                                                                              echo "checked";
                                                                                                                                                                           } else {
                                                                                                                                                                              "";
                                                                                                                                                                           } ?>>
                                                               </div>
                                                               <br />
                                                               <br />
                                                               <br />
                                                               <br />

                                                            </div>
                                                            <div>&nbsp;</div>
                                                            <button type="submit" name="addInvoice" class="btn btn-primary" style="margin-left: 236px;">Submit</button>
                                                         </form>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>

                                       <?php
                                          }
                                       }
                                       ?>
                                    </tbody>
                                 </table>
                              </div>
                              <div id="salarystructure" class="tab-pane fade">
                                 <br>
                                 <a class="btn btn-success" style="background-color: #00203d;" data-toggle="modal" data-target="#addsalarystructure">Add Salary Structure</a>
                                 <br><br>
                                 <table id="tblenrollments" class="DataTable table table-striped" style="width: 100% !important;">
                                    <thead>
                                       <tr>

                                          <th>Basic</th>
                                          <th>HRA</th>
                                          <th>TDS</th>
                                          <th>PT</th>
                                          <th>Status</th>
                                          <th>Action</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php
                                       if (!empty($SalaryStructure)) {
                                          foreach ($SalaryStructure as $account) {
                                       ?>
                                             <tr>

                                                <td> <?php echo $account->basic ?>
                                                </td>
                                                <td> <?php echo $account->houserentalallowance ?>
                                                </td>
                                                <td> <?php echo $account->tds ?>
                                                </td>
                                                <td> <?php echo $account->pt ?>
                                                </td>
                                                <td> <?php if ($account->is_active == 1) {
                                                         echo "Active";
                                                      } else {
                                                         echo "In-active";
                                                      } ?>
                                                </td>
                                                <td>
                                                   <a class="btn btn-success" style="background-color: #00203d;" data-toggle="modal" data-target="#editsalarystructure_<?php echo $account->salarygradeid ?>"> <i class='fa fa-pencil'></i></ </td>
                                             </tr>

                                             <div class="modal fade" id="editsalarystructure_<?php echo $account->salarygradeid ?>" tabindex="-1" role="dialog">
                                                <div class="modal-dialog" role="document">
                                                   <div class="modal-content">
                                                      <div class="modal-header">
                                                         <h2 class="modal-title">Edit Salary Structure</h2>
                                                         <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -45px;">
                                                            <span>&times;</span>
                                                         </button>
                                                      </div>
                                                      <div class="modal-body">
                                                         <form method="post" action="<?php echo base_url('users/editsalarystructure') ?>">
                                                            <br>
                                                            <div class="row">
                                                               <div class="col-md-6">
                                                                  <input type="hidden" name="userid" value="<?php echo $EmployeeDetails->userid; ?>" />
                                                                  <input type="hidden" name="returnURL" value="users/employeedetails/<?php echo $EmployeeDetails->userid ?>" />
                                                                  <input type="hidden" name="accountid" value="<?php echo $account->salarygradeid; ?>" />
                                                                  <label class="text-uppercase text-sm">Basic</label>
                                                                  <input type="text" placeholder="Basic" name="basic" class="form-control mb" value="<?php echo $account->basic; ?>" required>
                                                               </div>
                                                               <div class="col-md-6">
                                                                  <label class="text-uppercase text-sm">HRA(Percentage on Basic)</label>
                                                                  <input type="text" placeholder="HRA" name="hra" class="form-control mb" value="<?php echo $account->houserentalallowance; ?>" required>
                                                               </div>
                                                               <div class="col-md-6">
                                                                  <label class="text-uppercase text-sm">PT</label>
                                                                  <input type="text" placeholder="PT" name="pt" class="form-control mb" value="<?php echo $account->pt; ?>" required>
                                                               </div>
                                                               <div class="col-md-6">
                                                                  <label class="text-uppercase text-sm">TDS</label>
                                                                  <input type="text" placeholder="TDS" name="tds" class="form-control mb" value="<?php echo $account->tds; ?>" required>
                                                               </div>
                                                               <div class="col-md-6">
                                                                  <label class="text-uppercase text-sm">Is Active</label>
                                                                  <input id="is_active" type="checkbox" placeholder="" name="is_active" class="form-control mb" <?php if ($account->is_active == 1) {
                                                                                                                                                                     echo "checked";
                                                                                                                                                                  } else {
                                                                                                                                                                     "";
                                                                                                                                                                  } ?>>
                                                               </div>
                                                               <br />
                                                               <br />
                                                               <br />
                                                               <br />

                                                            </div>
                                                            <div>&nbsp;</div>
                                                            <button type="submit" name="addInvoice" class="btn btn-primary" style="margin-left: 236px;">Submit</button>
                                                         </form>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>

                                       <?php
                                          }
                                       }
                                       ?>
                                    </tbody>
                                 </table>
                              </div>

                              <div id="loans" class="tab-pane fade">
                                 <br>
                                 <a class="btn btn-success" style="background-color: #00203d;" data-toggle="modal" data-target="#addloans">Add Advance Payment</a>
                                 <br><br>
                                 <table id="tblenrollments" class="DataTable table table-striped" style="width: 100% !important;">
                                    <thead>
                                       <tr>
                                          <th>Id</th>
                                          <th>Amount</th>
                                          <th>Months</th>
                                          <th>Effective Date</th>
                                          <th>Created By</th>
                                          <th>Status</th>

                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php
                                       if (!empty($Loans)) {
                                          foreach ($Loans as $loan) {
                                       ?>
                                             <tr>
                                                <td> <a target="_blank" href=<?php echo base_url("users/loandetails/$loan->id") ?>><?php echo $loan->id ?></a>
                                                </td>
                                                <td> <?php echo $loan->amount ?>
                                                </td>
                                                <td> <?php echo $loan->months ?>
                                                </td>
                                                <td> <?php $orgDate = $loan->effective_date;
                                                      $newDate = date("M Y", strtotime($orgDate));
                                                      echo $newDate ?>
                                                </td>
                                                <td> <?php echo $loan->CreatedBy ?>
                                                </td>
                                                <td> <?php if ($loan->status == 1) {
                                                         echo "Approved";
                                                      } elseif ($loan->status == 2) {
                                                         echo "Rejected";
                                                      } else {
                                                         echo "Pending";
                                                      } ?>
                                                </td>
                                                <td>
                                                   <!-- <a class="btn btn-success" style="background-color: #00203d;" data-toggle="modal" data-target="#editloan_<?php echo $loan->id ?>"> <i class='fa fa-pencil'></i></ </td> -->
                                             </tr>

                                         

                                       <?php
                                          }
                                       }
                                       ?>
                                    </tbody>
                                 </table>
                              </div>
                              
                              <div id="insurance" class="tab-pane fade">
                                 <br>
                                 <a class="btn btn-success" style="background-color: #00203d;" data-toggle="modal" data-target="#addinsurance">Add Insurance</a>
                                 <br><br>
                                 <table id="tblenrollments" class="DataTable table table-striped" style="width: 100% !important;">
                                    <thead>
                                       <tr>
                                          <th>Id</th>
                                          <th>Policy Number</th>
                                          <th>Provider</th>
                                          <th>URL</th>
                                          <th>Date</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php
                                       if (!empty($Insurance)) {
                                          foreach ($Insurance as $loan) {
                                       ?>
                                             <tr>
                                                <td> <a target="_blank" href=<?php echo base_url("users/loandetails/$loan->id") ?>><?php echo $loan->id ?></a>
                                                </td>
                                                <td> <?php echo $loan->policy_no ?>
                                                </td>
                                                <td> <?php echo $loan->provider ?>
                                                </td>
                                                <td> <?php $orgDate = $loan->url;
                                                     // $newDate = date("M Y", strtotime($orgDate));
                                                      echo $orgDate ?>
                                                </td>
                                                <td> <?php echo $loan->date ?>
                                                </td>
                                               
                                                <td>
                                                   <!-- <a class="btn btn-success" style="background-color: #00203d;" data-toggle="modal" data-target="#editloan_<?php echo $loan->id ?>"> <i class='fa fa-pencil'></i></ </td> -->
                                             </tr>

                                         

                                       <?php
                                          }
                                       }
                                       ?>
                                    </tbody>
                                 </table>
                              </div>


                              <div id="salary" class="tab-pane fade">
                                 <br />
                                 <div class="row">
                                    <div class="col-md-12">
                                       <table id="tblotherusers" class="DataTable table table-striped" style="width: 100%;">
                                          <thead>
                                             <tr>
                                                <th>Date</th>
                                                <th>Breakdown</th>
                                                <th>Edit</th>
                                                <th>Regenerate</th>
                                                <th>Download Payslip</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                             <?php
                                             if ($EmployeeSalaries != null) :
                                                foreach ($EmployeeSalaries as $result) :
                                             ?>
                                                   <tr>
                                                      <td><?php echo date_format(date_create($result->salarydate), "M-Y") ?></td>
                                                      <td>
                                                         <a data-toggle="modal" data-target="#addsalarygrade_<?php echo $result->salarypaymentid ?>"><i class="fa fa-sticky-note-o"></i></a>
                                                         <div class="modal fade" id="addsalarygrade_<?php echo $result->salarypaymentid ?>" tabindex="-1" role="dialog">
                                                            <div class="modal-dialog" role="document" style="width: 90vw">
                                                               <div class="modal-content">
                                                                  <div class="modal-header">
                                                                     <h2 class="modal-title">Salary Breakdown</h2>
                                                                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span>&times;</span>
                                                                     </button>
                                                                  </div>
                                                                  <div class="modal-body">
                                                                     <div class="row">
                                                                        <div class="col-md-3">
                                                                           <b>Name:</b> <?php echo $result->name . " ({$result->employeeid})"; ?><br />
                                                                           <b>Package:</b> <?php echo $result->ctc; ?><br />
                                                                           <b>Monthly:</b> <?php echo $result->monthly; ?><br />
                                                                           <b>Daily:</b> <?php echo $result->daily; ?><br />
                                                                           <b>Date:</b> <?php echo $result->salarydate; ?><br />
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                           <b>Basic:</b> <?php echo $result->basic; ?><br />
                                                                           <b>House Rental Allowance:</b> <?php echo $result->houserentalallowance; ?><br />
                                                                           <b>Special Allowance:</b> <?php echo $result->specialallowance; ?><br />
                                                                           <b>Transport Allowance:</b> <?php echo $result->transportallowance; ?><br /><br />
                                                                           <b>Basic Arrears:</b> <?php echo $result->basic_arrears; ?><br />
                                                                           <b>Other Arrears:</b> <?php echo $result->other_arrears; ?><br />
                                                                           <b>Bonus:</b> <?php echo $result->bonus; ?><br /><br />
                                                                           <b>Gross:</b> <?php echo $result->gross; ?><br />
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                           <b>PT:</b> <?php echo $result->pt; ?><br />
                                                                           <b>TDS:</b> <?php echo $result->tds; ?><br />
                                                                           <b>Penalty:</b> <?php echo $result->penalty; ?><br />
                                                                           <b>Other Deductions:</b> <?php echo $result->other_decuctions; ?><br /><br />
                                                                           <b>Net:</b> <?php echo $result->net; ?><br /><br />
                                                                           <b>Comments:</b> <?php echo $result->comments; ?><br /><br />
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                           <b>Total Business Days:</b> <?php echo $result->totalbusinessdays; ?><br />
                                                                           <b>Total Paid Days:</b> <?php echo $result->paiddays; ?><br />
                                                                           <b>Total Unpaid Days:</b> <?php echo $result->unpaiddays; ?><br />
                                                                        </div>
                                                                     </div>
                                                                  </div>
                                                               </div>
                                                            </div>
                                                         </div>
                                                      </td>
                                                      <td>
                                                         <?php
                                                         $todaysDate = date_create(date("Y-m-d"));
                                                         $todaysmonth = (date("Y-m-d"));
                                                         $newdate = date("m", strtotime('-0 month', strtotime($todaysmonth)));
                                                         $salaryDate = date_create($result->salarydate);
                                                         if (
                                                            $newdate == date_format($salaryDate, "m") &&
                                                            date_format($todaysDate, "Y") == date_format($salaryDate, "Y")
                                                         ) : ?>
                                                            <a href="<?php echo base_url('payroll/edit_payslip') . '/' . $result->salarypaymentid ?>"><i class="fa fa-pencil-square-o editbtn"></i></a>
                                                         <?php
                                                         endif; ?>
                                                      </td>
                                                      <td>
                                                         <?php
                                                         $todaysDate = date_create(date("Y-m-d"));
                                                         $salaryDate = date_create($result->salarydate);
                                                         if (
                                                            $newdate == date_format($salaryDate, "m") &&
                                                            date_format($todaysDate, "Y") == date_format($salaryDate, "Y")
                                                         ) : ?>
                                                            <a href="<?php echo base_url("payroll/regenerate_salary/{$result->userid}/{$result->salarydate}") ?>" onclick="return confirm('Are you sure to regenerate salary?')"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                                                         <?php
                                                         endif; ?>
                                                      </td>
                                                      <td><a target="_blank" href="<?php echo base_url("payments/generatepayslip/{$result->salarypaymentid}") ?>"><i class="fa fa-download" aria-hidden="true"></i></a></td>
                                                   </tr>
                                             <?php
                                                endforeach;
                                             endif;
                                             ?>
                                          </tbody>
                                       </table>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div id="idcard" class="tab-pane fade">
                                <br>
                               <a class="btn btn-success" style="background-color: #00203d;" data-toggle="modal" data-target="#addidcard">Issue Id Card</a>
                              <br><br>
                              <table id="tblenrollments" class="DataTable table table-striped" style="width: 100% !important;">
                                 <thead>
                                    <tr>
                                       <th>Id Card</th>
                                       <th>Actions</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                        <?php
                                        if($EmployeeDetails->rfid != ''){
                                        ?>
                                          <tr>
                                             <td> <?php echo $EmployeeDetails->rfid ?>
                                          </td>
                                             <td>
                                               <a class="btn btn-success" style="background-color: #00203d;" data-toggle="modal" data-target="#editidcard"> <i class='fa fa-pencil'></i></
                                             </td>
                                          </tr>
                                    <?php
                                        }
                                        ?>
                                 </tbody>
                              </table>
                           </div>
                           
                            <div id="accounts" class="tab-pane fade">
                                <br>
                               <a class="btn btn-success" style="background-color: #00203d;" data-toggle="modal" data-target="#addaccount">Add Bank Account</a>
                              <br><br>
                              <table id="tblenrollments" class="DataTable table table-striped" style="width: 100% !important;">
                                 <thead>
                                    <tr>
                                       
                                       <th>Branch Name</th>
                                       <th>Bank Name</th>
                                       <th>Account Number</th>
                                       <th>Ifsc Code</th>
                                       <th>Status</th>
                                       <th>Actions</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                        <?php
                                        if(!empty($Accounts)){
                                            foreach($Accounts as $account){
                                        ?>
                                          <tr>
                                            
                                           <td> <?php echo $account->branch_name ?>
                                          </td>
                                           <td> <?php echo $account->bank_name ?>
                                          </td>
                                           <td> <?php echo $account->account_no ?>
                                          </td>
                                           <td> <?php echo $account->ifsc_code ?>
                                          </td>
                                           <td> <?php if($account->is_active ==1)
                                           {
                                               echo "Active";
                                           }else
                                           {
                                               echo "In-active";
                                           }?>
                                          </td>
                                             <td>
                                               <a class="btn btn-success" style="background-color: #00203d;" data-toggle="modal" data-target="#editaccount_<?php echo $account->id ?>"> <i class='fa fa-pencil'></i></
                                             </td>
                                          </tr>
                                          
                                           <div class="modal fade" id="editaccount_<?php echo $account->id ?>" tabindex="-1" role="dialog">
                              <div class="modal-dialog" role="document">
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <h2 class="modal-title">Edit Bank Account</h2>
                                       <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -45px;">
                                          <span>&times;</span>
                                       </button>
                                    </div>
                                    <div class="modal-body">
                                       <form method="post" action="<?php echo base_url('users/editaccount') ?>">
                                          <br>
                                          <div class="row">
                                              <div class="col-md-6">
                                                    <input type="hidden" name="userid" value="<?php echo $EmployeeDetails->userid; ?>" />
                                                    <input type="hidden" name="returnURL" value="users/employeedetails/<?php echo $EmployeeDetails->userid ?>" />
                                                    <input type="hidden" name="accountid" value="<?php echo $account->id;?>" />
                                                    <label class="text-uppercase text-sm">Bank Name</label>
                                                    <input type="text" placeholder="Bank Name" name="bank_name" class="form-control mb" value="<?php echo $account->bank_name;?>" required>
                                                 </div>
                                                  <div class="col-md-6">
                                                    <label class="text-uppercase text-sm">Branch Name</label>
                                                    <input type="text" placeholder="Branch Name" name="branch_name" class="form-control mb" value="<?php echo $account->branch_name;?>"  required>
                                                 </div>
                                                  <div class="col-md-6">
                                                    <label class="text-uppercase text-sm">Account Number</label>
                                                    <input type="text" placeholder="Account Number" name="account_no" class="form-control mb" value="<?php echo $account->account_no;?>"  required>
                                                 </div>
                                                  <div class="col-md-6">
                                                    <label class="text-uppercase text-sm">Ifsc Code</label>
                                                    <input type="text" placeholder="Ifsc Code" name="ifsc_code" class="form-control mb"  value="<?php echo $account->ifsc_code;?>"  required>
                                                 </div>
                                                 <div class="col-md-6">
                                                    <label class="text-uppercase text-sm">Is Active</label>
                                                     <input id="is_active" type="checkbox" placeholder="marketing" name="is_active" class="form-control mb" <?php if( $account->is_active==1){ echo "checked"; }else{ ""; } ?>>
                                                 </div>
                                             <br />
                                             <br />
                                             <br />
                                             <br />
                                            
                                          </div>
                                          <div>&nbsp;</div>
                                          <button type="submit" name="addInvoice" class="btn btn-primary" style="margin-left: 236px;">Submit</button>
                                       </form>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           
                                    <?php
                                            }
                                        }
                                        ?>
                                 </tbody>
                              </table>
                           </div>
                            <div class="modal fade" id="addaccount" tabindex="-1" role="dialog">
                              <div class="modal-dialog" role="document">
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <h2 class="modal-title">Add Bank Account</h2>
                                       <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -45px;">
                                          <span>&times;</span>
                                       </button>
                                    </div>
                                    <div class="modal-body">
                                       <form method="post" action="<?php echo base_url('users/addaccount') ?>">
                                          <br>
                                          <div class="row">
                                                 <div class="col-md-6">
                                                    <input type="hidden" name="userid" value="<?php echo $EmployeeDetails->userid; ?>" />
                                                    <input type="hidden" name="returnURL" value="users/employeedetails/<?php echo $EmployeeDetails->userid ?>" />
                                                    <label class="text-uppercase text-sm">Bank Name</label>
                                                    <input type="text" placeholder="Bank Name" name="bank_name" class="form-control mb" required>
                                                 </div>
                                                  <div class="col-md-6">
                                                    <label class="text-uppercase text-sm">Branch Name</label>
                                                    <input type="text" placeholder="Branch Name" name="branch_name" class="form-control mb" required>
                                                 </div>
                                                  <div class="col-md-6">
                                                    <label class="text-uppercase text-sm">Account Number</label>
                                                    <input type="text" placeholder="Account Number" name="account_no" class="form-control mb" required>
                                                 </div>
                                                  <div class="col-md-6">
                                                    <label class="text-uppercase text-sm">Ifsc Code</label>
                                                    <input type="text" placeholder="Ifsc Code" name="ifsc_code" class="form-control mb" required>
                                                 </div>
                                                 <div class="col-md-6">
                                                    <label class="text-uppercase text-sm">Is Active</label>
                                                     <input id="is_active" type="checkbox" placeholder="marketing" name="is_active" class="form-control mb">
                                                 </div>
                                             <div class="col-md-3">
                                                 </div>
                                             <br />
                                             <br />
                                             <br />
                                             <br />
                                            
                                          </div>
                                          <div>&nbsp;</div>
                                          <button type="submit" name="addInvoice" class="btn btn-primary" style="margin-left: 236px;">Submit</button>
                                       </form>
                                    </div>
                                 </div>
                              </div>
                           </div>
                             <div class="modal fade" id="addsalarystructure" tabindex="-1" role="dialog">
                              <div class="modal-dialog" role="document">
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <h2 class="modal-title">Add Salary Structure</h2>
                                       <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -45px;">
                                          <span>&times;</span>
                                       </button>
                                    </div>
                                    <div class="modal-body">
                                       <form method="post" action="<?php echo base_url('users/addsalarystructure') ?>">
                                          <br>
                                          <div class="row">
                                                 <div class="col-md-6">
                                                    <input type="hidden" name="userid" value="<?php echo $EmployeeDetails->userid; ?>" />
                                                    <input type="hidden" name="returnURL" value="users/employeedetails/<?php echo $EmployeeDetails->userid ?>" />
                                                    <label class="text-uppercase text-sm">Basic</label>
                                                    <input type="text" placeholder="Basic Salary" name="basic" class="form-control mb" required>
                                                 </div>
                                                  <div class="col-md-6">
                                                    <label class="text-uppercase text-sm">HRA</label>
                                                    <input type="text" placeholder="HRA" name="hra" class="form-control mb" required>
                                                 </div>
                                                  <div class="col-md-6">
                                                    <label class="text-uppercase text-sm">Special Allowance</label>
                                                    <input type="text" placeholder="Special allowance" name="specialallowance" class="form-control mb" required>
                                                 </div>
                                                  <div class="col-md-6">
                                                    <label class="text-uppercase text-sm">Travel Allowance</label>
                                                    <input type="text" placeholder="Ifsc Code" name="travelallowance" class="form-control mb">
                                                 </div>
                                                 <div class="col-md-6">
                                                    <label class="text-uppercase text-sm">PT</label>
                                                    <input type="text" placeholder="PT" name="pt" class="form-control mb">
                                                 </div>
                                                  <div class="col-md-6">
                                                    <label class="text-uppercase text-sm">TDS</label>
                                                    <input type="text" placeholder="TDS" name="tds" class="form-control mb">
                                                 </div>
                                             <div class="col-md-3">
                                                 </div>
                                             <br />
                                             <br />
                                             <br />
                                             <br />
                                            
                                          </div>
                                          <div>&nbsp;</div>
                                          <button type="submit" name="addInvoice" class="btn btn-primary" style="margin-left: 236px;">Submit</button>
                                       </form>
                                    </div>
                                 </div>
                              </div>
                           </div>
                              <div id="salarystructure" class="tab-pane fade">
                                <br>
                               <a class="btn btn-success" style="background-color: #00203d;" data-toggle="modal" data-target="#addsalarystructure">Add Salary Structure</a>
                              <br><br>
                              <table id="tblenrollments" class="DataTable table table-striped" style="width: 100% !important;">
                                 <thead>
                                    <tr>
                                       
                                       <th>Basic</th>
                                       <th>HRA</th>
                                       <th>Special Allownace</th>
                                       <th>Travel Allowance</th>
                                       <th>Tds</th>
                                       <th>Pt</th>
                                       <th>Status</th>
                                       <th>Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                        <?php
                                        if(!empty($SalaryStructure)){
                                            foreach($SalaryStructure as $account){
                                        ?>
                                          <tr>
                                            
                                           <td> <?php echo $account->basic ?>
                                          </td>
                                           <td> <?php echo $account->houserentalallowance ?>
                                          </td>
                                           <td> <?php echo $account->specialallowance ?>
                                          </td>
                                           <td> <?php echo $account->transportallowance ?>
                                          </td>
                                          <td> <?php echo $account->tds ?>
                                          </td>
                                          <td> <?php echo $account->pt ?>
                                          </td>
                                           <td> <?php if($account->is_active ==1)
                                           {
                                               echo "Active";
                                           }else
                                           {
                                               echo "In-active";
                                           }?>
                                          </td>
                                             <td>
                                               <a class="btn btn-success" style="background-color: #00203d;" data-toggle="modal" data-target="#editsalarystructure_<?php echo $account->salarygradeid ?>"> <i class='fa fa-pencil'></i></
                                             </td>
                                          </tr>
                                          
                                           <div class="modal fade" id="editsalarystructure_<?php echo $account->salarygradeid ?>" tabindex="-1" role="dialog">
                              <div class="modal-dialog" role="document">
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <h2 class="modal-title">Edit Salary Structure</h2>
                                       <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -45px;">
                                          <span>&times;</span>
                                       </button>
                                    </div>
                                    <div class="modal-body">
                                       <form method="post" action="<?php echo base_url('users/editsalarystructure') ?>">
                                          <br>
                                          <div class="row">
                                              <div class="col-md-6">
                                                    <input type="hidden" name="userid" value="<?php echo $EmployeeDetails->userid; ?>" />
                                                    <input type="hidden" name="returnURL" value="users/employeedetails/<?php echo $EmployeeDetails->userid ?>" />
                                                    <input type="hidden" name="accountid" value="<?php echo $account->salarygradeid;?>" />
                                                    <label class="text-uppercase text-sm">Basic</label>
                                                    <input type="text" placeholder="Basic" name="basic" class="form-control mb" value="<?php echo $account->basic;?>" required>
                                                 </div>
                                                  <div class="col-md-6">
                                                    <label class="text-uppercase text-sm">HRA</label>
                                                    <input type="text" placeholder="HRA" name="hra" class="form-control mb" value="<?php echo $account->houserentalallowance;?>"  required>
                                                 </div>
                                                  <div class="col-md-6">
                                                    <label class="text-uppercase text-sm">Special Allowance</label>
                                                    <input type="text" placeholder="Special Allowance" name="specialallowance" class="form-control mb" value="<?php echo $account->specialallowance;?>"  required>
                                                 </div>
                                                  <div class="col-md-6">
                                                    <label class="text-uppercase text-sm">Transport Allowance</label>
                                                    <input type="text" placeholder="Transport Allowance" name="transportallowance" class="form-control mb"  value="<?php echo $account->transportallowance;?>"  required>
                                                 </div>
                                                 <div class="col-md-6">
                                                    <label class="text-uppercase text-sm">PT</label>
                                                    <input type="text" placeholder="PT" name="pt" class="form-control mb"  value="<?php echo $account->pt;?>"  required>
                                                 </div>
                                                 <div class="col-md-6">
                                                    <label class="text-uppercase text-sm">TDS</label>
                                                    <input type="text" placeholder="TDS" name="tds" class="form-control mb"  value="<?php echo $account->tds;?>"  required>
                                                 </div>
                                                 <div class="col-md-6">
                                                    <label class="text-uppercase text-sm">Is Active</label>
                                                     <input id="is_active" type="checkbox" placeholder="" name="is_active" class="form-control mb" <?php if( $account->is_active==1){ echo "checked"; }else{ ""; } ?>>
                                                 </div>
                                             <br />
                                             <br />
                                             <br />
                                             <br />
                                            
                                          </div>
                                          <div>&nbsp;</div>
                                          <button type="submit" name="addInvoice" class="btn btn-primary" style="margin-left: 236px;">Submit</button>
                                       </form>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           
                                    <?php
                                            }
                                        }
                                        ?>
                                 </tbody>
                              </table>
                           </div>
                            <div class="modal fade" id="addidcard" tabindex="-1" role="dialog">
                              <div class="modal-dialog" role="document">
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <h2 class="modal-title">Add RF Id</h2>
                                       <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -45px;">
                                          <span>&times;</span>
                                       </button>
                                    </div>
                                    <div class="modal-body">
                                       <form method="post" action="<?php echo base_url('users/addrfidcard') ?>">
                                          <br>
                                          <div class="row">
                                                <div class="col-md-3">
                                                </div>
                                                 <div class="col-md-6">
                                                    <input type="hidden" name="userid" value="<?php echo $EmployeeDetails->userid; ?>" />
                                                    <input type="hidden" name="returnURL" value="users/employeedetails/<?php echo $EmployeeDetails->userid ?>" />
                                                    <label class="text-uppercase text-sm">RF Id</label>
                                                    <input type="text" placeholder="RF Id" name="rfid" class="form-control mb" required>
                                                 </div>
                                             <div class="col-md-3">
                                                 </div>
                                             <br />
                                             <br />
                                             <br />
                                             <br />
                                            
                                          </div>
                                          <div>&nbsp;</div>
                                          <button type="submit" name="addInvoice" class="btn btn-primary" style="margin-left: 236px;">Submit</button>
                                       </form>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="modal fade" id="addpackage" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                           <div class="modal-content">
                              <div class="modal-header">
                                 <h2 class="modal-title">Add Package</h2>
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -45px;">
                                    <span>&times;</span>
                                 </button>
                              </div>
                              <div class="modal-body">
                                 <form method="post" action="<?php echo base_url('users/addpackage') ?>">
                                    <br>
                                    <div class="row">
                                       <div class="col-md-6">
                                          <input type="hidden" name="userid" value="<?php echo $EmployeeDetails->userid; ?>" />
                                          <input type="hidden" name="returnURL" value="users/employeedetails/<?php echo $EmployeeDetails->userid ?>" />
                                          <label class="text-uppercase text-sm">Package</label>
                                          <input type="text" placeholder="Package" name="package" class="form-control mb" required>
                                       </div>

                                       <div class="col-md-6">
                                          <label class="text-uppercase text-sm">TDS (Check if TDS is Applicable)</label>
                                          <input id="is_active" type="checkbox" placeholder="tds" name="is_tds" class="form-control mb">
                                       </div>
                                       <div class="col-md-3">
                                       </div>
                                       <br />
                                       <br />
                                       <br />
                                       <br />

                                    </div>
                                    <div>&nbsp;</div>
                                    <button type="submit" name="addInvoice" class="btn btn-primary" style="margin-left: 236px;">Submit</button>
                                 </form>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="modal fade" id="addaccount" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                           <div class="modal-content">
                              <div class="modal-header">
                                 <h2 class="modal-title">Add Bank Account</h2>
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -45px;">
                                    <span>&times;</span>
                                 </button>
                              </div>
                              <div class="modal-body">
                                 <form method="post" action="<?php echo base_url('users/addaccount') ?>">
                                    <br>
                                    <div class="row">
                                       <div class="col-md-6">
                                          <input type="hidden" name="userid" value="<?php echo $EmployeeDetails->userid; ?>" />
                                          <input type="hidden" name="returnURL" value="users/employeedetails/<?php echo $EmployeeDetails->userid ?>" />
                                          <label class="text-uppercase text-sm">Bank Name</label>
                                          <input type="text" placeholder="Bank Name" name="bank_name" class="form-control mb" required>
                                       </div>
                                       <div class="col-md-6">
                                          <label class="text-uppercase text-sm">Branch Name</label>
                                          <input type="text" placeholder="Branch Name" name="branch_name" class="form-control mb" required>
                                       </div>
                                       <div class="col-md-6">
                                          <label class="text-uppercase text-sm">Account Number</label>
                                          <input type="text" placeholder="Account Number" name="account_no" class="form-control mb" required>
                                       </div>
                                       <div class="col-md-6">
                                          <label class="text-uppercase text-sm">IFSC Code</label>
                                          <input type="text" placeholder="IFSC Code" name="ifsc_code" class="form-control mb" required>
                                       </div>
                                       <div class="col-md-6">
                                          <label class="text-uppercase text-sm">Is Active</label>
                                          <input id="is_active" type="checkbox" placeholder="marketing" name="is_active" class="form-control mb">
                                       </div>
                                       <div class="col-md-3">
                                       </div>
                                       <br />
                                       <br />
                                       <br />
                                       <br />

                                    </div>
                                    <div>&nbsp;</div>
                                    <button type="submit" name="addInvoice" class="btn btn-primary" style="margin-left: 236px;">Submit</button>
                                 </form>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="modal fade" id="addsalarystructure" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                           <div class="modal-content">
                              <div class="modal-header">
                                 <h2 class="modal-title">Add Salary Structure</h2>
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -45px;">
                                    <span>&times;</span>
                                 </button>
                              </div>
                              <div class="modal-body">
                                 <form method="post" action="<?php echo base_url('users/addsalarystructure') ?>">
                                    <br>
                                    <div class="row">
                                       <div class="col-md-6">
                                          <input type="hidden" name="userid" value="<?php echo $EmployeeDetails->userid; ?>" />
                                          <input type="hidden" name="returnURL" value="users/employeedetails/<?php echo $EmployeeDetails->userid ?>" />
                                          <label class="text-uppercase text-sm">Basic</label>
                                          <input type="text" placeholder="Basic Salary" name="basic" class="form-control mb" required>
                                       </div>
                                       <div class="col-md-6">
                                          <label class="text-uppercase text-sm">HRA(Percentage on Basic)</label>
                                          <input type="text" placeholder="HRA" name="hra" class="form-control mb" required>
                                       </div>
                                       <div class="col-md-6">
                                          <label class="text-uppercase text-sm">PT</label>
                                          <input type="text" placeholder="PT" name="pt" class="form-control mb">
                                       </div>
                                       <div class="col-md-6">
                                          <label class="text-uppercase text-sm">TDS</label>
                                          <input type="text" placeholder="TDS" name="tds" class="form-control mb">
                                       </div>
                                       <div class="col-md-3">
                                       </div>
                                       <br />
                                       <br />
                                       <br />
                                       <br />

                                    </div>
                                    <div>&nbsp;</div>
                                    <button type="submit" name="addInvoice" class="btn btn-primary" style="margin-left: 236px;">Submit</button>
                                 </form>
                              </div>
                           </div>
                        </div>
                     </div>
                        <div class="modal fade" id="addinsurance" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                           <div class="modal-content">
                              <div class="modal-header">
                                 <h2 class="modal-title">Add Insurance</h2>
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -45px;">
                                    <span>&times;</span>
                                 </button>
                              </div>
                              <div class="modal-body">
                                 <form method="post" action="<?php echo base_url('users/addinsurance') ?>">
                                    <br>
                                    <div class="row">
                                       <div class="col-md-6">
                                                <input type="hidden" name="userid" value="<?php echo $EmployeeDetails->userid; ?>" />
                                                <input type="hidden" name="returnURL" value="users/employeedetails/<?php echo $EmployeeDetails->userid ?>" />
                                                <label class="text-uppercase text-sm">Policy Number</label>
                                                <input type="number" placeholder="Policy Number" name="policy_no" class="form-control mb" required>
                                       </div>
                                       <div class="col-md-6">
                                          <label class="text-uppercase text-sm">Provider</label>
                                          <input type="text" placeholder="Provider"  name="provider" class="form-control mb" required>
                                       </div>

                                       <div class="col-md-6">
                                          <label class="text-uppercase text-sm">URL</label>
                                          <input type="text" placeholder="URL" name="url" class="form-control mb" required>
                                       </div>
                                       <div class="col-md-3">
                                       </div>
                                       <br />
                                       <br />
                                       <br />
                                       <br />

                                    </div>
                                    <div>&nbsp;</div>
                                    <button type="submit" name="addInvoice" class="btn btn-primary" style="margin-left: 236px;">Submit</button>
                              
                                 </form>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="modal fade" id="addloans" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                           <div class="modal-content">
                              <div class="modal-header">
                                 <h2 class="modal-title">Add Advance Payment</h2>
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -45px;">
                                    <span>&times;</span>
                                 </button>
                              </div>
                              <div class="modal-body">
                                 <form method="post" action="<?php echo base_url('users/addloan') ?>">
                                    <br>
                                    <div class="row">
                                       <div class="col-md-6">
                                          <?php
                                          if (!empty($salary_package)) {
                                             $package = $data['ctc'] = $salary_package[0]->package;
                                             if ($package != 0) {
                                                $monthly = $data['monthly'] = round($package / 12);
                                                $monthly =  $monthly * 2;
                                          ?>
                                                <input type="hidden" name="userid" value="<?php echo $EmployeeDetails->userid; ?>" />
                                                <input type="hidden" name="returnURL" value="users/employeedetails/<?php echo $EmployeeDetails->userid ?>" />
                                                <label class="text-uppercase text-sm">Amount</label>
                                                <input type="number" placeholder="Amount" name="amount" max="<?php echo $monthly; ?>" class="form-control mb" required>
                                       </div>
                                       <div class="col-md-6">
                                          <label class="text-uppercase text-sm">Number of Months</label>
                                          <input type="number" placeholder="Months" max=6 min=1 name="months" class="form-control mb" required>
                                       </div>

                                       <div class="col-md-6">
                                          <label class="text-uppercase text-sm">Loan Effective date(Month)</label>
                                          <input type="month" placeholder="Date" name="effective_date" class="form-control mb" required>
                                       </div>
                                       <div class="col-md-3">
                                       </div>
                                       <br />
                                       <br />
                                       <br />
                                       <br />

                                    </div>
                                    <div>&nbsp;</div>
                                    <button type="submit" name="addInvoice" class="btn btn-primary" style="margin-left: 236px;">Submit</button>
                              <?php
                                             }
                                          }
                              ?>
                                 </form>
                              </div>
                           </div>
                        </div>
                     </div>
                           <div class="modal fade" id="editidcard" tabindex="-1" role="dialog">
                              <div class="modal-dialog" role="document">
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <h2 class="modal-title">Edit RF Id</h2>
                                       <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -45px;">
                                          <span>&times;</span>
                                       </button>
                                    </div>
                                    <div class="modal-body">
                                       <form method="post" action="<?php echo base_url('users/addrfidcard') ?>">
                                          <br>
                                          <div class="row">
                                              <div class="col-md-3">
                                                 </div>
                                             <div class="col-md-6">
                                                <input type="hidden" name="userid" value="<?php echo $EmployeeDetails->userid;; ?>" />
                                                <input type="hidden" name="returnURL" value="users/employeedetails/<?php echo $EmployeeDetails->userid; ?>" />

                                                <label class="text-uppercase text-sm">RF Id</label>
                                            
                                            
                                                 <input type="text" placeholder="RF Id" name="rfid" class="form-control mb" value="<?php echo $EmployeeDetails->rfid; ?>" required>
                                             </div>
                                             <div class="col-md-3">
                                                 </div>
                                             <br />
                                             <br />
                                             <br />
                                             <br />
                                            
                                          </div>
                                          <div>&nbsp;</div>
                                          <button type="submit" name="addInvoice" class="btn btn-primary" style="margin-left: 236px;">Submit</button>
                                       </form>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           
                           
                           
                     <div id="finance" class="tab-pane fade">
                        <br>
                        <div class="col-md-12">
                           <ul class="nav nav-pills red">
                              <li class="nav-item active"><a class="nav-link active" data-toggle="tab" href="#package">Package</a></li>
                              <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#salary">Payslips</a></li>
                           </ul>
                           <div class="tab-content">
                              <div id="package" class="tab-pane fade in active">
                                 <form method="post" action="<?php echo base_url('payroll/update_employee_package') ?>">
                                    <br>
                                    <div class="row">
                                       <div class="col-md-6">
                                          <label class="text-uppercase text-sm">Total Package</label>
                                          <input id="newpackage" type="number" placeholder="Package" name="newpackage" class="form-control mb" value="<?php echo $EmployeeDetails->package; ?>" required>
                                          <input type="text" name="userid" id="userid" value="<?php echo $EmployeeDetails->userid; ?>" hidden>
                                       </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update Package</button>
                                 </form>
                              </div>

                              <div id="salary" class="tab-pane fade">
                                 <br />
                                 <div class="row">
                                    <div class="col-md-12">
                                       <table id="tblotherusers" class="DataTable table table-striped" style="width: 100%;">
                                          <thead>
                                             <tr>
                                                <th>Date</th>
                                                <th>Breakdown</th>
                                                <th>Edit</th>
                                                <th>Regenerate</th>
                                                <th>Download Payslip</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                             <?php
                                             if ($EmployeeSalaries != null) :
                                                foreach ($EmployeeSalaries as $result) :

                                             ?>
                                                   <tr>
                                                      <td><?php echo date_format(date_create($result->salarydate), "M-Y") ?></td>
                                                      <td>
                                                         <a data-toggle="modal" data-target="#addsalarygrade_<?php echo $result->userid ?>"><i class="fa fa-sticky-note-o"></i></a>
                                                         <div class="modal fade" id="addsalarygrade_<?php echo $result->userid ?>" tabindex="-1" role="dialog">
                                                            <div class="modal-dialog" role="document" style="width: 90vw">
                                                               <div class="modal-content">
                                                                  <div class="modal-header">
                                                                     <h2 class="modal-title">Salary Breakdown</h2>
                                                                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span>&times;</span>
                                                                     </button>
                                                                  </div>
                                                                  <div class="modal-body">
                                                                     <div class="row">
                                                                        <div class="col-md-3">
                                                                           <b>Name:</b> <?php echo $result->name . " ({$result->employeeid})"; ?><br />
                                                                           <b>Package:</b> <?php echo $result->ctc; ?><br />
                                                                           <b>Monthly:</b> <?php echo $result->monthly; ?><br />
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                           <b>Basic:</b> <?php echo $result->basic; ?><br />
                                                                           <b>House Rental Allowance:</b> <?php echo $result->houserentalallowance; ?><br />
                                                                           <b>Transport Allowance:</b> <?php echo $result->transportallowance; ?><br />
                                                                           <b>Children Education Allowance:</b> <?php echo $result->childreneducationallowance; ?><br />
                                                                           <b>Medical Allowance:</b> <?php echo $result->medicalallowance; ?><br />
                                                                           <b>Special Allowance:</b> <?php echo $result->specialallowance; ?><br />
                                                                           <b>Gross:</b> <?php echo $result->gross; ?><br />
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                           <b>Provident Fund (Employer):</b> <?php echo $result->providentfund_employer; ?><br />
                                                                           <b>ESIC (Employer):</b> <?php echo $result->employeesstateinsurance_employer; ?><br />
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                           <b>Provident Fund (Employee):</b> <?php echo $result->providentfund_employee; ?><br />
                                                                           <b>ESIC (Employee):</b> <?php echo $result->employeesstateinsurance_employee; ?><br />
                                                                           <b>PT:</b> <?php echo $result->pt; ?><br />
                                                                           <b>TDS:</b> <?php echo $result->tds; ?><br />
                                                                           <b>Net:</b> <?php echo $result->net; ?><br />
                                                                        </div>
                                                                     </div>
                                                                  </div>
                                                               </div>
                                                            </div>
                                                         </div>
                                                      </td>
                                                      <td>
                                                         <?php
                                                         $todaysDate = date_create(date("Y-m-d"));
                                                         $salaryDate = date_create($result->salarydate);
                                                         if (
                                                            date_format($todaysDate, "m") == date_format($salaryDate, "m") &&
                                                            date_format($todaysDate, "Y") == date_format($salaryDate, "Y")
                                                         ) : ?>
                                                            <a href="<?php echo base_url('payroll/edit_payslip') . '/' . $result->salarypaymentid ?>"><i class="fa fa-pencil-square-o editbtn"></i></a>
                                                         <?php
                                                         endif; ?>
                                                      </td>
                                                      <td>
                                                         <?php
                                                         $todaysDate = date_create(date("Y-m-d"));
                                                         $salaryDate = date_create($result->salarydate);
                                                         if (
                                                            date_format($todaysDate, "m") == date_format($salaryDate, "m") &&
                                                            date_format($todaysDate, "Y") == date_format($salaryDate, "Y")
                                                         ) : ?>
                                                            <a href="<?php echo base_url("payroll/regenerate_salary/{$result->userid}/{$result->salarydate}") ?>" onclick="return confirm('Are you sure to regenerate salary?')"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                                                         <?php
                                                         endif; ?>
                                                      </td>
                                                      <td><a target="_blank" href="<?php echo base_url("payroll/print_payslip/{$result->salarypaymentid}") ?>"><i class="fa fa-download" aria-hidden="true"></i></a></td>
                                                   </tr>
                                             <?php
                                                endforeach;
                                             endif;
                                             ?>
                                          </tbody>
                                       </table>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<style>
   input.error {
      border-color: #f00 !important;
   }

   select.error+span>span>span {
      border-color: #f00 !important;
   }

   small.required {
      color: #f00;
   }

   .error {
      color: red;
   }
</style>

<script>
   function recordAttendance(url) {
      var xmlHttp = new XMLHttpRequest();
      xmlHttp.open("GET", url);
      xmlHttp.send(null);
   }
</script>