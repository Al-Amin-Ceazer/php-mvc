<?php

class Login extends Controller
{
	public function index()
	{
		$this->view('customer/login');
	}

	public function postLogin()
    {
        print_r($_POST);
    }

}
