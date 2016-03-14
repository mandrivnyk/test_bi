<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {



    public $dir= './uploads/';

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
    }


    public function index()
    {
        $this->load->view('/test/head');
        $this->load->view('/test/upload_form', array('error' => ' '));
        $this->load->view('/test/foot');
    }

    public function do_upload()
    {
        $config['upload_path']          = $this->getDir();
        $config['allowed_types']        = 'txt';
        $config['max_size']             = 1000;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('userfile'))
        {
            $error = array('error' => $this->upload->display_errors());
            $this->load->view('/test/head');
            $this->load->view('/test/upload_form', $error);
            $this->load->view('/test/foot');
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
            $json_str =  $this->_task1($data['upload_data']['file_name']);
           if($this->_task2($json_str)>0){
               $result_arr = $this->_task3();
               $error = array('error' => $this->upload->display_errors());
               $this->load->helper('url');
               $this->load->view('/test/head');
               $this->load->view('/test/upload_form',$error);
               $this->load->view('/test/show_table', $result_arr);
               $this->load->view('/test/foot');
           }
        }
    }

    private function  getDir(){
        return $this->dir;
    }

    public function _task1($data){
        if( isset($data)){
            $myfile = fopen('./uploads/'.$data,'r') or die("Unable to open file!");

            $my_arr =  preg_split("/[\s]+/", fread($myfile,filesize('./uploads/'.$data))); // read and split
            fclose($myfile);
            $big_arr = [];

            foreach($my_arr as $arr){

                $arr = str_split(preg_replace( '/[^0-9]/', '', $arr )); // we need only digits
                rsort($arr);
                $big_arr[]=$arr;
            }
            $json_str  = json_encode($big_arr,JSON_NUMERIC_CHECK);

            return $json_str;
        }
    }

    public function _task2($json_str){
        $this->load->model('test_model');
        $this->test_model->insert_entry($json_str);
        return $this->db->insert_id();
    }


    public function _task3(){
        $this->load->model('test_model');
        $data =  $this->test_model->get_entry();
        $data = json_decode($data[0]->json_obj);
        $max = 0;
        $out_arr = array();
        $count_all = 0;
        $i = 0;
        // get max count of elements
        foreach($data as $arr){
           // $new_max = max(array_keys($arr));
            $new_max = count($arr);

            if($new_max>0 && $arr[0] !== ''){
            $count_all += $new_max;
            }

            if($new_max > $max){
                $max = $new_max;
            }
            $i++;
        }

        // make all arrays the same length
        $k = 0;
        foreach($data as $arr){
            $arr2 = array();
            $count = 0;
            for($y=0;$y<$max;$y++){
                if(isset($arr[$y]) && $arr[$y] !== ''){
                    $arr2[$y] = $arr[$y];
                    $count++;
                }
                else{
                    $arr2[$y] = '';
                }
            }
            $arr2[++$y] = $count;
            $out_arr[$k++]['data'] = $arr2;
        }

        // prepare other data
        $result_arr['data'] = $out_arr;
        $result_arr['max'] = $max;
        $result_arr['count_all'] = $count_all;
        $result_arr['count_rows'] = $i;

        return $result_arr;
    }

    public function refreshAjax(){

        $dir = $this->getDir();
        $lastModFile= $this->_getLastUploadedFile($dir);
        $json_str =  $this->_task1($lastModFile);
        if($this->_task2($json_str)>0){
            $result_arr = $this->_task3();
            $result_arr = json_encode($result_arr);
            print_r($result_arr);
        }
        exit();
    }

    public function _getLastUploadedFile($dir){
        $lastMod = 0;
        $lastModFile = '';
        foreach (scandir($dir) as $entry) {
            if (is_file($dir.$entry) && filectime($dir.$entry) > $lastMod) {
                $lastMod = filectime($dir.$entry);
                $lastModFile = $entry;
            }
        }
        return $lastModFile;
    }
}
