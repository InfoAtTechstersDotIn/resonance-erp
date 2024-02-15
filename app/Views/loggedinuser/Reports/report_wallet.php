<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Wallet Report
                </h2>
            </div>
        </div>
        <form id="filterForm">
            <div class="row">
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
                    <label class="text-uppercase text-sm">Wallet Type</label>
                    <select name="wallettypeid" id="wallettypeid" onchange="filter(0)" style="width: 100%;" class="form-control mb">
                        <option value="">Select</option>
                        <?php
                        foreach ($lookups['wallettypelookup'] as $result) :
                        ?>
                            <option value="<?php echo $result->wallettypeid; ?>" <?php echo (isset($_GET['wallettypeid']) && $_GET['wallettypeid'] != "" && $_GET['wallettypeid'] == $result->wallettypeid) ? "selected" : "" ?>><?php echo $result->wallettypename; ?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </div>
            </div>
        </form>
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
                                    <th>Wallet Type</th>
                                    <th>Wallet Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($report_wallet != null) :
                                    foreach ($report_wallet as $result) :
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
                                                <?php echo $result->wallettypename ?>
                                            </td>
                                            <td>
                                                <?php echo $result->amount ?>
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
        var URL = "<?php echo base_url('reports/report_wallet') ?>" + "?" + $('#filterForm').serialize();

        if (download == 1) {
            URL = URL + "&download=1";
        }

        window.location.href = URL;
    }
</script>