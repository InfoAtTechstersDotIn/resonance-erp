<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Revenue Report
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
                                    <th>Branch Name</th>
                                    <th>Total Students</th>
                                    <th>Original Fees</th>
                                    <th>Tuition Fees</th>
                                    <th>Hostel Fees</th>
                                    <th>Miscellaneous Fees</th>
                                    <th>Committed Fees</th>
                                    <th>Scholarship Availed</th>
                                    <th>Total Collected</th>
                                    <th>Pending Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($report_revenue != null) :
                                    foreach ($report_revenue as $result) :
                                ?>
                                        <tr>
                                            <td>
                                                <b><?php echo $result->branchname ?></b>
                                            </td>
                                            <td>
                                                <?php echo $result->TotalStudents ?>
                                            </td>
                                            <td>
                                                <?php echo $result->OriginalFee ?>
                                            </td>
                                            <td>
                                                <?php echo $result->TotalTuitionFee ?>
                                            </td>
                                            <td>
                                                <?php echo $result->TotalHostelFee ?>
                                            </td>
                                            <td>
                                                <?php echo $result->TotalMiscelleniousFee ?>
                                            </td>
                                            <td>
                                                <?php echo $result->CommittedFee ?>
                                            </td>
                                            <td>
                                                <?php echo $result->TotalScholarship ?>
                                            </td>
                                            <td>
                                                <?php echo $result->TotalCollected ?>
                                            </td>
                                            <td>
                                                <?php echo $result->TotalPending ?>
                                            </td>
                                        </tr>
                                <?php endforeach;
                                endif; ?>
                                <?php
                                $totalStudents = 0;
                                $totalOriginal = 0;
                                $totalTuition = 0;
                                $totalHostel = 0;
                                $totalMiscellaneous = 0;
                                $totalCommitted = 0;
                                $totalScholarship = 0;
                                $totalCollected = 0;
                                $totalPending = 0;

                                if ($report_revenue != null) :
                                    foreach ($report_revenue as $result) :
                                        $totalStudents += $result->TotalStudents;
                                        $totalOriginal += $result->OriginalFee;
                                        $totalTuition += $result->TotalTuitionFee;
                                        $totalHostel += $result->TotalHostelFee;
                                        $totalMiscellaneous += $result->TotalMiscelleniousFee;
                                        $totalCommitted += $result->CommittedFee;
                                        $totalScholarship += $result->TotalScholarship;
                                        $totalCollected += $result->TotalCollected;
                                        $totalPending += $result->TotalPending;
                                    endforeach;
                                ?>
                                    <tr style="font-weight:bold">
                                        <td>
                                            Total
                                        </td>
                                        <td>
                                            <?php echo $totalStudents; ?>
                                        </td>
                                        <td>
                                            <?php echo $totalOriginal; ?>
                                        </td>
                                        <td>
                                            <?php echo $totalTuition; ?>
                                        </td>
                                        <td>
                                            <?php echo $totalHostel; ?>
                                        </td>
                                        <td>
                                            <?php echo $totalMiscellaneous; ?>
                                        </td>
                                        <td>
                                            <?php echo $totalCommitted; ?>
                                        </td>
                                        <td>
                                            <?php echo $totalScholarship; ?>
                                        </td>
                                        <td>
                                            <?php echo $totalCollected; ?>
                                        </td>
                                        <td>
                                            <?php echo $totalPending; ?>
                                        </td>
                                    </tr>
                                <?php
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