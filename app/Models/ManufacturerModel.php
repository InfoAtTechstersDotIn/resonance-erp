<?php

namespace App\Models;

use CodeIgniter\Model;

class ManufacturerModel extends Model
{
    
    public function getManufacturers()
    {
        $db = db_connect();
        $builder = $db->table('manufacturers');
        $query = $builder->get();
        return $query->getResult();
    }

    public function addmanufacturer($data)
    {
        $db = db_connect();
        $builder = $db->table('manufacturers');
        $builder->insert($data);

        $db->close();
    }

    public function update_manufacturer($manufacturerid, $data)
    {
        $db = db_connect();
        $builder = $db->table('manufacturers');
        $builder->where('id', $manufacturerid);
        $builder->update($data);
        $db->close();
    }

    public function deletemanufacturer($id)
    {
        $db = db_connect();
        $builder = $db->table('manufacturers');
        $builder->where('id', $id);
        $builder->delete();
        $db->close();
    }
    

}
