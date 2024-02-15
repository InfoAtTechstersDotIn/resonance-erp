<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Student Attendance
                </h2>
            </div>
        </div>
        <form id="filterForm">
            <div class="row">
                <div class="col-md-3">
                    <label class="text-uppercase text-sm"> Date</label>
                    <input type="text" style="height: 30px !important" onchange="filter()" value="<?php echo (isset($_GET['date']) && $_GET['date'] != "") ? "{$_GET['date']}" : "" ?>" placeholder="dd/mm/yy" id="date" name="date" class="form-control mb datepicker" required>
                </div>
                <div class="col-md-3">
                    <label class="text-uppercase text-sm">Branch</label>
                    <select name="branchid" id="branchid" onchange="filter(0)" style="width: 100%;" class="form-control mb">
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
                <div class="col-md-3">
                    <label class="text-uppercase text-sm">Course</label>
                    <select name="courseid" id="courseid" onchange="filter(0)" style="width: 100%;" class="form-control mb">
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
                    <select name="sectionid" id="sectionid" onchange="filter(0)" style="width: 100%;" class="form-control mb">
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
                    <label class="text-uppercase text-sm">Status</label>
                            <select name="status" style="width: 100%;" class="form-control mb" onchange="filter(0)">
                                <option value="">Select</option>
                                <option value="1" <?php echo isset($_GET['status']) && $_GET['status'] == 1 ? "selected" : "" ?>>Present</option>
                                <option value="0" <?php echo isset($_GET['status']) && $_GET['status'] == 0 && $_GET['status'] != '' ? "selected" : "" ?>>Absent</option>
                            </select>
                        </div>
               <!-- <div class="col-md-3">
                    <label class="text-uppercase text-sm"> Class</label>
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
                </div-->
            </div>
        </form>
        <div class="row">
            <div class="col-md-12">
                <?php
                $date = isset($_GET['date']) && $_GET['date'] != "" ? $_GET['date'] : "";
               // $classid = isset($_GET['classid']) && $_GET['classid'] != "" ? $_GET['classid'] : "";
     
                if ($date != "") :
                ?>
                    <form method="post" id="add_attendance" action="<?php echo base_url('users/add_student_attendance') ?>">
                        <?php
                        $total = 0;
                        $present = 0;
                        $absent = 0;
                        ?>
                       
                        <table class="table table-striped DataTable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Attendance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                
                                foreach ($attendance_info as $result) :
                                     if (isset($_GET['status'])) {
                                        if(($_GET['status']==1 || $_GET['status']==0) && $_GET['status'] !="")
                                        {
                                        if ($result->status==$_GET['status'] ) {
                                        } else {
                                            continue;
                                        }
                                        }
                                     }
                                ?>
                                    <tr>
                                        <td><?php echo $result->name ?></td>
                                        <td>
                                            Present: <input type="radio" name="<?php echo $result->userid ?>_status[]" value="1" <?php echo $result->status == 1 ? "checked" : "" ?> style="margin-right: 20px; !important" />
                                            Absent: <input type="radio" name="<?php echo $result->userid ?>_status[]" value="0" <?php echo $result->status != 1 ? "checked" : "" ?> style="margin-right: 20px; !important" />
                                            <input type="hidden" name="userid[]" value="<?php echo $result->userid ?>" />

                                        </td>
                                    </tr>
                                <?php 
                               $total = $total+1;
                               if($result->status == 1)
                               {
                                   $present = $present+1;
                               }else
                               {
                                   $absent = $absent+1;
                               }
                                endforeach; ?>
                                <input type="hidden" name="classid" value="<?php echo $_GET['classid'] ?>" />
                                <input type="hidden" name="date" value="<?php echo $_GET['date'] ?>" />
                            </tbody>
                                    <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                                <div class="col-md-4">
                                    <div class="panel panel-default">
                                        <div class="panel-body bk-primary text-light">
                                            <div class="stat-panel text-center">
                                                
                                                <div class="stat-panel-number h1 "><b><?php echo $total;?></b></div>
                                                <div class="stat-panel-title text-uppercase">Total Students</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <div class="col-md-4">
                                    <div class="panel panel-default">
                                        <div class="panel-body bk-primary text-light">
                                            <div class="stat-panel text-center">
                                                
                                                <div class="stat-panel-number h1 "><b><?php echo $present;?></b></div>
                                                <div class="stat-panel-title text-uppercase">Present Students</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <div class="col-md-4">
                                    <div class="panel panel-default">
                                        <div class="panel-body bk-primary text-light">
                                            <div class="stat-panel text-center">
                                                
                                                <div class="stat-panel-number h1 "><b><?php echo $absent;?></b></div>
                                                <div class="stat-panel-title text-uppercase">Absent Students</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                </div>
                                </div>
                            
                               </span>
                        </table>
                        <button type="submit" class="btn btn-primary">Update</button>
                    <?php
                    
                endif;
                    ?>
                    </form>
            </div>
        </div>
    </div>
</div>

<script>
    function filter() {
        var classid = $('#classid').val();
        var teacherid = $('#date').val();

        var URL = "<?php echo base_url('users/student_attendance') ?>" + "?" + $('#filterForm').serialize();
        window.location.href = URL;
    }
</script>