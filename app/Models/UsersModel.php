<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\PaymentsModel;

class UsersModel extends Model
{
    public function checkReservationId($reservationid)
    {
        $db = db_connect();
        $query = $db->query("SELECT * from reservation 
                             WHERE reservation_ukey='{$reservationid}'");
        $results = $query->getResult();
        $isvalid = COUNT($results) > 0 ? "false" : "true";

        return $isvalid;
    }

    public function checkDuplicateResofastId($resofastid)
    {
        $db = db_connect();
        $query = $db->query("SELECT * from reservation 
                             WHERE rezofastdetails LIKE '%$resofastid%'");
        $results = $query->getResult();
        $isvalid = COUNT($results) > 0 ? "false" : "true";
        return $isvalid;
    }
    
    public function getAllStudentDetailsone()
    {
        $db = db_connect();
        $query = $db->query("SELECT student_class_relation.studentid as userid from student_class_relation where student_class_relation.batchid IN (select batchlookup.batchid from batchlookup where isactive=1);");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    
    public function getAllStudentDetailsonenew()
    {
        $db = db_connect();
        $query = $db->query("SELECT student_class_relation.studentid as userid from student_class_relation where student_class_relation.batchid IN (SELECT batchid FROM `batchlookup` where batchid >= (SELECT batchid FROM `batchlookup` where isactive = 1)) GROUP by student_class_relation.studentid");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    
    public function updateapplicationprofileimage($id,$profile_image)
    {
         $db = db_connect();
        $data['is_profile_uploaded'] = 1;
        $data['profile_image'] = $profile_image;
        $builder = $db->table('applications');
        $builder->where('applicationid', $id);
        $builder->update($data);
        $db->close();
    }
    public function getApplicationDetail($userid)
    {
        $db = db_connect();
        $query = $db->query("SELECT profile_image,is_profile_uploaded,application_ukey,dateofbirth,name,fathername from applications where applicationid='$userid';");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function getResevationDetail($userid)
    {
        $db = db_connect();
        $query = $db->query("SELECT profile_image,is_profile_uploaded,reservation_ukey,dateofbirth,name,fathername from reservation where reservationid='$userid';");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function updatereservationprofileimage($id,$profile_image)
    {
         $db = db_connect();
        $data['is_profile_uploaded'] = 1;
        $data['profile_image'] = $profile_image;
        $builder = $db->table('reservation');
        $builder->where('reservationid', $id);
        $builder->update($data);
        $db->close();
    }

    public function checkApplicationNumber($applicationNumber)
    {
        $db = db_connect();
        $query = $db->query("SELECT * from application_numbers 
                             WHERE applicationnumber='{$applicationNumber}'");
        $results = $query->getResult();
        $isvalid = COUNT($results) > 0 ? "true" : "false";

        if ($isvalid == "true") {
            $query = $db->query("SELECT * from users 
                             join studentdetails S on users.userid = S.userid 
                             WHERE applicationnumber='{$applicationNumber}'");
            $results = $query->getResult();
            $db->close();

            $isvalid =  COUNT($results) > 0 ? "false" : "true";
        }

        return $isvalid;
    }

    public function getscholarship($rezofastscore, $interviewscore, $batchid)
    {
        $db = db_connect();
        $query = $db->query("SELECT * FROM `rezofastscholarshiplookup` 
                             WHERE ('{$rezofastscore}' BETWEEN marks_min and marks_max) AND
                                   ('{$interviewscore}' BETWEEN interview_min and interview_max) AND
                                   (batchid = '{$batchid}')");
        $result = $query->getRow();
        $db->close();

        return $result;
    }

    public function validateAadhaar($aadhaar)
    {
        $db = db_connect();
        $query = $db->query("SELECT * FROM studentdetails 
                             WHERE studentaadhaar = '{$aadhaar}'");
        $result = $query->getRow();
        $db->close();

        return $result;
    }

    public function getAutocompleteUsers($searchfor)
    {
        $db = db_connect();
        $query = $db->query("SELECT * FROM users JOIN roleslookup ON users.roleid = roleslookup.roleid 
        join studentdetails S on users.userid = S.userid
        JOIN student_class_relation ON student_class_relation.studentid = S.userid
         WHERE S.studentstatus=1 AND (S.name like '%$searchfor%' OR
                S.mobile1 like '%$searchfor%' OR
                S.mobile2 like '%$searchfor%' OR
                S.email like '%$searchfor%' OR
                S.applicationnumber like '%$searchfor%' OR
                S.reservation_ukey like '%$searchfor%' OR
                S.rfid like '%$searchfor%') 
                AND student_class_relation.branchid IN ({$_SESSION['userdetails']->branchid}) 
                -- and student_class_relation.batchid IN ({$_SESSION['activebatch']}) 
                GROUP BY student_class_relation.studentid
                LIMIT 5");
        $results = $query->getResult();
        $userData = array();

        foreach ($results as $user) {
            $studentURL = base_url('users/studentdetails') . "?id=";

            $imageURL = file_exists("uploads/{$user->userid}/photo.jpeg") ? base_url("uploads/{$user->userid}/photo.jpeg") :  base_url('images/user-image.png');
            $data['id']    = $user->userid;
            $data['value'] = $user->name;
            if($user->reservation_ukey != '' || $user->reservation_ukey != NULL){
            $data['label'] = '<a target="_blank" href="' . $studentURL . $user->userid . '">
                <img src="' . $imageURL . '" width="50" height="50"/>
                <span>' . $user->applicationnumber . '('.$user->reservation_ukey.') - ' . $user->name . '</span><br />
                <small>' . $user->email . ', ' . $user->mobile1 . ', ' . $user->mobile2 . '</small>
            </a>';
            }else
            {
                 $data['label'] = '<a target="_blank" href="' . $studentURL . $user->userid . '">
                <img src="' . $imageURL . '" width="50" height="50"/>
                <span>' . $user->applicationnumber .' - ' . $user->name . '</span><br />
                <small>' . $user->email . ', ' . $user->mobile1 . ', ' . $user->mobile2 . '</small>
            </a>';
            }
            array_push($userData, $data);
        }

        $query = $db->query("SELECT * FROM users JOIN roleslookup ON users.roleid = roleslookup.roleid 
                             join employeedetails E on users.userid = E.userid
                             WHERE (E.name like '%$searchfor%' OR
                                    E.mobile like '%$searchfor%' OR
                                    E.email like '%$searchfor%' OR
                                    E.employeeid like '%$searchfor%' OR
                                    E.designation like '%$searchfor%' OR
                                    roleslookup.rolename like '%$searchfor%') LIMIT 5");
        $results2 = $query->getResult();
        $db->close();

        foreach ($results2 as $user) {
            $imageURL = file_exists("uploads/{$user->userid}/photo.jpeg") ? base_url("uploads/{$user->userid}/photo.jpeg") :  base_url('images/user-image.png');
            $data['id']    = $user->userid;
            $data['value'] = $user->name;
            $employeeURL = base_url('users/employeedetails') . "/";

            $data['label'] = "<a target='_blank' href='" . $employeeURL . $user->userid . "'>
                <img src='" . $imageURL . "' width='50' height='50'/>
                <span>" . $user->employeeid . " - " . $user->name . "</span><br />
                <span>" . $user->rolename . " - " . $user->designation . "</span><br />
                <small>" . $user->email . ", " . $user->mobile1 . ", " . $user->mobile2 . "</small>
            </a>";
            array_push($userData, $data);
        }

        $query = $db->query("SELECT * FROM reservation R 
                             WHERE (R.name like '%$searchfor%' OR
                                    R.mobile1 like '%$searchfor%' OR
                                    R.mobile2 like '%$searchfor%' OR
                                    R.email like '%$searchfor%' OR
                                    R.reservation_ukey like '%$searchfor%' ) and is_migrate=0");
        $results3 = $query->getResult();
        $db->close();

        foreach ($results3 as $user) {
            $data['id']    = $user->reservationid;
            $data['value'] = $user->name;
            $reservationURL = base_url('users/reservationDetails') . "?id=";

            $data['label'] = "<a target='_blank' href='" . $reservationURL . $user->reservationid . "'>
                <span>" . $user->reservation_ukey . " - " . $user->name . "</span><br />
                <small>" . $user->email . ", " . $user->mobile1 . ", " . $user->mobile2 . "</small>
            </a>";
            array_push($userData, $data);
        }
        echo json_encode($userData);
    }

    public function getAllEmployeeDetails()
    {
        $db = db_connect();
        $query = $db->query("SELECT users.password, employeedetails.mobile,employeedetails.active, employeedetails.leavespermonth,
                             employeedetails.employeeid, users.username, users.roleid, employeedetails.branchid, users.userid,
                             employeedetails.name, roleslookup.rolename, employeediscount_limit.discount, employeediscount_limit.totallimit,employeedetails.active, 
                             employeediscount_limit.availablelimit from users JOIN roleslookup ON roleslookup.roleid = users.roleid 
                             JOIN employeedetails ON users.userid = employeedetails.userid 
                             LEFT JOIN employeediscount_limit ON users.userid = employeediscount_limit.employeeid AND employeediscount_limit.batchid = '{$_SESSION['activebatch']}' where employeedetails.active=1");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function getAllEmployeeDetailsBranch($branchid)
    {
        $db = db_connect();
        $query = $db->query("SELECT users.password, employeedetails.mobile,employeedetails.active, employeedetails.leavespermonth,
                             employeedetails.employeeid, users.username, users.roleid, employeedetails.branchid, users.userid,
                             employeedetails.name, roleslookup.rolename, employeediscount_limit.discount, employeediscount_limit.totallimit,employeedetails.active, 
                             employeediscount_limit.availablelimit from users JOIN roleslookup ON roleslookup.roleid = users.roleid 
                             JOIN employeedetails ON users.userid = employeedetails.userid 
                             LEFT JOIN employeediscount_limit ON users.userid = employeediscount_limit.employeeid AND employeediscount_limit.batchid = '{$_SESSION['activebatch']}' where employeedetails.active=1 and employeedetails.branchid IN ($branchid)");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
     public function getAllEmployeeDetailsfilter($branchid,$roleid,$active)
    {
        $where ='';
        $db = db_connect();
         if ($branchid != NULL) {
            if ($where == '') {
                $where = " employeedetails.branchid IN ({$branchid})";
            } else {
                $where = $where . " AND employeedetails.branchid in ({$branchid})";
            }
        }
        if ($roleid != NULL) {
            if ($where == '') {
                $where = " users.roleid ={$roleid}";
            } else {
                $where = $where . " AND users.roleid  = {$roleid}";
            }
        }
        if ($active != NULL) {
            if ($where == '') {
                $where = " employeedetails.active ={$active}";
            } else {
                $where = $where . " AND employeedetails.active  = {$active}";
            }
        }
        $whereCondition = $where == '' ? '' : "WHERE {$where}";
        $query = $db->query("SELECT users.password, employeedetails.mobile,employeedetails.active, employeedetails.leavespermonth, employeedetails.package,
                             employeedetails.employeeid, users.username, users.roleid, employeedetails.branchid, users.userid,employeedetails.twostep_verification,
                             employeedetails.name, roleslookup.rolename, employeediscount_limit.discount, employeediscount_limit.totallimit,employeedetails.active, 
                             employeediscount_limit.availablelimit from users JOIN roleslookup ON roleslookup.roleid = users.roleid 
                             JOIN employeedetails ON users.userid = employeedetails.userid 
                             LEFT JOIN employeediscount_limit ON users.userid = employeediscount_limit.employeeid AND employeediscount_limit.batchid = '{$_SESSION['activebatch']}' $whereCondition");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function getMarketingEmployeeDetails()
    {
        $db = db_connect();
        $query = $db->query("SELECT users.password, employeedetails.mobile, employeedetails.leavespermonth, employeedetails.package,
                             employeedetails.employeeid, users.username, users.roleid, employeedetails.branchid, users.userid,
                             employeedetails.name, roleslookup.rolename from users JOIN roleslookup ON roleslookup.roleid = users.roleid 
                             JOIN employeedetails ON users.userid = employeedetails.userid
                             WHERE employeedetails.is_marketing = 1");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function getAllEmployeeDetailsById($empId)
    {
        $db = db_connect();
        $query = $db->query("SELECT users.password, employeedetails.rfid,employeedetails.mobile, employeedetails.leavespermonth, employeedetails.email, employeedetails.designation, employeedetails.package, 
                             employeedetails.employeeid, users.username, users.roleid, employeedetails.branchid, users.userid,employeedetails.login_time,employeedetails.logout_time,employeedetails.report_person,employeedetails.totalleaves,
                             employeedetails.name, roleslookup.rolename, employeediscount_limit.discount,employeediscount_limit.resdiscount, employeediscount_limit.totallimit, 
                             employeediscount_limit.availablelimit from users JOIN roleslookup ON roleslookup.roleid = users.roleid 
                             JOIN employeedetails ON users.userid = employeedetails.userid 
                             LEFT JOIN employeediscount_limit ON users.userid = employeediscount_limit.employeeid 
                             WHERE users.userid = '{$empId}'");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function getEmployeename($empId)
    {
        $db = db_connect();
        $query = $db->query("SELECT name from employeedetails WHERE employeedetails.userid = '{$empId}'");
        $results = $query->getResult();
        $db->close();
        return $results;

    }
    public function getDiscounttype($id)
    {
         $db = db_connect();
        $query = $db->query("SELECT discountname from discountlookup WHERE id = '{$id}'");
        $results = $query->getResult();
        $db->close();
        return $results;
    }

    public function get_teachers()
    {
        $db = db_connect();
        $query = $db->query("SELECT employeedetails.mobile1,employeedetails.employeeid,users.username,users.roleid,employeedetails.branchid,users.userid,employeedetails.name, roleslookup.rolename from users 
                             JOIN roleslookup ON roleslookup.roleid = users.roleid 
                             JOIN employeedetails ON users.userid = employeedetails.userid 
                             WHERE roleslookup.rolename = 'Teacher'");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function get_student_attendance($date,$branchid, $courseid,$sectionid)
    {
        $where ='';
        $db = db_connect();
        if ($branchid != NULL) {
            if ($where == '') {
                $where = " student_class_relation.branchid = {$branchid}";
            } else {
                $where = $where . " AND student_class_relation.branchid = {$branchid}";
            }
        }
        if ($courseid != NULL) {
            if ($where == '') {
                $where = " student_class_relation.courseid = {$courseid}";
            } else {
                $where = $where . " AND student_class_relation.courseid = {$courseid}";
            }
        }
        if ($sectionid != NULL) {
            if ($where == '') {
                $where = " student_class_relation.sectionid = {$sectionid}";
            } else {
                $where = $where . " AND student_class_relation.sectionid = {$sectionid}";
            }
        }
        if ($date != NULL) {
            if ($where == '') {
                $where = " SA.date = '{$date}' AND student_class_relation.batchid=3";
            } else {
                $where = $where . " AND SA.date = '{$date}' AND student_class_relation.batchid=3";
            }
        }
        $whereCondition = $where == '' ? '' : "WHERE {$where}";
        $query = $db->query("SELECT A.userid, A.name, SA.status FROM student_attendance_details SA RIGHT JOIN 
                                (SELECT SD.userid, SD.name FROM studentdetails SD where studentstatus=1) A 
                             ON SA.user_id = A.userid
                             LEFT JOIN student_class_relation ON student_class_relation.studentid = A.userid
                             LEFT JOIN branchlookup ON student_class_relation.branchid = branchlookup.branchid
                             LEFT JOIN courselookup ON student_class_relation.courseid = courselookup.courseid
                             LEFT JOIN sectionlookup ON student_class_relation.sectionid = sectionlookup.sectionid
                             {$whereCondition}");

        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function getAbsentstudentsDayscholar($date)
    {
        $db = db_connect();
        $where = "SA.status=0 and student_class_relation.admissiontypeid=3 AND student_class_relation.batchid=3 AND sectionlookup.sectionid != 115 AND is_student_workingday=1";
        if ($date != NULL) {
            if ($where == '') {
                $where = " SA.date = '{$date}'";
            } else {
                $where = $where . " AND SA.date = '{$date}'";
            }
        }
        $whereCondition = $where == '' ? '' : "WHERE {$where}";
        $query = $db->query("SELECT A.userid, A.name, SA.status,A.mobile1,A.applicationnumber FROM student_attendance_details SA RIGHT JOIN 
                                (SELECT SD.userid, SD.name,SD.mobile1,SD.applicationnumber FROM studentdetails SD) A 
                             ON SA.user_id = A.userid
                             LEFT JOIN student_class_relation ON student_class_relation.studentid = A.userid
                             LEFT JOIN branchlookup ON student_class_relation.branchid = branchlookup.branchid
                             LEFT JOIN courselookup ON student_class_relation.courseid = courselookup.courseid
                             LEFT JOIN sectionlookup ON student_class_relation.sectionid = sectionlookup.sectionid
                             JOIN business_calendar on business_calendar.date = SA.date
                             {$whereCondition}");

        $results = $query->getResult();
        $db->close();

        return $results;
        
    }
    public function getLatestudentsDayscholar($date)
    {
         $db = db_connect();
        $where = "SA.status=1 and SA.login_time BETWEEN '{$date} 08:01:00' AND '{$date} 08:30:59' and student_class_relation.admissiontypeid=3 AND student_class_relation.batchid=3 AND sectionlookup.sectionid != 115";
      
        if ($date != NULL) {
            if ($where == '') {
                $where = " SA.date = '{$date}'";
            } else {
                $where = $where . " AND SA.date = '{$date}'";
            }
        }
        $whereCondition = $where == '' ? '' : "WHERE {$where}";
        $query = $db->query("SELECT A.userid, A.name, SA.status,A.mobile1,A.applicationnumber,SA.login_time FROM student_attendance_details SA RIGHT JOIN 
                                (SELECT SD.userid, SD.name,SD.mobile1,SD.applicationnumber FROM studentdetails SD) A 
                             ON SA.user_id = A.userid
                             LEFT JOIN student_class_relation ON student_class_relation.studentid = A.userid
                             LEFT JOIN branchlookup ON student_class_relation.branchid = branchlookup.branchid
                             LEFT JOIN courselookup ON student_class_relation.courseid = courselookup.courseid
                             LEFT JOIN sectionlookup ON student_class_relation.sectionid = sectionlookup.sectionid
                             JOIN business_calendar on business_calendar.date = SA.date
                             {$whereCondition}");

        $results = $query->getResult();
        $db->close();

        return $results;
        
    }
    public function getAbsentstudentsResdential($date)
    {
        $db = db_connect();
        $where = "SA.status=0 and student_class_relation.admissiontypeid=1 AND student_class_relation.batchid=3 AND sectionlookup.sectionid != 115";
        if ($date != NULL) {
            if ($where == '') {
                $where = " SA.date = '{$date}'";
            } else {
                $where = $where . " AND SA.date = '{$date}'";
            }
        }
        $whereCondition = $where == '' ? '' : "WHERE {$where}";
        $query = $db->query("SELECT A.userid, A.name, SA.status,A.mobile1,A.applicationnumber FROM student_attendance_details SA RIGHT JOIN 
                                (SELECT SD.userid, SD.name,SD.mobile1,SD.applicationnumber FROM studentdetails SD) A 
                             ON SA.user_id = A.userid
                             LEFT JOIN student_class_relation ON student_class_relation.studentid = A.userid
                             LEFT JOIN branchlookup ON student_class_relation.branchid = branchlookup.branchid
                             LEFT JOIN courselookup ON student_class_relation.courseid = courselookup.courseid
                             LEFT JOIN sectionlookup ON student_class_relation.sectionid = sectionlookup.sectionid
                             JOIN business_calendar on business_calendar.date = SA.date
                             {$whereCondition}");

        $results = $query->getResult();
        $db->close();

        return $results;
        
    }
    public function getLatestudentsResdential($date)
    {
         $db = db_connect();
        $where = "SA.status=1 and SA.login_time BETWEEN '{$date} 06:01:00' AND '{$date} 06:30:59' and student_class_relation.admissiontypeid=1 AND student_class_relation.batchid=3 AND sectionlookup.sectionid != 115";
        if ($date != NULL) {
            if ($where == '') {
                $where = " SA.date = '{$date}'";
            } else {
                $where = $where . " AND SA.date = '{$date}'";
            }
        }
        $whereCondition = $where == '' ? '' : "WHERE {$where}";
        $query = $db->query("SELECT A.userid, A.name, SA.status,A.mobile1,A.applicationnumber,SA.login_time FROM student_attendance_details SA RIGHT JOIN 
                                (SELECT SD.userid, SD.name,SD.mobile1,SD.applicationnumber FROM studentdetails SD) A 
                             ON SA.user_id = A.userid
                             LEFT JOIN student_class_relation ON student_class_relation.studentid = A.userid
                             LEFT JOIN branchlookup ON student_class_relation.branchid = branchlookup.branchid
                             LEFT JOIN courselookup ON student_class_relation.courseid = courselookup.courseid
                             LEFT JOIN sectionlookup ON student_class_relation.sectionid = sectionlookup.sectionid
                             JOIN business_calendar on business_calendar.date = SA.date
                             {$whereCondition}");

        $results = $query->getResult();
        $db->close();

        return $results;
        
    }
    public function if_exists_delete_student_attendance($classid, $date, $userid)
    {
        $db = db_connect();
        $query = $db->query("SELECT * FROM student_attendance WHERE 
                            class_id = '{$classid}' AND date = '{$date}' AND student_id = '{$userid}'");
        $results = $query->getResult();

        if (COUNT($results) > 0) {
            $query = $db->query("DELETE FROM student_attendance WHERE 
                            class_id = '{$classid}' AND date = '{$date}' AND student_id = '{$userid}'");
            $results = $query->getResult();
        }
    }

    public function add_student_attendance($classid, $date, $userid, $status)
    {
        $this->if_exists_delete_student_attendance($classid, $date, $userid);

        $db = db_connect();

        $data['class_id'] = $classid;
        $data['date'] = $date;
        $data['student_id'] = $userid;
        $data['status'] = $status;

        $builder = $db->table('student_attendance');
        $builder->insert($data);
        $db->close();
    }

     public function get_employee_attendance($date)
    {
        $db = db_connect();
        $query = $db->query("SELECT ED.userid,ED.branchid, ED.name, EA.status, EA.loginTime, EA.logoutTime, EA.reason, EA.loginregularised,EA.logoutregularised,EA.isEarlyLogout,EA.isLatelogin,EA.lateLoginReason,EA.earlyLogoutReason
                             FROM employee_attendance EA RIGHT JOIN 
                                  employeedetails ED ON EA.employee_id = ED.userid AND EA.date = '{$date}' 
                                  WHERE ED.branchid IN ({$_SESSION['userdetails']->branchid})");

        $results = $query->getResult();
        $db->close();

        return $results;
    }

   public function get_employee_to_loginregularize()
    {
        $db = db_connect();
        $query = $db->query("SELECT EA.attendance_id, ED.userid, ED.name, EA.status, EA.loginTime, EA.logoutTime, EA.lateLoginReason AS reason, EA.loginregularised
                             FROM employee_attendance EA 
                             RIGHT JOIN employeedetails ED ON EA.employee_id = ED.userid
                             JOIN users U ON U.userid = ED.userid
                             JOIN roleslookup RL ON RL.roleid = U.roleid
                             WHERE EA.isLatelogin = 1 and loginregularised IS NULL AND
                             ED.branchid IN ({$_SESSION['userdetails']->branchid}) AND
                             RL.role_hierarchy > {$_SESSION['userdetails']->role_hierarchy}");

        $results = $query->getResult();
        $db->close();

        return $results;
    }
    
    public function get_employee_to_logoutregularize()
    {
        $db = db_connect();
        $query = $db->query("SELECT EA.attendance_id, ED.userid, ED.name, EA.status, EA.loginTime, EA.logoutTime, EA.earlyLogoutReason AS reason, EA.logoutregularised
                             FROM employee_attendance EA 
                             RIGHT JOIN employeedetails ED ON EA.employee_id = ED.userid
                             JOIN users U ON U.userid = ED.userid
                             JOIN roleslookup RL ON RL.roleid = U.roleid
                             WHERE EA.isEarlyLogout = 1 and logoutregularised IS NULL AND
                             ED.branchid IN ({$_SESSION['userdetails']->branchid}) AND
                             RL.role_hierarchy > {$_SESSION['userdetails']->role_hierarchy}");

        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function get_employee_leaveRequests()
    {
        $db = db_connect();
        $query = $db->query("SELECT LR.*, ED.name FROM leave_requests LR 
                             JOIN employeedetails ED ON LR.userid = ED.userid 
                             JOIN users U ON U.userid = ED.userid
                             JOIN roleslookup RL ON RL.roleid = U.roleid
                             WHERE LR.isapproved IS NULL AND 
                             ED.branchid IN ({$_SESSION['userdetails']->branchid})  AND ED.report_person={$_SESSION['userdetails']->userid}");

        $results = $query->getResult();
        $db->close();

        return $results;
    }
    
    public function get_employee_allleaveRequests()
    {
        $db = db_connect();
        $query = $db->query("SELECT LR.*, ED.name FROM leave_requests LR 
                             JOIN employeedetails ED ON LR.userid = ED.userid 
                             JOIN users U ON U.userid = ED.userid
                             JOIN roleslookup RL ON RL.roleid = U.roleid
                             WHERE LR.isapproved IS NULL AND 
                             ED.branchid IN ({$_SESSION['userdetails']->branchid})");

        $results = $query->getResult();
        $db->close();

        return $results;
    }
    
    public function get_employee_leaveapproved()
    {
        $db = db_connect();
        $query = $db->query("SELECT LR.*, ED.name FROM leave_requests LR 
                             JOIN employeedetails ED ON LR.userid = ED.userid 
                             JOIN users U ON U.userid = ED.userid
                             JOIN roleslookup RL ON RL.roleid = U.roleid
                             WHERE LR.isapproved = 1 AND 
                             ED.branchid IN ({$_SESSION['userdetails']->branchid}) AND ED.report_person={$_SESSION['userdetails']->userid}");

        $results = $query->getResult();
        $db->close();

        return $results;
    }
    
    public function get_employee_allleaveapproved()
    {
        $db = db_connect();
        $query = $db->query("SELECT LR.*, ED.name FROM leave_requests LR 
                             JOIN employeedetails ED ON LR.userid = ED.userid 
                             JOIN users U ON U.userid = ED.userid
                             JOIN roleslookup RL ON RL.roleid = U.roleid
                             WHERE LR.isapproved = 1 AND 
                             ED.branchid IN ({$_SESSION['userdetails']->branchid})");

        $results = $query->getResult();
        $db->close();

        return $results;
    }
    
    public function get_employee_leaverejected()
    {
        $db = db_connect();
        $query = $db->query("SELECT LR.*, ED.name FROM leave_requests LR 
                             JOIN employeedetails ED ON LR.userid = ED.userid 
                             JOIN users U ON U.userid = ED.userid
                             JOIN roleslookup RL ON RL.roleid = U.roleid
                             WHERE LR.isapproved = 0 AND 
                             ED.branchid IN ({$_SESSION['userdetails']->branchid}) AND ED.report_person={$_SESSION['userdetails']->userid}");

        $results = $query->getResult();
        $db->close();

        return $results;
    }
    
    public function get_employee_allleaverejected()
    {
        $db = db_connect();
        $query = $db->query("SELECT LR.*, ED.name FROM leave_requests LR 
                             JOIN employeedetails ED ON LR.userid = ED.userid 
                             JOIN users U ON U.userid = ED.userid
                             JOIN roleslookup RL ON RL.roleid = U.roleid
                             WHERE LR.isapproved = 0 AND 
                             ED.branchid IN ({$_SESSION['userdetails']->branchid})");

        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function get_employee_attendance_by_employeeid($empId)
    {
        $date = date('Y-m-d');
        $db = db_connect();
        $query = $db->query("SELECT business_calendar.date, business_calendar.day, business_calendar.is_employee_workingday,
                             business_calendar.comment, employee_attendance.employee_id, employee_attendance.status,
                             employee_attendance.loginTime, employee_attendance.logoutTime
                             FROM `business_calendar` 
                             LEFT JOIN employee_attendance on business_calendar.date = employee_attendance.date 
                             AND employee_id = '{$empId}' and business_calendar.date <= '$date' order by employee_attendance.attendance_id desc ");

        $results = $query->getResult();
        $db->close();

        return $results;
    }

   public function get_employee_workingdays($empId, $year, $month)
    {
        $db = db_connect();
        $query = $db->query("SELECT YEAR(A.date), MONTH(A.date), COUNT(*) AS TotalWorkingDays, COUNT(status) AS TotalDaysAttended FROM 
                                (SELECT business_calendar.date, business_calendar.is_employee_workingday FROM business_calendar WHERE is_employee_workingday = 1)A LEFT JOIN
                                (SELECT employee_attendance.date, employee_attendance.employee_id, employee_attendance.status FROM employee_attendance WHERE employee_id = '{$empId}' AND status = 1)B 
                             ON A.date = B.date WHERE YEAR(A.date) = '{$year}' AND MONTH(A.date) = '{$month}'");

        $results = $query->getResult();
        $db->close();

        return $results;
    }

   public function get_employee_lates($empId, $year, $month)
    {
       
        $db = db_connect();
        $query = $db->query("select COUNT(*) AS Lates From employee_attendance WHERE isLatelogin = 1 AND (loginregularised IS NULL OR loginregularised = 0) AND employee_id = '{$empId}' AND YEAR(date) = '{$year}' AND MONTH(date) = '{$month}'");

        $result = $query->getRow();
        $db->close();

        return $result->Lates;
    }
    public function get_employee_lateslogout($empId, $year, $month)
    {
        $db = db_connect();
        $query = $db->query("select COUNT(*) AS Lates From employee_attendance WHERE isEarlyLogout = 1 AND (logoutregularised = 0 OR  logoutregularised IS NULL) AND employee_id = '{$empId}' AND YEAR(date) = '{$year}' AND MONTH(date) = '{$month}'");

        $result = $query->getRow();
        $db->close();

        return $result->Lates;
    }

    public function check_employee_attendance($date, $userid)
    {
        $db = db_connect();
        $query = $db->query("SELECT * FROM employee_attendance WHERE 
                             date = '{$date}' AND employee_id = '{$userid}'");
        $result = $query->getRow();

        if ($result != null) {
            return false;
        } else {
            return true;
        }
    }

    public function if_exists_delete_employee_attendance($date, $userid)
    {
        $db = db_connect();
        $query = $db->query("SELECT * FROM employee_attendance WHERE 
                             date = '{$date}' AND employee_id = '{$userid}'");
        $result = $query->getRow();

        if ($result != null) {
            $builder = $db->table('employee_attendance');
            $builder->where('attendance_id', $result->attendance_id);
            $builder->delete();
        }
        $db->close();
    }

    public function add_employee_attendance($date, $userid, $status,$login,$logout)
    {
        // $this->if_exists_delete_employee_attendance($date, $userid);

        if ($this->check_employee_attendance($date, $userid)) {
            $db = db_connect();
            $data['date'] = $date;
            $data['employee_id'] = $userid;
            $data['status'] = $status;
            $data['isLatelogin'] = $login;
            $data['isEarlyLogout'] = $logout;
            $builder = $db->table('employee_attendance');
            $builder->insert($data);
            $db->close();
        } else {
            $db = db_connect();
            $data['status'] = $status;
            $data['isLatelogin'] = $login;
            $data['isEarlyLogout'] = $logout;
            $builder = $db->table('employee_attendance');
            $builder->where('date', $date);
            $builder->where('employee_id', $userid);
            $builder->update($data);
            $db->close();
        }
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
    public function update_leave_status($leaverequestid, $isapproved,$days,$userid)
    {
        $db = db_connect();
        $data['isapproved'] = $isapproved == "1" ? 1 : 0;
        $data['statusupdatedby'] = $_SESSION['userdetails']->userid;

        $builder = $db->table('leave_requests');
        $builder->where('leaverequestid', $leaverequestid);
        $builder->update($data);
        
        if($isapproved == 0)
        {
            $query1 = $db->query("SELECT * FROM `employeedetails` where userid = '$userid'");
            $results = $query1->getResult();
            $total = $results[0]->totalleaves;
             $data1['totalleaves'] = $total + $days;
             $builder = $db->table('employeedetails');
            $builder->where('userid', $userid);
            $builder->update($data1);
            $name = $results[0]->name;
            $mobile = $results[0]->mobile;
           
            $template_id = "1707167203570257889";
            $entity_id = "1701159195824664328";
            $daysvar = $days.' Days';
             
            $body = urlencode("Dear {$name}, your leave is Rejected for {$daysvar} by your reporting Manager. Resonance Hyderabad");
            $apiurl = "http://pwtpl.com/sms/V1/send-sms-api.php?apikey=dr7xJ6KiNJh7v9bk&senderid=MAIDEN&templateid=$template_id&entityid=$entity_id&number=$mobile&message=$body";

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $apiurl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET",
        )); 
        
        curl_exec($curl);
        
        curl_close($curl);
        } 
        $db->close();
    }

    public function resetphone($empid)
    {
        $db = db_connect();
        $data['otp'] = "";
        $data['status'] = "";
        $data['uniid'] = "";

        $builder = $db->table('employeedetails');
        $builder->where('userid', $empid);
        $builder->update($data);
        $db->close();
    }
    
    public function remove_report_employee($empid)
    {
        $db = db_connect();
        $data['report_person'] = NULL;
        $builder = $db->table('employeedetails');
        $builder->where('userid', $empid);
        $builder->update($data);
        $db->close();
    }
    public function updatereportemployee($userid,$id)
    {
        $db = db_connect();
        $data['report_person'] = $userid;
        $builder = $db->table('employeedetails');
        $builder->where('userid', $id);
        $builder->update($data);
        $db->close();
        
    }
    public function getAllStudentDetails()
    {
        $db = db_connect();
        $query = $db->query("SELECT * from users 
                             JOIN studentdetails ON users.userid = studentdetails.userid
                             JOIN student_class_relation ON student_class_relation.studentid = studentdetails.userid
                             LEFT JOIN branchlookup ON student_class_relation.branchid = branchlookup.branchid
                             LEFT JOIN admissiontypelookup ON student_class_relation.admissiontypeid = admissiontypelookup.admissiontypeid
                             LEFT JOIN courselookup ON student_class_relation.courseid = courselookup.courseid
                             LEFT JOIN sectionlookup ON student_class_relation.sectionid = sectionlookup.sectionid
                             LEFT JOIN applicationstatuslookup ON studentdetails.applicationstatusid = applicationstatuslookup.applicationstatusid
                             LEFT JOIN genderlookup ON studentdetails.genderid = genderlookup.genderid
                             WHERE studentdetails.studentstatus=1 and branchlookup.branchid IN ({$_SESSION['userdetails']->branchid}) 
                             and student_class_relation.batchid IN ({$_SESSION['activebatch']}) order by studentdetails.userid desc");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    
     public function getAllStudentDetailsTc()
    {
        $db = db_connect();
        $query = $db->query("SELECT tc_table.*,studentdetails.userid from tc_table JOIN studentdetails ON tc_table.application_number = studentdetails.applicationnumber
                             WHERE college_code  IN ({$_SESSION['college_code']}) 
                             ");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public  function getAllPendingStudenDetails()
    {
        $db = db_connect();
        $query = $db->query("SELECT * from users 
                             join studentdetails S on users.userid = S.userid
                             JOIN student_class_relation ON student_class_relation.studentid = S.userid
                             JOIN branchlookup ON student_class_relation.branchid = branchlookup.branchid
                             JOIN admissiontypelookup ON student_class_relation.admissiontypeid = admissiontypelookup.admissiontypeid
                             JOIN courselookup ON student_class_relation.courseid = courselookup.courseid
                             JOIN sectionlookup ON student_class_relation.sectionid = sectionlookup.sectionid
                             JOIN applicationstatuslookup ON S.applicationstatusid = applicationstatuslookup.applicationstatusid
                             WHERE S.studentstatus=1 and S.applicationstatusid <> 2 and S.applicationstatusid <> 4 and S.applicationstatusid <> 5 
                             and branchlookup.branchid IN ({$_SESSION['userdetails']->branchid})
                             and student_class_relation.batchid IN ({$_SESSION['activebatch']})");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function getStudentDetails($userid, $batchid = NULL)
    {
        $WhereClausebatchid = $batchid == NULL ? "" : " and studentdetails.studentstatus=1 and student_class_relation.batchid IN ({$batchid})";
        $db = db_connect();
        $query = $db->query("SELECT * from users 
                             JOIN studentdetails ON users.userid = studentdetails.userid
                             JOIN student_class_relation ON student_class_relation.studentid = studentdetails.userid
                             LEFT JOIN batchlookup ON student_class_relation.batchid = batchlookup.batchid
                             LEFT JOIN branchlookup ON student_class_relation.branchid = branchlookup.branchid
                             LEFT JOIN admissiontypelookup ON student_class_relation.admissiontypeid = admissiontypelookup.admissiontypeid
                             LEFT JOIN courselookup ON student_class_relation.courseid = courselookup.courseid
                             LEFT JOIN sectionlookup ON student_class_relation.sectionid = sectionlookup.sectionid
                             LEFT JOIN applicationstatuslookup ON studentdetails.applicationstatusid = applicationstatuslookup.applicationstatusid
                             LEFT JOIN genderlookup ON studentdetails.genderid = genderlookup.genderid
                             LEFT JOIN nationalitylookup ON studentdetails.nationalityid = nationalitylookup.nationalityid
                             LEFT JOIN religionlookup ON studentdetails.religionid = religionlookup.religionid
                             LEFT JOIN categorylookup ON studentdetails.categoryid = categorylookup.categoryid
                             
                             WHERE users.userid = $userid $WhereClausebatchid");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    
    public function getStudentDetailsTc($userid, $batchid = NULL)
    {
        $db = db_connect();
        $query = $db->query("SELECT * from tc_table 
                             WHERE tc_table.id = $userid");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    
    public function getApplicationDetails($reservationId)
    {
        //$WhereClausebatchid = $batchid == NULL ? "" : " and applications.batchid IN ({$batchid})";
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
                                 WHERE applications.applicationid = '$reservationId'");
        $results = $query->getRow();
        $db->close();

        return $results;
    }

    public function getStudentDetailsByUniqueId($uniqueid)
    {
        $db = db_connect();
        $query = $db->query("SELECT * from users 
                             JOIN studentdetails ON users.userid = studentdetails.userid
                             JOIN student_class_relation ON student_class_relation.studentid = studentdetails.userid
                             LEFT JOIN branchlookup ON student_class_relation.branchid = branchlookup.branchid
                             LEFT JOIN admissiontypelookup ON student_class_relation.admissiontypeid = admissiontypelookup.admissiontypeid
                             LEFT JOIN courselookup ON student_class_relation.courseid = courselookup.courseid
                             LEFT JOIN sectionlookup ON student_class_relation.sectionid = sectionlookup.sectionid
                             LEFT JOIN applicationstatuslookup ON studentdetails.applicationstatusid = applicationstatuslookup.applicationstatusid
                             LEFT JOIN genderlookup ON studentdetails.genderid = genderlookup.genderid
                             LEFT JOIN nationalitylookup ON studentdetails.nationalityid = nationalitylookup.nationalityid
                             LEFT JOIN religionlookup ON studentdetails.religionid = religionlookup.religionid
                             LEFT JOIN categorylookup ON studentdetails.categoryid = categorylookup.categoryid
                             WHERE users.uniqueid = '$uniqueid'");
        $result = $query->getRow();
        $db->close();

        return $result;
    }

    public function getStudentDetailsByApplicationNumber($applicationNumber)
    {
        $db = db_connect();
        $query = $db->query("SELECT * from users 
                             JOIN studentdetails ON users.userid = studentdetails.userid
                             JOIN student_class_relation ON student_class_relation.studentid = studentdetails.userid
                             LEFT JOIN branchlookup ON student_class_relation.branchid = branchlookup.branchid
                             LEFT JOIN admissiontypelookup ON student_class_relation.admissiontypeid = admissiontypelookup.admissiontypeid
                             LEFT JOIN courselookup ON student_class_relation.courseid = courselookup.courseid
                             LEFT JOIN sectionlookup ON student_class_relation.sectionid = sectionlookup.sectionid
                             LEFT JOIN applicationstatuslookup ON studentdetails.applicationstatusid = applicationstatuslookup.applicationstatusid
                             LEFT JOIN genderlookup ON studentdetails.genderid = genderlookup.genderid
                             LEFT JOIN nationalitylookup ON studentdetails.nationalityid = nationalitylookup.nationalityid
                             LEFT JOIN religionlookup ON studentdetails.religionid = religionlookup.religionid
                             LEFT JOIN categorylookup ON studentdetails.categoryid = categorylookup.categoryid
                             WHERE studentdetails.applicationnumber = '$applicationNumber'");
        $result = $query->getRow();
        $db->close();

        return $result;
    }

    public function addUser($uniqueid, $username, $password, $roleid)
    {
        $db = db_connect();
        $data['uniqueid'] = $uniqueid;
        $data['username'] = $username;
        $data['password'] = $password;
        $data['roleid'] = $roleid;

        $builder = $db->table('users');
        $builder->insert($data);
        $insertId = $db->insertID();
        if ($insertId == 0) {
            $random = rand(0, 999999);
            $now = date('dmYHisu') . $random;
            $U = "USR-" . $now;
            $P = md5($username);
            return $this->addUser($uniqueid, $U, $P, $roleid);
        } else {
            return $insertId;
        }
    }

    public function updateUser($userid, $username, $password, $roleid)
    {
        $db = db_connect();
        $data['username'] = $username;
        $data['password'] = $password;
        $data['roleid'] = $roleid;

        $builder = $db->table('users');
        $builder->where('userid', $userid);
        $builder->update($data);

        $db->close();
    }

    public function deleteUser($userid)
    {
        $db = db_connect();
        $builder = $db->table('users');
        $builder->where('userid', $userid);
        $builder->delete();

        $db->close();
    }

    public function promoteUserold($userid, $batchid)
    {
        $studentDetails = $this->getStudentDetails($userid, $_SESSION['activebatch']);

        $db = db_connect();
        $data['studentid'] = $userid;
        $data['batchid'] = $batchid;
        $data['branchid'] = $studentDetails[0]->branchid;
        $data['courseid'] = $studentDetails[0]->courseid;
        $data['sectionid'] = $studentDetails[0]->sectionid;
        $data['admissiontypeid'] = $studentDetails[0]->admissiontypeid;
        print_r($data);
        exit();
        $builder = $db->table('student_class_relation');
        $builder->insert($data);

        $db->close();

        $paymentmodel = new PaymentsModel();
        return $paymentmodel->generateInvoice($userid, $batchid);
    }
    
    public function promoteUser($userid,
    $admissiontypeid,
    $branchid,
    $batchid,
    $courseid,
    $sectionid,$tuition_discount,$ipe_discount,
                $hostel_discount)
    {

        $db = db_connect();
        $data['studentid'] = $userid;
        $data['batchid'] = $batchid;
        $data['branchid'] = $branchid;
        $data['courseid'] = $courseid;
        $data['sectionid'] = $sectionid;
        $data['admissiontypeid'] = $admissiontypeid;
        $builder = $db->table('student_class_relation');
        $builder->insert($data);
        $paymentmodel = new PaymentsModel();
        return $paymentmodel->generatePromoteInvoice($userid,$courseid,$admissiontypeid, $batchid,$tuition_discount,$ipe_discount,
                $hostel_discount);
    }

    public function addEmployee($userid, $name, $branchid, $designation, $mobile, $employee_id, $email,$totalleaves,$joiningdate,$gender,$pancard,$login_time,$logout_time,$reportperson)
    {
      //  ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
        $db = db_connect();
        $data['userid'] = $userid;
        $data['name'] = $name;
        $data['branchid'] = $branchid;
        $data['designation'] = $designation;
        $data['mobile'] = $mobile;
        $data['employeeid'] = $employee_id;
        $data['email'] = $email;
        $data['totalleaves'] =$totalleaves;
        $data['report_person'] =$reportperson;
        $data['joiningdate'] =$joiningdate;
        $data['gender'] =$gender;
        $data['pancard']=$pancard;
        $data['login_time'] =$login_time;
        $data['logout_time'] =$logout_time;
        $db = db_connect();
        $query = $db->query("SELECT * from employeedetails WHERE employeeid='{$employee_id}'");
        $results = $query->getResult();
        if(count($results) == 0 ){
           
        $builder = $db->table('employeedetails');
        return $builder->insert($data);
        }
    }

    public function updateEmployee($userid, $name, $branchid, $designation, $mobile, $email, $leavespermonth,$logintime,$logouttime,$marketing,$totalleaves,$reportperson)
    {
        $db = db_connect();
        $data['name'] = $name;
        $data['branchid'] = $branchid;
        $data['designation'] = $designation;
        $data['mobile'] = $mobile;
        $data['email'] = $email;
        $data['leavespermonth'] = $leavespermonth;
        $data['totalleaves'] = $totalleaves;
        $data['login_time'] = $logintime;
        $data['logout_time'] = $logouttime;
        $data['is_marketing'] = $marketing;
        $data['report_person'] = $reportperson;
        $builder = $db->table('employeedetails');
        $builder->where('userid', $userid);
        $builder->update($data);
    }
    public function updateEmployeestatus($userid, $user_status)
    {
        $db = db_connect();
        $data['active'] = $user_status;
        $builder = $db->table('employeedetails');
        $builder->where('userid', $userid);
        $builder->update($data);
    }
     public function updateEmployeeTwoStepstatus($userid, $user_status)
    {
        $db = db_connect();
        $data['twostep_verification'] = $user_status;
        $builder = $db->table('employeedetails');
        $builder->where('userid', $userid);
        $builder->update($data);
    }


    public function update_employee_package($newPackage, $userid)
    {
        $db = db_connect();
        $data['package'] = $newPackage;

        $builder = $db->table('employeedetails');
        $builder->where('userid', $userid);
        $builder->update($data);
    }

    public function addStudentApplicationDetails(
                $userid,
                $applicationnumber,
                $reservation_ukey,
                $studentaadhaar,
                $room,
                $admissiontypeid,
                $branchid,
                $batchid,
                $courseid,
                $sectionid
    ) {
        $db = db_connect();
        $data['userid'] = $userid;
        $data['applicationnumber'] = $applicationnumber;
        $data['reservation_ukey'] = $reservation_ukey;
        $data['studentaadhaar'] = $studentaadhaar;
        $data['applicationstatusid'] = 1;
        $data['created_by'] = $_SESSION['userdetails']->userid;
        $builder = $db->table('studentdetails');
        $status = $builder->insert($data);
        $db->close();
        if ($status) {
            $db1 = db_connect();
            $data1['studentid'] = $userid;
            $data1['admissiontypeid'] = $admissiontypeid;
            $data1['branchid'] = $branchid;
            $data1['batchid'] = $batchid;
            $data1['courseid'] = $courseid;
            $data1['sectionid'] = $sectionid;
            $builder1 = $db1->table('student_class_relation');
            $status1 = $builder1->insert($data1);
            $db->close();
        }
    }

    public function dynamicStudentDetailsUpdate($data, $userid)
    {
        $db = db_connect();

        $builder = $db->table('studentdetails');
        $builder->where('userid', $userid);
        $builder->update($data);
    }

    public function addStudent(
        $userid,
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
        $previous_class_information,
        $address,
        $mobile1,
        $mobile2,
        $email,
        $admissiontypeid,
        $branchid,
        $courseid,
        $sectionid,
        $secondlanguageid,
        $applicationstatusid,
        $applicationnumber,
        $comments,
        $referredby,
        $batchid,
        $admissiondate,
        $tuition_discount,
        $hostel_discount,
        $cheque_details = "[]",
        $scholarship
    ) {
        $db = db_connect();
        $data['userid'] = $userid;
        $data['name'] = $name;
        $data['dateofbirth'] = $dateofbirth;
        $data['genderid'] = $genderid;
        $data['nationalityid'] = $nationalityid;
        $data['religionid'] = $religionid;
        $data['categoryid'] = $categoryid;
        $data['studentaadhaar'] = $studentaadhaar;
        $data['fathername'] = $fathername;
        $data['mothername'] = $mothername;
        $data['parentoccupation'] = $parentoccupation;
        $data['previous_class_information'] = $previous_class_information;
        $data['address'] = $address;
        $data['mobile1'] = $mobile1;
        $data['mobile2'] = $mobile2;
        $data['email'] = $email;

        $data['secondlanguageid'] = $secondlanguageid;
        $data['applicationstatusid'] = $applicationstatusid;
        $data['applicationnumber'] = $applicationnumber;
        $data['comments'] = $comments;
        $data['referredby'] = $referredby;
        $data['admissiondate'] = $admissiondate;

        $data['tuition_discount'] = $tuition_discount;
        $data['hostel_discount'] = $hostel_discount;
        $data['scholarship'] = $scholarship;

        $data['cheque_details'] = $cheque_details;

        $data['created_by'] = $_SESSION['userdetails']->userid;

        $builder = $db->table('studentdetails');
        $status = $builder->insert($data);

        $db->close();

        $db1 = db_connect();
        $data1['studentid'] = $userid;
        $data1['admissiontypeid'] = $admissiontypeid;
        $data1['branchid'] = $branchid;
        $data1['courseid'] = $courseid;
        $data1['batchid'] = $batchid;
        $data1['sectionid'] = $sectionid;

        $builder1 = $db1->table('student_class_relation');
        $status1 = $builder1->insert($data1);

        $db->close();
    }

    public function addQuickStudent(
        $userid,
        $name,
        $mobile1,
        $email,
        $admissiontypeid,
        $branchid,
        $courseid,
        $secondlanguageid,
        $applicationstatusid,
        $applicationnumber,
        $comments,
        $referredby,
        $batchid,
        $admissiondate,
        $tuition_discount,
        $hostel_discount,
        $cheque_details,
        $scholarship
    ) {
        $db = db_connect();
        $data['userid'] = $userid;
        $data['name'] = $name;
        $data['mobile1'] = $mobile1;
        $data['email'] = $email;

        $data['secondlanguageid'] = $secondlanguageid;
        $data['applicationstatusid'] = $applicationstatusid;
        $data['applicationnumber'] = $applicationnumber;
        $data['comments'] = $comments;
        $data['referredby'] = $referredby;
        $data['admissiondate'] = $admissiondate;

        $data['tuition_discount'] = $tuition_discount;
        $data['hostel_discount'] = $hostel_discount;
        $data['scholarship'] = $scholarship;

        $data['cheque_details'] = $cheque_details;

        $data['created_by'] = $_SESSION['userdetails']->userid;

        $builder = $db->table('studentdetails');
        $status = $builder->insert($data);

        $db->close();

        $db1 = db_connect();
        $data1['studentid'] = $userid;
        $data1['admissiontypeid'] = $admissiontypeid;
        $data1['branchid'] = $branchid;
        $data1['courseid'] = $courseid;
        $data1['batchid'] = $batchid;
        $data1['sectionid'] = 1;

        $builder1 = $db1->table('student_class_relation');
        $status1 = $builder1->insert($data1);

        $db->close();
    }

    public function updateStudent(
        $userid,
        $name = NULL,
        $dateofbirth,
        $genderid,
        $nationalityid,
        $religionid,
        $categoryid,
        $studentaadhaar,
        $room,
        $fathername,
        $mothername,
        $parentoccupation,
        $previous_class_information,
        $address,
        $mobile1 = NULL,
        $mobile2,
        $email = NULL,
        $admissiontypeid = NULL,
        $branchid = NULL,
        $courseid = NULL,
        $sectionid = NULL,
        $secondlanguageid = NULL,
        $cheque_details = NULL,
        $tuition_discount = NULL,
        $hostel_discount = NULL,
        $comments = NULL,
        $applicationstatusid = 0,
        $batchid
    ) {
        $db = db_connect();
        $data['dateofbirth'] = $dateofbirth;
        $data['genderid'] = $genderid;
        $data['nationalityid'] = $nationalityid;
        $data['religionid'] = $religionid;
        $data['categoryid'] = $categoryid;
        $data['studentaadhaar'] = $studentaadhaar;
        $data['roomnumber'] = $room;
        $data['fathername'] = $fathername;
        $data['mothername'] = $mothername;
        $data['parentoccupation'] = $parentoccupation;
        $data['previous_class_information'] = $previous_class_information;
        $data['address'] = $address;
        $data['mobile2'] = $mobile2;

        $data['updated_by'] = $_SESSION['userdetails']->userid == null ? $userid : $_SESSION['userdetails']->userid;

        if ($name != NULL) {
            $data['name'] = $name;
        }
        if ($mobile1 != NULL) {
            $data['mobile1'] = $mobile1;
        }
        if ($email != NULL) {
            $data['email'] = $email;
        }
        if ($secondlanguageid != NULL) {
            $data['secondlanguageid'] = $secondlanguageid;
        }

        if ($secondlanguageid != NULL) {
            $data['cheque_details'] = $cheque_details;
        }

        if ($tuition_discount != NULL) {
            $data['tuition_discount'] = $tuition_discount;
        }
        if ($hostel_discount != NULL) {
            $data['hostel_discount'] = $hostel_discount;
        }
        if ($comments != NULL) {
            $data['comments'] = $comments;
        }
        if ($applicationstatusid != 0) {
            $data['applicationstatusid'] = $applicationstatusid;
        }

        if ($admissiontypeid == NULL && $branchid == NULL && $courseid == NULL && $secondlanguageid == NULL && $sectionid == NULL) {
            $data['verifiedbyuser'] = 1;
        }

        $builder = $db->table('studentdetails');
        $builder->where('userid', $userid);
        
        $builder->update($data);

        if ($admissiontypeid != NULL) {
            $data1['admissiontypeid'] = $admissiontypeid;
        }
        if ($branchid != NULL) {
            $data1['branchid'] = $branchid;
        }
        if ($courseid != NULL) {
            $data1['courseid'] = $courseid;
        }
        if ($sectionid != NULL) {
            $data1['sectionid'] = $sectionid;
        }

        $builder = $db->table('student_class_relation');
        $builder->where('studentid', $userid);
        $builder->where('batchid', $batchid);
        $builder->update($data1);
    }
    public function insertQuickStudent(
        $application_number,
                $tc_no,
                $year,
                $admission_no,
                $admission_year,
                $college_code,
                $rc_no,
                $address,
                $place,
                $district,
                $class,
                $admission_date,
                $class_joined,
                $scholarship,
                $concession,
                $date_left,
                $tc_date,
                $conduct,
                $name,
                $fathername,
                $mothername,
                $dob,
                $caste,
                $subcaste,
                $nationality,
                $medium,
                $eligible,
                $qualified,
                $mothertounge,
                $firstlanguage,
                $secondlanguage,
                $optionals
                )
    {
        $db = db_connect();
            $data['application_number'] = $application_number;
            $data['tc_no'] =     $tc_no;
            $data['year'] =    $year;
            $data['admission_no'] =   $admission_no;
            $data['admission_year'] =   $admission_year;
            $data['college_code'] =  $college_code;
            $data['rc_no'] =    $rc_no;
            $data['address'] =     $address;
            $data['place'] =    $place;
            $data['district'] =   $district;
            $data['class'] =  $class;
            $data['admission_date'] =   $admission_date;
            $data['class_joined'] =   $class_joined;
            $data['scholarship'] =   $scholarship;
            $data['concession'] =  $concession;
            $data['date_left'] =   $date_left;
            $data['tc_date'] =  $tc_date;
            $data['conduct'] =  $conduct;
            $data['caste'] = $caste;
            $data['subcaste'] = $subcaste;
            $data['eligible'] = $eligible;
            $data['qualified'] = $qualified;
            $data['name'] = $name;
            $data['fathername'] = $fathername;
            $data['mothername'] = $mothername;
            $data['dob'] = $dob;
            $data['nationality'] = $nationality;
            $data['medium'] = $medium;
            $data['mother_tounge'] = $mothertounge;
            $data['first_language'] = $firstlanguage;
            $data['second_language'] = $secondlanguage;
            $data['optionals'] = $optionals;
            $builder = $db->table('tc_table');
      $user =  $builder->insert($data);
     return $db->insertID();
        $db->close();
    }

    public function updateQuickStudent(
        $userid,
        $name,
        $fathername,
        $mothername,
        $dob,
        $caste,
        $subcaste,
        $nationality,
        $medium,
        $eligible,
        $qualified,
        $mothertounge,
        $firstlanguage,
        $secondlanguage,
        $optionals,
        $conduct
    ) {
        $db = db_connect();
        $data['caste'] = $caste;
        $data['subcaste'] = $subcaste;
         $data['eligible'] = $eligible;
         $data['qualified'] = $qualified;
        $data['name'] = $name;
        $data['fathername'] = $fathername;
        $data['mothername'] = $mothername;
        $data['dob'] = $dob;
        $data['nationality'] = $nationality;
        $data['medium'] = $medium;
        $data['mother_tounge'] = $mothertounge;
        $data['first_language'] = $firstlanguage;
        $data['second_language'] = $secondlanguage;
        $data['optionals'] = $optionals;
        $data['conduct'] =  $conduct;

        $data['updated_by'] = $_SESSION['userdetails']->userid == null ? $userid : $_SESSION['userdetails']->userid;

        $builder = $db->table('tc_table');
        $builder->where('id', $userid);
        $builder->update($data);
    }

    public function deleteEmployee($userid)
    {
        $db = db_connect();
        $builder = $db->table('employeedetails');
        $builder->where('userid', $userid);
        $builder->delete();
    }

    public function deleteStudent($userid)
    {
        $db = db_connect();
        $builder = $db->table('studentdetails');
        $builder->where('userid', $userid);
        $builder->delete();

        $builder = $db->table('student_class_relation');
        $builder->where('studentid', $userid);
        $builder->delete();

        $builder = $db->table('invoices');
        $builder->where('userid', $userid);
        $builder->delete();

        $builder = $db->table('payments');
        $builder->where('userid', $userid);
        $builder->delete();

        $builder = $db->table('payment_links');
        $builder->where('userid', $userid);
        $builder->delete();

        $builder = $db->table('student_attendance');
        $builder->where('userid', $userid);
        $builder->delete();

        // $builder = $db->table('rezofast');
        // $data['userid'] = NULL;
        // $builder->where('userid', $userid);
        // $builder->update($data);
    }

    public function approveStudent($userid, $comments, $applicationstatusid)
    {
        $db = db_connect();

        $data['comments'] = $comments;
        $data['applicationstatusid'] = $applicationstatusid;
        $data['approved_by'] = $_SESSION['userdetails']->userid == null ? 0 : $_SESSION['userdetails']->userid;
        $data['approved_date'] = date('Y-m-d');

        $builder = $db->table('studentdetails');
        $builder->where('userid', $userid);
        $builder->update($data);

        $paymentmodel = new PaymentsModel();
        return $paymentmodel->generateInvoice($userid);
    }
    
    public function approveReservationStudent($userid, $comments, $applicationstatusid)
    {
        $db = db_connect();

        $data['comments'] = $comments;
        $data['applicationstatusid'] = $applicationstatusid;
        $data['approved_by'] = $_SESSION['userdetails']->userid == null ? 0 : $_SESSION['userdetails']->userid;
        $data['approved_date'] = date('Y-m-d');

        $builder = $db->table('studentdetails');
        $builder->where('userid', $userid);
        $builder->update($data);

        $paymentmodel = new PaymentsModel();
        return $paymentmodel->generateReservationInvoice($userid);
    }

    public function declineStudent($userid, $comments, $applicationstatusid)
    {
        $db = db_connect();

        $data['comments'] = $comments;
        $data['applicationstatusid'] = $applicationstatusid;
        $data['updated_by'] = $_SESSION['userdetails']->userid == null ? 0 : $_SESSION['userdetails']->userid;

        $builder = $db->table('studentdetails');
        $builder->where('userid', $userid);
        $builder->update($data);
    }

    public function dropStudent($userid)
    {
        $db = db_connect();

        $data['applicationstatusid'] = 5;
        $data['updated_by'] = $_SESSION['userdetails']->userid == null ? 0 : $_SESSION['userdetails']->userid;

        $builder = $db->table('studentdetails');
        $builder->where('userid', $userid);
        $builder->update($data);
    }
    public function updateremark($userid,$remarks,$date){
        $db = db_connect();
        $data['remarks'] = $remarks;
        $data['remarkdate'] = $date;
        $builder = $db->table('studentdetails');
        $builder->where('userid', $userid);
        $builder->update($data);
    }
     public function updateidcard($userid,$rfid){
        
        $db = db_connect();
        $data['rfid'] = $rfid;
        $builder = $db->table('studentdetails');
        $builder->where('userid', $userid);
        $builder->update($data);
    }
    public function updaterfidcard($userid,$rfid){
        
        $db = db_connect();
        $data['rfid'] = $rfid;
        $builder = $db->table('employeedetails');
        $builder->where('userid', $userid);
        $builder->update($data);
    }
    public function checkDuplicateRfid($rfid)
    {
        $db = db_connect();
        $query = $db->query("SELECT rfid from studentdetails 
                             WHERE rfid = '$rfid'");
        $results = $query->getResult();
        $isvalid = COUNT($results) > 0 ? 1 : 0;

        return $isvalid;
    }
     public function checkDuplicateRfidEmployee($rfid)
    {
        $db = db_connect();
        $query = $db->query("SELECT rfid from employeedetails 
                             WHERE rfid = '$rfid'");
        $results = $query->getResult();
        $isvalid = COUNT($results) > 0 ? 1 : 0;

        return $isvalid;
    }
    public function getbranches()
    {
         $db = db_connect();
        $query = $db->query("SELECT * from branchlookup");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
     public function get_tc_details($userid)
    {
        //$WhereClausebatchid = $batchid == NULL ? "" : " and student_class_relation.batchid IN ({$batchid})";
        $db = db_connect();
        $query = $db->query("SELECT * from tc_table WHERE application_number = '".$userid."'");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function get_reporting_employees($empid)
    {
         $db = db_connect();
        $query = $db->query("SELECT employeedetails.name,employeedetails.userid  from employeedetails WHERE report_person = '".$empid."' and active=1");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function getNonReportEmployees($empid)
    {
         $db = db_connect();
        $query = $db->query("SELECT employeedetails.name,employeedetails.userid  from employeedetails WHERE  active=1 and (report_person != {$empid}  or report_person is null)");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function getattendanceByUserId($userid,$from,$to)
    {
        $where = " employeedetails.userid='{$userid}'";
        if ($from != NULL) {
            if ($where == '') {
                $where = " employee_attendance.date >= '{$from}'";
            } else {
                $where = $where . " AND employee_attendance.date >= '{$from}'";
            }
        }
        if ($to != NULL) {
            if ($where == '') {
                $where = " employee_attendance.date <= '{$to}'";
            } else {
                $where = $where . " AND employee_attendance.date <= '{$to}'";
            }
        }

        $whereCondition = $where == '' ? '' : "WHERE {$where}";
        $db = db_connect();
        $query = $db->query("SELECT employeedetails.name,employeedetails.employeeid,employeedetails.email,employee_attendance.loginregularised,employee_attendance.logoutregularised,employeedetails.mobile,employee_attendance.status,employee_attendance.loginTime,employee_attendance.logoutTime,isLatelogin,isEarlyLogout,employee_attendance.date FROM employee_attendance JOIN employeedetails ON employee_attendance.employee_id = employeedetails.userid {$whereCondition}");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function getinvoicevalue($invoiceid,$userid)
    {
        $db = db_connect();
        $query = $db->query("SELECT InvoiceDetails.*, InvoiceDetails.userid, InvoiceDetails.TotalValue,InvoiceDetails.admissiontypeid,
                              PaymentDetails.TotalPaid,InvoiceDetails.branchid FROM
                                 (SELECT student_class_relation.branchid,student_class_relation.batchid, SUM(invoices.feesvalue) as TotalValue, studentdetails.userid, admissiontypelookup.admissiontypeid
                                 from invoices JOIN users ON invoices.userid = users.userid 
                                 JOIN studentdetails ON studentdetails.userid = users.userid 
                                 JOIN student_class_relation ON student_class_relation.studentid = studentdetails.userid
                                 JOIN admissiontypelookup ON student_class_relation.admissiontypeid = admissiontypelookup.admissiontypeid
                                 WHERE student_class_relation.batchid =3 and invoices.batchid=3 and invoices.invoiceid='$invoiceid' and student_class_relation.studentid =$userid
                                 GROUP BY student_class_relation.studentid) InvoiceDetails
                                 LEFT JOIN
                                 (SELECT SUM(payments.paymentamount) as TotalPaid, payments.userid FROM payments JOIN users ON payments.userid = users.userid where payments.batchid=3 and payments.invoice='$invoiceid' GROUP BY payments.userid) PaymentDetails ON InvoiceDetails.userid = PaymentDetails.userid");
        $results = $query->getRowArray();
        $db->close();
        return $results;
    }
    public function get_BankAccounts($empid)
    {
         $db = db_connect();
        $query = $db->query("SELECT * from employee_bankdetails WHERE employeeid = '".$empid."'");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function addBankAccount($userid,$bank_name,$branch_name,$account_no,$ifsc_code,$is_active)
    {
         $db = db_connect();

        $data['bank_name'] = $bank_name;
        $data['branch_name'] = $branch_name;
        $data['employeeid'] = $userid;
        $data['account_no'] = $account_no;
        $data['is_active'] = $is_active;
        $data['ifsc_code'] = $ifsc_code;

        $builder = $db->table('employee_bankdetails');
        $builder->insert($data);
        $db->close();
    }
    public function editBankAccount($id,$bank_name,$branch_name,$account_no,$ifsc_code,$is_active)
    {
        $db = db_connect();

        $data['bank_name'] = $bank_name;
        $data['branch_name'] = $branch_name;
        $data['account_no'] = $account_no;
        $data['is_active'] = $is_active;
        $data['ifsc_code'] = $ifsc_code;

        $builder = $db->table('employee_bankdetails');
        $builder->where('id', $id);
        $builder->update($data);
    }
    public function get_SalaryStructure($empid)
    {
         $db = db_connect();
        $query = $db->query("SELECT * from employeesalarygrades WHERE employeeid = '".$empid."'");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function addSalaryStructure($userid,$basic,$hra,$specialallowance,$travelallowance,$pt,$tds)
    {
         $db = db_connect();

        $data['basic'] = $basic;
        $data['houserentalallowance'] = $hra;
        $data['employeeid'] = $userid;
        $data['specialallowance'] = $specialallowance;
        $data['transportallowance'] = $travelallowance;
        $data['tds'] = $tds;
        $data['pt'] = $pt;
        $builder = $db->table('employeesalarygrades');
        $builder->insert($data);
        $db->close();
    }
    public function addInsurance($userid,$policy_no,$provider,$url)
    {
         $db = db_connect();
        $data['policy_no'] = $policy_no;
        $data['userid'] = $userid;
        $data['provider'] = $provider;
        $data['url'] = $url;
        $builder = $db->table('employee_insurance');
        $builder->insert($data);
        $db->close();
    }
    public function updateActiveSalary($userid)
    {
        $db = db_connect();
        $data['is_active'] = 0;
        $builder = $db->table('employeesalarygrades');
        $builder->where('employeeid', $userid);
        $builder->update($data);
        $db->close();
    }
    public function editSalaryStructure($id,$basic,$hra,$specialallowance,$travelallowance,$pt,$tds,$is_active)
    {
        $db = db_connect();
        $data['basic'] = $basic;
        $data['houserentalallowance'] = $hra;
        $data['specialallowance'] = $specialallowance;
        $data['is_active'] = $is_active;
        $data['transportallowance'] = $travelallowance;
        $data['tds'] = $tds;
        $data['pt'] = $pt;
        $builder = $db->table('employeesalarygrades');
        $builder->where('salarygradeid', $id);
        $builder->update($data);
    }
    public function getMaxPayment($invoice,$userid)
    {
         $db = db_connect();
         $batchid = $_SESSION['activebatch'];
        $query = $db->query("SELECT sum(paymentamount) as amount,invoice  from payments where invoice=(select invoiceid from invoices where invoice={$invoice} and userid={$userid} and batchid=$batchid group by invoiceid)");
        $results = $query->getResult();
        $db->close();
        return $results;
        //and userid=7814);
    }
     public function getMaxInvoice($invoice,$userid)
    {
         $db = db_connect();
         $batchid = $_SESSION['activebatch'];
        $query = $db->query("SELECT sum(feesvalue) as amount from invoices where invoice=$invoice and batchid=$batchid and userid=$userid");
        $results = $query->getResult();
        $db->close();
        return $results;
        //and userid=7814);
    }
    public function updateActiveBankAccount($userid)
    {
        $db = db_connect();
        $data['is_active'] = 0;
        $builder = $db->table('employee_bankdetails');
        $builder->where('employeeid', $userid);
        $builder->update($data);
        $db->close();
    }
     public function getActiveBatch()
    {
        $db = db_connect();
        $query = $db->query("select batchlookup.batchid from batchlookup where isactive=1");
        $results = $query->getResult();
        $db->close();
        return $results;
    }
     public function get_Loans($empid)
    {
        $db = db_connect();
        $query = $db->query("SELECT employee_loans.*,Cr.name AS CreatedBy, Up.Name as UpdatedBy,employeedetails.userid,employeedetails.employeeid,employeedetails.name FROM `employee_loans` join employeedetails on employee_loans.employee_id=employeedetails.userid JOIN employeedetails Cr on employee_loans.created_by = Cr.userid
        LEFT JOIN employeedetails Up on employee_loans.approved_by = Up.userid where employee_loans.employee_id = '" . $empid . "'");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function get_Insurance($empid)
    {
        $db = db_connect();
        $query = $db->query("select * from employee_insurance where userid={$empid}");
        $results = $query->getResult();
        $db->close();
        return $results;
    }
     public function get_Packages($empid)
    {
        $db = db_connect();
        $query = $db->query("SELECT * from employee_package WHERE employeeid = '" . $empid . "'");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function get_employee_holidays($empId, $year, $month)
    {
        $db = db_connect();
        $query = $db->query("SELECT A.date FROM 
                                (SELECT business_calendar.date, business_calendar.is_employee_workingday FROM business_calendar WHERE is_employee_workingday = 0)A LEFT JOIN
                                (SELECT employee_attendance.date, employee_attendance.employee_id, employee_attendance.status FROM employee_attendance WHERE employee_id = '{$empId}' AND status = 1)B 
                             ON A.date = B.date WHERE YEAR(A.date) = '{$year}' AND MONTH(A.date) = '{$month}'");

        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function getAllOnBoardEmployeeDetails()
    {
        $db = db_connect();
        $query = $db->query("SELECT is_onboard_status,employeedetails.mobile,employeedetails.employeeid, users.uniqueid,users.userid  from users JOIN employeedetails ON users.userid = employeedetails.userid  where is_onboard = 0
                             ");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function addOnboardEmployee($userid,$mobile, $employee_id)
    {
        $db = db_connect();
        $data['userid'] = $userid;
        $data['mobile'] = $mobile;
      //  $data['employeeid'] = $employee_id;
        $data['is_onboard'] = 0;
        $data['active'] = 0;
        $db = db_connect();
        // $query = $db->query("SELECT * from employeedetails WHERE employeeid='{$employee_id}'");
        // $results = $query->getResult();
        // if (count($results) == 0) {
            $builder = $db->table('employeedetails');
            return $builder->insert($data);
        //}
    }
    public function updateOnBoardEmployeeDetails($userid,$employee_id, $branchid,$designation,$totalleaves, $joiningdate,$login_time, $logout_time, $reportperson,$sunday, $monday, $tuesday, $wednesday, $thursday, $friday, $saturday)
    {
        $db = db_connect();
        $data['branchid'] = $branchid;
        $data['employeeid'] = $employee_id;
        $data['designation'] = $designation;
        $data['totalleaves'] = $totalleaves;
        $data['joiningdate'] = $joiningdate;
        $data['login_time'] = $login_time;
        $data['logout_time'] = $logout_time;
        $data['report_person'] = $reportperson;
        $data['sunday'] = $sunday;
        $data['monday'] = $monday;
        $data['tuesday'] = $tuesday;
        $data['wednesday'] = $wednesday;
        $data['thursday'] = $thursday;
        $data['friday'] = $friday;
        $data['saturday'] = $saturday;
        $data['is_onboard_status'] = 2;
        $data['is_onboard'] = 1;
        $data['active'] = 1;

        $builder = $db->table('employeedetails');
        $builder->where('userid', $userid);
        $builder->update($data);
    }
    public function updateOnBoardEmployee($userid, $name, $email, $dob,$gender, $pancard,$bloodgroup, $aadhar, $h_no, $village, $mandal, $district, $state, $pincode, $father, $mother, $spouse)
    {
        $db = db_connect();
        $data['name'] = $name;
        $data['dob'] = $dob;
        $data['gender'] = $gender;
        $data['pancard'] = $pancard;
        $data['email'] = $email;
        $data['bloodgroup'] = $bloodgroup;
        $data['aadhar'] = $aadhar;
        $data['h_no'] = $h_no;
        $data['village'] = $village;
        $data['mandal'] = $mandal;
        $data['district'] = $district;
        $data['state'] = $state;
        $data['pin'] = $pincode;
        $data['father'] = $father;
        $data['mother'] = $mother;
        $data['spouse'] = $spouse;
        $data['is_onboard_status'] = 1;
        $builder = $db->table('employeedetails');
        $builder->where('userid', $userid);
        $builder->update($data);
    }
    public function getOnboardEmployee($uniqueid)
    {
        $db = db_connect();
        $query = $db->query("SELECT * from users join employeedetails on users.userid = employeedetails.userid where uniqueid='$uniqueid'");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function Employeework($userid)
    {
        $db = db_connect();
        $query = $db->query("SELECT * from employee_work where employeeid='$userid'");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function Employeeeducation($userid)
    {
        $db = db_connect();
        $query = $db->query("SELECT * from employee_education where employeeid='$userid'");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function addOnboardUser($uniqueid)
    {
        $db = db_connect();
        $data['uniqueid'] = $uniqueid;
        $random = rand(0, 999999);
        $now = date('dmYHisu') . $random;
        $U = "USR-" . $now;
        $data['username'] = $U;
        $builder = $db->table('users');
        $builder->insert($data);
        $insertId = $db->insertID();
        if ($insertId == 0) {
            return $this->addOnboardUser($uniqueid);
        } else {
            return $insertId;
        }
    }
    public function getEmployeeToRegularize($date)
    {
        $db = db_connect();
        $query = $db->query("SELECT * from employee_attendance where date='$date' and status=1 and logoutTime IS NOT NULL and (isLatelogin=1 or isEarlyLogout=1)");
        $results = $query->getResult();
        $db->close();
        return $results;
    }
    public function getEmployeeToAutoEarlyLogout($date)
    {
        $db = db_connect();
        $query = $db->query("SELECT * from employee_attendance where date='$date' and status=1 and logoutTime IS NULL");
        $results = $query->getResult();
        $db->close();
        return $results;
    }
    public function updatePaymentstatus($id, $user_status)
    {
        $db = db_connect();
        
        $query = $db->query("update payment_gateway set status=0");
        $data['status'] = $user_status;
        $builder = $db->table('payment_gateway');
        $builder->where('id', $id);
        $builder->update($data);
    }

}
