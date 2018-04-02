<?php

/**
*
*/
class MY_Model extends CI_Model
{

    protected $_table_name = '';
    protected $_primary_key = 'id';
    protected $_table_prefix = '';
    protected $_order_by = '';
    protected $_timestamps = false;
    public $rules = array();


    function get($id = null, $single = false){

        if($this->_order_by != ''){
            $this->db->order_by($this->_order_by, 'ASC');
        }

        if($id !== NULL && $single === false){
            $this->db->where($this->_primary_key, $id);
            $method = 'result_array';
        }else if($id !== NULL && $single === true){
            $this->db->where($this->_primary_key, $id);
            $method = 'row_array';
        }else if($single === true){
            $method = 'row_array';
        }else{
            $method = 'result_array';
        }
        return $this->db->get($this->_table_name)->$method();
    }


    function get_by($where, $single = false){
        $this->db->where($where);
        return $this->get(null, $single);
    }

    function save($data, $id = null){

        $now = date('Y-m-d H:i:s');
        if($id !== NULL){
            //update
            if($this->_timestamps){
            $data[$this->_table_prefix.'_date_updated'] = $now;
            }
            $this->db->where($this->_primary_key, $id);
            $this->db->set($data);
            return $this->db->update($this->_table_name);
        }else{
            // insert
            if($this->_timestamps){
                $data[$this->_table_prefix.'_date_inserted'] = $now;
            }
            $this->db->set($data);
            $this->db->insert($this->_table_name);
            return $this->db->insert_id();
        }

    }


    function delete($id){
        $this->db->where($this->_primary_key, $id);
        return $this->db->delete($this->_table_name);
    }


    function get_count(){
        $this->db->select('count(*) as n');
        $products = $this->db->get($this->_table_name)->row_array();
        return $products->n;
    }

    function insert_on_duplicate_update_batch($table, $col_index ,$where_fields, $update_fields,$data)
    {

        $this->db->select('*');
        $rows = $this->db->get($table)->result_array();
        $rows2 = $rows;
        $to_insert_data = array();
        $to_update_data = array();
        /*
        foreach($data as $d){

            if(count($rows)){
                foreach($rows as $index => &$row){
                    $row_temp = array();
                    $d_temp = array();
                    foreach($where_fields as $field){
                        $row_temp[$field] = $row[$field];
                        $d_temp[$field] = $d[$field];
                    }


                    if($d_temp == $row_temp){
                        foreach($update_fields as $uf){
                             $row[$uf] = $d[$uf];
                        }

                        $to_update_data[] = $row;
                        unset($rows[$index]);
                        break;
                    }else{
                         $to_insert_data[] = $d;
                         break;
                    }
                }
            }else{
                 $to_insert_data[] = $d;
            }
        } // END LOOP
        */



        foreach($data as $d){
            if(count($rows)){
                foreach($rows as $index => &$row){
                    $row_temp = array();
                    $d_temp = array();

                    foreach($where_fields as $field){
                        $row_temp[$field] = $row[$field];
                        $d_temp[$field] = $d[$field];
                    }

                    if($d_temp == $row_temp){
                        foreach($update_fields as $uf){
                             $row[$uf] = $d[$uf];
                        }
                        $to_update_data[] = $row;
                        unset($rows[$index]);
                        break;
                    }
                }
            }else{
                $not_found = true;
            }

            $row_temp = array();
            $d_temp = array();

            foreach($rows2 as $r2){
                foreach($where_fields as $field){
                    $row_temp[$field] = $r2[$field];
                    $d_temp[$field] = $d[$field];
                }

                 $not_found = true;
                 if($d_temp == $row_temp){
                     $not_found = false;
                     break;
                 }

            }

            if($not_found){
               $to_insert_data[] =  $d;
            }

        } // END LOOP


        if(count($to_insert_data)){
            if(!$this->db->insert_batch($table,$to_insert_data)){
                return false;
            }
        }

        if(count($to_update_data)){
            if(!$this->db->update_batch($table,$to_update_data, $col_index)){
                return false;
            }
        }
        return true;
    }
}
