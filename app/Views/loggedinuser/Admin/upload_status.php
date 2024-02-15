<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Upload Status
                </h2>
                <div class="row">
                    <div class="col-md-12">
                        <?php if ($error != NULL && $error != "") : ?>
                            <h4 class="mb-3 header-title">Error Records</h4>
                            <?php echo $error; ?>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-12">
                        <?php if ($status != NULL && $status != "") : ?>
                            <h4 class="mb-3 header-title">Success Records</h4>
                            <?php echo $status; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>