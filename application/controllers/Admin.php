<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require FCPATH .'vendor/autoload.php';
use Jlorente\CreditCards\CreditCardTypeConfig;
use Jlorente\CreditCards\CreditCardValidator;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Admin extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->library('email'); 
		$this->load->library('form_validation'); 
		$this->load->library('alert'); 
		$this->load->helper('cookie');
		// Load pagination library 
        $this->load->library('ajax_pagination'); 
		$this->load->library('session');
		$this->load->model('admin_model');
		$this->load->library('encrypt');
		$this->load->model('user_model');
		$this->settings = $this->admin_model->theme_setting();
		$this->perPage = 1; 
		date_default_timezone_set('America/New_York');

		// Load the custom helper for logging
		$this->load->helper('credit_card_info_log_helper');
		$this->load->helper('admin_settings_update_log_helper');

		/**Login cookie check */
		if($this->session->userdata('mes_admin_id') == ''){

			$remember_me = get_cookie('remember_me');
			if ($remember_me) {
                $user = $this->admin_model->get_user_by_token($remember_me);
                if ($user) {
                    //$this->session->set_userdata('user_id', $user['id']);
					$result = $this->admin_model->get_admin_detail_byadminid($user['id']);
					$newdata = array(
						'mes_admin_id'  => $result['id'],
						'admin_email'     => $result['email'],
						'admin_username' => $result['user_name'],
						'admin_full_name' => $result['full_name'],
						'admin_profile_pic' => $result['profile_pic'],
						'admin_cmp_id' => $result['cmp_id'],
						'admin_role' => $result['role'],
						'admin_notifications' => $result['notifications'],
					);
	
	
	
					$this->session->set_userdata($newdata);
                }
            }
		}
		
		
		//Destroy admin session if admin is deleted
		if($this->session->userdata('mes_admin_id') != ''){
			$userInfo = $this->admin_model->get_admin_detail_byadminid($this->session->userdata('mes_admin_id'));
			if(empty($userInfo)){
				$this->session->sess_destroy();
				redirect('admin');
			}

		}
	}
	public function index()
	{
		
		if($this->session->userdata('mes_admin_id') != ''){
			redirect('admin/dashboard');
			
		}
		else{
			$this->load->view('admin/login');
		}
	}
	
	public function reset_password_form(){
		$id = $this->input->post('id');
		$password = $this->input->post('new_password');
		$result = $this->admin_model->update_password_user($id,$password);
	}
	public function reset_booking_status(){
		$result = $this->admin_model->reset_booking_status();
	}

	public function reset_password(){
		$id = $this->uri->segment(3);
		$token = $this->uri->segment(4);
		if($id != '' && $token != ''){
			$result = $this->admin_model->check_resetcode_userid($id,$token);
			if(!empty($result)){
				$data['user_data'] = $result;
				$this->load->view('reset_password',$data);
			}
			else{
				redirect('admin');
			}
		}
		else{
			redirect('admin');
		}
	}
	/**Controller for admin_front_form_reset_password reset temp password */
	public function admin_front_form_reset_password(){
		// $username = $this->input->post('username');
        // $password = $this->input->post('password');
        // $newPassword = $this->input->post('new-password');
		// echo($username.'---'.$password.'---'.$newPassword);
		// exit('---from admin');

		$username = $this->input->post('username');
        $password = $this->input->post('password');
        $newPassword = $this->input->post('new-password');

		if($username && $newPassword){
			$result = $this->admin_model->admin_front_form_reset_password();
			if($result){

				$newdata = array(
					'mes_admin_id'  => $result['id'],
					'admin_email'     => $result['email'],
					'admin_username' => $result['user_name'],
					'admin_full_name' => $result['full_name'],
					'admin_profile_pic' => $result['profile_pic'],
					'admin_cmp_id' => $result['cmp_id'],
					'admin_role' => $result['role'],
					'admin_notifications' => $result['notifications'],
				);
				$this->session->set_userdata($newdata);

				$data['response'] = 'success';
				$data['message'] = 'Your password has been set successfully.';
			}else{
				$data['response'] = 'failure';
				$data['message'] = 'Your password has not been set.';
			}
		}
		echo json_encode($data);
		exit;


	}

	/**
	 * Send OTP on email
	 */
	public function send_otp_on_email(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$receiver = $this->input->post('receiver');
			$type = $this->input->post('type');
			if($receiver){
				$$receiverEmail = null;
				if($receiver='setting_admin_email'){
					$settingsData = $this->admin_model->theme_setting();
					// echo('<pre>');
					// print_r($settingsData['admin_email']);
					// echo('</pre>');
					// $code = $this->admin_model->random_strings(8);
					// echo($code);
					// exit();
					/**
					 * Send OTP to Settings => ADMIN EMAIL
					 */
					if($type=='credit_card_info'){
						// exit('credit_card_  info');
						if($settingsData['admin_email']){
							$code = $this->admin_model->random_strings(8); //New random password 
							$sendOtp = $this->admin_model->insert_otp_for_send_credit_card_details($code);
							if($sendOtp){
	
								
								// $this->admin_model->update_pasword_foremail($email,$code); //Update password
								$email_template = $this->admin_model->get_email_template('otp_for_creditcardinfo_download');
								$email_template = str_replace('{{site_title}}',$this->settings['site_title'],$email_template);
								$email_template = str_replace('{{loginlink}}',site_url('admin'),$email_template);
								$email_template = str_replace('{{site_url}}',site_url(),$email_template);
				
								$email_template = str_replace('{{currentyear}}',date("Y"),$email_template);
								$subject = $email_template['email_subject'];
								$email_template = str_replace('{{code}}',$code,$email_template['email_body']);
								$email_template = str_replace('{{mailsubject}}',$subject,$email_template);
								$this->email->set_newline("\r\n");
								$this->email->from($this->settings['smtp_from_email'],$this->settings['site_title']); // change it to yours
								$this->email->to($settingsData['admin_email']);// change it to yours
								$this->email->reply_to($this->settings['smtp_to_email']);
								$this->email->subject($this->settings['site_title'].' - '.$subject);
								$this->email->message($email_template);
								$this->email->send();
	
	
	
								$data['status']="success";
								echo json_encode($data);
								exit;
							}else{
								$data['status']="fail";
								$data['message']="Something went wrong please try after some time.";
								echo json_encode($data);
								exit;	
							}
	
						}else{
							$data['status']="fail";
							$data['message']="Invalid email, Please check email address at Dashboard->settings->Admin Email";
							echo json_encode($data);
							exit;
						}
					}else if($type=='admin_settings'){
						//exit('admin settings');
						if($settingsData['admin_email']){
							$code = $this->admin_model->random_strings(8); //New random password 
							$sendOtp = $this->admin_model->insert_otp_for_update_admin_settings($code);
							if($sendOtp){
	
								
								// $this->admin_model->update_pasword_foremail($email,$code); //Update password
								$email_template = $this->admin_model->get_email_template('otp_for_update_admin_settings');
								$email_template = str_replace('{{site_title}}',$this->settings['site_title'],$email_template);
								$email_template = str_replace('{{loginlink}}',site_url('admin'),$email_template);
								$email_template = str_replace('{{site_url}}',site_url(),$email_template);
				
								$email_template = str_replace('{{currentyear}}',date("Y"),$email_template);
								$subject = $email_template['email_subject'];
								$email_template = str_replace('{{code}}',$code,$email_template['email_body']);
								$email_template = str_replace('{{mailsubject}}',$subject,$email_template);
								$this->email->set_newline("\r\n");
								$this->email->from($this->settings['smtp_from_email'],$this->settings['site_title']); // change it to yours
								$this->email->to($settingsData['admin_email']);// change it to yours
								$this->email->reply_to($this->settings['smtp_to_email']);
								$this->email->subject($this->settings['site_title'].' - '.$subject);
								$this->email->message($email_template);
								$this->email->send();
	
	
	
								$data['status']="success";
								echo json_encode($data);
								exit;
							}else{
								$data['status']="fail";
								$data['message']="Something went wrong please try after some time.";
								echo json_encode($data);
								exit;	
							}
	
						}else{
							$data['status']="fail";
							$data['message']="Invalid email, Please check email address at Dashboard->settings->Admin Email";
							echo json_encode($data);
							exit;
						}
					}


					
					/**
					 * Insert record in MS-OTP-FOR-SEND-CREDITCARD-DETAILS
					 */


					// if($this->input->post('for_forgot_psw') == 1){
					// 	//exit('click on forgot');
					// 	$code = $this->admin_model->random_strings(8); //New random password 
					// 	$this->admin_model->update_pasword_foremail($email,$code); //Update password
					// 	$email_template = $this->admin_model->get_email_template('reset_user_password');
					// 	$email_template = str_replace('{{site_title}}',$this->settings['site_title'],$email_template);
					// 	$email_template = str_replace('{{loginlink}}',site_url('admin'),$email_template);
					// 	$email_template = str_replace('{{site_url}}',site_url(),$email_template);
		
					// 	$email_template = str_replace('{{currentyear}}',date("Y"),$email_template);
					// 	$subject = $email_template['email_subject'];
					// 	$email_template = str_replace('{{code}}',$code,$email_template['email_body']);
					// 	$this->email->set_newline("\r\n");
					// 	$this->email->from($this->settings['smtp_from_email'],$this->settings['site_title']); // change it to yours
					// 	$this->email->to($email);// change it to yours
					// 	$this->email->reply_to($this->settings['smtp_to_email']);
					// 	$this->email->subject($this->settings['site_title'].' - '.$subject);
					// 	$this->email->message($email_template);
					// 	$this->email->send();
					// }



				}
				$data['status']="success";
				echo json_encode($data);
				exit;
			}else{
				$data['status']="fail";
				$data['message']="Invalid recever type";
				echo json_encode($data);
				exit;
			}
		}else{
			redirect('admin');
		}

	}

	/**Controller for admin_front_form_reset_password END*/
	public function forgot_password(){
		$this->load->view('forgot_password');
	}
	public function check_email_address(){
		$email = $this->input->post('username');
		$result = $this->admin_model->check_email($email);
		if(is_array($result)){
			/**Set new temp password and send on email only if user have clicked on forgot password */
			
			if($this->input->post('for_forgot_psw') == 1){
				//exit('click on forgot');
				$code = $this->admin_model->random_strings(8); //New random password 
				$this->admin_model->update_pasword_foremail($email,$code); //Update password
				$email_template = $this->admin_model->get_email_template('reset_user_password');
				$email_template = str_replace('{{site_title}}',$this->settings['site_title'],$email_template);
				$email_template = str_replace('{{loginlink}}',site_url('admin'),$email_template);
				$email_template = str_replace('{{site_url}}',site_url(),$email_template);

				$email_template = str_replace('{{currentyear}}',date("Y"),$email_template);
				$subject = $email_template['email_subject'];
				$email_template = str_replace('{{code}}',$code,$email_template['email_body']);
				$this->email->set_newline("\r\n");
				$this->email->from($this->settings['smtp_from_email'],$this->settings['site_title']); // change it to yours
				$this->email->to($email);// change it to yours
				$this->email->reply_to($this->settings['smtp_to_email']);
				$this->email->subject($this->settings['site_title'].' - '.$subject);
				$this->email->message($email_template);
				$this->email->send();
			}


			$data['response'] = 'success';
			$data['message'] = 'Email sent Successfully.';
		}
		else{
			if($email == ''){
				$data['message'] = 'Please enter email.';
			}
			else{
				$data['message'] = 'Email not Match.';
			}
			$data['response'] = 'failure';
			
		}
		echo json_encode($data);
		exit;
	}
	public function check_login(){
		$result = $this->admin_model->check_login();
		if(is_array($result)){
			if($result['temp_password_status'] == 0){
				$data['response'] = 'resetpassword';
				$data['message'] = 'Loggedin using Temporary Password';
			}else{
				$newdata = array(
					'mes_admin_id'  => $result['id'],
					'admin_email'     => $result['email'],
					'admin_username' => $result['user_name'],
					'admin_full_name' => $result['full_name'],
					'admin_profile_pic' => $result['profile_pic'],
					'admin_cmp_id' => $result['cmp_id'],
					'admin_role' => $result['role'],
					'admin_notifications' => $result['notifications'],
				);



				$this->session->set_userdata($newdata);

				$remember_me = $this->input->post('remember_me');
				if ($remember_me) {
					// Generate a random token
					$token = bin2hex(random_bytes(16));
					// Save the token in the database
					$this->admin_model->save_token($result['id'], $token);
	
					// Set a cookie with the token
					set_cookie('remember_me', $token, 3600*24*30); // Expires in 30 days
				}



				$data['response'] = 'success';
				$data['message'] = 'Login Successfully.';
			}

		}
		else{
			$data['response'] = 'failure';
			$data['message'] = 'Incorrect Password.';
		}
		echo json_encode($data);
		exit;
	}
	public function insert_user(){
		if($this->session->userdata('mes_admin_id') != ''){
			$result = $this->admin_model->insert_user();
			if(!empty($result)){
				/**Send Password on user Email */

				
				//Uncomment Below code to send email to user when guser is created

				// $email_template = $this->admin_model->get_email_template('reset_user_password');
				// $email_template = str_replace('{{site_title}}',$this->settings['site_title'],$email_template);
				// $email_template = str_replace('{{loginlink}}',site_url(),$email_template);
				// $email_template = str_replace('{{currentyear}}',date("Y"),$email_template);
				// $email_template = str_replace('{{site_url}}',site_url(),$email_template);
				// $subject = $email_template['email_subject'];
				// $email_template = str_replace('{{code}}',$result['password'],$email_template['email_body']);
				// $this->email->set_newline("\r\n");
				// $this->email->from($this->settings['smtp_from_email'],$this->settings['site_title']); // change it to yours
				// $this->email->to($result['email']);// change it to yours
				//$this->email->reply_to($this->settings['smtp_to_email']);
				// $this->email->subject($this->settings['site_title'].' - '.$subject);
				// $this->email->message($email_template);
				// $this->email->send();

				
				/**Send Password on user Email END*/
			}
			else{
				$this->session->set_flashdata('message', '<script>Swal.fire("Email Already Exist!");</script>');
			}
			redirect('admin/user_list');
		}
		else{
			redirect('admin');
		}
	}
	/**Rest User Password */
	public function reset_user_password(){
		$id = $this->input->post('user_id');
		$email = $this->input->post('user_email');
		if($this->session->userdata('mes_admin_id') != ''){
			$result = $this->admin_model->check_email_address_users($email);
			if($result){
				
				$code = $this->admin_model->random_strings(8);
				$this->admin_model->rest_user_pasword_foremail($email,$code);
				$email_template = $this->admin_model->get_email_template('reset_user_password');
				$email_template = str_replace('{{site_title}}',$this->settings['site_title'],$email_template);
				$email_template = str_replace('{{loginlink}}',site_url(),$email_template);
				$email_template = str_replace('{{site_url}}',site_url(),$email_template);
				$email_template = str_replace('{{currentyear}}',date("Y"),$email_template);
				$subject = $email_template['email_subject'];

				$email_template = str_replace('{{code}}',$code,$email_template['email_body']);
				$this->email->set_newline("\r\n");
				$this->email->from($this->settings['smtp_from_email'],$this->settings['site_title']); // change it to yours
				$this->email->to($email);// change it to yours
				$this->email->reply_to($this->settings['smtp_to_email']);
				$this->email->subject($this->settings['site_title'].' - '.$subject);
				$this->email->message($email_template);
				$this->email->send();
				$data['response'] = 'success';
				$data['message'] = 'New password sent on user\'s email Successfully.';
			}else{
				if($email == ''){
					$data['message'] = 'User not found.';
				}
				else{
					$data['message'] = 'User not found.';
				}
				$data['response'] = 'failure';
				
			}

		}else{
			$data['response'] = 'failure';
			$data['message'] = 'You are not allowed to make this change.';
			return false;
		}
		echo json_encode($data);
		exit;
	}
	public function update_user(){
		if($this->session->userdata('mes_admin_id') != ''){
			$id = $this->uri->segment(3);
			$result = $this->admin_model->update_user($id);
			if(!empty($result)){
			}
			else{
				$this->alert->set('alert-danger', 'Email Already Exist!');
			}
			redirect('admin/user_list');
		}
		else{
			redirect('admin');
		}
	}
	public function update_admin(){
		if($this->session->userdata('mes_admin_id') != ''){
			$id = $this->uri->segment(3);
			$result = $this->admin_model->update_admin($id);
			if(!empty($result)){
			}
			else{
				$this->alert->set('alert-danger', 'Email Already Exist!');
			}
			redirect('admin/admin_list');
		}
		else{
			redirect('admin');
		}
	}
	public function reset_password_admin(){
		if($this->session->userdata('mes_admin_id') != ''){
			$id = $this->uri->segment(3);
			$password = $this->input->post('password');
			$resetpassword = $this->input->post('reset_password');
			if($password != $resetpassword){
				$this->alert->set('alert-danger', 'Incorrect Password!');
				redirect('admin/admin_list');
			}
			$this->session->set_flashdata('message', '<script>Swal.fire("Password Updated successfully!");</script>');
			$result = $this->admin_model->reset_password_admin($id);
			redirect('admin/admin_list');
		}
		else{
			redirect('admin');
		}
	}
	public function update_theme_setting(){
		if($this->session->userdata('mes_admin_id') != ''){
			$result = $this->admin_model->update_theme_setting();
			$this->session->set_flashdata('message', '<script>Swal.fire("Updated successfully!");</script>');
			redirect('admin/theme_setting');
		}
		else{
			redirect('admin');
		}
	}
	public function theme_setting(){
		if($this->session->userdata('mes_admin_id') != ''){
			$data['setting'] = $this->admin_model->theme_setting();
			$this->load->view('admin/header');
			$this->load->view('admin/theme_settings',$data);
			$this->load->view('admin/footer');
		}
		else{
			redirect('admin');
		}
	}
	public function insert_filter(){
		if($this->session->userdata('mes_admin_id') != ''){
			$result = $this->admin_model->insert_filter();
			$data['filters'] = $this->admin_model->get_all_filters();
			$view_filter = $this->load->view('admin/restaurant_list/filter-sidebar', $data, true);
			$add_filter = $this->load->view('admin/restaurant_list/add_filter', $data, true);
		}
		else{
			$view_filter = '';
			$add_filter = '';
		}
		$data = array(
			'view_filter'=>$view_filter,
			'add_filter'=>$add_filter,
		);
		echo json_encode($data);
	}
	// public function help_center($page = null){
	// 	if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
	// 		$this->load->view('admin/help_center/header');
	// 		if ($page === null){
	// 			// $data['recent'] = $this->admin_model->get_recent_booking_list();
				
	// 			$this->load->view('admin/help_center/index');
				
	// 		}else {
	// 			// Check if the requested page view exists
	// 			if (file_exists(APPPATH.'views/admin/help_center/'.$page.'.php')) {
	// 				$this->load->view('admin/help_center/'.$page);
	// 			} else {
	// 				// Show a 404 error if the page doesn't exist
	// 				show_404();
	// 			}
	// 		}
	// 		$this->load->view('admin/help_center/footer');
	// 	}
	// 	else{
	// 		redirect('admin');
	// 	}
	// }


	public function dashboard(){
	
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$data['recent'] = $this->admin_model->get_recent_booking_list();
			$this->load->view('admin/header');
			$this->load->view('admin/dashboard',$data);
			$this->load->view('admin/footer');
		}
		else{
			redirect('admin');
		}
	}
	public function change_password(){
		if($this->session->userdata('mes_admin_id') != ''){
			$this->load->view('admin/header');
			$this->load->view('change_password');
			$this->load->view('admin/footer');
		}
		else if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '1'){
			redirect('admin/company_list');
		}
		else{
			redirect('admin');
		}
	}
	public function logout(){
		$this->session->sess_destroy();
		delete_cookie('remember_me');
		redirect('admin/index');
	}
	public function admin_list(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$condition['returnType'] = 'count';
			$condition['where'] = array('role'=>0);
			$data['total_count'] = $this->admin_model->get_admin_list($condition);
			$condition1['where'] = array('role'=>0);
			$data['list'] = $this->admin_model->get_admin_list($condition1);
			$this->load->view('admin/header');
			$this->load->view('admin/admin_list/admin_list',$data);
			$this->load->view('admin/footer');
		}
		else{
			redirect('admin');
		}
	}
	public function user_list(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$condition1['where'] = array('role'=>1);
			$data['list'] = $this->admin_model->get_user_list($condition1);
			$this->load->view('admin/header');
			$this->load->view('admin/user_list/user_list',$data);
			$this->load->view('admin/footer');
		}
		else{
			redirect('admin');
		}
	}
	public function restaurant_list(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$condition1 = [];
			$data['list'] = $this->admin_model->get_restaurant_list($condition1);

			$this->load->view('admin/header');
			$this->load->view('admin/restaurant_list/restaurant_list',$data);
			$this->load->view('admin/footer');
		}
		else{
			redirect('admin');
		}
	}
	public function filter_icon_upload(){
		$config['upload_path']="./uploads/assets/images";
        $config['allowed_types']='gif|jpg|png';
        $config['encrypt_name'] = TRUE;
		$image='';
        $this->load->library('upload',$config);
		$category= $this->input->post('table_text_slug');
        if($this->upload->do_upload("filter_main_icon")){
            $data = array('upload_data' => $this->upload->data());
            $image= $data['upload_data']['file_name']; 
        }
		$result= $this->admin_model->add_filter_category($category,$image);
		echo $image;
    }
	public function delete_bulk_users(){
		$userids = $this->input->post('checkbox');
		if(!empty($userids)){
			foreach($userids as $user_id){
				$this->admin_model->delete_user_admin($user_id);
			}
		}
	}
	/**Reset Bulk user Passwords */
	public function reset_bulk_users_passwords(){
		$userids = $this->input->post('checkbox');
		if(!empty($userids)){
			// echo('<pre>');
			// print_r($userids);
			// echo('</pre>');
			// exit();
			if($this->session->userdata('mes_admin_id') != ''){
				foreach($userids as $user_id){
					//$this->admin_model->check_user_id($user_id);
					//$this->admin_model->reset_bulk_users_passwords($user_id);
	
					$id = $user_id;
					//$email = $this->input->post('user_email');
					$result = $this->admin_model->check_user_id($id);
					// echo('<pre>');
					// print_r($result);
					// echo('<pre>');
					// exit('jkkjkjkj');
					if($result){
						$code = $this->admin_model->random_strings(8);
						$this->admin_model->rest_user_pasword_forId($id,$code);
						$email_template = $this->admin_model->get_email_template('reset_user_password');
						$email_template = str_replace('{{site_title}}',$this->settings['site_title'],$email_template);
						$email_template = str_replace('{{loginlink}}',site_url(),$email_template);
						$email_template = str_replace('{{site_url}}',site_url(),$email_template);
						$email_template = str_replace('{{currentyear}}',date("Y"),$email_template);
						$subject = $email_template['email_subject'];
		
						$email_template = str_replace('{{code}}',$code,$email_template['email_body']);
						$this->email->set_newline("\r\n");
						$this->email->from($this->settings['smtp_from_email'],$this->settings['site_title']); // change it to yours
						$this->email->to($result['email']);// change it to yours
						$this->email->reply_to($this->settings['smtp_to_email']);
						$this->email->subject($this->settings['site_title'].' - '.$subject);
						$this->email->message($email_template);
						$this->email->send();
						// $data['response'] = 'success';
						// $data['message'] = 'New password sent on user\'s email Successfully.';
					}
					// echo json_encode($data);
					// exit;

				}
				$data['response'] = 'success';
				$data['message'] = 'New password sent on user\'s email Successfully.';
				echo json_encode($data);
				exit;
			}else{
				$data['response'] = 'failure';
				$data['message'] = 'You are not allowed to make this change.';
				echo json_encode($data);
				exit;
			}

		}
	}
	/**Reset Bulk user Passwords END*/

	public function import_excel_restaurant(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			if(isset($_FILES['excel_import_rest'])){
				$config['upload_path']="./uploads/assets/excel";
				$config['allowed_types']='xlsx|xls';
				$config['encrypt_name'] = TRUE;
				$file_path='';
				$this->load->library('upload',$config);
				if($this->upload->do_upload("excel_import_rest")){
					$data = array('upload_data' => $this->upload->data());
					$file_path = $data['upload_data']['full_path'];
				}
				if($file_path != ''){
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
					$spreadsheet 	= $reader->load($file_path);
					$sheetCount = $spreadsheet->getSheetCount();
					for($i=0;$i<$sheetCount;$i++){
						if($i < 2){
							$sheet = $spreadsheet->getSheet($i);
							$sheetData = $sheet->toArray(null, true, true, true);
							if(!empty($sheetData)){
								foreach($sheetData as $key => $data){
									$lastColumn = $sheet->getHighestColumn();
									$lastColumn++;
									if($key == 1){
										$kr = 1;
										$fir_ary = [];
										for ($column = 'A'; $column != $lastColumn; $column++) {
											// $cell = $sheet->getCell($column.$key);
											if($kr > 7 && $data[$column] != ''){
												$filter_name = $data[$column];
												$filter_name = preg_replace('/[^a-zA-Z0-9_ -]/s','_',$filter_name);
												$this->admin_model->insert_filter_name($filter_name);
												$fir_ary[$column] = $data[$column];
											}
											if($data[$column] == ''){
												break;
											}
											$kr++;
										}
									}
									if($key > 1 && $i == 0){
										$restaurant_name = $data['A'];
										$property_type = $data['B'];
										// $filter_type = $data['C'];
										$description = $data['C'];
										$website_url = $data['D'];
										$address = $data['E'];
										$phone = $data['F'];
										$amount = $data['G'];
										if(!empty($fir_ary)){
											foreach($fir_ary as $clm => $fil_name){
												if($data[$clm] != ''){
													$fil_value = $data[$clm];
													$fil_name = preg_replace('/[^a-zA-Z0-9_ -]/s','_',$fil_name);
													$filval = explode(',',$fil_value);
													if(!empty($filval)){
														foreach($filval as $flval){
															$this->admin_model->modify_filter_value_byname($fil_name,$flval); 
														}
													}
												}
											}
										}
										if($restaurant_name != ''){
											$this->db->where('restaurant_name',$restaurant_name);
											$query = $this->db->get('ms-restaurant');
											if(strpos($property_type, "On") !== false){
												$ptype = 'on';
											}
											else if(strpos($property_type, "Off") !== false){
												$ptype = 'off';
											}
											else{
												$ptype = '';
											}

											if($amount <= 0 || $amount == ''){
												$deposite = 'no';
											}
											else{
												$deposite = 'yes';
											}
											$data1 = array(
												'restaurant_name'=>$restaurant_name,
												'property_type'=>$ptype,
												'website_link'=>$website_url,
												'description'=>$description,
												'address'=>$address,
												'contact'=>$phone,
												'deposite'=>strtolower($deposite),
												'deposite_amount'=>$amount,
											);
											$count = $query->num_rows();
											if($count > 0){						
												$this->db->where('restaurant_name',$restaurant_name);
												$this->db->update('ms-restaurant',$data1);
											}
											else{
												$this->db->insert('ms-restaurant',$data1);
											}

											if(!empty($fir_ary)){
												$rest_id = $this->admin_model->get_restaurant_id_byname($restaurant_name);
												foreach($fir_ary as $clm => $fil_name){
													if($data[$clm] != ''){
														$filvalue = $data[$clm];
														$expfil = explode(',',$filvalue);
														if(!empty($expfil)){
															foreach($expfil as $fil_value){
																$fil_name = preg_replace('/[^a-zA-Z0-9_ -]/s','_',$fil_name);
																$where = "( rest_id = '$rest_id' AND filter_type = '$fil_name' AND filter_value = '$fil_value')";
																$this->db->where($where);
																$query = $this->db->get('ms-restaurant-filters');
																$counts = $query->num_rows();
																if($counts > 0){}
																else{
																	$dts = array(
																		'rest_id'=>$rest_id,
																		'filter_type'=>$fil_name,
																		'filter_value'=>$fil_value,
																	);
																	$this->db->insert('ms-restaurant-filters',$dts);
																}
															}
														}
													}
												}
											}
										}
									}


									if($key > 1 && $i == 1){
										$rest_name = $data['A'];
										$date = $data['B'];
										$time = $data['C'];
										$time = str_replace('.',':',$time);
										// $time = str_replace(':00 ',':00',$time);
										$size = $data['D'];
										$capacity = $data['E'];
										$this->db->where('restaurant_name',$rest_name);
										$query = $this->db->get('ms-restaurant');
										$count = $query->num_rows();
										if($count > 0){
											$row = (array)$query->row();
											$rest_id = $row['id'];
											if($date != ''){
												$where_data1 = array(
													'restaurant_id'=>$rest_id,
													'time'=>strtolower($time),
													'date'=>date('Y-m-d',strtotime($date)),
													'size'=>$size
												);
												$this->db->where($where_data1);
												$query2 = $this->db->get('ms-restaurant-tables');
												$data1 = array(
													'restaurant_id'=>$rest_id,
													'time'=>strtolower($time),
													'date'=>date('Y-m-d',strtotime($date)),
													'size'=>$size
												);
												$data1['capacity'] = $capacity;
												$count2 = $query2->num_rows();
												if($count2 > 0){
													$this->db->where($where_data1);
													$this->db->update('ms-restaurant-tables',$data1);
												}
												else{
													$this->db->insert('ms-restaurant-tables',$data1);
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}
			redirect('admin/restaurant_list');
		}
		else{
			redirect('admin');
		}
	}
	public function import_excel_users(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			if(isset($_FILES['import_users'])){
				$config['upload_path']="./uploads/assets/excel";
				$config['allowed_types'] = 'xlsx|csv|xls|ods';
				$config['encrypt_name'] = TRUE;
				$file_path='';
				$this->load->library('upload',$config);
				if($this->upload->do_upload("import_users")){
					$data = array('upload_data' => $this->upload->data());
					$file_path = $data['upload_data']['full_path'];
				}
				if($file_path != ''){
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
					$spreadsheet 	= $reader->load($file_path);
					$sheet_data 	= $spreadsheet->getActiveSheet()->toArray();
					foreach($sheet_data as $key => $val) {
						if($key > 0){
							$code = $val[0];
							$email = $val[1];
							$altemail = $val[2];
							$name = $val[3];
							$user_name = str_replace(' ','_',$name);
							$phone = $val[4];
							$temp_password = $this->admin_model->random_strings(8);
							if($email != ''){
								$this->db->where('email',$email);
								$query = $this->db->get('ms-admin');
								$count = $query->num_rows();
								$indata = array(
									'user_code'=>$code,
									'user_name'=>$user_name,
									'full_name'=>$name,
									'email'=>$email,
									'alternate_email'=>$altemail,
									'password'=>$temp_password,
									'temp_password_status'=>0,
									'mobile_number'=>$phone,
									'role'=>1,
									'status'=>0,
								);
								if($count > 0){
									$this->db->where('email',$email);
									$this->db->update('ms-admin',$indata);
								}
								else{
									$this->db->insert('ms-admin',$indata);
								}

								/**Send Password on user Email */
								//Uncomment below code to send an email to user while importing users

								// $email_template = $this->admin_model->get_email_template('reset_user_password');
								// $email_template = str_replace('{{site_title}}',$this->settings['site_title'],$email_template);
								// $email_template = str_replace('{{loginlink}}',site_url(),$email_template);
								// $email_template = str_replace('{{currentyear}}',date("Y"),$email_template);
								// $subject = $email_template['email_subject'];
								// $email_template = str_replace('{{code}}',$temp_password,$email_template['email_body']);
								// $this->email->set_newline("\r\n");
								// $this->email->from($this->settings['smtp_from_email'],$this->settings['site_title']); // change it to yours
								// $this->email->to($email);// change it to yours
								//$this->email->reply_to($this->settings['smtp_to_email']);
								// $this->email->subject($this->settings['site_title'].' - '.$subject);
								// $this->email->message($email_template);
								// $this->email->send();
								/**Send Password on user Email END*/
							}
						}
					}
				}
			}
			// redirect('admin/user_list');
		}
		else{
			// redirect('admin');
		}
	}
	public function exportRestaurant(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$condition = [];
			$list = $this->admin_model->get_restaurant_list($condition);
			$tables = $this->admin_model->get_all_restaurant_tables_list();
			$mySpreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
			$mySpreadsheet->removeSheetByIndex(0);
			$worksheet1 = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($mySpreadsheet, "Restaurants Import");
			$mySpreadsheet->addSheet($worksheet1, 0);
			$worksheet2 = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($mySpreadsheet, "Reservation Time Import");
			$mySpreadsheet->addSheet($worksheet2, 1);
			$column1 = array('Restaurant Name','Property Type','Description','Website URL','Restaurant Address','Restaurant Phone','Fee');
			$sql_fiiters = $this->admin_model->get_all_filters();
			$all_filters = [];
			if(!empty($sql_fiiters)){
				foreach($sql_fiiters as $sqlf){
					array_push($column1,$sqlf['filter_name']);
					array_push($all_filters,$sqlf['filter_name']);
				}
			}
			$sheet1data[] = $column1;
			$sheet2data[] = array('Restaurant Name','Reservation Start Date','Reservation Start Time','Table Size','Capacity');
			if(!empty($list)){
				foreach($list as $row){
					$rest_id = $row['id'];
					$type = $row['property_type'];
					if($type == 'on'){
						$property_type = 'On Property';
					}
					else if($type == 'off'){
						$property_type = 'Off Property';
					}
					else{
						$property_type = '';
					}
					$inrow = array(
						$row['restaurant_name'],$property_type,$row['description'],$row['website_link'],$row['address'],$row['contact'],$row['deposite_amount']
					);
					if(!empty($all_filters)){
						foreach($all_filters as $all_f){
							$rest_fil = $this->admin_model->get_filters_restid_filtername($rest_id,$all_f);
							$selected_val = [];
							if(!empty($rest_fil)){
								foreach($rest_fil as $filval){
									array_push($selected_val,$filval['filter_value']);
								}
							}
							$final_fil = implode(',',$selected_val);
							array_push($inrow,$final_fil);
						}
					}
					$sheet1data[] = $inrow;
				}
			} 
			if(!empty($tables)){
				foreach($tables as $row1){
					$rest_id = $row1['restaurant_id'];
					$rest_name = $this->admin_model->get_restaurant_name_byid($rest_id);
					$sheet2data[] = array(
						$rest_name,date('m/d/Y',strtotime($row1['date'])),$row1['time'],$row1['size'],$row1['capacity']
					);
				}
			}
			$worksheet1->fromArray($sheet1data);
			$worksheet2->fromArray($sheet2data);
			$worksheets = [$worksheet1, $worksheet2];
			foreach ($worksheets as $worksheet)
			{
				foreach ($worksheet->getColumnIterator() as $column)
				{
					$worksheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
				}
			}
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="export_excel'.time().'.xlsx"');
			header('Cache-Control: max-age=0');

			$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($mySpreadsheet, 'Xlsx');
			$writer->save('php://output');
			die();
		}
		else{
			redirect('admin');
		}
	}
	public function export_users(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$condition1['where'] = array('role'=>1);
			$list = $this->admin_model->get_user_list($condition1);
			$mySpreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
			$mySpreadsheet->removeSheetByIndex(0);
			$worksheet1 = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($mySpreadsheet, "Users List");
			$mySpreadsheet->addSheet($worksheet1, 0);
			$sheet1data[] = array('User Code','User Name','User Email','User Alternate Email','Contact','Temporary Password');
			$password = '';
			if(!empty($list)){

				foreach($list as $row1){
					if($row1['temp_password_status'] == 1){
						$password = 'Password has been reset';
					}else{
						$password = $row1['password'];
					}
					$sheet1data[] = array(
						$row1['user_code'],$row1['full_name'],$row1['email'],$row1['email'],$row1['mobile_number'],$password
					);
				}
			}
			$worksheet1->fromArray($sheet1data);
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="export_user_list'.time().'.xlsx"');
			header('Cache-Control: max-age=0');
			$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($mySpreadsheet, 'Xlsx');
			$writer->save('php://output');
			die();
		}
		else{
			redirect('admin');
		}
	}
	public function insert_restaurant(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$result = $this->admin_model->insert_restaurant();
			$this->session->set_flashdata('message', '<script>Swal.fire("Restaurant inserted successfully!");</script>');
			redirect('admin/restaurant_list');
		}
		else{
			redirect('admin');
		}
	}
	public function update_restaurant(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$result = $this->admin_model->update_restaurant();
			$this->session->set_flashdata('message', '<script>Swal.fire("Restaurant updated successfully!");</script>');
			redirect('admin/restaurant_list');
		}
		else{
			redirect('admin');
		}
	}

	public function update_restaurant_slots(){


		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$result = $this->admin_model->update_restaurant_slots();
			// echo json_encode($result[]=array('adminstatus'=>true));
			echo json_encode($result);
			exit;
			// $this->session->set_flashdata('message', '<script>Swal.fire("Restaurant updated successfully!");</script>');
			// redirect('admin/restaurant_list');
		}
		else{
			echo json_encode(array('status'=>false));
			exit;
			// redirect('admin');
		}

		// $data = $this->input->post();
		// echo json_encode($data);
		// exit;
		// return array('sdfsdf'=>'ffff');
	}

	public function modify_booking_detail(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$book_slot_id = $this->uri->segment(3);
			$data['booked_list'] = $this->admin_model->get_dates_list_booking_byid($book_slot_id);
			$user_id = $data['booked_list']['user_id'];
			$selected_date = $data['booked_list']['booking_date'];
			$selected_time = $data['booked_list']['booking_time'];
			$selected_pax = $data['booked_list']['booking_pax'];
			$data['booking_detail'] = $this->admin_model->get_booking_detail_byuserid($user_id);
			$data['filters'] = $this->admin_model->get_all_filters();
			$data['dates_list'] = $this->admin_model->get_dates_list_booking();
			$data['time_list'] = $this->admin_model->get_time_list_booking();
			$data['pax_list'] = $this->admin_model->get_pax_list_booking();
			$data['hotels_list'] = $this->admin_model->get_hotels_list_with_filter($selected_date,$selected_time,$selected_pax);
			$data['selected_date'] = $selected_date;
			$data['selected_time'] = $selected_time;
			$data['selected_pax'] = $selected_pax;
			$this->load->view('admin/header');
			$this->load->view('admin/booking_list/modify_booking_detail',$data);
			$this->load->view('admin/footer');
		}
		else{
			redirect('admin');
		}
	}
	public function add_booking_user(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$userid = $this->uri->segment(3);
			$userdata = $this->admin_model->get_booking_detail_byuserid($userid);
			if(empty($userdata)){
			$data = array('userid'=>$userid);
			$date = '';
			$time = '';
			$pax = '';
			$data['dates_list'] = $this->admin_model->get_dates_list_booking();
			$data['time_list'] = $this->admin_model->get_time_list_booking();
			$data['pax_list'] = $this->admin_model->get_pax_list_booking();
			$data['hotels_list'] = $this->admin_model->get_hotels_list_with_filter($date,$time,$pax);
			$data['filters'] = $this->admin_model->get_filters_list();
			$this->load->view('admin/header');
			$this->load->view('admin/booking_list/add_booking_user',$data);
			$this->load->view('admin/footer');
			}
		}
		else{
			redirect('admin');
		}
	}
	public function modify_popup_booking_restaurant(){
		$rest_id = $this->input->post('rest_id');
		$bookid = $this->input->post('bookid');
		$time = $this->input->post('time');
		$pax = $this->input->post('pax');
		$data['hotel'] = $this->admin_model->get_restaurant_detail($rest_id);
		$data['book_id'] = $bookid;
		$data['time'] = $time;
		$data['pax'] = $pax;
		$data['book'] = $this->admin_model->get_dates_list_booking_byid($bookid);
		$this->load->view('admin/modify-restaurant-popup',$data);
	}
	public function edit_restaurant(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$rest_id = $this->uri->segment(3);
			$data['data'] = $this->admin_model->get_restaurant_detail($rest_id);
			$data['tables'] = $this->admin_model->get_restaurant_tables_list($rest_id);
			$data['reviews'] = $this->admin_model->get_restaurant_reviews_list($rest_id);
			$data['selected_filters'] = $this->admin_model->get_restaurant_filters_list($rest_id);
			$data['filters'] = $this->admin_model->get_all_filters();
			$this->load->view('admin/header');
			$this->load->view('admin/restaurant_list/edit_restaurant',$data);
			$this->load->view('admin/footer');
		}
		else{
			redirect('admin');
		}
	}
	public function view_restaurant(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$rest_id = $this->uri->segment(3);
			$data['data'] = $this->admin_model->get_restaurant_detail($rest_id);
			$data['tables'] = $this->admin_model->get_restaurant_tables_list($rest_id);
			$data['reviews'] = $this->admin_model->get_restaurant_reviews_list($rest_id);
			$data['selected_filters'] = $this->admin_model->get_restaurant_filters_list($rest_id);
			$data['filters'] = $this->admin_model->get_all_filters();
			$this->load->view('admin/header');
			$this->load->view('admin/restaurant_list/view_restaurant',$data);
			$this->load->view('admin/footer');
		}
		else{
			redirect('admin');
		}
	}
	public function modify_restaurant_admin_book(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$data = $this->admin_model->modify_restaurant_admin_book();
			$data = array(
				'response'=>'success',
				'href'=>site_url('admin/view_booking_detail/'.$data['booking_id']),
			);
			echo json_encode($data);
		}
		else{
			redirect('admin');
		}
	}
	public function filter_restaurant_list(){
		if($this->session->userdata('mes_admin_id') != ''){
		$filter_type = $this->input->post('filter_type');
		$filter_value = $this->input->post('filter_value');
		$property_type = $this->input->post('property_type');
		$book_date = $this->input->post('book_date');
		$book_time = $this->input->post('book_time');
		$bookid = $this->input->post('bookid');
		$book_pax = $this->input->post('book_pax');
		$data['booked_list'] = $this->admin_model->get_dates_list_booking_byid($bookid);
		$hotels = $this->user_model->filter_restaurant_list($filter_type,$filter_value,$property_type,$book_date,$book_pax,$book_time);
		foreach ($hotels as $hotel) { 
			$data['hotel'] = $hotel;
			$data['selected_pax'] = $book_pax;
			$data['selected_time'] = $book_time;
			$data['date'] = $book_date;
			$data['selected_date'] = $book_date;
			$data['booked'] = 'no';
			$this->load->view('admin/restaurant-box',$data);    
		 }
		}
		else{
			redirect('index');
		}
	}
	public function add_restaurant(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$data['filters'] = $this->admin_model->get_all_filters();
			$this->load->view('admin/header');
			$this->load->view('admin/restaurant_list/add_restaurant',$data);
			$this->load->view('admin/footer');
		}
		else{
			redirect('admin');
		}
	}
	public function add_filter(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$this->load->view('admin/header');
			$this->load->view('admin/restaurant_list/add_filter');
			$this->load->view('admin/footer');
		}
		else{
			redirect('admin');
		}
	}
	public function add_admin(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$this->load->view('admin/header');
			$this->load->view('admin/admin_list/add_admin');
			$this->load->view('admin/footer');
		}
		else{
			redirect('admin');
		}
	}
	public function insert_admin(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$result = $this->admin_model->insert_admin();
			if(!empty($result)){
				/**Send Password on user Email */
				//$this->admin_model->rest_user_pasword_foremail($email,$temp_password);
				
				// $email_template = $this->admin_model->get_email_template('reset_user_password');
				// $email_template = str_replace('{{site_title}}',$this->settings['site_title'],$email_template);
				// $email_template = str_replace('{{loginlink}}',site_url('admin'),$email_template);
				// $email_template = str_replace('{{currentyear}}',date("Y"),$email_template);
				// $subject = $email_template['email_subject'];
				// $email_template = str_replace('{{code}}',$result['password'],$email_template['email_body']);
				// $this->email->set_newline("\r\n");
				// $this->email->from($this->settings['smtp_from_email'],$this->settings['site_title']); // change it to yours
				// $this->email->to($result['email']);// change it to yours
				//$this->email->reply_to($this->settings['smtp_to_email']);
				// $this->email->subject($this->settings['site_title'].' - '.$subject);
				// $this->email->message($email_template);
				// $this->email->send();
				/**Send Password on user Email END*/
				redirect('admin/admin_list');
			}
			
		}
		else{
			redirect('admin');
		}
	}
	public function remove_filter_permanent(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$filter_id = $this->input->post('filter_id');
			$result = $this->admin_model->remove_filter_permanent($filter_id);
		}
		else{
			redirect('admin');
		}
	}
	public function delete_admin_restaurant(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$rest_id = $this->input->post('rest_id');
			$notify = $this->input->post('notify');
			$result = $this->admin_model->markBookedResAsCanceld($rest_id);
			if($notify == 'yes'){
				$this->markBookedResAsCanceld($result);
			}
			$this->admin_model->delete_admin_restaurant($rest_id);
		}
		else{
			redirect('admin');
		}
	}
	
	function markBookedResAsCanceld($result){

		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
	
				if(!empty($result)){
					foreach($result as $res){

						
						//Send Cancelation email to Admins and User
						$user_id = $res['user_id'];
						$cancellation = "Restaurant removed by Admin ".$this->session->userdata('admin_email');
						$user_data = $this->user_model->get_user_detail_byuserid($user_id);
						$user_name = $user_data['full_name'];
						$user_email = $user_data['email'];
		
						$id = $res['id'];
						
						//exit($id.'dddd');
						$list = '';
						$resByBookingId = $this->admin_model->get_all_bookings_by_booking_id($res['booking_id']);

						foreach($resByBookingId as $singleRes){
							$booking = $this->user_model->get_booking_date_detail($singleRes['id']);
							$rest_id = $res['booking_restid'];
							$booking_id = $booking['booking_id'];
							$array['booking'] = $booking;
							$array['hotel'] = $this->user_model->get_restaurant_detail($rest_id);
							
							$list .= $this->load->view('emails/cancel_restaurant', $array, TRUE);
						}

						$admins = $this->user_model->get_admin_list_sendemail('restaurant_removed_admin_canceled_reservation');
		
						//Send Cancelation email to Admins only is restaurant_removed_admin_canceled_reservation notification is Enabled

						$admin_id = $this->session->userdata('mes_admin_id');
						$notificationConf = $this->admin_model->get_user_detail($admin_id);
						$noti = $notificationConf['notifications'];
						$arrayNoti = explode(',',$noti);

						// if(in_array('restaurant_removed_admin_canceled_reservation',$arrayNoti)){
							$email_template = $this->admin_model->get_email_template('restaurant_removed_admin_canceled_reservation');
							
							$subject = $email_template['email_subject'];
							$email_template = str_replace('{{user_name}}',$user_name,$email_template['email_body']);
		
							$email_template = str_replace('{{cancel_restaurant_list}}',$list,$email_template);
							$email_template = str_replace('{{order_id}}',$booking_id,$email_template);
							$email_template = str_replace('{{site_title}}',$this->settings['site_title'],$email_template);
							$email_template = str_replace('{{cancel_booking_reason}}',$cancellation,$email_template);
							$email_template = str_replace('{{admin_url}}',site_url('admin'),$email_template);
							$email_template = str_replace('{{currentyear}}',date("Y"),$email_template);
							$email_template = str_replace('{{site_url}}',site_url(),$email_template);
							$this->email->set_newline("\r\n");
							$this->email->from($this->settings['smtp_from_email'],$this->settings['site_title']); // change it to yours
							$this->email->to($this->settings['admin_email']);// change it to yours
							$this->email->reply_to($this->settings['smtp_to_email']);
							if(!empty($admins)){
								$this->email->cc($admins);
							}
							$this->email->subject($this->settings['site_title'].' - '.$subject);
							$this->email->message($email_template);
							$this->email->send();
						// }
						//Send Cancelation email to Admins END
			
						//Send Cancelation email to User
						$email_template = $this->admin_model->get_email_template('restaurant_removed_user_canceled_reservation');
						$subject = $email_template['email_subject'];
						$email_template = str_replace('{{user_name}}',$user_name,$email_template['email_body']);
						$email_template = str_replace('{{cancel_restaurant_list}}',$list,$email_template);
						$email_template = str_replace('{{order_id}}',$booking_id,$email_template);
						$email_template = str_replace('{{site_title}}',$this->settings['site_title'],$email_template);
						$email_template = str_replace('{{cancel_booking_reason}}',$cancellation,$email_template);
						$email_template = str_replace('{{site_url}}',site_url(),$email_template);
						$email_template = str_replace('{{currentyear}}',date("Y"),$email_template);
						$this->email->set_newline("\r\n");
						$this->email->from($this->settings['smtp_from_email'],$this->settings['site_title']); // change it to yours
						$this->email->to($user_email);// change it to yours
						$this->email->reply_to($this->settings['smtp_to_email']);
						$this->email->subject($this->settings['site_title'].' - '.$subject);
						$this->email->message($email_template);
						$this->email->send();
						//Send Cancelation email to User END
					}
			}
			return;
		}
		else{
			redirect('admin');
		}



	}

	public function email_list(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$condition1 = [];
			$data['list'] = $this->admin_model->get_email_list($condition1);
			$this->load->view('admin/header');
			$this->load->view('admin/email_list/email_list',$data);
			$this->load->view('admin/footer');
		}
		else{
			redirect('admin');
		}
	}
	public function edit_email(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$id = $this->uri->segment(3);
			$data['data'] = $this->admin_model->get_email_detail_byid($id);
			$this->load->view('admin/header');
			$this->load->view('admin/email_list/edit_email',$data);
			$this->load->view('admin/footer');
		}
		else{
			redirect('admin');
		}
	}
	public function booking_list(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$condition1 = [];
			$data['list'] = $this->admin_model->get_email_list($condition1);
			$data['settingsData'] = $this->admin_model->theme_setting();
			$this->load->view('admin/header');
			$this->load->view('admin/booking_list/booking_list',$data);
			$this->load->view('admin/footer');
		}
		else{
			redirect('admin');
		}
	}
	public function reports_list(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$condition1 = [];
			$data['list'] = $this->admin_model->get_email_list($condition1);
			$this->load->view('admin/header');
			$this->load->view('admin/reports_list/reports_list',$data);
			$this->load->view('admin/footer');
		}
		else{
			redirect('admin');
		}
	}
	public function edit_email_setting(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$this->load->view('admin/header');
			$this->load->view('admin/email_list/edit_email_setting');
			$this->load->view('admin/footer');
		}
		else{
			redirect('admin');
		}
	}
	public function master_booking_list(){

			// echo('<pre>');
			// print_r($_SERVER);
			// echo('</pre>');exit();

		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$data['list'] = $this->admin_model->get_master_booking_list();
			$config['target']      = '#total_master_reservation'; 
			$config['base_url']    = base_url('admin/ajax_master_booking_list'); 
			$config['total_rows']  = count($data['list']); 
			$data['total_rows']  = count($data['list']); 
			$config['per_page']    = 10; 
			$config['link_func']    = 'ajax_filter_form_complete_booking'; 
			$this->ajax_pagination->initialize($config); 
			$conditions = array( 
				'limit' => 10 
			); 

			$data['list'] = $this->admin_model->get_master_booking_list($conditions);


			$this->load->view('admin/header');
			$this->load->view('admin/booking_list/master_booking_list',$data);
			$this->load->view('admin/footer');
		}
		else{
			redirect('admin');
		}
	}
	public function ajax_master_booking_list(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$per_page = 10;
			$page = $this->input->post('page'); 
			$min = $this->input->post('min'); 
			$max = $this->input->post('max'); 
			$length = $this->input->post('length'); 
			$book_status = $this->input->post('book_status'); 
			$search_keyword = $this->input->post('search_keyword'); 
			$conditions = [];
			if($min != '' && $max != ''){
				$conditions = array( 
					'from_date' => $min, 
					'to_date' => $max, 
				); 
			}
			if($search_keyword != ''){
				$conditions['keyword'] = $search_keyword;
			}
			if($book_status != ''){
				$conditions['book_status'] = $book_status;
			}
			$data['list'] = $this->admin_model->get_master_booking_list($conditions);
			if($length != ''){
				$per_page = $length;
			}
			if(!$page){ 
				$offset = 0; 
			}else{ 
				$offset = $page; 
			} 
			$config['target']      = '#total_master_reservation'; 
			$config['base_url']    = base_url('admin/ajax_master_booking_list'); 
			$config['total_rows']  = count($data['list']); 
			$config['per_page']    = $per_page; 
			$config['cur_page']    = $offset; 
			$config['link_func']    = 'ajax_filter_form_complete_booking'; 
			$this->ajax_pagination->initialize($config); 
			$conditions ['limit'] = $per_page; 
			if($offset > 0){
				$conditions['start'] = $offset;
			}
			$data['list'] = $this->admin_model->get_master_booking_list($conditions);
			$this->load->view('admin/booking_list/ajax/master_booking_list',$data);
		}
	}	
	public function export_master_booking_list(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$min = $this->input->post('min'); 
			$max = $this->input->post('max'); 
			$book_status = $this->input->post('book_status'); 
			$search_keyword = $this->input->post('search_keyword'); 
			$exportFileName = $this->input->post('exportfilename'); 

			$conditions = [];
			if($min != '' && $max != ''){
				$conditions = array( 
					'from_date' => $min, 
					'to_date' => $max, 
				); 
			}
			if($search_keyword != ''){
				$conditions['keyword'] = $search_keyword;
			}
			if($book_status != ''){
				$conditions['book_status'] = $book_status;
			}
			$dates = $this->admin_model->get_dates_list_booking();
			$list = $this->admin_model->get_master_booking_list($conditions);
			// echo('<pre>');
			// print_r($list);
			// echo('</pre>');exit();
			$mySpreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
			$mySpreadsheet->removeSheetByIndex(0);
			$worksheet1 = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($mySpreadsheet, "Users List");
			$mySpreadsheet->addSheet($worksheet1, 0);
			$columns = array('First Name','Last Name','Email Address','Response Status');
			if(!empty($dates)){
				$k=1; 
				foreach($dates as $date){
					// array_push($columns,'Day '.$k.' Status');
					// array_push($columns,'Day '.$k.' Role');
					// array_push($columns,'Day '.$k.' Date');
					// array_push($columns,'Day '.$k.' Time');
					// array_push($columns,'Day '.$k.' Restaurant Name');
					// array_push($columns,'Day '.$k.' Property Type');
					// array_push($columns,'Day '.$k.' Reserved People');
					// array_push($columns,'Day '.$k.' Guests');
					// array_push($columns,'Day '.$k.' Admin Note');
					// array_push($columns,'Day '.$k.' Modified Date');
					
					array_push($columns,'Day '.$k.' Status');
					array_push($columns,'Day '.$k.' Role');
					array_push($columns,'Day '.$k.' Date');
					array_push($columns,'Day '.$k.' Time');
					array_push($columns,'Day '.$k.' Restaurant Name');
					array_push($columns,'Day '.$k.' Property Type');
					array_push($columns,'Day '.$k.' Pax');
					array_push($columns,'Day '.$k.' Guests');
					array_push($columns,'Day '.$k.' Admin Note');
					array_push($columns,'Day '.$k.' Last Updated');
					$k++;
				}
			}
			$sheet1data[] = $columns;
			if(!empty($list)){
				$j=1;
				foreach($list as $key => $data){
					$user_id = $data['id'];
					$booking = $this->admin_model->get_booking_detail_byuserid($user_id);
					$booking_status = 'No Response';
					if(!empty($dates) && !empty($booking)){
						$booked = 1;
						foreach($dates as $date){
							$status = $this->admin_model->get_status_of_booking_date_byid($booking['id'],$date['date']);
							if($status != 'Booked'){
								$booked = 0;
							}
						}
						if($booked == 0){
							$booking_status = 'Partial';
						}
						if($booked == 1){
							$booking_status = 'Completed';
						}
					}
					$username = $data['full_name'];
					$exp = explode(' ',$username);
					$first_name = $exp[0];
					$last_name = $exp[1];
					$row = array($first_name,$last_name,$data['email'],$booking_status);
					if(!empty($dates)){
						foreach($dates as $date){
								// $reservation_status = 'Skipped';
								$reservation_status = 'No Response';
								$reservation_role = '';
								$reservation_date = '';
								$reservation_time = '';
								$reservation_restname = '';
								$reservation_resttype = '';
								$reservation_pax = '';
								$reservation_guests = '';
								$reservation_admin_note = '';
								$modify_date = '';
								$invite_status = $this->admin_model->get_invite_status_byuserid_bookdate($user_id,$date['date']);
								if(!empty($invite_status)){
									if($invite_status['status'] == 'invite'){
										$reservation_status = 'Pending Acceptance';
									}
									$from_data = $this->admin_model->get_user_detail($invite_status['from_id']);
									$reservation_role = 'Guest of '.$from_data['full_name'];
								}
								if(!empty($booking)){
								$reserv_data = $this->admin_model->get_booking_dates_list_by_bookingid_date($booking['id'],$date['date']);
									if(!empty($reserv_data)){
										$reservation_admin_note = $reserv_data['admin_note'];
										$reservation_status = ucfirst($reserv_data['booking_status']);
										if($reserv_data['booking_status'] == 'skip'){
											// $reservation_status = $reservation_status.' ('.$reserv_data['booking_reason'].')';
											$reservation_status = $reserv_data['booking_reason'];
										}
										if($reserv_data['booking_status'] == 'cancel'){
											$reservation_status = $reservation_status.' ('.$reserv_data['booking_reason'].')';
										}
										if($reserv_data['ref_id'] == 0){
											$reservation_role = 'Primary';
										}
										$reservation_date = date('m-d-Y',strtotime($reserv_data['booking_date']));
										$reservation_time = $reserv_data['booking_time'];
										$reservation_pax = $reserv_data['booking_pax'];
										$reservation_restname  = $this->admin_model->get_restaurant_name_byid($reserv_data['booking_restid']);
										$property_type  = $this->admin_model->get_restaurant_type_byid($reserv_data['booking_restid']);
                                        $reservation_resttype = $this->admin_model->get_property_type_text($property_type);
										// if($reserv_data['guests'] != ''){
										// 	$gexp = explode(',',$reserv_data['guests']);
										// 	$guest = [];
										// 	foreach($gexp as $gid){
										// 		$guest[] = $this->admin_model->get_user_name_byid($gid);
										// 	}
										// 	$reservation_guests = implode(', ',$guest);
										// }
										if($reserv_data['guests'] != ''){
											$gexp = explode(',',$reserv_data['guests']);
											$guest = [];
											foreach($gexp as $gid){
												$guest[] = $this->admin_model->get_user_name_byid($gid);
											}
											$reservation_guests = implode(', ',$guest);
										}
										if($reserv_data['booking_status'] == 'cancel' || $reserv_data['booking_status'] == 'skip'){
											$reservation_role = '';
											$reservation_date = '';
											$reservation_time = '';
											$reservation_restname = '';
											$reservation_resttype = '';
											$reservation_pax = '';
											$reservation_guests = '';
										}
									}
									$modify_date = date('m-d-Y',strtotime($booking['modify_date']));

									//Convert time stamp to NY time zone
									// Create a DateTime object from the timestamp string
									$date = DateTime::createFromFormat('Y-m-d H:i:s', $booking['modify_date'], new DateTimeZone('UTC'));

									// Set the target time zone (New York)
									$date->setTimezone(new DateTimeZone('America/New_York'));

									// Format the date in the target time zone
									$new_york_time = $date->format('Y-m-d H:i:s');
									$modify_date = date('m-d-Y H:i:s',strtotime($new_york_time));
									//Convert time stamp to NY time zone END

								}
							array_push($row, $reservation_status);
							array_push($row, $reservation_role);
							array_push($row, $reservation_date);
							array_push($row, $reservation_time);
							array_push($row, $reservation_restname);
							array_push($row, $reservation_resttype);
							array_push($row, $reservation_pax);
							array_push($row, $reservation_guests);
							array_push($row, $reservation_admin_note);
							array_push($row, $modify_date);
							}
						}
						$sheet1data[] = $row;
			$j++;	}
				}
			$worksheet1->fromArray($sheet1data);
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="export_master_booking_list'.time().'.xlsx"');
			header('Cache-Control: max-age=0');
			$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($mySpreadsheet, 'Xlsx');
			ob_start();
			$writer->save('php://output');
			$xlsData = ob_get_contents();
			ob_end_clean();
			$array = array(
				// 'filename'=> "export_master_booking_list".time().".xlsx",
				'filename'=> $exportFileName.".xlsx",
				'data' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
			);
			echo json_encode($array);
		}
	}
	public function complete_booking_list(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$data['list'] = $this->admin_model->get_complete_booking_list();
			$this->load->view('admin/header');
			$this->load->view('admin/booking_list/complete_booking_list',$data);
			$this->load->view('admin/footer');
		}
		else{
			redirect('admin');
		}
	}
	public function partial_booking_list(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$data['list'] = $this->admin_model->get_partial_booking_list();
			$this->load->view('admin/header');
			$this->load->view('admin/booking_list/partial_booking_list',$data);
			$this->load->view('admin/footer');
		}
		else{
			redirect('admin');
		}
	}
	public function pending_booking_list(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$data['list'] = $this->admin_model->get_pending_booking_list();
			$config['target']      = '#total_master_reservation'; 
			$config['base_url']    = base_url('admin/ajax_pending_booking_list'); 
			$config['total_rows']  = count($data['list']); 
			$config['per_page']    = 10; 
			$config['link_func']    = 'ajax_filter_form_complete_booking'; 
			$this->ajax_pagination->initialize($config); 
			$conditions = array( 
				'limit' => 10 
			); 
			$data['list'] = $this->admin_model->get_pending_booking_list($conditions);
			$this->load->view('admin/header');
			$this->load->view('admin/booking_list/pending_booking_list',$data);
			$this->load->view('admin/footer');
		}
		else{
			redirect('admin');
		}
	}
	public function ajax_pending_booking_list(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$per_page = 10;
			$page = $this->input->post('page'); 
			$length = $this->input->post('length'); 
			$search_keyword = $this->input->post('search_keyword'); 
			$conditions = [];
			if($search_keyword != ''){
				$conditions['keyword'] = $search_keyword;
			}
			$data['list'] = $this->admin_model->get_pending_booking_list($conditions);
			if($length != ''){
				$per_page = $length;
			}
			if(!$page){ 
				$offset = 0; 
			}else{ 
				$offset = $page; 
			} 
			$config['target']      = '#total_master_reservation'; 
			$config['base_url']    = base_url('admin/ajax_pending_booking_list'); 
			$config['total_rows']  = count($data['list']); 
			$config['per_page']    = $per_page; 
			$config['cur_page']    = $offset; 
			$config['link_func']    = 'ajax_filter_form_complete_booking'; 
			$this->ajax_pagination->initialize($config); 
			$conditions ['limit'] = $per_page; 
			if($offset > 0){
				$conditions['start'] = $offset;
			}
			$data['list'] = $this->admin_model->get_pending_booking_list($conditions);
			$this->load->view('admin/booking_list/ajax/pending_booking_list',$data);
		}	
	}
	public function export_pending_booking_list(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$search_keyword = $this->input->post('search_keyword'); 
			$exportFileName = $this->input->post('exportfilename');
			$conditions = [];
			if($search_keyword != ''){
				$conditions['keyword'] = $search_keyword;
			}
			$list = $this->admin_model->get_pending_booking_list($conditions);
			$mySpreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
			$mySpreadsheet->removeSheetByIndex(0);
			$worksheet1 = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($mySpreadsheet, "Users List");
			$mySpreadsheet->addSheet($worksheet1, 0);
			$columns = array('User email','User name','User contact','Reservervation status');
			$sheet1data[] = $columns;
			if(!empty($list)):
				foreach ($list as $key => $data) {
					$sheet1data[] = array($data['email'],$data['full_name'],$data['mobile_number'],'No Response');
				}
			endif;
			$worksheet1->fromArray($sheet1data);
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="export_pending_booking_list'.time().'.xlsx"');
			header('Cache-Control: max-age=0');
			$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($mySpreadsheet, 'Xlsx');
			ob_start();
			$writer->save('php://output');
			$xlsData = ob_get_contents();
			ob_end_clean();
			$array = array(
				// 'filename'=> "export_pending_booking_list".time().".xlsx",
				'filename'=> $exportFileName.".xlsx",
				'data' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
			);
			echo json_encode($array);
		}
	}
	public function cancel_booking_list(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$data['list'] = $this->admin_model->get_cancel_booking_list();
			$config['target']      = '#total_master_reservation'; 
			$config['base_url']    = base_url('admin/ajax_cancel_booking_list'); 
			$config['total_rows']  = count($data['list']); 
			$config['per_page']    = 10; 
			$config['link_func']    = 'ajax_filter_form_complete_booking'; 
			$this->ajax_pagination->initialize($config); 
			$conditions = array( 
				'limit' => 10 
			); 
			$data['list'] = $this->admin_model->get_cancel_booking_list($conditions);
			$this->load->view('admin/header');
			$this->load->view('admin/booking_list/cancel_booking_list',$data);
			$this->load->view('admin/footer');
		}
		else{
			redirect('admin');
		}
	}
	public function ajax_cancel_booking_list(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$per_page = 10;
			$page = $this->input->post('page'); 
			$length = $this->input->post('length'); 
			$search_keyword = $this->input->post('search_keyword'); 
			$conditions = [];
			if($search_keyword != ''){
				$conditions['keyword'] = $search_keyword;
			}
			$data['list'] = $this->admin_model->get_cancel_booking_list($conditions);
			if($length != ''){
				$per_page = $length;
			}
			if(!$page){ 
				$offset = 0; 
			}else{ 
				$offset = $page; 
			} 
			$config['target']      = '#total_master_reservation'; 
			$config['base_url']    = base_url('admin/ajax_cancel_booking_list'); 
			$config['total_rows']  = count($data['list']); 
			$config['per_page']    = $per_page; 
			$config['cur_page']    = $offset; 
			$config['link_func']    = 'ajax_filter_form_complete_booking'; 
			$this->ajax_pagination->initialize($config); 
			$conditions ['limit'] = $per_page; 
			if($offset > 0){
				$conditions['start'] = $offset;
			}
			$data['list'] = $this->admin_model->get_cancel_booking_list($conditions);
			$this->load->view('admin/booking_list/ajax/cancel_booking_list',$data);
		}
	}
	public function export_cancel_booking_list(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){ 
			$search_keyword = $this->input->post('search_keyword'); 
			$exportFileName = $this->input->post('exportfilename');
			$conditions = [];
			if($search_keyword != ''){
				$conditions['keyword'] = $search_keyword;
			}
			$list = $this->admin_model->get_cancel_booking_list($conditions);
			$mySpreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
			$mySpreadsheet->removeSheetByIndex(0);
			$worksheet1 = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($mySpreadsheet, "Cancel Booking List");
			$mySpreadsheet->addSheet($worksheet1, 0);
			$columns = array('Confirmation ID','User name','User email','Restaurant name','Date','Time','No of People','Deposit $','Cancelled Date','Cancelled Time');
			$sheet1data[] = $columns;
			if(!empty($list)){
				$j=1;
				foreach($list as $key => $data){
					$confirm_id = '#'.$data['booking_id'];
					$user_id = $data['user_id'];
					$udata = $this->admin_model->get_user_date_byid($user_id);
					$busname = $udata['full_name'];
					$bemail = $udata['email'];
					$bdate = date('d-m-Y',strtotime($data['created_date']));
					$btime = date('h:ia',strtotime($data['created_date']));
					$rest_name = $this->admin_model->get_restaurant_name_byid($data['booking_restid']);
					$sheet1data[] = array($confirm_id,$busname,$bemail,$rest_name,date('m-d-Y',strtotime($data['booking_date'])),$data['booking_time'],$data['booking_pax'],'$'.$data['booking_deposite'],$bdate,$btime);
			    }
				}
			$worksheet1->fromArray($sheet1data);
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="export_cancel_booking_list'.time().'.xlsx"');
			header('Cache-Control: max-age=0');
			$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($mySpreadsheet, 'Xlsx');
			ob_start();
			$writer->save('php://output');
			$xlsData = ob_get_contents();
			ob_end_clean();
			$array = array(
				// 'filename'=> "export_cancel_booking_list".time().".xlsx",
				'filename'=> $exportFileName.".xlsx",
				'data' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
			);
			echo json_encode($array);
		}
	}
	public function confirm_delete_invite(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){ 
			$to_id = $this->input->post('userid');
			$listid = $this->input->post('listid');
			$from_id = $this->admin_model->get_invited_fromid_bytoid($to_id,$listid);
			$result = $this->user_model->confirm_delete_invite($from_id,$to_id,$listid);
			$data = array(
				'response'=>'success',
				'message'=>'successfuly deleted.'
			);
		}
		else{
			$data = array(
				'response'=>'failure',
				'message'=>'something went wrong, please try again later.'
			);
		}
		echo json_encode($data);
		exit;
	}
	public function all_booking_list(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$data['list'] = $this->admin_model->get_master_booking_list();
			$config['target']      = '#total_master_reservation'; 
			$config['base_url']    = base_url('admin/ajax_all_booking_list'); 
			$config['total_rows']  = count($data['list']); 
			$data['total_rows']  = count($data['list']); 
			$config['per_page']    = 10; 
			$config['link_func']    = 'ajax_filter_form_complete_booking'; 
			$this->ajax_pagination->initialize($config); 
			$conditions = array( 
				'limit' => 10 
			); 
			$data['list'] = $this->admin_model->get_master_booking_list($conditions);
			$this->load->view('admin/header');
			$this->load->view('admin/booking_list/all_booking_list',$data);
			$this->load->view('admin/footer');
		}
		else{
			redirect('admin');
		}
	}
	public function ajax_all_booking_list(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$per_page = 10;
			$page = $this->input->post('page'); 
			$min = $this->input->post('min'); 
			$max = $this->input->post('max'); 
			$length = $this->input->post('length'); 
			$book_status = $this->input->post('book_status'); 
			$search_keyword = $this->input->post('search_keyword'); 
			$conditions = [];
			if($min != '' && $max != ''){
				$conditions = array( 
					'from_date' => $min, 
					'to_date' => $max, 
				); 
			}
			if($search_keyword != ''){
				$conditions['keyword'] = $search_keyword;
			}
			if($book_status != ''){
				$conditions['book_status'] = $book_status;
			}
			$data['list'] = $this->admin_model->get_master_booking_list($conditions);
			if($length != ''){
				$per_page = $length;
			}
			if(!$page){ 
				$offset = 0; 
			}else{ 
				$offset = $page; 
			} 
			$config['target']      = '#total_master_reservation'; 
			$config['base_url']    = base_url('admin/ajax_all_booking_list'); 
			$config['total_rows']  = count($data['list']); 
			$config['per_page']    = $per_page; 
			$config['cur_page']    = $offset; 
			$config['link_func']    = 'ajax_filter_form_complete_booking'; 
			$this->ajax_pagination->initialize($config); 
			$conditions ['limit'] = $per_page; 
			if($offset > 0){
				$conditions['start'] = $offset;
			}
			$data['list'] = $this->admin_model->get_master_booking_list($conditions);
			$this->load->view('admin/booking_list/ajax/all_booking_list',$data);
		}		
	}
	public function export_all_booking_list(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$min = $this->input->post('min'); 
			$max = $this->input->post('max'); 
			$book_status = $this->input->post('book_status'); 
			$search_keyword = $this->input->post('search_keyword'); 
			$exportFileName = $this->input->post('exportfilename');
			$conditions = [];
			if($min != '' && $max != ''){
				$conditions = array( 
					'from_date' => $min, 
					'to_date' => $max, 
				); 
			}
			if($search_keyword != ''){
				$conditions['keyword'] = $search_keyword;
			}
			if($book_status != ''){
				$conditions['book_status'] = $book_status;
			}
			$dates = $this->admin_model->get_dates_list_booking();
			$list = $this->admin_model->get_master_booking_list($conditions);
			$mySpreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
			$mySpreadsheet->removeSheetByIndex(0);
			$worksheet1 = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($mySpreadsheet, "Users List");
			$mySpreadsheet->addSheet($worksheet1, 0);
			$columns = array('User Code','Full Name','User Email','Alternate Email','Booking Status');
			if(!empty($dates)){
				$k=1; 
				foreach($dates as $date){
					array_push($columns,date('m-d-Y',strtotime($date['date'])));
					$k++;
				}
			}
			array_push($columns,'Modified Date');
			$sheet1data[] = $columns;
			if(!empty($list)){
				$j=1;
				foreach($list as $key => $data){
					$user_id = $data['id'];
						$booking = $this->admin_model->get_booking_detail_byuserid($user_id);
						$booking_status = 'No Response';
						// $reservation_status = 'Skipped';
						$reservation_status = 'No Response';
						if(!empty($dates) && !empty($booking)){
							$booked = 1;
							foreach($dates as $date){
								$status = $this->admin_model->get_status_of_booking_date_byid($booking['id'],$date['date']);
								if($status != 'Booked'){
									$booked = 0;
								}
							}
							if($booked == 0){
								$booking_status = 'Partial';
							}
							if($booked == 1){
								$booking_status = 'Completed';
							}
						}
					$row = array($data['user_code'],$data['full_name'],$data['email'],$data['alternate_email'],$booking_status);
					if(!empty($dates)){
						foreach($dates as $date){
							if(!empty($booking)){
								$reserv_data = $this->admin_model->get_booking_dates_list_by_bookingid_date($booking['id'],$date['date']);
									if(!empty($reserv_data)){
										$reservation_status = ucfirst($reserv_data['booking_status']);
										if($reserv_data['booking_status'] == 'skip'){
											// $reservation_status = $reservation_status.' ('.$reserv_data['booking_reason'].')';
											$reservation_status = $reserv_data['booking_reason'];
										}
										if($reserv_data['booking_status'] == 'cancel'){
											$reservation_status = $reservation_status.' ('.$reserv_data['booking_reason'].')';
										}
									}
							}
							array_push($row,$reservation_status);
						}
					}
					$book_date = '';
					if(!empty($booking)){
						$book_date = date('m-d-Y',strtotime($booking['modify_date']));
					}
					array_push($row,$book_date);
					$sheet1data[] = $row;
				}
			}
			$worksheet1->fromArray($sheet1data);
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="export_all_booking_list'.time().'.xlsx"');
			header('Cache-Control: max-age=0');
			$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($mySpreadsheet, 'Xlsx');
			ob_start();
			$writer->save('php://output');
			$xlsData = ob_get_contents();
			ob_end_clean();
			$array = array(
				// 'filename'=> "export_all_booking_list".time().".xlsx",
				'filename'=> $exportFileName.".xlsx",
				'data' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
			);
			echo json_encode($array);
		}
	}
	public function master_modification_logs(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$conditions = [];
			$data['list'] = $this->admin_model->get_master_modification_logs($conditions);
			$config['target']      = '#total_master_reservation'; 
			$config['base_url']    = base_url('admin/ajax_master_modification_logs'); 
			$config['total_rows']  = count($data['list']); 
			$data['total_rows']  = count($data['list']); 
			$config['per_page']    = 10; 
			$config['link_func']    = 'ajax_filter_form_complete_booking'; 
			$this->ajax_pagination->initialize($config); 
			$conditions = array( 
				'limit' => 10 
			); 
			$data['list'] = $this->admin_model->get_master_modification_logs($conditions);
			$this->load->view('admin/header');
			$this->load->view('admin/booking_list/master-modify-log',$data);
			$this->load->view('admin/footer');
		}
		else{
			redirect('admin');
		}
	}
	public function ajax_master_modification_logs(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			// if($this->input->post('master-filter-fields-params')){
			// 	exit('has');
			// }else{
			// 	exit('noo');
			// }
			$per_page = 10;
			$page = $this->input->post('page'); 
			$min = $this->input->post('min'); 
			$max = $this->input->post('max'); 
			$length = $this->input->post('length'); 
			$book_status = $this->input->post('book_status'); 
			$search_keyword = $this->input->post('search_keyword'); 
			$conditions = [];
			if($min != '' && $max != ''){
				$conditions = array( 
					'from_date' => $min, 
					'to_date' => $max, 
				); 
			}
			if($search_keyword != ''){
				$conditions['keyword'] = $search_keyword;
			}
			if($book_status != ''){
				$conditions['book_status'] = $book_status;
			}
			$data['list'] = $this->admin_model->get_master_modification_logs($conditions);
			if($length != ''){
				$per_page = $length;
			}
			if(!$page){ 
				$offset = 0; 
			}else{ 
				$offset = $page; 
			} 
			$config['target']      = '#total_master_reservation'; 
			$config['base_url']    = base_url('admin/ajax_master_modification_logs'); 
			$config['total_rows']  = count($data['list']); 
			$config['per_page']    = $per_page; 
			$config['cur_page']    = $offset; 
			$config['link_func']    = 'ajax_filter_form_complete_booking'; 
			$this->ajax_pagination->initialize($config); 
			$conditions ['limit'] = $per_page; 
			if($offset > 0){
				$conditions['start'] = $offset; 	
			}

			if($this->input->post('master-filter-fields-params')){
				$conditions['selected_fields'] = $this->input->post('master-filter-fields-params');
			}
			// echo('<pre>');
			// print_r($conditions);
			// echo('</pre>');
			// exit('dddd');
			$data['list'] = $this->admin_model->get_master_modification_logs($conditions);
			// echo('<pre>');
			// print_r($data);
			// echo('</pre>');
			// exit('dddd');
			$this->load->view('admin/booking_list/ajax/master-modify-log',$data);
		}		
	}
	public function export_master_modification_logs(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$min = $this->input->post('min'); 
			$max = $this->input->post('max'); 
			// echo('<pre>');
			// print_r($this->input->post('master-filter-fields-params'));
			// echo('<pre>');exit('gggg');
			$book_status = $this->input->post('book_status'); 
			$search_keyword = $this->input->post('search_keyword'); 
			$exportFileName = $this->input->post('exportfilename'); 
			$conditions = [];
			if($min != '' && $max != ''){
				$conditions = array( 
					'from_date' => $min, 
					'to_date' => $max, 
				); 
			}
			if($search_keyword != ''){
				$conditions['keyword'] = $search_keyword;
			}
			if($book_status != ''){
				$conditions['book_status'] = $book_status;
			}
			$list = $this->admin_model->get_master_modification_logs($conditions);
			$mySpreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
			$mySpreadsheet->removeSheetByIndex(0);
			$worksheet1 = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($mySpreadsheet, "Users List");
			$mySpreadsheet->addSheet($worksheet1, 0);
			$columns = array('Time Stamp','Booking ID','Action Performed','By','By Email','For User','To User','Restaurent Name','Restaurent Date','Restaurent Time','No of People','Reason Note','Admin Note');
			
			// $colsWithFields = [
			// 	array('timestamp'=>'Time Stamp'),
			// 	array('booking_id'=>'Booking ID'),
			// 	array('action'=>'Action Performed'),
			// 	array('added_by'=>'By'),
			// 	array('by_email'=>'By Email'),
			// 	array('for_user'=>'For User'),
			// ];
			$colsWithFields = [
				'first_col'=>'Place Holder for zero index',//jsut to avoid 0 index as we have Fisrt field bank on frontend
				'timestamp'=>'Time Stamp',
				'booking_id'=>'Booking ID',
				'action'=>'Action Performed',
				'added_by'=>'By',
				'by_email'=>'By Email',
				'for_user'=>'For User',
				'to_user'=>'To User',
				'restaurant_name'=>'Restaurent Name',
				'restaurant_date'=>'Restaurent Date',
				'restaurant_time'=>'Restaurent Time',
				'no_of_people'=>'No of People',
				'reason'=>'Reason Note',
				'admin_note'=>'Admin Note',
			];
			
			$sheet1data[] = $columns;
			if(!empty($list)):
				$j=1;
					foreach ($list as $key => $data) {
						$bookings = $this->admin_model->get_booking_dates_list($data['id']);
						$k = 1;

						$modify_date = date('m-d-Y',strtotime($data['timestamp']));

						//Convert time stamp to NY time zone
						// Create a DateTime object from the timestamp string
						$date = DateTime::createFromFormat('Y-m-d H:i:s', $data['timestamp'], new DateTimeZone('UTC'));

						// Set the target time zone (New York)
						$date->setTimezone(new DateTimeZone('America/New_York'));

						// Format the date in the target time zone
						$new_york_time = $date->format('Y-m-d H:i:s');
						$modify_date = date('m-d-Y H:i:s',strtotime($new_york_time));


						// $sheet1data[] = array(date('m-d-Y h:i:s',strtotime($data['timestamp'])),$data['booking_id'],$data['action'],$data['added_by'],$data['by_email'],$data['for_user'],$data['to_user'],$data['restaurant_name'],date('m-d-Y',strtotime($data['restaurant_date'])),$data['restaurant_time'],$data['no_of_people'],$data['reason'],$data['admin_note']);
						$sheet1data[] = array($modify_date,$data['booking_id'],$data['action'],$data['added_by'],$data['by_email'],$data['for_user'],$data['to_user'],$data['restaurant_name'],date('m-d-Y',strtotime($data['restaurant_date'])),$data['restaurant_time'],$data['no_of_people'],$data['reason'],$data['admin_note']);
				}
			endif;
			$worksheet1->fromArray($sheet1data);
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="export_master_modification_logs'.time().'.xlsx"');
			header('Cache-Control: max-age=0');
			$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($mySpreadsheet, 'Xlsx');
			ob_start();
			$writer->save('php://output');
			$xlsData = ob_get_contents();
			ob_end_clean();
			$array = array(
				// 'filename'=> "export_master_modification_logs".time().".xlsx",
				'filename'=> $exportFileName.".xlsx",
				'data' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
			);
			echo json_encode($array);
		}
	}
	public function all_booking_detail_list(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$conditions = [];
			$book_status = $this->input->get('book_status'); 
			if($book_status != ''){
				$conditions['book_status'] = $book_status;
			}
			$data['list'] = $this->admin_model->get_all_booking_detail_list($conditions);
			$config['target']      = '#total_master_reservation'; 
			$config['base_url']    = base_url('admin/ajax_master_booking_list'); 
			$config['total_rows']  = count($data['list']); 
			$data['total_rows']  = count($data['list']); 
			$config['per_page']    = 10; 
			$config['link_func']    = 'ajax_filter_form_complete_booking'; 
			$this->ajax_pagination->initialize($config); 
			$conditions = array( 
				'limit' => 10 
			); 
			$data['list'] = $this->admin_model->get_all_booking_detail_list($conditions);
			$this->load->view('admin/header');
			$this->load->view('admin/booking_list/all_booking_detail_list',$data);
			$this->load->view('admin/footer');
		}
		else{
			redirect('admin');
		}
	}
	public function ajax_all_booking_detail_list(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$per_page = 10;
			$page = $this->input->post('page'); 
			$min = $this->input->post('min'); 
			$max = $this->input->post('max'); 
			$length = $this->input->post('length'); 
			$book_status = $this->input->post('book_status'); 
			$search_keyword = $this->input->post('search_keyword'); 
			$conditions = [];
			if($min != '' && $max != ''){
				$conditions = array( 
					'from_date' => $min, 
					'to_date' => $max, 
				); 
			}
			if($search_keyword != ''){
				$conditions['keyword'] = $search_keyword;
			}
			if($book_status != ''){
				$conditions['book_status'] = $book_status;
			}
			$data['list'] = $this->admin_model->get_all_booking_detail_list($conditions);
			if($length != ''){
				$per_page = $length;
			}
			if(!$page){ 
				$offset = 0; 
			}else{ 
				$offset = $page; 
			} 
			$config['target']      = '#total_master_reservation'; 
			$config['base_url']    = base_url('admin/ajax_all_booking_detail_list'); 
			$config['total_rows']  = count($data['list']); 
			$config['per_page']    = $per_page; 
			$config['cur_page']    = $offset; 
			$config['link_func']    = 'ajax_filter_form_complete_booking'; 
			$this->ajax_pagination->initialize($config); 
			$conditions ['limit'] = $per_page; 
			if($offset > 0){
				$conditions['start'] = $offset;
			}
			$data['list'] = $this->admin_model->get_all_booking_detail_list($conditions);
			$this->load->view('admin/booking_list/ajax/all_booking_detail_list',$data);
		}		
	}
	public function export_all_booking_detail_list(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$min = $this->input->post('min'); 
			$max = $this->input->post('max'); 
			$book_status = $this->input->post('book_status'); 
			$search_keyword = $this->input->post('search_keyword'); 
			if($book_status==''){
				$file_name = $this->input->post('exportfilename');
			}else{
				$file_name =  $book_status;
			}
			$conditions = [];
			if($min != '' && $max != ''){
				$conditions = array( 
					'from_date' => $min, 
					'to_date' => $max, 
				); 
			}
			if($search_keyword != ''){
				$conditions['keyword'] = $search_keyword;
			}
			if($book_status != ''){
				$conditions['book_status'] = $book_status;
			}
			if($book_status != ''){
				$conditions['book_status'] = $book_status;
				$file_name = $book_status;
				$file_name = strtolower($file_name);
			}
			$dates = $this->admin_model->get_dates_list_booking();
			$list = $this->admin_model->get_all_booking_detail_list($conditions);
			$mySpreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
			$mySpreadsheet->removeSheetByIndex(0);
			$worksheet1 = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($mySpreadsheet, "Users List");
			$mySpreadsheet->addSheet($worksheet1, 0);
			$columns = array('Confirmation ID','Invited Type','User name','User email','Restaurant name','Date','Time','Skip days','No of People','Deposit $','Booked Date','Booked Time','Modify Date','Admin Note');
			$sheet1data[] = $columns;
			if(!empty($list)):
				$j=1;
					foreach ($list as $key => $data) {
						$bookings = $this->admin_model->get_booking_dates_list($data['id']);
						$k = 1;
						foreach($bookings as $book){
							if($k==1){
								$bid = '#'.$data['id'];
								$user_id = $data['user_id'];
								$udata = $this->admin_model->get_user_date_byid($user_id);
								$busname = $udata['full_name'];
								$bemail = $udata['email'];
								$bdate = date('m-d-Y',strtotime($book['created_date']));
								$btime = date('h:ia',strtotime($book['created_date']));
							}
							else{
								$bid = '';
								$busname = '';
								$bemail = '';
								$bdate = '';
								$btime = '';
							}
							if($book['ref_id'] == 0){
								$type = 'Primary';
							}
							else{
								$type = 'Guest';
							}
						$booking_time = $book['booking_time'];
						$booking_pax = $book['booking_pax'];
						$booking_date = date('m-d-Y',strtotime($book['booking_date']));
						$modify_date = date('m-d-Y',strtotime($book['modify_date']));
						$date = DateTime::createFromFormat('Y-m-d H:i:s', $book['modify_date'], new DateTimeZone('UTC'));
						$date->setTimezone(new DateTimeZone('America/New_York'));
						$new_york_time = $date->format('Y-m-d H:i:s');
						$modify_date = date('m-d-Y H:i:s',strtotime($new_york_time));
						$booking_deposite = '$'.$book['booking_deposite'];
						$booking_skip = '';
						$rest_name = $this->admin_model->get_restaurant_name_byid($book['booking_restid']);
						if($book['booking_status'] == 'skip'){
							$rest_name = '';
							$booking_time = '';
							$booking_pax = '';
							$modify_date = '';
							$booking_date = date('m-d-Y',strtotime($book['booking_date']));
							$booking_deposite = '';
							$bdate = '';
							$btime = '';
							$booking_skip = 'Skip';
						}
						else if($book['booking_status'] == 'cancel'){
							$rest_name = '';
							$booking_time = '';
							$booking_pax = '';
							$booking_date = date('m-d-Y',strtotime($book['booking_date']));
							$booking_deposite = '';
							$modify_date = '';
							$bdate = '';
							$btime = '';
							$booking_skip = 'Cancel';
						}

						$sheet1data[] = array($bid,$type,$busname,$bemail,$rest_name,$booking_date,$booking_time,$booking_skip,$booking_pax,$booking_deposite,$bdate,$btime,$modify_date,$book['admin_note']);


					}
				}
			endif;
			$worksheet1->fromArray($sheet1data);
			header('Content-Type: application/vnd.ms-excel');
			// header('Content-Disposition: attachment;filename="export_'.$file_name.time().'.xlsx"');
			if($book_status==''){

				header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
			}else{
				header('Content-Disposition: attachment;filename="'.$file_name.'reservations.xlsx"');

			}
			header('Cache-Control: max-age=0');
			$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($mySpreadsheet, 'Xlsx');
			ob_start();
			$writer->save('php://output');
			$xlsData = ob_get_contents();
			ob_end_clean();
			if($book_status==''){
				$array = array(
					// 'filename'=> "export_".$file_name.time().".xlsx",
					'filename'=> $file_name.".xlsx",
					'data' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
				);
			}else{
				$array = array(
					// 'filename'=> "export_".$file_name.time().".xlsx",
					'filename'=> $file_name."_reservations.xlsx",
					'data' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
				);
			}

			echo json_encode($array);
		}
	}
	public function view_booking_detail(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$id = $this->uri->segment(3); 
			$data['detail'] = $this->admin_model->get_booking_detail($id);
			$data['list'] = $this->admin_model->get_booking_dates_list($id);
			$data['hide_hotel_contact'] = $this->settings['restaurant_contact_hide'];
			// $data['restaurant_address_hide'] = $this->settings['restaurant_address_hide'];
			// $data['restaurant_fee_hide'] = $this->settings['restaurant_fee_hide'];
			// $data['restaurant_website_url_hide'] = $this->settings['restaurant_website_url_hide'];
			$data['restaurant_address_hide'] = $this->settings['restaurant_address_hide'];
			$data['restaurant_fee_hide'] = $this->settings['restaurant_fee_hide'];
			$data['restaurant_establishment_hide'] = $this->settings['restaurant_establishment_hide'];
			$data['restaurant_meals_hide'] = $this->settings['restaurant_meals_hide'];
			$data['restaurant_website_url_hide'] = $this->settings['restaurant_website_url_hide'];
			$data['restaurant_location_hide'] = $this->settings['restaurant_location_hide'];
			$data['restaurant_email_hide'] = $this->settings['restaurant_email_hide'];
			$this->load->view('admin/header');
			$this->load->view('admin/booking_list/view_booking_detail',$data);
			$this->load->view('admin/footer');
		}
		else{
			redirect('admin');
		}
	}
	public function invitation_sendto_guest(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$email = $this->input->post('email');
			$list_id = $this->input->post('share_booking_listid');
			$count = $this->user_model->get_email_exist_not_user($email);
			if($count > 0){
				$list_data = $this->admin_model->get_dates_list_booking_byid($list_id);
				$from_id = $list_data['user_id'];
				$to_data = $this->user_model->get_user_detail_byemail($email);
				$to_id = $to_data['id'];
				$result = $this->admin_model->create_booking_baseon_invitebyadmin($from_id,$to_id,$list_data);
				if(!is_array($result)){
					$data = array(
						'response'=>'failure',
						'message'=>'You already send invitation to this email for this date.'
					);
				}
				else{
				$data = array(
					'response'=>'success',
					'message'=>'Mail sent successfully.'
				);
				}
			}
			else{
				$data = array(
					'response'=>'failure',
					'message'=>'Your provided email doesn`t matched with our list-record of guests.'
				);
			}
			echo json_encode($data);
			exit;
		}
		else{
			redirect('index');
		}
	}
	public function delete_user_admin(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$user_id = $this->input->post('user_id');
			$this->admin_model->delete_user_admin($user_id);
			redirect('admin/user_list');
		}
		else{
			redirect('admin');
		}
	}
	public function update_email(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$this->admin_model->update_email();
			redirect('admin/email_list');
		}
		else{
			redirect('admin');
		}
	}
	public function email_notification_setting(){
		$condition1 = [];
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$user_id = $this->session->userdata('mes_admin_id');
			$data['list'] = $this->admin_model->get_email_list($condition1);
			$data['data'] = $this->admin_model->get_user_detail($user_id);
			$this->load->view('admin/header');
			$this->load->view('admin/email_notification',$data);
			$this->load->view('admin/footer');
		}
		else{
			redirect('admin');
		}
	}
	public function update_email_notification(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$this->admin_model->update_email_notification();
			redirect('admin/email_notification_setting');
		}
		else{
			redirect('admin');
		}
	}
	public function resend_booking_email_user(){
		if($this->session->userdata('mes_admin_id') != ''){
			$user_id = $this->input->get('user_id');
			$user_data = $this->user_model->get_user_detail_byuserid($user_id);
			$booking_id = $this->admin_model->get_booking_id_byuserid($user_id);
			$user_name = $user_data['full_name'];
					$email_template = $this->admin_model->get_email_template('user_reservation_Confirmed');
					$user_id = $this->session->userdata('mes_user_id');
					$user_name = $user_data['full_name'];
					$subject = $email_template['email_subject'];
					$email_template = str_replace('{{user_name}}',$user_name,$email_template['email_body']);
					$email_template = str_replace('{{order_id}}',$booking_id,$email_template);
					$email_template = str_replace('{{site_title}}',$this->settings['site_title'],$email_template);
					$email_template = str_replace('{{currentyear}}',date("Y"),$email_template);
					$email_template = str_replace('{{site_url}}',site_url(),$email_template);
					$data['hide_hotel_contact'] = $this->settings['restaurant_contact_hide'];
					// $data['restaurant_address_hide'] = $this->settings['restaurant_address_hide'];
					// $data['restaurant_fee_hide'] = $this->settings['restaurant_fee_hide'];
					// $data['restaurant_website_url_hide'] = $this->settings['restaurant_website_url_hide'];
					$data['restaurant_address_hide'] = $this->settings['restaurant_address_hide'];
					$data['restaurant_fee_hide'] = $this->settings['restaurant_fee_hide'];
					$data['restaurant_establishment_hide'] = $this->settings['restaurant_establishment_hide'];
					$data['restaurant_meals_hide'] = $this->settings['restaurant_meals_hide'];
					$data['restaurant_website_url_hide'] = $this->settings['restaurant_website_url_hide'];
					$data['restaurant_location_hide'] = $this->settings['restaurant_location_hide'];
					$data['restaurant_email_hide'] = $this->settings['restaurant_email_hide'];
					$list = '';
					$data['date_list'] = $this->user_model->get_booking_datelist_byid($booking_id);
					$list .= $this->load->view('emails/book_restaurants_list',$data,TRUE);
					$email_template = str_replace('{{book_restaurants_list}}',$list,$email_template);
					$this->email->set_newline("\r\n");
					$this->email->from($this->settings['smtp_from_email'],$this->settings['site_title']); // change it to yours
					$this->email->to($user_data['email']);// change it to yours 
					$this->email->reply_to($this->settings['smtp_to_email']);
					$this->email->subject($this->settings['site_title'].' - '.$subject);
					$this->email->message($email_template);
					$this->email->send();
					$this->session->set_flashdata('success', 'Email sent successfully.');
			redirect('admin/user_list');
		}
		else{
			redirect('admin');
		}
	}
	public function cancel_reservation_date(){
		if($this->session->userdata('mes_admin_id') != ''){
			$this->admin_model->cancel_reservation_date();
			//Send Cancelation email to Admins and User
			$user_id = $this->session->userdata('mes_user_id');
			$cancellation = $this->input->post('cancellation');
			$user_data = $this->user_model->get_user_detail_byuserid($user_id);
			$user_name = $user_data['full_name'];
			$user_email = $user_data['email'];
			$email_template = $this->admin_model->get_email_template('admin_canceled_reservation');
			$admins = $this->user_model->get_admin_list_sendemail('admin_canceled_reservation');
			$subject = $email_template['email_subject'];
			$email_template = str_replace('{{user_name}}',$user_name,$email_template['email_body']);
			$id = $this->input->post('cancel_booking_listid');
			$booking = $this->user_model->get_booking_date_detail($id);
			$rest_id = $booking['booking_restid'];
			$booking_id = $booking['booking_id'];
			$array['booking'] = $booking;
			$array['hotel'] = $this->user_model->get_restaurant_detail($rest_id);
			$array['hide_hotel_contact'] = $this->settings['restaurant_contact_hide'];
			// $array['restaurant_address_hide'] = $this->settings['restaurant_address_hide'];
			// $array['restaurant_fee_hide'] = $this->settings['restaurant_fee_hide'];
			// $array['restaurant_website_url_hide'] = $this->settings['restaurant_website_url_hide'];
			$array['restaurant_address_hide'] = $this->settings['restaurant_address_hide'];
			$array['restaurant_fee_hide'] = $this->settings['restaurant_fee_hide'];
			$array['restaurant_establishment_hide'] = $this->settings['restaurant_establishment_hide'];
			$array['restaurant_meals_hide'] = $this->settings['restaurant_meals_hide'];
			$array['restaurant_website_url_hide'] = $this->settings['restaurant_website_url_hide'];
			$array['restaurant_location_hide'] = $this->settings['restaurant_location_hide'];
			$array['restaurant_email_hide'] = $this->settings['restaurant_email_hide'];
			$list = '';
			$list .= $this->load->view('emails/cancel_restaurant', $array, TRUE);
			$email_template = str_replace('{{cancel_restaurant_list}}',$list,$email_template);
			$email_template = str_replace('{{order_id}}',$booking_id,$email_template);
			$email_template = str_replace('{{site_title}}',$this->settings['site_title'],$email_template);
			$email_template = str_replace('{{cancel_booking_reason}}',$cancellation,$email_template);
			$email_template = str_replace('{{admin_url}}',site_url('admin'),$email_template);
			$email_template = str_replace('{{currentyear}}',date("Y"),$email_template);
			$email_template = str_replace('{{site_url}}',site_url(),$email_template);
			$this->email->set_newline("\r\n");
			$this->email->from($this->settings['smtp_from_email'],$this->settings['site_title']); // change it to yours
			$this->email->to($this->settings['admin_email']);// change it to yours
			$this->email->reply_to($this->settings['smtp_to_email']);
			if(!empty($admins)){
				$this->email->cc($admins);
			}
			$this->email->subject($this->settings['site_title'].' - '.$subject);
			$this->email->message($email_template);
			$this->email->send();

			$email_template = $this->admin_model->get_email_template('user_canceled_reservation');
			$subject = $email_template['email_subject'];
			$email_template = str_replace('{{user_name}}',$user_name,$email_template['email_body']);
			$list = '';
			$list .= $this->load->view('emails/cancel_restaurant', $array, TRUE);
			$email_template = str_replace('{{cancel_restaurant_list}}',$list,$email_template);
			$email_template = str_replace('{{order_id}}',$booking_id,$email_template);
			$email_template = str_replace('{{site_title}}',$this->settings['site_title'],$email_template);
			$email_template = str_replace('{{cancel_booking_reason}}',$cancellation,$email_template);
			$email_template = str_replace('{{site_url}}',site_url(),$email_template);
			$email_template = str_replace('{{currentyear}}',date("Y"),$email_template);
			$this->email->set_newline("\r\n");
			$this->email->from($this->settings['smtp_from_email'],$this->settings['site_title']); // change it to yours
			$this->email->to($user_email);// change it to yours
			$this->email->reply_to($this->settings['smtp_to_email']);
			$this->email->subject($this->settings['site_title'].' - '.$subject);
			$this->email->message($email_template);
			$this->email->send();




			$data = array(
				'response'=>'success',
				'message'=>'Reservtion cancelled successfuly.'
			);
		}
		else{
			$data = array(
				'response'=>'failure',
				'message'=>'Something went wrong, please try again later.'
			);
		}
		echo json_encode($data);
		exit;
	}
	public function restaurant_slot_report_list(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$data['list'] = $this->admin_model->get_restaurant_slot_report_list();
			$config['target']      = '#total_master_reservation'; 
			$config['base_url']    = base_url('admin/ajax_restaurant_slot_report_list'); 
			$config['total_rows']  = count($data['list']); 
			$data['total_rows']  = count($data['list']); 
			$config['per_page']    = 10; 
			$config['link_func']    = 'ajax_filter_form_complete_booking'; 
			$this->ajax_pagination->initialize($config); 
			$conditions = array( 
				'limit' => 10 
			); 
			$data['list'] = $this->admin_model->get_restaurant_slot_report_list($conditions);
			$this->load->view('admin/header');
			$this->load->view('admin/booking_list/restaurant_slot_report_list',$data);
			$this->load->view('admin/footer');
		}
		else{
			redirect('admin');
		}
	}
	public function ajax_restaurant_slot_report_list(){
		$per_page = 10;
		$page = $this->input->post('page'); 
		$length = $this->input->post('length'); 
		$search_keyword = $this->input->post('search_keyword'); 
		$order = $this->input->post('order'); 
		$orderby = $this->input->post('orderby'); 
		$conditions = [];
		if($search_keyword != ''){
			$conditions['keyword'] = $search_keyword;
		}
		$data['list'] = $this->admin_model->get_restaurant_slot_report_list($conditions);
		if($length != ''){
			$per_page = $length;
		}
		$data['order'] = '';
		$data['orderby'] = '';
		if($orderby != '' && $order != ''){
			$conditions['order'] = $order;
			$conditions['orderby'] = $orderby;
			$data['order'] = $order;
			$data['orderby'] = $orderby;
		}
		if(!$page){ 
			$offset = 0; 
		}else{ 
			$offset = $page; 
		} 
		$config['target']      = '#total_master_reservation'; 
		$config['base_url']    = base_url('admin/ajax_restaurant_slot_report_list'); 
		$config['total_rows']  = count($data['list']); 
		$config['per_page']    = $per_page; 
		$config['cur_page']    = $offset; 
		$config['link_func']    = 'ajax_filter_form_complete_booking'; 
		$this->ajax_pagination->initialize($config); 
		$conditions ['limit'] = $per_page; 
		if($offset > 0){
			$conditions['start'] = $offset;
		}
		$data['list'] = $this->admin_model->get_restaurant_slot_report_list($conditions);
		$this->load->view('admin/booking_list/ajax/restaurant_slot_report_list',$data);
	}
	public function export_restaurant_slot_report_list(){
		$search_keyword = $this->input->post('search_keyword'); 
		$exportFileName = $this->input->post('exportfilename'); 
			$conditions = [];
			if($search_keyword != ''){
				$conditions['keyword'] = $search_keyword;
			}
		$list = $this->admin_model->get_restaurant_slot_report_list($conditions);
		$mySpreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
		$mySpreadsheet->removeSheetByIndex(0);
		$worksheet1 = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($mySpreadsheet, "Restaurant Slot List");
		$mySpreadsheet->addSheet($worksheet1, 0);
		$sheet1data[] = array('Restaurant Name','Property type','Reservation Time','Reservation Date','Table Size','Capacity','Booked','Remaining','Booked List');
		if(!empty($list)){
			foreach($list as $data){
				$booked = $this->admin_model->count_booked_tablle_byrestid_date($data['restaurant_id'],$data['date'],$data['time'],$data['size']);
				$remain = $data['capacity'] - $booked;
				$book = $this->admin_model->get_booking_slot_username_bookingid($data['restaurant_id'],$data['date'],$data['time'],$data['size']);
				// Base row data
				$row = [
					$data['restaurant_name'],
					$this->admin_model->get_property_type_text($data['property_type']),
					$data['time'],
					date('m-d-Y', strtotime($data['date'])),
					$data['size'],
					$data['capacity'],
					$booked,
					$remain
				];
		
				// Add each booking ID and user name as separate columns
				$bookedList = '';
				if (!empty($book)) {
					foreach ($book as $data1) {
						$bookedList .= '#' . $data1['booking_id'] . ' ' . $this->admin_model->get_user_name_byid($data1['user_id']) . "\n";
					}
				}
				$bookedList = rtrim($bookedList, "\n");
				// Add the combined list to the row
				$row[] = $bookedList;
		
				// Add the row to the sheet data
				$sheet1data[] = $row;
			}
		}
		$worksheet1->fromArray($sheet1data);
		$highestRow = count($sheet1data); // Get the total number of rows
		$worksheet1->getStyle('I1:I' . $highestRow)
			->getAlignment()
			->setWrapText(true);
		$highestColumn = $worksheet1->getHighestColumn(); // Get the last column (e.g., "I")
		foreach (range('A', $highestColumn) as $columnID) {
			$worksheet1->getColumnDimension($columnID)->setAutoSize(true);
		}
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="export_restaurant_slot_report_list'.time().'.xlsx"');
		header('Cache-Control: max-age=0');
		$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($mySpreadsheet, 'Xlsx');
		ob_start();
		$writer->save('php://output');
		$xlsData = ob_get_contents();
		ob_end_clean();
		$array = array(
			// 'filename'=> "export_restaurant_slot_report_list".time().".xlsx",
			'filename'=> $exportFileName.".xlsx",
			'data' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
		);
		echo json_encode($array);
	}
	public function get_booking_slot_username_bookingid(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$rest_id = $this->input->post('rest_id');
			$date = $this->input->post('date');
			$time = $this->input->post('time');
			$size = $this->input->post('size');
			$list = $this->admin_model->get_booking_slot_username_bookingid($rest_id,$date,$time,$size);
			if(!empty($list)):?>
			<table class="table table-responsive">
				<thead>
					<tr>
						<th>Confirmation #</th>
						<th>Guest Name</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($list as $data){
						$content_after = '<span class="tag-host"> <img src="https://2025restaurants.madisontravel-reservations.com/uploads/assets/images/star.png" alt=""> PRIMARY</span>';
						if($data['guests'] != ''){
							$content_after = '<span class="tag-host"> <img src="https://reservation.2024internalmedicinepremier.com/uploads/assets/images/star.png" alt=""> PRIMARY</span>';
						}
						else if($data['ref_id'] != ''){
							
							$booking_list_data = $this->admin_model->get_booking_list_detail_by_id($data['ref_id']);
							if(!empty($booking_list_data)){
								$user_id = $booking_list_data['user_id'];
								$user_name = $this->admin_model->get_user_name_byid($user_id);
								$content_after = '<span class="tag-guest"> <img src="https://2025restaurants.madisontravel-reservations.com/uploads/assets/images/star.png" alt=""> GUEST OF '.$user_name.'</span>';
								// $content_after = '(GUEST OF '.$user_name.')';
							}
						}
						?>
					
					<tr>
						<td><a href="<?php echo site_url('admin/view_booking_detail/').$data['booking_id'];?>">#<?php echo $data['booking_id'];?></td>
						<td><?php echo $this->admin_model->get_user_name_byid($data['user_id']).' '.$content_after;?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
			<?php
			endif;
			exit;
		}
	}
	public function add_admin_note(){
		if($this->session->userdata('mes_admin_id') != ''){
			$this->admin_model->add_admin_note();
			$data = array(
				'response'=>'success',
				'message'=>'Added successfuly.'
			);
		}
		else{
			$data = array(
				'response'=>'failure',
				'message'=>'Something went wrong, please try again later.'
			);
		}
		echo json_encode($data);
		exit;
	}
	public function unauthorize_user_list(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$data['list'] = $this->admin_model->get_unauthorize_user_list();
			$config['target']      = '#total_master_reservation'; 
			$config['base_url']    = base_url('admin/ajax_unauthorize_user_list'); 
			$config['total_rows']  = count($data['list']); 
			$data['total_rows']  = count($data['list']); 
			$config['per_page']    = 10; 
			$config['link_func']    = 'ajax_filter_form_complete_booking'; 
			$this->ajax_pagination->initialize($config); 
			$conditions = array( 
				'limit' => 10 
			); 
			$data['list'] = $this->admin_model->get_unauthorize_user_list($conditions);
			$this->load->view('admin/header');
			$this->load->view('admin/booking_list/unauthorize_user_list',$data);
			$this->load->view('admin/footer');
		}
		else{
			redirect('admin');
		}
	}
	public function ajax_unauthorize_user_list(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$per_page = 10;
			$page = $this->input->post('page'); 
			$length = $this->input->post('length'); 
			$search_keyword = $this->input->post('search_keyword'); 
			$conditions = [];
			if($search_keyword != ''){
				$conditions['keyword'] = $search_keyword;
			}
			$data['list'] = $this->admin_model->get_unauthorize_user_list($conditions);
			if($length != ''){
				$per_page = $length;
			}
			if(!$page){ 
				$offset = 0; 
			}else{ 
				$offset = $page; 
			} 
			$config['target']      = '#total_master_reservation'; 
			$config['base_url']    = base_url('admin/ajax_unauthorize_user_list'); 
			$config['total_rows']  = count($data['list']); 
			$config['per_page']    = $per_page; 
			$config['cur_page']    = $offset; 
			$config['link_func']    = 'ajax_filter_form_complete_booking'; 
			$this->ajax_pagination->initialize($config); 
			$conditions ['limit'] = $per_page; 
			if($offset > 0){
				$conditions['start'] = $offset;
			}
			$data['list'] = $this->admin_model->get_unauthorize_user_list($conditions);
			$this->load->view('admin/booking_list/ajax/unauthorize_user_list',$data);
		}
	}
	public function export_unauthorize_user_list(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$search_keyword = $this->input->post('search_keyword'); 
			$exportFileName = $this->input->post('exportfilename');
			$conditions = [];
			if($search_keyword != ''){
				$conditions['keyword'] = $search_keyword;
			}
			$list = $this->admin_model->get_unauthorize_user_list($conditions);
			$mySpreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
			$mySpreadsheet->removeSheetByIndex(0);
			$worksheet1 = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($mySpreadsheet, "Users List");
			$mySpreadsheet->addSheet($worksheet1, 0);
			$columns = array('User email','IP');
			$sheet1data[] = $columns;
			if(!empty($list)):
				$j=1;
					foreach ($list as $key => $data) {
						$sheet1data[] = array($data['email'],$data['ip']);
					}
			endif;
			$worksheet1->fromArray($sheet1data);
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="export_unauthorize_user_list'.time().'.xlsx"');
			header('Cache-Control: max-age=0');
			$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($mySpreadsheet, 'Xlsx');
			ob_start();
			$writer->save('php://output');
			$xlsData = ob_get_contents();
			ob_end_clean();
			$array = array(
				'filename'=> $exportFileName.".xlsx",
				'data' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
			);
			echo json_encode($array);
		}
	}
	public function excel_export_master_booking(){
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="master-booking'.date('Y-m-d H:i:s').'.xlsx"');
		header('Cache-Control: max-age=0');
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue("A1", "First Name");
		$sheet->setCellValue("B1", "Last Name");
		$sheet->setCellValue("C1", "Email Address");
		$sheet->setCellValue("D1", "Response Status");
		$col = 5;
		$row = 1;
		$dates = $this->admin_model->get_dates_list_booking();
		if(!empty($dates)){
			$k=1; 
			foreach($dates as $date){
				$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 'Day '.$k.' Status');
				$col++;
				$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 'Day '.$k.' Role');
				$col++;
				$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 'Day '.$k.' Date');
				$col++;
				$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 'Day '.$k.' Time');
				$col++;
				$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 'Day '.$k.' Restaurant Name');
				$col++;
				$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 'Day '.$k.' Reserved People');
				$col++;
				$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 'Day '.$k.' Guests');
				$col++;
			$k++;}
		} 
		$condition1['where'] = array('role'=>1);
		$list = $this->admin_model->get_user_list($condition1);
		$row = 2;
		if(!empty($list)):
			$j=1;
			foreach ($list as $key => $data) {
					$col = 5;
					$user_id = $data['id'];
					$booking = $this->admin_model->get_booking_detail_byuserid($user_id);
					$booking_status = 'No Response';
					if(!empty($dates) && !empty($booking)){
						$booked = 1;
						foreach($dates as $date){
							$status = $this->admin_model->get_status_of_booking_date_byid($booking['id'],$date['date']);
							if($status != 'Booked'){
								$booked = 0;
							}
						}
						if($booked == 0){
							$booking_status = 'Partial';
						}
						if($booked == 1){
							$booking_status = 'Completed';
						}
					}
					$username = $data['full_name'];
					$exp = explode(' ',$username);
					$first_name = $exp[0];
					$last_name = $exp[1];

					$sheet->setCellValue("A".$row, $first_name);
					$sheet->setCellValue("B".$row, $last_name);
					$sheet->setCellValue("C".$row, $data['email']);
					$sheet->setCellValue("D".$row, $booking_status);
					
					
					if(!empty($dates)){
							foreach($dates as $date){
							// $reservation_status = 'Skipped';
							$reservation_status = 'No Response';
							$reservation_role = '';
							$reservation_date = '';
							$reservation_time = '';
							$reservation_restname = '';
							$reservation_pax = '';
							$reservation_guests = '';
							$invite_status = $this->admin_model->get_invite_status_byuserid_bookdate($user_id,$date['date']);
							if(!empty($invite_status)){
								if($invite_status['status'] == 'invite'){
									$reservation_status = 'Pending Acceptance';
								}
								$from_data = $this->admin_model->get_user_detail($invite_status['from_id']);
								$reservation_role = 'Guest of '.$from_data['full_name'];
							}
							if(!empty($booking)){
							$reserv_data = $this->admin_model->get_booking_dates_list_by_bookingid_date($booking['id'],$date['date']);
								if(!empty($reserv_data)){
									$reservation_status = ucfirst($reserv_data['booking_status']);
									if($reserv_data['booking_status'] == 'skip'){
										// $reservation_status = $reservation_status.' ('.$reserv_data['booking_reason'].')';
										$reservation_status = $reserv_data['booking_reason'];
									}
									if($reserv_data['booking_status'] == 'cancel'){
										$reservation_status = $reservation_status.' ('.$reserv_data['booking_reason'].')';
									}
									if($reserv_data['ref_id'] == 0){
										$reservation_role = 'Primary';
									}
									$reservation_date = date('m-d-Y',strtotime($reserv_data['booking_date']));
									$reservation_time = $reserv_data['booking_time'];
									$reservation_pax = $reserv_data['booking_pax'];
									$reservation_restname  = $this->admin_model->get_restaurant_name_byid($reserv_data['booking_restid']);
									if($reserv_data['guests'] != ''){
										$gexp = explode(',',$reserv_data['guests']);
										$guest = [];
										foreach($gexp as $gid){
											$guest[] = $this->admin_model->get_user_name_byid($gid);
										}
										$reservation_guests = implode(', ',$guest);
									}
								}
							}
							$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $reservation_status);
							$col++;
							$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $reservation_role);
							$col++;
							$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $reservation_date);
							$col++;
							$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $reservation_time);
							$col++;
							$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $reservation_restname);
							$col++;
							$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $reservation_pax);
							$col++;
							$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $reservation_guests);
							$col++;
							}
						} 
					 $j++; $row++;
				 }
			endif;
		$writer = new Xlsx($spreadsheet);
		$writer->save("php://output");
	}
	public function invite_guest_list(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$data['list'] = $this->admin_model->get_invite_guest_list();
			$config['target']      = '#total_master_reservation'; 
			$config['base_url']    = base_url('admin/ajax_invite_guest_list'); 
			$config['total_rows']  = count($data['list']); 
			$data['total_rows']  = count($data['list']); 
			$config['per_page']    = 10; 
			$config['link_func']    = 'ajax_filter_form_complete_booking'; 
			$this->ajax_pagination->initialize($config); 
			$conditions = array( 
				'limit' => 10 
			); 
			$data['list'] = $this->admin_model->get_invite_guest_list($conditions);
			$this->load->view('admin/header');
			$this->load->view('admin/booking_list/invite_guest_list',$data);
			$this->load->view('admin/footer');
		}
		else{
			redirect('admin');
		}
	}
	public function ajax_invite_guest_list(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$per_page = 10;
			$page = $this->input->post('page'); 
			$length = $this->input->post('length'); 
			$search_keyword = $this->input->post('search_keyword'); 
			$conditions = [];
			if($search_keyword != ''){
				$conditions['keyword'] = $search_keyword;
			}
			$data['list'] = $this->admin_model->get_invite_guest_list($conditions);
			if($length != ''){
				$per_page = $length;
			}
			if(!$page){ 
				$offset = 0; 
			}else{ 
				$offset = $page; 
			} 
			$config['target']      = '#total_master_reservation'; 
			$config['base_url']    = base_url('admin/ajax_invite_guest_list'); 
			$config['total_rows']  = count($data['list']); 
			$config['per_page']    = $per_page; 
			$config['cur_page']    = $offset; 
			$config['link_func']    = 'ajax_filter_form_complete_booking'; 
			$this->ajax_pagination->initialize($config); 
			$conditions ['limit'] = $per_page; 
			if($offset > 0){
				$conditions['start'] = $offset;
			}
			$data['list'] = $this->admin_model->get_invite_guest_list($conditions);
			$this->load->view('admin/booking_list/ajax/invite_guest_list',$data);
		}
	}
	public function export_invite_guest_list(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$search_keyword = $this->input->post('search_keyword'); 
			$exportFileName = $this->input->post('exportfilename');
			$conditions = [];
			if($search_keyword != ''){
				$conditions['keyword'] = $search_keyword;
			}
			$list = $this->admin_model->get_invite_guest_list($conditions);
			$mySpreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
			$mySpreadsheet->removeSheetByIndex(0);
			$worksheet1 = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($mySpreadsheet, "INVITE GUEST List");
			$mySpreadsheet->addSheet($worksheet1, 0);
			$columns = array('From Name','To Name','Restaurant Name','Booking Date','Booking Time','Booking Pax','Status');
			$sheet1data[] = $columns;
			if(!empty($list)):
				$j=1;
					foreach ($list as $key => $data) {
						$from = $this->admin_model->get_user_detail($data['from_id']);
                                $to = $this->admin_model->get_user_detail($data['to_id']);
						$rest_name = $this->admin_model->get_restaurant_name_byid($data['booking_restid']);
						$sheet1data[] = array($from['full_name'].' ('.$from['email'].')',$to['full_name'].' ('.$to['email'].')',$rest_name,date('m-d-Y',strtotime($data['booking_date'])),$data['booking_time'],$data['booking_pax'],ucfirst($data['status']));
					}
			endif;
			$worksheet1->fromArray($sheet1data);
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="export_invite_guest_list'.time().'.xlsx"');
			header('Cache-Control: max-age=0');
			$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($mySpreadsheet, 'Xlsx');
			ob_start();
			$writer->save('php://output');
			$xlsData = ob_get_contents();
			ob_end_clean();
			$array = array(
				'filename'=> $exportFileName.".xlsx",
				'data' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
			);
			echo json_encode($array);
		}
	}

	public function get_credit_card_details($userid){
		$cardDetails = $this->admin_model->get_credit_card_details($userid);
	}
	public function update_user_credit_card_details(){
		$user_id = $this->uri->segment(3);		

		$result = $this->admin_model->update_user_credit_card_details($user_id);
		if($result){
			$this->session->set_flashdata('message', '<script>Swal.fire("Card Updated successfully!");</script>');
		}else{
			$this->session->set_flashdata('message', '<script>Swal.fire("Card Updated failed!");</script>');
		}
		redirect('admin/user_list');
	}

	public function send_creditcard_detail(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$otp = $this->input->post('otp');
			/**
			 * Verify OTP
			 */
			$otpCheck = $this->admin_model->verify_otp_for_send_credit_card_info($otp);
			if($otpCheck){
				
				$admiData = $this->admin_model->theme_setting();
				log_creditcard_info_request_activity($this->session->userdata('admin_email'),$admiData['admin_email']);
				$list = $this->admin_model->get_creditcard_details_foradmin();
				$mySpreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
				$mySpreadsheet->removeSheetByIndex(0);
				$worksheet1 = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($mySpreadsheet, "Credit Card List");
				$mySpreadsheet->addSheet($worksheet1, 0);
				$columns = array('Booking Code','User Code','Full Name','Email','Alternate Email','Mobile Number','Card Number','Card Type','Expire','CVV','Card Holder Name');
				$sheet1data[] = $columns;
				if(!empty($list)):
						foreach ($list as $key => $data) {
							$sheet1data[] = array($data['booking_code'],$data['user_code'],$data['full_name'],$data['email'],$data['alternate_email'],$data['mobile_number'],$data['card_number'],$data['card_type'],$data['expiry'],$data['cvv'],$data['card_holder']);
						}
				endif;
				$worksheet1->fromArray($sheet1data);
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="export_credit_card_list'.time().'.xlsx"');
				header('Cache-Control: max-age=0');
				$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($mySpreadsheet, 'Xlsx');
				$filename = FCPATH.'/uploads/excel/export_credit_card_list'.time().'.xlsx';
				$writer->save($filename);
				$email_template = $this->admin_model->get_email_template('admin_creditcard_information');
				$email_template = str_replace('{{currentyear}}',date("Y"),$email_template);
				$email_template = str_replace('{{site_url}}',site_url(),$email_template);

				$body = $email_template['email_body'];
				$parse = parse_url(site_url());
				$host = $parse['host'];
				$domain = str_ireplace('www.', '', $host);
				$body = str_replace('{{site_title}}',$this->settings['site_title'],$body);
				$body = str_replace('{{domain}}',$domain,$body);
				$body = str_replace('{{date}}',date('m-d-Y'),$body);
				$body = str_replace('{{admin_url}}',site_url('admin'),$body);

				$this->email->set_newline("\r\n");
				$this->email->from($this->settings['smtp_from_email'],$this->settings['site_title']); // change it to yours
				$this->email->to($admiData['admin_email']);// change it to yours
				$this->email->reply_to($this->settings['smtp_to_email']);
				$this->email->subject($this->settings['site_title'].' - Credit Card Information');
				$this->email->message($body);
				$this->email->attach($filename);
				$this->email->send();
				$data = array(
					'response'=>'success',
					'message'=>'Email sent successfully.'
				);
			}else{
				$data = array(
					'response'=>'fail',
					'message'=>'Invalid OTP.'
				);
			}
		}
		else{
			$data = array(
				'response'=>'fail',
				'message'=>'something went wrong, please try again later.'
			);
		}
		echo json_encode($data);
		exit();
	}

	/**Verify Admin settings OTP */
	public function verify_otp_for_admin_settings(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$otp = $this->input->post('otp');
			/**
			 * Verify OTP
			 */
			$otpCheck = $this->admin_model->verify_otp_for_admin_settings($otp);
			if($otpCheck){
				
				$admiData = $this->admin_model->theme_setting();
				log_admin_settings_update_request_activity($this->session->userdata('admin_email'),$admiData['admin_email']);
				$data = array(
					'response'=>'success',
					'message'=>'OTP verified.'
				);
			}else{
				$data = array(
					'response'=>'fail',
					'message'=>'Invalid OTP.'
				);
			}
		}
		else{
			$data = array(
				'response'=>'fail',
				'message'=>'something went wrong, please try again later.'
			);
		}
		echo json_encode($data);
		exit();
	}
	public function reports_dashboard(){
		$condition1 = [];
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$this->load->view('admin/header');
			$this->load->view('admin/step-reports/home');
			$this->load->view('admin/footer');
		}
		else{
			redirect('admin');
		}
	}
	public function reports_steps(){
		$condition1 = [];
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$data['dates']=$this->admin_model->get_dates_list_booking();
			//Get Saved Filters values if exists

			$definedFilterValues = $this->admin_model->get_defined_filter_values();
			// echo('<pre>');
			// print_r($this->session->userdata('mes_admin_id'));
			// print_r($definedFilterValues[0]['report_filters']);
			// echo('</pre>');
			// exit('sdfsd');
			// if($definedFilterValues[0]['report_filters']){
			// 	$data['definedfilters'] = $definedFilterValues[0]['report_filters'];
			// }
			$data['definedfilters'] = $definedFilterValues[0]['report_filters'];
			//Get Saved Filters values if exists END
			$data['dates']=$this->admin_model->get_dates_list_booking();
			$params=[];
			$data['restaurants']=$this->admin_model->get_restaurant_list($params);
			$this->load->view('admin/header');
			$this->load->view('admin/step-reports/reports_steps',$data);
			$this->load->view('admin/footer');
		}
		else{
			redirect('admin');
		}
	}

	public function save_report_filter_fields(){
		// $this->input->post();
		$result=$this->admin_model->save_report_filter_fields();
		echo json_encode(array("status"=>$result));
		exit();
	}

	public function report_generate(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$posts = $this->input->post();
			if($posts){
				//Save Filter fields for Quick Report
				$this->admin_model->save_report_filter_fields($posts);
				//Save Filter fields for Quick Report END


				$data['list'] = $this->admin_model->get_report_generate_list($posts);
				// $config['target']      = '#total_master_reservation'; 
				// $config['base_url']    = base_url('admin/ajax_master_report_generate'); 
				// $config['total_rows']  = count($data['list']); 
				$data['total_rows']  = count($data['list']); 
				$config['per_page']    = 8; 
				//$config['link_func']    = 'ajax_filter_form_complete_booking'; 
				$this->ajax_pagination->initialize($config); 
				$conditions = array( 
					//'limit' => 8 
				); 
				$conditions = array_merge($conditions, $posts);
				$data['list'] = $this->admin_model->get_report_generate_list($conditions);

				//Update Last filter values
				$this->admin_model->save_report_filter_fields();
				//Update Last filter values END

				$this->load->view('admin/header');
				$this->load->view('admin/step-reports/report_generate',$data);
				$this->load->view('admin/footer');
			}else{
				//$this->load->helper(site_url('admin/reports_steps'));
				redirect('/admin/reports_steps', 'refresh');
			}

		}
		else{
			redirect('admin');
		}
	}
	public function ajax_master_report_generate(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$per_page = 8;
			$page = $this->input->post('page'); 
			$conditions = [];
			$conditions = $this->input->post();
			$data['list'] = $this->admin_model->get_report_generate_list($conditions);
			if($length != ''){
				$per_page = $length;
			}
			if(!$page){ 
				$offset = 0; 
			}else{ 
				$offset = $page; 
			} 
			$config['target']      = '#total_master_reservation'; 
			$config['base_url']    = base_url('admin/ajax_master_booking_list'); 
			$config['total_rows']  = count($data['list']); 
			$config['per_page']    = $per_page; 
			$config['cur_page']    = $offset; 
			$config['link_func']    = 'ajax_filter_form_complete_booking'; 
			$this->ajax_pagination->initialize($config); 
			$conditions ['limit'] = $per_page; 
			if($offset > 0){
				$conditions['start'] = $offset;
			}
			$data['posts']=$this->input->post();
			$data['list'] = $this->admin_model->get_report_generate_list($conditions);
			$this->load->view('admin/step-reports/ajax_report_generate',$data);
		}
	}	
	public function export_master_report_generate(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$conditions = [];
			$conditions = $this->input->post();
			$days_columns = $this->input->post('days_columns');
			$dates = $this->input->post('select_days');
			$list = $this->admin_model->get_report_generate_list($conditions);
			$mySpreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
			$mySpreadsheet->removeSheetByIndex(0);
			$worksheet1 = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($mySpreadsheet, "Users List");
			$mySpreadsheet->addSheet($worksheet1, 0);

			/**Generic cols */
			$columns = [];
			//$columns = array('First Name','Last Name','Email Address','Response Status');
			if($conditions['generic_columns']){
				foreach($conditions['generic_columns'] as $generic_column){
					if($generic_column == 'first_name'){
						array_push($columns,'First Name');
					}
					if($generic_column == 'last_name'){
						array_push($columns,'Last Name');
					}
					if($generic_column == 'email'){
						array_push($columns,'Email Address');
					}
					if($generic_column == 'response_status'){
						array_push($columns,'Response Status');
					}
				}
			}

			/**Generic cols END*/

			$def_dates = $this->admin_model->get_dates_list_booking();
			if(!empty($dates)){
				foreach($dates as $date){
					$k=1; 
					foreach ($def_dates as $key => $inndate) {
						if($inndate['date'] == $date){
							$day = $k;
						}
						$k++;
					}
					$corrected_columns = array();
					foreach ($days_columns as $key => $value) {
						$corrected_key = trim($key, "'");
						$corrected_columns[$corrected_key] = $value;
					}
					// print_r($corrected_columns);
					// exit('ffff');
					if(in_array('status',$corrected_columns[$date])){
						array_push($columns,'Day '.$day.' Status');
					}
					if(in_array('role',$corrected_columns[$date])){
						array_push($columns,'Day '.$day.' Role');
					}
					if(in_array('date',$corrected_columns[$date])){
						array_push($columns,'Day '.$day.' Date');
					}
					if(in_array('time',$corrected_columns[$date])){
						array_push($columns,'Day '.$day.' Time');
					}
					if(in_array('restaurant_name',$corrected_columns[$date])){
						array_push($columns,'Day '.$day.' Restaurant Name');
					}
					if(in_array('property_type',$corrected_columns[$date])){
						array_push($columns,'Day '.$day.' Property Type');
					}
					if(in_array('pax',$corrected_columns[$date])){
						array_push($columns,'Day '.$day.' Pax');
					}
					if(in_array('guests',$corrected_columns[$date])){
						array_push($columns,'Day '.$day.' Guests');
					}
					if(in_array('admin_note',$corrected_columns[$date])){
						array_push($columns,'Day '.$day.' Admin Note');
					}
					if(in_array('last_updated',$corrected_columns[$date])){
						array_push($columns,'Day '.$day.' Last Updated');
					}
					// array_push($columns,'Day '.$k.' Status');
					// array_push($columns,'Day '.$k.' Role');
					// array_push($columns,'Day '.$k.' Date');
					// array_push($columns,'Day '.$k.' Time');
					// array_push($columns,'Day '.$k.' Restaurant Name');
					// array_push($columns,'Day '.$k.' Property Type');
					// array_push($columns,'Day '.$k.' Reserved People');
					// array_push($columns,'Day '.$k.' Guests');
					//array_push($columns,'Day '.$k.' Admin Note');
					//array_push($columns,'Day '.$k.' Modified Date');
				}
			}
			$sheet1data[] = $columns;
			if(!empty($list)){
				$j=1;
				foreach($list as $key => $data){
					$user_id = $data['id'];
					$booking = $this->admin_model->get_booking_detail_byuserid($user_id);
					$booking_status = 'No Response';
					if(!empty($dates) && !empty($booking)){
						$booked = 1;
						foreach($dates as $date){
							// echo($booking['id']);
							// echo('<br>');
							// echo($date);
							// exit('---iii');
							// $status = $this->admin_model->get_status_of_booking_date_byid($booking['id'],$date['date']);//error in $date['date']
							$status = $this->admin_model->get_status_of_booking_date_byid($booking['id'],$date);
							if($status != 'Booked'){
								$booked = 0;
							}
						}
						if($booked == 0){
							$booking_status = 'Partial';
						}
						if($booked == 1){
							$booking_status = 'Completed';
						}
					}
					$username = $data['full_name'];
					$exp = explode(' ',$username);
					$first_name = $exp[0];
					$last_name = $exp[1];
					$row = [];
					// $row = array($first_name,$last_name,$data['email'],$booking_status);
					if(in_array('first_name',$conditions['generic_columns'])){
						array_push($row,$first_name);
					}
					if(in_array('last_name',$conditions['generic_columns'])){
						array_push($row,$last_name);
					}
					if(in_array('email',$conditions['generic_columns'])){
						array_push($row,$data['email']);
					}
					if(in_array('response_status',$conditions['generic_columns'])){
						array_push($row,$booking_status);
					}
					if(!empty($dates)){
						foreach($dates as $date){
								// $reservation_status = 'Skipped';
								$reservation_status = 'No Response';
								$reservation_role = '';
								$reservation_date = '';
								$reservation_time = '';
								$reservation_restname = '';
								$reservation_resttype = '';
								$reservation_pax = '';
								$reservation_guests = '';
								$reservation_admin_note = '';
								$modify_date = '';
								//$invite_status = $this->admin_model->get_invite_status_byuserid_bookdate($user_id,$date['date']);//erro in $date['date']
								$invite_status = $this->admin_model->get_invite_status_byuserid_bookdate($user_id,$date);
								if(!empty($invite_status)){
									if($invite_status['status'] == 'invite'){
										$reservation_status = 'Pending Acceptance';
									}
									$from_data = $this->admin_model->get_user_detail($invite_status['from_id']);
									$reservation_role = 'Guest of '.$from_data['full_name'];
								}
								if(!empty($booking)){
								// $reserv_data = $this->admin_model->get_booking_dates_list_by_bookingid_date($booking['id'],$date['date']);//erro in $date['date']
								$reserv_data = $this->admin_model->get_booking_dates_list_by_bookingid_date($booking['id'],$date);
									if(!empty($reserv_data)){
										$reservation_admin_note = $reserv_data['admin_note'];
										$reservation_status = ucfirst($reserv_data['booking_status']);
										if($reserv_data['booking_status'] == 'skip'){
											// $reservation_status = $reservation_status.' ('.$reserv_data['booking_reason'].')';
											$reservation_status = $reserv_data['booking_reason'];
										}
										if($reserv_data['booking_status'] == 'cancel'){
											$reservation_status = $reservation_status.' ('.$reserv_data['booking_reason'].')';
										}
										if($reserv_data['ref_id'] == 0){
											$reservation_role = 'Primary';
										}
										$reservation_date = date('m-d-Y',strtotime($reserv_data['booking_date']));
										$reservation_time = $reserv_data['booking_time'];
										$reservation_pax = $reserv_data['booking_pax'];
										$reservation_restname  = $this->admin_model->get_restaurant_name_byid($reserv_data['booking_restid']);
										$property_type  = $this->admin_model->get_restaurant_type_byid($reserv_data['booking_restid']);
                                        $reservation_resttype = $this->admin_model->get_property_type_text($property_type);
										if($reserv_data['guests'] != ''){
											$gexp = explode(',',$reserv_data['guests']);
											$guest = [];
											foreach($gexp as $gid){
												$guest[] = $this->admin_model->get_user_name_byid($gid);
											}
											$reservation_guests = implode(', ',$guest);
										}
									}
									$modify_date = date('m-d-Y',strtotime($booking['modify_date']));

									//Convert time stamp to NY time zone
									// Create a DateTime object from the timestamp string
									$datein = DateTime::createFromFormat('Y-m-d H:i:s', $booking['modify_date'], new DateTimeZone('UTC'));

									// Set the target time zone (New York)
									$datein->setTimezone(new DateTimeZone('America/New_York'));

									// Format the date in the target time zone
									$new_york_time = $datein->format('Y-m-d H:i:s');
									$modify_date = date('m-d-Y H:i:s',strtotime($new_york_time));
									//Convert time stamp to NY time zone END

								}
							if(in_array('status',$corrected_columns[$date])){
								array_push($row, $reservation_status);
							}
							if(in_array('role',$corrected_columns[$date])){
								array_push($row, $reservation_role);
							}
							if(in_array('date',$corrected_columns[$date])){
								array_push($row, $reservation_date);
							}
							if(in_array('time',$corrected_columns[$date])){
								$ehiteSpaceFix = '';
								if (str_contains($reservation_time, 'pm')){
									$ehiteSpaceFix = str_replace("pm"," pm",$reservation_time);
									array_push($row, str_replace("  pm"," pm",$ehiteSpaceFix));
								}elseif(str_contains($reservation_time, 'am')){
									$ehiteSpaceFix = str_replace("am"," am",$reservation_time);
									array_push($row, str_replace("  am"," am",$ehiteSpaceFix));
								}else{
									array_push($row, $reservation_time);
								}
							}
							if(in_array('restaurant_name',$corrected_columns[$date])){
								array_push($row, $reservation_restname);
							}
							if(in_array('property_type',$corrected_columns[$date])){
								array_push($row, $reservation_resttype);
							}
							if(in_array('pax',$corrected_columns[$date])){
								array_push($row, $reservation_pax);
							}
							if(in_array('guests',$corrected_columns[$date])){
								array_push($row, $reservation_guests);
							}
							if(in_array('admin_note',$corrected_columns[$date])){
								array_push($row, $reservation_admin_note);
							}
							if(in_array('last_updated',$corrected_columns[$date])){
								array_push($row, $modify_date);
							}
							// array_push($row, $reservation_status);
							//array_push($row, $reservation_role);
							// array_push($row, $reservation_date);
							//array_push($row, $reservation_time);
							//array_push($row, $reservation_restname);
							// array_push($row, $reservation_resttype);
							// array_push($row, $reservation_pax);
							// array_push($row, $reservation_guests);
							// array_push($row, $reservation_admin_note);
							// array_push($row, $modify_date);
							}
						}
						$sheet1data[] = $row;
			$j++;	}
				}
			$worksheet1->fromArray($sheet1data);
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="export_master_booking_list'.time().'.xlsx"');
			header('Cache-Control: max-age=0');
			$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($mySpreadsheet, 'Xlsx');
			ob_start();
			$writer->save('php://output');
			$xlsData = ob_get_contents();
			ob_end_clean();
			$array = array(
				'filename'=> "export_master_booking_list".time().".xlsx",
				'data' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
			);
			echo json_encode($array);
		}
	}
}
