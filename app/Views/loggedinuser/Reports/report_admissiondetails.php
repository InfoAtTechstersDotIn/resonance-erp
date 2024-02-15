<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Admission Details Report
                </h2>
            </div>
        </div>
        <form id="filterForm">
            <div class="row">
            <div class="col-md-3">
                    <label class="text-uppercase text-sm">Admission Date From</label>
                    <input type="text" onchange="filter(0)" placeholder="Admission Date From" name="AdmissionDateFrom" class="datepicker form-control mb" value="<?php echo (isset($_GET['AdmissionDateFrom']) && $_GET['AdmissionDateFrom'] != "") ? $_GET['AdmissionDateFrom'] : "" ?>">
                </div>
                <div class="col-md-3">
                    <label class="text-uppercase text-sm">Admission Date To</label>
                    <input type="text" onchange="filter(0)" placeholder="Admission Date To" name="AdmissionDateTo" class="datepicker form-control mb" value="<?php echo (isset($_GET['AdmissionDateTo']) && $_GET['AdmissionDateTo'] != "") ? $_GET['AdmissionDateTo'] : "" ?>">
                </div>
            </div>
        </form>
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
                                    <?php
                                    foreach ($lookups['branchlookup'] as $res) {
                                    ?>
                                        <th><?php echo $res->branchname; ?></th>
                                    <?php } ?>
                                    <th>Grand Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                class MyClass
                                {
                                    public $name;
                                    public $id;
                                }

                                $employees = [];

                                foreach ($AdmissionDetails as $result) {

                                    $foo = new MyClass();
                                    $foo->name = $result->name;
                                    $foo->id = $result->userid;

                                    array_push($employees, $foo);
                                }
                                sort($employees);
                                $employees = array_unique($employees, SORT_REGULAR);

                                foreach ($employees as $employee) :
                                ?>
                                    <tr>
                                        <td>
                                            <b><?php echo $employee->name == "" ? "-" : $employee->name ?></b>
                                        </td>
                                        <?php
                                        $TotalCount = 0;
                                        foreach ($lookups['branchlookup'] as $res) {
                                        ?>
                                            <td>
                                                <?php foreach ($AdmissionDetails as $AdmissionDet) {
                                                    if ($employee->id == $AdmissionDet->userid && $AdmissionDet->branchid == $res->branchid) {
                                                        echo $AdmissionDet->sum;
                                                        $TotalCount += $AdmissionDet->sum;
                                                    }
                                                }
                                                ?>
                                            </td>
                                        <?php
                                        }
                                        ?>
                                        <td>
                                            <b><?php echo $TotalCount; ?></b>
                                        </td>
                                    </tr>
                                <?php endforeach;
                                ?>
                                <tr>
                                    <td>
                                        <b>Grand Total</b>
                                    </td>
                                    <?php
                                    $TotalTotalCount = 0;

                                    foreach ($lookups['branchlookup'] as $res) {
                                        $TotalCount = 0;

                                    ?>
                                        <td>
                                            <?php foreach ($AdmissionDetails as $AdmissionDet) {
                                                if ($AdmissionDet->branchid == $res->branchid) {
                                                    $TotalCount += $AdmissionDet->sum;
                                                    $TotalTotalCount += $AdmissionDet->sum;
                                                }
                                            }
                                            ?>
                                            <b><?php echo $TotalCount ?></b>
                                        </td>
                                    <?php
                                    }
                                    ?>
                                    <td>
                                        <b><?php echo $TotalTotalCount ?></b>
                                    </td>
                                </tr>
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
        var URL = "<?php echo base_url('reports/report_admissiondetails') ?>" + "?" + $('#filterForm').serialize();

        if (download == 1) {
            URL = URL + "&download=1";
        }

        window.location.href = URL;
    }
</script>