<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\AreaModel;
use App\Models\BuildingModel;
use App\Models\EmailModel;
use App\Models\FloorModel;
use App\Models\HelperModel;
use App\Models\MasterModel;
use App\Models\PaymentsModel;
use App\Models\RoomModel;
use App\Models\UsersModel;
use App\Models\WarehouseModel;

class Master extends BaseController
{
    public $session;
    public function __construct()
    {
        $session = session();
    }

    public function index()
    {
        if ($_SESSION['userdetails'] == null) {
            return view('loggedoutuser/index.php');
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function batch()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Master/batch';

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function branch()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Master/branch';

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function course()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Master/course';

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function section()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Master/section';

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function subject()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Master/subject';

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    // BATCH
    public function addbatch()
    {
        if ($_SESSION['userdetails'] != null) {
            $name = $_POST['name'];

            $mastermodel = new MasterModel();
            $mastermodel->addbatch($name);

            return redirect()->to(base_url('master/batch'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function updatebatch()
    {
        if ($_SESSION['userdetails'] != null) {
            $id = $_POST['id'];
            $name = $_POST['name'];

            $mastermodel = new MasterModel();
            $mastermodel->update_batch($id, $name);

            return redirect()->to(base_url('master/batch'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function deletebatch()
    {
        if ($_SESSION['userdetails'] != null) {
            $id = $_GET['id'];

            $mastermodel = new MasterModel();
            $mastermodel->deletebatch($id);

            return redirect()->to(base_url('master/batch'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }
    // BATCH

    // BRANCH
    public function addbranch()
    {
        if ($_SESSION['userdetails'] != null) {
            $name = $_POST['name'];
            $latitude = $_POST['latitude'];
            $longitude = $_POST['longitude'];
            $branch_address = $_POST['branch_address'];

            $mastermodel = new MasterModel();
            $mastermodel->addbranch($name, $latitude, $longitude, $branch_address);

            return redirect()->to(base_url('master/branch'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }
    
    public function addmaterialrequisition()
    {
        if ($_SESSION['userdetails'] != null) {
            $name = $_POST['name'];

            $mastermodel = new MasterModel();
            $mastermodel->addmaterialrequisition($name);

            return redirect()->to(base_url('admin/materialrequisitionlist'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function updatebranch()
    {
        if ($_SESSION['userdetails'] != null) {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $latitude = $_POST['latitude'];
            $longitude = $_POST['longitude'];
            $branch_address = $_POST['branch_address'];

            $mastermodel = new MasterModel();
            $mastermodel->updatebranch($id, $name, $latitude, $longitude, $branch_address);

            return redirect()->to(base_url('master/branch'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }
    
     public function updatematerialrequisition()
    {
        if ($_SESSION['userdetails'] != null) {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $mastermodel = new MasterModel();
            $mastermodel->updatematerialrequisition($id, $name);

            return redirect()->to(base_url('admin/materialrequisitionlist'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function deletebranch()
    {
        if ($_SESSION['userdetails'] != null) {
            $id = $_GET['id'];

            $mastermodel = new MasterModel();
            $mastermodel->deletebranch($id);

            return redirect()->to(base_url('master/branch'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }
    
    public function deletematerialrequisition()
    {
        if ($_SESSION['userdetails'] != null) {
            $id = $_GET['id'];
            $mastermodel = new MasterModel();
            $mastermodel->deletematerialrequisition($id);

            return redirect()->to(base_url('admin/materialrequisitionlist'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }
    // BRANCH

    // COURSE
    public function addcourse()
    {
        if ($_SESSION['userdetails'] != null) {
            $name = $_POST['name'];

            $mastermodel = new MasterModel();
            $mastermodel->addcourse($name);

            return redirect()->to(base_url('master/course'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function updatecourse()
    {
        if ($_SESSION['userdetails'] != null) {
            $id = $_POST['id'];
            $name = $_POST['name'];

            $mastermodel = new MasterModel();
            $mastermodel->updatecourse($id, $name);

            return redirect()->to(base_url('master/course'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function deletecourse()
    {
        if ($_SESSION['userdetails'] != null) {
            $id = $_GET['id'];

            $mastermodel = new MasterModel();
            $mastermodel->deletecourse($id);

            return redirect()->to(base_url('master/course'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }
    // COURSE

    // SECTION
    public function addsection()
    {
        if ($_SESSION['userdetails'] != null) {
            $name = $_POST['name'];

            $mastermodel = new MasterModel();
            $mastermodel->addsection($name);

            return redirect()->to(base_url('master/section'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function updatesection()
    {
        if ($_SESSION['userdetails'] != null) {
            $id = $_POST['id'];
            $name = $_POST['name'];

            $mastermodel = new MasterModel();
            $mastermodel->updatesection($id, $name);

            return redirect()->to(base_url('master/section'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function deletesection()
    {
        if ($_SESSION['userdetails'] != null) {
            $id = $_GET['id'];

            $mastermodel = new MasterModel();
            $mastermodel->deletesection($id);

            return redirect()->to(base_url('master/section'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }
    // SECTION

    // SUBJECT
    public function addsubject()
    {
        if ($_SESSION['userdetails'] != null) {
            $name = $_POST['name'];

            $mastermodel = new MasterModel();
            $mastermodel->addsubject($name);

            return redirect()->to(base_url('master/subject'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function updatesubject()
    {
        if ($_SESSION['userdetails'] != null) {
            $id = $_POST['id'];
            $name = $_POST['name'];

            $mastermodel = new MasterModel();
            $mastermodel->updatesubject($id, $name);

            return redirect()->to(base_url('master/subject'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function deletesubject()
    {
        if ($_SESSION['userdetails'] != null) {
            $id = $_GET['id'];

            $mastermodel = new MasterModel();
            $mastermodel->deletesubject($id);

            return redirect()->to(base_url('master/subject'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }
    // SUBJECT

    public function buildings()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Master/building';

            $buildingModel = new BuildingModel();
            $data['buildings'] = $buildingModel->get_buildings();

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function addbuilding()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['name'] = $_POST['buildingname'];
            $data['branch_id'] = $_POST['branch_id'];

            $buildingModel = new BuildingModel();
            $buildingModel->add_building($data);

            return redirect()->to(base_url('Master/buildings'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function updatebuilding()
    {
        if ($_SESSION['userdetails'] != null) {
            $buildingid = $_POST['buildingid'];
            $data['name'] = $_POST['buildingname'];
            $data['branch_id'] = $_POST['branch_id'];

            $buildingModel = new BuildingModel();
            $buildingModel->update_building($buildingid, $data);

            return redirect()->to(base_url('Master/buildings'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function deletebuilding()
    {
        if ($_SESSION['userdetails'] != null) {
            $id = $_GET['buildingid'];
            $buildingModel = new BuildingModel();
            $buildingModel->delete_building($id);

            return redirect()->to(base_url('Master/buildings'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function floors()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Master/floor';

            $floorModel = new FloorModel();
            $data['floors'] = $floorModel->get_floors();

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            $floorModel = new BuildingModel();
            $data['buildings'] = $floorModel->get_all_buildings();

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function addfloor()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['name'] = $_POST['floorname'];
            $data['branch_id'] = $_POST['branch_id'];
            $data['building_id'] = $_POST['building_id'];

            $floorModel = new FloorModel();
            $floorModel->add_floor($data);

            return redirect()->to(base_url('Master/floors'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function updatefloor()
    {
        if ($_SESSION['userdetails'] != null) {
            $floorid = $_POST['floorid'];
            $data['name'] = $_POST['floorname'];
            $data['branch_id'] = $_POST['branch_id'];
            $data['building_id'] = $_POST['building_id'];

            $floorModel = new FloorModel();
            $floorModel->update_floor($floorid, $data);

            return redirect()->to(base_url('Master/floors'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function deletefloor()
    {
        if ($_SESSION['userdetails'] != null) {
            $id = $_GET['floorid'];
            $floorModel = new FloorModel();
            $floorModel->delete_floor($id);

            return redirect()->to(base_url('Master/floors'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function rooms()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Master/room';

            $roomModel = new RoomModel();
            $data['rooms'] = $roomModel->get_rooms();

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            $floorModel = new BuildingModel();
            $data['buildings'] = $floorModel->get_all_buildings();

            $floorModel = new FloorModel();
            $data['floors'] = $floorModel->get_all_floors();

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function addroom()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['name'] = $_POST['roomname'];
            $data['branch_id'] = $_POST['branch_id'];
            $data['building_id'] = $_POST['building_id'];
            $data['floor_id'] = $_POST['floor_id'];

            $roomModel = new RoomModel();
            $roomModel->add_room($data);

            return redirect()->to(base_url('Master/rooms'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function updateroom()
    {
        if ($_SESSION['userdetails'] != null) {
            $roomid = $_POST['roomid'];
            $data['name'] = $_POST['roomname'];
            $data['branch_id'] = $_POST['branch_id'];
            $data['building_id'] = $_POST['building_id'];
            $data['floor_id'] = $_POST['floor_id'];

            $roomModel = new RoomModel();
            $roomModel->update_room($roomid, $data);

            return redirect()->to(base_url('Master/rooms'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function deleteroom()
    {
        if ($_SESSION['userdetails'] != null) {
            $id = $_GET['roomid'];
            
            $roomModel = new RoomModel();
            $roomModel->delete_room($id);

            return redirect()->to(base_url('Master/rooms'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }


    public function areas()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Master/area';

            $areaModel = new AreaModel();
            $data['areas'] = $areaModel->get_areas();

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function addarea()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['name'] = $_POST['name'];

            $areaModel = new AreaModel();
            $areaModel->add_area($data);

            return redirect()->to(base_url('Master/areas'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function updatearea()
    {
        if ($_SESSION['userdetails'] != null) {
            $area_id = $_POST['area_id'];
            $data['name'] = $_POST['name'];

            $areaModel = new AreaModel();
            $areaModel->update_area($area_id, $data);

            return redirect()->to(base_url('Master/areas'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function deletearea()
    {
        if ($_SESSION['userdetails'] != null) {
            $area_id = $_GET['area_id'];

            $areaModel = new AreaModel();
            $areaModel->delete_area($area_id);

            return redirect()->to(base_url('Master/areas'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function warehouses()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['page_name'] = 'Master/warehouse';

            $warehouseModel = new WarehouseModel();
            $data['warehouses'] = $warehouseModel->get_warehouses();

            return view('loggedinuser/index.php', $data);
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function addwarehouse()
    {
        if ($_SESSION['userdetails'] != null) {
            $data['name'] = $_POST['name'];
            $data['address'] = $_POST['address'];

            $warehouseModel = new WarehouseModel();
            $warehouseModel->add_warehouse($data);

            return redirect()->to(base_url('Master/warehouses'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function updatewarehouse()
    {
        if ($_SESSION['userdetails'] != null) {
            $warehouse_id = $_POST['warehouse_id'];
            $data['name'] = $_POST['name'];
            $data['address'] = $_POST['address'];

            $warehouseModel = new WarehouseModel();
            $warehouseModel->update_warehouse($warehouse_id, $data);

            return redirect()->to(base_url('Master/warehouses'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function deletewarehouse()
    {
        if ($_SESSION['userdetails'] != null) {
            $warehouse_id = $_POST['warehouse_id'];

            $warehouseModel = new WarehouseModel();
            $warehouseModel->delete_warehouse($warehouse_id);

            return redirect()->to(base_url('Master/warehouses'));
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }
}
