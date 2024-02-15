<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Distribute
                </h2>
                <div class="row">
                    <div class="col-md-5">
                        <form method='get' action=''>
                        <input type="text" value="<?php echo $_GET['id'];?>" name="id">
                        <input type="submit" name="submit" value="submit">
                        </form>
                    </div>
                    <?php if($_GET['id'] !=''){
                       
                  if(!empty($StudentDetail))
                  {
                  
                  
                    ?>
                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-md-4">
                            Name
                            </div>
                            <div class="col-md-5">
                                <?php echo $StudentDetail[0]->studentname;?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                            Application Number
                            </div>
                            <div class="col-md-5">
                                <?php echo $StudentDetail[0]->applicationnumber;?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                            Branch
                            </div>
                            <div class="col-md-5">
                                <?php echo $StudentDetail[0]->branchname;?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                            Course
                            </div>
                            <div class="col-md-5">
                                <?php echo $StudentDetail[0]->coursename;?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php }else
                {
                    echo "Enter Correct Id number";
                }
                } ?>
                <hr>
                <?php if($_GET['id'] !='' && !empty($StudentDetail)){?>
                <div class="row">
                    <div class="col-md-5">
                    <button type="button" name="addmore" id="addmore" class="btn btn-success">Add Material To Distribute</button>
                    <br /><br />
                    <form action="<?php echo base_url('Inventory/studentinventory') ?>" method="POST">
							<div id="getslots">
							
							</div>  
                            <br> 
                            <input type="hidden" value="<?php echo $StudentDetail[0]->userid;?>" name="userid"> 
                            <button type="submit" class="btn btn-success">Submit</button>
                </form> 
                </div>
                    <div class="col-md-7">
                        <h3>Inventory Distributed List</h3>
                       
                        <div class="row">
                            <div class="col-md-4">
                            Name
                            </div>
                            <div class="col-md-4">
                            Quantity
                            </div>
                           
                        </div>
                        <?php 
                        if(!empty($StudentDetail)){
                        foreach($StudentDetails as $StudentDetail){
                            ?>
                        <div class="row">
                        <div class="col-md-5">
                                <?php echo $StudentDetail->name;?>
                            </div>
                            <div class="col-md-5">
                                <?php echo $StudentDetail->quantity;?>
                            </div>
                        </div>
                       <?php } }?>
                    </div>
                </div>
                <?php } ?>
               
<script>
    function distributeEmployee(current, productid, userid, inventorydetailsid) {
        remainingtotal = document.getElementById('hdnremainingtotal').value;
        $.ajax({
            url: "<?php echo base_url('Inventory/employee_inventory') ?>",
            type: "POST",
            async: false,
            data: {
                productid: productid,
                userid: userid,
                inventorydetailsid: inventorydetailsid,
                remainingtotal: remainingtotal,
            },
            success: function(data) {
                if (data == 1) {
                    current.disabled = 'true';
                    document.getElementById('hdnremainingtotal').value = remainingtotal - 1;
                    document.getElementById('remaining').innerText = remainingtotal - 1;
                } else {
                    alert("You dont have items remaining");
                    current.checked = false;
                }
            }
        });
    }

    function distributeStudent(current, productid, userid, inventorydetailsid) {
        remainingtotal = document.getElementById('hdnremainingtotal').value;
        $.ajax({
            url: "<?php echo base_url('Inventory/student_inventory') ?>",
            type: "POST",
            async: false,
            data: {
                productid: productid,
                userid: userid,
                inventorydetailsid: inventorydetailsid,
                remainingtotal: remainingtotal,
            },
            success: function(data) {
                if (data == 1) {
                    current.disabled = 'true';
                    document.getElementById('hdnremainingtotal').value = remainingtotal - 1;
                    document.getElementById('remaining').innerText = remainingtotal - 1;
                } else {
                    alert("You dont have items remaining");
                    current.checked = false;
                }
            }
        });
    }

    function distributeReservationStudent(current, productid, userid, inventorydetailsid) {
        remainingtotal = document.getElementById('hdnremainingtotal').value;
        $.ajax({
            url: "<?php echo base_url('Inventory/reservation_inventory') ?>",
            type: "POST",
            async: false,
            data: {
                productid: productid,
                userid: userid,
                inventorydetailsid: inventorydetailsid,
                remainingtotal: remainingtotal,
            },
            success: function(data) {
                if (data == 1) {
                    current.disabled = 'true';
                    document.getElementById('hdnremainingtotal').value = remainingtotal - 1;
                    document.getElementById('remaining').innerText = remainingtotal - 1;
                } else {
                    alert("You dont have items remaining");
                    current.checked = false;
                }
            }
        });
    }
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
        $('#'+selectedoption.dataset.rowcount).html('');
        var divcontents = "<td><input type='text' class='form-control' disabled value="+selectedoption.options[selectedoption.selectedIndex].dataset.quantity+" placeholder='Quantity' required></td>&nbsp;<td></td><td><input type='text' class='form-control' placeholder='Quantity' name='quantity[]' required max="+selectedoption.options[selectedoption.selectedIndex].dataset.quantity+" required><input type='hidden' class='form-control' placeholder='Quantity' name='remainingtotal[]'  value="+selectedoption.options[selectedoption.selectedIndex].dataset.quantity+"></td>&nbsp;<td></td>";
        $('#'+selectedoption.dataset.rowcount).append(divcontents);
        
    }
}
var i=1; 
var rowcount = 0;
     $('#addmore').click(function(){  

           i++;  
           rowcount++;
           

            $('#getslots').append('<tr id="row'+i+'" class="dynamic-added"><td><select style="width: 100%;" class="select2 form-control mb" name="productid[]" required data-rowcount="div_'+rowcount+'" onchange="changeproduct(this)"><option value="">select product</option><?php if(!empty($StudentDetail)) {  foreach ($InventoryDetails as $product) : if($product->quantity > 0){ ?><option value="<?php echo $product->product_id; ?>" data-type="<?php echo $product->product_type_id; ?>" data-quantity="<?php echo $product->quantity; ?>"><?php echo $product->name; ?></option><?php } endforeach; } ?></select></td><td>&nbsp;</td><td><div id="div_'+rowcount+'"></div></td><td>&nbsp;</td></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
      });
      
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      }); 
</script>