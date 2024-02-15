<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\EmailModel;
use App\Models\HelperModel;
use App\Models\MasterModel;
use App\Models\PaymentsModel;
use App\Models\UsersModel;

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
}
