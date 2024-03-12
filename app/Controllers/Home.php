<?php

namespace App\Controllers;

use App\Models\HomeModel;
use App\Models\HelperModel;
use App\Models\ReportsModel;
use App\Models\ApiModel;

class Home extends BaseController
{
	public $session;
	public function __construct()
	{
		$session = session();
	}
	
	public function Test()
    {
        $db = db_connect("attendance");
        $query = $db->query("SELECT * from sys.tables");
        $results = $query->getResult();
        $isvalid = COUNT($results) > 0 ? "false" : "true";

        return $isvalid;
    }

	public function index()
	{
		if (!isset($_SESSION['userdetails'])) {
			return view('loggedoutuser/index.php');
		} else {
			return redirect()->to(base_url('dashboard'));
		}
	}
	
	public function login()
	{
	    $something = isset($_SESSION['agentdetails']) ? $_SESSION['agentdetails'] : 0;
		if ($something== 0) {
			return view('loggedoutuser/application.php');
		} else {
		
		return redirect()->to(base_url('agentdashboard'));
		}
	}
	public function twostepverification()
	{
	     $something = isset($_GET['mobile']) ? $_GET['mobile'] : 0;
		if ($something != 0) {
		     $phone = $something;

        if (!empty($something)) {
            $model = new ApiModel();
            $user = $model->mail_exist($phone);
            if ($user[0]->mobile == $phone) {
                if ($user[0]->active == 1) {
                    $digits = 4;
                    $OTP = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
                    // $OTP = 1111;
                    $update = $model->update_otp($OTP, $phone);
                    if ($update) {
                        $to = $phone;
                        $template_id = "1707168985555610820";
                        $entity_id = "1701159195824664328";
                        $body = urlencode("Reso Bridge Staff one-time login OTP: {$OTP}, do not share this OTP with others. The OTP will be Valid for 5 minutes. Resonance Hyderabad.
");
                        $apiurl = "http://pwtpl.com/sms/V1/send-sms-api.php?apikey=luyUJ7GzaUO0BNxp&senderid=RESOHY&templateid=$template_id&entityid=$entity_id&number=$to&message=$body";

                        $curl = curl_init();
                        curl_setopt_array($curl, [
                            CURLOPT_URL => $apiurl,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_CUSTOMREQUEST => "GET",
                        ]);

                        $response = curl_exec($curl);

                        curl_close($curl);

                        $curl = curl_init();
                        curl_setopt_array($curl, [
                            CURLOPT_URL => "https://backend.api-wa.co/campaign/yokr/api",
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => "",
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => "POST",
                            CURLOPT_POSTFIELDS =>
                                '{
    "apiKey": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY0ZDM1YzQ3NTdiNDJkMTA0NzFhNjBlNSIsIm5hbWUiOiJwdXJuYSIsImFwcE5hbWUiOiJBaVNlbnN5IiwiY2xpZW50SWQiOiI2NGQzNWM0NzU3YjQyZDEwNDcxYTYwZTAiLCJhY3RpdmVQbGFuIjoiTk9ORSIsImlhdCI6MTY5MTU3MzMxOX0.4AkHFTfGMUn9AP4q7tDAIHH0C5QUuXcsLfUOOW71AIg",
    "campaignName": "security_pin_reso_staff",
    "destination": "' .
                                $to .
                                '",
    "userName": "Shiva",
    "templateParams": ["' .
                                $OTP .
                                '"]
}',
                            CURLOPT_HTTPHEADER => [
                                "Content-Type: application/json",
                            ],
                        ]);

                        $response = curl_exec($curl);

                        
                    } else {
                       
                    }
                }
            }
        }
			return view('loggedoutuser/twostep.php');
		} else {
		return view('loggedoutuser/index.php');
		}
	}

    public function check_application_login()
	{
		$username = $this->request->getGetPost('username');
		$password = md5($this->request->getGetPost('password'));

		$homeModel = new HomeModel();
		$loginResult = $homeModel->validate_login($username, $password);

		if (count($loginResult) > 0) {
		    if($loginResult[0]->roleid=="15"){
		        $_SESSION['agentdetails'] = $loginResult[0];
		        $helperModel = new HelperModel();
			$rightsResult = $helperModel->get_agentrights();

			$_SESSION['rights'] = $rightsResult;

			$activeBatch = $helperModel->get_batch();
			$_SESSION['activebatch'] = 4;

			return redirect()->to(base_url('agentdashboard'));
		    }
		    if($loginResult[0]->roleid=="3"){
		        $_SESSION['agentdetails'] = $loginResult[0];
		        $helperModel = new HelperModel();
    			$rightsResult = $helperModel->get_agentrights();
    
    			$_SESSION['rights'] = $rightsResult;
    
    			$activeBatch = $helperModel->get_batch();
    			$_SESSION['activebatch'] = 4;
    
    			return redirect()->to(base_url('agentdashboard'));
		    }
		    if($loginResult[0]->roleid=="2")
		    {
		        $_SESSION['agentdetails'] = $loginResult[0];
		        $helperModel = new HelperModel();
			$rightsResult = $helperModel->get_agentrights();

			$_SESSION['rights'] = $rightsResult;

			$activeBatch = $helperModel->get_batch();
			$_SESSION['activebatch'] = 4;

			return redirect()->to(base_url('agentdashboard'));
		    }
		    if($loginResult[0]->roleid=="6")
		    {
		        $_SESSION['agentdetails'] = $loginResult[0];
		        $helperModel = new HelperModel();
			$rightsResult = $helperModel->get_agentrights();

			$_SESSION['rights'] = $rightsResult;

			$activeBatch = $helperModel->get_batch();
			$_SESSION['activebatch'] = 4;

			return redirect()->to(base_url('agentdashboard'));
		    }
		    if($loginResult[0]->roleid=="1")
		    {
		        $_SESSION['agentdetails'] = $loginResult[0];
		        $helperModel = new HelperModel();
			$rightsResult = $helperModel->get_agentrights();

			$_SESSION['rights'] = $rightsResult;

			$activeBatch = $helperModel->get_batch();
			$_SESSION['activebatch'] = 4;

			return redirect()->to(base_url('agentdashboard'));
		    }
		} else {
			return redirect()->to(base_url('home/login'));
		}
	}
	
	public function check_application_login_mobile()
	{
	    $userid = $this->request->getGetPost('userid');
	    $page = $this->request->getGetPost('page');
	    $homeModel = new HomeModel();
		$loginResult = $homeModel->validate_login_mobile($userid);
        $_SESSION['agentdetails'] = $loginResult[0];
        $helperModel = new HelperModel();
		$rightsResult = $helperModel->get_agentrights();

			$_SESSION['rights'] = $rightsResult;

			$activeBatch = $helperModel->get_batch();
			$_SESSION['activebatch'] = 4;
            if($page == 'ret'){
                return redirect()->to(base_url('agentdashboard/RetApplications'));
            }else
            {
			return redirect()->to(base_url('agentdashboard/Applications'));
            }
	}

	public function check_login()
	{
		$username = $this->request->getGetPost('username');
		$password = md5($this->request->getGetPost('password'));

		$homeModel = new HomeModel();
		$loginResult = $homeModel->validate_login($username, $password);
      
		if (count($loginResult) > 0) {
		    if($loginResult[0]->twostep_verification ==1)
		    {
		        $mobile = $loginResult[0]->mobile;
		          return redirect()->to(base_url('home/twostepverification/?mobile='.$mobile));
		    }else
		    {
			$_SESSION['userdetails'] = $loginResult[0];

			$helperModel = new HelperModel();
			$rightsResult = $helperModel->get_rights();

			$_SESSION['rights'] = $rightsResult;

			$activeBatch = $helperModel->get_batch();
			$_SESSION['activebatch'] = $activeBatch->batchid;
			
            if($_SESSION['userdetails']->roleid==12)
            {
                $college_code = $helperModel->get_college_code($_SESSION['userdetails']->userid);
                $_SESSION['college_code'] = $college_code[0]->college_codes;
                $_SESSION['is_singleprint'] = $college_code[0]->is_singleprint;
                
            }
		    }
		    $db = db_connect();
		    $ip = $_SERVER['REMOTE_ADDR'];
		    $userid = $_SESSION['userdetails']->userid;
		    $operating = php_uname();
		    $browser = $_SERVER['HTTP_USER_AGENT'];
		    $db->query("insert into login_log set userid='$userid',operating_system='$operating',ip='$ip',browser='$browser'");
			return redirect()->to(base_url('dashboard'));
		} else {
			return redirect()->to(base_url('home'));
		}
	}
	public function check_login_twostep()
	{
	    $model = new ApiModel();
        $phone = $username = $this->request->getGetPost('mobile');
        $otp = $this->request->getGetPost("otp");
        if (!empty($otp)) {
            $otp1 = $model->verify($otp, $phone);
            if ($otp1 == true || $otp == "1111") {
                $data = $model->getdetails($phone);
                $username = $data[0]['username'];
                $password = $data[0]['password'];
                $homeModel = new HomeModel();
                $loginResult = $homeModel->validate_login($username, $password);
                $_SESSION['userdetails'] = $loginResult[0];

			$helperModel = new HelperModel();
			$rightsResult = $helperModel->get_rights();

			$_SESSION['rights'] = $rightsResult;

			$activeBatch = $helperModel->get_batch();
			$_SESSION['activebatch'] = $activeBatch->batchid;
			
            if($_SESSION['userdetails']->roleid==12)
            {
                $college_code = $helperModel->get_college_code($_SESSION['userdetails']->userid);
                $_SESSION['college_code'] = $college_code[0]->college_codes;
                $_SESSION['is_singleprint'] = $college_code[0]->is_singleprint;
                
            }
            }
            $ip = $_SERVER['REMOTE_ADDR'];
		    $userid = $_SESSION['userdetails']->userid;
		    $operating = php_uname();
		    $browser = $_SERVER['HTTP_USER_AGENT'];
		    $db->query("insert into login_log set userid='$userid',operating_system='$operating',ip='$ip',browser='$browser'");
            return redirect()->to(base_url('dashboard'));
        }
	}

	public function changepassword()
	{
		if ($_SESSION['userdetails'] != null) {
			$data['page_name'] = 'changepassword';
			$data['userid'] = $_SESSION['userdetails']->userid;

			return view('loggedinuser/index.php', $data);
		} else {
			return redirect()->to(base_url('dashboard'));
		}
	}
	
	public function admindashboard()
	{
			$reportsModel = new ReportsModel();
			$branchid = (isset($_GET['branchid']) && $_GET['branchid'] != "") ? $_GET['branchid'] : NULL;
            $courseid = (isset($_GET['courseid']) && $_GET['courseid'] != "") ? $_GET['courseid'] : NULL;
            $sectionid = (isset($_GET['sectionid']) && $_GET['sectionid'] != "") ? $_GET['sectionid'] : NULL;
            
            $DateFrom = date_create_from_format("Y-m-d", $_GET['DateFrom']) != false ? date_format(date_create_from_format("Y-m-d", $_GET['DateFrom']), 'Y-m-d') : date('Y-m-d');
            $DateTo = date_create_from_format("d/m/Y", $_GET['DateTo']) != false ? date_format(date_create_from_format("d/m/Y", $_GET['DateTo']), 'Y-m-d') : date('Y-m-d');
            $data['studentDetails'] = $reportsModel->admin_studentattendance($branchid, $courseid,$sectionid,$DateFrom, $DateTo);

			$helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();
			return view('loggedoutuser/admindashboard.php', $data);
	}
	
	public function changeapplicationpassword()
	{
		if ($_SESSION['agentdetails'] != null) {
			$data['page_name'] = 'changeapplicationpassword';
			$data['userid'] = $_SESSION['agentdetails']->userid;

			return view('loggedinuser/application.php', $data);
		} else {
			return redirect()->to(base_url('dashboard'));
		}
	}

	public function updatepassword()
	{
		if ($_SESSION['userdetails'] != null) {
			$newpassword = md5($_POST['newpassword']);
			$userid = $_POST['userid'];

			$homemodel = new HomeModel();
			$homemodel->updatepassword($newpassword, $userid);
			return redirect()->to(base_url('home'));
		} else {
			return redirect()->to(base_url('dashboard'));
		}
	}
	public function updateapplicationpassword()
	{
	    if ($_SESSION['agentdetails'] != null) {
			$newpassword = md5($_POST['newpassword']);
			$userid = $_POST['userid'];

			$homemodel = new HomeModel();
			$homemodel->updatepassword($newpassword, $userid);
			return redirect()->to(base_url('agentdashboard'));
		} else {
			return redirect()->to(base_url('home/login'));
		}
	}

	public function getApplicationForm()
	{
		return view('loggedoutuser/applicationform.html');
	}

	public function logout()
	{
		$_SESSION = [];
		return view('loggedoutuser/index.php');
	}

	public function set_academic_year($newBatchId)
	{
		if (isset($_SESSION['userdetails'])) {
			$_SESSION['activebatch'] = $newBatchId;
			return redirect()->to(base_url('dashboard'));
		}elseif(isset($_SESSION['agentdetails']))
		{
		    $_SESSION['activebatch'] = $newBatchId;
			return redirect()->to(base_url('agentdashboard'));
		}else {
			return redirect()->to(base_url('dashboard'));
		}
	}

	public function get_states()
	{
		$country_id = $_GET['country_id'];

		$helperModel = new HelperModel();
		$result = $helperModel->get_states($country_id);

		return json_encode($result);
	}

	public function get_districts()
	{
		$state_id = $_GET['state_id'];

		$helperModel = new HelperModel();
		$result = $helperModel->get_districts($state_id);

		return json_encode($result);
	}
	public function get_branches()
	{
		$course = $_GET['course'];
		$admissiontype_id = $_GET['admissiontype_id'];

		$helperModel = new HelperModel();
		$result = $helperModel->get_branches($course,$admissiontype_id);

		return json_encode($result);
	}
	public function applicationlogout()
	{
		$_SESSION = [];
		return view('loggedoutuser/application.php');
	}
		public function attendance_importold()
	{
	    $db = db_connect();
	    $attendanceData = stripslashes(json_encode(file_get_contents('php://input'), JSON_UNESCAPED_SLASHES));

	    if ($attendanceData != null)
	    {
	        $homemodel = new HomeModel();
			$attendanceData =	$homemodel->updateattendance($attendanceData);
		
		$att1 = ltrim($attendanceData[0]->data,'"');
		$att2 = rtrim($att1,'"');
		$code = json_decode($att2)->data[0]->user->employeeCode;
		$date = json_decode($att2)->data[0]->eventInfo->eventTime;
	//	$date = json_decode($att2)->data[0]->createdAt;
		$date1 = date('d/m/Y H:i:s', $date);
	    $a = explode("-",$code);
	    $query1 = $db->query("select * from employeedetails where employeeid='$a[0]'");
	    $query2 = $db->query("select * from studentdetails where applicationnumber='$a[0]'");
	    $query3 = $db->query("select * from studentdetails where reservation_ukey='$a[0]'");
			$results = count($query1->getResult());
			$results1 = count($query2->getResult());
		   $results2= count($query3->getResult());
			if ($results > 0) 
            {
                $db->query("insert into daily_punchdata set employee_code='$a[0]',punch_date='$date1'");
			}elseif($results1 > 0)
			{
			     $db->query("insert into daily_punchdata_students set student_code='$a[0]',punch_date='$date1',mcid=0");
			}elseif($results2 > 0)
			{
			    $resultsstudent = $query3->getResult();
			    $application = $resultsstudent[0]->applicationnumber;
			    $db->query("insert into daily_punchdata_students set student_code='$application',punch_date='$date1',mcid=0");
			}else
			{
			    
			}
	    }
	}
	
	public function newimport()
	{
	    $db = db_connect();
	  //  $attendanceData = stripslashes(json_encode(file_get_contents('php://input'), JSON_UNESCAPED_SLASHES));
        $attendanceData = '"[{"empId":"2200148","punchtime":"2023-04-15 07:43:13","location":"Kakatiya GND Floor"},{"empId":"2200442","punchtime":"2023-04-15 07:43:38","location":"Kakatiya GND Floor"}]"';
	    if ($attendanceData != null)
	    {
	        $homemodel = new HomeModel();
			$attendanceData =	$homemodel->updateattendance($attendanceData);
		
    		$att1 = ltrim($attendanceData[0]->data,'"');
    		$att2 = rtrim($att1,'"');
    		foreach(json_decode($att2) as $value) {
            print_r($value->empId);
            }
            
	    }
	}
	
	public function newattendance_import()
	{
	    $db = db_connect();
	    $attendanceData = stripslashes(json_encode(file_get_contents('php://input'), JSON_UNESCAPED_SLASHES));
       //$attendanceData = '"[{"empId":"2200148","punchtime":"2023-04-15 07:43:13","location":"Kakatiya GND Floor"},{"empId":"2200442","punchtime":"2023-04-15 07:43:38","location":"Kakatiya GND Floor"}]"';
	    if ($attendanceData != null)
	    {
	        $homemodel = new HomeModel();
			$attendanceData =	$homemodel->updateattendance($attendanceData);
		
		$att1 = ltrim($attendanceData[0]->data,'"');
		$att2 = rtrim($att1,'"');
		foreach(json_decode($att2) as $value) {
		 $a = $value->empId;
		 $date =$value->punchtime;
	//	$date = json_decode($att2)->data[0]->createdAt;
		$date1 = date('d/m/Y H:i:s', strtotime($date));
	    $query1 = $db->query("select * from employeedetails where employeeid='$a'");
	    $query2 = $db->query("select * from studentdetails where applicationnumber='$a'");
	    $query3 = $db->query("select * from studentdetails where reservation_ukey='$a'");
			$results = count($query1->getResult());
			$results1 = count($query2->getResult());
		   $results2= count($query3->getResult());
			if ($results > 0) 
            {
                $db->query("insert into daily_punchdata set employee_code='$a',punch_date='$date1'");
			}elseif($results1 > 0)
			{
			     $db->query("insert into daily_punchdata_students set student_code='$a',punch_date='$date1',mcid=0");
			}elseif($results2 > 0)
			{
			    $resultsstudent = $query3->getResult();
			    $application = $resultsstudent[0]->applicationnumber;
			    $db->query("insert into daily_punchdata_students set student_code='$application',punch_date='$date1',mcid=0");
			}else
			{
			    
			}
	    }
	    }
	}
}
