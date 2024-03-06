<?php

namespace App\Models;

use CodeIgniter\Model;

class AssetAllocationHistory extends Model
{
    public function get_asset_allocation_history()
    {
        $db = db_connect();
        $builder = $db->table('asset_allocation_history');
        $query = $builder->get();
        return $query->getResult();
    }

    public function add_asset_allocation_history($data)
    {
        $db = db_connect();
        $builder = $db->table('asset_allocation_history');
        $result = $builder->insert($data);
        $insertId = $db->insertID();
        $db->close();
        return $insertId;
    }
}
