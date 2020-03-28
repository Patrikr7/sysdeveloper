<?php

class Permissiongroups_model extends CI_Model
{
    protected $table = 'tb_permission_groups';
    private $group;
    private $permission_array;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('permission_model', 'permission');
    }

    public function getGroup()
    {
        $this->db->select()
            ->from($this->table)
            ->order_by('g_name', 'ASC');
        return $this->db->get()->result_array();
    }

    public function getGroupId($id)
    {
        return $this->db->get_where($this->table, array('g_id' => $id))->row();
    }

    public function getGroupUrl($uri)
    {
        return $this->db->get_where($this->table, array('g_url' => $uri))->row();
    }

    public function getGroupName($name)
    {
        return $this->db->get_where($this->table, array('g_name' => $name))->row();
    }

    public function create($data)
    {
        $this->db->insert($this->table, $data);

        if ($this->db->insert_id()) :
            return true;
        else :
            return false;
        endif;
    }

    public function update($data)
    {
        $this->db->where('g_id', $data['g_id']);
        unset($data['g_id']);
        $this->db->update($this->table, $data);

        if ($this->db->affected_rows() === 0 || $this->db->affected_rows() > 0) :
            return true;
        else :
            return false;
        endif;
    }

    public function setGroup($g_id)
    {
        $this->permission_array = [];

        if ($this->getGroupId($g_id)) :
            $row = $this->getGroupId($g_id);

            if (empty($row->g_params)) :
                $row->g_params = '0';
            endif;

            $params = $row->g_params;
            $where_in = $this->permission->permission_where_in($params);

            if ($where_in) :
                foreach ($where_in as $item) :
                    $this->permission_array[] = $item['p_name'];
                endforeach;
            endif;
        endif;
    }

    public function hasPermission($name)
    {
        if (in_array($name, $this->permission_array)) :
            return true;
        else :
            return false;
        endif;
    }
}
