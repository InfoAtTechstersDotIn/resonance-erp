<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Asset Report</h2>

                <div class="row">

                    <div class="col-lg-6">
                        <div class="row">

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
                                <select id="room_id_from" name="room_id_from" style="width: 100%;" class="form-control mb">
                                    <option value="">Select Room</option>
                                    <?php foreach ($rooms as $room) : ?>
                                        <option style="display: block;" data-room-floor-id="<?php echo $room->floor_id; ?>" value="<?php echo $room->id; ?>"><?php echo $room->name; ?></option>
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
                                    <th>QR Code</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
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

    let manufacturers = undefined;

    function handleFilterBuildingFrom(event) {
        handleGetItem('BRANCH', event.target.value);
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
        handleGetItem('BUILDING', event.target.value);
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
        handleGetItem('FLOOR', event.target.value);
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

    function handleGetItem(type, id) {

        document.getElementById('items-list-table').innerHTML = '';

        fetch(`<?php echo base_url('api/filter_products') ?>?type=${type}&id=${id}`)
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