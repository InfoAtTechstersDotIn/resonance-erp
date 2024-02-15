<?php

namespace App\Models;

use CodeIgniter\Model;

class RazorpayModel extends Model
{
    public function save_payment_link($userid, $invoiceid,$invoiceno, $batchid, $invoice_id, $orderid, $amount, $url, $status,$type,$uniqueid)
    {
        $db = db_connect();
        $data['userid'] = $userid;
        $data['invoice'] = $invoiceno;
        $data['invoice_id'] = $invoiceid;
        $data['batchid'] = $batchid;
        $data['invoiceid'] = $invoice_id;
        $data['orderid'] = $orderid;
        $data['amount'] = $amount;
        $data['url'] = $url;
        $data['status'] = $status;
        $data['type'] = $type;
        $data['uniqueid'] = $uniqueid;

        $builder = $db->table('payment_links');
        $builder->insert($data);

        $db->close();
    }
    public function update_applicationpayment_status($invoiceid, $status,$userid)
    {
        $db = db_connect();
        $data['status'] = $status;

        $builder = $db->table('applicationpayment_links');
        $builder->where('invoiceid', $invoiceid);
        $builder->update($data);

        $db->close();
    }
    public function update_application_status($userid)
    {
         $db = db_connect();
         $data1['reservationstatusid'] = 5;
         $builder = $db->table('applications');
        $builder->where('applicationid', $userid);
        $builder->update($data1);

        $db->close();
    }
     public function save_applicationpayment_link($userid, $invoice, $batchid, $invoiceid, $orderid, $amount, $url, $status,$type,$uniqueid)
    {
        $db = db_connect();
        $data['userid'] = $userid;
        $data['invoice'] = $invoice;
        $data['batchid'] = $batchid;
        $data['invoiceid'] = $invoiceid;
        $data['orderid'] = $orderid;
        $data['amount'] = $amount;
        $data['url'] = $url;
        $data['status'] = $status;
         $data['type']=$type;
        $data['uniqueid']  = $uniqueid;

        $builder = $db->table('applicationpayment_links');
        $builder->insert($data);

        $db->close();
    }

    
    public function update_payment_status($invoiceid, $status)
    {
        $db = db_connect();
        $data['status'] = $status;

        $builder = $db->table('payment_links');
        $builder->where('invoiceid', $invoiceid);
        $builder->update($data);

        $db->close();
    }
    public function update_payment_status_orderid($invoiceid, $status)
    {
        $db = db_connect();
        $data['status'] = $status;

        $builder = $db->table('payment_links');
        $builder->where('orderid', $invoiceid);
        $builder->update($data);

        $db->close();
    }
}
