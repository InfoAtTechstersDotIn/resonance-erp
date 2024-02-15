<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Salary Grade
                    <a class="btn btn-success" style="float: right;" data-toggle="modal" data-target="#addsalarygrade">Add Salary Grade</a>
                </h2>
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblotherusers" class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Basic Pay</th>
                                    <th>House Rental Allowance</th>
                                    <th>Travel Allowance</th>
                                    <th>Medical Allowance</th>
                                    <th>Provident Fund</th>
                                    <th>Leaves</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="addsalarygrade" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document" style="width: 60vw">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title">Add Salary Grade</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?php echo base_url('payroll/add_salary_grades') ?>">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="text-uppercase text-sm">Name</label>
                                        <input type="text" placeholder="Name" name="salarygradename" class="form-control mb" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="text-uppercase text-sm">Basic Pay</label>
                                        <input type="number" placeholder="Basic Pay" name="basic" class="form-control mb" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="text-uppercase text-sm">House Rental Allowance</label>
                                        <input type="number" placeholder="HRA" name="hra" class="form-control mb" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="text-uppercase text-sm">Travel Allowance</label>
                                        <input type="number" placeholder="TA" name="ta" class="form-control mb" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="text-uppercase text-sm">Medical Allowance</label>
                                        <input type="number" placeholder="MA" name="ma" class="form-control mb" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="text-uppercase text-sm">Provident Fund</label>
                                        <input type="number" placeholder="PF" name="pf" class="form-control mb" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="text-uppercase text-sm">Total Leaves(Yearly)</label>
                                        <input type="number" placeholder="Total Leaves(Yearly)" name="leaves" class="form-control mb" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Add Salary Grade</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="editsalarygrade" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title">Edit Salary Grade</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?php echo base_url('payroll/update_salary_grade') ?>">
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="text-uppercase text-sm">Name</label>
                                        <input type="text" placeholder="Name" name="salarygradename" id="salarygradename" class="form-control mb" required>
                                        <input type="hidden" name="salarygradeid" id="salarygradeid" required>
                                    </div>
                                </div>
                                <br />
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="text-uppercase text-sm">Basic Pay</label>
                                        <input type="number" placeholder="Basic Pay" name="basic" id="basic" class="form-control mb" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="text-uppercase text-sm">House Rental Allowance</label>
                                        <input type="number" placeholder="HRA" name="hra" id="hra" class="form-control mb" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="text-uppercase text-sm">Travel Allowance</label>
                                        <input type="number" placeholder="TA" name="ta" id="ta" class="form-control mb" required>
                                    </div>
                                </div>
                                <br />
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="text-uppercase text-sm">Medical Allowance</label>
                                        <input type="number" placeholder="MA" name="ma" id="ma" class="form-control mb" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="text-uppercase text-sm">Provident Fund</label>
                                        <input type="number" placeholder="PF" name="pf" id="pf" class="form-control mb" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="text-uppercase text-sm">Total Leaves(Yearly)</label>
                                        <input type="number" placeholder="Total Leaves(Yearly)" name="leaves" id="leaves" class="form-control mb" required>
                                    </div>
                                </div>
                                <button type="submit" name="update_otherusers" class="btn btn-primary">Update Salary Grade</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function edit(id, value) {
        $('#id').val(id);
        $('#name').val(value);
    }

    function remove(id) {
        if (confirm('Are you sure?')) {
            window.location.href = "<?php echo base_url('master/deletesection?id=') ?>" + id;
        }
    }
</script>