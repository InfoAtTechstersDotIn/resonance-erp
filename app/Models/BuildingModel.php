<?php

namespace App\Models;

use CodeIgniter\Model;

class BuildingModel extends Model
{

    public function get_all_buildings()
    {
        $db = db_connect();
        $builder = $db->table('buildings');
        $query = $builder->get();
        return $query->getResult();
    }
    
    public function get_buildings()
    {
        $db = db_connect();
        $query = $db->query('SELECT * FROM buildings JOIN branchlookup ON buildings.branch_id = branchlookup.branchid;');
        return $query->getResult();
    }

    public function add_building($data)
    {
        $db = db_connect();
        $builder = $db->table('buildings');
        $builder->insert($data);

        $db->close();
    }

    public function update_building($building_id, $data)
    {
        $db = db_connect();
        $builder = $db->table('buildings');
        $builder->where('id', $building_id);
        $builder->update($data);
        $db->close();
    }

    public function delete_building($id)
    {
        $db = db_connect();
        $builder = $db->table('buildings');
        $builder->where('id', $id);
        $builder->delete();
        $db->close();
    }
    

}
