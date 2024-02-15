<html>

<body>
    <div class="ts-main-content">
        <div class="content-wrapper">
            <div class="container-fluid">
                <h1 style="text-align: center; background-color: #99cc33; color: white;"><strong>Inventory Receipt</strong></h1>
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
                                <p><img src="<?php echo base_url('images/logo.png') ?>" alt="" width="110" height="110" /></p>
                            </td>
                            <td style="width: 70%; text-align: right; vertical-align:bottom">
                                <table style="width: 100%; margin-left: auto; margin-right: auto;">
                                    <tbody>
                                        <tr>
                                            <td style="background-color: #99cc33; border: 1px solid #99cc33;"><b>Branch</b></td>
                                            <td style="border: 1px solid #99cc33;"><i><?php echo $userDetails->branchname ;?></i></td>
                                            <td style="background-color: #99cc33; border: 1px solid #99cc33;"><b>Application No</b></td>
                                            <td style="border: 1px solid #99cc33;"><i><?php echo $userDetails->reservation_ukey ?></i></td>
                                        </tr>
                                        <tr>
                                            <td style="background-color: #99cc33; border: 1px solid #99cc33;"><b>Name</b></td>
                                            <td style="border: 1px solid #99cc33;"><i><?php echo $userDetails->name ?></i></td>
                                            <td style="background-color: #99cc33; border: 1px solid #99cc33;"><b>Admission Type</b></td>
                                            <td style="border: 1px solid #99cc33;"><i><?php echo $userDetails->admissiontypename ?></i></td>
                                        </tr>
                                        <tr>
                                            <td style="background-color: #99cc33; border: 1px solid #99cc33;"><b>Course</b></td>
                                            <td style="border: 1px solid #99cc33;"><i><?php echo $userDetails->coursename ?></i></td>
                                            <td style="background-color: #99cc33; border: 1px solid #99cc33;"><b>Section</b></td>
                                            <td style="border: 1px solid #99cc33;"><i><?php echo $userDetails->sectionname ?></i></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 30%;">
                            </td>
                            <td style="width: 70%;">
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 30%;">
                            </td>
                            <td style="width: 70%; text-align: right; vertical-align:bottom">
                                <table style="width: 100%; margin-left: auto; margin-right: auto;">
                                    <tbody>
                                        <tr>
                                            <td style="background-color: #99cc33; border: 1px solid #99cc33;"><b>Date</b></td>
                                            <td style="border: 1px solid #99cc33;"><i><?php echo date('Y-m-d') ?></i></td>
                                        </tr>
                                        <tr>
                                            <td style="background-color: #99cc33; border: 1px solid #99cc33;"><b>Given By</b></td>
                                            <td style="border: 1px solid #99cc33;"><i><?php echo $employeeDetails[0]->name ?></i></td>
                                        </tr>
                                        <tr>
                                            <td style="background-color: #99cc33; border: 1px solid #99cc33;"><b>Product</b></td>
                                            <td style="border: 1px solid #99cc33;"><i><?php echo $inventoryDetails->productname ?></i></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 30%;">
                            </td>
                            <td style="width: 70%; text-align: right; vertical-align:bottom">
                                <table style="width: 100%; margin-left: auto; margin-right: auto;">
                                    <tbody>
                                        <tr>
                                            <td colspan="2">
                                                <br />
                                                <br />
                                                <br />
                                                <br />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Employee Signature</b></td>
                                            <td><b>Student Signature</b></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div style="text-align:center;margin-top:50px;border-bottom:1px solid #99cc33;"></div>
                <p style="text-align:center;"><strong>MAIDENDROP EDU FOUNDATION</strong>, Corporate office, Plot No. 26, 100ft road, main road, Madhapur, Hyderabad- 500081,Phone: 9121219858</p>
            </div>
        </div>

    </div>
</body>

</html>