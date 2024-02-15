<?php

namespace App\Controllers;

use App\Models\HelperModel;

class Comm extends BaseController
{
    public $session;
    public function __construct()
    {
        $session = session();
    }

    public function sendSMS($messageType, $data)
    {
        $to = $data[0];
        if ($messageType == "Welcome") {
            $template_id = "1707161933307466572";
            $entity_id = "1701159195824664328";
            $body = urlencode("Dear {$data[1]}, Thank you for Joining Resonance Hyderabad. Your Application number is {$data[2]}. We wish you a happy learning ahead. Thanks - Resonance Hyderabad.");
        } else if ($messageType == "PaymentConfirm") {
            $template_id = "1707161933304325495";
            $entity_id = "1701159195824664328";

            // $curl = curl_init();

            // $data['group_guid'] = "Bl7a8hOS5Jw";
            // $data['domain'] = "bit.ly";
            // $data['long_url'] = "{$data[3]}";

            // curl_setopt_array($curl, array(
            //     CURLOPT_URL => 'https://api-ssl.bitly.com/v4/shorten',
            //     CURLOPT_RETURNTRANSFER => true,
            //     CURLOPT_ENCODING => '',
            //     CURLOPT_MAXREDIRS => 10,
            //     CURLOPT_TIMEOUT => 0,
            //     CURLOPT_FOLLOWLOCATION => true,
            //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            //     CURLOPT_CUSTOMREQUEST => 'POST',
            //     CURLOPT_POSTFIELDS => json_encode($data),
            //     CURLOPT_HTTPHEADER => array(
            //         'Authorization: Bearer 64b4d2d7e8b05beebdbbadbce621cafcc654783d',
            //         'Content-Type: application/json'
            //     ),
            // ));

            // $response = curl_exec($curl);

            // curl_close($curl);
            // $jsonResult = json_decode($response);

            // $link = $jsonResult->link;

            $body = urlencode("Dear Parent/Student, We here by confirm the receipt of Rs. {$data[1]} towards your ward fee for roll number {$data[2]}. Receipt from the same can be viewed/downloaded from the following link {$data[3]}. Thanks Resonance Hyderabad.");
        } 
         else if($messageType == "ReservationDiscount")
        {
            
             $template_id = "1707170428417607843";
            $entity_id = "1701159195824664328";
           $body = urlencode("Dear {$data[1]}, you have been approved a Scholarship Amount of Rs.{$data[7]} for the Application No {$data[2]} for the Course {$data[6]} of academic Year of {$data[5]}.Please click the link {$data[4]} to get the receipt.Thanks Resonance Hyderabad.");

        }
         else if($messageType == "ApplicationPaymentConfirm")
        {
             $template_id = "1707166678193919689";
            $entity_id = "1701159195824664328";
           $body = urlencode("Dear {$data[4]} ,your application no {$data[2]} is confirmed with Resonance {$data[5]} campus, Hyderabad . Please click below {$data[3]} to download the reciept for Rs.{$data[1]}.Thanks Resonance Hyderabad.");

        }
        else if($messageType == "concession")
        {
             $template_id = "1707166901336540580";
            $entity_id = "1701159195824664328";
           $body = urlencode("Dear {$data[1]}, you have been approved a Concession of RS {$data[3]} for the Application No {$data[2]} Please click here {$data[4]} to get the receipt. Thanks Resonance Hyderabad.");

        }
        else if ($messageType == "PaymentDecline") {
            $template_id = "1707161933305853494";
            $entity_id = "1701159195824664328";
            $body = urlencode("Dear Parent/Student, We Regret to inform you that the receipt number {$data[1]} towards your ward {$data[2]} fee is rejected as the payment is not credited to Resonance. Please contact the administration team for any clarification.Thanks Resonance Hyderabad");
        }
        else if($messageType =="Newapplication")
        {
             $template_id = "1707166678044498491";
            $entity_id = "1701159195824664328";
            $body = urlencode("Dear {$data[1]},Your Application No {$data[2]} is registered with Resonance {$data[3]} Campus, Hyderabad. We will update you once its approved. You can click here {$data[4]} to see the application details. Thanks Resonance Hyderabad.");
       
        }
        else if($messageType =="Feelink")
        {
            
             $template_id = "1707166678055981792";
            $entity_id = "1701159195824664328";
            $body = urlencode("Dear {$data[1]},Your Application No {$data[2]} is Approved with Resonance {$data[3]} Campus, Hyderabad. Please click here {$data[4]} to Make registration fee to confirm the application. Thanks Resonance Hyderabad.");
       
        }
       
        $apiurl = "http://pwtpl.com/sms/V1/send-sms-api.php?apikey=luyUJ7GzaUO0BNxp&senderid=RESOHY&templateid=$template_id&entityid=$entity_id&number=$to&message=$body";

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $apiurl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));
        curl_exec($curl);
        curl_close($curl);
    }

    public function sendEmail($to, $subject, $message, $filename = NULL, $attachment = NULL)
    {
        if ($filename != NULL && $attachment != NULL) {
            $content = file_get_contents($attachment);
            $content = chunk_split(base64_encode($content));
        }

        // a random hash will be necessary to send mixed content
        $separator = md5(time());

        // carriage return type (RFC)
        $eol = "\r\n";

        // main header (multipart mandatory)
        $headers = "From: Maidendropgroup <admin@maidendropgroup.com>" . $eol;
        $headers .= "MIME-Version: 1.0" . $eol;
        $headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol;
        $headers .= "Content-Transfer-Encoding: 7bit" . $eol;
        $headers .= "This is a MIME encoded message." . $eol;

        // message
        $body = "--" . $separator . $eol;
        $body .= "Content-Type: text/plain; charset=ISO-8859-1" . $eol;
        $body .= "Content-Transfer-Encoding: base64" . $eol . $eol;
        $body .= $message . $eol;

        // attachment
        if ($filename != NULL && $attachment != NULL) {
            $body .= "--" . $separator . $eol;
            $body .= "Content-Type: application/octet-stream; name=\"" . $filename . "\"" . $eol;
            $body .= "Content-Transfer-Encoding: base64" . $eol;
            $body .= "Content-Disposition: attachment" . $eol;
            $body .= $content . $eol;
            $body .= "--" . $separator . "--";
        }

        //SEND Mail
        if (isset($to)) {
            mail($to, $subject, $body, $headers);
        }
    }
}
