<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Out Pass Report
                </h2>
            </div>
        </div>
        <form id="filterForm">
            <div class="row">
                 <div class="col-md-3">
                    <label class="text-uppercase text-sm">Date From</label>
                    <input type="text" onchange="filter(0)" placeholder="Date From" name="PaymentDateFrom" class="datepicker form-control mb" value="<?php echo (isset($_GET['PaymentDateFrom']) && $_GET['PaymentDateFrom'] != "") ? $_GET['PaymentDateFrom'] : "" ?>">
                </div>
                <div class="col-md-3">
                    <label class="text-uppercase text-sm">Date To</label>
                    <input type="text" onchange="filter(0)" placeholder="Date To" name="PaymentDateTo" class="datepicker form-control mb" value="<?php echo (isset($_GET['PaymentDateTo']) && $_GET['PaymentDateTo'] != "") ? $_GET['PaymentDateTo'] : "" ?>">
                </div>
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
                    <label class="text-uppercase text-sm">Section</label>
                    <select name="sectionid" id="sectionid" onchange="filter(0)" style="width: 100%;" class="form-control mb">
                        <option value="">Select</option>
                        <?php
                        foreach ($lookups['sectionlookup'] as $result) :
                        ?>
                            <option value="<?php echo $result->sectionid; ?>" <?php echo (isset($_GET['sectionid']) && $_GET['sectionid'] != "" && $_GET['sectionid'] == $result->sectionid) ? "selected" : "" ?>><?php echo $result->sectionname; ?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </div>
               
            </div>
        </form>
        Today Out Going = <?php echo $out;?>
        <br>
        Today In coming = <?php echo $in;?>
        <br>
        Today Pending = <?php echo $pending;?>
        <br>
        <a class="btn btn-primary" onclick="filter(1)">Download</a>
        <br />
        <br />
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
                        <table class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>Student Details</th>
                                    <th>From Date</th>
                                    <th>To Date</th>
                                    <th>Data</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($outpass != null) :
                                    foreach ($outpass as $result) :
                                ?>
                                        <tr>
                                            <td>
                                                <b>Application Number:</b> <?php echo $result->applicationnumber ?><br />
                                                <b>Student Name:</b> <?php echo $result->name ?><br />
                                                <b>Gender:</b> <?php echo $result->gendername ?><br />
                                                <b>Course:</b> <?php echo $result->coursename ?><br />
                                                <b>Section:</b> <?php echo $result->sectionname ?><br />
                                                <b>Branch:</b> <?php echo $result->branchname ?><br />
                                            </td>
                                            <td>
                                                <?php echo $result->fromdate ?>
                                            </td>
                                            <td>
                                                <?php echo $result->todate ?>
                                            </td>
                                            <td>
                                                <?php 
                                                $data = json_decode($result->data);
                                      
                                                ?>
                                                <b>Purpose:</b> <?php echo $data->Purpose ?><br />
                                                <b>Accompanied By:</b> <?php echo $data->gardian ?><br />
                                                <b>Days:</b> <?php echo $data->Days ?><br />
                                                <b>Hours:</b> <?php echo $data->Hours ?><br />
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
        var URL = "<?php echo base_url('reports/report_outpass') ?>" + "?" + $('#filterForm').serialize();

        if (download == 1) {
            URL = URL + "&download=1";
        }

        window.location.href = URL;
    }
</script>