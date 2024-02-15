<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Resofast Registrations
                </h2>
                <br />
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblStudents" class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>Resofast Id</th>
                                    <th>Student Name</th>
                                    <th>Mobile/ Email</th>
                                    <th>Aadhaar</th>
                                    <th>Exam Date</th>
                                    <th>Scores</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($StudentDetails as $result) :
                                ?>
                                    <tr>
                                        <td><?php echo $result->reference_no ?></td>
                                        <td><?php echo $result->name ?></td>
                                        <td><?php echo $result->mobile . "<br />" . $result->email ?></td>
                                        <td><?php echo $result->aadhar; ?></td>
                                        <td><?php echo $result->mode . "<br />" . $result->exam_date; ?></td>
                                        <td>Score: <?php echo $result->score ?><br />
                                            Interview Score: <?php echo $result->interview_score ?></td>
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