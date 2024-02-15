<div class="salary-slip">
    <table class="empDetail" style="border-bottom:none !important;">
    <tr height="100px">
            <!-- <td colspan='4'>
                <img height="90px" src='<?php echo base_url('images/logo1.png') ?>' />
            </td> -->
            
            <td  class="companyName1"><img style="margin-left:50px;" width="140" height="60" src='<?php echo base_url('images/maidendrop.png') ?>' /></td>
           <td> <img style="margin-left:200px;" width="140" height="50" src='<?php echo base_url('images/logo1.png') ?>' /></td>
        </tr>
</table>
        <table class="empDetail" style="border-top:none !important;">
        <tr height="100px">
            <!-- <td colspan='4'>
                <img height="90px" src='<?php echo base_url('images/logo.png') ?>' />
            </td> -->
            <td  class="companyName">Maiden Drop Edu Foundation</td>
        </tr>
        <tr >
            <!-- <td colspan='4'>
                <img height="90px" src='<?php echo base_url('images/logo.png') ?>' />
            </td> -->
            <td style="text-align:center">Plot No:388, Kakateeya Hills Rd 8,Guttala Begumpet, Kavuri Hills, Madhapur,Hyderabad-500081


</td>
        </tr>
        <tr >
            <!-- <td colspan='4'>
                <img height="90px" src='<?php echo base_url('images/logo.png') ?>' />
            </td> -->
            <td style="text-align:center;padding-bottom:10px">
            <?php 
             $orgDate = $payment_data->salarydate;  
             $newDate = date("M Y", strtotime($orgDate));  
             $orgDate = $payment_data->joiningdate;  
             $newDate1 = date("d M Y", strtotime($orgDate));  
             $newMonth = date("m", strtotime($orgDate));
             $newYear = date("Y", strtotime($orgDate));
            ?>
            
            <b>Payslip for the month of <?php echo $newDate;?></b>


</td>
        </tr>
</table>
        <!-- <tr>
            <th>
                Name
            </th>
            <td>
                <?php echo $payment_data->name ?>
            </td>
            <td></td>
            <th>
                Employee Code
            </th>
            <td>
                <?php echo $payment_data->employeeid ?>

            </td>
            <td></td>
            <th>
                Job Description
            </th>
            <td>
                <?php echo $payment_data->designation ?>

            </td>
        </tr> -->
        <!-- <tr>
            <th>
                Pay Period
            </th>
            <td>
                <?php echo date_format(date_create($payment_data->salarydate), "M-Y") ?>

            </td>
            <td></td>
            <th>
                Payslip No.
            </th>
            <td>
                <?php echo $salaryPaymentId ?>

            </td>
            <td></td>
            <th></th>
            <td></td>
        </tr> -->
        <table class="empDetail">
        <tr class="myBackground" style="border-top:1px solid black;">
            <th colspan="2">
                Name
            </th>
        
            <th colspan="2" class="table-border-right ">
            <?php echo $payment_data->name ?>
            </th>
            <th colspan="2">
            Bank Name
            </th>
         
            <td colspan="2">
            <?php echo $payment_data->bank_name ?>
            </td>
        </tr>

        <tr class="myBackground">
            <th colspan="2">
            Designation
            </th>
        
            <th colspan="2" class="table-border-right ">
            <?php echo $payment_data->designation ?>
            </th>
            <th colspan="2">
            Bank Account No:
            </th>
         
            <th colspan="2">
            <?php echo $payment_data->account_no; ?>
            </th>
        </tr>
        <tr class="myBackground">
            <th colspan="2">
            Joining Date:
            </th>
        
            <th colspan="2" class="table-border-right ">
            <?php echo $newDate1; ?>
            </th>
            <th colspan="2">
            IFSC Code
            </th>
         
            <th colspan="2">
            <?php echo $payment_data->ifsc_code; ?>
            </th>
        </tr>
        <tr class="myBackground">
            <th colspan="2">
            Effective Work Days:
            </th>
        
            <th colspan="2" class="table-border-right ">
            <?php echo $payment_data->totalbusinessdays; ?>
            </th>
            <th colspan="2">
            PAN
            </th>
         
            <th colspan="2">
            <?php echo $payment_data->pancard; ?>
            </th>
        </tr>
        <tr class="myBackground">
            <th colspan="2">
            Days In Month:
            </th>
        
            <th colspan="2" class="table-border-right ">
            <?php echo cal_days_in_month(CAL_GREGORIAN, $newMonth, $newYear) ?>
            </th>
            <th colspan="2">
            Paid Days
            </th>
         
            <th colspan="2">
            <?php echo $payment_data->paiddays; ?>
            </th>
        </tr>
        

        <tr class="myBackground" style="border: 1px solid black;">
            <th colspan="2">
            <b>Earnings</b>
            </th>
        
            <th  class="">
            <!-- Full -->
            </th>

            <th  class="table-border-right ">
            Rs. 
            </th>
            <th colspan="2">
               <b> Deductions</b>
            </th>
            <th colspan="2" style="text-align: right !important;">
            Rs.
            </th>
        </tr>

        <tr class="myBackground">
            <th colspan="2">
            BASIC
            </th>
        
            <th  class="">
            <!-- <?php echo $payment_data->basic ?> -->
            </th>

            <th  class="table-border-right ">
            <?php echo $payment_data->basic ?>
            </th>
            <th colspan="2">
            PF
            </th>
            <th colspan="2" style="text-align: right !important;">
            0.00
            </th>
        </tr>


        <tr class="myBackground">
            <th colspan="2">
            HRA
            </th>
        
            <th  class="">
            <!-- <?php echo $payment_data->houserentalallowance ?> -->
            </th>

            <th  class="table-border-right ">
            <?php echo $payment_data->houserentalallowance ?>
            </th>
            <th colspan="2">
            PROF TAX
            </th>
            <th colspan="2" style="text-align: right !important;">
            <?php echo $payment_data->pt ?>
            </th>
        </tr>

        <tr class="myBackground">
            <th colspan="2">
            SPECIAL ALLOWANCE
            </th>
        
            <th  class="">
            <!-- <?php echo $payment_data->specialallowance ?> -->
            </th>

            <th  class="table-border-right ">
            <?php echo $payment_data->specialallowance ?>
            </th>
            <th colspan="2">
            TDS
            </th>
            <th colspan="2" style="text-align: right !important;">
            <?php echo $payment_data->tds ?>
            </th>
        </tr>

        <tr class="myBackground">
            <th colspan="2">
            BONUS	
            </th>
        
            <th  class="">
            <!-- <?php echo $payment_data->bonus ?> -->
            </th>

            <th  class="table-border-right ">
            <?php echo $payment_data->bonus ?>
            </th>
            <th colspan="2">
            Advance/Loan Deduction
            </th>
            <th colspan="2" style="text-align: right !important;">
            <?php echo $payment_data->emi_deduction ?>
            </th>
        </tr>

        <tr class="myBackground">
            <th colspan="2">
            Travelling Allowance	
            </th>
        
            <th  class="">
            <!-- <?php echo $payment_data->transportallowance ?> -->

            </th>

            <th  class="table-border-right ">
            <?php echo $payment_data->transportallowance ?>

            </th>
            <th colspan="2">
            Other Deduction
            </th>
            <th colspan="2" style="text-align: right !important;">
            <?php echo $payment_data->other_decuctions ?>
            </th>
        </tr>
        <tr class="myBackground">
            <th colspan="2">
            Basic Arrears	
            </th>
        
            <th  class="">
            <!-- <?php echo $payment_data->basic_arrears ?> -->

            </th>

            <th  class="table-border-right ">
            <?php echo $payment_data->basic_arrears ?>

            </th>
            <th colspan="2">
            LOP
            </th>
            <th colspan="2" style="text-align: right !important;">
            <?php echo $payment_data->penalty ?>
            </th>
        </tr>
        <tr class="myBackground">
            <th colspan="2">
            Other Arrears	
            </th>
        
            <th  class="">
            <!-- <?php echo $payment_data->other_arrears ?> -->

            </th>

            <th  class="table-border-right ">
            <?php echo $payment_data->other_arrears ?>

            </th>
            <th colspan="2">
            
            </th>
            <th colspan="2" style="text-align: right !important;">
            
            </th>
        </tr>

        <tr class="myBackground" style="border: 1px solid black;">
            <th colspan="2">
          <b>Gross</b>	
            </th>
        
            <th  class="">
            <!-- <?php echo $payment_data->gross ?> -->
            </th>

            <th  class="table-border-right ">
            <?php echo $payment_data->gross ?>
            </th>
            <th colspan="2">
            <b>Total Deduction</b>
            </th>
            <th colspan="2" style="text-align: right !important;">
            <?php echo $payment_data->pt + $payment_data->tds + $payment_data->emi_deduction + $payment_data->other_decuctions + $payment_data->penalty ?>
            </th>
        </tr>

       

       <!-- <tr class="myBackground">
            <th colspan="2">
          <b>Total Earnings</b>
            </th>
        
            <th  class="">
            <?php echo $payment_data->net ?>
            </th>

            <th  class="table-border-right ">
            <?php echo $payment_data->net ?>
            </th>
            <th colspan="2">
          
            </th>
            <th colspan="2">
         
            </th>
        </tr> -->


        <tr class="myBackground" style="border-top:1px solid black">
            <th colspan="4">
          <b>Net Pay for the month ( Gross - Total Deductions): Rs - <?php echo $payment_data->net ?></b>
            </th>
            
            <th colspan="4">
          <b>
          <?php
          $number = $payment_data->net;
          $no = floor($number);
          $point = round($number - $no, 2) * 100;
          $hundred = null;
          $digits_1 = strlen($no);
          $i = 0;
          $str = array();
          $words = array('0' => '', '1' => 'One', '2' => 'Two',
           '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
           '7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
           '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
           '13' => 'Thirteen', '14' => 'Fourteen',
           '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
           '18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
           '30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
           '60' => 'Sixty', '70' => 'Seventy',
           '80' => 'Eighty', '90' => 'Ninety');
          $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
          while ($i < $digits_1) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += ($divider == 10) ? 1 : 2;
            if ($number) {
               $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
               $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
               $str [] = ($number < 21) ? $words[$number] .
                   " " . $digits[$counter] . $plural . " " . $hundred
                   :
                   $words[floor($number / 10) * 10]
                   . " " . $words[$number % 10] . " "
                   . $digits[$counter] . $plural . " " . $hundred;
            } else $str[] = null;
         }
         $str = array_reverse($str);
         $result = implode('', $str);
         $points = ($point) ?
           "." . $words[$point / 10] . " " . 
                 $words[$point = $point % 10] : '';
         echo $result . "Rupees  " . $points . " Paise";
        ?>   
          </b>
            </th>
            <!-- <th  class="table-border-right ">
            1,800.00
            </th>

            <th  class="table-border-right ">
            1,800.00
            </th>
            <th colspan="2">
          
            </th>
            <th colspan="2">
         
            </th> -->
        </tr>


       










        <!-- <tr>
            <th colspan="2">
                Basic Salary
            </th>
            <td></td>
            <td class="myAlign">
                <?php echo $payment_data->basic ?>

            </td>

        </tr> -->
        <!-- <tr>
            <th colspan="2">
                House Rental Allowance
            </th>
            <td></td>

            <td class="myAlign">
                <?php echo $payment_data->houserentalallowance ?>

            </td>
            <th colspan="2">
                
            </th>
            <td></td>

            <td class="myAlign">
              

            </td>
        </tr> -->
        <!-- <tr>
            <th colspan="2">
                Transport Allowance
            </th>
            <td></td>

            <td class="myAlign">
                <?php echo $payment_data->transportallowance ?>

            </td>
            <th colspan="2">
                PT
            </th>
            <td></td>

            <td class="myAlign">
                <?php echo $payment_data->pt ?>

            </td>
        </tr> -->
        <!-- <tr>
          
            <th colspan="2">
                Special Allowance
            </th>
            <td></td>
            <td class="myAlign">
                <?php echo $payment_data->specialallowance ?>

            </td>
            <th colspan="2">
                EMI Deductions
            </th>
            <td></td>

            <td class="myAlign">
                <?php echo $payment_data->emi_deduction ?>

            </td>
        </tr> -->
        <!-- <tr>
        <th colspan="2">
                Bonus
            </th>
            <td></td>
            <td class="myAlign">
                <?php echo $payment_data->bonus ?>

            </td>
            <th colspan="2">
                TDS
            </th>
            <td></td>
            <td class="myAlign">
                <?php echo $payment_data->tds ?>

            </td>
        </tr> -->
        <!-- <tr>
            
            <th colspan="2">
                Penalty
            </th>
            <td></td>
            <td class="myAlign">
                <?php echo $payment_data->penalty ?>

            </td>
        </tr> -->
        <!-- <tr class="myBackground">
            <th colspan="3">
                Gross Salary
            </th>
            <td class="myAlign">
                <?php echo $payment_data->gross ?>

            </td>
            <th colspan="3">
                Net Salary
            </th>
            <td class="myAlign">
                <?php echo $payment_data->net ?>

            </td>
        </tr> -->

        <!-- <tbody class="border-center">
            <tr>
                <th colspan="2">
                    Attend/ Absence
                </th>
                <th colspan="2">
                    Days in Month
                </th>
                <th colspan="2">
                    Days Paid
                </th>
                <th colspan="2">
                    Days Not Paid
                </th>
            </tr>
            <tr>
                <th colspan="2">Current Month</th>
                <td colspan="2"><?php echo $payment_data->totalbusinessdays; ?></td>
                <td colspan="2"><?php echo $payment_data->paiddays; ?></td>
                <td colspan="2"><?php echo $payment_data->unpaiddays; ?></td>
            </tr>
            <tr>
                <th colspan="2">Comments</th>
                <td colspan="6"><?php echo $payment_data->comments; ?></td>
            </tr>
        </tbody> -->
    </table>

</div>
<style>
    .salary-slip {
        margin: 15px;
    margin: auto;
    width: 80%;
    }

    .empDetail {
        width: 100%;
        text-align: left;
        border: 2px solid black;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .empDetail1 {
        width: 100%;
        text-align: left;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .head {
        margin: 10px;
        margin-bottom: 50px;
        width: 100%;
    }

    .companyName {
        text-align: center;
        font-size: 25px;
        font-weight: bold;
        padding-top:20px;
    }
    .companyName1{
        
        padding-top:8px;
        margin-top:200px;
    }

    .salaryMonth {
        text-align: center;
    }

    .table-border-bottom {
        border-bottom: 1px solid;
    }

    .table-border-right {
        border-right: 1px solid;
    }

    .myBackground {
        padding-top: 10px;
        text-align: left;
        /* border: 1px solid black; */
        height: 40px;
    }

    .myAlign {
        text-align: center;
        border-right: 1px solid black;
    }

    .myTotalBackground {
        padding-top: 10px;
        text-align: left;
        background-color: #EBF1DE;
        border-spacing: 0px;
    }
    th{
        text-align: left !important;
        font-weight:12px;
        padding:5px 5px;
    }
    .align-4 {
        width: 25%;
        float: left;
    }

    .tail {
        margin-top: 35px;
    }

    .align-2 {
        margin-top: 25px;
        width: 50%;
        float: left;
    }

    .border-center {
        text-align: center;
    }

    .border-center th,
    .border-center td {
        border: 1px solid black;
    }

    th,
    td {
        padding-left: 6px;
    }
</style>