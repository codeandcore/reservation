<?php
class HelpPageModel extends CI_Model {
    public function __construct() {
        $this->load->database();
    }

    public function get_help_pages() {
        $this->db->order_by('position', 'ASC');
        $query = $this->db->get('ms-help_pages');
        return $query->result_array();
    }

    public function get_help_page($id) {
        $query = $this->db->get_where('ms-help_pages', array('id' => $id));
        return $query->row_array();
    }

    public function create_help_page($data) {
        // Unset other new feature pages if this is a new feature page
        if ($data['is_new_feature']) {
            $this->db->update('ms-help_pages', array('is_new_feature' => 0));
        }
        return $this->db->insert('ms-help_pages', $data);
    }

    public function update_help_page($id, $data) {
        // Unset other new feature pages if this is a new feature page
        if ($data['is_new_feature']) {
            $this->db->update('ms-help_pages', array('is_new_feature' => 0));
        }
        $this->db->where('id', $id);
        return $this->db->update('ms-help_pages', $data);
    }

    public function delete_help_page($id) {
        $this->db->where('id', $id);
        return $this->db->delete('ms-help_pages');
    }

    public function search($query) {
        /**Wihout excluding New Features page */
        // // Search in ms-help_pages
        // $this->db->like('title', $query);
        // // $this->db->or_like('summary', $query);
        // $page_query = $this->db->get('ms-help_pages');
        // $page_results = $page_query->result_array();

        // // Search in ms-help_topics
        // $this->db->like('title', $query);
        // $this->db->or_like('content', $query);
        // $topic_query = $this->db->get('ms-help_topics');
        // $topic_results = $topic_query->result_array();

        // // Combine results
        // return array_merge($page_results, $topic_results);


        /**Excluding New Features page */
        // Search in ms-help_pages
        // Search in ms-help_pages
        $this->db->select('id, title, content, summary, image, created_at, updated_at');
        $this->db->from('ms-help_pages');
        // $this->db->where('exclude_from_search', 0); // Exclude pages with exclude_from_search = 1
        $this->db->where('is_new_feature', 0); // Exclude pages with is_new_feature = 1
        $this->db->group_start();
        $this->db->like('title', $query);
        $this->db->or_like('content', $query);
        $this->db->group_end();
        $page_query = $this->db->get();
        $page_results = $page_query->result_array();

        // Debug SQL query for pages
        // echo $this->db->last_query() . "<br>";

        // Search in ms-help_topics, excluding topics from excluded pages
        $this->db->select('topics.id, topics.page_id, topics.title, topics.content, pages.title as page_title');
        $this->db->from('ms-help_topics as topics');
        $this->db->join('ms-help_pages as pages', 'topics.page_id = pages.id', 'left');
        // $this->db->where('pages.exclude_from_search', 0); // Exclude topics from pages with exclude_from_search = 1
        $this->db->where('pages.is_new_feature', 0); // Exclude topics from pages with is_new_feature = 1
        $this->db->group_start();
        $this->db->like('topics.title', $query);
        $this->db->or_like('topics.content', $query);
        $this->db->group_end();
        $topic_query = $this->db->get();
        $topic_results = $topic_query->result_array();

        // Debug SQL query for topics
        // echo $this->db->last_query() . "<br>";

        // Combine results
        return array_merge($page_results, $topic_results);

    }

    public function update_page_positions($positions) {
        foreach ($positions as $id => $position) {
            $this->db->where('id', $id);
            $this->db->update('ms-help_pages', array('position' => $position));
        }
    }

    public function get_popular_topics() {
        $this->db->select('ms-help_topics.id, ms-help_topics.title,ms-help_topics.page_id, ms-help_pages.title as page_title');
        $this->db->from('ms-help_topics');
        $this->db->join('ms-help_pages', 'ms-help_topics.page_id = ms-help_pages.id');
        $this->db->where('ms-help_topics.include_in_popular', 1);
        $query = $this->db->get();
        return $query->result_array();
    }
}
