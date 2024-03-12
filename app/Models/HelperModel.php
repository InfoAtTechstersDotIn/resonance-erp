<?php

namespace App\Models;

use CodeIgniter\Model;

class HelperModel extends Model
{
    public function generateUniqueId()
    {
        $db = db_connect();
        $query = $db->query("SELECT UUID() as uniqueid");
        $results = $query->getResult();
        $db->close();

        return $results[0]->uniqueid;
    }

    public function get_rights()
    {
        $db = db_connect();
        if(isset($_SESSION['userdetails']))
        {
        $query = $db->query("SELECT * from rights r 
            JOIN roleslookup rl ON rl.roleid = r.roleid
            JOIN operationslookup o ON r.operationid = o.operationid 
            WHERE r.roleid = {$_SESSION['userdetails']->roleid}");
        }elseif(isset($_SESSION['agentdetails']))
        {
            $query = $db->query("SELECT * from rights r 
            JOIN roleslookup rl ON rl.roleid = r.roleid
            JOIN operationslookup o ON r.operationid = o.operationid 
            WHERE r.roleid = {$_SESSION['agentdetails']->roleid}");
        }
        $results = $query->getResult();
        $db->close();

        return $results;
    }
     public function get_branches($course,$admissiontype_id)
    {
        $db = db_connect();
        $query = $db->query("SELECT * from branchlookup where foundationtype like '%{$course}%' and campustype like '%{$admissiontype_id}%' and is_active=1");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    
    public function get_agentrights()
    {
         $db = db_connect();
        $query = $db->query("SELECT * from rights r 
            JOIN roleslookup rl ON rl.roleid = r.roleid
            JOIN operationslookup o ON r.operationid = o.operationid 
            WHERE r.roleid = {$_SESSION['agentdetails']->roleid}");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function get_paymentidcounter()
    {
        $db = db_connect();
        $query = $db->query("SELECT paymentid FROM counters");
        $result = $query->getRow();
        $db->close();

        return $result->paymentid;
    }
     public function get_regapplicationidcounter()
    {
        $db = db_connect();
        $query = $db->query("SELECT registrationnumber FROM counters");
        $result = $query->getRow();
        $db->close();

        return $result->registrationnumber;
    }
    public function get_nextemployeeidcounter()
    {
         $db = db_connect();
        $query = $db->query("SELECT employeeid FROM counters");
        $result = $query->getRow();
        $db->close();

        return $result->employeeid;
    }
    public function set_paymentidcounter()
    {
        $current = $this->get_paymentidcounter();
        $nextpaymentid = $current + 1;

        $data['paymentid'] = $nextpaymentid;

        $db = db_connect();

        $builder = $db->table('counters');
        $builder->update($data);
    }
    public function set_regapplicationidcounter()
    {
        $current = $this->get_regapplicationidcounter();
        $nextpaymentid = $current + 1;

        $data['registrationnumber'] = $nextpaymentid;

        $db = db_connect();

        $builder = $db->table('counters');
        $builder->update($data);
    }
    public function set_nextemployeeid()
    {
        $current = $this->get_nextemployeeidcounter();
        $nextpaymentid = $current + 1;

        $data['employeeid'] = $nextpaymentid;

        $db = db_connect();

        $builder = $db->table('counters');
        $builder->update($data);
    }
    public function add_ApplicationdiscountLog($discount, $userid)
    {
        $db = db_connect();

        $data['discount'] = $discount;
        $data['discount_by'] = $_SESSION['agentdetails']->userid;
        $data['userid'] = $userid;
        $data['batchid'] = 3;

        $builder = $db->table('applicationdiscount_logs');
        $builder->insert($data);

        $db->query("UPDATE employeediscount_limit 
                    set availablelimit = availablelimit - {$discount}
                    where employeeid = {$_SESSION['agentdetails']->userid}
                    AND batchid = 3");
        $db->close();
    }
    
    public function get_reservationnumbercounter()
    {
        $db = db_connect();
        $query = $db->query("SELECT reservationapplicationnumber FROM counters");
        $result = $query->getRow();
        $db->close();

        return $result->reservationapplicationnumber;
    }

    public function set_reservationnumbercounter()
    {
        $current = $this->get_reservationnumbercounter();
        $nextpaymentid = $current + 1;

        $data['reservationapplicationnumber'] = $nextpaymentid;

        $db = db_connect();

        $builder = $db->table('counters');
        $builder->update($data);
    }
    
    public function get_student_application_number($branchid,$batchid)
    {
        $db = db_connect();
        $query = $db->query("SELECT applicationnumber FROM student_application_numbers where branchid={$branchid} and batchid={$batchid}");
        $result = $query->getRow();
        $db->close();

        return $result->applicationnumber;
    }

    public function set_student_application_number($branchid,$batchid)
    {
        $current = $this->get_student_application_number($branchid,$batchid);
        $nextpaymentid = $current + 1;

        $data['applicationnumber'] = $nextpaymentid;

        $db = db_connect();

        $builder = $db->table('student_application_numbers');
        $builder->where('branchid', $branchid);
        $builder->where('batchid', $batchid);
        $builder->update($data);
    }

    public function get_applicationid()
    {
        $db = db_connect();
        $query = $db->query("SELECT applicationnumber FROM counters");
        $result = $query->getRow();
        $db->close();

        return $result->applicationnumber;
    }

    public function set_applicationid($oldCounter)
    {
        $data['applicationnumber'] = $oldCounter + 1;

        $db = db_connect();
        $builder = $db->table('counters');
        $builder->update($data);
        $db->close();
    }

    public function get_nextInvoiceId($userid)
    {
        $db = db_connect();
        $query = $db->query("SELECT invoiceid from invoices WHERE userid = {$userid} GROUP BY invoiceid ORDER BY invoiceid DESC LIMIT 1");
        $results = $query->getRow();

        if ($results == null) {
            return 1;
        } else {
            return explode("-", $results->invoiceid)[2] + 1;
        }
    }
    public function get_nextInvoiceId1($userid)
    {
        $db = db_connect();
        $query = $db->query("SELECT invoiceid from invoices WHERE userid = {$userid} GROUP BY invoiceid ORDER BY invoiceid DESC LIMIT 1");
        $results = $query->getRow();

        if ($results == null) {
            return 1;
        } else {
            return explode("-", $results->invoiceid)[2];
        }
    }

    public function get_lookups()
    {
        $data['rights'] = $this->get_rights();
        $data['rightslookup'] = $this->get_rightslookup();
        $data['paymenttypelookup'] = $this->get_paymenttypelookup();
        $data['paymentstatuslookup'] = $this->get_paymentstatuslookup();
        $data['roleslookup'] = $this->get_roleslookup();
        $data['operationslookup'] = $this->get_operationslookup();
        $data['feestructurelookup'] = $this->get_feestructurelookup();
        $data['cuttofffeelookup'] = $this->get_cuttofffeelookup();
        $data['coursetypelookup'] = $this->get_coursetypelookup();
        $data['feestructurelookup_Other'] = $this->get_feestructurelookup_Other();
        $data['admissiontypelookup'] = $this->get_admissiontypelookup();
        $data['applicationstatuslookup'] = $this->get_applicationstatuslookup();
        $data['boardlookup'] = $this->get_boardlookup();
        $data['categorylookup'] = $this->get_categorylookup();
        $data['courselookup'] = $this->get_courselookup();
        $data['applicationtypelookup'] = $this->get_applicationtype();
        $data['genderlookup'] = $this->get_genderlookup();
        $data['nationalitylookup'] = $this->get_nationalitylookup();
        $data['religionlookup'] = $this->get_religionlookup();
        $data['secondlanguagelookup'] = $this->get_secondlanguagelookup();
        $data['branchlookup'] = $this->get_branchlookup();
        $data['discountlookup'] = $this->get_discountlookup();
        $data['materialrequisition'] = $this->get_materialrequisition();
        $data['batchlookup'] = $this->get_batchlookup();
        $data['sectionlookup'] = $this->get_sectionlookup();
        $data['subjectlookup'] = $this->get_subjectlookup();
        $data['stateslookup'] = $this->get_stateslookup(1);
        $data['districtslookup'] = $this->get_districtslookup();
        $data['wallettypelookup'] = $this->get_wallettypelookup();
        $data['reservationstatuslookup'] = $this->get_reservationstatuslookup();
        $data['rights_json'] = json_encode($data['rights']);
        $data['rightslookup_json'] = json_encode($data['rightslookup']);
        $data['paymenttypelookup_json'] = json_encode($data['paymenttypelookup']);
        $data['paymentstatuslookup_json'] = json_encode($data['paymentstatuslookup']);
        $data['roleslookup_json'] = json_encode($data['roleslookup']);
        $data['operationslookup_json'] = json_encode($data['operationslookup']);
        $data['feestructurelookup_json'] = json_encode($data['feestructurelookup']);
        $data['cuttofffeelookup_json'] = json_encode($data['cuttofffeelookup']);
        $data['coursetypelookup_json'] = json_encode($data['coursetypelookup']);
        $data['feestructurelookup_Other_json'] = json_encode($data['feestructurelookup_Other']);
        $data['admissiontypelookup_json'] = json_encode($data['admissiontypelookup']);
        $data['applicationstatuslookup_json'] = json_encode($data['applicationstatuslookup']);
        $data['boardlookup_json'] = json_encode($data['boardlookup']);
        $data['categorylookup_json'] = json_encode($data['categorylookup']);
        $data['courselookup_json'] = json_encode($data['courselookup']);
        $data['applicationtypelookup_json'] = json_encode($data['applicationtypelookup']);
        $data['genderlookup_json'] = json_encode($data['genderlookup']);
        $data['nationalitylookup_json'] = json_encode($data['nationalitylookup']);
        $data['religionlookup_json'] = json_encode($data['religionlookup']);
        $data['secondlanguagelookup_json'] = json_encode($data['secondlanguagelookup']);
        $data['branchlookup_json'] = json_encode($data['branchlookup']);
        $data['discountlookup_json'] = json_encode($data['discountlookup']);
        $data['batchlookup_json'] = json_encode($data['batchlookup']);
        $data['sectionlookup_json'] = json_encode($data['sectionlookup']);
        $data['subjectlookup_json'] = json_encode($data['subjectlookup']);
        $data['stateslookup_json'] = json_encode($data['stateslookup']);
        $data['districtslookup_json'] = json_encode($data['districtslookup']);
        $data['wallettypelookup_json'] = json_encode($data['wallettypelookup']);
        $data['reservationstatuslookup_json'] = json_encode($data['reservationstatuslookup']);
        return $data;
    }
    
    public function get_coursetypelookup()
    {
        $db = db_connect();
        $query = $db->query("SELECT * from coursetypelookup");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function get_batch()
    {
        $db = db_connect();
        $query = $db->query("SELECT * FROM batchlookup WHERE isactive = 1");
        $result = $query->getRow();
        $db->close();

        return $result;
    }

    public function get_reservationstatuslookup()
    {
        $db = db_connect();
        $query = $db->query("SELECT * FROM reservationstatuslookup");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function get_batchlookup()
    {
        $db = db_connect();
        $query = $db->query("SELECT * FROM batchlookup");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function get_sectionlookup()
    {
        $db = db_connect();
        $query = $db->query("SELECT * FROM sectionlookup");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function get_subjectlookup()
    {
        $db = db_connect();
        $query = $db->query("SELECT * FROM subjectlookup");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function get_rightslookup()
    {
        $db = db_connect();
        $query = $db->query("SELECT * from rights r 
                             JOIN roleslookup rl ON rl.roleid = r.roleid
                             JOIN operationslookup o ON r.operationid = o.operationid");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function get_paymenttypelookup()
    {
        $db = db_connect();
        $query = $db->query("SELECT * from paymenttypelookup WHERE paymenttypename <> 'Refund'");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function get_paymentstatuslookup()
    {
        $db = db_connect();
        $query = $db->query("SELECT * from paymentstatuslookup");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function get_roleslookup()
    {
        $db = db_connect();
        $query = $db->query("SELECT * from roleslookup");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function get_operationslookup()
    {
        $db = db_connect();
        $query = $db->query("SELECT * from operationslookup");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function get_feestructurelookup()
    {
        $db = db_connect();
        $query = $db->query("SELECT * from feestructurelookup 
                             JOIN admissiontypelookup ON feestructurelookup.admissiontypeid = admissiontypelookup.admissiontypeid 
                             JOIN courselookup ON feestructurelookup.courseid = courselookup.courseid
                             AND feecategoryid = '1'");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    
    public function get_cuttofffeelookup()
    {
        $db = db_connect();
        $query = $db->query("SELECT * from cuttofffee 
                             JOIN admissiontypelookup ON cuttofffee.admissiontypeid = admissiontypelookup.admissiontypeid 
                             JOIN courselookup ON cuttofffee.courseid = courselookup.courseid");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function get_feestructurelookup_Other()
    {
        $db = db_connect();
        $query = $db->query("SELECT * from feestructurelookup WHERE feecategoryid = '2'");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function add_discountLog($discount, $userid)
    {
        $db = db_connect();

        $data['discount'] = $discount;
        $data['discount_by'] = $_SESSION['userdetails']->userid;
        $data['userid'] = $userid;
        $data['batchid'] = $_SESSION['activebatch'];

        $builder = $db->table('discount_logs');
        $builder->insert($data);

        $db->query("UPDATE employeediscount_limit 
                    set availablelimit = availablelimit - {$discount}
                    where employeeid = {$_SESSION['userdetails']->userid}
                    AND batchid = {$_SESSION['activebatch']}");
        $db->close();
    }

    public function get_admissiontypelookup()
    {
        $db = db_connect();
        $query = $db->query("SELECT * from admissiontypelookup");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function get_applicationstatuslookup()
    {
        $db = db_connect();
        $query = $db->query("SELECT * from applicationstatuslookup");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function get_boardlookup()
    {
        $db = db_connect();
        $query = $db->query("SELECT * from boardlookup");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function get_categorylookup()
    {
        $db = db_connect();
        $query = $db->query("SELECT * from categorylookup");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function get_courselookup()
    {
        $db = db_connect();
        $query = $db->query("SELECT * from courselookup");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function get_genderlookup()
    {
        $db = db_connect();
        $query = $db->query("SELECT * from genderlookup");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function get_nationalitylookup()
    {
        $db = db_connect();
        $query = $db->query("SELECT * from nationalitylookup");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function get_religionlookup()
    {
        $db = db_connect();
        $query = $db->query("SELECT * from religionlookup");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function get_secondlanguagelookup()
    {
        $db = db_connect();
        $query = $db->query("SELECT * from secondlanguagelookup");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function get_materialrequisition()
    {
        $db = db_connect();
        $query = $db->query("SELECT * from materialrequisitionlookup");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function get_applicationtype()
    {
        $db = db_connect();
        $query = $db->query("SELECT * from applicationtypelookup");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function get_discountlookup()
    {
        $db = db_connect();
        $query = $db->query("SELECT * from discountlookup");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

     public function get_branchlookup()
    {
        $db = db_connect();
        if(isset($_SESSION['userdetails']))
        {
            if(!isset($_SESSION['new_student_form']))
            {
                $_SESSION['new_student_form'] = null;
            }
            if(!isset($_SESSION['api']))
            {
                $_SESSION['api'] = null;
            }
            if ($_SESSION['userdetails']->userid == 1 || $_SESSION['new_student_form'] == 1 || $_SESSION['api'] == 1) {
                $query = $db->query("SELECT * from branchlookup");
            } else {
                $query = $db->query("SELECT * from branchlookup where branchid in ({$_SESSION['userdetails']->branchid})");
            }
        }elseif($_SESSION['agentdetails'] != null)
        {
            $query = $db->query("SELECT * from branchlookup");
        }else
        {
             $query = $db->query("SELECT * from branchlookup");
        }
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function get_stateslookup($country_id = 0)
    {
        $db = db_connect();
        $query = $db->query("SELECT * from stateslookup where country_id = '{$country_id}'");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function get_districtslookup()
    {
        $db = db_connect();
        $query = $db->query("SELECT * from districtslookup");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function get_districts($state_id = 0)
    {
        $db = db_connect();
        $query = $db->query("SELECT * from districtslookup where state_id = '{$state_id}'");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function get_coachingfees_by_courceid_admissiontypeid($cource_id, $admissiontype_id)
    {
        $db = db_connect();
        $query = $db->query("SELECT * from feestructurelookup WHERE courseid = '{$cource_id}' 
                                AND admissiontypeid = '{$admissiontype_id}'
                                AND feetype = 'Tuition Fee'
                                AND feecategoryid = '1'");
        $results = $query->getRow();
        $db->close();

        return $results;
    }

    public function get_hostel_by_courceid_admissiontypeid($cource_id, $admissiontype_id)
    {
        $db = db_connect();
        $query = $db->query("SELECT * from feestructurelookup WHERE courseid = '{$cource_id}' 
                                AND admissiontypeid = '{$admissiontype_id}'
                                AND feetype = 'Hostel Fee'
                                AND feecategoryid = '1'");
        $results = $query->getRow();
        $db->close();

        return $results;
    }

    public function get_fees_from_lookup($cource_id, $admissiontype_id, $batch_id, $feetype)
    {
        $db = db_connect();
        $query = $db->query("SELECT SUM(feesvalue) AS ActualFees FROM feestructurelookup where courseid = '{$cource_id}' 
                                AND admissiontypeid = '{$admissiontype_id}' 
                                AND batchid = '{$batch_id}'
                                AND feetype = '{$feetype}'
                                AND feecategoryid = '1'");
        $result = $query->getRow();
        $db->close();

        return $result->ActualFees == null ? 0 : $result->ActualFees;
    }

    public function get_settings($text)
    {
        $db = db_connect();

        $query = $db->query("SELECT * FROM settings where name = '{$text}'");
        $value = $query->getResult()[0]->value;

        $db->close();

        return $value;
    }

    public function get_approvallookup($admissiontypeid, $coachingfees)
    {
        $db = db_connect();

        $query = $db->query("SELECT * FROM approvallookup JOIN roleslookup ON roleslookup.roleid = approvallookup.roleid  WHERE admissiontypeid = '$admissiontypeid' AND fees_from <= $coachingfees AND fees_to >= $coachingfees");
        $value = $query->getResult()[0];
        $db->close();

        return $value;
    }

    public function get_wallettypelookup()
    {
        $db = db_connect();
        $query = $db->query("SELECT * from wallettypelookup");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
     public function studentpromoted($userid)
    {
        $db = db_connect();
        $batchid = $_SESSION['activebatch']+1;
        $query = $db->query("SELECT * from student_class_relation WHERE studentid = {$userid} and batchid={$batchid}");
        $results = $query->getRow();
        if ($results == null) {
            return 0;
        } else {
            return 1;
        }
    }
    public function studentpromoteddiscount($userid)
    {
        $db = db_connect();
        $batchid = $_SESSION['activebatch'];
        $query = $db->query("SELECT * from student_class_relation WHERE studentid = {$userid} and batchid={$batchid}");
        $results = $query->getRow();
        if ($results == 0) {
            return 0;
        } else {
            return 1;
        }
    }
    public function getFeeStructure($courseid,$admissiontypeid,$batchid)
    {
        $db = db_connect();
        $query = $db->query("SELECT sum(feesvalue) as fee from feestructurelookup WHERE courseid = {$courseid} and admissiontypeid={$admissiontypeid} and batchid={$batchid}");
        $results = $query->getResult();
        return $results;
    }
    public function getNextFeeStructure($courseid,$admissiontypeid,$batchid)
    {
        $db = db_connect();
        $query = $db->query("SELECT sum(feesvalue) as fee,coursename from feestructurelookup join courselookup on feestructurelookup.courseid = courselookup.courseid WHERE feestructurelookup.courseid = {$courseid} and feestructurelookup.admissiontypeid={$admissiontypeid} and feestructurelookup.batchid={$batchid}");
        $results = $query->getResult();
        return $results;
    }
    public function getStudentKit($courseid)
    {
        $db = db_connect();
        $query = $db->query("SELECT studentkit_dayscholar,studentkit_resdential from courselookup WHERE courseid = {$courseid}");
        $results = $query->getResult();
        return $results;
    }
    public function studentbatchcount($userid)
    {
        $db = db_connect();
        $batchid = $batchid + 1;
        $query = $db->query("SELECT * from student_class_relation WHERE studentid = {$userid}");
        $results = $query->getResult();
        if (count($results) ==1 ) {
            return 0;
        } else {
            return 1;
        }
    }
    public function studentcount($userid,$batchid)
    {
        $db = db_connect();
        $batchid = $batchid + 1;
        $query = $db->query("SELECT * from student_class_relation WHERE studentid = {$userid} and batchid={$batchid}");
        $results = $query->getResult();
        if (count($results) == 0) {
            return 0;
        } else {
            return 1;
        }
    }
    public function get_college_code($userid)
    {
        $db = db_connect();
        $query = $db->query("SELECT college_codes,is_singleprint from college_codes WHERE userid = {$userid}");
        $results = $query->getResult();
        return $results;
    }
    public function student_tc_log($userid)
    {
        $db = db_connect();
        $batchid = $batchid + 1;
        $query = $db->query("SELECT * from tc_log WHERE userid = {$userid} and generated_by={$_SESSION['userdetails']->userid}");
        $results = $query->getResult();
        if (count($results) == 0) {
            return 0;
        } else {
            return 1;
        }
    }
}
