<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Test_model extends CI_Model {


    public $json_obj;
    public $dt;

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }

    public function insert_entry($json_str)
    {
        $this->json_obj    = $json_str;
        $this->dt     = date ("Y-m-d H:i:s", time());
        $this->db->insert('test_table', $this);
    }

    public function get_entry()
    {
        $query = $this->db->query("SELECT id,json_obj, dt FROM test_table ORDER BY id DESC LIMIT 1");
        return $query->result();
    }


}