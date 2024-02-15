<!doctype html>
<html lang="en">
  <head>
    <title>Resonance Hyderabad</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
  </head>
  <body>
      <div class="container py-4">
          <br>
          <br>
          <br>
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 m-auto">
             
                 <h3 style='text-align:center;'>Success! Image uploaded.</h3>

                    <div class="card shadow" style='text-align:center;'>
                         <div class="form-group py-4">
                        <h5 class="py-2">Image Preview</h5>
                            <img src="<?php echo base_url($folder.'/'.$res[0]->profile_image)?>" class="img-fluid" height="200px"/>
                        </div>
                    </div>

              
                </div>
            </div>
        </div>
      </div>
  </body>
</html>