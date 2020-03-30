<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Permission extends CI_Controller
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

	public function index()
	{
		if ($this->user->hasPermission('view_permission')) :
			$dados = [
				'title'   => 'Permissão',
				'title_page' => 'Permissão',
				'user' => $this->user->getUserId($this->session->userOnline['user_id']),
				'g_permission' => $this->pgroups->getGroup(),
				'permission' => $this->permission->getPermission(),
				'menuActive' => ["menuPage" => "PermissionsActive"]
			];
			$this->template->load('admin/template/template', 'admin/view/permission/view-permissions', $dados);

		else :
			redirect('admin/nopermission', 'refresh');
			die;

		endif;
	}

	public function nopermission()
	{
		$dados = [
			'title'   => 'Acesso negado',
			'title_page' => 'Acesso negado!',
			'user' => $this->user->getUserId($this->session->userOnline['user_id'])
		];
		$this->template->load('admin/template/template', 'admin/noPermission', $dados);
	}

	public function page_create()
	{
		if ($this->user->hasPermission('create_permission')) :
			$dados = [
				'title'   => 'Cadastrar Permissão',
				'title_page' => 'Cadastrar Permissão',
				'user' => $this->user->getUserId($this->session->userOnline['user_id']),
				'menuActive' => ["menuPage" => "PermissionsActive"]
			];
			$this->template->load('admin/template/template', 'admin/view/permission/view-permission', $dados);

		else :
			redirect('admin/nopermission', 'refresh');
			die;

		endif;
	}

	public function page_update()
	{
		if ($this->user->hasPermission('update_permission')) :
			$dados = [
				'title'   => 'Atualizar Permissão',
				'title_page' => 'Atualizar Permissão',
				'user' => $this->user->getUserId($this->session->userOnline['user_id']),
				'permission' => $this->permission->getPermissionUrl($this->uri->segment(4)),
				'menuActive' => ["menuPage" => "PermissionsActive"]
			];
			$this->template->load('admin/template/template', 'admin/view/permission/view-permission-update', $dados);

		else :
			redirect('admin/nopermission', 'refresh');
			die;

		endif;		
	}

	public function create()
	{
		$json = [];
		$dados = $this->input->post();

		if ($this->form_validation->set_rules('p_name', 'Nome da Permissão', 'trim|required|min_length[3]')->run() === false) :
			$json["error"] = validation_errors();

		elseif ($this->permission->getPermissionName($dados['p_name'])) :
			$json["error"] = 'Está permissão já existe';

		else :
			$dados["p_url"] = slug($dados["p_name"]);

			if ($this->permission->create($dados)) :
				$json["success"] = "<strong>" . $dados["p_name"] . "</strong>, cadastrado com sucesso!";
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

		$name = $this->permission->getPermissionName($dados['p_name']);

		if ($this->form_validation->set_rules('p_name', 'Nome da Permissão', 'trim|required|min_length[3]')->run() === false) :
			$json["error"] = validation_errors();

		elseif ($name && ($name->p_id != $dados['p_id'])) :
			$json["error"] = 'Está permissão já existe';

		else :
			$dados["p_url"] = slug($dados["p_name"]);

			if ($this->permission->update($dados)) :
				$json["success"] = "<strong>" . $dados["p_name"] . "</strong>, atualizado com sucesso!";
				$json["redirect"] = "../../permissions";

			else :
				$json["error"] = "Erro ao atualizar. Entre com contato com suporte!";

			endif;

		endif;

		echo json_encode($json);
	}
}
