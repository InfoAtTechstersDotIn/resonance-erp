<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">
                    <?php
                    $uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
                    $lastUriSegment = array_pop($uriSegments);
                    //echo $lastUriSegment;
                    if($lastUriSegment == "Applications")
                    {
                        echo "Applications";
                    }else{
                    echo "RET Eligilble Leads";
                    }
                    use App\Models\HelperModel;
                    use App\Models\ReservationModel;
                   ?>
                   <?php if($_SESSION['agentdetails']->roleid == 14)
                   {
                       ?>
                       <a  class="btn btn-default" href="<?php echo base_url("agentdashboard/addApplicant") ?>" style="float: right;">Add Application</a>
                       <?php
                   }
                        ?>
                    
                </h2>
                <form class="mb">
                    <div class="row">
                        <div class="col-md-4 mb">
                            <select name="branchid" style="width: 100%;" class="form-control">
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
                        <div class="col-md-4 mb">
                            <select name="courseid" style="width: 100%;" class="form-control">
                                <option value="">Select Course</option>
                                <?php
                                foreach ($lookups['courselookup'] as $course) :
                                ?>
                                    <option value="<?php echo $course->courseid; ?>" <?php echo isset($_GET['courseid']) && $_GET['courseid'] == $course->courseid ? "selected" : "" ?>><?php echo $course->coursename; ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb">
                            <select name="admissiontypeid" style="width: 100%;" class="form-control">
                                <option value="">Select Admission Type</option>
                                <?php
                                foreach ($lookups['admissiontypelookup'] as $admissiontype) :
                                ?>
                                    <option value="<?php echo $admissiontype->admissiontypeid; ?>" <?php echo isset($_GET['admissiontypeid']) && $_GET['admissiontypeid'] == $admissiontype->admissiontypeid ? "selected" : "" ?>><?php echo $admissiontype->admissiontypename; ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb">
                            <select name="reservationstatusid" style="width: 100%;" class="form-control">
                                <option value="">Select Application Status</option>
                                <?php
                                foreach ($lookups['reservationstatuslookup'] as $reservationstatus) :
                                ?>
                                    <option value="<?php echo $reservationstatus->reservationstatusid; ?>" <?php echo isset($_GET['reservationstatusid']) && $_GET['reservationstatusid'] == $reservationstatus->reservationstatusid ? "selected" : "" ?>><?php echo $reservationstatus->reservationstatusname; ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-md-12" style="overflow-x:auto;">
                        <table id="tblStudents" class="DataTable table table-striped" >
                            <thead>
                                <tr>
                                    <th>Application Id</th>
                                    <th>Student Name</th>
                                    <th>Application Status</th>
                                    <th>RET Status</th>
                                    <th>Gender</th>
                                    <th>Branch - Course - Admission Type</th>
                                    <th>Mobile/ Email</th>
                                    <th>Comments</th>
                                    <th>Print Application</th>
                                    <th>Print Discount</th>
                                    <th>Print Application & Payment</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            
                                foreach ($reservations as $result) :
                                     
                                    if (isset($_GET['branchid'])) {
                                        if ($_GET['branchid'] == "" || $result->branchid == $_GET['branchid']) {
                                        } else {
                                            continue;
                                        }
                                    }
                                    if (isset($_GET['courseid'])) {
                                        if ($_GET['courseid'] == "" || $result->courseid == $_GET['courseid']) {
                                        } else {
                                            continue;
                                        }
                                    }
                                    if (isset($_GET['admissiontypeid'])) {
                                        if ($_GET['admissiontypeid'] == "" || $result->admissiontypeid == $_GET['admissiontypeid']) {
                                        } else {
                                            continue;
                                        }
                                    }
                                    if (isset($_GET['reservationstatusid'])) {
                                        if ($_GET['reservationstatusid'] == "" || $result->reservationstatusid == $_GET['reservationstatusid']) {
                                        } else {
                                            continue;
                                        }
                                    }
                                    if (isset($_GET['secondlanguageid'])) {
                                        if ($_GET['secondlanguageid'] == "" || $result->secondlanguageid == $_GET['secondlanguageid']) {
                                        } else {
                                            continue;
                                        }
                                    }
                                ?>
                                    <tr>
                                        <td><a  href="<?php echo base_url('agentdashboard/applicationDetails?id=' . $result->applicationid ) ?>"><?php echo $result->application_ukey ?></a>
                                     <?php if($result->is_profile_uploaded == 1){
                                         ?>
                                         Image <i class="fa fa-check" aria-hidden="true" style="color: green;font-size: 25px;"></i>
                                         <?php
                                     }
                                     ?>
                                       

                                        <?php
                                     $reservationModel = new ReservationModel();
                                   $PaymentDetail = $reservationModel->getReservationPaymentDetailsByReservationId($result->applicationid);
                                   $totalPayment=0;
                                   foreach ($PaymentDetail as $payment) :
                                       $totalPayment = $totalPayment+$payment->paymentamount;
                                    //if( $payment->paymentstatusid == 3)
                                   // {
                                        
                                    //}
                                   endforeach;
                                //    $helperModel = new HelperModel();
                                //   $ipe =  $helperModel->get_fees_from_lookup($result->courseid, $result->admissiontypeid, $result->batchid, 'Intermediate Fee');
                                //    $tution =  $helperModel->get_fees_from_lookup($result->courseid, $result->admissiontypeid, $result->batchid, 'Tuition Fee');
                                //     $hostel =  $helperModel->get_fees_from_lookup($result->courseid, $result->admissiontypeid, $result->batchid, 'Hostel Fee');
                                //      $laundry =  $helperModel->get_fees_from_lookup($result->courseid, $result->admissiontypeid, $result->batchid, 'Laundry');
                                //      $uniform =  $helperModel->get_fees_from_lookup($result->courseid, $result->admissiontypeid, $result->batchid, 'Uniform');
                                //       $books =  $helperModel->get_fees_from_lookup($result->courseid, $result->admissiontypeid, $result->batchid, 'Books');
                                //        $caution =  $helperModel->get_fees_from_lookup($result->courseid, $result->admissiontypeid, $result->batchid, 'Caution Deposit');
                                //    $finalfee = ($tution + $hostel + $ipe + $laundry + $books + $caution + $uniform)- $result->discountgiven;
                                  // echo $result->tuition_discount;
                                   //echo $finalfee;
                                //   $halffee = (15 / 100) * $finalfee;
                                  //$halffee = $finalfee/2;
                                    if($result->reservationstatusname=="Confirmed" && $result->is_migrate==0 && ($_SESSION['agentdetails']->roleid == 1 || $_SESSION['agentdetails']->userid == 7181))
                                    {
                                        echo "<a href='" . base_url('users/createapplicationreservation') .'/'. $result->applicationid . "' class='btn btn-danger' target='_blank'>Migrate</a>";
                                    }
                                    if($result->is_migrate==1)
                                    {
                                        echo "<a class='btn btn-danger'>Migrated</a>";
                                    }
                                    ?>
                                        </td>
                                        <td><?php echo $result->name ?></td>
                                        <td><?php echo $result->reservationstatusname ?></td>
                                        <td><?php echo $result->retstatusname ?>
                                        <br>
                                        <br>
                                        <?php
                                        if(($_SESSION['agentdetails']->userid == 1 || $_SESSION['agentdetails']->roleid == 3) && $result->retstatus==1)
                                        {
                                            ?>
  					                        <button class="btn btn-warning user_retstatus" uid="<?php echo $result->applicationid; ?>"  ustatus="4">Mark As Postpone</button>
                                            <?php
                                        }
                                        if(($_SESSION['agentdetails']->userid == 1) && $result->retstatus==3)
                                        {
                                            ?>
  					                        <button class="btn btn-warning user_retstatus" uid="<?php echo $result->applicationid; ?>"  ustatus="5">Mark As Manually Qualified</button>
                                            <?php
                                        }
                                        ?>
                                        </td>
                                        <td><?php echo $result->gendername ?></td>
                                        <td><?php echo $result->branchname . "<br />" . $result->coursename . "<br />" . $result->admissiontypename ?></td>
                                        <td><?php echo $result->mobile1 . "<br />" . $result->mobile2 . "<br />" . $result->email ?></td>
                                        <td><?php echo $result->comments; ?></td>
                                        <td>
                                              <?php if($result->reservationstatusid !=6)
                                            {
                                                ?>
                                            <a class="btn btn-primary" target="_blank" href="https://maidendropgroup.com/public/payments/printapp?userid=<?php echo $result->applicationid ?>">Print Application</a>
                                            <?php } ?>
                                            </td>
                                        <td>
                                            <?php if($result->discountgiven != null || $result->discountgiven !="")
                                            {
                                                ?>
                                                <a class="btn btn-primary" target="_blank" href="https://maidendropgroup.com/public/payments/printdis?userid=<?php echo $result->applicationid ?>">Print Discount</a>
                                                <?php
                                            }
                                            ?>
                                            </td>
                                            
                                            <td>
                                            <?php if($result->reservationstatusid ==5)
                                            {
                                                ?>
                                            <a class="btn btn-primary" target="_blank" href="https://maidendropgroup.com/public/agentdashboard/successform/?id=<?php echo $result->applicationid ?>">Print Acknowledgement</a>

                                                <?php
                                            }
                                            ?>
                                            </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal modal-danger fade" id="modal_popup">

    <div class="modal-dialog modal-sm">

        
    	<form action="<?php echo base_url(); ?>/agentdashboard/ret_status_changed" method="post"> 
	     	 <div class="modal-content">

		        <div class="modal-header" style="height: 150px;">

		          	<h4 style="margin-top: 50px;text-align: center;">Are you sure, do you change user status?</h4>

                  
					<input type="hidden" name="id" id="user_id" value="">
					<input type="hidden" name="retstatus" id="user_status" value="">

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

        
    	<form action="<?php echo base_url(); ?>/agentdashboard/ret_status_changed" method="post"> 
	     	 <div class="modal-content">

		        <div class="modal-header" style="height: 150px;">

		          	<h4 style="margin-top: 50px;text-align: center;">Are you sure, do you change user status?</h4>

                  
					<input type="hidden" name="id" id="user_id" value="">
					<input type="hidden" name="retstatus" id="user_status" value="">

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
	$(document).on('click','.user_retstatus',function(){

		var id = $(this).attr('uid'); //get attribute value in variable
		
		var status = $(this).attr('ustatus'); //get attribute value in variable

		$('#user_id').val(id); //pass attribute value in ID
		$('#user_status').val(status);  //pass attribute value in ID

		$('#modal_popup').modal({backdrop: 'static', keyboard: true, show: true}); //show modal popup

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

    });
    
    $('#tblStudents').DataTable( {
    responsive: true
} );
</script>