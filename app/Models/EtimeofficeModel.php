<?php

namespace App\Models;

use CodeIgniter\Model;


class EtimeofficeModel extends Model
{
    public function get_employee_punch($Empcode,$PunchDate)
    {
        $db = db_connect();
        $query = $db->query("SELECT * FROM daily_punchdata WHERE employee_code = '{$Empcode}' AND punch_date = '{$PunchDate}'");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function insertPunchData($Empcode, $PunchDate, $mcid,$date,$id)
    {
        $db = db_connect();
        $results = $this->get_employee_punch($Empcode,$PunchDate);
        if (count($results) == 0) 
        {
            $data["employee_code"] = $Empcode;
            $data["punch_date"] = $PunchDate;
            $data["mcid"] = $mcid;
            $builder = $db->table('daily_punchdata');
            $builder->insert($data);
        }
        
        $db->close();
    }
    public function insertLogintime($Empcode, $PunchDate, $mcid,$date,$id,$date1)
    {
        $db = db_connect();
        $query1 = $db->query("SELECT SUBSTRING_INDEX(daily_punchdata.punch_date, ' ', -1) AS punch_time, SUBSTRING_INDEX(daily_punchdata.punch_date, ' ', 1) AS punchdate FROM daily_punchdata WHERE employee_code = '{$Empcode}' and punch_date like '%$PunchDate%' order by id ASC limit 1");
        $resultspunch = $query1->getResult();
        $queryemp = $db->query("SELECT * FROM employeedetails WHERE employeeid = '{$Empcode}'");
        $resultemp = $queryemp->getResult();
        $userdid = $resultemp[0]->userid;
        $originalDate1 = $resultspunch[0]->punch_time;
        $punchdate = $resultspunch[0]->punchdate;
        $punchdate = str_replace("/","-",$punchdate);
        $punchdatenew = date("Y-m-d", strtotime($punchdate));  
        $newDate = date($punchdatenew . ' ' . $originalDate1);
       // $logintime = substr($resultspunch[0]->punch_date, strpos($resultspunch[0]->punch_date, " ") + 1); 
        $db->query("update employee_attendance set status= 1, loginTime = '{$newDate}',shiftlogintime='{$resultemp[0]->login_time}'  where employee_id='{$userdid}' and date='$punchdatenew' ");
        $st_time    =   strtotime($punchdate.' '.$resultemp[0]->login_time);
        $end_time   =   strtotime($newDate);
        if($end_time > $st_time)
        {
            //send sms to employee for late login
            $db->query("update employee_attendance set isLatelogin= 1 where employee_id='{$userdid}' and date='$punchdatenew' ");
        }
        $db->close();
    }
    
    public function insertLogintimestudent($Empcode, $PunchDate, $mcid,$date,$id,$date1)
    {
        $db = db_connect();
            $query1 = $db->query("SELECT SUBSTRING_INDEX(daily_punchdata_students.punch_date, ' ', -1) AS punch_time, SUBSTRING_INDEX(daily_punchdata_students.punch_date, ' ', 1) AS punchdate FROM daily_punchdata_students WHERE student_code = '{$Empcode}' and punch_date like '%$PunchDate%' order by id ASC limit 1");
            $resultspunch = $query1->getResult();
           
            $queryemp = $db->query("SELECT userid,intime FROM studentdetails join student_class_relation on studentdetails.userid= student_class_relation.studentid join admissiontypelookup on student_class_relation.admissiontypeid=admissiontypelookup.admissiontypeid WHERE applicationnumber = '{$Empcode}' and student_class_relation.batchid=3");
            $resultemp = $queryemp->getResult();
            $userdid = $resultemp[0]->userid;
            $originalDate1 = $resultspunch[0]->punch_time;
            $punchdate = $resultspunch[0]->punchdate;
            $punchdate = str_replace("/","-",$punchdate);
            $punchdatenew = date("Y-m-d", strtotime($punchdate));  
            $newDate = date($punchdatenew . ' ' . $originalDate1);
            $db->query("update student_attendance_details set status= 1,login_time='{$newDate}' where user_id='{$userdid}' and date='$punchdatenew' ");
             $st_time    =   strtotime($punchdate.' '.$resultemp[0]->intime);
            $end_time   =   strtotime($newDate);
            if($end_time > $st_time)
            {
                //send sms to employee for late login
                $db->query("update student_attendance_details set is_latelogin= 1 where user_id='{$userdid}' and date='$punchdatenew' ");
            }
        $db->close();
    }
    
    public function insertLogouttime($Empcode, $PunchDate, $mcid,$date,$id)
    {
        $db = db_connect();
            $query1 = $db->query("SELECT SUBSTRING_INDEX(daily_punchdata.punch_date, ' ', -1) AS punch_time, SUBSTRING_INDEX(daily_punchdata.punch_date, ' ', 1) AS punchdate FROM daily_punchdata WHERE employee_code = '{$Empcode}' and punch_date like '%$PunchDate%'  order by id DESC limit 1");
            $results1 = $query1->getResult();
           
            $queryemp = $db->query("SELECT * FROM employeedetails WHERE employeeid = '{$Empcode}'");
            $resultemp = $queryemp->getResult();
            $userdid = $resultemp[0]->userid;
          //  $logouttime = substr($results1[0]->punch_date, strpos($results1[0]->punch_date, " ") + 1); 
            $logouttime = $results1[0]->punch_time;
            $punchdate = $results1[0]->punchdate;
            $punchdate = str_replace("/","-",$punchdate);
            $punchdatenew = date("Y-m-d", strtotime($punchdate));
           
            $queryempatt = $db->query("SELECT * FROM employee_attendance WHERE employee_id = '{$userdid}' and date='$punchdatenew'");
            $resultempatt = $queryempatt->getResult();
            $originalDates = $results1[0]->punchdate;
            $originalDatea = str_replace("/","-",$originalDates);
            $newDate1 = date("Y-m-d", strtotime($originalDatea));
            $newDate = date($newDate1 . ' ' . $logouttime);
            
            if($resultempatt[0]->loginTime !=  $newDate)
            {
               
                $db->query("update employee_attendance set logoutTime = '{$newDate}',shiftlogouttime='{$resultemp[0]->logout_time}' where employee_id='{$userdid}' and date='$punchdatenew' ");
                $st_time    =   strtotime($punchdatenew.' '.$resultemp[0]->logout_time);
                $end_time   =   strtotime($newDate);
                if($st_time > $end_time)
                {
                    //send sms to employee for late login
                    $db->query("update employee_attendance set isEarlyLogout= 1 where employee_id='{$userdid}' and date='$punchdatenew' ");
                }
            }
        
        $db->close();
    }
    
    
    public function insertCentralPunchData($Empcode, $PunchDate, $mcid)
    {
        $db = db_connect();
        $data["employee_code"] = $Empcode;
        $data["punch_date"] = $PunchDate;
        $data["mcid"] = $mcid;
        $builder = $db->table('centralized_punchdata');
        $builder->insert($data);
        $db->close();
    }
}