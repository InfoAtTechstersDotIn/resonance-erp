<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\EmailModel;
use App\Models\HelperModel;
use App\Models\PaymentsModel;
use App\Models\PayrollModel;
use App\Models\UsersModel;

class Payroll extends BaseController
{
    public $session;
    public function __construct()
    {
        $session = session();
    }


    
    // public function salary_grade()
    // {
    //     $data['page_name'] = 'Payroll/salary_grade';

    //     $helperModel = new HelperModel();
    //     $data['lookups'] = $helperModel->get_lookups();

    //     $payrollModel = new PayrollModel();
    //     $data['salary_grades'] = $payrollModel->get_salary_grades();

    //     return view('loggedinuser/index.php', $data);
    // }

    // public function add_salary_grades()
    // {
    //     $data['salarygradename'] = $_POST['salarygradename'];
    //     $data['basic'] = $_POST['basic'];
    //     $data['hra'] = $_POST['hra'];
    //     $data['ta'] = $_POST['ta'];
    //     $data['ma'] = $_POST['ma'];
    //     $data['pf'] = $_POST['pf'];
    //     $data['leaves'] = $_POST['leaves'];

    //     $payrollModel = new PayrollModel();
    //     $payrollModel->add_salary_grades($data);

    //     return redirect()->to(base_url('payroll/salary_grade'));
    // }

    // public function update_salary_grades()
    // {
    //     $data['salarygradeid'] = $_POST['salarygradeid'];
    //     $data['salarygradename'] = $_POST['salarygradename'];
    //     $data['basic'] = $_POST['basic'];
    //     $data['hra'] = $_POST['hra'];
    //     $data['ta'] = $_POST['ta'];
    //     $data['ma'] = $_POST['ma'];
    //     $data['pf'] = $_POST['pf'];
    //     $data['leaves'] = $_POST['leaves'];

    //     $payrollModel = new PayrollModel();
    //     $payrollModel->update_salary_grades($data);

    //     return redirect()->to(base_url('payroll/salary_grade'));
    // }

    // public function delete_salary_grades()
    // {
    //     $data['salarygradeid'] = $_GET['salarygradeid'];

    //     $payrollModel = new PayrollModel();
    //     $payrollModel->delete_salary_grades($data);

    //     return redirect()->to(base_url('payroll/salary_grade'));
    // }

    public function employee_package()
    {
        $data['page_name'] = 'Payroll/employee_package';

        $helperModel = new HelperModel();
        $data['lookups'] = $helperModel->get_lookups();

        $usersModel = new UsersModel();
        $data['employee_packages'] = $usersModel->getAllEmployeeDetails();

        return view('loggedinuser/index.php', $data);
    }

    public function salary_payment()
    {
        $data['page_name'] = 'Payroll/salary_payment';

        $helperModel = new HelperModel();
        $data['lookups'] = $helperModel->get_lookups();

        if (isset($_GET['date'])) {
             $date = explode('-', $_GET['date'])[0] . "-" . explode('-', $_GET['date'])[1] . "-01";
            $payrollModel = new PayrollModel();
            $data['salaries'] = $payrollModel->get_salaries($date);
        }

        return view('loggedinuser/index.php', $data);
    }

    public function update_employee_package()
    {
        $usersModel = new UsersModel();

        $newPackage = $_POST['newpackage'];
        $userid = $_POST['userid'];

        $data['employee_packages'] = $usersModel->update_employee_package($newPackage, $userid);

        return redirect()->to(base_url("users/employee"));
    }

     public function regenerate_salary($employeeId, $salaryDate)
    {
        $usersModel = new UsersModel();
        $employee = $usersModel->getAllEmployeeDetailsById($employeeId)[0];

        $payrollModel = new PayrollModel();
        $salary_grade = $payrollModel->get_salary_grades()[0];

        $data['salarydate'] = $salaryDate;
        $data['employeeid'] = $employee->userid;

        $empWorkingDays = $usersModel->get_employee_workingdays($data['employeeid'], date_format(date_create($salaryDate), "Y"), date_format(date_create($salaryDate), "m"));
        $empLates = $usersModel->get_employee_lates($data['employeeid'], date_format(date_create($salaryDate), "Y"), date_format(date_create($salaryDate), "m"));

        $helperModel = new HelperModel();
        $numberOfLatesForADayOfAbsence = $helperModel->get_settings('numberOfLatesForADayOfAbsence');

        $package = $data['ctc'] = $employee->package;
        if ($package != 0) {
            $monthly = $data['monthly'] = round($package / 12);

            $basic = $data['basic'] = round(($monthly * $salary_grade->basic) / 100);
            $houserentalallowance = $data['houserentalallowance'] = round(($basic * $salary_grade->houserentalallowance) / 100);
            $transportallowance = $data['transportallowance'] = $salary_grade->transportallowance;
            $childreneducationallowance = $data['childreneducationallowance'] = $salary_grade->childreneducationallowance;
            $medicalallowance = $data['medicalallowance'] = $salary_grade->medicalallowance;

            $providentfund_employer = $data['providentfund_employer'] = round(($basic * $salary_grade->providentfund_employer) / 100);

            $specialallowance = $data['specialallowance'] = $monthly - $basic - $houserentalallowance - $transportallowance - $childreneducationallowance - $medicalallowance - $providentfund_employer;
            $gross = $data['gross'] = $basic + $houserentalallowance + $transportallowance + $childreneducationallowance + $medicalallowance + $specialallowance;

            $data['employeesstateinsurance_employer'] = round(($gross * $salary_grade->employeesstateinsurance_employer) / 100);

            $pt = $data['pt'] = $salary_grade->pt;
            $tds = $data['tds'] = $salary_grade->tds;

            if ($monthly < 20000) {
                $providentfund_employee = $data['providentfund_employee'] = 0;
                $employeesstateinsurance_employee = $data['employeesstateinsurance_employee'] = round(($gross * $salary_grade->employeesstateinsurance_employee) / 100);
            } elseif ($monthly >= 20000) {
                $providentfund_employee = $data['providentfund_employee'] = round(($basic * $salary_grade->providentfund_employee) / 100);
                $employeesstateinsurance_employee = $data['employeesstateinsurance_employee'] = 0;
            }

            $net = $data['net'] = $gross - $providentfund_employee - $employeesstateinsurance_employee - $pt - $tds;

            $TotalWorkingDays = $data['totalbusinessdays'] = $data['paiddays'] = $empWorkingDays[0]->TotalWorkingDays;

            $TotalDaysAttended = $empWorkingDays[0]->TotalDaysAttended;

            $daily = $data['daily'] = $net / ($TotalWorkingDays);
            $totalLeaves = $TotalWorkingDays - $TotalDaysAttended;

            $comment = "";
            $penalty = 0;
            $paiddays = $data['paiddays'];
            $unpaiddays = 0;
            $net = $data['net'];

            if ($totalLeaves > $employee->leavespermonth) {
                $unpaiddays = $totalLeaves - $employee->leavespermonth;
                $paiddays = $paiddays - $unpaiddays;
                $penalty = $daily * $unpaiddays;
                $comment = $comment . "{$unpaiddays} Days Penalty for leaves, ";
            }

            if ($empLates > $numberOfLatesForADayOfAbsence) {
                $totalAbsentByLates = floor($empLates / $numberOfLatesForADayOfAbsence);

                $unpaiddays = $unpaiddays + $totalAbsentByLates;
                $paiddays = $paiddays - $unpaiddays;
                $penalty = $daily * $unpaiddays;
                $comment = $comment . "{$totalAbsentByLates} Days Penalty for coming late, ";
            }

            $data['unpaiddays'] = $unpaiddays;
            $data['paiddays'] = $paiddays;
            $data['penalty'] = $penalty;
            $data['net'] = $net - $penalty;

            $payrollModel->insert_salary_payment($data, 1);
        }

        return redirect()->to(base_url("payroll/salary_payment?date=") . explode('-', $salaryDate)[1] . "/" . explode('-', $salaryDate)[0]);
    }

    public function generate_current_month_salaries()
    {
        $salaryDate = explode('-', $_POST['salarydate'])[0] . "-" . explode('-', $_POST['salarydate'])[1] . "-01";


        if (isset($_POST['branchid'])) {
            $branchid = COUNT($_POST['branchid']) == 0 ? "" : implode(',', $_POST['branchid']);
        } else {
            $branchid = '';
        }
        $usersModel = new UsersModel();
        if (!empty($branchid)) {
            $employeeDetails = $usersModel->getAllEmployeeDetailsBranch($branchid);
        } else {
            $employeeDetails = $usersModel->getAllEmployeeDetails();
        }
        foreach ($employeeDetails as $employee) {
            $payrollModel = new PayrollModel();
            $salary_grade = $payrollModel->get_employee_salary_grades($employee->userid);
            $salary_package = $payrollModel->get_employee_salary_package($employee->userid);
            if (!empty($salary_package)) {
                if (!empty($salary_grade)) {
                    $salary_grade = $payrollModel->get_employee_salary_grades($employee->userid)[0];
                    $data['salarydate'] = date_format(date_create($salaryDate), "Y-m-d");
                    $data['employeeid'] = $employee->userid;
                    $month = date_format(date_create($salaryDate), "m");
                    $year = date_format(date_create($salaryDate), "Y");
                    $employee_weekoff = $payrollModel->get_employee_week_off($employee->userid);
                    $empHolidays = $usersModel->get_employee_holidays($data['employeeid'], date_format(date_create($salaryDate), "Y"), date_format(date_create($salaryDate), "m"));
                    $month = date_format(date_create($salaryDate), "m");
                    $year = date_format(date_create($salaryDate), "Y");
                    $dt = $salaryDate;
                    $fromdt = date("Y-m-01", strtotime($dt));
                    $todt =  date("Y-m-t", strtotime($dt));
                    $monthName = date("F", mktime(0, 0, 0, $month));
                    $begin  = new \DateTime($fromdt);
                    $end    = new \DateTime($todt);
                    $array = [];
                    $sunday = [];
                    $i = 0;
                    while ($begin <= $end) // Loop will work begin to the end date 
                    {
                        $array[$begin->format("Y-m-d")] = 0;
                        if ($i != 0) {
                            $begin->modify('+1 day');
                        }
                        foreach ($employee_weekoff as $week) {
                            if ($week->sunday == 1) {
                                if ($begin->format("D") == "Sun") //Check that the day is Sunday here
                                {
                                    $sunday[$begin->format("Y-m-d")] = 1;
                                }
                            }
                            if ($week->monday == 1) {
                                if ($begin->format("D") == "Mon") //Check that the day is Sunday here
                                {
                                    $sunday[$begin->format("Y-m-d")] = 1;
                                }
                            }
                            if ($week->tuesday == 1) {
                                if ($begin->format("D") == "Tue") //Check that the day is Sunday here
                                {
                                    $sunday[$begin->format("Y-m-d")] = 1;
                                }
                            }
                            if ($week->wednesday == 1) {
                                if ($begin->format("D") == "Wed") //Check that the day is Sunday here
                                {

                                    $sunday[$begin->format("Y-m-d")] = 1;
                                }
                            }
                            if ($week->thursday == 1) {
                                if ($begin->format("D") == "Thur") //Check that the day is Sunday here
                                {
                                    $sunday[$begin->format("Y-m-d")] = 1;
                                }
                            }
                            if ($week->friday == 1) {
                                if ($begin->format("D") == "Fri") //Check that the day is Sunday here
                                {
                                    $sunday[$begin->format("Y-m-d")] = 1;
                                }
                            }
                            if ($week->saturday == 1) {
                                if ($begin->format("D") == "Sat") //Check that the day is Sunday here
                                {
                                    echo $begin->format("Y-m-d");

                                    $sunday[$begin->format("Y-m-d")] = 1;
                                }
                            }
                        }
                        $i++;
                    }
                    $workingdays = 0;
                    foreach ($array as $key => $a) {
                        foreach ($sunday as $key1 => $a1) {
                            if ($key == $key1) {
                                $array[$key] = 1;
                            }
                        }
                        foreach ($empHolidays as $a2) {
                            $holiday = $a2->date;
                            if ($key == $holiday) {
                                $array[$key] = 1;
                            }
                        }
                        if ($array[$key] == 0) {
                            $workingdays++;
                        }
                    }
                    $empWorkingDays = $usersModel->get_employee_workingdays($data['employeeid'], date_format(date_create($salaryDate), "Y"), date_format(date_create($salaryDate), "m"));

                    $empLateslogin = $usersModel->get_employee_lates($data['employeeid'], date_format(date_create($salaryDate), "Y"), date_format(date_create($salaryDate), "m"));
                    $empLateslogout = $usersModel->get_employee_lateslogout($data['employeeid'], date_format(date_create($salaryDate), "Y"), date_format(date_create($salaryDate), "m"));
                    $empLates = $empLateslogin + $empLateslogout;
                    $helperModel = new HelperModel();
                    $numberOfLatesForADayOfAbsence = $helperModel->get_settings('numberOfLatesForADayOfAbsence');

                    if (!empty($salary_package)) {
                        $package = $data['ctc'] = $salary_package[0]->package;
                        if ($package != 0) {

                            $monthly = $data['monthly'] = round($package / 12);

                            $basic = $data['basic'] = round(($monthly * $salary_grade->basic) / 100);

                            $houserentalallowance = $data['houserentalallowance'] = round(($basic * $salary_grade->houserentalallowance) / 100);

                            $specialallowance = $data['specialallowance'] = $monthly - $basic - $houserentalallowance;

                            $gross = $data['gross'] = $basic + $houserentalallowance + $specialallowance;

                            $emis = $payrollModel->get_employee_emis($employee->userid, $data['salarydate']);

                            $emi_deductions = 0;
                            foreach ($emis as $emi) {
                                $emi_deductions = $emi_deductions + $emi->amount;
                            }
                            $data['emi_deduction'] = $emi_deductions;

                            $pt = 0;
                            $tds = 0;
                            if ($salary_package[0]->is_tds == 1) {
                                $emi_tax =  ($emi_deductions * $salary_grade->tds) / 100;
                                $tds = $data['tds'] = (($gross * $salary_grade->tds) / 100) + $emi_tax;
                            } else {
                                $pt = $data['pt'] = $salary_grade->pt;
                            }

                            $net = $data['net'] = $gross - $pt - $tds;
                            $TotalWorkingDays = $data['totalbusinessdays'] = $data['paiddays'] = $workingdays;

                            $TotalDaysAttended = $empWorkingDays[0]->TotalDaysAttended;

                            $daily = $data['daily'] = $net / $TotalWorkingDays;
                            $totalLeaves = $TotalWorkingDays - $TotalDaysAttended;

                            $comment = "";
                            $penalty = 0;
                            $paiddays = $data['paiddays'];
                            $unpaiddays = 0;
                            $net = $data['net'];

                            if ($totalLeaves > $employee->leavespermonth) {
                                $unpaiddays = $totalLeaves - $employee->leavespermonth;
                                $paiddays = $paiddays - $unpaiddays;
                                $penalty = $daily * $unpaiddays;
                                $comment = $comment . "{$unpaiddays} Days Penalty for leaves, ";
                            }

                            if ($empLates > $numberOfLatesForADayOfAbsence) {
                                $totalAbsentByLates = floor($empLates / $numberOfLatesForADayOfAbsence);

                                $unpaiddays = $unpaiddays + $totalAbsentByLates;
                                $paiddays = $paiddays - $totalAbsentByLates;
                                $penalty = $daily * $unpaiddays;
                                $comment = $comment . "{$totalAbsentByLates} Days Penalty for coming late, ";
                            }

                            $data['unpaiddays'] = $unpaiddays;
                            $data['paiddays'] = $paiddays;
                            $data['penalty'] = $penalty;
                            $data['net'] = $net - $emi_deductions - $penalty;
                            $getInsertID =  $payrollModel->insert_salary_payment($data, 1);
                            foreach ($emis as $emi) {
                                $payrollModel->update_employee_emis($emi->id, $getInsertID);
                            }
                        }
                    }
                } else {

                    $salary_grade = $payrollModel->get_salary_grades()[0];


                    $data['salarydate'] = date_format(date_create($salaryDate), "Y-m-d");
                    $data['employeeid'] = $employee->userid;

                    $employee_weekoff = $payrollModel->get_employee_week_off($employee->userid);
                     
                    $empHolidays = $usersModel->get_employee_holidays($data['employeeid'], date_format(date_create($salaryDate), "Y"), date_format(date_create($salaryDate), "m"));
                    $month = date_format(date_create($salaryDate), "m");
                    $year = date_format(date_create($salaryDate), "Y");
                    $dt = $salaryDate;
                    $fromdt = date("Y-m-01", strtotime($dt));
                    $todt =  date("Y-m-t", strtotime($dt));
                    $monthName = date("F", mktime(0, 0, 0, $month));
                    $begin  = new \DateTime($fromdt);
                    $end    = new \DateTime($todt);
                    $array = [];
                    $sunday = [];
                    $i = 0;
                    while ($begin <= $end) // Loop will work begin to the end date 
                    {
                        $array[$begin->format("Y-m-d")] = 0;
                        if ($i != 0) {
                            $begin->modify('+1 day');
                        }
                        foreach ($employee_weekoff as $week) {
                            if ($week->sunday == 1) {
                                if ($begin->format("D") == "Sun") //Check that the day is Sunday here
                                {
                                    $sunday[$begin->format("Y-m-d")] = 1;
                                }
                            }
                            if ($week->monday == 1) {
                                if ($begin->format("D") == "Mon") //Check that the day is Sunday here
                                {
                                    $sunday[$begin->format("Y-m-d")] = 1;
                                }
                            }
                            if ($week->tuesday == 1) {
                                if ($begin->format("D") == "Tue") //Check that the day is Sunday here
                                {
                                    $sunday[$begin->format("Y-m-d")] = 1;
                                }
                            }
                            if ($week->wednesday == 1) {
                                if ($begin->format("D") == "Wed") //Check that the day is Sunday here
                                {

                                    $sunday[$begin->format("Y-m-d")] = 1;
                                }
                            }
                            if ($week->thursday == 1) {
                                if ($begin->format("D") == "Thu") //Check that the day is Sunday here
                                {
                                    $sunday[$begin->format("Y-m-d")] = 1;
                                }
                            }
                            if ($week->friday == 1) {
                                if ($begin->format("D") == "Fri") //Check that the day is Sunday here
                                {
                                    $sunday[$begin->format("Y-m-d")] = 1;
                                }
                            }
                            if ($week->saturday == 1) {
                                if ($begin->format("D") == "Sat") //Check that the day is Sunday here
                                {
                                    //echo $begin->format("Y-m-d");

                                    $sunday[$begin->format("Y-m-d")] = 1;
                                }
                            }
                        }
                        $i++;
                    }
                   
                    $workingdays = 0;
                    foreach ($array as $key => $a) {
                        foreach ($sunday as $key1 => $a1) {
                            if ($key == $key1) {
                                $array[$key] = 1;
                            }
                        }
                        foreach ($empHolidays as $a2) {
                            $holiday = $a2->date;
                            if ($key == $holiday) {
                                $array[$key] = 1;
                            }
                        }
                        if ($array[$key] == 0) {
                            $workingdays++;
                        }
                    }
                    
                    $empWorkingDays = $usersModel->get_employee_workingdays($data['employeeid'], date_format(date_create($salaryDate), "Y"), date_format(date_create($salaryDate), "m"));
                    $empLateslogin = $usersModel->get_employee_lates($data['employeeid'], date_format(date_create($salaryDate), "Y"), date_format(date_create($salaryDate), "m"));
                    $empLateslogout = $usersModel->get_employee_lateslogout($data['employeeid'], date_format(date_create($salaryDate), "Y"), date_format(date_create($salaryDate), "m"));
                    $empLates = $empLateslogin + $empLateslogout;
                    $helperModel = new HelperModel();
                    $numberOfLatesForADayOfAbsence = $helperModel->get_settings('numberOfLatesForADayOfAbsence');

                    if (!empty($salary_package)) {
                        $package = $data['ctc'] = $salary_package[0]->package;
                        if ($package != 0) {

                            $monthly = $data['monthly'] = round($package / 12);

                            $basic = $data['basic'] = round(($monthly * $salary_grade->basic) / 100);
                            $houserentalallowance = $data['houserentalallowance'] = round(($basic * $salary_grade->houserentalallowance) / 100);

                            $specialallowance = $data['specialallowance'] = $monthly - $basic - $houserentalallowance;
                            $gross = $data['gross'] = $basic + $houserentalallowance + $specialallowance;
                            $emis = $payrollModel->get_employee_emis($employee->userid, $data['salarydate']);

                            $emi_deductions = 0;
                            foreach ($emis as $emi) {
                                $emi_deductions = $emi_deductions + $emi->amount;
                            }
                            $data['emi_deduction'] = $emi_deductions;

                            $pt = 0;
                            $tds = 0;
                            if ($salary_package[0]->is_tds == 1) {
                                $emi_tax =  ($emi_deductions * $salary_grade->tds) / 100;
                                $tds = $data['tds'] = (($gross * $salary_grade->tds) / 100) + $emi_tax;
                                 $pt = $data['pt'] = 0;
                            } else {
                                $tds = $data['tds'] = 0 ;
                                $pt_structure = json_decode($salary_grade->pt);
                                foreach ($pt_structure as $each) {
                                    if ($gross >= $each->min && $gross <= $each->max) {
                                        $pt = $data['pt'] = $each->value;
                                    }
                                }
                            }

                            $net = $gross;

                            $TotalWorkingDays = $data['totalbusinessdays'] = $data['paiddays'] = $workingdays;
                           
                            $TotalDaysAttended = $empWorkingDays[0]->TotalDaysAttended;


                            $daily = $data['daily'] = $net / $TotalWorkingDays;
                            $net = $data['net'] = $gross - $pt - $tds;
                            $totalLeaves = $TotalWorkingDays - $TotalDaysAttended;

                            $comment = "";
                            $penalty = 0;
                            $paiddays = $data['paiddays'];
                            $unpaiddays = 0;
                            $net = $data['net'];
                            if ($totalLeaves > $employee->leavespermonth) {
                                $unpaiddays = $totalLeaves - $employee->leavespermonth;
                               
                                $paiddays = $paiddays - $unpaiddays;
                                $penalty = $daily * $unpaiddays;
                                $comment = $comment . "{$unpaiddays} Days Penalty for leaves, ";
                            }
                            if ($empLates > $numberOfLatesForADayOfAbsence) {
                                $totalAbsentByLates = floor($empLates / $numberOfLatesForADayOfAbsence);
                                $unpaiddays = $unpaiddays + $totalAbsentByLates;
                                $paiddays = $paiddays - $totalAbsentByLates;
                                $penalty = $daily * $unpaiddays;
                                $comment = $comment . "{$totalAbsentByLates} Days Penalty for coming late, ";
                            }

                            $data['unpaiddays'] = $unpaiddays;
                            $data['paiddays'] = $paiddays;
                            $data['penalty'] = $penalty;
                            $data['net'] = $net - $emi_deductions - $penalty;

                            $getInsertID =  $payrollModel->insert_salary_payment($data, 1);
                            foreach ($emis as $emi) {
                                $payrollModel->update_employee_emis($emi->id, $getInsertID);
                            }
                        }
                    }
                }
            }
        }

       return redirect()->to(base_url("payroll/salary_payment?date={$_POST['salarydate']}"));
    }

    public function edit_payslip($salaryPaymentId)
    {
        $data['page_name'] = 'Payroll/edit_payslip';
        $data['salaryPaymentId'] = $salaryPaymentId;

        $payrollModel = new PayrollModel();
        $data['payment_data'] = $payrollModel->get_payslip_by_payslipid($salaryPaymentId);

        return view('loggedinuser/index.php', $data);
    }

    public function update_payslip($salaryPaymentId)
    {
        $data['salaryPaymentId'] = $salaryPaymentId;

        $data['transportallowance'] = $_POST['transportallowance'];
        $data['basic_arrears'] = $_POST['basic_arrears'];
        $data['other_arrears'] = $_POST['other_arrears'];
        $data['bonus'] = $_POST['bonus'];

        $data['gross'] = $_POST['gross'];

        $data['penalty'] = $_POST['penalty'];
        $data['other_decuctions'] = $_POST['other_decuctions'];

        $data['net'] = $_POST['net'];
        $data['comments'] = $_POST['comments'];
        $data['arrearscomments'] = $_POST['arrearscomments'];
        $data['deductioncomments'] = $_POST['deductioncomments'];

        $data['updated_by'] = $_SESSION['userdetails']->userid;
        $data['updated_at'] = date("Y-m-d h:m:i");

        $payrollModel = new PayrollModel();
        $payrollModel->update_payslip($data);

        return redirect()->to(base_url('payroll/edit_payslip') . "/" . $salaryPaymentId);
    }

    public function print_payslip($salaryPaymentId)
    {
        $data['salaryPaymentId'] = $salaryPaymentId;

        $payrollModel = new PayrollModel();
        $data['payment_data'] = $payrollModel->get_payslip_by_payslipid($salaryPaymentId);

        return view('loggedinuser/Print/print_payslip.php', $data);
    }
}
