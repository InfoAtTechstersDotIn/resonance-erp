<div class="content-wrapper">
    <div class="container-fluid">
        <form action="<?php echo base_url('Inventory/update_asset_transfer') ?>" method="POST">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Asset Transfer</h2>

                <div class="row">

                    <div class="col-lg-6">
                        <div class="row">

                            <div class="col-md-12">
                                <h4 class="page-title">Transfer From</h4>
                            </div>

                            <div class="col-md-12">
                                <select onchange="handleFilterBuildingFrom(event)" name="branch_id_from" style="width: 100%;" class="form-control mb">
                                    <option value="">Select Branch</option>
                                    <?php foreach ($lookups['branchlookup'] as $branch) : ?>
                                        <option value="<?php echo $branch->branchid; ?>"><?php echo $branch->branchname; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <select onchange="handleFilterFloorFrom(event)" id="building_id_from" name="building_id_from" style="width: 100%;" class="form-control mb">
                                    <option value="">Select Building</option>
                                    <?php foreach ($buildings as $building) : ?>
                                        <option style="display: none;" data-building-branch-id="<?php echo $building->branch_id; ?>" value="<?php echo $building->id; ?>"><?php echo $building->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                                    
                            <div class="col-md-12">
                                <select onchange="handleFilterRoomFrom(event)" id="floor_id_from" name="floor_id_from" style="width: 100%;" class="form-control mb">
                                    <option value="">Select Floor</option>
                                    <?php foreach ($floors as $floor) : ?>
                                        <option style="display: none;" data-floor-building-id="<?php echo $floor->building_id; ?>" value="<?php echo $floor->id; ?>"><?php echo $floor->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                                    
                            <div class="col-md-12">
                                <select onchange="handleGetItem('ROOM', event)" id="room_id_from" name="room_id_from" style="width: 100%;" class="form-control mb">
                                    <option value="">Select Room</option>
                                    <?php foreach ($rooms as $room) : ?>
                                        <option style="display: none;" data-room-floor-id="<?php echo $room->floor_id; ?>" value="<?php echo $room->id; ?>"><?php echo $room->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="row">
                            
                            <div class="col-md-12">
                                <h4 class="page-title">Transfer To</h4>
                            </div>

                            <div class="col-md-12">
                                <select onchange="handleFilterBuildingTo(event)" name="branch_id_to" style="width: 100%;" class="form-control mb">
                                    <option value="">Select Branch</option>
                                    <?php foreach ($lookups['branchlookup'] as $branch) : ?>
                                        <option value="<?php echo $branch->branchid; ?>"><?php echo $branch->branchname; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <select onchange="handleFilterFloorTo(event)" id="building_id_to" name="building_id_to" style="width: 100%;" class="form-control mb">
                                    <option value="">Select Building</option>
                                    <?php foreach ($buildings as $building) : ?>
                                        <option style="display: none;" data-building-branch-id="<?php echo $building->branch_id; ?>" value="<?php echo $building->id; ?>"><?php echo $building->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                                    
                            <div class="col-md-12">
                                <select onchange="handleFilterRoomTo(event)" id="floor_id_to" name="floor_id_to" style="width: 100%;" class="form-control mb">
                                    <option value="">Select Floor</option>
                                    <?php foreach ($floors as $floor) : ?>
                                        <option style="display: none;" data-floor-building-id="<?php echo $floor->building_id; ?>" value="<?php echo $floor->id; ?>"><?php echo $floor->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                                    
                            <div class="col-md-12">
                                <select id="room_id_to" name="room_id_to" style="width: 100%;" class="form-control mb">
                                    <option value="">Select Room</option>
                                    <?php foreach ($rooms as $room) : ?>
                                        <option style="display: none;" data-room-floor-id="<?php echo $room->floor_id; ?>" value="<?php echo $room->id; ?>"><?php echo $room->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div>
                            <h4>Select Product</h4>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Manufacturer</th>
                                    <th>Product Serial No</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="items-list-table">
                                
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success mb">Submit</button>
                    </div>
                </div>
            </div>

        </div>
        </form>
    </div>
</div>

<script>

    let manufacturers = undefined;

    function handleFilterBuildingFrom(event) {
        var select = document.getElementById("building_id_from");
        for (var i = 0; i < select.options.length; i++) {
            var option = select.options[i];
            if (option.getAttribute("data-building-branch-id") == event.target.value) {
                option.style.display = "block";
            } else {
                option.style.display = "none";
            }
        }
    }

    function handleFilterFloorFrom(event) {
        var select = document.getElementById("floor_id_from");
        for (var i = 0; i < select.options.length; i++) {
            var option = select.options[i];
            if (option.getAttribute("data-floor-building-id") == event.target.value) {
                option.style.display = "block";
            } else {
                option.style.display = "none";
            }
        }
    }

    function handleFilterRoomFrom(event) {
        var select = document.getElementById("room_id_from");
        for (var i = 0; i < select.options.length; i++) {
            var option = select.options[i];
            if (option.getAttribute("data-room-floor-id") == event.target.value) {
                option.style.display = "block";
            } else {
                option.style.display = "none";
            }
        }
    }

    function handleFilterBuildingTo(event) {
        var select = document.getElementById("building_id_to");
        for (var i = 0; i < select.options.length; i++) {
            var option = select.options[i];
            if (option.getAttribute("data-building-branch-id") == event.target.value) {
                option.style.display = "block";
            } else {
                option.style.display = "none";
            }
        }
    }

    function handleFilterFloorTo(event) {
        var select = document.getElementById("floor_id_to");
        for (var i = 0; i < select.options.length; i++) {
            var option = select.options[i];
            if (option.getAttribute("data-floor-building-id") == event.target.value) {
                option.style.display = "block";
            } else {
                option.style.display = "none";
            }
        }
    }

    function handleFilterRoomTo(event) {
        var select = document.getElementById("room_id_to");
        for (var i = 0; i < select.options.length; i++) {
            var option = select.options[i];
            if (option.getAttribute("data-room-floor-id") == event.target.value) {
                option.style.display = "block";
            } else {
                option.style.display = "none";
            }
        }
    }

    function handleGetItem(type, event) {

        document.getElementById('items-list-table').innerHTML = '';

        fetch(`<?php echo base_url('api/filter_products') ?>?type=${type}&id=${event.target.value}`)
        .then(response => {
            return response.json();
        })
        .then(data => {    
            
            console.log(data.data);

            data.data.forEach((element,index) => {

                let parentDiv = document.createElement('tr');
                
                let product_specification_name = document.createElement('td');
                product_specification_name.innerHTML =element.product_specification_name;

                let manufacturer_name = document.createElement('td');
                manufacturer_name.innerHTML =element.manufacturer_name;

                let product_serial_no = document.createElement('td');
                product_serial_no.innerHTML =element.product_serial_no;

                let action = document.createElement('td');

                let checkbox = document.createElement('input');
                checkbox.type = "checkbox";
                checkbox.name = "allocated_id[]";
                checkbox.value = element.id;
                
                let product_id = document.createElement('input');
                product_id.type = "hidden";
                product_id.name = "product_id[]";
                product_id.value = element.product_id;
                
                let purchase_invoice_item_id = document.createElement('input');
                purchase_invoice_item_id.type = "hidden";
                purchase_invoice_item_id.name = "purchase_invoice_item_id[]";
                purchase_invoice_item_id.value = element.purchase_invoice_item_id;
                
                let manufacturer_serial_no = document.createElement('input');
                manufacturer_serial_no.type = "hidden";
                manufacturer_serial_no.name = "manufacturer_serial_no[]";
                manufacturer_serial_no.value = element.manufacturer_serial_no;
                
                let product_serial_no_input = document.createElement('input');
                product_serial_no_input.type = "hidden";
                product_serial_no_input.name = "product_serial_no[]";
                product_serial_no_input.value = element.product_serial_no;

                action.append(checkbox,product_id, purchase_invoice_item_id, manufacturer_serial_no, product_serial_no_input);
                
                parentDiv.append(product_specification_name, manufacturer_name, product_serial_no, action);
                document.getElementById('items-list-table').appendChild(parentDiv);
            });

        })
        .catch(error => {
            console.error(error);
        });
    }
</script>