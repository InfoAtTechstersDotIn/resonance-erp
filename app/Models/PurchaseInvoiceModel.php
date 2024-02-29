<?php

namespace App\Models;

use CodeIgniter\Model;

class PurchaseInvoiceModel extends Model
{
    public function get_purchase_invoices()
    {
        $db = db_connect();
        // $query = $db->query('SELECT * FROM floors JOIN branchlookup ON floors.branch_id = branchlookup.branchid;');
        $query = $db->query('SELECT purchase_invoices.*, warehouses.name AS warehouse_name, vendor.name AS vendor_name FROM purchase_invoices JOIN warehouses ON purchase_invoices.warehouse_id = warehouses.id JOIN vendor ON purchase_invoices.vendor_id = vendor.id;');        
        return $query->getResult();
    }
    
    public function add_purchase_invoice($data)
    {
        $db = db_connect();
        $builder = $db->table('purchase_invoices');
        $result = $builder->insert($data);
        $insertId = $db->insertID();
        $db->close();
        return $insertId;
    }

    public function update_purchase_invoice($purchase_invoice_id, $data)
    {
        $db = db_connect();
        $builder = $db->table('purchase_invoices');
        $builder->where('id', $purchase_invoice_id);
        $builder->update($data);
        $db->close();
    }

    public function delete_purchase_invoice($id)
    {
        $db = db_connect();
        $builder = $db->table('purchase_invoices');
        $builder->where('id', $id);
        $builder->delete();
        $db->close();
    }

}
