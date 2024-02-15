<style>
    li {
        list-style: circle !important;
    }
</style>
<div class="content-wrapper">
    <div class="container-fluid">
            <div class="col-md-12">
                <h2 class="page-title"><?php

                                        use App\Models\UsersModel;

                                        echo $_SESSION['userdetails']->name . " " ?> <span style="float:right;">Current ERP Version : <a target="_blank" href="<?php echo base_url('dashboard/version') ?>">20.05</a></span></h2>
                     <ul> <h3>Features of version 20.06</h3>
<li>Students Attendance Report based on Branch and section wise</li>
<li>Students Application numbers corrected in Spintly according to ERP </li>
<li>Employee code corrected in ERP according to Spintly</li>
<li>Students Reservation numbers changed to Application Numbers in Spintly according to ERP</li>
<li>Uploaded New employee in ERP </li>
<li>Added Reporting Persons to Employees and also added leave Balance summary</li>
<li>Leave Request and pending leaves to the reporting person In the Erp</li>
<li>Now Based on the Rights to the user they can view list of leaves applied by the employee</li>
<li>Reporting ca view Accepted and Rejected leaves</li>
<li>Bulk campus change of the students</li>
<li>Bulk section  change of the students</li>
<li>In the RESO ESS app employee can view list of Leves applied and remaining leaves</li>
<li>In the RESO ESS app now employee can enter reason for the previous day late login and early logout</li>
<li>Some of the payments posted in the Batch 2021-2022 of the 2022-2023 students moved to batch 2022-2023</li>
<li>Reservation students migrated to students while the academic year is 2021-2022 corrected from backend</li>

                       
                    </ul>
                    <ul> <h3>Features of version 20.05</h3>
<li>Spintly Attendance Data integrated into ERP(Employee and students) </li>
<li>Employee Attendance report </li>
<li>Student Attendance report </li>
<li>Changes in Mobile app(Reso ESS) and Now Employee can view remaining leaves </li>
<li>Leave balance summary </li>
<li>Integrated Login OTP while logging into Reso ESS</li>
<li>List of leaves applied by the employees</li>
<li>Employee attendance dashboard</li>
<li>Student attendance dashboard</li>

                       
                    </ul>
                    
                    <ul> <h3>Features of version 20.04</h3>
<li>Inventory slip related to reservation students and generate receipt for reservation students</li>
<li>Transfer Certificate of Students</li>
<li>Reservation payment delete option in cfo panel</li>
<li>Reservation payment edit option in cfo and administrator panel</li>
<li>Payments issuse related to new Razorpay account Fixed</li>
<li>Changed payments receipt and inventory receipt</li>
<li>Invoice receipt designed changed</li>
<li>Reference employee edit option in the super admin</li>
<li>If we are doing Student Migration then all Payment all old payments are showing with new date ….Now they showing old date of the reservation payment</li>
<li>After student migrate now we can search based on the application number and reservation number</li>
<li>In the inventory distribute we can search students based on the reservation number</li>
<li>While adding product in the inventory we can add them bulk and transfer to the branches according(with adding branch wise)</li>
<li>Generated dynamic application number for the reservation students and in the backend we have assigned application number who are already migrated as students</li>

                       
                    </ul>
                    
                     <ul> <h3>Features of version 20.03</h3>
<li>Now reservation students can migrate as students</li>
<li>Gave option to promote First year students to Second year </li>
<li>While migrating or promoting students from First year to Second year gave option to print ONBOARDING Form</li>
<li>Now we have two invoices one for Private and another for society</li>
<li>Changed the fee structure for new batch(2022-2023)</li>
<li>Changed all the reports according to the new fee structure</li>
                       
                    </ul>
                    </div>
                    </div>
                    </div>
                    
                    
                    