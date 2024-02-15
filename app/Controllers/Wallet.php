<?php

namespace App\Controllers;

use App\Models\HelperModel;
use App\Models\InventoryModel;
use App\Models\UsersModel;
use App\Models\WalletModel;

class Wallet extends BaseController
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

    public function addWalletDetails()
    {
        if ($_SESSION['userdetails'] != null) {
            $returnURL = $_POST['returnURL'];

            $wallettypeid = $_POST['wallettypeid'];
            $userid = $_POST['userid'];
            $amount = $_POST['amount'];

            $transactiontype = $_POST['transactiontype'];
            $paymenttypeid = $_POST['paymenttypeid'];
            $transactedby = $_SESSION['userdetails']->userid;
            $remarks = $_POST['remarks'];

            $payment_details = $_POST['payment_details'];
            $date = date_create_from_format("d/m/Y", $_POST['date']) != false ? date_format(date_create_from_format("d/m/Y", $_POST['date']), 'Y-m-d') : date('Y-m-d');

            $walletModel = new WalletModel();
            $walletDetails = $walletModel->getWalletDetails($userid, $wallettypeid)[0];
            if ($walletDetails == NULL) {
                if ($transactiontype == "Credit") {
                    $walletid = $walletModel->addWalletDetails($wallettypeid, $userid, $amount);
                } else {
                    $walletid = $walletModel->addWalletDetails($wallettypeid, $userid, -$amount);
                }

                if ($walletid != 0) {
                    $walletModel->addUpdateWalletTransactions($walletid, $userid, $amount, $date, $transactiontype,$paymenttypeid, $transactedby, $remarks, $payment_details);
                }
            } else {
                if ($transactiontype == "Credit") {
                    $FinalAmount = $walletDetails->amount + $amount;
                    $walletModel->updateWalletDetails($walletDetails->walletid, $FinalAmount);
                    $walletModel->addUpdateWalletTransactions($walletDetails->walletid, $userid, $amount, $date, $transactiontype,$paymenttypeid, $transactedby, $remarks, $payment_details);
                } else if ($transactiontype == "Debit") {
                    $FinalAmount = $walletDetails->amount - $amount;
                    $walletModel->updateWalletDetails($walletDetails->walletid, $FinalAmount);
                    $walletModel->addUpdateWalletTransactions($walletDetails->walletid, $userid, $amount, $date, $transactiontype,$paymenttypeid, $transactedby, $remarks, $payment_details);
                }
            }

            return redirect()->to(base_url($returnURL));
        } else {
            return redirect()->to(base_url('Payments'));
        }
    }

    public function print_WalletReceipt()
    {
        $userid = $_GET['userid'];
        $walletid = $_GET['walletid'];

        $walletModel = new WalletModel();
        $data['WalletDetails'] = $walletModel->getWalletDetail($walletid);
        $data['WalletTransactionDetails'] = $walletModel->getWalletTransactions($userid, $walletid);

        $usersModel = new UsersModel();
        $data['userDetails'] = $usersModel->getStudentDetails($userid);

        return view('loggedinuser/Print/print_walletreceipt.php', $data);
    }

    public function print_WalletTransactionReceipt()
    {
        $userid = $_GET['userid'];
        $wallettransactionid = $_GET['wallettransactionid'];

        $walletModel = new WalletModel();
        $data['WalletTransaction'] = $walletModel->getWalletTransaction($wallettransactionid);

        $usersModel = new UsersModel();
        $data['userDetails'] = $usersModel->getStudentDetails($userid);

        return view('loggedinuser/Print/print_wallettransactionreceipt.php', $data);
    }
}
