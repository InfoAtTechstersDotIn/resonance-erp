<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Add Inventory
                </h2>
                <div class="row">
                    <div class="col-md-12">
                        <form method='get'>
                            <table class="table table-striped">
                                <tbody>
                               
                                    <tr>
                                        <td>
                                        <label>Inventory Type</label>
                                            <select class="select2 mb" onchange="this.form.submit()" name='type'>
                                                <option>Select Add Inventory Type
                                                </option>
                                                <option value='1'  <?php if($_GET['type']==1){echo "selected";}?>>From Purchase Order
                                                </option>
                                                <option value='2' <?php if($_GET['type']==2){echo "selected";}?>>Normal Inventory
                                                </option>
                                            </select>
                                        </td>
                                    </tr>
                                        <tr>
                                   <!-- <td>
                                        <?php if(!empty($getpo))
                                        {
                                           ?>
                                           <select class="select2 mb" onchange="this.form.submit()" name='pid'>
                                           <option>
                                            select product order id
                                        </option>
                                           <?php
                                            foreach($getpo as $material)
                                            {
                                                ?>
                                                <option value="<?php echo $material->id;?>" <?php if($_GET['pid']==$material->id){echo "selected";}?>>
                                                    <?php
                                                print_r($material->id.'-'.$material->CreatedBy);
                                                    ?>
                                                </option>
                                                <?php
                                            }
                                            ?>
                                            </select>
                                            <?php
                                        }
                                        ?>
                                    </td> -->
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                        <?php if($_GET['type'] != ''){
                            ?>
                        
                        <form action="<?php echo base_url('Inventory/addInventory') ?>" method="POST">
                            <input type="hidden" name="user_id" value="<?php echo $_SESSION['userdetails']->userid ?>" />
                            <input type="hidden" name="type" value="<?php echo $_GET['type'] ?>" />
                            <input type="hidden" name="pid" value="<?php echo $_GET['pid'] ?>" />
                            <table class="table table-striped">
                                <tbody>
                                    <?php if($_GET['type']==2){
                                        ?>
                                    <td>
                                        <label>Vendor</label>
                                    <select class="select2 mb" name='vendor' required>
                                         
                                    <?php
                                    $i=1;
                                    foreach($vendors as $vendor)
                                            {
                                                ?>
                                                <option value="<?php echo $vendor->id;?>" <?php if($_GET['vendor']==$vendor->id || $i==1){echo "selected";}?>>
                                                    <?php
                                                print_r($vendor->id.'-'.$vendor->name);
                                                    ?>
                                                </option>
                                                <?php
                                                $i++;
                                            }
                                            ?>
                                            </select>
                                      <!--  <?php if(!empty($getmaterialrequest))
                                        {
                                           ?>
                                           <select class="select2 mb" onchange="this.form.submit()" name='materialid'>
                                           <option>
                                            select material request id
                                        </option>
                                           <?php
                                            foreach($getmaterialrequest as $material)
                                            {
                                                ?>
                                                <option value="<?php echo $material->id;?>" <?php if($_GET['materialid']==$material->id){echo "selected";}?>>
                                                    <?php
                                                print_r($material->id.'-'.$material->CreatedBy);
                                                    ?>
                                                </option>
                                                <?php
                                            }
                                            ?>
                                            </select>
                                            <?php
                                        }
                                        ?>-->
                                    </td>
                                    
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Receipt Number</label>
                                            <input type="text" placeholder="Receipt Number" name="receipt" required>
                                    </td>
                                    </tr>
                                    <tr>
                                        <td><b>Material Name</b></td>
                                        <td>
                                      <!-- <select style="width: 100%;"  class="select2 form-control mb" multiple name="productname[]" required>
                                          <option value="">Select Material</option>
                                          <?php
                                          foreach ($products as $product) :
                                          ?>
                                             <option value="<?php echo $materialrequisition->materialrequisitionname; ?>"><?php echo $materialrequisition->materialrequisitionname; ?></option>
                                          <?php
                                          endforeach;
                                          ?>
                                       </select>-->
                                       
                                       <button type="button" name="addmore" id="addmore" class="btn btn-success">Add Material</button>
                                       <br /><br />
                                        <div id="getslots">
                                        
                                        </div>
                                        </td>
                                    </tr>
                                    <?php }elseif($_GET['type']==1){
                                  ?>
                                <tr>
                                    <td>
                                        <label>Vendor</label>
                                    <select class="select2 mb" name='vendor' required>
                                         
                                    <?php
                                    $i=1;
                                    foreach($vendors as $vendor)
                                            {
                                                ?>
                                                <option value="<?php echo $vendor->id;?>" <?php if($_GET['vendor']==$vendor->id || $i==1){echo "selected";}?>>
                                                    <?php
                                                print_r($vendor->id.'-'.$vendor->name);
                                                    ?>
                                                </option>
                                                <?php
                                                $i++;
                                            }
                                            ?>
                                            </select>
                                      <!--  <?php if(!empty($getmaterialrequest))
                                        {
                                           ?>
                                           <select class="select2 mb" onchange="this.form.submit()" name='materialid'>
                                           <option>
                                            select material request id
                                        </option>
                                           <?php
                                            foreach($getmaterialrequest as $material)
                                            {
                                                ?>
                                                <option value="<?php echo $material->id;?>" <?php if($_GET['materialid']==$material->id){echo "selected";}?>>
                                                    <?php
                                                print_r($material->id.'-'.$material->CreatedBy);
                                                    ?>
                                                </option>
                                                <?php
                                            }
                                            ?>
                                            </select>
                                            <?php
                                        }
                                        ?>-->
                                    </td>
                                    
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Receipt Number</label>
                                            <input type="text" placeholder="Receipt Number" name="receipt" required>
                                    </td>
                                    </tr>
                                        <tr>
                                  <?php
                                        $i=1;
                                        foreach($getproductorderitems as $getproductorderitem){
                                            if($getproductorderitem->product_type_id == 1)
                                            {
                                                for ($x = 1; $x <= $getproductorderitem->quantity; $x++) {
                                                ?>
                                            <tr id="row<?php echo $i;?>" class="dynamic-added"><td>
                                            <input type="text" name="productname[]" placeholder="productname" value="<?php echo $getproductorderitem->productname; ?>" class="form-control" />   
                                            <input type="hidden" name="productid[]" placeholder="productname" value="<?php echo $getproductorderitem->product_id; ?>" class="form-control" />   
                                            <input type="hidden" name="material_requisition_item_id[]" placeholder="productname" value="<?php echo $getproductorderitem->material_requisition_item_id; ?>" class="form-control" /> 
                                            <input type="hidden" name="purchase_order_item_id[]" placeholder="productname" value="<?php echo $getproductorderitem->id; ?>" class="form-control" />   
                                            </td><td>&nbsp;</td><td><input type="number" name="quantity[]" placeholder="Quantity" value="1" class="form-control" min="1" max="1"/></td><td>&nbsp;<td><input type="text" name="comment[]" placeholder="Comment" class="form-control" value="<?php echo $getproductorderitem->comment; ?>" /></td><td>&nbsp;</td>
                                            <td><input type="text" name="serial[]" placeholder="Serial No" class="form-control" value="" required/></td><td>&nbsp;</td>
                                            <td><button type="button" name="remove" id="<?php echo $i;?>" class="btn btn-danger btn_remove">X</button></td></tr>
                                                <?php
                                                }
                                            }else
                                            {
                                            if(($getproductorderitem->quantity-$getproductorderitem->delivered_quantity) > 0){
                                        ?>

                                            <tr id="row<?php echo $i;?>" class="dynamic-added"><td>
                                            <input type="text" name="productname[]" placeholder="productname" value="<?php echo $getproductorderitem->productname; ?>" class="form-control" />   
                                            <input type="hidden" name="productid[]" placeholder="productname" value="<?php echo $getproductorderitem->product_id; ?>" class="form-control" />   
                                            <input type="hidden" name="material_requisition_item_id[]" placeholder="productname" value="<?php echo $getproductorderitem->material_requisition_item_id; ?>" class="form-control" /> 
                                            <input type="hidden" name="purchase_order_item_id[]" placeholder="productname" value="<?php echo $getproductorderitem->id; ?>" class="form-control" />   
                                            </td><td>&nbsp;</td><td><input type="number" name="quantity[]" placeholder="Quantity" value="<?php echo $getproductorderitem->quantity-$getproductorderitem->delivered_quantity; ?>" class="form-control" min="1" max="<?php echo $getproductorderitem->quantity;?>"/></td><td>&nbsp;<td><input type="text" name="comment[]" placeholder="Comment" class="form-control" value="<?php echo $getproductorderitem->comment; ?>" /></td><td>&nbsp;</td>
                                            </td>
                                            <td><input type="hidden" name="serial[]" placeholder="Serial No" class="form-control" value="" required/></td><td>&nbsp;</td><td><button type="button" name="remove" id="<?php echo $i;?>" class="btn btn-danger btn_remove">X</button></td></tr>
                                            <?php
                                                }
                                            }
                                        $i++;
                                        }
                                    }
                                    ?>
                                   
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </form>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js"></script>
<script>
function loadtags(){  
    $('#tags').tagsinput({
   maxTags: 20
});
}
loadtags();
</script>
<script>
    
function changeproduct(selectedoption)
{

    if(selectedoption.options[selectedoption.selectedIndex].dataset.type==1)
    {
        $('#'+selectedoption.dataset.rowcount).html('');
        var divcontents = "<input type='text' placeholder='Serial Numbers' id='tags' name='serial[]' data-role='tagsinput' class='form-control' required>";
        $('#'+selectedoption.dataset.rowcount).append(divcontents);
        loadtags();
    }else
    {
        var ids = selectedoption.options[selectedoption.selectedIndex].dataset.ids;
        if(ids !=''){
        $.ajax({
            url: "<?php echo base_url('Inventory/minquantity') ?>",
            type: "POST",
            async: false,
            data: {
                productid: ids,
            },
            success: function(data) {
                $('#'+selectedoption.dataset.rowcount).html('');
                var divcontents = "<td><input type='number' class='form-control' placeholder='Quantity' name='quantity[]' min=0 max="+data+" required></td>";
                $('#'+selectedoption.dataset.rowcount).append(divcontents);
            }
        });
           
        }else
        {
             $('#'+selectedoption.dataset.rowcount).html('');
            var divcontents = "<td><input type='text' class='form-control' placeholder='Quantity' name='quantity[]' required></td>";
            $('#'+selectedoption.dataset.rowcount).append(divcontents);
        }
       
        
    }
}
var i=1; 
var rowcount = 0;
     $('#addmore').click(function(){ 
           i++;  
           rowcount++;
           $('#getslots').append('<tr id="row'+i+'" class="dynamic-added"><td><select style="width: 100%;" class="select2 form-control mb" name="productid[]" required data-rowcount="div_'+rowcount+'" onchange="changeproduct(this)"><option value="">select product</option><?php foreach ($products as $product) :?><option value="<?php echo $product->id; ?>" data-ids="<?php echo $product->product_ids; ?>" data-type="<?php echo $product->product_type_id; ?>"><?php echo $product->productname; ?></option><?php endforeach;?></select></td><td>&nbsp;</td><td><div id="div_'+rowcount+'"></div></td><td>&nbsp;</td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
      });
      
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      }); 
</script>
<style>
    input[type=number]{
    width: 100px;
}
</style>