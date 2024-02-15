<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\EmailModel;
use App\Models\HelperModel;
use App\Models\PaymentsModel;
use App\Models\UsersModel;
use App\Models\EtimeofficeModel;

class Etimeoffice extends BaseController
{
    public $session;
    public function __construct()
    {
        $session = session();
    }
    public function dailypunchdata($id = "")
    {
        $db = db_connect();
        if($id !="")
        {
            $date = date('Y-m-d',strtotime("-1 days"));
            $Fromdate = date('d/m/Y_00:00',strtotime("-1 days"));
            $Todate = date('d/m/Y_23:59',strtotime("-1 days"));
        }else
        {
            $date = date('d/m/Y');
            $Fromdate = date('d/m/Y_00:00');
            $Todate = date('d/m/Y_23:59');
        }
        $usersModel = new UsersModel();
        $date1 = date('d/m/Y');
       // $date1 = date('d/m/Y',strtotime("-1 days"));
        $att = $db->query("select SUBSTRING_INDEX(daily_punchdata.punch_date, ' ', 1) AS punchdate,id,employee_code,punch_date,mcid from daily_punchdata where is_read=0 and punch_date like '%$date1%'");
        $resultspunch = $att->getResult();
        foreach($resultspunch as $attendance)
        {
            $etimeofficemodel = new EtimeofficeModel();
            $etimeofficemodel->insertLogintime($attendance->employee_code, $attendance->punchdate,$attendance->mcid,$date,$id,$date1);
            $db->query("update daily_punchdata set is_read= 1 where id='{$attendance->id}'");
        }
        if($id !="")
        {
            // $db->query("truncate table daily_punchdata");
        }
    }
    
    public function dailypunchdatatesting($id = "")
    {
        $db = db_connect();
        if($id !="")
        {
            $date = date('Y-m-d',strtotime("-8 days"));
            $Fromdate = date('d/m/Y_00:00',strtotime("-8 days"));
            $Todate = date('d/m/Y_23:59',strtotime("-8 days"));
        }else
        {
            $date = '13-07-2023';
            $Fromdate = date('d/m/Y_00:00');
            $Todate = date('d/m/Y_23:59');
        }
       
        $usersModel = new UsersModel();
        $date1 = '13/07/2023';
        $att = $db->query("select SUBSTRING_INDEX(daily_punchdata.punch_date, ' ', 1) AS punchdate,id,employee_code,punch_date,mcid from daily_punchdata where employee_code='MDG0020' and punch_date like '%18/10%'");
        $resultspunch = $att->getResult();
        
        foreach($resultspunch as $attendance)
        {
            $etimeofficemodel = new EtimeofficeModel();
            $etimeofficemodel->insertLogintime($attendance->employee_code, $attendance->punchdate,$attendance->mcid,$date,$id,$date1);
            $db->query("update daily_punchdata set is_read= 1 where id='{$attendance->id}'");
        }
        if($id !="")
        {
            // $db->query("truncate table daily_punchdata");
        }
    }
    
    public function dailypunchdata1testing($id=0)
    {
        $db = db_connect();
         $date = date('Y-m-d',strtotime("- days"));
        // $Fromdate = date('d/m/Y_00:00',strtotime("-2 days"));
        // $Todate = date('d/m/Y_23:59',strtotime("-2 days"));
        $usersModel = new UsersModel();
        $date1 = date('d/m/Y',strtotime("-16 days"));
        $att = $db->query("select SUBSTRING_INDEX(daily_punchdata.punch_date, ' ', 1) AS punchdate,id,employee_code,punch_date,mcid from daily_punchdata where punch_date like '%$date1%' and employee_code='MDG0020'");
        $resultspunch = $att->getResult();
        
       
        foreach($resultspunch as $attendance)
        {
            $etimeofficemodel = new EtimeofficeModel();
            $etimeofficemodel->insertLogouttime($attendance->employee_code, $attendance->punchdate,$attendance->mcid,$date,$id);
            //$db->query("update daily_punchdata set is_read_out= 1 where id='{$attendance->id}'");
        }
           //  $db->query("truncate table daily_punchdata");
    }
    public function dailypunchdata1($id=0)
    {
        $db = db_connect();
         $date = date('Y-m-d',strtotime("-3 days"));
        // $Fromdate = date('d/m/Y_00:00',strtotime("-2 days"));
        // $Todate = date('d/m/Y_23:59',strtotime("-2 days"));
        $usersModel = new UsersModel();
        $date1 = date('d/m/Y',strtotime("-1 days"));
        $att = $db->query("select SUBSTRING_INDEX(daily_punchdata.punch_date, ' ', 1) AS punchdate,id,employee_code,punch_date,mcid from daily_punchdata where punch_date like '%$date1%'");
        
        $resultspunch = $att->getResult();
         
       
        foreach($resultspunch as $attendance)
        {
            $etimeofficemodel = new EtimeofficeModel();
            $etimeofficemodel->insertLogouttime($attendance->employee_code, $attendance->punchdate,$attendance->mcid,$date,$id);
            $db->query("update daily_punchdata set is_read_out= 1 where id='{$attendance->id}'");
        }
           //  $db->query("truncate table daily_punchdata");
    }
    public function testtime()
    {
       $date =  date('Y-m-d');
       $db = db_connect();
        $db->query("insert into student_attendance_details(date,user_id,status) values('$date',5580, 0)");
    }
        public function dailypunchdatastudentattendance()
    {
        $db = db_connect();
        
        $date = date('Y-m-d');
        $usersModel = new UsersModel();
        $StudentDetails = $usersModel->getAllStudentDetailsonenew();
        foreach($StudentDetails as $StudentDetail)
        {
		
                $db->query("insert into student_attendance_details(date,user_id,status) values('$date','$StudentDetail->userid', 0)");
			
        }
        $EmployeeDetails = $usersModel->getAllEmployeeDetails();
        foreach($EmployeeDetails as $EmployeeDetail)
        {
		
                $db->query("insert into employee_attendance(date,employee_id,status) values('$date','$EmployeeDetail->userid', 0)");
			
        }
    }
    public function dailypunchdatastudent($id = "")
    {
        $db = db_connect();
        if($id !="")
        {
            $date = date('Y-m-d',strtotime("-1 days"));
        }else
        {
            $date = '2023-07-13';
        }
       
        $date1 = date('d/m/Y');

        $att = $db->query("select SUBSTRING_INDEX(daily_punchdata_students.punch_date, ' ', 1) AS punchdate,id,student_code,punch_date,mcid from daily_punchdata_students where is_read=0 and punch_date like '%$date1%'");
        $resultspunch = $att->getResult();
        $i=0;
        foreach($resultspunch as $attendance)
        {
            $etimeofficemodel = new EtimeofficeModel();
            $etimeofficemodel->insertLogintimestudent($attendance->student_code, $attendance->punchdate,$attendance->mcid,$date,$id,$date1);
            $db->query("update daily_punchdata_students set is_read= 1 where id='{$attendance->id}'");
            
            $i++;
        }
        if($id !="")
        {
             $db->query("truncate table daily_punchdata_students");
        }
    }
    


    public function dailypunchdataold($id = "")
    {
        ini_set('max_execution_time', '300'); 
        $db = db_connect();
        for ($n = 21; $n <= 31; $n++) {
        if($n <= 9)
        {
            $date = "2022-03-0" . $n;
            $Fromdate = "0" . $n . "/03/2022_00:00"; //date('d/m/Y_00:00');
            $Todate = "0" . $n . "/03/2022_23:59"; //date('d/m/Y_23:59');
        }
        else{
            $date = "2022-03-" . $n;
            $Fromdate = $n . "/03/2022_00:00"; //date('d/m/Y_00:00');
            $Todate = $n . "/03/2022_23:59"; //date('d/m/Y_23:59');
        }
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "http://api.etimeoffice.com/api/DownloadPunchDataMCID?Empcode=ALL&FromDate=$Fromdate&ToDate=$Todate",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Basic cmVzb25hbmNlaHlkOnJlc29uYW5jZWh5ZDpSZXNvQDEyMzp0cnVlOg=='
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $data = json_decode($response);
        $usersModel = new UsersModel();
        $EmployeeDetails = $usersModel->getAllEmployeeDetails();
        foreach($EmployeeDetails as $EmployeeDetail)
        {
			$query1 = $db->query("select * from employee_attendance where employee_id='$EmployeeDetail->userid' and date='$date' ");
			$results = count($query1->getResult());
			if ($results == 0) 
            {
                $db->query("insert into employee_attendance(date,employee_id,status) values('$date','$EmployeeDetail->userid', 0)");
			}
        }
        foreach($data->PunchData as $attendance)
        {
            $etimeofficemodel = new EtimeofficeModel();
            $etimeofficemodel->insertPunchData($attendance->Empcode, $attendance->PunchDate,$attendance->mcid,$date,$id);
        }
        foreach($data->PunchData as $attendance)
        {
            $etimeofficemodel = new EtimeofficeModel();
            $etimeofficemodel->insertLogintime($attendance->Empcode, $attendance->PunchDate,$attendance->mcid,$date,$id);
        }

       // $db->query("truncate table daily_punchdata");
        }
    }


    public function centalizedpunchdata()
    {
        $Fromdate = date('d/m/Y_00:00',strtotime("-1 days"));
        $Todate = date('d/m/Y_23:59',strtotime("-1 days"));
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "http://api.etimeoffice.com/api/DownloadPunchDataMCID?Empcode=ALL&FromDate=$Fromdate&ToDate=$Todate",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Basic cmVzb25hbmNlaHlkOnJlc29uYW5jZWh5ZDpSZXNvQDEyMzp0cnVlOg=='
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $data = json_decode($response);
        // print_r($data);
        foreach($data->PunchData as $attendance)
        {
            $etimeofficemodel = new EtimeofficeModel();
            $etimeofficemodel->insertCentralPunchData($attendance->Empcode, $attendance->PunchDate,$attendance->mcid);
        }
    }
    public function absentDayscholar()
    {
        $db = db_connect();
        $date = date('Y-m-d');
        $usersModel = new UsersModel();
        $EmployeeDetails = $usersModel->getAbsentstudentsDayscholar($date);
        foreach($EmployeeDetails as $details){
           $userid = $details->userid;
          
           $att = $db->query("insert into absent_log (date,userid) values('$date',$userid)");
        $to = $details->mobile1;
      //  $to = 9154852727;
	        $template_id = "1707167211657719994";
            $entity_id = "1701159195824664328";
            $body = urlencode("Dear Parent, Your Ward {$details->name} bearing Roll No {$details->applicationnumber} is absent for Today classes. Regular Attendance is mandatory for effective learning. In Case of Any queries Please reach to branch team. Thanks Resonance - Hyderabad");
            $apiurl = "http://pwtpl.com/sms/V1/send-sms-api.php?apikey=dr7xJ6KiNJh7v9bk&senderid=MAIDEN&templateid=$template_id&entityid=$entity_id&number=$to&message=$body";

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $apiurl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET",
        )); 
        
        curl_exec($curl);
        
        curl_close($curl);
       }
       
    }
    public function lateDayscholar()
    {
        $db = db_connect();
        $date = date('Y-m-d');
        $usersModel = new UsersModel();
        $EmployeeDetails = $usersModel->getLatestudentsDayscholar($date);
        foreach($EmployeeDetails as $details){
           $userid = $details->userid;
           $time = $details->login_time;
           $att = $db->query("insert into absent_log (date,userid,status,is_late,login_time) values('$date',$userid,1,1,'$time')");
        $to = $details->mobile1;
      //$to = 7013315793;
	        $template_id = "1707169572170179288";
            $entity_id = "1701159195824664328";
            $body = urlencode("Dear Parent, Your Ward {$details->name} bearing Roll No {$details->applicationnumber} is late for Today class. Regular Attendance is mandatory for effective learning In Case of Any queries please reach to our admin team. Thank you, Resonance Hyderabad.");
            $apiurl = "http://pwtpl.com/sms/V1/send-sms-api.php?apikey=luyUJ7GzaUO0BNxp&senderid=RESOHY&templateid=$template_id&entityid=$entity_id&number=$to&message=$body";

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $apiurl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET",
        )); 
        
        curl_exec($curl);
        
        curl_close($curl);
       }
       
    }
    public function absentResdential()
    {
        $db = db_connect();
        $date = date('Y-m-d');
        $usersModel = new UsersModel();
        $EmployeeDetails = $usersModel->getAbsentstudentsResdential($date);
        foreach($EmployeeDetails as $details){
           $userid = $details->userid;
           $att = $db->query("insert into absent_log (date,userid) values('$date',$userid)");
        $to = $details->mobile1;
      //  $to = 9154852727;
	       $template_id = "1707167211657719994";
            $entity_id = "1701159195824664328";
            $body = urlencode("Dear Parent, Your Ward {$details->name} bearing Roll No {$details->applicationnumber} is absent for Today classes. Regular Attendance is mandatory for effective learning. In Case of Any queries Please reach to branch team. Thanks Resonance - Hyderabad");
            $apiurl = "http://pwtpl.com/sms/V1/send-sms-api.php?apikey=dr7xJ6KiNJh7v9bk&senderid=MAIDEN&templateid=$template_id&entityid=$entity_id&number=$to&message=$body";

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $apiurl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET",
        )); 
        
        curl_exec($curl);
        
        curl_close($curl);
       }
       
    }
    public function lateResdential()
    {
    //     $db = db_connect();
    //     $date = date('Y-m-d');
    //     $usersModel = new UsersModel();
    //     $EmployeeDetails = $usersModel->getLatestudentsResdential($date);
    //     foreach($EmployeeDetails as $details){
    //       $userid = $details->userid;
    //       $time = $details->login_time;
    //       $att = $db->query("insert into absent_log (date,userid,status,is_late,login_time) values('$date',$userid,1,1,'$time')");
    //     $to = $details->mobile1;
    //   //  $to = 9154852727;
	   //     $template_id = "1707169572170179288";
    //         $entity_id = "1701159195824664328";
    //         $body = urlencode("Dear Parent, Your Ward {$details->name} bearing Roll No {$details->applicationnumber} is late for Today class. Regular Attendance is mandatory for effective learning In Case of Any queries please reach to our admin team. Thank you, Resonance Hyderabad.");
    //         $apiurl = "http://pwtpl.com/sms/V1/send-sms-api.php?apikey=luyUJ7GzaUO0BNxp&senderid=RESOHY&templateid=$template_id&entityid=$entity_id&number=$to&message=$body";

    //     $curl = curl_init();
    //     curl_setopt_array($curl, array(
    //         CURLOPT_URL => $apiurl,
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_CUSTOMREQUEST => "GET",
    //     )); 
        
    //     curl_exec($curl);
        
    //     curl_close($curl);
    //   }
       
    }
    public function ping()
    {
       $host = '183.83.218.213'; 
        $port = 80; 
        $waitTimeoutInSeconds = 10; 
        $status = 0;
        if($fp = @fsockopen($host,$port,$errCode,$errStr,$waitTimeoutInSeconds)){   
         $status = 1;
        }
        if(!$fp) {
         $status = 0;
        }
       if($status == 0111)
       {
             $to = "8123540068,8885526751,9346112322,7997004444,9154852727,8977245573";
	        $template_id = "1707169164758399223";
            $entity_id = "1701159195824664328";
            $body = urlencode("The static IP system has been Turned Off. Please Turn On the static IP system - Resonance Hyderabad.
");
            $apiurl = "http://pwtpl.com/sms/V1/send-sms-api.php?apikey=luyUJ7GzaUO0BNxp&senderid=RESOHY&templateid=$template_id&entityid=$entity_id&number=$to&message=$body";

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $apiurl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET",
        )); 
        
       $response =  curl_exec($curl);
        
        curl_close($curl);
        $mobile = "8123540068";
        $amount= 1;
        $roll = 11;
        $url = 111;
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://backend.api-wa.co/campaign/yokr/api',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
            "apiKey": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY0ZDM1YzQ3NTdiNDJkMTA0NzFhNjBlNSIsIm5hbWUiOiJwdXJuYSIsImFwcE5hbWUiOiJBaVNlbnN5IiwiY2xpZW50SWQiOiI2NGQzNWM0NzU3YjQyZDEwNDcxYTYwZTAiLCJhY3RpdmVQbGFuIjoiTk9ORSIsImlhdCI6MTY5MTU3MzMxOX0.4AkHFTfGMUn9AP4q7tDAIHH0C5QUuXcsLfUOOW71AIg",
            "campaignName": "ip_update",
            "destination": "'.$mobile.'",
            "userName": "Shiva"
        }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        $mobile = "7997004444";
        $amount= 1;
        $roll = 11;
        $url = 111;
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://backend.api-wa.co/campaign/yokr/api',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
            "apiKey": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY0ZDM1YzQ3NTdiNDJkMTA0NzFhNjBlNSIsIm5hbWUiOiJwdXJuYSIsImFwcE5hbWUiOiJBaVNlbnN5IiwiY2xpZW50SWQiOiI2NGQzNWM0NzU3YjQyZDEwNDcxYTYwZTAiLCJhY3RpdmVQbGFuIjoiTk9ORSIsImlhdCI6MTY5MTU3MzMxOX0.4AkHFTfGMUn9AP4q7tDAIHH0C5QUuXcsLfUOOW71AIg",
            "campaignName": "ip_update",
            "destination": "'.$mobile.'",
            "userName": "Shiva"
        }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
               print_r($response);
               echo "Staic ip is Turned Off";
               }else
               {
                   echo "Staic ip Working";
               }
            }
           public function differenceInHours($startdate,$enddate){
        	$starttimestamp = strtotime($startdate);
        	$endtimestamp = strtotime($enddate);
        	$difference = abs($endtimestamp - $starttimestamp)/3600;
        	return $difference;
    }
    public function autoregularize()
    {
        $db = db_connect();
        $date = date('Y-m-d',strtotime("-1 days"));
        
        $usersModel = new UsersModel();
        $StudentDetails = $usersModel->getEmployeeToRegularize($date);
        foreach( $StudentDetails as $res)
        {
            if($res->userid){
                
            }
            $login =  $res->loginTime;
            $logout =  $res->logoutTime;
           $hours_difference = $this->differenceInHours($login,$logout);
            
           if($hours_difference >= 9)
           {
                if($res->isLatelogin == 1)
                {
                    $db = db_connect();
                    $db->query("update employee_attendance set loginregularised= 1,lateLoginReason='Auto Regularized' where attendance_id='{$res->attendance_id}'");
                }
                if($res->isEarlyLogout == 1)
                {
                    $db->query("update employee_attendance set 	logoutregularised= 1,earlyLogoutReason='Auto Regularized' where attendance_id='{$res->attendance_id}'");
                }
           }
        }
    }
    
    public function AutoEarlyLogout()
    {
        $db = db_connect();
        $date = date('Y-m-d',strtotime("-1 days"));
         $date1 = date('Y-m-d H:i:d');
        $usersModel = new UsersModel();
        $StudentDetails = $usersModel->getEmployeeToAutoEarlyLogout($date);
       
        foreach( $StudentDetails as $res)
        {
            $db = db_connect();
            $db->query("update employee_attendance set isEarlyLogout= 1,AutoEarlyLogouttime='$date1' where attendance_id='{$res->attendance_id}'");
        }
    }
    
   
}