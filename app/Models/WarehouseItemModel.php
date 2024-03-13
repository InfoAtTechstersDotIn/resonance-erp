<?php

namespace App\Models;

use CodeIgniter\Model;

class WarehouseItemModel extends Model
{

    public function get_warehouse_items()
    {
        $db = db_connect();
        $builder = $db->table('warehouse_items');
        $query = $builder->get();
        return $query->getResult();
    }

    public function add_warehouse_item($data)
    {
        $db = db_connect();
        $builder = $db->table('warehouse_items');
        $builder->insert($data);
        $db->close();
    }

    public function update_warehouse_item($product_id, $warehouse_id, $data)
    {
        $db = db_connect();
        $builder = $db->table('warehouse_items');
        $builder->where('product_id', $product_id)->where('warehouse_id', $warehouse_id);
        $builder->update($data);
        $db->close();
    }

    public function update_warehouse_single_item($warehouse_item_id, $data)
    {
        $db = db_connect();
        $builder = $db->table('warehouse_items');
        $builder->where('id', $warehouse_item_id);
        $builder->update($data);
        $db->close();
    }

}
