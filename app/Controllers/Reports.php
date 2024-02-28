<?php

namespace App\Controllers;

use App\Models\HelperModel;
use App\Models\PaymentsModel;
use App\Models\ReportsModel;
use App\Models\ReservationModel;
use App\Models\UsersModel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
class Reports extends BaseController
{
    public $session;
    public function __construct()
    {
        $session = session();
    }

    public function index()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Reports/reports';
            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('home'));
        }
    }

    public function report_studentdetails()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Reports/report_studentdetails';
            $branchid = $_SESSION['userdetails']->branchid;
            $batchid = (isset($_GET['batchid']) && $_GET['batchid'] != "") ? $_GET['batchid'] : NULL;
            $branchid = (isset($_GET['branchid']) && $_GET['branchid'] != "") ? $_GET['branchid'] : $branchid;
            $courseid = (isset($_GET['courseid']) && $_GET['courseid'] != "") ? $_GET['courseid'] : NULL;
            $admissiontypeid = (isset($_GET['admissiontypeid']) && $_GET['admissiontypeid'] != "") ? $_GET['admissiontypeid'] : NULL;
            $sectionid = (isset($_GET['sectionid']) && $_GET['sectionid'] != "") ? $_GET['sectionid'] : NULL;
            $referredbyid = (isset($_GET['referredbyid']) && $_GET['referredbyid'] != "") ? $_GET['referredbyid'] : NULL;
            $genderid = (isset($_GET['genderid']) && $_GET['genderid'] != "") ? $_GET['genderid'] : NULL;
            
            $AdmissionDateFrom = date_create_from_format("d/m/Y", $_GET['AdmissionDateFrom']) != false ? date_format(date_create_from_format("d/m/Y", $_GET['AdmissionDateFrom']), 'Y-m-d') : NULL;
            $AdmissionDateTo = date_create_from_format("d/m/Y", $_GET['AdmissionDateTo']) != false ? date_format(date_create_from_format("d/m/Y", $_GET['AdmissionDateTo']), 'Y-m-d') : NULL;

            $download = (isset($_GET['download']) && $_GET['download'] != "") ? $_GET['download'] : NULL;

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            $reportsModel = new ReportsModel();
            $data['studentDetails'] = $reportsModel->report_studentdetails($batchid, $branchid, $courseid, $admissiontypeid, $sectionid,
                                                        $referredbyid, $genderid, $AdmissionDateFrom, $AdmissionDateTo);
           

            $usersModel = new UsersModel();
            $data['EmployeeDetails'] = $usersModel->getAllEmployeeDetails();

            if ($download == 1) {
                $setData = '';
                foreach ($data['studentDetails'] as $key => $rec) {
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
                        if($key == "batchid"){
                            $batch = $value;
                            
                        }
                        if($key == "applicationnumber"){
                            $applicationnumber = $value;
                            
                        }
                        if($key == "userid"){
                            $userid = $value;
                            
                        }
                        if($key == "FeesDue"){
                            $FeesDue = $value;
                            
                        }
                            if($key == "TotalFeesPaid")
                        {
                              $promoted = $helperModel->studentcount($userid,$batch);
                              $promoted1 = $helperModel->studentbatchcount($userid);
                                               if($promoted1==0)
                                               {
                                                    $value = $value-2500;
                                               }else{
                                                   if($applicationnumber > 2300001){
                                                           $value = $value-2500;
                                                        }
                                                        else{   
                                                            if($applicationnumber > 220001 && $promoted ==1)
                                                            {
                                                                $value = $value-2500;
                                                            }
                                                        }
                                                }
                            $value = '"' . $value . '"' . "\t";
                            $rowData .= $value;
                        }
                        elseif($key == "BalanceToBePaid")
                        { 
                            
                           
                            if($promoted1==0)
                                               {
                                                    $value = $value+$FeesDue+2500;
                                               }else{
                             if ($applicationnumber > 2300001){
                                                   $value = $value+$FeesDue+2500;;
                                                }
                                         else{       
                             if($applicationnumber > 220001 && $promoted==1)
                            {
                            $value = $value+$FeesDue+2500;
                            }
                                         }
                                               }
                                               $value = $value +$FeesDue ;
                            $value = '"' . $value . '"' . "\t";
                            $rowData .= $value;
                        }
                        else
                        {
                            $value = '"' . $value . '"' . "\t";
                            $rowData .= $value;
                        }
                        
                    }
                    $setData .= trim($rowData) . "\n";
                }

                header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=Student_Details_Report.xls");
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
    
    public function print_studentattendancesummary()
    {
        $branchid = $_SESSION['userdetails']->branchid;
        $branchid = (isset($_GET['branchid']) && $_GET['branchid'] != "") ? $_GET['branchid'] : $branchid;
        $courseid = (isset($_GET['courseid']) && $_GET['courseid'] != "") ? $_GET['courseid'] : NULL;
        $sectionid = (isset($_GET['sectionid']) && $_GET['sectionid'] != "") ? $_GET['sectionid'] : NULL;
        $DateFrom = date_create_from_format("d/m/Y", $_GET['DateFrom']) != false ? date_format(date_create_from_format("d/m/Y", $_GET['DateFrom']), 'Y-m-d') : date('Y-m-d');
        $DateTo = date_create_from_format("d/m/Y", $_GET['DateTo']) != false ? date_format(date_create_from_format("d/m/Y", $_GET['DateTo']), 'Y-m-d') : date('Y-m-d');
        $reportsModel = new ReportsModel();
        $data['report_attendancesummarydetails'] = $reportsModel->report_attendancesummarydetails($DateFrom, $DateTo);
        $helperModel = new HelperModel();
        $data['lookups'] = $helperModel->get_lookups();
		return view('loggedinuser/Print/print_studentattendancesummary.php', $data);
    }
    public function report_studentattendance()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Reports/report_studentattendance';
            $branchid = $_SESSION['userdetails']->branchid;
            $branchid = (isset($_GET['branchid']) && $_GET['branchid'] != "") ? $_GET['branchid'] : $branchid;
            $courseid = (isset($_GET['courseid']) && $_GET['courseid'] != "") ? $_GET['courseid'] : NULL;
            $sectionid = (isset($_GET['sectionid']) && $_GET['sectionid'] != "") ? $_GET['sectionid'] : NULL;
            $DateFrom = date_create_from_format("d/m/Y", $_GET['DateFrom']) != false ? date_format(date_create_from_format("d/m/Y", $_GET['DateFrom']), 'Y-m-d') : date('Y-m-d');
            $DateTo = date_create_from_format("d/m/Y", $_GET['DateTo']) != false ? date_format(date_create_from_format("d/m/Y", $_GET['DateTo']), 'Y-m-d') : date('Y-m-d');
            $download = (isset($_GET['download']) && $_GET['download'] != "") ? $_GET['download'] : NULL;
            $message = (isset($_GET['message']) && $_GET['message'] != "") ? $_GET['message'] : NULL;

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            $reportsModel = new ReportsModel();
            $data['studentDetails'] = $reportsModel->report_studentattendance($branchid, $courseid,$sectionid,$DateFrom, $DateTo);
           
            
            $usersModel = new UsersModel();
            $data['EmployeeDetails'] = $usersModel->getAllEmployeeDetails();

            if ($download == 1) {
                $setData = '';
                foreach ($data['studentDetails'] as $key => $rec) {
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
                       if($key=='status')
                       {
                           if($value ==1)
                           {
                               $value = "Present";
                           }else
                           {
                               $value = "Absent";
                           }
                       }
                       if($key=='is_latelogin')
                       {
                           if($value ==1)
                           {
                               $value = "Yes";
                           }else
                           {
                               
                           }
                       }
                      
                            $value = '"' . $value . '"' . "\t";
                            $rowData .= $value;
                    }
                    $setData .= trim($rowData) . "\n";
                }

                header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=Student_Attendance_Report.xls");
                header("Pragma: no-cache");
                header("Expires: 0");
                echo $setData . "\n";
            }elseif($message ==1)
            {
                foreach ($data['studentDetails'] as $students) {
                    if($students->status ==0)
                    {
                        exit();
                        // $to = $students->mobile1;
                          $to = '';
                          $template_id = "1707167211657719994";
                            $entity_id = "1701159195824664328";
                            $body = urlencode("Dear Parent, Your Ward {$students->name} bearing Roll No {$students->applicationnumber} is absent for Today classes. Regular Attendance is mandatory for effective learning. In Case of Any queries Please reach to branch team. Thanks Resonance - Hyderabad");
                            $apiurl = "http://pwtpl.com/sms/V1/send-sms-api.php?apikey=dr7xJ6KiNJh7v9bk&senderid=MAIDEN&templateid=$template_id&entityid=$entity_id&number=$to&message=$body";
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => $apiurl,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_CUSTOMREQUEST => "GET",
                        )); 
                        
                        curl_exec($curl);
                        
                        curl_close($curl); 
                         
                    }
                   // print_r($students->applicationnumber);
                    //print_r($students->name);
                     //print_r($students->status);
                }
                
            }
            else {
                return view('loggedinuser/index.php', $data);
            }
        } else {
            return redirect()->to(base_url('home'));
        }
    }
    public function createExcel() {
		$fileName = 'employee.xlsx';  
		 $DateFrom = date_create_from_format("d/m/Y", $_GET['FromDate']) != false ? date_format(date_create_from_format("d/m/Y", $_GET['FromDate']), 'Y-m-d') : "2023-06-28";
            $DateTo = date_create_from_format("d/m/Y", $_GET['ToDate']) != false ? date_format(date_create_from_format("d/m/Y", $_GET['ToDate']), 'Y-m-d') :  date('Y-m-d');
            $branchid = (isset($_GET['branchid']) && $_GET['branchid'] != "") ? $_GET['branchid'] : NULL;
            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();
            $reportsModel = new ReportsModel();
            $employeeData = $reportsModel->report_employeeattendance($DateFrom, $DateTo,$branchid);
		    $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'EmployeeId');
            $sheet->setCellValue('B1', 'Name');
            $startDate = strtotime($DateFrom);
            $endDate = strtotime($DateTo);
            $col = 'C';
            for ($currentDate = $startDate; $currentDate <= $endDate; $currentDate += (86400)) {
                $row= 1;
                //$element = chr((((ord($val) - 97) + 1) % 26) + 97);
                $date = date('M-d D', $currentDate);
                $sheet->setCellValue($col.$row, $date);
                $val = $element;
            $col++;
            }
        $rows = 2;

        foreach ($employeeData as $task){
            $sheet->setCellValue('A' . $rows, $task->employeeid);
            $sheet->setCellValue('B' . $rows, $task->name);
            $userid = $task->userid;
            $usersModel = new UsersModel();
            $attendance = $usersModel->getattendanceByUserId($userid,$DateFrom,$DateTo);
            $val1 = 'C';
            foreach($attendance as $payment)
            {
                $value ='';
                if( $payment->status == 1){
                    if($payment->isLatelogin == 1)
                    {
                        $late = 'Yes';
                    }else
                    {
                        $late = 'No';
                    }
                     if($payment->isEarlylogout == 1)
                    {
                        $Early = 'Yes';
                    }else
                    {
                        $Early = 'No';
                    }
                    $value .='Present'."\n";
                    $value .= 'Login Time =' . $payment->loginTime."\n";
                    $value .='Late Login ='. $late."\n";
                    $value .='Logout Time ='. $payment->logoutTime."\n";
                    $value .='Late Login ='. $Early;
                }else
                {
                     $value .='Absent';
                }
                $sheet->setCellValue($val1.$rows, $value);
                $spreadsheet->getActiveSheet()->getStyle($val1.$rows)->getAlignment()->setWrapText(true);
                $value = '';
                $val1 ++;
            }
            $rows++;
        }
        $writer = new Xlsx($spreadsheet);
        $filename = 'excel-report';
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');        
    }    
    public function report_employeeattendance()
    {
         if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Reports/report_employeeattendance';
            $branchid = $_SESSION['userdetails']->branchid;   
            $DateFrom = date_create_from_format("d/m/Y", $_GET['FromDate']) != false ? date_format(date_create_from_format("d/m/Y", $_GET['FromDate']), 'Y-m-d') : date('Y-m-d');
            $DateTo = date_create_from_format("d/m/Y", $_GET['ToDate']) != false ? date_format(date_create_from_format("d/m/Y", $_GET['ToDate']), 'Y-m-d') :  date('Y-m-d');
            $branchid = (isset($_GET['branchid']) && $_GET['branchid'] != "") ? $_GET['branchid'] : $branchid;
            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            $reportsModel = new ReportsModel();
            $data['Employeeattendance'] = $reportsModel->report_employeeattendance($DateFrom, $DateTo,$branchid);
            $download = (isset($_GET['download']) && $_GET['download'] != "") ? $_GET['download'] : NULL;
            if ($download == 1) {
                $setData = '';
                foreach ($data['Employeeattendance'] as $key => $rec) {
                    if ($key == 0) {
                        $rowData = '';
                        foreach ($rec as $key => $value) {
                           
                            if($key=='date')
                            {
                                $startDate = strtotime($DateFrom);
                                $endDate = strtotime($DateTo);
                                for ($currentDate = $startDate; $currentDate <= $endDate; $currentDate += (86400)) {
                                    $date = date('M-d D', $currentDate);
                                    $key = $date . "\t";
                                    $rowData .= $key;
                                }
                            }else{
                                $key = '"' . $key . '"' . "\t";
                                $rowData .= $key;
                            }
                            
                            
                        }
                        $setData .= trim($rowData) . "\n";
                    }

                    $rowData = '';
                    foreach ($rec as $key => $value) {
                        if($key == 'userid')
                        {
                            $userid = $value;
                        }
                        if($key=='date')
                       {
                            $usersModel = new UsersModel();
                            $attendance = $usersModel->getattendanceByUserId($userid,$DateFrom,$DateTo);
                            foreach($attendance as $payment)
                            {
                                if($payment->status==1)
                                {
                                    $value = 'Present'."\t";;
                                }else
                                {
                                    $value = 'Absent'."\t";;
                                }
                                //$value = '"Login Time =' . $payment->loginTime . 'Late Login ='. $payment->isLatelogin . '<br>Logout Time ='. $payment->logoutTime. '<br>Early Logout ='. $payment->isEarlyLogout.'"' . "\t";
                                $rowData .= $value;
                            }
                                
                       }else
                       {
                            $value = '"' . $value . '"' . "\t";
                            $rowData .= $value;
                       }
                        
                    }
                    
                    $setData .= trim($rowData) . "\n";
                }

                header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=Employee_Attendance_Report.xls");
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
    
    public function report_employeedetailattendance()
    {
         if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Reports/report_employeedetailattendance';
            $branchid = $_SESSION['userdetails']->branchid;
            $DateFrom = date_create_from_format("d/m/Y", $_GET['FromDate']) != false ? date_format(date_create_from_format("d/m/Y", $_GET['FromDate']), 'Y-m-d') : date('Y-m-d');
            $DateTo = date_create_from_format("d/m/Y", $_GET['ToDate']) != false ? date_format(date_create_from_format("d/m/Y", $_GET['ToDate']), 'Y-m-d') :  date('Y-m-d');
            $branchid = (isset($_GET['branchid']) && $_GET['branchid'] != "") ? $_GET['branchid'] : $branchid;
            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            $reportsModel = new ReportsModel();
            $data['Employeeattendance'] = $employeeData = $reportsModel->report_employeedetailattendance($DateFrom, $DateTo,$branchid);
            $download = (isset($_GET['download']) && $_GET['download'] != "") ? $_GET['download'] : NULL;
            if ($download == 1) {
              $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'EmployeeId');
            $sheet->setCellValue('B1', 'Name');
            $startDate = strtotime($DateFrom);
            $endDate = strtotime($DateTo);
            $col = 'C';
            for ($currentDate = $startDate; $currentDate <= $endDate; $currentDate += (86400)) {
                $row= 1;
                $date = date('M-d D', $currentDate);
                $sheet->setCellValue($col.$row, $date);
            $col++;
            }
            $col++;
            $sheet->setCellValue($col.$row, 'No Of Late Logins');
            $col++;
            $sheet->setCellValue($col.$row, 'No Of Early Logouts');
        $rows = 2;

        foreach ($employeeData as $task){
            $sheet->setCellValue('A' . $rows, $task->employeeid);
            $sheet->setCellValue('B' . $rows, $task->name);
            $userid = $task->userid;
            $usersModel = new UsersModel();
            $attendance = $usersModel->getattendanceByUserId($userid,$DateFrom,$DateTo);
            $val1 = 'C';
            $nolates = 0;
            $noearly = 0;
            foreach($attendance as $payment)
            {
                $value ='';
                if( $payment->status == 1){
                    if($payment->isLatelogin == 1 && $payment->loginregularised !=1)
                    {
                        $late = 'Yes';
                        $nolates++;
                    }else
                    {
                        $late = 'No';
                    }
                    if($payment->isEarlyLogout == 1 && $payment->logoutregularised !=1)
                    {
                        $Early = 'Yes';
                        $noearly++;
                    }else
                    {
                        $Early = 'No';
                    }
                    if($payment->isLatelogin == 1 && $payment->loginregularised !=1)
                    {
                        $value .= 'Late Login regularization Pending'."\n";
                    }elseif($payment->isLatelogin == 1 && $payment->loginregularised =1)
                    {
                         $value .= 'Late Login regularized'."\n";
                    }else
                    {
                        
                    }
                    
                      if($payment->isEarlyLogout == 1 && $payment->logoutregularised !=1)
                    {
                        $value .= 'Early Logout regularization Pending'."\n";
                    }elseif($payment->isEarlyLogout == 1 && $payment->logoutregularised =1)
                    {
                         $value .= 'Early Logout regularized'."\n";
                    }else
                    {
                        
                    }
                    
                    $value .='Present'."\n";
                    $value .= 'Login Time =' . $payment->loginTime."\n";
                    $value .='Late Login ='. $late."\n";
                    $value .='Logout Time ='. $payment->logoutTime."\n";
                    $value .='Early Logout ='. $Early;
                }else
                {
                     $value .='Absent';
                }
                $sheet->setCellValue($val1.$rows, $value);
                $spreadsheet->getActiveSheet()->getStyle($val1.$rows)->getAlignment()->setWrapText(true);
                $value = '';
                $val1 ++;
            }
            $val1++;
            $sheet->setCellValue($val1.$rows, $nolates);
            $val1++;
            $sheet->setCellValue($val1.$rows, $noearly);
            $rows++;
        }
        
        $writer = new Xlsx($spreadsheet);
        $filename = 'Employee_Attendance_Detail_Report';
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');        
            } else {

            return view('loggedinuser/index.php', $data);
            }
        } else {
            return redirect()->to(base_url('home'));
        }
    }

    public function report_reservationdetails()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Reports/report_reservationdetails';
            $branchid = $_SESSION['userdetails']->branchid;
            $batchid = (isset($_GET['batchid']) && $_GET['batchid'] != "") ? $_GET['batchid'] : NULL;
            $branchid = (isset($_GET['branchid']) && $_GET['branchid'] != "") ? $_GET['branchid'] : $branchid;
            $courseid = (isset($_GET['courseid']) && $_GET['courseid'] != "") ? $_GET['courseid'] : NULL;
            $admissiontypeid = (isset($_GET['admissiontypeid']) && $_GET['admissiontypeid'] != "") ? $_GET['admissiontypeid'] : NULL;
            $referredbyid = (isset($_GET['referredbyid']) && $_GET['referredbyid'] != "") ? $_GET['referredbyid'] : NULL;
            $genderid = (isset($_GET['genderid']) && $_GET['genderid'] != "") ? $_GET['genderid'] : NULL;
            
            $AdmissionDateFrom = date_create_from_format("d/m/Y", $_GET['AdmissionDateFrom']) != false ? date_format(date_create_from_format("d/m/Y", $_GET['AdmissionDateFrom']), 'Y-m-d') : NULL;
            $AdmissionDateTo = date_create_from_format("d/m/Y", $_GET['AdmissionDateTo']) != false ? date_format(date_create_from_format("d/m/Y", $_GET['AdmissionDateTo']), 'Y-m-d') : NULL;
            $ReservationDateFrom = date_create_from_format("d/m/Y", $_GET['ReservationDateFrom']) != false ? date_format(date_create_from_format("d/m/Y", $_GET['ReservationDateFrom']), 'Y-m-d') : NULL;
            $ReservationDateTo = date_create_from_format("d/m/Y", $_GET['ReservationDateTo']) != false ? date_format(date_create_from_format("d/m/Y", $_GET['ReservationDateTo']), 'Y-m-d') : NULL;

            $download = (isset($_GET['download']) && $_GET['download'] != "") ? $_GET['download'] : NULL;

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            $reportsModel = new ReportsModel();
            $data['studentDetails'] = $reportsModel->report_reservationdetails($batchid, $branchid, $courseid, $admissiontypeid,
                                                        $referredbyid, $genderid, $AdmissionDateFrom, $AdmissionDateTo,$ReservationDateFrom,$ReservationDateTo);

            $usersModel = new UsersModel();
            $data['EmployeeDetails'] = $usersModel->getAllEmployeeDetails();

            if ($download == 1) {
                $setData = '';
                foreach ($data['studentDetails'] as $key => $rec) {
                    if ($key == 0) {
                        $rowData = '';
                        foreach ($rec as $key => $value) {
                            if($key == "PaymentDetails")
                            {
                                $paymentsModel = new PaymentsModel();
                                $maxRows = $paymentsModel->getMaxReservationPaymentsBySingleUser();

                                for($i = 1; $i <= $maxRows; $i++)
                                {
                                    $key = '"payment - "' . $i . "\t";
                                    $rowData .= $key;

                                    $key = '"amount - "' . $i . "\t";
                                    $rowData .= $key;
                                    
                                    $key = '"paymenttypename - "' . $i . "\t";
                                    $rowData .= $key;
                                    
                                    $key = '"otherdetails - "' . $i . "\t";
                                    $rowData .= $key;
                                    
                                     $key = '"paymentstatusname - "' . $i . "\t";
                                    $rowData .= $key;
                                }
                            }
                            else
                            {
                                $key = '"' . $key . '"' . "\t";
                                $rowData .= $key;
                            }
                        }
                        $setData .= trim($rowData) . "\n";
                    }

                    $rowData = '';
                    foreach ($rec as $key => $value) {
                        if($key == "PaymentDetails")
                        {
                            $userid = $value;
                            $paymentsModel = new PaymentsModel();
                            $paymentDetails = $paymentsModel->getReservationPaymentDetailsByUserId($userid, $batchid = NULL);
                            foreach($paymentDetails as $payment)
                            {
                                $value = '"' . $payment->paymentdate . '"' . "\t";
                                $rowData .= $value;

                                $value = '"' . $payment->paymentamount . '"' . "\t";
                                $rowData .= $value;
                                
                                $value = '"' . $payment->paymenttypename . '"' . "\t";
                                $rowData .= $value;
                                
                                $value = '"' . $payment->otherdetails . '"' . "\t";
                                $rowData .= $value;
                                
                                $value = '"' . $payment->paymentstatusname . '"' . "\t";
                                $rowData .= $value;
                            }
                        }
                        else
                        {
                            $value = '"' . $value . '"' . "\t";
                            $rowData .= $value;
                        }
                    }
                    $setData .= trim($rowData) . "\n";
                }

                header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=Reservation_Details_Report.xls");
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
    
    public function report_applicationdetails()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Reports/report_applicationdetails';
            $branchid = $_SESSION['userdetails']->branchid;
            $batchid = (isset($_GET['batchid']) && $_GET['batchid'] != "") ? $_GET['batchid'] : NULL;
            $branchid = (isset($_GET['branchid']) && $_GET['branchid'] != "") ? $_GET['branchid'] : $branchid;
            $courseid = (isset($_GET['courseid']) && $_GET['courseid'] != "") ? $_GET['courseid'] : NULL;
            $admissiontypeid = (isset($_GET['admissiontypeid']) && $_GET['admissiontypeid'] != "") ? $_GET['admissiontypeid'] : NULL;
            $referredbyid = (isset($_GET['referredbyid']) && $_GET['referredbyid'] != "") ? $_GET['referredbyid'] : NULL;
            $genderid = (isset($_GET['genderid']) && $_GET['genderid'] != "") ? $_GET['genderid'] : NULL;
            
            $AdmissionDateFrom = date_create_from_format("d/m/Y", $_GET['AdmissionDateFrom']) != false ? date_format(date_create_from_format("d/m/Y", $_GET['AdmissionDateFrom']), 'Y-m-d') : NULL;
            $AdmissionDateTo = date_create_from_format("d/m/Y", $_GET['AdmissionDateTo']) != false ? date_format(date_create_from_format("d/m/Y", $_GET['AdmissionDateTo']), 'Y-m-d') : NULL;

            $download = (isset($_GET['download']) && $_GET['download'] != "") ? $_GET['download'] : NULL;

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            $reportsModel = new ReportsModel();
            $data['studentDetails'] = $reportsModel->report_applicationdetails($batchid, $branchid, $courseid, $admissiontypeid,
                                                        $referredbyid, $genderid, $AdmissionDateFrom, $AdmissionDateTo);
          
            $usersModel = new UsersModel();
            $data['EmployeeDetails'] = $usersModel->getAllEmployeeDetails();

            if ($download == 1) {
                $setData = '';
                foreach ($data['studentDetails'] as $key => $rec) {
                    if ($key == 0) {
                        $rowData = '';
                        foreach ($rec as $key => $value) {
                            if($key == "PaymentDetails")
                            {
                               
                                $paymentsModel = new PaymentsModel();
                                $maxRows = $paymentsModel->getMaxApplicationPaymentsBySingleUser();
                                for($i = 1; $i <= $maxRows; $i++)
                                {
                                    $key = '"payment - "' . $i . "\t";
                                    $rowData .= $key;

                                    $key = '"amount - "' . $i . "\t";
                                    $rowData .= $key;
                                    
                                    $key = '"paymenttypename - "' . $i . "\t";
                                    $rowData .= $key;
                                    
                                    $key = '"otherdetails - "' . $i . "\t";
                                    $rowData .= $key;
                                    
                                     $key = '"paymentstatusname - "' . $i . "\t";
                                    $rowData .= $key;
                                }
                            }
                            else
                            {
                                $key = '"' . $key . '"' . "\t";
                                $rowData .= $key;
                            }
                        }
                        $setData .= trim($rowData) . "\n";
                    }

                    $rowData = '';
                    foreach ($rec as $key => $value) {
                        if($key == "PaymentDetails")
                        {
                            $userid = $value;
                            $paymentsModel = new PaymentsModel();
                            $paymentDetails = $paymentsModel->getApplicationPaymentDetailsByUserId($userid, $batchid = NULL);
                            foreach($paymentDetails as $payment)
                            {
                                $value = '"' . $payment->paymentdate . '"' . "\t";
                                $rowData .= $value;

                                $value = '"' . $payment->paymentamount . '"' . "\t";
                                $rowData .= $value;
                                
                                $value = '"' . $payment->paymenttypename . '"' . "\t";
                                $rowData .= $value;
                                
                                $value = '"' . $payment->otherdetails . '"' . "\t";
                                $rowData .= $value;
                                
                                $value = '"' . $payment->paymentstatusname . '"' . "\t";
                                $rowData .= $value;
                            }
                        }
                        else
                        {
                            $value = '"' . $value . '"' . "\t";
                            $rowData .= $value;
                        }
                    }
                    $setData .= trim($rowData) . "\n";
                }

                header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=Application_Details_Report.xls");
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

    public function report_admissiondetails()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Reports/report_admissiondetails';
                      
            $AdmissionDateFrom = date_create_from_format("d/m/Y", $_GET['AdmissionDateFrom']) != false ? date_format(date_create_from_format("d/m/Y", $_GET['AdmissionDateFrom']), 'Y-m-d') : NULL;
            $AdmissionDateTo = date_create_from_format("d/m/Y", $_GET['AdmissionDateTo']) != false ? date_format(date_create_from_format("d/m/Y", $_GET['AdmissionDateTo']), 'Y-m-d') : NULL;

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            $reportsModel = new ReportsModel();
            $data['AdmissionDetails'] = $reportsModel->report_admissiondetails($AdmissionDateFrom, $AdmissionDateTo);

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('home'));
        }
    }
    public function print_collectionsummarydetails()
    {
        $PaymentDateFrom = date_create_from_format("d/m/Y", $_GET['PaymentDateFrom']) != false ? date_format(date_create_from_format("d/m/Y", $_GET['PaymentDateFrom']), 'Y-m-d') : date('Y-m-d');
        $PaymentDateTo = date_create_from_format("d/m/Y", $_GET['PaymentDateTo']) != false ? date_format(date_create_from_format("d/m/Y", $_GET['PaymentDateTo']), 'Y-m-d') : date('Y-m-d');

        $helperModel = new HelperModel();
        $data['lookups'] = $helperModel->get_lookups();

        $reportsModel = new ReportsModel();
        $data['report_collectionsummarydetails'] = $reportsModel->report_collectionsummarydetails($PaymentDateFrom, $PaymentDateTo);
        return view('loggedinuser/Print/print_collectionsummarydetails.php', $data);
    }
    public function report_collectionsummarydetails()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Reports/report_collectionsummarydetails';

            $PaymentDateFrom = date_create_from_format("d/m/Y", $_GET['PaymentDateFrom']) != false ? date_format(date_create_from_format("d/m/Y", $_GET['PaymentDateFrom']), 'Y-m-d') : NULL;
            $PaymentDateTo = date_create_from_format("d/m/Y", $_GET['PaymentDateTo']) != false ? date_format(date_create_from_format("d/m/Y", $_GET['PaymentDateTo']), 'Y-m-d') : NULL;

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            $reportsModel = new ReportsModel();
            $data['report_collectionsummarydetails'] = $reportsModel->report_collectionsummarydetails($PaymentDateFrom, $PaymentDateTo);

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('home'));
        }
    }
    
     public function report_attendancesummarydetails()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Reports/report_attendancesummarydetails';
            $fromdate = date('Y-m-d');
            $todate = date('Y-m-d');
            $DateFrom = date_create_from_format("d/m/Y", $_GET['DateFrom']) != false ? date_format(date_create_from_format("d/m/Y", $_GET['DateFrom']), 'Y-m-d') : $fromdate;
            $DateTo = date_create_from_format("d/m/Y", $_GET['DateTo']) != false ? date_format(date_create_from_format("d/m/Y", $_GET['DateTo']), 'Y-m-d') : $todate;

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            $reportsModel = new ReportsModel();
            $data['report_attendancesummarydetails'] = $reportsModel->report_attendancesummarydetails($DateFrom, $DateTo);
            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('home'));
        }
    }
    
     public function report_concernsummarydetails()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Reports/report_concerns';
            $fromdate = date('Y-m-d');
            $todate = date('Y-m-d');
            $DateFrom = date_create_from_format("d/m/Y", $_GET['DateFrom']) != false ? date_format(date_create_from_format("d/m/Y", $_GET['DateFrom']), 'Y-m-d') : $fromdate;
            $DateTo = date_create_from_format("d/m/Y", $_GET['DateTo']) != false ? date_format(date_create_from_format("d/m/Y", $_GET['DateTo']), 'Y-m-d') : $todate;

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            $reportsModel = new ReportsModel();
            $data['report_concernsummarydetails'] = $reportsModel->report_concernsummarydetails($DateFrom, $DateTo);
            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('home'));
        }
    }

    public function report_collectiondetails()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Reports/report_collectiondetails';
            $fromdate = date('Y/m/d',strtotime("-2 days"));
            $todate = date('Y/m/d');
            $PaymentDateFrom = date_create_from_format("d/m/Y", $_GET['PaymentDateFrom']) != false ? date_format(date_create_from_format("d/m/Y", $_GET['PaymentDateFrom']), 'Y-m-d') : $fromdate;
            $PaymentDateTo = date_create_from_format("d/m/Y", $_GET['PaymentDateTo']) != false ? date_format(date_create_from_format("d/m/Y", $_GET['PaymentDateTo']), 'Y-m-d') : $todate;
            
            $download = (isset($_GET['download']) && $_GET['download'] != "") ? $_GET['download'] : NULL;

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            $reportsModel = new ReportsModel();
            $data['report_collectiondetails'] = $reportsModel->report_collectiondetails($PaymentDateFrom, $PaymentDateTo);
            if ($download == 1) {
                $setData = '';
                foreach ($data['report_collectiondetails'] as $key => $rec) {
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
                header("Content-Disposition: attachment; filename=Collection_Details_Report.xls");
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

    public function report_reservationcollectiondetails()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Reports/report_reservationcollectiondetails';

            $PaymentDateFrom = date_create_from_format("d/m/Y", $_GET['PaymentDateFrom']) != false ? date_format(date_create_from_format("d/m/Y", $_GET['PaymentDateFrom']), 'Y-m-d') : NULL;
            $PaymentDateTo = date_create_from_format("d/m/Y", $_GET['PaymentDateTo']) != false ? date_format(date_create_from_format("d/m/Y", $_GET['PaymentDateTo']), 'Y-m-d') : NULL;

            $download = (isset($_GET['download']) && $_GET['download'] != "") ? $_GET['download'] : NULL;

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            $reportsModel = new ReportsModel();
            $data['report_collectiondetails'] = $reportsModel->report_reservationcollectiondetails($PaymentDateFrom, $PaymentDateTo);
            if ($download == 1) {
                $setData = '';
                foreach ($data['report_collectiondetails'] as $key => $rec) {
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
                header("Content-Disposition: attachment; filename=Reservation_Daily_Collection_Report.xls");
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

    public function report_revenue()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Reports/report_revenue';

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            $reportsModel = new ReportsModel();
            $data['report_revenue'] = $reportsModel->report_getrevenue();

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('home'));
        }
    }
    public function report_tc_eligible()
    {
        if ($_SESSION['userdetails'] != null) {
             $courseid = (isset($_GET['courseid']) && $_GET['courseid'] != "") ? $_GET['courseid'] : NULL;
            $data['page_name'] = 'Reports/report_tc_eligible';

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            $reportsModel = new ReportsModel();
            $data['report_tc_eligible'] = $reportsModel->report_tc_eligible($courseid);
             $data['report_tc_given'] = $reportsModel->report_tc_given($courseid);
            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('home'));
        }
    }
     public function report_discount()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Reports/report_discount';

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            $reportsModel = new ReportsModel();
            $data['report_discount'] = $reportsModel->report_getdiscount();
            $download = (isset($_GET['download']) && $_GET['download'] != "") ? $_GET['download'] : NULL;
            if ($download == 1) {
                $setData = '';
                foreach ($data['report_discount'] as $key => $rec) {
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
                header("Content-Disposition: attachment; filename=Discount_Report.xls");
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
    public function report_reservationbudget()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Reports/report_reservationbudget';

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            $reportsModel = new ReportsModel();
            $data['report_budget'] = $reportsModel->report_getreservationbudget();
            $download = (isset($_GET['download']) && $_GET['download'] != "") ? $_GET['download'] : NULL;
            if ($download == 1) {
                $setData = '';
                foreach ($data['report_budget'] as $key => $rec) {
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
                header("Content-Disposition: attachment; filename=Reservation_Budget_Report.xls");
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
    public function report_studentdiscount()
    {
          if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Reports/report_studentdiscount';

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            $reportsModel = new ReportsModel();
            $data['report_discount'] = $reportsModel->report_getstudentdiscount();

            $download = (isset($_GET['download']) && $_GET['download'] != "") ? $_GET['download'] : NULL;
            if ($download == 1) {
                $setData = '';
                foreach ($data['report_discount'] as $key => $rec) {
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
                         if($key=='type')
                       {
                           $value="Student";
                       }
                          if($key=='status')
                       {
                           if($value ==1)
                           {
                               $value = "Approved";
                           }elseif($value ==2)
                           {
                               $value = "Rejected";
                           }else
                           {
                               $value = "Pending";
                           }
                       }
                        $value = '"' . $value . '"' . "\t";
                        $rowData .= $value;
                    }
                    $setData .= trim($rowData) . "\n";
                }

                header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=Student_voucher_Discount_Report.xls");
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
    public function report_reservationdiscount()
    {
          if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Reports/report_reservationdiscount';

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            $reportsModel = new ReportsModel();
            $data['report_discount'] = $reportsModel->report_getreservationdiscount();

            $download = (isset($_GET['download']) && $_GET['download'] != "") ? $_GET['download'] : NULL;
            if ($download == 1) {
                $setData = '';
                foreach ($data['report_discount'] as $key => $rec) {
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
                        if($key=='type')
                       {
                           $value="Reservation";
                       }
                          if($key=='status')
                       {
                           if($value ==1)
                           {
                               $value = "Approved";
                           }elseif($value ==2)
                           {
                               $value = "Rejected";
                           }else
                           {
                               $value = "Pending";
                           }
                       }
                        $value = '"' . $value . '"' . "\t";
                        $rowData .= $value;
                    }
                    $setData .= trim($rowData) . "\n";
                }
                header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=Reservation_Voucher_Discount_Report.xls");
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
    public function report_concerns()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Reports/report_concern';

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            $reportsModel = new ReportsModel();
            $data['report_concerns'] = $reportsModel->report_concerns();
           
            $download = (isset($_GET['download']) && $_GET['download'] != "") ? $_GET['download'] : NULL;
            if ($download == 1) {
                $setData = '';
                foreach ($data['report_concerns'] as $key => $rec) {
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
                header("Content-Disposition: attachment; filename=Report_Concerns.xls");
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

    public function report_noc()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Reports/report_noc';

            $reportsModel = new ReportsModel();
            $data['report_noc'] = $reportsModel->report_getnoc();
            $paymentsModel = new PaymentsModel();
            $data['invoices'] = $paymentsModel->getAllInvoiceDetails();
            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('home'));
        }
    }

    public function report_dropstudents()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Reports/report_dropstudents';
            $branchid = $_SESSION['userdetails']->branchid;
            $batchid = (isset($_GET['batchid']) && $_GET['batchid'] != "") ? $_GET['batchid'] : NULL;
            $branchid = (isset($_GET['branchid']) && $_GET['branchid'] != "") ? $_GET['branchid'] : $branchid;
            $courseid = (isset($_GET['courseid']) && $_GET['courseid'] != "") ? $_GET['courseid'] : NULL;
            $admissiontypeid = (isset($_GET['admissiontypeid']) && $_GET['admissiontypeid'] != "") ? $_GET['admissiontypeid'] : NULL;
            $sectionid = (isset($_GET['sectionid']) && $_GET['sectionid'] != "") ? $_GET['sectionid'] : NULL;

            $download = (isset($_GET['download']) && $_GET['download'] != "") ? $_GET['download'] : NULL;

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            $reportsModel = new ReportsModel();
            $data['studentDetails'] = $reportsModel->report_dropstudents($batchid, $branchid, $courseid, $admissiontypeid, $sectionid);

            $usersModel = new UsersModel();
            $data['EmployeeDetails'] = $usersModel->getAllEmployeeDetails();

            if ($download == 1) {
                $setData = '';
                foreach ($data['studentDetails'] as $key => $rec) {
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
                header("Content-Disposition: attachment; filename=Dropped_Students_Detail_Report.xls");
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

    public function report_wallet()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Reports/report_wallet';
            $branchid = $_SESSION['userdetails']->branchid;
            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            $wallettypeid = (isset($_GET['wallettypeid']) && $_GET['wallettypeid'] != "") ? $_GET['wallettypeid'] : NULL;
            $branchid = (isset($_GET['branchid']) && $_GET['branchid'] != "") ? $_GET['branchid'] : $branchid;

            $reportsModel = new ReportsModel();
            $data['report_wallet'] = $reportsModel->report_wallet($branchid, $wallettypeid);

            $download = (isset($_GET['download']) && $_GET['download'] != "") ? $_GET['download'] : NULL;

            if ($download == 1) {
                $setData = '';
                foreach ($data['report_wallet'] as $key => $rec) {
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
                header("Content-Disposition: attachment; filename=Wallet_Report.xls");
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
    
    public function report_tc()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Reports/report_tc';

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();
            $reportsModel = new ReportsModel();
            $data['report_tc'] = $reportsModel->report_tc();
            $download = (isset($_GET['download']) && $_GET['download'] != "") ? $_GET['download'] : NULL;

            if ($download == 1) {
                $setData = '';
                foreach ($data['report_tc'] as $key => $rec) {
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
                header("Content-Disposition: attachment; filename=Tc_Report.xls");
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

    public function report_wallettransactions()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Reports/report_wallettransactions';
            $branchid = $_SESSION['userdetails']->branchid;
            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            $wallettypeid = (isset($_GET['wallettypeid']) && $_GET['wallettypeid'] != "") ? $_GET['wallettypeid'] : NULL;
            $branchid = (isset($_GET['branchid']) && $_GET['branchid'] != "") ? $_GET['branchid'] : NULL;
            $PaymentDateFrom = date_create_from_format("d/m/Y", $_GET['PaymentDateFrom']) != false ? date_format(date_create_from_format("d/m/Y", $_GET['PaymentDateFrom']), 'Y-m-d') : NULL;
            $PaymentDateTo = date_create_from_format("d/m/Y", $_GET['PaymentDateTo']) != false ? date_format(date_create_from_format("d/m/Y", $_GET['PaymentDateTo']), 'Y-m-d') : NULL;

            $reportsModel = new ReportsModel();
            $data['report_wallettransactions'] = $reportsModel->report_wallettransactions($branchid, $wallettypeid, $PaymentDateFrom, $PaymentDateTo);

            $download = (isset($_GET['download']) && $_GET['download'] != "") ? $_GET['download'] : NULL;

            if ($download == 1) {
                $setData = '';
                foreach ($data['report_wallettransactions'] as $key => $rec) {
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
                header("Content-Disposition: attachment; filename=Wallet_Transaction_Report.xls");
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

    public function report_reservationadmission()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Reports/report_reservationadmission';
                      
            $reportsModel = new ReportsModel();
            $data['ReservationAdmissions'] = $reportsModel->report_reservationadmission();

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('home'));
        }
    }
    
    public function report_applicationadmission()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Reports/report_applicationadmission';
                      
            $reportsModel = new ReportsModel();
            $data['ReservationAdmissions'] = $reportsModel->report_applicationadmission();

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('home'));
        }
    }

    public function report_reservationsummary()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Reports/report_reservationsummary';

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            $reservationModel = new ReservationModel();
            $data['ReservationSummary'] = $reservationModel->get_reservations();

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('home'));
        }
    }
    public function report_applicationsummary()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Reports/report_applicationsummary';

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            $reservationModel = new ReservationModel();
            $data['ReservationSummary'] = $reservationModel->get_applications();

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('home'));
        }
    }
    public function report_outpass()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Reports/report_outpass';
            $branchid = $_SESSION['userdetails']->branchid;
            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();
            $branchid = (isset($_GET['branchid']) && $_GET['branchid'] != "") ? $_GET['branchid'] : $branchid;
            $sectionid = (isset($_GET['sectionid']) && $_GET['sectionid'] != "") ? $_GET['sectionid'] : NULL;
            $DateFrom = date_create_from_format("d/m/Y", $_GET['PaymentDateFrom']) != false ? date_format(date_create_from_format("d/m/Y", $_GET['PaymentDateFrom']), 'Y-m-d') : date('Y-m-d');
            $DateTo = date_create_from_format("d/m/Y", $_GET['PaymentDateTo']) != false ? date_format(date_create_from_format("d/m/Y", $_GET['PaymentDateTo']), 'Y-m-d') : date('Y-m-d');

            $reportsModel = new ReportsModel();
            $todayout = $reportsModel->report_outpassout($branchid,$sectionid, $DateFrom, $DateTo);
            $todayin = $reportsModel->report_outpassin($branchid,$sectionid, $DateFrom, $DateTo);
            $todaypending = $reportsModel->report_outpasspending($branchid, $sectionid,$DateFrom, $DateTo);
            
            $cart = array();
            $in = 0;
            $out = 0;
            $pending = 0;
            foreach($todayin as $to)
            {
                array_push($cart, $to);
                $in++;
            }
            foreach($todayout as $to)
            {
                array_push($cart, $to);
                $out++;
            }
            foreach($todaypending as $to)
            {
                array_push($cart, $to);
                $pending++;
            }
            //print_r($cart);
            $data['outpass'] = $cart;
            $data['in'] = $in;
            $data['out'] = $out;
            $data['pending'] = $pending;
            $download = (isset($_GET['download']) && $_GET['download'] != "") ? $_GET['download'] : NULL;
            if ($download == 1) {
                $setData = '';
                foreach ($data['outpass'] as $key => $rec) {
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
                header("Content-Disposition: attachment; filename=Out_pass_Report.xls");
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
    public function report_profileimage()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Reports/report_profileimage';
            $branchid = $_SESSION['userdetails']->branchid;
            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();
            $branchid = (isset($_GET['branchid']) && $_GET['branchid'] != "") ? $_GET['branchid'] : $branchid;
            $reportsModel = new ReportsModel();
            $profileimage = $reportsModel->report_profileimage($branchid);
            $cart = array();
            $pending = 0;
            foreach($profileimage as $to)
            {
                array_push($cart, $to);
                $pending++;
            }
             $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();
            $data['pending'] = $pending;
             $data['reservation'] = $cart;
            $download = (isset($_GET['download']) && $_GET['download'] != "") ? $_GET['download'] : NULL;
            if ($download == 1) {
                $setData = '';
                foreach ($data['reservation'] as $key => $rec) {
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
                header("Content-Disposition: attachment; filename=Pending_profileimage_Report.xls");
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
    public function report_employeebudget()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Reports/report_budget';

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            $reportsModel = new ReportsModel();
            $data['report_budget'] = $reportsModel->report_getbudget();

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('home'));
        }
    }
    public function report_outpasssummery()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Reports/report_outpasssummery';

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            $reportsModel = new ReportsModel();
            $data['report_getoutpasssummery'] = $reportsModel->report_getoutpasssummery();
            $data['report_getoutpassout'] = $reportsModel->report_getoutpassout();
            $data['report_getoutpassouttoday'] = $reportsModel->report_gettodayout();
            $data['report_getoutpassoutintoday'] = $reportsModel->report_getoutpassoutintoday();
            $data['report_getoutpassoutin'] = $reportsModel->report_gettodayin();
            $data['report_getoutpassouttotalin'] = $reportsModel->report_gettotalin();

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('home'));
        }
    }
     public function report_employeeleaves()
    {
         if (isset($_SESSION['userdetails'])) {
            $data['page_name'] = 'Reports/report_employeeleaves';
            if (isset($_GET['date'])) {
                $Fromdate = explode('-', $_GET['date'])[0] . "-" . explode('-', $_GET['date'])[1] . "-01";
                $Todate = explode('-', $_GET['date'])[0] . "-" . explode('-', $_GET['date'])[1] . "-31";
            }else
            {
                $Fromdate = date('Y-m').'-01';
                $Todate = date('Y-m').'-31';

            }
          $reportsModel = new ReportsModel();
            $data['employeeleaves'] = $reportsModel->report_employeeleaves($Fromdate,$Todate);
             $download = (isset($_GET['download']) && $_GET['download'] != "") ? $_GET['download'] : NULL;
            if ($download == 1) {
                $setData = '';
                foreach ($data['employeeleaves'] as $key => $rec) {
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
                header("Content-Disposition: attachment; filename=Employeeleaves_Report.xls");
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
    public function report_employeepaysheet()
    {
        if (isset($_SESSION['userdetails'])) {
            $data['page_name'] = 'Reports/report_employeepaysheet';
            if (isset($_GET['date'])) {
                $Fromdate = explode('-', $_GET['date'])[0] . "-" . explode('-', $_GET['date'])[1] . "-01";
            }else
            {
                $Fromdate = date('Y-m').'-01';
            }
            $reportsModel = new ReportsModel();
            $data['employeepaysheet'] = $reportsModel->report_employeepaysheet($Fromdate);
             $download = (isset($_GET['download']) && $_GET['download'] != "") ? $_GET['download'] : NULL;
            if ($download == 1) {
                $setData = '';
                foreach ($data['employeepaysheet'] as $key => $rec) {
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
                header("Content-Disposition: attachment; filename=Employeepaysheet_Report.xls");
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
    public function report_absentlog()
    {
        if (isset($_SESSION['userdetails'])) {
            $data['page_name'] = 'Reports/report_absentstudents';
            $branchid = (isset($_GET['branchid']) && $_GET['branchid'] != "") ? $_GET['branchid'] : NULL;
            $DateTo = date_create_from_format("d/m/Y", $_GET['ToDate']) != false ? date_format(date_create_from_format("d/m/Y", $_GET['ToDate']), 'Y-m-d') :  date('Y-m-d');
            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();
            $reportsModel = new ReportsModel();
            $data['absentlog'] = $reportsModel->report_absentlog($DateTo,$branchid);
            $download = (isset($_GET['download']) && $_GET['download'] != "") ? $_GET['download'] : NULL;
            if ($download == 1) {
                $setData = '';
                foreach ($data['absentlog'] as $key => $rec) {
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
                header("Content-Disposition: attachment; filename=Employeeleaves_Report.xls");
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
}
