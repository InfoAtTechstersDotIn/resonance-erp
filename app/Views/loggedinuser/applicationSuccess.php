<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maiden</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body style="
    font-family: sans-serif; font-size: 20px;margin-top:20px;
">

<div class="fd" style="max-width: 80%; margin:auto;">


<p >Your application has been submitted successfully.</p>

<h3> Application No.: <?php print_r($StudentDetail[0]->application_ukey); ?></h3>


<h3 style="
    border-bottom: 1px solid black;
    padding-bottom: 3%;
"> Payment Transaction ID : <?php print_r($StudentDetail[0]->otherdetails); ?></h3>


<div class="prints" style="width: 100%;">


<p style="width: 30%;float: left;border-bottom: 1px solid black;padding-top: 30px;"> <i class="fa fa-print" aria-hidden="true" style="
    padding-right: 10px;
"><a target="_blank" href="https://maidendropgroup.com/public/payments/printapp?userid=<?php echo $StudentDetail[0]->applicationid ?>"></i>Print Application Form</a></p>

<p style="width: 40%;float: right;border-bottom: 1px solid black;padding-top: 30px;"> <i class="fa fa-print" aria-hidden="true" style="
    padding-right: 10px;
"><a href="https://maidendropgroup.com/t.php?p=<?php echo $StudentDetail[0]->applicationid ?>" target="_blank"></i>Print Discount Receipt</a></p>

<p style="width: 30%;float: right;border-bottom: 1px solid black;padding-top: 30px;"> <i class="fa fa-print" aria-hidden="true" style="
    padding-right: 10px;
"><a href="https://maidendropgroup.com/t.php?p=<?php echo $StudentDetail[0]->paymentid;?>" target="_blank"></i>Print Acknowledgement Receipt</a></p>

</div>




<p style="
    padding-top: 15%;
">For further reference and any correspondence, please ensure that you mention your application number printed above for easy retrieval of your application form.</p>










<p>This also serves as an acknowledgement that your application has been received by the institution. You can print your completed application form and acknowledgement receipt for your own records.</p>

</div>




    
</body>
</html>