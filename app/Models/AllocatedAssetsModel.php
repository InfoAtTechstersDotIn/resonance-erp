<?php

namespace App\Models;

use CodeIgniter\Model;

class AllocatedAssetsModel extends Model
{
    public function get_allocated_assets()
    {
        $db = db_connect();
        $builder = $db->table('allocated_assets');
        $query = $builder->get();
        return $query->getResult();
    }

    public function add_allocated_assets($data)
    {
        $db = db_connect();
        $builder = $db->table('allocated_assets');
        $result = $builder->insert($data);
        $insertId = $db->insertID();
        $db->close();
        return $insertId;
    }

    public function update_allocated_assets($allocated_asset_id, $data)
    {
        $db = db_connect();
        $builder = $db->table('allocated_assets');
        $builder->where('id', $allocated_asset_id);
        $builder->update($data);
        $db->close();
    }

    public function delete_allocated_assets($id)
    {
        $db = db_connect();
        $builder = $db->table('allocated_assets');
        $builder->where('id', $id);
        $builder->delete();
        $db->close();
    }
    

}
