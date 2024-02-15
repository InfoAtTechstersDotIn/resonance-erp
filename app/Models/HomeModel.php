<?php

namespace App\Models;

use CodeIgniter\Model;

class HomeModel extends Model
{
    public function validate_login($username, $password)
    {
        $db = db_connect();
        $query = $db->query("SELECT * FROM users 
            JOIN roleslookup on users.roleid = roleslookup.roleid 
            JOIN employeedetails on employeedetails.userid = users.userid 
            WHERE (username='{$username}' OR employeeid='{$username}') and password='{$password}' and active=1");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    
    public function validate_login_mobile($userid)
    {
        $db = db_connect();
        $query = $db->query("SELECT * FROM users 
            JOIN roleslookup on users.roleid = roleslookup.roleid 
            JOIN employeedetails on employeedetails.userid = users.userid 
            WHERE employeedetails.userid='{$userid}' and active=1");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function updatepassword($password, $userid)
    {
        $db = db_connect();

        $data['password'] = $password;

        $builder = $db->table('users');
        $builder->where('userid', $userid);
        $builder->update($data);
    }
    public function updateattendance($data)
    {
        $db = db_connect();
        
        $d["data"] = $data;
        $builder = $db->table('attendance_data');
        $builder->insert($d);
        $roleid = $db->insertID();
        $query = $db->query("SELECT data FROM attendance_data WHERE id='$roleid'");
        $results = $query->getResult();
        $db->close();
        return $results;
    }
}
