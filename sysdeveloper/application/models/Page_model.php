<?php

class Page_model extends CI_Model
{
    protected $table = 'tb_page';

    public function __construct()
    {
        parent::__construct();
    }

    public function getPageParentNull($id = null)
    {
        if ($id === null) :
            $this->db->select('*')
                ->from($this->table)
                ->where('page_parent IS NULL OR page_parent = 0')
                ->order_by('page_title', 'ASC');
            return $this->db->get()->result_array();

        else :
            $this->db->select('*')
                ->from($this->table)
                ->where('page_id !=', $id)
                ->where('page_parent IS NULL OR page_parent = 0')
                ->order_by('page_title', 'ASC');
            return $this->db->get()->result_array();

        endif;
    }

    public function getPageUrl($uri)
    {
        return $this->db->get_where($this->table, array('page_url' => $uri))->row();
    }

    // PESQUISA SE EXITE PAGINA COMO FILHA CADASTRADA
    public function getSubPages($page_id)
    {
        $this->db->select()
            ->from($this->table)
            ->where('page_parent', $page_id)
            ->order_by('page_title', 'ASC');
        return $this->db->get()->result_array();
    }

    public function getTitle($title)
    {
        return $this->db->get_where($this->table, array('page_title' => $title))->row();
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
        if ($this->user->hasPermission('update_page1')) :
            $this->db->where('page_id', $data['page_id']);
            unset($data['page_id']);
            $this->db->update($this->table, $data);

            if ($this->db->affected_rows() === 0 || $this->db->affected_rows() === 1) :
                return true;
            else :
                return false;
            endif;

        else :
            return 'denied';

        endif;
    }
}
