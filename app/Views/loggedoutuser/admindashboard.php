<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Dashboard</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?php echo base_url('admindashboard/assets/vendors/mdi/css/materialdesignicons.min.css');?>" >
    <link rel="stylesheet" href="<?php echo base_url('admindashboard/assets/vendors/css/vendor.bundle.base.css');?>">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="<?php echo base_url('admindashboard/assets/css/style.css');?>">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="<?php echo base_url('images/logo.png');?>" />
     <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
     
     <style>
     
     body{
         width:100%;
         float:left;
         position:relative;
     }
         
         .main-panel {
              width: 100%;
    float: left;
    position: relative;
    background-color: #f2edf3;
    text-align: center;
}


.content-wrapper {
    display: flex;
    flex-direction: row;
    justify-content: space-around;
    flex-wrap: wrap;
}
     
     #donutchart{
         margin:20px 0px;
     }
         
         
         svg {
    width: 100%;
}

.text-uppercase {
    text-transform: uppercase !important;
    padding: 10px 0px;
}

select.form-control {
      padding: .4375rem .75rem;
    border: 0;
    outline: 1px solid #ebedf2;
    color: #000;
    padding: 15px 10px;
    border-radius: 5px;
}

.left_part {
    background-color: white;
  
    padding: 20px;
    height: 100%;
    position: fixed;
    /* width: 23%; */
    width: 17%;
    border-radius: 10px;
    box-shadow: -2px 2px 11px 8px #ddd;
    top: 100p;
    top: 100px;
}

.left_part p {
     margin: 0px;
    padding: 10px 0px;
    text-transform: capitalize;
    color: #000;
    font-size: 14px;
    border-bottom: 1px solid #dddddd40;
}

.header {
    background-color: #f2edf3;
    position: fixed;
    width: 100%;
    z-index: 999;
}

.header {
    text-align:center;
}

.header .row{
        display: flex;
    justify-content: center;
    align-items: center;
}

.below_header{
      position: relative;
    top: 102px;
    background-color: #f2edf3;
    
}

.dashboard_heading{
    position: relative;
    text-align: center;
    top: 99px;
    position: relative;
    position: fixed;
    width: 100%;
    padding: 25px;
    background-color: #fff;
    z-index: 99999;
  
}

rect {
    width: 100% !important;
}
#donutchart:hover {
    cursor: pointer;
    scale: 1.1;
}

         
     </style>
     
     
     
  </head>
  <body>
      
      
                
          <div class="header">
              
              <div class="row">
                    <div class="col-md-2">
               <a href="">  <img src="https://maidendropgroup.com/public/images/logo.png" style=" width: 100px;padding: 10px;"></a>
                     </div>
              <div class="col-md-10">
                     
                     <h1 > Branch Wise Attendance </h1>
                     
                     </div>
                     
                     </div>
          </div>
      
                

    <div class="container-scroller">
        <?php
            $Totalstudents = 0;
            $TotalPresentstudents = 0;
            $TotalAbsentstudents = 0;
            $studentDetails =  $studentDetails ;
            $arrData["data"] = array();
        ?>
     
      <!-- partial -->
      <div class="container-fluid page-body-wrapper below_header">
          

          
          <div class="row">
              
                 <div class="col-md-2">
                     <div class="left_part">
                         
                      <p>Attendance</p>
                         <p>Fee</p>
                     </div>
                     
                     
                     </div>
              
              <div class="col-md-10">
                  
                  
          
          
          
          
      
        <!-- partial -->
        <div class="main-panel">
            
            <form id="filterForm">
            <div class="row" style="
    display: flex;
    justify-content: center;
text-align: left;
    padding: 30px;

">
                
                <div class="col-md-3">
                    <label class="text-uppercase text-sm">Date</label>
                    <input type="date" onchange="filter(0)" placeholder="Date From" name="DateFrom" class="form-control mb" value="<?php echo (isset($_GET['DateFrom']) && $_GET['DateFrom'] != "") ? $_GET['DateFrom'] : "" ?>">
                </div>
                <div class="col-md-3">
                    <label class="text-uppercase text-sm">Branch</label>
                    <select name="branchid" id="branchid" onchange="filter(0)" style="width: 100%;" class="form-control mb">
                        <option value="" >Select</option>
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
                         <option  value="" >Select</option>
                                <?php
                                foreach ($lookups['courselookup'] as $course) :
                                ?>
                                    <option value="<?php echo $course->courseid; ?>" <?php echo isset($_GET['courseid']) && $_GET['courseid'] == $course->courseid ? "selected" : "" ?>><?php echo $course->coursename; ?></option>
                                <?php
                                endforeach;
                                ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="text-uppercase text-sm">Section</label>
                    <select name="sectionid" id="sectionid" onchange="filter(0)" style="width: 100%;" class="form-control mb">
                        <option  value="" >Select</option>
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
        </form>
      
          <div class="content-wrapper">
              <?php
              $i=1;
              foreach ($lookups['branchlookup'] as $branch) :
                  if(!empty($_GET['branchid'])) {
                  if(!empty($_GET['branchid']) && $_GET['branchid']==$branch->branchid){
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
           
 <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Status', 'Value'],
          ['Present (<?php echo $Presentstudents;?>)',     <?php echo $Presentstudents;?>],
          ['Absent (<?php echo $Absentstudents;?>)',      <?php echo $Absentstudents;?>]
        ]);

        var options = {
          title: '<?php echo $branch->branchname;?>\n (<?php echo 'Total Students : '.$students;?>)',
          pieHole: 0.4,
          slices: {
            0: { color: 'green' },
            1: { color: 'red' }
          }
          
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'+<?php echo $i ;?>));
        chart.draw(data, options);
      }
    </script>
    
    
    
     <div id="donutchart<?php echo $i;?>" style="width: 45%;float:left;position:relative;height: 300px;margin: 20px 0px;box-shadow: 2px 2px 5px 5px #ddd;text-align: center;align-items: center;display: flex;justify-content: center;border-radius: 10px;background-color: #fff;"></div>
     <?php $i++; } }else
     {
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
           
 <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Status', 'Value'],
          ['Present (<?php echo $Presentstudents;?>)',     <?php echo $Presentstudents;?>],
          ['Absent (<?php echo $Absentstudents;?>)',      <?php echo $Absentstudents;?>]
        ]);

        var options = {
          title: '<?php echo $branch->branchname;?>\n(<?php echo 'Total Students : '.$students;?>)',
          pieHole: 0.4,
          slices: {
            0: { color: 'green' },
            1: { color: 'red' }
          }
          
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'+<?php echo $i ;?>));
        chart.draw(data, options);
      }
    </script>
    
    
    
     <div id="donutchart<?php echo $i;?>" style="width: 45%;float:left;position:relative;height: 300px;margin: 20px 0px;box-shadow: 2px 2px 5px 5px #ddd;text-align: center;align-items: center;display: flex;justify-content: center;border-radius: 10px;background-color: #fff;">
        
         
     </div>
     <?php $i++;
     }endforeach; ?>
    <div id="columnchart_material" style="width: 100%; height: 500px;display:none"></div>

             <?php
                  $Totalstudents = 0;
                            $TotalPresentstudents = 0;
                            $TotalAbsentstudents = 0;

               $studentDetails =  $studentDetails ;
                                $arrData["data"] = array();
                                foreach ($lookups['branchlookup'] as $branch) :
                                
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
                                               
                                                 array_push($arrData["data"], array(
                "label" => $branch->branchname,
                "Total Student" => $students,
                "Total Present Student" => $Presentstudents,
                "Total Absent Student" => $Absentstudents) );
                                                endforeach;
                                               // print_r( $arrData["data"]);
                                               foreach($arrData["data"] as $arr){
                                                  // print_r($arr['label']);
                                               }
                                                ?>
                               <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Branchname', 'Total', 'Present', 'Absent'],
         <?php foreach($arrData["data"] as $arr){
             $label = $arr['label'];
             $students = $arr['Total Student'];
             $Presentstudents = $arr['Total Present Student'];
             $Absentstudents = $arr['Total Absent Student'];
             echo "['{$label}', {$students}, {$Presentstudents}, {$Absentstudents}],";
         }
         ?>
        ]);

        var options = {
          chart: {
            title: 'Attendance',
            subtitle: 'Branch Wise Attendance',
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>                 
          
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <footer class="footer">
            <div class="container-fluid d-flex justify-content-between">
              <span class="text-muted d-block text-center text-sm-start d-sm-inline-block">Copyright © maidendropgroup.com 2023</span>
              <span class="float-none float-sm-end mt-1 mt-sm-0 text-end"> Developed By <a href="https://techsters.in/" target="_blank">Techsters</a></span>
            </div>
          </footer>
          <!-- partial -->
        </div>
        
        
                
              </div>
          
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="<?php echo base_url('admindashboard/assets/vendors/js/vendor.bundle.base.js');?>"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="<?php echo base_url('admindashboard/assets/vendors/chart.js/Chart.min.js');?>"></script>
    <script src="<?php echo base_url('admindashboard/assets/js/jquery.cookie.js');?>" type="text/javascript"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="<?php echo base_url('admindashboard/assets/js/off-canvas.js');?>"></script>
    <script src="<?php echo base_url('admindashboard/assets/js/hoverable-collapse.js');?>"></script>
    <script src="<?php echo base_url('admindashboard/assets/js/misc.js');?>"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="<?php echo base_url('admindashboard/assets/js/dashboard.js');?>"></script>
    <script src="<?php echo base_url('admindashboard/assets/js/todolist.js');?>"></script>
    <script>
    function filter(download = 0) {
        var URL = "<?php echo base_url('home/admindashboard') ?>" + "?" + $('#filterForm').serialize();
        window.location.href = URL;
    }
</script>
    <!-- End custom js for this page -->
  </body>
</html>