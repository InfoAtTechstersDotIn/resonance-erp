<!doctype html>
<html>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Resonance Checkout</title>
    <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://use.fontawesome.com/releases/v5.7.2/css/all.css' rel='stylesheet'>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');

        body {
            background: linear-gradient(to right, rgba(235, 224, 232, 1) 50%, #99cc33 50%, #99cc33 100%);
            font-family: 'Roboto', sans-serif
        }

        .card {
            border: none;
            max-width: 450px;
            border-radius: 15px;
            margin: 100px 0 150px;
            padding: 35px;
            padding-bottom: 20px !important
        }

        .heading {
            color: #C1C1C1;
            font-size: 14px;
            font-weight: 500
        }

        img {
            transform: translate(120px, -10px)
        }

        img:hover {
            cursor: pointer
        }

        .text-warning {
            font-size: 12px;
            font-weight: 500;
            color: #99cc33 !important
        }

        #cno {
            transform: translateY(-10px)
        }

        input {
            border-bottom: 1.5px solid #E8E5D2 !important;
            font-weight: bold;
            border-radius: 0;
            border: 0
        }

        .form-group input:focus {
            border: 0;
            outline: 0
        }

        .col-sm-5 {
            padding-left: 90px
        }

        .btn {
            background: #99cc33 !important;
            border: none;
            border-radius: 30px
        }

        .btn:focus {
            box-shadow: none
        }
    </style>
    <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <script type='text/javascript' src='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js'></script>
    <script type='text/javascript'></script>
</head>

<body oncontextmenu='return false' class='snippet-body'>
    <div class="container-fluid">
        <div class="row d-flex justify-content-center">
            <div class="col-sm-12">
                <div class="card mx-auto">
                    <p class="heading">Resonace - Payment Details</p>
                    <form class="card-details" action="<?php echo base_url('Razorpay/payAmount') ?>" method="POST">
                        <div class="form-group pt-2">
                            <div class="row d-flex">
                                <div class="col-sm-6">
                                    <p class="text-warning mb-0">Student Name</p> <input type="text" name="name" required>
                                </div>
                                <div class="col-sm-6 pt-0"> <img src="https://maidendropgroup.com/public/images/logo.png" width="64px" height="64px" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <p class="text-warning mb-0">Mobile Number</p> <input type="number" name="number" required>
                        </div>
                        <div class="form-group">
                            <p class="text-warning mb-0">Email Address</p> <input type="email" name="email" required>
                        </div>
                        <div class="form-group pt-2">
                            <div class="row d-flex">
                                <div class="col-sm-7">
                                    <p class="text-warning mb-0">Amount</p> <input type="number" min="1" name="amount" required>
                                </div>
                                <div class="col-sm-5 pt-0"> 
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-arrow-right px-3 py-2"></i></button> </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>