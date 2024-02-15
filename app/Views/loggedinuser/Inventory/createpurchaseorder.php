<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Purchase Order Form
                </h2>
                <div class="row">
                    <div class="col-md-12">
                        <form method='get'>
                            <table class="table table-striped">
                                <tbody>
                                <tr>
                                    <td>
                                        <label>Vendor</label>
                                    <select class="select2 mb" onchange="this.form.submit()" name='vendor' required>
                                    
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
                                    
                                        <td>
                                            <label>Purchase Type </label>
                                            <select class="select2 mb" onchange="this.form.submit()" name='type'>
                                                <option>Select Purchase Type
                                                </option>
                                                <option value='1'  <?php if($_GET['type']==1){echo "selected";}?>>From Material Requisition
                                                </option>
                                                <option value='2' <?php if($_GET['type']==2){echo "selected";}?>>Normal Purchase Order
                                                </option>
                                            </select>
                                        </td>
                                    </tr>
                                       
                                </tbody>
                            </table>
                        </form>
                        <?php if($_GET['type'] != ''){
                            ?>
                        
                        <form action="<?php echo base_url('Inventory/savepurchaseorder') ?>" method="POST">
                            <input type="hidden" name="user_id" value="<?php echo $_SESSION['userdetails']->userid ?>" />
                            <input type="hidden" name="type" value="<?php echo $_GET['type'] ?>" />
                            <input type="hidden" name="materialid" value="<?php echo $_GET['materialid'] ?>" />
                            <table class="table table-striped">
                                <tbody>
                                    <?php if($_GET['type']==2){
                                        ?>
                                    
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
                                    <?php }
                                   if($_GET['type']==1){
                                        $i=1;
                                        foreach($getmaterialrequestitems as $getmaterialrequestitem){
                                            
                                            if(($getmaterialrequestitem->quantity-$getmaterialrequestitem->delivered_quantity) > 0){
                                       ?>

                                        <tr>
                                            

                                            </tr>
                                            <tr id="row<?php echo $i;?>" class="dynamic-added">
                                            
                                            <td>
                                            <?php echo $getmaterialrequestitem->productname; ?> 
                                             
                                            <input type="hidden" name="productid[]" placeholder="productname" value="<?php echo $getmaterialrequestitem->product_id; ?>" class="form-control" />  
                                            <input type="hidden" name="material_requisition_item_ids[]" placeholder="productname" value="<?php echo $getmaterialrequestitem->material_requisition_item_ids; ?>" class="form-control" />   
                                            </td><td>&nbsp;</td><td><input type="number" name="quantity[]" placeholder="Quantity" value="<?php echo ($getmaterialrequestitem->quantity-$getmaterialrequestitem->delivered_quantity); ?>" class="form-control" min="1" max="<?php echo ($getmaterialrequestitem->quantity-$getmaterialrequestitem->delivered_quantity);?>"/></td><td>&nbsp;<td>&nbsp;</td><td><button type="button" name="remove" id="<?php echo $i;?>" class="btn btn-danger btn_remove">X</button></td></tr>
                                        <?php
                                        $i++;
                                            }
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

<script>
    
function changeproduct(selectedoption)
{

    if(selectedoption.options[selectedoption.selectedIndex].dataset.type==1)
    {
        $('#'+selectedoption.dataset.rowcount).html('');
        var divcontents = "<input type='text' placeholder='Quantity' name='quantity[]' required class='form-control' required>";
        $('#'+selectedoption.dataset.rowcount).append(divcontents);
        loadtags();
    }else
    {
        $('#'+selectedoption.dataset.rowcount).html('');
        var divcontents = "<td><input type='text' class='form-control' placeholder='Quantity' name='quantity[]' required></td>";
        $('#'+selectedoption.dataset.rowcount).append(divcontents);
        
    }
}
var i=1; 
var rowcount = 0;
     $('#addmore').click(function(){ 
           i++;  
           rowcount++;
           $('#getslots').append('<tr id="row'+i+'" class="dynamic-added"><td><select style="width: 100%;" class="select2 form-control mb" name="productid[]" required data-rowcount="div_'+rowcount+'" onchange="changeproduct(this)"><option value="">select product</option><?php foreach ($products as $product) :?><option value="<?php echo $product->id; ?>" data-type="<?php echo $product->product_type_id; ?>"><?php echo $product->productname; ?></option><?php endforeach;?></select></td><td>&nbsp;</td><td><div id="div_'+rowcount+'"></div></td><td>&nbsp;</td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
      });
      
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      }); 
</script>