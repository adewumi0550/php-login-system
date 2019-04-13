<?php 
//<------------------------------------Developer Information------------------------------------->
 // Template Belbec: Adewumi  Adewale 
//Email adewumiadewale493@gmail.com
//Company Name: Starcom Emerald Developer Global Enterprise
 //    Description: Geneology Development System.
 //    Author: Colorlib
 //    Version: 1.0

if (!defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

   public function __construct()
  {
    parent::__construct();
// $user= $this->session->userdata('username');
    if (!$this->session->userdata('user_logged_in') ) {
       

  redirect('login','refresh');
          
  }


  // $this->total_gwallet();
  // $this->level4();

  $this->tree_change();
   // $this->update_level();

}




     

public function index($user='index')
	{
		 if ( ! file_exists(APPPATH.'views/user/'.$user.'.php'))
        {
                // Whoops, we don't have a user for that!
                show_404();
        }




            $username = $_SESSION['username'];
                 $data['user_info'] = $this->User_model->user_info($username);
  if ($data['user_info']['user_status']==false) {
    $data['title'] = "Update Profile";
    $this->load->view('user/update_status', $data);
  }else{
// echo $data['user_info']['user_status'];

			// $data['footer_post'] = $this->user_model->foot_post();
			        $data['title'] = 'Dashboard'; // Capitalize the first letter
              $username = $_SESSION['username'];
              
              $data['user_info'] = $this->User_model->user_info($username);
              $user_id = $data['user_info']['user_id'];
              $data['refferal'] = $this->User_model->refferal($username);
             $data['direct_count'] = $this->User_model->direct_count($username);
             // $this->User_model->direct_count($username);

                           $data['e_wallet'] = $this->User_model->get_wallet($username);

         $data['left_count']= $this->User_model->count_left();
          $data['right_count']= $this->User_model->count_right();
          $data['today_left'] = $this->User_model->count_today_left();
          $data['today_right'] = $this->User_model->count_today_right();
          $data['recent_join']= $this->User_model->recent_join();
         // die();count_today_left
          // print_r($this->User_model->count_today_right());
                    $this->load->view('template/user_header', $data);
			        $this->load->view('user/'.$user, $data);
                    $this->load->view('template/user_footer', $data);

	}}



public function change_access($value='')
{
  $this->form_validation->set_rules('password', 'User Password', 'trim|required|min_length[6]|matches[conpassword]');
  $this->form_validation->set_rules('conpassword', 'Confirm User Password', 'trim|required|min_length[6]');
  $this->form_validation->set_rules('wallet_password', 'Wallet Password', 'trim|required|min_length[6]|matches[wallet_conpassword]');
  $this->form_validation->set_rules('wallet_conpassword', ' Confirm Wallet Password', 'trim|required|min_length[6]');

  if ($this->form_validation->run() == FALSE) {

     $data['title'] = "Update Profile";
       $username = $_SESSION['username'];
                 $data['user_info'] = $this->User_model->user_info($username);
    $this->load->view('user/update_status', $data);

  }else{
      $username = $_SESSION['username'];
                 $data['user_info'] = $this->User_model->user_info($username);
     $data['title'] = "Update Profile";


     $password_id = md5($this->input->post('password'));
     $wallet_password =md5($this->input->post('wallet_password'));
     $password = array(

      'username_password' =>$password_id,
      'user_id_password' => $wallet_password
     );

       $this->db->where('username', $username);
      $this->db->update('user_login_table', $password);
      $username = $_SESSION['username'];
        $status = array(
      'user_status' =>1
     );

         $this->db->where('username', $username);
      $this->db->update('belbec_user', $status);

                     
    $this->load->view('user/update_status', $data);
    redirect('Page/logout','refresh');

  }
}

public function main($value='')
{
  # code...
}
  public function tree_user()
  {

                $username = $_SESSION['username'];
                 $data['user_info'] = $this->User_model->user_info($username);
  if ($data['user_info']['user_status']==false) {
    $data['title'] = "Update Profile";
    $this->load->view('user/update_status', $data);
  }else{
                     $data['title'] = 'Star 1 '; // Capitalize the first letter
                    $username = $_SESSION['username'];
              $data['user_info'] = $this->User_model->user_info($username);
                            //$user_id = $data['user_info']['user_id'];
                            // $ancestor_id = $data['user_info']['id'];
                            //  $lft = $data['user_info']['lft'];
                            // $rgt = $data['user_info']['rgt'];
                  
                 $data['getMain'] = $this->User_model->get_levelone($username);
                    $this->load->view('template/user_header', $data);
                    $this->load->view('user/tree_user', $data);
                    $this->load->view('template/user_footer', $data);
  }
}



// <---------------------------------------------achievement_form------------------------------------------------------------------------------>
  public function achievement()
  {

                $username = $_SESSION['username'];
                 $data['user_info'] = $this->User_model->user_info($username);
  if ($data['user_info']['user_status']==false) {
    $data['title'] = "Update Profile";
    $this->load->view('user/update_status', $data);
  }else{
        $data['title'] = 'Achievement'; // Capitalize the first letter
                    $username = $_SESSION['username'];
              $data['user_info'] = $this->User_model->user_info($username);
                            $data['user_id'] = $data['user_info']['user_id'];
                              $user_id = $data['user_info']['user_id'];

                              // print_r($this->User_model->check_status('leveltwo', $user_id));
                           $data['levelone_check_status'] = $this->User_model->check_status('leveltwo', $user_id);
                          $data['levelthree_check_status'] = $this->User_model->check_status('levelthree', $user_id);
                           $data['levelfour_check_status'] = $this->User_model->check_status('levelfour', $user_id);

                           // print_r($this->User_model->check_status('leveltwo', $user_id));
                           // die();
                             $data['leveltwo_check_status'] = $this->User_model->check_status('leveltwo', $user_id);
                    $this->load->view('template/user_header', $data);
                    $this->load->view('user/achievement', $data);
                    $this->load->view('template/user_footer', $data);
  }

}

public function product1($level,$user_id)
{

  // echo $user_id.$level;
  # code...

  //Get User ID wallet
  $data['e_wallet'] = $this->User_model->user_id_wallet($user_id);
 $balance = $data['e_wallet']['B_wallet'];

$total_bwallet = $balance-10;
  $data = array(
          'B_wallet' => $total_bwallet
          );

    $this->db->where('user_id', $user_id);
    $this->db->update('user_wallet', $data);


    $product_status = array(
          'product_status' => '1'
          );

    $this->db->where('user_id', $user_id);
    $this->db->update($level, $product_status);
    echo "<script>alert('Thanks, Product Succesfully Claim');</script>";

    redirect('User/product_table', 'refresh');

}


public function product2($level,$user_id)
{

  // echo $user_id.$level;
  # code...

  //Get User ID wallet
  $data['e_wallet'] = $this->User_model->user_id_wallet($user_id);
 $balance = $data['e_wallet']['B_wallet'];

$total_bwallet = $balance-20;
  $data = array(
          'B_wallet' => $total_bwallet
          );

    $this->db->where('user_id', $user_id);
    $this->db->update('user_wallet', $data);


    $product_status = array(
          'product_status' => '1'
          );

    $this->db->where('user_id', $user_id);
    $this->db->update($level, $product_status);
    echo "<script>alert('Thanks, Product Succesfully Claim');</script>";

    redirect('User/product_table', 'refresh');

}

public function product3($level,$user_id)
{

  // echo $user_id.$level;
  # code...

  //Get User ID wallet
  $data['e_wallet'] = $this->User_model->user_id_wallet($user_id);
 $balance = $data['e_wallet']['B_wallet'];

$total_bwallet = $balance-60;
  $data = array(
          'B_wallet' => $total_bwallet
          );

    $this->db->where('user_id', $user_id);
    $this->db->update('user_wallet', $data);


    $product_status = array(
          'product_status' => '1'
          );

    $this->db->where('user_id', $user_id);
    $this->db->update($level, $product_status);
    echo "<script>alert('Thanks, Product Succesfully Claim');</script>";

    redirect('User/product_table', 'refresh');

}

public function product4($level,$user_id)
{

  // echo $user_id.$level;
  # code...

  //Get User ID wallet
  $data['e_wallet'] = $this->User_model->user_id_wallet($user_id);
 $balance = $data['e_wallet']['B_wallet'];

$total_bwallet = $balance-160;
  $data = array(
          'B_wallet' => $total_bwallet
          );

    $this->db->where('user_id', $user_id);
    $this->db->update('user_wallet', $data);


    $product_status = array(
          'product_status' => '1'
          );

    $this->db->where('user_id', $user_id);
    $this->db->update($level, $product_status);
    echo "<script>alert('Thanks, Product Succesfully Claim');</script>";

    redirect('User/product_table', 'refresh');

}

public function product5($level,$user_id)
{

  // echo $user_id.$level;
  # code...

  //Get User ID wallet
  $data['e_wallet'] = $this->User_model->user_id_wallet($user_id);
 $balance = $data['e_wallet']['B_wallet'];

$total_bwallet = $balance-500;
  $data = array(
          'B_wallet' => $total_bwallet
          );

    $this->db->where('user_id', $user_id);
    $this->db->update('user_wallet', $data);


    $product_status = array(
          'product_status' => '1'
          );

    $this->db->where('user_id', $user_id);
    $this->db->update($level, $product_status);
    echo "<script>alert('Thanks, Product Succesfully Claim');</script>";

    redirect('User/product_table', 'refresh');

}

public function product6($level,$user_id)
{

  // echo $user_id.$level;
  # code...

  //Get User ID wallet
  $data['e_wallet'] = $this->User_model->user_id_wallet($user_id);
 $balance = $data['e_wallet']['B_wallet'];

$total_bwallet = $balance-1000;
  $data = array(
          'B_wallet' => $total_bwallet
          );

    $this->db->where('user_id', $user_id);
    $this->db->update('user_wallet', $data);


    $product_status = array(
          'product_status' => '1'
          );

    $this->db->where('user_id', $user_id);
    $this->db->update($level, $product_status);
    echo "<script>alert('Thanks, Product Succesfully Claim');</script>";

    redirect('User/product_table', 'refresh');

}


public function product7($level,$user_id)
{

  // echo $user_id.$level;
  # code...

  //Get User ID wallet
  $data['e_wallet'] = $this->User_model->user_id_wallet($user_id);
 $balance = $data['e_wallet']['B_wallet'];

$total_bwallet = $balance-2000;
  $data = array(
          'B_wallet' => $total_bwallet
          );

    $this->db->where('user_id', $user_id);
    $this->db->update('user_wallet', $data);


    $product_status = array(
          'product_status' => '1'
          );

    $this->db->where('user_id', $user_id);
    $this->db->update($level, $product_status);
    echo "<script>alert('Thanks, Product Succesfully Claim');</script>";

    redirect('User/product_table', 'refresh');

}


public function product8($level,$user_id)
{

  // echo $user_id.$level;
  # code...

  //Get User ID wallet
  $data['e_wallet'] = $this->User_model->user_id_wallet($user_id);
 $balance = $data['e_wallet']['B_wallet'];

$total_bwallet = $balance-4000;
  $data = array(
          'B_wallet' => $total_bwallet
          );

    $this->db->where('user_id', $user_id);
    $this->db->update('user_wallet', $data);


    $product_status = array(
          'product_status' => '1'
          );

    $this->db->where('user_id', $user_id);
    $this->db->update($level, $product_status);
    echo "<script>alert('Thanks, Product Succesfully Claim');</script>";

    redirect('User/product_table', 'refresh');

}




public function product9($level,$user_id)
{

  // echo $user_id.$level;
  # code...

  //Get User ID wallet
  $data['e_wallet'] = $this->User_model->user_id_wallet($user_id);
 $balance = $data['e_wallet']['B_wallet'];

$total_bwallet = $balance-10000;
  $data = array(
          'B_wallet' => $total_bwallet
          );

    $this->db->where('user_id', $user_id);
    $this->db->update('user_wallet', $data);


    $product_status = array(
          'product_status' => '1'
          );

    $this->db->where('user_id', $user_id);
    $this->db->update($level, $product_status);
    echo "<script>alert('Thanks, Product Succesfully Claim');</script>";

    redirect('User/product_table', 'refresh');

}

public function b_wallet()
{
  
                      $username = $_SESSION['username'];
                       $data['user_info'] = $this->User_model->user_info($username);
                      $user_id = $data['user_info']['user_id'];
                      $data['e_wallet'] = $this->User_model->get_wallet($username);
                       $balance = $data['e_wallet']['B_wallet'];
                           if ($balance<$amount)
                        {
                                $this->form_validation->set_message('b_wallet', 'Insufficent Balance for Wallet Transfer Kindly Fund Account');
                                return FALSE;
                        }
                        else
                        {
                                return TRUE;
                        }
}

 public function apply_loan()
  {

               $data['title'] = 'Compose Message'; // Capitalize the first letter
                     $username =  $_SESSION['username'];
                    $data['user_info'] = $this->User_model->user_info($username);     


                    // $this->form_validation->set_rules('Sender', 'Sender ID', 'trim|required');
                    // $this->form_validation->set_rules('receiver', 'Receiver ID', 'trim|required');
                    $this->form_validation->set_rules('message', 'Message Content', 'trim|required');
                    $this->form_validation->set_rules('amount', 'Amount', 'trim|required|numeric');
                    $this->form_validation->set_rules('agree', 'Confirm Company Agreement', 'trim|required');
                    if ($this->form_validation->run() == FALSE) {
                       $this->load->view('template/user_header', $data);
                    $this->load->view('user/apply_loan', $data);
                    $this->load->view('template/user_footer', $data);
                    } else {
                      $data = array(
                        'sender_id' => $this->input->post('sender'),
                        'receiver' => $this->input->post('receiver'),
                        'full_name' =>$this->input->post('full_name'),
                        'username' => $this->input->post('username'),
                        'message' => $this->input->post('message')

                      );

                      $this->db->insert('message', $object);
                       $this->load->view('template/user_header', $data);
                    $this->load->view('user/apply_loan', $data);
                    $this->load->view('template/user_footer', $data);
                    }

}










public function grant_four($user_id)
{
  // $data['levelfour'] = $this->User_model->check_status('levelfour', $user_id);
  if ($this->User_model->check_status('levelfive', $user_id)==false) {
    redirect('User/achievement','refresh');
  }else{
    $data = array(
      'status'=> '1'

    );
    $this->db->where('user_id', $user_id);
    $this->db->update('levelfour', $data);
echo "<script>alert('congratulation you have Grant $400 Request');</script>";
    redirect('User/achievement','refresh');
  }
}

public function grant_five($user_id)
{
  if ($this->User_model->check_status('levelfive', $user_id)==false) {
    redirect('User/achievement','refresh');
  }else{
     $username =  $_SESSION['username'];
                    $data['user_info'] = $this->User_model->user_info($username);
                    $user_mobile = $data['user_info']['user_mobile'];
    $data = array(
      'status'=> '1',
      'user_mobile' =>$user_mobile

    );
    $this->db->where('user_id', $user_id);
    $this->db->update('levelfive', $data);
    echo "<script>alert('congratulation!!! you have Achievement Request');</script>";
    redirect('User/achievement','refresh');
  }

}


public function grant_six($user_id)
{
  if ($this->User_model->check_status('levelsix', $user_id)==false) {
    redirect('User/achievement','refresh');
  }else{
     $username =  $_SESSION['username'];
                    $data['user_info'] = $this->User_model->user_info($username);
                    $user_mobile = $data['user_info']['user_mobile'];
    $data = array(
      'status'=> '1',
      'user_mobile' =>$user_mobile

    );
    $this->db->where('user_id', $user_id);
    $this->db->update('levelsix', $data);
    echo "<script>alert('congratulation!!! you have Achievement  Request ');</script>";
    redirect('User/achievement','refresh');
  }

}


public function grant_seven($user_id)
{
  if ($this->User_model->check_status('levelseven', $user_id)==false) {
    redirect('User/achievement','refresh');
  }else{
     $username =  $_SESSION['username'];
                    $data['user_info'] = $this->User_model->user_info($username);
                    $user_mobile = $data['user_info']['user_mobile'];
    $data = array(
      'status'=> '1',
      'user_mobile' =>$user_mobile

    );
    $this->db->where('user_id', $user_id);
    $this->db->update('levelseven', $data);
    echo "<script>alert('congratulation!!! you have Achievement  Request ');</script>";
    redirect('User/achievement','refresh');
  }

}


public function grant_eight($user_id)
{
  if ($this->User_model->check_status('leveleight', $user_id)==false) {
    redirect('User/achievement','refresh');
  }else{
     $username =  $_SESSION['username'];
                    $data['user_info'] = $this->User_model->user_info($username);
                    $user_mobile = $data['user_info']['user_mobile'];
    $data = array(
      'status'=> '1',
      'user_mobile' =>$user_mobile

    );
    $this->db->where('user_id', $user_id);
    $this->db->update('leveleight', $data);
    echo "<script>alert('congratulation!!! you have Achievement  Request ');</script>";
    redirect('User/achievement','refresh');
  }

}

public function stick()
{
  $username = 'belbec';
  print_r($this->User_model->helper_leg($username));
}

public function grant_nine($user_id)
{
  if ($this->User_model->check_status('levelnine', $user_id)==false) {
    redirect('User/achievement','refresh');
  }else{
     $username =  $_SESSION['username'];
                    $data['user_info'] = $this->User_model->user_info($username);
                    $user_mobile = $data['user_info']['user_mobile'];
    $data = array(
      'status'=> '1',
      'user_mobile' =>$user_mobile

    );
    $this->db->where('user_id', $user_id);
    $this->db->update('levelnine', $data);
    echo "<script>alert('congratulation!!! you have Achievement  Request ');</script>";
    redirect('User/achievement','refresh');
  }

}

  public function achievement_form($level=null,$user_id=null)
  {



    if ($user_id=="") {
      redirect('dashboard','refresh');
    }


    // echo $level.' '.$user_id;
        $data['title'] = 'Achievement'; // Capitalize the first letter
                    $username = $_SESSION['username'];
              $data['user_info'] = $this->User_model->user_info($username);
                            $data['user_id'] = $data['user_info']['user_id'];
                              $user_id = $data['user_info']['user_id'];
                              $data['level'] = $level;
                              $data['user_id'] = $user_id;
                              // print_r($this->User_model->check_status('leveltwo', $user_id));
                           $data['leveltwo_check_status'] = $this->User_model->check_status('leveltwo', $user_id);
                           $data['levelthree_check_status'] = $this->User_model->check_status('levelthree', $user_id);
                           $data['levelfour_check_status'] = $this->User_model->check_status('levelfour', $user_id);
                    $this->load->view('template/user_header', $data);
                    $this->load->view('user/achievement_form', $data);
                    $this->load->view('template/user_footer', $data);
  }


     public function stage2()
  {
                $username = $_SESSION['username'];
                 $data['user_info'] = $this->User_model->user_info($username);
  if ($data['user_info']['user_status']==false) {
    $data['title'] = "Update Profile";
    $this->load->view('user/update_status', $data);
  }else{
                     $data['title'] = 'Star 2'; // Capitalize the first letter
                    $username = $_SESSION['username'];
              $data['user_info'] = $this->User_model->user_info($username);

                            $user_id = $data['user_info']['user_id'];

                            $data['level'] = 'leveltwo';
                    $this->load->view('template/user_header', $data);
                    $this->load->view('user/leveltwo', $data);
                    $this->load->view('template/user_footer', $data);
  }
}

 

 public function upload_photo()
 {
   $config['upload_path'] = './assets/';
   $config['allowed_types'] = 'gif|jpg|png';
   $config['max_size']  = '2048';
   $config['file_name'] = $_FILES["userfile"]['name'];
   $config['max_width']  = '1024';
   $config['max_height']  = '768';
   $config['overwrite'] = TRUE;
   
   $this->load->library('upload', $config);
   
   if ( ! $this->upload->do_upload()){
     $error = array('error' => $this->upload->display_errors());
      // $this->load->view('upload_form', $error);
     $this->profile($error);
   }
   else{
     $data = array('upload_data' => $this->upload->data());
     $picture = $_FILES['userfile']['name'];

      $picture_update = array(

                          'user_photo' => $picture
                         
                     );
                      $username = $_SESSION['username'];
                     $this->db->where('username', $username);
                     $this->db->update('belbec_user', $picture_update);
                 

   }
 }


 ///////////////////////////////////////////Wallet System---------------------------------------------------------->
public function total_gwallet()
{
              $username = $_SESSION['username'];
                 $data['user_info'] = $this->User_model->user_info($username);
  if ($data['user_info']['user_status']==false) {
    $data['title'] = "Update Profile";
    $this->load->view('user/update_status', $data);
  }else{
   $username = $_SESSION['username'];
     $data['user_info'] = $this->User_model->user_info($username);
    $user_id = $data['user_info']['user_id'];
    $data['e_wallet'] = $this->User_model->get_wallet($username);

    $R_wallet = $data['e_wallet']['R_wallet'];
    $L_wallet = $data['e_wallet']['L_wallet'];
     $G_wallet = $data['e_wallet']['G_wallet'];

     if ($R_wallet==0 && $L_wallet==0) {
       redirect('wallet_dashboard','refresh');
     }

     //Move to Transcation Summary
     $date = date('dS-m-Y');
     $total_moved = $R_wallet+$L_wallet;
     $move_status = array(
      'amount_type' =>'wallet Moved',
      'sender_id' => $user_id,
      'amount' =>$total_moved,
      'reciever_id'=>'G wallet',
      'date' => $date

     );

     $this->db->insert('transfer', $move_status);

    // $R_walet = $data['e_wallet'][?'R_wallet'];
    $total_wallet = $R_wallet+$L_wallet+$G_wallet;


              $R_wallet =0;
              $L_wallet = 0;
               $wallet_panel = array(

                          'G_wallet' => $total_wallet,
                          'R_wallet' => $R_wallet,
                          'L_wallet' => $L_wallet
                          
                     );
                     $this->db->where('user_id', $user_id);
                     $this->db->update('user_wallet', $wallet_panel);
                     redirect('wallet_dashboard','refresh');

}
}


  //Wallet Dashboard 
  public function wallet_dashboard()
  {            $username = $_SESSION['username'];
                 $data['user_info'] = $this->User_model->user_info($username);
  if ($data['user_info']['user_status']==false) {
    $data['title'] = "Update Profile";
    $this->load->view('user/update_status', $data);
  }else{
     $data['title'] = 'Wallet Dashboard'; // Capitalize the first letter
              $username = $_SESSION['username'];
              
              $data['user_info'] = $this->User_model->user_info($username);
                $user_id = $data['user_info']['user_id'];
              $data['refferal'] = $this->User_model->refferal($user_id);
              $data['e_wallet'] = $this->User_model->get_wallet($username);

         // $data['e_wallet'] = $this->User_model->get_wallet($username);
                    $this->load->view('template/user_header', $data);
              $this->load->view('user/wallet_dashboard', $data);
                    $this->load->view('template/user_footer', $data);
  }
}

  public function account()
  {
                $username = $_SESSION['username'];
                 $data['user_info'] = $this->User_model->user_info($username);
  if ($data['user_info']['user_status']==false) {
    $data['title'] = "Update Profile";
    $this->load->view('user/update_status', $data);
  }else{
    $this->form_validation->set_rules('acct_number', 'Account Number', 'trim|required|numeric|max_length[10]');
    $this->form_validation->set_rules('acct_name', 'Account Name', 'trim|required');
    $this->form_validation->set_rules('bank_name', 'Bank Name', 'trim|required');
    if ($this->form_validation->run() == FALSE) {
      $this->wallet_dashboard();
    } else {

      $data = array(
        'acct_number' =>$this->input->post('acct_number'),
        'acct_name' =>$this->input->post('acct_name'),
        'bank_name' =>$this->input->post('bank_name')
      );
      $this->db->where('username', $this->input->post('username'));
                      $this->db->update('user_wallet', $data);
                      $this->session->set_flashdata("success_update_acct","Account Information Succesfully Updated");

      $this->wallet_dashboard();
    }
  }
}




public function tree_change()
{
    // print_r($this->User_model->all_leg());
  $userlist = $this->User_model->all_leg();
   foreach ($userlist as $product){

   $username =  $product['username'];


 if ($this->User_model->comfirm_stater($username)>=3) {
          
           $complete_leg = array(
                        'leg_complete' => '1'
                      );
                      //$last=  $data['complete_leg']['username'];
                                // $uername = $_SESSION['username'];
                      $this->db->where('username', $username);
                      $this->db->update('belbec_user', $complete_leg);
   }

$getMain = $this->User_model->get_levelone($username);
// echo $ancestor_id;

// print_r($this->User_model->get_levelone($username));
// print_r($getMain);
// print_r($getMain);
// $data['left1']= '';
// $data['right1']= $getMain[1];
// $data['left2']= $getMain[2];
// $data['right2']= $getMain[3];
// $data['left3']= $getMain[4];
// $data['right3']= $getMain[5];
//  print_r($getMain);

$data['left1']= '';
$data['right1']= '';
 $data['left2']= '';
  $data['right2']= '';
   $data['left3']= '';
     $data['right3'] ='';

if (empty($getMain[0])) {
 $data['left1']= '';
}else{
 $data['left1']= $getMain[0];

}
if (empty($getMain[1])) {
 $data['right1']= '';
}else{
 $data['right1']= $getMain[1];

}




if (!empty($data['left1'])) {
  
$username1 = $data['left1']['username'];


$children = $this->User_model->get_all_child($username1);
if (!empty($children[0])) {
  $children1 = $children[0];
  $data['left2']= $children1;
}elseif(!empty($getMain[2])){
  $data['left2']= $getMain[2];
}

if (!empty($children[1])) {
  $children2 = $children[1];
  $data['right2']= $children2;
}elseif(!empty($getMain[2])){
  $data['right2']= $getMain[2];
}



  }elseif(!empty($getMain[2]) && !empty($getMain[3])){

    $data['left2']= $getMain[4];
     $data['right2']= $getMain[5];
  }





if (!empty($data['right1'])) {
  
 $username2 = $data['right1']['username'];


$leftchildren = $this->User_model->get_all_child($username2);



// print_r($this->User_model->get_all_child($usernam2));



if (!empty($leftchildren[0])) {
  $leftchildren1 = $leftchildren[0];
  $data['left3']= $leftchildren1;
}elseif(!empty($getMain[4])){

  $data['left3']= $getMain[4];
}

if (!empty($leftchildren[1])) {
  $leftchildren2 = $leftchildren[1];
  $data['right3']= $leftchildren2;
}elseif(!empty($getMain[5])){
  
  $data['right3']= $getMain[5];
}



  }elseif(!empty($getMain[4]) && !empty($getMain[5])){

    $data['left3']= $getMain[4];
     $data['right3']= $getMain[5];
  }



if ( $data['right3']==true && $data['left3']==true && $data['right2']==true && $data['left1']==true && $data['right1']==true && $data['left2']==true) {
                    $level = "leveltwo";
                    $data['user_info'] = $this->User_model->user_info($username);
                   
                $user_id = $data['user_info']['user_id'];
                 if ($this->User_model->user_level($level, $user_id)==false) {
                   $user_first_name = $data['user_info']['user_first_name'];
                   $user_last_name = $data['user_info']['user_last_name'];
                   $user_id = $data['user_info']['user_id'];
                     

                   $username = $data['user_info']['username'];
                   $sponsor_key = $data['user_info']['sponsor_key'];
                   $data['sponsor_wallet'] = $this->User_model->get_wallet($sponsor_key);
                   $data['e_wallet'] = $this->User_model->get_wallet($username);


                     $B_wallet = $data['e_wallet']['B_wallet'];
                     $L_wallet = $data['sponsor_wallet']['L_wallet'];


                     $update_Lwallet = $L_wallet +4;


                   

                      $sponsor_panel = array(

                          'L_wallet' => $update_Lwallet
                         
                     );
                     $this->db->where('username', $sponsor_key);
                     $this->db->update('user_wallet', $sponsor_panel);
                 
                        $update_bwallet = $B_wallet + 10;
                       $wallet_panel = array(

                          'B_wallet' => $update_bwallet
                         
                     );
                     $this->db->where('user_id', $user_id);
                     $this->db->update('user_wallet', $wallet_panel);

                      $date = date('jS / F / Y');
                    $data['help_sponsor']  = $this->User_model->helper_leg($username);

                    if ($this->User_model->helper_leg($username)==false) {
                     $help_level ='';
                    }else{
                   $help_level = $data['help_sponsor']['help_key'];
                   }
                  $data = array(
                    'user_first_name' => $user_first_name,
                    'user_last_name' => $user_last_name,
                    'user_id' => $user_id,
                    'username' => $username,
                    'sponsor_key' => $sponsor_key,
                    'help_key' =>$help_level,
                    'date' => $date

                  );
                  $this->db->insert($level, $data);
}                   
}


}
}





public function update_level()
{
  if ($this->User_model->table_level_two()==true) {
    $leveltwo = $this->User_model->table_level_two();
    foreach ($leveltwo as $level){
      $username =  $level['username'];
       $data['user_info'] = $this->User_model->user_info($username);
        $id = $data['user_info']['id'];
       if ($this->User_model->leveltwo_count($username, $id)>=14) {
           $username =  $level['username'];
           $data['user_info'] = $this->User_model->user_info($username);
                    $level = "levelthree";
                $user_id = $data['user_info']['user_id'];
                 if ($this->User_model->user_level($level, $user_id)==false) {
                   $user_first_name = $data['user_info']['user_first_name'];
                   $user_last_name = $data['user_info']['user_last_name'];
                   $user_id = $data['user_info']['user_id'];
                     

                   $username = $data['user_info']['username'];
                   $sponsor_key = $data['user_info']['sponsor_key'];
                   $data['sponsor_wallet'] = $this->User_model->get_wallet($sponsor_key);
                   $data['e_wallet'] = $this->User_model->get_wallet($username);

                     $B_wallet = $data['e_wallet']['B_wallet'];
                     $L_wallet = $data['sponsor_wallet']['L_wallet'];


                     $update_Lwallet = $L_wallet +20;


                     $update_bwallet = $B_wallet + 10;

                      $sponsor_panel = array(

                          'L_wallet' => $update_Lwallet
                         
                     );
                     $this->db->where('username', $sponsor_key);
                     $this->db->update('user_wallet', $sponsor_panel);
                 
                      
                       $wallet_panel = array(

                          'B_wallet' => $update_bwallet
                         
                     );
                     $this->db->where('user_id', $user_id);
                     $this->db->update('user_wallet', $wallet_panel);

                      $date = date('jS / F / Y');
                  
                  if ($data['user_info']['help_key']==false) {
                     $help_level ='';
                    }else{
                   $help_level = $data['user_info']['help_key'];
                   }
                  
                  $data = array(
                    'user_first_name' => $user_first_name,
                    'user_last_name' => $user_last_name,
                    'user_id' => $user_id,
                    'username' => $username,
                    'sponsor_key' => $sponsor_key,
                    'help_key' =>$help_level,
                    'date' => $date

                  );
                  $this->db->insert($level, $data);
                  
 
}


    }



  }

  // level three
}


// level Three zlib_get_coding_type()

if ($this->User_model->table_level_three()==true) {
    $leveltwo = $this->User_model->table_level_three();
    foreach ($levelthree as $level){
      $username =  $level['username'];
       $data['user_info'] = $this->User_model->user_info($username);
        $id = $data['user_info']['id'];
       if ($this->User_model->levelthree_count($username,$id)>=14) {
           $username =  $level['username'];
           $data['user_info'] = $this->User_model->user_info($username);
                    $level = "levelfour";
                $user_id = $data['user_info']['user_id'];
                 if ($this->User_model->user_level($level, $user_id)==false) {
                   $user_first_name = $data['user_info']['user_first_name'];
                   $user_last_name = $data['user_info']['user_last_name'];
                   $user_id = $data['user_info']['user_id'];
                     

                   $username = $data['user_info']['username'];
                   $sponsor_key = $data['user_info']['sponsor_key'];
                   $data['sponsor_wallet'] = $this->User_model->get_wallet($sponsor_key);
                   $data['e_wallet'] = $this->User_model->get_wallet($username);

                     $B_wallet = $data['e_wallet']['B_wallet'];
                     $L_wallet = $data['sponsor_wallet']['L_wallet'];


                     $update_Lwallet = $L_wallet +60;


                     $update_bwallet = $B_wallet + 60;

                      $sponsor_panel = array(

                          'L_wallet' => $update_Lwallet
                         
                     );
                     $this->db->where('username', $sponsor_key);
                     $this->db->update('user_wallet', $sponsor_panel);
                 
                      
                       $wallet_panel = array(

                          'B_wallet' => $update_bwallet
                         
                     );
                     $this->db->where('user_id', $user_id);
                     $this->db->update('user_wallet', $wallet_panel);

                      $date = date('jS / F / Y');
                   if ($data['user_info']['help_key']==false) {
                     $help_level ='';
                    }else{
                   $help_level = $data['user_info']['help_key'];
                   }
                  
                  $data = array(
                    'user_first_name' => $user_first_name,
                    'user_last_name' => $user_last_name,
                    'user_id' => $user_id,
                    'username' => $username,
                    'sponsor_key' => $sponsor_key,
                    'help_key' =>$help_level,
                    'date' => $date

                  );
                  $this->db->insert($level, $data);
                
 
}


    }



  }

}

// Level Four Stage 




if ($this->User_model->table_level_four()==true) {
    $leveltwo = $this->User_model->table_level_four();
    foreach ($levelfour as $level){
      $username =  $level['username'];
       $data['user_info'] = $this->User_model->user_info($username);
        $id = $data['user_info']['id'];
       if ($this->User_model->levelfour_count($username,$id)>=14) {
           $username =  $level['username'];
           $data['user_info'] = $this->User_model->user_info($username);
                    $level = "levelfive";
                $user_id = $data['user_info']['user_id'];
                 if ($this->User_model->user_level($level, $user_id)==false) {
                   $user_first_name = $data['user_info']['user_first_name'];
                   $user_last_name = $data['user_info']['user_last_name'];
                   $user_id = $data['user_info']['user_id'];
                     

                   $username = $data['user_info']['username'];
                   $sponsor_key = $data['user_info']['sponsor_key'];
                   $data['sponsor_wallet'] = $this->User_model->get_wallet($sponsor_key);
                   $data['e_wallet'] = $this->User_model->get_wallet($username);

                     $B_wallet = $data['e_wallet']['B_wallet'];
                     $L_wallet = $data['sponsor_wallet']['L_wallet'];


                     $update_Lwallet = $L_wallet +300;


                     $update_bwallet = $B_wallet + 160;

                      $sponsor_panel = array(

                          'L_wallet' => $update_Lwallet
                         
                     );
                     $this->db->where('username', $sponsor_key);
                     $this->db->update('user_wallet', $sponsor_panel);
                 
                      
                       $wallet_panel = array(

                          'B_wallet' => $update_bwallet
                         
                     );
                     $this->db->where('user_id', $user_id);
                     $this->db->update('user_wallet', $wallet_panel);

                      $date = date('jS / F / Y');
                  
                  if ($data['user_info']['help_key']==false) {
                     $help_level ='';
                    }else{
                   $help_level = $data['user_info']['help_key'];
                   }
                  
                  $data = array(
                    'user_first_name' => $user_first_name,
                    'user_last_name' => $user_last_name,
                    'user_id' => $user_id,
                    'username' => $username,
                    'sponsor_key' => $sponsor_key,
                    'help_key' =>$help_level,
                    'date' => $date

                  );
                  $this->db->insert($level, $data);
                
 
}


    }


  }

}



 // Level FIve For 

if ($this->User_model->table_level_five()==true) {
    $leveltwo = $this->User_model->table_level_five();
    foreach ($levelfive as $level){
      $username =  $level['username'];
       $data['user_info'] = $this->User_model->user_info($username);
        $id = $data['user_info']['id'];
       if ($this->User_model->levelfive_count($username,$id)>=14) {
           $username =  $level['username'];
           $data['user_info'] = $this->User_model->user_info($username);
                    $level = "levelsix";
                $user_id = $data['user_info']['user_id'];
                 if ($this->User_model->user_level($level, $user_id)==false) {
                   $user_first_name = $data['user_info']['user_first_name'];
                   $user_last_name = $data['user_info']['user_last_name'];
                   $user_id = $data['user_info']['user_id'];
                     

                   $username = $data['user_info']['username'];
                   $sponsor_key = $data['user_info']['sponsor_key'];
                   $data['sponsor_wallet'] = $this->User_model->get_wallet($sponsor_key);
                   $data['e_wallet'] = $this->User_model->get_wallet($username);

                     $B_wallet = $data['e_wallet']['B_wallet'];
                     $L_wallet = $data['sponsor_wallet']['L_wallet'];


                     $update_Lwallet = $L_wallet +800;


                     $update_bwallet = $B_wallet + 500;

                      $sponsor_panel = array(

                          'L_wallet' => $update_Lwallet
                         
                     );
                     $this->db->where('username', $sponsor_key);
                     $this->db->update('user_wallet', $sponsor_panel);
                 
                      
                       $wallet_panel = array(

                          'B_wallet' => $update_bwallet
                         
                     );
                     $this->db->where('user_id', $user_id);
                     $this->db->update('user_wallet', $wallet_panel);

                      $date = date('jS / F / Y');
                  
                 if ($data['user_info']['help_key']==false) {
                     $help_level ='';
                    }else{
                   $help_level = $data['user_info']['help_key'];
                   }
                  
                  $data = array(
                    'user_first_name' => $user_first_name,
                    'user_last_name' => $user_last_name,
                    'user_id' => $user_id,
                    'username' => $username,
                    'sponsor_key' => $sponsor_key,
                    'help_key' =>$help_level,
                    'date' => $date

                  );
                  $this->db->insert($level, $data);
                
 
}


    }



  }

}


if ($this->User_model->table_level_six()==true) {
    $leveltwo = $this->User_model->table_level_six();
    foreach ($levelsix as $level){
      $username =  $level['username'];
       $data['user_info'] = $this->User_model->user_info($username);
        $id = $data['user_info']['id'];
       if ($this->User_model->levelsix_count($username,$id)>=14) {
           $username =  $level['username'];
           $data['user_info'] = $this->User_model->user_info($username);
                    $level = "levelseven";
                $user_id = $data['user_info']['user_id'];
                 if ($this->User_model->user_level($level, $user_id)==false) {
                   $user_first_name = $data['user_info']['user_first_name'];
                   $user_last_name = $data['user_info']['user_last_name'];
                   $user_id = $data['user_info']['user_id'];
                     

                   $username = $data['user_info']['username'];
                   $sponsor_key = $data['user_info']['sponsor_key'];
                   $data['sponsor_wallet'] = $this->User_model->get_wallet($sponsor_key);
                   $data['e_wallet'] = $this->User_model->get_wallet($username);

                     $B_wallet = $data['e_wallet']['B_wallet'];
                     $L_wallet = $data['sponsor_wallet']['L_wallet'];


                     $update_Lwallet = $L_wallet +4000;


                     $update_bwallet = $B_wallet + 1000;

                      $sponsor_panel = array(

                          'L_wallet' => $update_Lwallet
                         
                     );
                     $this->db->where('username', $sponsor_key);
                     $this->db->update('user_wallet', $sponsor_panel);
                 
                      
                       $wallet_panel = array(

                          'B_wallet' => $update_bwallet
                         
                     );
                     $this->db->where('user_id', $user_id);
                     $this->db->update('user_wallet', $wallet_panel);

                      $date = date('jS / F / Y');
                  
                  if ($data['user_info']['help_key']==false) {
                     $help_level ='';
                    }else{
                   $help_level = $data['user_info']['help_key'];
                   }
                  
                  $data = array(
                    'user_first_name' => $user_first_name,
                    'user_last_name' => $user_last_name,
                    'user_id' => $user_id,
                    'username' => $username,
                    'sponsor_key' => $sponsor_key,
                    'help_key' =>$help_level,
                    'date' => $date

                  );
                  $this->db->insert($level, $data);
                
 
}


    }



  }

}



if ($this->User_model->table_level_seven()==true) {
    $leveltwo = $this->User_model->table_level_seven();
    foreach ($levelseven as $level){
      $username =  $level['username'];
       $data['user_info'] = $this->User_model->user_info($username);
        $id = $data['user_info']['id'];
       if ($this->User_model->levelseven_count($username,$id)>=14) {
           $username =  $level['username'];
           $data['user_info'] = $this->User_model->user_info($username);
                    $level = "leveleight";
                $user_id = $data['user_info']['user_id'];
                 if ($this->User_model->user_level($level, $user_id)==false) {
                   $user_first_name = $data['user_info']['user_first_name'];
                   $user_last_name = $data['user_info']['user_last_name'];
                   $user_id = $data['user_info']['user_id'];
                     

                   $username = $data['user_info']['username'];
                   $sponsor_key = $data['user_info']['sponsor_key'];
                   $data['sponsor_wallet'] = $this->User_model->get_wallet($sponsor_key);
                   $data['e_wallet'] = $this->User_model->get_wallet($username);

                     $B_wallet = $data['e_wallet']['B_wallet'];
                     $L_wallet = $data['sponsor_wallet']['L_wallet'];


                     $update_Lwallet = $L_wallet +20000;


                     $update_bwallet = $B_wallet + 2000;

                      $sponsor_panel = array(

                          'L_wallet' => $update_Lwallet
                         
                     );
                     $this->db->where('username', $sponsor_key);
                     $this->db->update('user_wallet', $sponsor_panel);
                 
                      
                       $wallet_panel = array(

                          'B_wallet' => $update_bwallet
                         
                     );
                     $this->db->where('user_id', $user_id);
                     $this->db->update('user_wallet', $wallet_panel);

                      $date = date('jS / F / Y');
                  
                  if ($data['user_info']['help_key']==false) {
                     $help_level ='';
                    }else{
                   $help_level = $data['user_info']['help_key'];
                   }
                  
                  $data = array(
                    'user_first_name' => $user_first_name,
                    'user_last_name' => $user_last_name,
                    'user_id' => $user_id,
                    'username' => $username,
                    'sponsor_key' => $sponsor_key,
                    'help_key' =>$help_level,
                    'date' => $date

                  );
                  $this->db->insert($level, $data);
                
 
}


    }



  }

}



if ($this->User_model->table_level_eight()==true) {
    $leveltwo = $this->User_model->table_level_eight();
    foreach ($leveleight as $level){
      $username =  $level['username'];
       $data['user_info'] = $this->User_model->user_info($username);
        $id = $data['user_info']['id'];
       if ($this->User_model->leveleight_count($username,$id)>=14) {
           $username =  $level['username'];
           $data['user_info'] = $this->User_model->user_info($username);
                    $level = "levelnine";
                $user_id = $data['user_info']['user_id'];
                 if ($this->User_model->user_level($level, $user_id)==false) {
                   $user_first_name = $data['user_info']['user_first_name'];
                   $user_last_name = $data['user_info']['user_last_name'];
                   $user_id = $data['user_info']['user_id'];
                     

                   $username = $data['user_info']['username'];
                   $sponsor_key = $data['user_info']['sponsor_key'];
                   $data['sponsor_wallet'] = $this->User_model->get_wallet($sponsor_key);
                   $data['e_wallet'] = $this->User_model->get_wallet($username);

                     $B_wallet = $data['e_wallet']['B_wallet'];
                     $L_wallet = $data['sponsor_wallet']['L_wallet'];


                     $update_Lwallet = $L_wallet +50000;


                     $update_bwallet = $B_wallet + 4000;

                      $sponsor_panel = array(

                          'L_wallet' => $update_Lwallet
                         
                     );
                     $this->db->where('username', $sponsor_key);
                     $this->db->update('user_wallet', $sponsor_panel);
                 
                      
                       $wallet_panel = array(

                          'B_wallet' => $update_bwallet
                         
                     );
                     $this->db->where('user_id', $user_id);
                     $this->db->update('user_wallet', $wallet_panel);

                      $date = date('jS / F / Y');
                  
                  if ($data['user_info']['help_key']==false) {
                     $help_level ='';
                    }else{
                   $help_level = $data['user_info']['help_key'];
                   }
                  
                  $data = array(
                    'user_first_name' => $user_first_name,
                    'user_last_name' => $user_last_name,
                    'user_id' => $user_id,
                    'username' => $username,
                    'sponsor_key' => $sponsor_key,
                    'help_key' =>$help_level,
                    'date' => $date

                  );
                  $this->db->insert($level, $data);
                
 
}


    }



  }

}



if ($this->User_model->table_level_nine()==true) {
    $leveltwo = $this->User_model->table_level_nine();
    foreach ($levelnine as $level){
      $username =  $level['username'];
       $data['user_info'] = $this->User_model->user_info($username);
        $id = $data['user_info']['id'];
       if ($this->User_model->levelnine_count($username,$id)>=14) {
           $username =  $level['username'];
           $data['user_info'] = $this->User_model->user_info($username);
                    $level = "levelten";
                $user_id = $data['user_info']['user_id'];
                 if ($this->User_model->user_level($level, $user_id)==false) {
                   $user_first_name = $data['user_info']['user_first_name'];
                   $user_last_name = $data['user_info']['user_last_name'];
                   $user_id = $data['user_info']['user_id'];
                     

                   $username = $data['user_info']['username'];
                   $sponsor_key = $data['user_info']['sponsor_key'];
                   $data['sponsor_wallet'] = $this->User_model->get_wallet($sponsor_key);
                   $data['e_wallet'] = $this->User_model->get_wallet($username);

                     $B_wallet = $data['e_wallet']['B_wallet'];
                     $L_wallet = $data['sponsor_wallet']['L_wallet'];


                     // $update_Lwallet = $L_wallet +50000;


                     $update_bwallet = $B_wallet + 10000;

                     //  $sponsor_panel = array(

                     //      'L_wallet' => $update_Lwallet
                         
                     // );
                     // $this->db->where('username', $sponsor_key);
                     // $this->db->update('user_wallet', $sponsor_panel);
                 
                      
                       $wallet_panel = array(

                          'B_wallet' => $update_bwallet
                         
                     );
                     $this->db->where('user_id', $user_id);
                     $this->db->update('user_wallet', $wallet_panel);

                      $date = date('jS / F / Y');
                  
                   if ($data['user_info']['help_key']==false) {
                     $help_level ='';
                    }else{
                   $help_level = $data['user_info']['help_key'];
                   }
                  
                  $data = array(
                    'user_first_name' => $user_first_name,
                    'user_last_name' => $user_last_name,
                    'user_id' => $user_id,
                    'username' => $username,
                    'sponsor_key' => $sponsor_key,
                    'help_key' =>$help_level,
                    'date' => $date

                  );
                    $this->db->insert($level, $data);
                
 
}


    }



  }

}








}

        ////////////////////////////////////////////////////////////// Register New User Into Database
    public function add_user()
    {

                  $username = $_SESSION['username'];
                 $data['user_info'] = $this->User_model->user_info($username);
  if ($data['user_info']['user_status']==false) {
    $data['title'] = "Update Profile";
    $this->load->view('user/update_status', $data);
  }else{



        $this->form_validation->set_rules('user_mobile', 'User Mobile Number', 'trim|required|min_length[11]|max_length[15]|numeric');
        
           $this->form_validation->set_rules('title', 'User Title', 'trim|required');
         $this->form_validation->set_rules('user_email', 'Email Address', 'trim|required|valid_email');
         $this->form_validation->set_rules('user_country', 'User Country', 'trim|required');
         $this->form_validation->set_rules('user_state', 'User State', 'trim|required');
         $this->form_validation->set_rules('user_city', 'User City', 'trim|required');
          $this->form_validation->set_rules('user_first_name', 'User First Name', 'trim|required');
          $this->form_validation->set_rules('user_last_name', 'User Last Name', 'trim|required');
         // remeber |callback_username_check function
          $this->form_validation->set_rules('username', 'Username', 'trim|required|callback_check_username_exists|callback_e_wallet_balance');
          $this->form_validation->set_rules('zip_code', 'Zip Code', 'trim|required');
            $this->form_validation->set_rules('package_id', 'Package Stage', 'required');

           $this->form_validation->set_rules('agree', 'Agree With Terms & Condition', 'required');

           
           

        if ($this->form_validation->run() == FALSE) {
                       $username =  $_SESSION['username'];             
                      $data['user_data'] = $this->User_model->user_info($username);
              $data['user_info'] = $this->User_model->user_info($username);
                      $data['title'] = 'Add User'; // Capitalize the first letter
                        // $data['user_data']['sponsor_key '];
                    $this->load->view('template/user_header', $data);
                    $this->load->view('user/sign_user', $data);
                    $this->load->view('template/user_footer', $data);
        } else {
                            // Check and regenerate UserID
                        // $user_id = rand(000000,99999);
            $data['user_info'] = $this->User_model->user_info($username);
              $user_id = $data['user_info']['user_id'];
              $data['leg_return'] = $this->User_model->placement($user_id);
               $username_id = "BB".$this->generate_user_id();
               $side =   $data['leg_return']['last_placement'];
                    //Check User Side and Change FUnction
                      if ($side=='left') {
                       $left_leg = "left";
                       $right_leg ='';
                      }else{
                        $right_leg = "right";
                        $left_leg ='';
                      }
                         
               
                      // echo $left_leg.' '.$right_leg;
                      // die();
                      $date = date('jS/F/Y');
                    
                        $last_User =  $this->generate_user_id(); 
                        $username = $_SESSION['username'];
            
              $data['leg_return'] = $this->User_model->placement($user_id);
               $side =   $data['leg_return']['last_placement'];

                if($this->User_model->user_info($username)['leg_complete']==false && $this->User_model->get_left($username)['last_placement']=='left'){


                       $data['last_sponsor']= $this->User_model->get_node($username);
                                           $rightleg = $data['last_sponsor']['rgt'];

                                        $sql = "UPDATE belbec_user
                                             SET lft = (CASE WHEN lft >='$rightleg' THEN lft + 2 ELSE lft END),
                                                 rgt = (CASE WHEN rgt >= '$rightleg' THEN rgt + 2 ELSE rgt END)
                                           WHERE rgt >= '$rightleg'
                                          ";

                                          $this->db->query($sql);


                                         $left_work = $rightleg;

                                        $right_work =  $rightleg +1;


                     
                                      
                        
            }elseif ($this->User_model->user_info($username)['leg_complete']==false && $this->User_model->get_left($username)['last_placement']=='right') {
                      
                      $data['last_sponsor']= $this->User_model->get_node($username);
                                           $myleft = $data['last_sponsor']['lft'];

                                        $sql = "UPDATE belbec_user
                                             SET lft = (CASE WHEN lft >'$myleft' THEN lft + 2 ELSE lft END),
                                                 rgt = (CASE WHEN rgt > '$myleft' THEN rgt + 2 ELSE rgt END)
                                           WHERE rgt >= '$myleft'
                                          ";

                                          $this->db->query($sql);


                                         $left_work = $myleft+1;

                                          $right_work = $myleft +2;
                     }


                      $username = $_SESSION['username'];

   // && $this->User_model->get_left($username)['last_placement']=='left'
                  if($this->User_model->user_info($username)['leg_complete']==true){

                      $username = $_SESSION['username'];

                     if ($this->User_model->complete_leg($username)==TRUE) {
                        $data['complete_leg'] = $this->User_model->complete_leg($username);
                     // echo $data['complete_leg']['last_placement'];
                    if ($data['complete_leg']['last_placement']=='left') {
                         $data['complete_leg'] = $this->User_model->complete_leg($username);

                          $complete = array(
                       
                        'last_placement' =>'right',
                        // 'leg_complete' => '1'
                      );
                      $last=  $data['complete_leg']['username'];
                      $this->db->where('username', $last);
                      $this->db->update('belbec_user', $complete);



                      $helper_status = array(

                         'sponsor_key'=>$username,
                        'help_key'=> $last,
                        'username' => $this->input->post('username'),
                        'user_first_name'=>$this->input->post('user_first_name'),
                          'user_last_name'=> $this->input->post('user_last_name'),
                          'user_id'=>$username_id,
                          'join_date ' => $date

                      );
                      $this->db->insert('helper', $helper_status);

                       // $data['last_sponsor']= $this->User_model->get_node($username);
                                           $rightleg =  $data['complete_leg']['rgt'];

                                        $sql = "UPDATE belbec_user
                                             SET lft = (CASE WHEN lft >='$rightleg' THEN lft + 2 ELSE lft END),
                                                 rgt = (CASE WHEN rgt >= '$rightleg' THEN rgt + 2 ELSE rgt END)
                                           WHERE rgt >= '$rightleg'
                                          ";

                                          $this->db->query($sql);


                                         $left_work = $rightleg;

                                        $right_work =  $rightleg +1;


                                     



                      
                    }elseif( $data['complete_leg']['last_placement']=='right'){
                           $data['complete_leg'] = $this->User_model->complete_leg($username);

                            $myleft =  $data['complete_leg']['lft'];
                        $complete = array(
                        'last_placement' =>'left'
                      );
                      $last=  $data['complete_leg']['username'];
                      $this->db->where('username', $last);
                      $this->db->update('belbec_user', $complete);



                      $helper_status = array(

                        'sponsor_key'=>$username,
                        'help_key'=> $last,
                        'username' => $this->input->post('username'),
                        'user_first_name'=>$this->input->post('user_first_name'),
                          'user_last_name'=> $this->input->post('user_last_name'),
                          'user_id'=>$username_id,
                          'join_date ' => $date


                      );
                      $this->db->insert('helper', $helper_status);


                      $sql = "UPDATE belbec_user
                                             SET lft = (CASE WHEN lft >'$myleft' THEN lft + 2 ELSE lft END),
                                                 rgt = (CASE WHEN rgt > '$myleft' THEN rgt + 2 ELSE rgt END)
                                           WHERE rgt >= '$myleft'
                                          ";

                                         $this->db->query($sql);


                                         $left_work = $myleft+1;

                                          $right_work = $myleft +2;

                    }
                     }elseif ($this->User_model->complete_leg($username)==false) {
                       if($this->User_model->get_left($username)['last_placement']=='left'){


                       $data['last_sponsor']= $this->User_model->get_node($username);
                                           $rightleg = $data['last_sponsor']['rgt'];

                                        $sql = "UPDATE belbec_user
                                             SET lft = (CASE WHEN lft >='$rightleg' THEN lft + 2 ELSE lft END),
                                                 rgt = (CASE WHEN rgt >= '$rightleg' THEN rgt + 2 ELSE rgt END)
                                           WHERE rgt >= '$rightleg'
                                          ";

                                          $this->db->query($sql);


                                         $left_work = $rightleg;

                                        $right_work =  $rightleg +1;


                     
                                      
                        
            }elseif ($this->User_model->get_left($username)['last_placement']=='right') {
                      
                      $data['last_sponsor']= $this->User_model->get_node($username);
                                           $myleft = $data['last_sponsor']['lft'];

                                        $sql = "UPDATE belbec_user
                                             SET lft = (CASE WHEN lft >'$myleft' THEN lft + 2 ELSE lft END),
                                                 rgt = (CASE WHEN rgt > '$myleft' THEN rgt + 2 ELSE rgt END)
                                           WHERE rgt >= '$myleft'
                                          ";

                                          $this->db->query($sql);


                                         $left_work = $myleft+1;

                                          $right_work = $myleft +2;
                     }
                     }
                  }

                    
                         $leg = $this->placement();
                           $data['leg_return'] = $this->User_model->placement($user_id);
               $side =   $data['leg_return']['last_placement'];

                                            $data = array( 
                                'user_id'=>$username_id,
                              'username'=>$this->input->post('username'),
                               'sponsor_key' => $this->input->post('sponsor_key'),
                               'title'=>$this->input->post('title'),
                                'user_email'=>$this->input->post('user_email'),
                                 'user_mobile'=>$this->input->post('user_mobile'),
                               'user_first_name'=>$this->input->post('user_first_name'),
                                'user_last_name'=> $this->input->post('user_last_name'),
                                 'user_country'=>$this->input->post('user_country'),
                                 'user_state'=>$this->input->post('user_state'),
                                 'user_state'=>$this->input->post('user_state'),
                               'user_city'=> $this->input->post('user_city'),
                               'user_address'=> $this->input->post('user_address'),
                               'placement' => $side,
                               'package_id'=> $this->input->post('package_id'),
                                'left_leg' => $left_leg,
                                'right_leg' => $right_leg,
                               'user_gender'=> $this->input->post('user_gender'),
                               'zip_code'=> $this->input->post('zip_code'),
                               'join_date ' => $date,
                               'stage' => 1,
                               'lft' => $left_work,
                               'rgt' => $right_work,
                               'user_number' => $last_User
                               // 'last_placement' => $leg

 


                        );
                   $this->db->insert('belbec_user', $data);

                   // $data['complete_leg'] = $this->User_model->complete_leg($username);
                   //                            $last=  $data['complete_leg']['username'];
                   //                           if ($this->User_model->get_numberlevelone($last)==2) {
                      //            $complete_leg = array(
                      //   'leg_complete' => '1'
                      // );
                      // //$last=  $data['complete_leg']['username'];
                      //           // $uername = $_SESSION['username'];
                      // $this->db->where('username', $last);
                      // $this->db->update('belbec_user', $complete_leg);
                   //          }
                

                       



                   $user_login_table = array(
                  'username_id' => $username_id,
                  'username' => $this->input->post('username'),
                  'username_password'=>md5($this->input->post('password')),
                   'user_id_password'=>md5($this->input->post('password'))
                 );
                  $this->db->insert('user_login_table', $user_login_table);
                  
                    $username =  $_SESSION['username'];             
                      $data['user_data'] = $this->User_model->user_info($username);
                   

                    

                   $user_wallet = array(
                  'user_id' => $username_id,
                  'username' => $this->input->post('username')
                 );
                  $this->db->insert('user_wallet', $user_wallet);
                   

                   //Update The Referral Account Wallet With 2$
                     $username = $_SESSION['username'];
                       $data['user_info'] = $this->User_model->user_info($username);
                      $user_id = $data['user_info']['user_id'];
                      $data['e_wallet'] = $this->User_model->get_wallet($username);

                    $Intial_wallet = $data['e_wallet']['R_wallet'];
                    $general_wallet = $data['e_wallet']['G_wallet'];
                    //Charge the refferal Charges $10
                    $general_charge = $general_wallet - 10;
                      $date = date('jS/F/Y');
                     $deduction_fee = array(
                    'sender_id' =>  $user_id,
                    'reciever_id' => $this->input->post('username'),
                    'amount' => 10,
                    'transaction_id' =>'Debit',
                    'amount_type' =>'Refferral Charges',
                    'date' => $date
                  );

                  $this->db->insert('transfer', $deduction_fee);




                    //Reward The Balance the with $2
                    $refferal_reward = $Intial_wallet+2;


                      $refferal_bonus = array(
                    'sender_id' =>  $user_id,
                    'reciever_id' => $this->input->post('username'),
                    'amount' => 2,
                    'transaction_id' =>'Credit',
                    'amount_type' =>'Refferral Bonus',
                    'date' => $date
                  );

                  $this->db->insert('transfer', $refferal_bonus);

                    $update_ref_wallet = array(
                  'R_wallet' => $refferal_reward,
                  'G_wallet' => $general_charge
                 );
                    $username =  $_SESSION['username'];
                  $this->db->where('username', $username);
                  $this->db->update('user_wallet', $update_ref_wallet);

                //   // Update The user Leg table Tree
                   $data['user_info'] = $this->User_model->user_info($username);
                $user_id = $data['user_info']['user_id'];
                  $leg = $this->placement();
                  $data = array(
                    'last_placement' => $leg
                  );
                   $username =  $_SESSION['username'];
                  $this->db->where('user_id', $user_id);
                  $this->db->update('belbec_user', $data);
 // $username_id


                     // $username = $_SESSION['username'];

                
              

                          $admin_tracker = array(
                            'sponsor' =>$username,
                            'new_member' => $username_id,
                            'new_username' => $this->input->post('username'),
                            'charge_get' => 8,
                            'email' =>$this->input->post('user_email')

                         );
                          $this->db->insert('admin_newmember_tracker', $admin_tracker);



                        $username =  $_SESSION['username'];             
                      $data['user_data'] = $this->User_model->user_info($username);
                   
                        if ($this->User_model->get_numberlevelone($username)==2) {
                                 $complete = array(
                        'leg_complete' => '1'
                      );
                      //$last=  $data['complete_leg']['username'];
                                 $uername = $_SESSION['username'];
                      $this->db->where('username', $username);
                      $this->db->update('belbec_user', $complete);
                            }

                
                    $data['title'] = 'Add New User'; // Capitalize the first letter
                     $username =  $_SESSION['username'];
                     $data['side']   = $side;         
                    $data['user_data'] = $this->User_model->user_info($username);     
                     $this->load->view('template/user_header', $data);
                    $this->load->view('user/add_user_confirm', $data);
                    $this->load->view('template/user_footer', $data);
                      echo "<script type='text/javascript'>
                  $(document).ready(function(){
                  
                  $('#Modal').modal('show');
                  });
                  </script>";
        }
         
    }}


    public function search_geanology($level)
    {
      // echo $this->input->post('name');
      // echo $level;
      $this->form_validation->set_rules('name', 'search Id', 'trim|required|callback_confirm_username');
      if ($this->form_validation->run() == FALSE) {
       echo "<script>alert('Kindly Provide Valid Username ID')</script>";
       $this->tree_user();
      } else {
         $data['username'] = $this->input->post('name');
         $username = $this->input->post('name');
         $data['title'] = $username.' '."Downline"; // Capitalize the first letter
                    
                     $data['user_info']  = $this->User_model->get_searchone($username);
                    $this->load->view('template/user_header', $data);
                    $this->load->view('user/get_user', $data);
                    $this->load->view('template/user_footer', $data);
      }
    }




       public function search_level($level)
    {
      // echo $this->input->post('name');
      // echo $level;
      $this->form_validation->set_rules('name', 'search Id', 'trim|required|callback_confirm_username');
      if ($this->form_validation->run() == FALSE) {
       echo "<script>alert('Kindly Provide Valid Username ID')</script>";
       $this->tree_user();
      } else {
        $data['level'] = $level;
         $data['user_id'] = $this->input->post('name');
         $username = $this->input->post('name');
         $data['title'] = $username.' '."Downline"; // Capitalize the first letter
                    // $level,$user_id
                      $data['user_info'] = $this->User_model->get_data($username);
                      $user_id = $data['user_info']['id'];

                      $data['id'] = $data['user_info']['id'];

                       if ($this->User_model->getmatrix($level, $user_id,$username)== FALSE) {
                     echo "<script>alert('Kindly Provide Valid Username ID')</script>";
                     $this->tree_user();
                    } 
                     $data['getMain']  = $this->User_model->getmatrix($level, $user_id,$username);
                    $this->load->view('template/user_header', $data);
                    $this->load->view('user/searchuser', $data);
                    $this->load->view('template/user_footer', $data);
      }
    }




    public function update_left()
    {
           $data['last_sponsor']= $this->User_model->get_node($username);
                                           $myleft = $data['last_sponsor']['lft'];

                                        $sql = "UPDATE belbec_user
                                             SET lft = (CASE WHEN lft >'$myleft' THEN lft + 2 ELSE lft END),
                                                 rgt = (CASE WHEN rgt > '$myleft' THEN rgt + 2 ELSE rgt END)
                                           WHERE rgt >= '$myleft'
                                          ";

                                          $this->db->query($sql);


                                         $left_work = $myleft+1;

                                          $right_work = $myleft +2;
    }
public function yes()
{

                $username = $_SESSION['username'];

    $data['last_sponsor']= $this->User_model->get_node($username);
                                         echo  $rightleg = $data['last_sponsor']['rgt'];

                                        $sql = "UPDATE belbec_user
                                             SET lft = (CASE WHEN lft >='$rightleg' THEN lft + 2 ELSE lft END),
                                                 rgt = (CASE WHEN rgt >= '$rightleg' THEN rgt + 2 ELSE rgt END)
                                           WHERE rgt >= '$rightleg'
                                          ";

                                          // $this->db->query($sql);


                                         $left_work = $rightleg;

                                        $right_work =  $rightleg +1;
}

    public function get_postion($side)
    {
      if ($side=='left') {
        return $left_leg=='left';
      }else{
        return $right_leg=='right';
      }
    }

//message Line 
    public function confirm_new()
    {
      $username= $_SESSION['username'];
      $data['title'] ='';
      $data['user_data'] = $this->User_model->user_info($username);     
                     $this->load->view('template/user_header', $data);
                    $this->load->view('user/add_user_confirm', $data);
                    $this->load->view('template/user_footer', $data);
    }


//\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\End Controller\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
                //check username eixst already
                  public function check_username_exists($username)
                  {


                       $this->form_validation->set_message('check_username_exists', 'The Username Already Exits ');
                    if ($this->User_model->check_username_exists($username)) {
                            return true;
                    }else{
                            return false;
                    }
                  }


             

                  //check the user E-wallet
                    public function e_wallet_balance()
                    {            $username = $_SESSION['username'];
                 $data['user_info'] = $this->User_model->user_info($username);
              if ($data['user_info']['user_status']==false) {
                $data['title'] = "Update Profile";
    $this->load->view('user/update_status', $data);
              }else{


                      $username = $_SESSION['username'];
                       $data['user_info'] = $this->User_model->user_info($username);
                      $user_id = $data['user_info']['user_id'];
                      $data['e_wallet'] = $this->User_model->get_wallet($username);
                       $balance = $data['e_wallet']['G_wallet'];
                           if ($balance<1)
                        {
                                $this->form_validation->set_message('e_wallet_balance', 'The minimum Refferal Balance is low for add new user $10 ');
                                return FALSE;
                        }
                        else
                        {
                                return TRUE;
                        }
                    }}




                     public function wallet_withdraw()
                    {



                      $username = $_SESSION['username'];
                       $data['user_info'] = $this->User_model->user_info($username);
                      $user_id = $data['user_info']['user_id'];
                      $data['e_wallet'] = $this->User_model->get_wallet($username);
                       $balance = $data['e_wallet']['G_wallet'];
                           if ($balance<100)
                        {
                                $this->form_validation->set_message('wallet_withdraw', 'The G Wallet Account Fund is Insufficent ');
                                return FALSE;
                        }
                        else
                        {
                                return TRUE;
                        }
                    }

                //Generate the UserId for the New User
                     public   function generate_user_id()
                        {
                            
                             // $user_id = "BB".rand(0000,9999).rand(000,999);
                          $data['last_id'] = $this->User_model->get_last_list();
                                $user_id = $data['last_id']['user_number'] + 1;
                             // $row = $query->last_row(‘array’);
                            if ($this->User_model->check_user_id($user_id)) {
                                generate_user_id();
                            }

                            return $user_id;
                        }


      public function users_table()
    {
                     $username = $_SESSION['username'];
                 $data['user_info'] = $this->User_model->user_info($username);
  if ($data['user_info']['user_status']==false) {
    $data['title'] = "Update Profile";
    $this->load->view('user/update_status', $data);
  }else{ $data['title'] = ''; // Capitalize the first letter
                    $this->load->view('template/user_header', $data);
                    $this->load->view('user/info_table', $data);
                    $this->load->view('template/user_footer', $data);
    }}


//Check Username if Available IN Belbec Database 
               public function username_check($str)
        {
                if ($str == 'test')
                {
                        $this->form_validation->set_message('username_check', 'The {field} field can not be the word "test"');
                        return FALSE;
                }
                else
                {
                        return TRUE;
                }
        }


//Leg Placement for user
        public function placement()
        {
               $username = $_SESSION['username'];
              $data['user_info'] = $this->User_model->user_info($username);
              $user_id = $data['user_info']['user_id'];
              $data['leg_return'] = $this->User_model->placement($user_id);
              // print_r($this->User_model->placement($user_id));
                  if ($data['leg_return']['last_placement']=="left") {
                     return "right";
                  }elseif($data['leg_return']['last_placement']=="right"){
                     return "left";
                  }

    
        }



      public function profile($error=null)
    {
                        $data['title'] = 'Profile'; 
                        $username =  $_SESSION['username'];             
                      $data['user_info'] = $this->User_model->user_info($username);
                      $data['access_key'] = $this->User_model->access_key($username);

                      $data['error']= $error;

                     $this->load->view('template/user_header', $data);
                    $this->load->view('user/profile', $data);
                   $this->load->view('template/user_footer', $data);
    }



    public function confirm_password_key($password)
    {
      
    }

      public function correct_password()
    {


      $this->form_validation->set_rules('newpassword', 'New Password', 'trim|required|matches[conpassword]|min_length[6]');
       $this->form_validation->set_rules('conpassword', 'Confirm Password', 'trim|required');

      if ($this->form_validation->run() == FALSE) {
        $this->profile();
      } else {
         $update_profile = array(
                
                    'username_password'=> $this->input->post('newpassword')
        );
        $this->db->where('username_id', $this->input->post('user_id'));
                      $this->db->update('user_login_table', $update_profile);
                      $this->session->set_flashdata("change_password","Password Successfully Changed");

        $this->profile();
        // redirect('Page/logout','refresh');
      }
    }



     public function update_profile()
    {


      $this->form_validation->set_rules('user_email', 'Email Address', 'trim|required|valid_email');
         $this->form_validation->set_rules('user_country', 'Country', 'trim|required');
         $this->form_validation->set_rules('user_state', 'State', 'trim|required');
         $this->form_validation->set_rules('user_address', 'Adress', 'trim|required');
         $this->form_validation->set_rules('user_city', 'City', 'trim|required');
         // remeber |callback_username_check function
          $this->form_validation->set_rules('user_mobile', 'Mobile Number', 'trim|required|min_length[11]|numeric');
          $this->form_validation->set_rules('zip_code', 'Zip Code', 'trim|required');


      if ($this->form_validation->run() == FALSE) {
        $this->profile();
      } else {
        $update_profile = array(
                'user_email' => $this->input->post('user_email'),
                'user_state' => $this->input->post('user_state'),
                 'user_country' => $this->input->post('user_country'),
                 'user_city' => $this->input->post('user_city'),
                  'user_mobile' => $this->input->post('user_mobile'),
                   'zip_code' => $this->input->post('zip_code'),
                    'user_address'=> $this->input->post('user_address')
        );
        $this->db->where('user_id', $this->input->post('user_id'));
                      $this->db->update('belbec_user', $update_profile);
                      $this->session->set_flashdata("update_profile","Profile Successfully Updated");


        $this->profile();
      }
    }


    // E-Wallet Controller Section
    //Check the G wallet Balance

    public function check_withdraw_balance($amount)
    {
      $this->form_validation->set_message('check_withdraw_balance','The Account Balance is too Low for Amount to Withdraw');


                   $username = $_SESSION['username'];
                       $data['user_info'] = $this->User_model->user_info($username);
                      $user_id = $data['user_info']['user_id'];
                      $data['e_wallet'] = $this->User_model->get_wallet($username);
                      $G_wallet = $data['e_wallet']['G_wallet'];

                      if ($amount<$G_wallet) {
                        return true;
                      }else{
                        return false;
                      }

    }
    //Add New Payment Application

      public function withdraw_fund()
    {               
if (!$this->session->userdata('wallet_logged_in') ) {
       

  redirect('wallet/login','refresh');
          
  }
           $this->form_validation->set_rules('amount', 'Amount Request', 'trim|required|numeric|integer|min_length[2]|callback_wallet_withdraw|callback_check_withdraw_balance');
           $this->form_validation->set_rules('acct_number', 'Account Number', 'trim|required');
                  if ($this->form_validation->run() == FALSE) {
                    $data['title'] = 'Withdraw Fund'; 
                         $username = $_SESSION['username'];
                       $data['user_info'] = $this->User_model->user_info($username);
                      $user_id = $data['user_info']['user_id'];
                      $data['e_wallet'] = $this->User_model->get_wallet($username);

                    $data['user_data'] = $this->User_model->user_info($username);
                     $this->load->view('template/user_header', $data);
                    $this->load->view('user/withdraw', $data);
                   $this->load->view('template/user_footer', $data);
                  } else {
                    $data['title'] = 'Withdraw Fund'; 
                        $username = $_SESSION['username'];
                       $data['user_info'] = $this->User_model->user_info($username);
                      $user_id = $data['user_info']['user_id'];
                      $data['e_wallet'] = $this->User_model->get_wallet($username);

                    $data['user_data'] = $this->User_model->user_info($username);

                    $date = date('dS-m-Y');
                    $data = array(
                      'user_id' =>$user_id,
                      'acct_number' =>$this->input->post('acct_number') ,
                      'amount' => $this->input->post('amount'),
                      'balance' =>$this->input->post('G_wallet'),
                      'bank_name' =>$this->input->post('bank_name'),
                      'acct_name' =>$this->input->post('acct_name'),
                      'date' =>$date
                    );

                    $this->db->insert('withdraw_request', $data);

                    $g_wallet = $this->input->post('G_wallet');
                    $amount = $this->input->post('amount');

                    $amount_balance = $g_wallet-$amount;


                    $balance = array(
          
           'G_wallet' => $amount_balance

        );

        $this->db->where('user_id', $user_id);
        $this->db->update('user_wallet', $balance);


                     $this->session->set_flashdata("succes_withdraw_request","Withdraw Request successfully Done");
                      $data['title'] = 'Withdraw Fund'; 
                        $username = $_SESSION['username'];
                       $data['user_info'] = $this->User_model->user_info($username);
                      $user_id = $data['user_info']['user_id'];
                      $data['e_wallet'] = $this->User_model->get_wallet($username);

                    $data['user_data'] = $this->User_model->user_info($username);
                     $this->load->view('template/user_header', $data);
                    $this->load->view('user/withdraw', $data);
                   $this->load->view('template/user_footer', $data);
                  }
                  
    }


    public function fund_account()
    {               
if (!$this->session->userdata('wallet_logged_in') ) {
       

  redirect('wallet/login','refresh');
          
  }
      $this->form_validation->set_rules('user_id', 'User Id', 'trim|required');
      $this->form_validation->set_rules('user_email', 'Email Address', 'trim|required|valid_email');
          $this->form_validation->set_rules('user_mobile', 'Mobile Number', 'trim|required');
           $this->form_validation->set_rules('amount', 'Amount Request', 'trim|required|numeric|integer|min_length[2]');

                  if ($this->form_validation->run() == FALSE) {
                    $data['title'] = 'Add Fund'; 
                         $username =  $_SESSION['username'];             
                    $data['user_data'] = $this->User_model->user_info($username);
                     $this->load->view('template/user_header', $data);
                    $this->load->view('user/add_fund', $data);
                   $this->load->view('template/user_footer', $data);
                  } else {
                      $data['title'] = 'Add Fund'; 
                         $username =  $_SESSION['username'];             
                    $data['user_data'] = $this->User_model->user_info($username);
                    $this->User_model->fund_account();
                     $this->load->view('template/user_header', $data);
                    $this->load->view('user/add_fund', $data);
                   $this->load->view('template/user_footer', $data);
                  }
                  
    }

      //Add Stage Display
     public function stage()
    {
                    $data['title'] = 'Stage 1'; 

                     $this->load->view('template/user_header', $data);
                    $this->load->view('user/stage', $data);
                   $this->load->view('template/user_footer', $data);
    }

 
                 public function error($id, $user_id)
                {
                  if (empty($id || $user_id)) {
                    show_404();
                  }

                }
    //Varify Payment After 
    public function verify_payment($id=false)
    {
     
if (!$this->session->userdata('wallet_logged_in') ) {
       

  redirect('wallet/login','refresh');
          
  }
      $username = $_SESSION['username'];
     if ($id==false) {
       show_404();
     }elseif ( $this->User_model->confirm_fund_id($id)==$username) {
      
                       
      $this->form_validation->set_rules('payment_date', 'Payment Date', 'trim|required');

      if ($this->form_validation->run() == FALSE) {
          $data['title'] = 'Verify Payment'; 
                     $username =  $_SESSION['username'];             
  $data['user_data'] = $this->User_model->user_info($username);
    $data['fund_request'] = $this->User_model->get_fund_details($id);
                     $this->load->view('template/user_header', $data);
                    $this->load->view('user/verify_payment', $data);
                   $this->load->view('template/user_footer', $data);
      } else {


                                        
                // $user =$_SESSION['username'];
                $config['upload_path'] = './assets/image/payment_pic';
                $config['allowed_types'] = 'gif|jpg|png|JPG|PNG|JPEG|jpeg|GIF';
                $config['max_size']     = '0';
                 $config['max_width']  = '0';
                $config['max_height']  = '0';
                $config['file_name'] = $_FILES["userfile"]['name'];
                $config['overwrite']= TRUE;

                $this->load->library('upload', $config);

                     if ( !$this->upload->do_upload('userfile'))
                                {
                                        $error = array('error' => $this->upload->display_errors());

                                        $payment = "icon.png";
                                }
                                else
                                {

                                   // $user =$_SESSION['username'];
                                        $data = array('upload_data' => $this->upload->data());
                                       
                                        $payment = $_FILES['userfile']['name'];

                                }


                                  $transaction_id = rand(00000,9999).rand(00000,99999).rand(0000,88888);
        $data = array(
          'payment_date' =>$this->input->post('payment_date'),
           'image' =>$payment,
           'status'=>'process',
           'transcation_id' => $transaction_id

        );

        $this->db->where('id', $id);
        $this->db->update('request_fund', $data);
         $data['title'] = 'Verify Payment'; 
                     $username =  $_SESSION['username'];             
  $data['user_data'] = $this->User_model->user_info($username);
    $data['fund_request'] = $this->User_model->get_fund_details($id);
    $this->session->set_flashdata('payment_reciept', 'Receipte Data Succefully Added');
                     $this->load->view('template/user_header', $data);
                    $this->load->view('user/verify_payment', $data);
                   $this->load->view('template/user_footer', $data);
      }


     }elseif($this->User_model->confirm_fund_id($id)!==$username){
      echo "ERROR";
     }
     

  
    }

    public function upload_fund_request($id)
    {
                       
    }

    // public function verify_id($id == false)
    // {
    //  if (empty($id)) {
    //     redirect('Page/logout','refresh');
    //     show_404();
    //   }else{
    //     $username =  $_SESSION['username'];
    //     $this->User_model->check_id($id,$username);
    //   }
    // }




    //COnfirm 


       //Tranfer Fund from users Payment After 


        public function amount_balance($amount)
                    {


                      $username = $_SESSION['username'];
                       $data['user_info'] = $this->User_model->user_info($username);
                      $user_id = $data['user_info']['user_id'];
                      $data['e_wallet'] = $this->User_model->get_wallet($username);
                       $balance = $data['e_wallet']['G_wallet'];
                           if ($balance<$amount)
                        {
                                $this->form_validation->set_message('amount_balance', 'Insufficent Balance for Wallet Transfer Kindly Fund Account');
                                return FALSE;
                        }
                        else
                        {
                                return TRUE;
                        }
                    }

                      public function sender_status($r_userid)
                    {


                      $username = $_SESSION['username'];
                       $data['user_info'] = $this->User_model->user_info($username);
                      $user_id = $data['user_info']['user_id'];
                        $this->form_validation->set_message('sender_status', 'Invalid Account');
                           if ($r_userid===$user_id)
                        {
                              
                                return true;
                        }
                        else
                        {
                                return false;
                        }
                    }



                    public function confirm_transfer_user()
                    {

                             $this->form_validation->set_rules('r_userid', 'Receiver Wallet ID', 'trim|required|callback_sender_status');
                   // $data['receive_user'] = '';

                      if ($this->form_validation->run() ==FALSE) {
                         $username = $_SESSION['username'];
                       $data['user_info'] = $this->User_model->user_info($username);
                      $user_id = $data['user_info']['user_id'];
                      $data['e_wallet'] = $this->User_model->get_wallet($username);

                    $data['title'] = 'Transfer Fund'; 
                     $username =  $_SESSION['username'];             
               $data['user_data'] = $this->User_model->user_info($username);
                     $reciver_user =  $this->input->post('r_userid');             
                   $data['receive_user'] = $this->User_model->user_data($reciver_user);
                    $data['wallet_transfer'] = $this->User_model->transfer_wallet($reciver_user);
                     $this->load->view('template/user_header', $data);
                    $this->load->view('user/transfer_fund', $data);
                   $this->load->view('template/user_footer', $data);

                      } else {
                         $username = $_SESSION['username'];
                       $data['user_info'] = $this->User_model->user_info($username);
                      $user_id = $data['user_info']['user_id'];
                      $data['e_wallet'] = $this->User_model->get_wallet($username);
                    $data['title'] = 'Transfer Fund'; 
                     $reciver_user =  $this->input->post('r_userid');             
                   $data['receive_user'] = $this->User_model->user_data($reciver_user);
                    $data['wallet_transfer'] = $this->User_model->transfer_wallet($reciver_user);
                   
                     $this->load->view('template/user_header', $data);
                    $this->load->view('user/transfer_fund', $data);
                   $this->load->view('template/user_footer', $data);
                      }
                    }

    public function transfer_fund()
    {
      if (!$this->session->userdata('wallet_logged_in') ) {
       

       redirect('wallet/login','refresh');
          
       }            

         $this->form_validation->set_rules('r_userid', 'Receiver Wallet ID', 'trim|required');
       $this->form_validation->set_rules('amount', 'Transfer Amount', 'trim|required|numeric|callback_amount_balance');
       
       if ($this->form_validation->run() == false) {
       

         $username = $_SESSION['username'];
                       $data['user_info'] = $this->User_model->user_info($username);
                      $user_id = $data['user_info']['user_id'];
                      $data['e_wallet'] = $this->User_model->get_wallet($username);
                    $data['title'] = 'Transfer Fund'; 
                     $username =  $_SESSION['username'];             
  $data['user_data'] = $this->User_model->user_info($username);
   $reciver_user =  $this->input->post('r_userid');             
                   $data['receive_user'] = $this->User_model->user_data($reciver_user);
                    $data['wallet_transfer'] = $this->User_model->transfer_wallet($reciver_user);
                     $this->load->view('template/user_header', $data);
                    $this->load->view('user/transfer_fund', $data);
                   $this->load->view('template/user_footer', $data);
                  echo "<script type='text/javascript'>
                        $(document).ready(function(){
                        alert('Done');
                        });
                        </script>";
       } else {


       
        //Credit the transfer Account
        $reciver_balance = '';
         $reciver_user =  $this->input->post('r_userid');             
                   $data['receive_user'] = $this->User_model->user_data($reciver_user);
         $username = $_SESSION['username'];
                       $data['user_info'] = $this->User_model->user_info($username);
                      $user_id = $data['user_info']['user_id'];
                      $data['e_wallet'] = $this->User_model->get_wallet($username);
                    $data['title'] = 'Transfer Fund'; 
                     $username =  $_SESSION['username'];             
                $data['user_data'] = $this->User_model->user_info($username);
                $data['wallet_transfer'] = $this->User_model->transfer_wallet($reciver_user);
                //The CRedit the account to users
                $reciver_id = $this->input->post('r_userid');
                $sender_id = $this->input->post('sender');
                
                  $amount = $this->input->post('amount');
                
                  $receiver_balance = $this->input->post('receiver_balance');
                   $balance = $this->input->post('balance');
                    // Calculate 

                   $sender_total_balance = $balance - $amount;
                   $sender_wallet = array(
                  'G_wallet' => $sender_total_balance
                 );
                  $this->db->where('user_id', $sender_id);
                  $this->db->update('user_wallet', $sender_wallet);

                  // Reciver Total Amount

                   $reciver_total_balance = $receiver_balance + $amount;
                   $reciver_wallet = array(
                  'G_wallet' => $reciver_total_balance
                 );
                  $this->db->where('user_id', $reciver_id);
                  $this->db->update('user_wallet', $reciver_wallet);
                  


                  $date = date('dS-m-Y');
                  $transactions_id = rand(1111,8888).rand(00000,99999).rand(0000,9999);
                  $admin_tracker = array(
                    'sender_id' => $sender_id,
                    'reciever_id' => $reciver_id,
                    'amount' => $amount,
                    'transaction_id' =>$transactions_id,
                    'amount_type' =>'E-wallet Transfer',
                    'date' => $date
                  );

                  $this->db->insert('transfer', $admin_tracker);
                     $this->session->set_flashdata("succes_transfer","Your Transfer transcation is successful");
                   redirect('User/transfer_fund','refresh');
       }
                      
    }


     //Verify Payment After 
    public function direct_referral()
    {               

                    $username = $_SESSION['username'];
              $data['user_info'] = $this->User_model->user_info($username);
                    $data['title'] = 'Direct Referral'; 
                     $user_id = $data['user_info']['user_id'];
              $data['refferal'] = $this->User_model->refferal($username);
              // print_r($this->User_model->refferal($user_id));
              
                     $this->load->view('template/user_header', $data);
                    $this->load->view('user/direct_referral_table', $data);
                   $this->load->view('template/user_footer', $data);
    }


    //Network Table
      //Verify Payment After 
    public function network_table()
    {               

                    $username = $_SESSION['username'];
              $data['user_info'] = $this->User_model->user_info($username);
                    $data['title'] = 'My Network'; 
                     $user_id = $data['user_info']['user_id'];
              $data['network'] = $this->User_model->network($username);
              // print_r($this->User_model->network($user_id));
                     $this->load->view('template/user_header', $data);
                    $this->load->view('user/my_network', $data);
                   $this->load->view('template/user_footer', $data);
    }

// Change User Password \

    public function user_Cpassword()
    {
      $this->form_validation->set_rules('user_id', 'Username', 'trim|required');
                     $this->form_validation->set_rules('password', 'Password', 'trim|required');
                            if ($this->form_validation->run() == FALSE) {
                                
                         $data['title'] = 'User Change Password'; 
                  $username = $_SESSION['username'];
            $data['user_info'] = $this->User_model->user_info($username);
                     $this->load->view('template/user_header', $data);
                    $this->load->view('user/change_userpassword', $data);
                   $this->load->view('template/user_footer', $data);

                            } else {
                              $data['title'] = 'User Change Password'; 
                                $username = $_SESSION['username'];
                          $data['user_info'] = $this->User_model->user_info($username);
                                   $this->load->view('template/user_header', $data);
                                  $this->load->view('user/change_userpassword', $data);
                                 $this->load->view('template/user_footer', $data);

                            }
    }


    // Change Wallet Password

     public function wallet_Cpassword()
    {
      $this->form_validation->set_rules('user_id', 'Username', 'trim|required');
                     $this->form_validation->set_rules('password', 'Password', 'trim|required');
                            if ($this->form_validation->run() == FALSE) {
                                
                         $data['title'] = 'Change Wallet Password'; 
                  $username = $_SESSION['username'];
            $data['user_info'] = $this->User_model->user_info($username);
                     $this->load->view('template/user_header', $data);
                    $this->load->view('user/change_walletpassword', $data);
                   $this->load->view('template/user_footer', $data);

                            } else {
                              $data['title'] = 'Change Wallet Password'; 
                                $username = $_SESSION['username'];
                          $data['user_info'] = $this->User_model->user_info($username);
                                   $this->load->view('template/user_header', $data);
                                  $this->load->view('user/change_walletpassword', $data);
                                 $this->load->view('template/user_footer', $data);

                            }
    }

      //Loin Walllet
     public function e_wallet_login()
    {
             if ($this->session->userdata('wallet_logged_in') ) {
       

  redirect('wallet_dashboard','refresh');
          
  }
                   // $this->form_validation->set_rules('user_id', 'Username', 'trim|required');
                     $this->form_validation->set_rules('password', 'Password', 'trim|required');
                            if ($this->form_validation->run() == FALSE) {
                                
                         $data['title'] = 'E-Wallet Login App'; 
                  $username = $_SESSION['username'];
          
            $data['user_info'] = $this->User_model->user_info($username);
                     $this->load->view('template/user_header', $data);
                    $this->load->view('user/login', $data);
                   $this->load->view('template/user_footer', $data);

                            } else {
                                  $username_id = $_SESSION['username'];
                                 $password =  strtolower($this->input->post('password'));
                                 $User_pass = md5($password);
                                

                          $user_id = $this->User_model->e_wallet($username_id,$User_pass);

                          if ($user_id) {
                            $user_data =array(
                              'user_id' => $user_id,
                              'username_id' => $username_id,
                              'password' => $password,
                              'wallet_logged_in' => TRUE
                            );
                             $username = $_SESSION['username'];
                              $data['user_info'] = $this->User_model->user_info($username);
                            $this->session->set_userdata($user_data);
                           $data['title'] = 'Dashboard';
                            redirect('wallet_dashboard','refresh',$data);

                          }else{

                    $this->session->set_flashdata("login_failed","Invalid Username or Password");

                                

                         $data['title'] = 'E-Wallet Login App'; 
                  $username = $_SESSION['username'];
            $data['user_info'] = $this->User_model->user_info($username);
                     $this->load->view('template/user_header', $data);
                    $this->load->view('user/login', $data);
                   $this->load->view('template/user_footer', $data);

                            }
    }


    }

    // Walllet transactions
      public function e_wallet_transaction()
    {

if (!$this->session->userdata('wallet_logged_in') ) {
       

  redirect('wallet/login','refresh');
          
  }
                $data['title'] = 'Fund Request Transaction'; 
                $user = $_SESSION['username'];
                $data['fund_request'] = $this->User_model->get_fund_request($user);
                     $this->load->view('template/user_header', $data);
                    $this->load->view('user/wallet_transcation', $data);
                   $this->load->view('template/user_footer', $data);
    }


    // Transfer Table
    public function transfer_transaction()
    {

if (!$this->session->userdata('wallet_logged_in') ) {
       

  redirect('wallet/login','refresh');
          
  }
                 $username = $_SESSION['username'];
                       $data['user_info'] = $this->User_model->user_info($username);
                      $user_id = $data['user_info']['user_id'];
                      
                    $data['title'] = 'E-wallet Summary Transaction'; 
                    $data['fund_transfer'] = $this->User_model->get_fund_transfer($user_id);
                     $this->load->view('template/user_header', $data);
                    $this->load->view('user/transfer_transcation', $data);
                   $this->load->view('template/user_footer', $data);
    }

    // Update payment data to process after update
    public function update_fund($id)
    {
       

    }



                public function Logout()
            { 
              //$data['info'] = $this->User_model->home_info();
               // redirect('User/login','refresh');


            
              
              $this->session->unset_userdata('wallet_logged_in');
                  $this->session->unset_userdata('user_id');
                  $this->session->unset_userdata('username_id');
                  $this->session->unset_userdata('password');
                  $this->session->set_flashdata("logout","You have succesfully log out");
                
                        redirect('wallet/login','refresh');
            }
    


              // Check Email System from dashboard
            function register_email($name, $email, $username,$password)
  {



          //SMTP & mail configuration
          $config = array(
              'protocol'  => 'smtp',
              'smtp_host' => 'ssl://smtp.googlemail.com',
              'smtp_port' => 465,
              'smtp_user' => 'emeralddeveloper360@gmail.com',
              'smtp_pass' => 'excelluck',
              'mailtype'  => 'html',
              'charset'   => 'utf-8'
          );
          $this->email->initialize($config);
          $this->email->set_mailtype("html");
          $this->email->set_newline("\r\n");

      $this->email->from('emeralddeveloper360@gmail.com', 'belbec');
      $this->email->to($email);
      $this->email->subject('Welcome to Belbec!');
      $msg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
      <html xmlns="http://www.w3.org/1999/xhtml">
      <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <title>Welcome Email from EmiratLink.com</title>
      <style type="text/css">
      .p {
        text-align: justify;
      }
      .name {
        color: #E34619;
        font-weight: bold;
      }
      body .footer {
        color: #FF9;
        font-size:12px;
        text-align:center;
      }
      </style>
      </head>

      <body>
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" bgcolor="#E34619">&nbsp;</td>
          <td colspan="2" align="center" bgcolor="#000000"><img src="https://www.belbec.com/assest/img/logo.png" /></td>
          <td align="center" bgcolor="#E34619">&nbsp;</td>
        </tr>
        <tr>
          <td width="6%" bgcolor="#E34619">&nbsp;</td>
          <td width="34%">&nbsp;</td>
          <td width="53%">&nbsp;</td>
          <td width="7%" bgcolor="#E34619">&nbsp;</td>
        </tr>
        <tr>
          <td bgcolor="#E34619">&nbsp;</td>
          <td colspan="2" rowspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>&nbsp;</td>
              <td><p>Hello <span class="name">'.$name.'</span>,</p>
                <p class="p">You have successfully Registred Account with Sponsored Id'.$username.' . Now, you are</p>
                <p class="p">onto the  Belbec Network Marketing where you can Order BUY</p>
                <p class="p">&amp; SELL with Instant Funding and Secured e-currencies of all kinds at an</p>
                <p class="p">affordable rate.</p>
                <p class="p">Moreso, You can Sell United State iTunes physical card to us</p>
                <p class="p">considering iTunes Gift card terms and Conditions strictly.</p>
                <p class="p">Access your belbec Account ..<a href="http://www.belbec.com/login">LOGIN</a>.... , anytime and anywhere with</p>
                <p class="p">our innovative solutions to E-business.</p>
                <p class="p">Privacy is important to us. We will not sell , rent, or give your name or address to anyone provided the belbec <a href="terms">terms and conditions</a> are strictly observed.<br />
              </p>
                <p class="p">Thank you for joining! In order to serve you better, If you have any questions or comments, feel free to contact us via the Live chat with our Support teams, any of our social network or Submit your compliant/enquiries message by using Contact US Form when we are offline.</p>
                <!--<p>To proceed, please click this link to <a href="'.base_url().'/signup/confirm/'.$password.'">'.base_url().'/signup/confirm/'.$password.'</a> </p>-->
                </td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><p><span class="name">Disclaimer</span>:</p>
                <p>This email was sent to '.$email.' because it was used to register on belbec.com. Kindly disregard if you have not registered on the website. Thanks</p></td>
              <td>&nbsp;</td>
            </tr>
          </table></td> 
          <td bgcolor="#E34619">&nbsp;</td>
        </tr>
        <tr>
          <td bgcolor="#E34619">&nbsp;</td>
          <td bgcolor="#E34619">&nbsp;</td>
        </tr>
        <tr>
          <td bgcolor="#E34619">&nbsp;</td>
          <td bgcolor="#E34619">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" bgcolor="#E34619">&nbsp;</td>
          <td colspan="2" align="center" bgcolor="#000000"><span class="footer">Copyright &copy; 2018. belbec.com </span></td>
          <td bgcolor="#E34619">&nbsp;</td>
        </tr>
      </table>
      </body>
      </html>';
      $this->email->message($msg);
       $this->email->set_mailtype("html");
      $this->email->send();
  }


    // Ajax COntroller for Form Page

    public function check_email()
    {
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            echo '<label class=text-danger>Invalid Email</label>';
        }else{
           if ($this->User_model->check_mail($_POST["email"])) {
                echo '<label class=text-danger>Email Already Register</label>';
           }else{
            echo '<label class=text-success> Email Available </label>';
           }
        }
    }






//Move to stage 2 if downline is 7
public function level2()
{
          
                   $this->stage2();
              
              
}


//check for level and moved to level 3
public function level3()
{
          $this->star3();
              
              
}
  


//check for level and moved to level 3
public function level4()
{

  $this->star4();
              
              
}


//check for level and moved to level 3
public function level5()
{$this->star5();              
}



//check for level and moved to level 3
public function level6()
{
        $this->star6();            
}


//check for level and moved to level 3
public function level7()
{
$this->star7();             
              
}



//check for level and moved to level 3
public function level8()
{$this->star8();            
              
}



//check for level and moved to level 3
public function level9()
{
        $this->star9();             
}




//check for level and moved to level 3
public function level10()
{
      $this->star10();          
}



public function star3()
{
   $data['title'] = 'Star 3'; // Capitalize the first letter
                    $username = $_SESSION['username'];
              $data['user_info'] = $this->User_model->user_info($username);
                            //$user_id = $data['user_info']['user_id'];
                    $this->load->view('template/user_header', $data);
                    $this->load->view('user/levelthree', $data);
                    $this->load->view('template/user_footer', $data);
}



public function star4()
{
   $data['title'] = 'Star 4'; // Capitalize the first letter
                    $username = $_SESSION['username'];
              $data['user_info'] = $this->User_model->user_info($username);
                            $user_id = $data['user_info']['user_id'];
                    $this->load->view('template/user_header', $data);
                    $this->load->view('user/levelfour', $data);
                    $this->load->view('template/user_footer', $data);
}


public function star5()
{
   $data['title'] = 'Star 5 Elite'; // Capitalize the first letter
                    $username = $_SESSION['username'];
              $data['user_info'] = $this->User_model->user_info($username);
                            $user_id = $data['user_info']['user_id'];
                    $this->load->view('template/user_header', $data);
                    $this->load->view('user/levelfive', $data);
                    $this->load->view('template/user_footer', $data);
}




public function star6()
{
   $data['title'] = 'Star 6 Elite'; // Capitalize the first letter
                    $username = $_SESSION['username'];
              $data['user_info'] = $this->User_model->user_info($username);
                            $user_id = $data['user_info']['user_id'];
                    $this->load->view('template/user_header', $data);
                    $this->load->view('user/levelsix', $data);
                    $this->load->view('template/user_footer', $data);
}




public function star7()
{
   $data['title'] = 'Star 7 Elite'; // Capitalize the first letter
                    $username = $_SESSION['username'];
              $data['user_info'] = $this->User_model->user_info($username);
                            $user_id = $data['user_info']['user_id'];
                    $this->load->view('template/user_header', $data);
                    $this->load->view('user/levelseven', $data);
                    $this->load->view('template/user_footer', $data);
}




public function star8()
{
   $data['title'] = 'Star 8 Ultimate'; // Capitalize the first letter
                    $username = $_SESSION['username'];
              $data['user_info'] = $this->User_model->user_info($username);
                            $user_id = $data['user_info']['user_id'];
                    $this->load->view('template/user_header', $data);
                    $this->load->view('user/leveleight', $data);
                    $this->load->view('template/user_footer', $data);
}




public function star9()
{
   $data['title'] = 'Star 9 Ultimate'; // Capitalize the first letter
                    $username = $_SESSION['username'];
              $data['user_info'] = $this->User_model->user_info($username);
                            $user_id = $data['user_info']['user_id'];
                    $this->load->view('template/user_header', $data);
                    $this->load->view('user/levelnine', $data);
                    $this->load->view('template/user_footer', $data);
}




public function star10()
{
   $data['title'] = 'Star 10 Ultimate <i class="fa fa-star"></i>'; // Capitalize the first letter
                    $username = $_SESSION['username'];
              $data['user_info'] = $this->User_model->user_info($username);
                            $user_id = $data['user_info']['user_id'];
                    $this->load->view('template/user_header', $data);
                    $this->load->view('user/levelten', $data);
                    $this->load->view('template/user_footer', $data);
}


public function search($level,$username,$id)
{

// echo $level.$username.$id;
                $data['title'] = "Downline"; // Capitalize the first letter
                     // $data['user_id'] = $user_id;
                     $data['level']  = $level;
                      $data['username']  = $username;
                     $data['id'] = $id;
                     $getMain = $this->User_model->user_id($level, $username, $id);
                    $this->load->view('template/user_header', $data);
                    $this->load->view('user/searchuser', $data);
                    $this->load->view('template/user_footer', $data);

}


public function levelonesearch($username)
{
                      $data['title'] = $username.' '."Downline"; // Capitalize the first letter
                     $data['username'] = $username;
                     $data['user_info']  = $this->User_model->get_searchone($username);
                    $this->load->view('template/user_header', $data);
                    $this->load->view('user/startertwo', $data);
                    $this->load->view('template/user_footer', $data);
}





public function compose_message()
{
                $data['title'] = 'Compose Message'; // Capitalize the first letter
                     $username =  $_SESSION['username'];
                    $data['user_info'] = $this->User_model->user_info($username);     


                    // $this->form_validation->set_rules('Sender', 'Sender ID', 'trim|required');
                    $this->form_validation->set_rules('receiver', 'Receiver ID', 'trim|required|callback_confirm_username|callback_same_mail_id');
                    $this->form_validation->set_rules('message', 'Message Content', 'trim|required');
                    $this->form_validation->set_rules('subject', 'Message', 'trim');
                    if ($this->form_validation->run() == FALSE) {
                        $data['title'] = 'Compose Message'; // Capitalize the first letter
                       $username =  $_SESSION['username'];
                      $data['sent_message'] = $this->User_model->sent_message($username);
                       $this->load->view('template/user_header', $data);
                    $this->load->view('user/compose_message', $data);
                    $this->load->view('template/user_footer', $data);
                    } else {

                      $full_name = $this->input->post('receiver');
                       $data['receiver_info'] = $this->User_model->user_info($full_name);
                       $first_name = $data['receiver_info']['user_first_name'];
                       $last_name = $data['receiver_info']['user_last_name'];

                       $name = $first_name.' '.$last_name;
                      $data = array(
                        'receiver' => $this->input->post('receiver'),
                        'full_name' => $name,
                        'subject' => $this->input->post('subject'),
                        'sender_full_name' => $this->input->post('sender_full_name'),
                        'username' => $this->input->post('username'),
                        'message' => $this->input->post('message'),
                        'message_type' => 'sent_message'

                      );
                      $this->db->insert('compose_message', $data);
                      $this->db->insert('inbox_message', $data);
                       $username =  $_SESSION['username'];
                         echo "<script>alert('Message Successfully Sent');</script>";
                      redirect('User/compose_message','refresh');
                    }
}

public function reply_message($id)
{
   $data['title'] = 'Compose Message'; // Capitalize the first letter
                     $username =  $_SESSION['username'];
                    $data['user_info'] = $this->User_model->user_info($username);     


                    // $this->form_validation->set_rules('Sender', 'Sender ID', 'trim|required');
                    $this->form_validation->set_rules('receiver', 'Receiver ID', 'trim|required|callback_confirm_username|callback_same_mail_id');
                    $this->form_validation->set_rules('message', 'Message Content', 'trim|required');
                    $this->form_validation->set_rules('subject', 'Message', 'trim');
                    if ($this->form_validation->run() == FALSE) {
                        $data['title'] = 'Reply Message'; // Capitalize the first letter
                       $username =  $_SESSION['username'];
                      $data['sent_message'] = $this->User_model->sent_message($username);
                      $data['reply_message'] = $this->User_model->reply_message($id);
                       $this->load->view('template/user_header', $data);
                    $this->load->view('user/reply_sent_message', $data);
                    $this->load->view('template/user_footer', $data);
                    } else {

                      $full_name = $this->input->post('receiver');
                       $data['receiver_info'] = $this->User_model->user_info($full_name);
                       $first_name = $data['receiver_info']['user_first_name'];
                       $last_name = $data['receiver_info']['user_last_name'];

                       $name = $first_name.' '.$last_name;
                      $data = array(
                        'receiver' => $this->input->post('receiver'),
                        'full_name' => $name,
                        'subject' => $this->input->post('subject'),
                        'sender_full_name' => $this->input->post('sender_full_name'),
                        'username' => $this->input->post('username'),
                        'message' => $this->input->post('message'),
                        'message_type' => 'sent_message'

                      );
                      $this->db->insert('compose_message', $data);
                      $this->db->insert('inbox_message', $data);
                       $username =  $_SESSION['username'];
                         echo "<script>alert('Message Successfully Sent');</script>";
                      redirect('User/compose_message','refresh');
                    }
}
public function reply_support_line($id)
{
   $data['title'] = 'Compose Message'; // Capitalize the first letter
                     $username =  $_SESSION['username'];
                    $data['user_info'] = $this->User_model->user_info($username);     


                    // $this->form_validation->set_rules('Sender', 'Sender ID', 'trim|required');
                    $this->form_validation->set_rules('receiver', 'Receiver ID', 'trim|required|callback_confirm_username|callback_same_mail_id');
                    $this->form_validation->set_rules('message', 'Message Content', 'trim|required');
                    $this->form_validation->set_rules('subject', 'Message', 'trim');
                    if ($this->form_validation->run() == FALSE) {
                        $data['title'] = 'Reply Support Line'; // Capitalize the first letter
                       $username =  $_SESSION['username'];
                      $data['support_line_message'] = $this->User_model->support_line_message($username);
                      $data['reply_message'] = $this->User_model->reply_line_message($id);
                       $this->load->view('template/user_header', $data);
                    $this->load->view('user/reply_admin', $data);
                    $this->load->view('template/user_footer', $data);
                    } else {

                      $full_name = $this->input->post('receiver');
                       $data['receiver_info'] = $this->User_model->user_info($full_name);
                       $first_name = $data['receiver_info']['user_first_name'];
                       $last_name = $data['receiver_info']['user_last_name'];

                       $name = $first_name.' '.$last_name;
                      $data = array(
                        'receiver' => $this->input->post('receiver'),
                        'full_name' => $name,
                        'subject' => $this->input->post('subject'),
                        'sender_full_name' => $this->input->post('sender_full_name'),
                        'username' => $this->input->post('username'),
                        'message' => $this->input->post('message'),
                        'message_type' => 'sent_message'

                      );
                      $this->db->insert('compose_message', $data);
                      $this->db->insert('inbox_message', $data);
                       $username =  $_SESSION['username'];
                         echo "<script>alert('Message Successfully Sent');</script>";
                      redirect('User/compose_message','refresh');
                    }
}
    
      public function support_line()
      {
        $data['title'] = 'Support Line'; // Capitalize the first letter
                     $username =  $_SESSION['username'];
                    $data['user_info'] = $this->User_model->user_info($username);     


                    // $this->form_validation->set_rules('Sender', 'Sender ID', 'trim|required');
                    $this->form_validation->set_rules('receiver', 'Receiver ID', 'trim|required');
                    $this->form_validation->set_rules('message', 'Message Content', 'trim|required');
                    $this->form_validation->set_rules('subject', 'Message', 'trim');
                    if ($this->form_validation->run() == FALSE) {
                        $data['title'] = 'Support Line'; // Capitalize the first letter
                       $username =  $_SESSION['username'];
                      $data['support_line_message'] = $this->User_model->support_line_message($username);
                       $this->load->view('template/user_header', $data);
                    $this->load->view('user/support', $data);
                    $this->load->view('template/user_footer', $data);
                    } else {

                      $full_name = $this->input->post('receiver');
                       $data['receiver_info'] = $this->User_model->user_info($full_name);
                       $first_name = $data['receiver_info']['user_first_name'];
                       $last_name = $data['receiver_info']['user_last_name'];

                       $name = $first_name.' '.$last_name;
                      $data = array(
                        'receipent_id' => $this->input->post('receiver'),
                        'situation' => $this->input->post('situation'),
                        'subject' => $this->input->post('subject'),
                        'sender_full_name' => $this->input->post('sender_full_name'),
                        'sender_id' => $this->input->post('username'),
                        'message' => $this->input->post('message'),
                        'message_type' => 'Message Sent'

                      );
                      $this->db->insert('message', $data);
                      // $this->db->insert('message', $data);
                       $username =  $_SESSION['username'];
                         echo "<script>alert('Thanks for contact the Administrator, Message Successfully Sent');</script>";
                      redirect('User/compose_message','refresh');
                    }
      }



      public function confirm_username($receiver)
                  {


                       $this->form_validation->set_message('confirm_username', 'Sorry, Invalid Username ID ');
                    if ($this->User_model->confirm_username($receiver)) {
                            return true;
                    }else{
                            return false;
                    }
                  }


                    public function same_mail_id($receiver)
                  {

                      $username = $_SESSION['username'];
                       $this->form_validation->set_message('same_mail_id', 'Sorry, Use Other Receiver ID ');
                    if ($receiver=== $username) {
                            return false;
                    }else{
                            return true;
                    }
                  }


                  //Delete Sent Message
                  public function delete_message($id)
                  {
                  
                    $this->User_model->delete_message($id);
                      echo "<script>alert('Message Successfully Deleted');</script>";
                    redirect('User/compose_message','refresh');
                  }


                  //Deelete Inbox Message
                  public function delete_inbox_message($id)
                      {
                     $this->User_model->delete_inbox_message($id);
                      echo "<script>alert('Message Successfully Deleted');</script>";
                    redirect('User/compose_message','refresh');
                      }


public function product_table()
{
                 $data['title'] = 'Belbec Product'; // Capitalize the first letter
                  $data['product_table'] = $this->Admin_model->product_table();
                   $username = $_SESSION['username'];
                     $data['user_info'] = $this->User_model->user_info($username);
                    $user_id = $data['user_info']['user_id'];
                    $data['user_id']  = $data['user_info']['user_id'];
                    $data['e_wallet'] = $this->User_model->get_wallet($username);
                    $this->load->view('template/user_header', $data);
                    $this->load->view('user/product_table', $data);
                    $this->load->view('template/user_footer', $data);
}



public function cart_product()
{
                 $data['title'] = 'Cart Product'; // Capitalize the first letter
                  $data['products'] = $this->User_model->cart_table();
                   $username = $_SESSION['username'];
                     $data['user_info'] = $this->User_model->user_info($username);
                    $user_id = $data['user_info']['user_id'];
                    $data['e_wallet'] = $this->User_model->get_wallet($username);
                    $this->load->view('template/user_header', $data);
                    $this->load->view('user/cart_table', $data);
                    $this->load->view('template/user_footer', $data);
}



public function PUC($id =null)
{             
if ($id==false || $this->Admin_model->product_info($id)==false) {
  redirect('dashboard','refresh');
}

              $this->form_validation->set_rules('quantity', 'Product Quantity', 'trim|required|is_natural_no_zero');
              $this->form_validation->set_rules('mobile', 'Phone Number', 'trim|required|min_length[11]|max_length[15]');
              $this->form_validation->set_rules('address', 'Delivery Address', 'trim|required');
              $this->form_validation->set_rules('state', 'State', 'trim|required');
              $this->form_validation->set_rules('country', 'Country', 'trim|required');
               $this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
                $this->form_validation->set_rules('method', 'Delivery Method', 'trim|required');

              if ($this->form_validation->run() == FALSE) {
               $username = $_SESSION['username'];
                     $data['user_info'] = $this->User_model->user_info($username);
                    $user_id = $data['user_info']['user_id'];
                    $data['e_wallet'] = $this->User_model->get_wallet($username);
                    $data['title'] = 'Cart Product::PUC'; // Capitalize the first letter
                    $data['product_info'] = $this->Admin_model->product_info($id);
                    $this->load->view('template/user_header', $data);
                    $this->load->view('user/cart', $data);
                    $this->load->view('template/user_footer', $data);
              } else {

                    $price = $this->input->post('price');
                    $quantity =$this->input->post('quantity');
                    $amount = $price*$quantity;
                    $username = $_SESSION['username'];
                    $transaction_id = rand(00000,999999).rand(0000000,999999999);
                $data = array(
                  'username' =>$username,
                  'amount' =>$amount,
                  'product_name' =>$this->input->post('product_name'),
                  'price' =>$this->input->post('price'),
                  'quantity' =>$this->input->post('quantity'),
                  'mobile' =>$this->input->post('mobile'),
                  'address' =>$this->input->post('address'),
                  'state' =>$this->input->post('state'),
                  'country' =>$this->input->post('country'),
                  'email' =>$this->input->post('email'),
                  'transaction_id' => $transaction_id
                );
                $this->db->insert('product_request', $data);
                $username = $_SESSION['username'];
                     $data['user_info'] = $this->User_model->user_info($username);
                    $user_id = $data['user_info']['user_id'];
                    $data['e_wallet'] = $this->User_model->get_wallet($username);
                    $data['title'] = 'Cart Product::PUC'; // Capitalize the first letter
                    $data['product_info'] = $this->Admin_model->product_info($id);
                    $this->session->set_flashdata("success_cart","Product Successfully Cart");
                    $this->load->view('template/user_header', $data);
                    $this->load->view('user/cart', $data);
                    $this->load->view('template/user_footer', $data);
              }
             

}



public function inbox()
{
              $data['title'] = 'Inbox Message'; // Capitalize the first letter
                   $username = $_SESSION['username'];
                     $data['inbox_message'] = $this->User_model->inbox_message($username);
                    //$user_id = $data['user_info']['user_id'];
                    $this->load->view('template/user_header', $data);
                    $this->load->view('user/inbox', $data);
                    $this->load->view('template/user_footer', $data);
}
// public function tree_Id() {
//    $username = $_SESSION['username'];
//               $data['user_info'] = $this->User_model->user_info($username);
//                             $user_id = $data['user_info']['user_id'];
//   $categories = array();
//   $this->db->from('tree');
//   $this->db->where('user_id', $user_id);
//   $result = $this->db->get()->result();
//   foreach ($result as $mainCategory) {
//     $category = array();
//     $category['user_id'] = $mainCategory->id;
//     // $category['username'] = $mainCategory->user_first_name;
//     // $category['sponsor_key'] = $mainCategory->sponsor_key;
//     $category['sub_categories'] = $this->tree_Id($category['user_id']);
//     $categories[$mainCategory->id] = $category;
//   }
//   return $categories;
// }

 public function categories(){

        
  $data = $this->User_model->get_categories();

  print_r($data);
    }
 

}


?>