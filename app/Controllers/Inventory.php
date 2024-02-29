<?php

namespace App\Controllers;

use App\Models\HelperModel;
use App\Models\InventoryModel;
use App\Models\ManufacturerModel;
use App\Models\ProductSpecificationModel;
use App\Models\PurchaseInvoiceItemModel;
use App\Models\PurchaseInvoiceModel;
use App\Models\UsersModel;
use App\Models\ReservationModel;
use App\Models\WarehouseModel;

class Inventory extends BaseController
{
    public $session;
    public function __construct()
    {
        $session = session();
    }

    public function index()
    {
        if ($_SESSION['userdetails'] == null) {
            return view('loggedoutuser/index.php');
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function vendor()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Inventory/vendor';

            $inventoryModel = new InventoryModel();
            $data['vendors'] = $inventoryModel->getvendors();

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function addvendor()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['name'] = $_POST['vendorname'];
            $data['gst'] = $_POST['vendorgst'];
            $data['pan'] = $_POST['vendorpan'];
            $data['bank_name'] = $_POST['bank_name'];
            $data['bank_branch'] = $_POST['bank_branch'];
            $data['bank_ifsc'] = $_POST['bank_ifsc'];
            $data['bank_account'] = $_POST['bank_account'];
            $data['bank_account_holder'] = $_POST['bank_account_holder'];

            $inventoryModel = new InventoryModel();
            $inventoryModel->addvendor($data);

            return redirect()->to(base_url('Inventory/vendor'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function updatevendor()
    {
        if ($_SESSION['userdetails'] != null) {
            $vendorid = $_POST['vendorid'];
            $data['name'] = $_POST['vendorname'];
            $data['gst'] = $_POST['vendorgst'];
            $data['pan'] = $_POST['vendorpan'];
            $data['bank_name'] = $_POST['bank_name'];
            $data['bank_branch'] = $_POST['bank_branch'];
            $data['bank_ifsc'] = $_POST['bank_ifsc'];
            $data['bank_account'] = $_POST['bank_account'];
            $data['bank_account_holder'] = $_POST['bank_account_holder'];

            $inventoryModel = new InventoryModel();
            $inventoryModel->update_vendor($vendorid, $data);
            return redirect()->to(base_url('Inventory/vendor'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function deletevendor()
    {
        if ($_SESSION['userdetails'] != null) {
            $id = $_GET['id'];
            $inventoryModel = new InventoryModel();
            $inventoryModel->deletevendor($id);

            return redirect()->to(base_url('Inventory/vendor'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function productcategory()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Inventory/productcategory';

            $inventoryModel = new InventoryModel();
            $data['productcategorys'] = $inventoryModel->getproductcategorys();

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function addproductcategory()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['name'] = $_POST['productcategoryname'];

            $inventoryModel = new InventoryModel();
            $inventoryModel->addproductcategory($data);

            return redirect()->to(base_url('Inventory/productcategory'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function updateproductcategory()
    {
        if ($_SESSION['userdetails'] != null) {
            $vendorid = $_POST['productcategoryid'];
            $data['name'] = $_POST['productcategoryname'];

            $inventoryModel = new InventoryModel();
            $inventoryModel->update_productcategory($vendorid, $data);

            return redirect()->to(base_url('Inventory/productcategory'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function deleteproductcategory()
    {
        if ($_SESSION['userdetails'] != null) {
            $vendorid = $_GET['productcategoryid'];

            $inventoryModel = new InventoryModel();
            $inventoryModel->deleteproductcategory($vendorid);

            return redirect()->to(base_url('Inventory/productcategory'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }


    public function products()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Inventory/products';

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            $inventoryModel = new InventoryModel();
            $data['productcategory'] = $inventoryModel->getproductcategorys();
            $data['producttype'] = $inventoryModel->getproducttype();
            $data['products'] = $inventoryModel->getproducts();
            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function addproduct()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['name'] = $_POST['productname'];
            $data['quantity'] = $_POST['quantity'];
            $data['product_category_id'] = $_POST['productcategory'];
            $data['product_type_id'] = $_POST['producttype'];
            if(isset($_POST['productids'])){
            $data['product_ids'] = COUNT($_POST['productids']) == 0 ? "" : implode(',', $_POST['productids']);
            }
            $inventoryModel = new InventoryModel();
            $inventoryModel->addproduct($data);

            return redirect()->to(base_url('Inventory/products'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function updateproduct()
    {
        if ($_SESSION['userdetails'] != null) {
            $productid = $_POST['productid'];
            $data['name'] = $_POST['productname'];
            $data['product_type_id'] = $_POST['producttype'];
            $data['product_category_id'] = $_POST['productcategory'];
            $data['quantity'] = $_POST['quantity'];

            $inventoryModel = new InventoryModel();
            $inventoryModel->update_product($productid, $data);

            return redirect()->to(base_url('Inventory/products'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function deleteproduct()
    {
        if ($_SESSION['userdetails'] != null) {
            $productid = $_GET['productid'];

            $inventoryModel = new InventoryModel();
            $inventoryModel->deleteproduct($productid);

            return redirect()->to(base_url('Inventory/products'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function Transfer()
    {
        if ($_SESSION['userdetails'] != null) {
            $inventorydetailsid = $_GET['inventorydetailsid'];
            $materialid = $_GET['materialid'];
            $inventoryModel = new InventoryModel();
            $data['InventoryDetails'] = $inventoryModel->getinventorydetails($inventorydetailsid,$materialid);
           // $data['inventorycount'] = $inventoryModel->getinventorycount();
                $data['page_name'] = 'Inventory/Transfer';

                $helperModel = new HelperModel();
                $data['lookups'] = $helperModel->get_lookups();

                $usersModel = new UsersModel();
                $data['EmployeeDetails'] = $usersModel->getAllEmployeeDetails();

                return view('loggedinuser/index.php', $data);
            
            return redirect()->to(base_url('dashboard'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }
    
    public function Return()
    {
        if ($_SESSION['userdetails'] != null) {
            $inventorydetailsid = $_GET['inventorydetailsid'];
            $materialid = $_GET['materialid'];
            $inventoryModel = new InventoryModel();
            $data['InventoryDetails'] = $inventoryModel->getinventorydetails($inventorydetailsid,$materialid);
           // $data['inventorycount'] = $inventoryModel->getinventorycount();
                $data['page_name'] = 'Inventory/Return';

                $helperModel = new HelperModel();
                $data['lookups'] = $helperModel->get_lookups();

                $usersModel = new UsersModel();
                $data['EmployeeDetails'] = $usersModel->getAllEmployeeDetails();

                return view('loggedinuser/index.php', $data);
            
            return redirect()->to(base_url('dashboard'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }
    
    

    public function Distribute()
    {
        if ($_SESSION['userdetails'] != null) {
            $inventorydetailsid = $_GET['inventorydetailsid'];

            $inventoryModel = new InventoryModel();
            if($inventorydetailsid !=''){
            $data['InventoryDetails'] = $inventoryModel->getinventorydetail($inventorydetailsid);
            
            }
            if ($data['InventoryDetails'][0]->user_id == $_SESSION['userdetails']->userid) {
                $data['page_name'] = 'Inventory/distribute';
    
                $helperModel = new HelperModel();
                $data['lookups'] = $helperModel->get_lookups();
                $data['product'] = array();
                if ($_GET['category'] == "2") {
                    $data['EmployeeDetails'] = $inventoryModel->getEmployeeDetailWithInventory($data['InventoryDetails'][0]->productid, $data['InventoryDetails'][0]->branch_id);
                   
                } else if ($_GET['category'] == "1") {
                   
                    $data['StudentDetails'] = $inventoryModel->getStudentDetailWithInventory($data['InventoryDetails'][0]->productid, $data['InventoryDetails'][0]->branch_id);
                } else if ($_GET['category'] == "3") {
                    $data['ReservationStudentDetails'] = $inventoryModel->getReservationStudentDetailWithInventory($data['InventoryDetails'][0]->productid, $data['InventoryDetails'][0]->branch_id);
                }

                return view('loggedinuser/index.php', $data);
            }
            else
            {
                $data['page_name'] = 'Inventory/distribute';

                $helperModel = new HelperModel();
                $data['lookups'] = $helperModel->get_lookups();
                $products = $_GET['products'];
               $p = implode(', ', $products);
               $data['product'] = $products;
               $data['InventoryDetails'] = $inventoryModel->getinventoryproducts($p);
               if ($_GET['category'] == "2") {
                $data['EmployeeDetails'] = $inventoryModel->getEmployeeDetailWithInventory($data['InventoryDetails'][0]->productid, $data['InventoryDetails'][0]->branch_id);
               
            } else if ($_GET['category'] == "1") {
                $data['StudentDetails'] = $inventoryModel->getStudentDetailWithInventory($p, $data['InventoryDetails'][0]->branch_id);
                
            } else if ($_GET['category'] == "3") {
                $data['ReservationStudentDetails'] = $inventoryModel->getReservationStudentDetailWithInventory($data['InventoryDetails'][0]->productid, $data['InventoryDetails'][0]->branch_id);
            }
               return view('loggedinuser/index.php', $data);
            }
            return redirect()->to(base_url('dashboard'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function studentdistribute($id=null)
    {
        $data['page_name'] = 'Inventory/studentdistribute';
        $helperModel = new HelperModel();
        $data['lookups'] = $helperModel->get_lookups();
        $inventoryModel = new InventoryModel();
        if($_GET['id'] != '')
        {
            $data['StudentDetails'] = $inventoryModel->getStudentDetailsWithInventory($_GET['id']);
           
            $data['StudentDetail'] = $inventoryModel->getStudentDetails($_GET['id']);
            $data['InventoryDetails'] = $inventoryModel->getInventory($_SESSION['userdetails']->userid);
        }
        return view('loggedinuser/index.php', $data);
    }

    public function admin_inventory()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['productid'] = $_POST['productid'];
            $data['count'] = $_POST['count'];
            $data['date'] = date('Y-m-d');
            $data['utilizedby'] = $_SESSION['userdetails']->userid;
            $data['comment'] = $_POST['comment'];

            $inventorydetailsid = $_POST['inventorydetailsid'];
            $data['inventorydetailsid'] = $inventorydetailsid;

            $inventoryModel = new InventoryModel();
            $inventoryModel->add_admin_inventory($data);

            $originalTotal = $_POST['remainingtotal'];
            $remainingTotal = $originalTotal - $data['count'];
            $inventoryModel->updateRemainingItems($inventorydetailsid, $remainingTotal);

            return redirect()->to(base_url('Inventory/details'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function employee_inventory()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['productid'] = $_POST['productid'];
            $data['date'] = date('Y-m-d');
            $data['givenby'] = $_SESSION['userdetails']->userid;
            $data['userid'] = $_POST['userid'];

            $inventorydetailsid = $_POST['inventorydetailsid'];
            $data['inventorydetailsid'] = $inventorydetailsid;

            $originalTotal = $_POST['remainingtotal'];
            $remainingTotal = $originalTotal - 1;

            if ($originalTotal == 1 || $remainingTotal > 0) {
                $inventoryModel = new InventoryModel();
                $inventoryModel->add_employee_inventory($data);

                $inventoryModel->updateRemainingItems($inventorydetailsid, $remainingTotal);

                return "1";
            }
            return "0";
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function student_inventory()
    {
        if ($_SESSION['userdetails'] != null) {
            $db = db_connect();
            $idss =array($_POST['productid']);
            $var = explode(',', $idss[0]);
            foreach($var as $ss){
            $data['product_id'] = $ss;
            $data['created_timestamp'] = date('Y-m-d');
            $data['transferred_by'] = $_SESSION['userdetails']->userid;
            $data['user_id'] = $_POST['userid'];
            $data['quantity'] = 1;
            $userid = $_POST['userid'];
            $productid = $ss;
            $data['batchid'] =  $_SESSION['activebatch'];

            $inventorydetailsid = $_POST['inventorydetailsid'];
            

            $originalTotal = $_POST['remainingtotal'];
            $remainingTotal = $originalTotal - 1;
            $batchid = $_SESSION['activebatch'];
            if ($originalTotal == 1 || $remainingTotal > 0) {
                $inventoryModel = new InventoryModel();
                $inventoryModel->add_student_inventory($data);

               // $inventoryModel->updateRemainingItems($inventorydetailsid, $remainingTotal);
                    $total = 1;
                    $product =$ss;
                    $user = $_SESSION['userdetails']->userid;
                    $querytol = $db->query("select * from inventorydetails where user_id='$user' and product_id='$product' and batchid='$batchid' order by `id` ASC");
                    $resulttol = $querytol->getResult();
                    foreach($resulttol as $resulttols)
                    {
                        $available = $resulttols->available_quantity;
                        $id = $resulttols->id;
                        if($total > 0){
                        if(($total-$available) >= 0)
                        {
                            $querytol = $db->query("update inventorydetails set available_quantity=0 where id='$id'");
                            $total = $total - $resulttols->available_quantity;
                        }
                        else{
                            $availble = abs($total-$available);
                            $querytol = $db->query("update inventorydetails set available_quantity='$availble' where id='$id'");
                            $total = $total - $availble;
                        }
                    }
                    

                 $batchid = $_SESSION['activebatch'];
                $query1 = $db->query("select * from inventory where user_id='$userid' and product_id='$productid' and batchid='$batchid'");
                $results = $query1->getResult();
                if (count($results) > 0) {
                    $quantity = $results[0]->quantity;
                    $updatequantity = $quantity + 1;
                    $query1 = $db->query("update inventory set quantity='$updatequantity' where product_id='$productid' and user_id='$userid' and batchid='$batchid'");
                } else {
                    $batchid = $_SESSION['activebatch'];
                    $query1 = $db->query("insert into inventory set user_id='$userid',product_id='$productid',quantity='1',batchid='$batchid'");
                }

                $proid = $productid;
                $userid = $_SESSION['userdetails']->userid;
                $queryres = $db->query("select * from inventory where product_id='$proid' and user_id='$userid' and batchid='$batchid' ");
                $resultres = $queryres->getResult();
                if (count($resultres) > 0) {
                    $invid = $resultres[0]->id;
                    $qty = $resultres[0]->quantity-1;
                $query1 = $db->query("update inventory set quantity='$qty' where id=' $invid'");
                }
                }
                
            }
            
        }
        return "1";
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function studentinventory()
    {
        if ($_SESSION['userdetails'] != null) {

            $nameArr = $_POST['productid'];
            $quantityArr  = $_POST['quantity'];
            $remainingtotal  = $_POST['remainingtotal'];

            for ($i = 0; $i < count($nameArr); $i++) {
            $data['product_id'] = $nameArr[$i];
            $data['created_timestamp'] = date('Y-m-d');
            $data['transferred_by'] = $_SESSION['userdetails']->userid;
            $data['user_id'] = $_POST['userid'];
            $data['quantity'] = $quantityArr[$i];
            $data['batchid'] =  $_SESSION['activebatch'];
            $userid = $_POST['userid'];
            $productid = $nameArr[$i];
            

            $inventorydetailsid = $_POST['inventorydetailsid'];
            
            $originalTotal = $remainingtotal[$i];
            $remainingTotal = $originalTotal - 1;
            $batchid = $_SESSION['activebatch'];
            if ($originalTotal == 1 || $remainingTotal > 0) {
                $inventoryModel = new InventoryModel();
                $inventoryModel->add_student_inventory($data);

                $db = db_connect();
                $total = $quantityArr[$i];
                    $product =$nameArr[$i];
                    $user = $_SESSION['userdetails']->userid;
                    $querytol = $db->query("select * from inventorydetails where user_id='$user' and product_id='$product' and batchid='$batchid' order by `id` ASC");
                    $resulttol = $querytol->getResult();
                    foreach($resulttol as $resulttols)
                    {
                        $available = $resulttols->available_quantity;
                        $id = $resulttols->id;
                        if($total > 0){
                        if(($total-$available) >= 0)
                        {
                            $querytol = $db->query("update inventorydetails set available_quantity=0 where id='$id'");
                            $total = $total - $resulttols->available_quantity;
                        }
                        else{
                            $availble = abs($total-$available);
                            $querytol = $db->query("update inventorydetails set available_quantity='$availble' where id='$id'");
                            $total = $total - $availble;
                        }
                    }
                    
                   $db = db_connect();
                $query1 = $db->query("select * from inventory where user_id='$userid' and product_id='$product' and batchid='$batchid'");
                $results = $query1->getResult();
                if (count($results) > 0) {
                    $quantity = $results[0]->quantity;
                    $updatequantity = $quantity + $quantityArr[$i];
                    $query1 = $db->query("update inventory set quantity='$updatequantity' where product_id='$product' and user_id='$userid' and batchid='$batchid'");
        
                } else {
                    $query1 = $db->query("insert into inventory set user_id='$userid',product_id='$product',quantity='$quantityArr[$i]',batchid='$batchid'");
                }

                $proid = $product;
                $userid = $_SESSION['userdetails']->userid;
                $queryres = $db->query("select * from inventory where product_id='$proid' and user_id='$userid' and batchid='$batchid'");
                $resultres = $queryres->getResult();
                if (count($resultres) > 0) {
                    $invid = $resultres[0]->id;
                    $qty = $resultres[0]->quantity-$quantityArr[$i];
                $query1 = $db->query("update inventory set quantity='$qty' where id=' $invid'");
                }

                    }
                    
               //  return redirect()->to(base_url("Inventory/studentdistribute?id={$userid}"));
                //return redirect()->to(base_url('Inventory/studentdistribute'));
            }
           
        }
        $userid = $_POST['userid'];
        $queryres = $db->query("select rfid from studentdetails where userid='$userid'");
        $resultres = $queryres->getResult();
         $rfid = $resultres[0]->rfid;
         return redirect()->to(base_url("Inventory/studentdistribute?id={$rfid}"));
        } else {
            return redirect()->to(base_url('Inventory/studentdistribute'));
        }
    }

    public function reservation_inventory()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['productid'] = $_POST['productid'];
            $data['date'] = date('Y-m-d');
            $data['givenby'] = $_SESSION['userdetails']->userid;
            $data['userid'] = $_POST['userid'];

            $inventorydetailsid = $_POST['inventorydetailsid'];
            $data['inventorydetailsid'] = $inventorydetailsid;

            $originalTotal = $_POST['remainingtotal'];
            $remainingTotal = $originalTotal - 1;

            if ($originalTotal == 1 || $remainingTotal > 0) {
                $inventoryModel = new InventoryModel();
                $inventoryModel->add_reservation_inventory($data);

                $inventoryModel->updateRemainingItems($inventorydetailsid, $remainingTotal);

                return "1";
            }
            return "0";
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function details($id=null)
    {
        if ($_SESSION['userdetails'] != null) {
            if($id ==null){
            $data['page_name'] = 'Inventory/details';

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            $inventoryModel = new InventoryModel();
            $data['products'] = $inventoryModel->getproducts();
            if ($_SESSION['rights'][array_search('WarehouseManager', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) :
                $data['inventory'] = $inventoryModel->getinventorydetails1();
                $data['allinventory'] = $inventoryModel->getallinventory();
                 $data['transfers'] = $inventoryModel->gettransfers();
                 $data['returns'] = $inventoryModel->getreturnrequest();
            else :
                $data['inventory'] = $inventoryModel->getinventorydetails();
                 $data['transfers'] = $inventoryModel->getdistribute();
                 $data['returns'] = $inventoryModel->getreturn();

              
            endif;
            $download = (isset($_GET['download']) && $_GET['download'] != "") ? $_GET['download'] : NULL;
           if ($download == 1) {
                $setData = '';
                foreach ($data['transfers']  as $key => $rec) {
                    if ($key == 0) {
                        $rowData = '';
                        foreach ($rec as $key => $value) {
                           
                                $key = '"' . $key . '"' . "\t";
                                $rowData .= $key;
                        }
                        $setData .= trim($rowData) . "\n";
                    }

                    $rowData = '';
                    foreach ($rec as $key => $value) {
                            $value = '"' . $value . '"' . "\t";
                            $rowData .= $value;
                    }
                    $setData .= trim($rowData) . "\n";
                }

                header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=transfer_Report.xls");
                header("Pragma: no-cache");
                header("Expires: 0");
                echo $setData . "\n";
            } 
            return view('loggedinuser/index.php', $data);
        }else
        {
            $data['id']= $id;
            $data['page_name'] = 'Inventory/details';
            $inventoryModel = new InventoryModel();
            $data['inventory'] = $inventoryModel->getproductinventorydetails($id);
            return view('loggedinuser/index.php', $data);
        }
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }
    public function reports()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Reports/inventoryreports';
            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('home'));
        }
    }
    
    public function warehousereport()
    {
        if ($_SESSION['userdetails'] != null) {
            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();
            $inventoryModel = new InventoryModel();
            $data['page_name'] = 'Reports/warehousereport';
            $data['getallinventorywarehouse'] = $inventoryModel->getallinventorywarehouse();
            
            if ($_SESSION['rights'][array_search('WarehouseManager', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) :
            $data['allinventory'] = $inventoryModel->getallinventory();
            $data['getdistributeinventory'] = $inventoryModel->getdistributeinventory();
            else :
            $data['allinventory'] = $inventoryModel->getmyinventory();
            $data['getdistributeinventory'] = $inventoryModel->getmydistributeinventory();
            endif;
             $download = (isset($_GET['download']) && $_GET['download'] != "") ? $_GET['download'] : NULL;
             
            if ($download == 1) {
                $setData = '';
                foreach ($data['getallinventorywarehouse'] as $key => $rec) {
                    if ($key == 0) {
                        $rowData = '';
                        foreach ($rec as $key => $value) {
                           
                                $key = '"' . $key . '"' . "\t";
                                $rowData .= $key;
                        }
                        $setData .= trim($rowData) . "\n";
                    }

                    $rowData = '';
                    foreach ($rec as $key => $value) {
                            $value = '"' . $value . '"' . "\t";
                            $rowData .= $value;
                    }
                    $setData .= trim($rowData) . "\n";
                }

                header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=warehouse_Report.xls");
                header("Pragma: no-cache");
                header("Expires: 0");
                echo $setData . "\n";
            } 
             elseif ($download == 2) {
                $setData = '';
                foreach ($data['allinventory'] as $key => $rec) {
                    if ($key == 0) {
                        $rowData = '';
                        foreach ($rec as $key => $value) {
                           
                                $key = '"' . $key . '"' . "\t";
                                $rowData .= $key;
                        }
                        $setData .= trim($rowData) . "\n";
                    }

                    $rowData = '';
                    foreach ($rec as $key => $value) {
                            $value = '"' . $value . '"' . "\t";
                            $rowData .= $value;
                    }
                    $setData .= trim($rowData) . "\n";
                }

                header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=inventorymanager_Report.xls");
                header("Pragma: no-cache");
                header("Expires: 0");
                echo $setData . "\n";
            } elseif ($download == 3) {
                $setData = '';
                foreach ($data['getdistributeinventory'] as $key => $rec) {
                    if ($key == 0) {
                        $rowData = '';
                        foreach ($rec as $key => $value) {
                           
                                $key = '"' . $key . '"' . "\t";
                                $rowData .= $key;
                        }
                        $setData .= trim($rowData) . "\n";
                    }

                    $rowData = '';
                    foreach ($rec as $key => $value) {
                            $value = '"' . $value . '"' . "\t";
                            $rowData .= $value;
                    }
                    $setData .= trim($rowData) . "\n";
                }

                header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=inventorymanagerdistribute_Report.xls");
                header("Pragma: no-cache");
                header("Expires: 0");
                echo $setData . "\n";
            }
            else {
                return view('loggedinuser/index.php', $data);
            }
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }
    
    
    public function warehousedailyreport()
    {
        if ($_SESSION['userdetails'] != null) {
            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();
            $inventoryModel = new InventoryModel();
            $data['page_name'] = 'Reports/dailywarehousereport';
            $DateFrom = date_create_from_format("d/m/Y", $_GET['DateFrom']) != false ? date_format(date_create_from_format("d/m/Y", $_GET['DateFrom']), 'Y-m-d') : date('Y-m-d');
            $DateTo = date_create_from_format("d/m/Y", $_GET['DateTo']) != false ? date_format(date_create_from_format("d/m/Y", $_GET['DateTo']), 'Y-m-d') : date('Y-m-d');

            $data['getallinventorywarehouse'] = $inventoryModel->getalldailyinventorywarehouse($DateFrom,$DateTo);
            $data['getallinventorywarehouse1'] = $inventoryModel->getalldailyinventorywarehouse1($DateFrom,$DateTo);
             $download = (isset($_GET['download']) && $_GET['download'] != "") ? $_GET['download'] : NULL;
             
                  if ($download == 1) {
                $setData = '';
                foreach ($data['getallinventorywarehouse'] as $key => $rec) {
                    if ($key == 0) {
                        $rowData = '';
                        foreach ($rec as $key => $value) {
                           
                                $key = '"' . $key . '"' . "\t";
                                $rowData .= $key;
                        }
                        $setData .= trim($rowData) . "\n";
                    }

                    $rowData = '';
                    foreach ($rec as $key => $value) {
                            $value = '"' . $value . '"' . "\t";
                            $rowData .= $value;
                    }
                    $setData .= trim($rowData) . "\n";
                }

                header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=warehouse_dailyinstock_Report.xls");
                header("Pragma: no-cache");
                header("Expires: 0");
                echo $setData . "\n";
            } 
             elseif ($download == 2) {
                $setData = '';
                foreach ($data['getallinventorywarehouse1'] as $key => $rec) {
                    if ($key == 0) {
                        $rowData = '';
                        foreach ($rec as $key => $value) {
                           
                                $key = '"' . $key . '"' . "\t";
                                $rowData .= $key;
                        }
                        $setData .= trim($rowData) . "\n";
                    }

                    $rowData = '';
                    foreach ($rec as $key => $value) {
                            $value = '"' . $value . '"' . "\t";
                            $rowData .= $value;
                    }
                    $setData .= trim($rowData) . "\n";
                }

                header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=warehouse_dailyoutstock_Report.xls");
                header("Pragma: no-cache");
                header("Expires: 0");
                echo $setData . "\n";
            } elseif ($download == 3) {
                $setData = '';
                foreach ($data['getdistributeinventory'] as $key => $rec) {
                    if ($key == 0) {
                        $rowData = '';
                        foreach ($rec as $key => $value) {
                           
                                $key = '"' . $key . '"' . "\t";
                                $rowData .= $key;
                        }
                        $setData .= trim($rowData) . "\n";
                    }

                    $rowData = '';
                    foreach ($rec as $key => $value) {
                            $value = '"' . $value . '"' . "\t";
                            $rowData .= $value;
                    }
                    $setData .= trim($rowData) . "\n";
                }

                header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=inventorymanagerdistribute_Report.xls");
                header("Pragma: no-cache");
                header("Expires: 0");
                echo $setData . "\n";
            }
            else {
                return view('loggedinuser/index.php', $data);
            }
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }
    
    
    public function warehousetransferreport()
    {
        if ($_SESSION['userdetails'] != null) {
            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();
            $inventoryModel = new InventoryModel();
            $data['page_name'] = 'Reports/warehousetransfer';
            $DateFrom = date_create_from_format("d/m/Y", $_GET['DateFrom']) != false ? date_format(date_create_from_format("d/m/Y", $_GET['DateFrom']), 'Y-m-d') : date('Y-m-d');
            $DateTo = date_create_from_format("d/m/Y", $_GET['DateTo']) != false ? date_format(date_create_from_format("d/m/Y", $_GET['DateTo']), 'Y-m-d') : date('Y-m-d');

            $data['getallinventorywarehouse'] = $inventoryModel->gettransfers($DateFrom);
             $download = (isset($_GET['download']) && $_GET['download'] != "") ? $_GET['download'] : NULL;
             
                  if ($download == 1) {
                $setData = '';
                foreach ($data['getallinventorywarehouse'] as $key => $rec) {
                    if ($key == 0) {
                        $rowData = '';
                        foreach ($rec as $key => $value) {
                           
                                $key = '"' . $key . '"' . "\t";
                                $rowData .= $key;
                        }
                        $setData .= trim($rowData) . "\n";
                    }

                    $rowData = '';
                    foreach ($rec as $key => $value) {
                            $value = '"' . $value . '"' . "\t";
                            $rowData .= $value;
                    }
                    $setData .= trim($rowData) . "\n";
                }

                header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=warehouse_dailyinstock_Report.xls");
                header("Pragma: no-cache");
                header("Expires: 0");
                echo $setData . "\n";
            } 
             elseif ($download == 2) {
                $setData = '';
                foreach ($data['getallinventorywarehouse1'] as $key => $rec) {
                    if ($key == 0) {
                        $rowData = '';
                        foreach ($rec as $key => $value) {
                           
                                $key = '"' . $key . '"' . "\t";
                                $rowData .= $key;
                        }
                        $setData .= trim($rowData) . "\n";
                    }

                    $rowData = '';
                    foreach ($rec as $key => $value) {
                            $value = '"' . $value . '"' . "\t";
                            $rowData .= $value;
                    }
                    $setData .= trim($rowData) . "\n";
                }

                header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=warehouse_dailyoutstock_Report.xls");
                header("Pragma: no-cache");
                header("Expires: 0");
                echo $setData . "\n";
            } elseif ($download == 3) {
                $setData = '';
                foreach ($data['getdistributeinventory'] as $key => $rec) {
                    if ($key == 0) {
                        $rowData = '';
                        foreach ($rec as $key => $value) {
                           
                                $key = '"' . $key . '"' . "\t";
                                $rowData .= $key;
                        }
                        $setData .= trim($rowData) . "\n";
                    }

                    $rowData = '';
                    foreach ($rec as $key => $value) {
                            $value = '"' . $value . '"' . "\t";
                            $rowData .= $value;
                    }
                    $setData .= trim($rowData) . "\n";
                }

                header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=inventorymanagerdistribute_Report.xls");
                header("Pragma: no-cache");
                header("Expires: 0");
                echo $setData . "\n";
            }
            else {
                return view('loggedinuser/index.php', $data);
            }
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    
    public function bulkTransfer()
    {
        if ($_SESSION['userdetails'] != null) {
             $db = db_connect();
            $nameArr = $_POST['productid'];
            $quantityArr  = $_POST['value'];
            $batchid = $_SESSION['activebatch'];
            $dispatch_id = uniqid();
            for ($i = 0; $i < count($nameArr); $i++) {
                $productid = explode("&", $nameArr[$i]);

                $data['product_id'] = $productid[0];
                $data['quantity'] = $quantityArr[$i];
                $data['available_quantity'] = $quantityArr[$i];
                $data['transferred_by'] = $_SESSION['userdetails']->userid;
                $data['dispatch_id'] = $dispatch_id;
                $data['branch_id'] = $_POST['receivedbybranch'];
                $data['batchid'] = $batchid;
                $inventoryModel = new InventoryModel();
                $inventoryModel->addInventory($data);
                
                 $total = $quantityArr[$i];
                    $product = $productid[0];
                    $user = $_SESSION['userdetails']->userid;
                    $querytol = $db->query("select * from inventorydetails where user_id='$user' and product_id='$product' and batchid='$batchid' order by `id` ASC");
                    $resulttol = $querytol->getResult();
                    foreach($resulttol as $resulttols)
                    {
                        $available = $resulttols->available_quantity;
                        $id = $resulttols->id;
                        if($total > 0){
                        if(($total-$available) >= 0)
                        {
                            $querytol = $db->query("update inventorydetails set available_quantity=0 where id='$id'");
                            $total = $total - $resulttols->available_quantity;
                        }
                        else{
                            $availble = abs($total-$available);
                            $querytol = $db->query("update inventorydetails set available_quantity='$availble' where id='$id'");
                            $total = $total - $availble;
                        }
                    }
                    
                    $proid = $nameArr[$i];
                    $userid = $_SESSION['userdetails']->userid;
                    $queryres = $db->query("select * from inventory where product_id='$proid' and user_id='$userid' and batchid='$batchid'");
                    $resultres = $queryres->getResult();
                    if (count($resultres) > 0) {
                        $invid = $resultres[0]->id;
                        $qty = $resultres[0]->quantity-$quantityArr[$i];
                    $query1 = $db->query("update inventory set quantity='$qty' where id=' $invid'");
                    }

                    }
            }

            return redirect()->to(base_url('Inventory/details'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function transferInventory()
    {
        if ($_SESSION['userdetails'] != null) {
            $db = db_connect();
            $nameArr = $_POST['productid'];
            $quantityArr  = $_POST['value'];
            $typeArr = $_POST['product_type_id'];
            $serialno = $_POST['serial'];
            $batchid = $_SESSION['activebatch'];
            $material_requisition_item_id = $_POST['material_requisition_item_id'];
            if($material_requisition_item_id[0] == '');
        {
            $material_requisition_item_id = NULL;
        }
            
            $dispatch_id = uniqid();
            for ($i = 0; $i < count($nameArr); $i++) {
                if($typeArr[$i]==1)
                {
                    foreach($serialno as $serial)
                    {
                        $queryres = $db->query("select * from inventorydetails where id='$serial' and batchid='$batchid'");
		                $resultres = $queryres->getResult();
                        $ser = $resultres[0]->product_serial;
                        $inventoryid = $resultres[0]->id;
                        $transferred_by = $resultres[0]->user_id;
                        $data['product_id'] = $nameArr[$i];
                        $data['branch_id'] = $_POST['receivedbybranch'];
                        $data['batchid'] = $_SESSION['activebatch'];
                        $data['quantity'] = 1;
                        $data['product_serial'] = $ser;
                        $data['available_quantity'] = 1;
                       // $data['material_requisition_item_id'] = $material_requisition_item_id[$i];
                        if ($material_requisition_item_id != NULL) {
                            $main['material_requisition_item_id'] = $material_requisition_item_id[$i];
                        }else
                        {
                            $main['material_requisition_item_id'] = NULL;
                        }
                       
                        $data['transferred_by'] = $transferred_by;
                        $data['dispatch_id'] = $dispatch_id;
                        $inventoryModel = new InventoryModel();
                        $inventoryModel->addInventory($data);
                        $query1 = $db->query("update inventorydetails set available_quantity=0 where id='$serial'");
                        $queryres = $db->query("select * from material_requisition_items where id='$material_requisition_item_id[$i]'");
		$resultres = $queryres->getResult();
        if (count($resultres) > 0) {
        $quantity = $resultres[0]->delivered_quantity;
        $approvedquantity = $resultres[0]->quantity;
        $delivered = $quantity + 1;
        $purchase_orderid = $resultres[0]->material_requisition_id;
        if($approvedquantity == $delivered)
        {
            $query1 = $db->query("update material_requisition_items set delivered_quantity='$delivered',material_requisition_item_status='delivered' where id='$material_requisition_item_id[$i]' ");
            $query1 = $db->query("update material_requisition set material_requisition_status='delivered' where id='$purchase_orderid'");
            
        }else{  
            $query1 = $db->query("update material_requisition_items set delivered_quantity='$delivered',material_requisition_item_status='partially delivered' where  id='$material_requisition_item_id[$i]' ");
            $query1 = $db->query("update material_requisition set material_requisition_status='partially delivered' where id='$purchase_orderid'");
        }
        $proid = $nameArr[$i];
        $userid = $_SESSION['userdetails']->userid;
        $queryres = $db->query("select * from inventory where product_id='$proid' and user_id='$userid' and batchid='$batchid'");
		$resultres = $queryres->getResult();
        if (count($resultres) > 0) {
            $invid = $resultres[0]->id;
            $qty = $resultres[0]->quantity-1;
        $query1 = $db->query("update inventory set quantity='$qty' where id=' $invid'");
        }

        }else
        {
             $proid = $nameArr[$i];
                    $userid = $_SESSION['userdetails']->userid;
                    $queryres = $db->query("select * from inventory where product_id='$proid' and user_id='$userid' and batchid='$batchid'");
                    $resultres = $queryres->getResult();
                    if (count($resultres) > 0) {
                        $invid = $resultres[0]->id;
                        $qty = $resultres[0]->quantity-1;
                    $query1 = $db->query("update inventory set quantity='$qty' where id=' $invid'");
                    }
        }
                    }
                }else
                {
                    $data['product_id'] = $nameArr[$i];
                    $data['branch_id'] = $_POST['receivedbybranch'];
                    $data['quantity'] = $quantityArr[$i];
                    $data['available_quantity'] = $quantityArr[$i];
                    $data['batchid'] = $batchid;
                   // $data['material_requisition_item_id'] = $material_requisition_item_id[$i];
                    if ($material_requisition_item_id != NULL) {
                        $main['material_requisition_item_id'] = $material_requisition_item_id[$i];
                    }else
                    {
                        $main['material_requisition_item_id'] = NULL;
                    }
                    $data['transferred_by'] = $_SESSION['userdetails']->userid;
                    $data['dispatch_id'] = $dispatch_id;
                    $inventoryModel = new InventoryModel();
                    $inventoryModel->addInventory($data);
                    $total = $quantityArr[$i];
                    $product = $nameArr[$i];
                    $user = $_SESSION['userdetails']->userid;
                    $querytol = $db->query("select * from inventorydetails where user_id='$user' and product_id='$product' and batchid='$batchid' order by `id` ASC");
                    $resulttol = $querytol->getResult();
                    foreach($resulttol as $resulttols)
                    {
                        $available = $resulttols->available_quantity;
                        $id = $resulttols->id;
                        if($total > 0){
                        if(($total-$available) >= 0)
                        {
                            $querytol = $db->query("update inventorydetails set available_quantity=0 where id='$id'");
                            $total = $total - $resulttols->available_quantity;
                        }
                        else{
                            $availble1 = abs($total-$available);
                            $querytol = $db->query("update inventorydetails set available_quantity='$availble1' where id='$id'");
                            $availblenew = $total-$available;
                            $total = $availblenew;
                        }
                    }
                   

                    }
                    $queryres = $db->query("select * from material_requisition_items where  id='$material_requisition_item_id[$i]'");
                    $resultres = $queryres->getResult();
                    
                    if (count($resultres) > 0) {
                    $quantity = $resultres[0]->delivered_quantity;
                    $approvedquantity = $resultres[0]->quantity;
                    $delivered = $quantity + $quantityArr[$i];
                    $purchase_orderid = $resultres[0]->material_requisition_id;
                    if($approvedquantity == $delivered)
                    {
                        
                        $query1 = $db->query("update material_requisition_items set delivered_quantity='$delivered',material_requisition_item_status='delivered' where id='$material_requisition_item_id[$i]' ");
                        $query1 = $db->query("update material_requisition set material_requisition_status='delivered' where id='$purchase_orderid'");
                    }else{  
                       
                        $query1 = $db->query("update material_requisition_items set delivered_quantity='$delivered',material_requisition_item_status='partially delivered' where id='$material_requisition_item_id[$i]'");
                        $query1 = $db->query("update material_requisition set material_requisition_status='partially delivered' where id='$purchase_orderid'");
                    }

                    $proid = $nameArr[$i];
                    $userid = $_SESSION['userdetails']->userid;
                    $queryres = $db->query("select * from inventory where product_id='$proid' and user_id='$userid' and batchid='$batchid'");
                    $resultres = $queryres->getResult();
                    if (count($resultres) > 0) {
                        $invid = $resultres[0]->id;
                        $qty = $resultres[0]->quantity-$quantityArr[$i];
                    $query1 = $db->query("update inventory set quantity='$qty' where id=' $invid'");
                    }
                    }    else
                    {
                         $proid = $nameArr[$i];
                    $userid = $_SESSION['userdetails']->userid;
                    $queryres = $db->query("select * from inventory where product_id='$proid' and user_id='$userid' and batchid='$batchid' ");
                    $resultres = $queryres->getResult();
                    if (count($resultres) > 0) {
                        $invid = $resultres[0]->id;
                        $qty = $resultres[0]->quantity-$quantityArr[$i];
                    $query1 = $db->query("update inventory set quantity='$qty' where id=' $invid'");
                    }
                    }
                }
            $originalTotal = $_POST['remainingtotal'];
            $remainingTotal = $data['available_quantity'];
           // $inventoryModel->updateRemainingItems($productid, $remainingTotal);
            }
            
            return redirect()->to(base_url('Inventory/details'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }
    
    
    public function returnInventory()
    {
        if ($_SESSION['userdetails'] != null) {
            $db = db_connect();
            $nameArr = $_POST['productid'];
            $quantityArr  = $_POST['value'];
            $typeArr = $_POST['product_type_id'];
            $serialno = $_POST['serial'];
            $batchid = $_SESSION['activebatch'];
            $material_requisition_item_id = $_POST['material_requisition_item_id'];
            if($material_requisition_item_id[0] == '');
        {
            $material_requisition_item_id = NULL;
        }
            
            $dispatch_id = uniqid();
            for ($i = 0; $i < count($nameArr); $i++) {
                if($typeArr[$i]==1)
                {
                    foreach($serialno as $serial)
                    {
                        $queryres = $db->query("select * from inventorydetails where id='$serial' and batchid='$batchid'");
		                $resultres = $queryres->getResult();
                        $ser = $resultres[0]->product_serial;
                        $inventoryid = $resultres[0]->id;
                        $transferred_by = $resultres[0]->user_id;
                        $data['product_id'] = $nameArr[$i];
                        $data['branch_id'] = $_POST['receivedbybranch'];
                        $data['batchid'] = $_SESSION['activebatch'];
                        $data['quantity'] = 1;
                        $data['product_serial'] = $ser;
                        $data['available_quantity'] = 1;
                       // $data['material_requisition_item_id'] = $material_requisition_item_id[$i];
                        if ($material_requisition_item_id != NULL) {
                            $main['material_requisition_item_id'] = $material_requisition_item_id[$i];
                        }else
                        {
                            $main['material_requisition_item_id'] = NULL;
                        }
                       
                        $data['transferred_by'] = $transferred_by;
                        $data['dispatch_id'] = $dispatch_id;
                        $inventoryModel = new InventoryModel();
                        $inventoryModel->addInventory($data);
                        $query1 = $db->query("update inventorydetails set available_quantity=0 where id='$serial'");
                        $queryres = $db->query("select * from material_requisition_items where id='$material_requisition_item_id[$i]'");
		$resultres = $queryres->getResult();
        if (count($resultres) > 0) {
        $quantity = $resultres[0]->delivered_quantity;
        $approvedquantity = $resultres[0]->quantity;
        $delivered = $quantity + 1;
        $purchase_orderid = $resultres[0]->material_requisition_id;
        if($approvedquantity == $delivered)
        {
            $query1 = $db->query("update material_requisition_items set delivered_quantity='$delivered',material_requisition_item_status='delivered' where id='$material_requisition_item_id[$i]' ");
            $query1 = $db->query("update material_requisition set material_requisition_status='delivered' where id='$purchase_orderid'");
            
        }else{  
            $query1 = $db->query("update material_requisition_items set delivered_quantity='$delivered',material_requisition_item_status='partially delivered' where  id='$material_requisition_item_id[$i]' ");
            $query1 = $db->query("update material_requisition set material_requisition_status='partially delivered' where id='$purchase_orderid'");
        }
        $proid = $nameArr[$i];
        $userid = $_SESSION['userdetails']->userid;
        $queryres = $db->query("select * from inventory where product_id='$proid' and user_id='$userid' and batchid='$batchid'");
		$resultres = $queryres->getResult();
        if (count($resultres) > 0) {
            $invid = $resultres[0]->id;
            $qty = $resultres[0]->quantity-1;
        $query1 = $db->query("update inventory set quantity='$qty' where id=' $invid'");
        }

        }else
        {
             $proid = $nameArr[$i];
                    $userid = $_SESSION['userdetails']->userid;
                    $queryres = $db->query("select * from inventory where product_id='$proid' and user_id='$userid' and batchid='$batchid'");
                    $resultres = $queryres->getResult();
                    if (count($resultres) > 0) {
                        $invid = $resultres[0]->id;
                        $qty = $resultres[0]->quantity-$quantityArr[$i];
                    $query1 = $db->query("update inventory set quantity='$qty' where id=' $invid'");
                    }
        }
                    }
                }else
                {
                    $data['product_id'] = $nameArr[$i];
                    $data['branch_id'] = NULL;
                    $data['quantity'] = $quantityArr[$i];
                    $data['available_quantity'] = $quantityArr[$i];
                    $data['batchid'] = $batchid;
                   // $data['material_requisition_item_id'] = $material_requisition_item_id[$i];
                    if ($material_requisition_item_id != NULL) {
                        $main['material_requisition_item_id'] = $material_requisition_item_id[$i];
                    }else
                    {
                        $main['material_requisition_item_id'] = NULL;
                    }
                    $data['transferred_by'] = $_SESSION['userdetails']->userid;
                    $data['dispatch_id'] = $dispatch_id;
                    $inventoryModel = new InventoryModel();
                    $inventoryModel->addInventory($data);
                    $total = $quantityArr[$i];
                    $product = $nameArr[$i];
                    $user = $_SESSION['userdetails']->userid;
                    $querytol = $db->query("select * from inventorydetails where user_id='$user' and product_id='$product' and batchid='$batchid' order by `id` ASC");
                    $resulttol = $querytol->getResult();
                    foreach($resulttol as $resulttols)
                    {
                        $available = $resulttols->available_quantity;
                        $id = $resulttols->id;
                        if($total > 0){
                        if(($total-$available) >= 0)
                        {
                            $querytol = $db->query("update inventorydetails set available_quantity=0 where id='$id'");
                            $total = $total - $resulttols->available_quantity;
                        }
                        else{
                            $availble1 = abs($total-$available);
                            $querytol = $db->query("update inventorydetails set available_quantity='$availble1' where id='$id'");
                            $availblenew = $total-$available;
                            $total = $availblenew;
                            
                        }
                     }
                    }
                    $queryres = $db->query("select * from material_requisition_items where  id='$material_requisition_item_id[$i]'");
                    $resultres = $queryres->getResult();
                    
                    if (count($resultres) > 0) {
                    $quantity = $resultres[0]->delivered_quantity;
                    $approvedquantity = $resultres[0]->quantity;
                    $delivered = $quantity + $quantityArr[$i];
                    $purchase_orderid = $resultres[0]->material_requisition_id;
                    if($approvedquantity == $delivered)
                    {
                        
                        $query1 = $db->query("update material_requisition_items set delivered_quantity='$delivered',material_requisition_item_status='delivered' where id='$material_requisition_item_id[$i]' ");
                        $query1 = $db->query("update material_requisition set material_requisition_status='delivered' where id='$purchase_orderid'");
                    }else{  
                       
                        $query1 = $db->query("update material_requisition_items set delivered_quantity='$delivered',material_requisition_item_status='partially delivered' where id='$material_requisition_item_id[$i]'");
                        $query1 = $db->query("update material_requisition set material_requisition_status='partially delivered' where id='$purchase_orderid'");
                    }

                    $proid = $nameArr[$i];
                    $userid = $_SESSION['userdetails']->userid;
                    $queryres = $db->query("select * from inventory where product_id='$proid' and user_id='$userid' and batchid='$batchid'");
                    $resultres = $queryres->getResult();
                    if (count($resultres) > 0) {
                        $invid = $resultres[0]->id;
                        $qty = $resultres[0]->quantity-$quantityArr[$i];
                    $query1 = $db->query("update inventory set quantity='$qty' where id=' $invid'");
                    }
                    }    else
                    {
                         $proid = $nameArr[$i];
                    $userid = $_SESSION['userdetails']->userid;
                    $queryres = $db->query("select * from inventory where product_id='$proid' and user_id='$userid' and batchid='$batchid' ");
                    $resultres = $queryres->getResult();
                    if (count($resultres) > 0) {
                        $invid = $resultres[0]->id;
                        $qty = $resultres[0]->quantity-$quantityArr[$i];
                    $query1 = $db->query("update inventory set quantity='$qty' where id=' $invid'");
                    }
                    }
                }
            $originalTotal = $_POST['remainingtotal'];
            $remainingTotal = $data['available_quantity'];
           // $inventoryModel->updateRemainingItems($productid, $remainingTotal);
            }
            
            return redirect()->to(base_url('Inventory/details'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function itemReceived()
    {
        if ($_SESSION['userdetails'] != null) {
            $id = $_POST['inventorydetailsid'];
            $receivedby = $_POST['receivedby'];

            $inventoryModel = new InventoryModel();
            $inventoryModel->updateisReceived($id, $receivedby);

            $db = db_connect();

            $query1 = $db->query("select * from inventorydetails where id='$id'");
		$results = $query1->getResult();
        $productid = $results[0]->product_id;
        $batchid = $_SESSION['activebatch'];
		$query2 = $db->query("select * from inventory where user_id='$receivedby' and product_id='$productid' and batchid='$batchid'");
		$results1 = $query2->getResult();
        $quantityArr = $results[0]->quantity;
		if (count($results1) > 0) {
            $quantity = $results1[0]->quantity;
            $updatequantity = $quantity + $results[0]->quantity;
            $quantityArr = $results[0]->quantity;
			$query1 = $db->query("update inventory set quantity='$updatequantity' where product_id='$productid' and user_id='$receivedby' and batchid='$batchid'");

		} else {
			$query1 = $db->query("insert into inventory set user_id='$receivedby',product_id='$productid',quantity='$quantityArr',batchid='$batchid'");
		}

        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }
    
    public function returnitemReceived()
    {
        if ($_SESSION['userdetails'] != null) {
            $id = $_POST['inventorydetailsid'];
            $receivedby = $_POST['receivedby'];

            $inventoryModel = new InventoryModel();
            $inventoryModel->updateisReceived($id, $receivedby);

            $db = db_connect();

            $query1 = $db->query("select * from inventorydetails where id='$id'");
		$results = $query1->getResult();
        $productid = $results[0]->product_id;
        $batchid = $_SESSION['activebatch'];
		$query2 = $db->query("select * from inventory where user_id='$receivedby' and product_id='$productid' and batchid='$batchid'");
		$results1 = $query2->getResult();
        $quantityArr = $results[0]->quantity;
		if (count($results1) > 0) {
            $quantity = $results1[0]->quantity;
            $updatequantity = $quantity + $results[0]->quantity;
            $quantityArr = $results[0]->quantity;
			$query1 = $db->query("update inventory set quantity='$updatequantity' where product_id='$productid' and user_id='$receivedby' and batchid='$batchid'");

		} else {
			$query1 = $db->query("insert into inventory set user_id='$receivedby',product_id='$productid',quantity='$quantityArr',batchid='$batchid'");
		}

        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function print_InventoryReceipt()
    {
        if ($_SESSION['userdetails'] != null) {
            $userid = $_GET['userid'];
            $inventoryDetailsId = $_GET['inventorydetailsid'];
            $givenby = $_SESSION['userdetails']->userid;

            $inventoryModel = new InventoryModel();
            $data['inventoryDetails'] = $inventoryModel->getinventorydetailprint($inventoryDetailsId,$userid);
            $usersModel = new UsersModel();
            $data['userDetails'] = $usersModel->getStudentDetails($userid);
            $data['employeeDetails'] = $usersModel->getAllEmployeeDetailsById($givenby);

            return view('loggedinuser/Print/print_inventoryreceipt.php', $data);
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }
    
    public function print_InventoryReceiptstudent()
    {
        if ($_SESSION['userdetails'] != null) {
            $userid = $_GET['userid'];
            $inventoryDetailsId = $_GET['inventorydetailsid'];
            $givenby = $_SESSION['userdetails']->userid;

            $inventoryModel = new InventoryModel();
        //    $data['inventoryDetails'] = $inventoryModel->getinventorydetail($inventoryDetailsId);
            $data['inventoryDetails'] = $inventoryModel->get_StudentInventory($userid);
            $usersModel = new UsersModel();
            $data['userDetails'] = $usersModel->getStudentDetails($userid);
            $data['employeeDetails'] = $usersModel->getAllEmployeeDetailsById($givenby);

            return view('loggedinuser/Print/print_inventoryreceipt.php', $data);
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function print_InventoryReceipt1()
    {
        if ($_SESSION['userdetails'] != null) {
            $userid = $_GET['userid'];
            $inventoryDetailsId = $_GET['inventorydetailsid'];
            $givenby = $_SESSION['userdetails']->userid;

            $inventoryModel = new InventoryModel();
            $data['inventoryDetails'] = $inventoryModel->getinventorydetails($inventoryDetailsId);
            $usersModel = new UsersModel();
            $reservationModel = new ReservationModel();
            $data['userDetails'] = $reservationModel->getReservationDetails($userid);
            $data['employeeDetails'] = $usersModel->getAllEmployeeDetailsById($givenby);

            return view('loggedinuser/Print/print_inventoryreceipt1.php', $data);
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }
    public function materialrequisitionforms($formgroupid = null)
    {
        if ($_SESSION['userdetails'] == null) {
            return redirect()->to(base_url());
        } else {
                $userid =  $_SESSION['userdetails']->userid;
            if ($formgroupid != '' || $formgroupid != null) {
                $data['page_name'] = 'Inventory/materialRequisitionlists';
                $userid = $_GET['userId'];
                $batchid = $_GET['batchid'];
                $inventoryModel = new InventoryModel();
                $data['forms'] = $inventoryModel->getApprovedMaterialForm($formgroupid);
                return view('loggedinuser/index.php', $data);
            } else {
                $userid =  $_SESSION['userdetails']->userid;
                $inventoryModel = new InventoryModel();
                $data['forms'] = $inventoryModel->getApprovedMaterialForms($userid);
                $data['page_name'] = 'Inventory/materialRequisitionlist';
                $userid = $_GET['userId'];
                $batchid = $_GET['batchid'];
                $helperModel = new HelperModel();
                $data['lookups'] = $helperModel->get_lookups();
                return view('loggedinuser/index.php', $data);
            }
        }
    }
    public function purchaseorderlist($formgroupid = null)
    {
        if ($_SESSION['userdetails'] == null) {
            return redirect()->to(base_url());
        } else {

            if ($formgroupid != '' || $formgroupid != null) {
                $data['page_name'] = 'Inventory/purchaseorderlist';
                $userid = $_GET['userId'];
                $batchid = $_GET['batchid'];
                $inventoryModel = new InventoryModel();
                $data['purchaseorders'] = $inventoryModel->getpruchaseorders($formgroupid);
                return view('loggedinuser/index.php', $data);
            } else {
            $data['page_name'] = 'Inventory/purchaseorder';
            $userid = $_GET['userId'];
            $inventoryModel = new InventoryModel();
            $data['purchaseorder'] = $inventoryModel->getpruchaseorder();
            return view('loggedinuser/index.php', $data);
            }
        }
    }
    public function createpurchaseorder()
    {
        if ($_SESSION['userdetails'] == null) {
            return redirect()->to(base_url());
        } else {
            $data['page_name'] = 'Inventory/createpurchaseorder';
            $inventoryModel = new InventoryModel();
            $data['vendors'] = $inventoryModel->getvendors();
            if($_GET['type']==1)
            {
                $data['getmaterialrequest'] = $inventoryModel->getMaterialRequest();
            }
            
                $data['getmaterialrequestitems'] = $inventoryModel->getMaterialRequestitems($_GET['materialid']);
               
                
            $data['products'] = $inventoryModel->getproducts();

            return view('loggedinuser/index.php', $data);
        }
    }
    public function savepurchaseorder()
    {
        $type = $_POST['type'];
        
        $nameArr = $_POST['productid'];
        $quantityArr  = $_POST['quantity'];
        $commentArr  = $_POST['comment'];
        $material_requisition_item_id = $_POST['material_requisition_item_ids'];
        if($material_requisition_item_id[0] == '');
        {
            $material_requisition_item_id = NULL;
        }
        $material['created_by'] = $_POST['user_id'];
        
        $db = db_connect();
        $builder = $db->table('purchase_order');
        $builder->insert($material);
        $materialid = $db->insertID();
        for ($i = 0; $i < count($nameArr); $i++) {
            $main['purchase_order_id'] = $materialid;
            $main['product_id'] = $nameArr[$i];
            $main['quantity'] = $quantityArr[$i];
            $main['approved_quantity'] = $quantityArr[$i];
            $main['comment'] = $commentArr[$i];
            $main['vendor_id'] = $_POST['vendor'];
            if ($material_requisition_item_id != NULL) {
                $main['material_requisition_item_ids'] = $material_requisition_item_id[$i];
            }else
            {
                $main['material_requisition_item_ids'] = NULL;
            }
            $db = db_connect();
            $builder = $db->table('purchase_order_items');
            $builder->insert($main);
            if(!empty($material_requisition_item_id)){
            foreach($material_requisition_item_id as $ids)
            {
                $db = db_connect();
                $query1 = $db->query("update material_requisition_items set is_pocreated=1 where id IN ({$ids})");
            }
        }
        }
    
        return redirect()->to(base_url("Forms/poforms"));
    }
    public function createinventory()
    {
        if ($_SESSION['userdetails'] == null) {
            return redirect()->to(base_url());
        } else {
            $data['page_name'] = 'Inventory/createinventory';
            $inventoryModel = new InventoryModel();
            $data['vendors'] = $inventoryModel->getvendors();
            if($_GET['type']==1)
            {
                $data['getpo'] = $inventoryModel->getPurchaseorder();
            }
            $data['getproductorderitems'] = $inventoryModel->getPurchaseorderitems($_GET['pid']);
            $data['products'] = $inventoryModel->getproducts();
            
            return view('loggedinuser/index.php', $data);
        }
    }
    public function minquantity()
    {
        $nameArr = $_POST['productid'];
        $userid =  $_SESSION['userdetails']->userid;
        $db = db_connect();
        $query1 = $db->query("SELECT MIN(quantity) as qty FROM inventory WHERE product_id in({$nameArr}) AND user_id='$userid'");
		$results = $query1->getResult();
		return $results[0]->qty;
    }
    public function productids()
    {
        $nameArr = $_POST['productid'];
        $db = db_connect();
        $query1 = $db->query("SELECT GROUP_CONCAT(product.name) as name FROM product WHERE id in({$nameArr})");
		$results = $query1->getResult();
		return $results[0]->name;
    }
    public function addInventory()
    {
        $type = $_POST['type'];
        $batchid = $_SESSION['activebatch'];
        if($type == 1){
        $nameArr = $_POST['productid'];
        $quantityArr  = $_POST['quantity'];
        $purchase_order_item_id = $_POST['purchase_order_item_id'];
        $material_requisition_item_id = $_POST['material_requisition_item_id'];
        if($material_requisition_item_id[0] == '');
        {
            $material_requisition_item_id = NULL;
        }
      
        if (!empty($_POST['serial'])) {
            $serial = $_POST['serial'];
        }
        for ($i = 0; $i < count($nameArr); $i++) {
            $main['user_id'] = $_POST['user_id'];
            $main['product_id'] = $nameArr[$i];
            $main['quantity'] = $quantityArr[$i];
            $main['available_quantity'] = $quantityArr[$i];
            $main['batchid'] = $_SESSION['activebatch'];
            if ($material_requisition_item_id != NULL) {
                $main['material_requisition_item_id'] = $material_requisition_item_id[$i];
            }else
            {
                $main['material_requisition_item_id'] = NULL;
            }
            if ($purchase_order_item_id !=NULL) {
                $main['purchase_order_item_id'] = $purchase_order_item_id[$i];
            }
            $main['vendor_id'] = $_POST['vendor'];
            $main['receipt'] = $_POST['receipt'];
            if (!empty($_POST['serial'])) {
                $main['product_serial'] = $serial[$i];
            }
            //$main['comment'] = $commentArr[$i];
            $db = db_connect();
            $builder = $db->table('inventorydetails');
            $builder->insert($main);
            $userid = $_POST['user_id'];
            $productid= $nameArr[$i];

            $db = db_connect();
		$query1 = $db->query("select * from inventory where user_id='$userid' and product_id='$productid'");
		$results = $query1->getResult();
		if (count($results) > 0) {
            $quantity = $results[0]->quantity;
            $updatequantity = $quantity + $quantityArr[$i];
			$query1 = $db->query("update inventory set quantity='$updatequantity' where product_id='$productid' and user_id='$userid'");

		} else {
			$query1 = $db->query("insert into inventory set user_id='$userid',product_id='$productid',quantity='$quantityArr[$i]'");
		}
        $queryres = $db->query("select * from purchase_order_items where product_id='$productid' and id='$purchase_order_item_id[$i]'");
		$resultres = $queryres->getResult();
        if (count($resultres) > 0) {
        $quantity = $resultres[0]->delivered_quantity;
        $approvedquantity = $resultres[0]->quantity;
        $delivered = $quantity + $quantityArr[$i];
        $purchase_orderid = $resultres[0]->purchase_order_id;
        if($approvedquantity == $delivered)
        {
            $query1 = $db->query("update purchase_order_items set delivered_quantity='$delivered',purchase_order_item_status='delivered' where product_id='$productid' and id='$purchase_order_item_id[$i]' ");
            $query1 = $db->query("update purchase_order set purchase_order_status='delivered' where id='$purchase_orderid'");
        }else{  
            $query1 = $db->query("update purchase_order_items set delivered_quantity='$delivered',purchase_order_item_status='partially delivered' where product_id='$productid' and id='$purchase_order_item_id[$i]' ");
            $query1 = $db->query("update purchase_order set purchase_order_status='partially delivered' where id='$purchase_orderid'");
        }
        }    
    }
    }
    else
    {
        $db = db_connect();
        $nameArr = $_POST['productid'];
        $quantityArr  = $_POST['quantity'];

        if (!empty($_POST['serial'])) {
            $serial = $_POST['serial'];
        }
        for ($i = 0; $i < count($nameArr); $i++) {
            $main['user_id'] = $_POST['user_id'];
            $main['product_id'] = $nameArr[$i];
            $queryres = $db->query("select * from product where id='$nameArr[$i]'");
            $resultres1 = $queryres->getResult();
            if($resultres1[0]->product_type_id ==1)
            {
                    
            $main['quantity'] = 1;
            $main['available_quantity'] = 1;
            $main['vendor_id'] = $_POST['vendor'];
            $main['receipt'] = $_POST['receipt'];
            $main['product_serial'] =  $serial[$i];
            $main['batchid'] = $_SESSION['activebatch'];
            //$main['comment'] = $commentArr[$i];
            $db = db_connect();
            $builder = $db->table('inventorydetails');
            $builder->insert($main);
            $userid = $_POST['user_id'];
            $productid= $nameArr[$i];
            $batchid = $_SESSION['activebatch'];
            $db = db_connect();
		$query1 = $db->query("select * from inventory where user_id='$userid' and product_id='$productid' and batchid='$batchid'");
		$results = $query1->getResult();
		if (count($results) > 0) {
            $quantity = $results[0]->quantity;
            $updatequantity = $quantity + 1;
			$query1 = $db->query("update inventory set quantity='$updatequantity' where product_id='$productid' and user_id='$userid' and batchid='$batchid'");

		} else {
			$query1 = $db->query("insert into inventory set user_id='$userid',product_id='$productid',quantity=1,batchid='$batchid'");
		}
        $queryres = $db->query("select * from purchase_order_items where product_id='$productid' and id='$purchase_order_item_id[$i]'");
		$resultres = $queryres->getResult();
        if (count($resultres) > 0) {
        $quantity = $resultres[0]->delivered_quantity;
        $approvedquantity = $resultres[0]->quantity;
        $delivered = $quantity + 1;
        $purchase_orderid = $resultres[0]->purchase_order_id;
        if($approvedquantity == $delivered)
        {
            $query1 = $db->query("update purchase_order_items set delivered_quantity='$delivered',purchase_order_item_status='delivered' where product_id='$productid' and id='$purchase_order_item_id[$i]' ");
            $query1 = $db->query("update purchase_order set purchase_order_status='delivered' where id='$purchase_orderid'");
        }else{  
            $query1 = $db->query("update purchase_order_items set delivered_quantity='$delivered',purchase_order_item_status='partially delivered' where product_id='$productid' and id='$purchase_order_item_id[$i]' ");
            $query1 = $db->query("update purchase_order set purchase_order_status='partially delivered' where id='$purchase_orderid'");
        }
        }
            }
            else
            {
            $main['quantity'] = $quantityArr[$i];
            $main['available_quantity'] = $quantityArr[$i];
            $main['vendor_id'] = $_POST['vendor'];
            $main['receipt'] = $_POST['receipt'];
            $main['product_serial'] = $serial[$i];
            $main['batchid'] = $_SESSION['activebatch'];
            //$main['comment'] = $commentArr[$i];
            $db = db_connect();
            $builder = $db->table('inventorydetails');
            $builder->insert($main);
            $userid = $_POST['user_id'];
            $productid= $nameArr[$i];
            $batchid = $_SESSION['activebatch'];
            $db = db_connect();
		    $query1 = $db->query("select * from inventory where user_id='$userid' and product_id='$productid' and batchid='$batchid'");
		    $results = $query1->getResult();
		if (count($results) > 0) {
            $quantity = $results[0]->quantity;
            $updatequantity = $quantity + $quantityArr[$i];
			$query1 = $db->query("update inventory set quantity='$updatequantity' where product_id='$productid' and user_id='$userid' and batchid='$batchid'");

		} else {
			$query1 = $db->query("insert into inventory set user_id='$userid',product_id='$productid',quantity='$quantityArr[$i]',batchid='$batchid'");
		}
        $queryres = $db->query("select * from purchase_order_items where product_id='$productid' and id='$purchase_order_item_id[$i]'");
		$resultres = $queryres->getResult();
        if (count($resultres) > 0) {
        $quantity = $resultres[0]->delivered_quantity;
        $approvedquantity = $resultres[0]->quantity;
        $delivered = $quantity + $quantityArr[$i];
        $purchase_orderid = $resultres[0]->purchase_order_id;
        if($approvedquantity == $delivered)
        {
            $query1 = $db->query("update purchase_order_items set delivered_quantity='$delivered',purchase_order_item_status='delivered' where product_id='$productid' and id='$purchase_order_item_id[$i]' ");
            $query1 = $db->query("update purchase_order set purchase_order_status='delivered' where id='$purchase_orderid'");
        }else{  
            $query1 = $db->query("update purchase_order_items set delivered_quantity='$delivered',purchase_order_item_status='partially delivered' where product_id='$productid' and id='$purchase_order_item_id[$i]' ");
            $query1 = $db->query("update purchase_order set purchase_order_status='partially delivered' where id='$purchase_orderid'");
        }
        }    
        if($resultres1[0]->product_ids !="")
        {
            $idss =array($resultres1[0]->product_ids);
            $var = explode(',', $idss[0]);
            foreach($var as $ss){
                $user = $_SESSION['userdetails']->userid;
            $query1 = $db->query("update inventory set quantity= quantity - '$quantityArr[$i]' where  user_id='$user' and product_id = '$ss' and batchid='$batchid' ");
              $total = $quantityArr[$i];
                    $product = $ss;
                    $user = $_SESSION['userdetails']->userid;
                    $querytol = $db->query("select * from inventorydetails where user_id='$user' and product_id='$product' and batchid='$batchid' order by `id` ASC");
                    $resulttol = $querytol->getResult();
                    foreach($resulttol as $resulttols)
                    {
                        $available = $resulttols->available_quantity;
                        $id = $resulttols->id;
                        if($total > 0){
                        if(($total-$available) >= 0)
                        {
                            $querytol = $db->query("update inventorydetails set available_quantity=0 where id='$id'");
                            $total = $total - $resulttols->available_quantity;
                        }
                        else{
                            $availble = abs($total-$available);
                            $querytol = $db->query("update inventorydetails set available_quantity='$availble' where id='$id'");
                            $total = $total - $availble;
                        }
                    }

                    }
                    
            }
        }
        
    }
}
    }
        return redirect()->to(base_url("inventory/details"));
    }
    public function addInventorysample()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['productid'] = $_POST['productid'];
            $data['originaltotal'] = $_POST['value'];
            $data['remainingtotal'] = $_POST['value'];
            $data['receivedfrom'] = 0;
            $data['receivedby'] = $_SESSION['userdetails']->userid;
            $data['receiveddate'] = date('Y-m-d');
            $data['isreceived'] = 1;

            $inventoryModel = new InventoryModel();
            $inventoryModel->addInventory($data);

            return redirect()->to(base_url('Inventory/details'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }
    
    
    public function manufacturers()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Inventory/manufacturers';

            $manufacturerModel = new ManufacturerModel();
            $data['manufacturers'] = $manufacturerModel->getManufacturers();

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function addmanufacturer()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['name'] = $_POST['manufacturername'];

            $manufacturerModel = new ManufacturerModel();
            $manufacturerModel->addmanufacturer($data);

            return redirect()->to(base_url('Inventory/manufacturers'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function updatemanufacturer()
    {
        if ($_SESSION['userdetails'] != null) {
            $manufacturerid = $_POST['manufacturerid'];
            $data['name'] = $_POST['manufacturername'];

            $manufacturerModel = new ManufacturerModel();
            $manufacturerModel->update_manufacturer($manufacturerid, $data);

            return redirect()->to(base_url('Inventory/manufacturers'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function deletemanufacturer()
    {
        if ($_SESSION['userdetails'] != null) {
            $id = $_GET['manufacturerid'];
            $manufacturerModel = new ManufacturerModel();
            $manufacturerModel->deletemanufacturer($id);

            return redirect()->to(base_url('Inventory/manufacturers'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function product_specifications()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Inventory/productSpecification';

            $productSpecificationModel = new ProductSpecificationModel();
            $data['product_specifications'] = $productSpecificationModel->get_product_specifications();

            $inventoryModel = new InventoryModel();
            $data['categories'] = $inventoryModel->getproductcategorys();

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function add_product_specification()
    {
        if ($_SESSION['userdetails'] != null) {
            
            $data['name'] = $_POST['name'];
            $data['category_id'] = $_POST['category_id'];

            $productSpecificationModel = new ProductSpecificationModel();
            $productSpecificationModel->add_product_specification($data);

            return redirect()->to(base_url('Inventory/product_specifications'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function update_product_specification()
    {
        if ($_SESSION['userdetails'] != null) {
            $product_specification_id = $_POST['product_specification_id'];
            $data['name'] = $_POST['name'];
            $data['category_id'] = $_POST['category_id'];

            $productSpecificationModel = new ProductSpecificationModel();
            $productSpecificationModel->update_product_specification($product_specification_id, $data);

            return redirect()->to(base_url('Inventory/product_specifications'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function delete_product_specification()
    {
        if ($_SESSION['userdetails'] != null) {
            $id = $_GET['product_specification_id'];

            $productSpecificationModel = new ProductSpecificationModel();
            $productSpecificationModel->delete_product_specification($id);

            return redirect()->to(base_url('Inventory/product_specifications'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function purchase_invoices()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Inventory/purchaseInvoice';

            $purchaseInvoiceModel = new PurchaseInvoiceModel();
            $data['purchase_invoices'] = $purchaseInvoiceModel->get_purchase_invoices();

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function create_purchase_invoice()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Inventory/createPurchaseInvoice';

            $vendorModel = new InventoryModel();
            $data['vendors'] = $vendorModel->getvendors();

            $warehouseModel = new WarehouseModel();
            $data['warehouses'] = $warehouseModel->get_warehouses();

                return view('loggedinuser/index.php', $data);
            } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function purchase_invoice_details($id)
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Inventory/detailsPurchaseInvoice';

            $db = db_connect();
            $query = $db->query('SELECT purchase_invoices.*, warehouses.name AS warehouse_name, vendor.name AS vendor_name FROM purchase_invoices JOIN warehouses ON purchase_invoices.warehouse_id = warehouses.id JOIN vendor ON purchase_invoices.vendor_id = vendor.id WHERE purchase_invoices.id = '.$id.';');        
            $data['purchase_invoice'] = $query->getRow();

            $db = db_connect();
            $query = $db->query('SELECT purchase_invoice_items.*, manufacturers.name AS manufacturer_name, product.name AS product_name FROM purchase_invoice_items JOIN manufacturers ON purchase_invoice_items.manufacturer_id = manufacturers.id JOIN product ON purchase_invoice_items.product_id = product.id WHERE purchase_invoice_items.purchase_invoice_id = '.$id.';');        
            $data['purchase_invoice_items'] = $query->getResult();

            $db = db_connect();
            $query = $db->query('SELECT SUM(purchase_invoice_items.total) AS total_amount FROM purchase_invoice_items WHERE purchase_invoice_id = '.$id.';');        
            $data['purchase_invoice_total'] = $query->getRow();
            
            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function update_purchase_invoice()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Inventory/updatePurchaseInvoice';

            $vendorModel = new InventoryModel();
            $data['vendors'] = $vendorModel->getvendors();

            $warehouseModel = new WarehouseModel();
            $data['warehouses'] = $warehouseModel->get_warehouses();

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function add_purchase_invoice()
    {
        if ($_SESSION['userdetails'] != null) {

            $data = [];
            $data['invoice_date'] = $_POST['invoice_date'];
            $data['invoice_no'] = $_POST['invoice_no'];
            $data['vendor_id'] = $_POST['vendor_id'];
            $data['warehouse_id'] = $_POST['warehouse_id'];
            
            $purchaseInvoiceModel = new PurchaseInvoiceModel();
            $purchaseInvoiceId = $purchaseInvoiceModel->add_purchase_invoice($data);

            foreach ($_POST['manufacturer_id'] as $key => $value) {
                $purchaseInvoiceItem = new PurchaseInvoiceItemModel();
                $purchaseInvoiceItem->add_purchase_invoice_item([
                    'purchase_invoice_id' => $purchaseInvoiceId,
                    'manufacturer_id' => $_POST['manufacturer_id'][$key],
                    'product_id' => $_POST['product_id'][$key],
                    'quantity' => $_POST['quantity'][$key],
                    'price' => $_POST['price'][$key],
                    'gst' => $_POST['gst'][$key],
                    'total' => $_POST['total'][$key],
                ]);
            }

            return redirect()->to(base_url('Inventory/purchase_invoices'));

        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

}
