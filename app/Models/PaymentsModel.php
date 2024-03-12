<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\HelperModel;
use App\Models\UsersModel;
use Dompdf\Dompdf;

include APPPATH . 'ThirdParty/dompdf/autoload.inc.php';

class PaymentsModel extends Model
{
    public function getAllInvoiceDetails()
    {
        $db = db_connect();
        $query = $db->query("SELECT InvoiceDetails.*, InvoiceDetails.userid, InvoiceDetails.TotalValue, InvoiceDetails.invoiceid, InvoiceDetails.name, InvoiceDetails.email, InvoiceDetails.branchname, InvoiceDetails.admissiontypename, InvoiceDetails.coursename, 
                             PaymentDetails.TotalPaid, (InvoiceDetails.TotalValue - PaymentDetails.TotalPaid) AS RemainingAmount, InvoiceDetails.branchid,InvoiceDetails.sectionid FROM
                                (SELECT student_class_relation.*, SUM(invoices.feesvalue) as TotalValue, invoices.invoiceid, studentdetails.userid, studentdetails.name, studentdetails.applicationnumber, studentdetails.email, branchlookup.branchname, sectionlookup.sectionname, admissiontypelookup.admissiontypename, courselookup.coursename
                                from invoices JOIN users ON invoices.userid = users.userid 
                                JOIN studentdetails ON studentdetails.userid = users.userid 
                                JOIN applicationstatuslookup ON studentdetails.applicationstatusid = applicationstatuslookup.applicationstatusid 
                                JOIN student_class_relation ON student_class_relation.studentid = studentdetails.userid
                                JOIN feestructurelookup ON invoices.feesid = feestructurelookup.feesid
                                JOIN branchlookup ON student_class_relation.branchid = branchlookup.branchid
                                JOIN admissiontypelookup ON student_class_relation.admissiontypeid = admissiontypelookup.admissiontypeid
                                JOIN courselookup ON student_class_relation.courseid = courselookup.courseid
                                JOIN sectionlookup ON student_class_relation.sectionid = sectionlookup.sectionid
                                WHERE studentdetails.studentstatus=1 and student_class_relation.branchid IN ({$_SESSION['userdetails']->branchid})
                                and student_class_relation.batchid IN ({$_SESSION['activebatch']})
                                and applicationstatuslookup.applicationstatusname <> 'Dropped Out'
                                GROUP BY invoices.invoiceid) InvoiceDetails
                                LEFT JOIN
                                (SELECT SUM(payments.paymentamount) as TotalPaid, payments.userid FROM payments JOIN users ON payments.userid = users.userid where payments.paymentstatusid <> 2 GROUP BY payments.userid) PaymentDetails ON InvoiceDetails.userid = PaymentDetails.userid");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function getAllPaymentDetails()
    {
        $db = db_connect();
        $query = $db->query("SELECT student_class_relation.*, branchlookup.branchname, sectionlookup.sectionname, admissiontypelookup.admissiontypename, courselookup.coursename, U.userid, studentdetails.applicationnumber, studentdetails.name, PSL.paymentstatusid, PSL.paymentstatusname, paymentid, paymentamount, paymentdate, PT.paymenttypeid, paymenttypename, otherdetails, employeedetails.name as receivedby, employeedetails.userid AS receivedbyid, P.remarks FROM payments P 
                             JOIN users U ON P.userid = U.userid 
                             JOIN studentdetails ON studentdetails.userid = U.userid
                             JOIN applicationstatuslookup ON studentdetails.applicationstatusid = applicationstatuslookup.applicationstatusid 
                             JOIN student_class_relation ON student_class_relation.studentid = studentdetails.userid
                             JOIN branchlookup ON student_class_relation.branchid = branchlookup.branchid
                             JOIN admissiontypelookup ON student_class_relation.admissiontypeid = admissiontypelookup.admissiontypeid
                             JOIN courselookup ON student_class_relation.courseid = courselookup.courseid
                             JOIN sectionlookup ON student_class_relation.sectionid = sectionlookup.sectionid
                             JOIN paymentstatuslookup PSL ON P.paymentstatusid = PSL.paymentstatusid 
                             JOIN paymenttypelookup PT ON P.paymenttypeid = PT.paymenttypeid 
                             LEFT JOIN users PC ON P.paymentcollectedby = PC.userid
                             LEFT JOIN employeedetails ON employeedetails.userid = PC.userid
                             WHERE studentdetails.studentstatus=1 and student_class_relation.branchid IN ({$_SESSION['userdetails']->branchid})
                             and student_class_relation.batchid IN ({$_SESSION['activebatch']})
                             and applicationstatuslookup.applicationstatusname <> 'Dropped Out'");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function getApplicationPaymentLinkByInvoiceId($invoiceid)
    {
        $db = db_connect();
        $query = $db->query("SELECT * FROM applicationpayment_links  
                             WHERE invoiceid = '$invoiceid'");
        $result = $query->getRow();
        $db->close();

        return $result;
    }
    public function getInvoiceDetails($userid)
    {
        $db = db_connect();
        $query = $db->query("SELECT InvoiceDetails.*, InvoiceDetails.userid, InvoiceDetails.TotalValue, InvoiceDetails.invoiceid,InvoiceDetails.invoice, InvoiceDetails.name, InvoiceDetails.branchname, InvoiceDetails.admissiontypename, InvoiceDetails.coursename, 
                             PaymentDetails.TotalPaid, (InvoiceDetails.TotalValue - PaymentDetails.TotalPaid) AS RemainingAmount FROM
                                (SELECT student_class_relation.*, SUM(invoices.feesvalue) as TotalValue, invoices.invoiceid,invoices.invoice, studentdetails.userid, studentdetails.name, branchlookup.branchname, sectionlookup.sectionname, admissiontypelookup.admissiontypename, courselookup.coursename 
                                 from invoices JOIN users ON invoices.userid = users.userid 
                                 JOIN studentdetails ON studentdetails.userid = users.userid
                                 JOIN student_class_relation ON student_class_relation.studentid = studentdetails.userid
                                 JOIN feestructurelookup ON invoices.feesid = feestructurelookup.feesid
                                 JOIN branchlookup ON student_class_relation.branchid = branchlookup.branchid
                                 JOIN admissiontypelookup ON student_class_relation.admissiontypeid = admissiontypelookup.admissiontypeid
                                 JOIN courselookup ON student_class_relation.courseid = courselookup.courseid
                                 JOIN sectionlookup ON student_class_relation.sectionid = sectionlookup.sectionid
                                 WHERE feestructurelookup.feetype != 'Application Fee' and student_class_relation.branchid IN ({$_SESSION['userdetails']->branchid})
                                 and student_class_relation.batchid=invoices.batchid
                                 GROUP BY invoices.invoiceid) InvoiceDetails
                                 LEFT JOIN
                                 (SELECT SUM(payments.paymentamount) as TotalPaid, payments.userid,payments.batchid FROM payments JOIN users ON payments.userid = users.userid GROUP BY payments.userid,payments.batchid) PaymentDetails ON InvoiceDetails.userid = PaymentDetails.userid AND InvoiceDetails.batchid = PaymentDetails.batchid WHERE InvoiceDetails.userid=$userid");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function getInvoiceDetailsByInvoiceId($invoiceid, $batchid)
    {
        $db = db_connect();
        $query = $db->query("SELECT student_class_relation.*, invoices.invoiceid,invoices.invoice,discountlookup.discountname, invoices.additionaldetails, users.userid, studentdetails.name, branchlookup.branchname, sectionlookup.sectionname, admissiontypelookup.admissiontypename, courselookup.coursename, feestructurelookup.feetype, feestructurelookup.feesvalue AS OriginalFees, studentdetails.applicationnumber,  studentdetails.scholarship, invoices.feesvalue  
                             from invoices 
                             JOIN users ON invoices.userid = users.userid 
                             JOIN studentdetails ON studentdetails.userid = users.userid
                             JOIN student_class_relation ON student_class_relation.studentid = studentdetails.userid
                             JOIN feestructurelookup ON invoices.feesid = feestructurelookup.feesid
                             JOIN branchlookup ON student_class_relation.branchid = branchlookup.branchid
                             JOIN admissiontypelookup ON student_class_relation.admissiontypeid = admissiontypelookup.admissiontypeid
                             JOIN courselookup ON student_class_relation.courseid = courselookup.courseid
                             JOIN sectionlookup ON student_class_relation.sectionid = sectionlookup.sectionid
                             LEFT JOIN discountlookup ON discountlookup.id = invoices.discountid
                             WHERE invoices.invoiceid = '{$invoiceid}'
                             and student_class_relation.batchid IN ({$batchid})");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function getAllPendingPaymentDetails()
    {
        $db = db_connect();
        $query = $db->query("SELECT student_class_relation.*, studentdetails.applicationnumber, studentdetails.name, PSL.paymentstatusid, PSL.paymentstatusname, paymentid, paymentamount, paymentdate, paymenttypename, otherdetails, employeedetails.name as receivedby, employeedetails.userid AS receivedbyid, U.userid
                             FROM payments P 
                             JOIN users U ON P.userid = U.userid 
                             JOIN studentdetails ON studentdetails.userid = U.userid
                             JOIN student_class_relation ON student_class_relation.studentid = studentdetails.userid
                             JOIN paymentstatuslookup PSL ON P.paymentstatusid = PSL.paymentstatusid 
                             JOIN paymenttypelookup PT ON P.paymenttypeid = PT.paymenttypeid 
                             LEFT JOIN users PC ON P.paymentcollectedby = PC.userid
                             LEFT JOIN employeedetails ON employeedetails.userid = PC.userid
                             WHERE PSL.paymentstatusid = 1 
                             AND studentdetails.applicationstatusid = 4 AND studentdetails.studentstatus=1
                             AND student_class_relation.branchid IN ({$_SESSION['userdetails']->branchid})
                             and student_class_relation.batchid IN ({$_SESSION['activebatch']})");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function getPaymentDetails($userid)
    {
        $db = db_connect();
        $query = $db->query("SELECT student_class_relation.*, studentdetails.applicationnumber, studentdetails.name, PSL.paymentstatusid, PSL.paymentstatusname, paymentid,invoice, paymentamount, paymentdate, PT.paymenttypeid, paymenttypename, otherdetails, employeedetails.name as receivedby,  P.remarks
                             FROM payments P 
                             JOIN users U ON P.userid = U.userid
                             JOIN studentdetails ON studentdetails.userid = U.userid 
                             JOIN student_class_relation ON student_class_relation.studentid = studentdetails.userid
                             JOIN paymentstatuslookup PSL ON P.paymentstatusid = PSL.paymentstatusid 
                             JOIN paymenttypelookup PT ON P.paymenttypeid = PT.paymenttypeid 
                             LEFT JOIN users PC ON P.paymentcollectedby = PC.userid 
                             LEFT JOIN employeedetails ON employeedetails.userid = PC.userid
                             WHERE U.userid=$userid and student_class_relation.branchid IN ({$_SESSION['userdetails']->branchid})
                             and student_class_relation.batchid=P.batchid
                             ");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function getPaymentLinks($userid = 0)
    {
        $db = db_connect();
        if ($userid == 0) {
            $query = $db->query("SELECT * FROM payment_links 
                                 JOIN studentdetails on payment_links.userid = studentdetails.userid
                                 JOIN applicationstatuslookup ON studentdetails.applicationstatusid = applicationstatuslookup.applicationstatusid 
                                 WHERE studentdetails.studentstatus=1 and batchid IN ({$_SESSION['activebatch']})
                                 and applicationstatuslookup.applicationstatusname <> 'Dropped Out'");
        } else {
            $query = $db->query("SELECT * FROM payment_links  
                             WHERE userid = $userid and batchid IN ({$_SESSION['activebatch']})");
        }
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    
    public function getApplicationPaymentLinks($userid = 0)
    {
        $db = db_connect();
        if ($userid == 0) {
            $query = $db->query("SELECT * FROM applicationpayment_links 
                                 JOIN applications on applicationpayment_links.userid = applications.applicationid
                                 JOIN applicationstatuslookup ON applications.applicationstatusid = applicationstatuslookup.applicationstatusid 
                                 WHERE batchid IN (4)
                                 and applicationstatuslookup.applicationstatusname <> 'Dropped Out'");
        } else {
            $query = $db->query("SELECT * FROM applicationpayment_links  
                             WHERE userid = $userid and batchid IN ({$_SESSION['activebatch']}) order by paymentlinkid desc");
        }
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function getPaymentLinkByInvoiceId($invoiceid)
    {
        $db = db_connect();
        $query = $db->query("SELECT * FROM payment_links  
                             WHERE invoiceid = '$invoiceid'");
        $result = $query->getRow();
        $db->close();

        return $result;
    }

    public function getPaymentDetailsByUserId($userid, $batchid)
    {
        $batchid = $batchid == NULL ? $_SESSION['activebatch'] : $batchid;
        $db = db_connect();
        $query = $db->query("SELECT student_class_relation.*, studentdetails.applicationnumber, studentdetails.name, PSL.paymentstatusid, PSL.paymentstatusname, paymentid, paymentamount, paymentdate, paymenttypename, otherdetails, employeedetails.name as receivedby 
                             FROM payments P 
                             JOIN users U ON P.userid = U.userid
                             JOIN studentdetails ON studentdetails.userid = U.userid 
                             JOIN student_class_relation ON student_class_relation.studentid = studentdetails.userid
                             JOIN paymentstatuslookup PSL ON P.paymentstatusid = PSL.paymentstatusid 
                             JOIN paymenttypelookup PT ON P.paymenttypeid = PT.paymenttypeid 
                             LEFT JOIN users PC ON P.paymentcollectedby = PC.userid 
                             LEFT JOIN employeedetails ON employeedetails.userid = PC.userid
                             WHERE U.userid=$userid
                             and student_class_relation.batchid IN ({$batchid}) and P.batchid IN ({$batchid})");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function getReservationPaymentDetailsByUserId($userid, $batchid = NULL)
    {
        $batchid = $batchid == NULL ? $_SESSION['activebatch'] : $batchid;
        $db = db_connect();
        $query = $db->query("SELECT PSL.paymentstatusid, PSL.paymentstatusname, P.reservationid, paymentamount, paymentdate, paymenttypename, otherdetails, employeedetails.name as receivedby 
                             FROM reservation_payments P 
                             JOIN reservation U ON P.reservationid = U.reservationid
                             JOIN paymentstatuslookup PSL ON P.paymentstatusid = PSL.paymentstatusid 
                             JOIN paymenttypelookup PT ON P.paymenttypeid = PT.paymenttypeid 
                             LEFT JOIN employeedetails ON P.paymentcollectedby = employeedetails.userid
                             WHERE U.reservationid=$userid");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    
    public function getApplicationPaymentDetailsByUserId($userid, $batchid = NULL)
    {
        $batchid = $batchid == NULL ? 3 : $batchid;
        $db = db_connect();
        $query = $db->query("SELECT PSL.paymentstatusid, PSL.paymentstatusname, P.userid, paymentamount, paymentdate, paymenttypename, otherdetails, employeedetails.name as receivedby 
                             FROM applicationpayments P 
                             JOIN applications U ON P.userid = U.applicationid
                             JOIN paymentstatuslookup PSL ON P.paymentstatusid = PSL.paymentstatusid 
                             JOIN paymenttypelookup PT ON P.paymenttypeid = PT.paymenttypeid 
                             LEFT JOIN employeedetails ON P.paymentcollectedby = employeedetails.userid
                             WHERE U.applicationid=$userid");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function getMaxPaymentsBySingleUser()
    {
        $batchid =  $_SESSION['activebatch'];
        $db = db_connect();
        $query = $db->query("SELECT COUNT(paymentid) AS Max FROM `payments` where batchid=$batchid group BY userid ORDER BY COUNT(paymentid) DESC LIMIT 1");
        $result = $query->getRow();
        $db->close();

        return $result->Max;
    }
    public function getMaxReservationPaymentsBySingleUser()
    {
        $db = db_connect();
        $query = $db->query("SELECT COUNT(reservation_paymentid) AS Max FROM `reservation_payments` group BY reservationid ORDER BY COUNT(reservation_paymentid) DESC LIMIT 1");
        $result = $query->getRow();
        $db->close();

        return $result->Max;
    }
    
    public function getMaxApplicationPaymentsBySingleUser()
    {
        $db = db_connect();
        $query = $db->query("SELECT COUNT(paymentid) AS Max FROM `applicationpayments` group BY userid ORDER BY COUNT(paymentid) DESC LIMIT 1");
        $result = $query->getRow();
        $db->close();

        return $result->Max;
    }

    public function getPaymentDetailsByPaymentId($paymentid)
    {
        $db = db_connect();
        $query = $db->query("SELECT student_class_relation.*, studentdetails.applicationnumber, studentdetails.name, PSL.paymentstatusid, PSL.paymentstatusname, P.paymentid,P.invoice, U.userid, paymentamount, paymentdate, paymenttypename, otherdetails, employeedetails.name as receivedby 
                             FROM payments P 
                             JOIN users U ON P.userid = U.userid
                             JOIN studentdetails ON studentdetails.userid = U.userid 
                             JOIN student_class_relation ON student_class_relation.studentid = studentdetails.userid
                             JOIN paymentstatuslookup PSL ON P.paymentstatusid = PSL.paymentstatusid 
                             JOIN paymenttypelookup PT ON P.paymenttypeid = PT.paymenttypeid 
                             LEFT JOIN users PC ON P.paymentcollectedby = PC.userid 
                             LEFT JOIN employeedetails ON employeedetails.userid = PC.userid
                             WHERE P.paymentid = '{$paymentid}'");
        $results = $query->getRow();
        $db->close();

        return $results;
    }
    
    public function getapplicationPaymentDetailsByPaymentId($paymentid)
    {
        $db = db_connect();
        $query = $db->query("SELECT `applications`.`application_ukey` as applicationnumber,applications.applicationid as userid,applications.name, PSL.paymentstatusid, PSL.paymentstatusname, P.paymentid,P.invoice, paymentamount, paymentdate, paymenttypename, otherdetails, employeedetails.name as receivedby 
                             FROM applicationpayments P 
                             JOIN applications ON applications.applicationid = P.userid 
                             JOIN paymentstatuslookup PSL ON P.paymentstatusid = PSL.paymentstatusid 
                             JOIN paymenttypelookup PT ON P.paymenttypeid = PT.paymenttypeid 
                             LEFT JOIN users PC ON P.paymentcollectedby = PC.userid 
                             LEFT JOIN employeedetails ON employeedetails.userid = PC.userid
                             WHERE P.paymentid = '{$paymentid}'");
        $results = $query->getRow();
        $db->close();

        return $results;
    }
    
    public function addPayment($paymentid, $userid, $paymentamount, $paymentdate, $paymenttypeid, $otherdetails, $paymentcollectedby, $paymentstatusid, $bathcid = 0, $remarks = NULL)
    {
        $db = db_connect();

        $data['updated_by'] = ($_SESSION['userdetails'] != NULL ? $_SESSION['userdetails']->userid : NULL) == NULL ? 1 : $_SESSION['userdetails']->userid;

        $data['paymentid'] = $paymentid;
        $data['userid'] = $userid;
        $data['paymentamount'] = $paymentamount;
        $data['paymentdate'] = $paymentdate;
        $data['paymenttypeid'] = $paymenttypeid;
        $data['otherdetails'] = $otherdetails;
        $data['paymentcollectedby'] = $paymentcollectedby;
        $data['paymentstatusid'] = $paymentstatusid;
        $data['batchid'] = $bathcid == 0 ? $_SESSION['activebatch'] : $bathcid;
        $data['remarks'] = $remarks;

        $builder = $db->table('payments');
        return $builder->insert($data);
    }
    
    public function addStudentPayment($paymentid, $userid, $paymentamount, $paymentdate, $paymenttypeid, $otherdetails, $paymentcollectedby, $paymentstatusid, $bathcid = 0,$invoice, $remarks = NULL)
    {
        $db = db_connect();

        $data['updated_by'] = ($_SESSION['userdetails'] != NULL ? $_SESSION['userdetails']->userid : NULL) == NULL ? 1 : $_SESSION['userdetails']->userid;

        $data['paymentid'] = $paymentid;
        $data['userid'] = $userid;
        $data['paymentamount'] = $paymentamount;
        $data['paymentdate'] = $paymentdate;
        $data['paymenttypeid'] = $paymenttypeid;
        $data['otherdetails'] = $otherdetails;
        $data['paymentcollectedby'] = $paymentcollectedby;
        $data['paymentstatusid'] = $paymentstatusid;
        $data['batchid'] = $bathcid == 0 ? $_SESSION['activebatch'] : $bathcid;
        $data['remarks'] = $remarks;
        $data['invoice'] = $invoice;

        $builder = $db->table('payments');
        return $builder->insert($data);
    }
    
    public function addStudentPayments($paymentid, $id, $paymentamount, $paymentdate, $paymenttypeid, $otherdetails, $paymentcollectedby, $paymentstatusid, $bathcid = 4,$remarks = NULL,$voucherid,$userid)
    {
        $db = db_connect();
        $data['updated_by'] = ($_SESSION['userdetails'] != NULL ? $_SESSION['userdetails']->userid : NULL) == NULL ? 1 : $_SESSION['userdetails']->userid;
        $data['paymentid'] = $paymentid;
        $data['userid'] = $id;
        $data['paymentamount'] = $paymentamount;
        $data['paymentdate'] = $paymentdate;
        $data['paymenttypeid'] = $paymenttypeid;
        $data['otherdetails'] = $otherdetails;
        $data['paymentcollectedby'] = $paymentcollectedby;
        $data['paymentstatusid'] = $paymentstatusid;
        $data['batchid'] = $bathcid == 0 ? $_SESSION['activebatch'] : $bathcid;
        $data['remarks'] = $remarks;
        $data['invoice'] = 1;
        $data['approved_by'] = $userid;
        $data['created_by'] = 1;
        $data['discountid'] = $voucherid;
        $data['approved_date'] = date('Y-m-d H:i:s');
        $builder = $db->table('payments');
        return $builder->insert($data);
    }
    public function addApplicationPayment($paymentid, $userid, $paymentamount, $paymentdate, $paymenttypeid, $otherdetails, $paymentcollectedby, $paymentstatusid, $bathcid = 0, $remarks = NULL)
    {
        $db = db_connect();
        
        if(isset($_SESSION['agentdetails']))
        {
            $updated_by = $_SESSION['agentdetails']->userid;
        }else
        {
            $updated_by = 1;
        }
        
        $data['updated_by'] = $updated_by;

        $data['paymentid'] = $paymentid;
        $data['userid'] = $userid;
        $data['paymentamount'] = $paymentamount;
        $data['paymentdate'] = $paymentdate;
        $data['paymenttypeid'] = $paymenttypeid;
        $data['otherdetails'] = $otherdetails;
        $data['paymentcollectedby'] = $paymentcollectedby;
        $data['paymentstatusid'] = $paymentstatusid;
        $data['batchid'] = $bathcid == 0 ? $_SESSION['activebatch'] : $bathcid;
        $data['remarks'] = $remarks;

        $builder = $db->table('applicationpayments');
        return $builder->insert($data);
    }
    
    
     public function addPaymentNew($paymentid, $userid, $invoice, $paymentamount, $paymentdate, $paymenttypeid, $otherdetails, $paymentcollectedby, $paymentstatusid, $bathcid = 0, $remarks = NULL, $createddate)
    {
        $db = db_connect();

        $data['updated_by'] = (isset($_SESSION['userdetails']) ? $_SESSION['userdetails']->userid : NULL) == NULL ? 1 : $_SESSION['userdetails']->userid;

        $data['paymentid'] = $paymentid;
        $data['userid'] = $userid;
        $data['invoice'] = $invoice;
        $data['paymentamount'] = $paymentamount;
        $data['paymentdate'] = $paymentdate;
        $data['paymenttypeid'] = $paymenttypeid;
        $data['otherdetails'] = $otherdetails;
        $data['paymentcollectedby'] = $paymentcollectedby;
        $data['paymentstatusid'] = $paymentstatusid;
        $data['batchid'] = $bathcid == 0 ? $_SESSION['activebatch'] : $bathcid;
        $data['remarks'] = $remarks;
        $data['createddate'] =  $createddate;

        $builder = $db->table('payments');
        return $builder->insert($data);
    }

    // public function updatePayment($paymentid, $paymentamount, $paymentdate, $paymenttypeid, $otherdetails, $remarks)
    public function updatePayment($paymentid, $paymentdate, $paymenttypeid, $otherdetails, $remarks)
    {
        $db = db_connect();

        // $data['paymentamount'] = $paymentamount;
      //  $data['paymentdate'] = $paymentdate;
        $data['paymenttypeid'] = $paymenttypeid;
        $data['otherdetails'] = $otherdetails;
        $data['updated_by'] = $_SESSION['userdetails']->userid;
        $data['remarks'] = $remarks;

        $builder = $db->table('payments');
        $builder->where('paymentid', $paymentid);
        $builder->update($data);
    }
    
    public function updateReservationPayment($paymentid, $paymentamount, $paymentdate, $paymenttypeid, $otherdetails, $remarks)
    {
        $db = db_connect();

         $data['paymentamount'] = $paymentamount;
        $data['paymentdate'] = $paymentdate;
        $data['paymenttypeid'] = $paymenttypeid;
        $data['otherdetails'] = $otherdetails;
        $data['updated_by'] = $_SESSION['userdetails']->userid;
        $data['remarks'] = $remarks;

        $builder = $db->table('reservation_payments');
        $builder->where('reservation_paymentid', $paymentid);
        $builder->update($data);
    }

    public function deletepayment($paymentid)
    {
        $db = db_connect();

        $builder = $db->table('payments');
        $builder->where('paymentid', $paymentid);
        $builder->delete();
    }
    public function deletereservationpayment($paymentid)
    {

        $db = db_connect();

        $builder = $db->table('reservation_payments');
        $builder->where('reservation_paymentid', $paymentid);
        $builder->delete();
    }

    public function approvePayment($paymentid, $paymentstatusid)
    {
        $db = db_connect();

        $data['paymentstatusid'] = $paymentstatusid;
        $data['approved_by'] = $_SESSION['userdetails']->userid;

        $builder = $db->table('payments');
        $builder->where('paymentid', $paymentid);
        $builder->update($data);
    }

    public function declinePayment($paymentid, $paymentstatusid)
    {
        $db = db_connect();

        $data['paymentstatusid'] = $paymentstatusid;

        $builder = $db->table('payments');
        $builder->where('paymentid', $paymentid);
        $builder->update($data);
    }

    public function approveReservationPayment($reservation_paymentid, $paymentstatusid)
    {
        $db = db_connect();

        $data['paymentstatusid'] = $paymentstatusid;
        $data['approved_by'] = $_SESSION['userdetails']->userid;

        $builder = $db->table('reservation_payments');
        $builder->where('reservation_paymentid', $reservation_paymentid);
        $builder->update($data);
    }

    public function declineReservationPayment($reservation_paymentid, $paymentstatusid)
    {
        $db = db_connect();

        $data['paymentstatusid'] = $paymentstatusid;

        $builder = $db->table('reservation_payments');
        $builder->where('reservation_paymentid', $reservation_paymentid);
        $builder->update($data);
    }

    public function addInvoice($data)
    {
        if ($data['invoiceid'] == null) {
            $usersmodel = new UsersModel();
            $studentDetails = $usersmodel->getStudentDetails($data['userid'], $data['batchid']);

            $helpermodel = new HelperModel();
            $newInvoiceId = $helpermodel->get_nextInvoiceId($data['userid']);
            $invoiceid = "RHYD-" . "{$studentDetails[0]->applicationnumber}-{$newInvoiceId}";
        } else {
            $invoiceid = $data['invoiceid'];
        }

        $db = db_connect();
        $data1['invoiceid'] = $invoiceid;
        $data1['invoice'] = 2;
        $data1['userid'] = $data['userid'];
        $data1['feesid'] = $data['feesid'];
        $data1['feesvalue'] = $data['feesvalue'];
        $data1['discountid'] = $data['discountid'];
        $data1['sub_id'] = $this->get_next_sub_id_for_invoice($data['feesid'], $data['userid']);
        $data1['additionaldetails'] = $data['additionaldetails'];
        $data1['batchid'] = $data['batchid'];
        $builder = $db->table('invoices');
        $builder->insert($data1);

        $db->close();

        return $invoiceid;
    }

    public function get_next_sub_id_for_invoice($feesid, $userid)
    {
        $db = db_connect();
        $query = $db->query("SELECT * from feestructurelookup WHERE feecategoryid = 2 AND feesid = '{$feesid}'");
        $results = $query->getRow();

        if ($results != null) {
            $db1 = db_connect();
            $query1 = $db1->query("SELECT sub_id from invoices WHERE feesid = '{$feesid}' AND userid = '{$userid}' ORDER BY sub_id DESC LIMIT 1");
            $results1 = $query1->getRow();
            return $results1 == null ? 0 : $results1->sub_id + 1;
        } else {
            return 0;
        }
    }

    public function generateInvoice($userid, $batchid = NULL)
    {
        $batchid = $batchid == NULL ? $_SESSION['activebatch'] : $batchid;
        $usersmodel = new UsersModel();
        $studentDetails = $usersmodel->getStudentDetails($userid, $_SESSION['activebatch']);

        $helpermodel = new HelperModel();
        $feestructurelookup = $helpermodel->get_feestructurelookup();

        $newInvoiceId = $helpermodel->get_nextInvoiceId($userid);
        $invoiceid = "RHYD-" . "{$studentDetails[0]->applicationnumber}-{$newInvoiceId}";

        foreach ($feestructurelookup as $feestructure) {
            if ($feestructure->admissiontypeid == $studentDetails[0]->admissiontypeid && $feestructure->courseid == $studentDetails[0]->courseid && $feestructure->batchid == $studentDetails[0]->batchid) {
                if ($feestructure->feetype == "Tuition Fee") {
                    $db = db_connect();

                    $data['invoiceid'] = $invoiceid;
                    $data['userid'] = $userid;
                    $data['feesid'] = $feestructure->feesid;
                    $data['feesvalue'] = intval($studentDetails[0]->tuition_discount);
                    $data['batchid'] = $batchid;

                    $builder = $db->table('invoices');
                    $builder->insert($data);

                    $db->close();
                } else if ($feestructure->feetype == "Hostel Fee") {
                    $db = db_connect();

                    $data['invoiceid'] = $invoiceid;
                    $data['userid'] = $userid;
                    $data['feesid'] = $feestructure->feesid;
                    $data['feesvalue'] = intval($studentDetails[0]->hostel_discount);
                    $data['batchid'] = $batchid;

                    $builder = $db->table('invoices');
                    $builder->insert($data);

                    $db->close();
                } else if ($feestructure->feetype == "Miscellaneous Charges") {
                    $db = db_connect();

                    $data['invoiceid'] = $invoiceid;
                    $data['userid'] = $userid;
                    $data['feesid'] = $feestructure->feesid;
                    $data['feesvalue'] = intval($studentDetails[0]->final_misc) != 0 ? intval($studentDetails[0]->final_misc) : $feestructure->feesvalue;
                    $data['batchid'] = $batchid;

                    $builder = $db->table('invoices');
                    $builder->insert($data);

                    $db->close();
                } else {
                    $db = db_connect();

                    $data['invoiceid'] = $invoiceid;
                    $data['userid'] = $userid;
                    $data['feesid'] = $feestructure->feesid;
                    $data['feesvalue'] = $feestructure->feesvalue;
                    $data['batchid'] = $batchid;

                    $builder = $db->table('invoices');
                    $builder->insert($data);

                    $db->close();
                }
            }
        }

        return $invoiceid;
    }
    
    public function generateReservationInvoice($userid, $batchid = NULL)
    {
        $batchid = $batchid == NULL ? $_SESSION['activebatch'] : $batchid;
        $usersmodel = new UsersModel();
        $studentDetails = $usersmodel->getStudentDetails($userid, $batchid);
        $helpermodel = new HelperModel();
        $feestructurelookup = $helpermodel->get_feestructurelookup();
        $newInvoiceId = $helpermodel->get_nextInvoiceId($userid);
        $invoiceid = "RHYD-" . "{$studentDetails[0]->applicationnumber}-{$newInvoiceId}";

        foreach ($feestructurelookup as $feestructure) {
            if ($feestructure->admissiontypeid == $studentDetails[0]->admissiontypeid && $feestructure->courseid == $studentDetails[0]->courseid && $feestructure->batchid == $studentDetails[0]->batchid) {
                if ($feestructure->feetype == "Tuition Fee") {
                    $db = db_connect();

                    $data['invoiceid'] = $invoiceid;
                    $data['invoice'] = 1;
                    $data['userid'] = $userid;
                    $data['feesid'] = $feestructure->feesid;
                    $data['feesvalue'] = intval($feestructure->feesvalue);
                    $data['batchid'] = $batchid;

                    $builder = $db->table('invoices');
                    $builder->insert($data);

                    $db->close();
                } 
                // else if ($feestructure->feetype == "Uniform") {
                //     $db = db_connect();

                //     $data['invoiceid'] = $invoiceid;
                //     $data['invoice'] = 1;
                //     $data['userid'] = $userid;
                //     $data['feesid'] = $feestructure->feesid;
                //     $data['feesvalue'] = intval($feestructure->feesvalue);
                //     $data['batchid'] = $batchid;

                //     $builder = $db->table('invoices');
                //     $builder->insert($data);

                //     $db->close();
                // } 
                else {
                }
            }
        }

        
        $newInvoiceId = $helpermodel->get_nextInvoiceId($userid);
        $invoiceid = "RHYD-" . "{$studentDetails[0]->applicationnumber}-{$newInvoiceId}";

        foreach ($feestructurelookup as $feestructure) {
            if ($feestructure->admissiontypeid == $studentDetails[0]->admissiontypeid && $feestructure->courseid == $studentDetails[0]->courseid && $feestructure->batchid == $studentDetails[0]->batchid) {
                if ($feestructure->feetype == "Coaching Fee") {
                    $db = db_connect();

                    $data['invoiceid'] = $invoiceid;
                    $data['invoice'] = 2;
                    $data['userid'] = $userid;
                    $data['feesid'] = $feestructure->feesid;
                    $data['feesvalue'] = intval($feestructure->feesvalue);
                    $data['batchid'] = $batchid;

                    $builder = $db->table('invoices');
                    $builder->insert($data);

                    $db->close();
                } 
                // else if ($feestructure->feetype == "Intermediate Fee") {
                //     $db = db_connect();

                //     $data['invoiceid'] = $invoiceid;
                //     $data['invoice'] = 2;
                //     $data['userid'] = $userid;
                //     $data['feesid'] = $feestructure->feesid;
                //     $data['feesvalue'] = intval($studentDetails[0]->ipe_discount) != 0 ? intval($studentDetails[0]->ipe_discount) : $feestructure->feesvalue;
                //     $data['batchid'] = $batchid;

                //     $builder = $db->table('invoices');
                //     $builder->insert($data);

                //     $db->close();
                // } 
                // else if ($feestructure->feetype == "Books") {
                //     $db = db_connect();

                //     $data['invoiceid'] = $invoiceid;
                //     $data['invoice'] = 2;
                //     $data['userid'] = $userid;
                //     $data['feesid'] = $feestructure->feesid;
                //     $data['feesvalue'] = intval($feestructure->feesvalue);
                //     $data['batchid'] = $batchid;

                //     $builder = $db->table('invoices');
                //     $builder->insert($data);

                //     $db->close();
                // }
                // else if ($feestructure->feetype == "Laundry") {
                //     $db = db_connect();

                //     $data['invoiceid'] = $invoiceid;
                //     $data['invoice'] = 2;
                //     $data['userid'] = $userid;
                //     $data['feesid'] = $feestructure->feesid;
                //     $data['feesvalue'] = intval($feestructure->feesvalue);
                //     $data['batchid'] = $batchid;

                //     $builder = $db->table('invoices');
                //     $builder->insert($data);

                //     $db->close();
                // }
                // else if ($feestructure->feetype == "Caution Deposit") {
                //     $db = db_connect();

                //     $data['invoiceid'] = $invoiceid;
                //     $data['invoice'] = 2;
                //     $data['userid'] = $userid;
                //     $data['feesid'] = $feestructure->feesid;
                //     $data['feesvalue'] = intval($feestructure->feesvalue);
                //     $data['batchid'] = $batchid;

                //     $builder = $db->table('invoices');
                //     $builder->insert($data);

                //     $db->close();
                // }
                // else if ($feestructure->feetype == "Miscellaneous Charges") {
                //     $db = db_connect();

                //     $data['invoiceid'] = $invoiceid;
                //     $data['invoice'] = 2;
                //     $data['userid'] = $userid;
                //     $data['feesid'] = $feestructure->feesid;
                //     $data['feesvalue'] = intval($studentDetails[0]->ipe_discount) != 0 ? intval($studentDetails[0]->ipe_discount) : $feestructure->feesvalue;
                //     $data['batchid'] = $batchid;

                //     $builder = $db->table('invoices');
                //     $builder->insert($data);

                //     $db->close();
                // }
                else {
                }
            }
        }

        return $invoiceid;
    }
    
    
     public function generatePromoteInvoice($userid,$courseid,$admissiontypeid, $batchid=NULL,$tuition_discount=NULL,$ipe_discount,
                $hostel_discount)
    {
        $batchid = $batchid == NULL ? $_SESSION['activebatch'] : $batchid;
        $usersmodel = new UsersModel();
        $helpermodel = new HelperModel();
        $studentDetails = $usersmodel->getStudentDetails($userid, $_SESSION['activebatch']);
        $InvoiceDetails = $this->getInvoiceDetails($userid);
        
        $TotalValue=0;
                                            foreach ($InvoiceDetails as $result) :
                                                if(2==$result->batchid){
                                            $TotalValue = $TotalValue+$result->TotalValue; 
                                                }
                                            endforeach;
                                            
                                             $TotalPaid=0;
                                            foreach ($InvoiceDetails as $result1) :
                                                if(2==$result1->batchid){
                                                    $TotalPaid = $result1->TotalPaid; 
                                                }
                                            endforeach;
                                           // $myString =  $StudentDetail->applicationnumber ;
                                            
                                            
                                                $TotalPaid = $TotalPaid-2500;
                                               $RemainingAmount = $TotalValue - $TotalPaid;
                                            
                                            
        $invoiceidPre =  $InvoiceDetails[0]->invoiceid;
        $remainingFee = ($InvoiceDetails[0]->TotalValue-$InvoiceDetails[0]->TotalPaid);
        if($InvoiceDetails[0]->TotalPaid == $InvoiceDetails[0]->TotalValue)
        {
        }
        elseif($InvoiceDetails[0]->TotalPaid > $InvoiceDetails[0]->TotalValue)
        {
           // $db = db_connect();
           // $remainingFee1 = ($InvoiceDetails[0]->TotalPaid-$InvoiceDetails[0]->TotalValue);
           // $data['invoiceid'] = $invoiceidPre;
           // $data['userid'] = $userid;
           // $data['feesid'] = 46;
           // $data['feesvalue'] = intval($remainingFee1);
           // $data['batchid'] = $_SESSION['activebatch'];
            //$builder = $db->table('invoices');
           // $builder->insert($data);
            //$db->close();
        }else
        {

           // $db = db_connect();
           // $remainingFee1 = ($InvoiceDetails[0]->TotalValue-$InvoiceDetails[0]->TotalPaid);
           // $data['invoiceid'] = $invoiceidPre;
           // $data['userid'] = $userid;
          //  $data['feesid'] = 43;
           // $data['feesvalue'] = -($remainingFee1);
           // $data['batchid'] = $_SESSION['activebatch'];
           // $builder = $db->table('invoices');
          //  $builder->insert($data);
          //  $db->close();
        }

        $helpermodel = new HelperModel();
        $feestructurelookup = $helpermodel->get_feestructurelookup();

        $newInvoiceId = $helpermodel->get_nextInvoiceId($userid);
        $invoiceid = "RHYD-" . "{$studentDetails[0]->applicationnumber}-{$newInvoiceId}";
        foreach ($feestructurelookup as $feestructure) {
            if ($feestructure->admissiontypeid == $admissiontypeid && $feestructure->courseid == $courseid && $feestructure->batchid == $batchid) {
               
                if ($feestructure->feetype == "Tuition Fee") {
                    $db = db_connect();

                    $data['invoiceid'] = $invoiceid;
                    $data['invoice'] = 1;
                    $data['userid'] = $userid;
                    $data['feesid'] = $feestructure->feesid;
                    $data['feesvalue'] = intval($tuition_discount);
                    $data['batchid'] = $batchid;

                    $builder = $db->table('invoices');
                    $builder->insert($data);

                    $db->close();
                } 
                else if ($feestructure->feetype == "Uniform") {
                    $db = db_connect();

                    $data['invoiceid'] = $invoiceid;
                    $data['invoice'] = 1;
                    $data['userid'] = $userid;
                    $data['feesid'] = $feestructure->feesid;
                    $data['feesvalue'] = intval($feestructure->feesvalue);
                    $data['batchid'] = $batchid;

                    $builder = $db->table('invoices');
                    $builder->insert($data);

                    $db->close();
                }
                else
                {
                    
                }
            }
        }
         $newInvoiceId = $helpermodel->get_nextInvoiceId($userid);
        $invoiceid1 = "RHYD-" . "{$studentDetails[0]->applicationnumber}-{$newInvoiceId}";

        foreach ($feestructurelookup as $feestructure) {
            if ($feestructure->admissiontypeid == $admissiontypeid && $feestructure->courseid == $courseid && $feestructure->batchid == $batchid) {
                if ($feestructure->feetype == "Hostel Fee") {
                    $db = db_connect();

                    $data['invoiceid'] = $invoiceid1;
                    $data['invoice'] = 2;
                    $data['userid'] = $userid;
                    $data['feesid'] = $feestructure->feesid;
                    $data['feesvalue'] = intval($hostel_discount);
                    $data['batchid'] = $batchid;

                    $builder = $db->table('invoices');
                    $builder->insert($data);

                    $db->close();
                } else if ($feestructure->feetype == "Intermediate Fee") {
                    $db = db_connect();

                    $data['invoiceid'] = $invoiceid1;
                    $data['invoice'] = 2;
                    $data['userid'] = $userid;
                    $data['feesid'] = $feestructure->feesid;
                    $data['feesvalue'] = intval($ipe_discount);
                    $data['batchid'] = $batchid;

                    $builder = $db->table('invoices');
                    $builder->insert($data);

                    $db->close();
                } 
                else if ($feestructure->feetype == "Miscellaneous Charges")
                {
                     $db = db_connect();

                    $data['invoiceid'] = $invoiceid1;
                    $data['invoice'] = 2;
                    $data['userid'] = $userid;
                    $data['feesid'] = $feestructure->feesid;
                    $data['feesvalue'] = intval($feestructure->feesvalue);
                    $data['batchid'] = $batchid;

                    $builder = $db->table('invoices');
                    $builder->insert($data);

                    $db->close();
                }
                else if ($feestructure->feetype == "Books") {
                    $db = db_connect();

                    $data['invoiceid'] = $invoiceid1;
                    $data['invoice'] = 2;
                    $data['userid'] = $userid;
                    $data['feesid'] = $feestructure->feesid;
                    $data['feesvalue'] = intval($feestructure->feesvalue);
                    $data['batchid'] = $batchid;

                    $builder = $db->table('invoices');
                    $builder->insert($data);

                    $db->close();
                }
                else if ($feestructure->feetype == "Laundry") {
                    $db = db_connect();

                    $data['invoiceid'] = $invoiceid1;
                    $data['invoice'] = 2;
                    $data['userid'] = $userid;
                    $data['feesid'] = $feestructure->feesid;
                    $data['feesvalue'] = intval($feestructure->feesvalue);
                    $data['batchid'] = $batchid;

                    $builder = $db->table('invoices');
                    $builder->insert($data);

                    $db->close();
                }
                else {
                }
                if($TotalPaid == $TotalValue)
        {
        }
        elseif($TotalPaid > $TotalValue)
        {
            $db = db_connect();
            $remainingFee = ($TotalPaid-$TotalValue);
            $data['invoiceid'] = $invoiceid1;
            $data['invoice'] = 2;
            $data['userid'] = $userid;
            $data['feesid'] = 46;
            $data['feesvalue'] = -($remainingFee);
            $data['batchid'] = $batchid;
            $builder = $db->table('invoices');
            $builder->insert($data);
            $db->close();
        }else
        {
            $db = db_connect();
            $remainingFee = ($TotalValue-$TotalPaid);
            $data['invoiceid'] = $invoiceid1;
            $data['invoice'] = 2;
            $data['userid'] = $userid;
            $data['feesid'] = 43;
            $data['feesvalue'] = intval($remainingFee);
            $data['batchid'] = $batchid;
            $builder = $db->table('invoices');
            $builder->insert($data);
            $db->close();
        }
            }
        }
        

        return $invoiceid;
    }
    
    public function htmltopdf($html, $type, $filename, $reporttype)
    {
        $dompdf = new Dompdf();

        $dompdf->set_option('enable_remote', TRUE);
        $dompdf->set_option('enable_css_float', TRUE);
        $dompdf->set_option('enable_html5_parser', FALSE);

        $dompdf->setPaper('A4', 'landscape');
        $dompdf->loadHtml($html);
        @$dompdf->render();

        switch ($type) {
            case "view":
                // $dompdf->stream("", array("Attachment" => false));
                // break;

                $output = $dompdf->output();
                if ($reporttype == "I") {
                    file_put_contents("invoices_files/{$filename}.pdf", $output);
                } else if ($reporttype == "RP") {
                    file_put_contents("reservation_files/{$filename}.pdf", $output);
                } else if ($reporttype == "P") {
                    file_put_contents("payslip/{$filename}.pdf", $output);
                } else {
                    file_put_contents("receipt_files/{$filename}.pdf", $output);
                }
                break;

            case "save":
                $output = $dompdf->output();
                if ($reporttype == "I") {
                    file_put_contents("invoices_files/{$filename}.pdf", $output);
                } else if ($reporttype == "RP") {
                    file_put_contents("reservation_files/{$filename}.pdf", $output);
                } else if ($reporttype == "A") {
                    file_put_contents("attendance_files/{$filename}.pdf", $output);
                }else if ($reporttype == "C") {
                    file_put_contents("collection_files/{$filename}.pdf", $output);
                }
                else {
                    file_put_contents("receipt_files/{$filename}.pdf", $output);
                }
                break;

            case "download":
                $dompdf->stream("{$filename}");
                break;
        }
    }
    public function htmltopdfapp($html, $type, $filename, $reporttype)
    {
        $dompdf = new Dompdf();

        $dompdf->set_option('enable_remote', TRUE);
        $dompdf->set_option('enable_css_float', TRUE);
        $dompdf->set_option('enable_html5_parser', FALSE);

        $dompdf->setPaper('A4', 'portrait');
        $dompdf->loadHtml($html);
        @$dompdf->render();

        switch ($type) {
            case "view":
                // $dompdf->stream("", array("Attachment" => false));
                // break;

                $output = $dompdf->output();
                if ($reporttype == "I") {
                    file_put_contents("invoices_files/{$filename}.pdf", $output);
                } else if ($reporttype == "RP") {
                    file_put_contents("reservation_files/{$filename}.pdf", $output);
                } else if ($reporttype == "P") {
                    file_put_contents("payslip/{$filename}.pdf", $output);
                } else {
                    file_put_contents("receipt_files/{$filename}.pdf", $output);
                }
                break;

            case "save":
                $output = $dompdf->output();
                if ($reporttype == "I") {
                    file_put_contents("invoices_files/{$filename}.pdf", $output);
                } else if ($reporttype == "RP") {
                    file_put_contents("reservation_files/{$filename}.pdf", $output);
                } else if ($reporttype == "A") {
                    file_put_contents("attendance_files/{$filename}.pdf", $output);
                }else if ($reporttype == "C") {
                    file_put_contents("collection_files/{$filename}.pdf", $output);
                }
                else {
                    file_put_contents("receipt_files/{$filename}.pdf", $output);
                }
                break;

            case "download":
                $dompdf->stream("{$filename}");
                break;
        }
    }
    public function htmltopdfnew($html, $type, $filename, $reporttype)
    {
        $dompdf = new Dompdf();

        $dompdf->set_option('enable_remote', TRUE);
        $dompdf->set_option('enable_css_float', TRUE);
        $dompdf->set_option('enable_html5_parser', FALSE);

        $dompdf->setPaper('A4', 'portrait');
        $dompdf->loadHtml($html);
        @$dompdf->render();

        switch ($type) {
            case "view":
                // $dompdf->stream("", array("Attachment" => false));
                // break;

                $output = $dompdf->output();
                if ($reporttype == "I") {
                    file_put_contents("invoices_files/{$filename}.pdf", $output);
                } else if ($reporttype == "RP") {
                    file_put_contents("reservation_files/{$filename}.pdf", $output);
                } else {
                    file_put_contents("receipt_files/{$filename}.pdf", $output);
                }
                break;

            case "save":
                $output = $dompdf->output();
                if ($reporttype == "I") {
                    file_put_contents("invoices_files/{$filename}.pdf", $output);
                } else if ($reporttype == "RP") {
                    file_put_contents("reservation_files/{$filename}.pdf", $output);
                } else {
                    file_put_contents("receipt_files/{$filename}.pdf", $output);
                }
                break;

            case "download":
                $dompdf->stream("{$filename}");
                break;
        }
    }
    public function getApplicationPaymentLinkByOrderId($orderid)
    {
        $db = db_connect();
        $query = $db->query("SELECT * FROM applicationpayment_links  
                             WHERE orderid = '$orderid'");
        $result = $query->getRow();
        $db->close();

        return $result;
    }
    public function getPaymentLinkByOrderId($orderid)
    {
       $db = db_connect();
        $query = $db->query("SELECT * FROM payment_links  
                             WHERE orderid = '$orderid'");
        $result = $query->getRow();
        $db->close();

        return $result;
    }
}
