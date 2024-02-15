<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Employee Pay Sheet Report
                </h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            <form id="filterForm">
                    <div class="row">
                        <div class="col-md-4">
                            <?php if (isset($_GET['date'])) {
                                $date = $_GET['date'];
                            } else {
                                $date = '';
                            }
                            ?>
                            <label class="text-uppercase text-sm">Filter By Month/ Year</label>
                            <input type="month" name="date" class="form-control mb" required value="<?php echo $date; ?>">
                        </div>
                        <div class="col-md-4">
                            <br />
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </form>
                <a class="btn btn-primary" onclick="filter(1)">Download</a>
                </br>
                </br>
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
                                    <th>Employee Name</th>
                                    <th>Basic</th>
                                    <th>HRA</th>
                                    <th>Special Allowance</th>
                                    <th>Travel Allowance</th>
                                    <th>Basic Arrears</th>
                                    <th>Other Arrears</th>
                                    <th>Bonus</th>
                                    <th>Gross</th>
                                    <th>PT</th>
                                    <th>TDS</th>
                                    <th>Loan/Advance Deductions</th>
                                    <th>Penality</th>
                                    <th>Other Deductions</th>
                                    <th>Net</th>
                                    <th>Total Working Days</th>
                                    <th>Paid Days</th>
                                    <th>Unpaid Days</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($employeepaysheet != null) :
                                    foreach ($employeepaysheet as $result) :
                                ?>
                                        <tr>
                                            <td>
                                                <b><?php echo $result->name ?>(<?php echo $result->employeecode ?>)</b>
                                            </td>
                                             <td>
                                                <b><?php echo $result->basic ?></b>
                                            </td>
                                             <td>
                                                <b><?php echo $result->houserentalallowance	 ?></b>
                                            </td>
                                            <td>
                                                <b><?php echo $result->specialallowance ?></b>
                                            </td>
                                            <td>
                                                <b><?php echo $result->transportallowance ?></b>
                                            </td>
                                            <td>
                                               <b><?php echo $result->basic_arrears ?>
                                            </td>
                                            <td>
                                            
                                            <b><?php echo $result->other_arrears ?></b>
                                            </td>
                                            <td>
                                            
                                            <b><?php echo $result->bonus ?></b>
                                            </td>
                                            <td>
                                            
                                            <b><?php echo $result->gross ?></b>
                                            </td>
                                            <td>
                                            
                                            <b><?php echo $result->pt ?></b>
                                            </td>
                                            <td>
                                            
                                            <b><?php echo $result->tds ?></b>
                                            </td>
                                            <td>
                                            
                                            <b><?php echo $result->emi_deduction ?></b>
                                            </td>
                                            <td>
                                            
                                            <b><?php echo $result->penalty ?></b>
                                            </td>
                                            <td>
                                            
                                            <b><?php echo $result->other_decuctions ?></b>
                                            </td>
                                            <td>
                                            
                                            <b><?php echo $result->net ?></b>
                                            </td>
                                            <td>
                                            
                                            <b><?php echo $result->totalbusinessdays ?></b>
                                            </td>
                                            <td>
                                            
                                            <b><?php echo $result->paiddays ?></b>
                                            </td>
                                            <td>
                                            
                                            <b><?php echo $result->unpaiddays ?></b>
                                            </td>
                                           
                                        </tr>
                                        
                                <?php endforeach;
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
        var URL = "<?php echo base_url('reports/report_employeepaysheet') ?>" + "?" + $('#filterForm').serialize();

        if (download == 1) {
            URL = URL + "&download=1";
        }

        window.location.href = URL;
    }
</script>