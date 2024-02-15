<?php

namespace App\Models;

use CodeIgniter\Model;

class PayrollModel extends Model
{
    public function get_salary_grades()
    {
        $db = db_connect();
        $query = $db->query("SELECT * FROM salarygrades");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function insert_salary_payment($data, $regenerate = 1)
    {
        if ($regenerate == 1) {
            $db = db_connect();
            $builder = $db->table('salarypayment');
            $builder->where('employeeid', $data['employeeid']);
            $builder->where('salarydate', $data['salarydate']);
            $builder->delete();
            $db->close();
        }

        $db = db_connect();
        $builder = $db->table('salarypayment');
        $builder->insert($data);

        $db->close();
    }

    public function get_salaries($date)
    {
        $db = db_connect();
        $query = $db->query("SELECT * FROM employeedetails 
                             JOIN salarypayment ON salarypayment.employeeid = employeedetails.userid
                             JOIN users ON users.userid = employeedetails.userid
                             JOIN roleslookup ON roleslookup.roleid = users.roleid WHERE salarydate = '{$date}'");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function get_salaries_by_empid($empId)
    {
        $db = db_connect();
        $query = $db->query("SELECT * FROM employeedetails 
                             JOIN salarypayment ON salarypayment.employeeid = employeedetails.userid
                             JOIN users ON users.userid = employeedetails.userid
                             JOIN roleslookup ON roleslookup.roleid = users.roleid WHERE employeedetails.userid = '{$empId}'");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function get_payslip_by_payslipid($payslipId)
    {
        $db = db_connect();
        $query = $db->query("SELECT * FROM salarypayment JOIN
                             employeedetails on salarypayment.employeeid = employeedetails.userid 
                             WHERE salarypayment.salarypaymentid = '{$payslipId}'");
        $result = $query->getRow();
        $db->close();

        return $result;
    }

    public function update_payslip($data)
    {
        $db = db_connect();
        $builder = $db->table('salarypayment');
        $builder->where('salarypaymentid', $data['salaryPaymentId']);
        $builder->update($data);
        $db->close();
    }
    public function get_employee_salary_package($userid)
    {
        $db = db_connect();
        $query = $db->query("SELECT * FROM employee_package where employeeid={$userid} and status=1");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function get_employee_salary_grades($userid)
    {
        $db = db_connect();
        $query = $db->query("SELECT * FROM employeesalarygrades where employeeid={$userid} and is_active=1");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function get_employee_week_off($empid)
    {
        $db = db_connect();
        $query = $db->query("SELECT sunday,monday,tuesday,wednesday,thursday,friday,saturday FROM employeedetails 
                              WHERE employeedetails.userid = '{$empid}'");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function get_employee_emis($userid,$date)
    {
        $db = db_connect();
        $query = $db->query("SELECT * FROM emis WHERE date = '{$date}' and employeeid={$userid}");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function update_employee_emis($id,$salarypaymentid)
    {
        $db = db_connect();
        $data['salarypaymentid'] = $salarypaymentid;
        $builder = $db->table('emis');
        $builder->where('id', $id);
        $builder->update($data);
        $db->close();
    }
    // public function add_salary_grades($data)
    // {
    //     $db = db_connect();
    //     $builder = $db->table('salarygrades');
    //     $builder->insert($data);
    //     $db->close();
    // }

    // public function update_salary_grades($data)
    // {
    //     $db = db_connect();
    //     $builder = $db->table('salarygrades');
    //     $builder->where('salarygradeid', $data['salarygradeid']);
    //     $builder->update($data);
    //     $db->close();
    // }

    // public function delete_salary_grades($data)
    // {
    //     $db = db_connect();
    //     $builder = $db->table('salarygrades');
    //     $builder->where('salarygradeid', $data['salarygradeid']);
    //     $builder->delete();
    //     $db->close();
    // }

}
