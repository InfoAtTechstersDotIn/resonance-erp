<html><body>
    <div class="ts-main-content">
        <div class="content-wrapper">
            <div class="container-fluid">
                <h1 style="text-align: center; background-color: #99cc33; color: white;"><strong>Payment Receipt</strong></h1>
                 <!--<div style="width: 75%; margin-left: auto; margin-right: auto;">
                        <?php if($payment->invoice==2)
                               {
                                   echo "Company Name : MAIDEN DROP EDU FOUNDATION SOCIETY";
                                   echo "<br>";
                                   echo "PAN : AALAM1258N";
                                   echo "<br>";
                                   echo "Address : 1st FLOOR FLAT NO 104, H NO. 6-3-348/10/104, NIRMAL
TOWERS, DWARAKAPURI CLY, PUNJAGUTTA, Hyderabad,
Telangana, 500082";
                               }elseif($payment->invoice==1)
                               {
                                   echo "Company Name : MAIDEN DROP EDU FOUNDATION PRIVATE LIMTED";
                                   echo "<br>";
                                   echo "PAN : AANCM1210C";
                                   echo "<br>";
                                   echo "Address : 1ST FLOOR FLAT NO 104, H NO. 6-3-348/10/104, NIRMAL
TOWERS, DWARAKAPURI CLY, PUNJAGUTTA, Hyderabad,
Telangana, 500082";
                               }
                               ?>
                               
                               </div>-->
                               
                               <br>
                <table style="width: 75%; margin-left: auto; margin-right: auto;">
                    <tbody>
                        <tr>
                            <td style="width: 30%;">
                               
                            </td>
                            <td style="width: 70%;">
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 30%;">
                                 <p><img src="<?php echo base_url('images/logo.png') ?>" alt="" width="110" height="110" /></p>
                            </td>
                            <td style="width: 70%; text-align: right; vertical-align:bottom">
                                <table style="width: 100%; margin-left: auto; margin-right: auto;">
                                    <tbody>
                                        <tr>
                                            <td style="background-color: #99cc33; border: 1px solid #99cc33;"><b>Application No</b></td>
                                            <td style="border: 1px solid #99cc33;"><i><?php echo $userDetails->application_ukey ?></i></td>
                                        </tr>
                                        <tr>
                                            <td style="background-color: #99cc33; border: 1px solid #99cc33;"><b>Name</b></td>
                                            <td style="border: 1px solid #99cc33;"><i><?php echo $userDetails->name ?></i></td>
                                        </tr>
                                        <tr>
                                            <td style="background-color: #99cc33; border: 1px solid #99cc33;"><b>Branch</b></td>
                                            <td style="border: 1px solid #99cc33;"><i><?php echo $userDetails->branchname ?></i></td>
                                        </tr>
                                        <tr>
                                            <td style="background-color: #99cc33; border: 1px solid #99cc33;"><b>Admission Type</b></td>
                                            <td style="border: 1px solid #99cc33;"><i><?php echo $userDetails->admissiontypename ?></i></td>
                                        </tr>
                                        <tr>
                                            <td style="background-color: #99cc33; border: 1px solid #99cc33;"><b>Course</b></td>
                                            <td style="border: 1px solid #99cc33;"><i><?php echo $userDetails->coursename ?></i></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p>&nbsp;</p>
                <?php
                $totalPaid = 0;
                ?>
                <table style="width: 75%; margin-left: auto; margin-right: auto;">
                    <tbody>
                        <tr>
                           
                            <td style="background-color: #99cc33; width: 20%; text-align: center; border: 1px solid #99cc33;"><strong>Receipt No</strong></td>
                            <td style="background-color: #99cc33; width: 20%; text-align: center; border: 1px solid #99cc33;"><strong>Payment Type</strong></td>
                            <td style="background-color: #99cc33; width: 20%; text-align: center; border: 1px solid #99cc33;"><strong>Payment Date</strong></td>
                            <td style="background-color: #99cc33; width: 20%; text-align: center; border: 1px solid #99cc33;"><strong>Payment Details</strong></td>
                            <td style="background-color: #99cc33; width: 20%; text-align: center; border: 1px solid #99cc33;"><strong>Payment Amount</strong></td>
                            <td style="background-color: #99cc33; width: 20%; text-align: center; border: 1px solid #99cc33;"><strong>Collect By</strong></td>
                        </tr>
                        <tr>
                            <td style="width: 20%; text-align: center; border: 1px solid #99cc33;"><?php echo $payment->paymentid ?></td>
                            <td style="width: 20%; text-align: center; border: 1px solid #99cc33;"><?php echo $payment->paymenttypename ?></td>
                            <td style="width: 20%; text-align: center; border: 1px solid #99cc33;"><?php echo $payment->paymentdate ?></td>
                            <td style="width: 20%; text-align: center; border: 1px solid #99cc33;"><?php echo $payment->otherdetails ?></td>
                            <td style="width: 20%; text-align: center; border: 1px solid #99cc33;"><?php echo $payment->paymentamount ?></td>
                            <td style="width: 20%; text-align: center; border: 1px solid #99cc33;"><?php echo $payment->receivedby ?></td>
                        </tr>
                    </tbody>
                </table>
                <div style="text-align:center;margin-top:50px;border-bottom:1px solid #99cc33;">This is computer generated receipt, signature and stamp is not required.</div>
                 <?php
                if($payment->invoice==1){
                    ?>
                <p style="text-align:center;"><strong>MAIDENDROP EDU FOUNDATION</strong>, GSTIN: 36AANCM1210C1Z0, Corporate office, 1ST FLOOR FLAT NO 104, H NO. 6-3-348/10/104, NIRMAL
TOWERS, DWARAKAPURI CLY, PUNJAGUTTA, Hyderabad,
Telangana, 500082</p>
           <?php }elseif($payment->invoice==2)
           {
            ?>               
            <p style="text-align:center;"><strong>MAIDENDROP EDU FOUNDATION</strong>, Registration Number 75 OF 2020, 1ST FLOOR FLAT NO 104, H NO. 6-3-348/10/104, NIRMAL
TOWERS, DWARAKAPURI CLY, PUNJAGUTTA, Hyderabad,
Telangana, 500082</p>
               
               <?php
           
           }else
           {
               ?>
                               <p style="text-align:center;"><strong>MAIDENDROP EDU FOUNDATION</strong>, Corporate office, Plot No. 26, 100ft road, main road, Madhapur, Hyderabad- 500081,Phone: 9121219858</p>

               <?php
           
           
           }?>
            </div>
        </div>
        
    </div>
</body></html>