<?php

namespace App\Controllers;

use App\Models\HelperModel;
use App\Models\PaymentsModel;
use App\Models\UsersModel;
use App\Models\WalletModel;
use PHPExcel_IOFactory;

include APPPATH . 'ThirdParty/Excel/Classes/PHPExcel.php';

class BulkUpload extends BaseController
{
    public $session;
    public function __construct()
    {
        $session = session();
    }

    public function index()
    {
        $data['page_name'] = 'Admin/bulkupload';
        return view('loggedinuser/index.php', $data);
    }

    public function uploademployees()
    {
       if ($_SESSION['userdetails'] != null) {
            $tmpfname = $_FILES['employees_upload']['tmp_name'];

            $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);

            $excelObj = $excelReader->load($tmpfname);
            $worksheet = $excelObj->getSheet(0);
            $lastRow = $worksheet->getHighestRow();

            for ($row = 2; $row <= $lastRow; $row++) {
                $employeeid = $worksheet->getCell('A' . $row)->getValue();
                $name = $worksheet->getCell('B' . $row)->getValue();
                $designation = $worksheet->getCell('C' . $row)->getValue();
                $branchid = $worksheet->getCell('D' . $row)->getValue();
                $mobile1 = $worksheet->getCell('E' . $row)->getValue();
                $email = $mobile1.'@gmail.com';
                $roleid = $worksheet->getCell('G' . $row)->getValue();
                $password = md5($mobile1);
                $totalleaves = '';
                $reportperson = '';
                $helperModel = new HelperModel();
                $uniqueid = $helperModel->generateUniqueId();

                $usersModel = new UsersModel();
                $userid = $usersModel->addUser($uniqueid, $email, $password, $roleid);
                $usersModel->addEmployee($userid, $name, $branchid, $designation, $mobile1, $employeeid, $email,$totalleaves,$reportperson);
            }

            return redirect()->to(base_url('users/employee'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function uploadstudents()
    {
        // if ($_SESSION['userdetails'] != null) {
        //     $tmpfname = $_FILES['students_upload']['tmp_name'];

        //     $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);

        //     $excelObj = $excelReader->load($tmpfname);
        //     $worksheet = $excelObj->getSheet(0);
        //     $lastRow = $worksheet->getHighestRow();

        //     $helperModel = new HelperModel();
        //     $lookups = $helperModel->get_lookups();

        //     $usersModel = new UsersModel();
        //     $EmployeeDetails = $usersModel->getAllEmployeeDetails();

        //     $output = "<table id='uploaddata' style='color:black !important;' class='table table-striped dt-responsive nowrap DataTable' width='100%' data-page-length='25'>
        //                <thead>
        //                <tr>
        //                  <th>Row Number</th>
        //                  <th>Status</th>
        //                </tr>
        //                </thead>
        //                <tbody>
        //                ";

        //     $errorOutPut = "<table id='errordata' style='color:black !important;' class='table table-striped dt-responsive nowrap DataTable' width='100%' data-page-length='25'>
        //                     <thead>
        //                     <tr>
        //                       <th>Row Number</th>
        //                       <th>Status</th>
        //                     </tr>
        //                     </thead>
        //                     <tbody>
        //                     ";

        //     $status = "";
        //     $error = 0;

        //     for ($row = 2; $row <= $lastRow; $row++) {

        //         if ($row > 2) {
        //             if ($error == 1) {
        //                 $errorOutPut = $errorOutPut . "<tr style='background:orangered'>";
        //                 $errorOutPut = $errorOutPut . "<td>" . ($row - 1) . "</td>";
        //                 $errorOutPut = $errorOutPut . "<td>" . rtrim($status, "- ") . "</td>";
        //                 $errorOutPut = $errorOutPut . "</tr>";
        //             } else {
        //                 $output = $output . "<tr style='background:limegreen'>";
        //                 $output = $output . "<td>" . ($row - 1) . "</td>";
        //                 $output = $output . "<td>" . rtrim($status, "- ") . "</td>";
        //                 $output = $output . "</tr>";
        //             }
        //         }

        //         $status = "";
        //         $error = 0;

        //         $application_number = $worksheet->getCell('A' . $row)->getValue();
        //         if ($application_number == null) {
        //             $status = $status . "Application Number cannot be empty";
        //             $error = 1;
        //             continue;
        //         }

        //         if ($usersModel->checkApplicationNumber($application_number) == "true") {
        //             $reso_fast_hallticket_number = $worksheet->getCell('B' . $row)->getValue();
        //             $reso_fast_score = $usersModel->getRezofastScore($reso_fast_hallticket_number)[0]->score;
        //             if ($reso_fast_score != null) {
        //                 $discount_percentage = $usersModel->getscholarshippercentage($reso_fast_score)->scholarshippercentage;
        //             } else if ($reso_fast_score == null) {
        //                 $discount_percentage = 0;
        //             }

        //             $admission_type = $worksheet->getCell('C' . $row)->getValue();
        //             if ($admission_type == null) {
        //                 $status = $status . "Admission Type cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             } else {
        //                 $admission_type_id = $lookups['admissiontypelookup'][array_search($admission_type, array_column($lookups['admissiontypelookup'], 'admissiontypename'))]->admissiontypeid;
        //             }

        //             $branch = $worksheet->getCell('D' . $row)->getValue();
        //             if ($branch == null) {
        //                 $status = $status . "Branch cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             } else {
        //                 $branch_id = $lookups['branchlookup'][array_search($branch, array_column($lookups['branchlookup'], 'branchname'))]->branchid;
        //             }

        //             $academic_year = $worksheet->getCell('E' . $row)->getValue();
        //             if ($academic_year == null) {
        //                 $status = $status . "Academic Year cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             } else {
        //                 $academic_year_id = $lookups['batchlookup'][array_search($academic_year, array_column($lookups['batchlookup'], 'batchname'))]->batchid;
        //             }

        //             $course = $worksheet->getCell('F' . $row)->getValue();
        //             if ($course == null) {
        //                 $status = $status . "Course cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             } else {
        //                 $course_id = $lookups['courselookup'][array_search($course, array_column($lookups['courselookup'], 'coursename'))]->courseid;
        //             }

        //             $section = $worksheet->getCell('G' . $row)->getValue();
        //             if ($section == null) {
        //                 $status = $status . "Section cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             } else {
        //                 $section_id = $lookups['sectionlookup'][array_search($section, array_column($lookups['sectionlookup'], 'sectionname'))]->sectionid;
        //             }

        //             $second_language = $worksheet->getCell('H' . $row)->getValue();
        //             if ($second_language == null) {
        //                 $status = $status . "Second Language cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             } else {
        //                 $second_language_id = $lookups['secondlanguagelookup'][array_search($second_language, array_column($lookups['secondlanguagelookup'], 'secondlanguagename'))]->secondlanguageid;
        //             }

        //             $referred_employee_id_optional = $worksheet->getCell('I' . $row)->getValue();
        //             if ($referred_employee_id_optional != null) {
        //                 $findEmployee = array_search($referred_employee_id_optional, array_column($EmployeeDetails, 'employeeid'));
        //                 if ($findEmployee != false) {
        //                     $employee = $EmployeeDetails[$findEmployee];
        //                     $referred_employee_id = $employee->userid;
        //                 } else {
        //                     $status = $status . "Invalid Referred Employee Id";
        //                     $error = 1;
        //                     continue;
        //                 }
        //             }

        //             $admission_date = $worksheet->getCell('J' . $row)->getValue();
        //             if ($admission_date == null) {
        //                 $status = $status . "Admission Date cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             } else {
        //                 $admission_date = date_create_from_format("d/m/Y", $admission_date) != false ? date_format(date_create_from_format("d/m/Y", $admission_date), 'Y-m-d') : date('Y-m-d');
        //             }

        //             $student_name = $worksheet->getCell('K' . $row)->getValue();
        //             if ($student_name == null) {
        //                 $status = $status . "Student Name cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             }

        //             $date_of_birth = $worksheet->getCell('L' . $row)->getValue();
        //             if ($date_of_birth == null) {
        //                 $status = $status . "Date of Birth cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             } else {
        //                 $date_of_birth = date_create_from_format("d/m/Y", $date_of_birth) != false ? date_format(date_create_from_format("d/m/Y", $date_of_birth), 'Y-m-d') : "1971-01-01";
        //             }

        //             $gender = $worksheet->getCell('M' . $row)->getValue();
        //             if ($gender == null) {
        //                 $status = $status . "Gender cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             } else {
        //                 $gender_id = $lookups['genderlookup'][array_search($gender, array_column($lookups['genderlookup'], 'gendername'))]->genderid;
        //             }

        //             $category = $worksheet->getCell('N' . $row)->getValue();
        //             if ($category == null) {
        //                 $status = $status . "Category cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             } else {
        //                 $category_id = $lookups['categorylookup'][array_search($category, array_column($lookups['categorylookup'], 'categoryname'))]->categoryid;
        //             }

        //             $nationality = $worksheet->getCell('O' . $row)->getValue();
        //             if ($nationality == null) {
        //                 $status = $status . "Nationality cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             } else {
        //                 $nationality_id = $lookups['nationalitylookup'][array_search($nationality, array_column($lookups['nationalitylookup'], 'nationalityname'))]->nationalityid;
        //             }

        //             $religion = $worksheet->getCell('P' . $row)->getValue();
        //             if ($religion == null) {
        //                 $status = $status . "Religion cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             } else {
        //                 $religion_id = $lookups['religionlookup'][array_search($religion, array_column($lookups['religionlookup'], 'religionname'))]->religionid;
        //             }

        //             $aadhaar_number = $worksheet->getCell('Q' . $row)->getValue();

        //             $father_name = $worksheet->getCell('R' . $row)->getValue();
        //             if ($father_name == null) {
        //                 $status = $status . "Father Name cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             }

        //             $mother_name = $worksheet->getCell('S' . $row)->getValue();
        //             if ($mother_name == null) {
        //                 $status = $status . "Mother Name cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             }

        //             $parent_occupation = $worksheet->getCell('T' . $row)->getValue();
        //             if ($parent_occupation == null) {
        //                 $status = $status . "Parent Occupation cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             }

        //             $board = $worksheet->getCell('U' . $row)->getValue();
        //             if ($board == null) {
        //                 $status = $status . "Board cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             } else {
        //                 $board_id = $lookups['boardlookup'][array_search($board, array_column($lookups['boardlookup'], 'boardname'))]->boardid;
        //             }

        //             $school_or_college = $worksheet->getCell('V' . $row)->getValue();
        //             if ($school_or_college == null) {
        //                 $status = $status . "School/ College cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             }

        //             $place = $worksheet->getCell('W' . $row)->getValue();
        //             if ($place == null) {
        //                 $status = $status . "Place of School/ College cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             }

        //             $grade_or_marks_optional = $worksheet->getCell('X' . $row)->getValue();
        //             $hallticket_number_optional = $worksheet->getCell('Y' . $row)->getValue();

        //             $door_number_street_name = $worksheet->getCell('Z' . $row)->getValue();
        //             if ($door_number_street_name == null) {
        //                 $status = $status . "Door No./ Street Name cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             }

        //             $state = $worksheet->getCell('AA' . $row)->getValue();
        //             if ($state == null) {
        //                 $status = $status . "State cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             } else {
        //                 $state_id = $lookups['stateslookup'][array_search($state, array_column($lookups['stateslookup'], 'state_name'))]->state_id;
        //             }

        //             $district = $worksheet->getCell('AB' . $row)->getValue();
        //             if ($district == null) {
        //                 $status = $status . "District cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             } else {
        //                 $district_id = $lookups['districtslookup'][array_search($district, array_column($lookups['districtslookup'], 'district_name'))]->district_id;
        //                 $district_state_id = $lookups['districtslookup'][array_search($district, array_column($lookups['districtslookup'], 'district_name'))]->state_id;
        //                 if ($district_state_id != $state_id) {
        //                     $status = $status . "District doesn't belong to same state selected";
        //                     $error = 1;
        //                     continue;
        //                 }
        //             }

        //             $city_or_town = $worksheet->getCell('AC' . $row)->getValue();
        //             if ($city_or_town == null) {
        //                 $status = $status . "City/ Town cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             }

        //             $village_or_mandal = $worksheet->getCell('AD' . $row)->getValue();
        //             if ($village_or_mandal == null) {
        //                 $status = $status . "Village/ Mandal cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             }

        //             $pincode = $worksheet->getCell('AE' . $row)->getValue();
        //             if ($pincode == null) {
        //                 $status = $status . "Pincode cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             }

        //             $landmark = $worksheet->getCell('AF' . $row)->getValue();
        //             if ($landmark == null) {
        //                 $status = $status . "Landmark cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             }

        //             $mobile_1 = $worksheet->getCell('AG' . $row)->getValue();
        //             if ($mobile_1 == null) {
        //                 $status = $status . "Mobile 1 cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             }

        //             $mobile_2 = $worksheet->getCell('AH' . $row)->getValue();
        //             if ($mobile_2 == null) {
        //                 $status = $status . "Mobile 2 cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             }

        //             $email_address = $worksheet->getCell('AI' . $row)->getValue();

        //             $tuition_discount = $worksheet->getCell('AJ' . $row)->getValue();
        //             if ($tuition_discount == null) {
        //                 $status = $status . "Final Tuition Fees cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             }

        //             $hostel_discount = $admission_type_id == "1" ? $worksheet->getCell('AK' . $row)->getValue() : "0";

        //             $comments_optional = $worksheet->getCell('AL' . $row)->getValue();

        //             $booking_fees_payment_type = $worksheet->getCell('AM' . $row)->getValue();
        //             if ($booking_fees_payment_type == null) {
        //                 $status = $status . "Booking Fees Payment Type cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             } else {
        //                 $booking_fees_payment_type_id = $lookups['paymenttypelookup'][array_search($booking_fees_payment_type, array_column($lookups['paymenttypelookup'], 'paymenttypename'))]->paymenttypeid;
        //             }

        //             $booking_fees_payment_date = $worksheet->getCell('AN' . $row)->getValue();
        //             if ($booking_fees_payment_date == null) {
        //                 $status = $status . "Book Fees Payment Date cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             } else {
        //                 $booking_fees_payment_date = date_create_from_format("d/m/Y", $booking_fees_payment_date) != false ? date_format(date_create_from_format("d/m/Y", $booking_fees_payment_date), 'Y-m-d') : date('Y-m-d');
        //             }

        //             $booking_fees_amount = $worksheet->getCell('AO' . $row)->getValue();
        //             if ($booking_fees_amount == null) {
        //                 $status = $status . "Booking Fees Amount cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             }

        //             $booking_fees_payment_details   = $worksheet->getCell('AP' . $row)->getValue();
        //             if ($booking_fees_payment_details == null) {
        //                 $status = $status . "Booking Fees Payment Details cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             }

        //             $booking_fees_collected_by_employee_id = $worksheet->getCell('AQ' . $row)->getValue();
        //             if ($booking_fees_collected_by_employee_id != null) {
        //                 $findEmployee = array_search($booking_fees_collected_by_employee_id, array_column($EmployeeDetails, 'employeeid'));
        //                 if ($findEmployee != false) {
        //                     $employee = $EmployeeDetails[$findEmployee];
        //                     $booking_fees_collected_by = $employee->userid;
        //                 } else {
        //                     $status = $status . "Invalid Booking Fees Collected By Employee Id";
        //                     $error = 1;
        //                     continue;
        //                 }
        //             } else {
        //                 $status = $status . "Booking Fees Collected By cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             }

        //             if ($error != 1) {
        //                 $coaching_fee = $helperModel->get_coachingfees_by_courceid_admissiontypeid($course_id, $admission_type_id)->feesvalue;
        //                 $scholarship = (($discount_percentage * $coaching_fee) / 100);

        //                 $previous_class_information = [];
        //                 $class = [];
        //                 $class['class'] = 'PCI';
        //                 $class['school'] = $school_or_college;
        //                 $class['board'] = $board_id;
        //                 $class['place'] = $place;
        //                 $class['grade'] = $grade_or_marks_optional;
        //                 $class['hallticketNo'] = $hallticket_number_optional;
        //                 array_push($previous_class_information, $class);

        //                 $address = [];
        //                 $permanent['door_street'] = $door_number_street_name;
        //                 $permanent['village_mandal'] = $village_or_mandal;
        //                 $permanent['landmark'] = $landmark;
        //                 $permanent['city_town'] = $city_or_town;
        //                 $permanent['state'] = $state_id;
        //                 $permanent['district'] = $district_id;
        //                 $permanent['pin'] = $pincode;

        //                 $address['permanent'] = $permanent;

        //                 $cheque_details = [];

        //                 $random = rand(0, 999999);
        //                 $now = date('dmYHisu') . $random;
        //                 $username = "USR-" . $now;
        //                 $password = md5($username);
        //                 $roleid = 5;

        //                 $applicationstatusid = 1;

        //                 $helperModel = new HelperModel();
        //                 $uniqueid = $helperModel->generateUniqueId();

        //                 $address_json = json_encode($address);
        //                 $previous_class_information_json = json_encode($previous_class_information);
        //                 $cheque_details_json = json_encode($cheque_details);

        //                 $usersModel = new UsersModel();
        //                 $userid = $usersModel->addUser($uniqueid, $username, $password, $roleid);
        //                 $usersModel->addStudent(
        //                     $userid,
        //                     $student_name,
        //                     $date_of_birth,
        //                     $gender_id,
        //                     $nationality_id,
        //                     $religion_id,
        //                     $category_id,
        //                     $aadhaar_number,
        //                     $father_name,
        //                     $mother_name,
        //                     $parent_occupation,
        //                     $previous_class_information_json,
        //                     $address_json,
        //                     $mobile_1,
        //                     $mobile_2,
        //                     $email_address,
        //                     $admission_type_id,
        //                     $branch_id,
        //                     $course_id,
        //                     $section_id,
        //                     $second_language_id,
        //                     $applicationstatusid,
        //                     $application_number,
        //                     $comments_optional,
        //                     $referred_employee_id,
        //                     $academic_year_id,
        //                     $admission_date,
        //                     $tuition_discount,
        //                     $hostel_discount,
        //                     $cheque_details_json,
        //                     $scholarship
        //                 );

        //                 $paymenttypeid = $booking_fees_payment_type_id;
        //                 $paymentamount = $booking_fees_amount;
        //                 $paymentdate = $booking_fees_payment_date;
        //                 $otherdetails = $booking_fees_payment_details;
        //                 $paymentcollectedby = $booking_fees_collected_by;

        //                 $paymentstatusid = 1;

        //                 $batch = $helperModel->get_batch()->year;
        //                 $nextpaymentid = $helperModel->get_paymentidcounter();

        //                 $paymentid = "RMD-" . $batch . "-" . str_pad($nextpaymentid, 6, '0', STR_PAD_LEFT);

        //                 $paymentsModel = new PaymentsModel();
        //                 $result = $paymentsModel->addPayment($paymentid, $userid, $paymentamount, $paymentdate, $paymenttypeid, $otherdetails, $paymentcollectedby, $paymentstatusid);

        //                 if ($result->resultID) {
        //                     $nextpaymentid = $helperModel->set_paymentidcounter();
        //                 }

        //                 $status = "Student Created Successfully";
        //             }
        //         } else {
        //             $status = $status . "Student Already Exists";
        //             $error = 1;
        //             continue;
        //         }
        //     }

        //     if (($row - 1) == $lastRow) {
        //         if ($error == 1) {
        //             $errorOutPut = $errorOutPut . "<tr style='background:orangered'>";
        //             $errorOutPut = $errorOutPut . "<td>" . ($row - 1) . "</td>";
        //             $errorOutPut = $errorOutPut . "<td>" . rtrim($status, "- ") . "</td>";
        //             $errorOutPut = $errorOutPut . "</tr>";
        //         } else {
        //             $output = $output . "<tr style='background:limegreen'>";
        //             $output = $output . "<td>" . ($row - 1) . "</td>";
        //             $output = $output . "<td>" . rtrim($status, "- ") . "</td>";
        //             $output = $output . "</tr>";
        //         }
        //     }

        //     $output = $output . "</tbody></table>";
        //     $errorOutPut = $errorOutPut . "</tbody></table>";

        //     $data['page_name'] = 'Admin/upload_status';

        //     $data['status'] = $output;
        //     $data['error'] = $errorOutPut;

        //     return view('loggedinuser/index.php', $data);
        // } else {
        //     return redirect()->to(base_url('dashboard'));
        // }
    }

    public function uploadstudents1()
    {
        // if ($_SESSION['userdetails'] != null) {
        //     $tmpfname = $_FILES['students_upload']['tmp_name'];

        //     $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);

        //     $excelObj = $excelReader->load($tmpfname);
        //     $worksheet = $excelObj->getSheet(0);
        //     $lastRow = $worksheet->getHighestRow();

        //     $helperModel = new HelperModel();
        //     $lookups = $helperModel->get_lookups();

        //     $usersModel = new UsersModel();
        //     $EmployeeDetails = $usersModel->getAllEmployeeDetails();

        //     $output = "<table id='uploaddata' style='color:black !important;' class='table table-striped dt-responsive nowrap DataTable' width='100%' data-page-length='25'>
        //                <thead>
        //                <tr>
        //                  <th>Row Number</th>
        //                  <th>Status</th>
        //                </tr>
        //                </thead>
        //                <tbody>
        //                ";

        //     $errorOutPut = "<table id='errordata' style='color:black !important;' class='table table-striped dt-responsive nowrap DataTable' width='100%' data-page-length='25'>
        //                     <thead>
        //                     <tr>
        //                       <th>Row Number</th>
        //                       <th>Status</th>
        //                     </tr>
        //                     </thead>
        //                     <tbody>
        //                     ";

        //     $status = "";
        //     $error = 0;

        //     for ($row = 2; $row <= $lastRow; $row++) {

        //         if ($row > 2) {
        //             if ($error == 1) {
        //                 $errorOutPut = $errorOutPut . "<tr style='background:orangered'>";
        //                 $errorOutPut = $errorOutPut . "<td>" . ($row - 1) . "</td>";
        //                 $errorOutPut = $errorOutPut . "<td>" . rtrim($status, "- ") . "</td>";
        //                 $errorOutPut = $errorOutPut . "</tr>";
        //             } else {
        //                 $output = $output . "<tr style='background:limegreen'>";
        //                 $output = $output . "<td>" . ($row - 1) . "</td>";
        //                 $output = $output . "<td>" . rtrim($status, "- ") . "</td>";
        //                 $output = $output . "</tr>";
        //             }
        //         }

        //         $status = "";
        //         $error = 0;

        //         $application_number = $worksheet->getCell('A' . $row)->getValue();
        //         if ($application_number == null) {
        //             $status = $status . "Application Number cannot be empty";
        //             $error = 1;
        //             continue;
        //         }

        //         if ($usersModel->checkApplicationNumber($application_number) == "true") {
        //             $reso_fast_hallticket_number = $worksheet->getCell('B' . $row)->getValue();
        //             $reso_fast_score = $usersModel->getRezofastScore($reso_fast_hallticket_number)[0]->score;
        //             if ($reso_fast_score != null) {
        //                 $discount_percentage = $usersModel->getscholarshippercentage($reso_fast_score)->scholarshippercentage;
        //             } else if ($reso_fast_score == null) {
        //                 $discount_percentage = 0;
        //             }

        //             $admission_type = $worksheet->getCell('C' . $row)->getValue();
        //             if ($admission_type == null) {
        //                 $status = $status . "Admission Type cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             } else {
        //                 $admission_type_id = $lookups['admissiontypelookup'][array_search($admission_type, array_column($lookups['admissiontypelookup'], 'admissiontypename'))]->admissiontypeid;
        //             }

        //             $branch = $worksheet->getCell('D' . $row)->getValue();
        //             if ($branch == null) {
        //                 $status = $status . "Branch cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             } else {
        //                 $branch_id = $lookups['branchlookup'][array_search($branch, array_column($lookups['branchlookup'], 'branchname'))]->branchid;
        //             }

        //             $academic_year = $worksheet->getCell('E' . $row)->getValue();
        //             if ($academic_year == null) {
        //                 $status = $status . "Academic Year cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             } else {
        //                 $academic_year_id = $lookups['batchlookup'][array_search($academic_year, array_column($lookups['batchlookup'], 'batchname'))]->batchid;
        //             }

        //             $course = $worksheet->getCell('F' . $row)->getValue();
        //             if ($course == null) {
        //                 $status = $status . "Course cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             } else {
        //                 $course_id = $lookups['courselookup'][array_search($course, array_column($lookups['courselookup'], 'coursename'))]->courseid;
        //             }

        //             $section = $worksheet->getCell('G' . $row)->getValue();
        //             if ($section == null) {
        //                 $status = $status . "Section cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             } else {
        //                 $section_id = $lookups['sectionlookup'][array_search($section, array_column($lookups['sectionlookup'], 'sectionname'))]->sectionid;
        //             }

        //             $second_language = $worksheet->getCell('H' . $row)->getValue();
        //             if ($second_language == null) {
        //                 $status = $status . "Second Language cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             } else {
        //                 $second_language_id = $lookups['secondlanguagelookup'][array_search($second_language, array_column($lookups['secondlanguagelookup'], 'secondlanguagename'))]->secondlanguageid;
        //             }

        //             $referred_employee_id_optional = $worksheet->getCell('I' . $row)->getValue();
        //             if ($referred_employee_id_optional != null) {
        //                 $findEmployee = array_search($referred_employee_id_optional, array_column($EmployeeDetails, 'employeeid'));
        //                 if ($findEmployee != false) {
        //                     $employee = $EmployeeDetails[$findEmployee];
        //                     $referred_employee_id = $employee->userid;
        //                 } else {
        //                     $status = $status . "Invalid Referred Employee Id";
        //                     $error = 1;
        //                     continue;
        //                 }
        //             }

        //             $admission_date = $worksheet->getCell('J' . $row)->getValue();
        //             if ($admission_date == null) {
        //                 $status = $status . "Admission Date cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             } else {
        //                 $admission_date = date_create_from_format("d/m/Y", $admission_date) != false ? date_format(date_create_from_format("d/m/Y", $admission_date), 'Y-m-d') : date('Y-m-d');
        //             }

        //             $student_name = $worksheet->getCell('K' . $row)->getValue();
        //             if ($student_name == null) {
        //                 $status = $status . "Student Name cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             }

        //             $date_of_birth = $worksheet->getCell('L' . $row)->getValue();
        //             if ($date_of_birth == null) {
        //                 $status = $status . "Date of Birth cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             } else {
        //                 $date_of_birth = date_create_from_format("d/m/Y", $date_of_birth) != false ? date_format(date_create_from_format("d/m/Y", $date_of_birth), 'Y-m-d') : "1971-01-01";
        //             }

        //             $gender = $worksheet->getCell('M' . $row)->getValue();
        //             if ($gender == null) {
        //                 $status = $status . "Gender cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             } else {
        //                 $gender_id = $lookups['genderlookup'][array_search($gender, array_column($lookups['genderlookup'], 'gendername'))]->genderid;
        //             }

        //             $category = $worksheet->getCell('N' . $row)->getValue();
        //             if ($category == null) {
        //                 $status = $status . "Category cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             } else {
        //                 $category_id = $lookups['categorylookup'][array_search($category, array_column($lookups['categorylookup'], 'categoryname'))]->categoryid;
        //             }

        //             $nationality = $worksheet->getCell('O' . $row)->getValue();
        //             if ($nationality == null) {
        //                 $status = $status . "Nationality cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             } else {
        //                 $nationality_id = $lookups['nationalitylookup'][array_search($nationality, array_column($lookups['nationalitylookup'], 'nationalityname'))]->nationalityid;
        //             }

        //             $religion = $worksheet->getCell('P' . $row)->getValue();
        //             if ($religion == null) {
        //                 $status = $status . "Religion cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             } else {
        //                 $religion_id = $lookups['religionlookup'][array_search($religion, array_column($lookups['religionlookup'], 'religionname'))]->religionid;
        //             }

        //             $aadhaar_number = $worksheet->getCell('Q' . $row)->getValue();

        //             $father_name = $worksheet->getCell('R' . $row)->getValue();
        //             if ($father_name == null) {
        //                 $status = $status . "Father Name cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             }

        //             $mother_name = $worksheet->getCell('S' . $row)->getValue();
        //             if ($mother_name == null) {
        //                 $status = $status . "Mother Name cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             }

        //             $parent_occupation = $worksheet->getCell('T' . $row)->getValue();
        //             if ($parent_occupation == null) {
        //                 $status = $status . "Parent Occupation cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             }

        //             $board = $worksheet->getCell('U' . $row)->getValue();
        //             if ($board == null) {
        //                 $status = $status . "Board cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             } else {
        //                 $board_id = $lookups['boardlookup'][array_search($board, array_column($lookups['boardlookup'], 'boardname'))]->boardid;
        //             }

        //             $school_or_college = $worksheet->getCell('V' . $row)->getValue();
        //             if ($school_or_college == null) {
        //                 $status = $status . "School/ College cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             }

        //             $place = $worksheet->getCell('W' . $row)->getValue();
        //             if ($place == null) {
        //                 $status = $status . "Place of School/ College cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             }

        //             $grade_or_marks_optional = $worksheet->getCell('X' . $row)->getValue();
        //             $hallticket_number_optional = $worksheet->getCell('Y' . $row)->getValue();

        //             $door_number_street_name = $worksheet->getCell('Z' . $row)->getValue();
        //             if ($door_number_street_name == null) {
        //                 $status = $status . "Door No./ Street Name cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             }

        //             $state = $worksheet->getCell('AA' . $row)->getValue();
        //             if ($state == null) {
        //                 $status = $status . "State cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             } else {
        //                 $state_id = $lookups['stateslookup'][array_search($state, array_column($lookups['stateslookup'], 'state_name'))]->state_id;
        //             }

        //             $district = $worksheet->getCell('AB' . $row)->getValue();
        //             if ($district == null) {
        //                 $status = $status . "District cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             } else {
        //                 $district_id = $lookups['districtslookup'][array_search($district, array_column($lookups['districtslookup'], 'district_name'))]->district_id;
        //                 $district_state_id = $lookups['districtslookup'][array_search($district, array_column($lookups['districtslookup'], 'district_name'))]->state_id;
        //                 if ($district_state_id != $state_id) {
        //                     $status = $status . "District doesn't belong to same state selected";
        //                     $error = 1;
        //                     continue;
        //                 }
        //             }

        //             $city_or_town = $worksheet->getCell('AC' . $row)->getValue();
        //             if ($city_or_town == null) {
        //                 $status = $status . "City/ Town cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             }

        //             $village_or_mandal = $worksheet->getCell('AD' . $row)->getValue();
        //             if ($village_or_mandal == null) {
        //                 $status = $status . "Village/ Mandal cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             }

        //             $pincode = $worksheet->getCell('AE' . $row)->getValue();
        //             if ($pincode == null) {
        //                 $status = $status . "Pincode cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             }

        //             $landmark = $worksheet->getCell('AF' . $row)->getValue();
        //             if ($landmark == null) {
        //                 $status = $status . "Landmark cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             }

        //             $mobile_1 = $worksheet->getCell('AG' . $row)->getValue();
        //             if ($mobile_1 == null) {
        //                 $status = $status . "Mobile 1 cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             }

        //             $mobile_2 = $worksheet->getCell('AH' . $row)->getValue();
        //             if ($mobile_2 == null) {
        //                 $status = $status . "Mobile 2 cannot be empty";
        //                 $error = 1;
        //                 continue;
        //             }

        //             $email_address = $worksheet->getCell('AI' . $row)->getValue();

        //             if ($error != 1) {
        //                 // $coaching_fee = $helperModel->get_coachingfees_by_courceid_admissiontypeid($course_id, $admission_type_id)->feesvalue;
        //                 // $scholarship = (($discount_percentage * $coaching_fee) / 100);

        //                 $previous_class_information = [];
        //                 $class = [];
        //                 $class['class'] = 'PCI';
        //                 $class['school'] = $school_or_college;
        //                 $class['board'] = $board_id;
        //                 $class['place'] = $place;
        //                 $class['grade'] = $grade_or_marks_optional;
        //                 $class['hallticketNo'] = $hallticket_number_optional;
        //                 array_push($previous_class_information, $class);

        //                 $address = [];
        //                 $permanent['door_street'] = $door_number_street_name;
        //                 $permanent['village_mandal'] = $village_or_mandal;
        //                 $permanent['landmark'] = $landmark;
        //                 $permanent['city_town'] = $city_or_town;
        //                 $permanent['state'] = $state_id;
        //                 $permanent['district'] = $district_id;
        //                 $permanent['pin'] = $pincode;

        //                 $address['permanent'] = $permanent;

        //                 $cheque_details = [];

        //                 $random = rand(0, 999999);
        //                 $now = date('dmYHisu') . $random;
        //                 $username = "USR-" . $now;
        //                 $password = md5($username);
        //                 $roleid = 5;

        //                 $applicationstatusid = 1;

        //                 $helperModel = new HelperModel();
        //                 $uniqueid = $helperModel->generateUniqueId();

        //                 $address_json = json_encode($address);
        //                 $previous_class_information_json = json_encode($previous_class_information);
        //                 $cheque_details_json = json_encode($cheque_details);

        //                 $usersModel = new UsersModel();
        //                 $userid = $usersModel->addUser($uniqueid, $username, $password, $roleid);

        //                 $usersModel->addStudent(
        //                     $userid,
        //                     $student_name,
        //                     $date_of_birth,
        //                     $gender_id,
        //                     $nationality_id,
        //                     $religion_id,
        //                     $category_id,
        //                     $aadhaar_number,
        //                     $father_name,
        //                     $mother_name,
        //                     $parent_occupation,
        //                     $previous_class_information_json,
        //                     $address_json,
        //                     $mobile_1,
        //                     $mobile_2,
        //                     $email_address,
        //                     $admission_type_id,
        //                     $branch_id,
        //                     $course_id,
        //                     $section_id,
        //                     $second_language_id,
        //                     $applicationstatusid,
        //                     $application_number,
        //                     '',
        //                     $referred_employee_id,
        //                     $academic_year_id,
        //                     $admission_date,
        //                     0,
        //                     0,
        //                     $cheque_details_json,
        //                     0
        //                 );
        //                 $status = "Student Created Successfully";
        //             }
        //         } else {
        //             $status = $status . "Student Already Exists";
        //             $error = 1;
        //             continue;
        //         }
        //     }

        //     if (($row - 1) == $lastRow) {
        //         if ($error == 1) {
        //             $errorOutPut = $errorOutPut . "<tr style='background:orangered'>";
        //             $errorOutPut = $errorOutPut . "<td>" . ($row - 1) . "</td>";
        //             $errorOutPut = $errorOutPut . "<td>" . rtrim($status, "- ") . "</td>";
        //             $errorOutPut = $errorOutPut . "</tr>";
        //         } else {
        //             $output = $output . "<tr style='background:limegreen'>";
        //             $output = $output . "<td>" . ($row - 1) . "</td>";
        //             $output = $output . "<td>" . rtrim($status, "- ") . "</td>";
        //             $output = $output . "</tr>";
        //         }
        //     }

        //     $output = $output . "</tbody></table>";
        //     $errorOutPut = $errorOutPut . "</tbody></table>";

        //     $data['page_name'] = 'Admin/upload_status';

        //     $data['status'] = $output;
        //     $data['error'] = $errorOutPut;

        //     return view('loggedinuser/index.php', $data);
        // } else {
        //     return redirect()->to(base_url('dashboard'));
        // }
    }

    public function uploadpayments()
    {
        // if ($_SESSION['userdetails'] != null) {
        //     $tmpfname = $_FILES['payments_upload']['tmp_name'];

        //     $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);

        //     $excelObj = $excelReader->load($tmpfname);
        //     $worksheet = $excelObj->getSheet(0);
        //     $lastRow = $worksheet->getHighestRow();

        //     $error = "";
        //     for ($row = 2; $row <= $lastRow; $row++) {
        //         $application_number = $worksheet->getCell('A' . $row)->getValue();

        //         $usersModel = new UsersModel();
        //         $studentDetails = $usersModel->getStudentDetailsByApplicationNumber($application_number);

        //         $fees = $worksheet->getCell('B' . $row)->getValue();

        //         if($studentDetails != null)
        //         {
        //             $helperModel = new HelperModel();
        //             $nextpaymentid = $helperModel->get_paymentidcounter();
        
        //             $paymentid = "RMD-2022-" . str_pad($nextpaymentid, 6, '0', STR_PAD_LEFT);
        
        //             $paymentsModel = new PaymentsModel();
        //             $result = $paymentsModel->addPayment($paymentid, $studentDetails->userid, $fees, "0001-01-01", 9, 'Bulk Posting Backend', 1, 1, 1);
        
        //             if ($result->resultID) {
        //                 $nextpaymentid = $helperModel->set_paymentidcounter();
        //             }
        //         }
        //         else
        //         {
        //             $error += "This user doesn't exist " . $studentDetails->userid . "<br />";
        //         }
               
        //     }
        //     var_dump($error);
        //        exit();

        //     return redirect()->to(base_url('payments/payment'));
        // } else {
        //     return redirect()->to(base_url('dashboard'));
        // }
    }

    public function uploadwallet()
    {
        if ($_SESSION['userdetails'] != null) {
            $tmpfname = $_FILES['wallet_upload']['tmp_name'];

            $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);

            $excelObj = $excelReader->load($tmpfname);
            $worksheet = $excelObj->getSheet(0);
            $lastRow = $worksheet->getHighestRow();

            $output = "<table id='uploaddata' style='color:black !important;' class='table table-striped dt-responsive nowrap DataTable' width='100%' data-page-length='25'>
                       <thead>
                       <tr>
                         <th>Row Number</th>
                         <th>Status</th>
                       </tr>
                       </thead>
                       <tbody>
                       ";

            $errorOutPut = "<table id='errordata' style='color:black !important;' class='table table-striped dt-responsive nowrap DataTable' width='100%' data-page-length='25'>
                            <thead>
                            <tr>
                              <th>Row Number</th>
                              <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            ";

            $status = "";
            $error = 0;

            $usersModel = new UsersModel();
            $EmployeeDetails = $usersModel->getAllEmployeeDetails();

            for ($row = 2; $row <= $lastRow; $row++) {

                if ($row > 2) {
                    if ($error == 1) {
                        $errorOutPut = $errorOutPut . "<tr style='background:orangered'>";
                        $errorOutPut = $errorOutPut . "<td>" . ($row - 1) . "</td>";
                        $errorOutPut = $errorOutPut . "<td>" . rtrim($status, "- ") . "</td>";
                        $errorOutPut = $errorOutPut . "</tr>";
                    } else {
                        $output = $output . "<tr style='background:limegreen'>";
                        $output = $output . "<td>" . ($row - 1) . "</td>";
                        $output = $output . "<td>" . rtrim($status, "- ") . "</td>";
                        $output = $output . "</tr>";
                    }
                }

                $status = "";
                $error = 0;

                $wallettypeid = $worksheet->getCell('A' . $row)->getValue();
                if ($wallettypeid == null) {
                    $status = $status . "Wallet Type Id cannot be empty";
                    $error = 1;
                    continue;
                }

                $applicationnumber = $worksheet->getCell('B' . $row)->getValue();
                if ($applicationnumber == null) {
                    $status = $status . "Application Number cannot be empty";
                    $error = 1;
                    continue;
                } else {
                    $studentDetails = $usersModel->getStudentDetailsByApplicationNumber($applicationnumber);
                    if ($studentDetails != null) {
                        $student_id = $studentDetails->userid;
                    } else {
                        $status = $status . "Invalid Student Application Number";
                        $error = 1;
                        continue;
                    }
                }

                $transactiontype = $worksheet->getCell('C' . $row)->getValue();
                if ($transactiontype == null) {
                    $status = $status . "Transaction Type cannot be empty";
                    $error = 1;
                    continue;
                }

                $amount = $worksheet->getCell('D' . $row)->getValue();
                if ($amount == null) {
                    $status = $status . "Amount cannot be empty";
                    $error = 1;
                    continue;
                }

                $date = $worksheet->getCell('E' . $row)->getValue();
                if ($date == null) {
                    $status = $status . "Payment Date cannot be empty";
                    $error = 1;
                    continue;
                } else {
                    $payment_date = date_create_from_format("d/m/Y", $date) != false ? date_format(date_create_from_format("d/m/Y", $date), 'Y-m-d') : date('Y-m-d');
                }

                $payment_details = $worksheet->getCell('F' . $row)->getValue();
                if ($payment_details == null) {
                    $status = $status . "Payment Details cannot be empty";
                    $error = 1;
                    continue;
                }

                $remarks = $worksheet->getCell('G' . $row)->getValue();
                if ($remarks == null) {
                    $status = $status . "Remarks cannot be empty";
                    $error = 1;
                    continue;
                }

                $transacted_by = $worksheet->getCell('H' . $row)->getValue();
                if ($transacted_by == null) {
                    $status = $status . "Transacted By cannot be empty";
                    $error = 1;
                    continue;
                } else {
                    $findEmployee = array_search($transacted_by, array_column($EmployeeDetails, 'employeeid'));
                    if ($findEmployee != false) {
                        $employee = $EmployeeDetails[$findEmployee];
                        $transacted_by_id = $employee->userid;
                    } else {
                        $status = $status . "Invalid Referred Employee Id";
                        $error = 1;
                        continue;
                    }
                }

                if ($error != 1) {
                    $walletModel = new WalletModel();
                    $walletDetails = $walletModel->getWalletDetails($student_id, $wallettypeid)[0];
                    if ($walletDetails == NULL) {
                        if ($transactiontype == "Credit") {
                            $walletid = $walletModel->addWalletDetails($wallettypeid, $student_id, $amount);
                        } else {
                            $walletid = $walletModel->addWalletDetails($wallettypeid, $student_id, -$amount);
                        }

                        if ($walletid != 0) {
                            $walletModel->addUpdateWalletTransactions($walletid, $student_id, $amount, $payment_date, $transactiontype, $transacted_by_id, $remarks, $payment_details);
                            $status = "Wallet Updated Successfully";
                        }
                    } else {
                        if ($transactiontype == "Credit") {
                            $FinalAmount = $walletDetails->amount + $amount;
                            $walletModel->updateWalletDetails($walletDetails->walletid, $FinalAmount);
                            $walletModel->addUpdateWalletTransactions($walletDetails->walletid, $student_id, $amount, $payment_date, $transactiontype, $transacted_by_id, $remarks, $payment_details);
                            $status = "Wallet Updated Successfully";
                        } else if ($transactiontype == "Debit") {
                            $FinalAmount = $walletDetails->amount - $amount;
                            $walletModel->updateWalletDetails($walletDetails->walletid, $FinalAmount);
                            $walletModel->addUpdateWalletTransactions($walletDetails->walletid, $student_id, $amount, $payment_date, $transactiontype, $transacted_by_id, $remarks, $payment_details);
                            $status = "Wallet Updated Successfully";
                        }
                    }
                }
            }

            if (($row - 1) == $lastRow) {
                if ($error == 1) {
                    $errorOutPut = $errorOutPut . "<tr style='background:orangered'>";
                    $errorOutPut = $errorOutPut . "<td>" . ($row - 1) . "</td>";
                    $errorOutPut = $errorOutPut . "<td>" . rtrim($status, "- ") . "</td>";
                    $errorOutPut = $errorOutPut . "</tr>";
                } else {
                    $output = $output . "<tr style='background:limegreen'>";
                    $output = $output . "<td>" . ($row - 1) . "</td>";
                    $output = $output . "<td>" . rtrim($status, "- ") . "</td>";
                    $output = $output . "</tr>";
                }
            }

            $output = $output . "</tbody></table>";
            $errorOutPut = $errorOutPut . "</tbody></table>";

            $data['page_name'] = 'Admin/upload_status';

            $data['status'] = $output;
            $data['error'] = $errorOutPut;

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }
}
