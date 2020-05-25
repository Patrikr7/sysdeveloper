<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Website extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model([
			'page_model' => 'pages'
		]);
	}

	public function index()
	{
		$dados = array(
			'title'   => 'INICIAL TEMPLATE',
			'description' => 'DESCRIPTION',
			'image' => 'site.jpg',
			'title_page' => getenv('SITE_NAME'),
			'message' => 'Aqui você encontra a página de teste!',
			'url' => ""
		);
		$this->template->load('site/template/template', 'home', $dados);
	}

	public function page($slug)
	{
		$pages = $this->pages->getPages();
		$page  = $this->pages->getPageUrl($slug);

		if($page):
			var_dump($page, base_url($slug));
			exit;
		endif;

		$dados = array(
			'title'   => 'Página de erro - 404',
			'description' => 'DESCRIPTION',
			'image' => SITE_IMG,
			'title_page' => 'Erro 404 - Página NÃO encontrada',
			'message' => 'Aqui você encontra a página 404!',
			'url' => $slug
		);

		$this->template->load('site/template/template', '404', $dados);
	}
}
