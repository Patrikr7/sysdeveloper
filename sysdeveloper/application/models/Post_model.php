<?php

class Post_model extends CI_Model
{
    protected $table = 'tb_post';

    public function __construct()
    {
        parent::__construct();
    }

    public function getCount()
    {
        return $this->db->select('*')
            ->from($this->table)
            ->get()
            ->num_rows();
    }

    public function getPosts($limit, $start)
    {
        return $this->db->select('*')
            ->from($this->table)
            ->limit($limit, $start)
            ->get()
            ->result();
    }
}
