<?php
if ($_SESSION['rights'] != null) : ?>
    <nav class="ts-sidebar">
        <ul class="ts-sidebar-menu">
            <?php if ($_SESSION['rights'][array_search('Dashboard', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <?php endif; ?>
            <?php if ($_SESSION['rights'][array_search('Users', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                <li data-toggle="collapse" data-target="#Users" class="collapsed active">
                    <a href="#"><i class="fa fa-users"></i>Users</a><i class="fa fa-angle-double-right" hidden></i>
                </li>
            <?php endif; ?>
            <ul class="sub-menu collapse" id="Users">
                <?php if ($_SESSION['rights'][array_search('Employee', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('users/onboardemployee') ?>"><i class="fa fa-users"></i>On Boarding Employee</a></li>
                <?php endif; ?>
                <?php if ($_SESSION['rights'][array_search('Employee', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('users/employee') ?>"><i class="fa fa-users"></i>Employee</a></li>
                <?php endif; ?>
                <?php if ($_SESSION['rights'][array_search('Student', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('users/student') ?>"><i class="fa fa-users"></i> Students</a></li>
                <?php endif; ?>
                <?php if ($_SESSION['rights'][array_search('Student', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('users/reservations') ?>"><i class="fa fa-users"></i> Reservations</a></li>
                <?php endif; ?>
                <?php if ($_SESSION['rights'][array_search('Student', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('users/resofast') ?>"><i class="fa fa-users"></i> Resofast Registrations</a></li>
                <?php endif; ?>
            </ul>
            <?php if ($_SESSION['rights'][array_search('Approval', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                <li data-toggle="collapse" data-target="#Approval" class="collapsed active">
                    <a href="#"><i class="fa fa-users"></i>Approvals</a><i class="fa fa-angle-double-right" hidden></i>
                </li>
            <?php endif; ?>
            <ul class="sub-menu collapse" id="Approval">
                <?php if ($_SESSION['rights'][array_search('UserApproval', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('users/approval') ?>"><i class="fa fa-users"></i> User Approvals</a></li>
                <?php endif; ?>
                <?php if ($_SESSION['rights'][array_search('UserApproval', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('users/reservationApproval') ?>"><i class="fa fa-users"></i> Reservation Approvals</a></li>
                <?php endif; ?>
                 <?php if ( $_SESSION['userdetails']->userid == 2244) : ?>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('payments/approval') ?>"><i class="fa fa-money"></i> Payment Approvals</a></li>
                <?php endif; ?>
                <?php if ($_SESSION['rights'][array_search('PaymentApproval', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('payments/approval') ?>"><i class="fa fa-money"></i> Payment Approvals</a></li>
                <?php endif; ?>
                <?php if ($_SESSION['rights'][array_search('PaymentApproval', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('payments/reservationPaymentapproval') ?>"><i class="fa fa-money"></i> Reservation Payment Approvals</a></li>
                <?php endif; ?>
                 <?php if($_SESSION['userdetails']->roleid == 1){ ?>
                <?php if ($_SESSION['rights'][array_search('PaymentApproval', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                    <li style="margin-left: 30px;" data-toggle="collapse" data-target="#FormApproval" class="collapsed active"><a href="#"><i class="fa fa-money"></i> Form Approvals</a><i class="fa fa-angle-double-right" hidden></i></li>
                <?php endif; ?>
               
                <ul class="sub-menu collapse" id="FormApproval">
                <?php if ($_SESSION['rights'][array_search('PaymentApproval', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                    <li style="margin-left: 60px;"><a href="<?php echo base_url('forms/formApprovals') ?>/?form=branchtransfer"><i class="fa fa-users"></i>Branch Tranfer Form</a></li>
                <?php endif; ?>
                <?php if ($_SESSION['rights'][array_search('PaymentApproval', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                    <li style="margin-left: 60px;"><a href="<?php echo base_url('forms/formApprovals') ?>/?form=discountApproval"><i class="fa fa-users"></i>Discount Approval</a></li>
                <?php endif; ?>
                <?php if ($_SESSION['rights'][array_search('PaymentApproval', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                    <li style="margin-left: 60px;"><a href="<?php echo base_url('forms/formApprovals') ?>/?form=refundApproval"><i class="fa fa-users"></i>Refund Approval</a></li>
                <?php endif; ?>
                </ul>
                <?php } ?>
                <?php 
                 if ($_SESSION['userdetails']->roleid == 3) : ?>
                 <li style="margin-left: 30px;"><a href="<?php echo base_url('forms/branchtransferformApprovals') ?>"><i class="fa fa-money"></i>Branch Transfer Approvals</a></li>
                 <?php endif; ?>
                 <?php
                if ($_SESSION['userdetails']->roleid == 1) : ?>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('forms/MaterialformApprovals') ?>"><i class="fa fa-money"></i>Material Form Approvals</a></li>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('forms/PoformApprovals') ?>"><i class="fa fa-money"></i>Po Form Approvals</a></li>
                    <?php endif; ?>
               <?php if ($_SESSION['rights'][array_search('StudentOutPass', array_column($_SESSION['rights'], 'operationname'))]->_edit == 1) : ?>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('forms/outPassformApprovals') ?>"><i class="fa fa-money"></i>Out Passes</a></li>
                <?php endif; ?>
                 <li style="margin-left: 30px;"><a href="<?php echo base_url('users/createbulkoutpass') ?>"><i class="fa fa-money"></i>Create Bulk Out Pass</a></li>
                <li style="margin-left: 30px;"><a href="<?php echo base_url('users/bulkoutpass') ?>"><i class="fa fa-money"></i>Bulk Out Pass Print</a></li>

            </ul>
            <?php if ($_SESSION['rights'][array_search('Finance', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                <li data-toggle="collapse" data-target="#Finance" class="collapsed active">
                    <a href="#"><i class="fa fa-users"></i>Finance</a><i class="fa fa-angle-double-right" hidden></i>
                </li>
            <?php endif; ?>
            <ul class="sub-menu collapse" id="Finance">
                <?php if ($_SESSION['rights'][array_search('Invoice', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('payments/invoice') ?>"><i class="fa fa-file-text"></i> Invoices</a></li>
                <?php endif; ?>
                <?php if ($_SESSION['rights'][array_search('Payment', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('payments/payment') ?>"><i class="fa fa-money"></i> Payments</a></li>
                <?php endif; ?>
                <?php if ($_SESSION['rights'][array_search('Payment', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('payments/getPaymentLinks') ?>"><i class="fa fa-money"></i> Payment Links</a></li>
                <?php endif; ?>
                <?php if ($_SESSION['rights'][array_search('Payment', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('payments/reservationpayment') ?>"><i class="fa fa-money"></i> Reservation Payments</a></li>
                <?php endif; ?>
                <?php if ($_SESSION['rights'][array_search('Generate_NOC', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('admin/StudentNoc') ?>"><i class="fa fa-arrow-circle-o-right"></i> NOC</a></li>
                <?php endif; ?>
            </ul>
            
             <?php if ($_SESSION['rights'][array_search('MaterialRequisition', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                <li data-toggle="collapse" data-target="#MaterialRequisition" class="collapsed active">
                    <a href="#"><i class="fa fa-th-list"></i>Material Requisition</a><i class="fa fa-angle-double-right" hidden></i>
                </li>
                <ul class="sub-menu collapse" id="MaterialRequisition">
                    <?php if ($_SESSION['rights'][array_search('Create MaterialRequisition', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                        <li style="margin-left: 30px;"><a href="<?php echo base_url('forms/materialrequisitionforms') ?>"><i class="fa fa-indent"></i>Material Requisitions</a></li>
                    <?php endif; ?>
                </ul>
            <?php endif; ?>

         
                <li data-toggle="collapse" data-target="#Attendance" class="collapsed active">
                    <a href="#"><i class="fa fa-calendar"></i>Attendance</a><i class="fa fa-angle-double-right" hidden></i>
                </li>
                <ul class="sub-menu collapse" id="Attendance">
                       <?php if ($_SESSION['rights'][array_search('Attendance', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('users/student_attendance') ?>"><i class="fa fa-calendar"></i> Student</a></li>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('users/employee_attendance') ?>"><i class="fa fa-calendar"></i> Employee</a></li>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('admin/regularizations') ?>"><i class="fa fa-calendar"></i> Regularizations</a></li>
                      <?php endif; ?>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('admin/leave_requests') ?>"><i class="fa fa-calendar"></i> Leave Requests</a></li>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('admin/leave_approved') ?>"><i class="fa fa-calendar"></i> Leave Approved</a></li>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('admin/leave_approved') ?>"><i class="fa fa-calendar"></i> Leave Rejected</a></li>
                </ul>
                
          
            
            <?php if ($_SESSION['userdetails']->userid == 1) : ?>
                <li data-toggle="collapse" data-target="#Admin" class="collapsed active">
                    <a href="#"><i class="fa fa-user-plus"></i>Admin</a><i class="fa fa-angle-double-right" hidden></i>
                </li>
                <ul class="sub-menu collapse" id="Admin">
                    <!-- <li style="margin-left: 30px;"><a href="<?php echo base_url('admin/class') ?>"><i class="fa fa-users"></i> Class</a></li> -->
                    <!-- <li style="margin-left: 30px;"><a href="<?php echo base_url('admin/enrol') ?>"><i class="fa fa-bullseye"></i> Enrol</a></li> -->
                    <!-- <li style="margin-left: 30px;"><a href="<?php echo base_url('admin/promote') ?>"><i class="fa fa-star"></i> Promote</a></li> -->
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('admin/paymentgateway') ?>"><i class="fa fa-star"></i>Payment Gateway List</a></li>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('bulkupload') ?>"><i class="fa fa-upload"></i> Bulk Upload</a></li>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('admin/roles') ?>"><i class="fa fa-arrow-circle-o-right"></i> Roles</a></li>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('admin/rights') ?>"><i class="fa fa-arrow-circle-o-right"></i> Rights</a></li>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('admin/concerns') ?>"><i class="fa fa-arrow-circle-o-right"></i>Parent Concerns</a></li>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('admin/announcements') ?>"><i class="fa fa-arrow-circle-o-right"></i>Announcements</a></li>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('admin/holidays') ?>"><i class="fa fa-arrow-circle-o-right"></i>Holidays</a></li>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('admin/business_calendar') ?>"><i class="fa fa-calendar"></i> Calendar</a></li>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('admin/reservationdiscount') ?>"><i class="fa fa-calendar"></i> Reservation Discount</a></li>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('admin/employee_fees_limits') ?>"><i class="fa fa-calendar"></i> Employee Fees Limits</a></li>
                </ul>
            <?php endif; ?>
            <!-- <?php if ($_SESSION['userdetails']->userid == 1) : ?>
                <li data-toggle="collapse" data-target="#Templates" class="collapsed active">
                    <a href="#"><i class="fa fa-plus"></i>Templates</a><i class="fa fa-angle-double-right" hidden></i>
                </li>
                <ul class="sub-menu collapse" id="Templates">
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('admin/sms') ?>"><i class="fa fa-leaf"></i> SMS Templates</a></li>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('admin/email') ?>"><i class="fa fa-leaf"></i> Email Templates</a></li>
                </ul>
            <?php endif; ?> -->
            <?php if ($_SESSION['userdetails']->userid == 1) : ?>
                <li data-toggle="collapse" data-target="#Master" class="collapsed active">
                    <a href="#"><i class="fa fa-gear"></i>Master</a><i class="fa fa-angle-double-right" hidden></i>
                </li>
                <ul class="sub-menu collapse" id="Master">
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('master/batch') ?>"><i class="fa fa-fighter-jet"></i> Batch</a></li>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('master/branch') ?>"><i class="fa fa-fighter-jet"></i> Branch</a></li>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('master/buildings') ?>"><i class="fa fa-fighter-jet"></i> Building</a></li>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('master/floors') ?>"><i class="fa fa-fighter-jet"></i> Floor</a></li>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('master/rooms') ?>"><i class="fa fa-fighter-jet"></i> Room</a></li>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('master/areas') ?>"><i class="fa fa-fighter-jet"></i> Area</a></li>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('master/warehouses') ?>"><i class="fa fa-fighter-jet"></i> Warehouse</a></li>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('master/course') ?>"><i class="fa fa-fighter-jet"></i> Course</a></li>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('master/section') ?>"><i class="fa fa-fighter-jet"></i> Section</a></li>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('master/subject') ?>"><i class="fa fa-fighter-jet"></i> Subject</a></li>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('admin/materialrequisitionlist') ?>"><i class="fa fa-fighter-jet"></i> Material Requisition</a></li>
                </ul>
            <?php endif; ?>

            <?php if ($_SESSION['userdetails']->userid == 1) : ?>
                <li data-toggle="collapse" data-target="#Payroll" class="collapsed active">
                    <a href="#"><i class="fa fa-credit-card"></i>Payroll</a><i class="fa fa-angle-double-right" hidden></i>
                </li>
                <ul class="sub-menu collapse" id="Payroll">
                     <li style="margin-left: 30px;"><a href="<?php echo base_url('payroll/salary_grade') ?>"><i class="fa fa-bar-chart"></i>Salary Grade</a></li> 
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('payroll/employee_package') ?>"><i class="fa fa-inr"></i>Employee Package</a></li>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('payroll/salary_payment') ?>"><i class="fa fa-inr"></i>Salary Payment</a></li>
                </ul>
            <?php endif; ?>

            <?php if ($_SESSION['rights'][array_search('WarehouseManager', array_column($_SESSION['rights'], 'operationname'))]->_view == 1 || $_SESSION['rights'][array_search('InventoryManager', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                <li data-toggle="collapse" data-target="#Inventory" class="collapsed active">
                    <a href="#"><i class="fa fa-th-list"></i>Inventory</a><i class="fa fa-angle-double-right" hidden></i>
                </li>
                <ul class="sub-menu collapse" id="Inventory">
                    <?php if ($_SESSION['rights'][array_search('WarehouseManager', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                        <li style="margin-left: 30px;"><a href="<?php echo base_url('Inventory/vendor') ?>"><i class="fa fa-align-justify"></i>Vendor</a></li>
                        <li style="margin-left: 30px;"><a href="<?php echo base_url('Inventory/manufacturers') ?>"><i class="fa fa-indent"></i>Manufacturers</a></li>
                        <li style="margin-left: 30px;"><a href="<?php echo base_url('Inventory/productcategory') ?>"><i class="fa fa-align-justify"></i>Product Category</a></li>
                        <li style="margin-left: 30px;"><a href="<?php echo base_url('Inventory/products') ?>"><i class="fa fa-indent"></i>Products</a></li>
                        <!--<li style="margin-left: 30px;"><a href="<?php echo base_url('Inventory/product_specifications') ?>"><i class="fa fa-indent"></i>Product Specification</a></li>-->
                        
                        <li style="margin-left: 30px;"><a href="<?php echo base_url('Inventory/materialrequisitionforms') ?>"><i class="fa fa-indent"></i>Approved MaterialRequisition</a></li>
                        <li style="margin-left: 30px;"><a href="<?php echo base_url('Forms/poforms') ?>"><i class="fa fa-indent"></i>Purchase Order List</a></li>
                        <li style="margin-left: 30px;"><a href="<?php echo base_url('Inventory/warehouse_details') ?>"><i class="fa fa-indent"></i>Warehouse Details</a></li>
                        <li style="margin-left: 30px;"><a href="<?php echo base_url('Inventory/warehouse_allocation_history') ?>"><i class="fa fa-indent"></i>Warehouse Allocation History</a></li>
                        <li style="margin-left: 30px;"><a href="<?php echo base_url('Inventory/purchase_invoices') ?>"><i class="fa fa-indent"></i>Purchase Invoice</a></li>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('Inventory/asset_allocation') ?>"><i class="fa fa-indent"></i>Asset Allocation</a></li>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('Inventory/asset_transfer') ?>"><i class="fa fa-indent"></i>Asset Transfer</a></li>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('Inventory/asset_transfer_history') ?>"><i class="fa fa-indent"></i>Asset Transfer History</a></li>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('Inventory/asset_report') ?>"><i class="fa fa-indent"></i>Asset Report</a></li>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('Inventory/asset_audit') ?>"><i class="fa fa-indent"></i>Asset Audit</a></li>
                    <?php endif; ?>
                     
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('Inventory/reports') ?>"><i class="fa fa-outdent"></i>Inventory Report</a></li>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('Inventory/details') ?>"><i class="fa fa-outdent"></i>Inventory Details</a></li>
                    <li style="margin-left: 30px;"><a href="<?php echo base_url('Inventory/studentdistribute') ?>"><i class="fa fa-outdent"></i>Distribute</a></li>
                </ul>
            <?php endif; ?>
            <?php if ($_SESSION['userdetails']->roleid == 14) : ?>
            <li><a href="<?php echo base_url('admin/counsollermapping') ?>"><i class="fa fa-file"></i>&nbsp;Counsoller Mapping</a></li>
             <?php endif; ?>
             
            <?php if ($_SESSION['rights'][array_search('Reports', array_column($_SESSION['rights'], 'operationname'))]->_view == 1 || $_SESSION['userdetails']->userid==12052) : ?>
                <li><a href="<?php echo base_url('reports') ?>"><i class="fa fa-file"></i>&nbsp;Reports</a></li>
            <?php endif; ?>
           
            <li><a href="<?php echo base_url('home/changepassword') ?>"><i class="fa fa-key"></i> &nbsp;Change Password</a></li>
            <li><a href="<?php echo base_url('home/logout') ?>"><i class="fa fa-sign-out"></i> &nbsp;Logout</a></li>
        </ul>
    </nav>
<?php
endif; ?>