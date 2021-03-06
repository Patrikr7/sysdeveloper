<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    private $userSession;
    private $UserInfo;

    function __construct()
    {
        parent::__construct();
        $this->user->setLoggedUser();
        $this->load->model(['email_model' => 'email']);
        $this->load->library('upload', config_upload('./assets/uploads/', 'jpg|png', 1500, 'users'));
    }

    public function index()
    {
        $this->user->isLogged();

        if ($this->user->hasPermission('view_user')) :
            $dados = [
                'title'      => 'Usuários',
                'title_page' => 'Usuários - ' . getenv('SIS_TITLE'),
                'user'       => $this->user->getUserId($this->session->userOnline['user_id']),
                'users'      => $this->user->getUsers($this->session->userOnline['user_title_level'], $this->session->userOnline['user_id']),
                'menuActive' => [
                    "menuPage" => "UserActive",
                    "subPage" => "UserHome"
                ]
            ];

            $this->template->load('admin/template/template', 'admin/view/user/view-home', $dados);

        else :
            redirect('admin/nopermission', 'refresh');
            die;

        endif;
    }

    public function page_create()
    {
        $this->user->isLogged();

        if ($this->user->hasPermission('create_user')) :
            $dados = [
                'title'      => 'Cadastrar Usuário',
                'title_page' => 'Cadastrar Usuário - ' . getenv('SIS_TITLE'),
                'user'       => $this->user->getUserId($this->session->userOnline['user_id']),
                'level'      => $this->user->getLevelUser($this->session->userOnline["user_title_level"]),
                'status'     => getStatus(),
                'menuActive' => [
                    "menuPage" => "UserActive",
                    "subPage" => "UserCreate"
                ]
            ];
            $this->template->load('admin/template/template', 'admin/view/user/view-create', $dados);

        else :
            redirect('admin/nopermission', 'refresh');
            die;

        endif;
    }

    public function page_update()
    {
        $this->user->isLogged();

        if (!$this->user->hasPermission('update_user')) :
            redirect('admin/nopermission', 'refresh');
            die;

        elseif ($this->user->getUserUri($this->uri->segments[4])) :
            $dados = [
                'title'      => 'Atualizar Usuário',
                'title_page' => 'Atualizar Usuário - ' . getenv('SIS_TITLE'),
                'user'       => $this->user->getUserId($this->session->userOnline['user_id']),
                'level'      => $this->user->getLevelUser($this->session->userOnline["user_title_level"]),
                'status'     => getStatus(),
                'user_url'   => $this->user->getUserUri($this->uri->segments[4]),
                'menuActive' => [
                    "menuPage" => "UserActive"
                ]
            ];
            $this->template->load('admin/template/template', 'admin/view/user/view-update', $dados);

        else :
            $dados = [
                'title'      => 'Erro 404',
                'title_page' => 'Erro 404 - Página NÃO encontrada',
                'user' => $this->user->getUserId($this->session->userOnline['user_id'])
            ];
            $this->template->load('admin/template/template', 'admin/404', $dados);

        endif;
    }

    public function create()
    {
        $json = [];
        $dados = $this->input->post();

        if ($this->form_validation->set_rules('user_name', 'Nome', 'trim|required|min_length[5]|alpha_numeric_spaces')->run() === false) :
            $json['error'] = validation_errors();
            $json['focus'] = 'user_name';

        elseif ($this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email|is_unique[tb_user.user_email]')->run() === false) :
            $json['error'] = validation_errors();
            $json['focus'] = 'user_email';

        elseif ($this->form_validation->set_rules('user_login', 'Login', 'trim|required|min_length[3]|max_length[12]|is_unique[tb_user.user_login]')->run() === false) :
            $json['error'] = validation_errors();
            $json['focus'] = 'user_login';

        elseif ($this->form_validation->set_rules('user_pass', 'Senha', 'trim|required|min_length[6]|max_length[12]|callback_validator_password')->run() === false) :
            $json['error'] = validation_errors();
            $json['focus'] = 'user_pass';

        elseif ($this->form_validation->set_rules('user_cpass', 'Confirmar Senha', 'trim|required|min_length[6]|max_length[12]|matches[user_pass]')->run() === false) :
            $json['error'] = validation_errors();
            $json['focus'] = 'user_cpass';

        elseif ($this->form_validation->set_rules('user_status', 'Status', 'trim|required')->run() === false) :
            $json['error'] = validation_errors();
            $json['focus'] = 'user_status';

        elseif ($this->form_validation->set_rules('user_level', 'Nível de Acesso', 'trim|required')->run() === false) :
            $json['error'] = validation_errors();
            $json['focus'] = 'user_level';

        elseif (empty($_FILES["user_img"]["name"])) :
            $url = slug($dados['user_name']);
            if ($this->user->getUserName($dados['user_name'])->num_rows() >= 1) :
                $url .= '-' . $this->user->getUserName($dados['user_name'])->num_rows();
            endif;

            $dados['user_img'] = NULL;
            $dados['user_url'] = $url;
            $dados["user_pass"] = password_hash($dados["user_pass"], PASSWORD_BCRYPT);
            $dados["user_cpass"] = $dados['user_pass'];
            $dados["user_uuid"] = $this->uuid->v4();

            if ($this->user->create($dados)) :

                $json['success'] = 'Cadastro realizado com sucesso!';
                $json['redirect'] = '../users';

            else :
                $json['error'] = 'Erro ao efetuar o cadastro, entre em contato com o suporte!';

            endif;

        else :
            $url = slug($dados['user_name']);
            if ($this->user->getUserName($dados['user_name'])->num_rows() >= 1) :
                $url .= '-' . $this->user->getUserName($dados['user_name'])->num_rows();
            endif;

            if (!is_dir(FCPATH . 'assets/uploads/users')) :
                mkdir(FCPATH . 'assets/uploads/users');
            endif;

            if (file_exists(FCPATH . 'assets/uploads/users/' . $_FILES['user_img']['name'])) :
                $json['error'] = 'A imagem <strong>' . $_FILES['user_img']['name'] . '</strong> já existe!';

            elseif ($this->upload->do_upload('user_img')) :
                $dados_upload = $this->upload->data();

                // FAZ O CROP DA IMAGEM
                $imageSize = $this->image_lib->get_image_properties(FCPATH . '/assets/uploads/users/' . $dados_upload['file_name'], TRUE);
                $this->image_lib->initialize(config_crop(FCPATH . 'assets/uploads/users/', $dados_upload['file_name'], 500, 500, $imageSize));

                if (!$this->image_lib->crop()) :
                    // DELETA A IMAGEM
                    unlink('./assets/uploads/users/' . $dados_upload['file_name']);
                    $json['error'] = $this->image_lib->display_errors();

                else :
                    $this->image_lib->clear();

                    $dados['user_img'] = $url . $dados_upload['file_ext'];
                    $dados['user_url'] = $url;
                    $dados["user_pass"] = password_hash($dados["user_pass"], PASSWORD_BCRYPT);
                    $dados["user_cpass"] = $dados['user_pass'];
                    $dados["user_uuid"] = $this->uuid->v4();

                    if ($this->user->create($dados)) :
                        // RENOMEIA A IMAGEM DENTRO DA PASTA
                        rename($dados_upload['full_path'], $dados_upload['file_path'] . $url . $dados_upload['file_ext']);

                        $json['success'] = 'Cadastro realizado com sucesso!';
                        $json['redirect'] = '../users';

                    else :
                        // DELETA A IMAGEM EM CASO DE ERRO
                        unlink($dados_upload['full_path']);
                        $json['error'] = 'Erro ao efetuar o cadastro, entre em contato com o suporte!';

                    endif;

                endif;

            else :
                $json['error'] = $this->upload->display_errors();

            endif;

        endif;

        echo json_encode($json);
    }

    public function update()
    {
        $json = [];
        $dados = $this->input->post();

        $id = $this->user->getUserId($dados['user_id']);
        $url = $this->user->getUserUrl($dados['user_name'], $dados['user_id']);

        if ($this->form_validation->set_rules('user_name', 'Nome', 'trim|required|min_length[5]|alpha_numeric_spaces')->run() === false) :
            $json['error'] = validation_errors();
            $json['focus'] = 'user_name';

        elseif ($this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email')->run() === false) :
            $json['error'] = validation_errors();
            $json['focus'] = 'user_email';

        elseif ($this->getEmail($dados['user_id'], $dados['user_email'])) :
            $json["error"] = 'O email <strong>' . $dados['user_email'] . '</strong> já existe';
            $json['focus'] = 'user_email';

        elseif ($this->form_validation->set_rules('user_login', 'Login', 'trim|required|min_length[3]')->run() === false) :
            $json['error'] = validation_errors();
            $json['focus'] = 'user_login';

        elseif ($this->getLogin($dados['user_id'], $dados['user_login'])) :
            $json["error"] = 'O login <strong>' . $dados['user_login'] . '</strong> já existe';
            $json['focus'] = 'user_login';

        elseif (!empty($dados['user_pass']) && $this->form_validation->set_rules('user_pass', 'Senha', 'trim|required|min_length[6]|max_length[12]|callback_validator_password')->run() === false) :
            $json['error'] = validation_errors();
            $json['focus'] = 'user_pass';

        elseif (!empty($dados['user_pass']) && $this->form_validation->set_rules('user_cpass', 'Confirmar Senha', 'trim|required|min_length[6]|max_length[12]|matches[user_pass]')->run() === false) :
            $json['error'] = validation_errors();
            $json['focus'] = 'user_cpass';

        elseif ($this->form_validation->set_rules('user_status', 'Status', 'trim|required')->run() === false) :
            $json['error'] = validation_errors();
            $json['focus'] = 'user_status';

        elseif ($this->form_validation->set_rules('user_level', 'Nível de Acesso', 'trim|required')->run() === false) :
            $json['error'] = validation_errors();
            $json['focus'] = 'user_level';

        elseif (empty($_FILES["user_img"]["name"])) :

            if (!empty($id->user_img)) :
                list($txt, $ext) = explode('.', $id->user_img);
                $img = $url . '.' . $ext;
            else :
                $img = null;
            endif;

            $dados['user_img'] = $img;
            $dados['user_url'] = $url;

            if (!empty($dados['user_pass'])) :
                $dados["user_pass"] = password_hash($dados["user_pass"], PASSWORD_BCRYPT);
                $dados["user_cpass"] = $dados['user_pass'];
            else :
                unset($dados["user_pass"], $dados["user_cpass"]);
            endif;

            $dados["user_uuid"] = $this->uuid->v4();

            if ($this->user->update($dados)) :

                // RENOMEIA A IMAGEM DENTRO DA PASTA
                if (!empty($id->user_img)) :
                    rename('./assets/uploads/users/' . $id->user_img, './assets/uploads/users/' . $img);
                endif;

                $json['success'] = 'Registro atualizado com sucesso!';
                $json['redirect'] = '../../users';

            else :
                $json['error'] = 'Erro ao atualizar registro, entre em contato com o suporte!';

            endif;

        else :

            if (file_exists(FCPATH . 'assets/uploads/users/' . $_FILES['user_img']['name'])) :
                $json['error'] = 'A imagem <strong>' . $_FILES['user_img']['name'] . '</strong> já existe!';

            elseif ($this->upload->do_upload('user_img')) :
                $dados_upload = $this->upload->data();

                // FAZ O CROP DA IMAGEM
                $imageSize = $this->image_lib->get_image_properties(FCPATH . '/assets/uploads/users/' . $dados_upload['file_name'], TRUE);
                $this->image_lib->initialize(config_crop(FCPATH . 'assets/uploads/users/', $dados_upload['file_name'], 500, 500, $imageSize));

                if (!$this->image_lib->crop()) :
                    // DELETA A IMAGEM
                    unlink('./assets/uploads/users/' . $dados_upload['file_name']);
                    $json['error'] = $this->image_lib->display_errors();

                else :
                    $this->image_lib->clear();
                    if (file_exists(FCPATH . 'assets/uploads/users/' . $id->user_img)) :
                        // DELETA A IMAGEM ANTIGA
                        unlink(FCPATH . 'assets/uploads/users/' . $id->user_img);
                    endif;

                    $dados['user_img'] = $url . $dados_upload['file_ext'];
                    $dados['user_url'] = $url;

                    if (!empty($dados['user_pass'])) :
                        $dados["user_pass"] = password_hash($dados["user_pass"], PASSWORD_BCRYPT);
                        $dados["user_cpass"] = $dados['user_pass'];
                    else :
                        unset($dados["user_pass"], $dados["user_cpass"]);
                    endif;

                    $dados["user_uuid"] = $this->uuid->v4();

                    if ($this->user->update($dados)) :
                        // RENOMEIA A IMAGEM DENTRO DA PASTA
                        rename($dados_upload['full_path'], $dados_upload['file_path'] . $url . $dados_upload['file_ext']);

                        $json['success'] = 'Registro atualizado com sucesso!';
                        $json['redirect'] = '../../users';

                    else :
                        // DELETA A IMAGEM EM CASO DE ERRO
                        unlink($dados_upload['full_path']);
                        $this->user->updateImg($dados['user_id']);
                        $json['error'] = 'Erro ao efetuar o cadastro, entre em contato com o suporte!';

                    endif;

                endif;

            else :
                $json['error'] = $this->upload->display_errors();

            endif;

        endif;

        echo json_encode($json);
    }

    // VERIFICA SE JÁ EXISTE O MESMO LOGIN
    public function getLogin($user_id, $user_login)
    {
        $login = $this->user->getLoginJoin($user_login);

        if ($login && ($user_id !== $login->user_id)) :
            return true;
        endif;
    }

    // VERIFICA SE JÁ EXISTE O MESMO EMAIL 
    public function getEmail($user_id, $user_email)
    {
        $email = $this->user->getUserEmail($user_email);

        if ($email && ($user_id !== $email['user_id'])) :
            return true;
        endif;
    }

    public function delete()
    {
        $json = [];
        $dados = $this->input->post();
        $user = $this->user->getUserId($dados['id']);

        if (!$user) :
            $json['error'] = 'Oppss! você tentou remover um usuário que não existe!';
            $json['type'] = "warning";

        elseif ($this->user->delete(intval($dados['id']))) :
            if (!empty($user->user_img)) :
                unlink(FCPATH . 'assets/uploads/users/' . $user->user_img);
            endif;
            $json['success'] = "Usuário deletado com sucesso!";

        else :
            $json['error'] = "Erro ao deletar a usuário, entre em contato com suporte!";
            $json['type'] = 'warning';

        endif;

        echo json_encode($json);
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
            'title_page' => 'Login - ' . getenv('SIS_TITLE'),
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
            'title_page' => 'Tela Bloqueada - ' . getenv('SIS_TITLE'),
        ];

        $this->load->view('admin/lockscreen', $dados);
    }

    public function forgot_password()
    {
        $dados = [
            'title'   => 'Recuperar Senha',
            'title_page' => 'Recuperar Senha - ' . getenv('SIS_TITLE'),
        ];

        $this->load->view('admin/forgot-password', $dados);
    }

    public function redefine_password($uuid)
    {
        if ($this->user->getUuid($uuid)) :
            $dados = [
                'title'   => 'Redefina sua Senha',
                'title_page' => 'Redefina sua Senha - ' . getenv('SIS_TITLE'),
                'user' => $this->user->getUuid($uuid)
            ];

            $this->load->view('admin/redefine-password', $dados);

        else :
            redirect('admin/login');
            die;
        endif;
    }

    public function forgot_password_send()
    {
        $json = [];
        $dados = $this->input->post();

        if (!$email = $this->user->getUserEmail($dados['user_email'])) :
            $json['error'] = 'Email não encontrado!';

        elseif ($this->email->ForgotPassword($email)) :
            $json["success"] = "<strong>{$email['user_name']}</strong>, em alguns minutos olhe sua caixa de entrada e procure por [Redefinir Senha].";
            $json["redirect"] = "login";

        else :
            $json["error"] = $this->email->ForgotPassword($email);

        endif;

        echo json_encode($json);
    }

    public function redefine_password_send()
    {
        $json = [];
        $dados = $this->input->post();

        $user_pass = password_hash($dados["user_pass"], PASSWORD_BCRYPT);

        if (!$user = $this->user->getUserId($dados['user_id'])) :
            $json['error'] = 'Usuário não encontrado!';

        elseif ($this->form_validation->set_rules('user_pass', 'Senha', 'trim|required|min_length[6]|max_length[12]|callback_validator_password')->run() === false) :
            $json['error'] = validation_errors();

        elseif ($this->form_validation->set_rules('user_cpass', 'Confirmar Senha', 'trim|required|min_length[6]|max_length[12]|matches[user_pass]')->run() === false) :
            $json['error'] = validation_errors();


        elseif ($this->email->RedefinePassword($user, $user_pass)) :
            $json["success"] = "<strong>{$user->user_name}</strong>, em alguns minutos olhe sua caixa de entrada e procure por [Redefinir Senha].";
            $json["redirect"] = "login";

        else :
            $json["error"] = $this->email->RedefinePassword($user, $user_pass);

        endif;

        echo json_encode($json);
    }

    public function access()
    {
        $json = [];
        $dados = $this->input->post();

        $User = $this->user->getLoginJoin($dados['user_login']);

        if ($this->form_validation->set_rules('user_login', 'Login', 'trim|required|min_length[3]')->run() === false) :
            $json["title"] = "CAMPO VAZIO";
            $json['error'] = validation_errors();

        elseif ($this->form_validation->set_rules('user_pass', 'Senha', 'trim|required|min_length[3]')->run() === false) :
            $json["title"] = "CAMPO VAZIO";
            $json['error'] = validation_errors();

        elseif (!$User) :
            $json["title"] = "Atenção!";
            $json['error'] = "Usuário não encontrado!";

        elseif (!password_verify($dados["user_pass"], $User->user_pass)) :
            $json["title"] = "Atenção!";
            $json['error'] = "Sua senha está incorreta!";

        elseif ($User->on_session && ($User->on_data_final > date('Y-m-d H:i:s'))) :
            $json["title"] = "Atenção!";
            $json['error'] = "Seu login está aberto em algum lugar. É você? Se não for, entre em contato urgente com o Suporte";

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
            $json['error'] = validation_errors();

        elseif (!$User) :
            $json["title"] = "Atenção!";
            $json['error'] = "Usuário não encontrado!";

        elseif (!password_verify($dados["user_pass"], $User->user_pass)) :
            $json["title"] = "Atenção!";
            $json['error'] = "Sua senha está incorreta!";

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
            $json['error'] = "Erro ao sair do sistema. Entre em contato com o suporte!";

        endif;

        echo json_encode($json);
    }

    // CALLBACK VALIDA SENHA
    public function validator_password($pass)
    {
        if (PasswordRegex($pass)) :
            return true;
        else :
            $this->form_validation->set_message('validator_password', 'Senha deve conter: Letra maiúscula, minúscula, numéro e caracteres especiais!');
            return false;
        endif;
    }
}
