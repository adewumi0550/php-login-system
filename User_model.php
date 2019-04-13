<?php 
//<------------------------------------Developer Information------------------------------------->
 // Template Belbec: Adewumi  Adewale 
//Phone Number: 07031828170
//Company Name: Starcom Emerald Developer Global Enterprise
 //    Description: Geneology Development System.
 //    Author: Colorlib
 //    Version: 1.0

if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {
    
        public function __construct()
        {
                $this->load->database();
        }

        public function check_email($email)
        {
        	$this->db->where('email', $email);
        	$query = $this->db->get('belbec_user');
        	if ($query->num_rows()>0) {
        		return false;
        	}else{
        		return true;
        	}
        }

        //Fuction check the database from 
        public function check_username_exists($username)
        {
            $this->db->where('username', $username);
          $query = $this->db->get('user_login_table');
          if ($query->num_rows()>0) {
            return false;
          }else{
            return true;
          }
        }



           public function confirm_username($receiver)
        {
            $this->db->where('username', $receiver);
          $query = $this->db->get('user_login_table');
          if ($query->num_rows()>0) {
            return true;
          }else{
            return false;
          }
        }


        //Puc ID

         public function confirm_puc($puc_id)
        {
            $this->db->where('puc', $puc_id);
          $query = $this->db->get('pick_center');
          if ($query->num_rows()>0) {
            return true;
          }else{
            return false;
          }
        }
        // Add Model into database
        public function add_user()
        {

        $data = array(

        	 ''=>$this->input->post(''),

        );
        $this->db->insert('Table', $object);
        	# code...
        }


        public function check_user_id($user_id)
        {
        	$this->db->where('user_id', $user_id);
        	$query = $this->db->get('belbec_user');
        	if ($query->num_rows()>0) {
        		return true;
        	}else{
        		return false;
        	}
        }
//Select last user insert into database
        public function get_last_list()
        {
          $query = $this->db->query("SELECT user_number FROM belbec_user ORDER BY id DESC LIMIT 1");
           return  $query->row_array();
              
        }



         public function get_last_leg_node()
        {
          $query = $this->db->query("SELECT id FROM belbec_user ORDER BY id DESC LIMIT 1");
           return  $query->row_array();
              
        }


         public function last_sponsor_node($username)
        {
          $query = $this->db->query("SELECT * FROM belbec_user WHERE sponsor_key = '$username' ORDER BY id DESC LIMIT 1");
           return  $query->row_array();
              
        }


          public function get_child($username)
        {
          $query = $this->db->query("SELECT * FROM belbec_user WHERE sponsor_key = '$username' ORDER BY id ASC");
           return  $query->result_array();
              
        }



          public function get_left($username)
        {
          
          $query = $this->db->query("SELECT last_placement FROM belbec_user WHERE username = '$username'");
           return  $query->row_array();
              
        }



          public function get_node($username)
        {
          $query = $this->db->query("SELECT * FROM belbec_user WHERE username = '$username'");
           return  $query->row_array();
              
        }


         public function get_last_descendant($username)
        {
          $query = $this->db->query("SELECT id FROM belbec_user where  username = '$username'");
           return  $query->row_array();
              
        }




         public function e_wallet($username_id,$User_pass)
        {
            $this->db->select('*');
             $this->db->where('username', $username_id);
              $this->db->where('user_id_password', $User_pass);
              

              $result = $this->db->get('user_login_table');
              if ($result->num_rows()==1) {
                return $result->row(0)->id;
              }else{

                return false;
              }
        }



        public function user_info($username)
        {
                  $query = $this->db->query("SELECT * FROM belbec_user where  username = '$username'");
                         return $query->row_array();  
        }

         public function helper_leg($username)
        {
                  $query = $this->db->query("SELECT * FROM helper where  username = '$username'");
                         return $query->row_array();  
        }


        public function get_data($username)
        {
          $query = $this->db->query("SELECT * FROM belbec_user where  username = '$username' OR user_id='$username'");
                         return $query->row_array();  
        }

         public function user_id($level,$username, $id)
        {
                 $query = $this->db->query("SELECT username,id,date,sponsor_key,user_id,user_first_name,user_last_name FROM $level WHERE $level.sponsor_key='$username' AND id>='$id'");
                                             return $query->result_array(); 
        }

        public function sent_message($username)
        {
          $query = $this->db->query("SELECT * FROM compose_message where  username = '$username'  ORDER BY date desc");
                         return $query->result_array(); 
        }



        public function inbox_message($username)
        {
           $query = $this->db->query("SELECT * FROM inbox_message where  receiver  = '$username' ORDER BY date desc");
                         return $query->result_array(); 
        }



        public function cart_table()
        {
          $username = $_SESSION['username'];
          $query = $this->db->query("SELECT * FROM product_request where  username = '$username'");
          return $query->result_array();
        }


        public function access_key($username)
        {
            $query = $this->db->query("SELECT * FROM user_login_table where  username = '$username'");
                         return $query->row_array();  
        }

          public function user_data($reciver_user)
          {

             $query = $this->db->query("SELECT * FROM belbec_user WHERE user_id = '$reciver_user'");
                       
                         return $query->row_array();
          }

          public function get_transaction($transaction_id)
          {
            $query = $this->db->query("SELECT * FROM transfer WHERE transaction_id = '$transaction_id'");
                       
                         return $query->row_array();
          }

           public function transfer_wallet($reciver_user)
          {

             $query = $this->db->query("SELECT * FROM user_wallet WHERE user_id = '$reciver_user' OR username  = '$reciver_user'");
                       
                         return $query->row_array();
          }
          
        public function get_fund_request($user)
        {
            $query = $this->db->query("SELECT * FROM request_fund where  username = '$user'  ORDER BY  id DESC ");
                         return $query->result_array(); 
        }



        public function get_fund_transfer($user_id)
        {
          $query = $this->db->query("SELECT * FROM transfer where  sender_id = '$user_id' ORDER BY  id DESC  ");
                         return $query->result_array(); 
        }




        public function get_fund_details($id)
        {
           $query = $this->db->query("SELECT * FROM request_fund where  id = '$id'");
              return $query->row_array();  
        }

        public function get_wallet($username)
        {
            $query = $this->db->query("SELECT * FROM user_wallet where  username = '$username'");
              return $query->row_array();
        }


        public function belbec_user_count($user_id)
        {
          $query = $this->db->query("SELECT * FROM belbec_user where  user_id = '$user_id'");
              return $query->row_array();
        }
//Genology Treee wotk
        public function get_right($username)
        {
           $query = $this->db->query("SELECT * FROM belbec_user  WHERE username = '$username'");
           return $query->row_array();
        }


         public function get_parent_sponsor($username)
        {
           $query = $this->db->query("SELECT * FROM belbec_user  WHERE sponsor_key = '$username'");
          return  $query->num_rows();
        }

          public function direct_count($user_id)
        {
          
          $query = $this->db->query("SELECT * FROM belbec_user where  sponsor_key = '$user_id'");
             return  $query->num_rows();
        }



        //check The last Placement of users
          public function placement($user_id)
        {
          
          $query = $this->db->query("SELECT last_placement FROM belbec_user where  user_id = '$user_id'");
             return  $query->row_array();
        }
        


        public function fund_account()
        {
                $data = array(
                    'username' => $_SESSION['username'],
                'user_id' => $this->input->post('user_id'),
                'email' => $this->input->post('user_email'),
                'phone' => $this->input->post('user_mobile'),
                'amount' => $this->input->post('amount')

                );

                $this->db->insert('request_fund', $data);
                echo "<script>alert('Done');</script>";
        }

        public function confirm_fund_id($id)
        {
             $query = $this->db->query("SELECT username FROM request_fund where  id = '$id'");
             
              if ($query->num_rows()==1) {
                  return true;
              }else{
                return false;
              }
        }

        //=============================================== Level Genology Case ======================================

            public function refferal($username)
            {
                 $query = $this->db->query("SELECT * FROM belbec_user where  sponsor_key = '$username' ORDER BY  id DESC");
                         return $query->result_array(); 
            }

            public function recent_join()
            {
               $query = $this->db->query("SELECT * FROM belbec_user ORDER BY  id DESC LIMIT 5");
                         return $query->result_array(); 
            }


            public function starter($user_id)
            {
                 $query = $this->db->query("SELECT username,placement FROM belbec_user where  sponsor_key = '$user_id' ORDER BY  id DESC");
                         return $query->result_array(); 
            }


             public function network($username)
            {
                 $query = $this->db->query("SELECT * FROM belbec_user ORDER BY id desc");
                         return $query->result_array(); 
            }



            //Total Today Sign Up
            public function count_today_left()
            {

               $date = date('jS/F/Y');
               $username = $_SESSION['username'];
              $query = $this->db->query("SELECT node.username,node.user_id,node.sponsor_key,node.user_first_name,node.user_last_name,node.join_date
                                        FROM belbec_user AS node,
                                                belbec_user AS parent
                                        WHERE node.lft BETWEEN parent.lft AND parent.rgt
                                                AND parent.username = '$username' and
                                        
                                           node.left_leg = 'left' and node.join_date = '$date'
                                           ");
                                                    return $query->num_rows();
            }


            public function count_today_right()
            {
               $date = date('jS/F/Y');
                $username = $_SESSION['username'];
              $query = $this->db->query("SELECT node.username,node.user_id,node.sponsor_key,node.user_first_name,node.user_last_name,node.join_date
                                        FROM belbec_user AS node,
                                                belbec_user AS parent
                                        WHERE node.lft BETWEEN parent.lft AND parent.rgt
                                                AND parent.username = '$username' and
                                        
                                           node.right_leg = 'right' and node.join_date = '$date'
                                           ");
                                                    return $query->num_rows();
            }


              //Total Sign Up for left
            public function count_left()
            {
               $username = $_SESSION['username'];
              $query = $this->db->query("SELECT node.username,node.user_id,node.sponsor_key,node.user_first_name,node.user_last_name,node.join_date
                                        FROM belbec_user AS node,
                                                belbec_user AS parent
                                        WHERE node.lft BETWEEN parent.lft AND parent.rgt
                                                AND parent.username = '$username' and
                                        
                                           node.left_leg = 'left'
                                           ");
                                                    return $query->num_rows();
                                  }


                  //Total Sign  up For Right Leg
                                      public function count_right()
                              {
                                 $username = $_SESSION['username'];
                                $query = $this->db->query("SELECT node.username,node.user_id,node.sponsor_key,node.user_first_name,node.user_last_name,node.join_date
                                        FROM belbec_user AS node,
                                                belbec_user AS parent
                                        WHERE node.lft BETWEEN parent.lft AND parent.rgt
                                                AND parent.username = '$username' and
                                        
                                           node.right_leg = 'right'");
                                                    return $query->num_rows();
                                  }


                  //Close The application
                         public function get_levelone($username){

 
                                     // $sql = $this->db->query("SELECT node.username,node.user_id,node.sponsor_key,node.user_first_name,node.user_last_name,node.join_date
                                     //    FROM belbec_user AS node,
                                     //            belbec_user AS parent
                                     //    WHERE node.lft BETWEEN parent.lft AND parent.rgt
                                     //            AND parent.username = '$username'
                                     // GROUP BY node.username
                                     //  ORDER BY  node.id;");
                          $sql = $this->db->query("SELECT username,date,sponsor_key,user_id,user_first_name,user_last_name,join_date FROM belbec_user WHERE belbec_user.sponsor_key='$username' UNION SELECT username,date,sponsor_key,user_id,user_first_name,user_last_name,join_date FROM helper WHERE helper.help_key='$username' ORDER BY date ASC");

                               return $sql->result_array(); 
                         //  $data['user_info'] = $this->User_model->user_info($username);
                         // $ancestor = $data['user_info']['id'];

                         //    $sql = $this->db->query("SELECT belbec_user.id, belbec_user.username,  belbec_user.user_id, belbec_user.join_date, belbec_user.user_first_name,  belbec_user.user_last_name, belbec_user.sponsor_key
                         //                        FROM belbec_user JOIN tree
                         //                        ON(belbec_user.id = tree.descendant)
                         //                        WHERE tree.ancestor = $ancestor and length >0  ORDER BY `length` ASC");

                         //                   return $sql->result_array(); 
                           
                                // return $categories;
                            }


                            public function complete_leg($username){

 
                                     $sql = $this->db->query("SELECT node.id,node.placement,node.leg_complete,node.username,node.user_id,node.sponsor_key,node.join_date,node.last_placement,node.lft,node.rgt FROM belbec_user AS node, belbec_user AS parent WHERE node.lft BETWEEN parent.lft AND parent.rgt AND node.leg_complete='0' AND parent.username = '$username' ORDER BY node.id LIMIT 1");

                                 return $sql->row_array(); 

                           
                                // return $categories;
                            }

                            public function all_leg()
                            {
                                $sql = $this->db->query("SELECT
                                              *
                                          FROM
                                              belbec_user ORDER by belbec_user.id ");

                                 return $sql->result_array(); 
                            }



                             public function get_searchone($username){

 
                                 //     $sql = $this->db->query("SELECT node.username,node.user_id,node.sponsor_key,node.user_first_name,node.user_last_name,node.join_date
                                 //        FROM belbec_user AS node,
                                 //                belbec_user AS parent
                                 //        WHERE node.lft BETWEEN parent.lft AND parent.rgt
                                 //                AND parent.username = '$username' OR parent.user_id = '$username'
                                 //                   GROUP BY node.username
                                 //        ORDER BY node.id");

                                 // return $sql->result_array(); 

                              $sql = $this->db->query("SELECT username,date,sponsor_key,user_id,user_first_name,user_last_name,join_date FROM belbec_user WHERE belbec_user.sponsor_key='$username' UNION SELECT username,date,sponsor_key,user_id,user_first_name,user_last_name,join_date FROM helper WHERE helper.help_key='$username' ORDER BY date ASC");

                                 return $sql->result_array(); 

                           
                                // return $categories;
                            }


                            public function get_all_child($username)
                            {
                              $query = $this->db->query("SELECT username,date,sponsor_key,user_id,user_first_name,user_last_name,join_date FROM belbec_user WHERE belbec_user.sponsor_key='$username' UNION SELECT username,date,sponsor_key,user_id,user_first_name,user_last_name,join_date FROM helper WHERE helper.help_key='$username' ORDER BY date ASC ");
                         return $query->result_array(); 
                            }



                            public function comfirm_stater($username)
                            {
                                  $sql = $this->db->query("SELECT node.username,node.user_id,node.sponsor_key,node.user_first_name,node.user_last_name,node.join_date
                                        FROM belbec_user AS node,
                                                belbec_user AS parent
                                        WHERE node.lft BETWEEN parent.lft AND parent.rgt
                                                AND parent.username = '$username'
                                     -- GROUP BY node.username
                                      ORDER BY  node.id");

                                 return $sql->num_rows(); 
                            }


                            //  public function sub_categories($user_id){

                            //     $this->db->select('*');
                            //     $this->db->from('levelone');
                            //     $this->db->where('sponsor_key', $user_id);

                            //     $child = $this->db->get();
                            //     $categories = $child->result();
                            //     $i=0;
                            //     foreach($categories as $p_cat){

                            //         $categories[$i]->sub = $this->sub_categories($p_cat->user_id);
                            //         $i++;
                            //     }
                            //     return $categories;       
                            // }



                            //Number of level one 
                                public function get_numberlevelone($username){

                                $this->db->select('*');
                                $this->db->from('belbec_user');
                                $this->db->where('sponsor_key', $username);

                                $parent = $this->db->get();

                                 return $parent->num_rows();
                                
                               
                            }

                              public function rate_parent(){

                                $username = $_SESSION['username'];

                                $this->db->select('*');
                                $this->db->from('belbec_user');
                                $this->db->where('sponsor_key', $username);

                                $parent = $this->db->get();

                                 return $parent->num_rows();
                                
                               
                            }


                             //Number of level one 
                                public function get_numberleveltwo($user_id){

                                $this->db->select('*');
                                $this->db->from('leveltwo');
                                $this->db->where('sponsor_key', $user_id);

                                $parent = $this->db->get();

                                 return $parent->num_rows();
                                
                               
                            }


                             //Number of level one 
                                public function get_numberlevelthree($user_id){

                                $this->db->select('*');
                                $this->db->from('levelthree');
                                $this->db->where('sponsor_key', $user_id);

                                $parent = $this->db->get();

                                 return $parent->num_rows();
                                
                               
                            }



                             //Number of level one 
                                public function get_numberlevelfour($user_id){

                                $this->db->select('*');
                                $this->db->from('levelfour');
                                $this->db->where('sponsor_key', $user_id);

                                $parent = $this->db->get();

                                 return $parent->num_rows();
                                
                               
                            }


                             //Number of level one 
                                public function get_numberlevelfive($user_id){

                                $this->db->select('*');
                                $this->db->from('levelfive');
                                $this->db->where('sponsor_key', $user_id);

                                $parent = $this->db->get();

                                 return $parent->num_rows();
                                
                               
                            }


                             //Number of level one 
                                public function get_numberlevelsix($user_id){

                                $this->db->select('*');
                                $this->db->from('levelsix');
                                $this->db->where('sponsor_key', $user_id);

                                $parent = $this->db->get();

                                 return $parent->num_rows();
                                
                               
                            }


                             //Number of level one 
                                public function get_numberlevelseven($user_id){

                                $this->db->select('*');
                                $this->db->from('levelseven');
                                $this->db->where('sponsor_key', $user_id);

                                $parent = $this->db->get();

                                 return $parent->num_rows();
                                
                               
                            }


                             //Number of level one 
                                public function get_numberleveleight($user_id){

                                $this->db->select('*');
                                $this->db->from('leveleight');
                                $this->db->where('sponsor_key', $user_id);

                                $parent = $this->db->get();

                                 return $parent->num_rows();
                                
                               
                            }


                             //Number of level one 
                                public function get_numberlevelnine($user_id){

                                $this->db->select('*');
                                $this->db->from('levelnine');
                                $this->db->where('sponsor_key', $user_id);

                                $parent = $this->db->get();

                                 return $parent->num_rows();
                                
                               
                            }



                            //Number of level one 
                                public function get_numberlevelten($user_id){

                                $this->db->select('*');
                                $this->db->from('levelten');
                                $this->db->where('sponsor_key', $user_id);

                                $parent = $this->db->get();

                                 return $parent->num_rows();
                                
                               
                            }

                            //Check level two

                              public function user_level($level, $user_id)
                                  {
                                       $query = $this->db->query("SELECT user_id FROM $level where  user_id = '$user_id'");
                                       
                                        if ($query->num_rows()==1) {
                                            return   true;
                                        }else{
                                          return  false;
                                        }
                                  }

                                  public function confirm_achievement($level, $user_id)
                                  {
                                    $query = $this->db->query("SELECT user_id FROM $level where  user_id = '$user_id'");
                                    return $query->num_rows(); 
                                  }


                                    public function check_status($level, $user_id)
                                  {
                                       $query = $this->db->query("SELECT * FROM $level where  user_id = '$user_id'");
                                       
                                        return $query->row_array();
                                  }



                                    public function leveltwo_count($username, $id)
                                {
                                     $query = $this->db->query("SELECT username,id,date,sponsor_key,user_id,user_first_name,user_last_name FROM leveltwo WHERE leveltwo.sponsor_key='$username' OR help_key='$username' AND id>=$id");
                                             return $query->num_rows(); 
                                }


                                public function leveltwo_user($username)
                                {
                                  $query = $this->db->query("SELECT * FROM leveltwo WHERE username= '$username'");
                                  return $query->row_array();
                                }

                                public function levelthree_user($username)
                                {
                                  $query = $this->db->query("SELECT * FROM levelthree WHERE username= '$username'");
                                  return $query->row_array();
                                }


                                 public function levelfour_user($username)
                                {
                                  $query = $this->db->query("SELECT * FROM levelfour WHERE username= '$username'");
                                  return $query->row_array();
                                }

                                   public function levelfive_user($username)
                                {
                                  $query = $this->db->query("SELECT * FROM levelfive WHERE username= '$username'");
                                  return $query->row_array();
                                }


                                   public function levelsix_user($username)
                                {
                                  $query = $this->db->query("SELECT * FROM levelsix WHERE username= '$username'");
                                  return $query->row_array();
                                }

                                   public function levelseven_user($username)
                                {
                                  $query = $this->db->query("SELECT * FROM levelseven WHERE username= '$username'");
                                  return $query->row_array();
                                }

                                public function level_userid($level,$username)
                                {
                                 $query = $this->db->query("SELECT * FROM $level WHERE username= '$username'");
                                  return $query->row_array();
                                }

                                   public function leveleight_user($username)
                                {
                                  $query = $this->db->query("SELECT * FROM leveleight WHERE username= '$username'");
                                  return $query->row_array();
                                }

                                   public function levelnine_user($username)
                                {
                                  $query = $this->db->query("SELECT * FROM levelnine WHERE username= '$username'");
                                  return $query->row_array();
                                }

                                   public function levelten_user($username)
                                {
                                  $query = $this->db->query("SELECT * FROM levelten WHERE username= '$username'");
                                  return $query->row_array();
                                }



                                public function levelthree_count($user_id)
                                {
                                    $query = $this->db->query("SELECT username,id,date,sponsor_key,user_id,user_first_name,user_last_name FROM levelthree WHERE levelthree.sponsor_key='$username' OR help_key='$username' AND id>=$user_id");
                                             return $query->num_rows(); 
                                }


                                public function levelfour_count($user_id)
                                {
                                    $query = $this->db->query("SELECT username,id,date,sponsor_key,user_id,user_first_name,user_last_name FROM levelfour WHERE levelfour.sponsor_key='$username' OR help_key='$username' AND id>=$user_id");
                                             return $query->num_rows(); 
                                }



                                 public function levelfive_count($user_id)
                                {
                                     $query = $this->db->query("SELECT username,id,date,sponsor_key,user_id,user_first_name,user_last_name FROM levelfive WHERE levelfive.sponsor_key='$username' OR help_key='$username' AND id>=$user_id");
                                             return $query->num_rows(); 
                                }


                                 public function levelsix_count($user_id)
                                {
                                    $query = $this->db->query("SELECT username,id,date,sponsor_key,user_id,user_first_name,user_last_name FROM levelsix WHERE levelsix.sponsor_key='$username' OR help_key='$username' AND id>=$user_id");
                                             return $query->num_rows(); 
                                }

                                 public function levelseven_count($user_id)
                                {
                                     $query = $this->db->query("SELECT username,id,date,sponsor_key,user_id,user_first_name,user_last_name FROM levelseven WHERE levelseven.sponsor_key='$username' OR help_key='$username' AND id>=$user_id");
                                             return $query->num_rows(); 
                                }

                                 public function leveleight_count($user_id)
                                {
                                   $query = $this->db->query("SELECT username,id,date,sponsor_key,user_id,user_first_name,user_last_name FROM leveleight WHERE leveleight.sponsor_key='$username' OR help_key='$username' AND id>=$user_id");
                                             return $query->num_rows(); 
                                }

                                 public function levelnine_count($user_id)
                                {
                                    $query = $this->db->query("SELECT username,id,date,sponsor_key,user_id,user_first_name,user_last_name FROM levelnine WHERE levelnine.sponsor_key='$username' OR help_key='$username' AND id>=$user_id");
                                             return $query->num_rows(); 
                                }


                                 public function levelten_count($user_id)
                                {
                                     $query = $this->db->query("SELECT username,id,date,sponsor_key,user_id,user_first_name,user_last_name FROM levelten WHERE levelten.sponsor_key='$username' OR help_key='$username' AND id>=$user_id");
                                             return $query->num_rows(); 
                                }




                                  public function table_level_two()
                                  {
                                    $query = $this->db->query("SELECT * FROM leveltwo ORDER BY id");
                                             return $query->result_array(); 
                                  }

                                    public function table_level_three()
                                  {
                                    $query = $this->db->query("SELECT * FROM levelthree ORDER BY id");
                                             return $query->result_array(); 
                                  }

                                  public function table_level_four()
                                  {
                                     $query = $this->db->query("SELECT * FROM levelfour ORDER BY id");
                                             return $query->result_array(); 
                                  }
                                  public function table_level_five()
                                  {
                                    $query = $this->db->query("SELECT * FROM levelfive ORDER BY id");
                                             return $query->result_array(); 
                                  }



                                  public function table_level_six()
                                  {
                                    $query = $this->db->query("SELECT * FROM levelsix ORDER BY id");
                                             return $query->result_array(); 
                                  }

                                  public function table_level_seven()
                                  {
                                    $query = $this->db->query("SELECT * FROM levelseven ORDER BY id");
                                             return $query->result_array(); 
                                  }

                                  public function table_level_eight()
                                  {
                                   $query = $this->db->query("SELECT * FROM leveleight ORDER BY id");
                                             return $query->result_array(); 
                                  }

                                    public function table_level_nine()
                                  {
                                   $query = $this->db->query("SELECT * FROM levelnine ORDER BY id");
                                             return $query->result_array(); 
                                  }

                               public function leveltwo($user_id,$username)
                                {
                                     $query = $this->db->query("SELECT id,username,date,sponsor_key,user_id,user_first_name,user_last_name FROM leveltwo WHERE leveltwo.sponsor_key='$username'  AND id>=$user_id");
                                             return $query->result_array(); 
                                }

                                 public function levelthree($user_id,$username)
                                {
                                     $query = $this->db->query("SELECT id,username,date,sponsor_key,user_id,user_first_name,user_last_name FROM levelthree WHERE leveltwo.sponsor_key='$username' AND id>=$user_id");
                                             return $query->result_array(); 
                                }

                                 public function levelfour($user_id,$username)
                                {
                                     $query = $this->db->query("SELECT username,id,date,sponsor_key,user_id,user_first_name,user_last_name FROM levelfour WHERE levelfour.sponsor_key='$username' AND id>=$user_id");
                                             return $query->result_array(); 
                                }

                                 public function levelfive($user_id,$username)
                                {
                                     $query = $this->db->query("SELECT username,id,date,sponsor_key,user_id,user_first_name,user_last_name FROM levelfive WHERE levelfive.sponsor_key='$username' AND id>=$user_id");
                                             return $query->result_array(); 
                                }

                                 public function levelsix($user_id,$username)
                                {
                                     $query = $this->db->query("SELECT username,id,date,sponsor_key,user_id,user_first_name,user_last_name FROM levelsix WHERE levelsix.sponsor_key='$username' AND id>=$user_id");
                                             return $query->result_array(); 
                                }

                                 public function levelseven($user_id,$username)
                                {
                                     $query = $this->db->query("SELECT username,id,date,sponsor_key,user_id,user_first_name,user_last_name FROM levelseven WHERE levelseven.sponsor_key='$username' AND id>=$user_id");
                                             return $query->result_array(); 
                                }

                                 public function leveleight($user_id,$username)
                                {
                                     $query = $this->db->query("SELECT username,id,date,sponsor_key,user_id,user_first_name,user_last_name FROM leveleight WHERE leveleight.sponsor_key='$username' AND id>=$user_id");
                                             return $query->result_array(); 
                                }

                                 public function levelnine($user_id,$username)
                                {
                                     $query = $this->db->query("SELECT username,id,date,sponsor_key,user_id,user_first_name,user_last_name FROM levelnine WHERE levelnine.sponsor_key='$username' AND id>=$user_id");
                                             return $query->result_array(); 
                                }


                                 public function levelten($user_id,$username)
                                {
                                     $query = $this->db->query("SELECT username,id,date,sponsor_key,user_id,user_first_name,user_last_name FROM levelten WHERE levelten.sponsor_key='$username' AND id>=$user_id");
                                             return $query->result_array(); 
                                }


                                public function get_matrix_two($user_id)
                                {
                                 $query = $this->db->query("SELECT * FROM belbec_user WHERE belbec_user.sponsor_key IN ( SELECT belbec_user.user_id AND belbec_user.sponsor_key FROM belbec_user WHERE belbec_user.sponsor_key ='$user_id' ) ");
                                   return $query->result_array(); 
                                }



                                public function getmatrix($level,$user_id,$username)
                                {
                                     $query = $this->db->query("SELECT username,date,sponsor_key,user_id,user_first_name,user_last_name FROM $level WHERE $level.sponsor_key='$username' OR help_key='$username' AND id>=$user_id");
                                             return $query->result_array(); 
                                }







                                 public function get_categories(){
  // $username = $_SESSION['username'];
  //     $data['user_info'] = $this->User_model->user_info($username);
  //          $user_id = $data['user_info']['user_id'];
        $this->db->select('*');
        $this->db->from('belbec_user');
        // $this->db->where('sponsor_key', $user_id);

        $parent = $this->db->get();
        
        $categories = $parent->result();
        $i=0;
        foreach($categories as $p_cat){

            $categories[$i]->sub = $this->sub_categories($p_cat->user_id);
            $i++;
        }
        return $categories;
    }


    public function sub_categories($user_id){

        $this->db->select('*');
        $this->db->from('belbec_user');
        $this->db->where('sponsor_key', $user_id);

        $child = $this->db->get();
        $categories = $child->result();
        $i=0;
        foreach($categories as $p_cat){

            $categories[$i]->sub = $this->sub_categories($p_cat->user_id);
            $i++;
        }
        return $categories;       
    }


    public function getCategorybelbec_userForParentId($user_id) {
      
  $categories = array();
  $this->db->from('belbec_user');
  $this->db->where('sponsor_key', $user_id);
  $result = $this->db->get()->result();
  foreach ($result as $mainCategory) {
    $category = array();
    $category['user_id'] = $mainCategory->user_id;
    $category['user_first_name'] = $mainCategory->user_first_name;
     $category['user_last_name'] = $mainCategory->user_last_name;
    $category['username'] = $mainCategory->username;
    $category['sponsor_key'] = $mainCategory->sponsor_key;
    $category['sub_categories'] = $this->getCategorybelbec_userForParentId($category['user_id']);
    $categories[$mainCategory->id] = $category;
  }
  return $categories;
}


public function confirm_parent($leg)
{
     $query = $this->db->query("SELECT user_id FROM belbec_user where  sponsor_key = '$leg'");
                                       
                                        return $query->row_array();
}


public function delete_message($id)
{
 $this->db->where('id', $id);
$this->db->delete('compose_message');
}



public function delete_inbox_message($id)
{
 $this->db->where('id', $id);
$this->db->delete('inbox_message');
}

public function reply_message($id)
{
   $query = $this->db->query("SELECT * FROM inbox_message where  id = '$id'");
              return $query->row_array();
}

public function reply_line_message($id)
{
   $query = $this->db->query("SELECT * FROM message where  id = '$id'");
              return $query->row_array();
}



public function support_line_message($username)
{
   $query = $this->db->query("SELECT * FROM message where  sender_id = '$username'");
                                       
                                        return $query->result_array();
}
// public function confirm_level($level, $leg)
// {
//    $query = $this->db->query("SELECT user_id FROM $level where  sponsor_key = '$leg'");
                                       
//                                         return $query->row_array();
// }


public function user_id_wallet($user_id)
{
  $query = $this->db->query("SELECT * FROM user_wallet where  user_id = '$user_id'");
              return $query->row_array();
}

public function confirm_leadershipbonus($left)
{
      $query = $this->db->query("SELECT bonus FROM leveltwo where  user_id = '$left'");
             
             return $query->row_array();
}

// function buildCategory($parent, $category) {
//             $html = "";
//             if (isset($category['parent_cats'][$parent])) {
//                 $html .= "<ul>\n";
//                 foreach ($category['parent_cats'][$parent] as $cat_id) {
//                     if (!isset($category['parent_cats'][$cat_id])) {
//                         $html .= "<li>\n  <a href='" . $category['categories'][$cat_id]['category_link'] . "'>" . $category['categories'][$cat_id]['category_name'] . "</a>\n</li> \n";
//                     }
//                     if (isset($category['parent_cats'][$cat_id])) {
//                         $html .= "<li>\n  <a href='" . $category['categories'][$cat_id]['category_link'] . "'>" . $category['categories'][$cat_id]['category_name'] . "</a> \n";
//                         $html .= buildCategory($cat_id, $category);
//                         $html .= "</li> \n";
//                     }
//                 }
//                 $html .= "</ul> \n";
//             }
//             return $html;
//         }


}
        
 ?>