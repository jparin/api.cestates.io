<?php

defined('BASEPATH') OR exit('No direct script access allowed');


    class Database extends MY_Controller {

        private $_db_name = 'cestates';

        function __construct() {
            parent::__construct();
            $this->load->module("core/app");
            $this->load->dbforge();
        }

        public function index()
        {
            
        }

        public function forge(){
           
            $this->dbforge->drop_database($this->_db_name);
            // CREATE DB
            if ($this->dbforge->create_database($this->_db_name))
            {
                   
                $this->db->query('USE '.$this->_db_name);
                $this->users_table(); // CREATE USERS TABLE
                $this->properties_table(); // CREATE USERS TABLE
                $this->properties_images_table(); // CREATE USERS TABLE
                $this->api_list();
                

                echo "<h1>Successfully DB FORGED!</h1>";
            }
        }


        public function users_table(){

            $fields = array(
                'cet_user_id' => array(
                        'type' => 'INT',
                        'constraint' => 11,
                        'unsigned' => TRUE,
                        'auto_increment' => TRUE
                ),
                'cet_user_fname' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '100'
                ),
                'cet_user_mname' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '100'
                ),
                'cet_user_lname' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '100'
                ),
                'cet_user_email' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '100'
                ),
                'cet_user_password' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '180'
                ),
                'cet_user_address' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '100'
                ),
                'cet_user_city' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '100'
                ),
                'cet_user_province' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '100'
                ),
                'cet_user_first_verification' => array(
                    'type' => 'TINYINT',
                    'constraint' => '1',
                    'default' => 0
                ),
                'cet_user_second_verification' => array(
                    'type' => 'TINYINT',
                    'constraint' => '1',
                    'default' => 0
                ),
                'cet_user_email_verified' => array(
                    'type' => 'TINYINT',
                    'constraint' => '1',
                    'default' => 0
                ),
                'cet_user_hash' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '200',
                    'default' => 0
                ),
                'cet_user_birthday' => array(
                    'type' => 'DATE'
                ),
                'cet_user_mobile' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '100'
                ),
                'cet_user_telephone' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '100'
                ),
                'cet_user_nem_address' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '100'
                ),
                'cet_user_created' => array(
                    'type' => 'TIMESTAMP'
                ),
                'cet_user_modified' => array(
                    'type' => 'TIMESTAMP'
                ),
                'cet_user_archived' => array(
                    'type' => 'TINYINT',
                    'constraint' => '1',
                    'default' => 0
                ),
            );

            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('cet_user_id');
            $this->dbforge->create_table('cet_users');
        }

        public function properties_table(){

            $fields = array(
                'cet_property_id' => array(
                        'type' => 'INT',
                        'constraint' => 11,
                        'unsigned' => TRUE,
                        'auto_increment' => TRUE
                ),
                'cet_property_name' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '255'
                ),
                'cet_property_description' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '255'
                ),
                'cet_property_map' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '255'
                ),
                'cet_property_price' => array(
                    'type' => 'DOUBLE',
                    'constraint' => '10,6'
                ),
                'cet_property_address' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '255'
                ),
                'cet_property_type' => array(
                    'type' => 'ENUM("Condominium", "Residential")',
                    'default' => 'Condominium'
                ),
                'cet_property_created' => array(
                    'type' => 'TIMESTAMP'
                ),
                'cet_property_modified' => array(
                    'type' => 'TIMESTAMP'
                ),
            );

            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('cet_property_id');
            $this->dbforge->create_table('cet_properties');
        }  

        public function properties_images_table(){
            $fields = array(
                'cet_pimages_id' => array(
                        'type' => 'INT',
                        'constraint' => 11,
                        'unsigned' => TRUE,
                        'auto_increment' => TRUE
                ),
                'cet_pimages_property_id' => array(
                    'type' => 'INT',
                    'constraint' => 11
                ),
                'cet_pimages_link' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '255'
                ),
                'cet_pimages_created' => array(
                    'type' => 'TIMESTAMP'
                ),
                'cet_pimages_modified' => array(
                    'type' => 'TIMESTAMP'
                ),
            );

            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('cet_pimages_id');
            $this->dbforge->create_table('cet_properties_images');
        }

        public function api_list(){
            $fields = array(
                'cet_api_id' => array(
                        'type' => 'INT',
                        'constraint' => 11,
                        'unsigned' => TRUE,
                        'auto_increment' => TRUE
                ),
                'cet_api_name' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                ),
                'cet_api_key' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 255
                )
            );

            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('cet_api_id');
            $this->dbforge->create_table('cet_api_list');
        }
    }