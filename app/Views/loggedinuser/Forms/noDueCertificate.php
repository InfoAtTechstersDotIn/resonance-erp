<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">No Due Certificate
                </h2>
                <?php
                    use App\Models\HelperModel;
                           $helperModel = new HelperModel();
                                             
                                            $promoted = $helperModel->studentcount($studentDetails[0]->userid,$_SESSION['activebatch']);
                                            $TotalValue=0;
                                            foreach ($feesDetails as $result) :
                                                if($studentDetails[0]->batchid==$result->batchid){
                                            $TotalValue = $TotalValue+$result->TotalValue; 
                                                }
                                            endforeach;
                                           // echo  $TotalValue.'.00';
                                            
                                             $TotalPaid=0;
                                            foreach ($feesDetails as $result1) :
                                                if($studentDetails[0]->batchid==$result1->batchid){
                                                    $TotalPaid = $result1->TotalPaid; 
                                                }
                                            endforeach;
                                            $myString =  $studentDetails[0]->applicationnumber ;
                                            
                                             if ($myString > 2300001){
                                                    $TotalPaid = $TotalPaid-2500;
                                                }
                                            
                                            elseif ($myString > 2200001 && $promoted==1) {
                                                $TotalPaid = $TotalPaid-2500;
                                               // echo  $TotalPaid.".00";
                                            }else
                                            {
                                                
                                            }
                                             $RemainingAmount = $TotalValue - $TotalPaid.'.00';
                                           // echo $TotalValue - $TotalPaid.'.00';
                                           // exit();
                if (($TotalPaid >= $TotalValue && $studentDetails[0]->admissiontypename == "Residential") ||
                    ($TotalPaid >= $TotalValue && $studentDetails[0]->admissiontypename != "Residential")
                ) :
                ?>
                    <a class="btn btn-success" onclick="printDiv('div')">Print</a>

                    <div class="row">
                        <div class="col-md-12" id="div" style="visibility: hidden;">
                            <div class="scale">
                                <p style="text-align: center;"><img src="<?php echo base_url('images/logo.png') ?>" width="110" height="110" /></p>
                                <br />
                                <br />
                                <h2 style="text-align: center;"><strong><u>NO DUE CERTIFICATE</u></strong></h2>
                                <br />
                                <br />
                                <p style="text-align: right;">Date: <?php echo date("d-m-Y"); ?><br />Hyderabad</p>
                                <br />
                                <br />
                                <p style="text-align: justify;">It is to certify that <?php echo $studentDetails[0]->gendername == "Male" ? "Mr." : "Ms."; ?> <?php echo $studentDetails[0]->name; ?> <?php echo $studentDetails[0]->gendername == "Male" ? "S/o" : "D/o"; ?> <?php echo $studentDetails[0]->fathername; ?>
                                    studied in our college in <?php echo $studentDetails[0]->coursename; ?> for the Acadamic year <?php echo $studentDetails[0]->batchname; ?>
                                    with Application No. <?php echo $studentDetails[0]->applicationnumber; ?> in <?php echo $studentDetails[0]->branchname; ?> has cleared the Total fee as on Date <?php echo date("d-m-Y"); ?>.</p>
                                <br />
                                <br />
                                <br />
                                <p>ACCOUNTANT
                                    <span style="float:right">PRINCIPAL</span>
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
                    Cannot generate No Due Certificate because the student haven't paid full fees.<br /><br />
                    <b>Total Fees</b>: <?php echo $TotalValue ?><br />
                    <b>Fees Paid</b>: <?php echo $TotalPaid ?><br />
                    <b>Remaining Fees</b>: <?php echo $RemainingAmount ?><br />
                    <b>Laundry</b>: <?php echo $Laundry ?><br />
                <?php
                endif;
                ?>
            </div>
        </div>
    </div>
</div>