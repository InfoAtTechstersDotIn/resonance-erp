<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Promote
                    <?php if ($_SESSION['userdetails']->userid == 1) : ?>

                    <?php endif; ?>
                </h2>
                <div class="row">
                    <form method="post" id="studentform" action="<?php echo base_url('admin/promotestudents') ?>">
                        <div class="col-md-3">
                            <select id="batchid" name="batchid" style="width: 100%;" class="select2 form-control mb" required>
                                <option value="">Select Academic Year</option>
                                <?php
                                foreach ($lookups['batchlookup'] as $batch) :
                                    if ($_SESSION['activebatch'] != $batch->batchid) :
                                ?>
                                        <option value="<?php echo $batch->batchid; ?>"><?php echo $batch->batchname; ?></option>
                                <?php
                                    endif;
                                endforeach;
                                ?>
                            </select>
                        </div>
                        <br />
                        <br />
                        <div class="col-md-12">
                            <button type="submit" name="promote" class="btn btn-primary">Promote Selected Students</button>
                            <br />
                            <table id="tblStudents" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" onchange="selectAll(this.checked)" /> Select All</th>
                                        <th>Application Number/ Name</th>
                                        <th>Branch</th>
                                        <th>Cource - Admission Type - Section</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($StudentDetails as $result) :
                                    ?>
                                        <tr>
                                            <td><input type="checkbox" name="userid[]" value="<?php echo $result->userid ?>" /> </td>
                                            <td>
                                                <?php echo $result->applicationnumber ?><br />
                                                <a href="<?php echo base_url('users/studentdetails') ?>?id=<?php echo $result->userid; ?>"><?php echo $result->name ?></a>
                                            </td>
                                            <td><?php echo $result->branchname ?></td>
                                            <td><?php echo $result->coursename . ", " . $result->admissiontypename . "<br />Section: " . $result->sectionname ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <br />
                            <button type="submit" name="promote" class="btn btn-primary">Promote Selected Students</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function selectAll(checked) {
        checkboxes = document.getElementsByName("userid[]");

        for (var i in checkboxes) {
            checkboxes[i].checked = checked;
        }
    }
</script>