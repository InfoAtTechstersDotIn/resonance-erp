<?php

namespace App\Models;

use CodeIgniter\Model;

class PurchaseInvoiceItemModel extends Model
{
    public function add_purchase_invoice_item($data)
    {
        $db = db_connect();
        $builder = $db->table('purchase_invoice_items');
        $result = $builder->insert($data);
        $db->close();
        return $result;
    }

    public function update_purchase_invoice($purchase_invoice_item_id, $data)
    {
        $db = db_connect();
        $builder = $db->table('purchase_invoice_items');
        $builder->where('id', $purchase_invoice_item_id);
        $builder->update($data);
        $db->close();
    }

    public function delete_purchase_invoice($id)
    {
        $db = db_connect();
        $builder = $db->table('purchase_invoice_items');
        $builder->where('id', $id);
        $builder->delete();
        $db->close();
    }

}