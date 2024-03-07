<div class="content-wrapper">
    <div class="container-fluid">
        <form action="<?php echo base_url('Inventory/add_purchase_invoice') ?>" method="POST">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Add Purchase Invoice</h2>

                <div class="row">
                    <div class="col-md-6">
                        <label class="text-uppercase text-sm">Invoice Date</label>
                        <input type="date" name="invoice_date" class="form-control mb" required>
                    </div>
                    <div class="col-md-6">
                        <label class="text-uppercase text-sm">Invoice No.</label>
                        <input type="text" placeholder="Invoice No." name="invoice_no" class="form-control mb" required>
                    </div>
                    <div class="col-lg-6">
                        <label class="text-uppercase text-sm">Vendor</label>
                        <select id="vendor_id" name="vendor_id" style="width: 100%;" class="form-control mb">
                            <option value="">Select Vendor</option>
                            <?php foreach ($vendors as $vendor): ?>
                                <option value="<?php echo $vendor->id; ?>">
                                    <?php echo $vendor->name; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <label class="text-uppercase text-sm">Warehouse</label>
                        <select id="warehouse_id" name="warehouse_id" style="width: 100%;" class="form-control mb">
                            <option value="">Select Warehouse</option>
                            <?php foreach ($warehouses as $warehouse): ?>
                                <option value="<?php echo $warehouse->id; ?>">
                                    <?php echo $warehouse->name; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <button type="button" onclick="handleCreateProductInput(null)" class="btn btn-success mb">Add Items</button>
                    </div>
                    <div class="col-md-12" id="purchase-invoice-items-input"></div>
                    <div class="col-md-12">
                        <div>
                            <h4><span>Total Amount = </span><span id="total_amount">0</span></h4>
                        </div>
                        <br>
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

    fetch('<?php echo base_url('api/get_manufacturers') ?>')
    .then(response => {
        return response.json();
    })
    .then(data => {    
        manufacturers = data.data
    })
    .catch(error => {
        console.error(error);
    });

    let product_specifications = undefined;

    fetch('<?php echo base_url('api/get_product_specifications') ?>')
    .then(response => {
        return response.json();
    })
    .then(data => {    
        product_specifications = data.data
    })
    .catch(error => {
        console.error(error);
    });

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
        productInput.onchange = (event) => {
            
        }

        let productOption = document.createElement('option');
        productOption.value = "";
        productOption.innerHTML = "Select Product";
        productInput.appendChild(productOption);
        productInput.onchange = (event) => {
            if ($(event.target).find(':selected').data('product-type') == 'consumable') {
                event.target.parentNode.querySelector('.manufacturer_input').setAttribute('type', 'hidden');
                event.target.parentNode.querySelector('.quantity_input').setAttribute('type', 'number');
            }
            if ($(event.target).find(':selected').data('product-type') == 'asset') {
                event.target.parentNode.querySelector('.manufacturer_input').setAttribute('type', 'text');
                event.target.parentNode.querySelector('.quantity_input').setAttribute('type', 'hidden');
            }
            if ($(event.target).find(':selected').data('product-type') == 'set') {
                event.target.parentNode.querySelector('.manufacturer_input').setAttribute('type', 'text');
                event.target.parentNode.querySelector('.quantity_input').setAttribute('type', 'hidden');
            }
        }

        product_specifications.forEach((element,index) => {
            let option = document.createElement('option');
            option.value = element.id;
            option.innerHTML = element.name;
            option.setAttribute('data-product-type',element.product_type);
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
        // manufacturerSerialNoInput.required = true;
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