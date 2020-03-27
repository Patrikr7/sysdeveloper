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
        //var_dump($uri, $level, $id);
        //die;
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

        /*
        SELECT u.user_id, u.user_name, u.user_img, u.user_email, u.user_status, u.user_level, u.user_url, g.*, s.*, o.on_id_user, o.on_online, o.on_data_final 
        FROM tb_user AS u 
        INNER JOIN tb_permission_groups AS g ON g.g_id = u.user_level 
        INNER JOIN tb_status AS s ON s.st_id = u.user_status 
        INNER JOIN tb_online AS o ON o.on_id_user = u.user_id 
        WHERE g.g_name = 'Administrador(a)' 
        OR g.g_name = 'Supervisor(a)' 
        OR g.g_name = 'Gerente' 
        OR g.g_name = 'Usuário' 
        OR g.g_name = 'Editor(a)' 
        OR (g.g_name = 'Admin Senior' AND u.user_id = 1) 
        ORDER BY user_name ASC
        */
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
}
