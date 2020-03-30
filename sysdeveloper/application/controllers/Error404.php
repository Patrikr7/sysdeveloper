<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Error404 extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
        $this->user->setLoggedUser();
	}

	public function index()
	{
		if($this->uri->segments[1] === 'admin'):
			
			$dados = [
				'title'   => 'Erro 404',
				'title_page' => 'Erro 404 - Página NÃO encontrada',
				'user' => $this->user->getUserId($this->session->userOnline['user_id'])
			];
			$this->template->load('admin/template/template', 'admin/404', $dados);

		else:
			echo 'página de erro SITE';
		endif;
	}
}
