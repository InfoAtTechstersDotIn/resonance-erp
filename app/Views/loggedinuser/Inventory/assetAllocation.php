<div class="content-wrapper">
    <div class="container-fluid">
        <form action="<?php echo base_url('Inventory/add_asset_allocation') ?>" method="POST">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Asset Allocation</h2>

                <div class="row">

                    <div class="col-lg-6">
                        <label class="text-uppercase text-sm">Category</label>
                        <select onchange="handleFilterSpecification(event)" name="category_id" style="width: 100%;" class="form-control mb">
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $category) : ?>
                                <option value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="col-lg-6">
                        <label class="text-uppercase text-sm">Product Specification</label>
                        <select id="product_specification_id" name="product_specification_id" style="width: 100%;" class="form-control mb">
                            <option value="">Select Specification</option>
                            <?php foreach ($product_specifications as $product_specification): ?>
                                <option data-category-id="<?php echo $product_specification->category_id; ?>" value="<?php echo $product_specification->id; ?>">
                                    <?php echo $product_specification->name; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    
                    <div class="col-lg-6">
                        <label class="text-uppercase text-sm">Warehouse</label>
                        <select onchange="handleGetVarehouseItem(event)" style="width: 100%;" class="form-control mb">
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

                    <div class="col-md-6">
                        <div>
                            <h4>Allocate to</h4>
                        </div>
                        <div class="row">

                            <div class="col-md-12">
                                <select onchange="handleFilterBuilding(event)" name="branch_id" style="width: 100%;" class="form-control mb">
                                    <option value="">Select Branch</option>
                                    <?php foreach ($lookups['branchlookup'] as $branch) : ?>
                                        <option value="<?php echo $branch->branchid; ?>"><?php echo $branch->branchname; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <select onchange="handleFilterFloor(event)" id="building_id" name="building_id" style="width: 100%;" class="form-control mb">
                                    <option value="">Select Building</option>
                                    <?php foreach ($buildings as $building) : ?>
                                        <option style="display: none;" data-building-branch-id="<?php echo $building->branch_id; ?>" value="<?php echo $building->id; ?>"><?php echo $building->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                                    
                            <div class="col-md-12">
                                <select onchange="handleFilterRoom(event)" id="floor_id" name="floor_id" style="width: 100%;" class="form-control mb">
                                    <option value="">Select Floor</option>
                                    <?php foreach ($floors as $floor) : ?>
                                        <option style="display: none;" data-floor-building-id="<?php echo $floor->building_id; ?>" value="<?php echo $floor->id; ?>"><?php echo $floor->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                                    
                            <div class="col-md-12">
                                <select id="room_id" name="room_id" style="width: 100%;" class="form-control mb">
                                    <option value="">Select Room</option>
                                    <?php foreach ($rooms as $room) : ?>
                                        <option style="display: none;" data-room-floor-id="<?php echo $room->floor_id; ?>" value="<?php echo $room->id; ?>"><?php echo $room->name; ?></option>
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

    function handleGetInventoryItem(event) {

        document.getElementById('items-list-table').innerHTML = '';

        fetch('<?php echo base_url('api/get_product_specification_by_id') ?>/' + event.target.value)
        .then(response => {
            return response.json();
        })
        .then(data => {    

            console.log(data.data.invoice_items);
            
            data.data.invoice_items.forEach((element,index) => {

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
                checkbox.name = "product_id[]";
                checkbox.value = element.id;
                action.append(checkbox);
                

                parentDiv.append(product_specification_name, manufacturer_name, product_serial_no, action);
                
                document.getElementById('items-list-table').appendChild(parentDiv);
            });

        })
        .catch(error => {
            console.error(error);
        });
    }

    
    function handleGetVarehouseItem(event) {

        let product_id = document.getElementById('product_specification_id').value;

        document.getElementById('items-list-table').innerHTML = '';

        fetch('<?php echo base_url('api/get_warehouse_item') ?>/' + event.target.value + '/' + product_id)
        .then(response => {
            return response.json();
        })
        .then(data => {    

            console.log(data.data.invoice_items);
            
            data.data.invoice_items.forEach((element,index) => {

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
                checkbox.name = "product_id[]";
                checkbox.value = element.id;
                action.append(checkbox);
                

                parentDiv.append(product_specification_name, manufacturer_name, product_serial_no, action);
                
                document.getElementById('items-list-table').appendChild(parentDiv);
            });

        })
        .catch(error => {
            console.error(error);
        });
    }
</script>