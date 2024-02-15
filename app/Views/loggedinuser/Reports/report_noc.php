<?php
use App\Models\WalletModel;
 use App\Models\UsersModel;
                 use App\Models\HelperModel;
                use App\Models\PaymentsModel;
?>
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Noc Report
                </h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <style>
                            table,
                            th,
                            td {
                                border: 1px solid black;
                                border-collapse: collapse;
                            }
                        </style>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Branch Name</th>
                                    <th>Section Name</th>
                                    <th>Total No Of Students</th>
                                    <th>NOC Eligible Students</th>
                                    <th>NOC Not Eligible Students</th>
                                    <th>% Eligibility</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($report_noc != null) :
                                    $AllNocstudents=0;
                                    $AllnonNocstudents=0;
                                    $eligibilitypercent=0;
                                    foreach ($report_noc as $result) :
                                ?>
                                        <tr>
                                            <td>
                                                <b><?php echo $result->branchname ?></b>
                                            </td>
                                            <td>
                                                <?php echo $result->sectionname ?>
                                            </td>
                                            <td>
                                                <?php echo $result->studentcount ?>
                                            </td>
                                            <td>
                                                <?php
                                                 $paymentsModel = new PaymentsModel();
                                                $feesDetails = $paymentsModel->getInvoiceDetails($result->userid);
                                               $TotalValue=0;
                                                 foreach ($feesDetails as $result1) :
                                                if($result->batchid==$result1->batchid){
                                                    
                                            $TotalValue = $TotalValue+$result1->TotalValue; 
                                                }
                                            endforeach;
                                            $TotalPaid=0;
                                            foreach ($feesDetails as $result1) :
                                                if($result->batchid==$result1->batchid){
                                                    $TotalPaid = $result1->TotalPaid; 
                                                }
                                            endforeach;
                                                $Totalstudents=0;
                                                foreach($invoices as $invoice)
                                                {
                                                    if($invoice->sectionid == $result->sec && $invoice->branchid == $result->branch)
                                                    {
                                                        if($invoice->admissiontypeid==1){
                                                        $walletModel = new WalletModel();
                                                        $walletData = $walletModel->getWalletDetails($invoice->userid, 15);
                                                        $Laundry = COUNT($walletData) > 0 ? $walletData[0]->amount : 0;
                                                        
                                                            if(($Laundry) > 0){
                                                                if ($TotalPaid >= $TotalValue) {
                                                                    $Totalstudents++;
                                                                }
                                                            }
                                                        }   
                                                        else
                                                        {
                                                            if ($TotalPaid >= $TotalValue) {
                                                                $Totalstudents++;
                                                            }
                                                        }
                                                    }
                                                }
                                                $AllNocstudents = $AllNocstudents+$Totalstudents;
                                                echo $Totalstudents;
                                                ?>
                                            </td>
                                            <td>
                                                <?php 
                                                $AllnonNocstudents = $AllnonNocstudents + ($result->studentcount)-($Totalstudents);
                                                echo(($result->studentcount)-($Totalstudents));?>
                                            </td>
                                            <td>
                                                <?php
                                                $eligibilitypercent = $eligibilitypercent+number_format((float)$eligibility, 2, '.', '');
                                                $eligibility = ($Totalstudents/$result->studentcount)*100;
                                                echo number_format((float)$eligibility, 2, '.', '');
                                                ?>
                                            </td>
                                            
                                        </tr>
                                <?php endforeach;
                                endif; ?>
                                <?php
                                $studentcount = 0;
                                $TotalNocstudents = $AllNocstudents;
                                $TotalnonNocstudents = $AllnonNocstudents;
                                $eligibilitypercent = $eligibilitypercent;

                                if ($report_noc != null) :
                                    foreach ($report_noc as $result) :
                                        $studentcount += $result->studentcount;
                                    endforeach;
                                ?>
                                    <tr style="font-weight:bold">
                                        <td>
                                            Total
                                        </td>
                                        <td>
                                            
                                        </td>
                                        <td>
                                            <?php echo $studentcount; ?>
                                        </td>
                                        <td>
                                            <?php echo $TotalNocstudents; ?>
                                        </td>
                                        <td>
                                            <?php echo $TotalnonNocstudents; ?>
                                        </td>
                                        <td>
                                            <?php $eli = $eligibilitypercent/count($report_noc);
                                            echo number_format((float)$eli, 2, '.', '');
                                            ?>
                                        </td>
                                    </tr>
                                <?php
                                endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function filter(download = 0) {
        var URL = "<?php echo base_url('reports/report_revenue') ?>" + "?" + $('#filterForm').serialize();

        if (download == 1) {
            URL = URL + "&download=1";
        }

        window.location.href = URL;
    }
</script>