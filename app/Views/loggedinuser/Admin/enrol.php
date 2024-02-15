<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Enroll
                    <a class="btn btn-success" style="float: right;" data-toggle="modal" data-target="#add">Add Enrollment</a>
                </h2>
            </div>
        </div>
        <form id="filterForm">
            <div class="row">
                <div class="col-md-3">
                    <label class="text-uppercase text-sm">Class</label>
                    <select name="classid" id="classid" onchange="filter()" style="width: 100%;" class="select2 form-control mb" required>
                        <option value="">Select</option>
                        <?php
                        foreach ($classes as $result) :
                        ?>
                            <option value="<?php echo $result->classid; ?>" <?php echo (isset($_GET['classid']) && $_GET['classid'] != "" && $_GET['classid'] == $result->classid) ? "selected" : "" ?>><?php echo $result->classname; ?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="text-uppercase text-sm">Teacher</label>
                    <select name="teacherid" id="teacherid" onchange="filter()" style="width: 100%;" class="select2 form-control mb" required>
                        <option value="">Select</option>
                        <?php
                        foreach ($teachers as $result) :
                        ?>
                            <option value="<?php echo $result->userid; ?>" <?php echo (isset($_GET['teacherid']) && $_GET['teacherid'] != "" && $_GET['teacherid'] == $result->userid) ? "selected" : "" ?>><?php echo $result->name; ?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="text-uppercase text-sm">Batch</label>
                    <select name="batchid" id="batchid" onchange="filter()" style="width: 100%;" class="select2 form-control mb" required>
                        <option value="">Select</option>
                        <?php
                        foreach ($lookups['batchlookup'] as $result) :
                        ?>
                            <option value="<?php echo $result->batchid; ?>" <?php echo (isset($_GET['batchid']) && $_GET['batchid'] != "" && $_GET['batchid'] == $result->batchid) ? "selected" : "" ?>><?php echo $result->batchname; ?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="text-uppercase text-sm">Branch</label>
                    <select name="branchid" id="branchid" onchange="filter()" style="width: 100%;" class="select2 form-control mb" required>
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
            </div>
            <br />
            <div class="row">
                <div class="col-md-3">
                    <label class="text-uppercase text-sm">Course</label>
                    <select name="courseid" id="courseid" onchange="filter()" style="width: 100%;" class="select2 form-control mb" required>
                        <option value="">Select</option>
                        <?php
                        foreach ($lookups['courselookup'] as $result) :
                        ?>
                            <option value="<?php echo $result->courseid; ?>" <?php echo (isset($_GET['courseid']) && $_GET['courseid'] != "" && $_GET['courseid'] == $result->courseid) ? "selected" : "" ?>><?php echo $result->coursename; ?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="text-uppercase text-sm">Section</label>
                    <select name="sectionid" id="sectionid" onchange="filter()" style="width: 100%;" class="select2 form-control mb" required>
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
                <div class="col-md-3">
                    <label class="text-uppercase text-sm">Subject</label>
                    <select name="subjectid" id="subjectid" onchange="filter()" style="width: 100%;" class="select2 form-control mb" required>
                        <option value="">Select</option>
                        <?php
                        foreach ($lookups['subjectlookup'] as $result) :
                        ?>
                            <option value="<?php echo $result->subjectid; ?>" <?php echo (isset($_GET['subjectid']) && $_GET['subjectid'] != "" && $_GET['subjectid'] == $result->subjectid) ? "selected" : "" ?>><?php echo $result->subjectname; ?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </div>
            </div>
        </form>
        <br /><br />
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblotherusers" class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>Student Details</th>
                                    <th>Class Details</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($enrollments != null) :
                                    foreach ($enrollments as $result) :
                                ?>
                                        <tr>
                                            <td><?php echo $result->studentname . ' - ' . $result->applicationnumber ?></td>
                                            <td><?php echo $result->classname . ' - ' . $result->teachername . ' - ' .
                                                           $result->batchname . ' - ' . $result->branchname . ' - ' .
                                                           $result->coursename . ' - ' . $result->sectionname . ' - ' . $result->subjectname
                                            ?></td>
                                            <td>
                                                <i onclick="remove('<?php echo $result->classid ?>', '<?php echo $result->studentid ?>')" class='fa fa-trash'></i>
                                            </td>
                                        </tr>
                                <?php endforeach;
                                endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="add" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title">Add Class</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?php echo base_url('admin/addenrol') ?>">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="text-uppercase text-sm">Class</label>
                                        <select name="classid[]" style="width: 100%;" class="select2 form-control mb" required multiple>
                                            <option value="">Select</option>
                                            <?php
                                            foreach ($classes as $result) :
                                            ?>
                                                <option value="<?php echo $result->classid; ?>"><?php echo $result->classname; ?></option>
                                            <?php
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <br />
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="text-uppercase text-sm">Students</label>
                                        <select name="studentid[]" style="width: 100%;" class="select2 form-control mb" required multiple>
                                            <option value="">Select</option>
                                            <?php
                                            foreach ($students as $result) :
                                            ?>
                                                <option value="<?php echo $result->userid; ?>"><?php echo $result->name; ?></option>
                                            <?php
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <br />
                                <button type="submit" class="btn btn-primary">Add Class</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function filter() {
        var classid = $('#classid').val();
        var teacherid = $('#teacherid').val();
        var batchid = $('#batchid').val();
        var branchid = $('#branchid').val();
        var courseid = $('#courseid').val();
        var sectionid = $('#sectionid').val();
        var subjectid = $('#subjectid').val();

        var URL = "<?php echo base_url('admin/enrol') ?>" + "?" + $('#filterForm').serialize();
        window.location.href = URL;
    }

    function remove(classid, studentid) {
        if (confirm('Are you sure?')) {
            window.location.href = "<?php echo base_url('admin/deleteenrol?classid=') ?>" + classid + "&studentid=" + studentid;
        }
    }
</script>