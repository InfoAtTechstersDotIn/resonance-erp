<?php

namespace App\Models;

use CodeIgniter\Model;

class FormsModel extends Model
{
    public function getFormRequests($form)
    {
        
        $db = db_connect();
        $query = $db->query("SELECT Fr.*, Sd.*, Cr.name AS CreatedBy, Up.Name as UpdatedBy FROM form_requests Fr
                            JOIN studentdetails Sd on Fr.user_id = Sd.userid
                            JOIN employeedetails Cr on Fr.created_by = Cr.userid
                            LEFT JOIN employeedetails Up on Fr.updated_by = Up.userid
                            WHERE Sd.studentstatus=1 and Fr.status IN ('created') and Fr.form_type='$form' order by form_request_id desc");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    
    public function getBranchFormRequests()
    {
       
        $db = db_connect();
        $branchid = $_SESSION['userdetails']->branchid;
        $query = $db->query("SELECT Fr.*, Sd.*, Cr.name AS CreatedBy, Up.Name as UpdatedBy FROM form_requests Fr
                            JOIN studentdetails Sd on Fr.user_id = Sd.userid
                            JOIN employeedetails Cr on Fr.created_by = Cr.userid
                            LEFT JOIN student_class_relation Scr on Sd.userid = Scr.studentid
                            LEFT JOIN branchlookup ON Scr.branchid = branchlookup.branchid
                            LEFT JOIN employeedetails Up on Fr.updated_by = Up.userid
                            WHERE Sd.studentstatus=1 and Fr.status IN ('created') and Fr.form_type='branchtransfer' and Scr.branchid IN ({$branchid})");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function getoutpassFormRequests()
    {
        $db = db_connect();
        $query = $db->query("SELECT Fr.*, Sd.*, Cr.name AS CreatedBy, Up.Name as UpdatedBy,sectionlookup.sectionname,branchlookup.branchname FROM form_requests Fr
                            JOIN studentdetails Sd on Fr.user_id = Sd.userid
                            LEFT JOIN student_class_relation Scr on Sd.userid = Scr.studentid and Fr.batchid=Scr.batchid
                            LEFT JOIN branchlookup ON Scr.branchid = branchlookup.branchid
                             LEFT JOIN courselookup ON Scr.courseid = courselookup.courseid
                             LEFT JOIN sectionlookup ON Scr.sectionid = sectionlookup.sectionid
                            LEFT JOIN employeedetails Cr on Fr.created_by = Cr.userid
                            LEFT JOIN employeedetails Up on Fr.updated_by = Up.userid
                            WHERE Fr.form_type='StudentOutPass' and Sd.studentstatus=1");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function getMaterialFormRequests()
    {
        $db = db_connect();
        $query = $db->query("SELECT Fr.*, Cr.name AS CreatedBy, Up.Name as UpdatedBy FROM material_requisition Fr
                            JOIN employeedetails Cr on Fr.created_by = Cr.userid
                            LEFT JOIN employeedetails Up on Fr.updated_by = Up.userid
                            ");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    
    public function getMaterialFormRequest($formgroupid)
    {
        $db = db_connect();
        $query = $db->query("SELECT Fr.*,Cr.name as productname FROM material_requisition_items Fr
                            JOIN product Cr on Fr.product_id = Cr.id
                            WHERE Fr.material_requisition_id='{$formgroupid}'");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function getPoFormRequests()
    {
        $db = db_connect();
        $query = $db->query("SELECT Fr.*, Cr.name AS CreatedBy, Up.Name as UpdatedBy FROM purchase_order Fr
                            JOIN employeedetails Cr on Fr.created_by = Cr.userid
                            LEFT JOIN employeedetails Up on Fr.updated_by = Up.userid
                            ");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    
    public function getPoFormRequest($formgroupid)
    {
        $db = db_connect();
        $query = $db->query("SELECT Fr.*,Cr.name as productname FROM purchase_order_items Fr
                            JOIN product Cr on Fr.product_id = Cr.id
                            WHERE Fr.purchase_order_id='{$formgroupid}'");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    
    public function getMaterialUserFormRequest($formgroupid)
    {
        $db = db_connect();
        $query = $db->query("SELECT Fr.*, Cr.name AS CreatedBy, Up.Name as UpdatedBy FROM form_requests Fr
                            JOIN employeedetails Cr on Fr.created_by = Cr.userid
                            LEFT JOIN employeedetails Up on Fr.updated_by = Up.userid
                            WHERE Fr.form_type='materialrequisition' and Fr.form_group_id='{$formgroupid}'");
        $results = $query->getResult();
        $db->close();

        return $results;
    }


    public function getPendingForms($userid)
    {
        $db = db_connect();
        $query = $db->query("SELECT Fr.*, Sd.*, Cr.name AS CreatedBy, Up.Name as UpdatedBy FROM form_requests Fr
                            JOIN studentdetails Sd on Fr.user_id = Sd.userid
                            left JOIN employeedetails Cr on Fr.created_by = Cr.userid
                            LEFT JOIN employeedetails Up on Fr.updated_by = Up.userid
                            WHERE Fr.user_id = $userid");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function getbulkoutForms($userid)
    {
        $db = db_connect();
        $query = $db->query("SELECT Fr.*, Sd.*,sectionlookup.*,branchlookup.*, Cr.name AS CreatedBy, Up.Name as UpdatedBy FROM form_requests Fr
                            JOIN studentdetails Sd on Fr.user_id = Sd.userid
                            JOIN employeedetails Cr on Fr.created_by = Cr.userid
                            LEFT JOIN employeedetails Up on Fr.updated_by = Up.userid 
                            LEFT JOIN student_class_relation Scr on Sd.userid = Scr.studentid and Fr.batchid=Scr.batchid
                            LEFT JOIN branchlookup ON Scr.branchid = branchlookup.branchid
                            LEFT JOIN courselookup ON Scr.courseid = courselookup.courseid
                            LEFT JOIN sectionlookup ON Scr.sectionid = sectionlookup.sectionid
                            WHERE Fr.form_type='StudentOutPass' and Fr.form_group_id !='' and Sd.studentstatus=1 group by Fr.form_group_id");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function getoutForms($userid)
    {
        $db = db_connect();
        $query = $db->query("SELECT Fr.*, Sd.*,sectionlookup.*,branchlookup.*, Cr.name AS CreatedBy, Up.Name as UpdatedBy FROM form_requests Fr
                            JOIN studentdetails Sd on Fr.user_id = Sd.userid
                            JOIN employeedetails Cr on Fr.created_by = Cr.userid
                            LEFT JOIN employeedetails Up on Fr.updated_by = Up.userid
                            LEFT JOIN student_class_relation Scr on Sd.userid = Scr.studentid
                            LEFT JOIN branchlookup ON Scr.branchid = branchlookup.branchid
                             LEFT JOIN courselookup ON Scr.courseid = courselookup.courseid
                             LEFT JOIN sectionlookup ON Scr.sectionid = sectionlookup.sectionid
                            WHERE Fr.form_type='StudentOutPass' and Sd.studentstatus=1");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function getPendingMaterialForms($userid)
    {
        $db = db_connect();
        $query = $db->query("SELECT Fr.*, Cr.name AS CreatedBy, Up.Name as UpdatedBy FROM material_requisition Fr
                            JOIN employeedetails Cr on Fr.created_by = Cr.userid
                            LEFT JOIN employeedetails Up on Fr.updated_by = Up.userid
                            ");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function getPendingMaterialForm($formgroupid)
    {
        $db = db_connect();
        $query = $db->query("SELECT Fr.*,p.name,mri.*, Cr.name AS CreatedBy, Up.Name as UpdatedBy FROM material_requisition Fr
        JOIN material_requisition_items mri on Fr.id = mri.material_requisition_id
        JOIN product p on mri.product_id = p.id
        JOIN employeedetails Cr on Fr.created_by = Cr.userid
        LEFT JOIN employeedetails Up on Fr.updated_by = Up.userid
                            WHERE Fr.id='{$formgroupid}'");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function getPendingPoForms($userid)
    {
        $db = db_connect();
        $query = $db->query("SELECT Fr.*, Cr.name AS CreatedBy, Up.Name as UpdatedBy FROM purchase_order Fr
                            JOIN employeedetails Cr on Fr.created_by = Cr.userid
                            LEFT JOIN employeedetails Up on Fr.updated_by = Up.userid
                            ");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function getPendingPoForm($formgroupid)
    {
        $db = db_connect();
        $query = $db->query("SELECT Fr.*,p.name,mri.*, Cr.name AS CreatedBy, Up.Name as UpdatedBy FROM purchase_order Fr
        JOIN purchase_order_items mri on Fr.id = mri.purchase_order_id
        JOIN product p on mri.product_id = p.id
        JOIN employeedetails Cr on Fr.created_by = Cr.userid
        LEFT JOIN employeedetails Up on Fr.updated_by = Up.userid
                            WHERE Fr.id='{$formgroupid}'");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function getPendingOutpassForm($formgroupid)
    {
        $db = db_connect();
        $query = $db->query("SELECT Fr.*,Sd.*, Cr.name AS CreatedBy, Up.Name as UpdatedBy,branchlookup.branchname,sectionlookup.sectionname FROM form_requests Fr
                            JOIN employeedetails Cr on Fr.created_by = Cr.userid
                            JOIN studentdetails Sd on Fr.user_id = Sd.userid
                            JOIN student_class_relation Scr on Sd.userid = Scr.studentid and Fr.batchid=Scr.batchid
                            LEFT JOIN employeedetails Up on Fr.updated_by = Up.userid
                            LEFT JOIN branchlookup ON Scr.branchid = branchlookup.branchid
                             LEFT JOIN courselookup ON Scr.courseid = courselookup.courseid
                             LEFT JOIN sectionlookup ON Scr.sectionid = sectionlookup.sectionid
                            WHERE Fr.form_type='StudentOutPass' and Fr.form_group_id='{$formgroupid}' and Sd.studentstatus=1");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function get_TotalPendingMaterialRequisitionRequests()
    {
        $db = db_connect();
        $query = $db->query("SELECT Fr.*, Cr.name AS CreatedBy, Up.Name as UpdatedBy FROM form_requests Fr
                            JOIN employeedetails Cr on Fr.created_by = Cr.userid
                            LEFT JOIN employeedetails Up on Fr.updated_by = Up.userid
                            WHERE Fr.form_type='materialrequisition' group by Fr.form_group_id");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function deletematerialrequisition($id)
    {
        $db = db_connect();
        $builder = $db->table('material_requisition_items');
        $builder->where('material_requisition_id', $id);
        $builder->delete();
        $db->close();

        $db = db_connect();
        $builder = $db->table('material_requisition');
        $builder->where('id', $id);
        $builder->delete();
        $db->close();
    }

    public function deletepoform($id)
    {
        $db = db_connect();
        $builder = $db->table('purchase_order_items');
        $builder->where('purchase_order_id', $id);
        $builder->delete();
        $db->close();

        $db = db_connect();
        $builder = $db->table('purchase_order');
        $builder->where('id', $id);
        $builder->delete();
        $db->close();
    }
     public function getdiscountid($branchid)
    {
        $db = db_connect();
        $query = $db->query("SELECT discountid FROM branchlookup where branchid ={$branchid}");
        $result = $query->getRow();
        $db->close();
        return $result->discountid;
    }
    public function getdiscountidnew($branchid)
    {
        $db = db_connect();
        $query = $db->query("SELECT discountid,branchcode FROM branchlookup where branchid ={$branchid}");
        $result = $query->getRow();
        $db->close();
        return $result;
    }
    public function set_getdiscountid($branchid)
    {
        $current = $this->getdiscountid($branchid);
        $nextpaymentid = $current + 1;
        $getdiscountid = $nextpaymentid;
        $db = db_connect();
	    $update = $db->query("UPDATE branchlookup set discountid ='" . $getdiscountid . "' where branchid='$branchid'");
       
    }
}
