<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Student Attendance Report
                </h2>
            </div>
        </div>
        <form id="filterForm">
            <div class="row">
               
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
            </div>
            <div class="row">
                <div class="col-md-3">
                    <label class="text-uppercase text-sm">Attendance Date From</label>
                    <input type="text" onchange="filter(0)" placeholder="Attendance Date From" name="DateFrom" class="datepicker form-control mb" value="<?php echo (isset($_GET['DateFrom']) && $_GET['DateFrom'] != "") ? $_GET['DateFrom'] : "" ?>">
                </div>
                <div class="col-md-3">
                    <label class="text-uppercase text-sm">Attendance Date To</label>
                    <input type="text" onchange="filter(0)" placeholder="Attendance Date To" name="DateTo" class="datepicker form-control mb" value="<?php echo (isset($_GET['DateTo']) && $_GET['DateTo'] != "") ? $_GET['DateTo'] : "" ?>">
                </div>
            </div>
        </form>
        <a class="btn btn-primary" onclick="filter(1)">Download</a>
        <?php
        if($_SESSION['userdetails']->roleid==1)
            {
                ?>
        <a class="btn btn-primary" href="" target="_blank" onclick="filter(2)">Send Absent Message</a>
        <?php } ?>
        <br />
        <br />
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
                         <style>
                            table,
                            th,
                            td {
                                border: 1px solid black;
                                border-collapse: collapse;
                            }
                        </style>
                         <h1>Branch wise report</h1>
                        <table class="table table-striped">
                            <?php
                            $Totalstudents = 0;
                            $TotalPresentstudents = 0;
                            $TotalAbsentstudents = 0;

                            ?>
                            <thead>
                                <tr>
                                    <th rowspan="2">Branch</th>
                                     <th rowspan="2">Total students</th>
                                      <th rowspan="2">Present students</th>
                                       <th rowspan="2">Absent students</th>
                                </tr>
                               
                            </thead>
                            <?php
                            ?>
                            <tbody>
                                <?php
                               
                                foreach ($lookups['branchlookup'] as $branch) :
                                ?>
                                    <tr>
                                        <td>
                                            <b><?php echo $branch->branchname ?></b>
                                        </td>
                                        
                                                <?php 
                                                 $students = 0;
                                                $Presentstudents = 0;
                                                $Absentstudents = 0;
                                                foreach ($studentDetails as $result1) {
                                                    $Totalstudents++;
                                                    if ($result1->branchid == $branch->branchid) {
                                                        $students++;
                                                        if($result1->status == 1)
                                                        {
                                                            $Presentstudents++;
                                                            $TotalPresentstudents++;
                                                        }else
                                                        {
                                                            $Absentstudents++;
                                                            $TotalAbsentstudents++;
                                                        }
                                                    }
                                                }
                                                ?>
                                                <td>
                                                    <?php echo  $students;?>
                                                </td>
                                                <td>
                                                     <?php echo  $Presentstudents;?>
                                                </td>
                                                <td>
                                                     <?php echo  $Absentstudents;?>
                                                </td>
                                        
                                        </tr>
                                        <?php endforeach;
                                            ?>
                                            <tr>
                                                <td>
                                            <b>Total</b>
                                        </td>
                                                 <td>
                                                    <?php echo  count($studentDetails);?>
                                                </td>
                                                <td>
                                                     <?php echo  $TotalPresentstudents;?>
                                                </td>
                                                <td>
                                                     <?php echo  $TotalAbsentstudents;?>
                                                </td>
                                            </tr>
                                        </tbody>
                                        </table>
                                        
                                        <h1>Section wise report</h1>
                                          <table class="table table-striped">
                            <?php
                            $Totalstudents1 = 0;
                            $TotalPresentstudents1 = 0;
                            $TotalAbsentstudents1 = 0;

                            ?>
                            <thead>
                                <tr>
                                    <th rowspan="2">Section</th>
                                     <th rowspan="2">Total students</th>
                                      <th rowspan="2">Present students</th>
                                       <th rowspan="2">Absent students</th>
                                </tr>
                               
                            </thead>
                            <?php
                            ?>
                            <tbody>
                                <?php
                               
                                foreach ($lookups['sectionlookup'] as $section) :
                                ?>
                                    <tr>
                                        <td>
                                            <b><?php echo $section->sectionname ?></b>
                                        </td>
                                        
                                                <?php 
                                                 $students1 = 0;
                                                $Presentstudents1 = 0;
                                                $Absentstudents1 = 0;
                                                foreach ($studentDetails as $result2) {
                                                    $Totalstudents1++;
                                                    if ($result2->sectionid == $section->sectionid) {
                                                        $students1++;
                                                        if($result2->status == 1)
                                                        {
                                                            $Presentstudents1++;
                                                            $TotalPresentstudents1++;
                                                        }else
                                                        {
                                                            $Absentstudents1++;
                                                            $TotalAbsentstudents1++;
                                                        }
                                                    }
                                                }
                                                ?>
                                                <td>
                                                    <?php echo  $students1;?>
                                                </td>
                                                <td>
                                                     <?php echo  $Presentstudents1;?>
                                                </td>
                                                <td>
                                                     <?php echo  $Absentstudents1;?>
                                                </td>
                                        
                                        </tr>
                                        <?php endforeach;
                                            ?>
                                            <tr>
                                                <td>
                                            <b>Total</b>
                                        </td>
                                                 <td>
                                                    <?php echo  count($studentDetails);?>
                                                </td>
                                                <td>
                                                     <?php echo  $TotalPresentstudents1;?>
                                                </td>
                                                <td>
                                                     <?php echo  $TotalAbsentstudents1;?>
                                                </td>
                                            </tr>
                                        </tbody>
                                        </table>
                                        
                        <table class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>Student Details</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($studentDetails != null) :
                                    foreach ($studentDetails as $result) :
                                ?>
                                        <tr>
                                            
                                            <td>
                                                <b>Student Name:</b> <?php echo $result->name ?><br />
                                                <b>Father Name:</b> <?php echo $result->fathername ?><br />
                                                <b>Application Number:</b> <?php echo $result->applicationnumber ?><br />
                                                <b>Section:</b> <?php echo $result->sectionname ?><br />
                                                <b>Course Name:</b> <?php echo $result->coursename ?><br />
                                                <b>Campus:</b> <?php echo $result->branchname ?><br />
                                            </td>
                                            <td>
                                                <b><?php 
                                                if($result->status ==1)
                                                {
                                                echo "Present";
                                                echo "<br>";
                                                echo "Login Time : $result->login_time";
                                                echo "<br>";
                                                if($result->is_latelogin ==1)
                                                {
                                                     echo "Late Login : 1";
                                                }
                                                }else
                                                {
                                                    echo "Absent";
                                                }?></b><br />
                                               <br />
                                            </td>
                                        </tr>
                                <?php endforeach;
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
        var URL = "<?php echo base_url('reports/report_studentattendance') ?>" + "?" + $('#filterForm').serialize();

        if (download == 1) {
            URL = URL + "&download=1";
        }
        if (download == 2) {
            URL = URL + "&message=1";
        }

        window.location.href = URL;
    }
</script>