<?php 
class Admin_model extends CI_Model {
    function check_email($email){
        $where = "email='$email' && status='0' && role='0'";
        $this->db->where($where);
        $query = $this->db->get('ms-admin');
        $count = $query->num_rows();
        if($count > 0){
            $row = $query->row();         
            return (array)$row;
        }
        else{
            return 1;
        }
    }
    function check_login(){
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $where = "email='$username' && password = '$password' && role='0' && status='0'";
        $this->db->where($where);
        $query = $this->db->get('ms-admin');
        $count = $query->num_rows();
        if($count > 0){
            $row = $query->row();         
            return (array)$row;
        }
        else{
            return 1;
        }
    }
    function check_email_already_exist_rolewise($email,$alternate_email,$role){
        $where = "((email='$email' || alternate_email = '$email') || (email='$alternate_email' || alternate_email = '$alternate_email')) && role='$role'";
        $this->db->where($where);
        $query = $this->db->get('ms-admin');
        $count = $query->num_rows();
        return $count;
    }   
    function random_strings($length_of_string){
        $randomNumber = random_int(10000, 99999);
        return $randomNumber;
        // $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        // return substr(str_shuffle($str_result), 0, $length_of_string);
    }
    function update_pasword_foremail($email,$code){
        $data = array(
            'password'=>$code,
            'temp_password_status'=>0,
            'otp_time'=>date('Y-m-d H:i:s')
        );
        $this->db->where('email',$email);
        $this->db->update('ms-admin',$data);
    }
    function reset_password_admin($id){
        $password = $this->input->post('password');
        $data = array(
            'password'=>$password,
        );
        $this->db->where('id',$id);
        $this->db->update('ms-admin',$data);
    }

    /**Admin form reset admin_front_form_reset_password temp password */
    function admin_front_form_reset_password(){
		$username = $this->input->post('username');
        $password = $this->input->post('password');
        $newPassword = $this->input->post('new-password');

        //exit('from admin module');

        $where = "(email='$username' || alternate_email = '$username') && role='0' && status='0'";
        $this->db->where($where);
        $query = $this->db->get('ms-admin');
        $count = $query->num_rows();
        if($count > 0){
            $data = array(
                'password' => $newPassword,
                'temp_password_status'  => 1,
            );
            $this->db->where($where);
            $this->db->set($data);
            $result = $this->db->update('ms-admin');
            $row = $query->row();         
            return (array)$row;
        }else{
            return false;

        }
    }
    /**Admin form reset admin_front_form_reset_password temp password END */

    /**Reset user password */
    function rest_user_pasword_foremail($email,$code){
        $data = array(
            // 'temp_password'=>'',
            'password'=>$code,
            'temp_password_status'=>0,
            'otp_time'=>date('Y-m-d H:i:s')
        );
        $this->db->where('email',$email);
        $this->db->update('ms-admin',$data);
    }

    /**Reset user password For User ID */
    function rest_user_pasword_forId($id,$code){
        $data = array(
            // 'temp_password'=>'',
            'password'=>$code,
            'temp_password_status'=>0,
            'otp_time'=>date('Y-m-d H:i:s')
        );
        $this->db->where('id',$id);
        $this->db->update('ms-admin',$data);
    }
    /**Reset user password For User ID END*/

    function check_resetcode_userid($id,$token){
        $this->db->where('id',$id);
        $this->db->where('reset_code',$token);
        $query = $this->db->get('ms-admin');
        if($query->num_rows() > 0){
            $row = (array)$query->row();
            $data = array(
                'reset_code'=>''
            );
            $this->db->where('id',$id);
            $this->db->where('reset_code',$token);
            $this->db->update('ms-admin',$data);
            return $row;
        }
    }
    function check_email_address_users($email){
        $this->db->where('email',$email);
        $query = $this->db->get('ms-admin');
        $count = $query->num_rows();
        if($count > 0){
            return 1;
        }
        else{
            return 0;
        }
    }
    function check_user_id($id){
        $this->db->where('id',$id);
        $query = $this->db->get('ms-admin');
        $count = $query->num_rows();
        if($count > 0){
            $row = (array)$query->row();
            // return 1;
            return $row;
        }
        else{
            return 0;
        }
    }
    function update_secretcode_reset_password($email){
        $code = $this->sernum();
        $data = array(
            'reset_code'=>$code
        );
        $this->db->where('email',$email);
        $this->db->update('ms-admin',$data);

        $this->db->where('email',$email);
        $query = $this->db->get('ms-admin');
        $row = (array)$query->row();
        return $row;
    }
    function sernum(){
        $template   = 'XX99-XX99-99XX-99XX-XXXX-99XX';
        $k = strlen($template);
        $sernum = '';
        for ($i=0; $i<$k; $i++)
        {
            switch($template[$i])
            {
                case 'X': $sernum .= chr(rand(65,90)); break;
                case '9': $sernum .= rand(0,9); break;
                case '-': $sernum .= '-';  break; 
            }
        }
        return $sernum;
    }
    function update_password(){
        $new_password = $this->input->post('new_password');
        $password = md5($new_password);
        $admin_id = $this->session->userdata('mes_admin_id');
        $this->db->set('password', $password);//if 2 columns
        $this->db->where('ID', $admin_id);
        $this->db->update('ms-admin');
    }
    function get_user_list($params){
        $this->db->select('*'); 
        $this->db->from('ms-admin'); 
        if(array_key_exists("where", $params)){ 
            foreach($params['where'] as $key => $val){ 
                $this->db->where($key, $val); 
            } 
        } 
        if(array_key_exists("search", $params)){ 
            $where = '(user_name LIKE "%'.$params['search'].'%" OR email LIKE "%'.$params['search'].'%" OR full_name LIKE "%'.$params['search'].'%" OR mobile_number LIKE "%'.$params['search'].'%")';
            $this->db->where($where);
        }
        if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){ 
            $result = $this->db->count_all_results(); 
        }else{ 
            if(array_key_exists("id", $params) || (array_key_exists("returnType", $params) && $params['returnType'] == 'single')){ 
                if(!empty($params['id'])){ 
                    $this->db->where('id', $params['id']); 
                } 
                $query = $this->db->get(); 
                $result = $query->row_array(); 
            }else{ 
                if(array_key_exists("plugin_version", $params)){
                    $this->db->order_by('ABS(version_number)', $params['plugin_version']); 
                }
                else{
                    $this->db->order_by('id', 'desc'); 
                }
                if(array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
                    $this->db->limit($params['limit'],$params['start']); 
                }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
                    $this->db->limit($params['limit']); 
                } 
                $query = $this->db->get(); 
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE; 
            } 
        } 
        // Return fetched data 
        return $result; 
    }
    function get_all_booking_detail_list($params = array()){
        $dates = $this->get_dates_list_booking();
        $indate = '';
        $where = 'WHERE 1=1';
        $limit = '';
        if(!empty($dates)){
            foreach($dates as $key => $date){
                
                // $where .= " AND  B$key.booking_date = '".$date['date']."' AND B$key.booking_status = 'booked'";
            }
        }
        if(array_key_exists("book_status",$params)){
            $book_status = $params['book_status'];
            if(!empty($dates)){
                if($book_status == 'Partial'){
                    $indate .= ' INNER JOIN `ms-booking-list` AS BZ ON BZ.booking_id = M.id ';
                    $or = '(';
                }
                foreach($dates as $key => $date){
                    if($book_status == 'Completed'){
                        $indate .= ' INNER JOIN `ms-booking-list` AS B'.$key.' ON B'.$key.'.booking_id = M.id ';
                        $where .= " AND  B$key.booking_date = '".$date['date']."' AND B$key.booking_status = 'booked'";
                    }
                    else if($book_status == 'Partial'){
                        $or .= " BZ.booking_date = '".$date['date']."' AND (BZ.booking_status = 'skip' OR BZ.booking_status = 'cancel') OR ";
                    }
                }
                if($book_status == 'Partial'){
                    $or = rtrim($or, "OR ");
                    $or .= ')';
                    $where .= " AND $or";
                }
            }
        }
        if(array_key_exists("from_date",$params) && array_key_exists("to_date",$params)){ 
            $from_date = date('Y-m-d',strtotime($params['from_date']));
            $to_date = date('Y-m-d',strtotime($params['to_date']));
            $where .= " AND  (DATE(M.booking_time) BETWEEN '".$from_date."' AND '".$to_date."')";
        }
        if(array_key_exists("keyword",$params)){
            $indate .= ' INNER JOIN `ms-admin` AS U ON U.id = M.user_id ';
            $where .= " AND  (U.full_name LIKE '%".$params['keyword']."%' OR U.email LIKE '%".$params['keyword']."%' OR U.alternate_email LIKE '%".$params['keyword']."%')";
        }
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
            $limit = ' LIMIT '.$params['limit'].','.$params['start']; 
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
            $limit = ' LIMIT '.$params['limit']; 
        } 
        $query = $this->db->query("SELECT M.* From `ms-booking` AS M $indate $where GROUP BY M.id ORDER BY M.modify_date DESC $limit");
        return $query->result_array();
    }
    function get_master_modification_logs($params = array()){
        $dates = $this->get_dates_list_booking();
        $where = 'WHERE 1=1';
        $limit = '';
        if(array_key_exists("from_date",$params) && array_key_exists("to_date",$params)){ 
            $from_date = date('Y-m-d',strtotime($params['from_date']));
            $to_date = date('Y-m-d',strtotime($params['to_date']));
            $where .= " AND  (DATE(M.timestamp) BETWEEN '".$from_date."' AND '".$to_date."')";
        }
        if(array_key_exists("keyword",$params)){
            $where .= " AND  (M.action LIKE '%".$params['keyword']."%' OR M.added_by LIKE '%".$params['keyword']."%' OR M.by_email LIKE '%".$params['keyword']."%' OR M.for_user LIKE '%".$params['keyword']."%' OR M.to_user LIKE '%".$params['keyword']."%' OR M.restaurant_name LIKE '%".$params['keyword']."%')";
        }
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
            $limit = ' LIMIT '.$params['limit'].','.$params['start']; 
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
            $limit = ' LIMIT '.$params['limit']; 
        } 
        $filedsToget = '*';
        if(array_key_exists("selected_fields",$params)){
            $filedsToget = $params['selected_fields'];
            // $test = 'timestamp,booking_id';
            // exit($test);
            $query = $this->db->query("SELECT M.$filedsToget From `ms-booking-logs` AS M $where ORDER BY M.timestamp DESC $limit");

        }else{
            $query = $this->db->query("SELECT M.* From `ms-booking-logs` AS M $where ORDER BY M.timestamp DESC $limit");
        }
        return $query->result_array();
    }
    function get_master_booking_list($params = array()){
        $dates = $this->get_dates_list_booking();
        $indate = '';
        $where = 'WHERE 1=1 AND M.role=1';
        $limit = '';
        if(array_key_exists("book_status",$params)){
            $book_status = $params['book_status'];
            if(!empty($dates)){
                if($book_status == 'Partial'){
                    $indate .= ' INNER JOIN `ms-booking-list` AS BZ ON BZ.user_id = M.id ';
                    $or = '(';
                }
                foreach($dates as $key => $date){
                    if($book_status == 'Completed'){
                        $indate .= ' INNER JOIN `ms-booking-list` AS B'.$key.' ON B'.$key.'.user_id = M.id ';
                        $where .= " AND  B$key.booking_date = '".$date['date']."' AND B$key.booking_status = 'booked'";
                    }
                    else if($book_status == 'Partial'){
                        $or .= " BZ.booking_date = '".$date['date']."' AND (BZ.booking_status = 'skip' OR BZ.booking_status = 'cancel') OR ";
                    }
                }
                if($book_status == 'Partial'){
                    $or = rtrim($or, "OR ");
                    $or .= ')';
                    $where .= " AND $or";
                }
            }
            if($book_status == 'No Response'){
                $where .= ' AND M.id NOT IN (SELECT BU.user_id FROM `ms-booking-list` AS BU)';
            }
        }
        if(array_key_exists("from_date",$params) && array_key_exists("to_date",$params)){ 
            $from_date = date('Y-m-d',strtotime($params['from_date']));
            $to_date = date('Y-m-d',strtotime($params['to_date']));
            $indate .= ' INNER JOIN `ms-booking` AS B ON B.user_id = M.id ';
            $where .= " AND  (DATE(B.booking_time) BETWEEN '".$from_date."' AND '".$to_date."')";
        }
        if(array_key_exists("keyword",$params)){
            $where .= " AND  (M.full_name LIKE '%".$params['keyword']."%' OR M.email LIKE '%".$params['keyword']."%' OR M.alternate_email LIKE '%".$params['keyword']."%')";
        }
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
            $limit = ' LIMIT '.$params['start'].','.$params['limit']; 
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
            $limit = ' LIMIT '.$params['limit']; 
        } 
        $query = $this->db->query("SELECT M.* From `ms-admin` AS M $indate $where GROUP BY M.id $limit");
        return $query->result_array();
    }
	function get_report_generate_list($params = array()){
		$dates = $params['select_days'];
        $default_dates = $this->get_dates_list_booking();
		$attend_type = $params['sel_attend_type'];
		$status = $params['booking_status'];
		$property_type = $params['sel_property_type'];
		$restaurants = $params['restaurants'];
		$indate = '';
		$where = 'WHERE 1=1 AND M.role=1';
        $limit = '';
		if(!empty($dates)){
            $orin = [];
            foreach ($dates as $key => $date) {
                $indate .= ' INNER JOIN `ms-booking-list` AS B'.$key.' ON B'.$key.'.user_id = M.id ';
                $orin[$key] = '( ';
                $orin[$key] .= " B$key.booking_date = '".$date."'";
                if (count($attend_type) == 1){
                    if($attend_type[0] == 'guest'){
                        $orin[$key] .= " AND B$key.ref_id > 0";
                    }
                    if($attend_type[0] == 'host'){
                        $orin[$key] .= " AND B$key.ref_id = 0";
                    }
                }
                if(!empty($status)){
					$statusin = [];
					foreach($status as $val){
						$statusin[] = " B$key.booking_status = '$val'";
					}
                    $orin[$key] .= " AND (".implode(' OR ',$statusin).")";
                }
                $orin[$key] .= ' )';
            }
            $implode = implode(' OR ',$orin);
            $where .= " AND  ($implode)";
        }
        // if(!empty($status)){
        //     if (count($status) == 1){
        //             $indate .= ' INNER JOIN `ms-booking` AS MB ON MB.user_id = M.id ';
        //             $where .= " AND  MB.booking_status = '".$status[0]."'";
        //     }
        // }
        if(!empty($restaurants)){
            $indate .= ' INNER JOIN `ms-booking-list` AS R ON R.user_id = M.id ';
                    $where .= " AND  R.booking_restid IN (".implode(',',$restaurants).")";
        }
        if(!empty($property_type)){
            $indate .= ' INNER JOIN `ms-booking-list` AS RM ON RM.user_id = M.id ';
            $indate .= ' INNER JOIN `ms-restaurant` AS RS ON RS.id = RM.booking_restid ';
            $restor = [];
            if(in_array('on',$property_type)){
                $restor[] = "RS.property_type = 'on'";
            }
            if(in_array('off',$property_type)){
                $restor[] = "RS.property_type = 'off'";
            }
            $implode = implode(' OR ',$restor);
                    $where .= " AND  ($implode)";
        }
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
            $limit = ' LIMIT '.$params['start'].','.$params['limit']; 
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
            $limit = ' LIMIT '.$params['limit']; 
        } 
        $query = $this->db->query("SELECT M.* From `ms-admin` AS M $indate $where GROUP BY M.id $limit");
        return $query->result_array();
	}
    function get_admin_detail_byadminid($user_id){
        $this->db->where('id',$user_id);
        $this->db->where('role','0');
        $query = $this->db->get('ms-admin');
        return (array)$query->row();
    }
    function get_admin_list($params){
        $this->db->select('*'); 
        $this->db->from('ms-admin'); 
        if(array_key_exists("where", $params)){ 
            foreach($params['where'] as $key => $val){ 
                $this->db->where($key, $val); 
            } 
        } 
        if(array_key_exists("search", $params)){ 
            $where = '(user_name LIKE "%'.$params['search'].'%" OR email LIKE "%'.$params['search'].'%" OR full_name LIKE "%'.$params['search'].'%" OR mobile_number LIKE "%'.$params['search'].'%")';
            $this->db->where($where);
        }
        if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){ 
            $result = $this->db->count_all_results(); 
        }else{ 
            if(array_key_exists("id", $params) || (array_key_exists("returnType", $params) && $params['returnType'] == 'single')){ 
                if(!empty($params['id'])){ 
                    $this->db->where('id', $params['id']); 
                } 
                $query = $this->db->get(); 
                $result = $query->row_array(); 
            }else{ 
                if(array_key_exists("plugin_version", $params)){
                    $this->db->order_by('ABS(version_number)', $params['plugin_version']); 
                }
                else{
                    $this->db->order_by('id', 'desc'); 
                }
                if(array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
                    $this->db->limit($params['limit'],$params['start']); 
                }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
                    $this->db->limit($params['limit']); 
                } 
                $query = $this->db->get(); 
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE; 
            } 
        } 
        // Return fetched data 
        return $result; 
    }

    function getRestaurantIsbooked($rest_id){
        $this->db->where('booking_restid',$rest_id);
        $query=$this->db->get('ms-booking-list');
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }

    }

    function get_restaurant_list($params){
        $this->db->select('*'); 
        $this->db->from('ms-restaurant'); 
        $this->db->where('is_deleted', '0'); 
        if(array_key_exists("where", $params)){ 
            foreach($params['where'] as $key => $val){ 
                $this->db->where($key, $val); 
            } 
        } 
        if(array_key_exists("search", $params)){ 
            $where = '(restaurant_name LIKE "%'.$params['search'].'%" OR email LIKE "%'.$params['search'].'%" OR description LIKE "%'.$params['search'].'%" OR address LIKE "%'.$params['search'].'%")';
            $this->db->where($where);
        }
        if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){ 
            $result = $this->db->count_all_results(); 
        }else{ 
            if(array_key_exists("id", $params) || (array_key_exists("returnType", $params) && $params['returnType'] == 'single')){ 
                if(!empty($params['id'])){ 
                    $this->db->where('id', $params['id']); 
                } 
                $query = $this->db->get(); 
                $result = $query->row_array(); 
            }else{ 
                if(array_key_exists("plugin_version", $params)){
                    $this->db->order_by('ABS(version_number)', $params['plugin_version']); 
                }
                else{
                    $this->db->order_by('restaurant_name', 'ASC'); 
                }
                if(array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
                    $this->db->limit($params['limit'],$params['start']); 
                }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
                    $this->db->limit($params['limit']); 
                } 
                $query = $this->db->get(); 
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE; 
            } 
        } 
        // Return fetched data 
        return $result; 
    }


    /**
     * Insert OTP record
     */
    function insert_otp_for_send_credit_card_details($code){

        /**
         * First check if reqiester id is already exists, if exists then update OTP and set OTP status to False
         * And if not then insert new record
         */

        $this->db->where('requester_admin_id', $this->session->userdata('mes_admin_id'));
        $query = $this->db->get('ms-otp-for-send-creditcard-details');
        $result = $query->result_array();
        if(!empty($result)){
            $data = array(
                'otp' => $code,
                'otp_status' => FALSE
            );
            $this->db->where('requester_admin_id',$this->session->userdata('mes_admin_id'));
            $this->db->update('ms-otp-for-send-creditcard-details',$data);
        }else{
            $data = array(
                'otp' => $code,
                'otp_status' => FALSE,
                'requester_admin_id' => $this->session->userdata('mes_admin_id')
            );
            $this->db->insert('ms-otp-for-send-creditcard-details',$data);
        }
        return true;
    }

    /**
     * Verify Credit card info send OTP
     */
    function verify_otp_for_send_credit_card_info($otp){
        $conditions = array(
            'requester_admin_id' => $this->session->userdata('mes_admin_id'),
            'otp' => $otp,
            'otp_status' => FALSE // Ensure otp_status is false
        );
        $this->db->where($conditions);
        $query = $this->db->get('ms-otp-for-send-creditcard-details');
        $result = $query->result_array();

        if(!empty($result)){
            $data = array(
                'otp_status' => TRUE
            );
            $this->db->where('requester_admin_id',$this->session->userdata('mes_admin_id'));
            $this->db->update('ms-otp-for-send-creditcard-details',$data);
            return true;
        }else{
            return false;
        }

    }

    /**
     * Verify Update admin settings OTP
     */
    function verify_otp_for_admin_settings($otp){
        $conditions = array(
            'requester_admin_id' => $this->session->userdata('mes_admin_id'),
            'otp' => $otp,
            'otp_status' => FALSE // Ensure otp_status is false
        );
        $this->db->where($conditions);
        $query = $this->db->get('ms-otp_for_update_admin_settings');
        $result = $query->result_array();

        if(!empty($result)){
            $data = array(
                'otp_status' => TRUE
            );
            $this->db->where('requester_admin_id',$this->session->userdata('mes_admin_id'));
            $this->db->update('ms-otp_for_update_admin_settings',$data);
            return true;
        }else{
            return false;
        }

    }


    /**
     * Insert OTP record for Update admin settings
     */
    function insert_otp_for_update_admin_settings($code){

        /**
         * First check if reqiester id is already exists, if exists then update OTP and set OTP status to False
         * And if not then insert new record
         */

        $this->db->where('requester_admin_id', $this->session->userdata('mes_admin_id'));
        $query = $this->db->get('ms-otp_for_update_admin_settings');
        $result = $query->result_array();
        if(!empty($result)){
            $data = array(
                'otp' => $code,
                'otp_status' => FALSE
            );
            $this->db->where('requester_admin_id',$this->session->userdata('mes_admin_id'));
            $this->db->update('ms-otp_for_update_admin_settings',$data);
        }else{
            $data = array(
                'otp' => $code,
                'otp_status' => FALSE,
                'requester_admin_id' => $this->session->userdata('mes_admin_id')
            );
            $this->db->insert('ms-otp_for_update_admin_settings',$data);
        }
        return true;
    }

    /**
     * Verify Update admin settings OTP
     */
    function verify_otp_for_update_admin_settings($otp){
        $conditions = array(
            'requester_admin_id' => $this->session->userdata('mes_admin_id'),
            'otp' => $otp,
            'otp_status' => FALSE // Ensure otp_status is false
        );
        $this->db->where($conditions);
        $query = $this->db->get('ms-otp_for_update_admin_settings');
        $result = $query->result_array();

        if(!empty($result)){
            $data = array(
                'otp_status' => TRUE
            );
            $this->db->where('requester_admin_id',$this->session->userdata('mes_admin_id'));
            $this->db->update('ms-otp_for_update_admin_settings',$data);
            return true;
        }else{
            return false;
        }

    }

    public function save_token($user_id, $token) {
        // Check if a token already exists for this user
        $this->db->where('user_id', $user_id);
        $existing_token = $this->db->get('ms-user_tokens')->row_array();

        if ($existing_token) {
            // Update existing token
            $this->db->where('user_id', $user_id);
            $this->db->update('ms-user_tokens', array('token' => $token, 'created_at' => date('Y-m-d H:i:s')));
        } else {
            // Insert new token
            $this->db->insert('ms-user_tokens', array('user_id' => $user_id, 'token' => $token, 'created_at' => date('Y-m-d H:i:s')));
        }
    }

    public function get_user_by_token($token) {
        $this->db->select('ms-admin.*');
        $this->db->from('ms-admin');
        $this->db->join('ms-user_tokens', 'ms-user_tokens.user_id = ms-admin.id');
        $this->db->where('ms-user_tokens.token', $token);
        $query = $this->db->get();
        return $query->row_array();
    }

    function insert_admin(){
        $first_name = $this->input->post('admin_fname');
        $last_name = $this->input->post('admin_lname');
        $full_name = $first_name.' '.$last_name;
        $user_name = $first_name.'_'.$last_name;
        $admin_email = $this->input->post('admin_email');
        $mobile_number = $this->input->post('contact_number');
        $count = $this->check_email_already_exist_rolewise($admin_email,'tersre@asfdassd.sdf',0);
        if($count <= 0){
            $temp_password = $this->admin_model->random_strings(8);
            $data = array(
                'user_name' => $user_name,
                'full_name' => $full_name,
                'email' => $admin_email,
                'mobile_number' => $mobile_number,
                'password' => $temp_password,
                'temp_password_status' => 0,
                'status' => 0,
                'role' => 0,
                'notifications' => 'admin_reservation_received,admin_canceled_reservation,admin_modification_reservation'
            );
            $this->db->insert('ms-admin',$data);
            return $data;
        }else{
            return [];
        }
    }
    function theme_setting(){
        $query = $this->db->get('ms-setting');
        $result = $query->result_array();
        $return = [];
        if(!empty($result)){
            foreach($result as $key => $value){
                $return[$value['meta_key']] = $value['meta_value'];
            }
        }
        return $return;
    }
    function update_theme_setting(){
        $post = $this->input->post();
        if (!isset($post['restaurant_address_hide'])) { $post['restaurant_address_hide'] = ''; }
        if (!isset($post['restaurant_contact_hide'])) { $post['restaurant_contact_hide'] = ''; }
        if (!isset($post['restaurant_fee_hide'])) { $post['restaurant_fee_hide'] = ''; }
        if (!isset($post['restaurant_establishment_hide'])) { $post['restaurant_establishment_hide'] = ''; }
        if (!isset($post['restaurant_meals_hide'])) { $post['restaurant_meals_hide'] = ''; }
        if (!isset($post['restaurant_website_url_hide'])) { $post['restaurant_website_url_hide'] = ''; }
        if (!isset($post['restaurant_location_hide'])) { $post['restaurant_location_hide'] = ''; }
        if (!isset($post['restaurant_email_hide'])) { $post['restaurant_email_hide'] = ''; }
        if($_FILES['theme_logo']['name'] != ''){
            $config['upload_path']="./uploads/assets/images";
            $config['allowed_types']='gif|jpg|png';
            $config['encrypt_name'] = TRUE;
            $image='';
            $this->load->library('upload',$config);
            $category= $this->input->post('table_text_slug');
            if($this->upload->do_upload("theme_logo")){
                $data = array('upload_data' => $this->upload->data());
                $image= $data['upload_data']['file_name']; 
                $this->db->where('meta_key','theme_logo');
                $data1 = array('meta_value'=>$image);
                $this->db->update('ms-setting',$data1);
            }
        }
   
        foreach($post as $key => $meta){
            if($key =="admin_skip_resons"){
                $serializedReasonsData = serialize($post[$key]);
                $this->db->where('meta_key',$key);
                $data1 = array('meta_value'=>$serializedReasonsData);
                $this->db->update('ms-setting',$data1);
            }
            else if($key == 'booking_end_date'){
                if($post[$key] != ''){
                    $dateObj = DateTime::createFromFormat('m-d-Y', $post[$key]);
                    $date = $dateObj->format('Y-m-d');
                    $this->db->where('meta_key',$key);
                    $data1 = array('meta_value'=>$date);
                    $this->db->update('ms-setting',$data1);
                }
            }
            else if($key == 'modify_end_date'){
                if($post[$key] != ''){
                    $dateObj = DateTime::createFromFormat('m-d-Y', $post[$key]);
                    $date = $dateObj->format('Y-m-d');
                    $this->db->where('meta_key',$key);
                    $data1 = array('meta_value'=>$date);
                    $this->db->update('ms-setting',$data1);
                }
            }
            else if($key == 'cancel_date'){
                if($post[$key] != ''){
                    $dateObj = DateTime::createFromFormat('m-d-Y', $post[$key]);
                    $date = $dateObj->format('Y-m-d');
                    $this->db->where('meta_key',$key);
                    $data1 = array('meta_value'=>$date);
                    $this->db->update('ms-setting',$data1);
                }
            }
            else{
                $this->db->where('meta_key',$key);
                $data1 = array('meta_value'=>$post[$key]);
                $this->db->update('ms-setting',$data1);
            }

        }
    }
    /**Reset User Password */
    // function reset_user_password($id){
    //     $data = array(
    //         'id'=> $id
    //     );
    //     //return true;
    //     return 0;
    //     //exit($id.'===from model');
    // }
    function update_user($id){
        $first_name = $this->input->post('admin_fname');
        $last_name = $this->input->post('admin_lname');
        $user_code = $this->input->post('user_code');
        $full_name = $first_name.' '.$last_name;
        $user_name = $first_name.'_'.$last_name;
        $admin_email = $this->input->post('admin_email');
        $admin_alternate_email = $this->input->post('admin_alternate_email');
        $mobile_number = $this->input->post('contact_number');
        $where ="(id != $id AND role = '1' AND (email = '$admin_email' OR alternate_email = '$admin_email' OR ('$admin_alternate_email' != '' AND (email = '$admin_alternate_email'  OR alternate_email = '$admin_alternate_email')) ))";
        $this->db->where($where);
        $query = $this->db->get('ms-admin');
        $count = $query->num_rows();
        if($count > 0){
            return 0;
        }
        $data = array(
            'user_name' => $user_name,
            'full_name' => $full_name,
            'email' => $admin_email,
            'user_code' => $user_code,
            'alternate_email' => $admin_alternate_email,
            'mobile_number' => $mobile_number,
            'status' => 0,
        );
        $this->db->where('id',$id);
        $this->db->update('ms-admin',$data);
        return $data;
    }
    function update_admin($id){
        $first_name = $this->input->post('admin_fname');
        $last_name = $this->input->post('admin_lname');
        $user_code = $this->input->post('user_code');
        $full_name = $first_name.' '.$last_name;
        $user_name = $first_name.'_'.$last_name;
        $admin_email = $this->input->post('admin_email');
        $admin_alternate_email = $this->input->post('admin_alternate_email');
        $mobile_number = $this->input->post('contact_number');
        $where ="(id != $id AND role = '0' AND (email = '$admin_email' OR alternate_email = '$admin_email' OR ('$admin_alternate_email' != '' AND (email = '$admin_alternate_email'  OR alternate_email = '$admin_alternate_email')) ))";
        $this->db->where($where);
        $query = $this->db->get('ms-admin');
        $count = $query->num_rows();
        if($count > 0){
            return 0;
        }
        $data = array(
            'user_name' => $user_name,
            'full_name' => $full_name,
            'email' => $admin_email,
            'user_code' => $user_code,
            'alternate_email' => $admin_alternate_email,
            'mobile_number' => $mobile_number,
            'status' => 0,
        );
        $this->db->where('id',$id);
        $this->db->update('ms-admin',$data);
        return $data;
    }
    function update_email_notification(){
        $noti = $this->input->post('email_notification');
        $user_id = $this->session->userdata('mes_admin_id');
        if(!empty($noti)){
            $imp = implode(',',$noti);
        }
        else{
            $imp = '';
        }
        $data = array(
            'notifications'=>$imp
        );
        $this->db->where('id',$user_id);
        $this->db->update('ms-admin',$data);
    }
    function insert_user(){
        $first_name = $this->input->post('admin_fname');
        $last_name = $this->input->post('admin_lname');
        $user_code = $this->input->post('user_code');
        $full_name = $first_name.' '.$last_name;
        $user_name = $first_name.'_'.$last_name;
        $admin_email = $this->input->post('admin_email');
        $admin_alternate_email = $this->input->post('admin_alternate_email');
        if($admin_alternate_email == ''){
            $adminemail = 'adsdgsdsdfsd@itityusdfgsd.com';
        }
        else{
            $adminemail = $admin_alternate_email;
        }
        $mobile_number = $this->input->post('contact_number');
        $count = $this->check_email_already_exist_rolewise($admin_email,$adminemail,1);
        if($count <= 0){
            $temp_password = $this->admin_model->random_strings(8);
            $data = array(
                'user_name' => $user_name,
                'full_name' => $full_name,
                'email' => $admin_email,
                'user_code' => $user_code,
                'password' => $temp_password,
                'temp_password_status' => 0,
                'alternate_email' => $admin_alternate_email,
                'mobile_number' => $mobile_number,
                'status' => 0,
                'role' => 1,
            );
            $this->db->insert('ms-admin',$data);
            return $data;
        }
        else{
            return [];
        }
    }
    function delete_bulk_users($user_ids){
        if(!empty($user_ids)){
            foreach($user_ids as $userid){
                $this->db->where('id',$userid);
                $this->db->delete('ms-admin');
            }
        }
    }
    function insert_restaurant(){
        $restaurants_name = $this->input->post('restaurants_name');
        $website_link = $this->input->post('website_link');
        $location_link = $this->input->post('location_link');
        $contact_number = $this->input->post('contact_number');
        $restaurants_code = $this->input->post('restaurants_code');
        $email = $this->input->post('email');
        $description = $this->input->post('description');
        $address = $this->input->post('address');
        $deposit = $this->input->post('deposit');
        $amount = $this->input->post('amount');
        $editor1 = $this->input->post('editor1');
        $property_type = $this->input->post('property_type');
        $filter_type = $this->input->post('filter_type');
        $hide_menu_images = $this->input->post('hide_menu_images');
        $hide_feature_image = $this->input->post('hide_feature_image');
        $hide_gallery = $this->input->post('hide_gallery');
        $review_photo = $this->input->post('review_photo');
        $review_name = $this->input->post('hide_review_name');
        $review_date = $this->input->post('hide_review_date');
        $review_rating = $this->input->post('hide_review_rating');
        $review_description = $this->input->post('hide_review_description');
        // $filters = serialize($filter_type);
        $config['upload_path']="./uploads/assets/images";
        $config['allowed_types']='jpg|jpeg|png|gif|webp';
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload',$config);
        $this->upload->initialize($config);
        $ImageCount = count($_FILES['menu_images']['name']);
        $menu_images = [];
        for($i = 0; $i < $ImageCount; $i++){
            $_FILES['file']['name']       = $_FILES['menu_images']['name'][$i];
            $_FILES['file']['type']       = $_FILES['menu_images']['type'][$i];
            $_FILES['file']['tmp_name']   = $_FILES['menu_images']['tmp_name'][$i];
            $_FILES['file']['error']      = $_FILES['menu_images']['error'][$i];
            $_FILES['file']['size']       = $_FILES['menu_images']['size'][$i];
            if($this->upload->do_upload('file')){
                $imageData = $this->upload->data();
                $menu_images[$i] = $imageData['file_name'];
            }
        }
        $menu_images = implode(',',$menu_images);
        $ImageCount = count($_FILES['feature_images']['name']);
        $feature_images = [];
        for($i = 0; $i < $ImageCount; $i++){
            $_FILES['file']['name']       = $_FILES['feature_images']['name'][$i];
            $_FILES['file']['type']       = $_FILES['feature_images']['type'][$i];
            $_FILES['file']['tmp_name']   = $_FILES['feature_images']['tmp_name'][$i];
            $_FILES['file']['error']      = $_FILES['feature_images']['error'][$i];
            $_FILES['file']['size']       = $_FILES['feature_images']['size'][$i];
            if($this->upload->do_upload('file')){
                $imageData = $this->upload->data();
                $feature_images[$i] = $imageData['file_name'];
            }
        }
        $feature_images = implode(',',$feature_images);
        $ImageCount = count($_FILES['gallery_images']['name']);
        $gallery_images = [];
        for($i = 0; $i < $ImageCount; $i++){
            $_FILES['file']['name']       = $_FILES['gallery_images']['name'][$i];
            $_FILES['file']['type']       = $_FILES['gallery_images']['type'][$i];
            $_FILES['file']['tmp_name']   = $_FILES['gallery_images']['tmp_name'][$i];
            $_FILES['file']['error']      = $_FILES['gallery_images']['error'][$i];
            $_FILES['file']['size']       = $_FILES['gallery_images']['size'][$i];
            if($this->upload->do_upload('file')){
                $imageData = $this->upload->data();
                $gallery_images[$i] = $imageData['file_name'];
            }
        }
        $gallery_images = implode(',',$gallery_images);
        $data = array(
            'restaurant_name'=>$restaurants_name,
            'website_link'=>$website_link,
            'restaurant_code'=>$restaurants_code,
            'property_type'=>$property_type,
            'location_link'=>$location_link,
            'contact'=>$contact_number,
            'email'=>$email,
            'description'=>$description,
            'full_content'=>$editor1,
            'address'=>$address,
            'deposite'=>$deposit,
            'deposite_amount'=>$amount,
            'menu_images'=>$menu_images,
            'feature_image'=>$feature_images,
            'gallery'=>$gallery_images,
        );
        $this->db->insert('ms-restaurant',$data);
        $rest_id = $this->db->insert_id();

        if(!empty($filter_type)){
            foreach($filter_type as $key => $fil){
                if(!empty($fil)){
                    foreach($fil as $val){
                        $dt = array(
                            'rest_id'=>$rest_id,
                            'filter_type'=>$key,
                            'filter_value'=>$val
                        );
                        $this->db->insert('ms-restaurant-filters',$dt);
                    }
                }
            }
        }

        $tableli_time = $this->input->post('tableli_time');
        $tableli_date = $this->input->post('tableli_date');
        $tableli_size = $this->input->post('tableli_size');
        $tableli_capacity = $this->input->post('tableli_capacity');
        if(!empty($tableli_date)){
            foreach($tableli_date as $key => $val){
                if($tableli_date[$key] != ''){
                    $exp = explode('-',$tableli_date[$key]);
                    $tbldate = $exp[1].'-'.$exp[0].'-'.$exp[2];
                    $data1 = array(
                        'restaurant_id'=>$rest_id,
                        'time'=>$tableli_time[$key],
                        'date'=>date('Y-m-d',strtotime($tbldate)),
                        'size'=>$tableli_size[$key],
                        'capacity'=>$tableli_capacity[$key],
                    );
                    $this->db->insert('ms-restaurant-tables',$data1);
                }
            }
        }

        if(!empty($review_name)){
            foreach($review_name as $key => $val){
                if($val != ''){
                    $filename = '';
                    if($review_photo[$key] != ''){
                            if (strpos($review_photo[$key], 'base64,') !== false) { 
                            $exp = explode('base64,',$review_photo[$key]);
                            $image = base64_decode($exp[1]);
                            $image_name = md5(uniqid(rand(), true));
                            $filename = $image_name . '.' . 'jpeg';
                            $path = FCPATH.'uploads/assets/images/';
                            file_put_contents($path . $filename, $image);
                        }
                        else{
                            $filename = $review_photo[$key];
                        }
                    }
                    $data3 = array(
                        'restaurant_id'=>$rest_id,
                        'person_pic'=>$filename,
                        'person_name'=>$review_name[$key],
                        'rating'=>$review_rating[$key],
                        'description'=>$review_description[$key],
                        'review_date'=>date('Y-m-d',strtotime($review_date[$key])),
                    );
                    $this->db->insert('ms-restaurant-reviews',$data3);
                }
            }
        }
    }
    function insert_filter(){
        $filter_name = $this->input->post('filter_name');
        $filter_value = $this->input->post('filter_value');
        $filter_name_uniq = array_unique($filter_name);
        $filter_array = [];
        if(!empty($filter_name_uniq)){
            foreach($filter_name_uniq as $type){
                foreach($filter_name as $key => $fname){
                    if($type == $fname){
                        $filter_array[$type][]=$filter_value[$key];
                    }
                }
            }
        }
        if(!empty($filter_array)){
            foreach($filter_array as $type => $type_array){
                $count = $this->count_filter_type($type);
                if($count > 0){
                    $insert_val = $this->get_filter_type_value($type);
                    $exp = explode(',',$insert_val);
                    $merge = array_filter(array_unique(array_merge($exp,$type_array)));
                    $implode = implode(',',$merge);
                    $data = array(
                        'filter_value'=>$implode,
                    );
                    $this->db->where('filter_name',$type);
                    $this->db->update('ms-filter',$data);
                }
                else{
                    $value = implode(',',$type_array);
                    $data = array(
                        'filter_name'=>$type,
                        'filter_value'=>$value,
                    );
                    $this->db->insert('ms-filter',$data);
                }
            } 
        }
    }
    function remove_filter_permanent($filter_id){
        $this->db->where('id',$filter_id);
        $query = $this->db->get('ms-filter');
        $filter_name = $query->row()->filter_name;
        
        $this->db->where('filter_type',$filter_name);
        $this->db->delete('ms-restaurant-filters');

        $this->db->where('id',$filter_id);
        $this->db->delete('ms-filter');
    }
    function update_restaurant(){
        $rest_id = $this->input->post('rest_id');
        $restaurants_name = $this->input->post('restaurants_name');
        $website_link = $this->input->post('website_link');
        $location_link = $this->input->post('location_link');
        $contact_number = $this->input->post('contact_number');
        $restaurants_code = $this->input->post('restaurants_code');
        $email = $this->input->post('email');
        $description = $this->input->post('description');
        $address = $this->input->post('address');
        $deposit = $this->input->post('deposit');
        $amount = $this->input->post('amount');
        $editor1 = $this->input->post('editor1');
        $property_type = $this->input->post('property_type');
        $filter_type = $this->input->post('filter_type');
        $hide_menu_images = $this->input->post('hide_menu_images');
        $hide_feature_image = $this->input->post('hide_feature_image');
        $hide_gallery = $this->input->post('hide_gallery');
        $review_photo = $this->input->post('review_photo');
        $review_name = $this->input->post('hide_review_name');
        $review_date = $this->input->post('hide_review_date');
        $review_rating = $this->input->post('hide_review_rating');
        $review_description = $this->input->post('hide_review_description');
        // $filters = serialize($filter_type);
        $config['upload_path']="./uploads/assets/images";
        $config['allowed_types']='jpg|jpeg|png|gif|webp';
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload',$config);
        $this->upload->initialize($config);
        $ImageCount = count($_FILES['menu_images']['name']);
        $menu_images = [];
        for($i = 0; $i < $ImageCount; $i++){
            $_FILES['file']['name']       = $_FILES['menu_images']['name'][$i];
            $_FILES['file']['type']       = $_FILES['menu_images']['type'][$i];
            $_FILES['file']['tmp_name']   = $_FILES['menu_images']['tmp_name'][$i];
            $_FILES['file']['error']      = $_FILES['menu_images']['error'][$i];
            $_FILES['file']['size']       = $_FILES['menu_images']['size'][$i];
            if($this->upload->do_upload('file')){
                $imageData = $this->upload->data();
                $menu_images[$i] = $imageData['file_name'];
            }
        }
        if(!empty($hide_menu_images)){
        $menu_images = array_merge($menu_images,$hide_menu_images);
        }
        $menu_images = implode(',',$menu_images);
        if (!empty($_FILES['feature_images']['name'])) {
            if($this->upload->do_upload('feature_images')){
                $imageData = $this->upload->data();
                $feature_images = $imageData['file_name'];
            }
            else{
                $feature_images = $hide_feature_image;
            }
        }
        else{
            $feature_images = $hide_feature_image;
        }
        $ImageCount = count($_FILES['gallery_images']['name']);
        $gallery_images = [];
        for($i = 0; $i < $ImageCount; $i++){
            $_FILES['file']['name']       = $_FILES['gallery_images']['name'][$i];
            $_FILES['file']['type']       = $_FILES['gallery_images']['type'][$i];
            $_FILES['file']['tmp_name']   = $_FILES['gallery_images']['tmp_name'][$i];
            $_FILES['file']['error']      = $_FILES['gallery_images']['error'][$i];
            $_FILES['file']['size']       = $_FILES['gallery_images']['size'][$i];
            if($this->upload->do_upload('file')){
                $imageData = $this->upload->data();
                $gallery_images[$i] = $imageData['file_name'];
            }
        }
        if(!empty($hide_gallery)){
        $gallery_images = array_merge($gallery_images,$hide_gallery);
        }
        $gallery_images = implode(',',$gallery_images);
        $data = array(
            'restaurant_name'=>$restaurants_name,
            'website_link'=>$website_link,
            'restaurant_code'=>$restaurants_code,
            'property_type'=>$property_type,
            // 'filters'=>$filters,
            'location_link'=>$location_link,
            'contact'=>$contact_number,
            'email'=>$email,
            'description'=>$description,
            'full_content'=>$editor1,
            'address'=>$address,
            'deposite'=>$deposit,
            'deposite_amount'=>$amount,
            'menu_images'=>$menu_images,
            'feature_image'=>$feature_images,
            'gallery'=>$gallery_images,
        );
        $this->db->where('id',$rest_id);
        $this->db->update('ms-restaurant',$data);

        if(!empty($filter_type)){
            $this->db->where('rest_id',$rest_id);
            $this->db->delete('ms-restaurant-filters');
            foreach($filter_type as $key => $fil){
                if(!empty($fil)){
                    foreach($fil as $val){
                        $dt = array(
                            'rest_id'=>$rest_id,
                            'filter_type'=>$key,
                            'filter_value'=>$val
                        );
                        $this->db->insert('ms-restaurant-filters',$dt);
                    }
                }
            }
        }

        $tableli_time = $this->input->post('tableli_time');
        $tableli_date = $this->input->post('tableli_date');
        $tableli_size = $this->input->post('tableli_size');
        $tableli_capacity = $this->input->post('tableli_capacity');
        $this->db->where('restaurant_id',$rest_id);
        $this->db->delete('ms-restaurant-tables');
        if(!empty($tableli_date)){
            foreach($tableli_date as $key => $val){
                if($tableli_date[$key] != ''){
                    $exp = explode('-',$tableli_date[$key]);
                    $tbldate = $exp[1].'-'.$exp[0].'-'.$exp[2];
                    $data1 = array(
                        'restaurant_id'=>$rest_id,
                        'time'=>$tableli_time[$key],
                        'date'=>date('Y-m-d',strtotime($tbldate)),
                        'size'=>$tableli_size[$key],
                        'capacity'=>$tableli_capacity[$key],
                    );
                    $this->db->insert('ms-restaurant-tables',$data1);
                }
            }
        }

        $this->db->where('restaurant_id',$rest_id);
        $this->db->delete('ms-restaurant-reviews');
        if(!empty($review_name)){
            foreach($review_name as $key => $val){
                if($val != ''){
                    $filename = '';
                    if($review_photo[$key] != ''){
                            if (strpos($review_photo[$key], 'base64,') !== false) { 
                            $exp = explode('base64,',$review_photo[$key]);
                            $image = base64_decode($exp[1]);
                            $image_name = md5(uniqid(rand(), true));
                            $filename = $image_name . '.' . 'jpeg';
                            $path = FCPATH.'uploads/assets/images/';
                            file_put_contents($path . $filename, $image);
                        }
                        else{
                            $filename = $review_photo[$key];
                        }
                    }
                    $data3 = array(
                        'restaurant_id'=>$rest_id,
                        'person_pic'=>$filename,
                        'person_name'=>$review_name[$key],
                        'rating'=>$review_rating[$key],
                        'description'=>$review_description[$key],
                        'review_date'=>date('Y-m-d',strtotime($review_date[$key])),
                    );
                    $this->db->insert('ms-restaurant-reviews',$data3);
                }
            }
        }
    }

    function update_restaurant_slots(){
        // return array('status'=>true);
        //exit('sss');
        $rest_id = $this->input->post('rest_id');
        // return array('status'=>$rest_id);
        $tableli_time = $this->input->post('tableli_time');
        $tableli_date = $this->input->post('tableli_date');
        $tableli_size = $this->input->post('tableli_size');
        $tableli_capacity = $this->input->post('tableli_capacity');
        $this->db->where('restaurant_id',$rest_id);
        $this->db->delete('ms-restaurant-tables');
        if(!empty($tableli_date)){
            foreach($tableli_date as $key => $val){
                if($tableli_date[$key] != ''){
                    $exp = explode('-',$tableli_date[$key]);
                    $tbldate = $exp[1].'-'.$exp[0].'-'.$exp[2];
                    $data1 = array(
                        'restaurant_id'=>$rest_id,
                        'time'=>$tableli_time[$key],
                        'date'=>date('Y-m-d',strtotime($tbldate)),
                        'size'=>$tableli_size[$key],
                        'capacity'=>$tableli_capacity[$key],
                    );
                    $this->db->insert('ms-restaurant-tables',$data1);
                }
            }
            return array('status'=>true);
            //return true;
        }else{
            return array('status'=>false);
            //return false;
        }
    }

    function get_last_notification_userwise_bookid($list_id){
        $this->db->where('booking_list_id',$list_id);
        $this->db->order_by('id','DESC');
        $this->db->group_by('to_id','DESC');
        $query = $this->db->get('ms-guest-invite');
        return $query->result_array();
    }
    function get_all_bookings_by_booking_id($booking_id){
        $this->db->where(['booking_id'=>$booking_id]);
        $this->db->where('booking_restid', '');
        $query = $this->db->get('ms-booking-list');
        $reservations = $query->result_array();
        return $reservations;
    }
    function markBookedResAsCanceld($rest_id){
        $this->db->where(['booking_restid'=>$rest_id]);
        $query = $this->db->get('ms-booking-list');
        $reservations = $query->result_array();
        $cancellationReason = "Restaurant removed by Admin ".$this->session->userdata('admin_email');

        /**Approch-2 remove all slots from ms-restaurant-tables db table and make booking_restid blank in db table ms-booking-list*/
            $data = array(
                'booking_restid'=>'',
                'booking_reason'=>$cancellationReason,
                'booking_status'=>'cancel'
            );
            $this->db->where('booking_restid',$rest_id);
            $this->db->update('ms-booking-list',$data);

            $this->db->where('restaurant_id', $rest_id);
            $this->db->delete('ms-restaurant-tables');
        $results=[];           
        if(!empty($reservations)){
            foreach($reservations as $data){
                $results[$data['user_id']] = $data;
            }
        }
        /**again Approch-2 END*/
        /**Approch-2 END*/

        /**Approch-1 Mark booked reservations as canceled */


        /**Make Booked recods as Canceld */
        // foreach($bookedReservations as $bookedReservation){
        //     $cancellation = "Restaurant removed by Admin ".$this->session->userdata('admin_email');
        //     $id = $bookedReservation['id'];
        //     $user_id = $this->session->userdata('mes_user_id');
        //     $book_data = $this->get_dates_list_booking_byid($id);

        //     $book_status = 'Booking Canceled';
        //     $userdata = $this->get_user_detail_byuserid($book_data['user_id']);
        //     $hoteldata = $this->get_restaurant_detail($book_data['booking_restid']);
        //     $data = array(
        //         'timestamp'=>date('Y-m-d h:i:s'),  
        //         'booking_id'=>$book_data['booking_id'],  
        //         'action'=> $book_status,  
        //         'added_by'=>'Admin',  
        //         'by_email'=>$this->session->userdata('admin_email'),  
        //         'for_user'=>$userdata['email'],  
        //         'to_user'=>'',  
        //         'restaurant_name'=>$hoteldata['restaurant_name'],  
        //         'restaurant_date'=>date('Y-m-d',strtotime($book_data['booking_date'])),  
        //         'restaurant_time'=>$book_data['booking_time'],  
        //         'no_of_people'=>$book_data['booking_pax'],  
        //         'reason'=>$cancellation,  
        //         'admin_note	'=>'',
        //     );
        //     $this->db->insert('ms-booking-logs',$data);
    
        //     $this->modify_invited_guests_list($id);
        //     $data = array(
        //         'booking_status'=>'cancel',
        //         'ref_id'=>'0',
        //         'booking_reason'=>$cancellation,
        //         'modify_date'=>date('Y-m-d H:i:s'),
        //     );
        //     $this->db->where('id',$id);
        //     $this->db->update('ms-booking-list',$data);
        //     $book_status = $this->check_booking_status($book_data['booking_id']);
        //     $datain = array(
        //         'booking_status' => $book_status
        //     );
        //     $this->db->where('id', $book_data['booking_id']);
        //     $this->db->update('ms-booking', $datain);

        // }
        /**Make Booked recods as Canceld END*/

        /**Approch-1 Mark booked res as canceld END*/

        return $results;
        
    }

    function create_booking_baseon_invitebyadmin($from_id,$to_id,$list_data){
        $this->db->where('user_id',$to_id);
        $this->db->where('booking_date',$list_data['booking_date']);
        $query = $this->db->get('ms-booking-list');
        $guests = $list_data['guests'];
        if($guests != ''){
            $exp = explode(',',$guests);
            array_push($exp,$to_id);
            $guests = implode(',',$exp);
        }
        else{
            $guests = $to_id;
        }
        if($query->num_rows() > 0){
            
            $book_status = 'Booking Modify';
            $row = (array)$query->row();
            $booking_id = $row['booking_id'];
            if($row['ref_id'] == $list_data['id']){
                return 1;
            }
            $this->modify_invited_guests_list($row['id']);
            $data = array(
                'booking_date'=>$list_data['booking_date'],
                'booking_time'=>$list_data['booking_time'],
                'booking_pax'=>$list_data['booking_pax'],
                'booking_restid'=>$list_data['booking_restid'],
                'booking_status'=>'booked',
                'booking_reason'=>'',
                'booking_deposite'=>$list_data['booking_deposite'],
                'ref_id'=>$list_data['id'],
                'guests'=>'',
                'modify_date'=>date('Y-m-d H:i:s'),
            );
            $this->db->where('id',$row['id']);
            $this->db->update('ms-booking-list',$data);
            $der = array(
                'modify_date'=>date('Y-m-d H:i:s'),
            );
            $this->db->where('id',$row['booking_id']);
            $this->db->update('ms-booking',$der);
            $book_status = $this->check_booking_status($booking_id);
            $datain = array(
                'booking_status' => $book_status
            );
            $this->db->where('id', $booking_id);
            $this->db->update('ms-booking', $datain);
        }
        else{
            $book_status = 'Booking Created';
            $this->db->where('user_id',$to_id);
            $query1 = $this->db->get('ms-booking');
            if($query1->num_rows() > 0){
                $bookrow = (array)$query1->row();
                $booking_id = $bookrow['id'];
            }
            else{
                $der = array(
                    'user_id'=>$to_id,
                    'modify_date'=>date('Y-m-d H:i:s'),
                );
                $this->db->insert('ms-booking',$der);
                $booking_id = $this->db->insert_id();
            }
            $data = array(
                'booking_id'=>$booking_id,
                'user_id'=>$to_id,
                'booking_date'=>$list_data['booking_date'],
                'booking_time'=>$list_data['booking_time'],
                'booking_pax'=>$list_data['booking_pax'],
                'booking_restid'=>$list_data['booking_restid'],
                'booking_status'=>'booked',
                'booking_reason'=>'',
                'booking_deposite'=>$list_data['booking_deposite'],
                'ref_id'=>$list_data['id'],
                'guests'=>'',
                'modify_date'=>date('Y-m-d H:i:s'),
                'created_date'=>date('Y-m-d H:i:s'),
            );
            $this->db->insert('ms-booking-list',$data);
            $book_status = $this->check_booking_status($booking_id);
            $datain = array(
                'booking_status' => $book_status
            );
            $this->db->where('id', $booking_id);
            $this->db->update('ms-booking', $datain);
        }
        
        $fromdata = $this->get_user_detail_byuserid($from_id);
        $todata = $this->get_user_detail_byuserid($to_id);
        $hoteldata = $this->get_restaurant_detail($list_data['booking_restid']);
        $data = array(
            'timestamp'=>date('Y-m-d h:i:s'),  
            'booking_id'=>$booking_id,  
            'action'=>$book_status,  
            'added_by'=>'Admin',  
            'by_email'=>$this->session->userdata('admin_email'),  
            'for_user'=>$fromdata['email'],  
            'to_user'=>$todata['email'],
            'restaurant_name'=>$hoteldata['restaurant_name'],  
            'restaurant_date'=>$list_data['booking_date'],  
            'restaurant_time'=>$list_data['booking_time'],  
            'no_of_people'=>$list_data['booking_pax'],  
            'reason'=>'',  
            'admin_note	'=>'',
        );
        $this->db->insert('ms-booking-logs',$data);


        $dt = array(
            'ref_id'=>'0',
            'guests'=>$guests,
            'modify_date'=>date('Y-m-d H:i:s'),
        );
        $this->db->where('id',$list_data['id']);
        $this->db->update('ms-booking-list',$dt);

        $dr = array(
            'booking_list_id'=>$list_data['id'],
            'from_id'=>$from_id,
            'to_id'=>$to_id,
            'status'=>'accept',
        );
        $this->db->insert('ms-guest-invite',$dr);
        return $dr;
    }
    function get_invited_fromid_bytoid($to_id,$listid){
        $this->db->where('booking_list_id',$listid);
        $this->db->where('status','accept');
        $this->db->where('to_id',$to_id);
        $query = $this->db->get('ms-guest-invite');
        if($query->num_rows() > 0){
            $row = $query->row();
            return $row->from_id;
        }
        else{
            return 0;
        }
    }
    function insert_filter_name($filter_name){
        $this->db->where('filter_name',$filter_name);
        $query = $this->db->get('ms-filter');
        $count = $query->num_rows();
        if($count > 0){}
        else{
            $data = array(
                'filter_name'=>$filter_name
            );
            $this->db->insert('ms-filter',$data);
        }
    }
    function modify_filter_value_byname($fil_name,$fil_value){
        $this->db->where('filter_name',$fil_name);
        $query = $this->db->get('ms-filter');
        $array = (array)$query->row();
        if(!empty($array)){
            $value = $array['filter_value'];
            if($value != ''){
                $exp = explode(',',$value);
                if (in_array($fil_value, $exp)){

                }
                else{
                    array_push($exp,$fil_value);
                    $val = implode(',',$exp);
                    $dt = array(
                        'filter_value'=>$val
                    );
                    $this->db->where('filter_name',$fil_name);
                    $this->db->update('ms-filter',$dt);
                }
            }
            else{
                $dt = array(
                    'filter_value'=>$fil_value
                );
                $this->db->where('filter_name',$fil_name);
                $this->db->update('ms-filter',$dt);
            }
        }
    }
    function count_filter_type($type){
        $this->db->where('filter_name',$type);
        $query = $this->db->get('ms-filter');
        $count = $query->num_rows();
        return $count;
    }
    function get_property_type_text($type){
        if($type == 'on'){
            $text = 'On - Property Restaurant';
        }
        else if($type == 'off'){
            $text = 'Off - Property Restaurant';
        }
        else{
            $text = 'All Restaurants';
        }
        return $text;
    }
    function get_notification_list_bookid($book_id){
        $this->db->where('booking_list_id',$book_id);
        $this->db->order_by('id','desc');
        $query = $this->db->get('ms-guest-invite');
        return $query->result_array();
    }
    function modify_restaurant_admin_book(){
        $bookid = $this->input->post('bookid');
        $restid = $this->input->post('restid');
        $date = $this->input->post('date');
        $time = $this->input->post('time');
        $pax = $this->input->post('pax');
        $data = array(
            'booking_date'=>$date,
            'booking_time'=>$time,
            'booking_pax'=>$pax,
            'booking_restid'=>$restid,
            'booking_status'=>'booked',
            'ref_id'=>'0',
            'guests'=>'',
            'modify_date'=>date('Y-m-d H:i:s'),
        );
        $this->db->where('id',$bookid);
        $this->db->update('ms-booking-list',$data);
        $book_status = $this->check_booking_status($bookid);
        $datain = array(
            'booking_status' => $book_status
        );
        $this->db->where('id', $bookid);
        $this->db->update('ms-booking', $datain);
        $result = $this->get_dates_list_booking_byid($bookid);
        $book_status = 'Booking Modify';
        $userdata = $this->get_user_detail_byuserid($result['user_id']);
        $hoteldata = $this->get_restaurant_detail($result['booking_restid']);
        $data = array(
            'timestamp'=>date('Y-m-d h:i:s'),  
            'booking_id'=>$result['booking_restid'],  
            'action'=>$book_status,  
            'added_by'=>'Admin',  
            'by_email'=>$this->session->userdata('admin_email'),  
            'for_user'=>$userdata['email'],  
            'to_user'=>'',  
            'restaurant_name'=>$hoteldata['restaurant_name'],  
            'restaurant_date'=>$date,  
            'restaurant_time'=>$time,  
            'no_of_people'=>$pax,  
            'reason'=>'',  
            'admin_note	'=>'',
        );
        $this->db->insert('ms-booking-logs',$data);
        
        $der = array(
            'modify_date'=>date('Y-m-d H:i:s'),
        );
        $this->db->where('id',$result['booking_id']);
        $this->db->update('ms-booking',$der);
        return $result;
    }
    function get_total_seating_capacity_restaurant($rest_id){
        $this->db->where('restaurant_id',$rest_id);
        $query = $this->db->get('ms-restaurant-tables');
        $count = $query->num_rows();
        $total = 0;
        if($count > 0){
            $result = $query->result_array();
            foreach($result as $data){
                $total += $data['size'] * $data['capacity'];
            }
        }
        return $total;
    }
    function get_restaurant_name_byid($rest_id){
        $this->db->where('id',$rest_id);
        $query = $this->db->get('ms-restaurant');
        $count = $query->num_rows();
        if($count > 0){
            $row = $query->row();
            return $row->restaurant_name;
        }
        else{
            return '';
        }
    }
    function get_restaurant_type_byid($rest_id){
        $this->db->where('id',$rest_id);
        $query = $this->db->get('ms-restaurant');
        $count = $query->num_rows();
        if($count > 0){
            $row = $query->row();
            return $row->property_type;
        }
        else{
            return '';
        }
    }

    function get_credit_card_details($userid){
        $this->db->where('user_id',$userid);
        $query = $this->db->get('ms-booking');
        $decryptedCardData =array();
        $count = $query->num_rows();
        if($count > 0){
            $row = $query->row();
            if(!empty($row)){
                //foreach($row as $ary){
                    if($row->card_number){
                        $decryptedCardData = array(                  
                            'card_number'=>$this->encrypt->decode($row->card_number),                                       
                            'expiry_month'=>$this->encrypt->decode($row->exp_month),                    
                            'expiry_year'=>$this->encrypt->decode($row->exp_year),                    
                            'cvv'=>$this->encrypt->decode($row->cvv),                    
                            'card_holder'=>$this->encrypt->decode($row->card_holder),                                         
                        );
                    }

                //}
            }
        }
        return $decryptedCardData;
    }

    function get_max_reservation_date_from_ms_rest_tables(){
        $query = $this->db->select_max('date')->get('ms-restaurant-tables');
        $row = $query->row();
        $maxDate = '';
        if(!empty($row)){
            $maxDate = $row->date;
        }
        return $maxDate;
    }

    function update_user_credit_card_details($user_id){
       
        //$userid = $this->input->post('user_id');

        $card_number = $this->input->post('card_number');
        $card_number = $this->encrypt->encode($card_number);
        $exp_month = $this->input->post('card_ex_month');
        $exp_month = $this->encrypt->encode($exp_month);
        $exp_year = $this->input->post('card_ex_year');
        $exp_year = $this->encrypt->encode($exp_year);
        $security_code = $this->input->post('card_cvv');
        $security_code = $this->encrypt->encode($security_code);
        $card_holder = $this->input->post('card_holder_name');
        $card_holder = $this->encrypt->encode($card_holder);

        $data = array(
            'card_number'=>$card_number,  
            'exp_month'=>$exp_month,  
            'exp_year'=>$exp_year,  
            'cvv'=>$security_code,  
            'card_holder'=>$card_holder,  
            'modify_date'=>date('Y-m-d h:i:s'),
          );

        $this->db->where('user_id',$user_id);
        $this->db->update('ms-booking',$data);
        if ($this->db->affected_rows() > 0) {
            // Update was successful
            return true;
        } else {
            // Update failed, find the reason
            return false;

        }
        
    }

    function get_creditcard_details_foradmin(){
        $where = "(card_number != '')";
        $this->db->where($where);
        $query = $this->db->get('ms-booking');
        $row = $query->result_array();
        $array = [];
        if(!empty($row)){
            foreach($row as $ary){
                $user_id = $ary['user_id'];
                $userdata = $this->get_user_date_byid($user_id);
                $exp_month = $this->encrypt->decode($ary['exp_month']);
                $exp_year = $this->encrypt->decode($ary['exp_year']);
                $expiry = $exp_month.'/'.$exp_year;
                $creditcard = $this->encrypt->decode($ary['card_number']);
                $creditcard_type = $this->restro_validatecard($creditcard);
                $array[] = array(
                    'user_code'=>$userdata['user_code'],
                    'full_name'=>$userdata['full_name'],
                    'email'=>$userdata['email'],
                    'alternate_email'=>$userdata['alternate_email'],
                    'mobile_number'=>$userdata['mobile_number'],                    
                    'card_number'=>$this->encrypt->decode($ary['card_number']),                    
                    'card_type'=>$creditcard_type,                    
                    'expiry'=>$expiry,                    
                    'cvv'=>$this->encrypt->decode($ary['cvv']),                    
                    'card_holder'=>$this->encrypt->decode($ary['card_holder']),                    
                    'booking_code'=>$ary['id'],                       
                );
            }
        }
        return $array;
    }
    function restro_validatecard($number){
        global $type;
        $cardtype = array(
            "visa"       => "/^4[0-9]{12}(?:[0-9]{3})?$/",
            "mastercard" => "/^5[1-5][0-9]{14}$/",
            "amex"       => "/^3[47][0-9]{13}$/",
            "discover"   => "/^6(?:011|5[0-9]{2})[0-9]{12}$/",
        );
        if (preg_match($cardtype['visa'],$number))
        {
        $type= "visa";
            return 'visa';
        }
        else if (preg_match($cardtype['mastercard'],$number))
        {
        $type= "mastercard";
            return 'mastercard';
        }
        else if (preg_match($cardtype['amex'],$number))
        {
        $type= "amex";
            return 'amex';
        }
        else if (preg_match($cardtype['discover'],$number))
        {
        $type= "discover";
            return 'discover';
        }
        else
        {
            return false;
        } 
    }
    function get_user_name_byid($user_id){
        $this->db->where('id',$user_id);
        $query = $this->db->get('ms-admin');
        $count = $query->num_rows();
        if($count > 0){
            $row = $query->row();
            return $row->full_name;
        }
        else{
            return '';
        }
    }
    function get_restaurant_id_byname($restaurant_name){
        $this->db->where('restaurant_name',$restaurant_name);
        $query = $this->db->get('ms-restaurant');
        $count = $query->num_rows();
        if($count > 0){
            $row = $query->row();
            return $row->id;
        }
        else{
            return '';
        }
    }
    function get_restaurant_detail($rest_id){
        $this->db->where('id',$rest_id);
        $query = $this->db->get('ms-restaurant');
        return (array)$query->row();
    }
    function get_restaurant_filters_list($rest_id){
        $this->db->where('rest_id',$rest_id);
        $query = $this->db->get('ms-restaurant-filters');
        return $query->result_array();
    }
    function get_all_restaurant_tables_list(){
        $query = $this->db->get('ms-restaurant-tables');
        return $query->result_array();
    }
    function get_restaurant_tables_list($rest_id){
        // $this->db->where('restaurant_id',$rest_id);
        // $query = $this->db->get('ms-restaurant-tables');
        // return $query->result_array();


        $this->db->from('ms-restaurant-tables');
        $this->db->where('restaurant_id', $rest_id);  // Filter by restaurant_id
        $this->db->order_by('date', 'asc');  // Sort by date in descending order
        $this->db->order_by("STR_TO_DATE(CONCAT(date, ' ', time), '%Y-%m-%d %h:%i %p')", 'asc', false);  // Sort by time in ascending order within each date
        
        $query = $this->db->get();
        $result = $query->result_array();
        
        return $result;
        
    }
    function get_restaurant_reviews_list($rest_id){
        $this->db->where('restaurant_id',$rest_id);
        $query = $this->db->get('ms-restaurant-reviews');
        return $query->result_array();
    }
    function get_email_list(){
        $query = $this->db->get('ms-emails');
        return $query->result_array();
    }
    function get_email_detail_byid($id){
        $this->db->where('id',$id);
        $query = $this->db->get('ms-emails');
        return (array)$query->row();
    }
    function get_filter_type_value($type){
        $this->db->where('filter_name',$type);
        $query = $this->db->get('ms-filter');
        $row = $query->row();
        return $row->filter_value;
    }
    function get_all_filters(){
        $query = $this->db->get('ms-filter');
        $result = $query->result_array();
        return $result;
    }
    function get_filters_restid_filtername($rest_id,$all_f){
        $this->db->where('rest_id',$rest_id);
        $this->db->where('filter_type',$all_f);
        $query = $this->db->get('ms-restaurant-filters');
        return $query->result_array();
    }
    function add_filter_category($category,$image){
        $data = array(
            'filter_icon'     => $image,
            'filter_name' => $category
        );  
        $result= $this->db->insert('ms-filter',$data);
        return $result;
    }
    function insert_new_user(){
        $user_name = $this->input->post('user_name');
        $full_name = $this->input->post('full_name');
        $email_address = $this->input->post('email_address');
        $mobile_number = $this->input->post('mobile_number');
        $pasword = $this->input->post('pasword');
        $role = $this->input->post('role');
        $user_status = $this->input->post('user_status');
        $cmp_id = $this->input->post('cmp_id');
        if($role == '0'){ $cmp_id = 0; $permision = '';}
        $status = 1;
        if($user_status == '1'){
            $status = 0;
        }
        $data = array(
            'user_name' => $user_name,
            'full_name' => $full_name,
            'email' => $email_address,
            'password' => md5($pasword),
            'mobile_number' => $mobile_number,
            'status' => $status,
            'role' => $role,
            'cmp_id' => $cmp_id,
        );
        $this->db->insert('ms-admin',$data);
    }
    function update_2fa_code_user($user_id,$secret_code){
        $data = array(
            '2fa_secret_code'=>$secret_code,
            'first_time'=>'1',
        );
        $this->db->where('id',$user_id);
        $this->db->update('ms-admin',$data);
    }
    function get_user_detail($id){
        $this->db->where('id',$id);
        $query = $this->db->get('ms-admin');
        $result = (array)$query->row();
        return $result;
    }
    function delete_users($user_ids){
        if(!empty($user_ids)){
            foreach($user_ids as $user_id){
                $this->db->where("id",$user_id);
                $this->db->delete("ms-admin");
            }
        }
    }
    function update_email(){
        $id = $this->input->post('id');
        $subject = $this->input->post('email_subject');
        $body = $this->input->post('email_body');
        $data = array(
            'email_subject'=>$subject,
            'email_body'=>$body,
        );
        $this->db->where('id',$id);
        $this->db->update('ms-emails',$data);
    }
    function get_email_template($template){
        $this->db->where('email_name',$template);
        $query = $this->db->get('ms-emails');
        return (array)$query->row();
    }
    function delete_user_admin($user_id){
        $this->db->where('user_id',$user_id);
        $query = $this->db->get('ms-booking-list');
        $rows = $query->result_array();
        if(!empty($rows)){
            foreach($rows as $array){
                $booking_id = $array['booking_id'];
                if($array['ref_id'] > 0){
                    $this->db->where('id',$array['ref_id']);    
                    $q1 = $this->db->get('ms-booking-list');
                    $r1 = (array)$q1->row();
                    if(!empty($r1)){
                        $guest = $r1['guests'];
                        $exp = explode(',',$guest);
                        if(!empty($exp)){
                            $remain = array_diff( $exp, [$user_id] );
                            if(!empty($remain)){
                                $remain = implode(',',$remain);
                            }
                            else{
                                $remain = '';
                            }
                            $dt1 = array(
                                'guests'=>$remain,
                                'modify_date'=>date('Y-m-d H:i:s'),
                            );
                            $this->db->where('id',$array['ref_id']);    
                            $q2 = $this->db->update('ms-booking-list',$dt1);
                        }
                    }
                }
                $guests = $array['guests'];
                $$id = $array['id'];
                if($guests != ''){
                    $exp = explode(',',$guests);
                    foreach($exp as $userid){
                        $next_host = $userid;
                        break;
                    }
                    $remain = array_diff( $exp, [$next_host] );
                    if(!empty($remain)){
                        $remain = implode(',',$remain);
                    }
                    else{
                        $remain = '';
                    }
                    $data = array(
                        'ref_id'=>'0',
                        'guests'=>$remain,
                        'modify_date'=>date('Y-m-d H:i:s'),
                    );
                    $this->db->where('user_id',$next_host);
                    $this->db->where('ref_id',$id);
                    $this->db->update('ms-booking-list',$data);
                }
            }
        }
        $this->db->where('user_id',$user_id);
        $this->db->delete('ms-booking-list');

        $where = "(from_id = '$user_id' OR to_id = '$user_id')";
        $this->db->where($where);
        $this->db->delete('ms-guest-invite');

        $this->db->where('user_id',$user_id);
        $this->db->delete('ms-booking');

        $book_data = $this->get_booking_detail_byuserid($user_id);
        if(!empty($book_data)){
            $this->db->where('booking_id',$book_data['id']);
            $this->db->delete('ms-booking-logs');
        }

        $this->db->where('id',$user_id);
        $this->db->delete('ms-admin');
        $book_status = $this->check_booking_status($booking_id);
        $datain = array(
            'booking_status' => $book_status
        );
        $this->db->where('id', $booking_id);
        $this->db->update('ms-booking', $datain);
    }
    function get_dates_list_booking(){
        $this->db->select('date');
        $this->db->group_by('date');
        $this->db->order_by('date','ASC');
        $query = $this->db->get('ms-restaurant-tables');
        return $query->result_array();
    }
    function get_defined_filter_values(){
        $this->db->select('report_filters');
        $this->db->where('id', $this->session->userdata('mes_admin_id'));
        $query = $this->db->get('ms-admin');
        $result = $query->result_array();
        return $query->result_array();
    }

    function save_report_filter_fields(){
        $data = array(
            'report_filters' => serialize($this->input->post())
        );
        $this->db->where('id',$this->session->userdata('mes_admin_id'));
        $this->db->update('ms-admin',$data);
        return true;

    }

    function get_time_list_booking(){
        $this->db->select('time');
        $this->db->group_by('time');
        $this->db->order_by('TIME(time)','ASC');
        $query = $this->db->get('ms-restaurant-tables');
        return $query->result_array();
    }
    function get_filters_listby_restid($rest_id){
        $this->db->where('rest_id',$rest_id);
        $query = $this->db->get('ms-restaurant-filters');
        return $query->result_array();
    }
    function get_icon_by_filterslug($slug){
        $this->db->where('filter_name',$slug);
        $query = $this->db->get('ms-filter');
        $count = $query->num_rows();
        if($count > 0){
        return $query->row()->filter_icon;
        }
        else{
            return '';
        }
    }
    function get_string_from_date($date){
        $date =  date('j<\s\u\p>S</\s\u\p> F', strtotime($date));
        return $date;
    }
    function time_list_table_restaurant($rest_id,$selected_date,$selected_pax){
        $this->db->where('restaurant_id',$rest_id);
        $this->db->where('date',date('Y-m-d',strtotime($selected_date)));
        $this->db->where('size',$selected_pax);
        $this->db->order_by('time', 'asc');
        $query = $this->db->get('ms-restaurant-tables');
        $array =  $query->result_array();
        $in_array = [];
        if(!empty($array)){
            foreach($array as $data){
                $date = $data['date'];
                $time = $data['time'];
                $size = $data['size'];
                $capacity = $data['capacity'];
                $this->db->where('booking_restid',$rest_id);
                $this->db->where('booking_date',$date);
                $this->db->where('booking_time',$time);
                $this->db->where('booking_status','booked');
                $this->db->where('booking_pax',$size);
                $this->db->where('ref_id','0');//To exclude invites
                $query = $this->db->get('ms-booking-list');
                $count = $query->num_rows();
                if($capacity > $count){
                    $in_array[] = $data;
                }
            }
        }
        return $in_array;
    }
    function get_dates_list_booking_byid($id){
        $this->db->where('id',$id);
        $query = $this->db->get('ms-booking-list');
        return (array)$query->row();
    }
    function get_booking_detail_byuserid($user_id){
        $this->db->where('user_id',$user_id);
        $query = $this->db->get('ms-booking');
        return (array)$query->row();
    }
    function get_pax_list_booking(){
        $this->db->select('size');
        $this->db->group_by('size');
        $this->db->order_by('size','ASC');
        $query = $this->db->get('ms-restaurant-tables');
        return $query->result_array();
    }
    function get_filters_list(){
        $query = $this->db->get('ms-filter');
        return $query->result_array();
    }
    function get_hotels_list_with_filter($date,$time,$pax){
        $where = 'is_deleted = 0';
        if($date != ''){
            $date = date('Y-m-d',strtotime($date));
            $where .= " AND tb.date = '$date'";
        }
        if($time != ''){
            $where .= " AND tb.time = '$time'";
        }
        if($pax != ''){
            $where .= " AND tb.size = '$pax'";
        }
        $sql = "SELECT re.* FROM `ms-restaurant` AS re
        INNER JOIN `ms-restaurant-tables` AS tb ON tb.restaurant_id = re.id
        WHERE $where GROUP BY re.id ORDER BY re.restaurant_name ASC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    function get_complete_booking_list($params = array()){
        $dates = $this->get_dates_list_booking();
        $indate = '';
        $where = 'WHERE 1=1';
        $limit = '';
        if(!empty($dates)){
            foreach($dates as $key => $date){
                $indate .= ' INNER JOIN `ms-booking-list` AS B'.$key.' ON B'.$key.'.booking_id = M.id ';
                $where .= " AND  B$key.booking_date = '".$date['date']."' AND B$key.booking_status = 'booked'";
            }
        }
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
            $limit = ' LIMIT '.$params['limit'].','.$params['start']; 
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
            $limit = ' LIMIT '.$params['limit']; 
        } 
        $query = $this->db->query("SELECT M.* From `ms-booking` AS M $indate $where $limit");
        return $query->result_array();
    }
    function get_pending_booking_list($params=array()){
        $indate = '';
        $where = "WHERE M.id NOT IN( SELECT user_id FROM `ms-booking-list`) AND M.role='1'";
        $limit = '';
        if(array_key_exists("keyword",$params)){
            $where .= " AND  (M.full_name LIKE '%".$params['keyword']."%' OR M.email LIKE '%".$params['keyword']."%' OR M.alternate_email LIKE '%".$params['keyword']."%')";
        }
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
            $limit = ' LIMIT '.$params['start'].','.$params['limit']; 
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
            $limit = ' LIMIT '.$params['limit']; 
        } 
        $query = $this->db->query("SELECT M.* From `ms-admin` AS M $indate $where GROUP BY M.id $limit");
        return $query->result_array();
    }
    function get_cancel_booking_list($params=array()){
        $indate = '';
        $where = "WHERE M.booking_status = 'cancel'";
        $limit = '';
        if(array_key_exists("keyword",$params)){
            $indate .= ' INNER JOIN `ms-admin` AS A ON A.id = M.user_id ';
            $where .= " AND  (A.full_name LIKE '%".$params['keyword']."%' OR A.email LIKE '%".$params['keyword']."%' OR A.alternate_email LIKE '%".$params['keyword']."%')";
        }
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
            $limit = ' LIMIT '.$params['start'].','.$params['limit']; 
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
            $limit = ' LIMIT '.$params['limit']; 
        } 
        $query = $this->db->query("SELECT M.* From `ms-booking-list` AS M $indate $where ORDER BY M.modify_date DESC $limit ");
        return $query->result_array();
    }
    function get_booking_detail($book_id){
        $this->db->where('id',$book_id);
        $query = $this->db->get('ms-booking');
        return (array)$query->row();
    }
    function get_booking_list_detail_by_id($id){
        $this->db->where('id',$id);
        $query = $this->db->get('ms-booking-list');
        return (array)$query->row();
    }
    function get_booking_dates_list($booking_id){
        $this->db->order_by('booking_date','ASC');
        $this->db->where('booking_id',$booking_id);
        $query = $this->db->get('ms-booking-list');
        return $query->result_array();
    }
    function get_booking_dates_list_by_bookingid_date($booking_id,$date){
        $this->db->where('booking_id',$booking_id);
        $this->db->where('booking_date',$date);
        $query = $this->db->get('ms-booking-list');
        return (array)$query->row();
    }
    function delete_admin_restaurant($rest_id){
        //Soft delete
        // $data = array(
        //     'is_deleted' => 1
        // );
        // $this->db->where('id',$rest_id);
        // $this->db->update('ms-restaurant',$data);

        //Hard Delete
        $this->db->where('id',$rest_id);
        $this->db->delete('ms-restaurant');
    }
    function get_user_date_byid($user_id){
        $this->db->where('id',$user_id);
        $query = $this->db->get('ms-admin');
        return (array)$query->row();
    }
    public function cancel_reservation_date(){
        $cancellation = $this->input->post('cancellation');
        $id = $this->input->post('cancel_booking_listid');
        $user_id = $this->session->userdata('mes_user_id');
        $book_data = $this->get_dates_list_booking_byid($id);
        $book_status = 'Booking Cancelled';
        $userdata = $this->get_user_detail_byuserid($book_data['user_id']);
        $hoteldata = $this->get_restaurant_detail($book_data['booking_restid']);
        $data = array(
            'timestamp'=>date('Y-m-d h:i:s'),  
            'booking_id'=>$book_data['booking_id'],  
            'action'=> $book_status,  
            'added_by'=>'Admin',  
            'by_email'=>$this->session->userdata('admin_email'),  
            'for_user'=>$userdata['email'],  
            'to_user'=>'',  
            'restaurant_name'=>$hoteldata['restaurant_name'],  
            'restaurant_date'=>date('Y-m-d',strtotime($book_data['booking_date'])),  
            'restaurant_time'=>$book_data['booking_time'],  
            'no_of_people'=>$book_data['booking_pax'],  
            'reason'=>$cancellation,  
            'admin_note	'=>'',
        );
        $this->db->insert('ms-booking-logs',$data);

        $this->modify_invited_guests_list($id);
        $data = array(
            'booking_status'=>'cancel',
            'ref_id'=>'0',
            'booking_reason'=>$cancellation,
            'modify_date'=>date('Y-m-d H:i:s'),
        );
        $this->db->where('id',$id);
        $this->db->update('ms-booking-list',$data);
        $book_status = $this->check_booking_status($book_data['booking_id']);
        $datain = array(
            'booking_status' => $book_status
        );
        $this->db->where('id', $book_data['booking_id']);
        $this->db->update('ms-booking', $datain);
        return $data;
    }
    function get_user_detail_byuserid($user_id){
        $this->db->where('id',$user_id);
        $this->db->where('role','1');
        $query = $this->db->get('ms-admin');
        return (array)$query->row();
    }
    public function modify_invited_guests_list($id){
        $this->db->where('id',$id);
        $query = $this->db->get('ms-booking-list');
        if($query->num_rows() > 0){
            $row = $query->row();
            $guests = $row->guests;
            $ref_id = $row->ref_id;
            $booking_id = $row->booking_id;
            if($guests != ''){
                $exp = explode(',',$guests);
                foreach($exp as $userid){
                    $next_host = $userid;
                    break;
                }
                $remain = array_diff( $exp, [$next_host] );
                if(!empty($remain)){
                    $remain = implode(',',$remain);
                }
                else{
                    $remain = '';
                }
                $dt = array(
                    'guests'=>'',
                    'modify_date'=>date('Y-m-d H:i:s'),
                );
                $this->db->where('id',$id);
                $this->db->update('ms-booking-list',$dt);
                $data = array(
                    'ref_id'=>'0',
                    'guests'=>$remain,
                    'modify_date'=>date('Y-m-d H:i:s'),
                );
                $this->db->where('user_id',$next_host);
                $this->db->where('ref_id',$id);
                $this->db->update('ms-booking-list',$data);
            }
            if($ref_id > 0){
                $user_id = $row->user_id;
                $this->db->where('id',$ref_id);
                $inquery = $this->db->get('ms-booking-list');
                $inrow = $inquery->row();
                if(!empty($inrow)){
                    $guests = $inrow->guests;
                    if($guests != ''){
                        $exp = explode(',',$guests);
                        $remain = array_diff( $exp, [$user_id] );
                        if(!empty($remain)){
                            $remain = implode(',',$remain);
                        }
                        else{
                            $remain = '';
                        }
                        $dt = array(
                            'guests'=>$remain,
                            'modify_date'=>date('Y-m-d H:i:s'),
                        );
                        $this->db->where('id',$ref_id);
                        $this->db->update('ms-booking-list',$dt);
                    }
                }
            }
            $book_status = $this->check_booking_status($booking_id);
            $datain = array(
                'booking_status' => $book_status
            );
            $this->db->where('id', $booking_id);
            $this->db->update('ms-booking', $datain);
        }
    }
    public function add_admin_note(){
        $adminNote = $this->input->post('admin_note');
        $id = $this->input->post('adminNote_booking_listid');
        // $this->modify_invited_guests_list($id);
        $data = array(
            'admin_note'=>$adminNote,
        );
        $this->db->where('id',$id);
        $this->db->update('ms-booking-list',$data);
        return $data;
    }
    function get_partial_booking_list(){
        $dates = $this->get_dates_list_booking();
        $indate = []; 
        if(!empty($dates)){
            foreach($dates as $key => $date){
                array_push($indate,$date['date']);
            }
        }
        // echo implode(',',$indate);exit;
        $indate = '';
        $where = 'WHERE 1=1';
        $or = [];
        if(!empty($dates)){
            foreach($dates as $key => $date){
                $indate .= ' INNER JOIN `ms-booking-list` AS B'.$key.' ON B'.$key.'.booking_id = M.id ';
                $or[]= " (B$key.booking_date = '".$date['date']."' AND B$key.booking_status = 'skip')";
            }
        }
        if(!empty($or)){
        $implode = implode(' OR ',$or);
        $where .= ' AND ('.$implode.')';
        }
        $query = $this->db->query("SELECT M.* From `ms-booking` AS M $indate $where GROUP BY M.id");
        return $query->result_array();
    }
    function get_invite_status_byuserid_bookdate($user_id,$book_date){
        $query = $this->db->query("SELECT MI.* From `ms-guest-invite` AS MI 
        INNER JOIN `ms-booking-list` AS MB ON MB.id = MI.booking_list_id
        WHERE MB.booking_date = '$book_date' AND MI.to_id = '$user_id' ORDER BY MI.id DESC LIMIT 1");
        return (array)$query->row();
    }
    function get_all_booking_list(){
        $query = $this->db->query("SELECT * From `ms-booking` ORDER BY id DESC");
        return $query->result_array();
    }
    function get_recent_booking_list(){
        $query = $this->db->query("SELECT * From `ms-booking` ORDER BY id DESC LIMIT 7 ");
        return $query->result_array();
    }
    function get_status_of_booking_date_byid($list_id,$date){
        $this->db->where('booking_id',$list_id);
        $this->db->where('booking_date',$date);
        $query = $this->db->get('ms-booking-list');
        if($query->num_rows() > 0){
            return ucfirst($query->row()->booking_status);
        }
        else{
            return 'Skip';
        }
    }
    function get_restaurant_slot_report_list($params=array()){
        $indate = 'INNER JOIN `ms-restaurant` AS M ON M.id = MT.restaurant_id';
        $where = "WHERE 1=1";
        $limit = '';
        // $orderby = 'ORDER BY M.id DESC';
        $orderby = 'ORDER BY M.restaurant_name ASC';
        if(array_key_exists("keyword",$params)){
            $where .= " AND  (M.restaurant_name LIKE '%".$params['keyword']."%')";
        }
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
            $limit = ' LIMIT '.$params['start'].','.$params['limit']; 
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
            $limit = ' LIMIT '.$params['limit']; 
        } 
        if(array_key_exists("orderby",$params)){
            if($params['order'] == 'name'){
                $orderby = 'ORDER BY M.restaurant_name '.$params['orderby'];
            }
            else if($params['order'] == 'time'){
                $orderby = 'ORDER BY MT.time '.$params['orderby'];
            }
            else if($params['order'] == 'date'){
                $orderby = 'ORDER BY MT.date '.$params['orderby'];
            }
            else if($params['order'] == 'size'){
                $orderby = 'ORDER BY MT.size '.$params['orderby'];
            }
            else if($params['order'] == 'capacity'){
                $orderby = 'ORDER BY MT.capacity '.$params['orderby'];
            }
            else if($params['order'] == 'booked'){
                $orderby = 'ORDER BY booking '.$params['orderby'];
                $query = $this->db->query("SELECT MT.*,M.restaurant_name,M.property_type,
                (select count(id) from `ms-booking-list` AS L where L.booking_restid = MT.restaurant_id AND L.booking_pax = MT.size AND L.booking_status = 'booked' AND L.booking_date = MT.date AND L.booking_time = MT.time AND L.ref_id=0) AS booking
                From `ms-restaurant-tables` AS MT $indate $where $orderby $limit");
                return $query->result_array();
            }
            else if($params['order'] == 'remaining'){
                $orderby = 'ORDER BY remaining '.$params['orderby'];
                $query = $this->db->query("SELECT MT.*,M.restaurant_name,M.property_type,
                (MT.capacity - (select count(id) from `ms-booking-list` AS L where L.booking_restid = MT.restaurant_id AND L.booking_pax = MT.size AND L.booking_status = 'booked' AND L.booking_date = MT.date AND L.booking_time = MT.time AND L.ref_id=0)) AS remaining
                From `ms-restaurant-tables` AS MT $indate $where $orderby $limit");
                return $query->result_array(); 
            }
        }
        $query = $this->db->query("SELECT MT.*,M.restaurant_name,M.property_type From `ms-restaurant-tables` AS MT $indate $where $orderby $limit");
        return $query->result_array();
    }
    function get_unauthorize_user_list($params=array()){
        $indate = '';
        $where = "WHERE 1=1";
        $limit = '';
        if(array_key_exists("keyword",$params)){
            $where .= " AND  (M.email LIKE '%".$params['keyword']."%' OR M.ip LIKE '%".$params['keyword']."%' )";
        }
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
            $limit = ' LIMIT '.$params['start'].','.$params['limit']; 
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
            $limit = ' LIMIT '.$params['limit']; 
        } 
        $query = $this->db->query("SELECT M.* From `ms-unauthorize-email` AS M $indate $where GROUP BY M.id ORDER BY M.id DESC $limit");
        return $query->result_array();
    }
    function get_invite_guest_list($params=array()){
        $indate = ' INNER JOIN `ms-booking-list` AS B ON M.booking_list_id = B.id';
        $where = "WHERE 1=1";
        $limit = '';
        if(array_key_exists("keyword",$params)){
            $indate .= ' INNER JOIN `ms-admin` AS U ON (U.id = M.from_id OR U.id = M.to_id)';
            $where .= " AND  (U.email LIKE '%".$params['keyword']."%' OR U.alternate_email LIKE '%".$params['keyword']."%' OR U.full_name LIKE '%".$params['keyword']."%' )";
        }
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
            $limit = ' LIMIT '.$params['start'].','.$params['limit']; 
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
            $limit = ' LIMIT '.$params['limit']; 
        } 
        $query = $this->db->query("SELECT M.*,B.booking_date,B.booking_time,B.booking_pax,B.booking_restid From `ms-guest-invite` AS M $indate $where GROUP BY M.id ORDER BY M.id DESC $limit");
        return $query->result_array();
    }
    function count_booked_tablle_byrestid_date($rest_id,$date,$time,$size){
        $this->db->where('booking_date',$date);
        $this->db->where('booking_restid',$rest_id);
        $this->db->where('booking_time',$time);
        $this->db->where('booking_pax',$size);
        $this->db->where('booking_status','booked');
        $this->db->where('ref_id','0');
        $query = $this->db->get('ms-booking-list');
        return $query->num_rows();
    }
    function get_booking_slot_username_bookingid($rest_id,$date,$time,$size){
        $this->db->where('booking_date',$date);
        $this->db->where('booking_restid',$rest_id);
        $this->db->where('booking_time',$time);
        $this->db->where('booking_pax',$size);
        $this->db->where('booking_status','booked');
        $query = $this->db->get('ms-booking-list');
        return $query->result_array();
    }
    function check_booking_status($booking_id){
        $dates = $this->get_dates_list_booking();
        $return = 'partial';
        if(!empty($dates)){
            $booked = 1;
            foreach ($dates as $key => $date) {
                $this->db->where('booking_id',$booking_id);
                $this->db->where('booking_date',$date['date']);
                $this->db->where('booking_status','booked');
                $qry = $this->db->get('ms-booking-list');
                if($qry->num_rows() > 0){ }
                else{
                    $booked = 0;
                }
            }
            if($booked == 1){
                $return = 'completed';
            }
        }
        return $return;
    }
    function reset_booking_status(){
        $query = $this->db->get('ms-booking');
        $results = $query->result_array();
        if(!empty($results)){
            foreach($results as $data){
                $booking_id = $data['id'];
                $status = $this->check_booking_status($booking_id);
                $datain = array(
                    'booking_status' => $status
                );
                $this->db->where('id', $booking_id);
                $this->db->update('ms-booking', $datain);
            }
        }
    }
    function get_booking_status_byuserid($user_id){
        $this->db->where('user_id',$user_id);
        $query = $this->db->get('ms-booking');
        if($query->num_rows() > 0){ 
            return ucfirst($query->row()->booking_status);
        }
        else{
            return '';
        }
    }
    function get_booking_id_byuserid($user_id){
        $this->db->where('user_id',$user_id);
        $query = $this->db->get('ms-booking');
        if($query->num_rows() > 0){ 
            return ucfirst($query->row()->id);
        }
        else{
            return 0;
        }
    }
}
?>
