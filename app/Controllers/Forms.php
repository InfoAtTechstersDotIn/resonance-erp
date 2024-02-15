<?php

namespace App\Controllers;

use App\Models\FormsModel;
use App\Models\HelperModel;
use App\Models\PaymentsModel;
use App\Models\InventoryModel;
use App\Models\UsersModel;
use App\Models\WalletModel;

class Forms extends BaseController
{
    public $session;
    public function __construct()
    {
        $session = session();
    }

    public function discountApproval()
    {
        if ($_SESSION['userdetails'] == null) {
            return redirect()->to(base_url());
        } else {
            $data['page_name'] = 'Forms/discountApproval';
            $userid = $_GET['userId'];

            $usersModel = new UsersModel();
            $paymentsModel = new PaymentsModel();
             $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();
            $data['Employees'] = $usersModel->getAllEmployeeDetails();
            $data['studentDetails'] = $usersModel->getStudentDetails($userid, $_SESSION['activebatch']);
            $data['feesDetails'] = $paymentsModel->getInvoiceDetails($userid);

            return view('loggedinuser/index.php', $data);
        }
    }

    public function saveDiscountApproval()
    {
        if ($_SESSION['userdetails'] == null) {
            return redirect()->to(base_url());
        } else {
            $main['user_id'] = $_POST['user_id'];
            $main['batchid'] = $_POST['batchid'];
            $data['discountid'] = $_POST['discountid'];
            $data['Amount'] = $_POST['amount'];
            $data['InvoiceId'] = $_POST['InvoiceId'];
            $data['additionaldetails'] = $_POST['additionaldetails'];
            $main['data'] = json_encode($data);
            $main['form_type'] = "discountApproval";
            $main['status'] = "created";
            $main['created_by'] = $_SESSION['userdetails']->userid;
            $branchid = $_POST['branchid'];
            $formsModel = new FormsModel();
            $nextdiscountid = $formsModel->getdiscountidnew($branchid);
            $disid = $nextdiscountid->branchcode.'-'.$nextdiscountid->discountid;
            $main['discount_id'] = $disid;
            $db = db_connect();
    
            $builder = $db->table('form_requests');
            $builder->insert($main);
            $formsModel->set_getdiscountid($branchid);
            return redirect()->to(base_url("users/studentdetails?id=" . $main['user_id']));
        }
    }

    public function refundApproval()
    {
        if ($_SESSION['userdetails'] == null) {
            return redirect()->to(base_url());
        } else {
            $data['page_name'] = 'Forms/refundApproval';
            $userid = $_GET['userId'];
            $batchid = $_GET['batchid'];
            $usersModel = new UsersModel();
            $paymentsModel = new PaymentsModel();
            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();
            $data['studentDetails'] = $usersModel->getStudentDetails($userid,$batchid);
            $data['feesDetails'] = $paymentsModel->getInvoiceDetails($userid);

            return view('loggedinuser/index.php', $data);
        }
    }
    public function branchtransfer()
    {
        if ($_SESSION['userdetails'] == null) {
            return redirect()->to(base_url());
        } else {
            $data['page_name'] = 'Forms/branchtransfer';
            $userid = $_GET['userId'];
            $batchid = $_GET['batchid'];
            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();
            $usersModel = new UsersModel();
            $paymentsModel = new PaymentsModel();

            $data['studentDetails'] = $usersModel->getStudentDetails($userid, $batchid);
            $data['feesDetails'] = $paymentsModel->getInvoiceDetails($userid);
            $data['branches'] = $usersModel->getbranches();

            return view('loggedinuser/index.php', $data);
        }
    }
    public function outpass()
    {
        if ($_SESSION['userdetails'] == null) {
            return redirect()->to(base_url());
        } else {
            $data['page_name'] = 'Forms/studentoutpass';
            $userid = $_GET['userId'];
            $batchid = $_GET['batchid'];
            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();
            $usersModel = new UsersModel();
            $paymentsModel = new PaymentsModel();

            $data['studentDetails'] = $usersModel->getStudentDetails($userid, $batchid);
            $data['feesDetails'] = $paymentsModel->getInvoiceDetails($userid);

            return view('loggedinuser/index.php', $data);
        }
    }
    public function materialrequisition()
    {
        if ($_SESSION['userdetails'] == null) {
            return redirect()->to(base_url());
        } else {
            $data['page_name'] = 'Forms/materialRequisition';
            $userid = $_GET['userId'];
            $batchid = $_GET['batchid'];
            $inventoryModel = new InventoryModel();
            $data['products'] = $inventoryModel->getproducts();
            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            return view('loggedinuser/index.php', $data);
        }
    }

    public function materialrequisitionforms($formgroupid = null)
    {
        if ($_SESSION['userdetails'] == null) {
            return redirect()->to(base_url());
        } else {
            $userid =  $_SESSION['userdetails']->userid;
            if ($formgroupid != '' || $formgroupid != null) {
                $data['page_name'] = 'Forms/materialRequisitionlists';
                $userid = $_GET['userId'];
                $batchid = $_GET['batchid'];
                $formsModel = new FormsModel();

                $data['forms'] = $formsModel->getPendingMaterialForm($formgroupid);

                 
                return view('loggedinuser/index.php', $data);
            } else {
                $userid =  $_SESSION['userdetails']->userid;
                $formsModel = new FormsModel();
                $data['forms'] = $formsModel->getPendingMaterialForms($userid);
                $data['page_name'] = 'Forms/materialRequisitionlist';
                $userid = $_GET['userId'];
                $batchid = $_GET['batchid'];
                $helperModel = new HelperModel();
                $data['lookups'] = $helperModel->get_lookups();
                return view('loggedinuser/index.php', $data);
            }
        }
    }

    public function poforms($formgroupid = null)
    {
        if ($_SESSION['userdetails'] == null) {
            return redirect()->to(base_url());
        } else {
            $userid =  $_SESSION['userdetails']->userid;
            if ($formgroupid != '' || $formgroupid != null) {
                $data['page_name'] = 'Forms/polists';
                $userid = $_GET['userId'];
                $batchid = $_GET['batchid'];
                $formsModel = new FormsModel();

                $data['forms'] = $formsModel->getPendingPoForm($formgroupid);

                 
                return view('loggedinuser/index.php', $data);
            } else {
                $userid =  $_SESSION['userdetails']->userid;
                $formsModel = new FormsModel();
                $data['forms'] = $formsModel->getPendingPoForms($userid);
                $data['page_name'] = 'Forms/polist';
                $userid = $_GET['userId'];
                $batchid = $_GET['batchid'];
                $helperModel = new HelperModel();
                $data['lookups'] = $helperModel->get_lookups();
                return view('loggedinuser/index.php', $data);
            }
        }
    }

    public function saveRefundApproval()
    {
        $main['user_id'] = $_POST['user_id'];
        $data['BooksReceived'] = $_POST['booksReceived'];
        $data['MaterialReceived'] = $_POST['materialReceived'];
        $data['BankName'] = $_POST['bankname'];
        $data['Branch'] = $_POST['branch'];
        $data['IFSC'] = $_POST['ifsc'];
        $data['Ac/No'] = $_POST['acno'];
        $data['DaysInHostel'] = $_POST['daysStayedInHostel'];
        $data['RefundAmount'] = 0;
        $data['RefundReason'] = $_POST['refundReason'];
        $main['data'] = json_encode($data);
        $main['form_type'] = "RefundApproval";
        $main['status'] = "created";
        $main['created_by'] = $_SESSION['userdetails']->userid;

        $db = db_connect();

        $builder = $db->table('form_requests');
        $builder->insert($main);

        return redirect()->to(base_url("users/studentdetails?id=" . $main['user_id']));
    }

    public function savebranchtransfer()
    {
        $main['user_id'] = $_POST['user_id'];

        $data['Branchid'] = $_POST['branchid'];
        $data['Inventory'] = $_POST['inventory'];

        $data['DaysStayedInHostel'] = $_POST['daysStayedInHostel'];
        $data['fee'] = $_POST['fee'];
        $data['AdmissionType'] = $_POST['admissionid'];
        $data['TransferReason'] = $_POST['transferReason'];
        $data['ReportingDate'] = $_POST['reporting'];
        $data['TransferDate'] = $_POST['transfer'];
        $main['data'] = json_encode($data);
        $main['form_type'] = "BranchTransfer";
        $main['status'] = "created";
        $main['created_by'] = $_SESSION['userdetails']->userid;

        $db = db_connect();

        $builder = $db->table('form_requests');
        $builder->insert($main);

        return redirect()->to(base_url("users/studentdetails?id=" . $main['user_id']));
    }
    public function saveoutpass()
    {
        $main['user_id'] = $_POST['user_id'];

        $data['FromDate'] = $_POST['fromdate'];
        $data['Todate'] = $_POST['todate'];
        $data['Purpose'] = $_POST['purpose'];
        $main['data'] = json_encode($data);
        $main['form_type'] = "StudentOutPass";
        $main['status'] = "created";
        $main['created_by'] = $_SESSION['userdetails']->userid;

        $db = db_connect();

        $builder = $db->table('form_requests');
        $builder->insert($main);

        return redirect()->to(base_url("users/studentdetails?id=" . $main['user_id']));
    }
    public function savematerialRequisition()
    {
        $nameArr = $_POST['productname'];
        $quantityArr  = $_POST['quantity'];
        $commentArr  = $_POST['comment'];
        $purposeArr = $_POST['purpose'];
        $material['branch_id'] = $_POST['branchid'];
        $material['created_by'] = $_POST['user_id'];

        $db = db_connect();

        $builder = $db->table('material_requisition');
        $builder->insert($material);
       $materialid = $db->insertID();
        for ($i = 0; $i < count($nameArr); $i++) {
            $main['material_requisition_id'] = $materialid;
            $main['product_id'] = $nameArr[$i];
            $main['purpose'] = $purposeArr[$i];
            $main['quantity'] = $quantityArr[$i];
            $main['approved_quantity'] = $quantityArr[$i];
            $main['comment'] = $commentArr[$i];
            $db = db_connect();

            $builder = $db->table('material_requisition_items');
            $builder->insert($main);
        }


        return redirect()->to(base_url("forms/materialrequisitionforms"));
    }

    public function noDueCertificate()
    {
        if ($_SESSION['userdetails'] == null) {
            return redirect()->to(base_url());
        } else {
            if ($_SESSION['rights'][array_search('Generate_NOC', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) {

                $data['page_name'] = 'Forms/noDueCertificate';
                $userid = $_GET['userId'];

                $usersModel = new UsersModel();
                $paymentsModel = new PaymentsModel();

                $data['studentDetails'] = $usersModel->getStudentDetails($userid, $_SESSION['activebatch']);
                $data['feesDetails'] = $paymentsModel->getInvoiceDetails($userid);


                $walletModel = new WalletModel();
                $walletData = $walletModel->getWalletDetails($userid, 15);

                $data['Laundry'] = COUNT($walletData) > 0 ? $walletData[0]->amount : 0;

                return view('loggedinuser/index.php', $data);
            } else {
                return redirect()->to(base_url('home'));
            }
        }
    }

    public function transferCertificate()
    {
        if ($_SESSION['userdetails'] == null) {
            return redirect()->to(base_url());
        } else {
            if ($_SESSION['rights'][array_search('Generate_NOC', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) {

                $data['page_name'] = 'Forms/TransferCertificate';
                $userid = $_GET['userId'];

                $batchid = $_GET['batchid'];

                $usersModel = new UsersModel();
                $paymentsModel = new PaymentsModel();

                $data['studentDetails'] = $usersModel->getStudentDetails($userid, $batchid);
                $data['feesDetails'] = $paymentsModel->getInvoiceDetails($userid);



                $walletModel = new WalletModel();
                $walletData = $walletModel->getWalletDetails($userid, 15);
                $data['Laundry'] = COUNT($walletData) > 0 ? $walletData[0]->amount : 0;
                return view('loggedinuser/index.php', $data);
            } else {
                return redirect()->to(base_url('home'));
            }
        }
    }

    public function DueCertificate()
    {
        if ($_SESSION['userdetails'] == null) {
            return redirect()->to(base_url());
        } else {
            if ($_SESSION['rights'][array_search('Generate_NOC', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) {

                $data['page_name'] = 'Forms/DueCertificate';
                $userid = $_GET['userId'];

                $usersModel = new UsersModel();
                $paymentsModel = new PaymentsModel();

                $data['studentDetails'] = $usersModel->getStudentDetails($userid, $_SESSION['activebatch']);
                $data['feesDetails'] = $paymentsModel->getInvoiceDetails($userid);


                $walletModel = new WalletModel();
                $walletData = $walletModel->getWalletDetails($userid, 6);

                $data['Laundry'] = COUNT($walletData) > 0 ? $walletData[0]->amount : 0;

                return view('loggedinuser/index.php', $data);
            } else {
                return redirect()->to(base_url('home'));
            }
        }
    }

    public function formApprovals()
    {
        if ($_SESSION['userdetails'] == null) {
            return redirect()->to(base_url());
        } else {
            $data['page_name'] = 'Forms/formApprovals';
            $form = $_GET['form'];
            $formsModel = new FormsModel();

            $data['formRequests'] = $formsModel->getFormRequests($form);

            return view('loggedinuser/index.php', $data);
        }
    }
    
    public function branchtransferformApprovals()
    {
        if ($_SESSION['userdetails'] == null) {
            return redirect()->to(base_url());
        } else {
            $data['page_name'] = 'Forms/formApprovals';

            $formsModel = new FormsModel();

            $data['formRequests'] = $formsModel->getBranchFormRequests();

            return view('loggedinuser/index.php', $data);
        }
    }


    public function outPassformApprovals()
    {
        if ($_SESSION['userdetails'] == null) {
            return redirect()->to(base_url());
        } else {
            
            $data['page_name'] = 'Forms/studentoutpassapprovals';

            $formsModel = new FormsModel();

            $data['formRequests'] = $formsModel->getoutpassFormRequests();

            return view('loggedinuser/index.php', $data);
        }
    }

    public function MaterialformApprovals($formgroupid = null)
    {
        if ($_SESSION['userdetails'] == null) {
            return redirect()->to(base_url());
        } else {
            if ($formgroupid != null || $formgroupid != '') {
                $data['page_name'] = 'Forms/materialformgroupApprovals';

                $formsModel = new FormsModel();

                $data['formRequests'] = $formsModel->getMaterialFormRequest($formgroupid);
                return view('loggedinuser/index.php', $data);
            } else {
                $data['page_name'] = 'Forms/materialformApprovals';

                $formsModel = new FormsModel();

                $data['formRequests'] = $formsModel->getMaterialFormRequests();
               

                return view('loggedinuser/index.php', $data);
            }
        }
    }

    public function PoformApprovals($formgroupid = null)
    {
        if ($_SESSION['userdetails'] == null) {
            return redirect()->to(base_url());
        } else {
            if ($formgroupid != null || $formgroupid != '') {
                $data['page_name'] = 'Forms/poformgroupApprovals';

                $formsModel = new FormsModel();

                $data['formRequests'] = $formsModel->getPoFormRequest($formgroupid);
                return view('loggedinuser/index.php', $data);
            } else {
                $data['page_name'] = 'Forms/poformApprovals';

                $formsModel = new FormsModel();

                $data['formRequests'] = $formsModel->getPoFormRequests();
               

                return view('loggedinuser/index.php', $data);
            }
        }
    }


    public function formRequestApprovalflow()
    {
        if ($_SESSION['userdetails'] != null) {
            $type = isset($_POST['approveform']) ? "approved" : "rejected";
            $form_request_id = $_POST['form_request_id'];
            $refundAmount = $_POST['refundAmount'];

            $main['status'] = $type;

            if ($type == "approved") {
                $db = db_connect();

                $query = $db->query("SELECT Fr.data,Fr.form_type,Fr.user_id,Fr.batchid FROM form_requests Fr
                                     WHERE Fr.form_request_id = $form_request_id");
                $result = $query->getResultArray();
                $db->close();
                $data = json_decode($result[0]['data']);
                if($refundAmount != NULL || $refundAmount != ''){
                    if($result[0]['form_type']=="discountApproval")
                {
                    $data->Amount = $refundAmount;
                }else
                {
                    $data->RefundAmount = $refundAmount;
                }
                }
                $main['updated_timestamp'] = date('Y-m-d H:i:s');
                $main['updated_by'] = $_SESSION['userdetails']->userid;

                $main['data'] = json_encode($data);

                $builder = $db->table('form_requests');
                $builder->where('form_request_id', $form_request_id);
                $builder->update($main);
                if($result[0]['form_type']=="discountApproval")
                {
                    //             $data1['userid'] = $result[0]['user_id'];
                    // 			$data1['invoiceid'] = $data->InvoiceId;
                    // 			$data1['invoice'] = 2;
                    // 			$data1['batchid'] = $result[0]['batchid'];
                    // 			$data1['feesid'] = 44;
                    // 			$data1['feesvalue'] = -$data->Amount;
                    // 			$data1['discountid'] = $data->discountid;
                    // 			$data1['additionaldetails'] = $data->additionaldetails;
                    // 			$paymentmodel = new PaymentsModel();
                    // 			$paymentmodel->addInvoice($data1);
                    $userid = $result[0]['user_id'];
			$paymenttypeid = 10;
			$paymentamount = $data->Amount;
			// $paymentdate = date_create_from_format("d/m/Y", $_POST['paymentdate']) != false ? date_format(date_create_from_format("d/m/Y", $_POST['paymentdate']), 'Y-m-d') : date('Y-m-d');
			$paymentdate = date('Y-m-d');
			$otherdetails = $data->discountid;
			$remarks = $data->additionaldetails;
			$invoice = $data->InvoiceId;

			$paymentcollectedby = 1;
			$paymentstatusid = 1;

			$helperModel = new HelperModel();
			$batch = $helperModel->get_batch()->year;
			$nextpaymentid = $helperModel->get_paymentidcounter();

			$paymentid = "RMD-" . $batch . "-" . str_pad($nextpaymentid, 6, '0', STR_PAD_LEFT);
            $createddate = date('Y-m-d H:i:s');
        	$paymentsModel = new PaymentsModel();
			$result = $paymentsModel->addPaymentNew($paymentid, $userid,$invoice, $paymentamount, $paymentdate, $paymenttypeid, $otherdetails, $paymentcollectedby, $paymentstatusid, 0, $remarks,$createddate);

		
				$nextpaymentid = $helperModel->set_paymentidcounter();
			

			$html = file_get_contents(base_url("payments/print_receipt?paymentid={$paymentid}&batchid={$_SESSION['activebatch']}"));
			$paymentsModel->htmltopdf($html, 'save', $paymentid, 'R');
                }
            } elseif ($type == "rejected") {
                $db = db_connect();

                $builder = $db->table('form_requests');
                $builder->where('form_request_id', $form_request_id);
                $builder->update($main);
            }
        } else {
            return redirect()->to(base_url('forms/formApprovals'));
        }
    }
    public function formRequestMaterialGroupApprovalflow()
    {
        if ($_SESSION['userdetails'] != null) {
            $type = isset($_POST['approveform']) ? "approved" : "rejected";
            $form_group_id = $_POST['form_group_id'];
            //  $quantity = $_POST['quantity'];

            $main['material_requisition_status'] = $type;

            if ($type == "approved") {
                $db = db_connect();

                $main['updated_time'] = date('Y-m-d H:i:s');
                $main['updated_by'] = $_SESSION['userdetails']->userid;
               // $main['material_requisition_status'] = "approved";
                $builder = $db->table('material_requisition');
                $builder->where('id', $form_group_id);
                $builder->update($main);
            } elseif ($type == "rejected") {
                $db = db_connect();

                $main['updated_time'] = date('Y-m-d H:i:s');
                $main['updated_by'] = $_SESSION['userdetails']->userid;

                $builder = $db->table('material_requisition');
                $builder->where('id', $form_group_id);
                $builder->update($main);
            }
        } else {
            return redirect()->to(base_url('forms/MaterialformApprovals'));
        }
    }

    public function poGroupApprovalflow()
    {
        if ($_SESSION['userdetails'] != null) {
            $type = isset($_POST['approveform']) ? "approved" : "rejected";
            $form_group_id = $_POST['form_group_id'];
            //  $quantity = $_POST['quantity'];

            $main['purchase_order_status'] = $type;

            if ($type == "approved") {
                $db = db_connect();

                $main['updated_time'] = date('Y-m-d H:i:s');
                $main['updated_by'] = $_SESSION['userdetails']->userid;
               // $main['material_requisition_status'] = "approved";
                $builder = $db->table('purchase_order');
                $builder->where('id', $form_group_id);
                $builder->update($main);
            } elseif ($type == "rejected") {
                $db = db_connect();

                $main['updated_time'] = date('Y-m-d H:i:s');
                $main['updated_by'] = $_SESSION['userdetails']->userid;

                $builder = $db->table('purchase_order');
                $builder->where('id', $form_group_id);
                $builder->update($main);
            }
        } else {
            return redirect()->to(base_url('forms/PoformApprovals'));
        }
    }
    public function formRequestMaterialUpdateflow()
    {
        if ($_SESSION['userdetails'] != null) {
            $form_request_id = $_POST['form_request_id'];
            $quantity = $_POST['quantity'];

            $db = db_connect();
            $main['quantity'] = $quantity;

           // $main['updated_timestamp'] = date('Y-m-d H:i:s');
           // $main['updated_by'] = $_SESSION['userdetails']->userid;

            $builder = $db->table('material_requisition_items');
            $builder->where('id', $form_request_id);
            $builder->update($main);
        } else {
            return redirect()->to(base_url('forms/MaterialformApprovals'));
        }
    }
    public function updatetclog()
    {
        $main['generated_by'] = $_POST['userid'];
        $main['applicationnumber'] = $_POST['applicationnumber'];
        $main['userid'] = $_POST['studentid'];
        $db = db_connect();
        $builder = $db->table('tc_log');
            $builder->insert($main);
    }
    public function deletematerialrequisitionforms()
    {
        if ($_SESSION['userdetails'] != null) {
            $id = $_GET['id'];

            $formsModel = new FormsModel();
            $formsModel->deletematerialrequisition($id);

            return redirect()->to(base_url('Forms/materialrequisitionforms'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }
    public function deletepoforms()
    {
        if ($_SESSION['userdetails'] != null) {
            $id = $_GET['id'];

            $formsModel = new FormsModel();
            $formsModel->deletepoform($id);

            return redirect()->to(base_url('Forms/poforms'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }
}
