<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">
                    Edit Payslip
                </h2>
                <div class="row">
                    <div class="col-md-12">
                        <form method="post" action="<?php echo base_url('payroll/update_payslip') . "/" . $salaryPaymentId ?>">
                            <table class="table">
                                <tr>
                                    <td><b>Employee Name - Employee Id</b></td>
                                    <td><?php echo $payment_data->name . " ({$payment_data->employeeid}) " ?></td>
                                </tr>
                                <tr>
                                    <td><b>Salary Date</b></td>
                                    <td><?php echo date_format(date_create($payment_data->salarydate), "M-Y") ?></td>
                                </tr>
                                <tr>
                                    <td><b>CTC</b></td>
                                    <td><input disabled type="number" id="ctc" name="ctc" value="<?php echo $payment_data->ctc ?>" /></td>
                                </tr>
                                <tr>
                                    <td><b>Monthly</b></td>
                                    <td><input disabled type="number" id="monthly" name="monthly" value="<?php echo $payment_data->monthly ?>" /></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th colspan="2" style="font-size: 20px;">Earnings</th>
                                </tr>
                                <tr>
                                    <th>Description</th>
                                    <th>Rs.</th>
                                </tr>
                                <tr>
                                    <td>Basic</td>
                                    <td><input disabled type="number" id="basic" name="basic" value="<?php echo $payment_data->basic ?>" /></td>
                                </tr>
                                <tr>
                                    <td>HRA</td>
                                    <td><input disabled type="number" id="houserentalallowance" name="houserentalallowance" value="<?php echo $payment_data->houserentalallowance ?>" /></td>
                                </tr>
                                <tr>
                                    <td>Special Allowance</td>
                                    <td><input disabled type="number" id="specialallowance" name="specialallowance" value="<?php echo $payment_data->specialallowance ?>" /></td>
                                </tr>
                                <tr>
                                    <td>Transport Allowance</td>
                                    <td><input type="number" onchange="recalculate()" id="transportallowance" name="transportallowance" value="<?php echo $payment_data->transportallowance ?>" /></td>
                                </tr>
                                <tr>
                                    <td>Basic Arrears</td>
                                    <td><input type="number" onchange="recalculate()" id="basic_arrears" name="basic_arrears" value="<?php echo $payment_data->basic_arrears ?>" /></td>
                                </tr>
                                <tr>
                                    <td>Other Arrears</td>
                                    <td><input type="number" onchange="recalculate()" id="other_arrears" name="other_arrears" value="<?php echo $payment_data->other_arrears ?>" /></td>
                                </tr>
                                <tr>
                                    <td>Other Arrears Comments</td>
                                    <td>
                                        <textarea id="arrearscomments" name="arrearscomments">
                                            <?php echo $payment_data->arrearscomments ?>
                                        </textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Bonus</td>
                                    <td><input onchange="recalculate()" type="number" id="bonus" name="bonus" value="<?php echo $payment_data->bonus ?>" /></td>
                                </tr>
                                <tr>
                                    <td><b>Total Gross</b></td>
                                    <td><input readonly type="number" id="gross" name="gross" value="<?php echo $payment_data->gross ?>" /></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th colspan="2" style="font-size: 20px;">Deductions</th>
                                </tr>
                                <tr>
                                    <th>Description</th>
                                    <th>Rs.</th>
                                </tr>
                                <tr>
                                    <td>PT</td>
                                    <td><input disabled type="number" id="pt" name="pt" value="<?php echo $payment_data->pt ?>" /></td>
                                </tr>
                                <tr>
                                    <td>TDS</td>
                                    <td><input disabled type="number" id="tds" name="tds" value="<?php echo $payment_data->tds ?>" /></td>
                                </tr>
                                <tr>
                                    <td>EMI Deductions</td>
                                    <td><input disabled type="number" id="tds" name="tds" value="<?php echo $payment_data->emi_deduction ?>" /></td>
                                </tr>
                                <tr>
                                    <td>Penalty</td>
                                    <td><input onchange="recalculate()" type="number" id="penalty" name="penalty" value="<?php echo $payment_data->penalty ?>" /></td>
                                </tr>
                                <tr>
                                    <td>Other Deductions</td>
                                    <td><input onchange="recalculate()" type="number" id="other_decuctions" name="other_decuctions" value="<?php echo $payment_data->other_decuctions ?>" /></td>
                                </tr>
                                <tr>
                                    <td>Deduction Comments</td>
                                    <td>
                                        <textarea id="deductioncomments" name="deductioncomments">
                                            <?php echo $payment_data->deductioncomments ?>
                                        </textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th colspan="2" style="font-size: 20px;">Salary Net Pay</th>
                                </tr>
                                <tr>
                                    <th>Description</th>
                                    <th>Rs.</th>
                                </tr>
                                <tr>

                                <tr>
                                    <td>Take Home Salary</td>
                                    <td>
                                        <input readonly type="number" id="net" name="net" value="<?php echo $payment_data->net ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Comments</td>
                                    <td>
                                        <textarea id="comments" name="comments">
                                            <?php echo $payment_data->comments ?>
                                        </textarea>
                                    </td>
                                </tr>
                            </table>
                            <button type="submit" class="btn btn-primary">Update Payslip</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function recalculate() {
        var ctc = document.getElementById('ctc');
        var monthly = document.getElementById('monthly');
        var basic = document.getElementById('basic');
        var houserentalallowance = document.getElementById('houserentalallowance');
        var specialallowance = document.getElementById('specialallowance');

        var transportallowance = document.getElementById('transportallowance');
        var basic_arrears = document.getElementById('basic_arrears');
        var other_arrears = document.getElementById('other_arrears');
        var bonus = document.getElementById('bonus');

        debugger;

        var gross = parseFloat(basic.value) + parseFloat(houserentalallowance.value) +
            parseFloat(specialallowance.value) + parseFloat(transportallowance.value) +
            parseFloat(basic_arrears.value) + parseFloat(other_arrears.value) +
            parseFloat(bonus.value);

        document.getElementById('gross').value = gross;

        var pt = document.getElementById('pt');
        var tds = document.getElementById('tds');
        var penalty = document.getElementById('penalty');
        var other_decuctions = document.getElementById('other_decuctions');

        var deductions = parseFloat(pt.value) + parseFloat(tds.value) +
            parseFloat(penalty.value) + parseFloat(other_decuctions.value);

        var net = gross - deductions;

        document.getElementById('net').value = net;
    }
</script>