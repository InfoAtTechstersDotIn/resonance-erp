<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Leave Approved
                </h2>
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblotherusers" class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>Employee Name</th>
                                    <th>Leave Request From</th>
                                    <th>Leave Request To</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($leaveRequests as $result) :
                                ?>
                                    <tr>
                                    <td><?php echo $result->name ?></td>
                                        <td><?php echo date_format(date_create($result->leavefrom), 'd/m/Y') ?></td>
                                        <td><?php echo date_format(date_create($result->leaveto), 'd/m/Y') ?></td>
                                        <td><?php echo $result->reason ?></td>
                                        <td>Rejected
                                           </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>