<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">

        
            <div class="col-md-12">
                    <h2 class="page-title">Warehouse Items</h2>
            </div>

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
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblotherusers" class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Name</th>
                                    <th>Total Quantity</th>
                                    <th>Available Quantity</th>
                                    <th>Manufacturer Serial No</th>
                                    <th>Product Serial No</th>
                                </tr>
                            </thead>
                            <tbody id="items-list-table">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            
        </div>
    </div>
</div>



<script>

    function handleGetWarehouseItem(event) {

        document.getElementById('items-list-table').innerHTML = '';

        fetch(`<?php echo base_url('api/get_warehouse_items') ?>/${event.target.value}`)
        .then(response => {
            return response.json();
        })
        .then(data => { 
            
            data.data.forEach((element,index) => {

                let parentDiv = document.createElement('tr');
                
                let sr_no_col = document.createElement('td');
                sr_no_col.innerHTML = index + 1;
                
                let product_name_col = document.createElement('td');
                product_name_col.innerHTML = element.product_name;
                product_name_col.style.whiteSpace = "nowrap";

                let total_quantity_col = document.createElement('td');
                total_quantity_col.innerHTML = element.available_quantity;

                let available_quantity_col = document.createElement('td');
                available_quantity_col.innerHTML = element.available_quantity;
                
                let manufacturer_serial_no_col = document.createElement('td');
                manufacturer_serial_no_col.innerHTML = element.manufacturer_serial_no;

                let product_serial_no_col = document.createElement('td');
                product_serial_no_col.innerHTML = element.product_serial_no;

                parentDiv.append(sr_no_col, product_name_col, total_quantity_col, available_quantity_col, manufacturer_serial_no_col, product_serial_no_col);
                document.getElementById('items-list-table').appendChild(parentDiv);

            });
        })
        .catch(error => {
            console.error(error);
        });
    }
</script>