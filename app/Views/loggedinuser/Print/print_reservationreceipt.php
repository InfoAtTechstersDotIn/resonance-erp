<html><body>
    <div class="ts-main-content">
        <div class="content-wrapper">
            <div class="container-fluid">
                <h1 style="text-align: center; background-color: #99cc33; color: white;"><strong>Reservation Payment Receipt</strong></h1>
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
                                            <td style="background-color: #99cc33; border: 1px solid #99cc33;"><b>Reservation Id</b></td>
                                            <td style="border: 1px solid #99cc33;"><i><?php echo $payment[0]->reservation_ukey ?></i></td>
                                        </tr>
                                        <tr>
                                            <td style="background-color: #99cc33; border: 1px solid #99cc33;"><b>Name</b></td>
                                            <td style="border: 1px solid #99cc33;"><i><?php echo $payment[0]->studentName ?></i></td>
                                        </tr>
                                        <tr>
                                            <td style="background-color: #99cc33; border: 1px solid #99cc33;"><b>Branch</b></td>
                                            <td style="border: 1px solid #99cc33;"><i><?php echo $payment[0]->branchname ?></i></td>
                                        </tr>
                                        <tr>
                                            <td style="background-color: #99cc33; border: 1px solid #99cc33;"><b>Admission Type</b></td>
                                            <td style="border: 1px solid #99cc33;"><i><?php echo $payment[0]->admissiontypename ?></i></td>
                                        </tr>
                                        <tr>
                                            <td style="background-color: #99cc33; border: 1px solid #99cc33;"><b>Course</b></td>
                                            <td style="border: 1px solid #99cc33;"><i><?php echo $payment[0]->coursename ?></i></td>
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
                            <td style="width: 20%; text-align: center; border: 1px solid #99cc33;"><?php echo $payment[0]->reservation_paymentid ?></td>
                            <td style="width: 20%; text-align: center; border: 1px solid #99cc33;"><?php echo $payment[0]->paymenttypename ?></td>
                            <td style="width: 20%; text-align: center; border: 1px solid #99cc33;"><?php echo $payment[0]->paymentdate ?></td>
                            <td style="width: 20%; text-align: center; border: 1px solid #99cc33;"><?php echo $payment[0]->otherdetails ?></td>
                            <td style="width: 20%; text-align: center; border: 1px solid #99cc33;"><?php echo $payment[0]->paymentamount ?></td>
                            <td style="width: 20%; text-align: center; border: 1px solid #99cc33;"><?php echo $payment[0]->receivedby ?></td>
                        </tr>
                    </tbody>
                </table>
                <div style="text-align:center;margin-top:50px;border-bottom:1px solid #99cc33;">This is computer generated receipt, signature and stamp is not required.</div>
                <p style="text-align:center;"><strong>MAIDENDROP EDU FOUNDATION</strong>, Corporate office, Plot No. 26, 100ft road, main road, Madhapur, Hyderabad- 500081,Phone: 9121219858</p>
            </div>
        </div>
        
    </div>
</body></html>