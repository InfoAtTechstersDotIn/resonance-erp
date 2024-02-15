<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Application Summary Report
                </h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th rowspan="3">
                                <h1><b>Branch</b></h1>
                            </th>
                            <th colspan="6">
                                <h1><b>JEE</b></h1>
                            </th>
                            <th colspan="6">
                                <h1><b>NEET</b></h1>
                            </th>
                            <th rowspan="3">
                                <h1>Branch Total</h1>
                            </th>
                        </tr>
                        <tr>
                            <th colspan="2">
                                <h3><b>Residential</b></h3>
                            </th>
                            <th colspan="2">
                                <h3><b>Semi Residential</b></h3>
                            </th>
                            <th colspan="2">
                                <h3><b>Day Scholar</b></h3>
                            </th>
                            <th colspan="2">
                                <h3><b>Residential</b></h3>
                            </th>
                            <th colspan="2">
                                <h3><b>Semi Residential</b></h3>
                            </th>
                            <th colspan="2">
                                <h3><b>Day Scholar</b></h3>
                            </th>
                        </tr>
                        <tr>
                            <th>
                                <h5><b>Boys</b></h5>
                            </th>
                            <th>
                                <h5><b>Girls</b></h5>
                            </th>
                            <th>
                                <h5><b>Boys</b></h5>
                            </th>
                            <th>
                                <h5><b>Girls</b></h5>
                            </th>
                            <th>
                                <h5><b>Boys</b></h5>
                            </th>
                            <th>
                                <h5><b>Girls</b></h5>
                            </th>
                            <th>
                                <h5><b>Boys</b></h5>
                            </th>
                            <th>
                                <h5><b>Girls</b></h5>
                            </th>
                            <th>
                                <h5><b>Boys</b></h5>
                            </th>
                            <th>
                                <h5><b>Girls</b></h5>
                            </th>
                            <th>
                                <h5><b>Boys</b></h5>
                            </th>
                            <th>
                                <h5><b>Girls</b></h5>
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($lookups['branchlookup'] as $branch) {
                            $branchTotal = 0;
                        ?>
                            <tr>
                                <td><b><?php echo $branch->branchname ?></b></td>
                                <td>
                                    <?php
                                    $count = 0;
                                    foreach ($ReservationSummary as $reservation) {
                                        if (
                                            $reservation->branchid == $branch->branchid &&
                                            (($reservation->courseid == 1) ||
                                                ($reservation->courseid == 2) ||
                                                ($reservation->courseid == 3)) &&
                                            ($reservation->admissiontypeid == 1) &&
                                            ($reservation->genderid == 1)
                                        ) {
                                            $count++;
                                            $branchTotal++;
                                        }
                                    }
                                    echo $count == 0 ? "<small>0</small>" : "<b>" . $count . "</b>";
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $count = 0;
                                    foreach ($ReservationSummary as $reservation) {
                                        if (
                                            $reservation->branchid == $branch->branchid &&
                                            (($reservation->courseid == 1) ||
                                                ($reservation->courseid == 2) ||
                                                ($reservation->courseid == 3)) &&
                                            ($reservation->admissiontypeid == 1) &&
                                            ($reservation->genderid == 2)
                                        ) {
                                            $count++;
                                            $branchTotal++;
                                        }
                                    }
                                    echo $count == 0 ? "<small>0</small>" : "<b>" . $count . "</b>";
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $count = 0;
                                    foreach ($ReservationSummary as $reservation) {
                                        if (
                                            $reservation->branchid == $branch->branchid &&
                                            (($reservation->courseid == 1) ||
                                                ($reservation->courseid == 2) ||
                                                ($reservation->courseid == 3)) &&
                                            ($reservation->admissiontypeid == 2) &&
                                            ($reservation->genderid == 1)
                                        ) {
                                            $count++;
                                            $branchTotal++;
                                        }
                                    }
                                    echo $count == 0 ? "<small>0</small>" : "<b>" . $count . "</b>";
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $count = 0;
                                    foreach ($ReservationSummary as $reservation) {
                                        if (
                                            $reservation->branchid == $branch->branchid &&
                                            (($reservation->courseid == 1) ||
                                                ($reservation->courseid == 2) ||
                                                ($reservation->courseid == 3)) &&
                                            ($reservation->admissiontypeid == 2) &&
                                            ($reservation->genderid == 2)
                                        ) {
                                            $count++;
                                            $branchTotal++;
                                        }
                                    }
                                    echo $count == 0 ? "<small>0</small>" : "<b>" . $count . "</b>";
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $count = 0;
                                    foreach ($ReservationSummary as $reservation) {
                                        if (
                                            $reservation->branchid == $branch->branchid &&
                                            (($reservation->courseid == 1) ||
                                                ($reservation->courseid == 2) ||
                                                ($reservation->courseid == 3)) &&
                                            ($reservation->admissiontypeid == 3) &&
                                            ($reservation->genderid == 1)
                                        ) {
                                            $count++;
                                            $branchTotal++;
                                        }
                                    }
                                    echo $count == 0 ? "<small>0</small>" : "<b>" . $count . "</b>";
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $count = 0;
                                    foreach ($ReservationSummary as $reservation) {
                                        if (
                                            $reservation->branchid == $branch->branchid &&
                                            (($reservation->courseid == 1) ||
                                                ($reservation->courseid == 2) ||
                                                ($reservation->courseid == 3)) &&
                                            ($reservation->admissiontypeid == 3) &&
                                            ($reservation->genderid == 2)
                                        ) {
                                            $count++;
                                            $branchTotal++;
                                        }
                                    }
                                    echo $count == 0 ? "<small>0</small>" : "<b>" . $count . "</b>";
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $count = 0;
                                    foreach ($ReservationSummary as $reservation) {
                                        if (
                                            $reservation->branchid == $branch->branchid &&
                                            (($reservation->courseid == 4) ||
                                                ($reservation->courseid == 5) ||
                                                ($reservation->courseid == 6)) &&
                                            ($reservation->admissiontypeid == 1) &&
                                            ($reservation->genderid == 1)
                                        ) {
                                            $count++;
                                            $branchTotal++;
                                        }
                                    }
                                    echo $count == 0 ? "<small>0</small>" : "<b>" . $count . "</b>";
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $count = 0;
                                    foreach ($ReservationSummary as $reservation) {
                                        if (
                                            $reservation->branchid == $branch->branchid &&
                                            (($reservation->courseid == 4) ||
                                                ($reservation->courseid == 5) ||
                                                ($reservation->courseid == 6)) &&
                                            ($reservation->admissiontypeid == 1) &&
                                            ($reservation->genderid == 2)
                                        ) {
                                            $count++;
                                            $branchTotal++;
                                        }
                                    }
                                    echo $count == 0 ? "<small>0</small>" : "<b>" . $count . "</b>";
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $count = 0;
                                    foreach ($ReservationSummary as $reservation) {
                                        if (
                                            $reservation->branchid == $branch->branchid &&
                                            (($reservation->courseid == 4) ||
                                                ($reservation->courseid == 5) ||
                                                ($reservation->courseid == 6)) &&
                                            ($reservation->admissiontypeid == 2) &&
                                            ($reservation->genderid == 1)
                                        ) {
                                            $count++;
                                            $branchTotal++;
                                        }
                                    }
                                    echo $count == 0 ? "<small>0</small>" : "<b>" . $count . "</b>";
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $count = 0;
                                    foreach ($ReservationSummary as $reservation) {
                                        if (
                                            $reservation->branchid == $branch->branchid &&
                                            (($reservation->courseid == 4) ||
                                                ($reservation->courseid == 5) ||
                                                ($reservation->courseid == 6)) &&
                                            ($reservation->admissiontypeid == 2) &&
                                            ($reservation->genderid == 2)
                                        ) {
                                            $count++;
                                            $branchTotal++;
                                        }
                                    }
                                    echo $count == 0 ? "<small>0</small>" : "<b>" . $count . "</b>";
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $count = 0;
                                    foreach ($ReservationSummary as $reservation) {
                                        if (
                                            $reservation->branchid == $branch->branchid &&
                                            (($reservation->courseid == 4) ||
                                                ($reservation->courseid == 5) ||
                                                ($reservation->courseid == 6)) &&
                                            ($reservation->admissiontypeid == 3) &&
                                            ($reservation->genderid == 1)
                                        ) {
                                            $count++;
                                            $branchTotal++;
                                        }
                                    }
                                    echo $count == 0 ? "<small>0</small>" : "<b>" . $count . "</b>";
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $count = 0;
                                    foreach ($ReservationSummary as $reservation) {
                                        if (
                                            $reservation->branchid == $branch->branchid &&
                                            (($reservation->courseid == 4) ||
                                                ($reservation->courseid == 5) ||
                                                ($reservation->courseid == 6)) &&
                                            ($reservation->admissiontypeid == 3) &&
                                            ($reservation->genderid == 2)
                                        ) {
                                            $count++;
                                            $branchTotal++;
                                        }
                                    }
                                    echo $count == 0 ? "<small>0</small>" : "<b>" . $count . "</b>";
                                    ?>
                                </td>
                                <td>
                                    <?php echo "<b>" . $branchTotal . "</b>" ?>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td>
                                <h1>Total</h1>
                            <td>
                                <?php
                                $count = 0;
                                foreach ($ReservationSummary as $reservation) {
                                    if (
                                        (($reservation->courseid == 1) ||
                                            ($reservation->courseid == 2) ||
                                            ($reservation->courseid == 3)) &&
                                        ($reservation->admissiontypeid == 1) &&
                                        ($reservation->genderid == 1)
                                    ) {
                                        $count++;
                                        $overallTotal++;
                                    }
                                }
                                echo $count == 0 ? "<small>0</small>" : "<b>" . $count . "</b>";
                                ?>
                            </td>
                            <td>
                                <?php
                                $count = 0;
                                foreach ($ReservationSummary as $reservation) {
                                    if (
                                        (($reservation->courseid == 1) ||
                                            ($reservation->courseid == 2) ||
                                            ($reservation->courseid == 3)) &&
                                        ($reservation->admissiontypeid == 1) &&
                                        ($reservation->genderid == 2)
                                    ) {
                                        $count++;
                                        $overallTotal++;
                                    }
                                }
                                echo $count == 0 ? "<small>0</small>" : "<b>" . $count . "</b>";
                                ?>
                            </td>
                            <td>
                                <?php
                                $count = 0;
                                foreach ($ReservationSummary as $reservation) {
                                    if (
                                        (($reservation->courseid == 1) ||
                                            ($reservation->courseid == 2) ||
                                            ($reservation->courseid == 3)) &&
                                        ($reservation->admissiontypeid == 2) &&
                                        ($reservation->genderid == 1)
                                    ) {
                                        $count++;
                                        $overallTotal++;
                                    }
                                }
                                echo $count == 0 ? "<small>0</small>" : "<b>" . $count . "</b>";
                                ?>
                            </td>
                            <td>
                                <?php
                                $count = 0;
                                foreach ($ReservationSummary as $reservation) {
                                    if (
                                        (($reservation->courseid == 1) ||
                                            ($reservation->courseid == 2) ||
                                            ($reservation->courseid == 3)) &&
                                        ($reservation->admissiontypeid == 2) &&
                                        ($reservation->genderid == 2)
                                    ) {
                                        $count++;
                                        $overallTotal++;
                                    }
                                }
                                echo $count == 0 ? "<small>0</small>" : "<b>" . $count . "</b>";
                                ?>
                            </td>
                            <td>
                                <?php
                                $count = 0;
                                foreach ($ReservationSummary as $reservation) {
                                    if (
                                        (($reservation->courseid == 1) ||
                                            ($reservation->courseid == 2) ||
                                            ($reservation->courseid == 3)) &&
                                        ($reservation->admissiontypeid == 3) &&
                                        ($reservation->genderid == 1)
                                    ) {
                                        $count++;
                                        $overallTotal++;
                                    }
                                }
                                echo $count == 0 ? "<small>0</small>" : "<b>" . $count . "</b>";
                                ?>
                            </td>
                            <td>
                                <?php
                                $count = 0;
                                foreach ($ReservationSummary as $reservation) {
                                    if (
                                        (($reservation->courseid == 1) ||
                                            ($reservation->courseid == 2) ||
                                            ($reservation->courseid == 3)) &&
                                        ($reservation->admissiontypeid == 3) &&
                                        ($reservation->genderid == 2)
                                    ) {
                                        $count++;
                                        $overallTotal++;
                                    }
                                }
                                echo $count == 0 ? "<small>0</small>" : "<b>" . $count . "</b>";
                                ?>
                            </td>
                            <td>
                                <?php
                                $count = 0;
                                foreach ($ReservationSummary as $reservation) {
                                    if (
                                        (($reservation->courseid == 4) ||
                                            ($reservation->courseid == 5) ||
                                            ($reservation->courseid == 6)) &&
                                        ($reservation->admissiontypeid == 1) &&
                                        ($reservation->genderid == 1)
                                    ) {
                                        $count++;
                                        $overallTotal++;
                                    }
                                }
                                echo $count == 0 ? "<small>0</small>" : "<b>" . $count . "</b>";
                                ?>
                            </td>
                            <td>
                                <?php
                                $count = 0;
                                foreach ($ReservationSummary as $reservation) {
                                    if (
                                        (($reservation->courseid == 4) ||
                                            ($reservation->courseid == 5) ||
                                            ($reservation->courseid == 6)) &&
                                        ($reservation->admissiontypeid == 1) &&
                                        ($reservation->genderid == 2)
                                    ) {
                                        $count++;
                                        $overallTotal++;
                                    }
                                }
                                echo $count == 0 ? "<small>0</small>" : "<b>" . $count . "</b>";
                                ?>
                            </td>
                            <td>
                                <?php
                                $count = 0;
                                foreach ($ReservationSummary as $reservation) {
                                    if (
                                        (($reservation->courseid == 4) ||
                                            ($reservation->courseid == 5) ||
                                            ($reservation->courseid == 6)) &&
                                        ($reservation->admissiontypeid == 2) &&
                                        ($reservation->genderid == 1)
                                    ) {
                                        $count++;
                                        $overallTotal++;
                                    }
                                }
                                echo $count == 0 ? "<small>0</small>" : "<b>" . $count . "</b>";
                                ?>
                            </td>
                            <td>
                                <?php
                                $count = 0;
                                foreach ($ReservationSummary as $reservation) {
                                    if (
                                        (($reservation->courseid == 4) ||
                                            ($reservation->courseid == 5) ||
                                            ($reservation->courseid == 6)) &&
                                        ($reservation->admissiontypeid == 2) &&
                                        ($reservation->genderid == 2)
                                    ) {
                                        $count++;
                                        $overallTotal++;
                                    }
                                }
                                echo $count == 0 ? "<small>0</small>" : "<b>" . $count . "</b>";
                                ?>
                            </td>
                            <td>
                                <?php
                                $count = 0;
                                foreach ($ReservationSummary as $reservation) {
                                    if (
                                        (($reservation->courseid == 4) ||
                                            ($reservation->courseid == 5) ||
                                            ($reservation->courseid == 6)) &&
                                        ($reservation->admissiontypeid == 3) &&
                                        ($reservation->genderid == 1)
                                    ) {
                                        $count++;
                                        $overallTotal++;
                                    }
                                }
                                echo $count == 0 ? "<small>0</small>" : "<b>" . $count . "</b>";
                                ?>
                            </td>
                            <td>
                                <?php
                                $count = 0;
                                foreach ($ReservationSummary as $reservation) {
                                    if (
                                        (($reservation->courseid == 4) ||
                                            ($reservation->courseid == 5) ||
                                            ($reservation->courseid == 6)) &&
                                        ($reservation->admissiontypeid == 3) &&
                                        ($reservation->genderid == 2)
                                    ) {
                                        $count++;
                                        $overallTotal++;
                                    }
                                }
                                echo $count == 0 ? "<small>0</small>" : "<b>" . $count . "</b>";
                                ?>
                            </td>
                            <td>
                                <?php echo "<b>" . $overallTotal . "</b>" ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- 
    
SELECT COUNT(reservation.courseid), coursename, admissiontypename, gendername, branchname FROM `reservation` 
JOIN courselookup ON courselookup.courseid = reservation.courseid
JOIN admissiontypelookup ON admissiontypelookup.admissiontypeid = reservation.admissiontypeid
JOIN genderlookup ON genderlookup.genderid = reservation.genderid
JOIN branchlookup ON branchlookup.branchid = reservation.branchid
GROUP BY reservation.courseid, reservation.admissiontypeid, reservation.genderid, reservation.branchid

-->