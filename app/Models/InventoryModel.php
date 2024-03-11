<?php

namespace App\Models;

use CodeIgniter\Model;

class InventoryModel extends Model
{
    public function getEmployeeDetailWithInventory($productid, $branchid)
    {
        $db = db_connect();
        $query = $db->query("SELECT employeedetails.employeeid, employeedetails.branchid, employeedetails.userid,
                             employeedetails.name, inventorydetails.transferred_by, inventorydetails.created_timestamp as date from employeedetails 
                             LEFT JOIN inventorydetails ON employeedetails.userid = inventorydetails.user_id 
                             AND inventorydetails.product_id = '{$productid}' WHERE employeedetails.branchid IN ({$branchid})");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function getStudentDetailWithInventory($productid, $branchid)
    {
        
        $db = db_connect();
        $query = $db->query("SELECT studentdetails.applicationnumber,studentdetails.reservation_ukey,student_class_relation.branchid, student_class_relation.courseid, studentdetails.userid,
                             studentdetails.name, inventorydetails.product_id, inventorydetails.created_timestamp as date from studentdetails 
                             JOIN student_class_relation ON studentdetails.userid = student_class_relation.studentid
                             LEFT JOIN inventorydetails ON studentdetails.userid = inventorydetails.user_id 
                             AND inventorydetails.product_id in ('{$productid}')
                             WHERE student_class_relation.branchid IN ({$_SESSION['userdetails']->branchid}) 
                             AND student_class_relation.batchid IN ({$_SESSION['activebatch']})");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function getStudentDetailsWithInventory($id)
    {
        $db = db_connect();
        $batchid = $_SESSION['activebatch'];
        $query = $db->query("SELECT studentdetails.name as studentname,studentdetails.applicationnumber,studentdetails.reservation_ukey,student_class_relation.branchid, student_class_relation.courseid, studentdetails.userid,branchlookup.branchname,courselookup.coursename,
                            product.name,product.id as productid,inventory.quantity as quantity from studentdetails 
                             JOIN student_class_relation ON studentdetails.userid = student_class_relation.studentid
                             JOIN branchlookup on student_class_relation.branchid=branchlookup.branchid
                             JOIN courselookup on student_class_relation.courseid=courselookup.courseid
                             JOIN inventory ON studentdetails.userid = inventory.user_id 
                             JOIN product on inventory.product_id=product.id
                             WHERE student_class_relation.branchid IN ({$_SESSION['userdetails']->branchid})  
                             AND student_class_relation.batchid IN ({$_SESSION['activebatch']}) and inventory.batchid='$batchid' AND (studentdetails.rfid = '$id' OR studentdetails.applicationnumber= '$id') ");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    
     public function getStudentDetails($id)
    {
        $db = db_connect();
        $query = $db->query("SELECT studentdetails.name as studentname,studentdetails.applicationnumber,studentdetails.reservation_ukey,student_class_relation.branchid,student_class_relation.batchid, student_class_relation.courseid, studentdetails.userid,branchlookup.branchname,courselookup.coursename from studentdetails 
                             JOIN student_class_relation ON studentdetails.userid = student_class_relation.studentid
                             JOIN branchlookup on student_class_relation.branchid=branchlookup.branchid
                             JOIN courselookup on student_class_relation.courseid=courselookup.courseid
                             WHERE student_class_relation.branchid IN ({$_SESSION['userdetails']->branchid})  
                             AND student_class_relation.batchid IN ({$_SESSION['activebatch']}) AND (studentdetails.rfid = '$id' OR studentdetails.applicationnumber = '$id')");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function getInventory($id)
    {
        $db = db_connect();
        $batchid = $_SESSION['activebatch'];
        $query = $db->query("SELECT inventory.product_id,inventory.quantity,product.name,product.product_type_id from inventory left join product on inventory.product_id=product.id where inventory.user_id={$id} and inventory.batchid={$batchid} ");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function getReservationStudentDetailWithInventory($productid, $branchid)
    {
        $db = db_connect();
        $query = $db->query("SELECT reservation.reservation_ukey, reservation.branchid, reservation.courseid, reservation.reservationid,
                            reservation.name, reservation_inventory.givenby, reservation_inventory.date from reservation 
                             LEFT JOIN reservation_inventory ON reservation.reservationid = reservation_inventory.userid 
                             AND reservation_inventory.productid = '{$productid}'
                             WHERE reservation.branchid IN ({$_SESSION['userdetails']->branchid}) 
                             AND reservation.branchid = '{$branchid}'
                             AND reservation.batchid IN ({$_SESSION['activebatch']})");
        $results = $query->getResult();
        $db->close();

        return $results;
    }



    public function getvendors()
    {
        $db = db_connect();
        $builder = $db->table('vendor');
        $query = $builder->get();
        return $query->getResult();
    }

    public function addvendor($data)
    {
        $db = db_connect();
        $builder = $db->table('vendor');
        $builder->insert($data);

        $db->close();
    }

    public function update_vendor($vendorid, $data)
    {
        $db = db_connect();
        $builder = $db->table('vendor');
        $builder->where('id', $vendorid);
        $builder->update($data);
        $db->close();
    }

    public function deletevendor($id)
    {
        $db = db_connect();
        $builder = $db->table('vendor');
        $builder->where('id', $id);
        $builder->delete();
        $db->close();
    }
    public function getproducttype()
    {
        $db = db_connect();
        $builder = $db->table('product_type');
        $query = $builder->get();
        return $query->getResult();
    }
    public function getproductcategorys()
    {
        $db = db_connect();
        $builder = $db->table('product_category');
        $query = $builder->get();
        return $query->getResult();
    }

    public function addproductcategory($data)
    {
        $db = db_connect();
        $builder = $db->table('product_category');
        $builder->insert($data);

        $db->close();
    }

    public function update_productcategory($vendorid, $data)
    {
        $db = db_connect();
        $builder = $db->table('product_category');
        $builder->where('id', $vendorid);
        $builder->update($data);
        $db->close();
    }

    public function deleteproductcategory($vendorid)
    {
        $db = db_connect();
        $builder = $db->table('product_category');
        $builder->where('id', $vendorid);
        $builder->delete();

        $db->close();
    }


    public function getproducts()
    {
        $db = db_connect();
        $query = $db->query('SELECT product.name as productname, product.code as code,product.id,product.product_type_id,product.product_ids,product.product_category_id, product.quantity, product_category.name as categoryname, product_type.name as producttype from product LEFT JOIN product_category ON product.product_category_id = product_category.id LEFT JOIN product_type ON product.product_type_id = product_type.id');
        return $query->getResult();
    }

    public function addproduct($data)
    {
        $db = db_connect();
        $builder = $db->table('product');
        $builder->insert($data);

        $db->close();
    }

    public function update_product($productid, $data)
    {
        $db = db_connect();
        $builder = $db->table('product');
        $builder->where('id', $productid);
        $builder->update($data);
        $db->close();
    }

    public function deleteproduct($productid)
    {
        $db = db_connect();
        $builder = $db->table('product');
        $builder->where('id', $productid);
        $builder->delete();

        $db->close();
    }

    public function getinventorydetails($inventoryDetailsId = null,$materialid=null)
    {
        $batchid = $_SESSION['activebatch'];
        $db = db_connect();
        if ($inventoryDetailsId == null && $materialid !=null) {
            $query = $db->query("SELECT product.id as productid,product.name as productname,product.product_type_id,product.product_ids,material_requisition_items.*,material_requisition.branch_id from material_requisition join material_requisition_items on material_requisition.id=material_requisition_items.material_requisition_id  join product on material_requisition_items.product_id=product.id 
            where material_requisition.id={$materialid}");
            return $query->getResult();
        } elseif($inventoryDetailsId !=null)
        {
            
            $query =  $db->query("SELECT product.name as productname,product.id as productid,product.product_type_id,product.product_ids,inventorydetails.created_timestamp,inventorydetails.id as intid,inventorydetails.quantity,inventorydetails.available_quantity,inventorydetails.product_received,inventorydetails.product_serial from inventorydetails JOIN product on inventorydetails.product_id=product.id  where inventorydetails.id ={$inventoryDetailsId} and inventorydetails.batchid='$batchid'");
            return $query->getResult();
        }
        else {
            $query =  $db->query("SELECT product.name as productname,product.id as productid,product.product_ids,inventorydetails.id,inventorydetails.created_timestamp,inventorydetails.quantity,inventorydetails.available_quantity,inventorydetails.product_received,inventorydetails.product_serial from inventorydetails JOIN product on inventorydetails.product_id=product.id  where inventorydetails.batchid='$batchid' and inventorydetails.branch_id in({$_SESSION['userdetails']->branchid})");
            return $query->getResult();
        }
    }
    public function getinventorydetail($inventoryDetailsId)
    {
        $db = db_connect();
        $query =  $db->query("SELECT product.id as productid,product.name as productname,product.product_ids,inventorydetails.id,inventorydetails.user_id,inventorydetails.quantity,inventorydetails.available_quantity,inventorydetails.product_received,inventorydetails.branch_id,inventorydetails.transferred_by from inventorydetails JOIN product on inventorydetails.product_id=product.id  where inventorydetails.id = {$inventoryDetailsId}");
        return $query->getResult();
    }
    public function getinventorydetailprint($productid,$userid)
    {
        $db = db_connect();
        $query =  $db->query("SELECT product.id as productid,product.name as productname,product.product_ids,inventorydetails.id,inventorydetails.user_id,inventorydetails.quantity,inventorydetails.available_quantity,inventorydetails.product_received,inventorydetails.branch_id,inventorydetails.transferred_by from inventorydetails JOIN product on inventorydetails.product_id=product.id  where inventorydetails.product_id = {$productid} and inventorydetails.user_id = {$userid}");
        return $query->getResult();
    }
    public function getinventoryproducts($p)
    {
        $db = db_connect();
        $query =  $db->query("SELECT product.id as productid,product.name as productname,product.product_ids,inventorydetails.id,inventorydetails.user_id,inventorydetails.quantity,inventorydetails.available_quantity,inventorydetails.product_received,inventorydetails.branch_id,inventorydetails.transferred_by from inventorydetails JOIN product on inventorydetails.product_id=product.id  where inventorydetails.product_id in ({$p}) and inventorydetails.user_id={$_SESSION['userdetails']->userid}");
        return $query->getResult();
    }
    public function getinventorydetails1()
    {
        $db = db_connect();
       $batchid = $_SESSION['activebatch'];
        $userid = $_SESSION['userdetails']->userid;
        $query = $db->query("SELECT product.product_type_id,product.id as productid,product.product_ids,product.name as productname,product_type.name as type,product_category.name as category,vendor.name as vendorname,inventorydetails.product_received,inventorydetails.id,sum(inventorydetails.quantity) as quantity,sum(inventorydetails.available_quantity) as available_quantity,inventorydetails.created_timestamp from inventorydetails JOIN product on inventorydetails.product_id=product.id left join vendor on inventorydetails.vendor_id=vendor.id JOIN product_type on product.product_type_id=product_type.id JOIN product_category on product.product_category_id=product_category.id where inventorydetails.batchid='{$batchid}' and inventorydetails.user_id='$userid' group by inventorydetails.product_id");
        return $query->getResult();
    }

    public function gettransfers($DateFrom=null)
    {
        $where = '';
        if ($DateFrom != NULL) {
            if ($where == '') {
                $where = " and inventorydetails.created_timestamp like '%{$DateFrom}%'";
            } else {
                $where = $where . " AND inventorydetails.created_timestamp like '%{$DateFrom}%'";
            }
        }
        $db = db_connect();
        $userid = $_SESSION['userdetails']->userid;
         $batchid = $_SESSION['activebatch'];
        $builder = $db->query("SELECT product.id as productid,product.name as name,inventorydetails.product_received,inventorydetails.quantity,branchlookup.branchname,inventorydetails.branch_id,inventorydetails.product_serial,inventorydetails.created_timestamp from inventorydetails
        join product on inventorydetails.product_id=product.id
        join branchlookup on inventorydetails.branch_id = branchlookup.branchid
        where inventorydetails.transferred_by='$userid' and inventorydetails.batchid={$batchid} $where");
        return $builder->getResult();
       
    }
    
     public function getdistribute()
    {
        $db = db_connect();
        $batchid = $_SESSION['activebatch'];
        $userid = $_SESSION['userdetails']->userid;
        $builder = $db->query("SELECT product.id as productid,product.name as name,inventorydetails.product_received,inventorydetails.quantity,studentdetails.name as studentname,inventorydetails.branch_id,inventorydetails.product_serial,inventorydetails.created_timestamp from inventorydetails
        join product on inventorydetails.product_id=product.id
        join studentdetails on studentdetails.userid = inventorydetails.user_id
        where inventorydetails.transferred_by='$userid' and inventorydetails.batchid='$batchid'");
        return $builder->getResult();
       
    }
    public function getreturn()
    {
         $db = db_connect();
        $batchid = $_SESSION['activebatch'];
        $userid = $_SESSION['userdetails']->userid;
        $builder = $db->query("SELECT product.id as productid,product.name as productname,inventorydetails.id,inventorydetails.product_received,inventorydetails.quantity,employeedetails.name as name,inventorydetails.branch_id,inventorydetails.product_serial,inventorydetails.created_timestamp from inventorydetails
        join product on inventorydetails.product_id=product.id
        join employeedetails on employeedetails.userid = inventorydetails.transferred_by
        where inventorydetails.transferred_by='$userid' and inventorydetails.batchid='$batchid' and dispatch_id is not null");
        return $builder->getResult();
       
    }
    public function getreturnrequest()
    {
         $db = db_connect();
        $batchid = $_SESSION['activebatch'];
        $userid = $_SESSION['userdetails']->userid;
        $builder = $db->query("SELECT product.id as productid,product.name as productname,inventorydetails.id,inventorydetails.product_received,inventorydetails.quantity,employeedetails.name as name,inventorydetails.branch_id,inventorydetails.product_serial,inventorydetails.created_timestamp from inventorydetails
        join product on inventorydetails.product_id=product.id
        join employeedetails on employeedetails.userid = inventorydetails.transferred_by
        where inventorydetails.batchid='$batchid' and dispatch_id is not null and branch_id is null");
        return $builder->getResult();
       
    }
    public function getproductinventorydetails($id)
    {
        $db = db_connect();
        $userid = $_SESSION['userdetails']->userid;
        $builder = $db->query("SELECT product.id as productid,product.name as productname,product_type.name as type,product_category.name as category,inventorydetails.quantity,inventorydetails.available_quantity,inventorydetails.branch_id,inventorydetails.product_serial,inventorydetails.receipt,inventorydetails.created_timestamp from inventorydetails
        join product on inventorydetails.product_id=product.id JOIN product_type on product.product_type_id=product_type.id JOIN product_category on product.product_category_id=product_category.id
        where inventorydetails.user_id='$userid' and inventorydetails.product_id='$id'");
        return $builder->getResult();
    }

    public function addInventory($data)
    {
        $db = db_connect();
        $builder = $db->table('inventorydetails');
        $builder->insert($data);

        $db->close();
    }

    public function updateRemainingItems($productid, $remainingTotal)
    {
        $data['available_quantity'] = $remainingTotal;

        $db = db_connect();
        $builder = $db->table('inventorydetails');
        //$builder->where('user_id', $_SESSION['userdetails']->userid);
        $builder->where('id', $productid);
        $builder->update($data);
        $db->close();
    }

    public function add_admin_inventory($data)
    {
        $db = db_connect();
        $builder = $db->table('admin_inventory');
        $builder->insert($data);

        $db->close();
    }

    public function add_employee_inventory($data)
    {
        $db = db_connect();
        $builder = $db->table('employee_inventory');
        $builder->insert($data);

        $db->close();
    }

    public function add_student_inventory($data)
    {
        $db = db_connect();
        $builder = $db->table('inventorydetails');
        $builder->insert($data);

        $db->close();
    }

    public function add_reservation_inventory($data)
    {
        $db = db_connect();
        $builder = $db->table('reservation_inventory');
        $builder->insert($data);

        $db->close();
    }

    public function updateisReceived($id, $receivedby)
    {
        $data['product_received'] = 1;
        $data['user_id'] = $_SESSION['userdetails']->userid;
       // $data['received_by'] = $receivedby;
        $db = db_connect();
        $builder = $db->table('inventorydetails');
        $builder->where('id', $id);
        $builder->update($data);
        $db->close();
    }

    public function get_EmployeeInventory($userid)
    {
        $db = db_connect();
        $query = $db->query("SELECT * FROM 
                                (SELECT products.productid, products.productname
                                FROM products WHERE products.productcategory = 'Employee')A 
                            LEFT JOIN
                                (SELECT employee_inventory.productid, employee_inventory.date, employee_inventory.givenby 
                                FROM `employee_inventory` RIGHT JOIN employeedetails on employee_inventory.userid = employeedetails.userid 
                                WHERE employeedetails.userid = $userid)B
                            ON A.productid = B.productid");
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function get_StudentInventory($userid)
    {
        $db = db_connect();
        $query = $db->query("SELECT studentdetails.name as studentname,studentdetails.applicationnumber,studentdetails.reservation_ukey,student_class_relation.branchid, student_class_relation.courseid, studentdetails.userid,branchlookup.branchname,courselookup.coursename,
                             studentdetails.name,Up.name as emp,product.product_ids, inventorydetails.created_timestamp as date,inventorydetails.id,product.name,product.name as productname,product.id as productid,inventorydetails.quantity as quantity,inventorydetails.created_timestamp,inventorydetails.batchid from studentdetails 
                             JOIN student_class_relation ON studentdetails.userid = student_class_relation.studentid
                             JOIN branchlookup on student_class_relation.branchid=branchlookup.branchid
                             JOIN courselookup on student_class_relation.courseid=courselookup.courseid
                             LEFT JOIN inventorydetails ON studentdetails.userid = inventorydetails.user_id 
                             LEFT JOIN product on inventorydetails.product_id=product.id
                            
                            LEFT JOIN employeedetails Up on inventorydetails.transferred_by = Up.userid
                             WHERE studentdetails.userid = '{$userid}'
                             AND student_class_relation.batchid IN ({$_SESSION['activebatch']})");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function getpruchaseorders($formgroupid)
    {
        $db = db_connect();
        $query = $db->query("SELECT Fr.*,p.*, Cr.name AS CreatedBy, Up.Name as UpdatedBy FROM purchase_order Fr
        JOIN purchase_order_items poi on Fr.id = poi.purchase_order_id
        JOIN product p on poi.product_id = p.id
        JOIN employeedetails Cr on Fr.created_by = Cr.userid
        LEFT JOIN employeedetails Up on Fr.updated_by = Up.userid
                            WHERE Fr.purchase_order_id='{$formgroupid}'");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function getpruchaseorder()
    {
        $db = db_connect();
        $query = $db->query("SELECT Fr.*, Cr.name AS CreatedBy, Up.Name as UpdatedBy FROM purchase_order Fr JOIN employeedetails Cr on Fr.created_by = Cr.userid
                            LEFT JOIN employeedetails Up on Fr.updated_by = Up.userid
                            WHERE Fr.purchase_order_status = 'created'");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function getMaterialRequest()
    {
        $db = db_connect();
        $query = $db->query("SELECT Fr.*, Cr.name AS CreatedBy, Up.Name as UpdatedBy FROM material_requisition Fr
                            JOIN employeedetails Cr on Fr.created_by = Cr.userid
                            LEFT JOIN employeedetails Up on Fr.updated_by = Up.userid
                            WHERE Fr.material_requisition_status != 'created'");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function getMaterialRequestitems($formgroupid)
    {
        $db = db_connect();
        $query = $db->query("SELECT Fr.material_requisition_id,Fr.product_id,sum(Fr.quantity) as quantity,
        Fr.approved_quantity,sum(Fr.delivered_quantity) as delivered_quantity,Cr.name as productname,Fr.id FROM material_requisition_items Fr
        JOIN material_requisition mr on mr.id=Fr.material_requisition_id
        JOIN product Cr on Fr.product_id = Cr.id
       
        WHERE mr.material_requisition_status !='created' GROUP BY Fr.product_id");
        $results = $query->getResult();
        foreach($results as $key => $result)
        {
            $query1 = $db->query("SELECT GROUP_CONCAT(Fr.id) as material_requisition_item_ids FROM material_requisition_items Fr
            JOIN material_requisition mr on mr.id=Fr.material_requisition_id
            JOIN product Cr on Fr.product_id = Cr.id
            WHERE mr.material_requisition_status !='created' and Fr.product_id={$result->product_id} GROUP BY Fr.product_id ");
            $results1 = $query1->getResult();
            $results[$key]->material_requisition_item_ids = $results1[0]->material_requisition_item_ids;
        }
        $db->close();

        return $results;

    }

    public function getApprovedMaterialForms($userid)
    {
        $db = db_connect();
        $query = $db->query("SELECT Fr.*, Cr.name AS CreatedBy, Up.Name as UpdatedBy,br.branchname FROM material_requisition Fr
                            JOIN employeedetails Cr on Fr.created_by = Cr.userid
                            LEFT JOIN employeedetails Up on Fr.updated_by = Up.userid
                            LEFT JOIN branchlookup br on Fr.branch_id = br.branchid
                            WHERE Fr.material_requisition_status != 'created'");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function getApprovedMaterialForm($formgroupid)
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

    public function getPurchaseorder()
    {
        $db = db_connect();
        $query = $db->query("SELECT Fr.*, Cr.name AS CreatedBy, Up.Name as UpdatedBy FROM purchase_order Fr
                            JOIN employeedetails Cr on Fr.created_by = Cr.userid
                            LEFT JOIN employeedetails Up on Fr.updated_by = Up.userid
                            WHERE Fr.purchase_order_status = 'approved'");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function getPurchaseorderitems($formgroupid)
    {
        $db = db_connect();
        $query = $db->query("SELECT Fr.*,Cr.name as productname,Cr.product_type_id FROM purchase_order_items Fr
        JOIN purchase_order mr on mr.id=Fr.purchase_order_id
        JOIN product Cr on Fr.product_id = Cr.id
        WHERE mr.purchase_order_status !='created'");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function getinventorycount()
    {
        $db = db_connect();
        $batchid = $_SESSION['activebatch'];
        $query = $db->query("select * from inventory where user_id={$_SESSION['userdetails']->userid} and inventory.batchid={$batchid} ");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function getallinventorywarehouse()
    {
        $db = db_connect();
        $batchid = $_SESSION['activebatch'];
        $query = $db->query("select product.name,inventory.quantity from inventory join 
        product on inventory.product_id=product.id JOIN
        employeedetails on inventory.user_id=employeedetails.userid where inventory.user_id={$_SESSION['userdetails']->userid} and inventory.batchid={$batchid} ");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function getalldailyinventorywarehouse($DateFrom,$DateTo)
    {
        $batchid = $_SESSION['activebatch'];
        $userid = $_SESSION['userdetails']->userid;
         if ($where == '') {
                $where = " inventorydetails.user_id={$userid}";
            } else {
                $where = $where . " AND inventorydetails.user_id={$userid}";
            }
             if ($where == '') {
                $where = " inventorydetails.batchid={$batchid}";
            } else {
                $where = $where . " AND inventorydetails.batchid={$batchid}";
            }
        if ($DateFrom != NULL) {
            if ($where == '') {
                $where = " inventorydetails.created_timestamp >= '{$DateFrom}'";
            } else {
                $where = $where . " AND inventorydetails.created_timestamp >= '{$DateFrom}'";
            }
        }
        if ($DateTo != NULL) {
            if ($where == '') {
                $where = " inventorydetails.created_timestamp <= '{$DateTo}'";
            } else {
                $where = $where . " AND inventorydetails.created_timestamp <= '{$DateTo}'";
            }
        }

        $whereCondition = $where == '' ? '' : "WHERE {$where}";
        $db = db_connect();
        $builder = $db->query("SELECT product.name as name,SUM(inventorydetails.quantity) as count,inventorydetails.created_timestamp from inventorydetails
        join product on inventorydetails.product_id=product.id
        left join employeedetails on inventorydetails.transferred_by=employeedetails.userid left join users on employeedetails.userid=users.userid
        {$whereCondition} Group by product.id");
        return $builder->getResult();
    }
     public function getalldailyinventorywarehouse1($DateFrom,$DateTo)
    {
        $batchid = $_SESSION['activebatch'];
        $userid = $_SESSION['userdetails']->userid;
         if ($where == '') {
                $where = " inventorydetails.transferred_by={$userid}";
            } else {
                $where = $where . " AND inventorydetails.transferred_by={$userid}";
            }
             if ($where == '') {
                $where = " inventorydetails.batchid={$batchid}";
            } else {
                $where = $where . " AND inventorydetails.batchid={$batchid}";
            }
         if ($DateFrom != NULL) {
            if ($where == '') {
                $where = " inventorydetails.created_timestamp >= '{$DateFrom}'";
            } else {
                $where = $where . " AND inventorydetails.created_timestamp >= '{$DateFrom}'";
            }
        }
        if ($DateTo != NULL) {
            if ($where == '') {
                $where = " inventorydetails.created_timestamp <= '{$DateTo}'";
            } else {
                $where = $where . " AND inventorydetails.created_timestamp <= '{$DateTo}'";
            }
        }

        $whereCondition = $where == '' ? '' : "WHERE {$where}";
        $db = db_connect();
        $builder = $db->query("SELECT product.name as name,SUM(inventorydetails.quantity) as count,branchlookup.branchname,inventorydetails.created_timestamp from inventorydetails
        join product on inventorydetails.product_id=product.id
        JOIN branchlookup on inventorydetails.branch_id=branchlookup.branchid
        left join employeedetails on inventorydetails.transferred_by=employeedetails.userid left join users on employeedetails.userid=users.userid
        {$whereCondition} Group by product.id,inventorydetails.branch_id");
        return $builder->getResult();
    }
     public function getallinventory()
    {
        $db = db_connect();
        $batchid = $_SESSION['activebatch'];
        $query = $db->query("select product.name,inventory.quantity,employeedetails.name as employeename from inventory join 
        product on inventory.product_id=product.id JOIN
        employeedetails on inventory.user_id=employeedetails.userid join users on employeedetails.userid=users.userid where users.roleid=7 and inventory.batchid={$batchid} ");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
     public function getmyinventory()
    {
        $db = db_connect();
        $batchid = $_SESSION['activebatch'];
        $query = $db->query("select product.name,inventory.quantity,employeedetails.name as employeename from inventory join 
        product on inventory.product_id=product.id JOIN
        employeedetails on inventory.user_id=employeedetails.userid join users on employeedetails.userid=users.userid where inventory.batchid={$batchid} and inventory.user_id={$_SESSION['userdetails']->userid}");
        $results = $query->getResult();
        $db->close();

        return $results;
    }
    public function getdistributeinventory()
    {
        $db = db_connect();
        $batchid = $_SESSION['activebatch'];
        $userid = $_SESSION['userdetails']->userid;
        $builder = $db->query("SELECT product.id as productid,product.name as name,inventorydetails.product_received,inventorydetails.quantity,studentdetails.name as studentname,applicationnumber,employeedetails.name as employeename,inventorydetails.branch_id,inventorydetails.product_serial,inventorydetails.created_timestamp from inventorydetails
        join product on inventorydetails.product_id=product.id
        join employeedetails on inventorydetails.transferred_by=employeedetails.userid join users on employeedetails.userid=users.userid
        join studentdetails on studentdetails.userid = inventorydetails.user_id
        where users.roleid=7 and inventorydetails.batchid={$batchid}");
        return $builder->getResult();
       
    }
    public function getmydistributeinventory()
    {
        $db = db_connect();
        $batchid = $_SESSION['activebatch'];
        $userid = $_SESSION['userdetails']->userid;
        $builder = $db->query("SELECT product.id as productid,product.name as name,inventorydetails.product_received,inventorydetails.quantity,applicationnumber,studentdetails.name as studentname,employeedetails.name as employeename,inventorydetails.branch_id,inventorydetails.product_serial,inventorydetails.created_timestamp from inventorydetails
        join product on inventorydetails.product_id=product.id
        join employeedetails on inventorydetails.transferred_by=employeedetails.userid join users on employeedetails.userid=users.userid
        join studentdetails on studentdetails.userid = inventorydetails.user_id
        where users.roleid=7 and inventorydetails.transferred_by='$userid' and inventorydetails.batchid={$batchid}");
        return $builder->getResult();
    }
    
}
