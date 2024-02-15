<?php

namespace App\Models;

use CodeIgniter\Model;


class AdminModel extends Model
{
    public function addRole($roleName)
    {
        $db = db_connect();
        $data['rolename'] = $roleName;

        $builder = $db->table('roleslookup');
        $builder->insert($data);
        $roleid = $db->insertID();
        $db->close();

        $helpermodel = new HelperModel();
        $operations = $helpermodel->get_operationslookup();

        foreach ($operations as $operation) {
            $this->insertRight("add", 0, $roleid, $operation->operationid);
            $this->insertRight("view", 0, $roleid, $operation->operationid);
            $this->insertRight("edit", 0, $roleid, $operation->operationid);
            $this->insertRight("delete", 0, $roleid, $operation->operationid);
        }
    }
    public function getAllStudentDetailsone()
    {
        $db = db_connect();
        $query = $db->query("SELECT studentdetails.firebase from studentdetails Join student_class_relation on studentdetails.userid = student_class_relation.studentid where student_class_relation.batchid IN (select batchlookup.batchid from batchlookup where isactive=1);");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function addAnnouncement($message,$description,$newDate)
    {
        $db = db_connect();
        $data['message'] = $message;
        $data['description'] = $description;
        $data['annoucement_date'] = $newDate;

        $builder = $db->table('announcement');
        $builder->insert($data);
        $roleid = $db->insertID();
        $db->close();
    }
    public function addcounsollermapping($userid,$name)
    {
        $db = db_connect();
        $data['userid'] = $userid;
        $data['name'] = $name;
        $builder = $db->table('counsellor_mapping');
        $builder->insert($data);
        $roleid = $db->insertID();
        $db->close();
    }
    public function addHoliday($message,$from_date,$to_date,$admissiontypeid)
    {
         $db = db_connect();
        $data['title'] = $message;
        $data['from_date'] = $from_date;
        $data['todate'] = $to_date;
         $data['admissiontype'] = $admissiontypeid;
        $data['batchid'] = 3;
        $builder = $db->table('holidays');
        $builder->insert($data);
        $roleid = $db->insertID();
        $db->close();
    }
    
    public function updateannouncement(
        $id,
        $message,
        $description
    ) {
        $data['message'] = $message;
        $data['description'] = $description;
        $db = db_connect();
        $builder = $db->table('announcement');
        $builder->where('id', $id);
        $builder->update($data);
        $db->close();
    }

    public function deleteannouncement($id)
    {
        $db = db_connect();
        $builder = $db->table('announcement');
        $builder->where('id', $id);
        $builder->delete();

        $db->close();
    }


    public function addOperation($operationName, $parent = 0)
    {
        $db = db_connect();
        $data['operationname'] = $operationName;
        $data['parent'] = $parent;

        $builder = $db->table('operationslookup');
        $builder->insert($data);
        $operationid = $db->insertID();
        $db->close();

        $helpermodel = new HelperModel();
        $roles = $helpermodel->get_roleslookup();

        foreach ($roles as $role) {
            $this->insertRight("add", 0, $role->roleid, $operationid);
            $this->insertRight("view", 0, $role->roleid, $operationid);
            $this->insertRight("edit", 0, $role->roleid, $operationid);
            $this->insertRight("delete", 0, $role->roleid, $operationid);
        }
    }

    public function insertRight($right, $checked, $roleid, $operationid)
    {
        $db = db_connect();

        $data["_" . "{$right}"] = $checked;
        $data["roleid"] = $roleid;
        $data["operationid"] = $operationid;

        $builder = $db->table('rights');
        $builder->insert($data);

        $db->close();
    }

    public function setRights($right, $checked, $roleid, $operationid)
    {
        $db = db_connect();
        $data["_" . "{$right}"] = $checked;

        $builder = $db->table('rights');
        $builder->where('roleid', $roleid);
        $builder->where('operationid', $operationid);
        $builder->update($data);

        $db->close();
    }

    public function get_classes()
    {
        $db = db_connect();
        $query = $db->query("SELECT C.classid, C.classname, C.classdescription, 
                                    C.batchid, BaL.batchname, 
                                    C.branchid, BrL.branchname,
                                    C.courseid, CL.coursename,
                                    C.sectionid, SeL.sectionname,
                                    C.subjectid, SuL.subjectname,
                                    C.teacherid, ED.name
                                      FROM class C 
                                      JOIN batchlookup BaL ON C.batchid = BaL.batchid
                                      JOIN branchlookup BrL ON C.branchid = BrL.branchid
                                      JOIN courselookup CL ON C.courseid = CL.courseid
                                      JOIN sectionlookup SeL ON C.sectionid = SeL.sectionid
                                      JOIN subjectlookup SuL ON C.subjectid = SuL.subjectid
                                      JOIN users U ON C.teacherid = U.userid 
                                      JOIN employeedetails ED ON U.userid = ED.userid 
                                      JOIN roleslookup RL ON U.roleid = RL.roleid 
                                      WHERE RL.rolename = 'Teacher'");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function get_enrollments(
        $classid = NULL,
        $batchid = NULL,
        $branchid = NULL,
        $courseid = NULL,
        $sectionid = NULL,
        $subjectid = NULL,
        $teacherid = NULL,
        $studentid = NULL
    ) {
        $whereCondition = "";
        if ($classid != NULL) {
            $whereCondition .= $whereCondition == "" ? " C.classid = {$classid} " : " AND C.classid = {$classid} ";
        }
        if ($batchid != NULL) {
            $whereCondition .= $whereCondition == "" ? " C.batchid = {$batchid} " : " AND C.batchid = {$batchid} ";
        }
        if ($branchid != NULL) {
            $whereCondition .= $whereCondition == "" ? " C.branchid = {$branchid} " : " AND C.branchid = {$branchid} ";
        }
        if ($courseid != NULL) {
            $whereCondition .= $whereCondition == "" ? " C.courseid = {$courseid} " : " AND C.courseid = {$courseid} ";
        }
        if ($sectionid != NULL) {
            $whereCondition .= $whereCondition == "" ? " C.sectionid = {$sectionid} " : " AND C.sectionid = {$sectionid} ";
        }
        if ($subjectid != NULL) {
            $whereCondition .= $whereCondition == "" ? " C.subjectid = {$subjectid} " : " AND C.subjectid = {$subjectid} ";
        }
        if ($teacherid != NULL) {
            $whereCondition .= $whereCondition == "" ? " C.teacherid = {$teacherid} " : " AND C.teacherid = {$teacherid} ";
        }
        if ($studentid != NULL) {
            $whereCondition .= $whereCondition == "" ? " SD.userid = {$studentid} " : " AND SD.userid = {$studentid} ";
        }

        if ($whereCondition != "") {
            $db = db_connect();
            $query = $db->query("SELECT C.classid, C.classname, C.classdescription, 
                                    C.batchid, BaL.batchname, 
                                    C.branchid, BrL.branchname,
                                    C.courseid, CL.coursename,
                                    C.sectionid, SeL.sectionname,
                                    C.subjectid, SuL.subjectname,
                                    C.teacherid, ED.name AS teachername,
                                    SD.userid AS studentid, SD.name AS studentname, SD.applicationnumber
                                      FROM class C 
                                      JOIN batchlookup BaL ON C.batchid = BaL.batchid
                                      JOIN branchlookup BrL ON C.branchid = BrL.branchid
                                      JOIN courselookup CL ON C.courseid = CL.courseid
                                      JOIN sectionlookup SeL ON C.sectionid = SeL.sectionid
                                      JOIN subjectlookup SuL ON C.subjectid = SuL.subjectid
                                      JOIN users U ON C.teacherid = U.userid 
                                      JOIN employeedetails ED ON U.userid = ED.userid 
                                      JOIN roleslookup RL ON U.roleid = RL.roleid 
                                      JOIN enrol E ON C.classid = E.classid
                                      JOIN studentdetails SD ON E.studentid = SD.userid
                                      WHERE RL.rolename = 'Teacher' AND {$whereCondition}");
            $results = $query->getResult();
            $db->close();

            return $results;
        }
    }

    public function get_smstemplates()
    {
        $db = db_connect();
        $query = $db->query("SELECT * FROM smstemplates");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function get_emailtemplates()
    {
        $db = db_connect();
        $query = $db->query("SELECT * FROM emailtemplates");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    
    public function get_announcements()
    {
        $db = db_connect();
        $query = $db->query("SELECT * FROM announcement");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function get_counsollermapping()
    {
        $db = db_connect();
        $query = $db->query("SELECT counsellor_mapping.id,counsellor_mapping.name,employeedetails.name as employeename,counsellor_mapping.created_at,counsellor_mapping.update_at,counsellor_mapping.is_active FROM counsellor_mapping join employeedetails on counsellor_mapping.userid =  employeedetails.userid");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    
    public function concernslist()
    {
        $db = db_connect();
        $query = $db->query("select studentdetails.applicationnumber,studentdetails.userid,branchlookup.branchname,studentdetails.name,employeedetails.name as assignedname,studentdetails.fathername,concerns.assigned_to,concerns.id,concerns.status,concerns.details,concerns.from_time,concerns.to_time,CC.name as categoryname, CSC.name as subcategoryname from concerns 
        join concern_subcategory CC on concerns.category=CC.id 
        join concern_subcategory CSC on concerns.sub_category=CSC.id 
        JOIN studentdetails on studentdetails.userid = concerns.student_id
        Join student_class_relation on studentdetails.userid = student_class_relation.studentid
        JOIN branchlookup ON student_class_relation.branchid = branchlookup.branchid
        left join employeedetails on employeedetails.userid = concerns.assigned_to");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    
    public function get_holidays()
    {
        $db = db_connect();
        $query = $db->query("SELECT * FROM holidays");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    // CLASS
    public function addclass(
        $classname,
        $classdescription,
        $batchid,
        $branchid,
        $courseid,
        $sectionid,
        $subjectid,
        $teacherid
    ) {
        $data['classname'] = $classname;
        $data['classdescription'] = $classdescription;

        $data['batchid'] = $batchid;
        $data['branchid'] = $branchid;
        $data['courseid'] = $courseid;
        $data['sectionid'] = $sectionid;
        $data['subjectid'] = $subjectid;
        $data['teacherid'] = $teacherid;


        $db = db_connect();
        $builder = $db->table('class');
        $builder->insert($data);

        $db->close();
    }

    public function updateclass(
        $classid,
        $classname,
        $classdescription,
        $batchid,
        $branchid,
        $courseid,
        $sectionid,
        $subjectid,
        $teacherid
    ) {
        $data['classname'] = $classname;
        $data['classdescription'] = $classdescription;

        $data['batchid'] = $batchid;
        $data['branchid'] = $branchid;
        $data['courseid'] = $courseid;
        $data['sectionid'] = $sectionid;
        $data['subjectid'] = $subjectid;
        $data['teacherid'] = $teacherid;

        $db = db_connect();
        $builder = $db->table('class');
        $builder->where('classid', $classid);
        $builder->update($data);
        $db->close();
    }

    public function deleteclass($classid)
    {
        $db = db_connect();
        $builder = $db->table('class');
        $builder->where('batchid', $classid);
        $builder->delete();

        $db->close();
    }
    // CLASS

    //ENROL
    public function enrol($classid, $studentid)
    {
        $this->deleteenrol($classid, $studentid);

        $data['classid'] = $classid;
        $data['studentid'] = $studentid;

        $db = db_connect();
        $builder = $db->table('enrol');
        $builder->insert($data);

        $db->close();
    }

    public function deleteenrol($classid, $studentid)
    {
        $db = db_connect();
        $builder = $db->table('enrol');
        $builder->where('classid', $classid);
        $builder->where('studentid', $studentid);
        $builder->delete();

        $db->close();
    }
    //ENROL

    // SMS Templates
    public function addsmstemplate($templatename, $template)
    {
        $data['smstemplatename'] = $templatename;
        $data['smstemplate'] = $template;

        $db = db_connect();
        $builder = $db->table('smstemplates');
        $builder->insert($data);

        $db->close();
    }

    public function updatesmstemplate($templateid, $templatename, $template)
    {
        $data['smstemplatename'] = $templatename;
        $data['smstemplatename'] = $templatename;
        $data['smstemplate'] = $template;

        $db = db_connect();
        $builder = $db->table('smstemplates');
        $builder->where('smstemplateid', $templateid);
        $builder->update($data);
        $db->close();
    }

    public function deletesmstemplate($templateid)
    {
        $db = db_connect();
        $builder = $db->table('smstemplates');
        $builder->where('smstemplateid', $templateid);
        $builder->delete();

        $db->close();
    }
    // SMS Templates

    // Email Templates
    public function addemailtemplate($templatename, $template)
    {
        $data['emailtemplatename'] = $templatename;
        $data['emailtemplate'] = $template;

        $db = db_connect();
        $builder = $db->table('emailtemplates');
        $builder->insert($data);

        $db->close();
    }

    public function updateemailtemplate($templateid, $templatename, $template)
    {
        $data['emailtemplatename'] = $templatename;
        $data['emailtemplate'] = $template;

        $db = db_connect();
        $builder = $db->table('emailtemplates');
        $builder->where('emailtemplateid', $templateid);
        $builder->update($data);
        $db->close();
    }

    public function deleteemailtemplate($templateid)
    {
        $db = db_connect();
        $builder = $db->table('emailtemplates');
        $builder->where('emailtemplateid', $templateid);
        $builder->delete();

        $db->close();
    }
    // Email Templates

    public function get_business_days($year)
    {
        $db = db_connect();
        $query = $db->query("SELECT * FROM `business_calendar` WHERE YEAR(date) = '{$year}'");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function update_business_day($date, $is_employee_workingday, $is_student_workingday, $comment)
    {
        $db = db_connect();

        $data['is_employee_workingday'] = $is_employee_workingday;
        $data['is_student_workingday'] = $is_student_workingday;
        $data['comment'] = $comment;

        $builder = $db->table('business_calendar');
        $builder->where('date', $date);

        $builder->update($data);
        $db->close();
    }

    public function get_employee_fees_limits($empId = NULL)
    {
        if ($empId != NULL) {
            $db = db_connect();
            $query = $db->query("SELECT * FROM employeediscount_limit WHERE employeeid = '{$empId}' AND batchid = '{$_SESSION['activebatch']}'");
            $results = $query->getResult();
            $db->close();

            return $results;
        } else {
            $db = db_connect();
            $query = $db->query("SELECT *, employeedetails.employeeid AS empid FROM employeedetails 
                                 left join employeediscount_limit 
                                 on employeedetails.userid = employeediscount_limit.employeeid 
                                 and employeediscount_limit.batchid IN ({$_SESSION['activebatch']})");
            $results = $query->getResult();
            $db->close();

            return $results;
        }
    }

    public function get_employee_discount_logs()
    {
        $db = db_connect();
        $query = $db->query("select * from discount_logs JOIN studentdetails ON studentdetails.userid = discount_logs.userid  
                             and discount_logs.batchid IN ({$_SESSION['activebatch']})");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function insertUpdate_employee_fees_limits($data)
    {
        $results = $this->get_employee_fees_limits($data['employeeid']);
        if (count($results) == 0) {
            if ($data['limit'] != NULL) {
                $db = db_connect();
                $db->query("INSERT INTO employeediscount_limit (employeeid, batchid, totallimit, availablelimit)
                            VALUES('{$data['employeeid']}', '{$data['batchid']}', '{$data['limit']}', '{$data['limit']}')");
                $db->close();
            } else {
                $db = db_connect();
                $builder = $db->table('employeediscount_limit');
                $builder->insert($data);

                $db->close();
            }
        } else {
            if ($data['limit'] != NULL) {
                $db = db_connect();
                $db->query("UPDATE employeediscount_limit 
                                      set availablelimit = availablelimit + {$data['limit']},
                                          totallimit = totallimit + {$data['limit']}
                                      where id = {$results[0]->id}");
                $db->close();
            } else {
                $db = db_connect();
                $builder = $db->table('employeediscount_limit');
                $builder->where('id', $results[0]->id);
                $builder->update($data);
                $db->close();
            }
        }
    }
    public function get_paymentgateway()
    {
        $db = db_connect();
        $query = $db->query("SELECT * FROM payment_gateway");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function get_reservationdiscount()
    {
        $db = db_connect();
        $query = $db->query("SELECT * FROM reservation_discounts_lookup JOIN branchlookup ON reservation_discounts_lookup.branchid = branchlookup.branchid JOIN courselookup ON reservation_discounts_lookup.courseid = courselookup.courseid JOIN admissiontypelookup ON reservation_discounts_lookup.admissiontypeid = admissiontypelookup.admissiontypeid where batchid = '{$_SESSION['activebatch']}'");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function get_reservationdiscountbyuserid()
    {
        $db = db_connect();
        $query = $db->query("SELECT * FROM reservation_discounts_lookup JOIN employeedetails ON reservation_discounts_lookup.userid = employeedetails.userid  where reservation_discounts_lookup.batchid = '{$_SESSION['activebatch']}'");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function addmaxreservationdiscount($branchid,$courseid,$admissiontypeid,$batchid,$amount)
    {
        $data['branchid'] = $branchid;
        $data['courseid'] = $courseid;
        $data['admissiontypeid'] = $admissiontypeid;
        $data['batchid'] = $batchid;
        $data['amount'] = $amount;

        $db = db_connect();
        $builder = $db->table('reservation_discounts_lookup');
        $builder->insert($data);

        $db->close();
    }
    public function updatemaxreservationdiscount($id,$amount)
    {
        $db = db_connect();

        $data['amount'] = $amount;
        $builder = $db->table('reservation_discounts_lookup');
        $builder->where('id', $id);

        $builder->update($data);
        $db->close();
    }
}
