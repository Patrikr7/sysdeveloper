<?php

class User_model extends CI_Model
{
    protected $table = 'tb_user';

    public function __construct()
    {
        parent::__construct();
    }

    public function getUsers($uri = false, $level, $id)
    {
        if ($uri === false) :
            $query = $this->db->select('u.user_id, u.user_name, u.user_img, u.user_email, u.user_status, u.user_level, u.user_url, g.*, s.*, o.on_id_user, o.on_online, o.on_data_final')
                ->from($this->table . ' AS u')
                ->join('tb_permission_groups AS g', 'u.user_level = g.g_id', 'inner')
                ->join('tb_online AS o', 'u.user_id = o.on_id_user', 'inner')
                ->join('tb_status AS s', 'u.user_status = s.st_id', 'inner')
                ->where("g.g_name = 'Admin Senior' AND u.user_id = {$id}")
                ->or_where('g.g_name', 'Administrador(a)')
                ->or_where('g.g_name', 'Supervisor(a)')
                ->or_where('g.g_name', 'Gerente')
                ->or_where('g.g_name', 'Usuário')
                ->or_where('g.g_name', 'Editor(a)')
                ->or_where('g.g_name', 'Editor(a)')
                ->order_by('u.user_name', 'ASC');
            return $this->db->get()->result_array();

        else :
            $query = $this->db->get_where($this->table, array('user_url' => $uri));
            return $query->row();
        endif;
    }

    //BUSCA USUARIO PELO ID
    public function getUserId($id)
    {
        $this->db->select('u.*, o.*, s.*, g.*')
            ->from($this->table . ' AS u')
            ->where('u.user_id', $id)
            ->join('tb_permission_groups AS g', 'u.user_level = g.g_id', 'inner')
            ->join('tb_online AS o', 'u.user_id = o.on_id_user', 'inner')
            ->join('tb_status AS s', 'u.user_status = s.st_id', 'inner');
        return $this->db->get()->row();
    }

    // BUSCA PELO LOGIN
    public function getLoginJoin($login)
    {
        $this->db->select('u.*, o.*, s.*, g.*')
            ->from($this->table . ' AS u')
            ->where('u.user_login', $login)
            ->join('tb_permission_groups AS g', 'u.user_level = g.g_id', 'inner')
            ->join('tb_online AS o', 'u.user_id = o.on_id_user', 'inner')
            ->join('tb_status AS s', 'u.user_status = s.st_id', 'inner');
        return $this->db->get()->row();
    }

    // ATUALIZA TABELA ONLINE
    public function updateOnline($data)
    {
        $this->db->where('on_id_user', $data['on_id_user']);
        unset($data['on_id_user']);
        $this->db->update('tb_online', $data);
    }

    // ATUALIZA TABELA ONLINE
    public function logout($data)
    {
        $this->db->where('on_id_user', $data['on_id_user']);
        unset($data['on_id_user']);
        $this->db->update('tb_online', $data);

        if ($this->db->affected_rows() === 0 || $this->db->affected_rows() > 0) :
            return true;
        else :
            return false;
        endif;
    }

    // VERIFICA SE EXISTE A SESSAO
    public function isLogged()
    {
        $User = $this->getUserId($this->session->userOnline['user_id']);
        //var_dump($this->session->userOnline); die;

        if (empty($this->session->userOnline)) {
            redirect('admin/login', 'refresh');
            die;

            //VERIFICA SE A SESSAO NIVEL ESTA VAZIA
        } elseif (empty($this->session->userOnline['user_level'])) {
            redirect('admin/lockscreen', 'refresh');
            die;

            //VERIFICA SE O ONLINE ESTA 0
        } elseif (((int) $User->on_online === 0) || (empty($User->on_online))) {
            session_destroy();
            redirect('admin/login', 'refresh');
            die;

            // VERIFICA SE A SESSÃO É O MESMO DO BD
        } elseif ($this->session->userOnline['on_session'] != $User->on_session) {
            $data = [
                'on_agent' => NULL,
                'on_ip' => NULL,
                'on_online' => 0,
                'on_session' => NULL,
                'on_data_final' => date('Y-m-d H:i:s'),
                'on_id_user' => $User->user_id
            ];

            $this->updateOnline($data);

            session_destroy();
            redirect('admin/login', 'refresh');
            die;
        } else {
            //$this->On_date_end($User["user_id"], $User["on_data_final"]);
        }
    }

    // METODO QUE VERIFICA A SESSÃO DO USUARIO PARA CADASTRAR NOVO USUARIO
	public function getLevelUser($level){
        if($level == "Admin Senior"):
            return $this->db->get('tb_permission_groups')->result_array();

		elseif($level == "Administrador(a)"):
			//return Users::FullQuery("SELECT * FROM tb_permission_groups WHERE g_name != 'Admin Senior'");

		elseif($level == "Supervisor(a)"):
			//return Users::FullQuery("SELECT * FROM tb_permission_groups WHERE g_name != 'Admin Senior' AND g_name != 'Administrador(a)' AND g_name != 'Supervisor(a)'");

		elseif($level == "Gerente"):
			//return Users::FullQuery("SELECT * FROM tb_permission_groups WHERE g_name != 'Admin Senior' AND g_name != 'Administrador(a)' AND g_name != 'Supervisor(a)' AND g_name != 'Gerente'");

		endif;
	}
}
