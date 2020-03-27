<?php

class Permissiongroups_model extends CI_Model
{
    protected $table = 'tb_permission_groups';

    public function __construct()
    {
        parent::__construct();
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

        if ($this->db->affected_rows() === 0 || $this->db->affected_rows() > 0):
            return true;
        else:
            return false;
        endif;
    }
}
