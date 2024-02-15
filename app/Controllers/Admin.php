<?php
namespace App\Controllers;

use CodeIgniter\Controller;

require '../vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Aws\S3\Exception\S3Exception;
use App\Models\AdminModel;
use App\Models\EmailModel;
use App\Models\HelperModel;
use App\Models\PaymentsModel;
use App\Models\UsersModel;
use DateTime;

class Admin extends BaseController
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
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function roles()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'roles';

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }
    
    public function announcements()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'announcements';

            $adminModel = new AdminModel();
            $data['announcements'] = $adminModel->get_announcements();

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }
    public function counsollermapping()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'counsollermapping';

            $adminModel = new AdminModel();
            $data['counsollermapping'] = $adminModel->get_counsollermapping();
            $usersModel = new UsersModel();
            $data['EmployeeDetail'] = $usersModel->getAllEmployeeDetails();

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }
    public function concerns()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'concerns';
        	$model = new AdminModel();
			$data['concerns'] = $model->concernslist();
			 $usersModel = new UsersModel();
            $data['EmployeeDetail'] = $usersModel->getAllEmployeeDetails();
			 return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }
    
    // public function concern_status_changed()
    // {
    //      $db = db_connect();
    //     //get hidden values in variables
    // 	$id = $_POST['id'];
    // 	$status = $_POST['status'];
    // 	$student_id = $_POST['student_id'];
    //     $data['status'] = $status;
    //     $builder = $db->table('concerns');
    //     $builder->where('id', $id);
    //     $builder->update($data);
    //     $db = db_connect();
    //     $query1 = $db->query("SELECT name,firebase FROM `studentdetails` where userid = '$student_id'");
    //     $results = $query1->getResult();
    //     $token = $results[0]->firebase;
    //         if($token != ''){
    //             $message = "Concern";
    //             $description =  "Your issue is resolved, we are closing the concern Thank you.";
    //             $google_api_key = "AAAAVgjSTtk:APA91bHDVyLfnWLl4NzHOHA8oE8-vMdqUXSNs2Z016_ecAQKstmNj4aQztNcTY_WC6nj-zl0XkAux4OlTqMQDzKSlVkU5xpq0Ya-IpNC7LxiA95dzW9LIpg8YLK1G8JJ9Uhml-CzrAgr";
    //             $registrationIds = $token;
    //             #prep the bundle
    //             $msg = array
    //                 (
    //                 'body'  => $description,
    //                 'title' => $message,
    //                 'sound' => 1/*Default sound*/
    //                 );
                  
    //             $fields = array
    //                 (
    //                 'to'            => $registrationIds,
    //                 'notification'  => $msg
    //                 );
    //             $headers = array
    //                 (
    //                 'Authorization: key=' . $google_api_key,
    //                 'Content-Type: application/json'
    //                 );
    //             #Send Reponse To FireBase Server
    //             $ch = curl_init();
    //             curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
    //             curl_setopt( $ch,CURLOPT_POST, true );
    //             curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
    //             curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
    //             curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
    //             curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
    //             $result = curl_exec ( $ch );
    //             curl_close ( $ch );
    //          }
    //     return redirect()->to(base_url('admin/concerns'));
    // }
    
    public function concern_status_changed()
    {
         $db = db_connect();
        //get hidden values in variables
    	$id = $_POST['id'];
        $userid = $_POST['userid'];
    	//$status = $_POST['status'];
    	//$student_id = $_POST['student_id'];
        $data['assigned_to'] = $userid;
        $builder = $db->table('concerns');
        $builder->where('id', $id);
        $builder->update($data);
       
        // $query1 = $db->query("SELECT name,firebase FROM `studentdetails` where userid = '$student_id'");
        // $results = $query1->getResult();
        // $token = $results[0]->firebase;
        //     if($token != ''){
        //         $message = "Concern";
        //         $description =  "Your issue is resolved, we are closing the concern Thank you.";
        //         $google_api_key = "AAAAVgjSTtk:APA91bHDVyLfnWLl4NzHOHA8oE8-vMdqUXSNs2Z016_ecAQKstmNj4aQztNcTY_WC6nj-zl0XkAux4OlTqMQDzKSlVkU5xpq0Ya-IpNC7LxiA95dzW9LIpg8YLK1G8JJ9Uhml-CzrAgr";
        //         $registrationIds = $token;
        //         #prep the bundle
        //         $msg = array
        //             (
        //             'body'  => $description,
        //             'title' => $message,
        //             'sound' => 1/*Default sound*/
        //             );
                  
        //         $fields = array
        //             (
        //             'to'            => $registrationIds,
        //             'notification'  => $msg
        //             );
        //         $headers = array
        //             (
        //             'Authorization: key=' . $google_api_key,
        //             'Content-Type: application/json'
        //             );
        //         #Send Reponse To FireBase Server
        //         $ch = curl_init();
        //         curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        //         curl_setopt( $ch,CURLOPT_POST, true );
        //         curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        //         curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        //         curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        //         curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        //         $result = curl_exec ( $ch );
        //         curl_close ( $ch );
        //      }
        return redirect()->to(base_url('admin/concerns'));
    }
    
    public function holidays()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'holidays';

            $adminModel = new AdminModel();
            $data['holidays'] = $adminModel->get_holidays();

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }
    
    public function updateannouncement()
    {
        if ($_SESSION['userdetails'] != null) {
            $id = $_POST['id'];

            $message = $_POST['message'];
            $description = $_POST['description'];

            $adminModel = new AdminModel();
            $adminModel->updateannouncement(
                $id,
                $message,
                $description
            );

            return redirect()->to(base_url('admin/announcements'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }
    public function updatecounsollermapping()
    {
        if ($_SESSION['userdetails'] != null) {
            $id = $_POST['id'];
             $db = db_connect();
             $date = date('Y-m-d H:i:s');
            $query1 = $db->query("update counsellor_mapping set is_active=0,update_at='$date' where id = '$id'");
            $name = $_POST['name'];
            $userid = $_POST['userid'];
            $adminModel = new AdminModel();
            $adminModel->addcounsollermapping($userid,$name);
            return redirect()->to(base_url('admin/counsollermapping'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function deleteannouncement()
    {
        if ($_SESSION['userdetails'] != null) {
            $id = $_GET['id'];

            $adminModel = new AdminModel();
            $adminModel->deleteannouncement($id);

            return redirect()->to(base_url('admin/announcements'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }
    
    public function materialrequisitionlist()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'materialrequisitionlist';

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }
    

    public function rights()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'rights';
            $data['roleid'] = $_GET['roleid'];

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function class()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Admin/class';

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            $adminModel = new AdminModel();
            $data['classes'] = $adminModel->get_classes();

            $usersModel = new UsersModel();
            $data['teachers'] = $usersModel->get_teachers();

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function enrol()
    {
        if ($_SESSION['userdetails'] != null) {
            $classid = (isset($_GET['classid']) && $_GET['classid'] != "") ? $_GET['classid'] : NULL;
            $batchid = (isset($_GET['batchid']) && $_GET['batchid'] != "") ? $_GET['batchid'] : NULL;
            $branchid = (isset($_GET['branchid']) && $_GET['branchid'] != "") ? $_GET['branchid'] : NULL;
            $courseid = (isset($_GET['courseid']) && $_GET['courseid'] != "") ? $_GET['courseid'] : NULL;
            $sectionid = (isset($_GET['sectionid']) && $_GET['sectionid'] != "") ? $_GET['sectionid'] : NULL;
            $subjectid = (isset($_GET['subjectid']) && $_GET['subjectid'] != "") ? $_GET['subjectid'] : NULL;
            $teacherid = (isset($_GET['teacherid']) && $_GET['teacherid'] != "") ? $_GET['teacherid'] : NULL;

            $data['page_name'] = 'Admin/enrol';

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            $adminModel = new AdminModel();
            $data['classes'] = $adminModel->get_classes();
            $data['enrollments'] = $adminModel->get_enrollments(
                $classid,
                $batchid,
                $branchid,
                $courseid,
                $sectionid,
                $subjectid,
                $teacherid
            );

            $usersModel = new UsersModel();
            $data['teachers'] = $usersModel->get_teachers();
            $data['students'] = $usersModel->getAllStudentDetails();

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function promote()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'promote';

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            $usersModel = new UsersModel();
            $data['StudentDetails'] = $usersModel->getAllStudentDetails();

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function sms()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Admin/smstemplate';

            $adminModel = new AdminModel();
            $data['smstemplates'] = $adminModel->get_smstemplates();

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function email()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Admin/emailtemplate';

            $adminModel = new AdminModel();
            $data['emailtemplates'] = $adminModel->get_emailtemplates();

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function promotestudents()
    {
        if ($_SESSION['userdetails'] != null) {
            $userIds = $_POST['userid'];
            $batchid = $_POST['batchid'];

            foreach ($userIds as $userid) {
                $usermodel = new UsersModel();
                $invoiceid = $usermodel->promoteUser($userid, $batchid);

                $html = file_get_contents(base_url("payments/print_invoice?invoiceid={$invoiceid}&batchid={$batchid}"));
                $paymentsmodel = new PaymentsModel();
                $paymentsmodel->htmltopdf($html, 'save', $invoiceid, 'I');

                // $emailmodel = new EmailModel();
                // $emailmodel->sendStudentPromotionEmail($userid, $invoiceid);
            }
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function createrole()
    {
        if ($_SESSION['userdetails'] != null) {
            $rolename = $_POST['rolename'];

            $adminModel = new AdminModel();
            $adminModel->addRole($rolename);

            return redirect()->to(base_url('admin/roles'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }
    
    public function createannouncement()
    {
        if ($_SESSION['userdetails'] != null) {
            $message = $_POST['message'];
            $description = $_POST['description'];
            $date = $_POST['date'];
            $orgDate = $date;  
            $newDate = date("d-m-Y", strtotime($orgDate));  
            $adminModel = new AdminModel();
            $adminModel->addAnnouncement($message,$description,$newDate);
        $StudentDetails = $adminModel->getAllStudentDetailsone();
        foreach($StudentDetails as $StudentDetail)
        {
             $token = $StudentDetail->firebase;
             if($token != ''){
        
          $google_api_key = "AAAAVgjSTtk:APA91bHDVyLfnWLl4NzHOHA8oE8-vMdqUXSNs2Z016_ecAQKstmNj4aQztNcTY_WC6nj-zl0XkAux4OlTqMQDzKSlVkU5xpq0Ya-IpNC7LxiA95dzW9LIpg8YLK1G8JJ9Uhml-CzrAgr";
                $registrationIds = $token;
                #prep the bundle
                $msg = array
                    (
                    'body'  => $description,
                    'title' => $message,
                    'sound' => 1/*Default sound*/
                    );
                    
                $fields = array
                    (
                    'to'            => $registrationIds,
                    'notification'  => $msg
                    );

                $headers = array
                    (
                    'Authorization: key=' . $google_api_key,
                    'Content-Type: application/json'
                    );
                #Send Reponse To FireBase Server
                $ch = curl_init();
                curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
                curl_setopt( $ch,CURLOPT_POST, true );
                curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
                curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
                $result = curl_exec ( $ch );
                print_r($result);
                curl_close ( $ch );
             }
        }

            return redirect()->to(base_url('admin/announcements'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }
    
    public function createcounsollermapping()
    {
        if ($_SESSION['userdetails'] != null) {
            $userid = $_POST['userid'];
            $name = $_POST['name'];
            $adminModel = new AdminModel();
            $adminModel->addcounsollermapping($userid,$name);
             return redirect()->to(base_url('admin/counsollermapping'));
        }else {
            return redirect()->to(base_url('dashboard'));
        }
    }
    
    public function createholiday()
    {
        if ($_SESSION['userdetails'] != null) {
            $message = $_POST['message'];
            $from_date = $_POST['from_date'];
            $to_date = $_POST['to_date'];
            $admissiontypeid = $_POST['admissiontypeid'];
            $adminModel = new AdminModel();
            $adminModel->addHoliday($message,$from_date,$to_date,$admissiontypeid);
            return redirect()->to(base_url('admin/holidays'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function createoperation()
    {
        if ($_SESSION['userdetails'] != null) {
            $operationName = $_POST['operationname'];
            $parent = $_POST['parent'] == "" ? 0 : $_POST['parent'];

            $adminModel = new AdminModel();
            $adminModel->addOperation($operationName, $parent);

            return redirect()->to(base_url('admin/roles'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function setrights()
    {
        if ($_SESSION['userdetails'] != null) {
            $operationid = $_POST['operationid'];
            $right = $_POST['right'];
            $roleid = $_POST['roleid'];
            $checked = $_POST['checked'] == "true" ? 1 : 0;

            $adminModel = new AdminModel();
            $adminModel->setRights($right, $checked, $roleid, $operationid);

            return true;
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }


    // CLASS
    public function addclass()
    {
        if ($_SESSION['userdetails'] != null) {
            $classname = $_POST['classname'];
            $classdescription = $_POST['classdescription'];

            $batchid = $_POST['batchid'];
            $branchid = $_POST['branchid'];
            $courseid = $_POST['courseid'];
            $sectionid = $_POST['sectionid'];
            $subjectid = $_POST['subjectid'];
            $teacherid = $_POST['teacherid'];

            $adminModel = new AdminModel();
            $adminModel->addclass(
                $classname,
                $classdescription,
                $batchid,
                $branchid,
                $courseid,
                $sectionid,
                $subjectid,
                $teacherid
            );

            return redirect()->to(base_url('admin/class'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function updateclass()
    {
        if ($_SESSION['userdetails'] != null) {
            $classid = $_POST['classid'];

            $classname = $_POST['classname'];
            $classdescription = $_POST['classdescription'];

            $batchid = $_POST['batchid'];
            $branchid = $_POST['branchid'];
            $courseid = $_POST['courseid'];
            $sectionid = $_POST['sectionid'];
            $subjectid = $_POST['subjectid'];
            $teacherid = $_POST['teacherid'];

            $adminModel = new AdminModel();
            $adminModel->updateclass(
                $classid,
                $classname,
                $classdescription,
                $batchid,
                $branchid,
                $courseid,
                $sectionid,
                $subjectid,
                $teacherid
            );

            return redirect()->to(base_url('admin/class'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function deleteclass()
    {
        if ($_SESSION['userdetails'] != null) {
            $id = $_GET['id'];

            $adminModel = new AdminModel();
            $adminModel->deleteclass($id);

            return redirect()->to(base_url('admin/class'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }
    // CLASS

    // ENROL
    public function addenrol()
    {
        if ($_SESSION['userdetails'] != null) {
            $classids = $_POST['classid'];
            $studentids = $_POST['studentid'];

            foreach ($classids as $classid) {
                foreach ($studentids as $studentid) {
                    $adminModel = new AdminModel();
                    $adminModel->enrol($classid, $studentid);
                }
            }

            return redirect()->to(base_url('admin/enrol'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function deleteenrol()
    {
        if ($_SESSION['userdetails'] != null) {
            $classid = $_GET['classid'];
            $studentid = $_GET['studentid'];

            $adminModel = new AdminModel();
            $adminModel->deleteenrol($classid, $studentid);

            return redirect()->to(base_url('admin/enrol'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }
    // ENROL

    // SMS Templates
    public function addsmstemplate()
    {
        if ($_SESSION['userdetails'] != null) {
            $smstemplatename = $_POST['smstemplatename'];
            $smstemplate = $_POST['smstemplate'];

            $adminModel = new AdminModel();
            $adminModel->addsmstemplate($smstemplatename, $smstemplate);

            return redirect()->to(base_url('admin/sms'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function updatesmstemplate()
    {
        if ($_SESSION['userdetails'] != null) {
            $smstemplateid = $_POST['smstemplateid'];

            $smstemplatename = $_POST['smstemplatename'];
            $smstemplate = $_POST['smstemplate'];

            $adminModel = new AdminModel();
            $adminModel->updatesmstemplate($smstemplateid, $smstemplatename, $smstemplate);

            return redirect()->to(base_url('admin/sms'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function deletesmstemplate()
    {
        if ($_SESSION['userdetails'] != null) {
            $smstemplateid = $_GET['smstemplateid'];

            $adminModel = new AdminModel();
            $adminModel->deletesmstemplate($smstemplateid);

            return redirect()->to(base_url('admin/sms'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }
    // SMS Templates

    // Email Templates
    public function addemailtemplate()
    {
        if ($_SESSION['userdetails'] != null) {
            $emailtemplatename = $_POST['emailtemplatename'];
            $emailtemplate = $_POST['emailtemplate'];

            $adminModel = new AdminModel();
            $adminModel->addemailtemplate($emailtemplatename, $emailtemplate);

            return redirect()->to(base_url('admin/email'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function updateemailtemplate()
    {
        if ($_SESSION['userdetails'] != null) {
            $emailtemplateid = $_POST['emailtemplateid'];

            $emailtemplatename = $_POST['emailtemplatename'];
            $emailtemplate = $_POST['emailtemplate'];

            $adminModel = new AdminModel();
            $adminModel->updateemailtemplate($emailtemplateid, $emailtemplatename, $emailtemplate);

            return redirect()->to(base_url('admin/email'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function deleteemailtemplate()
    {
        if ($_SESSION['userdetails'] != null) {
            $emailtemplateid = $_GET['emailtemplateid'];

            $adminModel = new AdminModel();
            $adminModel->deleteemailtemplate($emailtemplateid);

            return redirect()->to(base_url('admin/email'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }
    // Email Templates
    
    public function InsertBussinessCalendar()
    {
        $start = $month = strtotime('2024-01-01');
$end = strtotime('2024-12-31');
while($month < $end)
{
    // echo date('F Y', $month), PHP_EOL;
     $month = strtotime("+1 month", $month);
}


$begin = new DateTime( "2024-01-01" );
$end   = new DateTime( "2024-12-31" );

for($i = $begin; $i <= $end; $i->modify('+1 day')){

    $date = $i->format("Y-m-d");
    $day = $i->format("l");
    if($day=="Sunday")
    {
    	$is_employee_workingday=0;
        $is_student_workingday=0;
        $comment = "Sunday";
    }else
    {
    	$is_employee_workingday = 1;
        $is_student_workingday = 1;
        $comment = '';
    }
    echo "INSERT INTO `business_calendar`(`date`, `day`, `is_employee_workingday`, `is_student_workingday`, `comment`) VALUES ('".$date."','".$day."','".$is_employee_workingday."','".$is_student_workingday."','".$comment."');";
}
    }

    public function business_calendar()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Admin/business_calendar';

            $year = isset($_GET['year']) ? $_GET['year'] : '2023';

            $adminModel = new AdminModel();
            $data['business_days'] = $adminModel->get_business_days($year);

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function update_business_day()
    {
        if ($_SESSION['userdetails'] != null) {
            $date = $_POST['date'];
            $is_employee_workingday = isset($_POST['is_employee_workingday']) ? 1 : 0;
            $is_student_workingday = isset($_POST['is_student_workingday']) ? 1 : 0;
            $comment = $_POST['comment'];

            $adminModel = new AdminModel();
            $data['business_days'] = $adminModel->update_business_day($date, $is_employee_workingday, $is_student_workingday, $comment);

            return redirect()->to(base_url('admin/business_calendar'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function leave_requests()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Attendance/leave_requests';

            $usersModel = new UsersModel();
            if($_SESSION['userdetails']->rolename=="Accounts")
            {
                $data['leaveRequests'] = $usersModel->get_employee_allleaveRequests();
            }else{
            $data['leaveRequests'] = $usersModel->get_employee_leaveRequests();
            }
            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }
    
    public function leave_approved()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Attendance/leave_approved';

            $usersModel = new UsersModel();
            if($_SESSION['userdetails']->rolename=="Accounts")
            {
                $data['leaveRequests'] = $usersModel->get_employee_allleaveapproved();
            }else
            {
                $data['leaveRequests'] = $usersModel->get_employee_leaveapproved();
            }

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }
    
    public function leave_rejected()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Attendance/leave_rejected';

            $usersModel = new UsersModel();
            if($_SESSION['userdetails']->rolename=="Accounts")
            {
                $data['leaveRequests'] = $usersModel->get_employee_allleaverejected();
            }else
            {
                $data['leaveRequests'] = $usersModel->get_employee_leaverejected();
            }

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

     public function regularizations()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Attendance/regularizations';

            $usersModel = new UsersModel();
            $data['loginregularizations'] = $usersModel->get_employee_to_loginregularize();
            
            $data['logoutregularizations'] = $usersModel->get_employee_to_logoutregularize();

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function regularize($attendanceId, $regularised)
    {
        if ($_SESSION['userdetails'] != null) {
            $usersModel = new UsersModel();
            $data['regularizations'] = $usersModel->update_employee_attendance($attendanceId, $regularised);

            return redirect()->to(base_url('admin/regularizations'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }
    public function regularizelogout($attendanceId, $regularised)
    {
        if ($_SESSION['userdetails'] != null) {
            $usersModel = new UsersModel();
            $data['regularizations'] = $usersModel->update_employee_attendancelogout($attendanceId, $regularised);

            return redirect()->to(base_url('admin/regularizations'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }


    public function approveRejectLeave($leaverequestid, $isapproved,$days=null,$userid)
    {
        if ($_SESSION['userdetails'] != null) {
            $usersModel = new UsersModel();
            $data['regularizations'] = $usersModel->update_leave_status($leaverequestid, $isapproved,$days,$userid);

            return redirect()->to(base_url('admin/leave_requests'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }
    
    
    public function employee_fees_limits()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Admin/employee_fees_limits';

            $adminModel = new AdminModel();
            $data['employee_fees_limits'] = $adminModel->get_employee_fees_limits();
            $data['discountLogs'] = $adminModel->get_employee_discount_logs();

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function AddUpdateMaxDiscount()
    {
        if ($_SESSION['userdetails'] != null) {

            $discount = $_POST['discount'];
            $userid = $_POST['userid'];

            $data['discount'] = $discount;
            $data['employeeid'] = $userid;
            $data['batchid'] = $_SESSION['activebatch'];

            $adminModel = new AdminModel();
            $adminModel->insertUpdate_employee_fees_limits($data);
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function AddUpdateLimit()
    {
        if ($_SESSION['userdetails'] != null) {
            $limit = $_POST['limit'];
            $userid = $_POST['userid'];

            $data['limit'] = $limit;
            $data['employeeid'] = $userid;
            $data['batchid'] = $_SESSION['activebatch'];

            $adminModel = new AdminModel();
            $adminModel->insertUpdate_employee_fees_limits($data);
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function StudentNoc()
    {
        if ($_SESSION['userdetails'] != null) {
            if ($_SESSION['rights'][array_search('Generate_NOC', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) {

                $data['page_name'] = 'Admin/NOC';

                $helperModel = new HelperModel();
                $data['lookups'] = $helperModel->get_lookups();

                $paymentsmodel = new PaymentsModel();
                $data['invoiceDetails'] = $paymentsmodel->getAllInvoiceDetails();

                return view('loggedinuser/index.php', $data);
            } else {
                return redirect()->to(base_url('home'));
            }
        } else {
            return redirect()->to(base_url('home'));
        }
    }
    public function upload()
    {
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
        
        $file = '1696836018_316a110374013562a8dc.pdf';
        //Creating a presigned URL
$cmd = $s3Client->getCommand('GetObject', [
    'Bucket' => 'resohyd',
    'Key' => "{$file}"
]);

$request = $s3Client->createPresignedRequest($cmd, '+2 minutes');

// Get the actual presigned-url
$presignedUrl = (string)$request->getUri();

$mobile = "8977245573";
$amount= 1435;
$roll = '203111';
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
    "campaignName": "payment_receipt",
    "destination": "'.$mobile.'",
    "userName": "Shiva",
    "templateParams": ["'.$amount.'", "'.$roll.'"],
    "media":{
      "url": "'.$presignedUrl.'",
      "filename": "'.$file.'"
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
exit();
        // try {
        //     // read object
        //     $result = $s3Client->getObject([
        //         'Bucket' => 'resohyd',
        //         'Key' => '1000003-Shiva Test (1).pdf'
        //     ]);
        //     print_r($result);
        // } catch (S3Exception $e) {
        //     echo $e->getMessage() . PHP_EOL;
        // }
        
       // $objInfo = $s3Client->get_object_headers('resohyd', '1000003-Shiva Test (1).pdf');
//     $result = $s3Client->getObject([
//                 'Bucket' => 'resohyd',
//                 'Key' => '1000003-Shiva Test (1).pdf'
//             ]);
// header('Content-type: application/pdf');
// echo $result->body;
        
//         exit();
        
//         $HELLO = file_get_contents('https://maidendropgroup.com/public/s3/1696420978_c399be7626d5f2db96cc.jpeg');

//         try {
//             $result = $s3Client->putObject([
//                 'ACL' => 'public-read',
//                 'Bucket' => 'resohyd',
//                 'Key' => "1696420978_c399be7626d5f2db96cc.jpeg",
//                 'Body' => $HELLO
//             ]);
//         } catch (S3Exception $e) {
//             echo $e->getMessage() . PHP_EOL;
//         }
        
        // $s3Client = new S3Client([
        //     'endpoint' => 'https://s3.wasabisys.com',
        //     'version' => 'latest',
        //     'region'  => 'us-east-1',
        //     'credentials' => [
        //         'key'    => '9R6N30YAWA67EHB6L3RB',
        //         'secret' => 'DsE1YPLqZGiSS1iTVyLoXY2L6VbZM3b0hAR7e7hl'
        //     ],
        //     'use_path_style_endpoint' => true
        // ]);
        //  try {
           
        //     $result = $s3Client->createBucket([
        //         'Bucket' => 'hello-world_ne'
        //     ]);
        // } catch (S3Exception $e) {
        //     echo $e->getMessage() . PHP_EOL;
        // }
         // exit();
        // $result = $s3Client->listBuckets(array());
        // foreach ($result['Buckets'] as $bucket) {
        //     echo $bucket['Name'], PHP_EOL;
        // }

        return view('welcome_message');
    }
    public function store()
    {  
        
        helper(['form', 'url']);
         
        $validated = 1;
       
        $msg = 'Please select a valid file';
  
        if ($validated) {
            $avatar = $this->request->getFile('file');
            $name = $avatar->getRandomName();
            $avatar->move('s3', $name);
            $filename = $name;
            $data = [
                'name' =>  $avatar->getClientName(),
                'type'  => $avatar->getClientMimeType()
            ];
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
        $HELLO = file_get_contents("https://maidendropgroup.com/public/s3/{$name}");
        try {
            $result = $s3Client->putObject([
                'ACL' => 'public-read',
                'Bucket' => 'resohyd',
                'Key' => "{$name}",
                'Body' => $HELLO
            ]);
            
        } catch (S3Exception $e) {
            $api_error = $e->getMessage() . PHP_EOL;
        }
             
             $cmd = $s3Client->getCommand('GetObject', [
        'Bucket' => 'resohyd',
        'Key' => "{$name}"
    ]);
    
    $request = $s3Client->createPresignedRequest($cmd, '+2 minutes');
    
    // Get the actual presigned-url
    $presignedUrl = (string)$request->getUri();
    $mobile = 8977245573;
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
        "campaignName": "payment_receipt",
        "destination": "'.$mobile.'",
        "userName": "Shiva",
        "templateParams": ["100", "RMD023"],
        "media":{
          "url": "'.$presignedUrl.'",
          "filename": "'.$name.'"
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
            if(empty($api_error)){ 
                $status = 'success'; 
                $statusMsg = "File was uploaded to the S3 bucket successfully!"; 
            }else{ 
                $statusMsg = $api_error; 
            } 

            $msg = 'File has been uploaded';
            echo $msg;
        }
 
       // return redirect()->to( base_url('/admin/upload') )->with('msg', $msg);
 
    }
    public function paymentgateway()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'paymentgateway';

            $adminModel = new AdminModel();
            $data['paymentgateway'] = $adminModel->get_paymentgateway();
                
            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }
    public function reservationdiscount()
    {
         if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'reservationdiscount';

            $adminModel = new AdminModel();
            $data['reservationdiscount'] = $adminModel->get_reservationdiscount();
            $data['reservationdiscountbyuserid'] = $adminModel->get_reservationdiscountbyuserid();
            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }
    public function createreservationdiscount()
    {
            $branchid = $_POST['branchid'];
            $courseid = $_POST['courseid'];
            $admissiontypeid = $_POST['admissiontypeid'];
            $batchid = $_POST['batchid'];
            $amount = $_POST['amount'];
            $adminModel = new AdminModel();
            $adminModel->addmaxreservationdiscount($branchid,$courseid,$admissiontypeid,$batchid,$amount);
            return redirect()->to(base_url('admin/reservationdiscount'));
    }
    public function updatereservationdiscount()
    {
            $amount = $_POST['amount'];
            $id = $_POST['id'];
            $adminModel = new AdminModel();
            $adminModel->updatemaxreservationdiscount($id,$amount);
            return redirect()->to(base_url('admin/reservationdiscount'));
    }
    public function updatereservationdiscountbyuserid()
    {
            $amount = $_POST['amount1'];
            $id = $_POST['id'];
            $adminModel = new AdminModel();
            $adminModel->updatemaxreservationdiscount($id,$amount);
            return redirect()->to(base_url('admin/reservationdiscount'));
    }
}
