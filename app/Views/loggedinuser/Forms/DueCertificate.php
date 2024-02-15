<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Fee Balance Confirmation form for AY 2021-22
                </h2>
                <?php
            $lan = 5000 - $Laundry;
                if (($feesDetails[0]->TotalPaid < $feesDetails[0]->TotalValue  && $studentDetails[0]->admissiontypename == "Residential") ||
                    ($feesDetails[0]->TotalPaid < $feesDetails[0]->TotalValue && $studentDetails[0]->admissiontypename != "Residential")
                ) :
                ?>
                    <a class="btn btn-success" onclick="printDiv('div')">Print</a>

                    <div class="row">
                        <div class="col-md-12" id="div" style="visibility: hidden;">
                            <div class="scale">
                                <p style="text-align: center;"><img src="<?php echo base_url('images/logo.png') ?>" width="110" height="110" /></p>
                                <br />
                                <br />
                                <h2 style="text-align: center;"><strong><u>Fee Balance Confirmation form for AY 2021-22</u></strong></h2>
                                <br />
                                <br />
                                <p style="text-align: right;">Date: <?php echo date("d-m-Y"); ?><br />Hyderabad</p>
                                <br />
                                <br />
                                <p style="text-align: justify;">It is to certify that <?php echo $studentDetails[0]->gendername == "Male" ? "Mr." : "Ms."; ?> <?php echo $studentDetails[0]->name; ?> <?php echo $studentDetails[0]->gendername == "Male" ? "S/o" : "D/o"; ?> <?php echo $studentDetails[0]->fathername; ?>
                                    studied in our college in <?php echo $studentDetails[0]->coursename; ?> for the Acadamic year <?php echo $studentDetails[0]->batchname; ?>
                                    with Application No. <?php echo $studentDetails[0]->applicationnumber; ?> in <?php echo $studentDetails[0]->branchname; ?> has Amount Due of Rs.<b><?php
                                    if($studentDetails[0]->admissiontypename == "Residential")
                                    {
                                    echo (($feesDetails[0]->TotalValue - $feesDetails[0]->TotalPaid) + $lan);
                                    }else
                                    {
                                        echo $feesDetails[0]->TotalValue - $feesDetails[0]->TotalPaid;
                                    }
                                    
                                    ?></b> as on Date <?php echo date("d-m-Y"); ?>.</p>
                                <br />
                                <br />
                                <br />
                                <p>ACCOUNTANT
                                <br />
                                <br />
                                <br />
                                <span>PRINCIPAL</span>
                                    <span style="float:right">PARENT</span>
                                </p>
                            </div>
                            <style>
                                @media print {
                                    .scale {
                                        font-size: 24px;
                                    }
                                }
                            </style>
                        </div>
                    </div>
                    <script>
                        function printDiv(divName) {
                            var printContents = document.getElementById(divName).innerHTML;
                            var originalContents = document.body.innerHTML;

                            document.body.innerHTML = printContents;
                            
                            window.print();

                            document.body.innerHTML = originalContents;
                        }
                    </script>

                <?php
                else :
                ?>
                    Cannot generate Due Certificate because the student have paid full fees.<br /><br />
                    <b>Total Fees</b>: <?php echo $feesDetails[0]->TotalValue ?><br />
                    <b>Fees Paid</b>: <?php echo $feesDetails[0]->TotalPaid ?><br />
                <?php
                endif;
                ?>
            </div>
        </div>
    </div>
</div>