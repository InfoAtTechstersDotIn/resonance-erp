
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Purchase Orders
                    <a class="btn btn-success" style="float: right;" href='../Inventory/createpurchaseorder'>Add Purchase Order</a>
                </h2>
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblpaymentApproval" class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Status</th>
                                    <th>Created Date</th>
                                    <th>Updated By</th>
                                    <th>Print</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($forms as $result) :
                                ?>
                                    <tr>
                                        <td>
                                            <a href="poforms/<?php echo $result->id ?>"><?php echo $result->id ?></a>
                                        </td>
                                        <td><?php echo $result->purchase_order_status ?></td>
                                        <td><?php echo date_format(date_create($result->created_time), 'd/m/Y') ?></td>
                                        <td><?php echo $result->UpdatedBy ?></td>
                                        <td><?php
                                            if ($result->purchase_order_status != "created") {
                                           
                                                $db = db_connect();
                                                $query = $db->query("SELECT Fr.*,p.name as productname,mri.quantity, Cr.name AS CreatedBy, Up.Name as UpdatedBy FROM purchase_order Fr
                                                JOIN purchase_order_items mri on Fr.id = mri.purchase_order_id
                                                JOIN product p on mri.product_id = p.id
                                                JOIN employeedetails Cr on Fr.created_by = Cr.userid
                                                LEFT JOIN employeedetails Up on Fr.updated_by = Up.userid
                                                                    WHERE Fr.id='{$result->id}'");
                                                $results = $query->getResult();
                                                $db->close();
                                               
                                           ?>
                                                <a class="btn btn-success" onclick="printDiv('div_<?php echo $result->id; ?>')">Print</a>

                                                <div class="col-md-12" id="div_<?php echo $result->id; ?>" style="display:none;">
                                                        <p style="text-align: center; display:none;"><img src="<?php echo base_url('images/logo1.png') ?>" width="140" height="50" /></p>
                                                    <div class="scale" style="display:non;">
                                                        <br />
                                                        <p style="text-align: right;">Date: <?php echo date("d-m-Y"); ?><br />Hyderabad</p>
                                                        <h4 style="text-align: center;"><strong><u>Purchase Order Form</u></strong></h4>
                                                        <br />

                                                        <br />
                                                        Status: <?php
                                                                echo $result->purchase_order_status . " (" . $result->UpdatedBy . ")";
                                                                ?>
                                                        <br />
                                                        <table style="width: 100%;margin: 0;" >

                                                            <tr>
                                                                <td><span style="width: 20%;"><b>ProductName</b></span></td>
                                                                <td><span style="width: 20%;"><b>Quantity</b></td>
                                                            </tr>
                                                            <br />
                                                            <?php
                                                            foreach ($results as $item) {
                                                            ?>
                                                                <tr>
                                                                    <td><span style="width: 20%;"><?php
                                                                                                   
                                                                                                            echo $item->productname;
                                                                                                
                                                                                                    ?></span></td>
                                                                    <td><span style="width: 20%;"> <?php
                                                                                                
                                                                                                            echo $item->quantity;
                                                                                                    
                                                                                                    ?></span></td>
                                                                </tr>
                                                            <?php
                                                            }
                                                            ?>
                                                        </table>

                                                        <p style="margin-top:100px;">Clerk-in-Charge
                                                            <span style="float:right">PRINCIPAL</span>
                                                        </p>
                                                    </div>
                                                    
                                                    <div class="scale_bottom">
                                                        
                                                        
                                                                                                        
                                                
    <div class="container polist" style="display:none">

        <div class="row gstin_num">
            <div class="col-md-6">
                <p><b> GSTIN : </b></p>
                <p>4567890-6789</p>
            </div>
        </div>


        <div class="row main_heading">
            
                  <p style="text-align: center;"><img src="<?php echo base_url('images/logo1.png') ?>" width="120" height="40" /></p>
               <h1 class="heading" style="font-size: 24px;font-weight: 700;"> MAIDENDROP GROUPS</h1>

            <p class="heading"> Lorem ipsum dolor sit amet consectetur, adipisicing elit. Repudiandae commodi quasi iusto a incidunt et facere repellendus harum est qui.</p>



            <p><a href="#">Tel: 9948502054</a> <a href="#">Email: Test@gmail.com</a></p>
        </div>

        <div class="row table_one">

            <div class="col-6 brder_right">

                <h3>Property Details</h3>


                <p>MAidendrop Edu Foundation Ist floor flat no 104 Lorem ipsum dolor sit amet consectetur, adipisicing elit. Hic, quod?
                </p>
                <table style="margin-bottom:20px;">

                    <tr>
                        <td><b> Party Pan :</b> </td>
                        <td>AAncM120cc</td>
                    </tr>
                    <tr>
                        <td><b> Party Mobile no :</b> </td>
                        <td>9948502054</td>
                    </tr>
                    <tr>
                        <td><b> Party State :</b> </td>
                        <td>Telangana</td>
                    </tr>
                    <tr>
                        <td><b> GSTIN / UIN</b> </td>
                        <td>36AANCM1210C1Z0</td>
                    </tr>

                </table>

            </div>

            <div class="col-6"> 
            
            <br>
                <table>

                    <tr>
                        <td><b> Invoice Number : </b> </td>
                        <td>AAncM120cc</td>
                    </tr>
                    <tr>
                        <td><b>  Dated : </b> </td>
                        <td>9948502054</td>
                    </tr>
                    <tr>
                        <td><b> Place of Supply : </b> </td>
                        <td>Telangana</td>
                    </tr>
                    <tr>
                        <td><b>  Reverse Charge : </b> </td>
                        <td>36AANCM1210C1Z0</td>
                    </tr>

                    <tr>
                        <td><b> GR/RR No : </b> </td>
                        <td></td>
                    </tr>

                    <tr>
                        <td><b> Transport : </b> </td>
                        <td>36AANCM1210C1Z0</td>
                    </tr>


                    <tr>
                        <td><b>  Vehicle No : </b> </td>
                        <td></td>
                    </tr>

                    <tr>
                        <td><b>  Station : </b> </td>
                        <td></td>
                    </tr>
                </table>

            </div>


        </div>



        <div class="row table_two">


            <table>

                <tr>
                    <th>S.no</th>

                    <th>Description of Goods</th>

                    <th>
                        HSN
                    </th>

                    <th>
                        GST%
                    </th>

                    <th>QTY</th>

                    <th>UNIT</th>

                    <th>MRP</th>


                    <th>RATE</th>


                    <th>DISC%</th>

                    <Th>BFT</Th>

                    <th>AMOUNT</th>
                </tr>


                <tr>
                    <td>01</td>

                    <td>KAPIL Jitesh pad n-5 thin R+P</td>

                    <td>4802</td>

                    <td>12%</td>

                    <td>260.00</td>

                    <td>Pcs</td>

                    <td>0.00</td>

                    <td>15.00</td>

                    <td>0.000 %</td>

                    <td>3,482.12</td>


                    <td>3,900.00</td>
                </tr>

                <tr>
                    <td>02</td>

                    <td>KAPIL Jitesh pad n-5 thin R+P</td>

                    <td>4802</td>

                    <td>12%</td>

                    <td>260.00</td>

                    <td>Pcs</td>

                    <td>0.00</td>

                    <td>15.00</td>

                    <td>0.000 %</td>

                    <td>3,482.12</td>


                    <td>3,900.00</td>
                </tr>
                <tr>
                    <td>03</td>

                    <td>KAPIL Jitesh pad n-5 thin R+P</td>

                    <td>4802</td>

                    <td>12%</td>

                    <td>260.00</td>

                    <td>Pcs</td>

                    <td>0.00</td>

                    <td>15.00</td>

                    <td>0.000 %</td>

                    <td>3,482.12</td>


                    <td>3,900.00</td>
                </tr>

                <tr>
                    <td>04</td>

                    <td>KAPIL Jitesh pad n-5 thin R+P</td>

                    <td>4802</td>

                    <td>12%</td>

                    <td>260.00</td>

                    <td>Pcs</td>

                    <td>0.00</td>

                    <td>15.00</td>

                    <td>0.000 %</td>

                    <td>3,482.12</td>


                    <td>3,900.00</td>
                </tr>
                <tr>
                    <td>05</td>

                    <td>KAPIL Jitesh pad n-5 thin R+P</td>

                    <td>4802</td>

                    <td>12%</td>

                    <td>260.00</td>

                    <td>Pcs</td>

                    <td>0.00</td>

                    <td>15.00</td>

                    <td>0.000 %</td>

                    <td>3,482.12</td>


                    <td>3,900.00</td>
                </tr>




            </table>

            <div class="row">

                <div class="col-12">
                    <table>
                        <tr>
                            <th id="total" colspan="6">Total </th>
                            <th>100000000</th>

                        </tr>
                    </table>

                </div>

                
                <div class="col-8" style="padding:0px 20px !important;   margin: -5px;">
                    <table style="padding:0px 30px !important;">

                        <tr>
                            <th>Tax rate</th>
                            <th>Taxable Amt</th>

                            <th> CGST AMT</th>
                            <th> SGST AMT</th>
                            <th> Total Tax</th>



                        </tr>

                        <tr>
                            <td>12%</td>

                            <td>3,482.14</td>

                            <td>208.93</td>

                            <td>208.93</td>

                            <td>417.86</td>
                        </tr>


                        <tr>
                            <td>18%</td>

                            <td>3,482.14</td>

                            <td>208.93</td>

                            <td>208.93</td>

                            <td>1562.86</td>
                        </tr>

                        <tr>
                            <th>Totals</th>

                            <th>12,164.34</th>

                            <th>990.33</th>

                            <th>990.33</th>

                            <th>1980.66</th>
                        </tr>

                        <br>


                    </table>
    <p style="text-transform: capitalize;font-weight: bold;padding: 0px 15px;">Rupees Fourty thousand One Hundred fourtfive Only</p>




                </div>


                <div class="col-md-12">

                    <table>

                        <tr>
                            <th>Bank Details</th>
                            <td>SBI</td>

                            <th>Branch</th>
                            <td>Madhapur</td>
                        </tr>



                        <tr>
                            <th>AC NO</th>
                            <td>121343545454</td>

                            <th>IFSC CODE</th>

                            <td>SBIN0032241</td>
                        </tr>




                    </table>
                </div>
            </div>



        </div>


        <div class="row footer">

            <div class="col-7 brder_right">

                <h3>Terms & Conditions</h3>

                <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
                <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
                <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
                <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
                <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>

            </div>

            <div class="col-5" style="padding:10px 30px;">
                <p  style="padding-left:90px !important;"><b style="padding-left:30px;"> Receivers Signature : </b></p>

            </div>
            
            
            <div class="col-12" style="padding-top:30px !important; border-top:1px solid ;">
                  <p style="float:right; display: flex;width: 100%;align-items: end;justify-content: end; margint-top:2rem;"><b> Authorised Signatory </b></p>
            </div>
            

        </div>



    </div>


                                                    </div>
                                                       

                                                </div>
                                                


                                                
                                                

                                            <?php
                                            } ?>
                                        </td>
                                       
                                        <?php
                                        if($result->purchase_order_status == "created")
                                        {
                                            ?>
                                            <td><i onclick="remove('<?php echo $result->id ?>')" class='fa fa-trash'></i></td>
                                            <?php
                                        } ?>
                                        
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
<script>
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }

    function remove(productcategoryid) {
        if(confirm('Are you sure?'))
        {
            window.location.href = "<?php echo base_url('Forms/deletepoforms?id=') ?>" + productcategoryid;
        }
    }
</script>