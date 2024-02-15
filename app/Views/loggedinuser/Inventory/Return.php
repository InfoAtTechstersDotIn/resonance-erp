<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Inventory Return
                </h2>
                <div class="row">
                    <div class="col-md-12">
                        <form method="post" action="<?php echo base_url('Inventory/returnInventory') ?>">
                            <div class="row">
                                <?php
                               
                                foreach($InventoryDetails as $inventory){
                                   // print_r($inventory);
                                  //  $inventorydetailsid = $_GET['inventorydetailsid'];
                                  //  $materialid = $_GET['materialid'];
                                    
                                    $db = db_connect();
                                    $query = $db->query("SELECT * from inventory where user_id={$_SESSION['userdetails']->userid} and product_id='$inventory->productid'");
                                    $results = $query->getResult();
                                    if($results[0]->quantity > 0 && $inventory->delivered_quantity != $inventory->quantity){
                                    ?>
                                    <div class="col-md-2">
                                    <label class="text-uppercase text-sm">Product Name</label><br />
                                    <?php echo $inventory->productname; 
                                    
                                    $a=array();
                                    if($inventory->product_ids !== '')
                                    {
                                        $query = $db->query("SELECT * from product where id in ({$inventory->product_ids})");
                                        $result = $query->getResult();
                                        ?>
                                        <br>
                                        ( 
                                        <?php
                                        foreach($result as $re)
                                        {
                                            array_push($a,$re->name.',');
                                            echo $re->name.' ,';
                                        }
                                        ?>
                                        )
                                        <?php
                                    }
                                    $aa = implode(" ", $a);
                                    ?>
                                    <input type="hidden" name="productid[]" value="<?php echo $inventory->productid ?>" />
                                    <input type="hidden" name="productname[]" value="<?php echo $inventory->productname ?>" />
                                    <input type="hidden" name="productids[]" value="<?php print_r($aa) ?>" />
                                    
                                    <input type="hidden" name="productname[]" value="<?php echo $inventory->productname ?>" />
                                    
                                    <input type="hidden" name="product_type_id[]" value="<?php echo $inventory->product_type_id ?>" />
                                    <input type="hidden" name="material_requisition_item_id[]" value="<?php echo $inventory->id ?>" />
                                    <input type="hidden" name="inventorydetailsid" value="<?php echo $inventory->intid ?>" />
                                </div>
                              
                                <div class="col-md-2">
                                    <label class="text-uppercase text-sm">Inventory Qty</label><br />
                                    <?php 
                                    
                                    echo $results[0]->quantity ?>
                                </div>
                                <?php if($inventory->product_type_id==1){
                                    ?>
                                <div class="col-md-3">
                                <select name="serial[]" id="serial" style="width: 100%;" class="select2 form-control mb" required multiple>
                                        <option value="">Select Printer serial</option>
                                   <?php
                                   $db = db_connect();
                                   $query = $db->query("SELECT * from inventorydetails where product_id={$inventory->productid} and dispatch_id IS NULL");
                                   $res = $query->getResult();
                                  
                                   foreach ($res as $result) :
                                    ?>
                                    <option value="<?php echo $result->id; ?>"><?php echo $result->product_serial; ?></option>
                                    <?php
                                   endforeach;
                                   ?>
                                    </select>
                                    
                                </div>
                               
                                    <?php
                                }else
                                {
                                    ?>
                                    <div class="col-md-3">
                                    <label class="text-uppercase text-sm">Return</label><br />
                                    <?php if($_GET['inventorydetailsid'] !='' && $_GET['materialid'] =='')
                                    {
                                        ?>
                                         <input type="number" placeholder="Return Amount" min="0" max="<?php 
                                    echo $results[0]->quantity;  ?>" name="value[]" class="form-control mb" required>
                                        <?php
                                        
                                    }else{
                                        ?>
                                        <input type="number" placeholder="Transfer Amount" min="0" max="<?php 
                                    if(($inventory->quantity-$inventory->delivered_quantity) > $results[0]->quantity){
                                    echo $results[0]->quantity; }else{ echo ($inventory->quantity-$inventory->delivered_quantity); } ?>" name="value[]" class="form-control mb" required>
                                        <?php
                                    }
                                    
                                    ?>
                                </div>
                                    <?php
                                }
                            }
                                }
                                ?>
                               
                            </div>
                            <br />
                           <!-- <div class="row">
                                <div class="col-md-6">
                                    <select name="receivedbybranch" id="receivedbybranch" style="width: 100%;" class="select2 form-control mb" required>
                                    <option value="">select branch</option>
                                        <?php print_r($lookups['branchlookup']);
                                            foreach ($lookups['branchlookup'] as $branch) :
                                            ?>
                                                <option <?php if($InventoryDetails[0]->branch_id==$branch->branchid){ echo "selected"; }?> value="<?php echo $branch->branchid; ?>"><?php echo $branch->branchname; ?></option>
                                            <?php
                                                
                                            endforeach;
                                            ?>
                                    </select>
                                </div>
                            </div> -->
                            <br>
                            <button type="submit" class="btn btn-primary">Transfer</button>
                            <a class="btn btn-primary" onclick="printDiv()">Print Dispatch Form</a>

                            <div class="col-md-12" id="div_print" style="display:none;">
                                        <div class="scale">
                                            <p style="text-align: center;"><img src="<?php echo base_url('images/logo1.png') ?>" width="140" height="50"  /></p>
                                            <br />
                                            <p style="text-align: right;">Date: <?php echo date("d-m-Y"); ?><br />Hyderabad</p>
                                            <h4 style="text-align: center;"><strong><u>Dispatch Form</u></strong></h4>
                                            <br />

                                            Dispatch to Branch: Ware House
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
    </div>
</div>

<script>

function printDiv() {
    
        $('#printBranch').text($('#receivedbybranch  option:selected').text());

        let html = '<tr><td><span style="width: 20%;"><b>ProductName</b></span></td><td><span style="width: 20%;"><b>Quantity</b></td></tr>';
        for (let i = 0; i < $("input[name='productid[]']").length; i++) {
            if($("input[name='product_type_id[]']")[i].value == 1)
            {
                var qty =  $('#serial option:selected').length;
            }else
            {
               
                 var qty = $("input[name='value[]']")[i].value;
                //$('#foo option:selected').length;
            }
            if($("input[name='productids[]']")[i].value != "")
            {
            html += '<tr><td><span style="width: 20%;">' + $("input[name='productname[]']")[i].value +'<br> ('+ $("input[name='productids[]']")[i].value+ ')'+'</span></td><td><span style="width: 20%;">' + 
           qty
            + '</td></tr>';
            }else
            {
                 html += '<tr><td><span style="width: 20%;">' + $("input[name='productname[]']")[i].value + $("input[name='productids[]']")[i].value +'</span></td><td><span style="width: 20%;">' + 
           qty
            + '</td></tr>';
            }
        }
        $('#printValues').html(html);

        var w = window.open();

        var printContents = document.getElementById("div_print").innerHTML;

        $(w.document.body).html(printContents);
        w.print();
    }
    </script>