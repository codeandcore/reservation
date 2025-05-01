<?php
class HelpCenter extends CI_Controller {
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
        $this->load->model('HelpPageModel');
        $this->load->model('HelpTopicModel');
        $this->load->helper('url');
        $this->load->library('form_validation');

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
        $data['help_pages'] = $this->HelpPageModel->get_help_pages();
        $data['setting'] = $this->admin_model->theme_setting();
        $this->load->view('admin/help_center/header');
        $this->load->view('admin/help_center/index', $data);
        $this->load->view('admin/help_center/footer');
    }

    public function update_positions() {
        $positions = $this->input->post('positions');
        $this->HelpPageModel->update_page_positions($positions);
        redirect('admin/help_center');
    }

    public function view_page($id) {
        if($this->session->userdata('mes_admin_id') == '' && $this->session->userdata('admin_role') != '0'){
			redirect('admin');
		}
        $data['setting'] = $this->admin_model->theme_setting();
        $data['help_page'] = $this->HelpPageModel->get_help_page($id);
        $data['help_topics'] = $this->HelpTopicModel->get_help_topics($id);
        $this->load->view('admin/help_center/header');
        $this->load->view('admin/help_center/view_page', $data);
        $this->load->view('admin/help_center/footer');
    }

    public function create_page() {
        if($this->session->userdata('mes_admin_id') == '' && $this->session->userdata('admin_role') != '0'){
			redirect('admin');
		}
        $data['setting'] = $this->admin_model->theme_setting();
        $this->form_validation->set_rules('title', 'Title', 'required');

        // if ($this->form_validation->run() === FALSE) {
        //     $this->load->view('admin/help_center/header');
        //     $this->load->view('admin/help_center/create_page');
        //     $this->load->view('admin/help_center/footer');
        // } else {
        //     $data = array(
        //         'title' => $this->input->post('title'),
        //         'created_at' => date('Y-m-d H:i:s'),
        //         'updated_at' => date('Y-m-d H:i:s')
        //     );
        //     $this->HelpPageModel->create_help_page($data);
        //     redirect('admin/help_center');
        // }

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('admin/help_center/header');
            $this->load->view('admin/help_center/create_page');
            $this->load->view('admin/help_center/footer');
        } else {
            // Handle file upload
            $image = $this->upload_image('image');

            $data = array(
                'title' => $this->input->post('title'),
                'summary' => $this->input->post('summary'),
                'image' => $image,
                // 'exclude_from_search' => $this->input->post('exclude_from_search') ? 1 : 0,
                'is_new_feature' => $this->input->post('is_new_feature') ? 1 : 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );

            $this->HelpPageModel->create_help_page($data);
            redirect('admin/help_center');
        }
    }

    public function edit_page($id) {
        if($this->session->userdata('mes_admin_id') == '' && $this->session->userdata('admin_role') != '0'){
			redirect('admin');
		}
        $data['setting'] = $this->admin_model->theme_setting();
        $data['help_page'] = $this->HelpPageModel->get_help_page($id);

        $this->form_validation->set_rules('title', 'Title', 'required');

        // if ($this->form_validation->run() === FALSE) {
        //     $this->load->view('admin/help_center/header');
        //     $this->load->view('admin/help_center/edit_page', $data);
        //     $this->load->view('admin/help_center/footer');
        // } else {
        //     $data = array(
        //         'title' => $this->input->post('title'),
        //         'updated_at' => date('Y-m-d H:i:s')
        //     );
        //     // $data['title'] = $this->input->post('title');
        //     // $data['updated_at'] = date('Y-m-d H:i:s');
        //     $this->HelpPageModel->update_help_page($id, $data);
        //     redirect('admin/help_center');
        // }

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('admin/help_center/header');
            $this->load->view('admin/help_center/edit_page', $data);
            $this->load->view('admin/help_center/footer');
        } else {
            // Handle file upload
            $image = $this->upload_image('image');
            $data = array(
                'title' => $this->input->post('title'),
                'summary' => $this->input->post('summary'),
                // 'exclude_from_search' => $this->input->post('exclude_from_search') ? 1 : 0,
                'is_new_feature' => $this->input->post('is_new_feature') ? 1 : 0,
                'updated_at' => date('Y-m-d H:i:s')
            );

            if ($image) {
                $data['image'] = $image;
            }

            $this->HelpPageModel->update_help_page($id, $data);
            redirect('admin/help_center');
        }

    }
    private function upload_image($field_name) {
        if($this->session->userdata('mes_admin_id') == '' && $this->session->userdata('admin_role') != '0'){
			redirect('admin');
		}
        if (!empty($_FILES[$field_name]['name'])) {
            $config['upload_path'] = './uploads_help_center/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png|webp|svg';
            $config['max_size'] = 2048;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload($field_name)) {
                $upload_data = $this->upload->data();
                return $upload_data['file_name'];
            } else {
                return null;
            }
        }
        return null;
    }
    public function delete_page($id) {
        if($this->session->userdata('mes_admin_id') == '' && $this->session->userdata('admin_role') != '0'){
			redirect('admin');
		}
        $data['setting'] = $this->admin_model->theme_setting();
        $this->HelpPageModel->delete_help_page($id);
        redirect('admin/help_center');
    }

    public function create_topic($page_id) {
        if($this->session->userdata('mes_admin_id') == '' && $this->session->userdata('admin_role') != '0'){
			redirect('admin');
		}
        $data['setting'] = $this->admin_model->theme_setting();
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('content', 'Content', 'required');

        if ($this->form_validation->run() === FALSE) {
            $data['page_id'] = $page_id;
            $this->load->view('admin/help_center/header');
            $this->load->view('admin/help_center/create_topic', $data);
            $this->load->view('admin/help_center/footer');
        } else {
            $data = array(
                'page_id' => $page_id,
                'title' => $this->input->post('title'),
                'content' => $this->input->post('content'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );
            // $data['page_id'] = $page_id;
            // $data['title'] = $this->input->post('title');
            // $data['content'] =  $this->input->post('content');
            // $data['created_at'] =  date('Y-m-d H:i:s');
            // $data['updated_at'] =  date('Y-m-d H:i:s');

            $this->HelpTopicModel->create_help_topic($data);
            redirect('admin/help_center/view_page/'.$page_id);
        }
    }

    public function edit_topic($id) {
        if($this->session->userdata('mes_admin_id') == '' && $this->session->userdata('admin_role') != '0'){
			redirect('admin');
		}
        $data['setting'] = $this->admin_model->theme_setting();
        $data['help_topic'] = $this->HelpTopicModel->get_help_topic($id);


        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('content', 'Content', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('admin/help_center/header');
            $this->load->view('admin/help_center/edit_topic', $data);
            $this->load->view('admin/help_center/footer');
        } else {
            $data = array(
                'title' => $this->input->post('title'),
                'content' => $this->input->post('content'),
                'include_in_popular' => $this->input->post('include_in_popular') ? 1 : 0,
                'updated_at' => date('Y-m-d H:i:s')
            );
            
            $this->HelpTopicModel->update_help_topic($id, $data);
            $data['help_topic'] = $this->HelpTopicModel->get_help_topic($id);
            redirect('admin/help_center/view_page/'.$data['help_topic']['page_id']);
        }
    }

    public function delete_topic($id) {
        if($this->session->userdata('mes_admin_id') == '' && $this->session->userdata('admin_role') != '0'){
			redirect('admin');
		}
        $data['setting'] = $this->admin_model->theme_setting();
        $topic = $this->HelpTopicModel->get_help_topic($id);
        $this->HelpTopicModel->delete_help_topic($id);
        redirect('admin/help_center/view_page/'.$topic['page_id']);
    }
}
