<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Student Out Pass
                </h2>
                <div class="row">
                    <div class="col-md-12">
                      
                        <form action="<?php echo base_url('Forms/saveoutpass') ?>" method="POST">
                            <input type="hidden" name="user_id" value="<?php echo $_GET['userId'] ?>" />
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td><b>Name of the student</b></td>
                                        <td><?php echo $studentDetails[0]->name ?></td>
                                        <td><b>Application Number</b></td>
                                        <td><?php echo $studentDetails[0]->applicationnumber ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Branch</b></td>
                                        <td><?php echo $studentDetails[0]->branchname ?></td>
                                        <td><b>Course</b></td>
                                        <td><?php echo $studentDetails[0]->coursename ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Section</b></td>
                                        <td><?php echo $studentDetails[0]->sectionname ?></td>
                                        <td><b>Type of admission</b></td>
                                        <td><?php echo $studentDetails[0]->admissiontypename ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Date of Joining</b></td>
                                        <td><?php echo date_format(date_create($StudentDetails[0]->admissiondate), 'd/m/Y') ?></td>
                                         <td><b>Purpose</b></td>
                                        <td><input type='text' name="purpose" required /></td>
                                    </tr>
                                    <tr>
                                        <td><b>From date</b></td>
                                        <td>
                                       <input type="date" name="fromdate" class="" required />
                                        </td>
                                        <td><b>To Date</b></td>
                                        <td><input type="date" name="todate" class='' required /></td>
                                    </tr>
                                    
                                   
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-success">Print Form</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>