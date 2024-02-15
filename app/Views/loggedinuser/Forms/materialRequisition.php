<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Add Material Requisition
                </h2>
                <div class="row">
                    <div class="col-md-12">
                        <form action="<?php echo base_url('Forms/savematerialRequisition') ?>" method="POST">
                            <input type="hidden" name="user_id" value="<?php echo$_SESSION['userdetails']->userid ?>" />
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td>
                                            <label>Branch</label>
                                            <select id="branchid" name="branchid" style="width: 60%;" class="select2 form-control mb" required>
                                            <option value=''>Select Branch</option>
                                            <?php
                                             foreach ($lookups['branchlookup'] as $branch) :
                                                ?>
                                                    <option value="<?php echo $branch->branchid; ?>"><?php echo $branch->branchname; ?></option>
                                                <?php
                                                endforeach;
                                            ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Material Name</b></td>
                                        <td>
                                       
                                       <button type="button" name="addmore" id="addmore" class="btn btn-success">Add Material</button>
                                       <br /><br />
							<div id="getslots">
							
							</div>
                                        </td>
                                        
                                        
                                    </tr>
                                   
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
var i=1; 
     $('#addmore').click(function(){  
           i++;  
           $('#getslots').append('<tr id="row'+i+'" class="dynamic-added"><td><select style="width: 100%;" class="select2 form-control mb" name="productname[]" required><?php foreach ($products as $product) :?><option value="<?php echo $product->id; ?>"><?php echo $product->productname; ?></option><?php endforeach;?></select></td><td>&nbsp;</td><td><input type="number" name="quantity[]" placeholder="Quantity" required class="form-control" /></td><td>&nbsp;<td><input type="text" required name="comment[]" placeholder="Comment" class="form-control" /></td><td>&nbsp;&nbsp;</td><td><input type="text" name="purpose[]" placeholder="Purpose" class="form-control" /></td><td></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
      });
      
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      }); 
</script>