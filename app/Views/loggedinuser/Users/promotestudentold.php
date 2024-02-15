<?php use App\Models\PaymentsModel;?>
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Promote Student</h2>
                
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="background-color: #00203d; color: white;" colspan="3">Personal Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><b>Name</td>
                                <td colspan="2"><?php echo $StudentDetail->name ?></td>
                            </tr>
                            <tr>
                                <td><b>Date of Birth</td>
                                <td colspan="2"><?php echo date_format(date_create($StudentDetail->dateofbirth), 'd/m/Y') ?></td>
                            </tr>
                            <tr>
                                <td><b>Mobile</td>
                                <td colspan="2"><?php echo $StudentDetail->mobile1 ?></td>
                            </tr>
                            <tr>
                                <td><b>E-Mail</td>
                                <td colspan="2"><?php echo $StudentDetail->email ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="background-color: #00203d; color: white;" colspan="3">Course Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><b>Course</td>
                                <td colspan="2"><?php echo $StudentDetail->coursename ?></td>
                            </tr>
                            <tr>
                                <td><b>Admission Type</td>
                                <td colspan="2"><?php echo $StudentDetail->admissiontypename ?></td>
                            </tr>
                            <tr>
                                <td><b>Admission Date</td>
                                <td colspan="2"><?php echo date_format(date_create($StudentDetail->admissiondate), 'd/m/Y') ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12">
                <form method="post" id="studentform" action="<?php

                                                                use App\Models\HelperModel;

                                                                echo base_url('users/userpromoteflow') ?>">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a id="ApplicationTab" data-toggle="tab" href="#application">Application Details</a>
                        </li>
                        <li><a id="FeesTab" data-toggle="tab" href="#fees">Fee Details</a></li>
                        <li><a id="PreviewTab" data-toggle="tab" href="#preview" onclick="generatePreview()">Preview and Create</a></li>
                        </ul>

                    <div class="tab-content tab-validate">
                        <?php
                        $rezofastdetails = json_decode($StudentDetail->rezofastdetails);
                        ?>
                        <div id="application" class="tab-pane fade in active">
                            <br />
                            <div class="row">
                                          <div class="col-md-12">
                                             <input type="hidden" placeholder="Application Number" id="applicationnumber" name="applicationnumber" class="form-control" value="<?php echo $StudentDetail->applicationnumber ?>">
                                          </div>
                                       </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <select onchange="this.classList.remove('error');changeFeesBasedOnCourse();" id="admissiontypeid" name="admissiontypeid" style="width: 100%;" class="select2 form-control mb" required>
                                        <option value="">Select Admission Type<i style="color: red;">*</i></option>
                                        <?php
                                        foreach ($lookups['admissiontypelookup'] as $admissiontype) :
                                        ?>
                                            <option value="<?php echo $admissiontype->admissiontypeid; ?>"><?php echo $admissiontype->admissiontypename; ?></option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                    <br><br>
                                </div>
                                <div class="col-md-6">
                                    <select onchange="this.classList.remove('error')" id="branchid" name="branchid" style="width: 100%;" class="select2 form-control mb" required>
                                        <option value="">Select Branch<i style="color: red;">*</i></option>
                                        <?php
                                        foreach ($lookups['branchlookup'] as $branch) :
                                        ?>
                                            <option value="<?php echo $branch->branchid; ?>"><?php echo $branch->branchname; ?></option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                    <br><br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <select onchange="this.classList.remove('error');changeFeesBasedOnCourse();" id="batchid" name="batchid" style="width: 100%;" class="select2 form-control mb" required>
                                        <option value="">Select Academic Year<i style="color: red;">*</i></option>
                                        <?php
                                        foreach ($lookups['batchlookup'] as $batch) :
                                            if ($batch->batchid != "1") :
                                        ?>
                                                <option value="<?php echo $batch->batchid; ?>"><?php echo $batch->batchname; ?></option>
                                        <?php
                                            endif;
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select onchange="this.classList.remove('error');changeFeesBasedOnCourse();" id="courseid" name="courseid" style="width: 100%;" class="select2 form-control mb" required>
                                        <option value="">Select Course<i style="color: red;">*</i></option>
                                        <?php
                                        foreach ($lookups['courselookup'] as $course) :
                                        ?>
                                            <option value="<?php echo $course->courseid; ?>"><?php echo $course->coursename; ?></option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                    <br><br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                   
                                    <select onchange="this.classList.remove('error')" id="sectionid" name="sectionid" style="width: 100%;" class="select2 form-control mb" required>
                                        <option value="">Select Section<i style="color: red;">*</i></option>
                                        <?php
                                        foreach ($lookups['sectionlookup'] as $section) :
                                        ?>
                                            <option value="<?php echo $section->sectionid; ?>"><?php echo $section->sectionname; ?></option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                                
                            </div>
                            
                            <br />
                            <div class="row">
                                <div class="col-md-10">
                                </div>
                                <div class="col-md-2">
                                    <a class="btn btn-primary" onclick="$('#FeesTab').click()">Next</a>
                                </div>
                            </div>
                        </div>
                        
                       
                        
                        <div id="basic" class="tab-pane fade">
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Student Name<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="Name" id="name" name="name" class="form-control mb" value="<?php echo $StudentDetail->name ?>" required>

                                </div>
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Date Of Birth<i style="color: red;">*</i></label>
                                    <input onchange="this.classList.remove('error')" type="text" placeholder="dd/mm/yy" id="dateofbirth" name="dateofbirth" class="form-control mb datepicker" value="<?php echo date_format(date_create($StudentDetail->dateofbirth), 'd/m/Y') ?>" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <select onchange="this.classList.remove('error')" id="genderid" name="genderid" style="width: 100%;" class="select2 form-control mb select" required>
                                        <option value="">Select Gender<i style="color: red;">*</i></option>
                                        <?php
                                                foreach ($lookups['genderlookup'] as $gender) :
                                                ?>
                                                   <option <?php echo $StudentDetail->genderid == $gender->genderid ? "selected" : ""; ?> value="<?php echo $gender->genderid; ?>"><?php echo $gender->gendername; ?></option>
                                                <?php
                                                endforeach;
                                                ?>
                                    </select>
                                    <br><br>
                                </div>
                                <div class="col-md-6">
                                    <select onchange="this.classList.remove('error')" id="categoryid" name="categoryid" style="width: 100%;" class="select2 form-control mb" required>
                                        <option value="">Select Category<i style="color: red;">*</i></option>
                                        <?php
                                                foreach ($lookups['categorylookup'] as $category) :
                                                ?>
                                                   <option <?php echo $StudentDetail->categoryid == $category->categoryid ? "selected" : "" ?> value="<?php echo $category->categoryid; ?>"><?php echo $category->categoryname; ?></option>
                                                <?php
                                                endforeach;
                                                ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <select onchange="this.classList.remove('error')" id="nationalityid" name="nationalityid" style="width: 100%;" class="select2 form-control mb" required>
                                        <option value="">Select Nationality<i style="color: red;">*</i></option>
                                        <?php
                                                foreach ($lookups['nationalitylookup'] as $nationality) :
                                                ?>
                                                   <option <?php echo $StudentDetail->nationalityid == $nationality->nationalityid ? "selected" : "" ?> value="<?php echo $nationality->nationalityid; ?>"><?php echo $nationality->nationalityname; ?></option>
                                                <?php
                                                endforeach;
                                                ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select onchange="this.classList.remove('error')" id="religionid" name="religionid" style="width: 100%;" class="select2 form-control mb" required>
                                        <option value="">Select Religion<i style="color: red;">*</i></option>
                                        <?php
                                                foreach ($lookups['religionlookup'] as $religion) :
                                                ?>
                                                   <option <?php echo $StudentDetail->religionid == $religion->religionid ? "selected" : "" ?> value="<?php echo $religion->religionid; ?>"><?php echo $religion->religionname; ?></option>
                                                <?php
                                                endforeach;
                                                ?>
                                    </select>
                                    <br><br>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Aadhaar Number<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="Aadhaar Number" id="studentaadhaar" name="studentaadhaar" class="form-control mb" value="<?php echo $StudentDetail->studentaadhaar ?>">
                                </div>
                            </div>
                            <br />
                            <div class="row">
                                <div class="col-md-10">
                                </div>
                                <div class="col-md-2">
                                    <a class="btn btn-primary" onclick="$('#ApplicationTab').click()">Previous</a>&nbsp;&nbsp;&nbsp;
                                    <a class="btn btn-primary" onclick="$('#FamilyTab').click()">Next</a>
                                </div>
                            </div>
                        </div>
                        <div id="family" class="tab-pane fade">
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Father Name/ Guardian Name<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="Father Name" id="fathername" name="fathername" class="form-control mb" value="<?php echo $StudentDetail->fathername ?>">>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Mother Name<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="Mother Name" id="mothername" name="mothername" class="form-control mb" value="<?php echo $StudentDetail->mothername ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Parent Occupation<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="Parent Occupation" id="parentoccupation" name="parentoccupation" class="form-control mb" value="<?php echo $StudentDetail->parentoccupation ?>" >
                                </div>
                            </div>
                            <br />
                            <div class="row">
                                <div class="col-md-10">
                                </div>
                                <div class="col-md-2">

                                    <a class="btn btn-primary" onclick="$('#BasicTab').click()">Previous</a>&nbsp;&nbsp;&nbsp;
                                    <a class="btn btn-primary" onclick="$('#EducationTab').click()">Next</a>
                                </div>
                            </div>
                        </div>
                        <div id="education" class="tab-pane fade">
                            <br>
                            <?php
                                       $PreviousClassesInfo = json_decode($StudentDetail->previous_class_information);
                                       if ($PreviousClassesInfo != "") {
                                          foreach ($PreviousClassesInfo as $classInfo) {
                                             $classInfo = $classInfo;
                                          }
                                       }
                                       ?>
                            <h3><label>Last Studied Information</label></h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Board<i style="color: red;">*</i></label>
                                    <select onchange="this.classList.remove('error')" id="board" name="board" style="width: 100%;" class="select2 form-control mb" required>
                                    <?php
                                                foreach ($lookups['boardlookup'] as $board) :
                                                ?>
                                                   <option <?php echo $classInfo->board == $board->boardid ? "selected" : "" ?> value="<?php echo $board->boardid; ?>"><?php echo $board->boardname; ?></option>
                                                <?php
                                                endforeach;
                                                ?>
                                    </select>
                                    <br /><br />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">School/ College<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="School Name" id="school" name="school" class="form-control mb" value="<?php echo $classInfo->school ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Place<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="Place" id="place" name="place" class="form-control mb" value="<?php echo $classInfo->place ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Grade/ Marks</label>
                                    <input type="text" placeholder="Grade/ Marks" id="grade" name="grade" class="form-control mb" value="<?php echo $classInfo->grade ?>" >
                                </div>
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">HallTicket No.</label>
                                    <input type="text" placeholder="HallTicket No." id="hallticketNo" name="hallticketNo" class="form-control mb" value="<?php echo $classInfo->hallticketNo ?>">
                                </div>
                            </div>
                            <br /><br />
                            <div class="row">
                                <div class="col-md-10">
                                </div>
                                <div class="col-md-2">
                                    <a class="btn btn-primary" onclick="$('#FamilyTab').click()">Previous</a>&nbsp;&nbsp;&nbsp;
                                    <a class="btn btn-primary" onclick="$('#ContactTab').click()">Next</a>
                                </div>
                            </div>
                        </div>
                        <div id="contact" class="tab-pane fade">
                            <br>
                            <?php
                            $Address = json_decode($StudentDetail->address);
                            $permanentAddress = $Address->permanent;
                            ?>
                            <h3><label>Address</label>
                            </h3>
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="text-uppercase text-sm">Door No./ Street Name<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="Door No./ Street Name" id="door_street" name="door_street" class="form-control mb" value="<?php echo $permanentAddress->door_street ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="text-uppercase text-sm">State<i style="color: red;">*</i></label>
                                    <select onchange="this.classList.remove('error');getdistricts_perm(this.value);" id="state" name="state" style="width: 100%;" class="select2 form-control mb" required>
                                        <option value="">Select State</option>
                                        <?php
                                        foreach ($lookups['stateslookup'] as $state) :
                                        ?>
                                            <option <?php echo $permanentAddress->state == $state->state_id ? "selected" : "" ?> value="<?php echo $state->state_id; ?>"><?php echo $state->state_name; ?></option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="text-uppercase text-sm">District<i style="color: red;">*</i></label>
                                    <select onchange="this.classList.remove('error')" id="district" name="district" style="width: 100%;" class="select2 form-control mb" required>
                                        <option value="">Select District</option>
                                        <?php
                                        foreach ($lookups['districtslookup'] as $district) :
                                            if ($district->state_id == $permanentAddress->state) :
                                        ?>
                                                <option <?php echo $permanentAddress->district == $district->district_id ? "selected" : "" ?> value="<?php echo $district->district_id; ?>"><?php echo $district->district_name; ?></option>
                                        <?php
                                            endif;
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="text-uppercase text-sm">City/ Town<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="City/ Town" id="city_town" name="city_town" class="form-control mb" value="<?php echo $permanentAddress->city_town ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="text-uppercase text-sm">Village/ Mandal<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="Village/ Mandal" id="village_mandal" name="village_mandal" class="form-control mb" value="<?php echo $permanentAddress->village_mandal ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="text-uppercase text-sm">Pin<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="Pin" id="pin" name="pin" class="form-control mb" value="<?php echo $permanentAddress->pin ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="text-uppercase text-sm">Landmark<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="Landmark" id="landmark" name="landmark" class="form-control mb" required value="<?php echo $permanentAddress->landmark ?>" >
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <label class="text-uppercase text-sm">Mobile 1<i style="color: red;">*</i></label>
                                    <input type="number" placeholder="Mobile 1" id="mobile1" name="mobile1" class="form-control mb" value="<?php echo $StudentDetail->mobile1 ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="text-uppercase text-sm">Mobile 2<i style="color: red;">*</i></label>
                                    <input type="number" placeholder="Mobile 2" id="mobile2" name="mobile2" class="form-control mb"  value="<?php echo $StudentDetail->mobile2 ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="text-uppercase text-sm">Email Address<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="Email Address" id="email" name="email" class="form-control mb" value="<?php echo $StudentDetail->email ?>">
                                </div>
                            </div>
                            <br />
                            <div class="row">
                                <div class="col-md-10">
                                </div>
                                <div class="col-md-2">
                                    <a class="btn btn-primary" onclick="$('#EducationTab').click()">Previous</a>&nbsp;&nbsp;&nbsp;
                                    <a class="btn btn-primary" onclick="$('#FeesTab').click()">Next</a>
                                </div>
                            </div>
                        </div>

                        <div id="fees" class="tab-pane fade">

                           

                            <br />
                            <br>
                              
                              <br>
                              <br>

                              <table id="tblinvoices" class="DataTable table table-striped" style="width: 100% !important;">
                                 <thead>
                                    <tr>
                                       <th>InvoiceId</th>
                                       <th>Total Invoice Value</th>
                                       <?php if ($_SESSION['rights'][array_search('Invoice', array_column($_SESSION['rights'], 'operationname'))]->_edit == 1) : ?>
                                          <th>
                                             Edit </th>
                                       <?php
                                       endif;
                                       ?>
                                       <th>Download</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php

                                    foreach ($InvoiceDetails as $result) :
                                    ?>
                                       <tr>
                                          <td><a target="_blank" href="<?php echo base_url('payments/generateinvoice') ?>?invoiceid=<?php echo $result->invoiceid ?>&type=view"><?php echo $result->invoiceid ?></a></td>
                                          <td><?php echo $result->TotalValue ?></td>
                                          <?php if ($_SESSION['rights'][array_search('Invoice', array_column($_SESSION['rights'], 'operationname'))]->_edit == 1) : ?>
                                             <td>
                                                <i data-toggle="modal" data-target="#editinvoice_<?php echo $result->invoiceid ?>" class="fa fa-pencil-square-o"></i>
                                                <div class="modal fade" id="editinvoice_<?php echo $result->invoiceid ?>" tabindex="-1" role="dialog">
                                                   <div class="modal-dialog" role="document" style="width: 60vw">
                                                      <div class="modal-content">
                                                         <div class="modal-header">
                                                            <h2 class="modal-title">Edit Invoice - <?php echo $result->invoiceid ?></h2>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                               <span>&times;</span>
                                                            </button>
                                                         </div>
                                                         <div class="modal-body">
                                                            <form method="post" action="<?php echo base_url('payments/editinvoice') ?>">
                                                               <div class="row">
                                                                  <div class="col-md-12">
                                                                     <input type="hidden" name="userid" value="<?php echo $userid; ?>" />
                                                                     <input type="hidden" name="returnURL" value="users/studentdetails?id=<?php echo $userid ?>" />
                                                                     <input type="hidden" name="invoiceid" id="invoiceid" value="<?php echo $result->invoiceid ?>" />

                                                                     <table class="table ">
                                                                        <thead>
                                                                           <tr>
                                                                              <th>Fees Type</th>
                                                                              <th>Fees Value(Value should be negative for Discount)</th>
                                                                              <th>Additional Details</th>
                                                                           </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                           <?php
                                                                           $paymentsModel = new PaymentsModel();
                                                                           $Tuitionfee = 0;
                                                                           $InvoiceDetails1 = $paymentsModel->getInvoiceDetailsByInvoiceId($result->invoiceid, $result->batchid);
                                                                           foreach ($InvoiceDetails1 as $each) :
                                                                            if($each->feetype == "Tuition Fee")
                                                                            {
                                                                                $Tuitionfee = $each->feesvalue ;
                                                                            }
                                                                           ?>
                                                                              <tr>
                                                                                 <td><?php echo $each->feetype ?></td>
                                                                                 <td><?php echo $each->feesvalue ?></td>
                                                                                 <td><?php echo $each->additionaldetails ?></td>
                                                                              </tr>
                                                                           <?php endforeach; ?>
                                                                           
                                                                           
                                                                        </tbody>
                                                                     </table>
                                                                  </div>
                                                               </div>
                                                               
                                                            </form>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                             </td>
                                          <?php
                                          endif;
                                          ?>
                                          <td>
                                             <a title="View" target="_blank" href="<?php echo base_url('payments/generateinvoice') ?>?invoiceid=<?php echo $result->invoiceid ?>&type=view"><i class="fa fa-eye"></i></a>&nbsp;
                                             <a title="Download" href="<?php echo base_url('payments/generateinvoice') ?>?invoiceid=<?php echo $result->invoiceid ?>&type=download"><i class="fa fa-download"></i></a>&nbsp;
                                             <a title="Send Email" onclick="sendinvoiceemail('<?php echo $result->invoiceid ?>', '<?php echo $result->userid ?>')"><i class="fa fa-paper-plane"></i></a>
                                          </td>
                                       </tr>
                                    <?php endforeach; ?>
                                   
                                 </tbody>
                              </table>
                              <?php
                                    if ($InvoiceDetails[0]->TotalValue == $InvoiceDetails[0]->TotalPaid) {
                                    }
                                    elseif($InvoiceDetails[0]->TotalPaid > $InvoiceDetails[0]->TotalValue)
                                    {
                                        echo "Note:".$InvoiceDetails[0]->RemainingAmount." will be carry forward
                                        last year Refund";
                                        ?>
                                        <input type="hidden" value="<?php echo $InvoiceDetails[0]->RemainingAmount;?>" name="lastyearrefunds" id="lastyearrefunds">
                                        <?php
                                    }
                                    else
                                    {
                                        echo "Note:".$InvoiceDetails[0]->RemainingAmount." will be carry forward
                                        last year dues";
                                         ?>
                                        <input type="hidden" value="<?php echo $InvoiceDetails[0]->RemainingAmount;?>" name="lastyeardues" id="lastyeardues">
                                        <?php
                                    }
                                    
                                    ?>
                                    <br>
                                    <br>
                            <?php $helperModel = new HelperModel(); ?>
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="text-uppercase text-sm">Final Tuition Fees</label>
                                    <input type="text" min="0" onkeyup="changeNormal()" onchange="changeNormal()"  readonly name="tuition_discount" id="text_tuition_fees_total" class='form-control mb' />
                                </div>
                                 <div class="col-md-4">
                                    <label class="text-uppercase text-sm">Final IPE Fees</label>
                                    <?php if ($_SESSION['userdetails']->userid == 1) : ?>
                                        <input type="text" min="0" value="0" onkeyup="changeNormal()" readonly onchange="changeNormal()" name="ipe_discount" id="text_ipe_fees_total" class='form-control mb' />
                                    <?php else: ?>
                                        <input type="text" min="0" value="0" onkeyup="changeNormal()" readonly onchange="changeNormal()" name="ipe_discount" id="text_ipe_fees_total" class='form-control mb' />
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-4">
                                    <label class="text-uppercase text-sm">Final Hostel Fees</label>
                                    <input type="text" min="0" value="0" onkeyup="changeNormal()" readonly onchange="changeNormal()" name="hostel_discount" id="text_hostel_fees_total" class='form-control mb' />
                                </div>
                                <div class="col-md-4">
                                    <label class="text-uppercase text-sm">Comments</label>
                                    <input type='text' name='comments' placeholder="comments" class='form-control mb'>
                                </div>
                            </div>
                            <br />
                            <div id="feecontent"></div>
                            <div id="totalfeecontent"></div>
                            <br />

                            <div class="row">
                                <div class="col-md-10">
                                </div>
                                <div class="col-md-2">
                                <a class="btn btn-primary" onclick="$('#ApplicationTab').click()">Previous</a>&nbsp;&nbsp;&nbsp;
                                 <a class="btn btn-primary" onclick="$('#PreviewTab').click()">Next</a>
                                
                                </div>
                            </div>
                        </div>
                         <div id="payment" class="tab-pane fade">
                            <br>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Booking Fees</label>
                                    <select onchange="this.classList.remove('error')" name="paymenttypeid" style="width: 100%;" class="select2 form-control mb">
                                        <option value="">Select Payment Type</option>
                                        <?php

                                        foreach ($lookups['paymenttypelookup'] as $paymenttype) :
                                        ?>
                                            <option value="<?php echo $paymenttype->paymenttypeid; ?>"><?php echo $paymenttype->paymenttypename; ?></option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Payment Amount</label>
                                    <input type="number" placeholder="Payment Amount" name="paymentamount" class="form-control mb">
                                </div>
                            </div>
                            <div class="row">
                                <!-- <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Payment Date</label>
                                    <input type="text" placeholder="dd/mm/yy" id="paymentdate" name="paymentdate" class="form-control mb paymentdate" required>
                                </div> -->
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Payment Details</label>
                                    <input type="text" placeholder="UTR No / Check No / Recipt No" name="otherdetails" class="form-control mb">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                </div>
                                <div class="col-md-2">
                                    <a class="btn btn-primary" onclick="$('#FeesTab').click()">Previous</a>&nbsp;&nbsp;&nbsp;
                                    <a class="btn btn-primary" onclick="$('#PreviewTab').click()">Next</a>
                                </div>
                            </div>
                        </div>
                        <div id="preview" class="tab-pane fade">
                            <div id="print_preview">
                                <table style="width: 100%;margin: 0;">
                                    <br />
                                    <tr>
                                        <th style="float: left !important;">Application Number: <b><span id="preview_applicationnumber"></span></b></th>
                                    </tr>

                                    <tr>
                                        <th style="float: left !important;"><br /><i>Application Details</i></th>
                                    </tr>
                                    <tr>
                                        <td>Admission Type: <b><span class="preview_admissiontype"></span></b></td>
                                        <td>Branch: <b><span class="preview_branch"></span></b></td>
                                        <td>Batch: <b><span class="preview_batch"></span></b></td>
                                    </tr>
                                    <tr>
                                        <td>Course: <b><span class="preview_course"></span></b></td>
                                        <td>Section: <b><span class="preview_section"></span></b></td>
                                        
                                    </tr>
                                   

                                    <tr>
                                        <th style="float: left !important;"><br /><i>Basic Details</i></th>
                                    </tr>
                                    <tr>
                                        <td>Student Name: <b><span class="preview_studentname"></span></b></td>
                                        <td>Date Of Birth: <b><span class="preview_dateofbirth"></span></b></td>
                                        <td>Gender: <b><span class="preview_gender"></span></b></td>
                                    </tr>
                                    <tr>
                                        <td>Category: <b><span class="preview_category"></span></b></td>
                                        <td>Nationality: <b><span class="preview_nationality"></span></b></td>
                                        <td>Religion: <b><span class="preview_religion"></span></b></td>
                                    </tr>
                                    <tr>
                                        <td>Aadhaar Number: <b><span class="preview_aadhaar"></span></b></td>
                                    </tr>

                                    <tr>
                                        <th style="float: left !important;"><br /><i>Family Details</i></th>
                                    </tr>
                                    <tr>
                                        <td>Father Name/ Guardian Name: <b><span class="preview_fathername"></span></b></td>
                                        <td>Mother Name: <b><span class="preview_mothername"></span></b></td>
                                        <td>Parent Occupation: <b><span class="preview_parentoccupation"></span></b></td>
                                    </tr>

                                    <tr>
                                        <th style="float: left !important;"><br /><i>Education Details</i></th>
                                    </tr>
                                    <tr>
                                        <td>Board Name: <b><span class="preview_board"></span></b></td>
                                        <td>School Name: <b><span class="preview_schoolname"></span></b></td>
                                        <td>Area/ Place: <b><span class="preview_area"></span></b></td>
                                    </tr>
                                    <tr>
                                        <td>Grade/ Marks: <b><span class="preview_grade"></span></b></td>
                                        <td>Hallticket Number: <b><span class="preview_hallticketnumber"></span></b></td>
                                    </tr>

                                    <tr>
                                        <th style="float: left !important;"><br /><i>Contact Details</i></th>
                                    </tr>
                                    <tr>
                                        <td>Door No./ Street Name: <b><span class="preview_doorno"></span></b></td>
                                        <td>State: <b><span class="preview_state"></span></b></td>
                                        <td>District: <b><span class="preview_district"></span></b></td>
                                    </tr>
                                    <tr>
                                        <td>City/ Town: <b><span class="preview_city"></span></b></td>
                                        <td>Village/ Mandal: <b><span class="preview_village"></span></b></td>
                                        <td>Pin: <b><span class="preview_pin"></span></b></td>
                                    </tr>
                                    <tr>
                                        <td>Landmark: <b><span class="preview_landmark"></span></b></td>
                                    </tr>
                                    <tr>
                                        <td>Mobile1: <b><span class="preview_mobile1"></span></b></td>
                                        <td>Mobile2: <b><span class="preview_mobile2"></span></b></td>
                                        <td>Email Address: <b><span class="preview_email"></span></b></td>
                                    </tr>

                                    <tr>
                                        <th style="float: left !important;"><br /><i>Fee Details</i></th>
                                    </tr>
                                    <tr>
                                        <td>Total Fee: <b><span class="preview_totalfee2"></span></b></td>
                                        <td>Comments: <b><span class="preview_comments"></span></b></td>
                                    </tr>
                                </table>
                            </div>
                            <div id="print_preview1" style="display:none; border:1px solid black;">
                                <table style="width: 100%;margin: 0;border:1px solid black;">
                                    <tr>
                                        <th style="text-align:center !important; border-bottom:1px solid black;    display: flex;
                                justify-content: center; width:50%; margin-left:auto; margin-right:auto;">STUDENT ONBOARDING FORM</th>
                                    </tr>
                                   
                                    <tr>
                                        <th style="text-align:right !important;">Date:<?php echo date("d-m-Y"); ?></th>
                                    </tr>
                                    <tr>
                                        <td>To,<br>The Resonance College,<br>Hyderabad.<br><br>I have decided to join my ward for <b><span class="preview_course"></span></b> course in <b><span class="preview_branch"></span></b> branch as <b><span class="preview_admissiontype"></span></b> student.
                                        Here by i am confirming that all the details furnished regarding my ward Admission are correct. 
                                        </td>
                                    </tr>
                                    <tr><td><br></td></tr>
                                    <tr><td><b>Student Details</b></td></tr>
                                    <tr style="display:flex;">
                                        <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">Application Number::</span> <b style="margin-right: auto;"><span class="preview_applicationnumber"></span></b></td>
                                        <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">Student Name:</span> <b style="margin-right: auto;"><span class="preview_studentname"></span></b></td>
                                    </tr>
                                    <tr  style="display:flex;">
                                        <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">Date Of Birth:</span> <b style="margin-right: auto;"><span class="preview_dateofbirth"></span></b></td>
                                        <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">Category:</span> <b style="margin-right: auto;"><span class="preview_category"></span></b></td>
                                    </tr>
                                    <tr style="display:flex;">
                                        <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">Nationality:</span> <b style="margin-right: auto;"><span class="preview_nationality"></span></b></td>
                                        <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">Religion:</span> <b style="margin-right: auto;"><span class="preview_religion"></span></b></td>
                                    </tr>
                                    
                                    <tr style="display:flex;">
                                        <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">Gender:</span> <b style="margin-right: auto;"><span class="preview_gender"></span></b></td>
                                        <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">Aadhar Number:</span> <b style="margin-right: auto;"><span class="preview_aadhaar"></span></b></td>
                                    </tr>
                                    <tr><td><br></td></tr>
                                    <tr><td><b>Education Details</b></td></tr>
                                    <tr style="display:flex;">
                                        <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">School/College:</span> <b style="margin-right: auto;"><span class="preview_schoolname"></span></b></td>
                                        <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">Board:</span> <b style="margin-right: auto;"> <b><span class="preview_board"></span></b></td>
                                    </tr>
                                    <tr>
                                    
                                    </tr>
                                    <tr><td><br></td></tr>
                                    <tr><td><b>Family Details</b></td></tr>
                                    <tr style="display:flex;">    
                                        <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">Father/Guardian Name:</span> <b style="margin-right: auto;"><span class="preview_fathername"></span></b></td>
                                        <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">Mother's Name:</span> <b style="margin-right: auto;"><span class="preview_mothername"></span></b></td>
                                    </tr>
                                    <tr>    
                                        
                                    </tr>
                                    <tr>
                                        <th style="float: left !important;"><br />Contact Details</th>
                                    </tr>
                                    <tr style="display:flex;">
                                        <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">Door No./ Street Name:</span> <b style="margin-right: auto;"><span class="preview_doorno"></span</b></td>
                                        <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">Colony/Village:</span> <b style="margin-right: auto;"><span class="preview_village"></span></b></td>
                                       
                                       
                                    </tr>
                                    <tr  style="display:flex;">
                                         <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">City/ Town: </span> <b style="margin-right: auto;"><span class="preview_city"></span></b></td>
                                         <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">Email Address: </span> <b style="margin-right: auto;"><span class="preview_email"></span></b></td>
                                    </tr>
                                     <tr style="display:flex;">
                                        <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">Mobile1: </span> <b style="margin-right: auto;"><span class="preview_mobile1"></span></b></td>
                                        <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">Mobile2: </span> <b style="margin-right: auto;"><span class="preview_mobile2"></span></b></td>
                                    </tr>
                                    
                                    <tr>
                                        <th style="float: left !important;"><br />Fee Details</th>
                                    </tr>
                                    <tr style="display:flex;">
                                        <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">Total Approved Fee:</span> <b style="margin-right: auto;"><span class="preview_totalfee2"></span></b></td>
                                          <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">Last Year Dues: </span> <b style="margin-right: auto;"><span id="preview_dues">
                                        </span></b></td>
                                    </tr>
                                    <tr style="display:flex;">
                                        <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">Last Year Refunds:</span> <b style="margin-right: auto;"><span id="preview_refunds"></span></b></td>
                                          <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;"></span> <b style="margin-right: auto;"><span id="">
                                        </span></b></td>
                                    </tr>
                                     
 
                                    <tr>
                                        <td>
                                           <br>
                                           <br>
                                           <br>
                                            <br>
                                             <br>
                                              <br>
                                        
                                            <b>Undertaking by the student</b>: I will abide by all the rules and regulations of the college. I will follow the discipline of the institution and strictly adopt anti 足
                                    ragging policies. In the event of my misbehavior, I will not question the action whatsoever taken by the authorities of the Institution, as a part of discipline,
                                    including my expulsion. I am informed by the management that electronic items like cell phones, FM Radio, Video games etc., should not be brought into the
                                    campus. If the student doesn't join for any reason reservation fee will not be refunded.
                                    <br>
                                    <br> <br />
                                    <span style='float:right;'>Signature of student </span>
                                    </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><br /><b>Undertaking by the parent</b>: I know that the fee paid towards reservation is non-refundable in any case. Cancellation of admission or settlement of account is
                                    as per the conditions mentioned above by the management. If my ward/visitor/misbehaves or creates any disturbance on the campus, the concerned ward
                                    will be transferred to the Day-Scholar campus or will be terminated from the Institution. The Institution will not bear any kind of responsibility for my ward's
                                    behavior outside the campus. If my ward leaves the campus without obtaining prior permission from the administrative authorities of the campus concerned
                                    the institution authorities are not held responsible and I myself will take up the responsibility of my ward. I understand that such actions on the part of the my
                                    ward may result to the terminatation from the Institution.
                                    <ul>
                                        <li>Fee paid for my ward will not be transferred to another student's name in any case.</li>
                                     <li>If I want to shift my ward from your institution to other before completion of two years course, I shall payback the concession given at the time of
                                    admission.</li>
                                     <li>Fee structure and concession may vary from branch to branch. The course fee does not include transport.</li>
                                     <li>Allotment of campus and section is at the sole discretion of the management. The management reserves the right to shift the students from one
                                    campus to another campus.</li>
                                     <li>Fee concession, if offered will be valid for that academic year only. Any other taxes will be collected separately, where ever applicable.</li>
                                     <li>Permission can be given to my ward, if he/she wishes to go out from the campus on any urgency or during the common outing.</li>
                                     <li> Reservation Fee once paid will not be refunded at any cost.</li>
                                     <li>Rs.10000/- from Reservation fee will be adjusted towards Tution Fee</ul>
                                    <br>
                                    <br>
                                    <span style='float:right;'>Signature of Parent </span>
                                    </td>
                                                                        </tr>
                                    </table>
                                    <br>
                                    <!--
                                    <table style='border: 1px solid #dddddd;width: 100%;margin: 0;border-collapse: collapse;' >
                                        <thead>
                                        <tr style='border: 1px solid #dddddd'>
                                            <td style='border: 1px solid #dddddd'>Details</td>
                                            <td style='border: 1px solid #dddddd'>Course</td>
                                        </tr>
                                        </thead>
                                        <tbody style='border: 1px solid #dddddd'>
                                        <tr style='border: 1px solid #dddddd'>
                                            <td style='border: 1px solid #dddddd'>Total Fee</td>
                                            <td style='border: 1px solid #dddddd'><span id="preview_totalfee12"><span></td>
                                        </tr>
                                        <tr style='border: 1px solid #dddddd'>
                                            <td style='border: 1px solid #dddddd'>Concession Fee</td>
                                            <td style='border: 1px solid #dddddd'><span id="preview_concessionfee"><span></td>
                                        </tr>
                                        <tr style='border: 1px solid #dddddd'>
                                            <td style='border: 1px solid #dddddd'>Committed Fee</td>
                                            <td style='border: 1px solid #dddddd'><span id="preview_committedfee"><span></td>
                                        </tr>
                                        <tr style='border: 1px solid #dddddd'>
                                            <td style='border: 1px solid #dddddd'>Miscellaneous Charges</td>
                                            <td style='border: 1px solid #dddddd'><span id="preview_misfee"><span></td>
                                        </tr>
                                        <tr style='border: 1px solid #dddddd'>
                                            <td style='border: 1px solid #dddddd'><b>Total Payable Amount</b></td>
                                            <td style='border: 1px solid #dddddd'><b><span id="preview_t"><span></b></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <h2>Payment Details</h2>
                                <div class="row" style="display:flex;">
                                
                                    <div class="col-md-5" style="flex:50%;max-width:50%">
                                    <h4>Payment Method - Direct Payment</h4>
                                    <p>Reservation Amount: <span id="preview_course"></span></p>
                                    <p>1st Installment Amount: <span id="preview_course"></span></p>
                                    <p>2nd Installment Amount: <span id="preview_course"></span></p>
                                    <table style='border: 1px solid #dddddd;width: 100%;margin: 0;border-collapse: collapse;'>
                                        <tr style='border: 1px solid #dddddd'>
                                            <td style='border: 1px solid #dddddd'>S.no</td>
                                            <td style='border: 1px solid #dddddd'>Cheque No</td>
                                            <td style='border: 1px solid #dddddd'>Amount </td>
                                            <td style='border: 1px solid #dddddd'>Bank Name </td>
                                            <td style='border: 1px solid #dddddd'>Cheque Date</td>
                                        </tr>
                                        <tr>
                                        <td style='border: 1px solid #dddddd'><b><span id="preview_totalfee">1</span></b></td>
                                            <td style='border: 1px solid #dddddd'><b><span id="preview_comments"></span></b></td>
                                            <td style='border: 1px solid #dddddd'><b><span id="preview_comments"></span></b></td>
                                            <td style='border: 1px solid #dddddd'><b><span id="preview_comments"></span></b></td>
                                            <td style='border: 1px solid #dddddd'><b><span id="preview_comments"></span></b></td>
                                        </tr>
                                        <tr>
                                        <td style='border: 1px solid #dddddd'><b><span id="preview_totalfee">2</span></b></td>
                                            <td style='border: 1px solid #dddddd'><b><span id="preview_comments"></span></b></td>
                                            <td style='border: 1px solid #dddddd'><b><span id="preview_comments"></span></b></td>
                                            <td style='border: 1px solid #dddddd'><b><span id="preview_comments"></span></b></td>
                                            <td style='border: 1px solid #dddddd'><b><span id="preview_comments"></span></b></td>
                                        </tr>
                                        <tr>
                                        <td style='border: 1px solid #dddddd'><b><span id="preview_totalfee">3</span></b></td>
                                            <td style='border: 1px solid #dddddd'><b><span id="preview_comments"></span></b></td>
                                            <td style='border: 1px solid #dddddd'><b><span id="preview_comments"></span></b></td>
                                            <td style='border: 1px solid #dddddd'><b><span id="preview_comments"></span></b></td>
                                            <td style='border: 1px solid #dddddd'><b><span id="preview_comments"></span></b></td>
                                        </tr>
                                        <tr>
                                        <td style='border: 1px solid #dddddd'><b><span id="preview_totalfee">4</span></b></td>
                                            <td style='border: 1px solid #dddddd'><b><span id="preview_comments"></span></b></td>
                                            <td style='border: 1px solid #dddddd'><b><span id="preview_comments"></span></b></td>
                                            <td style='border: 1px solid #dddddd'><b><span id="preview_comments"></span></b></td>
                                            <td style='border: 1px solid #dddddd'><b><span id="preview_comments"></span></b></td>
                                        </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-2" style="flex:10%;max-width:10%">
                                    </div>
                                    <div class="col-md-5" style="flex:40%;max-width:40%">
                                    <h4>Payment Method - Bajaj Payment</h4>
                                    <p>Reservation Amount: <span id="preview_course"></span></p>
                                    <p>Initial Payment: <span id="preview_course"></span></p>
                                    <p>Final Approved Fee: <span id="preview_course"></span></p>
                                    <p>Bajaj Application No: <span id="preview_course"></span></p>
                                    <p>Bajaj Application Date: <span id="preview_course"></span></p>
                                    <p>Bajaj Net Loan Amount: <span id="preview_course"></span></p>
                                    <p>Balance Amount: <span id="preview_course"></span></p>
                                    </div>
                                </div>-->
                                
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <div class="row" style="display:flex;">
                                    <div class="col-md-6" style="flex:50%;max-width:50%">
                                    <b>Accountant</b></div>
                                    <div class="col-md-4" style="flex:50%;max-width:50%">
                                    <b></b></div>
                                    <div class="col-md-2" style="flex:40%;max-width:40%">
                                    <b>Principal</b>
                                    </div>
                                </div>
                                
                            </div>
                       
                            <div class="row">
                                <div class="col-md-9">
                                    <button type="submit" name="createstudent" class="btn btn-primary">Promote Student</button>
                                </div>
                                <div class="col-md-3">
                                    <a class="btn btn-primary" onclick="$('#FeesTab').click()">Previous</a>&nbsp;&nbsp;&nbsp;
                                    <a class="btn btn-primary" onclick="print_preview1()">Print ONBOARDFORM</a>
                                </div>
                            </div>
                    
                       
                        
                    </div>
                    <input type="hidden" id="coachingfee" name='coachingfee'  />
                     <input type="hidden" id="hostelfee" name='hostelfee'  />
                    <input type="hidden" id="ipefee" name='ipefee'  />
                     <input type="hidden" id="scholarship" name='scholarship'  />
                    <input type="hidden" id="discountgiven" name='discountgiven' value="<?php echo $StudentDetail->discountgiven ?>"  />
                </form>
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
        var admissiontypelookup_json = <?php echo $lookups['admissiontypelookup_json']; ?>;
        var batchlookup_json = <?php echo $lookups['batchlookup_json']; ?>;
        var boardlookup_json = <?php echo $lookups['boardlookup_json']; ?>;
        var branchlookup_json = <?php echo $lookups['branchlookup_json']; ?>;
        var categorylookup_json = <?php echo $lookups['categorylookup_json']; ?>;
        var courselookup_json = <?php echo $lookups['courselookup_json']; ?>;
        var districtslookup_json = <?php echo $lookups['districtslookup_json']; ?>;
        var feestructurelookup_json = <?php echo $lookups['feestructurelookup_json']; ?>;
        var genderlookup_json = <?php echo $lookups['genderlookup_json']; ?>;
        var nationalitylookup_json = <?php echo $lookups['nationalitylookup_json']; ?>;
        var religionlookup_json = <?php echo $lookups['religionlookup_json']; ?>;
        var secondlanguagelookup_json = <?php echo $lookups['secondlanguagelookup_json']; ?>;
        var sectionlookup_json = <?php echo $lookups['sectionlookup_json']; ?>;
        var stateslookup_json = <?php echo $lookups['stateslookup_json']; ?>;

        var actualCoachingFee = 0;
        var actualMiscellaneousFee = 0;
        var actualIntermediateFee = 0;
        var actualHostelFee = 0;

        function generatePreview() {
          var fakeURL = "http://www.example.com/t.html?" + $('#studentform').serialize();
            var createURL = new URL(fakeURL);

            $('.preview_applicationnumber').html(createURL.searchParams.get('applicationnumber'));
            admissiontypelookup_json.forEach((a) => {
                if (a.admissiontypeid == createURL.searchParams.get('admissiontypeid')) {
                    $('.preview_admissiontype').html(a.admissiontypename)
                }
            });
            branchlookup_json.forEach((a) => {
                if (a.branchid == createURL.searchParams.get('branchid')) {
                    $('.preview_branch').html(a.branchname)
                }
            });
            batchlookup_json.forEach((a) => {
                if (a.batchid == createURL.searchParams.get('batchid')) {
                    $('.preview_batch').html(a.batchname)
                }
            });
            courselookup_json.forEach((a) => {
                if (a.courseid == createURL.searchParams.get('courseid')) {
                    $('.preview_course').html(a.coursename)
                }
            });
            sectionlookup_json.forEach((a) => {
                if (a.sectionid == createURL.searchParams.get('sectionid')) {
                    $('.preview_section').html(a.sectionname)
                }
            });
            $('.preview_admissiondate').html(createURL.searchParams.get('admissiondate'));
            secondlanguagelookup_json.forEach((a) => {
                if (a.secondlanguageid == createURL.searchParams.get('secondlanguageid')) {
                    $('#preview_secondlanguage').html(a.secondlanguagename)
                }
            });
            
            $('.preview_studentname').html(createURL.searchParams.get('name'));
            $('.preview_dateofbirth').html(createURL.searchParams.get('dateofbirth'));
            genderlookup_json.forEach((a) => {
                if (a.genderid == createURL.searchParams.get('genderid')) {
                    $('.preview_gender').html(a.gendername)
                }
            });
            categorylookup_json.forEach((a) => {
                if (a.categoryid == createURL.searchParams.get('categoryid')) {
                    $('.preview_category').html(a.categoryname)
                }
            });
            nationalitylookup_json.forEach((a) => {
                if (a.nationalityid == createURL.searchParams.get('nationalityid')) {
                    $('.preview_nationality').html(a.nationalityname)
                }
            });
            religionlookup_json.forEach((a) => {
                if (a.religionid == createURL.searchParams.get('religionid')) {
                    $('.preview_religion').html(a.religionname)
                }
            });
            $('.preview_aadhaar').html(createURL.searchParams.get('studentaadhaar'));

            $('.preview_fathername').html(createURL.searchParams.get('fathername'));
            $('.preview_mothername').html(createURL.searchParams.get('mothername'));
            $('.preview_parentoccupation').html(createURL.searchParams.get('parentoccupation'));

            boardlookup_json.forEach((a) => {
                if (a.boardid == createURL.searchParams.get('board')) {
                    $('.preview_board').html(a.boardname)
                }
            });
            $('.preview_schoolname').html(createURL.searchParams.get('school'));
            $('.preview_area').html(createURL.searchParams.get('place'));
            $('.preview_grade').html(createURL.searchParams.get('grade'));
            $('.preview_hallticketnumber').html(createURL.searchParams.get('hallticketNo'));

            $('.preview_doorno').html(createURL.searchParams.get('door_street'));
            stateslookup_json.forEach((a) => {
                if (a.state_id == createURL.searchParams.get('state')) {
                    $('.preview_state').html(a.state_name)
                }
            });
            districtslookup_json.forEach((a) => {
                if (a.district_id == createURL.searchParams.get('district')) {
                    $('.preview_district').html(a.district_name)
                }
            });
            $('.preview_city').html(createURL.searchParams.get('city_town'));
            $('.preview_village').html(createURL.searchParams.get('village_mandal'));
            $('.preview_pin').html(createURL.searchParams.get('pin'));
            $('.preview_landmark').html(createURL.searchParams.get('landmark'));
            $('.preview_mobile1').html(createURL.searchParams.get('mobile1'));
            $('.preview_mobile2').html(createURL.searchParams.get('mobile2'));
            $('.preview_email').html(createURL.searchParams.get('email'));
            $('.preview_totalfee2').html(parseFloat($('#text_tuition_fees_total').val()) + parseFloat($('#text_hostel_fees_total').val()) + parseFloat($('#text_ipe_fees_total').val()) + parseFloat(actualMiscellaneousFee));
            $('#preview_totalfee').html(parseFloat($('#text_tuition_fees_total').val()) + parseFloat($('#text_hostel_fees_total').val()) + parseFloat(actualMiscellaneousFee) + parseFloat($('#text_ipe_fees_total').val()) );
            $('#preview_comments').html(createURL.searchParams.get('comments'));
            $('#preview_dues').html(createURL.searchParams.get('lastyeardues'));
            $('#preview_refunds').html(createURL.searchParams.get('lastyearrefunds'));

        }

        function getdistricts_perm(stateid = 0) {
            $.getJSON("<?php echo base_url('home/get_districts') ?>" + "?state_id=" + stateid, function(json) {
                $('#district').empty();
                $('#district').append($('<option>').text("Select District"));
                $.each(json, function(i, obj) {
                    $('#district').append($('<option>').text(obj.district_name).attr('value', obj.district_id));
                });
            });
        }

        window.onload = function() {
            changeFeesBasedOnCourse();

            $('#studentform').validate({
                ignore: [],
                submitHandler: function() {
                    form.submit();
                },
                invalidHandler: function() {
                    setTimeout(function() {
                        $('.nav-tabs a small.required').remove();
                        var validatePane = $('.tab-content.tab-validate .tab-pane:has(input.error)').each(function() {
                            var id = $(this).attr('id');
                            $('.nav-tabs').find('a[href^="#' + id + '"]').append(' <small class="required">*</small>');
                        });
                        var validatePaneSelect = $('.tab-content.tab-validate .tab-pane:has(select.error)').each(function() {
                            var id = $(this).attr('id');
                            $('.nav-tabs').find('a[href^="#' + id + '"]').append(' <small class="required">*</small>');
                        });
                    });
                }
            });
        }

        function changeFeesBasedOnCourse() {
            var course_id = $('#courseid').val();
            var admissiontype_id = $('#admissiontypeid').val();
            var batch_id = $('#batchid').val();
             if(admissiontype_id==1)
            {
                $("#text_hostel_fees_total").attr("readonly", false); 
            }else
            {
                $("#text_hostel_fees_total").attr("readonly", true); 
            }
            if(admissiontype_id==3)
            {
                $("#text_ipe_fees_total").attr("readonly", false); 
            }
            else
            {
                $("#text_ipe_fees_total").attr("readonly", true); 
            }
            $('#feecontent').html('');
            var fees = "";

            actualCoachingFee = 0;
            actualHostelFee = 0;
            actualMiscellaneousFee = 0;
            actualIntermediateFee = 0;

            $('#coachingfee').val(0);
           // $('#text_tuition_fees_total').val(0);
            $('#text_hostel_fees_total').val(0);
            $('#text_hostel_fees_total').attr("min", 0);
            $('#text_hostel_fees_total').attr("max", 0);
            $('#totalfeecontent').html("");

            if (course_id != "" && admissiontype_id != "" && batch_id != "") {
                feestructurelookup_json.map((a) => {
                    if (a.courseid == course_id && a.admissiontypeid == admissiontype_id && a.batchid == batch_id) {
                       if (a.feetype == "Tuition Fee") {
                            actualCoachingFee = a.feesvalue;
                        }
                        if (a.feetype == "Books") {
                            fees += "<div class='row'><div class='col-md-4'>" + a.feetype + "</div><div class='col-md-4'>" + a.feesvalue + "</div><div class='col-md-4'>&nbsp;</div></div>";
                            actualMiscellaneousFee += parseFloat(a.feesvalue);
                        }
                        if (a.feetype == "Uniform") {
                            fees += "<div class='row'><div class='col-md-4'>" + a.feetype + "</div><div class='col-md-4'>" + a.feesvalue + "</div><div class='col-md-4'>&nbsp;</div></div>";
                            actualMiscellaneousFee += parseFloat(a.feesvalue);
                        }
                        
                        if (a.feetype == "Laundry") {
                            fees += "<div class='row'><div class='col-md-4'>" + a.feetype + "</div><div class='col-md-4'>" + a.feesvalue + "</div><div class='col-md-4'>&nbsp;</div></div>";
                            actualMiscellaneousFee += parseFloat(a.feesvalue);
                        }
                        if (a.feetype == "Intermediate Fee") {
                            actualIntermediateFee = a.feesvalue;
                        }
                        if (a.feetype == "Hostel Fee") {
                            actualHostelFee = a.feesvalue;
                        }
                    };
                });
                change(admissiontype_id);
            }

            $('#feecontent').html(fees);
        }

        function change(admissiontype_id) {
             if(admissiontype_id==1)
            {
            $('#coachingfee').val(actualCoachingFee);
            $('#hostelfee').val(actualHostelFee);
            $('#ipefee').val(actualIntermediateFee);
            $('#text_tuition_fees_total').attr("min", 0);
            $('#text_tuition_fees_total').attr("max", $('#coachingfee').val());
            $('#text_tuition_fees_total').attr("title", "Fees Should be between " + 0 + " and " + $('#coachingfee').val());
            $('#text_tuition_fees_total').val($('#coachingfee').val());
            $('#text_ipe_fees_total').val(actualIntermediateFee);
            $('#text_hostel_fees_total').attr("min", 0);
            $('#text_hostel_fees_total').attr("max", actualHostelFee);
            $('#text_hostel_fees_total').val($('#hostelfee').val() - $('#discountgiven').val());
            }else
            {
            var ms = parseFloat($('#meritscholarship').html()) + parseFloat($('#meritinterviewscholarship').html());
                $('#scholarship').val(ms);
                $('#coachingfee').val(actualCoachingFee);
                $('#hostelfee').val(actualHostelFee);
                $('#ipefee').val(actualIntermediateFee);
                $('#text_tuition_fees_total').attr("min", 0);
                $('#text_tuition_fees_total').attr("max", $('#coachingfee').val());
                $('#text_tuition_fees_total').attr("title", "Fees Should be between " + 0 + " and " + $('#coachingfee').val());
                $('#text_tuition_fees_total').val($('#coachingfee').val());
                $('#text_ipe_fees_total').val(actualIntermediateFee - $('#discountgiven').val());
                $('#text_hostel_fees_total').attr("min", 0);
                $('#text_hostel_fees_total').attr("max", actualHostelFee);
                $('#text_hostel_fees_total').val($('#hostelfee').val());
            }
            changeNormal(admissiontype_id);
        }

        function changeNormal(admissiontype_id=0) {
           
             if(admissiontype_id==0)
            {
            if($('#hostelfee').val()>0)
            {
            $('#discountgiven').val($('#hostelfee').val() - $('#text_hostel_fees_total').val());
            $('#totalfeecontent').html("<div class='row'><div class='col-md-4'>Total Fees</div><div class='col-md-4'>" + (parseFloat($('#text_tuition_fees_total').val()) + parseFloat($('#text_hostel_fees_total').val()) + parseFloat(actualMiscellaneousFee) + parseFloat(actualIntermediateFee)) + "</div><div class='col-md-4'>&nbsp;</div></div>");
            }else
            {
            $('#discountgiven').val($('#ipefee').val() - $('#text_ipe_fees_total').val());
            $('#totalfeecontent').html("<div class='row'><div class='col-md-4'>Total Fees</div><div class='col-md-4'>" + (parseFloat($('#text_tuition_fees_total').val()) + parseFloat($('#text_hostel_fees_total').val()) + parseFloat(actualMiscellaneousFee) + parseFloat($('#text_ipe_fees_total').val())) + "</div><div class='col-md-4'>&nbsp;</div></div>");
            }
            }else
            {
                if(admissiontype_id==1)
            {
            $('#discountgiven').val($('#hostelfee').val() - $('#text_hostel_fees_total').val());
            $('#totalfeecontent').html("<div class='row'><div class='col-md-4'>Total Fees</div><div class='col-md-4'>" + (parseFloat($('#text_tuition_fees_total').val()) + parseFloat($('#text_hostel_fees_total').val()) + parseFloat(actualMiscellaneousFee) + parseFloat(actualIntermediateFee)) + "</div><div class='col-md-4'>&nbsp;</div></div>");
            }else
            {
                $('#discountgiven').val($('#ipefee').val() - $('#text_ipe_fees_total').val());
            $('#totalfeecontent').html("<div class='row'><div class='col-md-4'>Total Fees</div><div class='col-md-4'>" + (parseFloat($('#text_tuition_fees_total').val()) + parseFloat($('#text_hostel_fees_total').val()) + parseFloat(actualMiscellaneousFee) + parseFloat($('#text_ipe_fees_total').val())) + "</div><div class='col-md-4'>&nbsp;</div></div>");
            }
            }
        }
    </script>
</div>