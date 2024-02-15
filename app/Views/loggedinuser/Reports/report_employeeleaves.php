<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Employee Leave Report
                </h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            <form>
                    <div class="row">
                        <div class="col-md-4">
                            <?php if (isset($_GET['date'])) {
                                $date = $_GET['date'];
                            } else {
                                $date = '';
                            }
                            ?>
                            <label class="text-uppercase text-sm">Filter By Month/ Year</label>
                            <input type="month" name="date" class="form-control mb" required value="<?php echo $date; ?>">
                        </div>
                        <div class="col-md-4">
                            <br />
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </form>
                <a class="btn btn-primary" onclick="filter(1)">Download</a>
                </br>
                </br>
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
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Employee Name</th>
                                    <th>Leave From</th>
                                    <th>Leave To</th>
                                    <th>Days</th>
                                    <th>Reason</th>
                                    <th>Staus</th>
                                    <th>Approved By</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($employeeleaves != null) :
                                    foreach ($employeeleaves as $result) :
                                ?>
                                        <tr>
                                            <td>
                                                <b><?php echo $result->name ?></b>
                                            </td>
                                             <td>
                                                <b><?php echo $result->leavefrom ?></b>
                                            </td>
                                             <td>
                                                <b><?php echo $result->leaveto ?></b>
                                            </td>
                                            <td>
                                                <b><?php echo $result->days ?></b>
                                            </td>
                                            <td>
                                                <b><?php echo $result->reason ?></b>
                                            </td>
                                            <td>
                                                <b><?php if($result->isapproved==1)
                                                {
                                                    echo "Approved";
                                                }elseif($result->isapproved==NULL || $result->isapproved=='')
                                                {
                                                    echo "Pending";
                                                }elseif($result->isapproved==0)
                                                {
                                                    echo "Rejected";
                                                } ?></b>
                                            </td>
                                            <td>
                                            
                                            <b><?php echo $result->Updatedby ?></b>
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
        var URL = "<?php echo base_url('reports/report_employeeleaves') ?>" + "?" + $('#filterForm').serialize();

        if (download == 1) {
            URL = URL + "&download=1";
        }

        window.location.href = URL;
    }
</script>