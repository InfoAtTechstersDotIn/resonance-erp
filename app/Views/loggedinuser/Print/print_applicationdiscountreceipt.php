<html><body>
    <div class="ts-main-content">
        <div class="content-wrapper">
            <div class="container-fluid">
                <h1 style="text-align: center; background-color: #99cc33; color: white;"><strong>Discount Acknowledgment</strong></h1>
                               <br>
                <table style="width: 75%; margin-left: auto; margin-right: auto;">
                    <tbody>
                        <tr>
                            <td style="width: 30%;">
                               
                            </td>
                            <td style="width: 70%;">
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 30%;">
                                 <p><img src="<?php echo base_url('images/logo1.png') ?>" alt="" width="190" height="90" /></p>
                            </td>
                            <td style="width: 70%; text-align: right; vertical-align:bottom">
                                <?php 
                                $discountedby = '';
                                foreach ($EmployeeDetails as $reference) :
                                        if($userDetails->discountapproved_by == $reference->userid)
                                        {
                                            $discountedby = $reference->name;
                                        }
                                        endforeach;
                                        ?>
                                
                                <table style="width: 100%; margin-left: auto; margin-right: auto;">
                                    <tbody>
                                        <tr>
                                            <td style="background-color: #99cc33; border: 1px solid #99cc33;"><b>Application No</b></td>
                                            <td style="border: 1px solid #99cc33;"><i><?php echo $userDetails->application_ukey ?></i></td>
                                        </tr>
                                        <tr>
                                            <td style="background-color: #99cc33; border: 1px solid #99cc33;"><b>Name</b></td>
                                            <td style="border: 1px solid #99cc33;"><i><?php echo $userDetails->name ?></i></td>
                                        </tr>
                                        <tr>
                                            <td style="background-color: #99cc33; border: 1px solid #99cc33;"><b>Branch</b></td>
                                            <td style="border: 1px solid #99cc33;"><i><?php echo $userDetails->branchname ?></i></td>
                                        </tr>
                                        <tr>
                                            <td style="background-color: #99cc33; border: 1px solid #99cc33;"><b>Admission Type</b></td>
                                            <td style="border: 1px solid #99cc33;"><i><?php echo $userDetails->admissiontypename ?></i></td>
                                        </tr>
                                        <tr>
                                            <td style="background-color: #99cc33; border: 1px solid #99cc33;"><b>Course</b></td>
                                            <td style="border: 1px solid #99cc33;"><i><?php echo $userDetails->coursename ?></i></td>
                                        </tr>
                                         <tr>
                                            <td style="background-color: #99cc33; border: 1px solid #99cc33;"><b>Approved Discount</b></td>
                                            <td style="border: 1px solid #99cc33;"><i><?php echo $userDetails->discountgiven ?></i></td>
                                        </tr>
                                        <?php if($userDetails->additionaldiscountgiven != null || $userDetails->additionaldiscountgiven !='')
                                        {
                                            ?>
                                            <tr>
                                            <td style="background-color: #99cc33; border: 1px solid #99cc33;"><b>Approved Discount</b></td>
                                            <td style="border: 1px solid #99cc33;"><i><?php echo $userDetails->additionaldiscountgiven  ?>.00</i></td>
                                        </tr>
                                            <?php
                                        }
                                        ?>
                                         
                                        <tr>
                                            <td style="background-color: #99cc33; border: 1px solid #99cc33;"><b>Approved Date</b></td>
                                            <td style="border: 1px solid #99cc33;"><i><?php echo date('Y-m-d');?></i></td>
                                        </tr>
                                        <tr>
                                            <td style="background-color: #99cc33; border: 1px solid #99cc33;"><b>Discount Approved By</b></td>
                                            <td style="border: 1px solid #99cc33;"><i><?php echo $discountedby;?></i></td>
                                        </tr>
                                        
                                        
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p>&nbsp;</p>
                
                <div style="text-align:center;margin-top:50px;border-bottom:1px solid #99cc33;">This is computer generated receipt, signature and stamp is not required.</div>
                 <?php
                if($payment->invoice==1){
                    ?>
                <p style="text-align:center;"><strong>MAIDENDROP EDU FOUNDATION</strong>, GSTIN: 36AANCM1210C1Z0, Corporate office, 1ST FLOOR FLAT NO 104, H NO. 6-3-348/10/104, NIRMAL
TOWERS, DWARAKAPURI CLY, PUNJAGUTTA, Hyderabad,
Telangana, 500082</p>
           <?php }elseif($payment->invoice==2)
           {
            ?>               
            <p style="text-align:center;"><strong>MAIDENDROP EDU FOUNDATION</strong>, Registration Number 75 OF 2020, 1ST FLOOR FLAT NO 104, H NO. 6-3-348/10/104, NIRMAL
TOWERS, DWARAKAPURI CLY, PUNJAGUTTA, Hyderabad,
Telangana, 500082</p>
               <?php
           }else
           {
               ?>
               <p style="text-align:center;"><strong>MAIDENDROP EDU FOUNDATION</strong>, Corporate office, Plot No. 26, 100ft road, main road, Madhapur, Hyderabad- 500081,Phone: 9121219858</p>
               <?php
           
           
           }?>
            </div>
        </div>
        
    </div>
</body></html>