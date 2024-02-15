<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Business Calendar
                </h2>
                <br />
                <form>
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" name="date" class="form-control datepicker" placeholder="Filter Date" />
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </form>
                <br />
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblotherusers" class="DataTable table table-striped ">
                            <thead>
                                <tr>
                                    <th>Sno</th>
                                    <th>Date</th>
                                    <th>Day of the Week</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($business_days != null) :
                                    $Date = isset($_GET['date']) ? $_GET['date'] : 0;
                                    $count = 1;
                                    foreach ($business_days as $result) :
                                        if ($Date == 0 || $Date == date_format(date_create($result->date), 'd/m/Y')) :
                                ?>
                                            <tr>
                                                <td><?php echo $count;?></td>
                                                <td><b><?php echo date_format(date_create($result->date), 'd/m/Y') ?></b></td>
                                                <td><?php echo $result->day ?></td>
                                                <td>
                                                    <form action="<?php echo base_url('admin/update_business_day') ?>" method="post">
                                                        Is Business Day?<br />
                                                        <b style="color: white;background-color: <?php echo $result->is_employee_workingday == 1 ? 'green' : 'red' ?>">Employee</b> <input type="checkbox" name="is_employee_workingday" <?php echo $result->is_employee_workingday == 1 ? 'checked' : '' ?> /><br />
                                                        <b style="color: white;background-color: <?php echo $result->is_student_workingday == 1 ? 'green' : 'red' ?>">Student</b> <input type="checkbox" name="is_student_workingday" <?php echo $result->is_student_workingday == 1 ? 'checked' : '' ?> />
                                                        <br />
                                                        <input type="hidden" name="date" value="<?php echo $result->date ?>" />
                                                        <input type="text" name="comment" value="<?php echo $result->comment ?>" class="form-control" />
                                                        <input type="submit" value="Submit" class="btn btn-primary">
                                                    </form>
                                                </td>
                                            </tr>
                                <?php
                                        endif;
                                        $count++;
                                    endforeach;
                                endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>