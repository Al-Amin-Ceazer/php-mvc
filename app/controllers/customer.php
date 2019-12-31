<?php

class Customer extends Controller
{
	public function index()
	{
		$user = $this->model('User');
		print_r($user->getAllUsers());
		exit();
		$allusers = $user->getAllUsers();


		$this->view('home/index', ['allusers' => $allusers]);
	}

	public function store()
    {
        print_r($_POST);
    }

    public function create()
    {
        $this->view('customer/create');
    }

}
