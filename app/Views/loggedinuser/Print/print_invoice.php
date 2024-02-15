<html><body>
    <div class="ts-main-content">
        <div class="content-wrapper">
            <div class="container-fluid">
                <?php
                if($InvoiceDetails[0]->invoice=='' || $InvoiceDetails[0]->invoice==NULL)
                {
                    ?>
                                    <h1 style="text-align: center; background-color: #99cc33; color:white"><strong>Student Invoice</strong></h1>

                    <?php
                }else{
                ?>
                <h1 style="text-align: center; background-color: #99cc33; color:white"><strong>Student Proforma Invoice</strong></h1>
               
               <?php } ?>
                <table style="width: 100%; margin-left: auto; margin-right: auto;">
                    <tbody>
                        <tr>
                            <td style="width: 25%;">
                                <p><img src="<?php echo base_url('images/logo.png') ?>" alt="" width="110" height="110" /></p>
                                <p>
                                    <strong>Name: </strong><?php echo $InvoiceDetails[0]->name ?><br />
                                    <strong>Application Number: </strong><?php echo $InvoiceDetails[0]->applicationnumber ?><br />
                                    <strong>Branch: </strong><?php echo $InvoiceDetails[0]->branchname ?><br />
                                    <strong>Admission Type: </strong><?php echo $InvoiceDetails[0]->admissiontypename ?><br />
                                    <strong>Course: </strong><?php echo $InvoiceDetails[0]->coursename ?><br />
                                    <strong>Section: </strong><?php echo $InvoiceDetails[0]->sectionname ?><br />
                            </td>
                            <td style="width: 75%;">
                                <table style="width: 80%; margin-left: auto; margin-right: auto;">
                                    <tbody>
                                        <tr>
                                            <td style="text-align: center; background-color: #99cc33; border:1px solid #99cc33; color:white"><strong>Invoice Number</strong></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center; border:1px solid #99cc33"><?php echo $InvoiceDetails[0]->invoiceid ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br />
                                <?php if ($InvoiceDetails[0]->rezofast_ht_no != NULL) : ?>
                                    <table style="width: 80%; margin-left: auto; margin-right: auto;">
                                        <tbody>
                                            <tr>
                                                <td style="text-align: center; background-color: #99cc33; border:1px solid #99cc33; color:white"><strong>Resofast</strong></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center; border:1px solid #99cc33">Hallticket No.: <?php echo $InvoiceDetails[0]->rezofast_ht_no ?><br />Scholarship: <?php echo $InvoiceDetails[0]->scholarship ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <br />
                                <?php endif; ?>
                                <table style="width: 80%; margin-left: auto; margin-right: auto;">
                                    <tbody>
                                        <tr>
                                            <td style="width: 50%; text-align: center; background-color: #99cc33; border:1px solid #99cc33; color:white"><strong>Fee Details</strong></td>
                                            <?php if($InvoiceDetails[0]->batchid==1)
                                            {
                                                ?>
                                                                                            <td style="width: 25%; text-align: center; background-color: #99cc33; border:1px solid #99cc33; color:white"><strong>Original Amount</strong></td>

                                                <?php
                                            }
                                            ?>
                                            <td style="width: 25%; text-align: center; background-color: #99cc33; border:1px solid #99cc33; color:white"><strong>Final Amount</strong></td>
                                        </tr>
                                        <?php
                                        $total = 0;
                                        $OriginalTotal = 0;
                                        foreach ($InvoiceDetails as $invoice) :
                                            $OriginalTotal = $OriginalTotal + $invoice->OriginalFees;
                                            $total = $total + $invoice->feesvalue;
                                        ?>
                                            <tr>
                                                <td style="width: 50%; text-align: center; border:1px solid #99cc33"><?php echo $invoice->feetype ?><?php echo $invoice->additionaldetails != NULL ? "(" . $invoice->additionaldetails . ")" : "" ?></td>
                                                <?php if($InvoiceDetails[0]->batchid==1)
                                            {
                                                ?>
                                                <td style="width: 25%; text-align: center; border:1px solid #99cc33"><?php echo $invoice->OriginalFees ?></td>
                                                <?php } ?>
                                                <td style="width: 25%; text-align: center; border:1px solid #99cc33"><?php echo $invoice->feesvalue ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <tr>
                                            <td style="width: 50%; text-align: center; background-color: #99cc33; border:1px solid #99cc33; color:white"><strong>Total</strong></td>
                                             <?php if($InvoiceDetails[0]->batchid==1)
                                            {
                                                ?>
                                            <td style="width: 25%; text-align: center; background-color: #99cc33; border:1px solid #99cc33; color:white"><strong><?php echo $OriginalTotal ?></strong></td>
                                            <?php } ?>
                                            <td style="width: 25%; text-align: center; background-color: #99cc33; border:1px solid #99cc33; color:white"><b><?php echo $total ?></b></td>
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
                <!-- <table style="width: 100%; margin-left: auto; margin-right: auto;">
                    <tbody>
                        <tr>
                            <td style="background-color: #99cc33; width: 16.66%; text-align: center; border:1px solid #99cc33"><strong>Payment Id</strong></td>
                            <td style="background-color: #99cc33; width: 16.66%; text-align: center; border:1px solid #99cc33"><strong>Payment Date</strong></td>
                            <td style="background-color: #99cc33; width: 16.66%; text-align: center; border:1px solid #99cc33"><strong>Payment Type</strong></td>
                            <td style="background-color: #99cc33; width: 16.66%; text-align: center; border:1px solid #99cc33"><strong>Other Details</strong></td>
                            <td style="background-color: #99cc33; width: 16.66%; text-align: center; border:1px solid #99cc33"><strong>Payment Received By</strong></td>
                            <td style="background-color: #99cc33; width: 16.66%; text-align: center; border:1px solid #99cc33"><strong>Amount Paid</strong></td>
                        </tr>
                        <?php
                        foreach ($PaymentDetails as $payment) :
                            $totalPaid = $totalPaid + $payment->paymentamount;
                        ?>
                            <tr>
                                <td style="width: 16.66%; text-align: center; border:1px solid #99cc33"><?php echo $payment->paymentid ?></td>
                                <td style="width: 16.66%; text-align: center; border:1px solid #99cc33"><?php echo $payment->paymentdate ?></td>
                                <td style="width: 16.66%; text-align: center; border:1px solid #99cc33"><?php echo $payment->paymenttypename ?></td>
                                <td style="width: 16.66%; text-align: center; border:1px solid #99cc33"><?php echo $payment->otherdetails ?></td>
                                <td style="width: 16.66%; text-align: center; border:1px solid #99cc33"><?php echo $payment->ReceivedBy ?></td>
                                <td style="width: 16.66%; text-align: center; border:1px solid #99cc33"><?php echo $payment->paymentamount ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td style="background-color: #99cc33; width: 16.66%; text-align: center; border:1px solid #99cc33"><strong>Balance Amount</strong></td>
                            <td style="background-color: #99cc33; width: 16.66%; text-align: center; border:1px solid #99cc33"></td>
                            <td style="background-color: #99cc33; width: 16.66%; text-align: center; border:1px solid #99cc33"></td>
                            <td style="background-color: #99cc33; width: 16.66%; text-align: center; border:1px solid #99cc33"></td>
                            <td style="background-color: #99cc33; width: 16.66%; text-align: center; border:1px solid #99cc33"></td>
                            <td style="background-color: #99cc33; width: 16.66%; text-align: center; border:1px solid #99cc33; color:white"><b><?php echo $totalPaid ?></b></td>
                        </tr>
                    </tbody>
                </table> -->
                
                <div style="text-align:center;margin-top:50px;border-bottom:1px solid #99cc33;">This is computer generated receipt, signature and stamp is not required.</div>
                <?php
                if($InvoiceDetails[0]->invoice==1){
                    ?>
                <p style="text-align:center;"><strong>MAIDENDROP EDU FOUNDATION</strong>, GSTIN: 36AANCM1210C1Z0, Corporate office, 1ST FLOOR FLAT NO 104, H NO. 6-3-348/10/104, NIRMAL
TOWERS, DWARAKAPURI CLY, PUNJAGUTTA, Hyderabad,
Telangana, 500082</p>
           <?php }elseif($InvoiceDetails[0]->invoice==2)
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