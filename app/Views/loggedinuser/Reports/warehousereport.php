
<div class="content-wrapper">
    <div class="container-fluid">
         <?php
         if ($_SESSION['rights'][array_search('WarehouseManager', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) :
             ?>
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Ware House Inventory Report
                </h2>
            </div>
        </div>
       <!-- <form id="filterForm">
            <div class="row">
                <div class="col-md-3">
                    <label class="text-uppercase text-sm">Branch</label>
                    <select name="branchid" id="branchid" onchange="filter(0)" style="width: 100%;" class="form-control mb">
                        <option value="">Select</option>
                        <?php
                        foreach ($lookups['branchlookup'] as $result) :
                        ?>
                            <option value="<?php echo $result->branchid; ?>" <?php echo (isset($_GET['branchid']) && $_GET['branchid'] != "" && $_GET['branchid'] == $result->branchid) ? "selected" : "" ?>><?php echo $result->branchname; ?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="text-uppercase text-sm">Wallet Type</label>
                    <select name="wallettypeid" id="wallettypeid" onchange="filter(0)" style="width: 100%;" class="form-control mb">
                        <option value="">Select</option>
                        <?php
                        foreach ($lookups['wallettypelookup'] as $result) :
                        ?>
                            <option value="<?php echo $result->wallettypeid; ?>" <?php echo (isset($_GET['wallettypeid']) && $_GET['wallettypeid'] != "" && $_GET['wallettypeid'] == $result->wallettypeid) ? "selected" : "" ?>><?php echo $result->wallettypename; ?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </div>
            </div>
        </form> -->
        
        <div class="row">
            <div class="col-md-12">
                 <a class="btn btn-primary" onclick="filter(1)">Download</a>
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
                                             <?php echo $result->quantity ?><br />
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
         <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Inventory Manager Report
                </h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-primary" onclick="filter(2)">Download</a>
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
                                    <th>Name</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                               
                                if ($allinventory != null) :
                                    foreach ($allinventory as $result) :
                                ?>
                                        <tr>
                                             <td>
                                                <?php echo $result->employeename ?><br />
                                            </td>
                                            <td>
                                                <?php echo $result->name ?><br />
                                            </td>
                                            <td>
                                             <?php echo $result->quantity ?><br />
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
        
         <br>
         <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Inventory Manager Distribute list Report
                </h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-primary" onclick="filter(3)">Download</a>
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
                                    <th>Name</th>
                                     <th>Application Number</th>
                                    <th>Student Name</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                               
                                if ($getdistributeinventory != null) :
                                    foreach ($getdistributeinventory as $result) :
                                      
                                ?>
                                        <tr>
                                             <td>
                                                <?php echo $result->employeename ?><br />
                                            </td>
                                            <td>
                                                <?php echo $result->applicationnumber ?><br />
                                            </td>
                                            <td>
                                                <?php echo $result->studentname ?><br />
                                            </td>
                                            <td>
                                                <?php echo $result->name ?><br />
                                            </td>
                                            <td>
                                             <?php echo $result->quantity ?><br />
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
        var URL = "<?php echo base_url('inventory/warehousereport') ?>" + "?" + $('#filterForm').serialize();

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