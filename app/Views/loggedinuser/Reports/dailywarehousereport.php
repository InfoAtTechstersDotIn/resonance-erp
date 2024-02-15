
<div class="content-wrapper">
    <div class="container-fluid">
         <?php
         if ($_SESSION['rights'][array_search('WarehouseManager', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) :
             ?>
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Ware House Daily IN stock Report
                </h2>
            </div>
        </div>
        <form id="filterForm">
            <div class="row">
               <div class="col-md-3">
                    <label class="text-uppercase text-sm">Date</label>
                    <input type="text" onchange="filter(0)" placeholder="Date" name="DateFrom" class="datepicker form-control mb" value="<?php echo (isset($_GET['DateFrom']) && $_GET['DateFrom'] != "") ? $_GET['DateFrom'] : "" ?>">
                </div>
                 <div class="col-md-3">
                    <label class="text-uppercase text-sm">To Date</label>
                    <input type="text" onchange="filter(0)" placeholder="Date" name="DateTo" class="datepicker form-control mb" value="<?php echo (isset($_GET['DateTo']) && $_GET['DateTo'] != "") ? $_GET['DateTo'] : "" ?>">
                </div>
            </div>
        </form>
        
        <div class="row">
            <div class="col-md-12">
                 <a class="btn btn-primary" onclick="filter(1)">Download In stock</a>
            <br>
            <br>
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
                        <table class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                               
                                if ($getallinventorywarehouse != null) :
                                    foreach ($getallinventorywarehouse as $result) :
                                ?>
                                        <tr>
                                            <td>
                                                <?php echo $result->name ?><br />
                                            </td>
                                            <td>
                                             <?php echo $result->count ?><br />
                                            </td>
                                            <td>
                                                <?php echo $result->created_timestamp ?><br />
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
         <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Ware House Daily OUT stock Report
                </h2>
            </div>
        </div>
              <div class="row">
            <div class="col-md-12">
                 <a class="btn btn-primary" onclick="filter(2)">Download Out stock</a>
            <br>
            <br>
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
                        <table class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Branch</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                               
                                if ($getallinventorywarehouse1 != null) :
                                    foreach ($getallinventorywarehouse1 as $result) :
                                ?>
                                        <tr>
                                            <td>
                                                <?php echo $result->name ?><br />
                                            </td>
                                            <td>
                                             <?php echo $result->count ?><br />
                                            </td>
                                            <td>
                                             <?php echo $result->branchname ?><br />
                                            </td>
                                            <td>
                                                <?php echo $result->created_timestamp ?><br />
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
        <?php endif; ?>
        <br>
        
    </div>
</div>

<script>
    function filter(download = 0) {
        var URL = "<?php echo base_url('inventory/warehousedailyreport') ?>" + "?" + $('#filterForm').serialize();

        if (download == 1) {
            URL = URL + "&download=1";
        }
        
        if (download == 2) {
            URL = URL + "&download=2";
        }
         if (download == 3) {
            URL = URL + "&download=3";
        }

        window.location.href = URL;
    }
</script>