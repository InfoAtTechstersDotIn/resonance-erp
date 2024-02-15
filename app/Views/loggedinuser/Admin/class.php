<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Class
                    <a class="btn btn-success" style="float: right;" data-toggle="modal" data-target="#add">Add Class</a>
                </h2>
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblotherusers" class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>Class Name</th>
                                    <th>Teacher</th>
                                    <th>Batch</th>
                                    <th>Branch</th>
                                    <th>Course</th>
                                    <th>Section</th>
                                    <th>Subject</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($classes != null) :
                                    foreach ($classes as $result) :
                                ?>
                                        <tr>
                                            <td><b title="<?php echo $result->classdescription ?>"><?php echo $result->classname ?></b></td>
                                            <td><?php echo $result->name ?></td>
                                            <td><?php echo $result->batchname ?></td>
                                            <td><?php echo $result->branchname ?></td>
                                            <td><?php echo $result->coursename ?></td>
                                            <td><?php echo $result->sectionname ?></td>
                                            <td><?php echo $result->subjectname ?></td>
                                            <td>
                                                <i onclick="edit('<?php echo $result->classid ?>', '<?php echo  $result->classname ?>', '<?php echo $result->teacherid ?>', '<?php echo $result->classdescription ?>', '<?php echo $result->batchid ?>', '<?php echo $result->branchid ?>', '<?php echo $result->courseid ?>', '<?php echo $result->sectionid ?>', '<?php echo $result->subjectid ?>')" data-toggle="modal" data-target="#edit" class="fa fa-pencil-square-o editbtn"></i>&nbsp;&nbsp;&nbsp;
                                                <i onclick="remove('<?php echo $result->classid ?>')" class='fa fa-trash'></i>
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
                            <form method="post" action="<?php echo base_url('admin/addclass') ?>">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Class Name</label>
                                        <input type="text" placeholder="Class Name" name="classname" class="form-control mb" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Teacher</label>
                                        <select name="teacherid" style="width: 100%;" class="select2 form-control mb" required>
                                            <option value="">Select</option>
                                            <?php
                                            foreach ($teachers as $result) :
                                            ?>
                                                <option value="<?php echo $result->userid; ?>"><?php echo $result->name; ?></option>
                                            <?php
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="text-uppercase text-sm">Class Description</label>
                                        <textarea placeholder="Class Description" name="classdescription" class="form-control mb" required></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Batch</label>
                                        <select name="batchid" style="width: 100%;" class="select2 form-control mb" required>
                                            <option value="">Select</option>
                                            <?php
                                            foreach ($lookups['batchlookup'] as $result) :
                                            ?>
                                                <option value="<?php echo $result->batchid; ?>"><?php echo $result->batchname; ?></option>
                                            <?php
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Branch</label>
                                        <select name="branchid" style="width: 100%;" class="select2 form-control mb" required>
                                            <option value="">Select</option>
                                            <?php
                                            foreach ($lookups['branchlookup'] as $result) :
                                            ?>
                                                <option value="<?php echo $result->branchid; ?>"><?php echo $result->branchname; ?></option>
                                            <?php
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <br />
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Course</label>
                                        <select name="courseid" style="width: 100%;" class="select2 form-control mb" required>
                                            <option value="">Select</option>
                                            <?php
                                            foreach ($lookups['courselookup'] as $result) :
                                            ?>
                                                <option value="<?php echo $result->courseid; ?>"><?php echo $result->coursename; ?></option>
                                            <?php
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <br />
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Section</label>
                                        <select name="sectionid" style="width: 100%;" class="select2 form-control mb" required>
                                            <option value="">Select</option>
                                            <?php
                                            foreach ($lookups['sectionlookup'] as $result) :
                                            ?>
                                                <option value="<?php echo $result->sectionid; ?>"><?php echo $result->sectionname; ?></option>
                                            <?php
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Subject</label>
                                        <select name="subjectid" style="width: 100%;" class="select2 form-control mb" required>
                                            <option value="">Select</option>
                                            <?php
                                            foreach ($lookups['subjectlookup'] as $result) :
                                            ?>
                                                <option value="<?php echo $result->subjectid; ?>"><?php echo $result->subjectname; ?></option>
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

            <div class="modal fade" id="edit" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title">Edit Class</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?php echo base_url('admin/updateclass') ?>">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="hidden" name="classid" id="classid" />
                                        <label class="text-uppercase text-sm">Class Name</label>
                                        <input type="text" placeholder="Class Name" name="classname" id="classname" class="form-control mb" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Teacher</label>
                                        <select name="teacherid" id="teacherid" style="width: 100%;" class="select2 form-control mb" required>
                                            <option value="">Select</option>
                                            <?php
                                            foreach ($teachers as $result) :
                                            ?>
                                                <option value="<?php echo $result->userid; ?>"><?php echo $result->name; ?></option>
                                            <?php
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="text-uppercase text-sm">Class Description</label>
                                        <textarea placeholder="Class Description" name="classdescription" id="classdescription" class="form-control mb" required></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Batch</label>
                                        <select name="batchid" id="batchid" style="width: 100%;" class="select2 form-control mb" required>
                                            <option value="">Select</option>
                                            <?php
                                            foreach ($lookups['batchlookup'] as $result) :
                                            ?>
                                                <option value="<?php echo $result->batchid; ?>"><?php echo $result->batchname; ?></option>
                                            <?php
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Branch</label>
                                        <select name="branchid" id="branchid" style="width: 100%;" class="select2 form-control mb" required>
                                            <option value="">Select</option>
                                            <?php
                                            foreach ($lookups['branchlookup'] as $result) :
                                            ?>
                                                <option value="<?php echo $result->branchid; ?>"><?php echo $result->branchname; ?></option>
                                            <?php
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <br />
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Course</label>
                                        <select name="courseid" id="courseid" style="width: 100%;" class="select2 form-control mb" required>
                                            <option value="">Select</option>
                                            <?php
                                            foreach ($lookups['courselookup'] as $result) :
                                            ?>
                                                <option value="<?php echo $result->courseid; ?>"><?php echo $result->coursename; ?></option>
                                            <?php
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <br />
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Section</label>
                                        <select name="sectionid" id="sectionid" style="width: 100%;" class="select2 form-control mb" required>
                                            <option value="">Select</option>
                                            <?php
                                            foreach ($lookups['sectionlookup'] as $result) :
                                            ?>
                                                <option value="<?php echo $result->sectionid; ?>"><?php echo $result->sectionname; ?></option>
                                            <?php
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Subject</label>
                                        <select name="subjectid" id="subjectid" style="width: 100%;" class="select2 form-control mb" required>
                                            <option value="">Select</option>
                                            <?php
                                            foreach ($lookups['subjectlookup'] as $result) :
                                            ?>
                                                <option value="<?php echo $result->subjectid; ?>"><?php echo $result->subjectname; ?></option>
                                            <?php
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <br />
                                <button type="submit" class="btn btn-primary">Update Class</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function edit(classid, classname, teacherid, classdescription, batchid, branchid, courseid, sectionid, subjectid) {
        $('#classid').val(classid);
        $('#classname').val(classname);
        $('#teacherid').val(teacherid).trigger('change');
        $('#classdescription').val(classdescription);
        $('#batchid').val(batchid).trigger('change');
        $('#branchid').val(branchid).trigger('change');
        $('#courseid').val(courseid).trigger('change');
        $('#sectionid').val(sectionid).trigger('change');
        $('#subjectid').val(subjectid).trigger('change');
    }

    function remove(id) {
        if (confirm('Are you sure?')) {
            window.location.href = "<?php echo base_url('admin/deleteclass?id=') ?>" + id;
        }
    }
</script>