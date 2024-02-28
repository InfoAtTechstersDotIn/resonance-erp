<?php

namespace App\Controllers;

use CodeIgniter\Controller;

require '../vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Aws\S3\Exception\S3Exception;
use App\Models\HelperModel;
use App\Models\PaymentsModel;
use App\Models\RazorpayModel;
use App\Models\ReservationModel;
use App\Models\UsersModel;
use App\Models\HomeModel;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

include APPPATH . 'ThirdParty/razorpay-php/Razorpay.php';

class Razorpay extends BaseController
{
    public $session;

    // var $key = "rzp_test_eGPHbsXxFT5kBQ";
    // var $secret = "GonZO4j11v75wyBj5fKDgn5N";

    var $key = "rzp_live_HitgmaI2G7gM95";
    var $secret = "Yfv8CwD9oUX3G4p5skO2bzCJ";

    var $key1 = "rzp_live_xYTgZTX1tbC9Lw";
    var $secret1 = "X1byNR9Hbti2xN2MR2mA2Aub";

    public function __construct()
    {
        $session = session();
    }

    public function createPaymentLink()
    {
        if (isset($_SESSION['userdetails'])) {
            $amount = isset($_POST['amount']) ? $_POST['amount'] * 100 : null;
            $description = isset($_POST['description']) ? $_POST['description'] : "";
            $userid = isset($_POST['userid']) ? $_POST['userid'] : null;
            $returnURL = $_POST['returnURL'];
            $invoiceid = $_POST['invoiceid'];
            $invoice = $_POST['invoice'];
              if ($userid != null && $amount != null) {
                  $db = db_connect();
                $query1 = $db->query("select * from payment_gateway where status=1");
                $results =$query1->getResult();
                if ($invoice == 1) {
                     if($results[0]->name=="CCAvenue"){
                    $unique = uniqid();
                    $orderid = "cc_".uniqid();
                    $short_url = "https://rb.gy/m0107o?cc=".$unique;
                    $razorpayModel = new RazorpayModel();
                $razorpayModel->save_payment_link($userid,$invoiceid, $invoice,  $_SESSION['activebatch'],'', $orderid, $amount / 100, $short_url, 'issued','ccavenue',$unique);
                }else{
                        $api = new Api($this->key, $this->secret);
                        $oneDayPlus = strtotime("+1 day");
                        $link = $api->invoice->create(
                            array(
                                'type' => 'link',
                                'amount' => $amount,
                                'description' => $description,
                                'expire_by' => $oneDayPlus
                            )
                        );
                        $razorpayModel = new RazorpayModel();
                        $razorpayModel->save_payment_link($userid,  $invoiceid, $invoice, $_SESSION['activebatch'], $link->id, $link->order_id, $amount / 100, $link->short_url, $link->status,'Razorpay','');
                    }
                } elseif ($invoice == 2) {
                      if($results[0]->name=="CCAvenue"){
                $unique = uniqid();
                $orderid = "cc_".uniqid();
                             $short_url = "https://rb.gy/m0107o?cc=".$unique;
                    $razorpayModel = new RazorpayModel();
                $razorpayModel->save_payment_link($userid,$invoiceid, $invoice,  $_SESSION['activebatch'],'', $orderid, $amount / 100, $short_url, 'issued','ccavenue',$unique);
                }else{
                        $api = new Api($this->key1, $this->secret1);
                        $oneDayPlus = strtotime("+1 day");
                        $link = $api->invoice->create(
                            array(
                                'type' => 'link',
                                'amount' => $amount,
                                'description' => $description,
                                'expire_by' => $oneDayPlus
                            )
                        );
                        $razorpayModel = new RazorpayModel();
                        $razorpayModel->save_payment_link($userid,  $invoiceid, $invoice, $_SESSION['activebatch'], $link->id, $link->order_id, $amount / 100, $link->short_url, $link->status,'Razorpay','');
                    }
                }
            }

            return redirect()->to(base_url($returnURL));
        } else {
            return redirect()->to(base_url('home'));
        }
    }

    // public function getPaymentLinks()
    // {
    //     $api = new Api($this->key, $this->secret);
    //     $links = $api->invoice->all();
    //     return var_dump($links);
    // }

    public function getPaymentLinkById($invoicenumber, $invoice)
    {
        $invoiceId = isset($_GET['invoicenumber']) ? $_GET['invoicenumber'] : ($invoicenumber != "" ? $invoicenumber : null);
        if ($invoiceId != null) {
            if ($invoice == 2) {
                $api = new Api($this->key1, $this->secret1);
                $link = $api->invoice->fetch($invoiceId);
            } else {
                $api = new Api($this->key, $this->secret);
                $link = $api->invoice->fetch($invoiceId);
            }
            return $link;
        }
        return null;
    }

    public function notifyAboutPaymentLinkBySms()
    {
        $invoiceId = isset($_GET['invoicenumber']) ? $_GET['invoicenumber'] : null;
        if ($invoiceId != null) {
            $api = new Api($this->key, $this->secret);
            $link = $api->invoice->fetch($invoiceId);
            $link->notifyBy('sms');
        }
    }

    public function notifyAboutPaymentLinkByEmail()
    {
        $invoiceId = isset($_GET['invoicenumber']) ? $_GET['invoicenumber'] : null;
        if ($invoiceId != null) {
            $api = new Api($this->key, $this->secret);
            $link = $api->invoice->fetch($invoiceId);
            $link->notifyBy('email');
        }
    }

    public function cancelPaymentLink()
    {
        $invoiceId = isset($_GET['invoicenumber']) ? $_GET['invoicenumber'] : null;
        if ($invoiceId != null) {
            $api = new Api($this->key, $this->secret);
            $link = $api->invoice->fetch($invoiceId);
            $link->cancel();
        }
    }

    public function invoicePaidWebhook1()
    {


        $invoiceId = 'inv_Muo4ZB1RFch4Zj';
        $paymentsModel = new PaymentsModel();
        $paymentLink = $paymentsModel->getPaymentLinkByInvoiceId($invoiceId);
        if ($paymentLink) {

            $otherdetails = $invoiceData['payload']['invoice']['entity']['payment_id'];
            $db = db_connect();
            $query = $db->query("SELECT * FROM payments  
                             WHERE otherdetails = 'pay_MuoBcKXDH6m9PZb'");
            $result = $query->getResult();
            $bg = count($result);
            $cot = htmlentities($bg);
            if ($cot > 0) {
                echo "already";
            } else {
                echo "noo";
            }
            $db->close();
        }
    }
    public function invoicePaidWebhook()
    {
        $invoiceData = json_decode(file_get_contents('php://input'), true);
        if ($invoiceData != null && $invoiceData['event'] == "invoice.paid") {
            $invoiceId = $invoiceData['payload']['invoice']['entity']['id'];
            $paymentsModel = new PaymentsModel();
            $paymentLink = $paymentsModel->getPaymentLinkByInvoiceId($invoiceId);
            if ($paymentLink) {
                $otherdetails = $invoiceData['payload']['invoice']['entity']['payment_id'];
                $db = db_connect();
                $query = $db->query("SELECT * FROM payments WHERE otherdetails = '$otherdetails'");
                $result = $query->getResult();
                $bg = count($result);
                $cot = htmlentities($bg);
                if ($cot > 0) {
                } else {
                    $userid = $paymentLink->userid;
                    $paymenttypeid = 6;
                    $paymentamount = $paymentLink->amount;
                    $invoice = $paymentLink->invoice_id;
                    $paymentdate = date("Y-m-d", $invoiceData['payload']['invoice']['entity']['paid_at']);
                    $otherdetails = $invoiceData['payload']['invoice']['entity']['payment_id'];
                    $paymentcollectedby = 1;
                    $paymentstatusid = 1;
                    $batchid = $paymentLink->batchid;

                    $helperModel = new HelperModel();
                    $batch = $helperModel->get_batch()->year;
                    $nextpaymentid = $helperModel->get_paymentidcounter();

                    $paymentid = "RMD-" . $batch . "-" . str_pad($nextpaymentid, 6, '0', STR_PAD_LEFT);

                    $paymentsModel = new PaymentsModel();
                    $result = $paymentsModel->addStudentPayment($paymentid, $userid, $paymentamount, $paymentdate, $paymenttypeid, $otherdetails, $paymentcollectedby, $paymentstatusid, $batchid, $invoice, "Payment Link");

                    if ($result->resultID) {
                        $nextpaymentid = $helperModel->set_paymentidcounter();
                    }

                    $razorpayModel = new RazorpayModel();
                    $razorpayModel->update_payment_status($invoiceId, $invoiceData['payload']['invoice']['entity']['status']);

                    $html = file_get_contents(base_url("payments/print_receipt?paymentid={$paymentid}&batchid={$batchid}"));

                    $paymentsmodel = new PaymentsModel();
                    $paymentsmodel->htmltopdf($html, 'save', $paymentid, 'R');

                    $usersModel = new UsersModel();
                    $studentDetails = $usersModel->getStudentDetails($userid, $batchid);
                    $comm = new Comm();
                    $data[0] = $studentDetails[0]->mobile1;
                    $data[1] = $paymentamount;
                    $data[2] = $studentDetails[0]->applicationnumber;
                    // $data[3] = base_url("receipt_files/{$paymentid}.pdf");
                    $data[3] = "rb.gy/o0uabr?p=" . $paymentid;

                    $s3Client = new S3Client([
                        'endpoint' => 'https://s3.wasabisys.com',
                        'version' => 'latest',
                        'region'  => 'us-east-1',
                        'credentials' => [
                            'key'    => '9R6N30YAWA67EHB6L3RB',
                            'secret' => 'DsE1YPLqZGiSS1iTVyLoXY2L6VbZM3b0hAR7e7hl'
                        ],
                        'use_path_style_endpoint' => true
                    ]);

                    $HELLO = file_get_contents("https://maidendropgroup.com/public/receipt_files/{$paymentid}.pdf");

                    try {
                        $result = $s3Client->putObject([
                            'ACL' => 'public-read',
                            'Bucket' => 'resohyd',
                            'Key' => "{$paymentid}.pdf",
                            'Body' => $HELLO
                        ]);
                    } catch (S3Exception $e) {
                        echo $e->getMessage() . PHP_EOL;
                    }


                    $comm->sendSMS("PaymentConfirm", $data);

                    $mobile = $studentDetails[0]->mobile1;
                    $roll = $studentDetails[0]->applicationnumber;
                    $name = $studentDetails[0]->name;
                    $url = "rb.gy/o0uabr?p=" . $paymentid;
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
                        CURLOPT_POSTFIELDS => '{
                "apiKey": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY0ZDM1YzQ3NTdiNDJkMTA0NzFhNjBlNSIsIm5hbWUiOiJwdXJuYSIsImFwcE5hbWUiOiJBaVNlbnN5IiwiY2xpZW50SWQiOiI2NGQzNWM0NzU3YjQyZDEwNDcxYTYwZTAiLCJhY3RpdmVQbGFuIjoiTk9ORSIsImlhdCI6MTY5MTU3MzMxOX0.4AkHFTfGMUn9AP4q7tDAIHH0C5QUuXcsLfUOOW71AIg",
                "campaignName": "payment_receipt_with_link",
                "destination": "' . $mobile . '",
                "userName": "' . $name . '",
                "templateParams": ["' . $paymentamount . '","' . $roll . '","' . $url . '"]
            }',
                        CURLOPT_HTTPHEADER => array(
                            'Content-Type: application/json'
                        ),
                    ));

                    $response = curl_exec($curl);

                    curl_close($curl);
                }
            } else {
                $paymentLink = $paymentsModel->getApplicationPaymentLinkByInvoiceId($invoiceId);
                $userid = $paymentLink->userid;
                $batchid = $paymentLink->batchid;

                $paymentLink = $paymentsModel->getApplicationPaymentLinkByInvoiceId($invoiceId);

                $userid = $paymentLink->userid;
                $paymenttypeid = 6;
                $paymentamount = $paymentLink->amount;
                $paymentdate = date("Y-m-d", $invoiceData['payload']['invoice']['entity']['paid_at']);
                $otherdetails = $invoiceData['payload']['invoice']['entity']['payment_id'];
                $db = db_connect();
                $query = $db->query("SELECT * FROM applicationpayments WHERE otherdetails = '$otherdetails'");
                $result = $query->getResult();
                $bg = count($result);
                $cot = htmlentities($bg);
                if ($cot > 0) {
                } else {
                $paymentcollectedby = 1;
                $paymentstatusid = 1;
                $batchid = $paymentLink->batchid;

                $helperModel = new HelperModel();
                $batch = $helperModel->get_batch()->year;
                $nextpaymentid = $helperModel->get_paymentidcounter();

                $paymentid = "RMDA-" . $batch . "-" . str_pad($nextpaymentid, 6, '0', STR_PAD_LEFT);

                $paymentsModel = new PaymentsModel();
                $result = $paymentsModel->addApplicationPayment($paymentid, $userid, $paymentamount, $paymentdate, $paymenttypeid, $otherdetails, $paymentcollectedby, $paymentstatusid, $batchid, "Booking Amount");

                if ($result->resultID) {
                    $nextpaymentid = $helperModel->set_paymentidcounter();
                }

                $html = file_get_contents(base_url("payments/print_applicationreceipt?paymentid={$paymentid}&batchid=3"));
                $paymentsModel->htmltopdf($html, 'save', $paymentid, 'R');
                $razorpayModel = new RazorpayModel();
                $razorpayModel->update_applicationpayment_status($invoiceId, $invoiceData['payload']['invoice']['entity']['status'], $userid);
                $razorpayModel->update_application_status($userid);
                $reservationModel = new ReservationModel();
                $studentDetails = $reservationModel->getApplicationDetails($userid, $batchid);

                $comm = new Comm();
                $data[0] = $studentDetails->mobile1;
                $data[1] = $paymentamount;
                $data[2] = $studentDetails->applicationnumber;
                // $data[3] = base_url("receipt_files/{$paymentid}.pdf");
                $data[3] = "https://rb.gy/geapsq?id=" . $studentDetails->applicationid;
                $data[4] = $studentDetails->name;
                $data[5] = $studentDetails->branchname;

                $comm->sendSMS("ApplicationPaymentConfirm", $data);

                $mobile = $studentDetails->mobile1;
                $roll = $studentDetails->application_ukey;
                $name = $studentDetails->name;
                $url = "rb.gy/o0uabr?p=" . $paymentid;
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
                    CURLOPT_POSTFIELDS => '{
                "apiKey": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY0ZDM1YzQ3NTdiNDJkMTA0NzFhNjBlNSIsIm5hbWUiOiJwdXJuYSIsImFwcE5hbWUiOiJBaVNlbnN5IiwiY2xpZW50SWQiOiI2NGQzNWM0NzU3YjQyZDEwNDcxYTYwZTAiLCJhY3RpdmVQbGFuIjoiTk9ORSIsImlhdCI6MTY5MTU3MzMxOX0.4AkHFTfGMUn9AP4q7tDAIHH0C5QUuXcsLfUOOW71AIg",
                "campaignName": "payment_receipt_with_link",
                "destination": "' . $mobile . '",
                "userName": "' . $name . '",
                "templateParams": ["' . $paymentamount . '","' . $roll . '","' . $url . '"]
            }',
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json'
                    ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);


                $reservationModel = new ReservationModel();
                $studentDetails = $reservationModel->getApplicationDetails($userid, $batchid);
                $usersModel = new UsersModel();
                $reservationModel = new ReservationModel();
                $reservationid = $studentDetails->applicationid;
                $PaymentDetail = $reservationModel->getApplicationPaymentDetailsByReservationPaymentId($reservationid);
                $reservationModel = new ReservationModel();
                $StudentDetail = $reservationModel->getApplicationDetails($reservationid);
                $reservation_ukey = $StudentDetail->application_ukey;
                $name = $StudentDetail->name;
                $dateofbirth = $StudentDetail->dateofbirth;
                $genderid = $StudentDetail->genderid;
                $nationalityid = $StudentDetail->nationalityid;
                $religionid = $StudentDetail->religionid;
                $categoryid = $StudentDetail->categoryid;
                $studentaadhaar = $StudentDetail->studentaadhaar;

                $fathername = $StudentDetail->fathername;
                $mothername = $StudentDetail->mothername;
                $parentoccupation = $StudentDetail->parentoccupation;
                $visitorname = $StudentDetail->visitorname;
                $relationwithstudent = $StudentDetail->relationwithstudent;
                $visitornumber = $StudentDetail->visitornumber;

                $PreviousClassesInfo = json_decode($StudentDetail->previous_class_information);
                if ($PreviousClassesInfo != "") {
                    foreach ($PreviousClassesInfo as $classInfo) {
                        $classInfo = $classInfo;
                    }
                }

                $previous_class_information = [];
                $class = [];
                $class['class'] = 'PCI';
                $class['school'] = $classInfo->school;
                $class['board'] = $classInfo->board;
                $class['place'] = $classInfo->place;
                $class['grade'] = $classInfo->grade;
                $class['hallticketNo'] = $classInfo->hallticketNo;
                array_push($previous_class_information, $class);
                $Address = json_decode($StudentDetail->address);
                $permanentAddress = $Address->permanent;
                $address = [];
                $permanent['door_street'] = $permanentAddress->door_street;
                $permanent['village_mandal'] = $permanentAddress->village_mandal;
                $permanent['landmark'] = $permanentAddress->landmark;
                $permanent['city_town'] = $permanentAddress->city_town;
                $permanent['state'] = $permanentAddress->state;
                $permanent['district'] = $permanentAddress->district;
                $permanent['pin'] = $permanentAddress->pin;

                $address['permanent'] = $permanent;

                $mobile1 = $StudentDetail->mobile1;
                $mobile2 = $StudentDetail->mobile2;
                $email = $StudentDetail->email;

                $admissiontypeid = $StudentDetail->admissiontypeid;
                $courseid = $StudentDetail->courseid;
                $sectionid = 0;
                $secondlanguageid = $StudentDetail->secondlanguageid;
                $branchid = $StudentDetail->branchid;
                $comments = $StudentDetail->comments;
                $referredby = $StudentDetail->referredby == "" ? 0 : $StudentDetail->referredby;
                $batchid = $StudentDetail->batchid;

                $admissiondate = $StudentDetail->admissiondate;
                $reservationstatusid = 4;
                $scholarship = 0;
                $tuition_discount = $StudentDetail->tuition_discount;
                $tuition_discount1 = $StudentDetail->tuition_discount1;
                $hostel_discount = 0;
                $final_misc = 0;
                $created_by = 1;

                $discountrequested = $StudentDetail->discountrequested;
                $discountgiven = $StudentDetail->discountgiven;
                $discountapproved_by = $StudentDetail->discountapproved_by;
                $additionaldiscountgiven = $StudentDetail->additionaldiscountgiven;

                $address_json = json_encode($address);
                $previous_class_information_json = json_encode($previous_class_information);

                $reservationModel = new ReservationModel();
                $insertId = $reservationModel->addApplicationReservationUser(
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
                );

                if ($insertId != 0) {

                    $paymenttypeid = $PaymentDetail[0]->paymenttypeid;
                    $paymentamount = $PaymentDetail[0]->paymentamount;
                    $paymentdate = $PaymentDetail[0]->paymentdate;
                    //$paymentdate = date('Y-m-d');
                    $otherdetails = $PaymentDetail[0]->otherdetails;
                    $paymentcollectedby = $PaymentDetail[0]->paymentcollectedby;
                    $paymentstatusid = 1;

                    $helperModel = new HelperModel();
                    $batch = $helperModel->get_batch()->year;
                    $nextpaymentid = $helperModel->get_paymentidcounter();

                    $reservation_paymentid = "RMD-" . $batch . "-" . str_pad($nextpaymentid, 6, '0', STR_PAD_LEFT);

                    $result = $reservationModel->addReservationPayment(
                        $reservation_paymentid,
                        $insertId,
                        $paymentamount,
                        $paymentdate,
                        $paymenttypeid,
                        $otherdetails,
                        $paymentcollectedby,
                        $paymentstatusid,
                        $batchid,
                        'Booking Amount'
                    );

                    if ($result->resultID) {
                        $nextpaymentid = $helperModel->set_paymentidcounter();
                    }

                    $reservationModel->updateApplication1(
                        $reservationid
                    );
                    $applicatio = $studentDetails->applicationnumber;
                    $email = $studentDetails->email;
                    $retstatus = $studentDetails->retstatus;
                    if($retstatus == 1)
                    {
                        $paymentdate = date("d/m/Y", $invoiceData['payload']['invoice']['entity']['paid_at']);
                        $data = array('email' => $email, 'application_no' => "$applicatio", 'secret_key' => '7f553c6768790902c5f73d49db02746f', 'form_id' => '18781', 'enrolled_field9' => '12500', 'enrolled_field10' => $paymentdate, 'enrolled_field11' => $otherdetails, 'mode' => 'update');

                    // Data should be passed as json format
                    $data_json = json_encode($data);
                    // API URL to send data
                    $url = 'https://api.in5.nopaperforms.com/form/post-application/5471/18781';

                    // curl initiate
                    $ch = curl_init();

                    curl_setopt($ch, CURLOPT_URL, $url);

                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

                    // SET Method as a POST
                    curl_setopt($ch, CURLOPT_POST, 1);

                    // Pass user data in POST command
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);

                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    // Execute curl and assign returned data
                    $response  = curl_exec($ch);

                    // Close curl
                    curl_close($ch);
                    }
                    $data = array('email' => $email, 'application_no' => "$applicatio", 'secret_key' => '7f553c6768790902c5f73d49db02746f', 'form_id' => '18781', 'enrolled_field8' => '1500691;;;Yes', 'mode' => 'update');

                    // Data should be passed as json format
                    $data_json = json_encode($data);
                    // API URL to send data
                    $url = 'https://api.in5.nopaperforms.com/form/post-application/5471/18781';

                    // curl initiate
                    $ch = curl_init();

                    curl_setopt($ch, CURLOPT_URL, $url);

                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

                    // SET Method as a POST
                    curl_setopt($ch, CURLOPT_POST, 1);

                    // Pass user data in POST command
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);

                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    // Execute curl and assign returned data
                    $response  = curl_exec($ch);

                    // Close curl
                    curl_close($ch);
                }
                }
            }
        }
    }
    
    public function invoicePaidWebhooktest()
    {
       // $invoiceData = json_decode(file_get_contents('php://input'), true);
       
            $invoiceId = 'inv_N4DVB0VlL42NXd';
            // $invoiceId = $invoiceData['payload']['invoice']['entity']['id'];
            $paymentsModel = new PaymentsModel();
            $paymentLink = $paymentsModel->getPaymentLinkByInvoiceId($invoiceId);
            if ($paymentLink) {
                $otherdetails = 'pay_N5NkavlapD4cZL';
                $db = db_connect();
                $query = $db->query("SELECT * FROM payments WHERE otherdetails = '$otherdetails'");
                $result = $query->getResult();
                $bg = count($result);
                $cot = htmlentities($bg);
                if ($cot > 0) {
                } else {
                    $userid = $paymentLink->userid;
                    $paymenttypeid = 6;
                    $paymentamount = $paymentLink->amount;
                    $invoice = $paymentLink->invoice_id;
                    $paymentdate = date("Y-m-d", $invoiceData['payload']['invoice']['entity']['paid_at']);
                    $otherdetails = $invoiceData['payload']['invoice']['entity']['payment_id'];
                    $paymentcollectedby = 1;
                    $paymentstatusid = 1;
                    $batchid = $paymentLink->batchid;

                    $helperModel = new HelperModel();
                    $batch = $helperModel->get_batch()->year;
                    $nextpaymentid = $helperModel->get_paymentidcounter();

                    $paymentid = "RMD-" . $batch . "-" . str_pad($nextpaymentid, 6, '0', STR_PAD_LEFT);

                    $paymentsModel = new PaymentsModel();
                    $result = $paymentsModel->addStudentPayment($paymentid, $userid, $paymentamount, $paymentdate, $paymenttypeid, $otherdetails, $paymentcollectedby, $paymentstatusid, $batchid, $invoice, "Payment Link");

                    if ($result->resultID) {
                        $nextpaymentid = $helperModel->set_paymentidcounter();
                    }

                    $razorpayModel = new RazorpayModel();
                    $razorpayModel->update_payment_status($invoiceId, $invoiceData['payload']['invoice']['entity']['status']);

                    $html = file_get_contents(base_url("payments/print_receipt?paymentid={$paymentid}&batchid={$batchid}"));

                    $paymentsmodel = new PaymentsModel();
                    $paymentsmodel->htmltopdf($html, 'save', $paymentid, 'R');

                    $usersModel = new UsersModel();
                    $studentDetails = $usersModel->getStudentDetails($userid, $batchid);
                    $comm = new Comm();
                    $data[0] = $studentDetails[0]->mobile1;
                    $data[1] = $paymentamount;
                    $data[2] = $studentDetails[0]->applicationnumber;
                    // $data[3] = base_url("receipt_files/{$paymentid}.pdf");
                    $data[3] = "rb.gy/o0uabr?p=" . $paymentid;

                    $s3Client = new S3Client([
                        'endpoint' => 'https://s3.wasabisys.com',
                        'version' => 'latest',
                        'region'  => 'us-east-1',
                        'credentials' => [
                            'key'    => '9R6N30YAWA67EHB6L3RB',
                            'secret' => 'DsE1YPLqZGiSS1iTVyLoXY2L6VbZM3b0hAR7e7hl'
                        ],
                        'use_path_style_endpoint' => true
                    ]);

                    $HELLO = file_get_contents("https://maidendropgroup.com/public/receipt_files/{$paymentid}.pdf");

                    try {
                        $result = $s3Client->putObject([
                            'ACL' => 'public-read',
                            'Bucket' => 'resohyd',
                            'Key' => "{$paymentid}.pdf",
                            'Body' => $HELLO
                        ]);
                    } catch (S3Exception $e) {
                        echo $e->getMessage() . PHP_EOL;
                    }


                    $comm->sendSMS("PaymentConfirm", $data);

                    $mobile = $studentDetails[0]->mobile1;
                    $roll = $studentDetails[0]->applicationnumber;
                    $name = $studentDetails[0]->name;
                    $url = "rb.gy/o0uabr?p=" . $paymentid;
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
                        CURLOPT_POSTFIELDS => '{
                "apiKey": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY0ZDM1YzQ3NTdiNDJkMTA0NzFhNjBlNSIsIm5hbWUiOiJwdXJuYSIsImFwcE5hbWUiOiJBaVNlbnN5IiwiY2xpZW50SWQiOiI2NGQzNWM0NzU3YjQyZDEwNDcxYTYwZTAiLCJhY3RpdmVQbGFuIjoiTk9ORSIsImlhdCI6MTY5MTU3MzMxOX0.4AkHFTfGMUn9AP4q7tDAIHH0C5QUuXcsLfUOOW71AIg",
                "campaignName": "payment_receipt_with_link",
                "destination": "' . $mobile . '",
                "userName": "' . $name . '",
                "templateParams": ["' . $paymentamount . '","' . $roll . '","' . $url . '"]
            }',
                        CURLOPT_HTTPHEADER => array(
                            'Content-Type: application/json'
                        ),
                    ));

                    $response = curl_exec($curl);

                    curl_close($curl);
                }
            } else {
                $paymentLink = $paymentsModel->getApplicationPaymentLinkByInvoiceId($invoiceId);
                $userid = $paymentLink->userid;
                $batchid = $paymentLink->batchid;

                $paymentLink = $paymentsModel->getApplicationPaymentLinkByInvoiceId($invoiceId);

                $userid = $paymentLink->userid;
                $paymenttypeid = 6;
                $paymentamount = $paymentLink->amount;
                $paymentdate = date("Y-m-d");
                $otherdetails = 'pay_N4EdzUjI5E4e3y';
                $db = db_connect();
                $query = $db->query("SELECT * FROM applicationpayments WHERE otherdetails = '$otherdetails'");
                $result = $query->getResult();
                $bg = count($result);
                $cot = htmlentities($bg);
                if ($cot > 0) {
                } else {
                $paymentcollectedby = 1;
                $paymentstatusid = 1;
                $batchid = $paymentLink->batchid;

                $helperModel = new HelperModel();
                $batch = $helperModel->get_batch()->year;
                $nextpaymentid = $helperModel->get_paymentidcounter();

                $paymentid = "RMDA-" . $batch . "-" . str_pad($nextpaymentid, 6, '0', STR_PAD_LEFT);

                $paymentsModel = new PaymentsModel();
                $result = $paymentsModel->addApplicationPayment($paymentid, $userid, $paymentamount, $paymentdate, $paymenttypeid, $otherdetails, $paymentcollectedby, $paymentstatusid, $batchid, "Booking Amount");

                if ($result->resultID) {
                    $nextpaymentid = $helperModel->set_paymentidcounter();
                }

                $html = file_get_contents(base_url("payments/print_applicationreceipt?paymentid={$paymentid}&batchid=3"));
                $paymentsModel->htmltopdf($html, 'save', $paymentid, 'R');
                $razorpayModel = new RazorpayModel();
                $razorpayModel->update_applicationpayment_status($invoiceId, 'paid', $userid);
                $razorpayModel->update_application_status($userid);
                $reservationModel = new ReservationModel();
                $studentDetails = $reservationModel->getApplicationDetails($userid, $batchid);

                $comm = new Comm();
                $data[0] = $studentDetails->mobile1;
                $data[1] = $paymentamount;
                $data[2] = $studentDetails->applicationnumber;
                // $data[3] = base_url("receipt_files/{$paymentid}.pdf");
                $data[3] = "https://rb.gy/geapsq?id=" . $studentDetails->applicationid;
                $data[4] = $studentDetails->name;
                $data[5] = $studentDetails->branchname;

                $comm->sendSMS("ApplicationPaymentConfirm", $data);

                $mobile = $studentDetails->mobile1;
                $roll = $studentDetails->application_ukey;
                $name = $studentDetails->name;
                $url = "rb.gy/o0uabr?p=" . $paymentid;
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
                    CURLOPT_POSTFIELDS => '{
                "apiKey": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY0ZDM1YzQ3NTdiNDJkMTA0NzFhNjBlNSIsIm5hbWUiOiJwdXJuYSIsImFwcE5hbWUiOiJBaVNlbnN5IiwiY2xpZW50SWQiOiI2NGQzNWM0NzU3YjQyZDEwNDcxYTYwZTAiLCJhY3RpdmVQbGFuIjoiTk9ORSIsImlhdCI6MTY5MTU3MzMxOX0.4AkHFTfGMUn9AP4q7tDAIHH0C5QUuXcsLfUOOW71AIg",
                "campaignName": "payment_receipt_with_link",
                "destination": "' . $mobile . '",
                "userName": "' . $name . '",
                "templateParams": ["' . $paymentamount . '","' . $roll . '","' . $url . '"]
            }',
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json'
                    ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);


                $reservationModel = new ReservationModel();
                $studentDetails = $reservationModel->getApplicationDetails($userid, $batchid);
                $usersModel = new UsersModel();
                $reservationModel = new ReservationModel();
                $reservationid = $studentDetails->applicationid;
                $PaymentDetail = $reservationModel->getApplicationPaymentDetailsByReservationPaymentId($reservationid);
                $reservationModel = new ReservationModel();
                $StudentDetail = $reservationModel->getApplicationDetails($reservationid);
                $reservation_ukey = $StudentDetail->application_ukey;
                $name = $StudentDetail->name;
                $dateofbirth = $StudentDetail->dateofbirth;
                $genderid = $StudentDetail->genderid;
                $nationalityid = $StudentDetail->nationalityid;
                $religionid = $StudentDetail->religionid;
                $categoryid = $StudentDetail->categoryid;
                $studentaadhaar = $StudentDetail->studentaadhaar;

                $fathername = $StudentDetail->fathername;
                $mothername = $StudentDetail->mothername;
                $parentoccupation = $StudentDetail->parentoccupation;
                $visitorname = $StudentDetail->visitorname;
                $relationwithstudent = $StudentDetail->relationwithstudent;
                $visitornumber = $StudentDetail->visitornumber;

                $PreviousClassesInfo = json_decode($StudentDetail->previous_class_information);
                if ($PreviousClassesInfo != "") {
                    foreach ($PreviousClassesInfo as $classInfo) {
                        $classInfo = $classInfo;
                    }
                }

                $previous_class_information = [];
                $class = [];
                $class['class'] = 'PCI';
                $class['school'] = $classInfo->school;
                $class['board'] = $classInfo->board;
                $class['place'] = $classInfo->place;
                $class['grade'] = $classInfo->grade;
                $class['hallticketNo'] = $classInfo->hallticketNo;
                array_push($previous_class_information, $class);
                $Address = json_decode($StudentDetail->address);
                $permanentAddress = $Address->permanent;
                $address = [];
                $permanent['door_street'] = $permanentAddress->door_street;
                $permanent['village_mandal'] = $permanentAddress->village_mandal;
                $permanent['landmark'] = $permanentAddress->landmark;
                $permanent['city_town'] = $permanentAddress->city_town;
                $permanent['state'] = $permanentAddress->state;
                $permanent['district'] = $permanentAddress->district;
                $permanent['pin'] = $permanentAddress->pin;

                $address['permanent'] = $permanent;

                $mobile1 = $StudentDetail->mobile1;
                $mobile2 = $StudentDetail->mobile2;
                $email = $StudentDetail->email;

                $admissiontypeid = $StudentDetail->admissiontypeid;
                $courseid = $StudentDetail->courseid;
                $sectionid = 0;
                $secondlanguageid = $StudentDetail->secondlanguageid;
                $branchid = $StudentDetail->branchid;
                $comments = $StudentDetail->comments;
                $referredby = $StudentDetail->referredby == "" ? 0 : $StudentDetail->referredby;
                $batchid = $StudentDetail->batchid;

                $admissiondate = $StudentDetail->admissiondate;
                $reservationstatusid = 4;
                $scholarship = 0;
                $tuition_discount = $StudentDetail->tuition_discount;
                $hostel_discount = 0;
                $final_misc = 0;
                $created_by = 1;

                $discountrequested = $StudentDetail->discountrequested;
                $discountgiven = $StudentDetail->discountgiven;
                $discountapproved_by = $StudentDetail->discountapproved_by;
                $additionaldiscountgiven = $StudentDetail->additionaldiscountgiven;

                $address_json = json_encode($address);
                $previous_class_information_json = json_encode($previous_class_information);

                $reservationModel = new ReservationModel();
                $insertId = $reservationModel->addApplicationReservationUser(
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
                    $discountapproved_by,
                    $additionaldiscountgiven,
                    $created_by
                );

                if ($insertId != 0) {

                    $paymenttypeid = $PaymentDetail[0]->paymenttypeid;
                    $paymentamount = $PaymentDetail[0]->paymentamount;
                    $paymentdate = $PaymentDetail[0]->paymentdate;
                    //$paymentdate = date('Y-m-d');
                    $otherdetails = $PaymentDetail[0]->otherdetails;
                    $paymentcollectedby = $PaymentDetail[0]->paymentcollectedby;
                    $paymentstatusid = 1;

                    $helperModel = new HelperModel();
                    $batch = $helperModel->get_batch()->year;
                    $nextpaymentid = $helperModel->get_paymentidcounter();

                    $reservation_paymentid = "RMD-" . $batch . "-" . str_pad($nextpaymentid, 6, '0', STR_PAD_LEFT);

                    $result = $reservationModel->addReservationPayment(
                        $reservation_paymentid,
                        $insertId,
                        $paymentamount,
                        $paymentdate,
                        $paymenttypeid,
                        $otherdetails,
                        $paymentcollectedby,
                        $paymentstatusid,
                        $batchid,
                        'Booking Amount'
                    );

                    if ($result->resultID) {
                        $nextpaymentid = $helperModel->set_paymentidcounter();
                    }

                    $reservationModel->updateApplication1(
                        $reservationid
                    );
                    $applicatio = $studentDetails->applicationnumber;
                    $email = $studentDetails->email;
                    $data = array('email' => $email, 'application_no' => "$applicatio", 'secret_key' => '7f553c6768790902c5f73d49db02746f', 'form_id' => '18781', 'enrolled_field8' => '1500691;;;Yes', 'mode' => 'update');

                    // Data should be passed as json format
                    $data_json = json_encode($data);
                    // API URL to send data
                    $url = 'https://api.in5.nopaperforms.com/form/post-application/5471/18781';

                    // curl initiate
                    $ch = curl_init();

                    curl_setopt($ch, CURLOPT_URL, $url);

                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

                    // SET Method as a POST
                    curl_setopt($ch, CURLOPT_POST, 1);

                    // Pass user data in POST command
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);

                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    // Execute curl and assign returned data
                    $response  = curl_exec($ch);

                    // Close curl
                    curl_close($ch);
                }
                }
            }
        
    }
    public function pdfgenerate()
    {
        $html = file_get_contents(base_url("payments/print_application?userid=189&batchid=3"));

        $paymentsModel = new PaymentsModel();
        $filename = 'RESHYD-2300138' . '-' . 'Gajjala koushik tej Reddy';
        $paymentsModel->htmltopdf($html, 'save', $filename, 'R');
    }
    
    public function ccavenuewebhook()
    {
        $order_id = $_POST['order_id'];
        $trackingid = $_POST['trackingid'];
        $db = db_connect();
      $sql11 = $db->query("insert into payment_log set data='$order_id'");
         $paymentsModel = new PaymentsModel();
                $paymentLink = $paymentsModel->getPaymentLinkByOrderId($order_id);
               
                $userid = $paymentLink->userid;
              
                    $paymenttypeid = 11;
                    $paymentamount = $paymentLink->amount;
                      
                    $invoice = $paymentLink->invoice_id;
                    $paymentdate = date("Y-m-d H:i:s");
                    $otherdetails = $trackingid;
                    $paymentcollectedby = 1;
                    $paymentstatusid = 1;
                    $batchid = $paymentLink->batchid;

                    $helperModel = new HelperModel();
                    $batch = $helperModel->get_batch()->year;
                    $nextpaymentid = $helperModel->get_paymentidcounter();

                    $paymentid = "RMD-" . $batch . "-" . str_pad($nextpaymentid, 6, '0', STR_PAD_LEFT);
                    // $sql11 = $db->query("insert into payment_log set data='$paymentid'");
                    $paymentsModel = new PaymentsModel();
                    $result = $paymentsModel->addStudentPayment($paymentid, $userid, $paymentamount, $paymentdate, $paymenttypeid, $otherdetails, $paymentcollectedby, $paymentstatusid, $batchid, $invoice, "Payment Link");

                  //  if ($result->resultID) {
                        $nextpaymentid = $helperModel->set_paymentidcounter();
                  //  }

                    $razorpayModel = new RazorpayModel();
                    $razorpayModel->update_payment_status_orderid($order_id ,'paid');

                    $html = file_get_contents(base_url("payments/print_receipt?paymentid={$paymentid}&batchid={$batchid}"));

                    $paymentsmodel = new PaymentsModel();
                    $paymentsmodel->htmltopdf($html, 'save', $paymentid, 'R');

                    $usersModel = new UsersModel();
                    $studentDetails = $usersModel->getStudentDetails($userid, $batchid);
                   
                    $comm = new Comm();
                    $data[0] = $studentDetails[0]->mobile1;
                    $data[1] = $paymentamount;
                    $data[2] = $studentDetails[0]->applicationnumber;
                    // $data[3] = base_url("receipt_files/{$paymentid}.pdf");
                    $data[3] = "rb.gy/o0uabr?p=" . $paymentid;

                    $s3Client = new S3Client([
                        'endpoint' => 'https://s3.wasabisys.com',
                        'version' => 'latest',
                        'region'  => 'us-east-1',
                        'credentials' => [
                            'key'    => '9R6N30YAWA67EHB6L3RB',
                            'secret' => 'DsE1YPLqZGiSS1iTVyLoXY2L6VbZM3b0hAR7e7hl'
                        ],
                        'use_path_style_endpoint' => true
                    ]);

                    $HELLO = file_get_contents("https://maidendropgroup.com/public/receipt_files/{$paymentid}.pdf");

                    try {
                        $result = $s3Client->putObject([
                            'ACL' => 'public-read',
                            'Bucket' => 'resohyd',
                            'Key' => "{$paymentid}.pdf",
                            'Body' => $HELLO
                        ]);
                    } catch (S3Exception $e) {
                        echo $e->getMessage() . PHP_EOL;
                    }


                    $comm->sendSMS("PaymentConfirm", $data);

                    $mobile = $studentDetails[0]->mobile1;
                    $roll = $studentDetails[0]->applicationnumber;
                    $name = $studentDetails[0]->name;
                    $url = "rb.gy/o0uabr?p=" . $paymentid;
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
                        CURLOPT_POSTFIELDS => '{
                "apiKey": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY0ZDM1YzQ3NTdiNDJkMTA0NzFhNjBlNSIsIm5hbWUiOiJwdXJuYSIsImFwcE5hbWUiOiJBaVNlbnN5IiwiY2xpZW50SWQiOiI2NGQzNWM0NzU3YjQyZDEwNDcxYTYwZTAiLCJhY3RpdmVQbGFuIjoiTk9ORSIsImlhdCI6MTY5MTU3MzMxOX0.4AkHFTfGMUn9AP4q7tDAIHH0C5QUuXcsLfUOOW71AIg",
                "campaignName": "payment_receipt_with_link",
                "destination": "' . $mobile . '",
                "userName": "' . $name . '",
                "templateParams": ["' . $paymentamount . '","' . $roll . '","' . $url . '"]
            }',
                        CURLOPT_HTTPHEADER => array(
                            'Content-Type: application/json'
                        ),
                    ));

                    $response = curl_exec($curl);

                    curl_close($curl);
    }
    
     public function dynamicpayment()
    {
            $unique = $_GET['cc'];
            $db = db_connect();
            $query2 = $db->query("select payment_links.status,invoice from payment_links where payment_links.uniqueid='$unique'");
            $results =$query2->getResult();
           
            $invoice = $results[0]->invoice;
            if( $results[0]->status == "issued")
            {
                header('location: https://maidendropgroup.com/ccavenue/index.php?uniqueid='.$unique.'&invoice='.$invoice);
            }else
            {
                echo 'Already paid';
            }
            
            
    }

    // public function payReservationAmount()
    // {
    //     $amount = $_SESSION['reservationamount'] * 100;
    //     $userid = $_SESSION['userid'];

    //     $api = new Api($this->key, $this->secret);

    //     $orderData = [
    //         'receipt'         => "U" . $userid,
    //         'amount'          => $amount,
    //         'currency'        => 'INR',
    //         'payment_capture' => 1
    //     ];

    //     $razorpayOrder = $api->order->create($orderData);
    //     $razorpayOrderId = $razorpayOrder['id'];
    //     $_SESSION['razorpay_order_id'] = $razorpayOrderId;

    //     $data['data'] = [
    //         "key"               => $this->key,
    //         "amount"            => $amount / 100,
    //         "name"              => "Resonance",
    //         "description"       => "Reservation Amount",
    //         "notes"              => [
    //             "userId"            => $userid
    //         ],
    //         "order_id"          => $razorpayOrderId
    //     ];

    //     return view('loggedoutuser/reservation.php', $data);
    // }

    // public function verifyReservationAmount()
    // {
    //     $success = true;
    //     if (empty($_POST['razorpay_payment_id']) === false) {
    //         $api = new Api($this->key, $this->secret);

    //         try {
    //             $attributes = array(
    //                 'razorpay_order_id' => $_POST['razorpay_order_id'],
    //                 'razorpay_payment_id' => $_POST['razorpay_payment_id'],
    //                 'razorpay_signature' => $_POST['razorpay_signature']
    //             );
    //             $api->utility->verifyPaymentSignature($attributes);
    //         } catch (SignatureVerificationError $e) {
    //             $success = false;
    //         }
    //     }

    //     if ($success === true) {
    //         $paymentamount = $_SESSION['reservationamount'];
    //         $userid = $_SESSION['userid'];
    //         $batchid = $_SESSION['batchid'];

    //         $helperModel = new HelperModel();
    //         $batch = $helperModel->get_batch()->year;
    //         $nextpaymentid = $helperModel->get_paymentidcounter();
    //         $paymentstatusid = 1;

    //         $paymentid = "RMD-" . $batch . "-" . str_pad($nextpaymentid, 6, '0', STR_PAD_LEFT);

    //         $paymentsModel = new PaymentsModel();
    //         $result = $paymentsModel->addPayment($paymentid, $userid, $paymentamount, date("Y-m-d"), 6, $_POST['razorpay_payment_id'], 1, $paymentstatusid, $batchid);

    //         if ($result->resultID) {
    //             $nextpaymentid = $helperModel->set_paymentidcounter();
    //         }

    //         return "<center style='margin-top:15%'><h1>Thank You, Your details had been saved.</h1><h4>You can now close this window.</h4></center>";
    //     }
    // }

    // public function pay()
    // {
    //     return view('loggedoutuser/pay.php');
    // }

    // public function payAmount()
    // {
    //     $api = new Api($this->key, $this->secret);

    //     $name = $_POST['name'];
    //     $email = $_POST['email'];
    //     $number = $_POST['number'];
    //     $amount = $_POST['amount'] * 100;

    //     if($amount == 0)
    //     {
    //         return redirect()->to(base_url('Razorpay/pay'));
    //     }

    //     $orderData = [
    //         'receipt'         => "U",
    //         'amount'          => $amount,
    //         'currency'        => 'INR',
    //         'payment_capture' => 1
    //     ];

    //     $razorpayOrder = $api->order->create($orderData);
    //     $razorpayOrderId = $razorpayOrder['id'];
    //     $_SESSION['razorpay_order_id'] = $razorpayOrderId;

    //     $data['data'] = [
    //         "key"               => $this->key,
    //         "amount"            => $amount / 100,
    //         "name"              => "Resonance",
    //         "description"       => "Resonance Easy Checkout",
    //         "prefill"           => [
    //             "name"              => $name,
    //             "email"             => $email,
    //             "contact"           => $number,
    //         ],
    //         "notes"             => [
    //             "amount"           => $amount / 100
    //         ],
    //         "order_id"          => $razorpayOrderId
    //     ];

    //     return view('loggedoutuser/paynow.php', $data);
    // }

    // public function verifypayAmount()
    // {
    //     $success = true;
    //     if (empty($_POST['razorpay_payment_id']) === false) {
    //         $api = new Api($this->key, $this->secret);

    //         $amount = $_POST['amount'];
    //         try {
    //             $attributes = array(
    //                 'razorpay_order_id' => $_POST['razorpay_order_id'],
    //                 'razorpay_payment_id' => $_POST['razorpay_payment_id'],
    //                 'razorpay_signature' => $_POST['razorpay_signature']
    //             );
    //             $api->utility->verifyPaymentSignature($attributes);
    //         } catch (SignatureVerificationError $e) {
    //             $success = false;
    //         }
    //     }

    //     if ($success === true) {
    //         return "<center style='margin-top:10%'><img src='https://maidendropgroup.com/public/images/logo.png' width='64px' height='64px' /><h4>Congratulations, Your payment of <h1>Rs. {$amount}</h1> is done and your Payment Id is <h1>{$attributes['razorpay_payment_id']}</h1>. Please take screenshot of this picture and send to Resonance to confirm payment. Thank You.</h4></center>";
    //     }
    // }
}
