<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Resonance Hyderabad</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <style>
    .container {
      max-width: 500px;
    }
    ul, li {
    margin: 0;
    padding: 0;
     list-style: circle !important;
}
  </style>
</head>
<body>
  <div class="container mt-5">
      <br>
      <br>
      <br>
      <div>
          <b>Name</b> :  <?php print_r($application[0]->name);?><br>
          <b>Father Name</b> :  <?php print_r($application[0]->fathername);?><br>
          <b>Application Number</b> :  <?php print_r($application[0]->application_ukey);?><br>
          
          <?php
         $date =  date("d-m-Y", strtotime($application[0]->dateofbirth)); 
          ?>
          <input type='hidden' value='<?php print_r($date);?>' id='dob'>
      </div>
      <br>
    <form method="post" action="<?php echo base_url('users/updatestudentprofileimage/'.$userid);?>" enctype="multipart/form-data" onsubmit="return validateForm()">
      <div class="form-group">
          
        <label>Profile Image</label>
        <input type="file" name="file" class="form-control" required>
        <input type="hidden" name="userid" value="<?php echo $userid;?>" class="form-control">
      </div>
       <div class="form-group">
        <label>Date Of Birth</label>
        <p id="demo" style="color:red"></p>
        <input type="text" name="dateofbirth" id="dateofbirth" class="form-control" placeholder='dd-mm-yyyy' required>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-danger">Upload</button>
      </div>
    </form>
     <h3>Sample Image</h3>
    <div style="text-align:center">
    <img src="<?php echo base_url()?>/uploads/Recognizable.png" alt="Recognizable.png" width="120" height="120"></div>
    <h3>Instructions To Upload Image</h3>
    <ul>
        <li>
            Format: JPG or PNG
        </li>
        <li>
            Maximum size: 2MB; Ideal size: at least 200 x 200 pixels
        </li>
        <li>
           Do not use blurry or unclear pictures 
        </li>
        <li>
           Do not use pictures with a busy background that detracts from you 
        </li>
        <li>
            Do not use pictures that contain other people
        </li>
        <li>
            Do not use pictures that have commercial logos or personal contact information
        </li>
    </ul>
  </div>
  <script>
      function validateForm() {
  let x =document.getElementById('dob').value;
    let y =document.getElementById('dateofbirth').value;
  if (x != y) {
    document.getElementById("demo").innerHTML = "Please Enter Correct Date Of Birth";
    return false;
  }
}
  </script>
</body>
</html>