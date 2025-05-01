<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require FCPATH .'vendor/autoload.php';
use Jlorente\CreditCards\CreditCardTypeConfig;
use Jlorente\CreditCards\CreditCardValidator;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Help extends CI_Controller {
    public function __construct() {
        parent::__construct();
        // $this->load->helper('url'); // Load the URL helper
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
        $this->load->model('HelpPageModel');
        $this->load->model('HelpTopicModel');

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

    public function index() {

        if($this->session->userdata('mes_admin_id') == '' && $this->session->userdata('admin_role') != '0'){
			redirect('admin');
		}


        $data['popular_topics'] = $this->HelpPageModel->get_popular_topics();
        $data['setting'] = $this->admin_model->theme_setting();
        $data['help_pages'] = $this->HelpPageModel->get_help_pages();
        $data['is_index']= true;
        $this->load->view('help/header',$data);
        $this->load->view('help/index', $data);
        $this->load->view('help/footer');
    }

    public function view($id) {
        $data['setting'] = $this->admin_model->theme_setting();
        $data['help_page'] = $this->HelpPageModel->get_help_page($id);
        $data['help_topics'] = $this->HelpTopicModel->get_help_topics($id);
        $this->load->view('help/view', $data);
    }

    public function search() {
        $query = $this->input->get('query');
        $data['setting'] = $this->admin_model->theme_setting();
        $data['results'] = $this->HelpPageModel->search($query);
        $this->load->view('help/search_results', $data);
    }
}
