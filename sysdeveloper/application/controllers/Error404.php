<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Error404 extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if($this->uri->segments[1] === 'admin'):
			$this->user->setLoggedUser();
			$this->user->isLogged();
			
			$dados = [
				'title'   => 'Erro 404',
				'title_page' => 'Erro 404 - Página NÃO encontrada',
				'user' => $this->user->getUserId($this->session->userOnline['user_id'])
			];
			$this->template->load('admin/template/template', 'admin/404', $dados);

		else:
			$dados = array(
				'title'   => 'Página de erro - 404',
				'description' => 'DESCRIPTION',
				'image' => 'site.jpg',
				'title_page' => 'Erro 404 - Página NÃO encontrada',
				'message' => 'Aqui você encontra a página 404!',
				'url' => ""
			);

			$this->template->load('site/template/template', '404', $dados);
			
		endif;
	}
}
