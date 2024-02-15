<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Add Bulk Outpass
                </h2>
                <div class="row">
                    <div class="col-md-12">
                        <form action="<?php echo base_url('api/savebulkoutpass') ?>" method="POST">
                            <input type="hidden" name="userid" value="<?php echo$_SESSION['userdetails']->userid ?>" />
                            <input type="hidden" name="web" value="1" />
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
                                        <td>
                                        <label>Section</label>
                                            <select id="sectionid" name="sectionid" style="width: 60%;" class="select2 form-control mb" required>
                                            <option value=''>Select Section</option>
                                            <?php
                                             foreach ($section as $sec) :
                                                ?>
                                                    <option value="<?php echo $sec->sectionid; ?>"><?php echo $sec->sectionname; ?></option>
                                                <?php
                                                endforeach;
                                            ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                        <label>Purpose</label>
                                           <input type="text" name="purpose" required>
                                        </td>
                                        
                                        <td>
                                        <label>Guardian</label>
                                           <input type="text" name="gardian" required>
                                        </td>
                                        
                                        <td>
                                        <label>From date</label>
                                           <input type="datetime-local" name="fromdate" min="1997-01-01" max="2030-12-31" required>
                                        </td>
                                        
                                        <td>
                                        <label>To date</label>
                                           <input type="datetime-local" name="todate" required>
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

