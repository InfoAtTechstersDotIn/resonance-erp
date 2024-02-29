<?php

namespace App\Models;

use CodeIgniter\Model;

class AreaModel extends Model
{
    public function get_areas()
    {
        $db = db_connect();
        $builder = $db->table('areas');
        $query = $builder->get();
        return $query->getResult();
    }

    public function add_area($data)
    {
        $db = db_connect();
        $builder = $db->table('areas');
        $builder->insert($data);

        $db->close();
    }

    public function update_area($area_id, $data)
    {
        $db = db_connect();
        $builder = $db->table('areas');
        $builder->where('id', $area_id);
        $builder->update($data);
        $db->close();
    }

    public function delete_area($id)
    {
        $db = db_connect();
        $builder = $db->table('areas');
        $builder->where('id', $id);
        $builder->delete();
        $db->close();
    }
    

}
