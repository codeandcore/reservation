<?php 
class User_model extends CI_Model {
    function check_email($email){
        $where = "(email='$email' || alternate_email = '$email')  && status='0' && role='1'";
        $this->db->where($where);
        $query = $this->db->get('ms-admin');
        $count = $query->num_rows();
        if($count > 0){
            $row = $query->row();         
            return (array)$row;
        }
        else{
            $this->insert_unauthorized_email($email);
            return 1;
        }
    }
    function get_user_already_booked_byuserid($user_id){
        $this->db->where('user_id',$user_id);
        $query = $this->db->get('ms-booking');
        return $query->num_rows();
    }
    function update_pasword_foremail($email,$code){
        $data = array(
            'password'=>$code,
            'temp_password_status'=>0,
            'otp_time'=>date('Y-m-d H:i:s')
        );
        $where = "(email='$email' || alternate_email = '$email')  && status='0' && role='1'";
        $this->db->where($where);
        $this->db->update('ms-admin',$data);
    }
    function check_login(){
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $where = "(email='$username' || alternate_email = '$username') && password = '$password' && role='1' && status='0'";
        $this->db->where($where);
        $query = $this->db->get('ms-admin');
        $count = $query->num_rows();
        if($count > 0){
            $row = $query->row();   
            
            $otp_time = $row->otp_time;
            $current_time = date('Y-m-d H:i:s');
            $from_time = strtotime($current_time); 
            $to_time = strtotime($otp_time); 
            $diff_minutes = round(abs($from_time - $to_time) / 60,2);
            // if($diff_minutes >= 15){
            //     return 2;
            // }
            // else{
            //     return (array)$row;
            // }

            return (array)$row;
        }else{
            return 1;
        }
    }

    function reset_password(){
		$username = $this->input->post('username');
        $password = $this->input->post('password');
        $newPassword = $this->input->post('new-password');

        $where = "(email='$username' || alternate_email = '$username') && role='1' && status='0'";
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
            $this->db->where($where); // Assuming $where contains the conditions for selecting the user
            $user_details = $this->db->get('ms-admin')->row_array();
            return $user_details;
        }else{
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
    function insert_unauthorized_email($email){
        $ip = $this->input->ip_address();
        $this->db->where('email',$email);
        $query = $this->db->get('ms-unauthorize-email');
        if($query->num_rows() > 0){

        }
        else{
            $data = array(
                'email'=>$email,
                'ip'=>$ip
            );
            $this->db->insert('ms-unauthorize-email',$data);
        }
    }
    function get_dates_list_booking(){
        $this->db->select('date');
        $this->db->group_by('date');
        $this->db->order_by('date','ASC');
        $query = $this->db->get('ms-restaurant-tables');
        return $query->result_array();
    }
    function get_dates_list_booking_byuserid($user_id){
        $this->db->where('user_id',$user_id);
        $this->db->order_by('booking_date','ASC');
        $query = $this->db->get('ms-booking-list');
        return $query->result_array();
    }
    function get_dates_list_booking_byuserid_date($user_id,$date){
        $this->db->where('user_id',$user_id);
        $this->db->where('booking_date',$date);
        $query = $this->db->get('ms-booking-list');
        return (array)$query->row();
    }
    function get_time_list_booking(){
        $this->db->select('time');
        $this->db->group_by('time');
        $this->db->order_by('TIME(time)','ASC');
        $query = $this->db->get('ms-restaurant-tables');
        return $query->result_array();
    }
    function get_string_from_date($date){
        $date =  date('F j<\s\u\p>S</\s\u\p>', strtotime($date));
        return $date;
    }
    function get_pax_list_booking(){
        $this->db->select('size');
        $this->db->group_by('size');
        $this->db->order_by('CAST(size AS UNSIGNED)', 'ASC'); // Cast size to integer for proper sorting
        $query = $this->db->get('ms-restaurant-tables');
        return $query->result_array();
    }
    function get_hotels_list_booking(){
        $this->db->where('is_deleted','0');
        $this->db->order_by('id','DESC');
        $query = $this->db->get('ms-restaurant');
        return $query->result_array();
    }
    function get_filters_listby_restid($rest_id){
        $this->db->where('rest_id',$rest_id);
        $query = $this->db->get('ms-restaurant-filters');
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
    function get_filters_list(){
        $query = $this->db->get('ms-filter');
        return $query->result_array();
    }
    function get_restaurant_detail($id){
        $this->db->where('id',$id);
        $query = $this->db->get('ms-restaurant');
        return (array)$query->row();
    }
    function compact_time_ago($created_at)
    {
        // 1. Detect server's current timezone automatically
        $serverTZ = new DateTimeZone(date_default_timezone_get());

        // 2. Parse DB datetime (usually stored in UTC)
        $dbTime = new DateTime($created_at, new DateTimeZone('UTC'));

        // 3. Convert DB time → local server timezone
        $dbTime->setTimezone($serverTZ);

        // 4. Current local time
        $now = new DateTime('now', $serverTZ);

        // 5. Difference in seconds
        $diffSeconds = max(0, $now->getTimestamp() - $dbTime->getTimestamp());

        if ($diffSeconds < 5) {
            return 'just now';
        }

        $minutes = floor($diffSeconds / 60);
        $hours   = floor($diffSeconds / 3600);
        $days    = floor($diffSeconds / 86400);

        if ($minutes < 5) {
            return 'just now';
        }

        if ($minutes < 60) {
            return "{$minutes}min ago";
        } elseif ($hours < 24) {
            return "{$hours}h ago";
        } else {
            return "{$days}d ago";
        }
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
    function time_list_table_restaurant($rest_id,$selected_date,$selected_pax){
        $this->db->where('restaurant_id',$rest_id);
        $this->db->where('date',date('Y-m-d',strtotime($selected_date)));
        if($selected_pax == ''){
            $selected_pax = 2; 
        }
        $this->db->where('size',$selected_pax);
        $this->db->order_by('time', 'asc');
        $query = $this->db->get('ms-restaurant-tables');
        // echo $this->db->last_query();
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
    function filter_restaurant_list($filter_type,$filter_value,$property_type,$book_date,$book_pax,$book_time){
        $where = 'is_deleted = 0';
        $indate = ' INNER JOIN `ms-restaurant-tables` AS tb ON tb.restaurant_id = re.id';
        if($book_date != ''){
            $date = date('Y-m-d',strtotime($book_date));
            $where .= " AND tb.date = '$date'";
        }
        if($book_time != ''){
            $where .= " AND tb.time = '$book_time'";
        }
        if($book_pax != ''){
            $where .= " AND tb.size = '$book_pax'";
        }
        if($property_type != ''){
            $where .= " AND re.property_type = '$property_type'";
        }
        if(!empty($filter_type)){
            $indate .= ' INNER JOIN `ms-restaurant-filters` AS rf ON rf.rest_id = re.id';
            $or = '(';
            $ary = [];
            foreach($filter_type as $key => $val){
                $ary[] = "(rf.filter_type = '$filter_type[$key]' AND rf.filter_value = '$filter_value[$key]')";
            }
            $or .= implode(' OR ',$ary);
            $or .= ')';
            $where .= " AND $or";
        }
        $sql = "SELECT re.* FROM `ms-restaurant` AS re
        $indate
        WHERE $where GROUP BY re.id ORDER BY re.restaurant_name";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    function get_count_booking_by_userid($user_id){
        $this->db->where('user_id',$user_id);
        $query = $this->db->get('ms-booking');
        return $query->num_rows();
    }
    function modify_final_restaurant_booking_detail(){
        $user_id = $this->session->userdata('mes_user_id');
        $booking_id = $this->input->post('booking_id');
        $booking_date = $this->input->post('booking_date');
        $booking_time = $this->input->post('booking_time');
        $booking_status = $this->input->post('booking_status');
        $booking_pax = $this->input->post('booking_pax');
        $booking_restid = $this->input->post('booking_restid');
        $booking_reason = $this->input->post('booking_reason');
        $booking_deposite = $this->input->post('booking_deposite');
        $card_number = $this->input->post('card_number');
        $card_number = $this->encrypt->encode($card_number);
        $exp_month = $this->input->post('exp_month');
        $exp_month = $this->encrypt->encode($exp_month);
        $exp_year = $this->input->post('exp_year');
        $exp_year = $this->encrypt->encode($exp_year);
        $security_code = $this->input->post('security_code');
        $security_code = $this->encrypt->encode($security_code);
        $card_holder = $this->input->post('card_holder');
        $card_holder = $this->encrypt->encode($card_holder);
        $data = array(
            'user_id'=>$user_id,  
            'booking_time'=>date('Y-m-d h:i:s'),  
            'card_number'=>$card_number,  
            'exp_month'=>$exp_month,  
            'exp_year'=>$exp_year,  
            'cvv'=>$security_code,  
            'card_holder'=>$card_holder,  
            'modify_date'=>date('Y-m-d h:i:s'),
          );
          $this->db->where('id',$booking_id);
          $this->db->update('ms-booking',$data);
          $data['booking_id'] = $booking_id;
          if(!empty($booking_date)){
            foreach($booking_date as $key => $date){
                $token =$this->generateRandomString();
                if($booking_status[$key] != 'cancel'){
                    if($booking_restid[$key] != ''){ $status = 'booked'; }
                    else{ $status = 'skip'; }
                    $book_date = date('Y-m-d',strtotime($booking_date[$key]));
                    $count = $this->get_user_booking_datewise($user_id,$book_date);
                    if($count > 0){
                        $lastdata = $this->get_dates_list_booking_byuserid_date($user_id,$book_date);
                        if($lastdata['booking_date'] != $book_date || $lastdata['booking_time'] != $booking_time[$key] || $lastdata['booking_pax'] != $booking_pax[$key] || $lastdata['booking_restid'] != $booking_restid[$key]){
                            $book_status = 'Booking Modify';
                            $userdata = $this->get_user_detail_byuserid($user_id);
                            $hoteldata = $this->get_restaurant_detail($booking_restid[$key]);
                            if($status == 'skip'){ $reason = $booking_reason[$key];}else{ $reason = '';}
                            $data = array(
                                'timestamp'=>date('Y-m-d h:i:s'),  
                                'booking_id'=>$booking_id,  
                                'action'=>$book_status,  
                                'added_by'=>'User',  
                                'by_email'=>$userdata['email'],  
                                'for_user'=>$userdata['email'],  
                                'to_user'=>'',  
                                'restaurant_name'=>$hoteldata['restaurant_name'],  
                                'restaurant_date'=>$book_date,  
                                'restaurant_time'=>$booking_time[$key],  
                                'no_of_people'=>$booking_pax[$key],  
                                'reason'=>$reason,  
                                'admin_note	'=>$lastdata['admin_note'],
                            );
                            $this->db->insert('ms-booking-logs',$data);
                        }

                        
                        $data = array(
                            'booking_id'=>$booking_id,  
                            'booking_time'=>$booking_time[$key],  
                            'booking_pax'=>$booking_pax[$key],  
                            'booking_restid'=>$booking_restid[$key],  
                            'booking_status'=>$status,  
                            'booking_reason'=>$booking_reason[$key],  
                            'booking_deposite'=>$booking_deposite[$key],
                            'token'=>$token,
                            'modify_date'=>date('Y-m-d h:i:s'),
                        );
                        $this->db->where('user_id',$user_id);
                        $this->db->where('booking_date',$book_date);
                        $this->db->update('ms-booking-list',$data);

                        $der = array(
                            'modify_date'=>date('Y-m-d H:i:s'),
                        );
                        $this->db->where('id',$booking_id);
                        $this->db->update('ms-booking',$der);


                        $this->db->where('user_id',$user_id);
                        $this->db->where('booking_date',$book_date);
                        $query = $this->db->get('ms-booking-list');
                        $row = (array)$query->row();
                        $guests = $row['guests'];
                        $listid = $row['id'];
                        $from_id = $row['user_id'];
                        if($guests != ''){
                            $exp = explode(',',$guests);
                            foreach($exp as $useid){
                                $der = array(
                                    'booking_time'=>$booking_time[$key],  
                                    'booking_restid'=>$booking_restid[$key],  
                                    'booking_deposite'=>$booking_deposite[$key],
                                    'modify_date'=>date('Y-m-d h:i:s'),
                                );
                                $this->db->where('ref_id',$listid);
                                $this->db->where('user_id',$useid);
                                $this->db->update('ms-booking-list',$der);
                            }
                        }
                    }
                    else{
                    $data = array(
                        'booking_id'=>$booking_id,  
                        'user_id'=>$user_id,  
                        'booking_date'=>$book_date,  
                        'booking_time'=>$booking_time[$key],  
                        'booking_pax'=>$booking_pax[$key],  
                        'booking_restid'=>$booking_restid[$key],  
                        'booking_status'=>$status,  
                        'booking_reason'=>$booking_reason[$key],  
                        'booking_deposite'=>$booking_deposite[$key],
                        'token'=>$token,
                        'modify_date'=>date('Y-m-d h:i:s'),
                        'created_date'=>date('Y-m-d H:i:s'),
                    );
                    $this->db->insert('ms-booking-list',$data);

                    //inserted log in create booking
                    if($status == 'skip'){ $reason = $booking_reason[$key];}else{ $reason = '';}
                        $book_status = 'Booking Created';
                        $userdata = $this->get_user_detail_byuserid($user_id);
                        $hoteldata = $this->get_restaurant_detail($booking_restid[$key]);
                        $data = array(
                            'timestamp'=>date('Y-m-d h:i:s'),  
                            'booking_id'=>$booking_id,  
                            'action'=>$book_status,  
                            'added_by'=>'User',  
                            'by_email'=>$userdata['email'],  
                            'for_user'=>$userdata['email'],  
                            'to_user'=>'',  
                            'restaurant_name'=>$hoteldata['restaurant_name'],  
                            'restaurant_date'=>$book_date,  
                            'restaurant_time'=>$booking_time[$key],  
                            'no_of_people'=>$booking_pax[$key],  
                            'reason'=>$reason,  
                            'admin_note	'=>'',
                        );
                        $this->db->insert('ms-booking-logs',$data);
                        
                    $der = array(
                        'modify_date'=>date('Y-m-d H:i:s'),
                    );
                    $this->db->where('id',$booking_id);
                    $this->db->update('ms-booking',$der);
                    }
                }
            }
          }
        $book_status = $this->check_booking_status($booking_id);
        $datain = array(
            'booking_status' => $book_status
        );
        $this->db->where('id', $booking_id);
        $this->db->update('ms-booking', $datain);
        return $data;
    }
    
    function get_user_booking_datewise($user_id,$book_date){
        $this->db->select('id');
      $this->db->where('user_id',$user_id);
      $this->db->where('booking_date',$book_date);
        $query = $this->db->get('ms-booking-list');
        return $query->num_rows();
    }
    function final_restaurant_booking(){
        $user_id = $this->session->userdata('mes_user_id');
        $count = $this->get_count_booking_by_userid($user_id);
        if($count == 0){
            $booking_date = $this->input->post('booking_date');
            $booking_time = $this->input->post('booking_time');
            $booking_pax = $this->input->post('booking_pax');
            $booking_restid = $this->input->post('booking_restid');
            $booking_reason = $this->input->post('booking_reason');
            $booking_deposite = $this->input->post('booking_deposite');
            $card_number = $this->input->post('card_number');
            $card_number = $this->encrypt->encode($card_number);
            $exp_month = $this->input->post('exp_month');
            $exp_month = $this->encrypt->encode($exp_month);
            $exp_year = $this->input->post('exp_year');
            $exp_year = $this->encrypt->encode($exp_year);
            $security_code = $this->input->post('security_code');
            $security_code = $this->encrypt->encode($security_code);
            $card_holder = $this->input->post('card_holder');
            $card_holder = $this->encrypt->encode($card_holder);
            $data = array(
              'user_id'=>$user_id,  
              'booking_time'=>date('Y-m-d h:i:s'),  
              'card_number'=>$card_number,  
              'exp_month'=>$exp_month,  
              'exp_year'=>$exp_year,  
              'cvv'=>$security_code,  
              'card_holder'=>$card_holder,  
              'modify_date'=>date('Y-m-d h:i:s'),
            );
            $this->db->insert('ms-booking',$data);
            $booking_id = $this->db->insert_id();
            if(!empty($booking_date)){
                foreach($booking_date as $key => $date){
                    $token =$this->generateRandomString();
                    if($booking_restid[$key] != ''){
                        $status = 'booked';
                    }
                    else{
                        $status = 'skip';
                    }
                    $data = array(
                        'booking_id'=>$booking_id,  
                        'user_id'=>$user_id,  
                        'booking_date'=>date('Y-m-d',strtotime($booking_date[$key])),  
                        'booking_time'=>$booking_time[$key],  
                        'booking_pax'=>$booking_pax[$key],  
                        'booking_restid'=>$booking_restid[$key],  
                        'booking_status'=>$status,  
                        'booking_reason'=>$booking_reason[$key],  
                        'booking_deposite'=>$booking_deposite[$key],
                        'token'=>$token,
                        'modify_date'=>date('Y-m-d h:i:s'),
                        'created_date'=>date('Y-m-d H:i:s'),
                      );
                      $this->db->insert('ms-booking-list',$data);

                    //inserted log in create booking
                        $book_status = 'Booking Created';
                        $userdata = $this->get_user_detail_byuserid($user_id);
                        $hoteldata = $this->get_restaurant_detail($booking_restid[$key]);
                        if(empty($hoteldata)){ $hoteldata['restaurant_name'] = '';}
                        if($status == 'skip'){ $reason = $booking_reason[$key];}else{ $reason = '';}
                        $data = array(
                            'timestamp'=>date('Y-m-d h:i:s'),  
                            'booking_id'=>$booking_id,  
                            'action'=> $book_status,  
                            'added_by'=>'User',  
                            'by_email'=>$userdata['email'],  
                            'for_user'=>$userdata['email'],  
                            'to_user'=>'',  
                            'restaurant_name'=>$hoteldata['restaurant_name'],  
                            'restaurant_date'=>date('Y-m-d',strtotime($booking_date[$key])),  
                            'restaurant_time'=>$booking_time[$key],  
                            'no_of_people'=>$booking_pax[$key],  
                            'reason'=>$reason,  
                            'admin_note	'=>'',
                        );
                        $this->db->insert('ms-booking-logs',$data);
                }
            }
            $book_status = $this->check_booking_status($booking_id);
            $datain = array(
                'booking_status' => $book_status
            );
            $this->db->where('id', $booking_id);
            $this->db->update('ms-booking', $datain);
            return $data;
        }
        else{
            return 1;
        }
    }
    function confirm_delete_invite($from_id,$to_id,$listid){
        $this->db->where('user_id',$from_id);
        $this->db->where('id',$listid);
        $query = $this->db->get('ms-booking-list');
        if($query->num_rows() > 0){
            $row = (array)$query->row();
            $guests = $row['guests'];
            $exp = explode(',',$guests);
            if(!empty($exp)){
                $gst=[];
                foreach($exp as $usr){
                    if($usr != $to_id){
                        array_push($gst,$usr);
                    }
                }
                if(!empty($gst)){ $guests = implode(',',$gst); }
                else{ $guests = ''; }
                $data = array('guests'=>$guests);
                $this->db->where('user_id',$from_id);
                $this->db->where('id',$listid);
                $this->db->update('ms-booking-list',$data);

                $this->db->where('from_id',$from_id);
                $this->db->where('to_id',$to_id);
                $this->db->where('booking_list_id',$listid);
                $this->db->delete('ms-guest-invite');
            
            $data = array(
                'booking_status'=>'cancel',
                'booking_reason	'=>'Primary removed you.',
                'ref_id'=>'0'
            ); 
            $this->db->where('user_id',$to_id);
            $this->db->where('ref_id',$listid);
            $this->db->update('ms-booking-list',$data);

            $bookdata = $this->get_booking_date_detail($listid);
            $der = array(
                'modify_date'=>date('Y-m-d H:i:s'),
            );
            $this->db->where('id',$bookdata['booking_id']);
            $this->db->update('ms-booking',$der);
            $book_status = $this->check_booking_status($bookdata['booking_id']);
            $datain = array(
                'booking_status' => $book_status
            );
            $this->db->where('id', $bookdata['booking_id']);
            $this->db->update('ms-booking', $datain);
            return $data;
            }
        }
        else{
            return 1;
        }
    }
    function check_timeslot_already_booked($booking_date,$booking_time,$booking_pax,$booking_restid){
        $return = 1;
        $this->db->where('restaurant_id',$booking_restid);
        $this->db->where('time',$booking_time);
        $this->db->where('date',date('Y-m-d',strtotime($booking_date)));
        $this->db->where('size',$booking_pax);
        $qry = $this->db->get('ms-restaurant-tables');
        if($qry->num_rows() > 0){
            $row1 = (array)$qry->row();
            $capacity = $row1['capacity'];
            $this->db->where('booking_restid',$booking_restid);
            $this->db->where('booking_time',$booking_time);
            $this->db->where('booking_date',date('Y-m-d',strtotime($booking_date)));
            $this->db->where('booking_pax',$booking_pax);
			$this->db->where('booking_status','booked');
            $this->db->where('ref_id','0');
            $qry2 = $this->db->get('ms-booking-list');
            if($qry2->num_rows() >= $capacity){
                $return = 1;
            }
            else{
                $return = 0;
            }
        }
        return $return;
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


    function generateRandomString($length = 10) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, strlen($characters) - 1)];
	    }
	    return $randomString;
	}
    function get_booking_detail_byuserid($user_id){
        $this->db->where('user_id',$user_id);
        $query = $this->db->get('ms-booking');
        return (array)$query->row();
    }
    function get_user_detail_byuserid($user_id){
        $this->db->where('id',$user_id);
        $this->db->where('role','1');
        $query = $this->db->get('ms-admin');
        return (array)$query->row();
    }
    function get_user_detail_byemail($email){
        $where = "( (email = '$email' OR alternate_email = '$email') AND role = '1')";
        $this->db->where($where);
        $query = $this->db->get('ms-admin');
        return (array)$query->row();
    }
    function get_booking_date_detail($id){
        $this->db->where('id',$id);
        $query = $this->db->get('ms-booking-list');
        return (array)$query->row();
    }
    function get_email_exist_not_user($email){
        $where = "( (email = '$email' OR alternate_email = '$email') AND role = '1')";
        $this->db->where($where);
        $query = $this->db->get('ms-admin');
        return $query->num_rows();
    }
    function pending_invite_userid($to_id){
        $where = "(to_id = '$to_id' AND status = 'invite')";
        $this->db->where($where);
        $query = $this->db->get('ms-guest-invite');
        return (array)$query->row();
    }
    function check_user_already_notify($list_id,$from_id,$to_id){
        $where = "(booking_list_id = '$list_id' AND from_id = '$from_id' AND to_id = '$to_id' AND status != 'decline')";
        $this->db->where($where);
        $query = $this->db->get('ms-guest-invite');
        return $query->num_rows();
    }
    function get_booking_datelist_byid($booking_id,$status=''){

        $this->db->where("booking_restid != ''")->where("booking_id",$booking_id);
        // $this->db->where('booking_id',$booking_id);

        // Apply the status filter only if $status is not empty
        if (!empty($status)) {

            $this->db->where("booking_status", $status);
        }

        $this->db->order_by('booking_date','ASC');
        $query = $this->db->get('ms-booking-list');
        return $query->result_array();
    }
    function get_booking_date_detail_byidtoken($id,$token){
        $this->db->where('id',$id);
        $this->db->where('token',$token);
        $query = $this->db->get('ms-booking-list');
        return (array)$query->row();
    }
    function get_guest_invite_detail_byid_userid($id,$user_id){
        $this->db->where('id',$id);
        $this->db->where('to_id',$user_id);
        $query = $this->db->get('ms-guest-invite');
        return (array)$query->row();
    }
    function set_notification_guest($list_id,$from_id,$to_id){
        $this->db->where('booking_list_id',$list_id);
        $this->db->where('from_id',$from_id);
        $this->db->where('to_id',$to_id);
        $query = $this->db->get('ms-guest-invite');
        if($query->num_rows() > 0){
            $data = array(
                'status'=>'invite'
            );
            $this->db->where('booking_list_id',$list_id);
            $this->db->where('from_id',$from_id);
            $this->db->where('to_id',$to_id);
            $this->db->update('ms-guest-invite',$data);
        }
        else{
            $data = array(
                'booking_list_id'=>$list_id,
                'from_id'=>$from_id,
                'to_id'=>$to_id,
                'status'=>'invite'
            );
            $this->db->insert('ms-guest-invite',$data);
        }
        $this->db->where('booking_list_id',$list_id);
        $this->db->where('from_id',$from_id);
        $this->db->where('to_id',$to_id);
        $query = $this->db->get('ms-guest-invite');
        return (array)$query->row();
    }
    function get_notification_list($user_id){
        $this->db->where('from_id',$user_id);
        $this->db->or_where('to_id',$user_id);
        // $this->db->where('status','invite');
        $query = $this->db->get('ms-guest-invite');
        return $query->result_array();
    }
    function get_user_already_book_date($user_id,$book_date){
      $this->db->select('id');
      $this->db->where('user_id',$user_id);
      $this->db->where('booking_date',$book_date);
      $this->db->where('booking_status','booked');
        $query = $this->db->get('ms-booking-list');
        return $query->num_rows();
    }
    function get_admin_list_sendemail($email_template){
        $this->db->select('email');
        $this->db->like('notifications',$email_template);
        $query = $this->db->get('ms-admin');
        $array = $query->result_array();
        $result = [];
        if(!empty($array)){
            foreach($array as $val){
                array_push($result,$val['email']);
            }
        }
        return $result;
    }
    function invitation_modify_byuser($invite_id,$status){
        $user_id = $this->session->userdata('mes_user_id');
        $invite_detail = $this->get_guest_invite_detail_byid_userid($invite_id,$user_id);
        $booking_list = $this->get_booking_date_detail($invite_detail['booking_list_id']);
        $booking_id = $booking_list['booking_id'];
        if($invite_detail['status'] == 'invite'){
            if($status == 'accept'){
                $this->db->where('user_id',$user_id);
                $query = $this->db->get('ms-booking');
                
                $book_date = $booking_list['booking_date'];
                $guests = $booking_list['guests'];
                if($query->num_rows() > 0){
                    $booking_id = $query->row()->id;
                    $this->db->where('booking_date',$book_date);
                    $this->db->where('booking_id',$booking_id);
                    $this->db->delete('ms-booking-list');
                }
                else{
                    $dt = array(
                        'user_id'=>$user_id,
                        'booking_time'=>date('Y-m-d h:i:s'),
                        'modify_date'=>date('Y-m-d h:i:s'),
                    );
                    $this->db->insert('ms-booking',$dt);
                    $booking_id = $this->db->insert_id();
                }
                if($guests != ''){
                    $exp = explode(',',$guests);
                    array_push($exp,$user_id);
                    $guests = implode(',',$exp);
                }
                else{
                    $guests = $user_id;
                }
                $count = $this->get_user_already_book_date($user_id,$book_date);
                if($count > 0){
                    return 1;
                }
                else{
                    $this->db->select('id');
                    $this->db->where('user_id',$user_id);
                    $this->db->where('booking_date',$book_date);
                    $query = $this->db->get('ms-booking-list');
                    $cnt = $query->num_rows();
                    $ret = array(
                        'booking_id'=>$booking_id,
                        'user_id'=>$user_id,
                        'booking_date'=>$booking_list['booking_date'],
                        'booking_time'=>$booking_list['booking_time'],
                        'booking_pax'=>$booking_list['booking_pax'],
                        'booking_restid'=>$booking_list['booking_restid'],
                        'booking_status'=> 'booked',
                        'booking_deposite'=>$booking_list['booking_deposite'],
                        'ref_id'=>$booking_list['id'],
                        'guests'=>'',
                        'modify_date'=>date('Y-m-d h:i:s'),
                        'created_date'=>date('Y-m-d H:i:s'),
                    );
                    if($cnt > 0){
                        $this->db->update('ms-booking-list',$ret);
                    }
                    else{
                        $this->db->insert('ms-booking-list',$ret);
                    }
                     //inserted log in create booking
                    $book_status = 'Invitation Accepted';
                    $fromuserdata = $this->get_user_detail_byuserid($invite_detail['from_id']);
                    $touserdata = $this->get_user_detail_byuserid($user_id);
                    $hoteldata = $this->get_restaurant_detail($booking_list['booking_restid']);
                    $data = array(
                        'timestamp'=>date('Y-m-d h:i:s'),  
                        'booking_id'=>$booking_id,  
                        'action'=> $book_status,  
                        'added_by'=>'User',  
                        'by_email'=>$fromuserdata['email'],  
                        'for_user'=>$fromuserdata['email'],  
                        'to_user'=>$touserdata['email'],
                        'restaurant_name'=>$hoteldata['restaurant_name'],  
                        'restaurant_date'=>date('Y-m-d',strtotime($booking_list['booking_date'])),  
                        'restaurant_time'=>$booking_list['booking_time'],  
                        'no_of_people'=>$booking_list['booking_pax'],  
                        'reason'=>'',  
                        'admin_note	'=>'',
                    );
                    $this->db->insert('ms-booking-logs',$data);
                    $decline_reason = $this->input->post('decline_reason');
                    $data = array(
                        'status'=>$status,
                        'decline_reason'=>$decline_reason,
                    );
                    $this->db->where('id',$invite_id);
                    $this->db->update('ms-guest-invite',$data);
                    $der = array(
                        'modify_date'=>date('Y-m-d H:i:s'),
                    );
                    $this->db->where('id',$booking_id);
                    $this->db->update('ms-booking',$der);
                    $wer = array(
                        'guests'=>$guests,
                        'modify_date'=>date('Y-m-d h:i:s'),
                    );
                    $this->db->where('id',$invite_detail['booking_list_id']);
                    $this->db->update('ms-booking-list',$wer);
                    $data['booking_id'] = $booking_id;
                    $data['from_id'] = $invite_detail['from_id'];
                    $data['list_id'] = $invite_detail['booking_list_id'];
                    $book_status = $this->check_booking_status($booking_id);
                    $datain = array(
                        'booking_status' => $book_status
                    );
                    $this->db->where('id', $booking_id);
                    $this->db->update('ms-booking', $datain);
                    return $data;
                }
            }
            else{
                $decline_reason = $this->input->post('decline_reason');
                $data = array(
                    'status'=>$status,
                    'decline_reason'=>$decline_reason
                );
                $this->db->where('id',$invite_id);
                $this->db->update('ms-guest-invite',$data);
                $data['from_id'] = $invite_detail['from_id'];
                $data['list_id'] = $invite_detail['booking_list_id'];
                $data['booking_id'] = $booking_id;
                return $data;
            }
        }
        else{
            return 1;
        }
    }
    public function cancel_reservation_date(){
        $cancellation = $this->input->post('cancellation');
        $id = $this->input->post('cancel_booking_listid');
        $user_id = $this->session->userdata('mes_user_id');
        $result = $this->get_booking_date_detail($id);
        //inserted log in create booking
        $book_status = 'Booking Cancelled';
        $userdata = $this->get_user_detail_byuserid($user_id);
        $hoteldata = $this->get_restaurant_detail($result['booking_restid']);
        $data = array(
            'timestamp'=>date('Y-m-d h:i:s'),  
            'booking_id'=>$result['booking_id'],  
            'action'=> $book_status,  
            'added_by'=>'User',  
            'by_email'=>$userdata['email'],  
            'for_user'=>$userdata['email'],  
            'to_user'=>'',  
            'restaurant_name'=>$hoteldata['restaurant_name'],  
            'restaurant_date'=>date('Y-m-d',strtotime($result['booking_date'])),  
            'restaurant_time'=>$result['booking_time'],  
            'no_of_people'=>$result['booking_pax'],  
            'reason'=>$cancellation,  
            'admin_note	'=>'',
        );
        $this->db->insert('ms-booking-logs',$data);



        $this->modify_invited_guests_list($id);
        $data = array(
            'booking_status'=>'cancel',
            'ref_id'=>'0',
            'booking_reason'=>$cancellation,
            'modify_date'=>date('Y-m-d h:i:s'),
        );
        $this->db->where('id',$id);
        $this->db->where('user_id',$user_id);
        $this->db->update('ms-booking-list',$data);

       
        $der = array(
            'modify_date'=>date('Y-m-d H:i:s'),
        );
        $this->db->where('id',$result['booking_id']);
        $this->db->update('ms-booking',$der);
        $book_status = $this->check_booking_status($result['booking_id']);
        $datain = array(
            'booking_status' => $book_status
        );
        $this->db->where('id', $result['booking_id']);
        $this->db->update('ms-booking', $datain);
        return $data;
    }
    public function get_rating_list_by_restid($rest_id){
        $this->db->where('restaurant_id',$rest_id);
        $query = $this->db->get('ms-restaurant-reviews');
        return $query->result_array();
    }
    public function modify_invited_guests_list($id){
        $this->db->where('id',$id);
        $query = $this->db->get('ms-booking-list');
        if($query->num_rows() > 0){
            $row = $query->row();
            $guests = $row->guests;
            $ref_id = $row->ref_id;
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
                );
                $this->db->where('id',$id);
                $this->db->update('ms-booking-list',$dt);
                $data = array(
                    'ref_id'=>'0',
                    'guests'=>$remain,
                    'modify_date'=>date('Y-m-d h:i:s'),
                );
                $this->db->where('user_id',$next_host);
                $this->db->where('ref_id',$id);
                $this->db->update('ms-booking-list',$data);

                $result = $this->get_booking_date_detail($id);
                $der = array(
                    'modify_date'=>date('Y-m-d H:i:s'),
                );
                $this->db->where('id',$result['booking_id']);
                $this->db->update('ms-booking',$der);
                $book_status = $this->check_booking_status($result['booking_id']);
                $datain = array(
                    'booking_status' => $book_status
                );
                $this->db->where('id', $result['booking_id']);
                $this->db->update('ms-booking', $datain);
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
                            'modify_date'=>date('Y-m-d h:i:s'),
                        );
                        $this->db->where('id',$ref_id);
                        $this->db->update('ms-booking-list',$dt);
                        
                        $result = $this->get_booking_date_detail($ref_id);
                        $der = array(
                            'modify_date'=>date('Y-m-d H:i:s'),
                        );
                        $this->db->where('id',$result['booking_id']);
                        $this->db->update('ms-booking',$der);
                    }
                }
                $book_status = $this->check_booking_status($result['booking_id']);
                $datain = array(
                    'booking_status' => $book_status
                );
                $this->db->where('id', $result['booking_id']);
                $this->db->update('ms-booking', $datain);
            }
        }
    }
    public function get_cancel_reservations(){
        $user_id = $this->session->userdata('mes_user_id');
        $this->db->where('booking_status','cancel');
        $this->db->where('user_id',$user_id);
        $query = $this->db->get('ms-booking-list');
        return $query->result_array();
    }
    public function get_hostname_byrefid($ref_id){
        $this->db->where('id',$ref_id);
        $query = $this->db->get('ms-booking-list');
        if($query->num_rows() > 0){
            $row = $query->row();
            $user_id = $row->user_id;
            $user_array = $this->get_user_detail_byuserid($user_id);
            if(!empty($user_array)){
                return $user_array['full_name'];
            }
            else{
                return '';
            }
        }
        else{
            return '';
        }
    }
    public function get_total_ratings_byrestid($rest_id){
        $this->db->where('restaurant_id',$rest_id);
        $query = $this->db->get('ms-restaurant-reviews');
        return $query->num_rows();
    }
    public function get_total_number_ratings_byrestid($number,$rest_id){
        $max = $number;
        $min = $number - 0.5;
        $where = "((rating = '$max' OR rating = '$min') AND restaurant_id='$rest_id')";
        $this->db->where($where);
        $query = $this->db->get('ms-restaurant-reviews');
        return $query->num_rows();
    }
    public function get_average_rating_restid($rest_id){
        $query = $this->db->query("SELECT AVG(rating) AS average FROM `ms-restaurant-reviews` WHERE restaurant_id='$rest_id'");
        return $query->row()->average;
    }
}