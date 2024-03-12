<?php

namespace App\Models;

use CodeIgniter\Model;

class AssetAuditModel extends Model
{
    public function get_asset_audits()
    {
        $db = db_connect();
        $query = $db->query('SELECT asset_audits.*, branchlookup.branchname FROM asset_audits JOIN branchlookup ON asset_audits.branch_id = branchlookup.branchid;');        
        return $query->getResult();
    }

    public function add_asset_audit_item($data)
    {
        $db = db_connect();
        $builder = $db->table('asset_audit_items');
        $builder->insert($data);
        $db->close();
    }

    public function add_asset_audit($data)
    {
        $db = db_connect();
        $builder = $db->table('asset_audits');
        $result = $builder->insert($data);
        $insertId = $db->insertID();
        $db->close();
        return $insertId;
    }

    public function update_asset_audit_item($id)
    {
        $db = db_connect();
        $query = $db->query("UPDATE asset_audit_items SET status = 'scanned' WHERE allocated_asset_id = $id AND DATE(created_at) = CURDATE();");        
    }

    public function delete_asset_audit($id)
    {
        $db = db_connect();
        $builder = $db->table('asset_audits');
        $builder->where('id', $id);
        $builder->delete();
        $db->close();
    }

    public function get_asset_audit_items($id)
    {
        $db = db_connect();
        $query = $db->query('SELECT asset_audits.*, branchlookup.branchname FROM asset_audits JOIN branchlookup ON asset_audits.branch_id = branchlookup.branchid;');        
        return $query->getResult();
    }
    

}
