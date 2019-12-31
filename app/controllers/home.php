<?php

class Home extends Controller
{
	public function index()
	{
		$this->view('customer/login');
	}

	public function store()
    {
        print_r($_POST);
    }

}
