<?php

class Permission_model extends CI_Model
{
    protected $table = 'tb_permission';

    public function __construct()
    {
        parent::__construct();
    }

    public function getPermission()
    {
        $this->db->select()
            ->from($this->table)
            ->order_by('p_name', 'ASC');
        return $this->db->get()->result_array();
    }

    public function getPermissionId($id)
    {
        return $this->db->get_where($this->table, array('p_id' => $id))->row();
    }

    public function getPermissionUrl($uri)
    {
        return $this->db->get_where($this->table, array('p_url' => $uri))->row();
    }

    public function getPermissionName($name)
    {
        return $this->db->get_where($this->table, array('p_name' => $name))->row();
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
        $this->db->where('p_id', $data['p_id']);
        unset($data['p_id']);
        $this->db->update($this->table, $data);

        if ($this->db->affected_rows() === 0 || $this->db->affected_rows() > 0):
            return true;
        else:
            return false;
        endif;
    }
}
