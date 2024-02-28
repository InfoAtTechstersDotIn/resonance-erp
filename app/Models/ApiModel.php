<?php

namespace App\Models;

use CodeIgniter\Model;

class ApiModel extends Model
{

	public function getdetails($phone)
	{
		$db = db_connect();
		$query = $db->query("select * from employeedetails join users on employeedetails.userid = users.userid  where mobile='" . $phone . "'");
		$results = $query->getResultArray();
		$db->close();

		return $results;
	}
	public function getguestdetails($phone)
	{
	    $db = db_connect();
		$query = $db->query("select * from guest_user where phone='" . $phone . "'");
		$results = $query->getResultArray();
		$db->close();

		return $results;
	}
	public function getstudentdetails($phone)
	{
		$db = db_connect();
		$query = $db->query("SELECT studentdetails.userid,studentdetails.firebase,studentdetails.name,studentdetails.applicationnumber,studentdetails.profile_image,studentdetails.fathername,studentdetails.mothername,studentdetails.dateofbirth,studentdetails.studentaadhaar,studentdetails.address,studentdetails.mobile1,studentdetails.mobile2,branchlookup.branchname,branchlookup.branch_address,courselookup.coursename,branchlookup.branchid,student_class_relation.admissiontypeid,student_class_relation.batchid,sectionlookup.sectionname from users 
                             JOIN studentdetails ON users.userid = studentdetails.userid
                             JOIN student_class_relation ON student_class_relation.studentid = studentdetails.userid LEFT JOIN branchlookup ON student_class_relation.branchid = branchlookup.branchid LEFT JOIN courselookup ON student_class_relation.courseid = courselookup.courseid LEFT JOIN sectionlookup ON student_class_relation.sectionid = sectionlookup.sectionid where (mobile1='" . $phone . "' or mobile2='" . $phone . "') and student_class_relation.batchid=3");
		$results = $query->getResultArray();
		$db->close();

		return $results;
	}
	public function getInvoices($userid)
    {
         $db = db_connect();
        $query = $db->query("SELECT invoiceid,invoice FROM `invoices` join feestructurelookup ON invoices.feesid = feestructurelookup.feesid where userid=$userid and invoices.batchid=3 and feestructurelookup.feetype <> 'Application Fee' group by invoiceid");
         $results = $query->getResult();
        $db->close();

        return $results;
    }
	public function getstudentdetails1($applicationnumber)
	{
		$db = db_connect();
		$query = $db->query("SELECT studentdetails.userid,studentdetails.firebase,studentdetails.name,studentdetails.applicationnumber,studentdetails.profile_image,studentdetails.fathername,studentdetails.mothername,studentdetails.dateofbirth,studentdetails.studentaadhaar,studentdetails.address,studentdetails.mobile1,studentdetails.mobile2,branchlookup.branchname,branchlookup.branch_address,courselookup.coursename,branchlookup.branchid,student_class_relation.admissiontypeid,student_class_relation.batchid,sectionlookup.sectionname from users 
                             JOIN studentdetails ON users.userid = studentdetails.userid
                             JOIN student_class_relation ON student_class_relation.studentid = studentdetails.userid LEFT JOIN branchlookup ON student_class_relation.branchid = branchlookup.branchid LEFT JOIN courselookup ON student_class_relation.courseid = courselookup.courseid LEFT JOIN sectionlookup ON student_class_relation.sectionid = sectionlookup.sectionid where applicationnumber='$applicationnumber' and student_class_relation.batchid=3");
		$results = $query->getResultArray();
		$db->close();

		return $results;
	}
	public function getuserdetais($id)
	{
		$db = db_connect();
		$query = $db->query("select * from employeedetails where userid='" . $id . "'");
		$results = $query->getResult();
		$db->close();

		return $results;
	}
	 public function validate_login($username, $password)
    {
        $db = db_connect();
        $query = $db->query("SELECT * FROM users 
            JOIN roleslookup on users.roleid = roleslookup.roleid 
            JOIN employeedetails on employeedetails.userid = users.userid 
            WHERE (username='{$username}' OR employeeid='{$username}') and password='{$password}' and is_delete=0");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
	public function mail_exist($phone)
	{
		$db = db_connect();
		$query = $db->query("select * from employeedetails where mobile='" . $phone . "' and is_delete=0");
		$results = $query->getResult();
		$db->close();
		return $results;
	}
	public function mail_exist_guest($phone)
	{
	    $db = db_connect();
		$query = $db->query("select * from guest_user where phone='" . $phone . "' and is_delete=0 ");
		$results = $query->getResult();
		$db->close();
		return $results;
	}
	public function mobile_exist($phone)
	{
		$db = db_connect();
		$query = $db->query("select * from studentdetails where mobile1='" . $phone . "' or mobile2='" . $phone . "'");
		$results = $query->getResult();
		$db->close();
		return $results;
	}
	
	public function mobile_exist_new($phone,$applicationnumber)
	{
		$db = db_connect();
		$query = $db->query("select * from studentdetails where applicationnumber='$applicationnumber' and (mobile1='" . $phone . "' or mobile2='" . $phone . "') ");
		$results = $query->getResult();
		$db->close();
		return $results;
	}
	public function applicationnumber_exist($applicationnumber)
	{
    	$db = db_connect();
		$query = $db->query("select * from studentdetails where applicationnumber='" . $applicationnumber . "'");
		$results = $query->getResult();
		$db->close();
		return $results;
	}

	public function update_otp($otp, $phone)
	{
		$db = db_connect();
		$update = $db->query("UPDATE `employeedetails` set otp ='" . $otp . "' where mobile='$phone'");
		return $update ? true : false;
		$db->close();
	}
	public function update_guest_otp($otp, $phone)
	{
	    	$db = db_connect();
		$update = $db->query("UPDATE `guest_user` set otp ='" . $otp . "' where phone='$phone'");
		return $update ? true : false;
		$db->close();
	}
	public function update_parentotp($otp, $id)
	{
		$db = db_connect();
		$update = $db->query("UPDATE `studentdetails` set otp ='" . $otp . "' where userid='$id'");
		return $update ? true : false;
		$db->close();
	}
	
		public function update_studentotp($otp, $phone)
	{
		$db = db_connect();
		$update = $db->query("UPDATE `studentdetails` set otp ='" . $otp . "' where mobile1='$phone'");
		return $update ? true : false;
		$db->close();
	}
	
	public function update_fcm($firebase, $phone)
	{
		$db = db_connect();
		$update = $db->query("UPDATE `employeedetails` set firebase ='" . $firebase . "' where mobile='$phone'");
		return $update ? true : false;
		$db->close();
	}
	public function update_parentfcm($firebase, $phone)
	{
	    $db = db_connect();
		$update = $db->query("UPDATE `studentdetails` set firebase ='" . $firebase . "' where userid='$phone'");
		return $update ? true : false;
		$db->close();
	}
	public function verify($otp, $phone)
	{
		$db = db_connect();
		$query = $db->query("select * from employeedetails where otp='$otp' and mobile='$phone' order by userid desc limit 1");
		$results = count($query->getResult());
		if ($results == 1) {
			$uniid = uniqid();
			$db->query("update employeedetails set status='1',uniid='$uniid' where mobile='$phone'");
			return true;
		} else {
			return false;
		}
		$db->close();
	}
	public function verifyguest($otp, $phone)
	{
	   
		$db = db_connect();
		$query = $db->query("select * from guest_user where otp='$otp' and phone='$phone' order by id desc limit 1");
		$results = count($query->getResult());
		if ($results > 0) {
			return true;
		} else {
			return false;
		}
		$db->close();
	}
	public function verifyparentotp($otp, $phone,$applicationnumber)
	{
		$db = db_connect();
		$query = $db->query("select * from studentdetails where otp='$otp' and applicationnumber='$applicationnumber' and (mobile1='$phone' or mobile2='$phone') order by userid desc limit 1");
		$results = count($query->getResult());
		if ($results == 1) {
			return true;
		} else {
			return false;
		}
		$db->close();
	}
	public function verifystudentotp($otp, $phone,$applicationnumber)
	{
		$db = db_connect();
		$query = $db->query("select * from studentdetails where otp='$otp' and applicationnumber='$applicationnumber' and (mobile1='$phone' or mobile2='$phone') order by userid desc limit 1");
		$results = count($query->getResult());
		if ($results == 1) {
			return true;
		} else {
			return false;
		}
		$db->close();
	}
	public function verifylatlong($latitude, $longitude, $userid)
	{
		$db = db_connect();
		$query = $db->query("select * from employeedetails join branchlookup on employeedetails.branchid= branchlookup.branchid where employeedetails.userid='$userid' and (6371 * acos(cos(radians($latitude)) * cos(radians(branchlookup.latitude)) * cos(radians(branchlookup.longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians(branchlookup.latitude)))) < '10'");
		$results = count($query->getResult());
		if ($results == 1) {
			return true;
		} else {
			return false;
		}
	}
	public function AddAttendance($date, $userid, $type)
	{
		$currentTimestamp = date_create(date('Y-m-d H:i:s'));

		if ($type == 'login') {
			$db = db_connect();

			$helperModel = new HelperModel();
			$loginTime = $helperModel->get_settings('loginTime');
			$lateLenienceInMinutes = $helperModel->get_settings('lateLenienceInMinutes');

			$loginTimestamp = date_create(date('Y-m-d') . ' ' . $loginTime);

			date_add($loginTimestamp, date_interval_create_from_date_string("{$lateLenienceInMinutes} Min"));

			if ($currentTimestamp > $loginTimestamp) {
				$status = 2;
			} else {
				$status = 1;
			}

			$query = $db->query("select * from employeedetails");
			$result = $query->getResult();
			$query1 = $db->query("select * from employee_attendance where employee_id='$userid' and date='$date' ");
			$results = count($query1->getResult());
			if ($results == 0) {
				foreach ($result as $res) {
					$db->query("insert into employee_attendance(date,employee_id,status) values('$date','$res->userid', 0)");
				}
			}

			$status = $db->query("update employee_attendance set status= {$status}, loginTime = '{$currentTimestamp->format('Y-m-d H:i:s')}' where employee_id='$userid' and date='$date' ");
		} else if ($type == 'logout') {
			$db = db_connect();

			$helperModel = new HelperModel();
			$logoutTime = $helperModel->get_settings('logoutTime');

			$logoutTimestamp = date_create(date('Y-m-d') . ' ' . $logoutTime);

			if ($currentTimestamp < $logoutTimestamp) {
				$status = $db->query("update employee_attendance set logoutTime = '{$currentTimestamp->format('Y-m-d H:i:s')}', isEarlyLogout=1 where employee_id='$userid' and date='$date' ");
			} else {
				$status = $db->query("update employee_attendance set logoutTime = '{$currentTimestamp->format('Y-m-d H:i:s')}' where employee_id='$userid' and date='$date' ");
			}
		}
	}
	public function AttendanceToday($userid, $date)
	{
		$db = db_connect();
		$query1 = $db->query("select * from employeedetails join employee_attendance on employeedetails.userid = employee_attendance.employee_id  where employee_attendance.employee_id='$userid' and employee_attendance.date='$date' ");
		$results = $query1->getResult();
		if (count($results) > 0) {
			return $results;
		} else {
			return false;
		}
	}
	public function StudentAttendanceToday($userid, $date)
	{
		$db = db_connect();
		$query1 = $db->query("select * from studentdetails join student_attendance_details on studentdetails.userid = student_attendance_details.user_id  where student_attendance_details.user_id='$userid' and student_attendance_details.date='$date' ");
		$results = $query1->getResult();
		if (count($results) > 0) {
			return $results;
		} else {
			return false;
		}
	}
	public function getattendance($attendanceid)
	{
		$db = db_connect();
		$query1 = $db->query("select * from employeedetails join employee_attendance on employeedetails.userid = employee_attendance.employee_id  where employee_attendance.attendance_id='$attendanceid'");
		$results = $query1->getResult();
		if (count($results) > 0) {
			return $results;
		} else {
			return false;
		}
	}
	public function MyAttendancelist($userid)
	{
		$db = db_connect();
		$query1 = $db->query("select * from employeedetails join employee_attendance on employeedetails.userid=employee_attendance.employee_id  where employeedetails.userid='$userid' order by employee_attendance.attendance_id desc");
		$results = $query1->getResult();
		return $results;
	}
	public function MyAttendancelistFilter($userid,$DateFrom,$DateTo)
	{
        	$db = db_connect();
		$query1 = $db->query("select * from employeedetails join employee_attendance on employeedetails.userid=employee_attendance.employee_id  where employeedetails.userid='$userid' and employee_attendance.date >='{$DateFrom}' and employee_attendance.date <='{$DateTo}' order by employee_attendance.attendance_id desc");
		$results = $query1->getResult();
		return $results;

	}
	
	public function Myannouncement()
	{
		$db = db_connect();
		$query1 = $db->query("select * from announcement order by id desc");
		$results = $query1->getResult();
		return $results;
	}
	
	public function MyHolidays($admissiontypeid,$batchid)
	{
	    $db = db_connect();
		$query1 = $db->query("select * from holidays where admissiontype='$admissiontypeid' and batchid='$batchid' order by id desc");
		$results = $query1->getResult();
		return $results;
	}
	
	public function getInvoiceDetails($userid)
    {
        $db = db_connect();
        $query = $db->query("SELECT InvoiceDetails.*, InvoiceDetails.userid, InvoiceDetails.TotalValue, InvoiceDetails.invoice,InvoiceDetails.invoiceid, InvoiceDetails.name, InvoiceDetails.branchname, InvoiceDetails.admissiontypename, InvoiceDetails.coursename, 
                             PaymentDetails.TotalPaid, (InvoiceDetails.TotalValue - PaymentDetails.TotalPaid) AS RemainingAmount FROM
                                (SELECT student_class_relation.*, SUM(invoices.feesvalue) as TotalValue, invoices.invoice,invoices.invoiceid, studentdetails.userid, studentdetails.name, branchlookup.branchname, sectionlookup.sectionname, admissiontypelookup.admissiontypename, courselookup.coursename 
                                 from invoices JOIN users ON invoices.userid = users.userid 
                                 JOIN studentdetails ON studentdetails.userid = users.userid
                                 JOIN student_class_relation ON student_class_relation.studentid = studentdetails.userid
                                 JOIN feestructurelookup ON invoices.feesid = feestructurelookup.feesid
                                 JOIN branchlookup ON student_class_relation.branchid = branchlookup.branchid
                                 JOIN admissiontypelookup ON student_class_relation.admissiontypeid = admissiontypelookup.admissiontypeid
                                 JOIN courselookup ON student_class_relation.courseid = courselookup.courseid
                                 JOIN sectionlookup ON student_class_relation.sectionid = sectionlookup.sectionid
                                 WHERE student_class_relation.batchid=invoices.batchid and  feestructurelookup.feetype != 'Application Fee'
                                 and invoices.batchid = 3
                                 GROUP BY invoices.invoiceid) InvoiceDetails
                                 LEFT JOIN
                                 (SELECT SUM(payments.paymentamount) as TotalPaid, payments.userid,payments.batchid FROM payments JOIN users ON payments.userid = users.userid where payments.batchid=3 GROUP BY payments.userid,payments.batchid) PaymentDetails ON InvoiceDetails.userid = PaymentDetails.userid AND InvoiceDetails.batchid = PaymentDetails.batchid WHERE InvoiceDetails.userid=$userid");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
	public function MyAttendanceliststudent($userid)
	{
		$db = db_connect();
		$query1 = $db->query("select * from studentdetails join student_attendance_details on studentdetails.userid=student_attendance_details.user_id  where studentdetails.userid='$userid' order by student_attendance_details.id desc");
		$results = $query1->getResult();
		return $results;
	}
	public function MyAttendancelistStudentFilter($userid,$DateFrom,$DateTo)
	{
        	$db = db_connect();
		$query1 = $db->query("select * from studentdetails join student_attendance_details on studentdetails.userid=student_attendance_details.user_id  where studentdetails.userid='$userid' and student_attendance_details.date >='{$DateFrom}' and student_attendance_details.date <='{$DateTo}' order by student_attendance_details.id desc");
		$results = $query1->getResult();
		return $results;

	}
	
	public function Leaverequestlist($branchid,$userid)
    {
        $db = db_connect();
        $query = $db->query("SELECT LR.*, ED.name,ED.employeeid,ED.firebase,ED.totalleaves FROM leave_requests LR 
                             JOIN employeedetails ED ON LR.userid = ED.userid 
                             JOIN users U ON U.userid = ED.userid
                             JOIN roleslookup RL ON RL.roleid = U.roleid
                             WHERE LR.isapproved IS NULL AND 
                             ED.branchid IN ({$branchid})  AND ED.report_person={$userid}");

        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function StudentLeaverequestlist($branchid)
    {
        $db = db_connect();
        $query = $db->query("SELECT LR.*, SD.name,SD.applicationnumber,SD.firebase FROM leave_requests LR 
                             JOIN studentdetails SD ON LR.userid = SD.userid 
                             JOIN student_class_relation ON student_class_relation.studentid = SD.userid
                             JOIN users U ON U.userid = SD.userid
                             JOIN roleslookup RL ON RL.roleid = U.roleid
                             WHERE LR.isapproved IS NULL AND student_class_relation.batchid=3 AND
                             student_class_relation.branchid IN ({$branchid})");

        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function concernslist($student_id)
    {
        $db = db_connect();
        $query = $db->query("select concerns.*,CC.name as categoryname, CSC.name as subcategoryname from concerns join concern_subcategory CC on concerns.category=CC.id 
        join concern_subcategory CSC on concerns.sub_category=CSC.id where concerns.student_id={$student_id}");

        $results = $query->getResult();
        $db->close();

        return $results;
    }
    
    public function Studentconcernslist($Userid)
    {
        $db = db_connect();
        $query = $db->query("select concerns.*,CC.name as categoryname,SD.name,SD.fathername,SD.applicationnumber,branchlookup.branchname, CSC.name as subcategoryname from concerns join concern_subcategory CC on concerns.category=CC.id 
        join concern_subcategory CSC on concerns.sub_category=CSC.id JOIN studentdetails SD ON concerns.student_id = SD.userid 
                             JOIN student_class_relation ON student_class_relation.studentid = SD.userid JOIN branchlookup ON student_class_relation.branchid = branchlookup.branchid where concerns.assigned_to ='{$Userid}'");

        $results = $query->getResult();
        $db->close();

        return $results;
    }
    
    
    public function getAllEmployeeDetails($userid)
    {
        $db = db_connect();
        $query = $db->query("SELECT employeedetails.mobile, employeedetails.leavespermonth, employeedetails.package,
                             employeedetails.employeeid, users.username, users.roleid, employeedetails.branchid, users.userid,
                             employeedetails.name,employeedetails.firebase, roleslookup.rolename from users JOIN roleslookup ON roleslookup.roleid = users.roleid 
                             JOIN employeedetails ON users.userid = employeedetails.userid 
                             where employeedetails.report_person = '{$userid}' and employeedetails.active=1");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

	public function recordReason($attendanceid, $reason, $type)
	{
		if ($type == 'login') {
			$db = db_connect();
			$update = $db->query("UPDATE employee_attendance set lateLoginReason ='" . $reason . "' where attendance_id='$attendanceid'");
			return $update ? true : false;
			$db->close();
		}else
		{
		    	$db = db_connect();
			$update = $db->query("UPDATE employee_attendance set earlyLogoutReason ='" . $reason . "' where attendance_id='$attendanceid'");
			return $update ? true : false;
			$db->close();
		}
	}
	public function AddEmployee($name, $email,$phone,$password)
	{
	    	$db = db_connect();
	        $data['email'] = $email;
    		$data['phone'] = $phone;
    		$data['name'] = $name;
    		$data['password'] = md5($password);
    		$builder = $db->table('guest_user');
    		$builder->insert($data);
    		$insertId = $db->insertID();
    		if ($insertId == 0) {
    			return false;
    		}else{
    		    return true;
    		}
	}
	public function updatepass($intime,$form_request_id)
	{
		$db = db_connect();
		$update = $db->query("UPDATE `form_requests` set indata ='" . $intime . "' where form_request_id='$form_request_id'");
		return $update ? true : false;
		$db->close();
	}
    public function totalleaves($userid)
	{
		$db = db_connect();
		
		 $query1 = $db->query("SELECT * FROM `employeedetails` where userid = '$userid'");
            $results = $query1->getResult();
            $total = $results[0]->totalleaves;
            
            $db->close();

        return $total;
	}
	public function saveLeaveRequest($from, $to, $reason, $userid,$days)
	{
		$db = db_connect();
	    $query1 = $db->query("SELECT * FROM `employeedetails` where userid = '$userid'");
	    
	     if(count($query1->getResult()) > 0){
        $results = $query1->getResult();
        $total = $results[0]->totalleaves;
		if($total >=$days)
		{
    		$data['leavefrom'] = $from;
    		$data['leaveto'] = $to;
    		$data['userid'] = $userid;
    		$data['reason'] = $reason;
            $data['days'] = $days;
    		$builder = $db->table('leave_requests');
    		$builder->insert($data);
    		$insertId = $db->insertID();
    		if ($insertId == 0) {
    			return false;
    		}else{
                $query1 = $db->query("SELECT * FROM `employeedetails` where userid = '$userid'");
                $results = $query1->getResult();
                $total = $results[0]->totalleaves;
                $data1['totalleaves'] = $total - $days;
                $builder = $db->table('employeedetails');
                $builder->where('userid', $userid);
                $builder->update($data1);
    			return true;
    		}
		}else
		{
		    	$data['leavefrom'] = $from;
    		$data['leaveto'] = $to;
    		$data['userid'] = $userid;
    		$data['reason'] = $reason;
            $data['days'] = $days;
    		$builder = $db->table('leave_requests');
    		$builder->insert($data);
    		$insertId = $db->insertID();
    		if ($insertId == 0) {
    			return false;
    		}else{
    		    return true;
    		}
		}
	     }else
	     {
	         	$data['leavefrom'] = $from;
    		$data['leaveto'] = $to;
    		$data['userid'] = $userid;
    		$data['reason'] = $reason;
            $data['days'] = $days;
    		$builder = $db->table('leave_requests');
    		$builder->insert($data);
    		$insertId = $db->insertID();
    		if ($insertId == 0) {
    			return false;
    		}else{
    		    return true;
    		}
	     }
	}
	
	public function saveconcern($from, $to, $details,$name, $student_id,$category,$sub_category)
	{
		    $db = db_connect();
        	$digits = 4;
            $uniqid = rand(pow(10, $digits-1), pow(10, $digits)-1);
	        $data['concern_id'] = $uniqid;
    		$data['from_time'] = $from;
    		$data['to_time'] = $to;
    		$data['student_id'] = $student_id;
    		$data['details'] = $details;
    		$data['image'] = $name;
    		$data['category'] = $category;
    		$data['sub_category'] = $sub_category;
    		$data['status'] = 'Pending';
    		$builder = $db->table('concerns');
    		$builder->insert($data);
    		$insertId = $db->insertID();
    		if ($insertId == 0) {
    			return false;
    		}else{
    			return true;
    		}
		
	}

	public function getLeaveRequests($userid)
	{
		$db = db_connect();
		$query1 = $db->query("select * from leave_requests where userid='$userid' ");
	//	$query1 = $db->query("select * from leave_requests where userid='$userid' AND (leaveto > CURDATE() OR leaveto = CURDATE())");
		$results = $query1->getResult();
		return $results;
	}

	public function deleteLeaveRequest($leaverequestid)
	{
		$db = db_connect();
		$query1 = $db->query("SELECT * FROM `leave_requests` where leaverequestid = '$leaverequestid'");
        $results = $query1->getResult();
        $userid = $results[0]->userid;
        $days = $results[0]->days;
        $query2 = $db->query("SELECT * FROM `employeedetails` where userid = '$userid'");
        $results1 = $query2->getResult();
        $total = $results1[0]->totalleaves;
        $data1['totalleaves'] = $total + $days;
        $builder = $db->table('employeedetails');
        $builder->where('userid', $userid);
        $builder->update($data1);
		$query1 = $db->query("DELETE FROM leave_requests where leaverequestid='$leaverequestid'");
		$results = $query1->getResult();
		return $results;
	}
	public function update_employee_attendance($attendanceId, $regularised)
    {
        $db = db_connect();
        $data['loginregularised'] = $regularised == "1" ? 1 : 0;

        $builder = $db->table('employee_attendance');
        $builder->where('attendance_id', $attendanceId);
        $builder->update($data);
        $db->close();
    }
    public function update_employee_attendancelogout($attendanceId, $regularised)
    {
        $db = db_connect();
        $data['logoutregularised'] = $regularised == "1" ? 1 : 0;

        $builder = $db->table('employee_attendance');
        $builder->where('attendance_id', $attendanceId);
        $builder->update($data);
        $db->close();
    }
    public function getOutpassRequests($userid,$branchid)
    {
        $db = db_connect();
		$query1 = $db->query("SELECT Fr.*, 
		REPLACE(JSON_EXTRACT(data, \"$[0].Todate\"), '\"', '') AS Todate,
		REPLACE(JSON_EXTRACT(data, \"$[0].FromDate\"), '\"', '') AS FromDate,
		REPLACE(JSON_EXTRACT(data, \"$[0].Purpose\"), '\"', '') AS Purpose,
		REPLACE(JSON_EXTRACT(data, \"$[0].gardian\"), '\"', '') AS accompanied_by,
		Sd.*, Cr.name AS CreatedBy, Up.Name as UpdatedBy FROM form_requests Fr
                            JOIN studentdetails Sd on Fr.user_id = Sd.userid
                            JOIN student_class_relation scr on Sd.userid = scr.studentid
                            left JOIN employeedetails Cr on Fr.created_by = Cr.userid
                            LEFT JOIN employeedetails Up on Fr.updated_by = Up.userid
                            WHERE Fr.form_type='StudentOutPass' and  scr.branchid IN ({$branchid}) and scr.batchid IN (select batchlookup.batchid from batchlookup where batchid=3) order by Fr.form_request_id desc");
		$results = $query1->getResult();
		return $results;
    }
    public function getStudentOutpassRequests($studentid)
    {
         $db = db_connect();
		$query1 = $db->query("SELECT Fr.*, 
		REPLACE(JSON_EXTRACT(data, \"$[0].Todate\"), '\"', '') AS Todate,
		REPLACE(JSON_EXTRACT(data, \"$[0].FromDate\"), '\"', '') AS FromDate,
		REPLACE(JSON_EXTRACT(data, \"$[0].Purpose\"), '\"', '') AS Purpose,
		REPLACE(JSON_EXTRACT(data, \"$[0].gardian\"), '\"', '') AS accompanied_by,
		Sd.*, Cr.name AS CreatedBy, Up.Name as UpdatedBy FROM form_requests Fr
                            JOIN studentdetails Sd on Fr.user_id = Sd.userid
                            JOIN student_class_relation scr on Sd.userid = scr.studentid
                            left JOIN employeedetails Cr on Fr.created_by = Cr.userid
                            LEFT JOIN employeedetails Up on Fr.updated_by = Up.userid
                            WHERE Fr.form_type='StudentOutPass' and  Fr.user_id={$studentid} and scr.batchid IN (select batchlookup.batchid from batchlookup where batchid=3) order by Fr.form_request_id desc");
		$results = $query1->getResult();
		return $results;
    }
    public function getOutpass($form_request_id)
    {
        $db = db_connect();
		$query1 = $db->query("SELECT Fr.*, 
		REPLACE(JSON_EXTRACT(data, \"$[0].Todate\"), '\"', '') AS Todate,
		REPLACE(JSON_EXTRACT(data, \"$[0].FromDate\"), '\"', '') AS FromDate,
		REPLACE(JSON_EXTRACT(data, \"$[0].Purpose\"), '\"', '') AS Purpose,
		REPLACE(JSON_EXTRACT(data, \"$[0].gardian\"), '\"', '') AS accompanied_by,
		Sd.*, Cr.name AS CreatedBy, Up.Name as UpdatedBy FROM form_requests Fr
                            JOIN studentdetails Sd on Fr.user_id = Sd.userid
                            JOIN student_class_relation scr on Sd.userid = scr.studentid
                            JOIN employeedetails Cr on Fr.created_by = Cr.userid
                            LEFT JOIN employeedetails Up on Fr.updated_by = Up.userid
                            WHERE Fr.form_type='StudentOutPass' and  Fr.form_request_id={$form_request_id}");
		$results = $query1->getResult();
		return $results;
    }
    public function getAllStudentDetails($branchid)
    {
        $db = db_connect();
        $query = $db->query("SELECT studentdetails.userid,studentdetails.name,studentdetails.applicationnumber,studentdetails.fathername,studentdetails.mobile1,studentdetails.mobile2 from users 
                             JOIN studentdetails ON users.userid = studentdetails.userid
                             JOIN student_class_relation ON student_class_relation.studentid = studentdetails.userid
                             LEFT JOIN branchlookup ON student_class_relation.branchid = branchlookup.branchid
                             LEFT JOIN admissiontypelookup ON student_class_relation.admissiontypeid = admissiontypelookup.admissiontypeid
                             LEFT JOIN courselookup ON student_class_relation.courseid = courselookup.courseid
                             LEFT JOIN sectionlookup ON student_class_relation.sectionid = sectionlookup.sectionid
                             LEFT JOIN applicationstatuslookup ON studentdetails.applicationstatusid = applicationstatuslookup.applicationstatusid
                             LEFT JOIN genderlookup ON studentdetails.genderid = genderlookup.genderid
                             WHERE student_class_relation.batchid IN (select batchlookup.batchid from batchlookup where batchid=3) and branchlookup.branchid IN ({$branchid} )");
        $results = $query->getResult();
        $db->close();
        return $results;
    }
    public function getoutpassid($branchid)
    {
        $db = db_connect();
        $query = $db->query("SELECT gatepassid FROM branchlookup where branchid ={$branchid}");
        $result = $query->getRow();
        $db->close();
        return $result->gatepassid;
    }
    public function set_getoutpassid($branchid)
    {
        $current = $this->getoutpassid($branchid);
        $nextpaymentid = $current + 1;
        $gatepassid = $nextpaymentid;
        $db = db_connect();
	    $update = $db->query("UPDATE branchlookup set gatepassid ='" . $gatepassid . "' where branchid='$branchid'");
       
    }
    public function videoslist()
    {
        $db = db_connect();
		$query1 = $db->query("select * from youtubevideos");
		$results = $query1->getResult();
		return $results;
    }
    public function help($branchid)
    {
        $db = db_connect();
		$query1 = $db->query("SELECT * FROM employeedetails JOIN users on employeedetails.userid=users.userid where employeedetails.designation = 'Principal' and employeedetails.branchid='$branchid'");
		$results = $query1->getResult();
		return $results;
    }
    public function promotion_image()
    {
        $db = db_connect();
		$query1 = $db->query("select * from promotion_images order by id desc limit 1");
		$results = $query1->getResult();
		return $results;
    }
    public function Concerncategorylist()
    {
        $db = db_connect();
		$query1 = $db->query("select * from concern_subcategory where category_id=0");
		$results = $query1->getResult();
		return $results;
    }
    public function ConcernSubcategorylist($categoryid)
    {
        $db = db_connect();
        $query = $db->query("SELECT * FROM concern_subcategory where category_id ={$categoryid}");
        $result = $query->getResult();
        $db->close();
        return $result;
    }
    public function getPaymentDetails($invoiceid)
    {
        $db = db_connect();
        $query = $db->query("SELECT sum(paymentamount) as sum from payments
                             WHERE payments.invoice='$invoiceid'
                             and payments.batchid=3 
                             ");
        $results = $query->getResult();
        $db->close();
        return $results;
    }
    
    public function Working_day()
	{
		$db = db_connect();
		$query1 = $db->query("SELECT COUNT(*) AS working_day FROM business_calendar where is_student_workingday = 1 AND YEAR(date) = YEAR(CURDATE()) AND date <= CURDATE() AND date >='2023-04-10'");
		$results = $query1->getResult();
		return $results;
	}
	
	public function Total_present($userid)
	{
		$db = db_connect();
		$query1 = $db->query("SELECT COUNT(*) AS Total_present FROM `business_calendar` JOIN student_attendance_details ON business_calendar.date = student_attendance_details.date where student_attendance_details.status = 1 AND business_calendar.is_student_workingday = 1 AND student_attendance_details.user_id = $userid AND business_calendar.date >='2023-04-10'");
		$results = $query1->getResult();
		return $results;
	}
	
	public function Total_absent($userid)
	{
		$db = db_connect();
		$query1 = $db->query("SELECT COUNT(*) AS Total_absent FROM `business_calendar` JOIN student_attendance_details ON business_calendar.date = student_attendance_details.date where student_attendance_details.status = 0 AND business_calendar.is_student_workingday = 1 AND student_attendance_details.user_id = $userid AND business_calendar.date >='2023-04-10'");
		$results = $query1->getResult();
		return $results;
	}
	public function Total_leaves($userid)
	{
		$db = db_connect();
		$query1 = $db->query("SELECT COUNT(*) AS Total_leaves FROM `leave_requests` WHERE isapproved = 1 AND userid = $userid");
		$results = $query1->getResult();
		return $results;
	}
	public function MonthWorking_day($DateFrom,$DateTo)
	{
	    $DateTo = date('Y-m-d');
		$db = db_connect();
		$query1 = $db->query("SELECT COUNT(*) AS working_day FROM business_calendar where is_student_workingday = 1 AND date between '$DateFrom' and '$DateTo'");
		$results = $query1->getResult();
		return $results;
	}
	
	public function MonthTotal_present($userid,$DateFrom,$DateTo)
	{
		$db = db_connect();
		$query1 = $db->query("SELECT COUNT(*) AS Total_present FROM `business_calendar` JOIN student_attendance_details ON business_calendar.date = student_attendance_details.date where student_attendance_details.status = 1 AND business_calendar.is_student_workingday = 1 AND student_attendance_details.user_id = $userid AND  business_calendar.date between '$DateFrom' and '$DateTo'");
		$results = $query1->getResult();
		return $results;
	}
	
	public function MonthTotal_absent($userid,$DateFrom,$DateTo)
	{
		$db = db_connect();
		$query1 = $db->query("SELECT COUNT(*) AS Total_absent FROM `business_calendar` JOIN student_attendance_details ON business_calendar.date = student_attendance_details.date where student_attendance_details.status = 0 AND business_calendar.is_student_workingday = 1 AND student_attendance_details.user_id = $userid AND business_calendar.date between '$DateFrom' and '$DateTo'");
		$results = $query1->getResult();
		return $results;
	}
	public function MonthTotal_leaves($userid)
	{
		$db = db_connect();
		$query1 = $db->query("SELECT COUNT(*) AS Total_leaves FROM `leave_requests` WHERE isapproved = 1 AND userid = $userid");
		$results = $query1->getResult();
		return $results;
	}
	public function deleteAccount($userid)
	{
	    $db = db_connect();
        $data['is_delete'] = 1;
        $builder = $db->table('employeedetails');
        $builder->where('userid', $userid);
        $builder->update($data);
        $db->close();
	}
		public function deleteGuestAccount($userid)
	{
	    $db = db_connect();
        $data['is_delete'] = 1;
        $builder = $db->table('guest_user');
        $builder->where('id', $userid);
        $builder->update($data);
        $db->close();
	}
    public function get_BankAccounts($empid)
    {
        $db = db_connect();
        $query = $db->query("SELECT * from employee_bankdetails WHERE employeeid = '".$empid."'");
        $results = $query->getResult();
        $db->close();
        return $results;
    }
    public function get_insurance($userid)
    {
        $db = db_connect();
        $query = $db->query("SELECT * from employee_insurance WHERE userid = '".$userid."'");
        $results = $query->getResult();
        $db->close();
        return $results;
    }
     public function updateapplication($data)
    {
        $db = db_connect();
        $d["data"] = $data;
        $builder = $db->table('application_data');
        $builder->insert($d);
        $roleid = $db->insertID();
        $query = $db->query("SELECT data FROM application_data WHERE id='$roleid'");
        $results = $query->getResult();
        $db->close();
        return $results;
    }
    public function updateabsentregularise($attendanceid,$reason,$type)
    {
        $db = db_connect();
        $data['absentregularised'] = 0;
        $data['absentReason'] = $reason;
        $data['absenttype'] = $type;
        $builder = $db->table('employee_attendance');
        $builder->where('attendance_id ', $attendanceid);
        $builder->update($data);
        $db->close();
    }
    public function approveabsentregularise($attendanceid,$status)
    {
        $db = db_connect();
        $data['absentregularised'] = $status;
        $builder = $db->table('employee_attendance');
        $builder->where('attendance_id ', $attendanceid);
        $builder->update($data);
        $db->close();
    }
    public function absentregulariselist($userid)
    {
        $db = db_connect();
        $query = $db->query("SELECT employee_attendance.absenttype,absentregularised,absentReason,date,attendance_id,employee_id,name from employee_attendance join employeedetails on employee_attendance.employee_id = employeedetails.userid WHERE employee_attendance.absentregularised=0 and employeedetails.report_person = '".$userid."'");
        $results = $query->getResult();
        $db->close();
        return $results;
    }
    public function getFormRequests($form)
    {
        $db = db_connect();
        $query = $db->query("SELECT Fr.*, Sd.name,Sd.applicationnumber, Cr.name AS CreatedBy, Up.Name as UpdatedBy FROM form_requests Fr
                            JOIN studentdetails Sd on Fr.user_id = Sd.userid
                            JOIN employeedetails Cr on Fr.created_by = Cr.userid
                            LEFT JOIN employeedetails Up on Fr.updated_by = Up.userid
                            WHERE Fr.status IN ('created') and Fr.form_type='$form' order by form_request_id desc");
        $results = $query->getResult();
        $db->close();
        return $results;
    }
    public function addresignation($userid,$last_working_day,$reason)
    {
        $db = db_connect();
		$data['employee_id'] = $userid;
		$data['last_working_day'] = $last_working_day;
		$data['reason'] = $reason;
		$builder = $db->table('resignations');
		$builder->insert($data);
		$db->close();
    }
    public function addreimbursement($userid,$category,$amount,$reason)
    {
        $db = db_connect();
		$data['userid'] = $userid;
		$data['category'] = $category;
		$data['amount'] = $amount;
		$data['reason'] = $reason;
		$builder = $db->table('reimbursement');
		$builder->insert($data);
		$db->close();
    }
    public function get_reimbursement($userid)
    {
        $db = db_connect();
        $query = $db->query("SELECT R.*, ED.name,ED.employeeid,ED.firebase,ED1.name as reportingname,ED3.name as hrname FROM reimbursement R 
                           left JOIN employeedetails ED ON R.userid = ED.userid 
                           left JOIN employeedetails ED1 ON R.reporting_approved_by = ED1.userid 
                             left JOIN employeedetails ED3 ON R.hr_approved_by = ED3.userid
                             JOIN users U ON U.userid = ED.userid
                             JOIN roleslookup RL ON RL.roleid = U.roleid WHERE R.userid = '".$userid."'");
        $results = $query->getResult();
        $db->close();
        return $results;
    }
    public function get_resignation($userid)
    {
        $db = db_connect();
        $query = $db->query("SELECT R.*, ED.name,ED.employeeid,ED.firebase,ED1.name as reportingname,ED2.name as financename,ED3.name as hrname from resignations R
                            left JOIN employeedetails ED ON R.employee_id = ED.userid 
                           left JOIN employeedetails ED1 ON R.reporting_approved_by = ED1.userid 
                             left JOIN employeedetails ED2 ON R.finance_approved_by = ED2.userid
                             left JOIN employeedetails ED3 ON R.hr_approved_by = ED3.userid
                             JOIN users U ON U.userid = ED.userid
                             JOIN roleslookup RL ON RL.roleid = U.roleid 
        WHERE R.employee_id = '".$userid."'");
        $results = $query->getResult();
        $db->close();
        return $results;
    }
    public function resignationrequestlist($userid)
    {
        $db = db_connect();
        $query = $db->query("SELECT R.*, ED.name,ED.employeeid,ED.firebase FROM resignations R 
                             JOIN employeedetails ED ON R.employee_id = ED.userid 
                             JOIN users U ON U.userid = ED.userid
                             JOIN roleslookup RL ON RL.roleid = U.roleid
                             WHERE R.is_reporting_approved IS NULL AND 
                             ED.report_person={$userid}");
        $results = $query->getResult();
        $db->close();
        return $results;
    }
    public function reimbursementrequestlist($userid)
    {
        $db = db_connect();
        $query = $db->query("SELECT R.*, ED.name,ED.employeeid,ED.firebase FROM reimbursement R 
                             JOIN employeedetails ED ON R.userid = ED.userid 
                             JOIN users U ON U.userid = ED.userid
                             JOIN roleslookup RL ON RL.roleid = U.roleid
                             WHERE R.is_reporting_approved IS NULL AND 
                             ED.report_person={$userid}");
        $results = $query->getResult();
        $db->close();
        return $results;
    }
    public function financeresignationrequestlist()
    {
        $db = db_connect();
        $query = $db->query("SELECT R.*, ED.name,ED.employeeid,ED.firebase,ED1.name as reportingname,ED2.name as financename,ED3.name as hrname FROM resignations R 
                             JOIN employeedetails ED ON R.employee_id = ED.userid 
                             JOIN employeedetails ED1 ON R.reporting_approved_by = ED1.userid 
                             left JOIN employeedetails ED2 ON R.finance_approved_by = ED2.userid
                             left JOIN employeedetails ED3 ON R.hr_approved_by = ED3.userid
                             JOIN users U ON U.userid = ED.userid
                             JOIN roleslookup RL ON RL.roleid = U.roleid
                             WHERE R.is_reporting_approved IS NOT NULL");
        $results = $query->getResult();
        $db->close();
        return $results;
    }
    public function hrresignationrequestlist()
    {
        $db = db_connect();
        $query = $db->query("SELECT R.*, ED.name,ED.employeeid,ED.firebase,ED1.name as reportingname,ED2.name as financename,ED3.name as hrname FROM resignations R 
                             JOIN employeedetails ED ON R.employee_id = ED.userid 
                             JOIN employeedetails ED1 ON R.reporting_approved_by = ED1.userid 
                             left JOIN employeedetails ED2 ON R.finance_approved_by = ED2.userid
                             left JOIN employeedetails ED3 ON R.hr_approved_by = ED3.userid
                             JOIN users U ON U.userid = ED.userid
                             JOIN roleslookup RL ON RL.roleid = U.roleid
                             WHERE R.is_reporting_approved IS NOT NULL AND is_finance_approved IS NOT NULL");
        $results = $query->getResult();
        $db->close();
        return $results;
    }
    public function hrreimbursementrequestlist()
    {
        $db = db_connect();
        $query = $db->query("SELECT R.*, ED.name,ED.employeeid,ED.firebase,ED1.name as reportingname,ED3.name as hrname FROM reimbursement R 
                             JOIN employeedetails ED ON R.userid = ED.userid 
                             JOIN employeedetails ED1 ON R.reporting_approved_by = ED1.userid
                             left JOIN employeedetails ED3 ON R.hr_approved_by = ED3.userid
                             JOIN users U ON U.userid = ED.userid
                             JOIN roleslookup RL ON RL.roleid = U.roleid
                             WHERE R.is_reporting_approved IS NOT NULL");
        $results = $query->getResult();
        $db->close();
        return $results;
    }
    public function approveresignation($resignationid, $status,$userid)
    {
        $db = db_connect();
        $data['status'] = $status;
        if($status ==1){ $is_reporting_approved = 1 ; }else{ $is_reporting_approved =0; }
        $data['is_reporting_approved'] = $is_reporting_approved;
        $data['reporting_approved_by'] = $userid;
        $builder = $db->table('resignations');
        $builder->where('id ', $resignationid);
        $builder->update($data);
        $db->close();
    }
    public function approvereimbursement($reimbursementid, $status,$userid)
    {
         $db = db_connect();
        $data['status'] = $status;
        if($status ==1){ $is_reporting_approved = 1 ; }else{ $is_reporting_approved =0; }
        $data['is_reporting_approved'] = $is_reporting_approved;
        $data['reporting_approved_by'] = $userid;
        $builder = $db->table('reimbursement');
        $builder->where('id ', $reimbursementid);
        $builder->update($data);
        $db->close();
    }
    public function financeapproveresignation($resignationid, $status,$userid)
    {
        $db = db_connect();
        if($status ==1){ $is_reporting_approved = 1 ; }else{ $is_reporting_approved =0; }
        $data['is_finance_approved'] = $is_reporting_approved;
        $data['finance_approved_by'] = $userid;
        $builder = $db->table('resignations');
        $builder->where('id ', $resignationid);
        $builder->update($data);
        $db->close();
    }
    public function hrapproveresignation($resignationid, $status,$userid)
    {
        $db = db_connect();
        if($status ==1){ $is_reporting_approved = 1 ; }else{ $is_reporting_approved =0; }
        $data['is_hr_approved'] = $is_reporting_approved;
        $data['hr_approved_by'] = $userid;
        $builder = $db->table('resignations');
        $builder->where('id ', $resignationid);
        $builder->update($data);
        $db->close();
    }
    public function hrapprovereimbursement($reimbursementid, $status,$userid)
    {
         $db = db_connect();
        if($status ==1){ $is_reporting_approved = 1 ; }else{ $is_reporting_approved =0; }
        $data['is_hr_approved'] = $is_reporting_approved;
        $data['hr_approved_by'] = $userid;
        $builder = $db->table('reimbursement');
        $builder->where('id ', $reimbursementid);
        $builder->update($data);
        $db->close();
    }
    public function Approvedapplicationlist($branchid,$batchid)
	{
		$db = db_connect();
		$query = $db->query("select reservationid,reservation_ukey,admissiontypeid,courseid,batchid,branchid,name from reservation where branchid in({$branchid}) and batchid={$batchid} and is_migrate=0");
    //	$query = $db->query("select application_ukey,email from applications where reservationstatusid=5 and batchid=4 and is_enrolled=0");
		$results = $query->getResult();
		$db->close();
		return $results;
	}
	public function Studentlist($branchid,$batchid)
	{
	    $db = db_connect();
		$query = $db->query("select userid as reservationid,applicationnumber as reservation_ukey,admissiontypeid,courseid,batchid,branchid,name from studentdetails JOIN student_class_relation ON student_class_relation.studentid = studentdetails.userid where branchid in({$branchid}) and batchid={$batchid}");
    //	$query = $db->query("select application_ukey,email from applications where reservationstatusid=5 and batchid=4 and is_enrolled=0");
		$results = $query->getResult();
		$db->close();
		return $results;
	}
	public function reservationmaxdiscount($admissiontypeid, $batchid,$branchid,$courseid)
	{
	    $db = db_connect();
		$query = $db->query("select amount from reservation_discounts_lookup where branchid={$branchid} and batchid={$batchid} and admissiontypeid={$admissiontypeid} and courseid={$courseid}");
		$results = $query->getResult();
		$db->close();
		return $results;
	}
	public function reservationmigrate($reservationid)
	{
	    $db = db_connect();
		$query = $db->query("select is_migrate from reservation where reservationid={$reservationid}");
		$results = $query->getResult();
		$db->close();
		return $results;
	}
	public function reservationmaxdiscountbyuserid($userid,$batchid)
	{
	    $db = db_connect();
		$query = $db->query("select amount from reservation_discounts_lookup where userid={$userid} and batchid={$batchid}");
		$results = $query->getResult();
		$db->close();
		return $results;
	}
	 public function Siblinglist()
	{
		$db = db_connect();
		$query = $db->query("select applicationnumber,name from studentdetails JOIN student_class_relation ON student_class_relation.studentid = studentdetails.userid where batchid in(1,2,3) group by student_class_relation.studentid");
		$results = $query->getResult();
		$db->close();
		return $results;
	}
	public function createreservationdiscount($reservationid, $amount,$amount1,$discounttype,$comments,$reason,$userid,$disid,$requested_to,$batchid,$type)
	{
	    if($amount1 =='' || $amount1 ==0){ $amount1 = NULL ; }
	    $db = db_connect();
	    $data['reservation_discountid'] = $disid;
	    $data['discounttypeid'] = 1;
		$data['userid'] = $reservationid;
		$data['discounttype'] = $discounttype;
		$data['amount'] = $amount;
		$data['amount1'] = $amount1;
		$data['comments'] = $comments;
		$data['reason'] = $reason;
		$data['batchid'] = $batchid;
		$data['created_by'] = $userid;
		$data['requested_to'] = $requested_to;
		$data['type'] = $type;
		$builder = $db->table('reservation_discounts');
		$builder->insert($data);
		
		 $db->query("UPDATE employeediscount_limit 
                    set availablelimit = availablelimit - {$amount}
                    where employeeid = $userid
                    AND batchid = {$batchid}");
        $batchid = $batchid+1;
        $db->query("UPDATE employeediscount_limit 
                    set availablelimit = availablelimit - {$amount1}
                    where employeeid = $userid
                    AND batchid = {$batchid}");
		$db->close();
	}
	public function createfvoucherdiscount($reservationid,$amount,$reason,$userid,$disid,$requested_to,$batchid,$type)
	{
	    $db = db_connect();
	    $data['reservation_discountid'] = $disid;
	    $data['discounttypeid'] = 2;
		$data['userid'] = $reservationid;
		$data['amount'] = $amount;
		$data['reason'] = $reason;
		$data['batchid'] = $batchid;
		$data['created_by'] = $userid;
		$data['requested_to'] = $requested_to;
		$data['type'] = $type;
		$builder = $db->table('reservation_discounts');
		$builder->insert($data);
		$db->close();
	}
	public function createevoucherdiscount($reservationid,$amount,$reason,$comments,$userid,$disid,$requested_to,$batchid,$type)
	{
	    $db = db_connect();
	    $data['reservation_discountid'] = $disid;
	    $data['discounttypeid'] = 3;
		$data['userid'] = $reservationid;
		$data['amount'] = $amount;
		$data['reason'] = $reason;
		$data['comments'] = $comments;
		$data['batchid'] = $batchid;
		$data['created_by'] = $userid;
		$data['requested_to'] = $requested_to;
		$data['type'] = $type;
		$builder = $db->table('reservation_discounts');
		$builder->insert($data);
		$db->close();
	}
	public function get_reservationdiscountlist($userid,$batchid)
	{
	    $db = db_connect();
        $query = $db->query("SELECT reservation_discounts.commentreason,reservation_discounts.type,reservation_discounts.amount,reservation_discounts.amount1,reservation_discounts.approvedamount,reservation_discounts.approvedamount1,reservation_discounts.reservation_discountid,ED1.name as approvedby,reservation_discounts.approved_date,reservation_discounts.discounttype,reservation_discounts.comments,reservation_discounts.reason,reservation_discounts.status,reservation.reservation_ukey,reservation.name,studentdetails.name as studentname,studentdetails.applicationnumber from reservation_discounts left join reservation on reservation_discounts.userid=reservation.reservationid 
        left join studentdetails on reservation_discounts.userid=studentdetails.userid 
        left JOIN employeedetails ED1 ON reservation_discounts.requested_to = ED1.userid 
        WHERE reservation_discounts.created_by = '".$userid."' and reservation_discounts.batchid= '".$batchid."' and discounttypeid=1 order by reservation_discounts.id desc");
        $results = $query->getResult();
        $db->close();
        return $results;
	}
	public function get_fvoucherlist($userid,$batchid)
	{
	    $db = db_connect();
        $query = $db->query("SELECT reservation_discounts.commentreason,reservation_discounts.type,reservation_discounts.amount,reservation_discounts.amount1,reservation_discounts.approvedamount,reservation_discounts.approvedamount1,reservation_discounts.reservation_discountid,ED1.name as approvedby,reservation_discounts.approved_date,reservation_discounts.discounttype,reservation_discounts.comments,reservation_discounts.reason,reservation_discounts.status,reservation.reservation_ukey,reservation.name,studentdetails.name as studentname,studentdetails.applicationnumber from reservation_discounts left join reservation on reservation_discounts.userid=reservation.reservationid 
        left join studentdetails on reservation_discounts.userid=studentdetails.userid 
        left JOIN employeedetails ED1 ON reservation_discounts.requested_to = ED1.userid 
        WHERE reservation_discounts.created_by = '".$userid."' and reservation_discounts.batchid= '".$batchid."' and discounttypeid=2 order by reservation_discounts.id desc");
        $results = $query->getResult();
        $db->close();
        return $results;
	}
	public function get_evoucherlist($userid,$batchid)
	{
	    $db = db_connect();
        $query = $db->query("SELECT reservation_discounts.commentreason,reservation_discounts.type,reservation_discounts.amount,reservation_discounts.amount1,reservation_discounts.approvedamount,reservation_discounts.approvedamount1,reservation_discounts.reservation_discountid,ED1.name as approvedby,reservation_discounts.approved_date,reservation_discounts.discounttype,reservation_discounts.comments,reservation_discounts.reason,reservation_discounts.status,reservation.reservation_ukey,reservation.name,studentdetails.name as studentname,studentdetails.applicationnumber from reservation_discounts left join reservation on reservation_discounts.userid=reservation.reservationid 
        left join studentdetails on reservation_discounts.userid=studentdetails.userid 
        left JOIN employeedetails ED1 ON reservation_discounts.requested_to = ED1.userid 
        WHERE reservation_discounts.created_by = '".$userid."' and reservation_discounts.batchid= '".$batchid."' and discounttypeid=3 order by reservation_discounts.id desc");
        $results = $query->getResult();
        $db->close();
        return $results;
	}
	public function get_reservationdiscounts($userid,$batchid)
	{
        $db = db_connect();
        $query = $db->query("SELECT reservation_discounts.amount,reservation_discounts.amount1,reservation_discounts.reservation_discountid,ED1.name as approvedby,reservation_discounts.approved_date,voucherlookup.vouchertype,ED2.name as createdby,reservation_discounts.discounttype,reservation_discounts.comments,reservation_discounts.reason,reservation_discounts.status,reservation.reservation_ukey,reservation.name,reservation_discounts.date from reservation_discounts join reservation on reservation_discounts.userid=reservation.reservationid 
        JOIN voucherlookup ON reservation_discounts.discounttypeid = voucherlookup.voucherid 
        left JOIN employeedetails ED1 ON reservation_discounts.requested_to = ED1.userid 
        left JOIN employeedetails ED2 ON reservation_discounts.created_by = ED2.userid
        WHERE reservation_discounts.userid = '".$userid."' and reservation_discounts.batchid= '".$batchid."' and reservation_discounts.status=1 order by reservation_discounts.id desc");
        $results = $query->getResult();
        $db->close();
        return $results;
	}
	public function get_studentdiscounts($userid,$batchid)
	{
	    $db = db_connect();
        $query = $db->query("SELECT payments.paymentamount as amount,payments.paymentamount as amount1,payments.discountid as reservation_discountid,ED1.name as approvedby,payments.approved_date,paymenttypelookup.paymenttypename as vouchertype,ED2.name as createdby,payments.otherdetails as discounttype,payments.remarks as comments,payments.remarks as reason,payments.paymentstatusid as status,studentdetails.applicationnumber as reservation_ukey,studentdetails.name,payments.createddate as date from payments join studentdetails on payments.userid=studentdetails.userid 
        JOIN paymenttypelookup ON payments.paymenttypeid = paymenttypelookup.paymenttypeid 
        left JOIN employeedetails ED1 ON payments.approved_by = ED1.userid 
        left JOIN employeedetails ED2 ON payments.created_by = ED2.userid
        WHERE payments.userid = '".$userid."' and payments.batchid= '".$batchid."' AND payments.paymenttypeid IN (10,11,12)");
        $results = $query->getResult();
        $db->close();
        return $results;
	}
	public function get_pendingreservationdiscounts($reservationid)
	{
	    $db = db_connect();
        $query = $db->query("SELECT count(*) as count from reservation_discounts
        WHERE reservation_discounts.userid = '".$reservationid."' and reservation_discounts.status=0 and reservation_discounts.discounttypeid=1");
        $results = $query->getResult();
        $db->close();
        return $results;
	}
	
	public function get_studentdiscountrequests($userid,$batchid)
	{
	    $db = db_connect();
        $query = $db->query("SELECT PaymentDetails1.TotalPaid1 as paidamount,PaymentDetails.TotalPaid as discounts,InvoiceDetails.batchid,InvoiceDetails.requested_to,InvoiceDetails.reservationid,InvoiceDetails.approvedby,InvoiceDetails.createdby,InvoiceDetails.amount,InvoiceDetails.id,InvoiceDetails.batchid,InvoiceDetails.amount1,InvoiceDetails.name,InvoiceDetails.reservation_ukey,InvoiceDetails.reservationid,InvoiceDetails.reason,PaymentDetails2.totalfee,InvoiceDetails.admissiontypename,InvoiceDetails.branchname,InvoiceDetails.coursename,InvoiceDetails.discounttype,InvoiceDetails.status,InvoiceDetails.comments,InvoiceDetails.reservation_discountid
        FROM (SELECT reservation_discounts.id,reservation_discounts.reservation_discountid,ED1.name as approvedby,ED5.name as createdby,reservation_discounts.batchid,reservation_discounts.requested_to,studentdetails.userid as reservationid,reservation_discounts.userid as studentid,reservation_discounts.amount,reservation_discounts.amount1,reservation_discounts.reason,reservation_discounts.discounttype,reservation_discounts.comments,reservation_discounts.status,studentdetails.applicationnumber as reservation_ukey,studentdetails.name,admissiontypelookup.admissiontypename,branchlookup.branchname,courselookup.coursename 
        from reservation_discounts join studentdetails on reservation_discounts.userid=studentdetails.userid join student_class_relation on studentdetails.userid=student_class_relation.studentid join payments on payments.userid=studentdetails.userid JOIN employeedetails ED5 ON reservation_discounts.created_by = ED5.userid left JOIN employeedetails ED1 ON reservation_discounts.approved_by = ED1.userid JOIN branchlookup ON student_class_relation.branchid = branchlookup.branchid
                                 JOIN admissiontypelookup ON student_class_relation.admissiontypeid = admissiontypelookup.admissiontypeid
                                 JOIN courselookup ON student_class_relation.courseid = courselookup.courseid where requested_to={$userid} and reservation_discounts.status=0 and reservation_discounts.discounttypeid=1 and reservation_discounts.batchid={$batchid} and reservation_discounts.type=2 and student_class_relation.batchid={$batchid} group by reservation_discountid order by reservation_discounts.id desc ) InvoiceDetails  LEFT JOIN
                                 (SELECT SUM(payments.paymentamount) as TotalPaid,userid,batchid FROM payments where payments.paymenttypeid IN (10,11,12) GROUP BY payments.userid,payments.batchid) PaymentDetails ON InvoiceDetails.reservationid = PaymentDetails.userid AND InvoiceDetails.batchid = PaymentDetails.batchid LEFT JOIN
                                 (SELECT SUM(payments.paymentamount) as TotalPaid1,userid,batchid FROM payments where payments.paymenttypeid NOT IN (10,11,12) GROUP BY payments.userid,payments.batchid) PaymentDetails1 ON InvoiceDetails.reservationid = PaymentDetails1.userid AND InvoiceDetails.batchid = PaymentDetails1.batchid LEFT JOIN
                                 (SELECT SUM(invoices.feesvalue) as totalfee,userid,batchid FROM invoices where invoices.feesid NOT IN (328) GROUP BY invoices.userid,invoices.batchid) PaymentDetails2 ON InvoiceDetails.reservationid = PaymentDetails2.userid AND InvoiceDetails.batchid = PaymentDetails2.batchid;");
        $results = $query->getResult();
        $db->close();
        return $results;
	}
	public function get_reservationdiscountrequests($userid,$batchid)
	{
	    $db = db_connect();
        $query = $db->query("SELECT PaymentDetails1.TotalPaid1 as paidamount,PaymentDetails.TotalPaid as discounts,InvoiceDetails.batchid,InvoiceDetails.requested_to,InvoiceDetails.reservationid,InvoiceDetails.approvedby,InvoiceDetails.createdby,InvoiceDetails.amount,InvoiceDetails.id,InvoiceDetails.batchid,InvoiceDetails.amount1,InvoiceDetails.name,InvoiceDetails.reservation_ukey,InvoiceDetails.reservationid,InvoiceDetails.reason,InvoiceDetails.totalfee,InvoiceDetails.admissiontypename,InvoiceDetails.branchname,InvoiceDetails.coursename,InvoiceDetails.discounttype,InvoiceDetails.status,InvoiceDetails.comments,InvoiceDetails.reservation_discountid
        FROM (SELECT reservation_discounts.id,reservation_discounts.reservation_discountid,ED1.name as approvedby,ED5.name as createdby,reservation_discounts.batchid,reservation_discounts.requested_to,reservation.reservationid,reservation_discounts.userid as studentid,reservation_discounts.amount,reservation_discounts.amount1,reservation_discounts.reason,reservation_discounts.discounttype,reservation_discounts.comments,reservation_discounts.status,reservation.reservation_ukey,reservation.name,reservation.tuition_discount as totalfee,admissiontypelookup.admissiontypename,branchlookup.branchname,courselookup.coursename 
        from reservation_discounts join reservation on reservation_discounts.userid=reservation.reservationid join reservation_payments on reservation_payments.reservationid=reservation.reservationid JOIN employeedetails ED5 ON reservation_discounts.created_by = ED5.userid left JOIN employeedetails ED1 ON reservation_discounts.approved_by = ED1.userid JOIN branchlookup ON reservation.branchid = branchlookup.branchid
                                 JOIN admissiontypelookup ON reservation.admissiontypeid = admissiontypelookup.admissiontypeid
                                 JOIN courselookup ON reservation.courseid = courselookup.courseid where requested_to={$userid} and reservation_discounts.status=0 and reservation_discounts.discounttypeid=1 and reservation_discounts.batchid={$batchid} and reservation_discounts.type=1 group by reservation_discountid order by reservation_discounts.id desc) InvoiceDetails  LEFT JOIN
                                 (SELECT SUM(reservation_payments.paymentamount) as TotalPaid,reservationid,batchid FROM reservation_payments where reservation_payments.paymenttypeid IN (10,11,12) GROUP BY reservation_payments.reservationid,reservation_payments.batchid) PaymentDetails ON InvoiceDetails.reservationid = PaymentDetails.reservationid AND InvoiceDetails.batchid = PaymentDetails.batchid LEFT JOIN
                                 (SELECT SUM(reservation_payments.paymentamount) as TotalPaid1,reservationid,batchid FROM reservation_payments where reservation_payments.paymenttypeid NOT IN (10,11,12) GROUP BY reservation_payments.reservationid,reservation_payments.batchid) PaymentDetails1 ON InvoiceDetails.reservationid = PaymentDetails1.reservationid AND InvoiceDetails.batchid = PaymentDetails1.batchid");
        $results = $query->getResult();
        $db->close();
        return $results;
	}
	public function get_studentfvoucherrequests($userid,$batchid)
	{
	    $db = db_connect();
        $query = $db->query("SELECT PaymentDetails1.TotalPaid1 as paidamount,PaymentDetails.TotalPaid as discounts,InvoiceDetails.batchid,InvoiceDetails.requested_to,InvoiceDetails.reservationid,InvoiceDetails.approvedby,InvoiceDetails.createdby,InvoiceDetails.amount,InvoiceDetails.id,InvoiceDetails.batchid,InvoiceDetails.amount1,InvoiceDetails.name,InvoiceDetails.reservation_ukey,InvoiceDetails.reservationid,InvoiceDetails.reason,InvoiceDetails.totalfee,InvoiceDetails.admissiontypename,InvoiceDetails.branchname,InvoiceDetails.coursename,InvoiceDetails.discounttype,InvoiceDetails.status,InvoiceDetails.comments,InvoiceDetails.reservation_discountid
        FROM (SELECT reservation_discounts.id,reservation_discounts.reservation_discountid,ED1.name as approvedby,ED5.name as createdby,reservation_discounts.batchid,reservation_discounts.requested_to,studentdetails.userid as reservationid,reservation_discounts.userid as studentid,reservation_discounts.amount,reservation_discounts.amount1,reservation_discounts.reason,reservation_discounts.discounttype,reservation_discounts.comments,reservation_discounts.status,studentdetails.applicationnumber as reservation_ukey,studentdetails.name,studentdetails.tuition_discount as totalfee,admissiontypelookup.admissiontypename,branchlookup.branchname,courselookup.coursename 
        from reservation_discounts join studentdetails on reservation_discounts.userid=studentdetails.userid join student_class_relation on studentdetails.userid=student_class_relation.studentid join payments on payments.userid=studentdetails.userid JOIN employeedetails ED5 ON reservation_discounts.created_by = ED5.userid left JOIN employeedetails ED1 ON reservation_discounts.approved_by = ED1.userid JOIN branchlookup ON student_class_relation.branchid = branchlookup.branchid
                                 JOIN admissiontypelookup ON student_class_relation.admissiontypeid = admissiontypelookup.admissiontypeid
                                 JOIN courselookup ON student_class_relation.courseid = courselookup.courseid where requested_to={$userid} and reservation_discounts.status=0 and reservation_discounts.discounttypeid=2 and reservation_discounts.batchid={$batchid} and reservation_discounts.type=2 group by reservation_discountid order by reservation_discounts.id desc) InvoiceDetails  LEFT JOIN
                                 (SELECT SUM(payments.paymentamount) as TotalPaid,userid,batchid FROM payments where payments.paymenttypeid IN (10,11,12) GROUP BY payments.userid,payments.batchid) PaymentDetails ON InvoiceDetails.reservationid = PaymentDetails.userid AND InvoiceDetails.batchid = PaymentDetails.batchid LEFT JOIN
                                 (SELECT SUM(payments.paymentamount) as TotalPaid1,userid,batchid FROM payments where payments.paymenttypeid NOT IN (10,11,12) GROUP BY payments.userid,payments.batchid) PaymentDetails1 ON InvoiceDetails.reservationid = PaymentDetails1.userid AND InvoiceDetails.batchid = PaymentDetails1.batchid");
        $results = $query->getResult();
        $db->close();
        return $results;
	}
	public function get_fvoucherrequests($userid,$batchid)
	{
        $db = db_connect();
        $query = $db->query("SELECT PaymentDetails1.TotalPaid1 as paidamount,PaymentDetails.TotalPaid as discounts,InvoiceDetails.batchid,InvoiceDetails.requested_to,InvoiceDetails.reservationid,InvoiceDetails.approvedby,InvoiceDetails.createdby,InvoiceDetails.amount,InvoiceDetails.id,InvoiceDetails.batchid,InvoiceDetails.amount1,InvoiceDetails.name,InvoiceDetails.reservation_ukey,InvoiceDetails.reservationid,InvoiceDetails.reason,InvoiceDetails.totalfee,InvoiceDetails.admissiontypename,InvoiceDetails.branchname,InvoiceDetails.coursename,InvoiceDetails.discounttype,InvoiceDetails.status,InvoiceDetails.comments,InvoiceDetails.reservation_discountid
        FROM (SELECT reservation_discounts.id,reservation_discounts.reservation_discountid,ED1.name as approvedby,ED5.name as createdby,reservation_discounts.batchid,reservation_discounts.requested_to,reservation.reservationid,reservation_discounts.userid as studentid,reservation_discounts.amount,reservation_discounts.amount1,reservation_discounts.reason,reservation_discounts.discounttype,reservation_discounts.comments,reservation_discounts.status,reservation.reservation_ukey,reservation.name,reservation.tuition_discount as totalfee,admissiontypelookup.admissiontypename,branchlookup.branchname,courselookup.coursename 
        from reservation_discounts join reservation on reservation_discounts.userid=reservation.reservationid join reservation_payments on reservation_payments.reservationid=reservation.reservationid JOIN employeedetails ED5 ON reservation_discounts.created_by = ED5.userid left JOIN employeedetails ED1 ON reservation_discounts.approved_by = ED1.userid JOIN branchlookup ON reservation.branchid = branchlookup.branchid
                                 JOIN admissiontypelookup ON reservation.admissiontypeid = admissiontypelookup.admissiontypeid
                                 JOIN courselookup ON reservation.courseid = courselookup.courseid where requested_to={$userid} and reservation_discounts.status=0 and reservation_discounts.discounttypeid=2 and reservation_discounts.batchid={$batchid} group by reservation_discountid order by reservation_discounts.id desc) InvoiceDetails  LEFT JOIN
                                 (SELECT SUM(reservation_payments.paymentamount) as TotalPaid,reservationid,batchid FROM reservation_payments where reservation_payments.paymenttypeid IN (10,11,12) GROUP BY reservation_payments.reservationid,reservation_payments.batchid) PaymentDetails ON InvoiceDetails.reservationid = PaymentDetails.reservationid AND InvoiceDetails.batchid = PaymentDetails.batchid LEFT JOIN
                                 (SELECT SUM(reservation_payments.paymentamount) as TotalPaid1,reservationid,batchid FROM reservation_payments where  reservation_payments.paymenttypeid NOT IN (10,11,12)  GROUP BY reservation_payments.reservationid,reservation_payments.batchid) PaymentDetails1 ON InvoiceDetails.reservationid = PaymentDetails1.reservationid AND InvoiceDetails.batchid = PaymentDetails1.batchid;");
        $results = $query->getResult();
        $db->close();
        return $results;
	}
	public function get_studentevoucherrequests($userid,$batchid)
	{
	    $db = db_connect();
        $query = $db->query("SELECT PaymentDetails1.TotalPaid1 as paidamount,PaymentDetails.TotalPaid as discounts,InvoiceDetails.batchid,InvoiceDetails.requested_to,InvoiceDetails.reservationid,InvoiceDetails.approvedby,InvoiceDetails.createdby,InvoiceDetails.amount,InvoiceDetails.id,InvoiceDetails.batchid,InvoiceDetails.amount1,InvoiceDetails.name,InvoiceDetails.reservation_ukey,InvoiceDetails.reservationid,InvoiceDetails.reason,InvoiceDetails.totalfee,InvoiceDetails.admissiontypename,InvoiceDetails.branchname,InvoiceDetails.coursename,InvoiceDetails.discounttype,InvoiceDetails.status,InvoiceDetails.comments,InvoiceDetails.reservation_discountid
        FROM (SELECT reservation_discounts.id,reservation_discounts.reservation_discountid,ED1.name as approvedby,ED5.name as createdby,reservation_discounts.batchid,reservation_discounts.requested_to,studentdetails.userid as reservationid,reservation_discounts.userid as studentid,reservation_discounts.amount,reservation_discounts.amount1,reservation_discounts.reason,reservation_discounts.discounttype,reservation_discounts.comments,reservation_discounts.status,studentdetails.applicationnumber as reservation_ukey,studentdetails.name,studentdetails.tuition_discount as totalfee,admissiontypelookup.admissiontypename,branchlookup.branchname,courselookup.coursename 
        from reservation_discounts join studentdetails on reservation_discounts.userid=studentdetails.userid join student_class_relation on studentdetails.userid=student_class_relation.studentid join payments on payments.userid=studentdetails.userid JOIN employeedetails ED5 ON reservation_discounts.created_by = ED5.userid left JOIN employeedetails ED1 ON reservation_discounts.approved_by = ED1.userid JOIN branchlookup ON student_class_relation.branchid = branchlookup.branchid
                                 JOIN admissiontypelookup ON student_class_relation.admissiontypeid = admissiontypelookup.admissiontypeid
                                 JOIN courselookup ON student_class_relation.courseid = courselookup.courseid where requested_to={$userid} and reservation_discounts.status=0 and reservation_discounts.discounttypeid=3 and reservation_discounts.batchid={$batchid} and reservation_discounts.type=2 group by reservation_discountid order by reservation_discounts.id desc) InvoiceDetails  LEFT JOIN
                                 (SELECT SUM(payments.paymentamount) as TotalPaid,userid,batchid FROM payments where payments.paymenttypeid IN (10,11,12) GROUP BY payments.userid,payments.batchid) PaymentDetails ON InvoiceDetails.reservationid = PaymentDetails.userid AND InvoiceDetails.batchid = PaymentDetails.batchid LEFT JOIN
                                 (SELECT SUM(payments.paymentamount) as TotalPaid1,userid,batchid FROM payments where payments.paymenttypeid NOT IN (10,11,12) GROUP BY payments.userid,payments.batchid) PaymentDetails1 ON InvoiceDetails.reservationid = PaymentDetails1.userid AND InvoiceDetails.batchid = PaymentDetails1.batchid");
        $results = $query->getResult();
        $db->close();
        return $results;
	}
	public function get_evoucherrequests($userid,$batchid)
	{
        $db = db_connect();
        $query = $db->query("SELECT PaymentDetails1.TotalPaid1 as paidamount,PaymentDetails.TotalPaid as discounts,InvoiceDetails.batchid,InvoiceDetails.requested_to,InvoiceDetails.reservationid,InvoiceDetails.approvedby,InvoiceDetails.createdby,InvoiceDetails.amount,InvoiceDetails.id,InvoiceDetails.batchid,InvoiceDetails.amount1,InvoiceDetails.name,InvoiceDetails.reservation_ukey,InvoiceDetails.reservationid,InvoiceDetails.reason,InvoiceDetails.totalfee,InvoiceDetails.admissiontypename,InvoiceDetails.branchname,InvoiceDetails.coursename,InvoiceDetails.discounttype,InvoiceDetails.status,InvoiceDetails.comments,InvoiceDetails.reservation_discountid
        FROM (SELECT reservation_discounts.id,reservation_discounts.reservation_discountid,ED1.name as approvedby,ED5.name as createdby,reservation_discounts.batchid,reservation_discounts.requested_to,reservation.reservationid,reservation_discounts.userid as studentid,reservation_discounts.amount,reservation_discounts.amount1,reservation_discounts.reason,reservation_discounts.discounttype,reservation_discounts.comments,reservation_discounts.status,reservation.reservation_ukey,reservation.name,reservation.tuition_discount as totalfee,admissiontypelookup.admissiontypename,branchlookup.branchname,courselookup.coursename 
        from reservation_discounts join reservation on reservation_discounts.userid=reservation.reservationid join reservation_payments on reservation_payments.reservationid=reservation.reservationid JOIN employeedetails ED5 ON reservation_discounts.created_by = ED5.userid left JOIN employeedetails ED1 ON reservation_discounts.approved_by = ED1.userid JOIN branchlookup ON reservation.branchid = branchlookup.branchid
                                 JOIN admissiontypelookup ON reservation.admissiontypeid = admissiontypelookup.admissiontypeid
                                 JOIN courselookup ON reservation.courseid = courselookup.courseid where requested_to={$userid} and reservation_discounts.status=0 and reservation_discounts.discounttypeid=3 and reservation_discounts.batchid={$batchid} group by reservation_discountid order by reservation_discounts.id desc) InvoiceDetails  LEFT JOIN
                                 (SELECT SUM(reservation_payments.paymentamount) as TotalPaid,reservationid,batchid FROM reservation_payments where reservation_payments.paymenttypeid IN (10,11,12) GROUP BY reservation_payments.reservationid,reservation_payments.batchid) PaymentDetails ON InvoiceDetails.reservationid = PaymentDetails.reservationid AND InvoiceDetails.batchid = PaymentDetails.batchid LEFT JOIN
                                 (SELECT SUM(reservation_payments.paymentamount) as TotalPaid1,reservationid,batchid FROM reservation_payments where  reservation_payments.paymenttypeid NOT IN (10,11,12)  GROUP BY reservation_payments.reservationid,reservation_payments.batchid) PaymentDetails1 ON InvoiceDetails.reservationid = PaymentDetails1.reservationid AND InvoiceDetails.batchid = PaymentDetails1.batchid;");
        $results = $query->getResult();
        $db->close();
        return $results;
	}
	public function approvereservationdiscount($id, $status,$userid,$studentid,$amount,$amount1,$comments,$commentreason)
	{
	    $db = db_connect();
        $data['status'] = $status;
       // $data['amount'] = $amount;
      //  $data['amount1'] = $amount1;
      if($status == 1){
        $data['approvedamount'] = $amount;
        $data['approvedamount1'] = $amount1;
        $data['approved_by'] = $userid;
        $data['commentreason'] = $commentreason;
      }
        $data['approved_date'] = date('Y-m-d H:i:s');
        $builder = $db->table('reservation_discounts');
        $builder->where('id ', $id);
        $builder->update($data);
        $db->close();
	}
	public function approvefvoucher($id, $status,$userid,$studentid,$amount,$comments,$commentreason)
	{
	    $db = db_connect();
        $data['status'] = $status;
       // $data['amount'] = $amount;
        if($status == 1){
        $data['approvedamount'] = $amount;
        $data['approved_by'] = $userid;
        $data['commentreason'] = $commentreason;
        }
        $data['approved_date'] = date('Y-m-d H:i:s');
        $builder = $db->table('reservation_discounts');
        $builder->where('id ', $id);
        $builder->update($data);
        $db->close();
	}
	public function approveevoucher($id, $status,$userid,$studentid,$amount,$comments,$commentreason)
	{
	    $db = db_connect();
        $data['status'] = $status;
         if($status == 1){
       // $data['amount'] = $amount;
        $data['commentreason'] = $commentreason;
        $data['approvedamount'] = $amount;
        $data['approved_by'] = $userid;
         }
        $data['approved_date'] = date('Y-m-d H:i:s');
        $builder = $db->table('reservation_discounts');
        $builder->where('id ', $id);
        $builder->update($data);
        $db->close();
	}
	public function employeediscountlimit($userid)
	{
        $db = db_connect();
        $query = $db->query("SELECT * from employeediscount_limit WHERE employeeid = '{$userid}' and batchid=4");
        $results = $query->getResult();
        $db->close();
        return $results;
	}
	public function reservationdiscountto()
	{
        $db = db_connect();
        $query = $db->query("SELECT name,employeeid,userid from employeedetails WHERE userid IN (62,6766)");
        $results = $query->getResult();
        $db->close();
        return $results;
	}
	public function getdiscountid($branchid)
    {
        $db = db_connect();
        $query = $db->query("SELECT reservation_discountid FROM branchlookup where branchid ={$branchid}");
        $result = $query->getRow();
        $db->close();
        return $result->reservation_discountid;
    }
    public function getvoucherid($branchid)
    {
        $db = db_connect();
        $query = $db->query("SELECT fvoucherid FROM branchlookup where branchid ={$branchid}");
        $result = $query->getRow();
        $db->close();
        return $result->fvoucherid;
    }
    public function getevoucherid($branchid)
    {
        $db = db_connect();
        $query = $db->query("SELECT evoucherid FROM branchlookup where branchid ={$branchid}");
        $result = $query->getRow();
        $db->close();
        return $result->evoucherid;
    }
    public function getdiscountidnew($branchid)
    {
        $db = db_connect();
        $query = $db->query("SELECT reservation_discountid,branchcode FROM branchlookup where branchid ={$branchid}");
        $result = $query->getRow();
        $db->close();
        return $result;
    }
    public function getfvoucheridnew($branchid)
    {
        $db = db_connect();
        $query = $db->query("SELECT fvoucherid,branchcode FROM branchlookup where branchid ={$branchid}");
        $result = $query->getRow();
        $db->close();
        return $result;
    }
    public function getevoucheridnew($branchid)
    {
        $db = db_connect();
        $query = $db->query("SELECT evoucherid,branchcode FROM branchlookup where branchid ={$branchid}");
        $result = $query->getRow();
        $db->close();
        return $result;
    }
    public function set_getdiscountid($branchid)
    {
        $current = $this->getdiscountid($branchid);
        $nextpaymentid = $current + 1;
        $getdiscountid = $nextpaymentid;
        $db = db_connect();
	    $update = $db->query("UPDATE branchlookup set reservation_discountid ='" . $getdiscountid . "' where branchid='$branchid'");
    }
    public function set_fvoucherid($branchid)
    {
        $current = $this->getvoucherid($branchid);
        $nextpaymentid = $current + 1;
        $getdiscountid = $nextpaymentid;
        $db = db_connect();
	    $update = $db->query("UPDATE branchlookup set fvoucherid ='" . $getdiscountid . "' where branchid='$branchid'");
    }
    public function set_evoucherid($branchid)
    {
        $current = $this->getevoucherid($branchid);
        $nextpaymentid = $current + 1;
        $getdiscountid = $nextpaymentid;
        $db = db_connect();
	    $update = $db->query("UPDATE branchlookup set evoucherid ='" . $getdiscountid . "' where branchid='$branchid'");
    }
    public function get_agentapplications($userid,$batchid,$applicationstatus)
    {
        $db = db_connect();
        $query = $db->query("SELECT * from applications
                             LEFT JOIN branchlookup ON applications.branchid = branchlookup.branchid
                             LEFT JOIN reservationstatuslookup ON applications.reservationstatusid = reservationstatuslookup.reservationstatusid
                             LEFT JOIN retstatuslookup ON applications.retstatus = retstatuslookup.retid
                             LEFT JOIN admissiontypelookup ON applications.admissiontypeid = admissiontypelookup.admissiontypeid
                             LEFT JOIN courselookup ON applications.courseid = courselookup.courseid
                             LEFT JOIN genderlookup ON applications.genderid = genderlookup.genderid
                             WHERE applications.created_by = {$userid}
                             AND applications.batchid IN ({$batchid})");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function get_applications($branchid,$batchid,$applicationstatus)
    {
        $db = db_connect();
        $query = $db->query("SELECT * from applications
                             LEFT JOIN branchlookup ON applications.branchid = branchlookup.branchid
                             LEFT JOIN reservationstatuslookup ON applications.reservationstatusid = reservationstatuslookup.reservationstatusid
                             LEFT JOIN retstatuslookup ON applications.retstatus = retstatuslookup.retid
                             LEFT JOIN admissiontypelookup ON applications.admissiontypeid = admissiontypelookup.admissiontypeid
                             LEFT JOIN courselookup ON applications.courseid = courselookup.courseid
                             LEFT JOIN genderlookup ON applications.genderid = genderlookup.genderid
                             WHERE branchlookup.branchid IN ({$branchid})
                             AND applications.batchid IN ({$batchid}) and applications.reservationstatusid !=6 and applications.reservationstatusid IN({$applicationstatus})");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function get_allapplications($batchid,$applicationstatus)
    {
        $db = db_connect();
        $query = $db->query("SELECT * from applications
                             LEFT JOIN branchlookup ON applications.branchid = branchlookup.branchid
                             LEFT JOIN reservationstatuslookup ON applications.reservationstatusid = reservationstatuslookup.reservationstatusid
                             LEFT JOIN retstatuslookup ON applications.retstatus = retstatuslookup.retid
                             LEFT JOIN admissiontypelookup ON applications.admissiontypeid = admissiontypelookup.admissiontypeid
                             LEFT JOIN courselookup ON applications.courseid = courselookup.courseid
                             LEFT JOIN genderlookup ON applications.genderid = genderlookup.genderid where applications.batchid IN ({$batchid})  and applications.reservationstatusid !=6
                             ");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function get_myapplications($userid,$batchid,$applicationstatus)
    {
        $db = db_connect();
        $query = $db->query("SELECT * from applications
                             LEFT JOIN branchlookup ON applications.branchid = branchlookup.branchid
                             LEFT JOIN reservationstatuslookup ON applications.reservationstatusid = reservationstatuslookup.reservationstatusid
                             LEFT JOIN retstatuslookup ON applications.retstatus = retstatuslookup.retid
                             LEFT JOIN admissiontypelookup ON applications.admissiontypeid = admissiontypelookup.admissiontypeid
                             LEFT JOIN courselookup ON applications.courseid = courselookup.courseid
                             LEFT JOIN genderlookup ON applications.genderid = genderlookup.genderid
                             WHERE applications.transferemployee ={$userid}
                             AND applications.batchid IN ({$batchid})  and applications.reservationstatusid !=6 and applications.reservationstatusid IN({$applicationstatus})");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
	public function get_Branches($userid)
	{
        $db = db_connect();
        $query = $db->query("SELECT branchid from employeedetails
                             WHERE employeedetails.userid ={$userid}");
        $results = $query->getResult();
        $bracnhid = $results[0]->branchid;
        $query = $db->query("SELECT branchid,branchname from branchlookup
                             WHERE branchid IN ({$bracnhid})");
        $results = $query->getResult();
        $db->close();

        return $results;
	}
	public function get_applicationlookupstatus()
	{
	    $db = db_connect();
        $query = $db->query("SELECT * from reservationstatuslookup where reservationstatusid not in (2,3,6)");
        $results = $query->getResult();
        $db->close();

        return $results;
	}
	public function get_Batch()
	{
	    $db = db_connect();
        $query = $db->query("SELECT * from batchlookup");
        $results = $query->getResult();
        $db->close();

        return $results;
	}
	public function getApplicationDetails($applicationid)
	{
	    $WhereClausebatchid = $batchid == NULL ? "" : " and applications.batchid IN ({$batchid})";
        $db = db_connect();
        $query = $db->query("SELECT * from applications 
                                 LEFT JOIN branchlookup ON applications.branchid = branchlookup.branchid
                                 LEFT JOIN admissiontypelookup ON applications.admissiontypeid = admissiontypelookup.admissiontypeid
                                 LEFT JOIN courselookup ON applications.courseid = courselookup.courseid
                                 LEFT JOIN sectionlookup ON applications.sectionid = sectionlookup.sectionid
                                 LEFT JOIN genderlookup ON applications.genderid = genderlookup.genderid
                                 LEFT JOIN nationalitylookup ON applications.nationalityid = nationalitylookup.nationalityid
                                 LEFT JOIN religionlookup ON applications.religionid = religionlookup.religionid
                                 LEFT JOIN categorylookup ON applications.categoryid = categorylookup.categoryid
                                 LEFT JOIN reservationstatuslookup ON applications.reservationstatusid = reservationstatuslookup.reservationstatusid
                                    LEFT JOIN retstatuslookup ON applications.retstatus = retstatuslookup.retid
                                 WHERE applications.applicationid = '$applicationid' $WhereClausebatchid");
        $results = $query->getRow();
        $db->close();

        return $results;
	}
	public function approveddiscount()
	{
	    $db = db_connect();
        $query = $db->query("SELECT * FROM `reservation_discounts` where type=2 and status=0 and userid IN(2917,
3075,
3378,
3385,
3386,
3391,
3398,
3399,
3400,
3402,
3886,
5405,
6054,
7696,
10677,
9883,
10686,
10245,
10246,
10535,
10546,
10810,
10666,
10769,
10841,
11711);");
        $results = $query->getResult();
        $db->close();

        return $results;
	}
}
