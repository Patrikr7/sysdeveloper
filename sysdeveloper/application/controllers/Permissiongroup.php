<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Permissiongroup extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->user->isLogged();
		$this->user->setLoggedUser();
		$this->load->model([
			'permission_model' => 'permission',
			'permissiongroups_model' => 'pgroups'
		]);
	}

	public function page_create()
	{
		$dados = [
			'title'   => 'Cadastrar Grupo de Permissão',
<<<<<<< HEAD
			'title_page' => 'Cadastrar Grupo de Permissão - ' . getenv('SIS_TITLE'),	
=======
			'title_page' => 'Cadastrar Grupo de Permissão',
>>>>>>> 41a7919cd8349e392a820f468268b365283ca407
			'user' => $this->user->getUserId($this->session->userOnline['user_id']),
			'permissions' => $this->permission->getPermission(),
			'menuActive' => ["menuPage" => "PermissionsActive"]
		];
		$this->template->load('admin/template/template', 'admin/view/permission/view-group', $dados);
	}

	public function page_update()
	{
		if ($this->pgroups->getGroupUrl($this->uri->segment(4))) :
			$dados = [
				'title'   => 'Atualizar Grupo de Permissão',
<<<<<<< HEAD
				'title_page' => 'Atualizar Grupo de Permissão - ' . getenv('SIS_TITLE'),	
=======
				'title_page' => 'Atualizar Grupo de Permissão',
>>>>>>> 41a7919cd8349e392a820f468268b365283ca407
				'user' => $this->user->getUserId($this->session->userOnline['user_id']),
				'permissions' => $this->permission->getPermission(),
				'pgroups' => $this->pgroups->getGroupUrl($this->uri->segment(4)),
				'menuActive' => ["menuPage" => "PermissionsActive"]
			];
			$this->template->load('admin/template/template', 'admin/view/permission/view-group-update', $dados);
		else :

		endif;
	}

	public function create()
	{
		$json = [];
		$dados = $this->input->post();

		if (!empty($dados["g_check"]) && isset($dados["g_check"])) :
			$check = $dados["g_check"];
			unset($dados["g_check"]);
		endif;

		if ($this->form_validation->set_rules('g_name', 'Nome do Grupo', 'trim|required|min_length[3]')->run() === false) :
			$json["error"] = validation_errors();

		elseif ($this->form_validation->set_rules('g_check[]', 'Permissões', 'trim|required')->run() === false) :
			$json["error"] = validation_errors();

		elseif ($this->pgroups->getGroupName($dados['g_name'])) :
			$json["error"] = 'Este Grupo já existe!';

		else :
			$dados["g_params"] = implode(',', $check);
			$dados["g_url"] = slug($dados["g_name"]);

			if ($this->pgroups->create($dados)) :
				$json["success"] = "<strong>" . $dados["g_name"] . "</strong>, cadastrado com sucesso!";
				$json["redirect"] = "../permissions";

			else :
				$json["error"] = "Erro ao cadastrar. Entre com contato com suporte!";

			endif;

		endif;

		echo json_encode($json);
	}

	public function update()
	{
		$json = [];
		$dados = $this->input->post();

		if (!empty($dados["g_check"]) && isset($dados["g_check"])) :
			$check = $dados["g_check"];
			unset($dados["g_check"]);
		endif;

		$name = $this->pgroups->getGroupName($dados['g_name']);

		if ($this->form_validation->set_rules('g_name', 'Nome do Grupo', 'trim|required|min_length[3]')->run() === false) :
			$json["error"] = validation_errors();

		elseif ($this->form_validation->set_rules('g_check[]', 'Permissões', 'trim|required')->run() === false) :
			$json["error"] = validation_errors();

		elseif ($name && ($name->g_id != $dados['g_id'])) :
			$json["error"] = 'Este Grupo já existe!';

		else :
			$dados["g_params"] = implode(',', $check);
			$dados["g_url"] = slug($dados["g_name"]);

			if ($this->pgroups->update($dados)) :
				$json["success"] = "<strong>" . $dados["g_name"] . "</strong>, atualizado com sucesso!";
				$json["redirect"] = "../../permissions";

			else :
				$json["error"] = "Erro ao ataulizar. Entre com contato com suporte!";

			endif;

		endif;

		echo json_encode($json);
	}
}
