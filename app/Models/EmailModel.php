<?php

namespace App\Models;

use App\Controllers\Comm;
use CodeIgniter\Model;
use App\Models\UsersModel;

class EmailModel extends Model
{
    public function sendEmployeeWelcomeEmail($userid)
    {
    }

    public function sendStudentWelcomeEmail($userid, $invoiceid)
    {
        $usersmodel = new UsersModel();
        $user = $usersmodel->getStudentDetails($userid, $_SESSION['activebatch']);

        $mailto = $user[0]->email;
        $filename = "{$invoiceid}.pdf";

        $file = base_url("invoices_files/{$filename}");

        $subject = 'Maidendrop Group - Welcome';
        $message = 'Thank you for joining maidendrop group. ';

        $comm = new Comm();
        // $comm->sendEmail($mailto, $subject, $message, $filename, $file);
        // $comm->sendEmail($mailto, $subject, $message);
    }

    public function sendStudentPromotionEmail($userid, $invoiceid)
    {
        $usersmodel = new UsersModel();
        $user = $usersmodel->getStudentDetails($userid, $_SESSION['activebatch']);

        $mailto = $user[0]->email;
        $filename = "{$invoiceid}.pdf";

        $file = base_url("invoices_files/{$filename}");

        $subject = 'Maidendrop Group - Promoted';
        $message = 'You are promoted to the next year. ';

        $comm = new Comm();
        // $comm->sendEmail($mailto, $subject, $message, $filename, $file);
        // $comm->sendEmail($mailto, $subject, $message);
    }

    public function sendInvoiceEmail($userid, $invoiceid)
    {
        $usersmodel = new UsersModel();
        $user = $usersmodel->getStudentDetails($userid, $_SESSION['activebatch']);

        $mailto = $user[0]->email;
        $filename = "{$invoiceid}.pdf";

        $file = base_url("invoices_files/{$filename}");

        $subject = 'Maidendrop Group - Invoice Details';
        $message = 'Thank you for joining maidendrop group. Your Invoice details are attached as a document. Thank You';

        $comm = new Comm();
        // $comm->sendEmail($mailto, $subject, $message, $filename, $file);
    }

    public function sendReceiptEmail($userid, $paymentid)
    {
        $usersmodel = new UsersModel();
        $user = $usersmodel->getStudentDetails($userid, $_SESSION['activebatch']);

        $mailto = $user[0]->email;
        $filename = "{$paymentid}.pdf";

        $file = base_url("receipt_files/{$filename}");

        $subject = 'Maidendrop Group - Payment Details';
        $message = 'Thank you for your payment. Your Payment details are attached as a document. Thank You';

        $comm = new Comm();
        // $comm->sendEmail($mailto, $subject, $message, $filename, $file);
    }
}
