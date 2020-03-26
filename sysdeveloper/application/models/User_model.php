<?php

class User_model extends CI_Model
{
    protected $table = 'tb_user';

    public function __construct()
    {
        parent::__construct();
    }

    public function getUsers($uri = false)
    {
        if ($uri === false) :
            $query = $this->db->get($this->table);
            return $query->result_array();
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

        if ($this->db->affected_rows() === 0 || $this->db->affected_rows() > 0):
            return true;
        else:
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
