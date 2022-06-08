<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('welcome_message');
    }

    public function custom()
    {
        $employeeModel = model('App\Models\Employee', false);

        $row = $employeeModel->find(1);

        // var_dump($row);

        return view('custom_view', [ 'row' => $row ]);
    }
}
