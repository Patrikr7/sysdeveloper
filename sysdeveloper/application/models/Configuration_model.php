<?php

class Configuration_model extends CI_Model
{
    protected $table = 'tb_config';

    public function __construct()
    {
        parent::__construct();
    }

    public function getConfigurations()
    {
        $this->db->select()
            ->from($this->table)
            ->order_by('conf_type', 'ASC');
        return $this->db->get()->result_array();
    }

    public function getConfigurationsTypes($conf_type)
    {
        return $this->db->select('*')
            ->from($this->table)
            ->where('conf_type', $conf_type)
            ->get()->result_array();
    }

    public function getConfigurationsValue($conf_key)
    {
        $value = $this->db
            ->get_where($this->table, array(
                'conf_key' => $conf_key
            ))->row();

        return $value->conf_value;
    }

    public function getGroupConfigurations()
    {
        $this->db->select('conf_type')->from($this->table);

        if ($this->session->userOnline['user_title_level'] !== "Admin Senior") :
            $this->db->where('conf_type !=', 'ADMIN_SENIOR');
        endif;

        $this->db->group_by('conf_type', 'ASC');

        return $this->db->get()->result_array();
    }

    public function update($data)
    {
        $this->db->where('conf_id', $data['conf_id']);
        unset($data['conf_id']);
        $this->db->update($this->table, $data);

        if ($this->db->affected_rows() === 0 || $this->db->affected_rows() > 0):
            $this->setEnv();
            return true;
        else:
            return false;
        endif;
    }

    public function setEnv()
    {
        $row = '';
        foreach ($this->getConfigurations() as $conf) :
            $row .= $this->CreateRow($conf['conf_key'] . '="' . $conf['conf_value'] . '"');
        endforeach;

        $file = fopen(FCPATH . "dotenv/.env", "w");
        fwrite($file, $row);
        fclose($file);
    }

    private function CreateRow($row)
    {
        return $row . PHP_EOL;
    }
}
