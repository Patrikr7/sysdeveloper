<?php

class User_model extends CI_Model
{
    protected $table = 'tb_user';
    private $userInfo;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['permission_model' => 'permission', 'permissiongroups_model' => 'pgroups']);
    }

    public function getUsers($level, $id)
    {
        if ($level === 'Admin Senior') :
            $this->db->select('u.user_id, u.user_name, u.user_img, u.user_email, u.user_status, u.user_level, u.user_url, g.*, s.*, o.on_id_user, o.on_online, o.on_data_final')
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
                ->order_by('u.user_name', 'ASC');
            return $this->db->get()->result_array();

        else :

        endif;
    }

    //BUSCA USER PELO NOME
    public function getUserName($name)
    {
        return $this->db->get_where($this->table, array('user_name' => $name));
    }

    //BUSCA USER PELO EMAIL
    public function getUserEmail($email)
    {
        return $this->db->get_where($this->table, array('user_email' => $email))->row_array();
    }

    //BUSCA USER PELA URI
    public function getUserUri($uri)
    {
        $query = $this->db->get_where($this->table, array('user_url' => $uri));
        return $query->row();
    }

    //CONFIGURA A URL
    public function getUserUrl($name, $id)
    {
        $url = slug($name);
        $array = [
            'user_url' => $url,
            'user_id !=' => $id,
        ];

        $query = $this->db->where($array)->get($this->table)->num_rows();

        if ($query > 0):
            return $url . '-' . $id;
        else:
            return $url;
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

    public function create($data)
    {
        $this->db->insert($this->table, $data);

        if ($this->db->insert_id()) :
            $dados = [
                'on_id'         => NULL,
                'on_id_user'    => $this->db->insert_id(),
                'on_agent'      => NULL,
                'on_data_final' => date('Y-m-d H:i:s'),
                'on_ip'         => NULL,
                'on_online'     => NULL,
                'on_session'    => NULL
            ];

            $this->insertOnline($dados);
            return true;

        else :
            return false;
        endif;
    }

    // INSERE USUARIO CADASTRADO NA tb_online
    public function insertOnline($data)
    {
        $this->db->insert('tb_online', $data);
    }

    public function update($data)
    {
        $this->db->where('user_id', $data['user_id']);
        unset($data['user_id']);
        $this->db->update($this->table, $data);

        if ($this->db->affected_rows() === 0 || $this->db->affected_rows() > 0):
            return true;
        else:
            return false;
        endif;
    }

    // CASO DE ERRO AO ATUALIZAR REGISTRO, SETA A IMAGEM COMO NULL NO BD
    public function updateImg($id)
    {        
        $this->db->set('user_img', NULL);
        $this->db->where('user_id', $id);
        $this->db->update($this->table);
    }

    // ATUALIZA TABELA ONLINE
    public function updateOnline($data)
    {
        $this->db->where('on_id_user', $data['on_id_user']);
        unset($data['on_id_user']);
        $this->db->update('tb_online', $data);
    }

    public function delete($id)
    {
        $this->db->delete($this->table, array('user_id' => $id));
        if ($this->db->affected_rows()):
            return true;
        else:
            return false;
        endif;
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
            $this->On_date_end($User->user_id, $User->on_data_final);
        }
    }

    public function setLoggedUser()
    {
        if (isset($this->session->userOnline['user_id']) && !empty($this->session->userOnline['user_id'])) :
            $id = $this->session->userOnline['user_id'];

            if ($this->getUserId($id)) :
                $this->userInfo = $this->getUserId($id);
                $this->pgroups->setGroup($this->userInfo->user_level);
            endif;
        endif;
    }

    public function hasPermission($name)
    {
        return $this->pgroups->hasPermission($name);
    }

    private function On_date_end($id, $date)
    {
        if ($date < date('Y-m-d H:i:s')) :
            $this->db->set('on_data_final', date('Y-m-d H:i:s', strtotime('+60 minute', strtotime(date('H:i:s')))));
            $this->db->where('on_id_user', $id);
            $this->db->update('tb_online');
        endif;
    }

    // METODO QUE VERIFICA A SESSÃO DO USUARIO PARA CADASTRAR NOVO USUARIO
    public function getLevelUser($level)
    {
        if ($level == "Admin Senior") :
            return $this->db->get('tb_permission_groups')->result_array();

        elseif ($level == "Administrador(a)") :
            $this->db->select('*')
                ->from('tb_permission_groups')
                ->where('g_name !=', 'Admin Senior');
            return $this->db->get()->result_array();

        elseif ($level == "Supervisor(a)") :
            $this->db->select('*')
                ->from('tb_permission_groups')
                ->where('g_name !=', 'Admin Senior')
                ->where('g_name !=', 'Administrador(a)')
                ->where('g_name !=', 'Supervidor(a)');
            return $this->db->get()->result_array();

        elseif ($level == "Gerente") :
            $this->db->select('*')
                ->from('tb_permission_groups')
                ->where('g_name !=', 'Admin Senior')
                ->where('g_name !=', 'Administrador(a)')
                ->where('g_name !=', 'Supervidor(a)')
                ->where('g_name !=', 'Gerente');
            return $this->db->get()->result_array();

        endif;
    }
}
