<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->user->isLogged();
	}
	
	public function index()
	{
		$dados = [
			'title'   => 'Painel',
			'title_page' => 'Painel Administrativo',
			'user' => $this->user->getUserId($this->session->userOnline['user_id']),
			'menuActive' => ["menuPage" => "dash"]
		];
		$this->template->load('admin/template/template', 'admin/home', $dados);
	}
}
