<?php

namespace App\Controllers;

use App\Models\HelperModel;

class Dashboard extends BaseController
{
    public $session;
    public function __construct()
    {
        $session = session();
    }

    public function index()
    {
        if (!isset($_SESSION['userdetails'])) {
			return redirect()->to(base_url());
		} else {
            $data['page_name'] = 'dashboard';

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            return view('loggedinuser/index.php', $data);
		}
    }
    public function version()
    {
        if (!isset($_SESSION['userdetails'])) {
			return redirect()->to(base_url());
		} else {
            $data['page_name'] = 'version';

            $helperModel = new HelperModel();
            $data['lookups'] = $helperModel->get_lookups();

            return view('loggedinuser/index.php', $data);
		}
    }
}