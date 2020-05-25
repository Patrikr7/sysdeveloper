<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
<<<<<<< HEAD
		$this->user->isLogged();
		$this->user->setLoggedUser();
=======
        $this->user->isLogged();
        $this->user->setLoggedUser();
>>>>>>> 41a7919cd8349e392a820f468268b365283ca407
	}

	public function index()
	{
		$dados = [
			'title'   => 'Painel',
			'title_page' => 'Painel Administrativo - ' . getenv('SIS_TITLE'),
			'user' => $this->user->getUserId($this->session->userOnline['user_id']),
			'menuActive' => ["menuPage" => "dash"]
		];

		$this->template->load('admin/template/template', 'admin/home', $dados);
	}
}
