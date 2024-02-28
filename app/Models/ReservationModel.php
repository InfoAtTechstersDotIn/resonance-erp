<?php

namespace App\Models;

use CodeIgniter\Model;


class ReservationModel extends Model
{
    public function get_reservations()
    {
        $db = db_connect();
        $query = $db->query("SELECT * from reservation
                             LEFT JOIN branchlookup ON reservation.branchid = branchlookup.branchid
                             LEFT JOIN reservationstatuslookup ON reservation.reservationstatusid = reservationstatuslookup.reservationstatusid
                             LEFT JOIN admissiontypelookup ON reservation.admissiontypeid = admissiontypelookup.admissiontypeid
                             LEFT JOIN courselookup ON reservation.courseid = courselookup.courseid
                             LEFT JOIN genderlookup ON reservation.genderid = genderlookup.genderid
                             WHERE branchlookup.branchid IN ({$_SESSION['userdetails']->branchid})
                             AND reservation.batchid IN ({$_SESSION['activebatch']})");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function get_agentapplications()
    {
        $db = db_connect();
        $query = $db->query("SELECT * from applications
                             LEFT JOIN branchlookup ON applications.branchid = branchlookup.branchid
                             LEFT JOIN reservationstatuslookup ON applications.reservationstatusid = reservationstatuslookup.reservationstatusid
                             LEFT JOIN retstatuslookup ON applications.retstatus = retstatuslookup.retid
                             LEFT JOIN admissiontypelookup ON applications.admissiontypeid = admissiontypelookup.admissiontypeid
                             LEFT JOIN courselookup ON applications.courseid = courselookup.courseid
                             LEFT JOIN genderlookup ON applications.genderid = genderlookup.genderid
                             WHERE applications.created_by = {$_SESSION['agentdetails']->userid}
                             AND applications.batchid IN ({$_SESSION['activebatch']}) and applications.reservationstatusid !=6");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    
    public function get_retagentapplications()
    {
        $db = db_connect();
        $query = $db->query("SELECT * from applications
                             LEFT JOIN branchlookup ON applications.branchid = branchlookup.branchid
                             LEFT JOIN reservationstatuslookup ON applications.reservationstatusid = reservationstatuslookup.reservationstatusid
                             LEFT JOIN retstatuslookup ON applications.retstatus = retstatuslookup.retid
                             LEFT JOIN admissiontypelookup ON applications.admissiontypeid = admissiontypelookup.admissiontypeid
                             LEFT JOIN courselookup ON applications.courseid = courselookup.courseid
                             LEFT JOIN genderlookup ON applications.genderid = genderlookup.genderid
                             WHERE applications.created_by = {$_SESSION['agentdetails']->userid}
                             AND applications.batchid IN ({$_SESSION['activebatch']}) and applications.reservationstatusid=6");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    
    public function get_applications()
    {
        $db = db_connect();
        $query = $db->query("SELECT * from applications
                             LEFT JOIN branchlookup ON applications.branchid = branchlookup.branchid
                             LEFT JOIN reservationstatuslookup ON applications.reservationstatusid = reservationstatuslookup.reservationstatusid
                             LEFT JOIN retstatuslookup ON applications.retstatus = retstatuslookup.retid
                             LEFT JOIN admissiontypelookup ON applications.admissiontypeid = admissiontypelookup.admissiontypeid
                             LEFT JOIN courselookup ON applications.courseid = courselookup.courseid
                             LEFT JOIN genderlookup ON applications.genderid = genderlookup.genderid
                             WHERE branchlookup.branchid IN ({$_SESSION['agentdetails']->branchid})
                             AND applications.batchid IN ({$_SESSION['activebatch']}) and applications.reservationstatusid !=6");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    
    public function get_retapplications()
    {
        $db = db_connect();
        $query = $db->query("SELECT * from applications
                             LEFT JOIN branchlookup ON applications.branchid = branchlookup.branchid
                             LEFT JOIN reservationstatuslookup ON applications.reservationstatusid = reservationstatuslookup.reservationstatusid
                             LEFT JOIN retstatuslookup ON applications.retstatus = retstatuslookup.retid
                             LEFT JOIN admissiontypelookup ON applications.admissiontypeid = admissiontypelookup.admissiontypeid
                             LEFT JOIN courselookup ON applications.courseid = courselookup.courseid
                             LEFT JOIN genderlookup ON applications.genderid = genderlookup.genderid
                             WHERE branchlookup.branchid IN ({$_SESSION['agentdetails']->branchid})
                             AND applications.batchid IN ({$_SESSION['activebatch']})  and applications.reservationstatusid =6");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    
    public function get_allapplications()
    {
        $db = db_connect();
        $query = $db->query("SELECT * from applications
                             LEFT JOIN branchlookup ON applications.branchid = branchlookup.branchid
                             LEFT JOIN reservationstatuslookup ON applications.reservationstatusid = reservationstatuslookup.reservationstatusid
                             LEFT JOIN retstatuslookup ON applications.retstatus = retstatuslookup.retid
                             LEFT JOIN admissiontypelookup ON applications.admissiontypeid = admissiontypelookup.admissiontypeid
                             LEFT JOIN courselookup ON applications.courseid = courselookup.courseid
                             LEFT JOIN genderlookup ON applications.genderid = genderlookup.genderid where applications.batchid IN ({$_SESSION['activebatch']})  and applications.reservationstatusid !=6
                             ");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    
    public function get_retallapplications()
    {
        $db = db_connect();
        $query = $db->query("SELECT * from applications
                             LEFT JOIN branchlookup ON applications.branchid = branchlookup.branchid
                             LEFT JOIN reservationstatuslookup ON applications.reservationstatusid = reservationstatuslookup.reservationstatusid
                             LEFT JOIN retstatuslookup ON applications.retstatus = retstatuslookup.retid
                             LEFT JOIN admissiontypelookup ON applications.admissiontypeid = admissiontypelookup.admissiontypeid
                             LEFT JOIN courselookup ON applications.courseid = courselookup.courseid
                             LEFT JOIN genderlookup ON applications.genderid = genderlookup.genderid where applications.batchid IN ({$_SESSION['activebatch']})  and applications.reservationstatusid =6
                             ");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    
    public function get_myapplications()
    {
        $db = db_connect();
        $query = $db->query("SELECT * from applications
                             LEFT JOIN branchlookup ON applications.branchid = branchlookup.branchid
                             LEFT JOIN reservationstatuslookup ON applications.reservationstatusid = reservationstatuslookup.reservationstatusid
                             LEFT JOIN retstatuslookup ON applications.retstatus = retstatuslookup.retid
                             LEFT JOIN admissiontypelookup ON applications.admissiontypeid = admissiontypelookup.admissiontypeid
                             LEFT JOIN courselookup ON applications.courseid = courselookup.courseid
                             LEFT JOIN genderlookup ON applications.genderid = genderlookup.genderid
                             WHERE applications.transferemployee ={$_SESSION['agentdetails']->userid}
                             AND applications.batchid IN ({$_SESSION['activebatch']})  and applications.reservationstatusid !=6");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    
    public function get_retmyapplications()
    {
        $db = db_connect();
        $query = $db->query("SELECT * from applications
                             LEFT JOIN branchlookup ON applications.branchid = branchlookup.branchid
                             LEFT JOIN reservationstatuslookup ON applications.reservationstatusid = reservationstatuslookup.reservationstatusid
                             LEFT JOIN retstatuslookup ON applications.retstatus = retstatuslookup.retid
                             LEFT JOIN admissiontypelookup ON applications.admissiontypeid = admissiontypelookup.admissiontypeid
                             LEFT JOIN courselookup ON applications.courseid = courselookup.courseid
                             LEFT JOIN genderlookup ON applications.genderid = genderlookup.genderid
                             WHERE applications.transferemployee ={$_SESSION['agentdetails']->userid}
                             AND applications.batchid IN ({$_SESSION['activebatch']}) and applications.reservationstatusid=6");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    
    
    public function getApplicationDetails($reservationId, $batchid = NULL)
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
                                 WHERE applications.applicationid = '$reservationId' $WhereClausebatchid");
        $results = $query->getRow();
        $db->close();

        return $results;
    }
     public function addApplicationUser(
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
        $eligibility,
        $scholarship,
        $tuition_discount,
        $hostel_discount,
        $final_misc,
        $discountrequested,
        $discountgiven,
        $created_by,
        $profile_image
    ) {
        $db = db_connect();
        $data['application_ukey'] = $reservation_ukey;
        $data['applicationtype'] = $applicationtype;
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
        $data['visitorname'] = $visitorname;
        $data['relationwithstudent'] =        $relationwithstudent;
        $data['visitornumber'] =        $visitornumber;
        $data['previous_class_information'] = $previous_class_information_json;
        $data['address'] = $address_json;
        $data['mobile1'] = $mobile1;
        $data['mobile2'] = $mobile2;
        $data['email'] = $email;

        $data['secondlanguageid'] = $secondlanguageid;
        $data['comments'] = $comments;
        $data['referredby'] = $referredby;

        $data['admissiontypeid'] = $admissiontypeid;
        $data['branchid'] = $branchid;
        $data['courseid'] = $courseid;
        $data['coursetype'] = $course;
        $data['batchid'] = $batchid;
        $data['sectionid'] = $sectionid;

        $data['admissiondate'] = $admissiondate;
        $data['reservationstatusid'] = $reservationstatusid;
        $data['retstatus'] = $eligibility;
        $data['scholarship'] = $scholarship;
        $data['tuition_discount'] = $tuition_discount;
        $data['hostel_discount'] = $hostel_discount;
        $data['final_misc'] = $final_misc;

        $data['discountrequested'] = $discountrequested;
        $data['discountgiven'] = $discountgiven;

        $data['created_by'] = $created_by;
        $data['profile_image'] = $profile_image;
        $builder = $db->table('applications');
        $builder->insert($data);

        $insertId = $db->insertID();
        $db->close();

        return $insertId;
    }
    public function updateApplicationEmployee($reservationid,$discountrequested,$employeeid)
   {
       $db = db_connect();
       
        $data['transferemployee'] = $employeeid;
        $builder = $db->table('applications');
        $data['discountrequested'] = $discountrequested;
        $builder->where('applicationid', $reservationid);
        $builder->update($data);

        $db->close();
   }
   public function updateEligibility($application_no,$eligibility)
   {
        $db = db_connect();
       
        //$data['transferemployee'] = $employeeid;
        $builder = $db->table('applications');
        $data['retstatus'] = $eligibility;
        $builder->where('application_ukey', $application_no);
        $builder->update($data);

        $db->close();
   }
   public function updatefeeRET($reservationid,$reservationstatusid,$tuition_discount1,$tuition_discount2,$hostel_discount)
   {
       $db = db_connect();
       
        //$data['transferemployee'] = $employeeid;
        $builder = $db->table('applications');
        $data['reservationstatusid'] = $reservationstatusid;
        $data['tuition_discount'] = $tuition_discount1;
        $data['tuition_discount1'] = $tuition_discount2;
        $data['hostel_discount'] = $hostel_discount;
        $builder->where('applicationid', $reservationid);
        $builder->update($data);

        $db->close();
   }
   public function updateRETDetails($reservationid,$name,$fathername,$mothername,$dateofbirth,
                $branchid,$courseid,$admissiontypeid,$var,$var1,$referredby)
   {
        $db = db_connect();
       
        //$data['transferemployee'] = $employeeid;
        $builder = $db->table('applications');
        $data['branchid'] = $branchid;
        $data['name'] = $name;
        $data['fathername'] = $fathername;
        $data['mothername'] = $mothername;
        $data['dateofbirth'] = $dateofbirth;
        $data['courseid'] = $courseid;
        $data['admissiontypeid'] = $admissiontypeid;
        $data['tuition_discount'] = $var;
        $data['tuition_discount1'] = $var1;
        if($_SESSION['agentdetails']->userid == 7181){
        $data['created_by'] = $referredby;
        }
        $builder->where('applicationid', $reservationid);
        $builder->update($data);

        $db->close();
   }
   public function updateCounsellorname($mobile1,$email,$userid)
   {
        $db = db_connect();
        $builder = $db->table('applications');
        $data['created_by'] = $userid;
        $builder->where('mobile1', $mobile1);
        $builder->where('email',$email);
        $builder->update($data);

        $db->close();
   }
    public function updateApplicationDetails(
       $name,
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
    ) {
        $db = db_connect();
        $data['name'] = $name;
        $data['dateofbirth'] = $dateofbirth;
        $data['genderid'] = $genderid;
        $data['studentaadhaar'] = $studentaadhaar;
        $data['fathername'] = $fathername;
        $data['mothername'] = $mothername;
        $data['previous_class_information'] = $previous_class_information_json;
        $data['address'] = $address_json;
        $data['mobile1'] = $mobile1;
        $data['mobile2'] = $mobile2;
        $data['email'] = $email;

        $data['admissiontypeid'] = $admissiontypeid;
        $data['branchid'] = $branchid;
        $data['courseid'] = $courseid;
        $data['sectionid'] = $sectionid;
        $data['tuition_discount'] = $tuition_discount;
        $data['hostel_discount'] = $hostel_discount;
        $data['additionaldiscountgiven'] =$additionaldiscountgiven;
        $data['comments'] = $comments;

        $builder = $db->table('applications');

        $builder->where('applicationid', $reservationid);
        $builder->update($data);

        $db->close();
    }
   public function updateApplication(
        $reservationid,
        $tuition_discount1,
        $tuition_discount2,
        $comments,
        $reservationstatusid
    ) {
        $db = db_connect();
       
        $data['reservationstatusid'] = $reservationstatusid;
        $data['tuition_discount'] = $tuition_discount1;
        $data['tuition_discount1'] = $tuition_discount2;
        $data['comments'] = $comments;
        $data['approved_by'] = $_SESSION['agentdetails']->userid == null ? 0 : $_SESSION['agentdetails']->userid;
        $data['approved_date'] = date('Y-m-d');

        $builder = $db->table('applications');

        $builder->where('applicationid', $reservationid);
        $builder->update($data);

        $db->close();
        
    }
    public function updateApplicationFee($reservationid,$discountrequested,
                $employeeid)
    {
        $db = db_connect();
       
        $data['discountrequested'] = $discountrequested;
        
         $data['transferemployee'] = $employeeid;

        $builder = $db->table('applications');

        $builder->where('applicationid', $reservationid);
        $builder->update($data);

        $db->close();
        
    }
    public function updateApplicationFeeGiven($reservationid,$discountgiven,$discountrequested)
    {
        $db = db_connect();
       
        $data['discountgiven'] = $discountgiven;
        $data['discountrequested'] = $discountrequested;
        $data['discountapproved_by'] = $_SESSION['agentdetails']->userid == null ? 0 : $_SESSION['agentdetails']->userid;
        $builder = $db->table('applications');

        $builder->where('applicationid', $reservationid);
        $builder->update($data);

        $db->close();
        
    }
    public function updateApplicationAdditionalFeeGiven($reservationid,$additionaldiscountgiven)
    {
        $db = db_connect();
       
        $data['additionaldiscountgiven'] = $additionaldiscountgiven;
        $builder = $db->table('applications');

        $builder->where('applicationid', $reservationid);
        $builder->update($data);

        $db->close();
        
    }
    public function getReservationDetails($reservationId, $batchid = NULL)
    {
        $WhereClausebatchid = $batchid == NULL ? "" : " and reservation.batchid IN ({$batchid})";
        $db = db_connect();
        $query = $db->query("SELECT reservation.*,reservation_discounts.amount,reservation_discounts.approvedamount,branchlookup.*,batchlookup.batchname,admissiontypelookup.*,courselookup.*,sectionlookup.*,genderlookup.*,nationalitylookup.*,religionlookup.*,categorylookup.* from reservation 
                                 LEFT JOIN reservation_discounts on reservation.reservationid= reservation_discounts.userid
                                 LEFT JOIN branchlookup ON reservation.branchid = branchlookup.branchid
                                 LEFT JOIN batchlookup ON reservation.batchid = batchlookup.batchid
                                 LEFT JOIN admissiontypelookup ON reservation.admissiontypeid = admissiontypelookup.admissiontypeid
                                 LEFT JOIN courselookup ON reservation.courseid = courselookup.courseid
                                 LEFT JOIN sectionlookup ON reservation.sectionid = sectionlookup.sectionid
                                 LEFT JOIN genderlookup ON reservation.genderid = genderlookup.genderid
                                 LEFT JOIN nationalitylookup ON reservation.nationalityid = nationalitylookup.nationalityid
                                 LEFT JOIN religionlookup ON reservation.religionid = religionlookup.religionid
                                 LEFT JOIN categorylookup ON reservation.categoryid = categorylookup.categoryid
                                 
                                 WHERE reservation.reservationid = '$reservationId' $WhereClausebatchid");
        $results = $query->getRow();
        $db->close();

        return $results;
    }
    
    public function getReservationDetail($reservation_ukey,$batchid = NULL)
    {
        $WhereClausebatchid = $batchid == NULL ? "" : " and reservation.batchid IN ({$batchid})";
        $db = db_connect();
        $query = $db->query("SELECT * from reservation 
                                 LEFT JOIN branchlookup ON reservation.branchid = branchlookup.branchid
                                 LEFT JOIN admissiontypelookup ON reservation.admissiontypeid = admissiontypelookup.admissiontypeid
                                 LEFT JOIN courselookup ON reservation.courseid = courselookup.courseid
                                 LEFT JOIN sectionlookup ON reservation.sectionid = sectionlookup.sectionid
                                 LEFT JOIN genderlookup ON reservation.genderid = genderlookup.genderid
                                 LEFT JOIN nationalitylookup ON reservation.nationalityid = nationalitylookup.nationalityid
                                 LEFT JOIN religionlookup ON reservation.religionid = religionlookup.religionid
                                 LEFT JOIN categorylookup ON reservation.categoryid = categorylookup.categoryid
                                 WHERE reservation.reservation_ukey = '$reservation_ukey' $WhereClausebatchid");
        $results = $query->getRow();
        $db->close();

        return $results;
    }

    public function addReservationUser(
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
        $hostel_discount,
        $final_misc,
        $discountrequested,
        $discountgiven,
        $created_by
    ) {
        $db = db_connect();
        $data['reservation_ukey'] = $reservation_ukey;
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
        $data['visitorname'] = $visitorname;
        $data['relationwithstudent'] =        $relationwithstudent;
        $data['visitornumber'] =        $visitornumber;
        $data['previous_class_information'] = $previous_class_information_json;
        $data['address'] = $address_json;
        $data['mobile1'] = $mobile1;
        $data['mobile2'] = $mobile2;
        $data['email'] = $email;

        $data['secondlanguageid'] = $secondlanguageid;
        $data['comments'] = $comments;
        $data['referredby'] = $referredby;

        $data['admissiontypeid'] = $admissiontypeid;
        $data['branchid'] = $branchid;
        $data['courseid'] = $courseid;
        $data['batchid'] = $batchid;
        $data['sectionid'] = $sectionid;

        $data['admissiondate'] = $admissiondate;
        $data['reservationstatusid'] = $reservationstatusid;
        $data['scholarship'] = $scholarship;
        $data['tuition_discount'] = $tuition_discount;
        $data['hostel_discount'] = $hostel_discount;
        $data['final_misc'] = $final_misc;

        $data['discountrequested'] = $discountrequested;
        $data['discountgiven'] = $discountgiven;

        $data['created_by'] = $created_by;

        $builder = $db->table('reservation');
        $builder->insert($data);

        $insertId = $db->insertID();
        $db->close();

        return $insertId;
    }
    
    public function addApplicationReservationUser(
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
    ) {
        $db = db_connect();
        $data['reservation_ukey'] = $reservation_ukey;
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
        $data['visitorname'] = $visitorname;
        $data['relationwithstudent'] =        $relationwithstudent;
        $data['visitornumber'] =        $visitornumber;
        $data['previous_class_information'] = $previous_class_information_json;
        $data['address'] = $address_json;
        $data['mobile1'] = $mobile1;
        $data['mobile2'] = $mobile2;
        $data['email'] = $email;

        $data['secondlanguageid'] = $secondlanguageid;
        $data['comments'] = $comments;
        $data['referredby'] = $referredby;

        $data['admissiontypeid'] = $admissiontypeid;
        $data['branchid'] = $branchid;
        $data['courseid'] = $courseid;
        $data['batchid'] = $batchid;
        $data['sectionid'] = $sectionid;

        $data['admissiondate'] = $admissiondate;
        $data['reservationstatusid'] = $reservationstatusid;
        $data['scholarship'] = $scholarship;
        $data['tuition_discount'] = $tuition_discount;
       $data['tuition_discount1'] = $tuition_discount1;
        $data['hostel_discount'] = $hostel_discount;
        $data['final_misc'] = $final_misc;

        $data['discountrequested'] = $discountrequested;
        $data['discountgiven'] = $discountgiven;
        $data['discountapproved_by'] = $discountapproved_by;
       $data['additionaldiscountgiven'] =      $additionaldiscountgiven;

        $data['created_by'] = $created_by;
        $date = date('Y-m-d H:i:s');
        $data['reservation_date'] = $date;

        $builder = $db->table('reservation');
        $builder->insert($data);

        $insertId = $db->insertID();
        $db->close();

        return $insertId;
    }

    public function updateReservation(
        $reservationid,
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
        $referredby,
        $batchid,
        $admissiondate,
        $scholarship,
        $tuition_discount,
        $hostel_discount,
        $comments,
        $rezofastdetails,
        $discountgiven,
        $reservationstatusid
    ) {
        $db = db_connect();
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
        $data['visitorname'] = $visitorname;
        $data['relationwithstudent'] =        $relationwithstudent;
        $data['visitornumber'] =        $visitornumber;
        $data['previous_class_information'] = $previous_class_information_json;
        $data['address'] = $address_json;
        $data['mobile1'] = $mobile1;
        $data['mobile2'] = $mobile2;
        $data['email'] = $email;

        $data['admissiontypeid'] = $admissiontypeid;
        $data['branchid'] = $branchid;
        $data['courseid'] = $courseid;
        $data['sectionid'] = $sectionid;
        $data['secondlanguageid'] = $secondlanguageid;
        $data['referredby'] = $referredby;
        $data['batchid'] = $batchid;

        $data['admissiondate'] = $admissiondate;
        $data['scholarship'] = $scholarship;
        $data['tuition_discount'] = $tuition_discount;
        $data['hostel_discount'] = $hostel_discount;
        $data['comments'] = $comments;

        $data['rezofastdetails'] = $rezofastdetails;
        $data['discountgiven'] = $discountgiven;

        $data['reservationstatusid'] = $reservationstatusid;

        $builder = $db->table('reservation');

        $builder->where('reservationid', $reservationid);
        $builder->update($data);

        $db->close();
    }
    public function updateReservationDetails(
        $reservationid,
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
        $referredby,
        $batchid,
        $admissiondate
    ) {
        $db = db_connect();
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
        $data['visitorname'] = $visitorname;
        $data['relationwithstudent'] =        $relationwithstudent;
        $data['visitornumber'] =        $visitornumber;
        $data['previous_class_information'] = $previous_class_information_json;
        $data['address'] = $address_json;
        $data['mobile1'] = $mobile1;
        $data['mobile2'] = $mobile2;
        $data['email'] = $email;

        $data['admissiontypeid'] = $admissiontypeid;
        $data['branchid'] = $branchid;
        $data['courseid'] = $courseid;
        $data['sectionid'] = $sectionid;
        $data['secondlanguageid'] = $secondlanguageid;
        $data['referredby'] = $referredby;
        $data['batchid'] = $batchid;

        $data['admissiondate'] = $admissiondate;

        $builder = $db->table('reservation');

        $builder->where('reservationid', $reservationid);
        $builder->update($data);

        $db->close();
    }
    public function updateReservation1(
        $reservationid){
            $db = db_connect();
        $data['is_migrate'] = 1;
        $builder = $db->table('reservation');

        $builder->where('reservationid', $reservationid);
        $builder->update($data);

        $db->close();
        }
        
        public function updateApplication1(
        $reservationid){
            $db = db_connect();
        $data['is_migrate'] = 1;
        $builder = $db->table('applications');

        $builder->where('applicationid', $reservationid);
        $builder->update($data);

        $db->close();
        }
    public function addReservationPayment($reservation_paymentid, $reservationId, $paymentamount, $paymentdate, $paymenttypeid, 
                                          $otherdetails, $paymentcollectedby, $paymentstatusid, $batch = 0,
                                          $remarks = NULL)
    {
        $db = db_connect();

        $data['reservation_paymentid'] = $reservation_paymentid;
        $data['reservationid'] = $reservationId;
        $data['paymentamount'] = $paymentamount;
        $data['paymentdate'] = $paymentdate;
        $data['paymenttypeid'] = $paymenttypeid;
        $data['otherdetails'] = $otherdetails;
        $data['paymentcollectedby'] = $paymentcollectedby;
        $data['paymentstatusid'] = $paymentstatusid;
        $data['batchid'] = $batch == 0 ? $_SESSION['activebatch'] : $batch;
        $data['remarks'] = $remarks;
        $builder = $db->table('reservation_payments');
        $status =  $builder->insert($data);

        return $status;
    }
    
    public function addReservationPaymentVoucher($reservation_paymentid, $reservationId,$userid, $paymentamount, $paymentdate, $paymenttypeid, 
                                          $otherdetails, $paymentcollectedby, $paymentstatusid, $batch = 0,
                                          $remarks = NULL,$voucherid)
    {
        $db = db_connect();

        $data['reservation_paymentid'] = $reservation_paymentid;
        $data['reservationid'] = $reservationId;
        $data['paymentamount'] = $paymentamount;
        $data['paymentdate'] = $paymentdate;
        $data['paymenttypeid'] = $paymenttypeid;
        $data['otherdetails'] = $otherdetails;
        $data['paymentcollectedby'] = $paymentcollectedby;
        $data['paymentstatusid'] = $paymentstatusid;
        $data['batchid'] = $batch == 0 ? $_SESSION['activebatch'] : $batch;
        $data['remarks'] = $remarks;
        $data['voucherid'] = $voucherid;
        $data['approved_by'] = $userid;
        $builder = $db->table('reservation_payments');
        $status =  $builder->insert($data);

        return $status;
    }

    public function getReservationPendingPaymentDetails()
    {
        $db = db_connect();
        $query = $db->query("SELECT *, ED.name as receivedby, R.name as studentName
                             FROM reservation_payments RP 
                             JOIN reservation R ON R.reservationid = RP.reservationid
                             JOIN paymentstatuslookup PSL ON RP.paymentstatusid = PSL.paymentstatusid 
                             JOIN paymenttypelookup PT ON RP.paymenttypeid = PT.paymenttypeid 
                             LEFT JOIN employeedetails ED ON RP.paymentcollectedby = ED.userid
                             WHERE RP.paymentstatusid = 1 AND
                             R.reservationstatusid = 4 AND
                             R.branchid IN ({$_SESSION['userdetails']->branchid})
                             AND R.batchid IN ({$_SESSION['activebatch']})");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function getAllReservationPaymentDetails()
    {
        $db = db_connect();
        $query = $db->query("SELECT *, ED.name as receivedby, R.name as studentName
                             FROM reservation_payments RP 
                             JOIN reservation R ON R.reservationid = RP.reservationid
                             JOIN paymentstatuslookup PSL ON RP.paymentstatusid = PSL.paymentstatusid 
                             JOIN paymenttypelookup PT ON RP.paymenttypeid = PT.paymenttypeid 
                             LEFT JOIN employeedetails ED ON RP.paymentcollectedby = ED.userid
                             LEFT JOIN branchlookup ON R.branchid = branchlookup.branchid
                             LEFT JOIN admissiontypelookup ON R.admissiontypeid = admissiontypelookup.admissiontypeid
                             LEFT JOIN courselookup ON R.courseid = courselookup.courseid
                             LEFT JOIN sectionlookup ON R.sectionid = sectionlookup.sectionid
                             LEFT JOIN genderlookup ON R.genderid = genderlookup.genderid
                             LEFT JOIN nationalitylookup ON R.nationalityid = nationalitylookup.nationalityid
                             LEFT JOIN religionlookup ON R.religionid = religionlookup.religionid
                             LEFT JOIN categorylookup ON R.categoryid = categorylookup.categoryid
                             WHERE R.branchid IN ({$_SESSION['userdetails']->branchid})
                             AND R.batchid IN ({$_SESSION['activebatch']})");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function getReservationPaymentDetailsByReservationId($reservationid)
    {
        $db = db_connect();
        $query = $db->query("SELECT *, ED.name as receivedby, R.name as studentName
                             FROM reservation_payments RP 
                             JOIN reservation R ON R.reservationid = RP.reservationid
                             JOIN paymentstatuslookup PSL ON RP.paymentstatusid = PSL.paymentstatusid 
                             JOIN paymenttypelookup PT ON RP.paymenttypeid = PT.paymenttypeid 
                             LEFT JOIN employeedetails ED ON RP.paymentcollectedby = ED.userid 
                             WHERE R.reservationid=$reservationid and RP.batchid IN ({$_SESSION['activebatch']})");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    
    public function getApplicationReservationPaymentDetailsByApplicationId($reservationid)
    {
        $db = db_connect();
        $query = $db->query("SELECT *, ED.name as receivedby, R.name as studentName
                             FROM reservation_payments RP 
                             JOIN reservation R ON R.reservationid = RP.reservationid
                             JOIN paymentstatuslookup PSL ON RP.paymentstatusid = PSL.paymentstatusid 
                             JOIN paymenttypelookup PT ON RP.paymenttypeid = PT.paymenttypeid 
                             LEFT JOIN employeedetails ED ON RP.paymentcollectedby = ED.userid 
                             WHERE R.reservationid=$reservationid and RP.batchid IN ({$_SESSION['activebatch']})");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function getReservationPaymentDetailsByReservationPaymentId($reservationpaymentid)
    {
        $db = db_connect();
        $query = $db->query("SELECT *, ED.name as receivedby, R.name as studentName
                             FROM reservation_payments RP 
                             JOIN reservation R ON R.reservationid = RP.reservationid
                             JOIN paymentstatuslookup PSL ON RP.paymentstatusid = PSL.paymentstatusid 
                             JOIN paymenttypelookup PT ON RP.paymenttypeid = PT.paymenttypeid 
                             LEFT JOIN branchlookup ON R.branchid = branchlookup.branchid
                             LEFT JOIN admissiontypelookup ON R.admissiontypeid = admissiontypelookup.admissiontypeid
                             LEFT JOIN courselookup ON R.courseid = courselookup.courseid
                             LEFT JOIN sectionlookup ON R.sectionid = sectionlookup.sectionid
                             LEFT JOIN genderlookup ON R.genderid = genderlookup.genderid
                             LEFT JOIN nationalitylookup ON R.nationalityid = nationalitylookup.nationalityid
                             LEFT JOIN religionlookup ON R.religionid = religionlookup.religionid
                             LEFT JOIN categorylookup ON R.categoryid = categorylookup.categoryid
                             LEFT JOIN employeedetails ED ON RP.paymentcollectedby = ED.userid 
                             WHERE RP.reservation_paymentid='$reservationpaymentid'");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    
    public function getReservationPaymentDiscountDetailsByReservationPaymentId($reservationpaymentid,$voucherid,$batchid)
    {
        $db = db_connect();
        $query = $db->query("SELECT RP.paymentamount,RP.reservation_paymentid,RD.approved_date,R.reservation_ukey,RD.reservation_discountid,branchlookup.branchname,batchlookup.batchname,admissiontypelookup.admissiontypename,courselookup.coursename, ED.name as receivedby, R.name as studentName
                             FROM reservation_payments RP 
                             JOIN reservation R ON R.reservationid = RP.reservationid
                             JOIN reservation_discounts RD ON RP.reservationid = RD.userid
                             JOIN paymentstatuslookup PSL ON RP.paymentstatusid = PSL.paymentstatusid 
                             JOIN paymenttypelookup PT ON RP.paymenttypeid = PT.paymenttypeid 
                             LEFT JOIN branchlookup ON R.branchid = branchlookup.branchid
                             LEFT JOIN batchlookup ON RP.batchid = batchlookup.batchid
                             LEFT JOIN admissiontypelookup ON R.admissiontypeid = admissiontypelookup.admissiontypeid
                             LEFT JOIN courselookup ON R.courseid = courselookup.courseid
                             LEFT JOIN sectionlookup ON R.sectionid = sectionlookup.sectionid
                             LEFT JOIN genderlookup ON R.genderid = genderlookup.genderid
                             LEFT JOIN nationalitylookup ON R.nationalityid = nationalitylookup.nationalityid
                             LEFT JOIN religionlookup ON R.religionid = religionlookup.religionid
                             LEFT JOIN categorylookup ON R.categoryid = categorylookup.categoryid
                             LEFT JOIN employeedetails ED ON RD.approved_by = ED.userid 
                             WHERE RP.reservation_paymentid='$reservationpaymentid' and RD.reservation_discountid='$voucherid' and RP.batchid=$batchid");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    
    public function getApplicationPaymentDetailsByReservationPaymentId($reservationpaymentid)
    {
        $db = db_connect();
        $query = $db->query("SELECT *, ED.name as receivedby, R.name as studentName
                             FROM applicationpayments RP 
                             JOIN applications R ON R.applicationid = RP.userid
                             JOIN paymentstatuslookup PSL ON RP.paymentstatusid = PSL.paymentstatusid 
                             JOIN paymenttypelookup PT ON RP.paymenttypeid = PT.paymenttypeid 
                             LEFT JOIN branchlookup ON R.branchid = branchlookup.branchid
                             LEFT JOIN admissiontypelookup ON R.admissiontypeid = admissiontypelookup.admissiontypeid
                             LEFT JOIN courselookup ON R.courseid = courselookup.courseid
                             LEFT JOIN sectionlookup ON R.sectionid = sectionlookup.sectionid
                             LEFT JOIN genderlookup ON R.genderid = genderlookup.genderid
                             LEFT JOIN nationalitylookup ON R.nationalityid = nationalitylookup.nationalityid
                             LEFT JOIN religionlookup ON R.religionid = religionlookup.religionid
                             LEFT JOIN categorylookup ON R.categoryid = categorylookup.categoryid
                             LEFT JOIN employeedetails ED ON RP.paymentcollectedby = ED.userid 
                             WHERE RP.userid='$reservationpaymentid'");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    
    public function getStudentPaymentDiscountDetailsByPaymentId($reservationpaymentid,$voucherid,$batchid)
    {
        $db = db_connect();
        $query = $db->query("SELECT RP.paymentamount,RP.paymentid as reservation_paymentid,RD.approved_date,R.applicationnumber as reservation_ukey,RD.reservation_discountid,branchlookup.branchname,batchlookup.batchname,admissiontypelookup.admissiontypename,courselookup.coursename, ED.name as receivedby, R.name as studentName
                             FROM payments RP 
                             JOIN studentdetails R ON R.userid = RP.userid
                             JOIN student_class_relation SCR ON R.userid = SCR.studentid
                             JOIN reservation_discounts RD ON RP.userid = RD.userid
                             JOIN paymentstatuslookup PSL ON RP.paymentstatusid = PSL.paymentstatusid 
                             JOIN paymenttypelookup PT ON RP.paymenttypeid = PT.paymenttypeid 
                             LEFT JOIN branchlookup ON SCR.branchid = branchlookup.branchid
                             LEFT JOIN batchlookup ON RP.batchid = batchlookup.batchid
                             LEFT JOIN admissiontypelookup ON SCR.admissiontypeid = admissiontypelookup.admissiontypeid
                             LEFT JOIN courselookup ON SCR.courseid = courselookup.courseid
                             LEFT JOIN sectionlookup ON SCR.sectionid = sectionlookup.sectionid
                             LEFT JOIN genderlookup ON R.genderid = genderlookup.genderid
                             LEFT JOIN nationalitylookup ON R.nationalityid = nationalitylookup.nationalityid
                             LEFT JOIN religionlookup ON R.religionid = religionlookup.religionid
                             LEFT JOIN categorylookup ON R.categoryid = categorylookup.categoryid
                             LEFT JOIN employeedetails ED ON RD.approved_by = ED.userid 
                             WHERE RP.paymentid='{$reservationpaymentid}' and RD.reservation_discountid='$voucherid' and RP.batchid={$batchid} and SCR.batchid={$batchid} group by SCR.studentid;");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function getAllPendingReservations()
    {
        $db = db_connect();
        $query = $db->query("SELECT * from reservation R 
                             JOIN branchlookup ON R.branchid = branchlookup.branchid
                             JOIN admissiontypelookup ON R.admissiontypeid = admissiontypelookup.admissiontypeid
                             JOIN courselookup ON R.courseid = courselookup.courseid
                             JOIN sectionlookup ON R.sectionid = sectionlookup.sectionid
                             JOIN reservationstatuslookup ON R.reservationstatusid = reservationstatuslookup.reservationstatusid
                             WHERE R.reservationstatusid IN (1,2) 
                             and branchlookup.branchid IN ({$_SESSION['userdetails']->branchid})
                             and R.batchid IN ({$_SESSION['activebatch']})");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function approveReservation($reservationid, $comments, $reservationstatusid)
    {
        $db = db_connect();

        $data['comments'] = $comments;
        $data['reservationstatusid'] = $reservationstatusid;
        $data['approved_by'] = $_SESSION['userdetails']->userid == null ? 0 : $_SESSION['userdetails']->userid;
        $data['approved_date'] = date('Y-m-d');

        $builder = $db->table('reservation');
        $builder->where('reservationid', $reservationid);
        $builder->update($data);
    }
    
    public function declineReservation($reservationid, $comments, $reservationstatusid)
    {
        $db = db_connect();

        $data['comments'] = $comments;
        $data['reservationstatusid'] = $reservationstatusid;
        $data['updated_by'] = $_SESSION['userdetails']->userid == null ? 0 : $_SESSION['userdetails']->userid;

        $builder = $db->table('reservation');
        $builder->where('reservationid', $reservationid);
        $builder->update($data);
    }
    public function updateRETstatus($id, $status)
    {
        $db = db_connect();
        $data['retstatus'] = $status;
        $builder = $db->table('applications');
        $builder->where('applicationid', $id);
        $builder->update($data);
    }
}
