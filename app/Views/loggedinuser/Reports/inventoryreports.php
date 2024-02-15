<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Reports</h2>
                <h4 class="page-title">Inventory</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <a target="_blank" target="_blank" href="<?php echo base_url('inventory/warehousereport') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <div class="stat-panel-title text-uppercase">Inventory Stock Report</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <?php if ($_SESSION['rights'][array_search('WarehouseManager', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
                                 <div class="col-md-4">
                                    <a target="_blank" target="_blank" href="<?php echo base_url('inventory/warehousedailyreport') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <div class="stat-panel-title text-uppercase">Inventory Daily Stock Report</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a target="_blank" target="_blank" href="<?php echo base_url('inventory/warehousetransferreport') ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <div class="stat-panel-title text-uppercase">Inventory Transfer Report</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>