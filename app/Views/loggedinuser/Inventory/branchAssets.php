<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Branch Asset</h2>

                <div class="row">

                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Manufacturer Serial No</th>
                                    <th>Product Serial No</th>
                                    <th>Recived</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($products as $key => $result) : ?>
                                <tr>
                                    <td><?php echo $key + 1 ?></td>
                                    <td><?php echo $result->product_name ?></td>
                                    <td><?php echo $result->quantity ?></td>
                                    <td><?php echo $result->manufacturer_serial_no ?></td>
                                    <td><?php echo $result->product_serial_no ?></td>
                                    <td>
                                        <?php if ($result->is_received) : ?>
                                        <div class="form-check">
                                            <a href="#">Distribute</a>
                                        </div>
                                        <?php else: ?>
                                        <div class="form-check">
                                            <input onchange="window.location = '<?php echo base_url('Inventory/asset_received') .'/' . $result->id ?>'" class="form-check-input" type="checkbox" value="" id="reveived_product_<?php echo $key ?>">
                                            <label class="form-check-label" for="reveived_product_<?php echo $key ?>">
                                            Received this product
                                            </label>
                                        </div>
                                        <?php endif; ?>
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

<script>


    function handleGetItem(type, id) {

        document.getElementById('items-list-table').innerHTML = '';

        fetch(`<?php echo base_url('api/get_branch_assets') ?>`)
        .then(response => {
            return response.json();
        })
        .then(data => {    
            
            data.data.forEach((element,index) => {

                let parentDiv = document.createElement('tr');
                
                let product_qr = document.createElement('td');
                
                if (element.qr_image_path) {
                    let qr_image = document.createElement('img');
                    qr_image.src = "<?php echo str_replace('public','',base_url('')) ?>/" + element.qr_image_path;
                    qr_image.style.height = "100px";
                    qr_image.style.width = "100px";
                    product_qr.append(qr_image);
                }
        
                let product_specification_name = document.createElement('td');
                product_specification_name.innerHTML =element.product_specification_name;
        
                let quantity_name = document.createElement('td');
                quantity_name.innerHTML =element.quantity;
        
                let manufacturer_serial_no = document.createElement('td');
                manufacturer_serial_no.innerHTML =element.manufacturer_serial_no;

                let product_serial_no = document.createElement('td');
                product_serial_no.innerHTML =element.product_serial_no;
                
                parentDiv.append(product_qr, product_specification_name, quantity_name, manufacturer_serial_no, product_serial_no);
                document.getElementById('items-list-table').appendChild(parentDiv);
            });

        })
        .catch(error => {
            console.error(error);
        });
    }
</script>