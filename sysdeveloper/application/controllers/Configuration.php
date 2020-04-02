<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Configuration extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
        $this->user->isLogged();
        $this->user->setLoggedUser();
	}
	
	public function index()
	{
		$dados = [
			'title'   => 'Configuração',
			'title_page' => 'Configuração',
			'user' => $this->user->getUserId($this->session->userOnline['user_id']),
			'menuActive' => ["menuPage" => "config"]
		];
		$this->template->load('admin/template/template', 'admin/view/config/view-home', $dados);
	}
}
