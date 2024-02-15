<?php

namespace App\Controllers;

use CodeIgniter\Controller;

require '../vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Aws\S3\Exception\S3Exception;
use App\Models\PaymentsModel;
use App\Models\UsersModel;
use App\Models\HelperModel;
use App\Models\EmailModel;
use App\Models\RazorpayModel;
use App\Models\FormsModel;
use App\Models\ReservationModel;

class Payments extends BaseController
{
	public $session;
	public function __construct()
	{
		$session = session();
	}

	public function index()
	{
		if ($_SESSION['userdetails'] == null) {
			return view('loggedoutuser/index.php');
		} else {
			return redirect()->to(base_url('Payments'));
		}
	}

	public function invoice()
	{
		if ($_SESSION['userdetails'] != null) {
			if ($_SESSION != null && count($_SESSION) > 0) {
				$data['page_name'] = 'invoice';

				$helperModel = new HelperModel();
				$data['lookups'] = $helperModel->get_lookups();

				$paymentsModel = new PaymentsModel();
				$data['InvoiceDetails'] = $paymentsModel->getAllInvoiceDetails();

				return view('loggedinuser/index.php', $data);
			} else {
				return redirect()->to(base_url('home'));
			}
		} else {
			return redirect()->to(base_url('Payments'));
		}
	}

	public function payment()
	{
		if ($_SESSION['userdetails'] != null) {
			if ($_SESSION != null && count($_SESSION) > 0) {
				$data['page_name'] = 'payment';

				$helperModel = new HelperModel();
				$data['lookups'] = $helperModel->get_lookups();

				$paymentsModel = new PaymentsModel();
				$data['PaymentDetails'] = $paymentsModel->getAllPaymentDetails();

				$usersModel = new UsersModel();
				$data['EmployeeDetails'] = $usersModel->getAllEmployeeDetails();
				$data['StudentDetails'] = $usersModel->getAllStudentDetails();

				return view('loggedinuser/index.php', $data);
			} else {
				return redirect()->to(base_url('home'));
			}
		} else {
			return redirect()->to(base_url('Payments'));
		}
	}

	public function reservationpayment()
	{
		if ($_SESSION['userdetails'] != null) {
			if ($_SESSION != null && count($_SESSION) > 0) {
				$data['page_name'] = 'reservationpayment';

				$helperModel = new HelperModel();
				$data['lookups'] = $helperModel->get_lookups();


				$reservationModel = new ReservationModel();
				$data['PaymentDetails'] = $reservationModel->getAllReservationPaymentDetails();
				$data['StudentDetails'] = $reservationModel->get_reservations();

				$usersModel = new UsersModel();
				$data['EmployeeDetails'] = $usersModel->getAllEmployeeDetails();

				return view('loggedinuser/index.php', $data);
			} else {
				return redirect()->to(base_url('home'));
			}
		} else {
			return redirect()->to(base_url('Payments'));
		}
	}

	public function getPaymentLinks()
	{
		if ($_SESSION['userdetails'] != null) {
			if ($_SESSION != null && count($_SESSION) > 0) {
				$data['page_name'] = 'Payments/paymentlinks';

				$paymentsModel = new PaymentsModel();
				$paymentLinks = $paymentsModel->getPaymentLinks();
				$data['PaymentLinks'] = $paymentLinks;

				return view('loggedinuser/index.php', $data);
			} else {
				return redirect()->to(base_url('home'));
			}
		} else {
			return redirect()->to(base_url('Payments'));
		}
	}

	public function getLatestPaymentLinkData($PaymentLinks)
	{
		if ($_SESSION['userdetails'] != null) {
			$razorpay = new Razorpay();
			$razorpayModel = new RazorpayModel();
			foreach ($PaymentLinks as $paymentlink) {
				$link = $razorpay->getPaymentLinkById($paymentlink->invoiceid);
				if ($paymentlink->status != $link->status) {
					$razorpayModel->update_payment_status($link->id, $link->status);
					$paymentlink->status = $link->status;
				}
			}
			return $PaymentLinks;
		} else {
			return redirect()->to(base_url('Payments'));
		}
	}

	public function approval()
	{
		if ($_SESSION['userdetails'] != null) {
			if ($_SESSION != null && count($_SESSION) > 0) {
				$data['page_name'] = 'paymentapproval';

				$helperModel = new HelperModel();
				$data['lookups'] = $helperModel->get_lookups();

				$paymentsModel = new PaymentsModel();
				$data['PendingPaymentDetails'] = $paymentsModel->getAllPendingPaymentDetails();

				return view('loggedinuser/index.php', $data);
			} else {
				return redirect()->to(base_url('home'));
			}
		} else {
			return redirect()->to(base_url('Payments'));
		}
	}

	public function formApprovals()
	{
		if ($_SESSION['userdetails'] != null) {
			$data['page_name'] = 'formApproval';

			$paymentsModel = new PaymentsModel();
			$data['PendingPaymentDetails'] = $paymentsModel->getAllPendingPaymentDetails();

			return view('loggedinuser/index.php', $data);
		} else {
			return redirect()->to(base_url('Home'));
		}
	}

	public function addinvoice()
	{
		if ($_SESSION['userdetails'] != null) {
			$returnURL = $_POST['returnURL'];
			$data['userid'] = $_POST['userid'];
			$data['batchid'] = $_SESSION['activebatch'];
			$data['feesid'] = $_POST['feesid'];
			$data['feesvalue'] = $_POST['feesvalue'];
			$data['additionaldetails'] = $_POST['additionaldetails'];

			$paymentmodel = new PaymentsModel();
			$paymentmodel->addInvoice($data);

			return redirect()->to(base_url($returnURL));
		} else {
			return redirect()->to(base_url('Payments'));
		}
	}

	public function editinvoice()
	{
		if ($_SESSION['userdetails'] != null) {
			$returnURL = $_POST['returnURL'];
			$data['userid'] = $_POST['userid'];
			$data['invoiceid'] = $_POST['invoiceid'];
			$data['batchid'] = $_SESSION['activebatch'];
			$data['feesid'] = $_POST['feesid'];
			$data['feesvalue'] = $_POST['feesvalue'];
			$data['discountid'] = $_POST['discountid'];
			$data['additionaldetails'] = $_POST['additionaldetails'];
			$paymentmodel = new PaymentsModel();
			$paymentmodel->addInvoice($data);

			return redirect()->to(base_url($returnURL));
		} else {
			return redirect()->to(base_url('Payments'));
		}
	}

	public function addpayment()
	{
		if ($_SESSION['userdetails'] != null) {
			$returnURL = $_POST['returnURL'];
			$userid = $_POST['userid'];
			$paymenttypeid = $_POST['paymenttypeid'];
			$paymentamount = $_POST['paymentamount'];
			// $paymentdate = date_create_from_format("d/m/Y", $_POST['paymentdate']) != false ? date_format(date_create_from_format("d/m/Y", $_POST['paymentdate']), 'Y-m-d') : date('Y-m-d');
			$paymentdate = date('Y-m-d');
			$otherdetails = $_POST['otherdetails'];
			$remarks = $_POST['remarks'];

			$paymentcollectedby = $_SESSION['userdetails']->userid;
			$paymentstatusid = 1;

			$helperModel = new HelperModel();
			$batch = $helperModel->get_batch()->year;
			$nextpaymentid = $helperModel->get_paymentidcounter();

			$paymentid = "RMD-" . $batch . "-" . str_pad($nextpaymentid, 6, '0', STR_PAD_LEFT);

			$paymentsModel = new PaymentsModel();
			$result = $paymentsModel->addPayment($paymentid, $userid, $paymentamount, $paymentdate, $paymenttypeid, $otherdetails, $paymentcollectedby, $paymentstatusid, 0, $remarks);

			if ($result->resultID) {
				$nextpaymentid = $helperModel->set_paymentidcounter();
			}

			$html = file_get_contents(base_url("payments/print_receipt?paymentid={$paymentid}&batchid={$_SESSION['activebatch']}"));
			$paymentsModel->htmltopdf($html, 'save', $paymentid, 'R');

			$usersModel = new UsersModel();
			$studentDetails = $usersModel->getStudentDetails($userid, $_SESSION['activebatch']);

			$comm = new Comm();
			$data[0] = $studentDetails[0]->mobile1;
			$data[1] = $paymentamount;
			$data[2] = $studentDetails[0]->applicationnumber;
			// $data[3] = base_url("receipt_files/{$paymentid}.pdf");
			$data[3] = "rb.gy/o0uabr?p=" . $paymentid;

			$comm->sendSMS("PaymentConfirm", $data);
			$mobile = $studentDetails[0]->mobile1;
			$roll = $studentDetails[0]->applicationnumber;
			$name = $studentDetails[0]->name;
			$url = "rb.gy/o0uabr?p=" . $paymentid;
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
                "campaignName": "payment_receipt_with_link",
                "destination": "'.$mobile.'",
                "userName": "'.$name.'",
                "templateParams": ["'.$paymentamount.'","'.$roll.'","'.$url.'"]
            }',
              CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
              ),
            ));
            
            $response = curl_exec($curl);
            
            curl_close($curl);

			return redirect()->to(base_url($returnURL));
		} else {
			return redirect()->to(base_url('Payments'));
		}
	}
	
	public function addpaymentNew()
	{
		if (isset($_SESSION['userdetails'])) {
			$returnURL = $_POST['returnURL'];
			$userid = $_POST['userid'];
			$paymenttypeid = $_POST['paymenttypeid'];
			$paymentamount = $_POST['paymentamount'];
			// $paymentdate = date_create_from_format("d/m/Y", $_POST['paymentdate']) != false ? date_format(date_create_from_format("d/m/Y", $_POST['paymentdate']), 'Y-m-d') : date('Y-m-d');
			$paymentdate = date('Y-m-d');
			$otherdetails = $_POST['otherdetails'];
			$remarks = $_POST['remarks'];
			$invoice = $_POST['invoiceid'];

			$paymentcollectedby = $_SESSION['userdetails']->userid;
			$paymentstatusid = 1;

			$helperModel = new HelperModel();
			$batch = $helperModel->get_batch()->year;
			$nextpaymentid = $helperModel->get_paymentidcounter();

			$paymentid = "RMD-" . $batch . "-" . str_pad($nextpaymentid, 6, '0', STR_PAD_LEFT);
            $createddate = date('Y-m-d H:i:s');
			$paymentsModel = new PaymentsModel();
			$result = $paymentsModel->addPaymentNew($paymentid, $userid,$invoice, $paymentamount, $paymentdate, $paymenttypeid, $otherdetails, $paymentcollectedby, $paymentstatusid, 0, $remarks,$createddate);

		
				$nextpaymentid = $helperModel->set_paymentidcounter();
			

			$html = file_get_contents(base_url("payments/print_receipt?paymentid={$paymentid}&batchid={$_SESSION['activebatch']}"));
			$paymentsModel->htmltopdf($html, 'save', $paymentid, 'R');

			$usersModel = new UsersModel();
			$studentDetails = $usersModel->getStudentDetails($userid, $_SESSION['activebatch']);

			$comm = new Comm();
			$data[0] = $studentDetails[0]->mobile1;
			$data[1] = $paymentamount;
			$data[2] = 
			$name = $studentDetails[0]->applicationnumber;;
			// $data[3] = base_url("receipt_files/{$paymentid}.pdf");
			$data[3] = "rb.gy/o0uabr?p=" . $paymentid;

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
              CURLOPT_POSTFIELDS =>'{
                "apiKey": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY0ZDM1YzQ3NTdiNDJkMTA0NzFhNjBlNSIsIm5hbWUiOiJwdXJuYSIsImFwcE5hbWUiOiJBaVNlbnN5IiwiY2xpZW50SWQiOiI2NGQzNWM0NzU3YjQyZDEwNDcxYTYwZTAiLCJhY3RpdmVQbGFuIjoiTk9ORSIsImlhdCI6MTY5MTU3MzMxOX0.4AkHFTfGMUn9AP4q7tDAIHH0C5QUuXcsLfUOOW71AIg",
                "campaignName": "payment_receipt_with_link",
                "destination": "'.$mobile.'",
                "userName": "'.$name.'",
                "templateParams": ["'.$paymentamount.'","'.$roll.'","'.$url.'"]
            }',
              CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
              ),
            ));
            
            $response = curl_exec($curl);
            
            curl_close($curl);

			return redirect()->to(base_url($returnURL));
		} else {
			return redirect()->to(base_url('Payments'));
		}
	}

	public function addReservationPayment()
	{
		if ($_SESSION['userdetails'] != null) {
			$reservationid = $_POST['reservationid'];

			$paymenttypeid = $_POST['paymenttypeid'];
			$paymentamount = $_POST['paymentamount'];

			$returnURL = isset($_POST['returnURL']) ? $_POST['returnURL'] : "";

			// $paymentdate = date_create_from_format("d/m/Y", $_POST['paymentdate']) != false ? date_format(date_create_from_format("d/m/Y", $_POST['paymentdate']), 'Y-m-d') : date('Y-m-d');
			$paymentdate = date('Y-m-d');
			$otherdetails = $_POST['otherdetails'];
			$remarks = $_POST['remarks'];

			$paymentcollectedby = $_SESSION['userdetails']->userid;
			$paymentstatusid = 1;

			$helperModel = new HelperModel();
			$batch = $helperModel->get_batch()->year;
			$nextpaymentid = $helperModel->get_paymentidcounter();

			$reservation_paymentid = "RMD-" . $batch . "-" . str_pad($nextpaymentid, 6, '0', STR_PAD_LEFT);

			$reservationModel = new ReservationModel();

			$result = $reservationModel->addReservationPayment(
				$reservation_paymentid,
				$reservationid,
				$paymentamount,
				$paymentdate,
				$paymenttypeid,
				$otherdetails,
				$paymentcollectedby,
				$paymentstatusid,
				0,
				$remarks
			);

			if ($result->resultID) {
				$nextpaymentid = $helperModel->set_paymentidcounter();

				$html = file_get_contents(base_url("payments/print_reservationreceipt?reservationpaymentid={$reservation_paymentid}&batchid={$_SESSION['activebatch']}"));

				$paymentsModel = new PaymentsModel();
				$paymentsModel->htmltopdf($html, 'save', $reservation_paymentid, 'RP');
			}
             $studentDetails = $reservationModel->getReservationDetails($reservationid);
            $comm = new Comm();
			$data[0] = $studentDetails->mobile1;
			$data[1] = $paymentamount;
			$data[2] = $studentDetails->reservation_ukey;
			// $data[3] = base_url("receipt_files/{$paymentid}.pdf");
			$data[3] = "rb.gy/o0uabr?p=" . $reservation_paymentid;

			$comm->sendSMS("PaymentConfirm", $data);
			return redirect()->to(base_url($returnURL));

			// $usersModel = new UsersModel();
			// $studentDetails = $usersModel->getStudentDetails($userid, $_SESSION['activebatch']);

			// $comm = new Comm();
			// $data[0] = $studentDetails[0]->mobile1;
			// $data[1] = $paymentamount;
			// $data[2] = $studentDetails[0]->applicationnumber;
			// // $data[3] = base_url("receipt_files/{$paymentid}.pdf");
			// $data[3] = "rb.gy/o0uabr?p=" . $paymentid;

			// $comm->sendSMS("PaymentConfirm", $data);

			// return redirect()->to(base_url($returnURL));
		} else {
			return redirect()->to(base_url('Payments'));
		}
	}

	public function updatepayment()
	{
		if ($_SESSION['userdetails'] != null) {
			$returnURL = $_POST['returnURL'];
			$paymentid = $_POST['paymentid'];
			$paymenttypeid = $_POST['paymenttypeid'];
			// $paymentamount = $_POST['paymentamount'];
			// $paymentdate = date_create_from_format("d/m/Y", $_POST['paymentdate']) != false ? date_format(date_create_from_format("d/m/Y", $_POST['paymentdate']), 'Y-m-d') : date('Y-m-d');
			$paymentdate = date('Y-m-d');
			$otherdetails = $_POST['otherdetails'];
			$remarks = $_POST['remarks'];

			$paymentsModel = new PaymentsModel();
			// $result = $paymentsModel->updatePayment($paymentid, $paymentamount, $paymentdate, $paymenttypeid, $otherdetails, $remarks);
			$result = $paymentsModel->updatePayment($paymentid, $paymentdate, $paymenttypeid, $otherdetails, $remarks);

			return redirect()->to(base_url($returnURL));
		} else {
			return redirect()->to(base_url('Payments'));
		}
	}
	
	public function updatereservationpayment()
	{
		if ($_SESSION['userdetails'] != null) {
			$returnURL = $_POST['returnURL'];
			$paymentid = $_POST['paymentid'];
			$paymenttypeid = $_POST['paymenttypeid'];
			 $paymentamount = $_POST['paymentamount'];
			 $paymentdate = date_create_from_format("d/m/Y", $_POST['paymentdate']) != false ? date_format(date_create_from_format("d/m/Y", $_POST['paymentdate']), 'Y-m-d') : date('Y-m-d');
		//	$paymentdate = date('Y-m-d');
			$otherdetails = $_POST['otherdetails'];
			$remarks = $_POST['remarks'];

			$paymentsModel = new PaymentsModel();
			// $result = $paymentsModel->updatePayment($paymentid, $paymentamount, $paymentdate, $paymenttypeid, $otherdetails, $remarks);
			$result = $paymentsModel->updateReservationPayment($paymentid,$paymentamount, $paymentdate, $paymenttypeid, $otherdetails, $remarks);

			return redirect()->to(base_url($returnURL));
		} else {
			return redirect()->to(base_url('Payments'));
		}
	}

	public function deletepayment()
	{
		if ($_SESSION['userdetails'] != null) {
			$paymentid = $_GET['paymentid'];

			$paymentsModel = new PaymentsModel();
			$paymentsModel->deletepayment($paymentid);

			return redirect()->to(base_url('Payments/payment'));
		} else {
			return redirect()->to(base_url('Payments/payment'));
		}
	}
	public function deletereservationpayment()
	{
		if ($_SESSION['userdetails'] != null) {
			$paymentid = $_GET['paymentid'];
			$reservationid = $_GET['reservationid'];
			$paymentsModel = new PaymentsModel();
			$paymentsModel->deletereservationpayment($paymentid);

			return redirect()->to(base_url("users/reservationDetails?id={$reservationid}"));
		} else {
			return redirect()->to(base_url('home'));
		}
	}


	public function paymentapprovalflow()
	{
		if ($_SESSION['userdetails'] != null) {
			$type = isset($_POST['approvepayment']) ? "Approve" : "Decline";
			$userid = $_POST['userid'];

			$paymentmodel = new PaymentsModel();

			if ($type == "Approve") {
				$paymentid = $_POST['paymentid'];
				$paymentstatusid = 3;

				$paymentmodel->approvePayment($paymentid, $paymentstatusid);

				$html = file_get_contents(base_url("payments/print_receipt?paymentid={$paymentid}&batchid={$_SESSION['activebatch']}"));
				$paymentmodel->htmltopdf($html, 'save', $paymentid, 'R');
			} elseif ($type == "Decline") {
				$paymentid = $_POST['paymentid'];
				$paymentstatusid = 2;

				$paymentmodel->declinePayment($paymentid, $paymentstatusid);

				$usersModel = new UsersModel();
				$studentDetails = $usersModel->getStudentDetails($userid, $_SESSION['activebatch']);

				$comm = new Comm();
				$data[0] = $studentDetails[0]->mobile1;
				$data[1] = $paymentid;
				$data[2] = $studentDetails[0]->name;
				$comm->sendSMS("PaymentDecline", $data);
			}
		} else {
			return redirect()->to(base_url('Payments'));
		}
	}

	public function reservationpaymentapprovalflow()
	{
		if ($_SESSION['userdetails'] != null) {
			$type = isset($_POST['approvepayment']) ? "Approve" : "Decline";
			$reservationid = $_POST['reservationid'];

			$paymentmodel = new PaymentsModel();

			if ($type == "Approve") {
				$reservation_paymentid = $_POST['reservation_paymentid'];
				$paymentstatusid = 3;

				$paymentmodel->approveReservationPayment($reservation_paymentid, $paymentstatusid);

				$html = file_get_contents(base_url("payments/print_reservationreceipt?reservationpaymentid={$reservation_paymentid}&batchid={$_SESSION['activebatch']}"));
				$paymentmodel->htmltopdf($html, 'save', $reservation_paymentid, 'RP');
			} elseif ($type == "Decline") {
				$reservation_paymentid = $_POST['reservation_paymentid'];
				$paymentstatusid = 2;

				$paymentmodel->declineReservationPayment($reservation_paymentid, $paymentstatusid);

				$reservationModel = new ReservationModel();
				$studentDetails = $reservationModel->getReservationDetails($reservationid, $_SESSION['activebatch']);

				$comm = new Comm();
				$data[0] = $studentDetails->mobile1;
				$data[1] = $reservation_paymentid;
				$data[2] = $studentDetails->name;
				$comm->sendSMS("PaymentDecline", $data);
			}
		} else {
			return redirect()->to(base_url('Payments'));
		}
	}

	public function print_invoice()
	{
		$invoiceid = $_GET['invoiceid'];
		$batchid = $_GET['batchid'];

		$paymentsModel = new PaymentsModel();
		$data['InvoiceDetails'] = $paymentsModel->getInvoiceDetailsByInvoiceId($invoiceid, $batchid);
		if (count($data['InvoiceDetails']) > 0) {
			$data['PaymentDetails'] = $paymentsModel->getPaymentDetailsByUserId($data['InvoiceDetails'][0]->userid, $batchid);
		}

		return view('loggedinuser/Print/print_invoice.php', $data);
	}

	public function print_receipt()
	{
		$paymentid = $_GET['paymentid'];
		$batchid = $_GET['batchid'];

		$paymentsModel = new PaymentsModel();
		$data['payment'] = $paymentsModel->getPaymentDetailsByPaymentId($paymentid);
		if ($data['payment'] != null) {
			$usersModel = new UsersModel();
			$data['userDetails'] = $usersModel->getStudentDetails($data['payment']->userid, $batchid);
		}

		return view('loggedinuser/Print/print_receipt.php', $data);
	}
	
	public function print_applicationreceipt()
	{
		$paymentid = $_GET['paymentid'];
		$batchid = $_GET['batchid'];
    
		$paymentsModel = new PaymentsModel();
		$data['payment'] = $paymentsModel->getapplicationPaymentDetailsByPaymentId($paymentid);
		
		if ($data['payment'] != null) {
			$usersModel = new UsersModel();
			$data['userDetails'] = $usersModel->getApplicationDetails($data['payment']->userid);
		}
	
        
		return view('loggedinuser/Print/print_applicationreceipt.php', $data);
	}
	
	public function print_applicationdiscountreceipt()
	{
		$userid = $_GET['userid'];
		$batchid = $_GET['batchid'];
		$paymentsModel = new PaymentsModel();
		$usersModel = new UsersModel();
	//	$data['payment'] = $paymentsModel->getapplicationPaymentDetailsByPaymentId($paymentid);
	    $data['EmployeeDetails'] = $usersModel->getAllEmployeeDetails();
		$usersModel = new UsersModel();
		$data['userDetails'] = $usersModel->getApplicationDetails($userid);
		return view('loggedinuser/Print/print_applicationdiscountreceipt.php', $data);
	}
	
	public function print_application()
	{
		$userid = $_GET['userid'];
		$batchid = $_GET['batchid'];
        $helperModel = new HelperModel();
        $data['lookups'] = $helperModel->get_lookups();
        $usersModel = new UsersModel();
        $data['EmployeeDetails'] = $usersModel->getAllEmployeeDetails();
		$paymentsModel = new PaymentsModel();
	//	$data['payment'] = $paymentsModel->getapplicationPaymentDetailsByPaymentId($paymentid);
		$data['userDetails'] = $usersModel->getApplicationDetails($userid);
		return view('loggedinuser/Print/print_application.php', $data);
	}
	public function print_outpass()
	{
	    $formgroupid =   $_GET['formgroupid'];
	    $formsModel = new FormsModel();
        $data['forms'] = $formsModel->getPendingOutpassForm($formgroupid);
        return view('loggedinuser/Print/print_bulkoutpass.php', $data);
	}
	
	public function printapp()
	{
	    $userid = $_GET['userid'];
		$batchid = $_GET['batchid'];
		$reservationModel = new ReservationModel();
		$StudentDetailS = $reservationModel->getApplicationDetails($userid);
        $html = file_get_contents(base_url("payments/print_application?userid={$userid}&batchid=3"));
        $paymentsModel = new PaymentsModel();
        $filename = $StudentDetailS->application_ukey.'-'.$StudentDetailS->name;
	    $paymentsModel->htmltopdf($html, 'save', $filename, 'R');
	    return redirect()->to(base_url("receipt_files/{$filename}.pdf"));
	}
	
	public function printbulkoutpass()
	{
	    $formgroupid = $_GET['formgroupid'];
        $html = file_get_contents(base_url("payments/print_outpass?formgroupid={$formgroupid}"));
        $paymentsModel = new PaymentsModel();
        $filename = $formgroupid;
	    $paymentsModel->htmltopdfnew($html, 'save', $filename, 'R');
	    return redirect()->to(base_url("receipt_files/{$filename}.pdf"));
	}
	
	public function printdis()
	{
	    $userid = $_GET['userid'];
		$batchid = $_GET['batchid'];
		$reservationModel = new ReservationModel();
		$StudentDetailS = $reservationModel->getApplicationDetails($userid);
        $html = file_get_contents(base_url("payments/print_applicationdiscountreceipt?userid={$userid}&batchid=3"));
        $paymentsModel = new PaymentsModel();
        $filename = $StudentDetailS->application_ukey.'-'.$userid;
	    $paymentsModel->htmltopdf($html, 'save', $filename, 'R');
	    return redirect()->to(base_url("receipt_files/{$filename}.pdf"));
	}
	public function print_reservationdiscountreceipt()
	{
	    $reservationpaymentid = $_GET['reservationpaymentid'];
	    $paymentid = $_GET['paymentid'];
	    $voucherid = $_GET['voucherid'];
	    $batchid = $_GET['batchid'];
		$reservationModel = new ReservationModel();
		if(!empty($reservationpaymentid)){
		$data['payment'] = $reservationModel->getReservationPaymentDiscountDetailsByReservationPaymentId($reservationpaymentid,$voucherid,$batchid);
		}
		if(!empty($paymentid)){
		$data['payment'] = $reservationModel->getStudentPaymentDiscountDetailsByPaymentId($paymentid,$voucherid,$batchid);
		}
		return view('loggedinuser/Print/print_reservationdiscountreceipt.php', $data);
	}
	public function print_reservationreceipt()
	{
		$reservationpaymentid = $_GET['reservationpaymentid'];
		$reservationModel = new ReservationModel();
		$data['payment'] = $reservationModel->getReservationPaymentDetailsByReservationPaymentId($reservationpaymentid);
		return view('loggedinuser/Print/print_reservationreceipt.php', $data);
	}
	public function generateinvoice()
	{
		if ($_SESSION['userdetails'] != null) {
			if ($_SESSION['userdetails'] != null) {
				$invoiceid = $_GET['invoiceid'];
				$type = $_GET['type'];
				$html = file_get_contents(base_url("payments/print_invoice?invoiceid={$invoiceid}&batchid={$_SESSION['activebatch']}"));
				$paymentsmodel = new PaymentsModel();
				$paymentsmodel->htmltopdf($html, $type, $invoiceid, 'I');
				if ($type == 'view') {
					return redirect()->to(base_url("invoices_files/" . $invoiceid . ".pdf"));
				}
			}
		} else {
			return redirect()->to(base_url('Payments'));
		}
	}
	public function generatereceipt()
	{
		if ($_SESSION['userdetails'] != null) {
			$paymentid = $_GET['paymentid'];
			$type = $_GET['type'];
			$html = file_get_contents(base_url("payments/print_receipt?paymentid={$paymentid}&batchid={$_SESSION['activebatch']}"));
			$paymentsmodel = new PaymentsModel();
			$paymentsmodel->htmltopdf($html, $type, $paymentid, 'R');
			if ($type == 'view') {
				return redirect()->to(base_url("receipt_files/" . $paymentid . ".pdf"));
			}
		} else {
			return redirect()->to(base_url('Payments'));
		}
	}
	public function reservationPaymentapproval()
	{
		if ($_SESSION['userdetails'] != null) {
			if ($_SESSION != null && count($_SESSION) > 0) {
				$data['page_name'] = 'reservationpaymentapproval';
				$helperModel = new HelperModel();
				$data['lookups'] = $helperModel->get_lookups();
				$reservationModel = new ReservationModel();
				$data['PendingPaymentDetails'] = $reservationModel->getReservationPendingPaymentDetails();
				return view('loggedinuser/index.php', $data);
			} else {
				return redirect()->to(base_url('home'));
			}
		} else {
			return redirect()->to(base_url('Payments'));
		}
	}
	public function generatereservationreceipt()
	{
		if ($_SESSION['userdetails'] != null) {
			$reservationpaymentid = $_GET['reservationpaymentid'];
			$type = $_GET['type'];
			$html = file_get_contents(base_url("payments/print_reservationreceipt?reservationpaymentid={$reservationpaymentid}&batchid={$_SESSION['activebatch']}"));
			$paymentsmodel = new PaymentsModel();
			$paymentsmodel->htmltopdf($html, $type, $reservationpaymentid, 'RP');
			if ($type == 'view') {
				return redirect()->to(base_url("reservation_files/" . $reservationpaymentid . ".pdf"));
			}
		} else {
			return redirect()->to(base_url('Payments'));
		}
	}
	public function sendInvoiceReceiptEmail()
	{
		if ($_SESSION['userdetails'] != null) {
			$paymentsmodel = new PaymentsModel();
			if ($_GET['invoiceid']){
				$invoiceid = $_GET['invoiceid'];
				$userid = $_GET['userid'];
				$html = file_get_contents(base_url("payments/print_invoice?invoiceid={$invoiceid}&batchid={$_SESSION['activebatch']}"));
				$paymentsmodel->htmltopdf($html, 'save', $invoiceid, 'I');
				$emailmodel = new EmailModel();
				$emailmodel->sendInvoiceEmail($userid, $invoiceid);
			}
			if ($_GET['paymentid']) {
				$paymentid = $_GET['paymentid'];
				$userid = $_GET['userid'];
				$html = file_get_contents(base_url("payments/print_receipt?paymentid={$paymentid}&batchid={$_SESSION['activebatch']}"));
				$paymentsmodel->htmltopdf($html, 'save', $paymentid, 'R');
				$emailmodel = new EmailModel();
				$emailmodel->sendReceiptEmail($userid, $paymentid);
			}
		} else {
			return redirect()->to(base_url('Payments'));
		}
	}
	public function generatePaymentReceiptFromResonanceHyderabad($userid, $batchid, $paymentid)
	{
		$html = file_get_contents(base_url("payments/print_receipt?paymentid={$paymentid}&batchid={$batchid}"));
		$paymentsmodel = new PaymentsModel();
		$paymentsmodel->htmltopdf($html, 'save', $paymentid, 'R');
		$usersModel = new UsersModel();
		$studentDetails = $usersModel->getStudentDetails($userid, $batchid);
		$paymentDetails = $paymentsmodel->getPaymentDetailsByPaymentId($paymentid);
		$comm = new Comm();
		$data[0] = $studentDetails[0]->mobile1;
		$data[1] = $paymentDetails->paymentamount;
		$data[2] = $studentDetails[0]->applicationnumber;
		// $data[3] = base_url("receipt_files/{$paymentid}.pdf");
		$data[3] = "rb.gy/o0uabr?p=" . $paymentid;
		$comm->sendSMS("PaymentConfirm", $data);
	}
	public function test()
	{
		$comm = new Comm();
		$data[0] = "9912465651";
		$data[1] = "1.23";
		$data[2] = "MD20000";
		// $data[3] = base_url("receipt_files/{$paymentid}.pdf");
		$data[3] = "rb.gy/o0uabr?p=" . "RMD-2022-000002";
		var_dump($data);
		$comm->sendSMS("PaymentConfirm", $data);
	}
	public function newpayments()
	{
	    exit();
	    	$db = db_connect();
	   // exit();
// 		$db = db_connect();
// 		$query1 = $db->query("SELECT invoices.userid,invoices.feesid,invoices.batchid,invoices.invoiceid,invoices.feesvalue,feestructurelookup.feetype from invoices join feestructurelookup on invoices.feesid=feestructurelookup.feesid where invoices.batchid=3 and invoices.userid=12001");
// 		$invoice = $query1->getResult();
// 		foreach ($invoice as $row) {
// 			if ($row->feetype == 'Tuition Fee') {
// 				$user_id = $row->userid;
// 				echo $user_id;
// 			echo "<br>";
// 				$querycount = $db->query("SELECT count(*) as count from student_class_relation where studentid=$user_id");
// 				$querycounts = $querycount->getResult();
// 				if ($querycounts[0]->count == 1) {
// 					$invoicevalue = 2500;
// 					$value = $row->feesvalue - $invoicevalue;
// 					$query1 = $db->query("update invoices set feesvalue = {$value} where invoiceid = '$row->invoiceid' and feesid='$row->feesid'");
// 					$helpermodel = new HelperModel();
// 					$newInvoiceId = $helpermodel->get_nextInvoiceId($row->userid);
// 					$newInvoiceId =  substr($row->invoiceid, 0, -1) . $newInvoiceId;
// 					$db->query("INSERT INTO `invoices`(`invoiceid`, `userid`, `invoice`, `feesid`, `sub_id`, `feesvalue`, `batchid`, `discountid`, `additionaldetails`)  VALUES ('{$newInvoiceId}','{$row->userid}','1',328,'0','{$invoicevalue}','{$row->batchid}',NULL,NULL)");
// 				}
// 			}
// 		}
// exit();
		$query1 = $db->query("SELECT userid from studentdetails join student_class_relation on studentdetails.userid =student_class_relation.studentid where student_class_relation.batchid=3 and studentdetails.userid=12001");
		$query1 = $query1->getResult();
		foreach ($query1 as $row) {
			$user_id = $row->userid;
			
			$querycount = $db->query("SELECT count(*) as count from student_class_relation where studentid=$user_id");
			$querycounts = $querycount->getResult();
			
			if ($querycounts[0]->count == 1) {
				$query11 = $db->query("SELECT invoices.invoiceid from invoices where invoices.batchid=3 and invoices.userid=$user_id");
				$invoice11 = $query11->getResult();
				if(!empty($invoice11)){
				$application_fee = 2500;
				$helpermodel = new HelperModel();
				$newInvoiceId = $helpermodel->get_nextInvoiceId1($row->userid);
				$newInvoiceId =  substr($invoice11[0]->invoiceid, 0, -1) . $newInvoiceId;
				}else
				{
					$application_fee = 0;
				}
			} else {
				$application_fee = 0;
			}
			$query1 = $db->query("SELECT * from payments where payments.userid=$user_id and payments.batchid=3 and payments.paymenttypeid <> 8");
			$payments = $query1->getResult();
			
			$query1 = $db->query("SELECT sum(invoices.feesvalue) as amount,invoiceid from invoices join feestructurelookup on invoices.feesid=feestructurelookup.feesid where invoices.userid=$user_id and invoices.batchid=3 and invoices.invoice=1 and invoices.feesid <> 328 group by invoices.invoiceid ");
			$invoice1 = $query1->getResult();

			$query1 = $db->query("SELECT sum(invoices.feesvalue) as amount,invoiceid from invoices join feestructurelookup on invoices.feesid=feestructurelookup.feesid where invoices.userid=$user_id and invoices.batchid=3 and invoices.invoice=2 group by invoices.invoiceid ");
			$invoice2 = $query1->getResult();
			$query1 = $db->query("SELECT invoices.feesvalue as amount,invoiceid from invoices join feestructurelookup on invoices.feesid=feestructurelookup.feesid where invoices.userid=$user_id and invoices.batchid=3 and invoices.feesid = 328");
			$applicationfee1 = $query1->getResult();
			if(!empty($invoice1)){
			$first_invoice_min_amount = 10000;
			$first_invoice_value = $invoice1[0]->amount - 10000;
			}else{
				$first_invoice_min_amount = 0;
			$first_invoice_value = 0;
			}
			if(!empty($invoice2)){
			$second_invoice_value = $invoice2[0]->amount;
			}else
			{
				$second_invoice_value = 0;
			}
			foreach ($payments as $payment) {
				$payids = 1;
				if ($payment->paymentamount >= $application_fee && $application_fee != 0 && $first_invoice_min_amount !=0) {
					$remainign_old_payment = $payment->paymentamount - $application_fee; //10100
					$payid = $payment->paymentid;
					$pay_id = $payid . '-' . $payids++;
					if ($remainign_old_payment == 0) {
						$db->query("UPDATE `payments` SET invoice='{$newInvoiceId}' where paymentid='{$payid}'");
						$application_fee = 0;
					} else {
						$db->query("INSERT INTO `payments`(`paymentid`, `userid`, `invoice`, `paymentamount`, `paymentdate`, `paymenttypeid`, `otherdetails`, `remarks`, `paymentcollectedby`, `paymentstatusid`, `batchid`, `updated_by`, `approved_by`, `createddate`) VALUES('{$pay_id}','{$payment->userid}','$newInvoiceId',$application_fee,'$payment->paymentdate','{$payment->paymenttypeid}','{$payment->otherdetails}','{$payment->remarks}','{$payment->paymentcollectedby}','{$payment->paymentstatusid}','$payment->batchid','$payment->updated_by','{$payment->approved_by}','{$payment->createddate}')");
						$application_fee = 0;
						if ($remainign_old_payment >= $first_invoice_min_amount) {
							$db->query("UPDATE `payments` SET paymentamount = {$remainign_old_payment},invoice='{$invoice1[0]->invoiceid}' where paymentid='{$payid}'");

							$firs_invoice_remainign_amont = $remainign_old_payment - $first_invoice_min_amount;

							if ($first_invoice_min_amount > 0) {

								if ($firs_invoice_remainign_amont <= 0) {
									$first_invoice_min_amount = $remainign_old_payment - $first_invoice_min_amount;
								} else {
									$pay_id = $payid . '-' . $payids++;
									$db->query("INSERT INTO `payments`(`paymentid`, `userid`, `invoice`, `paymentamount`, `paymentdate`, `paymenttypeid`, `otherdetails`, `remarks`, `paymentcollectedby`, `paymentstatusid`, `batchid`, `updated_by`, `approved_by`, `createddate`) VALUES('{$pay_id}','{$payment->userid}','{$invoice1[0]->invoiceid}',$first_invoice_min_amount,'$payment->paymentdate','{$payment->paymenttypeid}','{$payment->otherdetails}','{$payment->remarks}','{$payment->paymentcollectedby}','{$payment->paymentstatusid}','$payment->batchid','$payment->updated_by','{$payment->approved_by}','{$payment->createddate}')");

									$first_invoice_min_amount = 0;
									$second_invoice_value1 = $second_invoice_value - $firs_invoice_remainign_amont;

									if ($second_invoice_value1 >= 0) {
										$db->query("UPDATE `payments` SET paymentamount = {$firs_invoice_remainign_amont},invoice='{$invoice2[0]->invoiceid}' where paymentid='{$payid}'");
										$second_invoice_value = $second_invoice_value - $firs_invoice_remainign_amont;
									} else {
										$pay_id = $payid . '-' . $payids++;

										$db->query("INSERT INTO `payments`(`paymentid`, `userid`, `invoice`, `paymentamount`, `paymentdate`, `paymenttypeid`, `otherdetails`, `remarks`, `paymentcollectedby`, `paymentstatusid`, `batchid`, `updated_by`, `approved_by`, `createddate`) VALUES('{$pay_id}','{$payment->userid}','{$invoice2[0]->invoiceid}',$second_invoice_value,'$payment->paymentdate','{$payment->paymenttypeid}','{$payment->otherdetails}','{$payment->remarks}','{$payment->paymentcollectedby}','{$payment->paymentstatusid}','$payment->batchid','$payment->updated_by','{$payment->approved_by}','{$payment->createddate}')");
										$second_invoice_value1 = -$second_invoice_value1;
										$db->query("UPDATE `payments` SET paymentamount = {$second_invoice_value1},invoice='{$invoice1[0]->invoiceid}' where paymentid='{$payid}'");
										$second_invoice_value = 0;
									}
								}
							} else {
							}
						} else {
							$amount = $payment->paymentamount;
							//$db->query("UPDATE `payments` SET invoice='{$invoice1[0]->invoiceid}' where paymentid='{$payment->paymentid}'");
							$db->query("UPDATE `payments` SET paymentamount = {$remainign_old_payment},invoice='{$invoice1[0]->invoiceid}' where paymentid='{$payid}'");
							$first_invoice_min_amount = $first_invoice_min_amount - $remainign_old_payment;
						}
					}
				} elseif ($payment->paymentamount < $application_fee && $application_fee != 0) {
					//update payment
					$db->query("UPDATE `payments` SET invoice='{$newInvoiceId}' where paymentid='{$payment->paymentid}'");
					$application_fee = $application_fee - $payment->paymentamount;
				} elseif ($payment->paymentamount >= $first_invoice_min_amount && $first_invoice_min_amount != 0) {
					$payid = $payment->paymentid;
					$pay_id = $payid . '-' . $payids++;
					$db->query("INSERT INTO `payments`(`paymentid`, `userid`, `invoice`, `paymentamount`, `paymentdate`, `paymenttypeid`, `otherdetails`, `remarks`, `paymentcollectedby`, `paymentstatusid`, `batchid`, `updated_by`, `approved_by`, `createddate`) VALUES('{$pay_id}','{$payment->userid}','{$invoice1[0]->invoiceid}',$first_invoice_min_amount,'$payment->paymentdate','{$payment->paymenttypeid}','{$payment->otherdetails}','{$payment->remarks}','{$payment->paymentcollectedby}','{$payment->paymentstatusid}','$payment->batchid','$payment->updated_by','{$payment->approved_by}','{$payment->createddate}')");
					$amount = $payment->paymentamount - $first_invoice_min_amount;
					$first_invoice_min_amount = 0;
					if ($amount > $second_invoice_value) {
						$pay_id = $payid . '-' . $payids++;
						$db->query("INSERT INTO `payments`(`paymentid`, `userid`, `invoice`, `paymentamount`, `paymentdate`, `paymenttypeid`, `otherdetails`, `remarks`, `paymentcollectedby`, `paymentstatusid`, `batchid`, `updated_by`, `approved_by`, `createddate`) VALUES('{$pay_id}','{$payment->userid}','{$invoice2[0]->invoiceid}',$second_invoice_value,'$payment->paymentdate','{$payment->paymenttypeid}','{$payment->otherdetails}','{$payment->remarks}','{$payment->paymentcollectedby}','{$payment->paymentstatusid}','$payment->batchid','$payment->updated_by','{$payment->approved_by}','{$payment->createddate}')");
						$amount = $amount - $second_invoice_value;
						$db->query("UPDATE `payments` SET paymentamount = {$amount},invoice='{$invoice1[0]->invoiceid}' where paymentid='{$payment->paymentid}'");
						$second_invoice_value = 0;
					} else {
						$db->query("UPDATE `payments` SET  paymentamount = {$amount},invoice='{$invoice2[0]->invoiceid}' where paymentid='{$payment->paymentid}'");
						$second_invoice_value = $second_invoice_value - $amount;
					}
				} elseif ($payment->paymentamount < $first_invoice_min_amount && $first_invoice_min_amount != 0) {
					$db->query("UPDATE `payments` SET invoice='{$invoice1[0]->invoiceid}' where paymentid='{$payment->paymentid}'");
					$first_invoice_min_amount = $first_invoice_min_amount - $payment->paymentamount;
				} else {
					if ($first_invoice_min_amount > 0) {
						echo $first_invoice_min_amount;
					} elseif ($second_invoice_value > 0) {

						$payid = $payment->paymentid;
						$pay_id = $payid . '-' . $payids++;
						if ($payment->paymentamount > $second_invoice_value) {
							$db->query("INSERT INTO `payments`(`paymentid`, `userid`, `invoice`, `paymentamount`, `paymentdate`, `paymenttypeid`, `otherdetails`, `remarks`, `paymentcollectedby`, `paymentstatusid`, `batchid`, `updated_by`, `approved_by`, `createddate`) VALUES('{$pay_id}','{$payment->userid}','{$invoice2[0]->invoiceid}',$second_invoice_value,'$payment->paymentdate','{$payment->paymenttypeid}','{$payment->otherdetails}','{$payment->remarks}','{$payment->paymentcollectedby}','{$payment->paymentstatusid}','$payment->batchid','$payment->updated_by','{$payment->approved_by}','{$payment->createddate}')");
							$amount = $payment->paymentamount - $second_invoice_value;
							$db->query("UPDATE `payments` SET paymentamount = {$amount},invoice='{$invoice1[0]->invoiceid}' where paymentid='{$payment->paymentid}'");
							$second_invoice_value = 0;
						} else {
							$db->query("UPDATE `payments` SET invoice='{$invoice2[0]->invoiceid}' where paymentid='{$payment->paymentid}'");
							$second_invoice_value = $second_invoice_value - $payment->paymentamount;
						}
					} elseif ($first_invoice_value > 0) {
						$db->query("UPDATE `payments` SET invoice='{$invoice1[0]->invoiceid}' where paymentid='{$payment->paymentid}'");
					}
				}
			}
		}
		$payids = 1;
		$first_invoice_min_amount = 0;
		$second_invoice_value = 0;
		$application_fee = 0;
	}
	public function generatepayslip($id)
	{
		if (isset($_SESSION['userdetails'])) {
			$type = 'view';
			$html = file_get_contents(base_url("payroll/print_payslip/{$id}"));
			$paymentsmodel = new PaymentsModel();
			$paymentsmodel->htmltopdf($html, $type, $id, 'P');
			if ($type == 'view') {
				return redirect()->to(base_url("payslip/" . $id . ".pdf"));
			}
		} else {
			return redirect()->to(base_url('Payments'));
		}
	}
	public function print_attendancesummary()
	{
	    $date = date('Y-m-d');
	    $paymentid = "AttendanceReport_".$date;
        $html = file_get_contents(base_url("reports/print_studentattendancesummary"));
       
        $paymentsmodel = new PaymentsModel();
        $paymentsmodel->htmltopdf($html, 'save', $paymentid, 'A');
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
        $url = "https://maidendropgroup.com/public/attendance_files/{$paymentid}.pdf";
        $HELLO = file_get_contents("https://maidendropgroup.com/public/attendance_files/{$paymentid}.pdf");
        try {
            $result = $s3Client->putObject([
                'ACL' => 'public-read',
                'ContentType' => 'application/pdf',
                'Bucket' => 'resohyd',
                'Key' => "{$paymentid}.pdf",
                'Body' => $HELLO
            ]);
            
        } catch (S3Exception $e) {
            $api_error = $e->getMessage() . PHP_EOL;
        }
             
             $cmd = $s3Client->getCommand('GetObject', [
        'Bucket' => 'resohyd',
        'Key' => "{$paymentid}.pdf"
    ]);
    
    $request = $s3Client->createPresignedRequest($cmd, '+2 minutes');
    
    // Get the actual presigned-url
    $presignedUrl = (string)$request->getUri();
    $mobile = 8123540068;
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
            "campaignName": "student_attendance_report_with_link/file",
            "destination": "'.$mobile.'",
            "userName": "Resonance",
            "templateParams": ["'.$date.'","'.$url.'"],
            "media":{
              "url": "'.$presignedUrl.'",
              "filename": "'.$paymentid.'.pdf"
          }
        }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
          ),
        ));
        $response = curl_exec($curl);
        
        curl_close($curl);
        $mobile = 7997004444;
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
            "campaignName": "student_attendance_report_with_link/file",
            "destination": "'.$mobile.'",
            "userName": "Resonance",
            "templateParams": ["'.$date.'","'.$url.'"],
            "media":{
              "url": "'.$presignedUrl.'",
              "filename": "'.$paymentid.'.pdf"
          }
        }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
          ),
        ));
        $response = curl_exec($curl);
        
        curl_close($curl);
        
        $mobile = 8885526751;
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
            "campaignName": "student_attendance_report_with_link/file",
            "destination": "'.$mobile.'",
            "userName": "Resonance",
            "templateParams": ["'.$date.'","'.$url.'"],
            "media":{
              "url": "'.$presignedUrl.'",
              "filename": "'.$paymentid.'.pdf"
          }
        }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
          ),
        ));
        $response = curl_exec($curl);
        
        curl_close($curl);
        //echo $response;
        print_r($response);
	}
	public function print_collectionsummary()
	{
	    $date = date('Y-m-d');
	    $paymentid = "CollectionReport_".$date;
        $html = file_get_contents(base_url("reports/print_collectionsummarydetails"));
        $paymentsmodel = new PaymentsModel();
        $paymentsmodel->htmltopdf($html, 'save', $paymentid, 'C');
        
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
        $url = "https://maidendropgroup.com/public/collection_files/{$paymentid}.pdf";
        $HELLO = file_get_contents("https://maidendropgroup.com/public/collection_files/{$paymentid}.pdf");
        try {
            $result = $s3Client->putObject([
                'ACL' => 'public-read',
                 'ContentType' => 'application/pdf',
                'Bucket' => 'resohyd',
                'Key' => "{$paymentid}.PDF",
                'Body' => $HELLO
            ]);
            
        } catch (S3Exception $e) {
            $api_error = $e->getMessage() . PHP_EOL;
        }
             
             $cmd = $s3Client->getCommand('GetObject', [
        'Bucket' => 'resohyd',
        'Key' => "{$paymentid}.PDF"
    ]);
    
    $request = $s3Client->createPresignedRequest($cmd, '+2 minutes');
    
    // Get the actual presigned-url
    $presignedUrl = (string)$request->getUri();
    $mobile = 8885526751;
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
            "campaignName": "daily_collection_report_with_link/file",
            "destination": "'.$mobile.'",
            "userName": "Resonance",
            "templateParams": ["'.$date.'","'.$url.'"],
            "media":{
              "url": "'.$presignedUrl.'",
              "filename": "'.$paymentid.'.PDF"
          }
        }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
          ),
        ));
        $response = curl_exec($curl);
        
        curl_close($curl);
         $mobile = 7997004444;
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
            "campaignName": "daily_collection_report_with_link/file",
            "destination": "'.$mobile.'",
            "userName": "Resonance",
            "templateParams": ["'.$date.'","'.$url.'"],
            "media":{
              "url": "'.$presignedUrl.'",
              "filename": "'.$paymentid.'.pdf"
          }
        }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
          ),
        ));
        $response = curl_exec($curl);
        
        curl_close($curl);
        
         $mobile = 8123540068;
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
            "campaignName": "daily_collection_report_with_link/file",
            "destination": "'.$mobile.'",
            "userName": "Resonance",
            "templateParams": ["'.$date.'","'.$url.'"],
            "media":{
              "url": "'.$presignedUrl.'",
              "filename": "'.$paymentid.'.pdf"
          }
        }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
          ),
        ));
        $response = curl_exec($curl);
        
        curl_close($curl);
        print_r($response);
	}
		public function singlepayment()
	{
	     $UsersModel = new UsersModel();
	     $db = db_connect();
	     	$query1 = $db->query("SELECT userid from studentdetails where applicationnumber IN (2300022,
2300091,
2300105,
2300131,
2300150,
2300154,
2300156,
2300168,
2300170,
2300181,
2300182,
2300213,
2300241,
2300249,
2300256,
2300265,
2300267,
2300349,
2300381,
2300392,
2300403,
2300422,
2300461,
2300464,
2300465,
2300467,
2300469,
2300555,
2300556,
2300591,
2300596,
2300606,
2300620,
2300656,
2300711,
2300727,
2300745,
2300769,
2300866,
2300875,
2300876,
2300919,
2300927,
2300929,
2300933,
2300946,
2300950,
2301030,
2301104,
2301115,
2301167,
2301209,
2301211,
2301214,
2301230,
2301237,
2301238,
2301241,
2301250,
2301391,
2301409,
2301412,
2301414,
2301425,
2301438,
2301500,
2301509,
2301516,
2301549,
2301579,
2301594,
2301634,
2301656,
2301693,
2301759,
2301797,
2301812,
2301847,
2301872,
2301888,
2301890,
2301892,
2301904,
2301922,
2301930,
2301957,
2302001,
2302041,
2302090,
2302092,
2302123,
2302158,
2302167,
2302168,
2302175,
2302181,
2302191,
2302261,
2302292,
2302315,
2302336,
2302342,
2302384,
2302390,
2302402,
2302403,
2302420,
2302430,
2302433,
2302449)");
			$payments = $query1->getResult();
			foreach($payments as $p){
		
                                                        $Detail = $UsersModel->getMaxInvoice(2,$p->userid);
                                                        $Detail1 = $UsersModel->getMaxPayment(2,$p->userid);
                                                        $inv2 = $Detail[0]->amount - $Detail1[0]->amount;
                                                        
                                                        $Detail2 = $UsersModel->getMaxInvoice(1,$p->userid);
                                                        $Detail3 = $UsersModel->getMaxPayment(1,$p->userid);
                                                        $inv1 = $Detail2[0]->amount - $Detail3[0]->amount;
                                                        
                                                        
                                                        $paymentsModel = new PaymentsModel();
                $InvoiceDetails = $paymentsModel->getInvoiceDetails($p->userid);
                   
                                                     if($inv2 > 0)
                                                        {
                                                   foreach ($InvoiceDetails as $result) :
                                                      if ($result->invoice ==2 && $result->batchid == $_SESSION['activebatch']) {
                                                   ?>
                                                      <!--<option value="<?php echo  $result->invoiceid;?>" data-id="<?php echo  $result->invoice;?>"><?php echo  $result->invoiceid;?></option>-->
                                                   <?php
                                                        $usersModel = new UsersModel();
                                                        $isValidRFid = $usersModel->getinvoicevalue($result->invoiceid,$p->userid);
                                                       $amount = $isValidRFid['TotalValue'] - $isValidRFid['TotalPaid'];
                                                        $userid = $p->userid;
			$paymenttypeid = 10;
			$paymentamount = $amount;
			// $paymentdate = date_create_from_format("d/m/Y", $_POST['paymentdate']) != false ? date_format(date_create_from_format("d/m/Y", $_POST['paymentdate']), 'Y-m-d') : date('Y-m-d');
			$paymentdate = date('Y-m-d');
			$otherdetails = 'Single payment';
			$remarks = '';
			$invoice = $result->invoiceid;

			$paymentcollectedby = 1;
			$paymentstatusid = 1;

			$helperModel = new HelperModel();
			$batch = $helperModel->get_batch()->year;
			$nextpaymentid = $helperModel->get_paymentidcounter();

			$paymentid = "RMD-" . $batch . "-" . str_pad($nextpaymentid, 6, '0', STR_PAD_LEFT);
            $createddate = date('Y-m-d H:i:s');
			$paymentsModel = new PaymentsModel();
			$result = $paymentsModel->addPaymentNew($paymentid, $userid,$invoice, $paymentamount, $paymentdate, $paymenttypeid, $otherdetails, $paymentcollectedby, $paymentstatusid, 0, $remarks,$createddate);

		
				$nextpaymentid = $helperModel->set_paymentidcounter();
                                                      }
                                                   endforeach;
                                                    
                                                        }elseif($inv1 > 0)
                                                        {
                                                           
                                                            foreach ($InvoiceDetails as $result) :
                                                      if ($result->invoice ==1 && $result->batchid == $_SESSION['activebatch']) {
                                                   ?>
                                                      <!--<option value="<?php echo  $result->invoiceid;?>" data-id="<?php echo  $result->invoice;?>"><?php echo  $result->invoiceid;?></option>-->
                                                   <?php
                                                        $usersModel = new UsersModel();
                                                        $isValidRFid = $usersModel->getinvoicevalue($result->invoiceid,$p->userid);
                                                        $amount = $isValidRFid['TotalValue'] - $isValidRFid['TotalPaid'];
                                                        $userid = $p->userid;
			$paymenttypeid = 10;
			$paymentamount = $amount;
			// $paymentdate = date_create_from_format("d/m/Y", $_POST['paymentdate']) != false ? date_format(date_create_from_format("d/m/Y", $_POST['paymentdate']), 'Y-m-d') : date('Y-m-d');
			$paymentdate = date('Y-m-d');
			$otherdetails = 'Single payment';
			$remarks = '';
			$invoice = $result->invoiceid;

			$paymentcollectedby = 1;
			$paymentstatusid = 1;

			$helperModel = new HelperModel();
			$batch = $helperModel->get_batch()->year;
			$nextpaymentid = $helperModel->get_paymentidcounter();

			$paymentid = "RMD-" . $batch . "-" . str_pad($nextpaymentid, 6, '0', STR_PAD_LEFT);
            $createddate = date('Y-m-d H:i:s');
			$paymentsModel = new PaymentsModel();
			$result = $paymentsModel->addPaymentNew($paymentid, $userid,$invoice, $paymentamount, $paymentdate, $paymenttypeid, $otherdetails, $paymentcollectedby, $paymentstatusid, 0, $remarks,$createddate);

		
				$nextpaymentid = $helperModel->set_paymentidcounter();
			
                                                      }
                                                   endforeach;
                                                        }
			}
                                                        
                
	}
}
