<?php
namespace App\Admin\Controllers;


class HomeController
{
    public function index()
    {
        return view('admin.home.index');
    }
}