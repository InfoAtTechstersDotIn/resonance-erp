<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\UsersModel;
use App\Models\PaymentsModel;
use App\Models\HelperModel;
use App\Models\EmailModel;
use App\Models\FormsModel;
use App\Models\InventoryModel;
use App\Models\PayrollModel;
use App\Models\RazorpayModel;
use App\Models\WalletModel;
use App\Models\ReservationModel;
use DateTime;

class Users extends BaseController
{
    public $session;
    public function __construct()
    {
        $session = session();
    }

    public function index()
    {
        if ($_SESSION['userdetails'] == null) {
            $data['page_name'] = 'employee';
            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('home'));
        }
    }

    public function autocomplete_users()
    {
        $searchfor = $_GET['term'];

        $usersModel = new UsersModel();
        return $usersModel->getAutocompleteUsers($searchfor);
    }

    public function employee()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Users/employee';

            $helperModel = new HelperModel();
            
            $data['nextemployeeid'] = $helperModel->get_nextemployeeidcounter();
            $data['lookups'] = $helperModel->get_lookups();
            $branchid = (isset($_GET['branchid']) && $_GET['branchid'] != "") ? $_GET['branchid'] : NULL;
            $roleid = (isset($_GET['roleid']) && $_GET['roleid'] != "") ? $_GET['roleid'] : NULL;
            $active = (isset($_GET['active']) && $_GET['active'] != "") ? $_GET['active'] : NULL;

            $usersModel = new UsersModel();
            $data['EmployeeDetails'] = $usersModel->getAllEmployeeDetailsfilter($branchid,$roleid,$active);
            $download = (isset($_GET['download']) && $_GET['download'] != "") ? $_GET['download'] : NULL;

            if ($download == 1) {
                $setData = '';
                foreach ($data['EmployeeDetails'] as $key => $rec) {
                    if ($key == 0) {
                        $rowData = '';
                        foreach ($rec as $key => $value) {
                           
                                $key = '"' . $key . '"' . "\t";
                                $rowData .= $key;
                        }
                        $setData .= trim($rowData) . "\n";
                    }

                    $rowData = '';
                    foreach ($rec as $key => $value) {
                            $value = '"' . $value . '"' . "\t";
                            $rowData .= $value;
                    }
                    $setData .= trim($rowData) . "\n";
                }

                header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=Employee_Report.xls");
                header("Pragma: no-cache");
                header("Expires: 0");
                echo $setData . "\n";
            } else {
                return view('loggedinuser/index.php', $data);
            }
           
        } else {
            return redirect()->to(base_url('home'));
        }
    }

    public function student()
    {
        if ($_SESSION['userdetails'] != null) {
            // if ($_SESSION['activebatch'] == "1") {
            //     $data['page_name'] = 'Users/old_student';
            // } else {
            $data['page_name'] = 'Users/student';
            // }

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            $usersModel = new UsersModel();
            $data['EmployeeDetails'] = $usersModel->getAllEmployeeDetails();
            if($_SESSION['userdetails']->roleid !=12)
            {
                $data['StudentDetails'] = $usersModel->getAllStudentDetails();
            }else
            {
                $data['StudentDetails'] = $usersModel->getAllStudentDetailsTc();
            }
            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('home'));
        }
    }

    public function addstudent()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Users/addstudent';

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            $usersModel = new UsersModel();
            $data['EmployeeDetails'] = $usersModel->getAllEmployeeDetails();
            $data['FeesLimit'] = $usersModel->getAllEmployeeDetailsById($_SESSION['userdetails']->userid);

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('home'));
        }
    }

    public function reservations()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Users/reservations';

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            $reservationModel = new ReservationModel();
            $reservations = $reservationModel->get_reservations();

            $data['reservations'] = $reservations;

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('home'));
        }
    }

    public function addReservation()
    {
        $data['page_name'] = 'Users/addReservation';

        $helperModel = new HelperModel();

        $data['lookups'] = $helperModel->get_lookups();

        $usersModel = new UsersModel();
        $data['EmployeeDetails'] = $usersModel->getMarketingEmployeeDetails();

        return view('loggedinuser/index.php', $data);
    }

    public function reservationDetails()
    {
        if ($_SESSION['userdetails'] != null) {
            $reservationId = $this->request->getGetPost('id');
            $resofastId = $this->request->getGetPost('resofast');

            $data['page_name'] = 'Users/reservationDetails';

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            $usersModel = new UsersModel();
            $data['EmployeeDetails'] = $usersModel->getAllEmployeeDetails();

            $reservationModel = new ReservationModel();
            $data['StudentDetail'] = $reservationModel->getReservationDetails($reservationId);
            
            if ($data['StudentDetail'] == NULL) {
                return redirect()->to(base_url('users/reservations'));
            }
            $data['PaymentDetail'] = $reservationModel->getReservationPaymentDetailsByReservationId($reservationId);

            if ($data['StudentDetail']->rezofastdetails != NULL || $data['StudentDetail']->rezofastdetails != "") {
                $data['StudentDetail']->rezofastdetails = urldecode($data['StudentDetail']->rezofastdetails);
            }

            if ($resofastId != "") {

                $isValidResofastId = $usersModel->checkDuplicateResofastId($resofastId);
                if ($isValidResofastId != "false") {

                    $db = db_connect("resoFast");

                    $query = $db->query("SELECT * FROM register 
                                     JOIN exam_score ON register.reference_no = exam_score.hall_no 
                                     where register.is_paid = 1 and reference_no = '{$resofastId}'");
                    $result = $query->getRow();
                    $db->close();

                    if ($result != null) {
                        $rezofastdetails = [];
                        $rezofastdetails['hallticketnumber'] = $result->reference_no == null ? '' : $result->reference_no;
                        $rezofastdetails['score'] = $result->score == null ? 0 : $result->score;
                        $rezofastdetails['interviewscore'] = $result->interview_score == null ? 0 : $result->interview_score;

                        $usersModel = new UsersModel();
                        $rezofastdetails['scholarship'] = $usersModel->getscholarship($rezofastdetails['score'], $rezofastdetails['interviewscore'], $data['StudentDetail']->batchid);

                        $data['StudentDetail']->rezofastdetails = json_encode($rezofastdetails);
                    } else {
                        echo "Invalid Resofast Id";
                        exit();
                    }
                }
            }

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('home'));
        }
    }

    public function resofast()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Users/resofast';

            $db = db_connect("resoFast");

            $query = $db->query("SELECT * FROM register 
                                 JOIN exam_score ON register.reference_no = exam_score.hall_no 
                                 where register.is_paid = 1 
                                 AND academic = {$_SESSION['activebatch']}");
            $results = $query->getResult();
            $db->close();

            $data['StudentDetails'] = $results;

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('home'));
        }
    }

    public function issueRefundAndDropStudent()
    {
        if ($_SESSION['userdetails'] != null) {
            $returnURL = $_POST['returnURL'];
            $userid = $_POST['userid'];
            $paymenttypeid = 8;
            $paymentamount = $_POST['paymentamount'];
            // $paymentdate = date_create_from_format("d/m/Y", $_POST['paymentdate']) != false ? date_format(date_create_from_format("d/m/Y", $_POST['paymentdate']), 'Y-m-d') : date('Y-m-d');
            $paymentdate = date('Y-m-d');
            $otherdetails = $_POST['otherdetails'];
            $remarks = $_POST['remarks'];

            $paymentcollectedby = $_SESSION['userdetails']->userid;
            $paymentstatusid = 3;

            $helperModel = new HelperModel();
            $batch = $helperModel->get_batch()->year;
            $nextpaymentid = $helperModel->get_paymentidcounter();

            $paymentid = "RMD-" . $batch . "-" . str_pad($nextpaymentid, 6, '0', STR_PAD_LEFT);

            $paymentsModel = new PaymentsModel();
            $result = $paymentsModel->addPayment($paymentid, $userid, $paymentamount, $paymentdate, $paymenttypeid, $otherdetails, $paymentcollectedby, $paymentstatusid, 0, $remarks);

            if ($result->resultID) {
                $nextpaymentid = $helperModel->set_paymentidcounter();
            }

            $usersModel = new UsersModel();
            $usersModel->dropStudent($userid);

            return redirect()->to(base_url($returnURL));
        } else {
            return redirect()->to(base_url('Payments'));
        }
    }

    public function dropstudent()
    {
        if ($_SESSION['userdetails'] != null) {
            $userid = $this->request->getGetPost('id');
            $data['userid'] = $userid;
            $data['page_name'] = 'Users/dropstudent';

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            $usersModel = new UsersModel();
            $data['EmployeeDetails'] = $usersModel->getAllEmployeeDetails();
            $data['StudentDetail'] = $usersModel->getStudentDetails($userid)[0];

            $paymentsModel = new PaymentsModel();
            $data['InvoiceDetails'] = $paymentsModel->getInvoiceDetails($userid);
            $data['PaymentDetails'] = $paymentsModel->getPaymentDetails($userid);

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('home'));
        }
    }
    
    public function migratestudent()
    {
        if ($_SESSION['userdetails'] != null) {
            $reservationId = $this->request->getGetPost('id');
            $data['reservationId'] = $reservationId;
            $data['page_name'] = 'Users/migratestudent';

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            $usersModel = new UsersModel();
            $data['EmployeeDetails'] = $usersModel->getAllEmployeeDetails();

            $reservationModel = new ReservationModel();
            $data['StudentDetail'] = $reservationModel->getReservationDetails($reservationId);

            $paymentsModel = new PaymentsModel();
            $data['PaymentDetail'] = $reservationModel->getReservationPaymentDetailsByReservationId($reservationId);

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('home'));
        }
    }
    
    
    
     public function promotestudent()
    {
        if ($_SESSION['userdetails'] != null) {
            $userid = $this->request->getGetPost('id');
            $data['userid'] = $userid;
            $data['page_name'] = 'Users/promotestudent';

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            $usersModel = new UsersModel();
            $data['EmployeeDetails'] = $usersModel->getAllEmployeeDetails();
            $data['StudentDetail'] = $usersModel->getStudentDetails($userid)[0];

            $paymentsModel = new PaymentsModel();
            $data['InvoiceDetails'] = $paymentsModel->getInvoiceDetails($userid);
            $data['PaymentDetails'] = $paymentsModel->getPaymentDetails($userid);

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('home'));
        }
    }
    
     public function userpromoteflow()
    {
        if ($_SESSION['userdetails'] != null) {
            
            $userid = isset($_POST['userid']) ? $_POST['userid'] : "";
            $usersModel = new UsersModel();

            $admissiontypeid = $_POST['admissiontypeid'];
            $branchid = $_POST['branchid'];
            $batchid = $_POST['batchid'];
            $courseid = $_POST['courseid'];
            $sectionid = $_POST['sectionid'];
            $tuition_discount = $_POST['tuition_discount'];
            $ipe_discount = $_POST['ipe_discount'];
            $hostel_discount = $_POST['hostel_discount'];
            $usersModel->promoteUser(
                $userid,
                $admissiontypeid,
                $branchid,
                $batchid,
                $courseid,
                $sectionid,
                $tuition_discount,
                $ipe_discount,
                $hostel_discount
            );
                return redirect()->to(base_url("users/studentdetails?id={$userid}"));
            //return redirect()->to(base_url('users/student'));
                //$comm = new Comm();
                //$data[0] = $studentDetails[0]->mobile1;
                //$data[1] = $studentDetails[0]->name;
                //$data[2] = $studentDetails[0]->applicationnumber;
                //$comm->sendSMS("Welcome", $data);

                // $html = file_get_contents(base_url("payments/print_invoice?invoiceid={$invoiceid}&batchid={$_SESSION['activebatch']}"));
                // $paymentsmodel = new PaymentsModel();
                // $paymentsmodel->htmltopdf($html, 'save', $invoiceid, 'I');
        
        } else {
            return redirect()->to(base_url('home'));
        }
    }

    public function studentdetails()
    {
        if ($_SESSION['userdetails'] != null) {
            $userid = $this->request->getGetPost('id');
            $data['userid'] = $userid;
            $data['page_name'] = 'Users/studentdetails';

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            $usersModel = new UsersModel();
            if ($_SESSION['userdetails']->roleid != 12) {
            $data['StudentDetails'] = $usersModel->getStudentDetails($userid);
            }else
            {
                $data['StudentDetails'] = $usersModel->getStudentDetailsTc($userid);
            }
            if ($_SESSION['userdetails']->roleid != 12) {
                $data['EmployeeDetails'] = $usersModel->getAllEmployeeDetails();

                $paymentsModel = new PaymentsModel();
                $data['InvoiceDetails'] = $paymentsModel->getInvoiceDetails($userid);
                $data['PaymentDetails'] = $paymentsModel->getPaymentDetails($userid);
                $paymentLinks = $paymentsModel->getPaymentLinks($userid);
                
                $data['PaymentLinks'] = $this->getLatestPaymentLinkData($paymentLinks);

                $inventoryModel = new InventoryModel();
                $data['Inventory'] = $inventoryModel->get_StudentInventory($userid);
                $walletModel = new WalletModel();
                $data['WalletDetails'] = $walletModel->getWalletDetails($userid);
                $data['WalletTransactions'] = $walletModel->getWalletTransactions($userid);

                $adminModel = new AdminModel();
                $data['enrollments'] = $adminModel->get_enrollments(
                    NULL,
                    NULL,
                    NULL,
                    NULL,
                    NULL,
                    NULL,
                    NULL,
                    NULL,
                    $userid
                );

                $formsModel = new FormsModel();
                $data['forms'] = $formsModel->getPendingForms($userid);
            } else {
                $data['quickStudent'] = 1;
            }

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('home'));
        }
    }

    public function employeedetails($empId)
    {
        if ($_SESSION['userdetails'] != null) {
            $data['userid'] = $empId;
            $data['page_name'] = 'Users/employee_details';
            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();
            $usersModel = new UsersModel();
            $data['EmployeeDetails'] = $usersModel->getAllEmployeeDetailsById($empId)[0];
            $data['EmployeeDetail'] = $usersModel->getAllEmployeeDetails();
            $data['EmployeeAttendance'] = $usersModel->get_employee_attendance_by_employeeid($empId);
            $data['Accounts'] = $usersModel->get_BankAccounts($empId);
            $data['Loans'] = $usersModel->get_Loans($empId);
            $data['Insurance'] = $usersModel->get_Insurance($empId);
            $data['Packages'] = $usersModel->get_Packages($empId);
            $data['SalaryStructure'] = $usersModel->get_SalaryStructure($empId);
            $data['ReportingEmployees'] = $usersModel->get_reporting_employees($empId);
            $data['NonReportEmployees'] = $usersModel->getNonReportEmployees($empId);
            $inventoryModel = new InventoryModel();
            $data['Inventory'] = $inventoryModel->get_EmployeeInventory($empId);
            $payrollModel = new PayrollModel();
            $data['EmployeeSalaries'] = $payrollModel->get_salaries_by_empid($empId);
            $data['salary_package'] = $payrollModel->get_employee_salary_package($empId);
            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('home'));
        }
    }

    public function resetphone()
    {
        if ($_SESSION['userdetails'] != null) {
            $empid = $_GET['id'];

            $usersModel = new UsersModel();
            $usersModel->resetphone($empid);

            return redirect()->to(base_url("users/employeedetails/{$empid}"));
        } else {
            return redirect()->to(base_url('home'));
        }
    }
    public function remove_reporting_employee($id,$empid)
    {
        if ($_SESSION['userdetails'] != null) {
            $usersModel = new UsersModel();
            $usersModel->remove_report_employee($id);

            return redirect()->to(base_url("users/employeedetails/{$empid}"));
        } else {
            return redirect()->to(base_url('home'));
        }
    }
    
    public function getLatestPaymentLinkData($PaymentLinks)
    {
        if ($_SESSION['userdetails'] != null) {
           $razorpay = new Razorpay();
            $razorpayModel = new RazorpayModel();
            foreach ($PaymentLinks as $paymentlink) {
                $link = $razorpay->getPaymentLinkById($paymentlink->invoiceid,$paymentlink->invoice);
                if ($paymentlink->status != $link->status) {
                    $razorpayModel->update_payment_status($link->id, $link->status);
                    $paymentlink->status = $link->status;
                }
            }
            return $PaymentLinks;
        } else {
            return redirect()->to(base_url('home'));
        }
    }

    public function approval()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'userapproval';

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            $usersModel = new UsersModel();
            $data['PendingStudentDetails'] = $usersModel->getAllPendingStudenDetails();

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('home'));
        }
    }

    public function reservationApproval()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'reservationApproval';

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            $reservationModel = new ReservationModel();
            $data['PendingStudentDetails'] = $reservationModel->getAllPendingReservations();

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('home'));
        }
    }

    public function student_attendance()
    {
        if ($_SESSION['userdetails'] != null) {
            $todate = date('Y-m-d');
            $branchid = (isset($_GET['branchid']) && $_GET['branchid'] != "") ? $_GET['branchid'] : NULL;
            $courseid = (isset($_GET['courseid']) && $_GET['courseid'] != "") ? $_GET['courseid'] : NULL;
            $sectionid = (isset($_GET['sectionid']) && $_GET['sectionid'] != "") ? $_GET['sectionid'] : NULL;
            $data['page_name'] = 'Users/student_attendance';

            $date = (isset($_GET['date']) && $_GET['date'] != "") ? date_format(date_create_from_format("d/m/Y", $_GET['date']), 'Y-m-d') : $todate;
            //$classid = (isset($_GET['classid']) && $_GET['classid'] != "") ? $_GET['classid'] : "";

            $adminModel = new AdminModel();
            $data['classes'] = $adminModel->get_classes();
                 $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();
            $usersmodel = new UsersModel();
            $data['attendance_info'] = $usersmodel->get_student_attendance($date,$branchid, $courseid,$sectionid);


            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('home'));
        }
    }

    public function add_student_attendance()
    {
        if ($_SESSION['userdetails'] != null) {
            $classid = $_POST['classid'];
            $date = date_format(date_create_from_format("d/m/Y", $_POST['date']), 'Y-m-d');

            $userids = $_POST['userid'];
            foreach ($userids as $userid) {
                $status = $_POST["{$userid}_status"][0] == "1" ? 1 : 0;

                $usersmodel = new UsersModel();
                $usersmodel->add_student_attendance($classid, $date, $userid, $status);
            }

            return redirect()->to(base_url('users/student_attendance'));
        } else {
            return redirect()->to(base_url('home'));
        }
    }

    public function employee_attendance()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Users/employee_attendance';
            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();
            $date = (isset($_GET['date']) && $_GET['date'] != "") ? date_format(date_create_from_format("d/m/Y", $_GET['date']), 'Y-m-d') : "";

            $usersmodel = new UsersModel();
            $data['attendance_info'] = $usersmodel->get_employee_attendance($date);

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('home'));
        }
    }

     public function add_employee_attendance()
    {
        if ($_SESSION['userdetails'] != null) {
            $date = date_format(date_create_from_format("d/m/Y", $_POST['date']), 'Y-m-d');

            $userids = $_POST['userid'];
            foreach ($userids as $userid) {
                $status = $_POST["{$userid}_status"][0] == "1" ? 1 : ($_POST["{$userid}_status"][0] == "2" ? 2 : 0);

                if(isset($_POST["{$userid}_login"][0]))
                {
                    $login = 1;
                }else
                {
                    $login = 0;
                }

                if(isset($_POST["{$userid}_logout"][0]))
                {
                    $logout = 1;
                }else
                {
                    $logout = 0;
                }
                
                
                $usersmodel = new UsersModel();
                $usersmodel->add_employee_attendance($date, $userid, $status,$login,$logout);
            }
            
            return redirect()->to(base_url('users/employee_attendance'));
        } else {
            return redirect()->to(base_url('home'));
        }
    }

    public function update_employee_attendance($date, $userid, $status)
    {
        if ($_SESSION['userdetails'] != null) {
            $usersmodel = new UsersModel();
            $usersmodel->add_employee_attendance($date, $userid, $status,NULL,NULL);

            return redirect()->to(base_url('users/employeedetails') . "/" . $userid);
        } else {
            return redirect()->to(base_url('home'));
        }
    }
    
    public function studentprofileimage($userid)
    {
        $usersModel = new UsersModel();
        $res = $usersModel->getApplicationDetail($userid);
        if( $res[0]->is_profile_uploaded == 0){
        $data['page_name'] = 'Users/updatestudentimage';
        $data['userid'] = $userid;
        $data['application'] =  $res;
        return view('loggedinuser/index.php', $data);
        }else
        {
            return redirect()->to(base_url('home'));
        }
    }
    
    public function updatestudentprofileimage($id)
    {
        
         $usersModel = new UsersModel();
        
        
         helper(['form', 'url']);
         $usersModel = new UsersModel();
        $input = $this->validate([
            'file' => [
                'uploaded[file]',
                'mime_in[file,image/jpg,image/jpeg,image/png]',
                'max_size[file,1024]',
            ]
        ]);
    
        if (!$input) {
            print_r('Choose a valid file');
        } else {
            $img = $this->request->getFile('file');
            $name = $img->getRandomName();
            $img->move('application', $name);
            $save = $usersModel->updateapplicationprofileimage($id,$name);
            session()->setFlashdata('success', 'Success! Image uploaded.');
            $res = $usersModel->getApplicationDetail($id);
            $data['page_name'] = 'Users/upload';
            $data['res'] = $res;
            $data['folder'] = 'application';
            return view('loggedinuser/index.php', $data); 
    
        }
         
    }
    
    
    public function reservationstudentprofileimage($userid)
    {
        $usersModel = new UsersModel();
        $res = $usersModel->getResevationDetail($userid);
        if( $res[0]->is_profile_uploaded == 0){
        $data['page_name'] = 'Users/updatereservationstudentimage';
        $data['userid'] = $userid;
        $data['application'] =  $res;
        return view('loggedinuser/index.php', $data);
        }else
        {
            return redirect()->to(base_url('home'));
        }
    }
    
    public function updatereservationstudentprofileimage($id)
    {
        
         $usersModel = new UsersModel();
        
        
         helper(['form', 'url']);
         $usersModel = new UsersModel();
        $input = $this->validate([
            'file' => [
                'uploaded[file]',
                'mime_in[file,image/jpg,image/jpeg,image/png]',
                'max_size[file,1024]',
            ]
        ]);
    
        if (!$input) {
            print_r('Choose a valid file');
        } else {
            $img = $this->request->getFile('file');
            $name = $img->getRandomName();
            $img->move('reservation', $name);
            $save = $usersModel->updatereservationprofileimage($id,$name);
            session()->setFlashdata('success', 'Success! Image uploaded.');
            $res = $usersModel->getResevationDetail($id);
            $data['page_name'] = 'Users/upload';
            $data['res'] = $res;
            $data['folder'] = 'reservation';
            return view('loggedinuser/index.php', $data); 
    
        }
         
    }

   public function createemployee()
    {
        if ($_SESSION['userdetails'] != null) {
            $name = $_POST['name'];
            $branchid = COUNT($_POST['branchid']) == 0 ? "" : implode(',', $_POST['branchid']);
            $roleid = $_POST['roleid'];
            $username = $_POST['username'];
            $password = md5($_POST['password']);
            $designation = $_POST['designation'];
            $employee_id = $_POST['employee_id'];
            $mobile = $_POST['mobile'];
            $email = $_POST['email'];
            $totalleaves = $_POST['totalleaves'];
            $joiningdate = $_POST['joiningdate'];
            $gender = $_POST['genderid'];
            $pancard = $_POST['pancard'];
            $login_time = $_POST['logintime'];
            $logout_time = $_POST['logouttime'];
            $reportperson = $_POST['reportperson'];
            $helperModel = new HelperModel();
            $uniqueid = $helperModel->generateUniqueId();
            $usersModel = new UsersModel();
            $userid = $usersModel->addUser($uniqueid, $username, $password, $roleid);
            $student_photo_doc = $_FILES['profile_image']['tmp_name'];
         if (!is_dir("uploads/{$userid}")) {
             mkdir("uploads/{$userid}");
         }
         move_uploaded_file($student_photo_doc, "uploads/{$userid}/photo.jpeg");
            $usersModel->addEmployee($userid, $name, $branchid, $designation, $mobile, $employee_id, $email,$totalleaves,$joiningdate,$gender,$pancard,$login_time,$logout_time,$reportperson);
            $nextpaymentid = $helperModel->set_nextemployeeid();
            return redirect()->to(base_url('users/employee'));
        } else {
            return redirect()->to(base_url('home'));
        }
    }

    public function updateemployee()
    {
        if ($_SESSION['userdetails'] != null) {
              if($_POST['marketing']==true)
           {
                $marketing = 1;
           }else
           {
                $marketing = 0;
           }
           $report_employee= $_POST['report_employee'];
            $name = $_POST['name'];
            $reportperson = $_POST['reportperson'];
            $userid = $_POST['id'];
            $username = $_POST['username'];
            $designation = $_POST['designation'];
            $mobile = $_POST['mobile'];
            $email = $_POST['email'];
            $logintime = $_POST['logintime'];
            $logouttime = $_POST['logouttime'];
            $leavespermonth = $_POST['leavespermonth'];
            $totalleaves = $_POST['totalleaves'];
            $branchid = COUNT($_POST['branchid']) == 0 ? "" : implode(',', $_POST['branchid']);
            $roleid = $_POST['roleid'];
            if ($_POST['password'] == "") {
                $password = $_POST['password_hidden'];
            } else {
                $password = md5($_POST['password']);
            }

            $usersModel = new UsersModel();
            $usersModel->updateUser($userid, $username, $password, $roleid);
            $usersModel->updateEmployee($userid, $name, $branchid, $designation, $mobile, $email, $leavespermonth,$logintime,$logouttime,$marketing,$totalleaves,$reportperson);
          if (isset($report_employee)) {
           foreach ($report_employee as $i) {
            $usersModel->updatereportemployee($userid, $i);
            }
          }
           return redirect()->to(base_url("users/employeedetails/{$userid}"));
        } else {
            return redirect()->to(base_url('home'));
        }
    }
    
    public function employee_status_changed()
    {
         $db = db_connect();
        //get hidden values in variables
    	$id = $_POST['id'];
    	$status = $_POST['status'];
    
        //check condition
    	if($status == '1'){
    		$user_status = '0';
    	}
    	else{
    		$user_status = '1';
    	}
        $usersModel = new UsersModel();
                $usersModel->updateEmployeestatus($id, $user_status);
        return redirect()->to(base_url('users/employee'));
    }
    public function employee_two_step_status_changed()
    {
        $db = db_connect();
            //get hidden values in variables
        	$id = $_POST['id'];
        	$status = $_POST['status'];
            //check condition
        	if($status == '1'){
        		$user_status = '0';
        	}
        	else{
        		$user_status = '1';
        	}
            $usersModel = new UsersModel();
                    $usersModel->updateEmployeeTwoStepstatus($id, $user_status);
            return redirect()->to(base_url('users/employee'));
    }

    public function deletestudent()
    {
        if ($_SESSION['userdetails'] != null) {
            $userid = $_GET['id'];
            $usersModel = new UsersModel();
            $usersModel->deleteUser($userid);
            $usersModel->deleteStudent($userid);
            return redirect()->to(base_url('users/student'));
        } else {
            return redirect()->to(base_url('home'));
        }
    }

    public function deleteemployee()
    {
        if ($_SESSION['userdetails'] != null) {
            $userid = $_GET['id'];
            $usersModel = new UsersModel();
            $usersModel->deleteUser($userid);
            $usersModel->deleteEmployee($userid);
            return redirect()->to(base_url('users/employee'));
        } else {
            return redirect()->to(base_url('home'));
        }
    }

    public function checkreservationid()
    {
        $reservationid = $_GET['reservationid'];

        $usersModel = new UsersModel();
        echo $usersModel->checkReservationId($reservationid);
    }

    public function checkapplicationnumber()
    {
        $applicationNumber = $_GET['applicationnumber'];

        $usersModel = new UsersModel();
        echo $usersModel->checkApplicationNumber($applicationNumber);
    }

    public function createstudent()
    {
        if ($_SESSION['userdetails'] != null) {
            $helperModel = new HelperModel();
            $uniqueid = $helperModel->generateUniqueId();

            $random = rand(0, 999999);
            $now = date('dmYHisu') . $random;
            $username = "USR-" . $now;
            $password = md5($username);
            $roleid = 5;

            $usersModel = new UsersModel();
            $userid = $usersModel->addUser($uniqueid, $username, $password, $roleid);

            $applicationnumber = $_POST['applicationnumber'];
            $studentaadhaar = $_POST['studentaadhaar'];
            $room = '';
            $reservation_ukey = NULL;
            $admissiontypeid = $_POST['admissiontypeid'];
            $branchid = $_POST['branchid'];
            $batchid = $_POST['batchid'];
            $courseid = $_POST['courseid'];
            $sectionid = $_POST['sectionid'];

            $usersModel->addStudentApplicationDetails(
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
            );

            $data = [];
            $data['name'] = $_POST['name'];
            $data['genderid'] = $_POST['genderid'];
            $usersModel->dynamicStudentDetailsUpdate($data, $userid);

            $data = [];
            $data['mobile1'] = $_POST['mobile1'];
            $data['mobile2'] = $_POST['mobile2'];
            $data['email'] = $_POST['email'];
            $usersModel->dynamicStudentDetailsUpdate($data, $userid);

            $data = [];
            $data['admissiondate'] = date_create_from_format("d/m/Y", $_POST['admissiondate']) != false ? date_format(date_create_from_format("d/m/Y", $_POST['admissiondate']), 'Y-m-d') : date('Y-m-d');
            $data['secondlanguageid'] = $_POST['secondlanguageid'];
            $data['referredby'] = $_POST['referredby'] == "" ? 0 : $_POST['referredby'];
            $usersModel->dynamicStudentDetailsUpdate($data, $userid);

            $data = [];
            $data['scholarship'] = $_POST['scholarship'];
            $data['tuition_discount'] = $_POST['tuition_discount'];
            $data['hostel_discount'] = $admissiontypeid == "1" ? $_POST['hostel_discount'] : "0";
            $data['comments'] = $_POST['comments'];
            $data['rezofastdetails'] = $_POST['rezofastdetails'];
            $usersModel->dynamicStudentDetailsUpdate($data, $userid);

            $discountgiven = $_POST['discountgiven'];
            if ($discountgiven != 0) {
                $helperModel->add_discountLog($discountgiven, $userid);
            }

            $data = [];
            $data['dateofbirth'] = date_create_from_format("d/m/Y", $_POST['dateofbirth']) != false ? date_format(date_create_from_format("d/m/Y", $_POST['dateofbirth']), 'Y-m-d') : "1971-01-01";
            $data['categoryid'] = $_POST['categoryid'];
            $data['nationalityid'] = $_POST['nationalityid'];
            $data['religionid'] = $_POST['religionid'];
            $usersModel->dynamicStudentDetailsUpdate($data, $userid);

            $data = [];
            $data['fathername'] = $_POST['fathername'];
            $data['mothername'] = $_POST['mothername'];
            $data['parentoccupation'] = $_POST['parentoccupation'];
            $usersModel->dynamicStudentDetailsUpdate($data, $userid);

            $previous_class_information = [];
            $class = [];
            $class['class'] = 'PCI';
            $class['board'] = $_POST['board'];
            $class['school'] = $_POST['school'];
            $class['place'] = $_POST['place'];
            $class['grade'] = $_POST['grade'];
            $class['hallticketNo'] = $_POST['hallticketNo'];
            array_push($previous_class_information, $class);

            $address = [];
            $permanent['door_street'] = $_POST['door_street'];
            $permanent['state'] = $_POST['state'];
            $permanent['district'] = $_POST['district'];
            $permanent['city_town'] = $_POST['city_town'];
            $permanent['village_mandal'] = $_POST['village_mandal'];
            $permanent['pin'] = $_POST['pin'];
            $permanent['landmark'] = $_POST['landmark'];
            $address['permanent'] = $permanent;

            $cheque_details = [];

            $data = [];
            $data['cheque_details'] = json_encode($cheque_details);
            $usersModel->dynamicStudentDetailsUpdate($data, $userid);

            $data = [];
            $data['address'] = json_encode($address);
            $usersModel->dynamicStudentDetailsUpdate($data, $userid);

            $data = [];
            $data['previous_class_information'] = json_encode($previous_class_information);
            $usersModel->dynamicStudentDetailsUpdate($data, $userid);

            $paymenttypeid = $_POST['paymenttypeid'];
            $paymentamount = $_POST['paymentamount'];
            // $paymentdate = date_create_from_format("d/m/Y", $_POST['paymentdate']) != false ? date_format(date_create_from_format("d/m/Y", $_POST['paymentdate']), 'Y-m-d') : date('Y-m-d');
            $paymentdate = date('Y-m-d');
            $otherdetails = $_POST['otherdetails'];

            $paymentcollectedby = $_SESSION['userdetails']->userid;
            $paymentstatusid = 1;

            $batch = $helperModel->get_batch()->year;
            $nextpaymentid = $helperModel->get_paymentidcounter();

            $paymentid = "RMD-" . $batch . "-" . str_pad($nextpaymentid, 6, '0', STR_PAD_LEFT);

            $paymentsModel = new PaymentsModel();
            $result = $paymentsModel->addPayment($paymentid, $userid, $paymentamount, $paymentdate, $paymenttypeid, $otherdetails, $paymentcollectedby, $paymentstatusid, 0, "Booking Amount");

            if ($result->resultID) {
                $nextpaymentid = $helperModel->set_paymentidcounter();
            }

            return redirect()->to(base_url("users/studentdetails?id={$userid}"));
        } else {
            return redirect()->to(base_url('home'));
        }
    }

  public function createreservation()
    {
        if ($_SESSION['userdetails'] != null) {
            $reservation_ukey = $_POST['reservationid'];
            $name = $_POST['name'];
            $dateofbirth = date_create_from_format("d/m/Y", $_POST['dateofbirth']) != false ? date_format(date_create_from_format("d/m/Y", $_POST['dateofbirth']), 'Y-m-d') : "1971-01-01";
            $genderid = $_POST['genderid'];
            $nationalityid = $_POST['nationalityid'];
            $religionid = $_POST['religionid'];
            $categoryid = $_POST['categoryid'];
            $studentaadhaar = $_POST['studentaadhaar'];

            $fathername = $_POST['fathername'];
            $mothername = $_POST['mothername'];
            $parentoccupation = $_POST['parentoccupation'];
            $visitorname = $_POST['visitorname'];
            $relationwithstudent = $_POST['relationwithstudent'];
            $visitornumber = $_POST['visitornumber'];

            $previous_class_information = [];
            $class = [];
            $class['class'] = 'PCI';
            $class['school'] = $_POST['school'];
            $class['board'] = $_POST['board'];
            $class['place'] = $_POST['place'];
            $class['grade'] = $_POST['grade'];
            $class['hallticketNo'] = $_POST['hallticketNo'];
            array_push($previous_class_information, $class);

            $address = [];
            $permanent['door_street'] = $_POST['door_street'];
            $permanent['village_mandal'] = $_POST['village_mandal'];
            $permanent['landmark'] = $_POST['landmark'];
            $permanent['city_town'] = $_POST['city_town'];
            $permanent['state'] = $_POST['state'];
            $permanent['district'] = $_POST['district'];
            $permanent['pin'] = $_POST['pin'];

            $address['permanent'] = $permanent;

            $mobile1 = $_POST['mobile1'];
            $mobile2 = $_POST['mobile2'];
            $email = $_POST['email'];

            $admissiontypeid = $_POST['admissiontypeid'];
            $courseid = $_POST['courseid'];
            $sectionid = 0;
            $secondlanguageid = $_POST['secondlanguageid'];
            $branchid = $_POST['branchid'];
            $comments = $_POST['comments'];
            $referredby = $_POST['referredby'] == "" ? 0 : $_POST['referredby'];
            $batchid = $_POST['batchid'];

            $admissiondate = date_create_from_format("d/m/Y", $_POST['admissiondate']) != false ? date_format(date_create_from_format("d/m/Y", $_POST['admissiondate']), 'Y-m-d') : "1971-01-01";
            $reservationstatusid = 1;
            $scholarship = 0;
            $tuition_discount = $_POST['tuition_discount'];
            $hostel_discount = 0;
            $final_misc = 0;
            $created_by = $_SESSION['userdetails']->userid;

            $discountrequested = $_POST['discountrequested'];
            $discountgiven = $_POST['discountgiven'];

            $address_json = json_encode($address);
            $previous_class_information_json = json_encode($previous_class_information);

            $reservationModel = new ReservationModel();
            $insertId = $reservationModel->addReservationUser(
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
            );

            if ($insertId != 0) {
                $paymenttypeid = $_POST['paymenttypeid'];
                $paymentamount = $_POST['paymentamount'];
                // $paymentdate = date_create_from_format("d/m/Y", $_POST['paymentdate']) != false ? date_format(date_create_from_format("d/m/Y", $_POST['paymentdate']), 'Y-m-d') : date('Y-m-d');
                $paymentdate = date('Y-m-d');
                $otherdetails = $_POST['otherdetails'];

                $paymentcollectedby = $_SESSION['userdetails']->userid;
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
                    0,
                    'Booking Amount'
                );

                if ($result->resultID) {
                    $nextpaymentid = $helperModel->set_paymentidcounter();
                }
                
                 $studentDetails = $reservationModel->getReservationDetails($insertId);
            $comm = new Comm();
			$data[0] = $studentDetails->mobile1;
			$data[1] = $paymentamount;
			$data[2] = $studentDetails->reservation_ukey;
			// $data[3] = base_url("receipt_files/{$paymentid}.pdf");
			$data[3] = "rb.gy/o0uabr?p=" . $reservation_paymentid;

			$comm->sendSMS("PaymentConfirm", $data);
            }

            return redirect()->to(base_url("users/reservationDetails?id=" . $insertId));
        }
    }
    
    
    public function createapplicationreservation($reservationid)
    {
      //  ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
       // if ($_SESSION['agentdetails'] != null) {
            $db = db_connect();
           // $query1 = $db->query("SELECT * FROM `applications` where is_migrate=0 and reservationstatusid=5 and branchid=13 ");
		//	$results = $query1->getResult();
             $usersModel = new UsersModel();
              $reservationModel = new ReservationModel();
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
            $visitornumber =$StudentDetail->visitornumber;
            
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
            $permanent['village_mandal'] =$permanentAddress->village_mandal;
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
            $reservationstatusid = 1;
            $scholarship = 0;
            $tuition_discount = $StudentDetail->tuition_discount;
            $hostel_discount = 0;
            $final_misc = 0;
            $created_by = $_SESSION['agentdetails']->userid;

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
                $paymentamount =$PaymentDetail[0]->paymentamount;
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
                    0,
                    'Booking Amount'
                );

                if ($result->resultID) {
                    $nextpaymentid = $helperModel->set_paymentidcounter();
                }
                
                  $reservationModel->updateApplication1(
                $reservationid);
            }

           // return redirect()->to(base_url("agentdashboard/Applications"));
        
    }
    
     public function createmigratestudent()
    {
        
        $reservationid = $_POST['id'];
        $reservationModel = new ReservationModel();
        $StudentDetail = $reservationModel->getReservationDetails($reservationid);
        $helperModel = new HelperModel();
            $uniqueid = $helperModel->generateUniqueId();

            $random = rand(0, 999999);
            $now = date('dmYHisu') . $random;
            $username = "USR-" . $now;
            $password = md5($username);
            $roleid = 5;

            $usersModel = new UsersModel();
            $userid = $usersModel->addUser($uniqueid, $username, $password, $roleid);
            
            //$applicationnumber = $_POST['applicationnumber'];
            $reservation_ukey = $StudentDetail->reservation_ukey;
            $split = explode("-",$StudentDetail->reservation_ukey);
            if($split[1] !='')
            {
            $applicationnumber = $split[1];
            }else
            {
                $applicationnumber = $_POST['applicationnumber'];
            }
            $studentaadhaar = $StudentDetail->studentaadhaar;

            $admissiontypeid =$StudentDetail->admissiontypeid;
            $branchid = $StudentDetail->branchid;
            $batchid =  $StudentDetail->batchid;
            $courseid =  $StudentDetail->courseid;
            $sectionid =  $StudentDetail->sectionid;

            $usersModel->addStudentApplicationDetails(
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
            );

            $data = [];
            $data['name'] =  $StudentDetail->name;
            $data['genderid'] =  $StudentDetail->genderid;
            $usersModel->dynamicStudentDetailsUpdate($data, $userid);

            $data = [];
            $data['mobile1'] =$StudentDetail->mobile1;
            $data['mobile2'] = $StudentDetail->mobile2;
            $data['email'] = $StudentDetail->email;
            $usersModel->dynamicStudentDetailsUpdate($data, $userid);

            $data = [];
            $data['admissiondate'] = $StudentDetail->admissiondate;
            $data['secondlanguageid'] = $StudentDetail->secondlanguageid;
            $data['referredby'] = $StudentDetail->referredby == "" ? 0 : $StudentDetail->referredby;
            $usersModel->dynamicStudentDetailsUpdate($data, $userid);

            $data = [];
            $data['scholarship'] = $StudentDetail->scholarship;
            $data['tuition_discount'] = $_POST['tuition_discount'];
            $data['ipe_discount'] =  $_POST['ipe_discount'];
            $data['hostel_discount'] = $admissiontypeid == "1" ? $_POST['hostel_discount'] : "0";
            $data['comments'] = $StudentDetail->comments; 
            $data['rezofastdetails'] = $StudentDetail->rezofastdetails; 
            $usersModel->dynamicStudentDetailsUpdate($data, $userid);

            $discountgiven = $StudentDetail->discountgiven; 
            if ($discountgiven != 0) {
                $helperModel->add_discountLog($discountgiven, $userid);
            }

            $data = [];
            $data['dateofbirth'] = $StudentDetail->dateofbirth;
            $data['categoryid'] = $StudentDetail->categoryid; 
            $data['nationalityid'] = $StudentDetail->nationalityid; 
            $data['religionid'] = $StudentDetail->religionid; 
            $usersModel->dynamicStudentDetailsUpdate($data, $userid);

            $data = [];
            $data['fathername'] =$StudentDetail->fathername; 
            $data['mothername'] = $StudentDetail->mothername; 
            $data['parentoccupation'] = $StudentDetail->parentoccupation; 
            $usersModel->dynamicStudentDetailsUpdate($data, $userid);

            $previous_class_information = [];
            $class = [];
            $class['class'] = 'PCI';
            $class['board'] = $_POST['board'];
            $class['school'] = $_POST['school'];
            $class['place'] = $_POST['place'];
            $class['grade'] = $_POST['grade'];
            $class['hallticketNo'] = $_POST['hallticketNo'];
            array_push($previous_class_information, $class);

            $address = [];
            $permanent['door_street'] = $_POST['door_street'];
            $permanent['state'] = $_POST['state'];
            $permanent['district'] = $_POST['district'];
            $permanent['city_town'] = $_POST['city_town'];
            $permanent['village_mandal'] = $_POST['village_mandal'];
            $permanent['pin'] = $_POST['pin'];
            $permanent['landmark'] = $_POST['landmark'];
            $address['permanent'] = $permanent;

            $cheque_details = [];

            $data = [];
            $data['cheque_details'] = json_encode($cheque_details);
            $usersModel->dynamicStudentDetailsUpdate($data, $userid);

            $data = [];
            $data['address'] = json_encode($address);
            $usersModel->dynamicStudentDetailsUpdate($data, $userid);

            $data = [];
            $data['previous_class_information'] = json_encode($previous_class_information);
            $usersModel->dynamicStudentDetailsUpdate($data, $userid);
            $comments =  $StudentDetail->comments;

            $applicationstatusid = 4;
            $usersModel->approveReservationStudent($userid, $comments, $applicationstatusid);
            $PaymentDetail = $reservationModel->getReservationPaymentDetailsByReservationId($reservationid);

        foreach ($PaymentDetail as $result) :
            $paymenttypeid = $result->paymenttypeid;
            $paymentamount = $result->paymentamount;
            $paymentdate = $result->paymentdate;
            $otherdetails = $result->otherdetails;

            $paymentcollectedby = $result->paymentcollectedby;
            $paymentstatusid = $result->paymentstatusid;
            $paymentid = $result->reservation_paymentid;
            $createddate = $result->createddate;
            $batchid = $result->batchid;
            $paymentsModel = new PaymentsModel();
            $result = $paymentsModel->addPaymentNew($paymentid, $userid, 2, $paymentamount, $paymentdate, $paymenttypeid, $otherdetails, $paymentcollectedby, $paymentstatusid, $batchid, "Booking Amount",$createddate);
        endforeach; 
        $nextpaymentid = $helperModel->set_reservationnumbercounter();
        $reservationModel = new ReservationModel();
            $reservationModel->updateReservation1(
                $reservationid);
            return redirect()->to(base_url("users/studentdetails?id={$userid}"));
    }

    public function verifyStudentDetails()
    {
        $uniqueid = isset($_POST['uniqueid']) ? $_POST['uniqueid'] : "";

        $usersmodel = new UsersModel();
        $results = $usersmodel->getStudentDetailsByUniqueId($uniqueid);

        if ($uniqueid != "" && $results != null) {
            $userid = $results->userid;

            $reservationamount = $_POST['reservationamount'];

            $fathername = $_POST['fathername'];
            $mothername = $_POST['mothername'];
            $parentoccupation = $_POST['parentoccupation'];
            $dateofbirth = date_create_from_format("d/m/Y", $_POST['dateofbirth']) != false ? date_format(date_create_from_format("d/m/Y", $_POST['dateofbirth']), 'Y-m-d') : "1971-01-01";
            $genderid = $_POST['genderid'];
            $studentaadhaar = $_POST['studentaadhaar'];
            $nationalityid = $_POST['nationalityid'];
            $religionid = $_POST['religionid'];
            $categoryid = $_POST['categoryid'];
            $mobile2 = $_POST['mobile2'];

            $address = [];
            $permanent['door_street'] = $_POST['door_street'];
            $permanent['village_mandal'] = $_POST['village_mandal'];
            $permanent['landmark'] = $_POST['landmark'];
            $permanent['city_town'] = $_POST['city_town'];
            $permanent['state'] = $_POST['state'];
            $permanent['district'] = $_POST['district'];
            $permanent['pin'] = $_POST['pin'];

            $address['permanent'] = $permanent;

            $previous_class_information = [];
            $class = [];
            $class['class'] = 'PCI';
            $class['school'] = $_POST['school'];
            $class['board'] = $_POST['board'];
            $class['place'] = $_POST['place'];
            $class['grade'] = $_POST['grade'];
            $class['hallticketNo'] = $_POST['hallticketNo'];
            array_push($previous_class_information, $class);

            $address_json = json_encode($address);
            $previous_class_information_json = json_encode($previous_class_information);

            $usersmodel->updateStudent(
                $userid,
                NULL,
                $dateofbirth,
                $genderid,
                $nationalityid,
                $religionid,
                $categoryid,
                $studentaadhaar,
                $fathername,
                $mothername,
                $parentoccupation,
                $previous_class_information_json,
                $address_json,
                NULL,
                $mobile2
            );

            $_SESSION['reservationamount'] = $reservationamount;
            $_SESSION['userid'] = $userid;
            $_SESSION['batchid'] = $results->batchid;

            return redirect()->to(base_url("Razorpay/payReservationAmount"));
        } else {
            echo "User not found";
        }
    }

    public function updatereservation()
    {
        if ($_SESSION['userdetails'] != null) {

            $reservationid = $_POST['id'];
        if(isset($_POST['updatestudent'])){
            $name = $_POST['name'];
            $dateofbirth = date_create_from_format("d/m/Y", $_POST['dateofbirth']) != false ? date_format(date_create_from_format("d/m/Y", $_POST['dateofbirth']), 'Y-m-d') : "1971-01-01";
            $genderid = $_POST['genderid'];
            $nationalityid = $_POST['nationalityid'];
            $religionid = $_POST['religionid'];
            $categoryid = $_POST['categoryid'];
            $studentaadhaar = $_POST['studentaadhaar'];

            $fathername = $_POST['fathername'];
            $mothername = $_POST['mothername'];
            $parentoccupation = $_POST['parentoccupation'];
            $visitorname = $_POST['visitorname'];
            $relationwithstudent = $_POST['relationwithstudent'];
            $visitornumber = $_POST['visitornumber'];
            

            $previous_class_information = [];
            $class = [];
            $class['class'] = 'PCI';
            $class['school'] = $_POST['school'];
            $class['board'] = $_POST['board'];
            $class['place'] = $_POST['place'];
            $class['grade'] = $_POST['grade'];
            $class['hallticketNo'] = $_POST['hallticketNo'];
            array_push($previous_class_information, $class);

            $address = [];
            $permanent['door_street'] = $_POST['door_street'];
            $permanent['village_mandal'] = $_POST['village_mandal'];
            $permanent['landmark'] = $_POST['landmark'];
            $permanent['city_town'] = $_POST['city_town'];
            $permanent['state'] = $_POST['state'];
            $permanent['district'] = $_POST['district'];
            $permanent['pin'] = $_POST['pin'];

            $address['permanent'] = $permanent;

            $mobile1 = $_POST['mobile1'];
            $mobile2 = $_POST['mobile2'];
            $email = $_POST['email'];

            $admissiontypeid = $_POST['admissiontypeid'];
            $branchid = $_POST['branchid'];
            $courseid = $_POST['courseid'];
            $sectionid = $_POST['sectionid'];
            $secondlanguageid = $_POST['secondlanguageid'];
            $referredby = $_POST['referredby'];
            $batchid = $_POST['batchid'];

            $admissiondate = date_create_from_format("d/m/Y", $_POST['admissiondate']) != false ? date_format(date_create_from_format("d/m/Y", $_POST['admissiondate']), 'Y-m-d') : date('Y-m-d');

            $previous_class_information_json = json_encode($previous_class_information);
            $address_json = json_encode($address);

            $reservationstatusid = $_POST['reservationstatusid'];

            $reservationModel = new ReservationModel();
            $reservationModel->updateReservationDetails(
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
            );
        }else
        {
           
            $name = $_POST['name'];
            $dateofbirth = date_create_from_format("d/m/Y", $_POST['dateofbirth']) != false ? date_format(date_create_from_format("d/m/Y", $_POST['dateofbirth']), 'Y-m-d') : "1971-01-01";
            $genderid = $_POST['genderid'];
            $nationalityid = $_POST['nationalityid'];
            $religionid = $_POST['religionid'];
            $categoryid = $_POST['categoryid'];
            $studentaadhaar = $_POST['studentaadhaar'];

            $fathername = $_POST['fathername'];
            $mothername = $_POST['mothername'];
            $parentoccupation = $_POST['parentoccupation'];
            $visitorname = $_POST['visitorname'];
            $relationwithstudent = $_POST['relationwithstudent'];
            $visitornumber = $_POST['visitornumber'];
            

            $previous_class_information = [];
            $class = [];
            $class['class'] = 'PCI';
            $class['school'] = $_POST['school'];
            $class['board'] = $_POST['board'];
            $class['place'] = $_POST['place'];
            $class['grade'] = $_POST['grade'];
            $class['hallticketNo'] = $_POST['hallticketNo'];
            array_push($previous_class_information, $class);

            $address = [];
            $permanent['door_street'] = $_POST['door_street'];
            $permanent['village_mandal'] = $_POST['village_mandal'];
            $permanent['landmark'] = $_POST['landmark'];
            $permanent['city_town'] = $_POST['city_town'];
            $permanent['state'] = $_POST['state'];
            $permanent['district'] = $_POST['district'];
            $permanent['pin'] = $_POST['pin'];

            $address['permanent'] = $permanent;

            $mobile1 = $_POST['mobile1'];
            $mobile2 = $_POST['mobile2'];
            $email = $_POST['email'];

            $admissiontypeid = $_POST['admissiontypeid'];
            $branchid = $_POST['branchid'];
            $courseid = $_POST['courseid'];
            $sectionid = $_POST['sectionid'];
            $secondlanguageid = $_POST['secondlanguageid'];
            $referredby = $_POST['referredby'];
            $batchid = $_POST['batchid'];

            $admissiondate = date_create_from_format("d/m/Y", $_POST['admissiondate']) != false ? date_format(date_create_from_format("d/m/Y", $_POST['admissiondate']), 'Y-m-d') : date('Y-m-d');
            $scholarship = $_POST['scholarship'];
            $tuition_discount = $_POST['tuition_discount'];
            $hostel_discount = $admissiontypeid == "1" ? $_POST['hostel_discount'] : "0";
            $comments = $_POST['comments'];
            $rezofastdetails = $_POST['rezofastdetails'];
            $discountgiven = $_POST['discountgiven'];

            $previous_class_information_json = json_encode($previous_class_information);
            $address_json = json_encode($address);

            $reservationstatusid = $_POST['reservationstatusid'];

            $reservationModel = new ReservationModel();
            $reservationModel->updateReservation(
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
            );
        }

            return redirect()->to(base_url("users/reservationDetails?id={$reservationid}"));
        } else {
            return redirect()->to(base_url('home'));
        }
    }


    public function updatestudent($batchid)
    {
        if ($_SESSION['userdetails'] != null) {
            $userid = $_POST['userid'];
            $applicationstatusname = $_POST['applicationstatusname'];
            $applicationstatusid = $applicationstatusname == "Declined" ? 3 : 0;

            $name = $_POST['name'];
            $dateofbirth = date_create_from_format("d/m/Y", $_POST['dateofbirth']) != false ? date_format(date_create_from_format("d/m/Y", $_POST['dateofbirth']), 'Y-m-d') : "1971-01-01";
            $genderid = $_POST['genderid'];
            $nationalityid = $_POST['nationalityid'];
            $religionid = $_POST['religionid'];
            $categoryid = $_POST['categoryid'];
            $studentaadhaar = $_POST['studentaadhaar'];
            $room = $_POST['room'];
            $fathername = $_POST['fathername'];
            $mothername = $_POST['mothername'];
            $parentoccupation = $_POST['parentoccupation'];

            $previous_class_information = [];
            $class = [];
            $class['class'] = 'PCI';
            $class['school'] = $_POST['school'];
            $class['board'] = $_POST['board'];
            $class['place'] = $_POST['place'];
            $class['grade'] = $_POST['grade'];
            $class['hallticketNo'] = $_POST['hallticketNo'];
            array_push($previous_class_information, $class);

            $address = [];
            $permanent['door_street'] = $_POST['door_street'];
            $permanent['village_mandal'] = $_POST['village_mandal'];
            $permanent['landmark'] = $_POST['landmark'];
            $permanent['city_town'] = $_POST['city_town'];
            $permanent['state'] = $_POST['state'];
            $permanent['district'] = $_POST['district'];
            $permanent['pin'] = $_POST['pin'];

            $address['permanent'] = $permanent;

            $mobile1 = $_POST['mobile1'];
            $mobile2 = $_POST['mobile2'];
            $email = $_POST['email'];

            $admissiontypeid = $_POST['admissiontypeid'];
            $courseid = $_POST['courseid'];
            $secondlanguageid = $_POST['secondlanguageid'];
            $branchid = $_POST['branchid'];
            $sectionid = $_POST['sectionid'];

            $cheque_details = [];
            array_push($cheque_details, $_POST['cheque_1']);
            array_push($cheque_details, $_POST['cheque_2']);
            array_push($cheque_details, $_POST['cheque_3']);

            $tuition_discount = $_POST['tuition_discount'];
            $hostel_discount = $_POST['hostel_discount'];
            $comments = $_POST['comments'];

            $address_json = json_encode($address);
            $previous_class_information_json = json_encode($previous_class_information);
            $cheque_details_json = json_encode($cheque_details);

            $usersModel = new UsersModel();
            $usersModel->updateStudent(
                $userid,
                $name,
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
                $cheque_details_json,
                $tuition_discount,
                $hostel_discount,
                $comments,
                $applicationstatusid,
                $batchid
            );

            return redirect()->to(base_url("users/studentdetails?id={$userid}"));
        } else {
            return redirect()->to(base_url('home'));
        }
    }
    public function insertQuickStudent()
    {
        if ($_SESSION['userdetails'] != null) {
            $application_number = $_POST['application_number'];
            $tc_no = $_POST['tc_no'];
            $year = $_POST['year'];
            $admission_no = $_POST['admission_no'];
            $admission_year = $_POST['admission_year'];
            $college_code = $_POST['college_code'];
            $rc_no = $_POST['rc_no'];
            $address = $_POST['address'];
            $place = $_POST['place'];
            $district = $_POST['district'];
            $class = $_POST['class'];
            $admission_date = $_POST['admission_date'];
            $class_joined = $_POST['class_joined'];
            $scholarship = $_POST['scholarship'];
            $concession = $_POST['concession'];
            $date_left = $_POST['date_left'];
            $tc_date = $_POST['tc_date'];
            $conduct = $_POST['conduct'];
            $name = $_POST['name'];
            $fathername = $_POST['fathername'];
            $mothername = $_POST['mothername'];
            $caste = $_POST['caste'];
            $subcaste = $_POST['subcaste'];
            $dob = $_POST['dob'];
            $nationality = $_POST['nationality'];
            $medium = $_POST['medium'];
            $eligible =  $_POST['eligible'];
            $qualified = $_POST['qualified'];
            $mothertounge = $_POST['mothertounge'];
            $firstlanguage = $_POST['firstlanguage'];
            $secondlanguage = $_POST['secondlanguage'];
            $optionals = $_POST['optionals'];
            $usersModel = new UsersModel();
           $id = $usersModel->insertQuickStudent(
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
            );

            return redirect()->to(base_url("users/studentdetails?id={$id}"));
        } else {
            return redirect()->to(base_url('home'));
        }
    }
    public function getcollgecode()
    {
      $id =  $_POST['id'];
      $db = db_connect();

                    $query = $db->query("SELECT * FROM tc_table 
                                     where college_code = '{$id}'");
                    $result = $query->getRowArray();
                    print_r(json_encode($result));
                    $db->close();
    }
    
     public function gettcno()
    {
      $id =  $_POST['id'];
      $db = db_connect();

                    $query = $db->query("SELECT max(tc_no) as tc_no FROM tc_table 
                                     where college_code = '{$id}'");
                    $result = $query->getRowArray();
                    print_r(json_encode($result));
                    $db->close();
    }
    public function updateQuickstudent()
    {
        if ($_SESSION['userdetails'] != null) {
            $userid = $_POST['userid'];
            $name = $_POST['name'];
            $fathername = $_POST['fathername'];
            $mothername = $_POST['mothername'];
            $caste = $_POST['caste'];
            $subcaste = $_POST['subcaste'];
            $dob = $_POST['dob'];
            $nationality = $_POST['nationality'];
            $medium = $_POST['medium'];
            $eligible =  $_POST['eligible'];
            $qualified =  $_POST['qualified'];
            $mothertounge = $_POST['mothertounge'];
            $firstlanguage = $_POST['firstlanguage'];
            $secondlanguage = $_POST['secondlanguage'];
            $optionals = $_POST['optionals'];
            $conduct = $_POST['conduct'];
            $usersModel = new UsersModel();
            $usersModel->updateQuickStudent(
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
            );

            return redirect()->to(base_url("users/studentdetails?id={$userid}"));
        } else {
            return redirect()->to(base_url('home'));
        }
    }

    public function uploadphoto()
    {
         $student_photo_doc = $_FILES['student_photo']['tmp_name'];

        // $userId = $_POST['student_id'];
        // if (!is_dir("uploads/{$userId}")) {
        //     mkdir("uploads/{$userId}");
        // }
        // move_uploaded_file($student_photo_doc, "uploads/{$userId}/photo.jpeg");

        // return redirect()->to(base_url("users/studentdetails?id={$userId}"));
    }

    public function userapprovalflow()
    {
        if ($_SESSION['userdetails'] != null) {
            $type = isset($_POST['approvestudent']) ? "Approve" : (isset($_POST['declinestudent']) ? "Decline" : "Update");

            $usersModel = new UsersModel();

            if ($type == "Approve") {
                $userid = $_POST['userid'];
                $comments = $_POST['comments'];

                $applicationstatusid = 4;
                $usersModel->approveStudent($userid, $comments, $applicationstatusid);

                $studentDetails = $usersModel->getStudentDetails($userid, $_SESSION['activebatch']);

                $comm = new Comm();
                $data[0] = $studentDetails[0]->mobile1;
                $data[1] = $studentDetails[0]->name;
                $data[2] = $studentDetails[0]->applicationnumber;
                $comm->sendSMS("Welcome", $data);

                // $html = file_get_contents(base_url("payments/print_invoice?invoiceid={$invoiceid}&batchid={$_SESSION['activebatch']}"));
                // $paymentsmodel = new PaymentsModel();
                // $paymentsmodel->htmltopdf($html, 'save', $invoiceid, 'I');
            } elseif ($type == "Decline") {
                $userid = $_POST['userid'];
                $comments = $_POST['comments'];
                $applicationstatusid = 2;

                $usersModel->declineStudent($userid, $comments, $applicationstatusid);
            }
        } else {
            return redirect()->to(base_url('home'));
        }
    }

    public function reservationapprovalflow()
    {
        if ($_SESSION['userdetails'] != null) {
            $type = isset($_POST['approvestudent']) ? "Approve" : (isset($_POST['declinestudent']) ? "Decline" : "Update");

            $reservationModel = new ReservationModel();

            if ($type == "Approve") {
                $reservationid = $_POST['reservationid'];
                $comments = $_POST['comments'];

                $reservationstatusid = 4;
                $reservationModel->approveReservation($reservationid, $comments, $reservationstatusid);
            } elseif ($type == "Decline") {
                $reservationid = $_POST['reservationid'];
                $comments = $_POST['comments'];
                $reservationstatusid = 3;

                $reservationModel->declineReservation($reservationid, $comments, $reservationstatusid);
            }
        } else {
            return redirect()->to(base_url('home'));
        }
    }
    public function bulkoutpass($formgroupid = null)
    {
         if ($_SESSION['userdetails'] != null) {
              if($formgroupid != '' || $formgroupid != null)
            {
            }else
            {
                $formsModel = new FormsModel();
                $data['forms'] = $formsModel->getbulkoutForms($_SESSION['userdetails']->userid);
                $data['page_name'] = 'Users/studentoutpass';
                return view('loggedinuser/index.php', $data);
            }
         }
    }
    public function createbulkoutpass()
    {
         if ($_SESSION['userdetails'] != null) {
                $helperModel = new HelperModel();
                $data1['lookups'] = $helperModel->get_lookups();
                $data1['branch'] = $data1['lookups']['branchlookup'];
                $data1['section'] = $data1['lookups']['sectionlookup'];
                $data1['page_name'] = 'Users/studentbulkoutpass';
                return view('loggedinuser/index.php', $data1);
         }
    }
    public function outpass()
    {
         if ($_SESSION['userdetails'] != null) {
            
                $formsModel = new FormsModel();
                $data['forms'] = $formsModel->getoutForms($_SESSION['userdetails']->userid);
                $data['page_name'] = 'Users/studentpass';
                return view('loggedinuser/index.php', $data);
            
         }
    }
     public function addremark()
    {
        if ($_SESSION['userdetails'] != null) {
            $userid = $_POST['userid'];
            $remarks = $_POST['remarks'];
            $date = date('Y-m-d H:i:s');
           $usersModel = new UsersModel();
            $usersModel->updateremark($userid,$remarks,$date);

            return redirect()->to(base_url("users/studentdetails?id={$userid}"));
        } else {
            return redirect()->to(base_url('home'));
        }
            
        
    }
    
     public function addidcard()
    {
        if ($_SESSION['userdetails'] != null) {
            $userid = $_POST['userid'];
            $rfid = $_POST['rfid'];
          
           $usersModel = new UsersModel();
          $isValidRFid = $usersModel->checkDuplicateRfid($rfid);
            if ($isValidRFid == 0) {
                 $usersModel->updateidcard($userid,$rfid);
                 return redirect()->to(base_url("users/studentdetails?id={$userid}"));
            }
           
             return redirect()->to(base_url("users/studentdetails?id={$userid}"));
        } else {
            return redirect()->to(base_url('home'));
        }
            
        
    }
     public function addrfidcard()
    {
        if ($_SESSION['userdetails'] != null) {
            $userid = $_POST['userid'];
            $rfid = $_POST['rfid'];
          
           $usersModel = new UsersModel();
          $isValidRFid = $usersModel->checkDuplicateRfidEmployee($rfid);
            if ($isValidRFid == 0) {
                 $usersModel->updaterfidcard($userid,$rfid);
                 return redirect()->to(base_url("users/employeedetails/{$userid}"));
            }
           
             return redirect()->to(base_url("users/studentdetails/{$userid}"));
        } else {
            return redirect()->to(base_url('home'));
        }
            
        
    }
    public function getinvoicevalue()
    {
        if ($_SESSION['userdetails'] != null) {
            $invoiceid = $_POST['invoiceid'];
            $userid = $_POST['userid'];
            $usersModel = new UsersModel();
          $isValidRFid = $usersModel->getinvoicevalue($invoiceid,$userid);
                    print_r(json_encode($isValidRFid));
        } else {
            return redirect()->to(base_url('home'));
        }
    }
    public function addaccount()
    {
        if ($_SESSION['userdetails'] != null) {
            $userid = $_POST['userid'];
            $bank_name = $_POST['bank_name'];
            $branch_name = $_POST['branch_name'];
            $account_no = $_POST['account_no'];
            $ifsc_code = $_POST['ifsc_code'];
            if($_POST['is_active']==true)
           {
                $is_active = 1;
           }else
           {
                $is_active = 0;
           }
           $usersModel = new UsersModel();
            $usersModel->addBankAccount($userid,$bank_name,$branch_name,$account_no,$ifsc_code,$is_active);
             return redirect()->to(base_url("users/employeedetails/{$userid}"));
             return redirect()->to(base_url("users/studentdetails/{$userid}"));
        } else {
            return redirect()->to(base_url('home'));
        }
    }
    public function editaccount()
    {
        if ($_SESSION['userdetails'] != null) {
            $userid = $_POST['userid'];
            $bank_name = $_POST['bank_name'];
            $branch_name = $_POST['branch_name'];
            $account_no = $_POST['account_no'];
            $ifsc_code = $_POST['ifsc_code'];
            $id = $_POST['accountid'];
            if($_POST['is_active']==true)
           {
                $is_active = 1;
           }else
           {
                $is_active = 0;
           }
           $usersModel = new UsersModel();
            $usersModel->editBankAccount($id,$bank_name,$branch_name,$account_no,$ifsc_code,$is_active);
             return redirect()->to(base_url("users/employeedetails/{$userid}"));
             return redirect()->to(base_url("users/studentdetails/{$userid}"));
        } else {
            return redirect()->to(base_url('home'));
        }
    }
    public function addsalarystructure()
    {
        if ($_SESSION['userdetails'] != null) {
            
            $userid = $_POST['userid'];
            $basic = $_POST['basic'];
            $hra = $_POST['hra'];
            $specialallowance = $_POST['specialallowance'];
            $travelallowance = $_POST['travelallowance'];
            $tds = $_POST['tds'];
            $pt = $_POST['pt'];
            $usersModel = new UsersModel();
             $usersModel->updateActiveSalary($userid);
            $usersModel->addSalaryStructure($userid,$basic,$hra,$specialallowance,$travelallowance,$pt,$tds);
             return redirect()->to(base_url("users/employeedetails/{$userid}"));
             return redirect()->to(base_url("users/studentdetails/{$userid}"));
        } else {
            return redirect()->to(base_url('home'));
        }
    }
    public function editsalarystructure()
    {
        if ($_SESSION['userdetails'] != null) {
             $usersModel = new UsersModel();
             $userid = $_POST['userid'];
            if($_POST['is_active']==true)
           {
                $is_active = 1;
           }else
           {
                $is_active = 0;
           }
           if($is_active==1){
           $usersModel->updateActiveSalary($userid);
           }
            $tds = $_POST['tds'];
            $pt = $_POST['pt'];
            $basic = $_POST['basic'];
            $hra = $_POST['hra'];
            $specialallowance = $_POST['specialallowance'];
            $travelallowance = $_POST['transportallowance'];
            $id = $_POST['accountid'];
            
          
            $usersModel->editSalaryStructure($id,$basic,$hra,$specialallowance,$travelallowance,$pt,$tds,$is_active);
             return redirect()->to(base_url("users/employeedetails/{$userid}"));
             return redirect()->to(base_url("users/studentdetails/{$userid}"));
        } else {
            return redirect()->to(base_url('home'));
        }
    }
    public function addinsurance()
    {
        if ($_SESSION['userdetails'] != null) {
            
            $userid = $_POST['userid'];
            $policy_no = $_POST['policy_no'];
            $provider = $_POST['provider'];
            $url = $_POST['url'];
            $usersModel = new UsersModel();
             $usersModel->updateActiveSalary($userid);
            $usersModel->addInsurance($userid,$policy_no,$provider,$url);
             return redirect()->to(base_url("users/employeedetails/{$userid}"));
             return redirect()->to(base_url("users/studentdetails/{$userid}"));
        } else {
            return redirect()->to(base_url('home'));
        }
    }
    public function editinsurance()
    {
        if ($_SESSION['userdetails'] != null) {
             $usersModel = new UsersModel();
             $userid = $_POST['userid'];
            if($_POST['is_active']==true)
           {
                $is_active = 1;
           }else
           {
                $is_active = 0;
           }
           if($is_active==1){
           $usersModel->updateActiveSalary($userid);
           }
            $tds = $_POST['tds'];
            $pt = $_POST['pt'];
            $basic = $_POST['basic'];
            $hra = $_POST['hra'];
            $specialallowance = $_POST['specialallowance'];
            $travelallowance = $_POST['transportallowance'];
            $id = $_POST['accountid'];
            
          
            $usersModel->editSalaryStructure($id,$basic,$hra,$specialallowance,$travelallowance,$pt,$tds,$is_active);
             return redirect()->to(base_url("users/employeedetails/{$userid}"));
             return redirect()->to(base_url("users/studentdetails/{$userid}"));
        } else {
            return redirect()->to(base_url('home'));
        }
    }
    public function onboardemployee()
    {
        if (isset($_SESSION['userdetails'])) {
            $data['page_name'] = 'Users/onboardemployee';

            $helperModel = new HelperModel();

            $data['nextemployeeid'] = $helperModel->get_nextemployeeidcounter();
            $data['lookups'] = $helperModel->get_lookups();
            $usersModel = new UsersModel();
            $data['EmployeeDetails'] = $usersModel->getAllOnBoardEmployeeDetails();
            $download = (isset($_GET['download']) && $_GET['download'] != "") ? $_GET['download'] : NULL;

            if ($download == 1) {
                $setData = '';
                foreach ($data['EmployeeDetails'] as $key => $rec) {
                    if ($key == 0) {
                        $rowData = '';
                        foreach ($rec as $key => $value) {

                            $key = '"' . $key . '"' . "\t";
                            $rowData .= $key;
                        }
                        $setData .= trim($rowData) . "\n";
                    }

                    $rowData = '';
                    foreach ($rec as $key => $value) {
                        $value = '"' . $value . '"' . "\t";
                        $rowData .= $value;
                    }
                    $setData .= trim($rowData) . "\n";
                }

                header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=Employee_OnBoard_Report.xls");
                header("Pragma: no-cache");
                header("Expires: 0");
                echo $setData . "\n";
            } else {
                return view('loggedinuser/index.php', $data);
            }
        } else {
            return redirect()->to(base_url('home'));
        }
    }
    public function updateonboardemployee()
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $dob = $_POST['dateofbirth'];
        $aadhar = $_POST['aadhaar'];
        $bloodgroup = $_POST['bloodgroup'];
        $pancard = $_POST['pancard'];
        $gender = $_POST['genderid'];
        $mandal = $_POST['mandal'];
        $h_no = $_POST['h_no'];
        $village = $_POST['village'];
        $district = $_POST['district'];
        $state = $_POST['state'];
        $pincode = $_POST['pincode'];
        $father = $_POST['father'];
        $mother = $_POST['mother'];
        $spouse = $_POST['spouse'];
        $userid = $_POST['userid'];
        $usersModel = new UsersModel();
        $student_photo_doc = $_FILES['profile_image']['tmp_name'];
        if (!is_dir("uploads/{$userid}")) {
            mkdir("uploads/{$userid}");
        }
        move_uploaded_file($student_photo_doc, "uploads/{$userid}/photo.jpeg");
        $usersModel->updateOnBoardEmployee($userid, $name, $email, $dob,$gender, $pancard,$bloodgroup, $aadhar, $h_no, $village, $mandal, $district, $state, $pincode, $father, $mother, $spouse);
       
    }
     public function updateonboardemployeedetails()
    {
        $userid = $_POST['userid'];
        $mobile = $_POST['mobile'];
        $employee_id = $_POST['employee_id'];
        $usersModel = new UsersModel();
        $branchid = COUNT($_POST['branchid']) == 0 ? "" : implode(',', $_POST['branchid']);
            if (!empty($_POST['sunday']) &&  $_POST['sunday'] == true) {
                $sunday = 0;
            } else {
                $sunday = 1;
            }
            if (!empty($_POST['monday']) &&  $_POST['monday'] == true) {
                $monday = 0;
            } else {
                $monday = 1;
            }
            if (!empty($_POST['tuesday']) &&  $_POST['tuesday'] == true) {
                $tuesday = 0;
            } else {
                $tuesday = 1;
            }
            if (!empty($_POST['wednesday']) &&  $_POST['wednesday'] == true) {
                $wednesday = 0;
            } else {
                $wednesday = 1;
            }
            if (!empty($_POST['thursday']) &&  $_POST['thursday'] == true) {
                $thursday = 0;
            } else {
                $thursday = 1;
            }
            if (!empty($_POST['friday']) &&  $_POST['friday'] == true) {
                $friday = 0;
            } else {
                $friday = 1;
            }
            if (!empty($_POST['saturday']) &&  $_POST['saturday'] == true) {
                $saturday = 0;
            } else {
                $saturday = 1;
            }

            $roleid = $_POST['roleid'];
            $designation = $_POST['designation'];
            $totalleaves = $_POST['totalleaves'];
            $joiningdate = $_POST['joiningdate'];
            $login_time = $_POST['logintime'];
            $logout_time = $_POST['logouttime'];
            $reportperson = $_POST['reportperson'];
            $username = $mobile.'@gmail.com';
            $password = md5($mobile);
            $usersModel->updateUser($userid, $username, $password, $roleid);
            $usersModel->updateOnBoardEmployeeDetails($userid, $employee_id,$branchid,$designation,$totalleaves, $joiningdate,$login_time, $logout_time, $reportperson,$sunday, $monday, $tuesday, $wednesday, $thursday, $friday, $saturday);
            $helperModel = new HelperModel();
            $nextpaymentid = $helperModel->set_nextemployeeid();

    }
    public function onboardemployeedetails()
    {
        if (isset($_GET['uniqueid'])) {
            $uniqueid = $_GET['uniqueid'];
            $usersModel = new UsersModel();
            $data['details'] = $usersModel->getOnboardEmployee($uniqueid);
            $branchid = (isset($_GET['branchid']) && $_GET['branchid'] != "") ? $_GET['branchid'] : NULL;
            $roleid = (isset($_GET['roleid']) && $_GET['roleid'] != "") ? $_GET['roleid'] : NULL;
            $active = (isset($_GET['active']) && $_GET['active'] != "") ? $_GET['active'] : 1;
            $data['EmployeeDetails'] = $usersModel->getAllEmployeeDetailsfilter($branchid, $roleid, $active);
            $helperModel = new HelperModel();
            $data['nextemployeeid'] = $helperModel->get_nextemployeeidcounter();
            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();
            $data['page_name'] = 'employeeonboardformdetails';
            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('home'));
        }
    }
     public function createonboardemployee()
    {
        if (isset($_SESSION['userdetails'])) {
            $employee_id = '';
            $mobile = $_POST['mobile'];
            $usersModel = new UsersModel();
            $helperModel = new HelperModel();
            $uniqueid = $helperModel->generateUniqueId();
            $userid = $usersModel->addOnboardUser($uniqueid);
            $usersModel->addOnboardEmployee($userid, $mobile, $employee_id);

           // $nextpaymentid = $helperModel->set_nextemployeeid();
            return redirect()->to(base_url('users/employee'));
        } else {
            return redirect()->to(base_url('home'));
        }
    }
    public function onboardemployeeform()
    {
        if (isset($_GET['uniqueid'])) {
            $uniqueid = $_GET['uniqueid'];
            $usersModel = new UsersModel();
            $data['details'] = $usersModel->getOnboardEmployee($uniqueid);
            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();
            $data['page_name'] = 'employeeonboardfrom';
            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('home'));
        }
    }
    public function payment_status_changed()
    {
         $db = db_connect();
        //get hidden values in variables
    	$id = $_POST['id'];
    	$status = $_POST['status'];
        //check condition
    	if($status == '1'){
    		$user_status = '0';
    	}
    	else{
    		$user_status = '1';
    	}
        $usersModel = new UsersModel();
        $usersModel->updatePaymentstatus($id, $user_status);
        return redirect()->to(base_url('admin/paymentgateway'));
    }
}
