<style>
    .accordion {
        border: 1px solid #ccc;
        margin-bottom: 20px;
    }

    .accordion-item {
        border-bottom: 1px solid #ccc;
    }

    .accordion-header {
        background-color: #f5f5f5;
        padding: 10px;
        font-weight: bold;
        cursor: pointer;
        text-align: right;
    }

    .accordion-content {
        padding: 10px;
        display: none;
    }
</style>
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">List of On Boarding Employee Employees
                </h2>
                <br />

                <a class="btn btn-primary" onclick="filter(1)">Download Excel</a>
                <br />
                <br />
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblotherusers" class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <!-- <th>Employee Id</th> -->
                                    <th>Mobile</th>
                                    <th>URL</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                foreach ($EmployeeDetails as $result) :


                                ?>
                                    <tr>
                                        <!-- <td><?php echo $result->employeeid ?></td> -->
                                        <td><?php echo $result->mobile ?></td>
                                        <td><?php echo base_url('users/onboardemployeeform?uniqueid=' . $result->uniqueid) ?></td>
                                        <td>
                                            <?php
                                            if ($result->is_onboard_status == 0) {
                                            ?>
                                            Created
                                            <?php
                                            } elseif ($result->is_onboard_status == 1) {
                                            ?>
                                            Submitted
                                            <?php
                                            }
                                            ?>

                                        </td>
                                        <td>
                                            <?php
                                            if ($result->is_onboard_status == 1) {
                                            ?>
                                                <a target="_blank" href="<?php echo base_url('users/onboardemployeedetails?uniqueid=' . $result->uniqueid) ?>">View Details</a>
                                            <?php
                                            }
                                            ?>
                                        </td>
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
<div class="modal modal-danger fade" id="modal_popup">

    <div class="modal-dialog modal-sm">




    </div>

</div>

<script type="text/javascript">
    $(document).on('click', '.user_status', function() {

        var id = $(this).attr('uid'); //get attribute value in variable

        var status = $(this).attr('ustatus'); //get attribute value in variable

        $('#user_id').val(id); //pass attribute value in ID
        $('#user_status').val(status); //pass attribute value in ID

        $('#modal_popup').modal({
            backdrop: 'static',
            keyboard: true,
            show: true
        }); //show modal popup

    });
</script>
<script>
    function filter(download = 0) {
        var URL = "<?php echo base_url('users/employee') ?>" + "?" + $('#filterForm').serialize();
        if (download == 1) {
            URL = URL + "&download=1";
        }

        window.location.href = URL;
    }
</script>
<script>
    const accordionItems = document.querySelectorAll('.accordion-item');

    accordionItems.forEach((item) => {
        const header = item.querySelector('.accordion-header');
        const content = item.querySelector('.accordion-content');

        header.addEventListener('click', () => {
            content.style.display = content.style.display === 'none' ? 'block' : 'none';
        });
    });
</script>
<script>
    $('.btn-del').on('click', function(e) {
        e.preventDefault();
        const href = $(this).attr('href')
        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this Data!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    document.location.href = href;
                }
            })

    })
</script>