<div class="content-wrapper">
    <div class="container-fluid">
        <form action="<?php echo base_url('Inventory/add_purchase_invoice') ?>" method="POST">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Edit Purchase Invoice
                    
                </h2>

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

    let products = undefined;

    fetch('<?php echo base_url('api/get_products') ?>')
    .then(response => {
        return response.json();
    })
    .then(data => {    
        products = data.data
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

        let productOption = document.createElement('option');
        productOption.value = "";
        productOption.innerHTML = "Select Product";
        productInput.appendChild(productOption);

        products.forEach((element,index) => {
            let option = document.createElement('option');
            option.value = element.id;
            option.innerHTML = element.productname;
            if (parseInt(product_id) == parseInt(element.id)) {
                option.selected = true;
            }
            productInput.appendChild(option);
        });
        
        let priceInput = document.createElement('input');
        priceInput.type = "number";
        priceInput.className = "form-control mb";
        priceInput.name = "price[]";
        priceInput.value = price;
        priceInput.required = true;
        priceInput.min = 1;
        priceInput.max = 10000000;
        priceInput.placeholder = "Enter Price";

        let quantityInput = document.createElement('input');
        quantityInput.type = "number";
        quantityInput.className = "form-control mb";
        quantityInput.name = "quantity[]";
        quantityInput.value = quantity;
        quantityInput.required = true;
        quantityInput.min = 1;
        quantityInput.max = 10000;
        quantityInput.placeholder = "Enter Quantity";
        
        let gstInput = document.createElement('input');
        gstInput.type = "number";
        gstInput.className = "form-control mb";
        gstInput.name = "gst[]";
        gstInput.value = gst;
        gstInput.required = true;
        gstInput.min = 1;
        gstInput.max = 10000;
        gstInput.placeholder = "Enter GST";

        let totalInput = document.createElement('input');
        totalInput.type = "number";
        totalInput.className = "form-control mb total_input";
        totalInput.name = "total[]";
        totalInput.value = total;
        totalInput.required = true;
        totalInput.min = 1;
        totalInput.max = 10000000;
        totalInput.placeholder = "Enter Total";
        totalInput.onkeyup = (event) => {
            calculateTotal();
        }

        let remove = document.createElement('button');
        remove.className = "btn btn-danger mb";
        remove.innerHTML = 'Remove';
        remove.type = "button";
        remove.onclick = (event) => {
            event.target.parentNode.remove();
        }

        parentDiv.append(manufacturerInput, productInput, priceInput, quantityInput, gstInput, totalInput, remove);
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