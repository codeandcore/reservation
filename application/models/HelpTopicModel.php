<?php
class HelpTopicModel extends CI_Model {
    public function __construct() {
        $this->load->database();
    }

    public function get_help_topics($page_id) {
        $query = $this->db->get_where('ms-help_topics', array('page_id' => $page_id));
        return $query->result_array();
    }

    public function get_help_topic($id) {
        $query = $this->db->get_where('ms-help_topics', array('id' => $id));
        return $query->row_array();
    }

    public function create_help_topic($data) {
        return $this->db->insert('ms-help_topics', $data);
    }

    public function update_help_topic($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('ms-help_topics', $data);
    }

    public function delete_help_topic($id) {
        $this->db->where('id', $id);
        return $this->db->delete('ms-help_topics');
    }
}
