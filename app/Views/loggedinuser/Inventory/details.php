<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Inventory Details

                    <?php 
                    
                    if ($_SESSION['rights'][array_search('WarehouseManager', array_column($_SESSION['rights'], 'operationname'))]->_add == 1) : ?>
                        <a class="btn btn-success" style="float: right;" href='createinventory'>Add Invetory</a>
                    <?php endif; ?>
                    <?php if ($_SESSION['rights'][array_search('WarehouseManager', array_column($_SESSION['rights'], 'operationname'))]->_edit == 1) : ?>
                        <a class="btn btn-success" style="float: right;margin-right:10px" data-toggle="modal" data-target="#bulkTransfer">Bulk Transfer</a>
                    <?php endif; ?>

                    <?php if ($_SESSION['rights'][array_search('InventoryManager', array_column($_SESSION['rights'], 'operationname'))]->_edit == 1) : ?>
                        <a class="btn btn-success" style="float: right;margin-right:10px" data-toggle="modal" data-target="#bulkDistribute">Bulk Distribute</a>
                    <?php endif; ?>
                </h2>
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblotherusers" class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Product Type</th>
                                    <th>Product Category</th>
                                    <?php if($id !=""){    ?>
                                    <th>Receipt</th>
                                    <?php } ?>
                                    <th>Total Quantity</th>
                                    <th>Available Quantity</th>
                                    <th>Received Date</th>
                                    <?php
                                    if($id ==""){
                                    if ($_SESSION['rights'][array_search('WarehouseManager', array_column($_SESSION['rights'], 'operationname'))]->_edit == 1) : ?>
                                        <th>Transfer</th>
                                    <?php endif; ?>

                                    <?php if ($_SESSION['rights'][array_search('InventoryManager', array_column($_SESSION['rights'], 'operationname'))]->_edit == 1) : ?>
                                        <th>Distribute</th>
                                        <th>Return</th>
                                    <?php endif; } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($inventory as $result) :
                                ?>
                                    <tr>
                                        <td>
                                       <?php if($id ==""){    ?>
                                        <a href="details/<?php echo $result->productid;  ?>" target="_blank"><?php echo $result->productname ;  ?></a>
                                    <?php }else{
                                        ?>
                                    <?php echo $result->productname ;  ?>
                                        <?php
                                    } ?>
                                    </td>
                                        <td><?php echo $result->type;?></td>
                                        <td><?php echo $result->category ?></td>
                                        <?php if($id !=""){    ?>
                                        <td><?php echo $result->receipt ?></td>
                                        <?php } ?>
                                        <td><?php echo $result->quantity . " {$result->productby}" ?></td>
                                        <td><?php echo $result->available_quantity . " {$result->productby}" ?></td>
                                        <td><?php echo date_format(date_create($result->created_timestamp), 'd/m/Y') ?></td>
                                        <?php if ($_SESSION['rights'][array_search('WarehouseManager', array_column($_SESSION['rights'], 'operationname'))]->_edit == 1) : 
                                            if($id==null){
                                            ?>

                                            <td>
                                                <?php if ($result->available_quantity > 0) : ?>
                                                    <a href="<?php echo base_url('Inventory/Transfer?inventorydetailsid=' . $result->id) ?>"><i class='fa fa-exchange'></i></a>
                                                <?php endif; ?>
                                            </td>
                                        <?php } endif; ?>

                                        <?php if ($_SESSION['rights'][array_search('InventoryManager', array_column($_SESSION['rights'], 'operationname'))]->_edit == 1) : ?>
                                            <td>
                                                <?php
                                                if ($result->product_received == 0) : ?>
                                                    Did you receive this?
                                                    <input type="checkbox" onclick="confirm('Are you sure?') && itemReceived('<?php echo $result->id ?>','<?php echo $_SESSION['userdetails']->userid; ?>')" />
                                                <?php
                                                else : ?>
                                                    <?php if ($result->available_quantity > 0) : ?>
                                                        <a href="<?php echo base_url('Inventory/Distribute?inventorydetailsid=' . $result->id) ?>"><i class='fa fa-paper-plane'></i></a>
                                                    <?php endif; ?>
                                                <?php
                                                endif; ?>
                                            </td>
                                            <td>
                                                 <?php if ($result->available_quantity > 0) : ?>
                                                        <a href="<?php echo base_url('Inventory/Return?inventorydetailsid=' . $result->id) ?>"><i class='fa fa-exchange'></i></a>
                                                    <?php endif; ?>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <?php if ($_SESSION['rights'][array_search('WarehouseManager', array_column($_SESSION['rights'], 'operationname'))]->_edit == 1) : 
                if($id ==null){
                ?>
                <div class="col-md-12">
                    <h2 class="page-title">My Transfers
                    </h2>
                    <a class="btn btn-primary" onclick="filter(1)">Download</a>
                    <br>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="DataTable table table-striped">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Product Serial</th>
                                        <th>Transferred Total</th>
                                        <th>Transferred To</th>
                                        <th>Transferred Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($transfers as $result) :
                                    ?>
                                        <tr>
                                            <td><a href="details/<?php echo $result->productid;  ?>" target="_blank"><?php echo $result->name;  ?></a></td>
                                            <td><?php echo $result->product_serial?></td>
                                            <td><?php echo $result->quantity?></td>
                                            <td><?php echo $result->branch_id == 0 ? "Vendor" : $result->branchname ?></td>
                                            <td><?php echo date_format(date_create($result->created_timestamp), 'd/m/Y') ?></td>
                                            <td><?php 
                                             
                                            if($result->product_received == 1)
                                            {
                                                echo "Received By Branch";
                                            }else
                                            {
                                            echo "Yet To receive";
                                            }?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                 <div class="col-md-12">
                    <h2 class="page-title">My Return Requests
                    </h2>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="DataTable table table-striped">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Return Total</th>
                                        <th>Return From</th>
                                        <th>Return Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($returns as $result) :
                                    ?>
                                        <tr>
                                            <td><?php echo $result->productname;  ?></td>
                                            <td><?php echo $result->quantity?></td>
                                            <td><?php echo $result->name ?></td>
                                            <td><?php echo date_format(date_create($result->created_timestamp), 'd/m/Y') ?></td>
                                            <td><?php 
                                              if ($result->product_received == 0) : ?>
                                                    Did you receive this?
                                                    <input type="checkbox" onclick="confirm('Are you sure?') && returnitemReceived('<?php echo $result->id ?>','<?php echo $_SESSION['userdetails']->userid; ?>')" />
                                               <?php
                                               endif;
                                               ?>
                                           </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="modal fade" id="add" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title">Add Inventory</h2>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="<?php echo base_url('Inventory/addInventory') ?>">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="text-uppercase text-sm">Product</label>
                                            <select name="productid" style="width: 100%;" class="select2 form-control mb" required>
                                                <option value="">Select Product</option>
                                                <?php
                                                foreach ($products as $product) :
                                                ?>
                                                    <option value="<?php echo $product->id; ?>"><?php echo $product->productname ?></option>
                                                <?php
                                                endforeach;
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <br />
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="text-uppercase text-sm">Value</label>
                                            <input type="number" placeholder="Value" name="value" class="form-control mb" required>
                                        </div>
                                    </div>
                                    <br />
                                    <button type="submit" class="btn btn-primary">Add to Inventory</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
               

                <div class="modal fade" id="bulkTransfer" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title">Bulk Transfer</h2>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="<?php echo base_url('Inventory/bulkTransfer') ?>">
                                    <button type="button" name="addmore" id="addmore" class="btn btn-success">Add Product</button>
                                    <br />
                                    <br />
                                    <div id="getslots">
                                       
                                    </div>
                                    <select id="receivedbybranch" name="receivedbybranch" style="width: 100%;" class="select2 form-control mb" required>
                                        <option value="">Select Branch</option>
                                        <?php
                                        foreach ($lookups['branchlookup'] as $branch) :
                                        ?>
                                            <option value="<?php echo $branch->branchid; ?>"><?php echo $branch->branchname; ?></option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                    <br />
                                    <br />

                                    <button type="submit" class="btn btn-primary">Transfer</button>
                                    <a class="btn btn-primary" onclick="printDiv()">Print Dispatch Form</a>

                                    <div class="col-md-12" id="div_print" style="display:none; background-color:#fff;">
                                        <div class="scale" style=" border:2px solid #000; ">
                                            <p style="text-align: center;"><img src="<?php echo base_url('images/logo1.png') ?>" width="160" height="60" /></p>
                                            <br />
                                            
                                            
                                            
                                            <p style="text-align: right;">Date: <?php echo date("d-m-Y"); ?><br />Hyderabad</p>
                                            <h4 style="text-align: center; font-size:25px;"><strong><u>Dispatch Form</u></strong></h4>
                                            <br />
                                            
                                     
                                                    <p style="border:1px solid black; font-weight:800; width:96%; float:left; position:relative; text-align:center; padding:10px;"> Dispatch to Branch: <span id="printBranch"></span>
                                                </p>
                                                
                                                
                                                
                                          

                                           
                                            <br />
                                            <br />
                                            <table style="width: 100%;margin: 0;" id="printValues">


                                            </table>

                                            <p style="margin-top:100px; padding:20px;">Clerk-in-Charge
                                                <span style="float:right">PRINCIPAL</span>
                                            </p>
                                        </div>

                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <?php } ?>
            <?php endif; ?>
            
            <?php if ($_SESSION['rights'][array_search('InventoryManager', array_column($_SESSION['rights'], 'operationname'))]->_edit == 1) : 
                if($id ==null){
                ?>
                <div class="col-md-12">
                    <h2 class="page-title">My Distributes
                    </h2>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="DataTable table table-striped">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Distribute To</th>
                                        <th>Distribute Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($transfers as $result) :
                                    ?>
                                        <tr>
                                            <td><a href="details/<?php echo $result->productid;  ?>" target="_blank"><?php echo $result->name;  ?></a></td>
                                            <td><?php echo $result->quantity?></td>
                                            <td><?php echo $result->studentname ?></td>
                                            <td><?php echo date_format(date_create($result->created_timestamp), 'd/m/Y') ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-12">
                    <h2 class="page-title">My Returns
                    </h2>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="DataTable table table-striped">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Return Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($returns as $result) :
                                    ?>
                                        <tr>
                                            <td><?php echo $result->productname;  ?></td>
                                            <td><?php echo $result->quantity?></td>
                                            <td><?php echo date_format(date_create($result->created_timestamp), 'd/m/Y') ?></td>
                                            <td><?php 
                                             
                                            if($result->product_received == 1)
                                            {
                                                echo "Received By Ware House";
                                            }else
                                            {
                                            echo "Yet To receive";
                                            }?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="modal fade" id="add" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title">Add Inventory</h2>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="<?php echo base_url('Inventory/addInventory') ?>">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="text-uppercase text-sm">Product</label>
                                            <select name="productid" style="width: 100%;" class="select2 form-control mb" required>
                                                <option value="">Select Product</option>
                                                <?php
                                                foreach ($products as $product) :
                                                ?>
                                                    <option value="<?php echo $product->productid; ?>"><?php echo $product->productname . "({$product->vendorname})" . " - {$product->productby}" . " -{$product->specification}"; ?></option>
                                                <?php
                                                endforeach;
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <br />
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="text-uppercase text-sm">Value</label>
                                            <input type="number" placeholder="Value" name="value" class="form-control mb" required>
                                        </div>
                                    </div>
                                    <br />
                                    <button type="submit" class="btn btn-primary">Add to Inventory</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
               

                <div class="modal fade" id="bulkTransfer" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title">Bulk Transfer</h2>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="<?php echo base_url('Inventory/bulkTransfer') ?>">
                                    <button type="button" name="addmore" id="addmore" class="btn btn-success">Add Product</button>
                                    <br />
                                    <br />
                                    <div id="getslots">
                                      
                                    </div>
                                    <select id="receivedbybranch" name="receivedbybranch" style="width: 100%;" class="select2 form-control mb" required>
                                        <option value="">Select Branch</option>
                                        <?php
                                        foreach ($lookups['branchlookup'] as $branch) :
                                        ?>
                                            <option value="<?php echo $branch->branchid; ?>"><?php echo $branch->branchname; ?></option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                    <br />
                                    <br />

                                    <button type="submit" class="btn btn-primary">Transfer</button>
                                    <a class="btn btn-primary" onclick="printDiv()">Print Dispatch Form</a>

                                    <div class="col-md-12" id="div_print" style="display:none;">
                                        <div class="scale">
                                            <p style="text-align: center;"><img src="<?php echo base_url('images/logo1.png') ?>" width="160" height="60"  /></p>
                                            <br />
                                            <p style="text-align: right;">Date: <?php echo date("d-m-Y"); ?><br />Hyderabad</p>
                                            <h4 style="text-align: center;"><strong><u>Dispatch Form</u></strong></h4>
                                            <br />

                                            Dispatch to Branch: <span id="printBranch"></span>
                                            <br />
                                            <br />
                                            <table style="width: 100%;margin: 0;" id="printValues">


                                            </table>

                                            <p style="margin-top:100px;">Clerk-in-Charge
                                                <span style="float:right">PRINCIPAL</span>
                                            </p>
                                        </div>

                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <?php } ?>
            <?php endif; ?>
          
            <div class="modal fade" id="bulkDistribute" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title">Bulk Distribute</h2>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="get" action="Distribute">
                                
                                <select id="" name="products[]" multiple style="width: 100%;" class="select2 form-control mb" required>
                                        <option value="">Select products</option>
                                      <?php  foreach ($inventory as $result) :
                                    ?>
                                    <option value="<?php echo $result->productid;?>"><?php echo $result->productname;?></option>
                                    <?php
                                    endforeach;
                                      ?>
                                    </select>
                                    <br>
                                    <br>
                                    <select class="form-control select2 mb" style="width: 100%;"  name='category'>
                                                <option>Select Distribute Category
                                                </option>
                                                <option value='1'  <?php if(isset($_GET['category']) && $_GET['category']==1){echo "selected";}?>>Student
                                                </option>
                                                <option value='2' <?php if(isset($_GET['category']) && $_GET['category']==2){echo "selected";}?>>Employee
                                                </option>
                                     </select>
                    <br>
                    <br>
                                    
                                    <br />
                                    <br />

                                    <button type="submit" class="btn btn-primary">Distribute</button>
                                    
                                    <div class="col-md-12" id="div_print" style="display:none;">
                                        <div class="scale">
                                            <p style="text-align: center;"><img src="<?php echo base_url('images/logo1.png') ?>" width="160" height="60"  /></p>
                                            <br />
                                            <p style="text-align: right; padding:20px;">Date: <?php echo date("d-m-Y"); ?><br />Hyderabad</p>
                                            <h4 style="text-align: center;"><strong><u>Dispatch Form</u></strong></h4>
                                            <br />

                                            Dispatch to Branch: <span id="printBranch"></span>
                                            <br />
                                            <br />
                                            <table style="width: 100%;margin: 0; width: 100%; display:flex;  border:1px solid black; padding:5px;" id="printValues">


                                            </table>

                                            <p style="margin-top:100px;">Clerk-in-Charge
                                                <span style="float:right">PRINCIPAL</span>
                                            </p>
                                        </div>

                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>

<script>
    function filter(download = 0) {
        var URL = "<?php echo base_url('Inventory/details') ?>" + "?" + $('#filterForm').serialize();

        if (download == 1) {
            URL = URL + "&download=1";
        }

        window.location.href = URL;
    }
</script>
<script>
var i=1; 
var rowcount = 0;
    $('#addmore').click(function() {
        i++;  
       rowcount++;
        $('#getslots').append('<tr id="row' + i + '" class="dynamic-added"><td><select data-rowcount="div_'+rowcount+'" onchange="changeproduct(this)" style="width: 100%;" class="select2 form-control mb" name="productid[]"><option  value="">select Product</option><?php foreach ($inventory as $inv) : if ($inv->available_quantity > 0 && $inv->product_type_id !=1) : ?><option  data-ids="<?php echo $inv->product_ids; ?>"  data-quantity="<?php echo $inv->available_quantity; ?>" value="<?php echo $inv->productid . "&" . $inv->inventorydetailsid . "&" . $inv->available_quantity; ?>"><?php echo $inv->productname ?></option><?php endif;endforeach; ?></select></td><td>&nbsp;</td><td></td><td><div id="div_'+rowcount+'"></div></td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
    });
    function changeproduct(selectedoption)
    {
       // alert(selectedoption.options[selectedoption.selectedIndex].dataset.quantity);
        var ids = selectedoption.options[selectedoption.selectedIndex].dataset.ids;
        
        if(ids !=''){
          $.ajax({
            url: "<?php echo base_url('Inventory/productids') ?>",
            type: "POST",
            async: false,
            data: {
                productid: ids
            },
            success: function(data) {
                 $('#'+selectedoption.dataset.rowcount).html('');
                var divcontents = "<td><td><input type='number' class='form-control' style='width: 118px;' placeholder='Quantity' name='value[]' required min=1 max="+selectedoption.options[selectedoption.selectedIndex].dataset.quantity+" required><input type='hidden' class='form-control' placeholder='Quantity' value='"+data+"' name='productids[]'  required></td>";
                $('#'+selectedoption.dataset.rowcount).append(divcontents);
            }
        });
           
        }else
        {
             $('#'+selectedoption.dataset.rowcount).html('');
            var divcontents = "<td><td><input type='number' class='form-control' style='width: 118px;' placeholder='Quantity' name='value[]' required max="+selectedoption.options[selectedoption.selectedIndex].dataset.quantity+" required><input type='hidden' class='form-control' placeholder='Quantity' name='productids[]' required></td>";
            $('#'+selectedoption.dataset.rowcount).append(divcontents);
        }   
    
    }
    function setMax(select, selectValue) {
        select.parentElement.nextElementSibling.nextElementSibling.firstChild.max = selectValue.split("&")[2]
    }

    $(document).on('click', '.btn_remove', function() {
        var button_id = $(this).attr("id");
        $('#row' + button_id + '').remove();
    });

    function printDiv() {
        $('#printBranch').text($('#receivedbybranch  option:selected').text());

        let html = '<tr><td><span style="width: 100%; display:flex;  border:1px solid black; padding:5px;"><b>ProductName</b></span></td><td><span style="width: 90%;border:1px solid black;position: relative;display: flex;padding: 5px ; padding-left:20px; border-left: none;"><b>Quantity</b></td></tr>';
        for (let i = 0; i < $("input[name='value[]']").length; i++) {
            if($("input[name='productids[]']")[i].value != "")
            {
                html += '<tr><td><span style="width: 100%; display:flex;  border:1px solid black; padding:5px;">' + $("select[name='productid[]'] option:selected")[i].text + '<br> (' + $("input[name='productids[]']")[i].value+ ')' +'</span></td><td><span style="width: 90%; display:flex;  border:1px solid black; padding:5px; padding-left:20px; border-left: none;">' + $("input[name='value[]']")[i].value + '</td></tr>';

            }else
            {
                html += '<tr><td><span style="width: 100%; display:flex;  border:1px solid black; padding:5px;">' + $("select[name='productid[]'] option:selected")[i].text +  $("input[name='productids[]']")[i].value +'</span></td><td><span style="width: 90%; display:flex;  border:1px solid black; padding:5px; padding-left:20px; border-left: none;">' + $("input[name='value[]']")[i].value + '</td></tr>';
            }
        }
        $('#printValues').html(html);

        var w = window.open();

        var printContents = document.getElementById("div_print").innerHTML;

        $(w.document.body).html(printContents);
        w.print();
    }
</script>
<script>
    function itemReceived(inventorydetailsid, receivedby) {
        $.ajax({
            url: "<?php echo base_url('Inventory/itemReceived') ?>",
            type: "POST",
            async: false,
            data: {
                inventorydetailsid: inventorydetailsid,
                receivedby: receivedby
            },
            success: function(data) {
                location.reload();
            }
        });
    }
    function returnitemReceived(inventorydetailsid, receivedby)
    {
         $.ajax({
            url: "<?php echo base_url('Inventory/returnitemReceived') ?>",
            type: "POST",
            async: false,
            data: {
                inventorydetailsid: inventorydetailsid,
                receivedby: receivedby
            },
            success: function(data) {
                location.reload();
            }
        });
    }
</script>