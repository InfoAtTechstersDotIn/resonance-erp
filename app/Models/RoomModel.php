<?php

namespace App\Models;

use CodeIgniter\Model;

class RoomModel extends Model
{
    
    public function get_rooms()
    {
        $db = db_connect();
        $query = $db->query('SELECT rooms.*, branchlookup.branchname,  buildings.name AS building_name, floors.name AS floor_name FROM rooms JOIN branchlookup ON rooms.branch_id = branchlookup.branchid JOIN buildings ON rooms.building_id = buildings.id JOIN floors ON rooms.floor_id = floors.id;');        
        return $query->getResult();
    }

    public function add_room($data)
    {
        $db = db_connect();
        $builder = $db->table('rooms');
        $builder->insert($data);

        $db->close();
    }

    public function update_room($room_id, $data)
    {
        $db = db_connect();
        $builder = $db->table('rooms');
        $builder->where('id', $room_id);
        $builder->update($data);
        $db->close();
    }

    public function delete_room($id)
    {
        $db = db_connect();
        $builder = $db->table('rooms');
        $builder->where('id', $id);
        $builder->delete();
        $db->close();
    }
    

}
