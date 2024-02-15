<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Budget Report
                </h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
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
                                    <th>Branch Name</th>
                                    <th>Amount</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($report_budget != null) :
                                    foreach ($report_budget as $result) :
                                ?>
                                        <tr>
                                            <td>
                                                <b><?php echo $result->name ?></b>
                                            </td>
                                             <td>
                                                <b><?php echo $result->branchname ?></b>
                                            </td>
                                             <td>
                                                <b><?php echo $result->total ?></b>
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
        var URL = "<?php echo base_url('reports/report_revenue') ?>" + "?" + $('#filterForm').serialize();

        if (download == 1) {
            URL = URL + "&download=1";
        }

        window.location.href = URL;
    }
</script>