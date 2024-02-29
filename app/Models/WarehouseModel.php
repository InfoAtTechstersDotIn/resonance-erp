<?php

namespace App\Models;

use CodeIgniter\Model;

class WarehouseModel extends Model
{
    public function get_warehouses()
    {
        $db = db_connect();
        $builder = $db->table('warehouses');
        $query = $builder->get();
        return $query->getResult();
    }

    public function add_warehouse($data)
    {
        $db = db_connect();
        $builder = $db->table('warehouses');
        $builder->insert($data);

        $db->close();
    }

    public function update_warehouse($area_id, $data)
    {
        $db = db_connect();
        $builder = $db->table('warehouses');
        $builder->where('id', $area_id);
        $builder->update($data);
        $db->close();
    }

    public function delete_warehouse($id)
    {
        $db = db_connect();
        $builder = $db->table('warehouses');
        $builder->where('id', $id);
        $builder->delete();
        $db->close();
    }
    

}
