<?php

namespace App\Models;

use CodeIgniter\Model;

class ReportsModel extends Model
{
    public function report_studentdetails(
        $batchid,
        $branchid,
        $courseid,
        $admissiontypeid,
        $sectionid,
        $referredbyid,
        $genderid,
        $AdmissionDateFrom,
        $AdmissionDateTo
    ) {
        $where = "ASL.applicationstatusname <> 'Dropped Out' and SD.studentstatus=1";

        if ($batchid != NULL) {
            if ($where == '') {
                $where = " SCR.batchid = {$batchid}";
            } else {
                $where = $where . " AND SCR.batchid = {$batchid}";
            }
        }else
        {
             if ($where == '') {
                $where = " SCR.batchid = {$_SESSION['activebatch']}";
            } else {
                $where = $where . " AND SCR.batchid = {$_SESSION['activebatch']}";
            }
        }
        if ($branchid != NULL) {
            if ($where == '') {
                $where = " SCR.branchid IN ({$branchid})";
            } else {
                $where = $where . " AND SCR.branchid IN ({$branchid})";
            }
        }
        if ($courseid != NULL) {
            if ($where == '') {
                $where = " SCR.courseid = {$courseid}";
            } else {
                $where = $where . " AND SCR.courseid = {$courseid}";
            }
        }
        if ($admissiontypeid != NULL) {
            if ($where == '') {
                $where = " SCR.admissiontypeid = {$admissiontypeid}";
            } else {
                $where = $where . " AND SCR.admissiontypeid = {$admissiontypeid}";
            }
        }
        if ($sectionid != NULL) {
            if ($where == '') {
                $where = " SCR.sectionid = {$sectionid}";
            } else {
                $where = $where . " AND SCR.sectionid = {$sectionid}";
            }
        }
        if ($referredbyid != NULL) {
            if ($where == '') {
                $where = " SD.referredby = {$referredbyid}";
            } else {
                $where = $where . " AND SD.referredby = {$referredbyid}";
            }
        }
        if ($genderid != NULL) {
            if ($where == '') {
                $where = " SD.genderid = {$genderid}";
            } else {
                $where = $where . " AND SD.genderid = {$genderid}";
            }
        }
        if ($AdmissionDateFrom != NULL) {
            if ($where == '') {
                $where = " SD.admissiondate >= '{$AdmissionDateFrom}'";
            } else {
                $where = $where . " AND SD.admissiondate >= '{$AdmissionDateFrom}'";
            }
        }
        if ($AdmissionDateTo != NULL) {
            if ($where == '') {
                $where = " SD.admissiondate <= '{$AdmissionDateTo}'";
            } else {
                $where = $where . " AND SD.admissiondate <= '{$AdmissionDateTo}'";
            }
        }

        $whereCondition = $where == '' ? '' : "WHERE {$where}";
        $db = db_connect();
        $query = $db->query("SELECT A.admissiondate, A.applicationnumber, A.branchname,A.batchid, A.name, A.fathername,
        A.gendername, A.admissiontypename, A.coursename, A.sectionname, A.mobile1, A.mobile2,
        A.batchname,A.reservation_ukey,A.userid,
        A.ReferredBy,
        D.FeesDue,
           CASE WHEN B.TotalFeesToPay IS NULL THEN 
               (SELECT SUM(feesvalue) + A.tuition_discount + A.hostel_discount FROM feestructurelookup WHERE courseid = A.courseid AND admissiontypeid = A.admissiontypeid AND feetype = 'Miscellaneous Charges')
           ELSE B.TotalFeesToPay END AS TotalFeesToPay,
           (D.FeesDue + TotalFeesToPay) AS TotalFeesIncludingDue,
           CASE WHEN C.TotalFeesPaid IS NULL THEN 
               0
           ELSE C.TotalFeesPaid END AS TotalFeesPaid, 
           CASE WHEN B.TotalFeesToPay IS NULL THEN 
               (SELECT SUM(feesvalue) + A.tuition_discount + A.hostel_discount - (CASE WHEN C.TotalFeesPaid IS NULL THEN 
               0
           ELSE C.TotalFeesPaid END) FROM feestructurelookup WHERE courseid = A.courseid AND admissiontypeid = A.admissiontypeid AND feetype = 'Miscellaneous Charges')
           ELSE B.TotalFeesToPay - ((CASE WHEN C.TotalFeesPaid IS NULL THEN 
               0
           ELSE C.TotalFeesPaid END)) END AS BalanceToBePaid, 
           A.userid AS PaymentDetails
           FROM
        (SELECT SD.admissiondate, BL.branchname, SD.applicationnumber, SCR.batchid, BAL.batchname,SD.reservation_ukey,
                GL.gendername, ED.name AS ReferredBy,SD.userid,
                SD.name, SD.fathername,CL.coursename, CL.courseid, SL.sectionid, SL.sectionname, mobile1, mobile2, 
                SD.tuition_discount,SD.hostel_discount, AL.admissiontypename, AL.admissiontypeid FROM studentdetails SD
                              LEFT JOIN student_class_relation SCR ON SD.userid = SCR.studentid
                              LEFT JOIN branchlookup BL ON SCR.branchid = BL.branchid
                              LEFT JOIN batchlookup BAL ON SCR.batchid = BAL.batchid
                              LEFT JOIN courselookup CL ON SCR.courseid = CL.courseid 
                              LEFT JOIN sectionlookup SL ON SCR.sectionid = SL.sectionid
                              LEFT JOIN employeedetails ED ON SD.referredby = ED.userid 
                              LEFT JOIN categorylookup CTL ON SD.categoryid = CTL.categoryid 
                              LEFT JOIN religionlookup RL ON SD.religionid = RL.religionid 
                              LEFT JOIN genderlookup GL ON SD.genderid = GL.genderid 
                              LEFT JOIN admissiontypelookup AL ON SCR.admissiontypeid = AL.admissiontypeid
                              LEFT JOIN applicationstatuslookup ASL ON ASL.applicationstatusid = SD.applicationstatusid $whereCondition) A 
        LEFT JOIN
        (select invoices.userid, invoices.batchid, SUM(invoices.feesvalue) AS TotalFeesToPay from invoices join feestructurelookup on invoices.feesid = feestructurelookup.feesid where feestructurelookup.feetype != 'Application Fee' and feestructurelookup.feetype != 'Dues' group by invoices.userid, invoices.batchid) B ON A.userid = B.userid AND A.batchid = B.batchid
        LEFT JOIN
        (select invoices.userid, invoices.batchid, SUM(invoices.feesvalue) AS FeesDue from invoices join feestructurelookup on invoices.feesid = feestructurelookup.feesid where feestructurelookup.feetype = 'Dues' group by invoices.userid, invoices.batchid) D ON A.userid = D.userid AND A.batchid = D.batchid
        LEFT JOIN
        (select userid, batchid, SUM(paymentamount) AS TotalFeesPaid from payments where paymentstatusid <> 2 group by userid, batchid) C ON C.userid = A.userid AND A.batchid = C.batchid");

        $results = $query->getResult();

        $db->close();

        return $results;
    }
    
    public function report_studentattendance(
        $branchid, $courseid,$sectionid,$AdmissionDateFrom, $AdmissionDateTo
    ) {
         $where = "SCR.batchid={$_SESSION['activebatch']} AND SD.studentstatus=1 AND SD.applicationstatusid <> 5";
        if ($branchid != NULL) {
            if ($where == '') {
                $where = " SCR.branchid IN ({$branchid})";
            } else {
                $where = $where . " AND SCR.branchid IN ({$branchid})";
            }
        }
        if ($courseid != NULL) {
            if ($where == '') {
                $where = " SCR.courseid = {$courseid}";
            } else {
                $where = $where . " AND SCR.courseid = {$courseid}";
            }
        }
        if ($admissiontypeid != NULL) {
            if ($where == '') {
                $where = " SCR.admissiontypeid = {$admissiontypeid}";
            } else {
                $where = $where . " AND SCR.admissiontypeid = {$admissiontypeid}";
            }
        }
        if ($sectionid != NULL) {
            if ($where == '') {
                $where = " SCR.sectionid = {$sectionid}";
            } else {
                $where = $where . " AND SCR.sectionid = {$sectionid}";
            }
        }
        if ($AdmissionDateFrom != NULL) {
            if ($where == '') {
                $where = " SAD.date >= '{$AdmissionDateFrom}'";
            } else {
                $where = $where . " AND SAD.date >= '{$AdmissionDateFrom}'";
            }
        }
        if ($AdmissionDateTo != NULL) {
            if ($where == '') {
                $where = " SAD.date <= '{$AdmissionDateTo}'";
            } else {
                $where = $where . " AND SAD.date <= '{$AdmissionDateTo}'";
            }
        }

        $whereCondition = $where == '' ? '' : "WHERE {$where}";

        $db = db_connect();
        $query = $db->query("SELECT A.applicationnumber,A.applicationstatusid, A.branchname, A.name,A.mobile1, A.fathername, A.mothername,
        A.coursename, A.sectionname, A.email,A.date,A.status,A.branchid,A.sectionid,A.login_time,A.is_latelogin
           FROM
        (SELECT SD.applicationstatusid,SD.userid, SD.email,BL.branchname, SD.applicationnumber,SCR.branchid,SCR.sectionid,
                SD.name, SD.mobile1, SD.fathername, SD.mothername, CL.coursename, CL.courseid,  SL.sectionname,SAD.date,SAD.status,SAD.login_time,SAD.is_latelogin FROM studentdetails SD
                              LEFT JOIN student_class_relation SCR ON SD.userid = SCR.studentid
                              LEFT JOIN branchlookup BL ON SCR.branchid = BL.branchid
                              LEFT JOIN batchlookup BAL ON SCR.batchid = BAL.batchid
                              LEFT JOIN courselookup CL ON SCR.courseid = CL.courseid 
                              LEFT JOIN sectionlookup SL ON SCR.sectionid = SL.sectionid
                              LEFT JOIN student_attendance_details SAD ON SAD.user_id = SD.userid
                              {$whereCondition}) A");

        $results = $query->getResult();

        $db->close();

        return $results;
    }
    
    public function admin_studentattendance(
        $branchid, $courseid,$sectionid,$AdmissionDateFrom, $AdmissionDateTo
    ) {
       
         $where = "SCR.batchid=3";
        if ($branchid != NULL) {
            if ($where == '') {
                $where = " SCR.branchid = {$branchid}";
            } else {
                $where = $where . " AND SCR.branchid = {$branchid}";
            }
        }
        if ($courseid != NULL) {
            if ($where == '') {
                $where = " SCR.courseid = {$courseid}";
            } else {
                $where = $where . " AND SCR.courseid = {$courseid}";
            }
        }
        if ($admissiontypeid != NULL) {
            if ($where == '') {
                $where = " SCR.admissiontypeid = {$admissiontypeid}";
            } else {
                $where = $where . " AND SCR.admissiontypeid = {$admissiontypeid}";
            }
        }
        if ($sectionid != NULL) {
            if ($where == '') {
                $where = " SCR.sectionid = {$sectionid}";
            } else {
                $where = $where . " AND SCR.sectionid = {$sectionid}";
            }
        }
        if ($AdmissionDateFrom != NULL) {
            if ($where == '') {
                $where = " SAD.date = '{$AdmissionDateFrom}'";
            } else {
                $where = $where . " AND SAD.date = '{$AdmissionDateFrom}'";
            }
        }
        $whereCondition = $where == '' ? '' : "WHERE {$where}";
        $db = db_connect();
        $query = $db->query("SELECT A.applicationnumber, A.branchname, A.name, A.fathername, A.mothername,
        A.coursename, A.sectionname, A.email,A.date,A.status,A.branchid,A.sectionid
           FROM
        (SELECT SD.userid, SD.email,BL.branchname, SD.applicationnumber,SCR.branchid,SCR.sectionid,
                SD.name, SD.fathername, SD.mothername, CL.coursename, CL.courseid,  SL.sectionname,SAD.date,SAD.status FROM studentdetails SD
                              LEFT JOIN student_class_relation SCR ON SD.userid = SCR.studentid
                              LEFT JOIN branchlookup BL ON SCR.branchid = BL.branchid
                              LEFT JOIN batchlookup BAL ON SCR.batchid = BAL.batchid
                              LEFT JOIN courselookup CL ON SCR.courseid = CL.courseid 
                              LEFT JOIN sectionlookup SL ON SCR.sectionid = SL.sectionid
                              LEFT JOIN student_attendance_details SAD ON SAD.user_id = SD.userid
                              {$whereCondition}) A");

        $results = $query->getResult();

        $db->close();

        return $results;
    }
    public function report_employeeattendance($AdmissionDateFrom, $AdmissionDateTo,$branchid)
    {
        
          if ($branchid != NULL) {
            if ($where == '') {
                $where = " employeedetails.branchid IN ({$branchid})";
            } else {
                $where = $where . " AND employeedetails.branchid IN ({$branchid})";
            }
        }
        if ($AdmissionDateFrom != NULL) {
            if ($where == '') {
                $where = " employee_attendance.date >= '{$AdmissionDateFrom}'";
            } else {
                $where = $where . " AND employee_attendance.date >= '{$AdmissionDateFrom}'";
            }
        }
        if ($AdmissionDateTo != NULL) {
            if ($where == '') {
                $where = " employee_attendance.date <= '{$AdmissionDateTo}'";
            } else {
                $where = $where . " AND employee_attendance.date <= '{$AdmissionDateTo}'";
            }
        }

        $whereCondition = $where == '' ? '' : "WHERE {$where}";
        $db = db_connect();
        $query = $db->query("SELECT employeedetails.userid,employeedetails.name,employeedetails.employeeid,employee_attendance.status,employee_attendance.date FROM employee_attendance JOIN employeedetails ON employee_attendance.employee_id = employeedetails.userid {$whereCondition} group by employeedetails.userid");

        $results = $query->getResult();
        $db->close();

        return $results;
    }
    
     public function report_employeedetailattendance($AdmissionDateFrom, $AdmissionDateTo,$branchid)
    {
        
          if ($branchid != NULL) {
            if ($where == '') {
                $where = " employeedetails.branchid IN ({$branchid})";
            } else {
                $where = $where . " AND employeedetails.branchid IN ({$branchid})";
            }
        }
        if ($AdmissionDateFrom != NULL) {
            if ($where == '') {
                $where = " employee_attendance.date >= '{$AdmissionDateFrom}'";
            } else {
                $where = $where . " AND employee_attendance.date >= '{$AdmissionDateFrom}'";
            }
        }
        if ($AdmissionDateTo != NULL) {
            if ($where == '') {
                $where = " employee_attendance.date <= '{$AdmissionDateTo}'";
            } else {
                $where = $where . " AND employee_attendance.date <= '{$AdmissionDateTo}'";
            }
        }

        $whereCondition = $where == '' ? '' : "WHERE {$where}";
        $db = db_connect();
        $query = $db->query("SELECT employeedetails.userid,employeedetails.name,employeedetails.employeeid,employee_attendance.status,employee_attendance.date FROM employee_attendance JOIN employeedetails ON employee_attendance.employee_id = employeedetails.userid {$whereCondition} group by employeedetails.userid");

        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function report_reservationdetails(
        $batchid,
        $branchid,
        $courseid,
        $admissiontypeid,
        $referredbyid,
        $genderid,
        $AdmissionDateFrom,
        $AdmissionDateTo,
        $ReservationDateFrom,
        $ReservationDateTo
    ) {
        $where = "RP.remarks ='Booking Amount'";

        if ($batchid != NULL) {
            if ($where == '') {
                $where = " R.batchid = {$batchid}";
            } else {
                $where = $where . " AND R.batchid = {$batchid}";
            }
        }
        else
        {
             if ($where == '') {
                $where = " R.batchid = {$_SESSION['activebatch']}";
            } else {
                $where = $where . " AND R.batchid = {$_SESSION['activebatch']}";
            }
        }
        if ($branchid != NULL) {
            if ($where == '') {
                $where = " R.branchid IN({$branchid})";
            } else {
                $where = $where . " AND R.branchid IN({$branchid})";
            }
        }
        if ($courseid != NULL) {
            if ($where == '') {
                $where = " R.courseid = {$courseid}";
            } else {
                $where = $where . " AND R.courseid = {$courseid}";
            }
        }
        if ($admissiontypeid != NULL) {
            if ($where == '') {
                $where = " R.admissiontypeid = {$admissiontypeid}";
            } else {
                $where = $where . " AND R.admissiontypeid = {$admissiontypeid}";
            }
        }
        if ($referredbyid != NULL) {
            if ($where == '') {
                $where = " R.referredby = {$referredbyid}";
            } else {
                $where = $where . " AND R.referredby = {$referredbyid}";
            }
        }
        if ($genderid != NULL) {
            if ($where == '') {
                $where = " R.genderid = {$genderid}";
            } else {
                $where = $where . " AND R.genderid = {$genderid}";
            }
        }
        if ($AdmissionDateFrom != NULL) {
            if ($where == '') {
                $where = " R.admissiondate >= '{$AdmissionDateFrom}'";
            } else {
                $where = $where . " AND R.admissiondate >= '{$AdmissionDateFrom}'";
            }
        }
        if ($AdmissionDateTo != NULL) {
            if ($where == '') {
                $where = " R.admissiondate <= '{$AdmissionDateTo}'";
            } else {
                $where = $where . " AND R.admissiondate <= '{$AdmissionDateTo}'";
            }
        }
        if ($ReservationDateFrom != NULL) {
            if ($where == '') {
                $where = " RP.paymentdate >= '{$ReservationDateFrom}'";
            } else {
                $where = $where . " AND RP.paymentdate >= '{$ReservationDateFrom}'";
            }
        }
        if ($ReservationDateTo != NULL) {
            if ($where == '') {
                $where = " RP.paymentdate <= '{$ReservationDateTo}'";
            } else {
                $where = $where . " AND RP.paymentdate <= '{$ReservationDateTo}'";
            }
        }

        $whereCondition = $where == '' ? '' : "WHERE {$where}";
        
        $db = db_connect();
        $query = $db->query("SELECT A.admissiondate, A.reservation_ukey, A.branchname, A.name, A.fathername, A.mothername, A.dateofbirth, 
                                    A.door_street, 
                                    A.village_mandal,
                                    A.landmark, 
                                    A.city_town,
                                    A.state_name,
                                    A.district_name,
                                    A.pin,
                                    A.school, A.place, A.courseid, A.admissiontypeid,
                                    A.gendername, A.admissiontypename, A.coursename, A.mobile1, A.mobile2, A.email,
                                    A.studentaadhaar, A.categoryname, A.religionname,
                                    A.ReferredBy, A.reservationstatusname, A.discountrequested,A.paymentdate,
                                    
                                    (SELECT Sum(feesvalue) FROM feestructurelookup FL WHERE  feetype <> 'Intermediate Fee' AND feetype <> 'Hostel Fee'
                                    AND FL.courseid = A.courseid
                                    AND FL.admissiontypeid = A.admissiontypeid
                                    AND FL.batchid = A.batchid) AS OtherFees,
                                    
                                    
                                      CASE
                                    WHEN A.admissiontypeid = 3 THEN 
                                      (
                                            ((SELECT feesvalue
                                             FROM feestructurelookup
                                             WHERE feetype = 'Intermediate Fee'
                                             AND feestructurelookup.courseid = A.courseid
                                             AND feestructurelookup.admissiontypeid = A.admissiontypeid
                                             AND feestructurelookup.batchid = A.batchid) - abs(A.discountgiven))
                                             )
                                      ELSE A.ipe_discount
                                    END AS IPEFees,
                                    ((SELECT Sum(feesvalue) FROM feestructurelookup FL WHERE 
                                     FL.courseid = A.courseid
                                    AND FL.admissiontypeid = A.admissiontypeid
                                    AND FL.batchid = A.batchid) - abs(A.discountgiven)) AS TotalFees,
                                CASE WHEN C.TotalFeesPaid IS NULL THEN 
                                    0
                                ELSE C.TotalFeesPaid END AS TotalFeesPaid,A.reservationid AS PaymentDetails 
                                FROM
                             (SELECT R.reservationid, R.batchid, R.email, R.admissiondate, BL.branchid, BL.branchname, R.reservation_ukey, 
                                     GL.gendername, R.dateofbirth, ED.name AS ReferredBy,
                                     R.studentaadhaar, CTL.categoryname, RL.religionname,
                                     R.name, R.fathername, R.mothername, RP.paymentdate,
                                     REPLACE(JSON_EXTRACT(address, '$[0].permanent.door_street'), '\"', '') AS door_street, 
                                     REPLACE(JSON_EXTRACT(address, '$[0].permanent.village_mandal'), '\"', '') AS village_mandal,
                                     REPLACE(JSON_EXTRACT(address, '$[0].permanent.landmark'), '\"', '') AS landmark, 
                                     REPLACE(JSON_EXTRACT(address, '$[0].permanent.city_town'), '\"', '') AS city_town,
                                     sl.state_name,
                                     dl.district_name,
                                     REPLACE(JSON_EXTRACT(address, '$[0].permanent.pin'), '\"', '') AS pin,
                                     REPLACE(JSON_EXTRACT(previous_class_information, \"$[0].school\"), '\"', '') AS school, 
                                     REPLACE(JSON_EXTRACT(previous_class_information, \"$[0].place\"), '\"', '') AS place,  
                                     CL.coursename, CL.courseid, mobile1, mobile2, 
                                     R.tuition_discount, R.hostel_discount, R.ipe_discount, R.discountrequested,R.discountgiven, AL.admissiontypename, AL.admissiontypeid, RSL.reservationstatusname FROM reservation R
                                                   LEFT JOIN reservation_payments RP ON RP.reservationid = R.reservationid
                                                   LEFT JOIN branchlookup BL ON R.branchid = BL.branchid
                                                   LEFT JOIN courselookup CL ON R.courseid = CL.courseid 
                                                   LEFT JOIN employeedetails ED ON R.referredby = ED.userid 
                                                   LEFT JOIN genderlookup GL ON R.genderid = GL.genderid 
                                                   LEFT JOIN categorylookup CTL ON R.categoryid = CTL.categoryid 
                                                   LEFT JOIN religionlookup RL ON R.religionid = RL.religionid 
                                                   LEFT JOIN admissiontypelookup AL ON R.admissiontypeid = AL.admissiontypeid
                                                   LEFT JOIN reservationstatuslookup RSL ON RSL.reservationstatusid = R.reservationstatusid 
                                                   LEFT JOIN stateslookup sl on sl.state_id = REPLACE(JSON_EXTRACT(R.address, '$[0].permanent.state'), '\"', '')
                                                   LEFT JOIN districtslookup dl on dl.district_id = REPLACE(JSON_EXTRACT(R.address, '$[0].permanent.district'), '\"', '')
                                                   {$whereCondition}) A
                             LEFT JOIN
                             (select reservationid, SUM(paymentamount) AS TotalFeesPaid from reservation_payments where paymentstatusid <> 2 group by reservationid) C ON C.reservationid = A.reservationid");

        $results = $query->getResult();
        $db->close();

        return $results;
    }
    
    
    public function report_applicationdetails(
        $batchid,
        $branchid,
        $courseid,
        $admissiontypeid,
        $referredbyid,
        $genderid,
        $AdmissionDateFrom,
        $AdmissionDateTo
    ) {
        $where = "";

        if ($batchid != NULL) {
            if ($where == '') {
                $where = " R.batchid = {$batchid}";
            } else {
                $where = $where . " AND R.batchid = {$batchid}";
            }
        }
        if ($branchid != NULL) {
            if ($where == '') {
                $where = " R.branchid IN ({$branchid})";
            } else {
                $where = $where . " AND R.branchid IN ({$branchid})";
            }
        }
        if ($courseid != NULL) {
            if ($where == '') {
                $where = " R.courseid = {$courseid}";
            } else {
                $where = $where . " AND R.courseid = {$courseid}";
            }
        }
        if ($admissiontypeid != NULL) {
            if ($where == '') {
                $where = " R.admissiontypeid = {$admissiontypeid}";
            } else {
                $where = $where . " AND R.admissiontypeid = {$admissiontypeid}";
            }
        }
        if ($referredbyid != NULL) {
            if ($where == '') {
                $where = " R.referredby = {$referredbyid}";
            } else {
                $where = $where . " AND R.referredby = {$referredbyid}";
            }
        }
        if ($genderid != NULL) {
            if ($where == '') {
                $where = " R.genderid = {$genderid}";
            } else {
                $where = $where . " AND R.genderid = {$genderid}";
            }
        }
        if ($AdmissionDateFrom != NULL) {
            if ($where == '') {
                $where = " R.admissiondate >= '{$AdmissionDateFrom}'";
            } else {
                $where = $where . " AND R.admissiondate >= '{$AdmissionDateFrom}'";
            }
        }
        if ($AdmissionDateTo != NULL) {
            if ($where == '') {
                $where = " R.admissiondate <= '{$AdmissionDateTo}'";
            } else {
                $where = $where . " AND R.admissiondate <= '{$AdmissionDateTo}'";
            }
        }

        $whereCondition = $where == '' ? '' : "WHERE {$where}";

        $db = db_connect();

        $query = $db->query("SELECT A.admissiondate, A.application_ukey, A.branchname, A.name, A.fathername, A.mothername, A.dateofbirth, 
                                    A.door_street, 
                                    A.village_mandal,
                                    A.landmark, 
                                    A.city_town,
                                    A.state_name,
                                    A.district_name,
                                    A.pin,
                                    A.school,A.boardname, A.place,
                                    A.gendername, A.admissiontypename, A.coursename, A.mobile1, A.mobile2, A.email,
                                    A.studentaadhaar, A.categoryname, A.religionname,
                                    A.ReferredBy, A.reservationstatusname,A.retstatusname, A.discountrequested,A.discountgiven,A.discountapproved_by,A.additionaldiscountgiven,A.comments,A.hostel_discount,A.tuition_discount,
                                    (A.hostel_discount + A.tuition_discount)AS TotalFees,
                                    C.TotalFeesPaid AS TotalFeesPaid,A.applicationid AS PaymentDetails
                                FROM
                             (SELECT R.applicationid, R.batchid, R.email, R.admissiondate, BL.branchid, BL.branchname, R.application_ukey, 
                                     GL.gendername, R.dateofbirth, ED.name AS ReferredBy,ED1.name AS discountapproved_by,
                                     R.studentaadhaar, CTL.categoryname, RL.religionname,
                                     R.name, R.fathername, R.mothername, 
                                     REPLACE(JSON_EXTRACT(address, '$[0].permanent.door_street'), '\"', '') AS door_street, 
                                     REPLACE(JSON_EXTRACT(address, '$[0].permanent.village_mandal'), '\"', '') AS village_mandal,
                                     REPLACE(JSON_EXTRACT(address, '$[0].permanent.landmark'), '\"', '') AS landmark, 
                                     REPLACE(JSON_EXTRACT(address, '$[0].permanent.city_town'), '\"', '') AS city_town,
                                     sl.state_name,
                                     dl.district_name,
                                     REPLACE(JSON_EXTRACT(address, '$[0].permanent.pin'), '\"', '') AS pin,
                                     REPLACE(JSON_EXTRACT(previous_class_information, \"$[0].school\"), '\"', '') AS school, 
                                     BOD.boardname,
                                     REPLACE(JSON_EXTRACT(previous_class_information, \"$[0].place\"), '\"', '') AS place,  
                                     CL.coursename, CL.courseid, mobile1, mobile2, 
                                     R.tuition_discount, R.hostel_discount, R.ipe_discount, R.discountrequested,R.discountgiven,R.additionaldiscountgiven,R.comments, AL.admissiontypename, AL.admissiontypeid, RSL.reservationstatusname,RETL.retstatusname FROM applications R
                                                   LEFT JOIN branchlookup BL ON R.branchid = BL.branchid
                                                   LEFT JOIN courselookup CL ON R.courseid = CL.courseid 
                                                   LEFT JOIN employeedetails ED ON R.created_by = ED.userid 
                                                   LEFT JOIN employeedetails ED1 ON R.discountapproved_by = ED1.userid 
                                                   LEFT JOIN genderlookup GL ON R.genderid = GL.genderid 
                                                   LEFT JOIN categorylookup CTL ON R.categoryid = CTL.categoryid 
                                                   LEFT JOIN religionlookup RL ON R.religionid = RL.religionid 
                                                   LEFT JOIN admissiontypelookup AL ON R.admissiontypeid = AL.admissiontypeid
                                                   LEFT JOIN reservationstatuslookup RSL ON RSL.reservationstatusid = R.reservationstatusid 
                                                   LEFT JOIN retstatuslookup RETL ON RETL.retid = R.retstatus
                                                   LEFT JOIN boardlookup BOD on BOD.boardid = REPLACE(JSON_EXTRACT(previous_class_information, \"$[0].board\"), '\"', '')
                                                   LEFT JOIN stateslookup sl on sl.state_id = REPLACE(JSON_EXTRACT(R.address, '$[0].permanent.state'), '\"', '')
                                                   LEFT JOIN districtslookup dl on dl.district_id = REPLACE(JSON_EXTRACT(R.address, '$[0].permanent.district'), '\"', '')
                                                   {$whereCondition}) A
                             LEFT JOIN
                             (select userid, SUM(paymentamount) AS TotalFeesPaid from applicationpayments where paymentstatusid <> 2 group by userid) C ON C.userid = A.applicationid");

        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function report_dropstudents($batchid, $branchid, $courseid, $admissiontypeid, $sectionid)
    {
        $where = "ASL.applicationstatusname = 'Dropped Out' AND SD.studentstatus=1";
        if ($batchid != NULL) {
            if ($where == '') {
                $where = " SCR.batchid = {$batchid}";
            } else {
                $where = $where . " AND SCR.batchid = {$batchid}";
            }
        }
        if ($branchid != NULL) {
            if ($where == '') {
                $where = " SCR.branchid IN ({$branchid})";
            } else {
                $where = $where . " AND SCR.branchid IN ({$branchid})";
            }
        }
        if ($courseid != NULL) {
            if ($where == '') {
                $where = " SCR.courseid = {$courseid}";
            } else {
                $where = $where . " AND SCR.courseid = {$courseid}";
            }
        }
        if ($admissiontypeid != NULL) {
            if ($where == '') {
                $where = " SCR.admissiontypeid = {$admissiontypeid}";
            } else {
                $where = $where . " AND SCR.admissiontypeid = {$admissiontypeid}";
            }
        }
        if ($sectionid != NULL) {
            if ($where == '') {
                $where = " SCR.sectionid = {$sectionid}";
            } else {
                $where = $where . " AND SCR.sectionid = {$sectionid}";
            }
        }

        $whereCondition = $where == '' ? '' : "WHERE {$where}";

        $db = db_connect();
        $query = $db->query("SELECT A.admissiondate, A.applicationnumber, A.branchname, A.name, A.fathername, A.dateofbirth, 
                             A.gendername, A.admissiontypename, A.coursename, A.sectionname, A.mobile1, A.mobile2, A.email,
                             A.ReferredBy, A.applicationstatusname,
                                CASE WHEN B.TotalFeesToPay IS NULL THEN 
                                    (SELECT SUM(feesvalue) + A.tuition_discount + A.hostel_discount FROM feestructurelookup WHERE courseid = A.courseid AND admissiontypeid = A.admissiontypeid AND feetype = 'Miscellaneous Charges')
                                ELSE B.TotalFeesToPay END AS TotalFeesToPay, 
                                CASE WHEN C.TotalFeesPaid IS NULL THEN 
                                    0
                                ELSE C.TotalFeesPaid END AS TotalFeesPaid, 
                                CASE WHEN B.TotalFeesToPay IS NULL THEN 
                                    (SELECT SUM(feesvalue) + A.tuition_discount + A.hostel_discount - (CASE WHEN C.TotalFeesPaid IS NULL THEN 
                                    0
                                ELSE C.TotalFeesPaid END) FROM feestructurelookup WHERE courseid = A.courseid AND admissiontypeid = A.admissiontypeid AND feetype = 'Miscellaneous Charges')
                                ELSE B.TotalFeesToPay - ((CASE WHEN C.TotalFeesPaid IS NULL THEN 
                                    0
                                ELSE C.TotalFeesPaid END)) END AS BalanceToBePaid,
                                D.TotalRefunded
                                FROM
                             (SELECT SD.userid, SD.email, SD.admissiondate, BL.branchname, SD.applicationnumber, 
                                     GL.gendername, SD.dateofbirth, ED.name AS ReferredBy,
                                     SD.name, SD.fathername, CL.coursename, CL.courseid, SL.sectionid, SL.sectionname, mobile1, mobile2, 
                                     SD.tuition_discount,SD.hostel_discount, AL.admissiontypename, AL.admissiontypeid, ASL.applicationstatusname FROM studentdetails SD
                                                   LEFT JOIN student_class_relation SCR ON SD.userid = SCR.studentid
                                                   LEFT JOIN branchlookup BL ON SCR.branchid = BL.branchid
                                                   LEFT JOIN courselookup CL ON SCR.courseid = CL.courseid 
                                                   LEFT JOIN sectionlookup SL ON SCR.sectionid = SL.sectionid
                                                   LEFT JOIN employeedetails ED ON SD.referredby = ED.userid 
                                                   LEFT JOIN genderlookup GL ON SD.genderid = GL.genderid 
                                                   LEFT JOIN admissiontypelookup AL ON SCR.admissiontypeid = AL.admissiontypeid
                                                   LEFT JOIN applicationstatuslookup ASL ON ASL.applicationstatusid = SD.applicationstatusid {$whereCondition}) A
                             LEFT JOIN
                             (select userid, invoiceid, SUM(feesvalue) AS TotalFeesToPay from invoices group by invoiceid) B ON A.userid = B.userid
                             LEFT JOIN
                             (select userid, SUM(paymentamount) AS TotalFeesPaid from payments where paymentstatusid <> 2 AND paymenttypeid <> 8 group by userid) C ON C.userid = A.userid
                             LEFT JOIN 
                             (select userid, -paymentamount AS TotalRefunded from payments where paymenttypeid = 8 group by userid) D ON D.userid = A.userid");

        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function report_admissiondetails($AdmissionDateFrom, $AdmissionDateTo)
    {
        $where = '';
        if ($AdmissionDateFrom != NULL) {
            if ($where == '') {
                $where = " AND studentdetails.admissiondate >= '{$AdmissionDateFrom}'";
            } else {
                $where = $where . " AND studentdetails.admissiondate >= '{$AdmissionDateFrom}'";
            }
        }
        if ($AdmissionDateTo != NULL) {
            if ($where == '') {
                $where = "AND studentdetails.admissiondate <= '{$AdmissionDateTo}'";
            } else {
                $where = $where . " AND studentdetails.admissiondate <= '{$AdmissionDateTo}'";
            }
        }

        $whereCondition = $where == '' ? '' : "WHERE studentdetails.studentstatus=1 {$where}";

        $db = db_connect();
        $query = $db->query("
		SELECT COUNT(studentdetails.referredby) as sum, employeedetails.name, employeedetails.userid, student_class_relation.branchid FROM 
        studentdetails  LEFT JOIN employeedetails ON studentdetails.referredby = employeedetails.userid 
        LEFT JOIN student_class_relation ON studentdetails.userid = student_class_relation.studentid {$whereCondition}
        GROUP BY studentdetails.referredby, student_class_relation.branchid
		");

        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function report_collectionsummarydetails($PaymentDateFrom, $PaymentDateTo)
    {
        $where = "payments.paymentstatusid <> 2 AND paymenttypelookup.paymenttypename <> 'Refund' AND studentdetails.studentstatus=1";
        if ($PaymentDateFrom != NULL) {
            if ($where == '') {
                $where = " payments.paymentdate >= '{$PaymentDateFrom}'";
            } else {
                $where = $where . " AND payments.paymentdate >= '{$PaymentDateFrom}'";
            }
        }
        if ($PaymentDateTo != NULL) {
            if ($where == '') {
                $where = " payments.paymentdate <= '{$PaymentDateTo}'";
            } else {
                $where = $where . " AND payments.paymentdate <= '{$PaymentDateTo}'";
            }
        }

        $whereCondition = $where == '' ? '' : "WHERE {$where}";

        $db = db_connect();
        $query = $db->query("
		SELECT sum(payments.paymentamount) as paymentamount, COUNT(payments.paymentid) AS NoOfTransactions, 
        branchlookup.branchname,paymenttypelookup.paymenttypename,payments.paymenttypeid,branchlookup.branchid 
        from payments 
        LEFT JOIN studentdetails ON payments.userid = studentdetails.userid
		LEFT JOIN student_class_relation ON payments.userid = student_class_relation.studentid AND payments.batchid = student_class_relation.batchid
		LEFT JOIN branchlookup ON student_class_relation.branchid = branchlookup.branchid
		LEFT JOIN paymenttypelookup ON payments.paymenttypeid = paymenttypelookup.paymenttypeid {$whereCondition}
		group by student_class_relation.branchid, payments.paymenttypeid
		");

        $results = $query->getResult();
        $db->close();

        return $results;
    }
    
    public function report_attendancesummarydetails($DateFrom, $DateTo)
    {
      //  $where = "SCR.batchid IN (SELECT batchid FROM `batchlookup` where batchid >= (SELECT batchid FROM `batchlookup` where isactive = 1))";
       $where = "SCR.batchid IN (SELECT batchid FROM `batchlookup` where batchid=(SELECT batchid FROM `batchlookup` where isactive = 1)) AND SD.studentstatus=1  AND SD.applicationstatusid <> 5";
        if ($DateFrom != NULL) {
            if ($where == '') {
                $where = " SAD.date = '{$DateFrom}'";
            } else {
                $where = $where . " AND SAD.date = '{$DateFrom}'";
            }
        }
        if ($DateTo != NULL) {
            if ($where == '') {
                $where = " SAD.date <= '{$DateTo}'";
            } else {
                $where = $where . " AND SAD.date <= '{$DateTo}'";
            }
        }

        $whereCondition = $where == '' ? '' : "WHERE {$where}";
        $db = db_connect();
        $query = $db->query("
		SELECT A.applicationnumber, A.branchname, A.name, A.fathername, A.mothername,
        A.coursename, A.sectionname, A.email,A.date,A.status,A.is_latelogin,A.branchid,A.sectionid,A.courseid
           FROM
        (SELECT SD.userid, SD.email,BL.branchname, SD.applicationnumber,SCR.branchid,SCR.sectionid,SCR.courseid,
                SD.name, SD.fathername, SD.mothername, CL.coursename, SL.sectionname,SAD.date,SAD.status,SAD.is_latelogin FROM studentdetails SD
                              LEFT JOIN student_class_relation SCR ON SD.userid = SCR.studentid
                              LEFT JOIN branchlookup BL ON SCR.branchid = BL.branchid
                              LEFT JOIN batchlookup BAL ON SCR.batchid = BAL.batchid
                              LEFT JOIN courselookup CL ON SCR.courseid = CL.courseid 
                              LEFT JOIN sectionlookup SL ON SCR.sectionid = SL.sectionid
                              LEFT JOIN student_attendance_details SAD ON SAD.user_id = SD.userid
                              {$whereCondition} GROUP BY SCR.studentid) A 
		");

        $results = $query->getResult();
        $db->close();

        return $results;
    }
    
    
    public function report_concernsummarydetails($DateFrom, $DateTo)
    {
      //  $where = "SCR.batchid IN (SELECT batchid FROM `batchlookup` where batchid >= (SELECT batchid FROM `batchlookup` where isactive = 1))";
       $where = "SCR.batchid IN (SELECT batchid FROM `batchlookup` where batchid={$_SESSION['activebatch']})";
        if ($DateFrom != NULL) {
            if ($where == '') {
                $DateFrom =  $DateFrom.' 01:00:00';
                $where = " SAD.created_date >= '{$DateFrom}'";
            } else {
                $DateFrom =  $DateFrom.' 01:00:00';
                $where = $where . " AND SAD.created_date >= '{$DateFrom}'";
            }
        }
        if ($DateTo != NULL) {
            if ($where == '') {
                $DateTo =  $DateTo.' 23:59:00';
                $where = " SAD.created_date <= '{$DateTo}'";
            } else {
                $DateTo =  $DateTo.' 23:59:00';
                $where = $where . " AND SAD.created_date <= '{$DateTo}'";
            }
        }

        $whereCondition = $where == '' ? '' : "WHERE {$where}";
        
        $db = db_connect();
        $query = $db->query("
		SELECT A.applicationnumber, A.branchname, A.name, A.fathername, A.mothername,
        A.coursename, A.email,A.branchid,A.courseid,A.status
           FROM
        (SELECT SD.userid, SD.email,BL.branchname, SD.applicationnumber,SCR.branchid,SCR.sectionid,SCR.courseid,
                SD.name, SD.fathername, SD.mothername, CL.coursename,SAD.status FROM studentdetails SD
                              LEFT JOIN student_class_relation SCR ON SD.userid = SCR.studentid
                              LEFT JOIN branchlookup BL ON SCR.branchid = BL.branchid
                              LEFT JOIN batchlookup BAL ON SCR.batchid = BAL.batchid
                              LEFT JOIN courselookup CL ON SCR.courseid = CL.courseid 
                              JOIN concerns SAD ON SAD.student_id = SD.userid
                              {$whereCondition}) A 
		");

        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function report_collectiondetails($PaymentDateFrom, $PaymentDateTo)
    {
        $where = "payments.paymentstatusid <> 2 AND paymenttypelookup.paymenttypename <> 'Refund' AND studentdetails.studentstatus=1";
        if ($PaymentDateFrom != NULL) {
            if ($where == '') {
                $where = " payments.paymentdate >= '{$PaymentDateFrom}'";
            } else {
                $where = $where . " AND payments.paymentdate >= '{$PaymentDateFrom}'";
            }
        }
        if ($PaymentDateTo != NULL) {
            if ($where == '') {
                $where = " payments.paymentdate <= '{$PaymentDateTo}'";
            } else {
                $where = $where . " AND payments.paymentdate <= '{$PaymentDateTo}'";
            }
        }
        $branchid = $_SESSION['userdetails']->branchid;
             if ($where == '') {
                $where = " student_class_relation.branchid IN ({$branchid})";
            } else {
                $where = $where . " AND student_class_relation.branchid IN ({$branchid})";
            }

        $whereCondition = $where == '' ? '' : "WHERE {$where}";

        $db = db_connect();
        $query = $db->query("
		SELECT (payments.paymentamount) as paymentamount,employeedetails.name AS paymententeredby,payments.paymentid,payments.createddate AS paymentcreateddate, genderlookup.gendername,courselookup.coursename,sectionlookup.sectionname,branchlookup.branchname,paymenttypelookup.paymenttypename,studentdetails.name,studentdetails.mobile1,studentdetails.applicationnumber,payments.otherdetails as paymentdetails,payments.paymentdate, paymentstatuslookup.paymentstatusname, payments.remarks from payments 
		LEFT JOIN employeedetails ON payments.paymentcollectedby = employeedetails.userid
		LEFT JOIN studentdetails ON payments.userid = studentdetails.userid  
        LEFT JOIN genderlookup ON studentdetails.genderid = genderlookup.genderid 
		LEFT JOIN student_class_relation ON payments.userid = student_class_relation.studentid AND payments.batchid = student_class_relation.batchid
        LEFT JOIN courselookup ON student_class_relation.courseid = courselookup.courseid 
        LEFT JOIN sectionlookup ON student_class_relation.sectionid = sectionlookup.sectionid
		LEFT JOIN branchlookup ON student_class_relation.branchid = branchlookup.branchid
		LEFT JOIN paymenttypelookup ON payments.paymenttypeid = paymenttypelookup.paymenttypeid
        LEFT JOIN paymentstatuslookup ON payments.paymentstatusid = paymentstatuslookup.paymentstatusid {$whereCondition}");

        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function report_reservationcollectiondetails($PaymentDateFrom, $PaymentDateTo)
    {
        $where = "RP.paymentstatusid <> 2 and R.is_migrate=0";
        if ($PaymentDateFrom != NULL) {
            if ($where == '') {
                $where = " RP.paymentdate >= '{$PaymentDateFrom}'";
            } else {
                $where = $where . " AND RP.paymentdate >= '{$PaymentDateFrom}'";
            }
        }
        if ($PaymentDateTo != NULL) {
            if ($where == '') {
                $where = " RP.paymentdate <= '{$PaymentDateTo}'";
            } else {
                $where = $where . " AND RP.paymentdate <= '{$PaymentDateTo}'";
            }
        }
            $branchid = $_SESSION['userdetails']->branchid;
             if ($where == '') {
                $where = " employeedetails.branchid IN ({$branchid})";
            } else {
                $where = $where . " AND employeedetails.branchid IN ({$branchid})";
            }
        $whereCondition = $where == '' ? '' : "WHERE {$where}";

        $db = db_connect();
        $query = $db->query("
		SELECT (RP.paymentamount) as paymentamount,employeedetails.name AS paymententeredby,RP.createddate AS paymentcreateddate, genderlookup.gendername,courselookup.coursename,branchlookup.branchname,paymenttypelookup.paymenttypename,R.name,R.reservation_ukey,R.mobile1,RP.otherdetails as paymentdetails,RP.paymentdate, paymentstatuslookup.paymentstatusname, RP.remarks from reservation_payments RP 
		LEFT JOIN employeedetails ON RP.paymentcollectedby = employeedetails.userid
		JOIN reservation R ON RP.reservationid = R.reservationid
        LEFT JOIN genderlookup ON R.genderid = genderlookup.genderid 
        LEFT JOIN courselookup ON R.courseid = courselookup.courseid 
        LEFT JOIN sectionlookup ON R.sectionid = sectionlookup.sectionid
		LEFT JOIN branchlookup ON R.branchid = branchlookup.branchid
		LEFT JOIN paymenttypelookup ON RP.paymenttypeid = paymenttypelookup.paymenttypeid
        LEFT JOIN paymentstatuslookup ON RP.paymentstatusid = paymentstatuslookup.paymentstatusid {$whereCondition}");

        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function report_getrevenue()
    {
        $db = db_connect();
        $query = $db->query("
        SELECT *, (A.CommittedFee - C.TotalCollected) AS TotalPending FROM 
        (SELECT COUNT(student_class_relation.studentid) AS TotalStudents, student_class_relation.branchid, SUM(studentdetails.tuition_discount) AS TotalTuitionFee, SUM(studentdetails.hostel_discount) AS TotalHostelFee, 
        SUM(feestructurelookup.feesvalue) AS TotalMiscelleniousFee, SUM(feestructurelookup.feesvalue + studentdetails.tuition_discount + studentdetails.hostel_discount) AS CommittedFee, SUM(studentdetails.scholarship) AS TotalScholarship FROM student_class_relation JOIN feestructurelookup ON student_class_relation.courseid = feestructurelookup.courseid AND student_class_relation.admissiontypeid = feestructurelookup.admissiontypeid AND feestructurelookup.feetype = 'Miscellaneous Charges'
        JOIN studentdetails ON student_class_relation.studentid = studentdetails.userid GROUP BY student_class_relation.branchid)A 
        JOIN 
        (SELECT student_class_relation.branchid, SUM(feesvalue) AS OriginalFee FROM student_class_relation JOIN feestructurelookup ON student_class_relation.courseid = feestructurelookup.courseid AND student_class_relation.admissiontypeid = feestructurelookup.admissiontypeid GROUP BY student_class_relation.branchid)B ON A.branchid = B.branchid
        JOIN 
        (SELECT student_class_relation.branchid, SUM(paymentamount) AS TotalCollected FROM payments JOIN studentdetails ON payments.userid = studentdetails.userid
        JOIN student_class_relation ON studentdetails.userid = student_class_relation.studentid
        WHERE payments.paymentstatusid <> 2 AND payments.paymenttypeid <> 8
        GROUP BY student_class_relation.branchid)C ON A.branchid = C.branchid
		JOIN branchlookup ON A.branchid = branchlookup.branchid");

        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function report_getoutpasssummery()
    {
        $db = db_connect();
        $query = $db->query("
        SELECT * FROM 
        (SELECT COUNT(student_class_relation.studentid) AS TotalStudents, student_class_relation.branchid FROM student_class_relation 
        JOIN studentdetails ON student_class_relation.studentid = studentdetails.userid where student_class_relation.batchid IN (select batchlookup.batchid from batchlookup where isactive=1) GROUP BY student_class_relation.branchid)A 
		JOIN branchlookup ON A.branchid = branchlookup.branchid");

        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function report_getoutpassout()
    {
        $db = db_connect();
        $query = $db->query("SELECT count(student_class_relation.branchid) as outtotal,student_class_relation.branchid from form_requests join student_class_relation on form_requests.user_id = student_class_relation.studentid where form_type='StudentOutPass' and student_class_relation.batchid IN (select batchlookup.batchid from batchlookup where isactive=1) and indata IS NULL group by student_class_relation.branchid");
        
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function report_gettodayout()
    {
         $db = db_connect();
        $query = $db->query("SELECT count(student_class_relation.branchid) as outtotal ,student_class_relation.branchid from form_requests join student_class_relation on form_requests.user_id = student_class_relation.studentid where form_type='StudentOutPass' and student_class_relation.batchid IN (select batchlookup.batchid from batchlookup where isactive=1) and date(fromdate)= curdate() group by student_class_relation.branchid");
        
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function report_getoutpassoutintoday()
    {
        $db = db_connect();
        $query = $db->query("SELECT count(student_class_relation.branchid) as outtotal ,student_class_relation.branchid from form_requests join student_class_relation on form_requests.user_id = student_class_relation.studentid where form_type='StudentOutPass' and student_class_relation.batchid IN (select batchlookup.batchid from batchlookup where isactive=1) and date(indata)= curdate() group by student_class_relation.branchid");
        
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function report_gettodayin()
    {
        $db = db_connect();
        $query = $db->query("SELECT count(student_class_relation.branchid) as outtotal ,student_class_relation.branchid from form_requests join student_class_relation on form_requests.user_id = student_class_relation.studentid where form_type='StudentOutPass' and student_class_relation.batchid IN (select batchlookup.batchid from batchlookup where isactive=1) and date(todate)= curdate() and indata IS NULL group by student_class_relation.branchid");
        
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function report_gettotalin()
    {
        $db = db_connect();
        $query = $db->query("SELECT count(student_class_relation.branchid) as outtotal ,student_class_relation.branchid from form_requests join student_class_relation on form_requests.user_id = student_class_relation.studentid where form_type='StudentOutPass' and student_class_relation.batchid IN (select batchlookup.batchid from batchlookup where isactive=1) and date(todate) <= curdate() and indata IS NULL group by student_class_relation.branchid;");
        
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function report_getnoc()
    {
        $db = db_connect();
        $query = $db->query("
        SELECT count(name) as studentcount ,branchname,sectionname,studentdetails.applicationnumber,studentdetails.userid,student_class_relation.batchid,student_class_relation.sectionid as sec,student_class_relation.branchid as branch, student_class_relation.admissiontypeid FROM studentdetails
        JOIN student_class_relation on studentdetails.userid=student_class_relation.studentid
        JOIN branchlookup on student_class_relation.branchid=branchlookup.branchid
        JOIN sectionlookup on student_class_relation.sectionid=sectionlookup.sectionid
        where  student_class_relation.batchid={$_SESSION['activebatch']}
        group by student_class_relation.branchid,student_class_relation.sectionid");

        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function report_tc_eligible($courseid)
    {
        $where = '';
        if ($courseid != NULL) {
            if ($where == '') {
                $where = "AND student_class_relation.courseid = {$courseid}";
            } else {
                $where = $where . " AND student_class_relation.courseid = {$courseid}";
            }
        }
        
        $whereCondition = $where == '' ? '' : "{$where}";

         $db = db_connect();
            $query = $db->query("
           SELECT InvoiceDetails.*, InvoiceDetails.userid, InvoiceDetails.TotalValue,InvoiceDetails.admissiontypeid,
                              PaymentDetails.TotalPaid,InvoiceDetails.branchid FROM
                                 (SELECT student_class_relation.branchid,student_class_relation.batchid, SUM(invoices.feesvalue) as TotalValue, studentdetails.userid, admissiontypelookup.admissiontypeid
                                 from invoices JOIN users ON invoices.userid = users.userid 
                                 JOIN studentdetails ON studentdetails.userid = users.userid 
                                 JOIN student_class_relation ON student_class_relation.studentid = studentdetails.userid
                                 JOIN admissiontypelookup ON student_class_relation.admissiontypeid = admissiontypelookup.admissiontypeid
                                 WHERE student_class_relation.batchid ={$_SESSION['activebatch']} and invoices.batchid={$_SESSION['activebatch']} $whereCondition
                                 GROUP BY student_class_relation.studentid) InvoiceDetails
                                 LEFT JOIN
                                 (SELECT SUM(payments.paymentamount) as TotalPaid, payments.userid FROM payments JOIN users ON payments.userid = users.userid where payments.batchid={$_SESSION['activebatch']} GROUP BY payments.userid) PaymentDetails ON InvoiceDetails.userid = PaymentDetails.userid;");

        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function report_tc_given($courseid)
    {
         $where = '';
        if ($courseid != NULL) {
            if ($where == '') {
                $where = "AND student_class_relation.courseid = {$courseid}";
            } else {
                $where = $where . " AND student_class_relation.courseid = {$courseid}";
            }
        }
        
        $whereCondition = $where == '' ? '' : "{$where}";
         $db = db_connect();
            $query = $db->query("
          select * from tc_log join studentdetails on studentdetails.userid=tc_log.userid JOIN student_class_relation ON student_class_relation.studentid = studentdetails.userid where student_class_relation.batchid={$_SESSION['activebatch']} $whereCondition GROUP BY tc_log.userid");

        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function report_getdiscount()
    {
        $db = db_connect();
        $query = $db->query("SELECT Fr.*, Sd.applicationnumber,Sd.name, Cr.name AS CreatedBy, Up.Name as UpdatedBy FROM form_requests Fr
                            JOIN studentdetails Sd on Fr.user_id = Sd.userid
                            JOIN employeedetails Cr on Fr.created_by = Cr.userid
                            LEFT JOIN employeedetails Up on Fr.updated_by = Up.userid
                            WHERE Fr.form_type='discountApproval' and Fr.batchid={$_SESSION['activebatch']}");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function report_getreservationbudget()
    {
         $db = db_connect();
        $query = $db->query("SELECT employeediscount_limit.*,employeedetails.name,branchlookup.branchname FROM `employeediscount_limit` JOIN employeedetails ON employeediscount_limit.employeeid=employeedetails.userid JOIN branchlookup ON employeedetails.branchid=branchlookup.branchid where batchid=4");

        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function report_getreservationdiscount()
    {
        $branchid = $_SESSION['userdetails']->branchid;
        $db = db_connect();
        $query = $db->query("SELECT reservation.reservation_ukey,reservation.name,BL.branchname,reservation_discounts.reservation_discountid,reservation_discounts.type,vouchertype,reservation_discounts.amount as firstyearamount,reservation_discounts.amount1 as secondyearamount,reservation_discounts.approvedamount as approvedfirstyearamount,reservation_discounts.approvedamount1 as approvedsecondyearamount,reservation_discounts.discounttype,reservation_discounts.comments,reservation_discounts.reason,reservation_discounts.status,ED2.name as createdby,reservation_discounts.date as createddate,ED1.name as approvedby,reservation_discounts.approved_date,reservation_discounts.commentreason as approvercomment from reservation_discounts left join reservation on reservation_discounts.userid=reservation.reservationid 
        JOIN branchlookup BL ON reservation.branchid = BL.branchid
        left JOIN employeedetails ED1 ON reservation_discounts.approved_by = ED1.userid 
        left JOIN employeedetails ED2 ON reservation_discounts.created_by = ED2.userid 
        left JOIN voucherlookup ON reservation_discounts.discounttypeid = voucherlookup.voucherid 
        WHERE reservation_discounts.batchid= {$_SESSION['activebatch']} and type=1 and reservation.branchid IN ({$branchid}) order by reservation_discounts.id desc;");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    
    public function report_getstudentdiscount()
    {
        
        $branchid = $_SESSION['userdetails']->branchid;
        $db = db_connect();
        $query = $db->query("SELECT studentdetails.applicationnumber,studentdetails.name,branchlookup.branchname,reservation_discounts.type,reservation_discounts.reservation_discountid,vouchertype,reservation_discounts.amount as requestedamount,reservation_discounts.approvedamount,ED2.name as createdby,reservation_discounts.discounttype,reservation_discounts.comments,reservation_discounts.reason,reservation_discounts.date as createddate,reservation_discounts.status,ED1.name as approvedby,reservation_discounts.approved_date,reservation_discounts.commentreason as approvercomment from reservation_discounts left join studentdetails on reservation_discounts.userid=studentdetails.userid 
        left join student_class_relation on studentdetails.userid = student_class_relation.studentid
        left join branchlookup on student_class_relation.branchid = branchlookup.branchid
        left JOIN employeedetails ED1 ON reservation_discounts.approved_by = ED1.userid 
        left JOIN employeedetails ED2 ON reservation_discounts.created_by = ED2.userid 
        left JOIN voucherlookup ON reservation_discounts.discounttypeid = voucherlookup.voucherid 
        WHERE reservation_discounts.batchid= {$_SESSION['activebatch']} and student_class_relation.batchid={$_SESSION['activebatch']} and type=2 and student_class_relation.branchid IN ({$branchid}) group by student_class_relation.studentid order by reservation_discounts.id desc;");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function report_wallet($branchid, $wallettypeid)
    {
        $where = " SCR.batchid IN ({$_SESSION['activebatch']})";
        if ($branchid != NULL) {
            if ($where == '') {
                $where = " SCR.branchid IN ({$branchid})";
            } else {
                $where = $where . " AND SCR.branchid IN ({$branchid})";
            }
        }
        if ($wallettypeid != NULL) {
            if ($where == '') {
                $where = " wallettypelookup.wallettypeid = {$wallettypeid}";
            } else {
                $where = $where . " AND wallettypelookup.wallettypeid = {$wallettypeid}";
            }
        }


        $whereCondition = $where == '' ? '' : "WHERE {$where}";

        $db = db_connect();
        $query = $db->query("SELECT SD.applicationnumber, SD.name, GL.gendername, CL.coursename,
                                    SL.sectionname, BL.branchname, wallettypelookup.wallettypename,
                                    wallet.amount FROM wallet 
                                JOIN wallettypelookup ON wallettypelookup.wallettypeid = wallet.wallettypeid 
                                LEFT JOIN studentdetails SD ON SD.userid = wallet.userid
                                LEFT JOIN student_class_relation SCR ON SD.userid = SCR.studentid
                                LEFT JOIN branchlookup BL ON SCR.branchid = BL.branchid
                                LEFT JOIN courselookup CL ON SCR.courseid = CL.courseid 
                                LEFT JOIN sectionlookup SL ON SCR.sectionid = SL.sectionid
                                LEFT JOIN genderlookup GL ON SD.genderid = GL.genderid 
                                $whereCondition");

        $results = $query->getResult();
        $db->close();

        return $results;
    }
    
     public function report_tc()
    {
        $db = db_connect();
        $query = $db->query("SELECT SD.applicationnumber,BL.branchname, SD.name,tc_log.date,ED.name as employeename FROM studentdetails SD  
                                JOIN student_class_relation SCR ON SD.userid = SCR.studentid
                                JOIN branchlookup BL ON SCR.branchid = BL.branchid
                                JOIN tc_log ON tc_log.userid = SD.userid 
                                LEFT JOIN employeedetails ED ON ED.userid = tc_log.generated_by
                                ");

        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function report_wallettransactions($branchid, $wallettypeid, $PaymentDateFrom, $PaymentDateTo)
    {
        $where = " SCR.batchid IN ({$_SESSION['activebatch']}) ";
        if ($branchid != NULL) {
            if ($where == '') {
                $where = " SCR.branchid IN ({$branchid})";
            } else {
                $where = $where . " AND SCR.branchid IN ({$branchid})";
            }
        }
        if ($wallettypeid != NULL) {
            if ($where == '') {
                $where = " wallettypelookup.wallettypeid = {$wallettypeid}";
            } else {
                $where = $where . " AND wallettypelookup.wallettypeid = {$wallettypeid}";
            }
        }
        if ($PaymentDateFrom != NULL) {
            if ($where == '') {
                $where = " wallettransactions.date >= '{$PaymentDateFrom}'";
            } else {
                $where = $where . " AND wallettransactions.date >= '{$PaymentDateFrom}'";
            }
        }
        if ($PaymentDateTo != NULL) {
            if ($where == '') {
                $where = " wallettransactions.date <= '{$PaymentDateTo}'";
            } else {
                $where = $where . " AND wallettransactions.date <= '{$PaymentDateTo}'";
            }
        }

        $whereCondition = $where == '' ? '' : "WHERE {$where}";

        $db = db_connect();
        $query = $db->query("SELECT SD.applicationnumber, SD.name, GL.gendername, CL.coursename,
                                    SL.sectionname, BL.branchname, wallettypelookup.wallettypename, 
                                    wallettransactions.amount, wallettransactions.date, wallettransactions.payment_details,
                                    wallettransactions.transactiontype, wallettransactions.remarks, 
                                    employeedetails.name AS TransactedBy FROM wallet 
                                JOIN wallettypelookup ON wallettypelookup.wallettypeid = wallet.wallettypeid 
                                JOIN wallettransactions ON wallettransactions.walletid = wallet.walletid
                                LEFT JOIN employeedetails ON wallettransactions.transactedby = employeedetails.userid
                                LEFT JOIN studentdetails SD ON SD.userid = wallet.userid
                                LEFT JOIN student_class_relation SCR ON SD.userid = SCR.studentid
                                LEFT JOIN branchlookup BL ON SCR.branchid = BL.branchid
                                LEFT JOIN courselookup CL ON SCR.courseid = CL.courseid 
                                LEFT JOIN sectionlookup SL ON SCR.sectionid = SL.sectionid
                                LEFT JOIN genderlookup GL ON SD.genderid = GL.genderid 
                                $whereCondition");

        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function report_reservationadmission()
    {
        $db = db_connect();
        $query = $db->query("SELECT ED.name, 
                                CASE WHEN Today IS NULL THEN 0 ELSE Today END AS Today,
                                CASE WHEN MTD IS NULL THEN 0 ELSE MTD END AS MTD,
                                CASE WHEN Total IS NULL THEN 0 ELSE Total END AS Total from employeedetails ED 

                                LEFT JOIN
                                (select referredby, count(admissiondate) AS Today from reservation WHERE admissiondate = CURDATE() group by referredby order by referredby)
                                A ON A.referredby = ED.userid

                                LEFT JOIN 
                                (select referredby, count(admissiondate) AS MTD from reservation WHERE month(admissiondate) = month(CURDATE()) AND year(admissiondate) = year(CURDATE()) group by referredby order by referredby) 
                                B ON B.referredby = ED.userid

                                LEFT JOIN 
                                (select referredby, count(admissiondate) AS Total from reservation group by referredby order by referredby)
                                C ON C.referredby = ED.userid

                                WHERE ED.is_marketing = 1;");

        $results = $query->getResult();
        $db->close();

        return $results;
    }
    
     public function report_applicationadmission()
    {
        $db = db_connect();
        $query = $db->query("SELECT ED.name, 
                                CASE WHEN Today IS NULL THEN 0 ELSE Today END AS Today,
                                CASE WHEN MTD IS NULL THEN 0 ELSE MTD END AS MTD,
                                CASE WHEN Total IS NULL THEN 0 ELSE Total END AS Total from employeedetails ED 

                                LEFT JOIN
                                (select referredby, count(admissiondate) AS Today from applications WHERE admissiondate = CURDATE() group by referredby order by referredby)
                                A ON A.referredby = ED.userid

                                LEFT JOIN 
                                (select referredby, count(admissiondate) AS MTD from applications WHERE month(admissiondate) = month(CURDATE()) AND year(admissiondate) = year(CURDATE()) group by referredby order by referredby) 
                                B ON B.referredby = ED.userid

                                LEFT JOIN 
                                (select referredby, count(admissiondate) AS Total from applications group by referredby order by referredby)
                                C ON C.referredby = ED.userid

                                WHERE ED.is_marketing = 1;");

        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function report_outpassout($branchid,$sectionid, $DateFrom, $DateTo)
    {
         $where = "form_type='StudentOutPass' and SCR.batchid IN ({$_SESSION['activebatch']})";
         if ($branchid != NULL) {
            if ($where == '') {
                $where = " SCR.branchid IN ({$branchid})";
            } else {
                $where = $where . " AND SCR.branchid IN ({$branchid})";
            }
        }
        if ($sectionid != NULL) {
            if ($where == '') {
                $where = " SCR.sectionid = {$sectionid}";
            } else {
                $where = $where . " AND SCR.sectionid = {$sectionid}";
            }
        }
        if ($DateFrom != NULL) {
            if ($where == '') {
                $where = " form_requests.fromdate = '{$DateFrom}'";
            } else {
                $where = $where . " AND form_requests.fromdate = '{$DateFrom}'";
            }
        }
        $whereCondition = $where == '' ? '' : "WHERE {$where}";
         $db = db_connect();
        $query = $db->query("select *, case when indata is null then 'a' else 'p' end as is_present from form_requests join studentdetails on form_requests.user_id =  studentdetails.userid LEFT JOIN student_class_relation SCR ON studentdetails.userid = SCR.studentid
                                LEFT JOIN branchlookup BL ON SCR.branchid = BL.branchid
                                LEFT JOIN courselookup CL ON SCR.courseid = CL.courseid 
                                LEFT JOIN sectionlookup SL ON SCR.sectionid = SL.sectionid
                                LEFT JOIN genderlookup GL ON studentdetails.genderid = GL.genderid  $whereCondition");

        $results = $query->getResult();
        $db->close();

        return $results;
    }
    
    public function report_profileimage($branchid)
    {
         $where = "reservation.batchid IN ({$_SESSION['activebatch']}) and is_profile_uploaded=0";
         if ($branchid != NULL) {
            if ($where == '') {
                $where = " reservation.branchid IN ({$branchid})";
            } else {
                $where = $where . " AND reservation.branchid IN ({$branchid})";
            }
        }else{
            $branchid = $_SESSION['userdetails']->branchid;
             if ($where == '') {
                $where = " reservation.branchid IN ({$branchid})";
            } else {
                $where = $where . " AND reservation.branchid IN ({$branchid})";
            }
        }
        $whereCondition = $where == '' ? '' : "WHERE {$where}";
         $db = db_connect();
        $query = $db->query("select name,reservation_ukey,profile_image from reservation  $whereCondition");

        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function report_outpassin($branchid,$sectionid, $DateFrom, $DateTo)
    {
         $where = "form_type='StudentOutPass' and SCR.batchid IN ({$_SESSION['activebatch']})";
         if ($branchid != NULL) {
            if ($where == '') {
                $where = " SCR.branchid IN ({$branchid})";
            } else {
                $where = $where . " AND SCR.branchid IN ({$branchid})";
            }
        }
        if ($sectionid != NULL) {
            if ($where == '') {
                $where = " SCR.sectionid = {$sectionid}";
            } else {
                $where = $where . " AND SCR.sectionid = {$sectionid}";
            }
        }
       
        if ($DateTo != NULL) {
            if ($where == '') {
                $where = " form_requests.todate = '{$DateTo}'";
            } else {
                $where = $where . " AND date(indata) = '{$DateTo}'";
            }
        }
        
        $whereCondition = $where == '' ? '' : "WHERE {$where}";
         $db = db_connect();
        $query = $db->query("select *, case when indata is null then 'a' else 'p' end as is_present from form_requests join studentdetails on form_requests.user_id =  studentdetails.userid LEFT JOIN student_class_relation SCR ON studentdetails.userid = SCR.studentid $whereCondition");

        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function report_outpasspending($branchid, $sectionid,$DateFrom, $DateTo)
    {
         $where = "form_type='StudentOutPass' and SCR.batchid IN ({$_SESSION['activebatch']})";
         if ($branchid != NULL) {
            if ($where == '') {
                $where = " SCR.branchid = {$branchid}";
            } else {
                $where = $where . " AND SCR.branchid = {$branchid}";
            }
        }
        if ($sectionid != NULL) {
            if ($where == '') {
                $where = " SCR.sectionid = {$sectionid}";
            } else {
                $where = $where . " AND SCR.sectionid = {$sectionid}";
            }
        }
        if ($DateTo != NULL) {
            if ($where == '') {
                $where = " form_requests.todate <= '{$DateTo}'";
            } else {
                $where = $where . " AND form_requests.todate = '{$DateTo}'";
            }
        }

        $whereCondition = $where == '' ? '' : "WHERE {$where}";
         $db = db_connect();
        $query = $db->query("select *, case when indata is null then 'a' else 'p' end as is_present from form_requests join studentdetails on form_requests.user_id =  studentdetails.userid LEFT JOIN student_class_relation SCR ON studentdetails.userid = SCR.studentid $whereCondition");

        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function report_getbudget()
    {
        $db = db_connect();
        $query = $db->query("SELECT sum(discountgiven) as total,discountapproved_by,employeedetails.name,branchlookup.branchname FROM `applications` JOIN employeedetails ON applications.discountapproved_by=employeedetails.userid JOIN branchlookup ON applications.branchid=branchlookup.branchid where discountapproved_by IS NOT NULL GROUP BY discountapproved_by,applications.branchid");

        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function report_employeeleaves($DateFrom,$Todate)
    {
     
        $db = db_connect();
        $query = $db->query("SELECT employeedetails.name,employeedetails.employeeid,leave_requests.*,Up.name as Updatedby FROM `leave_requests` join employeedetails on leave_requests.userid = employeedetails.userid LEFT JOIN employeedetails Up on leave_requests.statusupdatedby = Up.userid WHERE leavefrom >= '$DateFrom' AND leavefrom <= '$Todate' ");

        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function report_concerns()
    {
         $where = "SCR.batchid IN (SELECT batchid FROM `batchlookup` where batchid={$_SESSION['activebatch']})";
         $whereCondition = $where == '' ? '' : "WHERE {$where}";
        $db = db_connect();
        $query = $db->query("select studentdetails.userid,studentdetails.applicationnumber,studentdetails.name,studentdetails.fathername,branchlookup.branchname,concerns.id,concerns.status,employeedetails.name as assignedname,concerns.details,concerns.from_time,concerns.to_time,CC.name as categoryname, CSC.name as subcategoryname from concerns 
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
    public function report_employeepaysheet($DateFrom)
    {
         $db = db_connect();
        $query = $db->query("SELECT employeedetails.name,employeedetails.employeeid as employeecode,salarypayment.* FROM `salarypayment` join employeedetails on salarypayment.employeeid = employeedetails.userid  WHERE salarydate = '$DateFrom' ");

        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function report_absentlog($DateFrom,$branchid)
    {
        $where = "SCR.batchid=(SELECT batchid FROM `batchlookup` where isactive = 1) and absent_log.status=0";
         if ($branchid != NULL) {
            if ($where == '') {
                $where = "SCR.branchid = {$branchid}";
            } else {
                $where = $where . " AND SCR.branchid = {$branchid}";
            }
        }
        if ($sectionid != NULL) {
            if ($where == '') {
                $where = " SCR.sectionid = {$sectionid}";
            } else {
                $where = $where . " AND SCR.sectionid = {$sectionid}";
            }
        }
        if ($DateFrom != NULL) {
            if ($where == '') {
                $where = " absent_log.date = '{$DateFrom}'";
            } else {
                $where = $where . " AND absent_log.date = '{$DateFrom}'";
            }
        }
        $whereCondition = $where == '' ? '' : "WHERE {$where}";
   
        $db = db_connect();
        $query = $db->query("select absent_log.date,studentdetails.name,studentdetails.applicationnumber from absent_log join studentdetails on absent_log.userid =  studentdetails.userid JOIN student_class_relation SCR ON studentdetails.userid = SCR.studentid $whereCondition");

        $results = $query->getResult();
        $db->close();

        return $results;
    }
}
