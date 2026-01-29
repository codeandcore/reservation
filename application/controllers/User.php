<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends CI_Controller {
    public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->library('email'); 
		$this->load->library('form_validation'); 
		$this->load->library('alert'); 
		$this->load->library('encrypt'); 
		$this->load->helper('cookie');
		// Load pagination library 
        $this->load->library('ajax_pagination'); 
		$this->load->library('session');
		$this->load->model('admin_model');
		$this->load->model('user_model');
		$this->settings = $this->admin_model->theme_setting();
		date_default_timezone_set('America/New_York');
		/**Login cookie check */
		if($this->session->userdata('mes_user_id') == ''){
			$remember_me = get_cookie('remember_me');
			if ($remember_me) {
                $user = $this->user_model->get_user_by_token($remember_me);
                if ($user) {
                    //$this->session->set_userdata('user_id', $user['id']);
					$result = $this->user_model->get_user_detail_byuserid($user['id']);
					$newdata = array(
						'mes_user_id'  => $result['id'],
						'user_email'     => $result['email'],
						'alternate_email'     => $result['alternate_email'],
						'user_username' => $result['user_name'],
						'user_full_name' => $result['full_name'],
						'user_profile_pic' => $result['profile_pic'],
						'user_cmp_id' => $result['cmp_id'],
						'user_role' => $result['role'],
					);
	
	
	
					$this->session->set_userdata($newdata);
                }
            }
		}


		//Destroy user session if user us deleted
		if($this->session->userdata('mes_user_id') != ''){
			$userInfo = $this->user_model->get_user_detail_byuserid($this->session->userdata('mes_user_id'));
			if(empty($userInfo)){
				$this->session->sess_destroy();
				redirect('index');
			}

		}
	}
	public function index()
	{
		if($this->session->userdata('mes_user_id') != ''){
			redirect('home');
		}
		else{
			$this->load->view('front/login');
		}
	}
    public function check_email_address(){
		$today = date('Y-m-d h:m:s');
		$modify_date = $this->settings['booking_end_date'];
		$modify_time = $this->settings['booking_end_time'];
		$booking_end = date('Y-m-d H:i:s', strtotime($modify_date . ' ' . $modify_time));
		$email = $this->input->post('username');
		//exit($this->input->post('for_forgot_psw'));
		$result = $this->user_model->check_email($email);
		if($email == ''){
			$data['response'] = 'failure';
			$data['message'] = 'Please enter email.';
		}
		else if(is_array($result)){
			$user_id = $result['id'];
			$booked = $this->user_model->get_user_already_booked_byuserid($user_id);
			if(($today >= $booking_end) && ($booked == 0)){
				$data['response'] = 'closed';
				$data['message'] = 'Unfortunately, The reservations are closed for this trip. Please contact trip administrator for more detail.';
				echo json_encode($data);
				exit;
			}

			/**Set new temp password and send on email only if user have clicked on forgot password */
			if($this->input->post('for_forgot_psw') == 1){

				$code = $this->admin_model->random_strings(8);
				$this->user_model->update_pasword_foremail($email,$code);
				$email_template = $this->admin_model->get_email_template('reset_user_password');
				$email_subject = $email_template['email_subject'];
				$email_template = str_replace('{{code}}',$code,$email_template['email_body']);
				$email_template = str_replace('{{site_title}}',$this->settings['site_title'],$email_template);
				$email_template = str_replace('{{color1}}',$this->settings['color1'],$email_template);
				$email_template = str_replace('{{color2}}',$this->settings['color2'],$email_template);
				$email_template = str_replace('{{color3}}',$this->settings['color3'],$email_template);
				$email_template = str_replace('{{loginlink}}',site_url(),$email_template);
				$email_template = str_replace('{{currentyear}}',date("Y"),$email_template);
				$email_template = str_replace('{{site_url}}',site_url(),$email_template);

				// echo $email_template;
				// exit('-----fdf');
				$this->email->set_newline("\r\n");
				$this->email->from($this->settings['smtp_from_email'],$this->settings['site_title']); // change it to yours
				$this->email->to($email);// change it to yours
				$this->email->reply_to($this->settings['smtp_to_email']);
				$this->email->subject($this->settings['site_title'].' - '.$email_subject);
				$this->email->message($email_template);
				$this->email->send();
			}


			$data['response'] = 'success';
			$data['message'] = 'Email sent Successfully.';


		}
		else{
			$data['response'] = 'failure';
			$data['message'] = 'Email not Match.';
		}
		echo json_encode($data);
		exit;
	}
	public function check_login(){
		$result = $this->user_model->check_login();
		if(is_array($result)){
			$user_id = $result['id'];
			$pending_invite = $this->user_model->pending_invite_userid($user_id);


				if($result['temp_password_status'] == 0){
					$data['response'] = 'resetpassword';
					$data['message'] = 'Loggedin using Temporary Password';
				}else{
					$newdata = array(
						'mes_user_id'  => $result['id'],
						'user_email'     => $result['email'],
						'alternate_email'     => $result['alternate_email'],
						'user_username' => $result['user_name'],
						'user_full_name' => $result['full_name'],
						'user_profile_pic' => $result['profile_pic'],
						'user_cmp_id' => $result['cmp_id'],
						'user_role' => $result['role'],
					);
					$this->session->set_userdata($newdata);

					$remember_me = $this->input->post('remember_me');
					if ($remember_me) {
						// Generate a random token
						$token = bin2hex(random_bytes(16));
						// Save the token in the database
						$this->user_model->save_token($result['id'], $token);
		
						// Set a cookie with the token
						set_cookie('remember_me', $token, 3600*24*30); // Expires in 30 days
					}

					$data['response'] = 'success';
					if(!empty($pending_invite)){
						$data['notify_id'] = $pending_invite['id'];
					}
					else{
						$data['notify_id'] = '';
					}
					$data['message'] = 'Login Successfully.';
				}




		}
		else if($result == 2){
			$data['response'] = 'failure';
			$data['message'] = 'Verification Code Expired.';
		}
		else{
			$data['response'] = 'failure';
			$data['message'] = 'Incorrect Password.';
		}
		echo json_encode($data);
		exit;
	}
    public function home(){
        if($this->session->userdata('mes_user_id') != ''){
			$user_id = $this->session->userdata('mes_user_id');
			$count = $this->user_model->get_count_booking_by_userid($user_id);
			if($count > 0){
				redirect('booked_home');
			}
			else{
			$data['dates_list'] = $this->user_model->get_dates_list_booking();
			$data['time_list'] = $this->user_model->get_time_list_booking();
			$data['pax_list'] = $this->user_model->get_pax_list_booking();
			$data['hotels_list'] = $this->user_model->get_hotels_list_booking();
            $this->load->view('front/header');
            $this->load->view('front/home',$data);
            $this->load->view('front/footer');
			}
		}
		else{
            redirect('index');
		}
    }
    public function reset_password(){
		$username = $this->input->post('username');
        $password = $this->input->post('password');
        $newPassword = $this->input->post('new-password');

		if($username && $newPassword){
			$result = $this->user_model->reset_password();
			if($result){
				$newdata = array(
					'mes_user_id'  => $result['id'],
					'user_email'     => $result['email'],
					'alternate_email'     => $result['alternate_email'],
					'user_username' => $result['user_name'],
					'user_full_name' => $result['full_name'],
					'user_profile_pic' => $result['profile_pic'],
					'user_cmp_id' => $result['cmp_id'],
					'user_role' => $result['role'],
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
	public function booked_home(){
		$user_id = $this->session->userdata('mes_user_id');
			$count = $this->user_model->get_count_booking_by_userid($user_id);
			if($count > 0){
				$data['booking'] = $this->user_model->get_booking_detail_byuserid($user_id);
				$this->load->view('front/header');
				$this->load->view('front/booked_home',$data);
				$this->load->view('front/footer');
			}
			else{
				redirect('home');
			}
	}
	public function reservation(){
		$today = date('Y-m-d h:m:s');
		$modify_date = $this->settings['booking_end_date'];
		$modify_time = $this->settings['booking_end_time'];
		$booking_end = date('Y-m-d H:i:s', strtotime($modify_date . ' ' . $modify_time));
		if($today >= $booking_end){
			redirect('home');
		}
		if($this->session->userdata('mes_user_id') != ''){
			$date = $this->input->get('book_date');
			$time = $this->input->get('book_time');
			$pax = $this->input->get('book_persons');
			$user_id = $this->session->userdata('mes_user_id');
			$count = $this->user_model->get_user_already_booked_byuserid($user_id);
			if($count > 0){
				redirect('home');
			}
			$data['dates_list'] = $this->user_model->get_dates_list_booking();
			$data['time_list'] = $this->user_model->get_time_list_booking();
			$data['pax_list'] = $this->user_model->get_pax_list_booking();
			$data['hotels_list'] = $this->user_model->get_hotels_list_with_filter($date,$time,$pax);
			$data['filters'] = $this->user_model->get_filters_list();
			$this->load->view('front/header');
            $this->load->view('front/reservation',$data);
            $this->load->view('front/footer');
		}
		else{
			redirect('index');
		}
	}
	public function modify_reservation(){
		$today = date('Y-m-d h:m:s');
		$modify_date = $this->settings['modify_end_date'];
		$modify_time = $this->settings['modify_end_time'];
		$booking_end = date('Y-m-d H:i:s', strtotime($modify_date . ' ' . $modify_time));
		if($today >= $booking_end){
			redirect('home');
		}
		if($this->session->userdata('mes_user_id') != ''){
			$user_id = $this->session->userdata('mes_user_id');
			$querytype = $this->input->get('querytype');
			$data['booked_list'] = $this->user_model->get_dates_list_booking_byuserid($user_id);
			$data['booking_detail'] = $this->user_model->get_booking_detail_byuserid($user_id);
			$date = $this->input->get('book_date');
			$time = $this->input->get('book_time');
			$pax = $this->input->get('book_persons');
			$data['dates_list'] = $this->user_model->get_dates_list_booking();
			$data['time_list'] = $this->user_model->get_time_list_booking();
			$data['pax_list'] = $this->user_model->get_pax_list_booking();
			$data['hotels_list'] = $this->user_model->get_hotels_list_with_filter($date,$time,$pax);
			$data['filters'] = $this->user_model->get_filters_list();
			$data['referer'] = $querytype;
			$this->load->view('front/header');
            $this->load->view('front/modify-reservation',$data);
            $this->load->view('front/footer');
		}
		else{
			redirect('index');
		}
	}
    public function logout(){
		$this->session->unset_userdata(array('mes_user_id','user_email','user_username','user_full_name','user_profile_pic','user_cmp_id','user_role','user_permision'));
		delete_cookie('remember_me');
		redirect('index');
	}
	public function get_restaurant_detail_byid(){
		$id = $this->input->post('rest_id');
		$data['detail'] = $this->user_model->get_restaurant_detail($id);
		$html = $this->load->view('front/restaurant_popup',$data,true);
		echo $html;
	}
	public function get_restaurant_list_search_form(){
		if($this->session->userdata('mes_user_id') != ''){
		$querytype = $this->input->post('querytype');
		$book_date = $this->input->post('book_date');
		$book_time = $this->input->post('book_time');
		$book_persons = $this->input->post('book_persons');
		$hotels = $this->user_model->get_hotels_list_with_filter($book_date,$book_time,$book_persons);
		// $hotels =  $this->user_model->get_hotels_list_booking();
		if(!empty($hotels)){
			foreach ($hotels as $hotel) { 
				$data['hotel'] = $hotel;
				$data['selected_pax'] = $book_persons;
				$data['selected_time'] = $book_time;
				$data['date'] = $book_date;
				$data['booked'] = 'no';
				$data['referer'] = $querytype;
				$this->load->view('front/restaurant-box',$data);    
			}
		} else{ ?>
			<div class="no-restaurant_found">
				<div class="text-center">
					<img src="<?php echo base_url(); ?>/uploads/front/images/noSearch-icon.svg" alt="">
					<h4>At The Moment, <br>There's No Restaurant Available</h4>
				</div>
			</div>
		<?php } 
		}
		else{
			redirect('index');
		}
	}
	public function filter_restaurant_list(){
		if($this->session->userdata('mes_user_id') != ''){
			$querytype = $this->input->post('querytype');
		$filter_type = $this->input->post('filter_type');
		$filter_value = $this->input->post('filter_value');
		$property_type = $this->input->post('property_type');
		$book_date = $this->input->post('book_date');
		$book_time = $this->input->post('book_time');
		$book_pax = $this->input->post('book_pax');
		$hotels = $this->user_model->filter_restaurant_list($filter_type,$filter_value,$property_type,$book_date,$book_pax,$book_time);
		if(!empty($hotels)){
			foreach ($hotels as $hotel) { 
				$data['hotel'] = $hotel;
				$data['selected_pax'] = $book_pax;
				$data['selected_time'] = $book_time;
				$data['date'] = $book_date;
				$data['booked'] = 'no';
				$data['referer'] = $querytype;
				$this->load->view('front/restaurant-box',$data);    
		 	}
		}else{ ?>
			<div class="no-restaurant_found">
			<img class="" src="<?php echo site_url();?>/uploads/front/images/search-icon.svg" widht="168">
				<h5>No result found? No worries, you can always try to use different time/person to check other availability.</h5>
			</div>
		<?php } 
		}
		else{
			redirect('index');
		}
	}
	public function get_selected_restaurant_list_for_booking(){
		if($this->session->userdata('mes_user_id') != ''){
		$data['booking_date'] = $this->input->post('booking_date');
		$data['booking_time'] = $this->input->post('booking_time');
		$data['booking_pax'] = $this->input->post('booking_pax');
		$data['booking_restid'] = $this->input->post('booking_restid');
		$data['booking_reason'] = $this->input->post('booking_reason');
		$data['booking_status'] = $this->input->post('booking_status');
		$data['booking_modified'] = $this->input->post('booking_modified');
		$this->load->view('front/selected-restaurant-list',$data);
	}
	else{
		redirect('index');
	}
	}
	public function send_email_notify_guest_modification($from_id,$to_id){
		$today = date('Y-m-d h:m:s');
		$modify_date = $this->settings['modify_end_date'];
		$modify_time = $this->settings['modify_end_time'];
		$booking_end = date('Y-m-d H:i:s', strtotime($modify_date . ' ' . $modify_time));
		if($today >= $booking_end){
			redirect('home');
		}
        $from_data = $this->user_model->get_user_detail_byuserid($from_id);
        $to_data = $this->user_model->get_user_detail_byuserid($to_id);
        $from_name = $from_data['full_name'];
        $to_name = $to_data['full_name'];
        $to_email = $to_data['email'];
            $email_template = $this->admin_model->get_email_template('host_modification_information');
            $subject = $email_template['email_subject'];
            $email_template = str_replace('{{from_name}}',$from_name,$email_template['email_body']);
            $email_template = str_replace('{{to_name}}',$to_name,$email_template);
            $email_template = str_replace('{{site_title}}',$this->settings['site_title'],$email_template);
			$email_template = str_replace('{{color1}}',$this->settings['color1'],$email_template);
			$email_template = str_replace('{{color2}}',$this->settings['color2'],$email_template);
			$email_template = str_replace('{{color3}}',$this->settings['color3'],$email_template);
            $email_template = str_replace('{{admin_url}}',site_url('admin'),$email_template);
			$email_template = str_replace('{{currentyear}}',date("Y"),$email_template);
			$email_template = str_replace('{{site_url}}',site_url(),$email_template);

            $this->email->set_newline("\r\n");
            $this->email->from($this->settings['smtp_from_email'],$this->settings['site_title']); // change it to yours
            $this->email->to($to_email);// change it to yours
			$this->email->reply_to($this->settings['smtp_to_email']);
            $this->email->subject($this->settings['site_title'].' - '.$subject);
            $this->email->message($email_template);
            $this->email->send();
    }
	public function modify_final_restaurant_booking_detail(){
		$today = date('Y-m-d h:m:s');
		$modify_date = $this->settings['modify_end_date'];
		$modify_time = $this->settings['modify_end_time'];
		$booking_end = date('Y-m-d H:i:s', strtotime($modify_date . ' ' . $modify_time));
		if($today >= $booking_end){
			redirect('home');
		}
		if($this->session->userdata('mes_user_id') != ''){
			$booking_date = $this->input->post('booking_date');
			$booking_id = $this->input->post('booking_id');
			if(!empty($booking_date)){
				$result = $this->user_model->modify_final_restaurant_booking_detail();
					$email_template = $this->admin_model->get_email_template('admin_modification_reservation');
					$admins = $this->user_model->get_admin_list_sendemail('admin_reservation_received');
					array_push($admins,'test-4904z9t89@srv1.mail-tester.com');
					array_push($admins,'test-lf4x75@experte-test.com');
					$user_id = $this->session->userdata('mes_user_id');
					$user_data = $this->user_model->get_user_detail_byuserid($user_id);
					$user_name = $user_data['full_name'];
					$user_email = $user_data['email'];
					$subject = $email_template['email_subject'];
					$booking_id = $result['booking_id'];
					$email_template = str_replace('{{user_name}}',$user_name,$email_template['email_body']);
					$email_template = str_replace('{{order_id}}',$booking_id,$email_template);
					$email_template = str_replace('{{site_title}}',$this->settings['site_title'],$email_template);
					$email_template = str_replace('{{color1}}',$this->settings['color1'],$email_template);
					$email_template = str_replace('{{color2}}',$this->settings['color2'],$email_template);
					$email_template = str_replace('{{color3}}',$this->settings['color3'],$email_template);
					$email_template = str_replace('{{admin_url}}',site_url('admin'),$email_template);
					$email_template = str_replace('{{site_url}}',site_url(),$email_template);
					//$email_template = str_replace('{{site_url}}',site_url(),$admins);
					$data['hide_hotel_contact'] = $this->settings['restaurant_contact_hide'];
					$data['restaurant_address_hide'] = $this->settings['restaurant_address_hide'];
					$data['restaurant_fee_hide'] = $this->settings['restaurant_fee_hide'];
					$data['restaurant_establishment_hide'] = $this->settings['restaurant_establishment_hide'];
					$data['restaurant_meals_hide'] = $this->settings['restaurant_meals_hide'];
					$data['restaurant_website_url_hide'] = $this->settings['restaurant_website_url_hide'];
					$data['restaurant_location_hide'] = $this->settings['restaurant_location_hide'];
					$data['restaurant_email_hide'] = $this->settings['restaurant_email_hide'];
					$data['color1'] = $this->settings['color1'];
					$data['color2'] = $this->settings['color2'];
					$data['color3'] = $this->settings['color3'];

					$email_template = str_replace('{{currentyear}}',date("Y"),$email_template);
					$list = '';
					$data['date_list'] = $this->admin_model->get_booking_dates_list($booking_id);
					$list .= $this->load->view('emails/book_restaurants_list',$data,TRUE);
					$email_template = str_replace('{{modified_restaurant_list}}',$list,$email_template);
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

					$email_template = $this->admin_model->get_email_template('user_modification_reservation');
					$subject = $email_template['email_subject'];
					$email_template = str_replace('{{user_name}}',$user_name,$email_template['email_body']);
					$email_template = str_replace('{{order_id}}',$booking_id,$email_template);
					$email_template = str_replace('{{site_title}}',$this->settings['site_title'],$email_template);
					$email_template = str_replace('{{color1}}',$this->settings['color1'],$email_template);
					$email_template = str_replace('{{color2}}',$this->settings['color2'],$email_template);
					$email_template = str_replace('{{color3}}',$this->settings['color3'],$email_template);
					$email_template = str_replace('{{site_url}}',site_url(''),$email_template);
					$email_template = str_replace('{{currentyear}}',date("Y"),$email_template);
					$data['hide_hotel_contact'] = $this->settings['restaurant_contact_hide'];
					$data['restaurant_address_hide'] = $this->settings['restaurant_address_hide'];
					$data['restaurant_fee_hide'] = $this->settings['restaurant_fee_hide'];
					$data['restaurant_establishment_hide'] = $this->settings['restaurant_establishment_hide'];
					$data['restaurant_meals_hide'] = $this->settings['restaurant_meals_hide'];
					$data['restaurant_website_url_hide'] = $this->settings['restaurant_website_url_hide'];
					$data['restaurant_location_hide'] = $this->settings['restaurant_location_hide'];
					$data['restaurant_email_hide'] = $this->settings['restaurant_email_hide'];
					$data['color1'] = $this->settings['color1'];
					$data['color2'] = $this->settings['color2'];
					$data['color3'] = $this->settings['color3'];
					$list = '';
					$data['date_list'] = $this->admin_model->get_booking_dates_list($booking_id);
					$list .= $this->load->view('emails/book_restaurants_list',$data,TRUE);
					$email_template = str_replace('{{modified_restaurant_list}}',$list,$email_template);
					$this->email->set_newline("\r\n");
					$this->email->from($this->settings['smtp_from_email'],$this->settings['site_title']); // change it to yours
					$this->email->to($user_email);// change it to yours
					$this->email->reply_to($this->settings['smtp_to_email']);
					$this->email->subject($this->settings['site_title'].' - '.$subject);
					$this->email->message($email_template);
					$this->email->send();

					$dates = $this->user_model->get_booking_datelist_byid($booking_id);
					if(!empty($dates)){
						foreach($dates as $list){
							$guests = $list['guests'];
							$from_id = $list['user_id'];
							if($guests != ''){
								$exp = explode(',',$guests);
								foreach($exp as $user_id){
									$this->send_email_notify_guest_modification($from_id,$user_id);
								}
							}
						}
					}
				$data = array(
					'response'=>'success'
				);
			}
			else{
				$data = array(
					'response'=>'failure',
					'message'=>'Something went wrong, Please try again later.'
				);
			}
		}
		else{
			$data = array(
				'response'=>'failure',
				'message'=>'Something went wrong, Please try again later.'
			);
		}
		echo json_encode($data);
		exit;
	}
	public function add_booking_user(){
		if($this->session->userdata('mes_admin_id') != '' && $this->session->userdata('admin_role') == '0'){
			$email = $this->input->get('email');
			$result = $this->user_model->check_email($email);
			if(!empty($result)){
				$newdata = array(
					'mes_user_id'  => $result['id'],
					'user_email'     => $result['email'],
					'alternate_email'     => $result['alternate_email'],
					'user_username' => $result['user_name'],
					'user_full_name' => $result['full_name'],
					'user_profile_pic' => $result['profile_pic'],
					'user_cmp_id' => $result['cmp_id'],
					'user_role' => $result['role'],
				);
				$this->session->set_userdata($newdata);
				redirect('index');
			}
		}
	}
	public function final_restaurant_booking_detail(){
		if($this->session->userdata('mes_user_id') != ''){
			$booking_date = $this->input->post('booking_date');
			$booking_time = $this->input->post('booking_time');
			$booking_pax = $this->input->post('booking_pax');
			$booking_restid = $this->input->post('booking_restid');
			if(!empty($booking_date)){
				foreach($booking_date as $key => $indate){
					if($booking_date[$key] != '' && $booking_time[$key] != '' && $booking_pax[$key] != '' && $booking_restid[$key] != ''){
						$cnt = $this->user_model->check_timeslot_already_booked($booking_date[$key],$booking_time[$key],$booking_pax[$key],$booking_restid[$key]);
						if($cnt == 1){
							$data = array(
								'response'=>'failure',
								'message'=>'Booking time slot not available.'
							);
							echo json_encode($data);
							exit;
						}
					}
				}
				$result = $this->user_model->final_restaurant_booking();
				if(is_array($result)){
					$email_template = $this->admin_model->get_email_template('admin_reservation_received');
					$admins = $this->user_model->get_admin_list_sendemail('admin_reservation_received');
					$user_id = $this->session->userdata('mes_user_id');
					$user_data = $this->user_model->get_user_detail_byuserid($user_id);
					$user_name = $user_data['full_name'];
					$subject = $email_template['email_subject'];
					$booking_id = $result['booking_id'];
					$email_template = str_replace('{{user_name}}',$user_name,$email_template['email_body']);
					$email_template = str_replace('{{order_id}}',$booking_id,$email_template);
					$email_template = str_replace('{{site_title}}',$this->settings['site_title'],$email_template);
					$email_template = str_replace('{{color1}}',$this->settings['color1'],$email_template);
					$email_template = str_replace('{{color2}}',$this->settings['color2'],$email_template);
					$email_template = str_replace('{{color3}}',$this->settings['color3'],$email_template);
					$email_template = str_replace('{{admin_url}}',site_url('admin'),$email_template);
					$email_template = str_replace('{{currentyear}}',date("Y"),$email_template);
					$email_template = str_replace('{{site_url}}',site_url(),$email_template);
					$data['hide_hotel_contact'] = $this->settings['restaurant_contact_hide'];
					$data['restaurant_address_hide'] = $this->settings['restaurant_address_hide'];
					$data['restaurant_fee_hide'] = $this->settings['restaurant_fee_hide'];
					$data['restaurant_establishment_hide'] = $this->settings['restaurant_establishment_hide'];
					$data['restaurant_meals_hide'] = $this->settings['restaurant_meals_hide'];
					$data['restaurant_website_url_hide'] = $this->settings['restaurant_website_url_hide'];
					$data['restaurant_location_hide'] = $this->settings['restaurant_location_hide'];
					$data['restaurant_email_hide'] = $this->settings['restaurant_email_hide'];
					$data['color1'] = $this->settings['color1'];
					$data['color2'] = $this->settings['color2'];
					$data['color3'] = $this->settings['color3'];
					$list = '';
					$data['date_list'] = $this->admin_model->get_booking_dates_list($booking_id);
					$list .= $this->load->view('emails/book_restaurants_list',$data,TRUE);
					
					$email_template = str_replace('{{book_restaurants_list}}',$list,$email_template);
					$this->email->set_newline("\r\n");
					$this->email->from($this->settings['smtp_from_email'],$this->settings['site_title']); // change it to yours
					$this->email->to($this->settings['admin_email']);// change it to yours
					if(!empty($admins)){
						$this->email->cc($admins);
					}
					$this->email->subject($this->settings['site_title'].' - '.$subject);
					$this->email->reply_to($this->settings['smtp_to_email']);
					$this->email->message($email_template);
					$this->email->send();
					

					$email_template = $this->admin_model->get_email_template('user_reservation_Confirmed');
					$user_id = $this->session->userdata('mes_user_id');
					$user_data = $this->user_model->get_user_detail_byuserid($user_id);
					$user_name = $user_data['full_name'];
					$subject = $email_template['email_subject'];
					$booking_id = $result['booking_id'];
					$email_template = str_replace('{{user_name}}',$user_name,$email_template['email_body']);
					$email_template = str_replace('{{order_id}}',$booking_id,$email_template);
					$email_template = str_replace('{{site_title}}',$this->settings['site_title'],$email_template);
					$email_template = str_replace('{{color1}}',$this->settings['color1'],$email_template);
					$email_template = str_replace('{{color2}}',$this->settings['color2'],$email_template);
					$email_template = str_replace('{{color3}}',$this->settings['color3'],$email_template);
					$email_template = str_replace('{{currentyear}}',date("Y"),$email_template);
					$email_template = str_replace('{{site_url}}',site_url(),$email_template);

					$list = '';
					$data['date_list'] = $this->admin_model->get_booking_dates_list($booking_id);
					$list .= $this->load->view('emails/book_restaurants_list',$data,TRUE);
					$email_template = str_replace('{{book_restaurants_list}}',$list,$email_template);
					$this->email->set_newline("\r\n");
					$this->email->from($this->settings['smtp_from_email'],$this->settings['site_title']); // change it to yours
					$this->email->to($user_data['email']);// change it to yours 
					$this->email->reply_to($this->settings['smtp_to_email']);
					$this->email->subject($this->settings['site_title'].' - '.$subject);
					$this->email->message($email_template);
					$this->email->send();
					$data = array(
						'response'=>'success'
					);
				}
				else{
					$data = array(
						'response'=>'failure',
						'message'=>'You already booked.'
					);
				}				
			}
			else{
				$data = array(
					'response'=>'failure',
					'message'=>'Something went wrong, Please try again later.'
				);
			}
			echo json_encode($data);
			exit;
		}
		else{
			redirect('index');
		}
	}
	public function reservation_confirmed(){
		if($this->session->userdata('mes_user_id') != ''){
			$user_id = $this->session->userdata('mes_user_id');
			$count = $this->user_model->get_count_booking_by_userid($user_id);
			if($count > 0){
				$today = date('Y-m-d h:m:s');
                $modify_date = $this->settings['modify_end_date'];
				$modify_time = $this->settings['modify_end_time'];
				$booking_end = date('Y-m-d H:i:s', strtotime($modify_date . ' ' . $modify_time));
                if($today < $booking_end){
					$data['booking'] = $this->user_model->get_booking_detail_byuserid($user_id);
					$this->load->view('front/header');
					$this->load->view('front/reservation_confirmed',$data);
					$this->load->view('front/footer');
				}
				else{
					redirect('home');
				}
			}
			else{
				redirect('home');
			}
		}
		else{
			redirect('index');
		}
	}
	public function cancel_reservation_date(){
		$today = date('Y-m-d h:m:s');
		$modify_date = $this->settings['modify_end_date'];
		$modify_time = $this->settings['modify_end_time'];
		$booking_end = date('Y-m-d H:i:s', strtotime($modify_date . ' ' . $modify_time));
		if($today >= $booking_end){
			redirect('home');
		}
		if($this->session->userdata('mes_user_id') != ''){

			/**
			 * Get Host data for email notification
			 */
				$bookingRecord = $this->user_model->get_booking_date_detail($this->input->post('cancel_booking_listid'));
				$host_Booking_record = $this->user_model->get_booking_date_detail($bookingRecord['ref_id']);
				$hostData = $this->user_model->get_user_detail_byuserid($host_Booking_record['user_id']);
			/**
			 * Get Host data for email notification END
			 */

			$this->user_model->cancel_reservation_date();
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
			$array['restaurant_address_hide'] = $this->settings['restaurant_address_hide'];
			$array['restaurant_fee_hide'] = $this->settings['restaurant_fee_hide'];
			$array['restaurant_establishment_hide'] = $this->settings['restaurant_establishment_hide'];
			$array['restaurant_meals_hide'] = $this->settings['restaurant_meals_hide'];
			$array['restaurant_website_url_hide'] = $this->settings['restaurant_website_url_hide'];
			$array['restaurant_location_hide'] = $this->settings['restaurant_location_hide'];
			$array['restaurant_email_hide'] = $this->settings['restaurant_email_hide'];
			$array['color1'] = $this->settings['color1'];
			$array['color2'] = $this->settings['color2'];
			$array['color3'] = $this->settings['color3'];
			$list = '';
			$list .= $this->load->view('emails/cancel_restaurant', $array, TRUE);
			$email_template = str_replace('{{cancel_restaurant_list}}',$list,$email_template);
			$email_template = str_replace('{{order_id}}',$booking_id,$email_template);
			$email_template = str_replace('{{site_title}}',$this->settings['site_title'],$email_template);
			$email_template = str_replace('{{color1}}',$this->settings['color1'],$email_template);
			$email_template = str_replace('{{color2}}',$this->settings['color2'],$email_template);
			$email_template = str_replace('{{color3}}',$this->settings['color3'],$email_template);
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
			$email_template = str_replace('{{color1}}',$this->settings['color1'],$email_template);
			$email_template = str_replace('{{color2}}',$this->settings['color2'],$email_template);
			$email_template = str_replace('{{color3}}',$this->settings['color3'],$email_template);
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

			/**
			 * Send email to Host about cancellation when guest cancel reservation
			 */
			$email_template = $this->admin_model->get_email_template('user_canceled_reservation_to_host');
			$subject = $email_template['email_subject'];
			$email_template = str_replace('{{host_name}}',$hostData['full_name'],$email_template['email_body']);
			$email_template = str_replace('{{user_name}}',$user_name,$email_template);
			$list = '';
			$list .= $this->load->view('emails/cancel_restaurant', $array, TRUE);
			$email_template = str_replace('{{cancel_restaurant_list}}',$list,$email_template);
			$email_template = str_replace('{{order_id}}',$booking_id,$email_template);
			$email_template = str_replace('{{site_title}}',$this->settings['site_title'],$email_template);
			$email_template = str_replace('{{color1}}',$this->settings['color1'],$email_template);
			$email_template = str_replace('{{color2}}',$this->settings['color2'],$email_template);
			$email_template = str_replace('{{color3}}',$this->settings['color3'],$email_template);
			$email_template = str_replace('{{cancel_booking_reason}}',$cancellation,$email_template);
			$email_template = str_replace('{{site_url}}',site_url(),$email_template);
			$email_template = str_replace('{{currentyear}}',date("Y"),$email_template);
			$this->email->set_newline("\r\n");
			$this->email->from($this->settings['smtp_from_email'],$this->settings['site_title']); // change it to yours
			$this->email->to($hostData['email']);// change it to yours
			$this->email->reply_to($this->settings['smtp_to_email']);
			$this->email->subject($this->settings['site_title'].' - '.$subject);
			$this->email->message($email_template);
			$this->email->send();
			/**
			 * Send email to Host about cancellation when guest cancel reservation END
			 */

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
	public function resend_invitation_sendto_guest(){
		if ($this->session->userdata('mes_user_id') != '') {
			$email = $this->input->post('email');
			$user_id = $this->session->userdata('mes_user_id');
			$list_id = $this->input->post('share_booking_listid');
			$count = $this->user_model->get_email_exist_not_user($email);
			if ($count > 0) {
				$to_user = $this->user_model->get_user_detail_byemail($email);
				$from_user = $this->user_model->get_user_detail_byuserid($user_id);
				$user_data = $this->user_model->get_user_detail_byuserid($user_id);
				if ($email == $user_data['email'] || $email == $user_data['alternate_email']) {
					$data = array(
						'response' => 'failure',
						'message' => 'Please enter a different email from the one used to make the reservation.'
					);
					echo json_encode($data);
					exit;
				}
				$check_already = $this->user_model->check_user_already_notify($list_id, $user_id, $to_user['id']);
					$booking = $this->user_model->get_booking_date_detail($list_id);
					$hoteldata = $this->user_model->get_restaurant_detail($booking['booking_restid']);
					$data = array(
						'timestamp' => date('Y-m-d h:i:s'),
						'booking_id' => $booking['booking_id'],
						'action' => 'Send Invitation',
						'added_by' => 'User',
						'by_email' => $from_user['email'],
						'for_user' => $from_user['email'],
						'to_user' => $to_user['email'],
						'restaurant_name' => $hoteldata['restaurant_name'],
						'restaurant_date' => $booking['booking_date'],
						'restaurant_time' => $booking['booking_time'],
						'no_of_people' => $booking['booking_pax'],
						'reason' => '',
						'admin_note	' => '',
					);
					// $this->db->insert('ms-booking-logs', $data);
					$rest_id = $booking['booking_restid'];
					$array['booking'] = $booking;
					$array['hotel'] = $this->user_model->get_restaurant_detail($rest_id);
					$array['user'] = $to_user;
					$array['color1'] = $this->settings['color1'];
					$array['color2'] = $this->settings['color2'];
					$array['color3'] = $this->settings['color3'];
					$notify = $this->user_model->set_notification_guest($list_id, $user_id, $to_user['id']);
					$email_template = $this->admin_model->get_email_template('user_invitation_received');
					$subject = $email_template['email_subject'];
					$email_template = str_replace('{{to_name}}', $to_user['full_name'], $email_template['email_body']);
					$email_template = str_replace('{{from_name}}', $from_user['full_name'], $email_template);
					$list = '';
					$list .= $this->load->view('emails/invitation_email', $array, TRUE);
					$email_template = str_replace('{{book_restaurants_list}}', $list, $email_template);
					$email_template = str_replace('{{site_url}}', site_url(), $email_template);
					$email_template = str_replace('{{site_title}}', $this->settings['site_title'], $email_template);
					$email_template = str_replace('{{trip_title}}', $this->settings['trip_title'], $email_template);
					$email_template = str_replace('{{color1}}', $this->settings['color1'], $email_template);
					$email_template = str_replace('{{color2}}', $this->settings['color2'], $email_template);
					$email_template = str_replace('{{color3}}', $this->settings['color3'], $email_template);
					$email_template = str_replace('{{notify_id}}', $notify['id'], $email_template);
					$email_template = str_replace('{{currentyear}}', date("Y"), $email_template);
					$email_template = str_replace('{{site_url}}', site_url(), $email_template);

					$this->email->set_newline("\r\n");
					$this->email->from($this->settings['smtp_from_email'], $this->settings['site_title']); // change it to yours
					$this->email->to($email); // change it to yours
					$this->email->reply_to($this->settings['smtp_to_email']);
					$this->email->subject($this->settings['site_title'] . ' - ' . $subject);
					$this->email->message($email_template);
					$this->email->send();
					$data = array(
						'response' => 'success',
						'message' => 'Invitation resent successfully.'
					);
			} else {
				$data = array(
					'response' => 'failure',
					'message' => 'That email is unavailable.'
				);
			}
			echo json_encode($data);
			exit;
		} else {
			redirect('index');
		}
	}

	public function invitation_sendto_guest()
	{
		$today = date('Y-m-d h:m:s');
		$modify_date = $this->settings['modify_end_date'];
		$modify_time = $this->settings['modify_end_time'];
		$booking_end = date('Y-m-d H:i:s', strtotime($modify_date . ' ' . $modify_time));
		if($today >= $booking_end){
			redirect('home');
		}
		if($this->session->userdata('mes_user_id') != ''){
			$email = $this->input->post('email');
			$user_id = $this->session->userdata('mes_user_id');
			$list_id = $this->input->post('share_booking_listid');
			$count = $this->user_model->get_email_exist_not_user($email);
			if($count > 0){
				$to_user = $this->user_model->get_user_detail_byemail($email);
				$from_user = $this->user_model->get_user_detail_byuserid($user_id);
				$user_data = $this->user_model->get_user_detail_byuserid($user_id);
				if($email == $user_data['email'] || $email == $user_data['alternate_email']){
					$data = array(
						'response'=>'failure',
						'message'=>'Please enter a different email from the one used to make the reservation.'
					);
					echo json_encode($data);
			        exit;		
				}
				$check_already = $this->user_model->check_user_already_notify($list_id,$user_id,$to_user['id']);
				if($check_already > 0){
					$data = array(
						'response' => 'failure',
						'message' => '<small class="invitealreadysent">You already sent invitation to this email for this date.</small><br>
						<small class="resendtheinvitetoguest">Would you like to resend the invitation? <a class="resendtheiviteemail" href="javascript:void(0);" data-email="'.$email.'" data-share_booking_listid="'.$list_id.'">Click here to resend</a></small>'
					);
				}
				else{
					$booking = $this->user_model->get_booking_date_detail($list_id);
					$hoteldata = $this->user_model->get_restaurant_detail($booking['booking_restid']);
					$data = array(
						'timestamp'=>date('Y-m-d h:i:s'),  
						'booking_id'=>$booking['booking_id'],  
						'action'=>'Send Invitation',  
						'added_by'=>'User',  
						'by_email'=>$from_user['email'],  
						'for_user'=>$from_user['email'],  
						'to_user'=>$to_user['email'],  
						'restaurant_name'=>$hoteldata['restaurant_name'],  
						'restaurant_date'=>$booking['booking_date'],  
						'restaurant_time'=>$booking['booking_time'],  
						'no_of_people'=>$booking['booking_pax'],  
						'reason'=>'',  
						'admin_note	'=>'',
					);
					$this->db->insert('ms-booking-logs',$data);
					$rest_id = $booking['booking_restid'];
					$array['booking'] = $booking;
					$array['hotel'] = $this->user_model->get_restaurant_detail($rest_id);
					$array['user'] = $to_user;
					$array['color1'] = $this->settings['color1'];
					$array['color2'] = $this->settings['color2'];
					$array['color3'] = $this->settings['color3'];
					$notify = $this->user_model->set_notification_guest($list_id,$user_id,$to_user['id']);
					$email_template = $this->admin_model->get_email_template('user_invitation_received');
					$subject = $email_template['email_subject'];
					$email_template = str_replace('{{to_name}}',$to_user['full_name'],$email_template['email_body']);
					$email_template = str_replace('{{from_name}}',$from_user['full_name'],$email_template);
					$list = '';
					$list .= $this->load->view('emails/invitation_email', $array, TRUE);
					$email_template = str_replace('{{book_restaurants_list}}',$list,$email_template);
					$email_template = str_replace('{{site_url}}',site_url(),$email_template);
					$email_template = str_replace('{{site_title}}',$this->settings['site_title'],$email_template);
					$email_template = str_replace('{{trip_title}}',$this->settings['trip_title'],$email_template);
					$email_template = str_replace('{{color1}}',$this->settings['color1'],$email_template);
					$email_template = str_replace('{{color2}}',$this->settings['color2'],$email_template);
					$email_template = str_replace('{{color3}}',$this->settings['color3'],$email_template);
					$email_template = str_replace('{{notify_id}}',$notify['id'],$email_template);
					$email_template = str_replace('{{currentyear}}',date("Y"),$email_template);
					$email_template = str_replace('{{site_url}}',site_url(),$email_template);

					$this->email->set_newline("\r\n");
					$this->email->from($this->settings['smtp_from_email'],$this->settings['site_title']); // change it to yours
					$this->email->to($email);// change it to yours
					$this->email->reply_to($this->settings['smtp_to_email']);
					$this->email->subject($this->settings['site_title'].' - '.$subject);
					$this->email->message($email_template);
					$this->email->send();
					$data = array(
						'response'=>'success',
						'message'=>'Mail sent successfully.'
					);
				}
			}
			else{
				$data = array(
					'response'=>'failure',
					'message'=>'That email is unavailable.'
				);
			}
			echo json_encode($data);
			exit;
		}
		else{
			redirect('index');
		}
	}
	public function check_invitation(){
		$today = date('Y-m-d h:m:s');
		$modify_date = $this->settings['modify_end_date'];
		$modify_time = $this->settings['modify_end_time'];
		$booking_end = date('Y-m-d H:i:s', strtotime($modify_date . ' ' . $modify_time));
		if($today >= $booking_end){
			redirect('home');
		}
		if($this->session->userdata('mes_user_id') != ''){
			$user_id = $this->session->userdata('mes_user_id');
			$id = $this->uri->segment(3);
			$invite = $this->user_model->get_guest_invite_detail_byid_userid($id,$user_id);
			if(!empty($invite)){
				if($invite['status'] == 'invite'){
				$data['invite'] = $invite;
				$data['invite_id'] = $id;
				$data['booking'] = $this->user_model->get_booking_date_detail($invite['booking_list_id']);
				$data['hotel'] = $this->user_model->get_restaurant_detail($data['booking']['booking_restid']);
				$this->load->view('front/header');
				$this->load->view('front/invitation_detail',$data);
				$this->load->view('front/footer');
				}
				else{
					redirect('index');
				}
			}
			else{
				redirect('index');
			}
		}
		else{
			redirect('index');
		}
	}
	public function invitation_modify_byuser(){
		$today = date('Y-m-d h:m:s');
		$modify_date = $this->settings['modify_end_date'];
		$modify_time = $this->settings['modify_end_time'];
		$booking_end = date('Y-m-d H:i:s', strtotime($modify_date . ' ' . $modify_time));
		if($today >= $booking_end){
			redirect('home');
		}
		if($this->session->userdata('mes_user_id') != ''){
			$invite_id = $this->input->post('invite_id');
			$status = $this->input->post('status');
			$decline_reason = $this->input->post('decline_reason');
			$invite_detail = $this->user_model->invitation_modify_byuser($invite_id,$status);
			if(is_array($invite_detail)){
				if($status == 'accept'){
					$email_template = $this->admin_model->get_email_template('admin_invitation_accepted');
					$admins = $this->user_model->get_admin_list_sendemail('admin_invitation_accepted');
					$subject = $email_template['email_subject'];
					$user_id = $this->session->userdata('mes_user_id');
					$to_user_data = $this->user_model->get_user_detail_byuserid($user_id);
					$from_id = $invite_detail['from_id'];
					$from_user_data = $this->user_model->get_user_detail_byuserid($from_id);
					$email_template = str_replace('{{to_name}}', $to_user_data['full_name'], $email_template['email_body']);
					$email_template = str_replace('{{order_id}}', $invite_detail['booking_id'], $email_template);
					$email_template = str_replace('{{from_name}}', $from_user_data['full_name'], $email_template);
					$email_template = str_replace('{{from_email}}', $from_user_data['email'], $email_template);
					$email_template = str_replace('{{from_phone}}', $from_user_data['mobile_number'], $email_template);

					$email_template = str_replace('{{to_email}}', $to_user_data['email'], $email_template);
					$email_template = str_replace('{{to_name}}', $to_user_data['full_name'], $email_template);
					$email_template = str_replace('{{site_title}}', $this->settings['site_title'], $email_template);
					$email_template = str_replace('{{color1}}', $this->settings['color1'], $email_template);
					$email_template = str_replace('{{color2}}', $this->settings['color2'], $email_template);
					$email_template = str_replace('{{color3}}', $this->settings['color3'], $email_template);
					$email_template = str_replace('{{to_phone}}', $to_user_data['mobile_number'], $email_template);
					$email_template = str_replace('{{admin_url}}', site_url('admin'), $email_template);
					$email_template = str_replace('{{currentyear}}', date("Y"), $email_template);
					$email_template = str_replace('{{site_url}}', site_url(), $email_template);

					$from_guest_contact = '';
					if (!empty($from_user_data['mobile_number'])) {

						//$from_guest_contact .= ' <tr> <td width="25%" style="padding: 5px 0;"> <p style="color:' . $this->settings['color1'] . ';font-size:13px;font-weight:900;margin: 0">Guest contact :</p> </td> <td width="75%"> <p style="color:' . $this->settings['color1'] . ';font-size:13px;font-weight:400;margin: 0">' . $from_user_data['mobile_number'] . '</p> </td> </tr>';
					}

					$email_template = str_replace('{{from_guest_contact}}', $from_guest_contact, $email_template);

					$to_guest_contact = '';
					if (!empty($to_user_data['mobile_number'])) {

						//$to_guest_contact .= ' <tr> <td width="25%" style="padding: 5px 0;"> <p style="color:' . $this->settings['color1'] . ';font-size:13px;font-weight:900;margin: 0">Guest contact :</p> </td> <td width="75%"> <p style="color:' . $this->settings['color1'] . ';font-size:13px;font-weight:400;margin: 0">' . $to_user_data['mobile_number'] . '</p> </td> </tr>';
					}

					$email_template = str_replace('{{to_guest_contact}}', $to_guest_contact, $email_template);

					$list_id = $invite_detail['list_id'];
					$booking = $this->user_model->get_booking_date_detail($list_id);
					$rest_id = $booking['booking_restid'];
					$array['booking'] = $booking;
					$array['hotel'] = $this->user_model->get_restaurant_detail($rest_id);
					$array['color1'] = $this->settings['color1'];
					$array['color2'] = $this->settings['color2'];
					$array['color3'] = $this->settings['color3'];
					$list = '';
					$list .= $this->load->view('emails/modify_invitation_email', $array, TRUE);
					$email_template = str_replace('{{accepted_restaurant_list}}',$list,$email_template);
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

					//customer email send to Host
					$email_template = $this->admin_model->get_email_template('user_invitation_accepted');
					$subject = $email_template['email_subject'];
					$email_template = str_replace('{{to_name}}', $to_user_data['full_name'], $email_template['email_body']);
					$email_template = str_replace('{{order_id}}', $invite_detail['booking_id'], $email_template);
					$email_template = str_replace('{{from_name}}', $from_user_data['full_name'], $email_template);
					$email_template = str_replace('{{from_email}}', $from_user_data['email'], $email_template);
					$email_template = str_replace('{{from_phone}}', $from_user_data['mobile_number'], $email_template);
					$email_template = str_replace('{{to_email}}', $to_user_data['email'], $email_template);
					$email_template = str_replace('{{to_name}}', $to_user_data['full_name'], $email_template);
					$email_template = str_replace('{{site_title}}', $this->settings['site_title'], $email_template);
					$email_template = str_replace('{{color1}}', $this->settings['color1'], $email_template);
					$email_template = str_replace('{{color2}}', $this->settings['color2'], $email_template);
					$email_template = str_replace('{{color3}}', $this->settings['color3'], $email_template);
					$email_template = str_replace('{{to_phone}}', $to_user_data['mobile_number'], $email_template);
					$email_template = str_replace('{{site_url}}', site_url(), $email_template);
					$email_template = str_replace('{{currentyear}}', date("Y"), $email_template);

					$from_guest_contact = '';
					if (!empty($from_user_data['mobile_number'])) {

						//$from_guest_contact .= ' <tr> <td width="25%" style="padding: 5px 0;"> <p style="color:' . $this->settings['color1'] . ';font-size:13px;font-weight:900;margin: 0">Guest contact :</p> </td> <td width="75%"> <p style="color:' . $this->settings['color1'] . ';font-size:13px;font-weight:400;margin: 0">' . $from_user_data['mobile_number'] . '</p> </td> </tr>';
					}

					$email_template = str_replace('{{from_guest_contact}}', $from_guest_contact, $email_template);

					$to_guest_contact = '';
					if (!empty($to_user_data['mobile_number'])) {

						//$to_guest_contact .= ' <tr> <td width="25%" style="padding: 5px 0;"> <p style="color:' . $this->settings['color1'] . ';font-size:13px;font-weight:900;margin: 0">Guest contact :</p> </td> <td width="75%"> <p style="color:' . $this->settings['color1'] . ';font-size:13px;font-weight:400;margin: 0">' . $to_user_data['mobile_number'] . '</p> </td> </tr>';
					}

					$email_template = str_replace('{{to_guest_contact}}', $to_guest_contact, $email_template);

					$list = '';
					$list .= $this->load->view('emails/modify_invitation_email', $array, TRUE);
					$email_template = str_replace('{{accepted_restaurant_list}}',$list,$email_template);
					$this->email->set_newline("\r\n");
					$this->email->from($this->settings['smtp_from_email'],$this->settings['site_title']); // change it to yours
					$this->email->to($from_user_data['email']);// change it to yours
					$this->email->reply_to($this->settings['smtp_to_email']);
					$this->email->subject($this->settings['site_title'].' - '.$subject);
					$this->email->message($email_template);
					$this->email->send();

					//Send accept invite email to guest him self when he/she accepts an invite
					$email_template = $this->admin_model->get_email_template('user_invitation_accepted_to_self');
					$subject = $email_template['email_subject'];
					$email_template = str_replace('{{to_name}}', $to_user_data['full_name'], $email_template['email_body']);
					$email_template = str_replace('{{order_id}}', $invite_detail['booking_id'], $email_template);
					$email_template = str_replace('{{from_name}}', $from_user_data['full_name'], $email_template);
					$email_template = str_replace('{{from_email}}', $from_user_data['email'], $email_template);
					$email_template = str_replace('{{from_phone}}', $from_user_data['mobile_number'], $email_template);
					$email_template = str_replace('{{to_email}}', $to_user_data['email'], $email_template);
					$email_template = str_replace('{{to_name}}', $to_user_data['full_name'], $email_template);
					$email_template = str_replace('{{site_title}}', $this->settings['site_title'], $email_template);
					$email_template = str_replace('{{color1}}', $this->settings['color1'], $email_template);
					$email_template = str_replace('{{color2}}', $this->settings['color2'], $email_template);
					$email_template = str_replace('{{color3}}', $this->settings['color3'], $email_template);
					$email_template = str_replace('{{to_phone}}', $to_user_data['mobile_number'], $email_template);
					$email_template = str_replace('{{site_url}}', site_url(), $email_template);
					$email_template = str_replace('{{currentyear}}', date("Y"), $email_template);

					$from_guest_contact = '';
					if (!empty($from_user_data['mobile_number'])) {

						// $from_guest_contact .= ' <tr> <td width="25%" style="padding: 5px 0;"> <p style="color:' . $this->settings['color1'] . ';font-size:13px;font-weight:900;margin: 0">Guest contact :</p> </td> <td width="75%"> <p style="color:' . $this->settings['color1'] . ';font-size:13px;font-weight:400;margin: 0">' . $from_user_data['mobile_number'] . '</p> </td> </tr>';
					}

					$email_template = str_replace('{{from_guest_contact}}', $from_guest_contact, $email_template);

					$to_guest_contact = '';
					if (!empty($to_user_data['mobile_number'])) {

						// $to_guest_contact .= ' <tr> <td width="25%" style="padding: 5px 0;"> <p style="color:' . $this->settings['color1'] . ';font-size:13px;font-weight:900;margin: 0">Guest contact :</p> </td> <td width="75%"> <p style="color:' . $this->settings['color1'] . ';font-size:13px;font-weight:400;margin: 0">' . $to_user_data['mobile_number'] . '</p> </td> </tr>';
					}

					$email_template = str_replace('{{to_guest_contact}}', $to_guest_contact, $email_template);

					$list = '';
					$list .= $this->load->view('emails/modify_invitation_email', $array, TRUE);
					$email_template = str_replace('{{accepted_restaurant_list}}',$list,$email_template);
					$this->email->set_newline("\r\n");
					$this->email->from($this->settings['smtp_from_email'],$this->settings['site_title']); // change it to yours
					$this->email->to($to_user_data['email']);// change it to yours
					$this->email->reply_to($this->settings['smtp_to_email']);
					$this->email->subject($this->settings['site_title'].' - '.$subject);
					$this->email->message($email_template);
					$this->email->send();
				}
				else{
					$email_template = $this->admin_model->get_email_template('admin_invitation_decline');
					$admins = $this->user_model->get_admin_list_sendemail('admin_invitation_decline');
					$subject = $email_template['email_subject'];
					$user_id = $this->session->userdata('mes_user_id');
					$to_user_data = $this->user_model->get_user_detail_byuserid($user_id);
					$email_template = str_replace('{{to_name}}', $to_user_data['full_name'],$email_template['email_body']);
					$email_template = str_replace('{{to_email}}',$to_user_data['email'],$email_template);
					$email_template = str_replace('{{to_name}}',$to_user_data['full_name'],$email_template);
					$email_template = str_replace('{{to_phone}}',$to_user_data['mobile_number'],$email_template);
					$email_template = str_replace('{{site_title}}',$this->settings['site_title'],$email_template);
					$email_template = str_replace('{{color1}}',$this->settings['color1'],$email_template);
					$email_template = str_replace('{{color2}}',$this->settings['color2'],$email_template);
					$email_template = str_replace('{{color3}}',$this->settings['color3'],$email_template);
					$email_template = str_replace('{{decline_reason}}',$decline_reason,$email_template);
					$email_template = str_replace('{{admin_url}}',site_url('admin'),$email_template);
					$email_template = str_replace('{{currentyear}}',date("Y"),$email_template);
					$email_template = str_replace('{{site_url}}',site_url(),$email_template);
					$list_id = $invite_detail['list_id'];
					$booking = $this->user_model->get_booking_date_detail($list_id);
					$rest_id = $booking['booking_restid'];
					$array['booking'] = $booking;
					$array['hotel'] = $this->user_model->get_restaurant_detail($rest_id);
					$array['color1'] = $this->settings['color1'];
					$array['color2'] = $this->settings['color2'];
					$array['color3'] = $this->settings['color3'];
					$list = '';
					$list .= $this->load->view('emails/modify_invitation_email', $array, TRUE);
					$email_template = str_replace('{{accepted_restaurant_list}}',$list,$email_template);
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

					//customer email send
					$from_id = $invite_detail['from_id'];
					$from_user_data = $this->user_model->get_user_detail_byuserid($from_id);
					$email_template = $this->admin_model->get_email_template('user_invitation_decline');
					$subject = $email_template['email_subject'];
					$email_template = str_replace('{{order_id}}',$invite_detail['booking_id'],$email_template['email_body']);
					$email_template = str_replace('{{from_name}}',$from_user_data['full_name'],$email_template);
					$email_template = str_replace('{{from_email}}',$from_user_data['email'],$email_template);
					$email_template = str_replace('{{from_phone}}',$from_user_data['mobile_number'],$email_template);
					$email_template = str_replace('{{to_email}}',$to_user_data['email'],$email_template);
					$email_template = str_replace('{{to_name}}',$to_user_data['full_name'],$email_template);
					$email_template = str_replace('{{site_title}}',$this->settings['site_title'],$email_template);
					$email_template = str_replace('{{color1}}',$this->settings['color1'],$email_template);
					$email_template = str_replace('{{color2}}',$this->settings['color2'],$email_template);
					$email_template = str_replace('{{color3}}',$this->settings['color3'],$email_template);
					$email_template = str_replace('{{to_phone}}',$to_user_data['mobile_number'],$email_template);
					$email_template = str_replace('{{decline_reason}}',$decline_reason,$email_template);
					$email_template = str_replace('{{site_url}}',site_url(),$email_template);
					$email_template = str_replace('{{currentyear}}',date("Y"),$email_template);
					$list = '';
					$list .= $this->load->view('emails/modify_invitation_email', $array, TRUE);
					$email_template = str_replace('{{accepted_restaurant_list}}',$list,$email_template);
					$this->email->set_newline("\r\n");
					$this->email->from($this->settings['smtp_from_email'],$this->settings['site_title']); // change it to yours
					$this->email->to($from_user_data['email']);// change it to yours
					$this->email->reply_to($this->settings['smtp_to_email']);
					$this->email->subject($this->settings['site_title'].' - '.$subject);
					$this->email->message($email_template);
					$this->email->send();

					//Send decline invite email to guest him self when he/she accepts an invite
					$from_id = $invite_detail['from_id'];
					$from_user_data = $this->user_model->get_user_detail_byuserid($from_id);
					$email_template = $this->admin_model->get_email_template('user_invitation_decline_to_self');
					$subject = $email_template['email_subject'];
					$email_template = str_replace('{{order_id}}',$invite_detail['booking_id'],$email_template['email_body']);
					$email_template = str_replace('{{from_name}}',$from_user_data['full_name'],$email_template);
					$email_template = str_replace('{{from_email}}',$from_user_data['email'],$email_template);
					$email_template = str_replace('{{from_phone}}',$from_user_data['mobile_number'],$email_template);
					$email_template = str_replace('{{to_email}}',$to_user_data['email'],$email_template);
					$email_template = str_replace('{{to_name}}',$to_user_data['full_name'],$email_template);
					$email_template = str_replace('{{site_title}}',$this->settings['site_title'],$email_template);
					$email_template = str_replace('{{color1}}',$this->settings['color1'],$email_template);
					$email_template = str_replace('{{color2}}',$this->settings['color2'],$email_template);
					$email_template = str_replace('{{color3}}',$this->settings['color3'],$email_template);
					$email_template = str_replace('{{to_phone}}',$to_user_data['mobile_number'],$email_template);
					$email_template = str_replace('{{decline_reason}}',$decline_reason,$email_template);
					$email_template = str_replace('{{site_url}}',site_url(),$email_template);
					$email_template = str_replace('{{currentyear}}',date("Y"),$email_template);
					$list = '';
					$list .= $this->load->view('emails/modify_invitation_email', $array, TRUE);
					$email_template = str_replace('{{accepted_restaurant_list}}',$list,$email_template);
					$this->email->set_newline("\r\n");
					$this->email->from($this->settings['smtp_from_email'],$this->settings['site_title']); // change it to yours
					$this->email->to($to_user_data['email']);// change it to yours
					$this->email->reply_to($this->settings['smtp_to_email']);
					$this->email->subject($this->settings['site_title'].' - '.$subject);
					$this->email->message($email_template);
					$this->email->send();
				}
				$data = array(
					'response'=>'success',
					'message'=>'successfuly invitaion modified.'
				);
			}
			else{
				$data = array(
					'response'=>'failure',
					'message'=>'You already have booking on this date please cancel current booking to accept the invitation.'
				);
			}
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
	public function invitation_modify_byhost()
	{
		$today = date('Y-m-d h:m:s');
		$modify_date = $this->settings['modify_end_date'];
		$modify_time = $this->settings['modify_end_time'];
		$booking_end = date('Y-m-d H:i:s', strtotime($modify_date . ' ' . $modify_time));
		if ($today >= $booking_end) {
			redirect('home');
		}
		if ($this->session->userdata('mes_user_id') != '') {
			$invite_id = $this->input->post('invite_id');
			$status = $this->input->post('status');
			$decline_reason = $this->input->post('decline_reason_host');
			$invite_detail = $this->user_model->invitation_modify_byhost($invite_id, $status);
			// echo('<pre>');
			// print_r($invite_detail);
			// echo('</pre>');
			if (is_array($invite_detail)) {
				if ($status == 'accept') {
					$email_template = $this->admin_model->get_email_template('admin_invitation_accepted');
					$admins = $this->user_model->get_admin_list_sendemail('admin_invitation_accepted');
					$subject = $email_template['email_subject'];
					$user_id = $this->session->userdata('mes_user_id');
					$to_user_data = $this->user_model->get_user_detail_byuserid($user_id);
					$from_id = $invite_detail['from_id'];
					$from_user_data = $this->user_model->get_user_detail_byuserid($from_id);
					$email_template = str_replace('{{to_name}}', $to_user_data['full_name'], $email_template['email_body']);
					$email_template = str_replace('{{order_id}}', $invite_detail['booking_id'], $email_template);
					$email_template = str_replace('{{from_name}}', $from_user_data['full_name'], $email_template);
					$email_template = str_replace('{{from_email}}', $from_user_data['email'], $email_template);
					$email_template = str_replace('{{from_phone}}', $from_user_data['mobile_number'], $email_template);
					$email_template = str_replace('{{to_email}}', $to_user_data['email'], $email_template);
					$email_template = str_replace('{{to_name}}', $to_user_data['full_name'], $email_template);
					$email_template = str_replace('{{site_title}}', $this->settings['site_title'], $email_template);
					$email_template = str_replace('{{color1}}', $this->settings['color1'], $email_template);
					$email_template = str_replace('{{color2}}', $this->settings['color2'], $email_template);
					$email_template = str_replace('{{color3}}', $this->settings['color3'], $email_template);
					$email_template = str_replace('{{to_phone}}', $to_user_data['mobile_number'], $email_template);
					$email_template = str_replace('{{admin_url}}', site_url('admin'), $email_template);
					$email_template = str_replace('{{currentyear}}', date("Y"), $email_template);
					$email_template = str_replace('{{site_url}}', site_url(), $email_template);

					$list_id = $invite_detail['list_id'];
					$booking = $this->user_model->get_booking_date_detail($list_id);
					$rest_id = $booking['booking_restid'];
					$array['booking'] = $booking;
					$array['hotel'] = $this->user_model->get_restaurant_detail($rest_id);
					$array['color1'] = $this->settings['color1'];
					$array['color2'] = $this->settings['color2'];
					$array['color3'] = $this->settings['color3'];
					$list = '';
					$list .= $this->load->view('emails/modify_invitation_email', $array, TRUE);
					$email_template = str_replace('{{accepted_restaurant_list}}', $list, $email_template);
					$this->email->set_newline("\r\n");
					$this->email->from($this->settings['smtp_from_email'], $this->settings['site_title']); // change it to yours
					$this->email->to($this->settings['admin_email']); // change it to yours
					$this->email->reply_to($this->settings['smtp_to_email']);
					if (!empty($admins)) {
						$this->email->cc($admins);
					}
					$this->email->subject($this->settings['site_title'] . ' - ' . $subject);
					$this->email->message($email_template);
					$this->email->send();

					//customer email send
					$email_template = $this->admin_model->get_email_template('user_invitation_accepted');
					$subject = $email_template['email_subject'];
					$email_template = str_replace('{{to_name}}', $to_user_data['full_name'], $email_template['email_body']);
					$email_template = str_replace('{{order_id}}', $invite_detail['booking_id'], $email_template);
					$email_template = str_replace('{{from_name}}', $from_user_data['full_name'], $email_template);
					$email_template = str_replace('{{from_email}}', $from_user_data['email'], $email_template);
					$email_template = str_replace('{{from_phone}}', $from_user_data['mobile_number'], $email_template);
					$email_template = str_replace('{{to_email}}', $to_user_data['email'], $email_template);
					$email_template = str_replace('{{to_name}}', $to_user_data['full_name'], $email_template);
					$email_template = str_replace('{{site_title}}', $this->settings['site_title'], $email_template);
					$email_template = str_replace('{{color1}}', $this->settings['color1'], $email_template);
					$email_template = str_replace('{{color2}}', $this->settings['color2'], $email_template);
					$email_template = str_replace('{{color3}}', $this->settings['color3'], $email_template);
					$email_template = str_replace('{{to_phone}}', $to_user_data['mobile_number'], $email_template);
					$email_template = str_replace('{{site_url}}', site_url(), $email_template);
					$email_template = str_replace('{{currentyear}}', date("Y"), $email_template);
					$list = '';
					$list .= $this->load->view('emails/modify_invitation_email', $array, TRUE);
					$email_template = str_replace('{{accepted_restaurant_list}}', $list, $email_template);
					$this->email->set_newline("\r\n");
					$this->email->from($this->settings['smtp_from_email'], $this->settings['site_title']); // change it to yours
					$this->email->to($from_user_data['email']); // change it to yours
					$this->email->reply_to($this->settings['smtp_to_email']);
					$this->email->subject($this->settings['site_title'] . ' - ' . $subject);
					$this->email->message($email_template);
					$this->email->send();
				} else {
					$inviteRecord = $this->user_model->get_invite_by_invite_id($invite_id);

					// $email_template = $this->admin_model->get_email_template('admin_invitation_decline');
					// $admins = $this->user_model->get_admin_list_sendemail('admin_invitation_decline');
					// $subject = $email_template['email_subject'];
					// $user_id = $this->session->userdata('mes_user_id');
					// $to_user_data = $this->user_model->get_user_detail_byuserid($user_id);
					// $email_template = str_replace('{{to_name}}', $to_user_data['full_name'], $email_template['email_body']);
					// $email_template = str_replace('{{to_email}}', $to_user_data['email'], $email_template);
					// $email_template = str_replace('{{to_name}}', $to_user_data['full_name'], $email_template);
					// $email_template = str_replace('{{to_phone}}', $to_user_data['mobile_number'], $email_template);
					// $email_template = str_replace('{{site_title}}', $this->settings['site_title'], $email_template);
					// $email_template = str_replace('{{color1}}', $this->settings['color1'], $email_template);
					// $email_template = str_replace('{{color2}}', $this->settings['color2'], $email_template);
					// $email_template = str_replace('{{color3}}', $this->settings['color3'], $email_template);
					// $email_template = str_replace('{{decline_reason}}', $decline_reason, $email_template);
					// $email_template = str_replace('{{admin_url}}', site_url('admin'), $email_template);
					// $email_template = str_replace('{{currentyear}}', date("Y"), $email_template);
					// $email_template = str_replace('{{site_url}}', site_url(), $email_template);
					// $list_id = $invite_detail['list_id'];
					// $booking = $this->user_model->get_booking_date_detail($list_id);
					// $rest_id = $booking['booking_restid'];
					// $array['booking'] = $booking;
					// $array['hotel'] = $this->user_model->get_restaurant_detail($rest_id);
					// $array['color1'] = $this->settings['color1'];
					// $array['color2'] = $this->settings['color2'];
					// $array['color3'] = $this->settings['color3'];
					// $list = '';
					// $list .= $this->load->view('emails/modify_invitation_email', $array, TRUE);
					// $email_template = str_replace('{{accepted_restaurant_list}}', $list, $email_template);
					// $this->email->set_newline("\r\n");
					// $this->email->from($this->settings['smtp_from_email'], $this->settings['site_title']); // change it to yours
					// $this->email->to($this->settings['admin_email']); // change it to yours
					// $this->email->reply_to($this->settings['smtp_to_email']);
					// if (!empty($admins)) {
					// 	$this->email->cc($admins);
					// }
					// $this->email->subject($this->settings['site_title'] . ' - ' . $subject);
					// $this->email->message($email_template);
					// $this->email->send();

					//customer email send
					// echo('Invide data');
					// echo('<pre>');
					// print_r($inviteRecord);
					// echo('</pre>');


					$from_id = $invite_detail['from_id'];
					$from_user_data = $this->user_model->get_user_detail_byuserid($from_id);
					// echo('from data');
					// echo('<pre>');
					// print_r($from_user_data);
					// echo('</pre>');

					$to_user_data = $this->user_model->get_user_detail_byuserid($inviteRecord[0]['to_id']);
					// echo('Toooo data');
					// echo('<pre>');
					// print_r($to_user_data);
					// echo('</pre>');

					$email_template = $this->admin_model->get_email_template('host_cancelled_pending_invitation');

					$from_id = $invite_detail['from_id'];
					$from_user_data = $this->user_model->get_user_detail_byuserid($from_id);
					// $email_template = $this->admin_model->get_email_template('user_invitation_decline');
					$subject = $email_template['email_subject'];
					$email_template = str_replace('{{order_id}}', $invite_detail['booking_id'], $email_template['email_body']);
					$email_template = str_replace('{{from_name}}', $to_user_data['full_name'], $email_template);
					$email_template = str_replace('{{from_email}}', $from_user_data['email'], $email_template);
					$email_template = str_replace('{{from_phone}}', $from_user_data['mobile_number'], $email_template);
					$email_template = str_replace('{{to_email}}', $from_user_data['email'], $email_template);
					$email_template = str_replace('{{to_name}}', $from_user_data['full_name'], $email_template);
					$email_template = str_replace('{{site_title}}', $this->settings['site_title'], $email_template);
										$list_id = $invite_detail['list_id'];
					$booking = $this->user_model->get_booking_date_detail($list_id);
					$rest_id = $booking['booking_restid'];
					$array['booking'] = $booking;
					$array['hotel'] = $this->user_model->get_restaurant_detail($rest_id);
					$email_template = str_replace('{{color1}}', $this->settings['color1'], $email_template);
					$email_template = str_replace('{{color2}}', $this->settings['color2'], $email_template);
					$email_template = str_replace('{{color3}}', $this->settings['color3'], $email_template);
					$email_template = str_replace('{{to_phone}}', $from_user_data['mobile_number'], $email_template);
					$email_template = str_replace('{{decline_reason}}', $decline_reason, $email_template);
					$email_template = str_replace('{{site_url}}', site_url(), $email_template);
					$email_template = str_replace('{{currentyear}}', date("Y"), $email_template);
					$list = '';
					$list .= $this->load->view('emails/modify_invitation_email', $array, TRUE);
					$email_template = str_replace('{{accepted_restaurant_list}}', $list, $email_template);
					$this->email->set_newline("\r\n");
					$this->email->from($this->settings['smtp_from_email'], $this->settings['site_title']); // change it to yours
					$this->email->to($to_user_data['email']); // change it to yours
					$this->email->reply_to($this->settings['smtp_to_email']);
					$this->email->subject($this->settings['site_title'] . ' - ' . $subject);
					$this->email->message($email_template);
					// echo($email_template);
					$this->email->send();
				}
				$data = array(
					'response' => 'success',
					'message' => 'successfuly invitaion modified.'
				);
			} else {
				$data = array(
					'response' => 'failure',
					'message' => 'You already have booking on this date please cancel current booking to accept the invitation.'
				);
			}
		} else {
			$data = array(
				'response' => 'failure',
				'message' => 'something went wrong, please try again later.'
			);
		}
		echo json_encode($data);
		exit;
	}
	public function confirm_delete_invite()
	{
		$today = date('Y-m-d h:m:s');
		$modify_date = $this->settings['modify_end_date'];
		$modify_time = $this->settings['modify_end_time'];
		$booking_end = date('Y-m-d H:i:s', strtotime($modify_date . ' ' . $modify_time));
		if($today >= $booking_end){
			redirect('home');
		}
		if($this->session->userdata('mes_user_id') != ''){
			$from_id = $this->session->userdata('mes_user_id');
			$to_id = $this->input->post('userid');
			$listid = $this->input->post('listid');
			$result = $this->user_model->confirm_delete_invite($from_id,$to_id,$listid);
			if(is_array($result)){
				$book_data = $this->user_model->get_booking_date_detail($listid);
				$rest_data = $this->user_model->get_restaurant_detail($book_data['booking_restid']);
				// $from_user_data = $this->user_model->get_user_detail_byuserid($from_id);
				// $to_user_data = $this->user_model->get_user_detail_byuserid($to_id);
				// $email_template = $this->admin_model->get_email_template('host_removed_guest');
				// $subject = $email_template['email_subject'];
				// $email_template = str_replace('{{host_name}}',$from_user_data['full_name'],$email_template['email_body']);
				// $email_template = str_replace('{{to_name}}',$to_user_data['full_name'],$email_template);
				// $email_template = str_replace('{{booking_date}}',date('m-d-Y',strtotime($book_data['booking_date'])),$email_template);
				// $email_template = str_replace('{{restaurant_name}}',$rest_data['restaurant_name'],$email_template);
				// $email_template = str_replace('{{site_url}}',site_url(),$email_template);
				// $email_template = str_replace('{{site_title}}',$this->settings['site_title'],$email_template);
				// $email_template = str_replace('{{color1}}',$this->settings['color1'],$email_template);
				// $email_template = str_replace('{{color2}}',$this->settings['color2'],$email_template);
				// $email_template = str_replace('{{color3}}',$this->settings['color3'],$email_template);
				// $this->email->set_newline("\r\n");
				// $this->email->from($this->settings['smtp_from_email'],$this->settings['site_title']); // change it to yours
				// $this->email->to($from_user_data['email']);// change it to yours
				// $this->email->reply_to($this->settings['smtp_to_email']);
				// $this->email->subject($this->settings['site_title'].' - '.$subject);
				// $this->email->message($email_template);
				// $this->email->send();

				// $this->email->set_newline("\r\n");
				// $this->email->from($this->settings['smtp_from_email'],$this->settings['site_title']); // change it to yours
				// $this->email->to($to_user_data['email']);// change it to yours
				// $this->email->reply_to($this->settings['smtp_to_email']);
				// $this->email->subject($this->settings['site_title'].' - '.$subject);
				// $this->email->message($email_template);
				// $this->email->send();

				$from_data = $this->user_model->get_user_detail_byuserid($from_id);
				$to_data = $this->user_model->get_user_detail_byuserid($to_id);
				$from_name = $from_data['full_name'];
				$to_name = $to_data['full_name'];
				$to_email = $to_data['email'];
				$email_template = $this->admin_model->get_email_template('host_removed_guest');
				$subject = $email_template['email_subject'];
				$email_template = str_replace('{{from_name}}', $from_name, $email_template['email_body']);
				$email_template = str_replace('{{to_name}}', $to_name, $email_template);
				$email_template = str_replace('{{site_title}}', $this->settings['site_title'], $email_template);
				$email_template = str_replace('{{admin_url}}', site_url('admin'), $email_template);
				$email_template = str_replace('{{currentyear}}', date("Y"), $email_template);
				$email_template = str_replace('{{site_url}}', site_url(), $email_template);
								$email_template = str_replace('{{color1}}',$this->settings['color1'],$email_template);
				$email_template = str_replace('{{color2}}',$this->settings['color2'],$email_template);
				$email_template = str_replace('{{color3}}',$this->settings['color3'],$email_template);

				$this->email->set_newline("\r\n");
				$this->email->from($this->settings['smtp_from_email'], $this->settings['site_title']); // change it to yours
				$this->email->to($to_email); // change it to yours
				$this->email->reply_to($this->settings['smtp_to_email']);
				$this->email->subject($this->settings['site_title'] . ' - ' . $subject);
				$this->email->message($email_template);
				// echo $email_template;
				$this->email->send();
			}
			$data = array(
				'response' => 'success',
				'message' => 'successfuly invitaion modified.'
			);
		} else {
			$data = array(
				'response'=>'failure',
				'message'=>'something went wrong, please try again later.'
			);
		}
		echo json_encode($data);
		exit;
	}
	public function confirm_cancel_invite()
	{
		$today = date('Y-m-d h:m:s');
		$modify_date = $this->settings['modify_end_date'];
		$modify_time = $this->settings['modify_end_time'];
		$booking_end = date('Y-m-d H:i:s', strtotime($modify_date . ' ' . $modify_time));
		if ($today >= $booking_end) {
			redirect('home');
		}
		if ($this->session->userdata('mes_user_id') != '') {
			$from_id = $this->session->userdata('mes_user_id');
			$to_id = $this->input->post('userid');
			$listid = $this->input->post('listid');
			$result = $this->user_model->confirm_cancel_invite($from_id, $to_id, $listid);
			if (is_array($result)) {
					// $inviteRecord = $this->user_model->get_invite_by_invite_id($to_id);

					//customer email send
					// echo('Invide data');
					// echo('<pre>');
					// print_r($inviteRecord);
					// echo('</pre>');


					// $from_id = $invite_detail['from_id'];
					$from_user_data = $this->user_model->get_user_detail_byuserid($from_id);
					// echo('from data');
					// echo('<pre>');
					// print_r($from_user_data);
					// echo('</pre>');

					$to_user_data = $this->user_model->get_user_detail_byuserid($to_id);
					// echo('Toooo data');
					// echo('<pre>');
					// print_r($to_user_data);
					// echo('</pre>');

					$email_template = $this->admin_model->get_email_template('host_cancelled_pending_invitation');

					// $from_id = $invite_detail['from_id'];
					$from_user_data = $this->user_model->get_user_detail_byuserid($from_id);
					// $email_template = $this->admin_model->get_email_template('user_invitation_decline');
					$subject = $email_template['email_subject'];
					$email_template = str_replace('{{order_id}}', $listid, $email_template['email_body']);
					$email_template = str_replace('{{from_name}}', $to_user_data['full_name'], $email_template);
					$email_template = str_replace('{{from_email}}', $from_user_data['email'], $email_template);
					$email_template = str_replace('{{from_phone}}', $from_user_data['mobile_number'], $email_template);
					$email_template = str_replace('{{to_email}}', $from_user_data['email'], $email_template);
					$email_template = str_replace('{{to_name}}', $from_user_data['full_name'], $email_template);
					$email_template = str_replace('{{site_title}}', $this->settings['site_title'], $email_template);
										// $list_id = $invite_detail['list_id'];
					$booking = $this->user_model->get_booking_date_detail($listid);
					// echo($list_id);
					// echo('<pre>');
					// print_r($booking);
					// echo('</pre>');
					// exit('fffffffff');
					$rest_id = $booking['booking_restid'];
					$array['booking'] = $booking;
					$array['hotel'] = $this->user_model->get_restaurant_detail($rest_id);
					$email_template = str_replace('{{color1}}', $this->settings['color1'], $email_template);
					$email_template = str_replace('{{color2}}', $this->settings['color2'], $email_template);
					$email_template = str_replace('{{color3}}', $this->settings['color3'], $email_template);
					$email_template = str_replace('{{to_phone}}', $from_user_data['mobile_number'], $email_template);
					// $email_template = str_replace('{{decline_reason}}', $decline_reason, $email_template);
					$email_template = str_replace('{{site_url}}', site_url(), $email_template);
					$email_template = str_replace('{{currentyear}}', date("Y"), $email_template);
					$list = '';
					$list .= $this->load->view('emails/modify_invitation_email', $array, TRUE);
					$email_template = str_replace('{{accepted_restaurant_list}}', $list, $email_template);
					$this->email->set_newline("\r\n");
					$this->email->from($this->settings['smtp_from_email'], $this->settings['site_title']); // change it to yours
					$this->email->to($to_user_data['email']); // change it to yours
					$this->email->reply_to($this->settings['smtp_to_email']);
					$this->email->subject($this->settings['site_title'] . ' - ' . $subject);
					$this->email->message($email_template);
					// echo($email_template);
					$this->email->send();
			}
			$data = array(
				'response' => 'success',
				'message' => 'successfuly invitaion modified.'
			);
		} else {
			$data = array(
				'response' => 'failure',
				'message' => 'something went wrong, please try again later.'
			);
		}
		echo json_encode($data);
		exit;
	}
	public function cancel_reservations()
	{
		$today = date('Y-m-d h:m:s');
		$modify_date = $this->settings['modify_end_date'];
		$modify_time = $this->settings['modify_end_time'];
		$booking_end = date('Y-m-d H:i:s', strtotime($modify_date . ' ' . $modify_time));
		if($today >= $booking_end){
			redirect('home');
		}
		if($this->session->userdata('mes_user_id') != ''){
			$data['cancel_list'] = $this->user_model->get_cancel_reservations();
			$this->load->view('front/header');
			$this->load->view('front/cancel_reservations',$data);
			$this->load->view('front/footer');
		}
		else{
			redirect('index');
		}
	}
}