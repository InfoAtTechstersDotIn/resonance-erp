<?php

namespace App\Controllers;

use App\Models\HelperModel;
use App\Models\PaymentsModel;
use App\Models\HomeModel;
use App\Models\UsersModel;
use App\Models\ReservationModel;
use App\Models\RazorpayModel;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

include APPPATH . 'ThirdParty/razorpay-php/Razorpay.php';

class Agentdashboard extends BaseController
{
    public $session;
    var $key = "rzp_live_HitgmaI2G7gM95";
    var $secret = "Yfv8CwD9oUX3G4p5skO2bzCJ";
    var $key1 = "rzp_live_xYTgZTX1tbC9Lw";
    var $secret1 = "X1byNR9Hbti2xN2MR2mA2Aub";
    public function __construct()
    {
        $session = session();
    }

    public function index()
    {
   
        if ($_SESSION['agentdetails'] == null) {
			return redirect()->to(base_url('home/login'));
		} else {
            $data['page_name'] = 'agentdashboard';

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            return view('loggedinuser/application.php', $data);
		}
    }
    public function addApplicant()
    {
         if ($_SESSION['agentdetails'] == null) {
			return redirect()->to(base_url('home/login'));
		} else {
        $data['page_name'] = 'addApplicant';

        $helperModel = new HelperModel();
        $data['nextapplicationid'] = $helperModel->get_regapplicationidcounter();
        $data['lookups'] = $helperModel->get_lookups();
        
        $usersModel = new UsersModel();
        $data['EmployeeDetails'] = $usersModel->getMarketingEmployeeDetails();
        $resofastId = $this->request->getGetPost('resofast');
         if ($resofastId != "") {

                $isValidResofastId = $usersModel->checkDuplicateResofastId($resofastId);
                if ($isValidResofastId != "false") {

                    $db = db_connect("resoFast");

                    $query = $db->query("SELECT * FROM exam_score where hall_no = '{$resofastId}'");
                    $result = $query->getRow();
                    $db->close();

                    if ($result != null) {
                        $rezofastdetails = [];
                        $rezofastdetails['hallticketnumber'] = $result->hall_no == null ? '' : $result->hall_no;
                        $rezofastdetails['score'] = $result->score == null ? 0 : $result->score;
                        $rezofastdetails['discount'] = $result->discount == null ? 0 : $result->discount;
                        //$usersModel = new UsersModel();
                        //$rezofastdetails['scholarship'] = $usersModel->getscholarship($rezofastdetails['score'], $rezofastdetails['interviewscore'], $data['StudentDetail']->batchid);
                        $data['rezofastdetails'] = json_encode($rezofastdetails);
                    } else {
                        echo "Invalid Resofast Id";
                        exit();
                    }
                }
            }

        return view('loggedinuser/application.php', $data);
		}
    }
    public function Applications()
    {
        
         if ($_SESSION['agentdetails'] == null) {
			return redirect()->to(base_url('home/login'));
		} else {
        $data['page_name'] = 'applications';

        $helperModel = new HelperModel();

        $data['lookups'] = $helperModel->get_lookups();
        $reservationModel = new ReservationModel();
         if($_SESSION['agentdetails']->userid==7181)
        {
            $reservations = $reservationModel->get_allapplications();
           
        }
        elseif($_SESSION['agentdetails']->roleid==15){
            $reservations = $reservationModel->get_agentapplications();
        }else if($_SESSION['agentdetails']->roleid==3)
        {
            $reservations = $reservationModel->get_applications();
        }
        else if($_SESSION['agentdetails']->roleid==1)
        {
            $reservations = $reservationModel->get_allapplications();
        }
        else
        {
            $reservations = $reservationModel->get_myapplications();
        }
            $data['reservations'] = $reservations;
            return view('loggedinuser/application.php', $data);
		}
    }
    
     public function RetApplications()
    {
        
         if ($_SESSION['agentdetails'] == null) {
			return redirect()->to(base_url('home/login'));
		} else {
        $data['page_name'] = 'applications';

        $helperModel = new HelperModel();

        $data['lookups'] = $helperModel->get_lookups();
        $reservationModel = new ReservationModel();
        if($_SESSION['agentdetails']->userid==7181)
        {
            $reservations = $reservationModel->get_retallapplications();
        }else
        {
        
        if($_SESSION['agentdetails']->roleid==15){
        $reservations = $reservationModel->get_retagentapplications();
        }  else if($_SESSION['agentdetails']->roleid==3)
        {
           
            $reservations = $reservationModel->get_retapplications();
        }
        else if($_SESSION['agentdetails']->roleid==1)
        {
            $reservations = $reservationModel->get_retallapplications();
        }
        else
        {
            $reservations = $reservationModel->get_retmyapplications();
        }
        }
            $data['reservations'] = $reservations;
        return view('loggedinuser/application.php', $data);
		}
    }
    
    public function applicationDetails()
    {
        if ($_SESSION['agentdetails'] != null) {
            $reservationId = $this->request->getGetPost('id');
            $resofastId = $this->request->getGetPost('resofast');

            $data['page_name'] = 'applicationDetails';

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            $usersModel = new UsersModel();
            $data['EmployeeDetails'] = $usersModel->getAllEmployeeDetails();
            $data['FeesLimit'] = $usersModel->getAllEmployeeDetailsById($_SESSION['agentdetails']->userid);
            $reservationModel = new ReservationModel();
            $data['StudentDetail'] = $reservationModel->getApplicationDetails($reservationId);
            if ($data['StudentDetail'] == NULL) {
                return redirect()->to(base_url('agentdashboard/addApplicant'));
            }
          //  $data['PaymentDetail'] = $reservationModel->getReservationPaymentDetailsByReservationId($reservationId);
            $paymentsModel = new PaymentsModel();
            $data['PaymentLinks']= $paymentsModel->getApplicationPaymentLinks($reservationId);
               // $data['PaymentLinks'] = $this->getLatestPaymentLinkData($paymentLinks);
            
            if ($data['StudentDetail']->rezofastdetails != NULL || $data['StudentDetail']->rezofastdetails != "") {
                $data['StudentDetail']->rezofastdetails = urldecode($data['StudentDetail']->rezofastdetails);
            }

            if ($resofastId != "") {

                $isValidResofastId = $usersModel->checkDuplicateResofastId($resofastId);
                if ($isValidResofastId != "false") {

                    $db = db_connect("resoFast");

                    $query = $db->query("SELECT * FROM register 
                                     JOIN exam_score ON register.reference_no = exam_score.hall_no 
                                     where register.is_paid = 1 and reference_no = '{$resofastId}'");
                    $result = $query->getRow();
                    $db->close();

                    if ($result != null) {
                        $rezofastdetails = [];
                        $rezofastdetails['hallticketnumber'] = $result->reference_no == null ? '' : $result->reference_no;
                        $rezofastdetails['score'] = $result->score == null ? 0 : $result->score;
                        $rezofastdetails['interviewscore'] = $result->interview_score == null ? 0 : $result->interview_score;

                        $usersModel = new UsersModel();
                        $rezofastdetails['scholarship'] = $usersModel->getscholarship($rezofastdetails['score'], $rezofastdetails['interviewscore'], $data['StudentDetail']->batchid);

                        $data['StudentDetail']->rezofastdetails = json_encode($rezofastdetails);
                    } else {
                        echo "Invalid Resofast Id";
                        exit();
                    }
                }
            }

            return view('loggedinuser/application.php', $data);
        } else {
            return redirect()->to(base_url('home/login'));
        }
    }
    
     public function applicationDetail()
    {
      
            $reservationId = $this->request->getGetPost('id');

            $data['page_name'] = 'applicationDetail';

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            $usersModel = new UsersModel();
            $data['EmployeeDetails'] = $usersModel->getAllEmployeeDetails();
            $data['FeesLimit'] = $usersModel->getAllEmployeeDetailsById($_SESSION['agentdetails']->userid);
            $reservationModel = new ReservationModel();
            $data['StudentDetail'] = $reservationModel->getApplicationDetails($reservationId);
            if ($data['StudentDetail'] == NULL) {
                return redirect()->to(base_url('agentdashboard/addApplicant'));
            }
            $data['PaymentDetail'] = $reservationModel->getReservationPaymentDetailsByReservationId($reservationId);

            if ($data['StudentDetail']->rezofastdetails != NULL || $data['StudentDetail']->rezofastdetails != "") {
                $data['StudentDetail']->rezofastdetails = urldecode($data['StudentDetail']->rezofastdetails);
            }

           
            return view('loggedinuser/application.php', $data);
        
    }
    public function createapplicant()
    {
        ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
        if ($_SESSION['agentdetails'] != null) {
            $reservation_ukey = $_POST['reservationid'];
            $applicationtype = $_POST['applicationtype'];
            $name = $_POST['name'];
            $dateofbirth = date_create_from_format("d/m/Y", $_POST['dateofbirth']) != false ? date_format(date_create_from_format("d/m/Y", $_POST['dateofbirth']), 'Y-m-d') : "1971-01-01";
            $genderid = $_POST['genderid'];
            $nationalityid = '';
            $religionid = '';
            $categoryid ='';
            $studentaadhaar = $_POST['studentaadhaar'];
            
              $input = $this->validate([
            'file' => [
                'uploaded[file]',
                'mime_in[file,image/jpg,image/jpeg,image/png]',
                'max_size[file,1024]',
            ]
        ]);
        if($_FILES["file"]["error"] == 4) {
            $profile_image = null;
        }else
        {
        if (!$input) {
            print_r('Choose a valid file');
            exit();
        } else {
            $img = $this->request->getFile('file');
            $profile_image = $img->getRandomName();
            $img->move('application', $profile_image);
        }
        }
            $fathername = $_POST['fathername'];
            $mothername = $_POST['mothername'];
            $parentoccupation = '';
            $visitorname = '';
            $relationwithstudent ='';
            $visitornumber = '';
            $previous_class_information = [];
            $class = [];
            $class['class'] = 'PCI';
            $class['school'] = $_POST['school'];
            $class['board'] = $_POST['board'];
            $class['place'] = $_POST['place'];
            $class['grade'] = '';
            $class['hallticketNo'] = '';
            array_push($previous_class_information, $class);
            $address = [];
            $permanent['door_street'] = $_POST['door_street'];
            $permanent['village_mandal'] = $_POST['village_mandal'];
            $permanent['landmark'] = $_POST['landmark'];
            $permanent['city_town'] = $_POST['city_town'];
            $permanent['state'] = $_POST['state'];
            $permanent['district'] = $_POST['district'];
            $permanent['pin'] = $_POST['pin'];
            $address['permanent'] = $permanent;
            $mobile1 = $_POST['mobile1'];
            $mobile2 = $_POST['mobile2'];
            $email = $_POST['email'];
            $admissiontypeid = $_POST['admissiontypeid'];
            $courseid = $_POST['courseid'];
            $course = $_POST['course'];
            $sectionid = 0;
            $secondlanguageid = '';
            $branchid = $_POST['branchid'];
            $comments = $_POST['comments'];
            $referredby = $_SESSION['agentdetails']->userid;
            $batchid = $_POST['batchid'];
            $admissiondate = date('Y-m-d');
            $reservationstatusid = 1;
            $scholarship = 0;
            if($applicationtype ==1)
            {
            $tuition_discount = (isset($_POST['tuition_discount']) && $_POST['tuition_discount'] != "") ? $_POST['tuition_discount'] : NULL;
            }
            else
            {
                $tuition_discount = (isset($_POST['resofastfinalfee']) && $_POST['resofastfinalfee'] != "") ? $_POST['resofastfinalfee'] : NULL;
            }
            $hostel_discount =(isset($_POST['hostel_discount']) && $_POST['hostel_discount'] != "") ? $_POST['hostel_discount'] : 0;
            $final_misc = 0;
            $created_by = $_SESSION['agentdetails']->userid;

            $discountrequested = (isset($_POST['discountrequested']) && $_POST['discountrequested'] != "") ? $_POST['discountrequested'] : NULL;
            $discountgiven = (isset($_POST['discountgiven']) && $_POST['discountgiven'] != "") ? $_POST['discountgiven'] : NULL;

            $address_json = json_encode($address);
            $previous_class_information_json = json_encode($previous_class_information);

            $reservationModel = new ReservationModel();
            $insertId = $reservationModel->addApplicationUser(
                $reservation_ukey,
                $applicationtype,
                $name,
                $dateofbirth,
                $genderid,
                $nationalityid,
                $religionid,
                $categoryid,
                $studentaadhaar,
                $fathername,
                $mothername,
                $parentoccupation,
                $visitorname,
                $relationwithstudent,
                $visitornumber,
                $previous_class_information_json,
                $address_json,
                $mobile1,
                $mobile2,
                $email,
                $admissiontypeid,
                $branchid,
                $courseid,
                $course,
                $sectionid,
                $secondlanguageid,
                $comments,
                $referredby,
                $batchid,
                $admissiondate,
                $reservationstatusid,
                $scholarship,
                $tuition_discount,
                $hostel_discount,
                $final_misc,
                $discountrequested,
                $discountgiven,
                $created_by,
                $profile_image
            );
             $helperModel = new HelperModel();
                $nextpaymentid = $helperModel->set_regapplicationidcounter();
                
                $html = file_get_contents(base_url("payments/print_application?userid={$insertId}&batchid=3"));
                $paymentsModel = new PaymentsModel();
                $filename = $reservation_ukey.'-'.$name;
			    $paymentsModel->htmltopdf($html, 'save', $filename, 'R');
                
                $StudentDetailS = $reservationModel->getApplicationDetails($insertId);

                $comm = new Comm();
                $data[0] = $mobile1;
                $data[1] = $StudentDetailS->name;
                $data[2] = $StudentDetailS->application_ukey;
                $data[3] = $StudentDetailS->branchname;
                $data[4] ="https://rb.gy/fjd7gn?id={$StudentDetailS->applicationid}";
                $comm->sendSMS("Newapplication", $data);
            return redirect()->to(base_url("agentdashboard/applications"));
        
        }
    }
    public function successform($id = null)
    {
         $reservationModel = new ReservationModel();

         $id = $_GET['id'];
         
          $db = db_connect();
         $query1 = $db->query("select * from applications join applicationpayments on applications.applicationid=applicationpayments.userid where applicationid='$id'");
         $results =$query1->getResult();
         if (count($results) > 0) 
                {
                     $data['page_name'] = 'applicationSuccess';
                     $data['StudentDetail'] = $results;
                   return view('loggedinuser/applicationSuccess.php', $data);
                }else
                {
                    echo  "Please pay the payment";
                }
               // echo view('applicationSuccess', $data);
       // $StudentDetailS = $reservationModel->getApplicationDetails($id);
        
    }
    public function testsms()
    {
         $comm = new Comm();
			$data[0] =8977245573;
			$data[1] = 1;
			$data[2] = 'dde3';
			// $data[3] = base_url("receipt_files/{$paymentid}.pdf");
			$data[3] = "rb.gy/o0uabr?p=" . 2;
			$data[4] = "shia";
			 $data[5] = "aa";

			$comm->sendSMS("ApplicationPaymentConfirm", $data);
    }
    public function updateapplication()
    {
        $reservationid = $_POST['id'];
        if(isset($_POST['updatestudentdetails']))
        {
            $admissiontypeid = $_POST['admissiontypeid'];
            $courseid = $_POST['courseid'];
            $branchid = $_POST['branchid'];
            $referredby = $_POST['referredby'];
            $batchid = $_POST['batchid'];
            $name = $_POST['name'];
            $fathername = $_POST['fathername'];
            $mothername = $_POST['mothername'];
            $dateofbirth = date_create_from_format("d/m/Y", $_POST['dateofbirth']) != false ? date_format(date_create_from_format("d/m/Y", $_POST['dateofbirth']), 'Y-m-d') : "1971-01-01";
            $helperModel = new HelperModel();
            $fee = $helperModel->getFeeStructure($courseid,$admissiontypeid,$batchid);
            $new = $fee[0]->fee;
            $var = (int)$new ;
            $db = db_connect();
            $query1 = $db->query("select nextid from courselookup where courseid='$courseid'");
            $results =$query1->getResult();
           
            if($results[0]->nextid != 0){
            $fee1 = $helperModel->getNextFeeStructure($results[0]->nextid,$admissiontypeid,$batchid);
            $new1 = $fee1[0]->fee;
            $new2 = $fee1[0]->coursename;
            $var1 = (int)$new1 ;
            }else
            {
                $var1 = 0;
                $new2 = '';
            }
            $reservationModel = new ReservationModel();
               $reservationModel->updateRETDetails(
                $reservationid,$name,$fathername,$mothername,$dateofbirth,
                $branchid,$courseid,$admissiontypeid,$var,$var1,$referredby
            );
            return redirect()->to(base_url("agentdashboard/applicationDetails?id={$reservationid}"));
        }
        if(isset($_POST['updatestudentfee']))
        {
            $reservationstatusid = $_POST['reservationstatusid'];
            $tuition_discount1 = $_POST['tuition_discount'];
            $tuition_discount2 = $_POST['tuition_discount1'];
            $hostel_discount = NULL;
            $reservationid = $reservationid;
            $reservationModel = new ReservationModel();
               $reservationModel->updatefeeRET(
                $reservationid,
                $reservationstatusid,$tuition_discount1,$tuition_discount2,$hostel_discount
            );
            
        }
        if(isset($_POST['updatestudent']))
        {
            $name = $_POST['name'];
            $dateofbirth = date_create_from_format("d/m/Y", $_POST['dateofbirth']) != false ? date_format(date_create_from_format("d/m/Y", $_POST['dateofbirth']), 'Y-m-d') : "1971-01-01";
            $genderid = $_POST['genderid'];
            $studentaadhaar = $_POST['studentaadhaar'];

            $fathername = $_POST['fathername'];
            $mothername = $_POST['mothername'];

            $previous_class_information = [];
            $class = [];
            $class['class'] = 'PCI';
            $class['school'] = $_POST['school'];
            $class['board'] = $_POST['board'];
            $class['place'] = $_POST['place'];
            $class['grade'] = '';
            $class['hallticketNo'] = '';
            array_push($previous_class_information, $class);

             $address = [];
            $permanent['door_street'] = $_POST['door_street'];
            $permanent['village_mandal'] = $_POST['village_mandal'];
            $permanent['landmark'] = $_POST['landmark'];
            $permanent['city_town'] = $_POST['city_town'];
            $permanent['state'] = $_POST['state'];
            $permanent['district'] = $_POST['district'];
            $permanent['pin'] = $_POST['pin'];

            $address['permanent'] = $permanent;


            $mobile1 = $_POST['mobile1'];
            $mobile2 = $_POST['mobile2'];
            $email = $_POST['email'];

            $admissiontypeid = $_POST['admissiontypeid'];
            $courseid = $_POST['courseid'];
            $course = $_POST['course'];
            $sectionid = 0;
            $secondlanguageid = '';
            $branchid = $_POST['branchid'];
            $comments = $_POST['comments'];
            $tuition_discount = $_POST['tuition_discount'];
           
            $hostel_discount = $_POST['hostel_discount'];
            $additionaldiscountgiven = $_POST['additionaldiscountgiven'];
            $address_json = json_encode($address);
            $previous_class_information_json = json_encode($previous_class_information);
             $reservationModel = new ReservationModel();
               $reservationModel->updateApplicationDetails( $name,
                $dateofbirth,
                $genderid,
                $studentaadhaar,
                $fathername,
                $mothername,
                $previous_class_information_json,
                $address_json,
                $mobile1,
                $mobile2,
                $email,
                $admissiontypeid,
                $branchid,
                $courseid,
                $course,
                $sectionid,
                $comments,
                $tuition_discount,
                $hostel_discount,
                $additionaldiscountgiven,
                $reservationid
               );
               
                return redirect()->to(base_url("agentdashboard/applicationDetails?id={$reservationid}"));
        }
        ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
        if ($_SESSION['agentdetails'] != null) {
            $reservationid = $_POST['id'];
            if ($_SESSION['agentdetails']->roleid == 1) {
                $additionaldiscountgiven = (isset($_POST['additionaldiscountgiven']) && $_POST['additionaldiscountgiven'] != "") ? $_POST['additionaldiscountgiven'] : NULL;
                 $reservationModel = new ReservationModel();
               $reservationModel->updateApplicationAdditionalFeeGiven(
                $reservationid,
                $additionaldiscountgiven
            );
             return redirect()->to(base_url("agentdashboard/applicationDetails?id={$reservationid}"));
                
            }
            $employeeid = (isset($_POST['employeeid']) && $_POST['employeeid'] != "") ? $_POST['employeeid'] : NULL;
            $discountrequested = (isset($_POST['discountrequested']) && $_POST['discountrequested'] != "") ? $_POST['discountrequested'] : NULL;
            $discountgiven = (isset($_POST['discountgiven']) && $_POST['discountgiven'] != "") ? $_POST['discountgiven'] : NULL;

            $reservationid = $_POST['id'];
           if($employeeid != null )
            {
                
                 $discountrequested = (isset($_POST['discountrequested2']) && $_POST['discountrequested2'] != "") ? $_POST['discountrequested2'] : NULL;
                $reservationModel = new ReservationModel();
               $reservationModel->updateApplicationEmployee(
                $reservationid,
                $discountrequested,
                $employeeid
            );
             return redirect()->to(base_url("agentdashboard/applicationDetails?id={$reservationid}"));
            } 
            
               if($_SESSION['agentdetails']->roleid == 15)
               {
                 $reservationModel = new ReservationModel();
                $reservationModel->updateApplicationFee(
                $reservationid,
                $discountrequested,
                $employeeid
            );
            
            return redirect()->to(base_url("agentdashboard/applicationDetails?id={$reservationid}"));
               }elseif($_SESSION['agentdetails']->roleid != 15)
               {
                   
                    if($discountgiven !=null && $discountrequested !=null){
                   $reservationModel = new ReservationModel();
                $reservationModel->updateApplicationFeeGiven(
                $reservationid,
                $discountgiven,
                $discountrequested
                );
                $discountgiven = $discountgiven;
                if ($discountgiven != 0) {
                     $helperModel = new HelperModel();
                $helperModel->add_ApplicationdiscountLog($discountgiven, $reservationid);
               
                $reservationstatusid = $_POST['reservationstatusid'];
             
                $html = file_get_contents(base_url("payments/print_applicationdiscountreceipt?userid={$reservationid}&batchid=3"));
                $paymentsModel = new PaymentsModel();
			    $paymentsModel->htmltopdf($html, 'save', $reservationid, 'R');
                $StudentDetailS = $reservationModel->getApplicationDetails($reservationid);

                $comm = new Comm();
                $data[0] = $StudentDetailS->mobile1;
                $data[1] = $StudentDetailS->name;
                $data[2] = $StudentDetailS->application_ukey;
                $data[3] = $discountgiven;
                $data[4] = "rb.gy/o0uabr?p=" . $reservationid;
                $comm->sendSMS("concession", $data);
                }
               // exit();
           // return redirect()->to(base_url("agentdashboard/applicationDetails?id={$reservationid}"));
               }
            
            $reservationid = $_POST['id'];

           
           // $tuition_discount = (isset($_POST['tuition_discount']) && $_POST['tuition_discount'] != "") ? $_POST['tuition_discount'] : NULL;

            $reservationstatusid = $_POST['reservationstatusid'];
            $reservationModel = new ReservationModel();
            $applicationDetail = $reservationModel->getApplicationDetails($reservationid);
            
           // $previous_discount = $applicationDetail->tuition_discount;
            $tuition_discount1 = $_POST['tuition_discount'];
            $tuition_discount2 = $_POST['tuition_discount1'];
            $comments = $_POST['comments'];
            $reservationModel->updateApplication(
                $reservationid,
                $tuition_discount1,
                $tuition_discount2,
                $comments,
                $reservationstatusid
            );
            
            if($reservationstatusid==4)
            {
                
                $StudentDetailS = $reservationModel->getApplicationDetails($reservationid);
                
                
            }
            $amount = 1 * 1250000 ;
            $description = "Payment Link";
            $userid = $reservationid;
             $invoiceid = '';
                 if ($userid != null && $amount != null) {
                $razorpayModel = new RazorpayModel();
                 $db = db_connect();
                $query1 = $db->query("select * from payment_gateway where status=1");
            $results =$query1->getResult();
           
                if($results[0]->name=="CCAvenue"){
                $unique = uniqid();
                $orderid = "cc_".uniqid();
                $short_url = "https://rb.gy/f8etkd?cc=".$unique;
                $razorpayModel->save_applicationpayment_link($userid,$invoiceid, 4, '', $orderid, $amount / 100, $short_url, 'issued','ccavenue',$unique);
                     
                $StudentDetailS = $reservationModel->getApplicationDetails($reservationid);

                $comm = new Comm();
                $data[0] = $StudentDetailS->mobile1;
                $data[1] = $StudentDetailS->name;
                $data[2] = $StudentDetailS->application_ukey;
                $data[3] = $StudentDetailS->branchname;
                $data[4] = $short_url;
                $comm->sendSMS("Feelink", $data); 
            }else if($results[0]->name=="Razorpay"){
                    $api = new Api($this->key, $this->secret);
                    $link = $api->invoice->create(
                        array(
                            'type' => 'link',
                            'amount' => $amount,
                            'description' => $description
                        )
                    );
                    $razorpayModel = new RazorpayModel();
                    $razorpayModel->save_applicationpayment_link($userid,$invoiceid, 4, $link->id, $link->order_id, $amount / 100, $link->short_url, $link->status,'razorpay','');
                
                $StudentDetailS = $reservationModel->getApplicationDetails($reservationid);

                $comm = new Comm();
                $data[0] = $StudentDetailS->mobile1;
                $data[1] = $StudentDetailS->name;
                $data[2] = $StudentDetailS->application_ukey;
                $data[3] = $StudentDetailS->branchname;
                $data[4] = $link->short_url;
                $comm->sendSMS("Feelink", $data);
                }else
                {
                    
                }
            }

            }
           return redirect()->to(base_url("agentdashboard/applicationDetails?id={$reservationid}"));
            
        } else {
            return redirect()->to(base_url('home/login'));
        }
    }
    
    public function ret_status_changed()
    {
         $db = db_connect();
        //get hidden values in variables
    	$id = $_POST['id'];
    	$status = $_POST['retstatus'];
       
     $reservationModel = new ReservationModel();
                $reservationModel->updateRETstatus($id, $status);
        return redirect()->to(base_url('agentdashboard/Applications'));
    }
    public function version()
    {
        if ($_SESSION['userdetails'] == null) {
			return redirect()->to(base_url());
		} else {
            $data['page_name'] = 'version';

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();
    
            return view('loggedinuser/index.php', $data);
		}
    }
    public function spintly()
    {
        $db = db_connect();
        $homemodel = new HomeModel();
        $data_array =  array(
            "pagination"        => array(
                "page"         => 1,
                "perPage"        => 10000
          ),
            "filters"         => array(
                  "start"         => '2022-09-03 00:00:00 +05:30',
                  "end"        => '2022-09-03 23:59:59 +05:30'
            ),
      );
       // $defaultjson = ('{"filters":{"start":"2022-09-01 00:00:00 +05:30","end":"2022-08-31 23:59:59 +05:30"},"pagination":{"page":1,"perPage":30000}}');
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.spintly.com/v2/organisationManagement/integrator/organisations/964/accessHistory",
        CURLOPT_POSTFIELDS => json_encode($data_array),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 100,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJzY29wZSI6ImNsaWVudHM6YWxsIiwic3ViIjo5NjQsImlhdCI6MTY1ODcyNjU0NSwiZXhwIjoxNjY2NTAyNTQ1fQ.Ml-f6SbvYEi3qJbqrY9RhygnLxskqxfrLKZJh-ZnSEyjJ6UwL5o9_XDitNeN0YqedHt8gqj-hEMhaCOBg_Cegy4u8APRu1Z8alfLruKnAb2LIqaQi_2p_gM7mF0-TyjPZ5nytxj0nhn4SMvy42QdV7mWxBFZZKldV9LW8qpsihj5bii_6W3zrjwNB6S8pCn1_3zH74Qa9F3uemrW1zYBjwkQ-9h5uGL86X5WMbZW4xr7Ib8HzUGikiyiIa_7kdtNP0KBZpoJEVkeACmp0flG63cUrSKazSpBWu2uUJjtF5KnGV2v6OUjQfpLyZWqcqgqPPuYa8Znw9HjUbMTidZXnHapPepM6U7KzOpahyXKe5QBN6C1SAoe1F3tgmKzZUEws6YKmEdE-xyOJHjsGtPmq6zwWwRkGOhPurneChztyK2PiEfZdJj3D7gFs1Q-C4RtN89Cj68DjDF9r0tqvKILTbeRovnivwUxVuE0Eon8QbXXdHSLkz312tr3ITHbzjHE'
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $data = json_decode($response);
        foreach($data->message->accessHistory as $key=>$d)
        {
           $attendanceData =	$homemodel->updateattendance($d->user->employeeCode);
           $code = $d->user->employeeCode;
            $dat = $d->accessedAt;
            $date1 = date('d/m/Y h:i:s', $dat);
            $query1 = $db->query("select employeeid from employeedetails where employeeid='$code'");
            $query2 = $db->query("select applicationnumber from studentdetails where applicationnumber='$code' or reservation_ukey='$code'");
                $results =$query1->getResult();
                
                $results1 = $query2->getResult();
                if (count($results) > 0) 
                {
                    
                    $db->query("insert into daily_punchdata set employee_code='$code',punch_date='$date1'");
                }elseif(count($results1) > 0)
                {
                    $code = $results1[0]->applicationnumber;
                     $db->query("insert into daily_punchdata_students set student_code='$code',punch_date='$date1',mcid=0");
                }
            
            
        }
    }
    public function ccavenue()
    {
        $order_id = $_POST['order_id'];
        $trackingid = $_POST['trackingid'];;
        $db = db_connect();
        $db->query("update applicationpayment_links set status='paid' where orderid='$order_id'");
        
        $paymentsModel = new PaymentsModel();
                $paymentLink = $paymentsModel->getApplicationPaymentLinkByOrderId($order_id);
               

                $userid = $paymentLink->userid;
                $batchid = $paymentLink->batchid;
                
                $paymenttypeid = 11;
                $paymentamount = $paymentLink->amount;
                $paymentdate = date("Y-m-d");
                $otherdetails = $trackingid;
                $paymentcollectedby = 1;
                $paymentstatusid = 1;
                $batchid = $paymentLink->batchid;
                
                $helperModel = new HelperModel();
                $batch = $helperModel->get_batch()->year;
                $nextpaymentid = $helperModel->get_paymentidcounter();

                $paymentid = "RMDA-" . $batch . "-" . str_pad($nextpaymentid, 6, '0', STR_PAD_LEFT);

                $paymentsModel = new PaymentsModel();
                $result = $paymentsModel->addApplicationPayment($paymentid, $userid, $paymentamount, $paymentdate, $paymenttypeid, $otherdetails, $paymentcollectedby, $paymentstatusid, $batchid, "Booking Amount");

                    $nextpaymentid = $helperModel->set_paymentidcounter();
                

               // $html = file_get_contents(base_url("payments/print_applicationreceipt?paymentid={$paymentid}&batchid=3"));
              //  $paymentsModel->htmltopdf($html, 'save', $paymentid, 'R');
                $razorpayModel = new RazorpayModel();
              
                $razorpayModel->update_application_status($userid);
                $reservationModel = new ReservationModel();
                $studentDetails = $reservationModel->getApplicationDetails($userid, $batchid);
                
                $comm = new Comm();
                $data[0] = $studentDetails->mobile1;
                $data[1] = $paymentamount;
                $data[2] = $studentDetails->application_ukey;
                // $data[3] = base_url("receipt_files/{$paymentid}.pdf");
                $data[3] = "https://rb.gy/geapsq?id=" . $studentDetails->applicationid;
                $data[4] = $studentDetails->name;
                $data[5] = $studentDetails->branchname;

                $comm->sendSMS("ApplicationPaymentConfirm", $data);


                $reservationModel = new ReservationModel();
                $studentDetails = $reservationModel->getApplicationDetails($userid, $batchid);
                $usersModel = new UsersModel();
                $reservationModel = new ReservationModel();
                $reservationid = $studentDetails->applicationid;
               
                $PaymentDetail = $reservationModel->getApplicationPaymentDetailsByReservationPaymentId($reservationid);
                $reservationModel = new ReservationModel();
                $StudentDetail = $reservationModel->getApplicationDetails($reservationid);
                $reservation_ukey = $StudentDetail->application_ukey;
                $name = $StudentDetail->name;
                $dateofbirth = $StudentDetail->dateofbirth;
                $genderid = $StudentDetail->genderid;
                $nationalityid = $StudentDetail->nationalityid;
                $religionid = $StudentDetail->religionid;
                $categoryid = $StudentDetail->categoryid;
                $studentaadhaar = $StudentDetail->studentaadhaar;

                $fathername = $StudentDetail->fathername;
                $mothername = $StudentDetail->mothername;
                $parentoccupation = $StudentDetail->parentoccupation;
                $visitorname = $StudentDetail->visitorname;
                $relationwithstudent = $StudentDetail->relationwithstudent;
                $visitornumber = $StudentDetail->visitornumber;

                $PreviousClassesInfo = json_decode($StudentDetail->previous_class_information);
                if ($PreviousClassesInfo != "") {
                    foreach ($PreviousClassesInfo as $classInfo) {
                        $classInfo = $classInfo;
                    }
                }

                $previous_class_information = [];
                $class = [];
                $class['class'] = 'PCI';
                $class['school'] = $classInfo->school;
                $class['board'] = $classInfo->board;
                $class['place'] = $classInfo->place;
                $class['grade'] = $classInfo->grade;
                $class['hallticketNo'] = $classInfo->hallticketNo;
                array_push($previous_class_information, $class);
                $Address = json_decode($StudentDetail->address);
                $permanentAddress = $Address->permanent;
                $address = [];
                $permanent['door_street'] = $permanentAddress->door_street;
                $permanent['village_mandal'] = $permanentAddress->village_mandal;
                $permanent['landmark'] = $permanentAddress->landmark;
                $permanent['city_town'] = $permanentAddress->city_town;
                $permanent['state'] = $permanentAddress->state;
                $permanent['district'] = $permanentAddress->district;
                $permanent['pin'] = $permanentAddress->pin;

                $address['permanent'] = $permanent;

                $mobile1 = $StudentDetail->mobile1;
                $mobile2 = $StudentDetail->mobile2;
                $email = $StudentDetail->email;

                $admissiontypeid = $StudentDetail->admissiontypeid;
                $courseid = $StudentDetail->courseid;
                $sectionid = 0;
                $secondlanguageid = $StudentDetail->secondlanguageid;
                $branchid = $StudentDetail->branchid;
                $comments = $StudentDetail->comments;
                $referredby = $StudentDetail->referredby == "" ? 0 : $StudentDetail->referredby;
                $batchid = $StudentDetail->batchid;

                $admissiondate = $StudentDetail->admissiondate;
                $reservationstatusid = 1;
                $scholarship = 0;
                $tuition_discount = $StudentDetail->tuition_discount;
                $tuition_discount1 = $StudentDetail->tuition_discount1;
                $hostel_discount = 0;
                $final_misc = 0;
                $created_by = 1;

                $discountrequested = $StudentDetail->discountrequested;
                $discountgiven = $StudentDetail->discountgiven;
                $discountapproved_by = $StudentDetail->discountapproved_by;
                $additionaldiscountgiven = $StudentDetail->additionaldiscountgiven;

                $address_json = json_encode($address);
                $previous_class_information_json = json_encode($previous_class_information);

                $reservationModel = new ReservationModel();
                $insertId = $reservationModel->addApplicationReservationUser(
                    $reservation_ukey,
                    $name,
                    $dateofbirth,
                    $genderid,
                    $nationalityid,
                    $religionid,
                    $categoryid,
                    $studentaadhaar,
                    $fathername,
                    $mothername,
                    $parentoccupation,
                    $visitorname,
                    $relationwithstudent,
                    $visitornumber,
                    $previous_class_information_json,
                    $address_json,
                    $mobile1,
                    $mobile2,
                    $email,
                    $admissiontypeid,
                    $branchid,
                    $courseid,
                    $sectionid,
                    $secondlanguageid,
                    $comments,
                    $referredby,
                    $batchid,
                    $admissiondate,
                    $reservationstatusid,
                    $scholarship,
                    $tuition_discount,
                    $tuition_discount1,
                    $hostel_discount,
                    $final_misc,
                    $discountrequested,
                    $discountgiven,
                    $discountapproved_by,
                    $additionaldiscountgiven,
                    $created_by
                );

                if ($insertId != 0) {

                    $paymenttypeid = $PaymentDetail[0]->paymenttypeid;
                    $paymentamount = $PaymentDetail[0]->paymentamount;
                    $paymentdate = $PaymentDetail[0]->paymentdate;
                    //$paymentdate = date('Y-m-d');
                    $otherdetails = $PaymentDetail[0]->otherdetails;
                    $paymentcollectedby = $PaymentDetail[0]->paymentcollectedby;
                    $paymentstatusid = 1;

                    $helperModel = new HelperModel();
                    $batch = $helperModel->get_batch()->year;
                    $nextpaymentid = $helperModel->get_paymentidcounter();

                    $reservation_paymentid = "RMD-" . $batch . "-" . str_pad($nextpaymentid, 6, '0', STR_PAD_LEFT);

                    $result = $reservationModel->addReservationPayment(
                        $reservation_paymentid,
                        $insertId,
                        $paymentamount,
                        $paymentdate,
                        $paymenttypeid,
                        $otherdetails,
                        $paymentcollectedby,
                        $paymentstatusid,
                        $batchid,
                        'Booking Amount'
                    );

                    
                        $nextpaymentid = $helperModel->set_paymentidcounter();
                    

                    $reservationModel->updateApplication1(
                        $reservationid
                    );
                }
    }
     public function dynamicpayment()
    {
            $unique = $_GET['cc'];
            $db = db_connect();
            $query2 = $db->query("select applicationpayment_links.status from applicationpayment_links where applicationpayment_links.uniqueid='$unique'");
            $results =$query2->getResult();
            if( $results[0]->status =="issued")
            {
                return redirect()->to('https://maidendropgroup.com/ccavenue/index.php?uniqueid='.$unique.'&invoice=1');
            }else
            {
                echo 444;
            }
            
            
    }
    public function updateapplicationdetails()
    {
        $reservationid = $this->request->getVar("applicationid");
        $reservationstatusid = $this->request->getVar("reservationstatusid");
            $reservationModel = new ReservationModel();
            $applicationDetail = $reservationModel->getApplicationDetails($reservationid);
            
           // $previous_discount = $applicationDetail->tuition_discount;
            $tuition_discount1 = $this->request->getVar("fee");
            $tuition_discount2 = $this->request->getVar("fee1");
            $comments = $this->request->getVar("comments");
            $reservationModel->updateApplication(
                $reservationid,
                $tuition_discount1,
                $tuition_discount2,
                $comments,
                $reservationstatusid
            );
            
            if($reservationstatusid==4)
            {
                $StudentDetailS = $reservationModel->getApplicationDetails($reservationid);
                
            }
            $amount = 1 * 1250000 ;
            $description = "Payment Link";
            $userid = $reservationid;
             $invoiceid = '';
                 if ($userid != null && $amount != null) {
                $razorpayModel = new RazorpayModel();
                 $db = db_connect();
                $query1 = $db->query("select * from payment_gateway where status=1");
            $results =$query1->getResult();
           
                if($results[0]->name=="CCAvenue"){
                $unique = uniqid();
                $orderid = "cc_".uniqid();
                $short_url = "https://rb.gy/f8etkd?cc=".$unique;
                $razorpayModel->save_applicationpayment_link($userid,$invoiceid, 4, '', $orderid, $amount / 100, $short_url, 'issued','ccavenue',$unique);
                     
                $StudentDetailS = $reservationModel->getApplicationDetails($reservationid);

                $comm = new Comm();
                $data[0] = $StudentDetailS->mobile1;
                $data[1] = $StudentDetailS->name;
                $data[2] = $StudentDetailS->application_ukey;
                $data[3] = $StudentDetailS->branchname;
                $data[4] = $short_url;
                $comm->sendSMS("Feelink", $data); 
            }else if($results[0]->name=="Razorpay"){
                    $api = new Api($this->key, $this->secret);
                    $link = $api->invoice->create(
                        array(
                            'type' => 'link',
                            'amount' => $amount,
                            'description' => $description
                        )
                    );
                    $razorpayModel = new RazorpayModel();
                    $razorpayModel->save_applicationpayment_link($userid,$invoiceid, 4, $link->id, $link->order_id, $amount / 100, $link->short_url, $link->status,'razorpay','');
                
                $StudentDetailS = $reservationModel->getApplicationDetails($reservationid);

                $comm = new Comm();
                $data[0] = $StudentDetailS->mobile1;
                $data[1] = $StudentDetailS->name;
                $data[2] = $StudentDetailS->application_ukey;
                $data[3] = $StudentDetailS->branchname;
                $data[4] = $link->short_url;
                $comm->sendSMS("Feelink", $data);
                }else
                {
                    
                }
            }
            $response = [
            "status" => true,
            "message" => "success",
        ];
        print_r(json_encode($response));
    }
}