<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    private $userSession;
    private $UserInfo;

    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->user->isLogged();

        var_dump($this->user->getUsers(false, $this->session->userOnline['user_title_level'], $this->session->userOnline['user_id'])); die;
          
        $dados = [
			'title'   => 'Usuários',
			'title_page' => 'Usuários',
            'user' => $this->user->getUserId($this->session->userOnline['user_id']),
            'users' => $this->user->getUsers(false, $this->session->userOnline['user_title_level'], $this->session->userOnline['user_id']),
			'menuActive' => [
                "menuPage" => "UserActive",
                "subPage" => "UserHome"
            ]
        ];
        

		$this->template->load('admin/template/template', 'admin/view/user/view-home', $dados);
    }

    public function page_create()
    {
        $this->user->isLogged();
          
        $dados = [
			'title'   => 'Cadastrar Usuário',
			'title_page' => 'Cadastrar Usuário',
			'user' => $this->user->getUserId($this->session->userOnline['user_id']),
			'menuActive' => [
                "menuPage" => "UserActive",
                "subPage" => "UserCreate"
            ]
		];
		$this->template->load('admin/template/template', 'admin/view/user/view-create', $dados);
    }

    public function login()
    {
        //session_destroy();
        if (!empty($this->session->userOnline)) :
            redirect('admin', 'refresh');
            die;
        endif;

        $dados = [
            'title'   => 'Login',
            'title_page' => 'Login',
        ];

        $this->load->view('admin/login', $dados);
    }

    public function lockscreen()
    {
        //session_destroy();
        if (empty($this->session->userOnline)) :
            redirect('admin', 'refresh');
            die;

        elseif (isset($this->session->userOnline['user_level'])) :
            redirect('admin', 'refresh');
            die;
        endif;

        $dados = [
            'title'   => 'Tela Bloqueada',
            'title_page' => 'Tela Bloqueada',
        ];

        $this->load->view('admin/lockscreen', $dados);
    }

    public function access()
    {
        $json = [];
        $dados = $this->input->post();

        $User = $this->user->getLoginJoin($dados['user_login']);

        if ($this->form_validation->set_rules('user_login', 'Login', 'trim|required|min_length[3]')->run() === false) :
            $json["title"] = "CAMPO VAZIO";
            $json["error"] = validation_errors();

        elseif ($this->form_validation->set_rules('user_pass', 'Senha', 'trim|required|min_length[3]')->run() === false) :
            $json["title"] = "CAMPO VAZIO";
            $json["error"] = validation_errors();

        elseif (!$User) :
            $json["title"] = "Atenção!";
            $json["error"] = "Usuário não encontrado!";

        elseif (!password_verify($dados["user_pass"], $User->user_pass)) :
            $json["title"] = "Atenção!";
            $json["error"] = "Sua senha está incorreta!";

        elseif ($User->on_session && ($User->on_data_final > date('Y-m-d H:i:s'))) :
            $json["title"] = "Atenção!";
            $json["error"] = "Seu login está aberto em algum lugar. É você? Se não for, entre em contato urgente com o Suporte";

        elseif ($User->user_level == 2) :
            $json["title"] = "CONTA INATIVADA";
            $json["warning"] = "
                Olá <b>{$User->user_name}</b>, seu acesso ao sistema foi bloqueado! <br>
                Atenciosamente <b>" . TITLE_NAME . "</b>.
            ";

        else :
            $code = getCode(45);

            $data = [
                'on_agent' => $_SERVER['HTTP_USER_AGENT'],
                'on_ip' => $_SERVER['REMOTE_ADDR'],
                'on_online' => 1,
                'on_session' => $code,
                'on_data_final' => date('Y-m-d H:i:s', strtotime('+60 minute', strtotime(date('H:i:s')))),
                'on_id_user' => $User->user_id
            ];

            $this->user->updateOnline($data);

            $this->userSession = array();
            $this->userSession["user_name"] = $User->user_name;
            $this->userSession["user_img"] = $User->user_img;
            $this->userSession["user_status"] = $User->st_title;
            $this->userSession["user_title_level"] = $User->g_name;
            $this->userSession["user_level"] = $User->g_id;
            $this->userSession["user_id"] = $User->user_id;
            $this->userSession["on_session"] = $code;
            $_SESSION["userOnline"] = $this->userSession;

            $json["title"] = "Aguarde!";
            $json["success"] = "Você será redirecionado para o sistema.";
            $json["redirect"] = "../admin";

        endif;

        echo json_encode($json);
    }

    public function unlock()
    {
        $json = [];
        $dados = $this->input->post();

        $User = $this->user->getUserId($this->session->userOnline['user_id']);

        if ($this->form_validation->set_rules('user_pass', 'Senha', 'trim|required|min_length[3]')->run() === false) :
            $json["title"] = "CAMPO VAZIO";
            $json["error"] = validation_errors();

        elseif (!$User) :
            $json["title"] = "Atenção!";
            $json["error"] = "Usuário não encontrado!";

        elseif (!password_verify($dados["user_pass"], $User->user_pass)) :
            $json["title"] = "Atenção!";
            $json["error"] = "Sua senha está incorreta!";

        elseif ($User->user_level == 2) :
            $json["title"] = "CONTA INATIVADA";
            $json["warning"] = "
                Olá <b>{$User->user_name}</b>, seu acesso ao sistema foi bloqueado! <br>
                Atenciosamente <b>" . TITLE_NAME . "</b>.
            ";

        else :
            $code = getCode(45);

            $data = [
                'on_agent' => $_SERVER['HTTP_USER_AGENT'],
                'on_ip' => $_SERVER['REMOTE_ADDR'],
                'on_online' => 1,
                'on_session' => $code,
                'on_data_final' => date('Y-m-d H:i:s', strtotime('+60 minute', strtotime(date('H:i:s')))),
                'on_id_user' => $User->user_id
            ];

            $this->user->updateOnline($data);

            $this->userSession = array();
            $this->userSession["user_name"] = $User->user_name;
            $this->userSession["user_img"] = $User->user_img;
            $this->userSession["user_status"] = $User->st_title;
            $this->userSession["user_title_level"] = $User->g_name;
            $this->userSession["user_level"] = $User->g_id;
            $this->userSession["user_id"] = $User->user_id;
            $this->userSession["on_session"] = $code;
            $_SESSION["userOnline"] = $this->userSession;

            $json["title"] = "Aguarde!";
            $json["success"] = "Você será redirecionado para o sistema.";
            $json["redirect"] = "../admin";

        endif;

        echo json_encode($json);
    }

    public function reset()
    {
        unset($_SESSION["userOnline"]['user_level']);
        redirect('admin/lockscreen', 'refresh');
        die;
    }

    public function logout()
    {
        $dados = $this->input->post();

        $data = [
            'on_agent' => NULL,
            'on_ip' => NULL,
            'on_online' => 0,
            'on_session' => NULL,
            'on_data_final' => date('Y-m-d H:i:s'),
            'on_id_user' => $dados['id']
        ];

        if ($this->user->logout($data)) :
            $this->session->sess_destroy();
            $json["success"] = "Você foi deslogado com sucesso.";
            $json["redirect"] = "../admin";

        else :
            $json["title"] = "Atenção!";
            $json["error"] = "Erro ao sair do sistema. Entre em contato com o suporte!";

        endif;

        echo json_encode($json);
    }
}
