<?php

namespace App\Models;

use CodeIgniter\Model;

class FloorModel extends Model
{

    public function get_all_floors()
    {
        $db = db_connect();
        $builder = $db->table('floors');
        $query = $builder->get();
        return $query->getResult();
    }
    
    public function get_floors()
    {
        $db = db_connect();
        // $query = $db->query('SELECT * FROM floors JOIN branchlookup ON floors.branch_id = branchlookup.branchid;');
        $query = $db->query('SELECT floors.*, branchlookup.branchname,  buildings.name AS building_name FROM floors JOIN branchlookup ON floors.branch_id = branchlookup.branchid JOIN buildings ON floors.building_id = buildings.id;');        
        return $query->getResult();
    }

    public function add_floor($data)
    {
        $db = db_connect();
        $builder = $db->table('floors');
        $builder->insert($data);

        $db->close();
    }

    public function update_floor($floor_id, $data)
    {
        $db = db_connect();
        $builder = $db->table('floors');
        $builder->where('id', $floor_id);
        $builder->update($data);
        $db->close();
    }

    public function delete_floor($id)
    {
        $db = db_connect();
        $builder = $db->table('floors');
        $builder->where('id', $id);
        $builder->delete();
        $db->close();
    }
    

}
