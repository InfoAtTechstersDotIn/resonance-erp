<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Reservation Admissions Report
                </h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th><h3>Employee Name</h3></th>
                            <th><h3>Today</h3></th>
                            <th><h3>MTD</h3></th>
                            <th><h3>Overall</h3></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($ReservationAdmissions as $row) {
                        ?>
                            <tr>
                                <td><b><?php echo $row->name ?></b></td>
                                <td><?php echo $row->Today == 0 ? 0 : "<b>" . $row->Today . "</b>"; $todayTotal += $row->Today; ?></td>
                                <td><?php echo $row->MTD == 0 ? 0 : "<b>" . $row->MTD . "</b>"; $MTDTotal += $row->MTD; ?></td>
                                <td><?php echo $row->Total == 0 ? 0 : "<b>" . $row->Total . "</b>"; $overallTotal += $row->Total; ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                        <tr>
                            <td><h3>Total</h3></td>
                            <td><b><?php echo $todayTotal ?></b></td>
                            <td><b><?php echo $MTDTotal ?></b></td>
                            <td><b><?php echo $overallTotal ?></b></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>