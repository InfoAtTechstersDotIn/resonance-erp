<?php

namespace App\Models;

use CodeIgniter\Model;

class WalletModel extends Model
{
    public function getWalletDetails($userid, $wallettypeid = NULL)
    {
        $db = db_connect();

        if ($wallettypeid == NULL) {
            $query = $db->query("SELECT * FROM 
                                 wallet JOIN wallettypelookup ON wallettypelookup.wallettypeid = wallet.wallettypeid
                                 WHERE wallet.userid = {$userid}");
        } else {
            $query = $db->query("SELECT * FROM 
                                 wallet JOIN wallettypelookup ON wallettypelookup.wallettypeid = wallet.wallettypeid
                                 WHERE wallet.userid = {$userid} AND wallet.wallettypeid = {$wallettypeid}");
        }
        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function getWalletDetail($walletid)
    {
        $db = db_connect();

        $query = $db->query("SELECT * FROM 
                             wallet JOIN wallettypelookup ON wallettypelookup.wallettypeid = wallet.wallettypeid
                             WHERE wallet.walletid = {$walletid}");

        $results = $query->getRow();
        $db->close();

        return $results;
    }

    public function getWalletTransactions($userid, $walletid = NULL)
    {
        $db = db_connect();

        if ($walletid == NULL) {
            $query = $db->query("SELECT * FROM wallet 
                                 JOIN wallettypelookup ON wallettypelookup.wallettypeid = wallet.wallettypeid
                                 JOIN wallettransactions ON wallettransactions.walletid = wallet.walletid
                                 LEFT JOIN employeedetails ON wallettransactions.transactedby = employeedetails.userid
                                 LEFT JOIN employeedetails ON wallettransactions.transactedby = employeedetails.userid
                                 LEFT JOIN paymenttypelookup ON wallettransactions.paymenttypeid = paymenttypelookup.paymenttypeid
                                 WHERE wallet.userid = {$userid}");
        } else {
            $query = $db->query("SELECT * FROM wallet 
                                 JOIN wallettypelookup ON wallettypelookup.wallettypeid = wallet.wallettypeid
                                 JOIN wallettransactions ON wallettransactions.walletid = wallet.walletid
                                 LEFT JOIN employeedetails ON wallettransactions.transactedby = employeedetails.userid
                                 LEFT JOIN paymenttypelookup ON wallettransactions.paymenttypeid = paymenttypelookup.paymenttypeid
                                 WHERE wallettransactions.userid = {$userid} AND wallettransactions.walletid = {$walletid}");
        }


        $results = $query->getResult();
        $db->close();

        return $results;
    }

    public function getWalletTransaction($walletTransactionId)
    {
        $db = db_connect();

        $query = $db->query("SELECT * FROM wallet 
                                 JOIN wallettypelookup ON wallettypelookup.wallettypeid = wallet.wallettypeid
                                 JOIN wallettransactions ON wallettransactions.walletid = wallet.walletid
                                 LEFT JOIN employeedetails ON wallettransactions.transactedby = employeedetails.userid
                                 WHERE wallettransactions.wallettransactionid = {$walletTransactionId}");


        $results = $query->getRow();
        $db->close();

        return $results;
    }

    public function addWalletDetails($wallettypeid, $userid, $amount)
    {
        $db = db_connect();

        $data['wallettypeid'] = $wallettypeid;
        $data['userid'] = $userid;
        $data['amount'] = $amount;

        $builder = $db->table('wallet');
        $builder->insert($data);

        $insertId = $db->insertID();
        if ($insertId != 0) {
            return $insertId;
        }
    }

    public function updateWalletDetails($walletid, $amount)
    {
        $db = db_connect();

        $data['amount'] = $amount;

        $builder = $db->table('wallet');
        $builder->where('walletid', $walletid);
        $builder->update($data);
        $db->close();
    }

    public function addUpdateWalletTransactions($walletid, $userid, $amount, $date, $transactiontype,$paymenttypeid, $transactedby, $remarks, $payment_details)
    {
        $db = db_connect();

        $data['walletid'] = $walletid;
        $data['userid'] = $userid;
        $data['amount'] = $amount;
        $data['date'] = $date;
        $data['payment_details'] = $payment_details;
        $data['transactiontype'] = $transactiontype;
        $data['paymenttypeid'] = $paymenttypeid;
        $data['transactedby'] = $transactedby;
        $data['remarks'] = $remarks;

        $builder = $db->table('wallettransactions');
        $builder->insert($data);
        $db->close();
    }
}
