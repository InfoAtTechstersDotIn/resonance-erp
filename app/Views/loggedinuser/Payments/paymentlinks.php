<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Payment Links
                </h2>
                <br />
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblPayments" class="DataTable table table-striped" style="width: 100% !important;">
                            <thead>
                                <tr>
                                    <th>Application Number</th>
                                    <th>Student Name</th>
                                    <th>Invoice Id</th>
                                    <th>Order Id</th>
                                    <th>Payment Status</th>
                                    <th>Payment Amount</th>
                                    <th>URL</th>
                                    <?php if ($_SESSION['rights'][array_search('Payment', array_column($_SESSION['rights'], 'operationname'))]->_edit == 1) : ?>
                                        <th>Send Notification</th>
                                    <?php endif; ?>
                                    <?php if ($_SESSION['rights'][array_search('Payment', array_column($_SESSION['rights'], 'operationname'))]->_delete == 1) : ?>
                                        <th>Cancel</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>

                            <tbody>
                                <?php

                                foreach ($PaymentLinks as $result) :
                                ?>
                                    <tr>
                                        <td><?php echo $result->applicationnumber ?></td>
                                        <td><a href="<?php echo base_url('users/studentdetails') ?>?id=<?php echo $result->userid; ?>"><?php echo $result->name ?></a></td>
                                        <td><?php echo $result->invoiceid ?></td>
                                        <td><?php echo $result->orderid ?></td>
                                        <td><?php echo $result->status ?></td>
                                        <td><?php echo $result->amount ?></td>
                                        <td><a target="_blank" href="<?php echo $result->url ?>"><?php echo $result->url ?></a></td>
                                        <?php if ($_SESSION['rights'][array_search('Payment', array_column($_SESSION['rights'], 'operationname'))]->_edit == 1) :
                                            echo "<td>";
                                            if ($result->status != "paid" && $result->status != "cancelled") { ?>

                                                <a onclick="notifyByEmail('<?php echo $result->invoiceid ?>')"><i class="fa fa-envelope-o"></i></a>
                                                &nbsp;&nbsp;&nbsp;
                                                <a onclick="notifyBySms('<?php echo $result->invoiceid ?>')"><i class="fa fa-commenting"></i></a>

                                        <?php }
                                            echo  "</td>";
                                        endif; ?>
                                        <?php if ($_SESSION['rights'][array_search('Payment', array_column($_SESSION['rights'], 'operationname'))]->_delete == 1) :
                                            echo "<td>";
                                            if ($result->status != "paid" && $result->status != "cancelled") {
                                        ?>
                                                <a onclick="cancelPayment('<?php echo $result->invoiceid ?>')"><i class="fa fa-ban"></i></a>
                                        <?php }
                                            echo  "</td>";
                                        endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>