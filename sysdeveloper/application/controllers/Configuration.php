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
			'title_page' => 'Configuração - ' . getenv('SIS_TITLE'),
			'user' => $this->user->getUserId($this->session->userOnline['user_id']),
			'configs' => $this->configurations->getGroupConfigurations(),
			'menuActive' => ["menuPage" => "config"]
		];

		$this->template->load('admin/template/template', 'admin/view/config/view-home', $dados);
	}

	public function update()
	{
		$json = array();
		$dados = $this->input->post();

		if ($this->configurations->update($dados)) :
			$json["success"] = "Atualizado com Sucesso!";
		else :
			$json["error"] = "Erro ao atualizar. Entre em contato com suporte!";
		endif;

		echo json_encode($json);
	}
}
