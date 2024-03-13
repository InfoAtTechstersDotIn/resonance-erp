<div class="content-wrapper">
    <div class="container-fluid">
        <form action="<?php echo base_url('Inventory/add_asset_allocation') ?>" method="POST">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Asset Allocation</h2>

                <div class="row">

                    <!-- <div class="col-lg-6">
                        <label class="text-uppercase text-sm">Category</label>
                        <select onchange="handleFilterSpecification(event)" name="category_id" style="width: 100%;" class="form-control mb" required>
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $category) : ?>
                                <option value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="col-lg-6">
                        <label class="text-uppercase text-sm">Product Specification</label>
                        <select id="product_specification_id" name="product_specification_id" style="width: 100%;" class="form-control mb" required>
                            <option value="">Select Specification</option>
                            <?php foreach ($product_specifications as $product_specification): ?>
                                <option data-category-id="<?php echo $product_specification->category_id; ?>" value="<?php echo $product_specification->id; ?>">
                                    <?php echo $product_specification->name; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div> -->
                    
                    <div class="col-lg-6">
                        <label class="text-uppercase text-sm">Warehouse</label>
                        <select onchange="handleGetWarehouseItem(event)" name="warehouse_id" id="warehouse_id" style="width: 100%;" class="form-control mb" required>
                            <option value="">Select Warehouse</option>
                            <?php foreach ($warehouses as $warehouse): ?>
                                <option value="<?php echo $warehouse->id; ?>">
                                    <?php echo $warehouse->name; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="col-md-12">
                        <div>
                            <h4>Product List</h4>
                        </div>
                        <!-- <div class="form-check" style="margin-bottom: 7px;">
                            <input class="form-check-input" onchange="checkAllCheckboxes()" type="checkbox" id="select_all_checkbox">
                            <label class="form-check-label" for="select_all_checkbox">Select All Items</label>
                        </div> -->
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Available Quantity</th>
                                    <th>Allocation Quantity</th>
                                    <th>Manufacturer Serial No</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="items-list-table">
                                
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <div>
                            <h4>Allocate to</h4>
                        </div>
                        <div class="row">

                            <div class="col-md-12">
                                <select onchange="handleFilterBuilding(event)" name="branch_id" style="width: 100%;" class="form-control mb" required>
                                    <option value="">Select Branch</option>
                                    <?php foreach ($lookups['branchlookup'] as $branch) : ?>
                                        <option value="<?php echo $branch->branchid; ?>"><?php echo $branch->branchname; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <select onchange="handleFilterFloor(event)" id="building_id" name="building_id" style="width: 100%;" class="form-control mb" required>
                                    <option value="">Select Building</option>
                                    <?php foreach ($buildings as $building) : ?>
                                        <option style="display: none;" data-building-branch-id="<?php echo $building->branch_id; ?>" value="<?php echo $building->id; ?>"><?php echo $building->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                                    
                            <div class="col-md-12">
                                <select onchange="handleFilterRoom(event)" id="floor_id" name="floor_id" style="width: 100%;" class="form-control mb" required>
                                    <option value="">Select Floor</option>
                                    <?php foreach ($floors as $floor) : ?>
                                        <option style="display: none;" data-floor-building-id="<?php echo $floor->building_id; ?>" value="<?php echo $floor->id; ?>"><?php echo $floor->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                                    
                            <div class="col-md-12">
                                <select id="room_id" name="room_id" style="width: 100%;" class="form-control mb" required>
                                    <option value="">Select Room</option>
                                    <?php foreach ($rooms as $room) : ?>
                                        <option style="display: none;" data-room-floor-id="<?php echo $room->floor_id; ?>" value="<?php echo $room->id; ?>"><?php echo $room->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                                    
                            <div class="col-md-12">
                                <select id="area_id" name="area_id" style="width: 100%;" class="form-control mb" required>
                                    <option value="">Select Area</option>
                                    <?php foreach ($areas as $area) : ?>
                                        <option value="<?php echo $area->id; ?>"><?php echo $area->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                        </div>
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

    function handleFilterSpecification(event) {
        var select = document.getElementById("product_specification_id");
        for (var i = 0; i < select.options.length; i++) {
            var option = select.options[i];
            if (option.getAttribute("data-category-id") == event.target.value) {
                option.style.display = "block";
            } else {
                option.style.display = "none";
            }
        }
    }

    function checkAllCheckboxes() {
        const checkboxes = document.querySelectorAll('table input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                checkbox.checked = false;
            }
            else {
                checkbox.checked = true;
            }
        });
    }

    function handleFilterBuilding(event) {
        var select = document.getElementById("building_id");
        for (var i = 0; i < select.options.length; i++) {
            var option = select.options[i];
            if (option.getAttribute("data-building-branch-id") == event.target.value) {
                option.style.display = "block";
            } else {
                option.style.display = "none";
            }
        }
    }

    function handleFilterFloor(event) {
        var select = document.getElementById("floor_id");
        for (var i = 0; i < select.options.length; i++) {
            var option = select.options[i];
            if (option.getAttribute("data-floor-building-id") == event.target.value) {
                option.style.display = "block";
            } else {
                option.style.display = "none";
            }
        }
    }

    function handleFilterRoom(event) {
        var select = document.getElementById("room_id");
        for (var i = 0; i < select.options.length; i++) {
            var option = select.options[i];
            if (option.getAttribute("data-room-floor-id") == event.target.value) {
                option.style.display = "block";
            } else {
                option.style.display = "none";
            }
        }
    }
    
    function handleGetWarehouseItem(event) {

        document.getElementById('items-list-table').innerHTML = '';

        fetch(`<?php echo base_url('api/get_warehouse_items') ?>/${event.target.value}`)
        .then(response => {
            return response.json();
        })
        .then(data => { 

            console.log(data.data);
            
            data.data.forEach((element,index) => {

                let parentDiv = document.createElement('tr');
                
                let product_name_col = document.createElement('td');
                product_name_col.innerHTML = element.product_name;

                let available_quantity_col = document.createElement('td');
                available_quantity_col.innerHTML = element.available_quantity;

                let allocation_quantity_col = document.createElement('td');
                let allocation_quantity_input = document.createElement('input');
                allocation_quantity_input.type = "number";
                allocation_quantity_input.name = "allocation_quantity[]";
                allocation_quantity_input.min = 1;
                allocation_quantity_input.required = true;
                allocation_quantity_input.placeholder = "Quantity";
                allocation_quantity_input.style.width = "100px";
                allocation_quantity_input.style.outline = "none";
                allocation_quantity_input.max = element.available_quantity;
                if (element.product_type == "asset") {
                    allocation_quantity_input.value = 1;
                    allocation_quantity_input.readOnly = true;
                }
                allocation_quantity_col.append(allocation_quantity_input);

                let manufacturer_serial_no_col = document.createElement('td');
                manufacturer_serial_no_col.innerHTML = element.manufacturer_serial_no;
                
                let options = document.createElement('td');

                let selectOption = document.createElement('select');
                selectOption.name = "selected_item[]";

                let option1 =document.createElement('option');
                option1.value = "SELECTED";
                option1.innerHTML = "Add Item";

                let option2 =document.createElement('option');
                option2.value = "NOT_SELECTED";
                option2.innerHTML = "Not Added";
                option2.selected = true;

                selectOption.append(option1, option2);
            
                let warehouse_item_id = document.createElement('input');
                warehouse_item_id.type = "hidden";
                warehouse_item_id.name = "warehouse_item_id[]";
                warehouse_item_id.value = element.id;

                let product_id = document.createElement('input');
                product_id.type = "hidden";
                product_id.name = "product_id[]";
                product_id.value = element.product_id;

                let manufacturer_serial_no = document.createElement('input');
                manufacturer_serial_no.type = "hidden";
                manufacturer_serial_no.name = "manufacturer_serial_no[]";
                manufacturer_serial_no.value = element.manufacturer_serial_no;

                let product_serial_no = document.createElement('input');
                product_serial_no.type = "hidden";
                product_serial_no.name = "product_serial_no[]";
                product_serial_no.value = element.product_serial_no;

                options.append(selectOption, manufacturer_serial_no, product_serial_no, warehouse_item_id, product_id);

                parentDiv.append(product_name_col, available_quantity_col, allocation_quantity_col, manufacturer_serial_no_col, options);
                document.getElementById('items-list-table').appendChild(parentDiv);

            });
        })
        .catch(error => {
            console.error(error);
        });
    }
</script>