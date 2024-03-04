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
                        <select onchange="handleGetInventoryItem(event)" id="product_specification_id" name="product_specification_id" style="width: 100%;" class="form-control mb">
                            <option value="">Select Specification</option>
                            <?php foreach ($product_specifications as $product_specification): ?>
                                <option data-category-id="<?php echo $product_specification->category_id; ?>" value="<?php echo $product_specification->id; ?>">
                                    <?php echo $product_specification->name; ?>
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

    const handleCreateProductInput = (manufacturer_id, product_id, price, quantity, gst, total) => {

        let parentDiv = document.createElement('div');
        parentDiv.style.display = "flex";

        let manufacturerInput = document.createElement('select');
        manufacturerInput.className = "form-control select2 mb mr-2";
        manufacturerInput.name = "manufacturer_id[]";
        manufacturerInput.required = true;

        let manufacturerOption = document.createElement('option');
        manufacturerOption.value = "";
        manufacturerOption.innerHTML = "Select Manufacturers";
        manufacturerInput.appendChild(manufacturerOption);
        manufacturers.forEach((element,index) => {
            let option = document.createElement('option');
            option.value = element.id;
            option.innerHTML = element.name;
            if (parseInt(manufacturer_id) == parseInt(element.id)) {
                option.selected = true;
            }
            manufacturerInput.appendChild(option);
        });

        let productInput = document.createElement('select');
        productInput.className = "form-control mb";
        productInput.name = "product_id[]";
        productInput.required = true;

        let productOption = document.createElement('option');
        productOption.value = "";
        productOption.innerHTML = "Select Product";
        productInput.appendChild(productOption);

        product_specifications.forEach((element,index) => {
            let option = document.createElement('option');
            option.value = element.id;
            option.innerHTML = element.name;
            if (parseInt(product_id) == parseInt(element.id)) {
                option.selected = true;
            }
            productInput.appendChild(option);
        });
        
        let priceInput = document.createElement('input');
        priceInput.type = "number";
        priceInput.className = "form-control mb price_input";
        priceInput.name = "price[]";
        priceInput.value = price;
        priceInput.required = true;
        priceInput.min = 1;
        priceInput.max = 10000000;
        priceInput.placeholder = "Price";
        priceInput.onkeyup = (event) => {
            let gst_percentage = event.target.parentNode.querySelector('.gst_input').value
            let gross_amount = event.target.value * event.target.parentNode.querySelector('.quantity_input').value;
            let tax = (gross_amount * gst_percentage) / 100;
            event.target.parentNode.querySelector('.total_input').value = (gross_amount + tax).toFixed(2);
            calculateTotal();
        };

        let manufacturerSerialNoInput = document.createElement('input');
        manufacturerSerialNoInput.type = "text";
        manufacturerSerialNoInput.className = "form-control mb manufacturer_input";
        manufacturerSerialNoInput.name = "manufacturer_serial_no[]";
        manufacturerSerialNoInput.required = true;
        manufacturerSerialNoInput.minLength = 1;
        manufacturerSerialNoInput.maxLength = 250;
        manufacturerSerialNoInput.placeholder = "Manufacturer Serial No";

        let quantityInput = document.createElement('input');
        quantityInput.type = "hidden";
        quantityInput.className = "form-control mb quantity_input";
        quantityInput.name = "quantity[]";
        quantityInput.value = 1;
        quantityInput.required = true;
        quantityInput.min = 1;
        quantityInput.max = 10000;
        quantityInput.placeholder = "Enter Quantity";
        quantityInput.onkeyup = (event) => {
            let gst_percentage = event.target.parentNode.querySelector('.gst_input').value
            let gross_amount = event.target.parentNode.querySelector('.price_input').value * event.target.value;
            let tax = (gross_amount * gst_percentage) / 100;
            event.target.parentNode.querySelector('.total_input').value = (gross_amount + tax).toFixed(2);
            calculateTotal();
        };
        
        let gstInput = document.createElement('input');
        gstInput.type = "number";
        gstInput.className = "form-control mb gst_input";
        gstInput.name = "gst[]";
        gstInput.value = gst;
        gstInput.required = true;
        gstInput.min = 1;
        gstInput.max = 10000;
        gstInput.placeholder = "Enter GST Percentage";
        gstInput.onkeyup = (event) => {
            let gst_percentage = event.target.value;
            let gross_amount = event.target.parentNode.querySelector('.price_input').value * event.target.parentNode.querySelector('.quantity_input').value;
            let tax = (gross_amount * gst_percentage) / 100;
            event.target.parentNode.querySelector('.total_input').value = (gross_amount + tax).toFixed(2);
            calculateTotal();
        };

        let totalInput = document.createElement('input');
        totalInput.type = "number";
        totalInput.className = "form-control mb total_input";
        totalInput.name = "total[]";
        totalInput.value = total;
        totalInput.required = true;
        totalInput.min = 1;
        totalInput.max = 10000000;
        totalInput.readOnly = true;
        totalInput.placeholder = "Enter Total";

        let remove = document.createElement('button');
        remove.className = "btn btn-danger mb";
        remove.innerHTML = 'Remove';
        remove.type = "button";
        remove.onclick = (event) => {
            event.target.parentNode.remove();
        }

        parentDiv.append(manufacturerInput, productInput, priceInput, manufacturerSerialNoInput, quantityInput, gstInput, totalInput, remove);
        document.getElementById('purchase-invoice-items-input').appendChild(parentDiv);
    }

    const calculateTotal = () => {
        let total = 0;
        document.querySelectorAll('.total_input').forEach((element) => {
            if (element.value != "") {
                total += parseInt(element.value)
            }
        });
        document.getElementById('total_amount').innerHTML = total.toFixed(2);
    }
</script>