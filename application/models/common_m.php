<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Common_m extends CI_Model {

    var $child_r;

    function search_by_product_r(){
        $this->db->select('*');
        $this->db->from('page');
        $this->db->where('page.published', 0); 
        $query = $this->db->get();
        
        return $query;
    }

    function search_by_printer_r(){
        $this->db->select('*');
        $this->db->from('printer');
        $query = $this->db->get();
        
        return $query;
    }

    function get_menu($id){
        $this->db->select('*');
        $this->db->from('page');
        $this->db->join('menu_page_rel', 'menu_page_rel.page_id = page.id');
        $this->db->where('menu_page_rel.menu_id', $id); 
        $this->db->where('page.published', 0); 
		$this->db->order_by("page.sort_order", "asc");
        $query = $this->db->get();
        
        return $query;
    }

    function sub_menu_printer_list($id){
        
        $this->db->select('*');
        $this->db->from('printer');        
        $this->db->where('parent_printer', $id);
        $this->db->where('published', 0);
        // $this->db->order_by("printer.sort_order", "asc");
        $this->db->order_by("printer_name", "asc");
        $this->db->distinct(); 
        $query = $this->db->get();
        
        return $query;
    }

    function related_printer_list($id){
        
        $this->db->select('*');
        $this->db->from('printer');
        $this->db->join('page_printer_rel', 'page_printer_rel.printer_id = printer.id');
        $this->db->where('page_printer_rel.page_id', $id);
        $this->db->where('printer.published', 0);
        $query = $this->db->get();
        
        return $query;
    }

    function sub_menu($id){
        $this->db->select('*');
        $this->db->from('page');
        $this->db->join('page_self_rel', 'page_self_rel.page_id = page.id');
        $this->db->where('page_self_rel.parent_page_id', $id); 
        $this->db->where('page.published', 0); 
        $this->db->order_by("page.sort_order", "asc");
        $query = $this->db->get();
        
        return $query;
    }

    function sub_menu_printer_list_data($id){
        $this->db->select('*');
        $this->db->from('page');
        $this->db->join('page_self_rel', 'page_self_rel.page_id = page.id');
        $this->db->where('page_self_rel.parent_page_id', $id); 
        $this->db->where('page.published', 0); 
        $this->db->where('page.show_in_product_list', 0); 
        $this->db->order_by("page.product_no", "asc");
        $query = $this->db->get();
        
        return $query;
    }

    function sub_menu_printer_r($id){
        $this->db->select('*');
        $this->db->from('page');
        $this->db->join('page_printer_rel', 'page_printer_rel.page_id = page.id');
        $this->db->where('page_printer_rel.printer_id', $id); 
        $this->db->where('page.published', 0); 
        $this->db->order_by("page.sort_order", "asc");        
        $query = $this->db->get();
        
        return $query;
    }

    function get_printer_type_info($id,$printr_type){
        $this->db->select('*');
        $this->db->from('page');
        $this->db->join('page_self_rel', 'page_self_rel.page_id = page.id');
        $this->db->where('page_self_rel.parent_page_id', $id); 
        $this->db->where('page.printer_type', $printr_type); 
        $this->db->where('page.published', 0); 
        $query = $this->db->get();
        
        return $query;   
    }

    function sub_menu_printer($id){
        $this->db->select('*');
        $this->db->from('page');
        $this->db->join('page_self_rel', 'page_self_rel.page_id = page.id');
        $this->db->where('page_self_rel.parent_page_id', $id); 
        $this->db->where('page.published', 0); 
        $this->db->group_by('printer_type');
        $query = $this->db->get();
        
        return $query;
    }

    function get_parent_page($id){
        $this->db->select('*');
        $this->db->from('page');
        $this->db->join('page_self_rel', 'page_self_rel.parent_page_id = page.id');
        $this->db->where('page_self_rel.page_id', $id); 
        $this->db->where('page.published', 0); 
        $query = $this->db->get();

        foreach($query->result() as $q){
            return $q;
        }
    }

    function get_child_page($id){
        $this->db->select('*');
        $this->db->from('page');
        $this->db->join('page_self_rel', 'page_self_rel.page_id = page.id');
        $this->db->where('page_self_rel.parent_page_id', $id); 
        $this->db->where('page.published', 0); 
        $query = $this->db->get();

        return $query;
    }

    function get_primary_photo($id){
        $this->db->select('*');
        $this->db->from('primary_gallery_photo');
        $this->db->where('primary_gallery_photo.page_id', $id); 
        $this->db->where('primary_gallery_photo.is_primary_photo', 1); 
        $query = $this->db->get();

        foreach($query->result() as $q){
            return $q;
        }
    }
	
	function get_printer_photo($id){
        $this->db->select('*');
        $this->db->from('printer_photos');
        $this->db->where('printer_photos.printer_id', $id);         
        $query = $this->db->get();

        foreach($query->result() as $q){
            return $q;
        }
    }

    function sitemap_inner_links($page_id) {
        $sql1 = 
            "SELECT psr.page_id, page.title
            FROM page_self_rel psr 
            INNER JOIN page ON psr.page_id = page.id
            WHERE psr.parent_page_id = {$page_id}
            ";
        
        $sql1_q = $this->db->query($sql1);

        if ($sql1_q->num_rows() != 0) {
            echo '<ul>';
            foreach ($sql1_q->result() as $item) {
                echo '<li>' . anchor("page/index/{$item->page_id}", $item->title);
                $this->common_m->sitemap_inner_links($item->page_id);
                echo '</li>';
            }
            echo '</ul>';
            echo '</li>';
        } else {
            // $sql2 = "SELECT title FROM page WHERE id = {$page_id}";
            // $sql2_q = $this->db->query($sql2);
            // $data= $sql2_q->row();
            // echo $data->title;
        }
        
    }

    function sitemap()
    {
        $sql1 = 
            "SELECT id, title
            FROM page
            WHERE id NOT IN (SELECT page_id FROM page_self_rel)
            AND is_segment != 1 AND is_news != 1
            ORDER BY sort_order
            ";

        $sql1_q = $this->db->query($sql1);
        echo '<ul class="sitemap">';
        foreach ($sql1_q->result() as $level1) {
            echo '<li>' . anchor("page/index/{$level1->id}", $level1->title) ;
            $this->common_m->sitemap_inner_links($level1->id);
        }
        echo '</ul>';
    }

    function get_page_title($page_title = '', $home_page = FALSE) {

        if ($home_page == TRUE) {
            $page_title = $this->config->item('website_title');
            if ($this->config->item('website_subtitle')) {
                $page_title .= ' - ' . $this->config->item('website_subtitle');
            }
            return ucwords($page_title);
        }

        if (!empty($page_title)) {
            $page_title = $this->config->item('website_title') . ' - ' . $this->config->item('website_subtitle') . ' - ' . $page_title;
        } else {
            $page_title = $this->config->item('website_title');
        }

        return ucwords($page_title);
    }

    function build_slug($keywords) {
        foreach ($keywords as $key => $word) {
            $keywords[$key] = str_replace(' ', '-', $word);
        }
        return url_title(implode("-", $keywords));
    }

    function get_id_from_slug($slug) {
        $slug_ar = explode('-', htmlspecialchars($slug));
        $id = (int) $slug_ar[0];
        return $id;
    }

    function get_by_fields($select = '', $from, $where = '', $order_by = '', $limit = '', $start = 0) {
        if (empty($select)) {
            $this->db->select('*');
        } else {
            $select_str = implode(',', $select);
            $this->db->select($select_str);
        }

        $this->db->from($from);

        if (!empty($where)) {
            $this->db->where($where);
        }

        if (!empty($order_by)) {
            $this->db->order_by($order_by);
        }

        if (!empty($limit)) {
            $this->db->limit($limit, $start);
        }

        $query = $this->db->get();

        $response = array();

        if ($query->num_rows() == 1) {
            $response['query'] = $query;
            $response['num_rows'] = $query->num_rows();
            $response['data'] = $query->row();
            return $response;
        } else {
            $response['query'] = $query;
            $response['num_rows'] = $query->num_rows();
            return $response;
        }
    }

    function insert($table, $insert_data) {
        if ($this->db->insert($table, $insert_data)) {
            return true;
        }
        return false;
    }

    function update($table, $update_data, $where) {
        if ($this->db->update($table, $update_data, $where)) {
            return true;
        }
        return false;
    }

    public function update_status($invoice_id){

        $data = array(
                'status' => 0
            );
        $this->db->where('invoice_id', $invoice_id);
        $this->db->update('product_request', $data);

        return 'Paypall Status';
    }

    function footer_links($parent_page_id = 0) {
        $page_request = $this->common_m->get_by_fields('', 'page', array('parent_page_id' => $parent_page_id), 'sort_order');
        $page_q = $page_request['query'];
        if ($page_q->num_rows() != 0) {
            echo '<ul>';
            foreach ($page_q->result() as $page) {
                echo "<li>{$page->name}";
                $child_page_request = $this->common_m->get_by_fields('', 'page', array('parent_page_id' => $page->id), 'sort_order');
                $child_page_q = $child_page_request['query'];
                if ($child_page_q->num_rows() != 0) {
                    echo '<ul>';
                    foreach ($child_page_q->result() as $child_page) {
                        echo "<li>{$child_page->name}";
                        echo "</li>";
                    }
                    echo '</ul>';
                }
                echo "</li>";
            }
        }
        echo '</ul>';
    }

    function all_pages($parent_page_id = 0) {
        $page_request = $this->common_m->get_by_fields('', 'page', array('parent_page_id' => $parent_page_id), 'sort_order');
        $page_q = $page_request['query'];
        if ($page_q->num_rows() != 0) {

            echo "<ul id='nav'>";
            foreach ($page_q->result() as $page) {
                //echo  "<li>{$page->name}";
                echo "<li>";
                echo anchor("", $page->name);
                $this->common_m->all_pages($page->id);
            }

            echo '</li>';
            echo '</ul>';
        }
    }


    function invalid_child($page_id, $parent_page_id) {

        $resource = $this->common_m->get_by_fields('', 'page_self_rel', array('parent_page_id' => $page_id), '', 1);
        if($resource['num_rows'] != 0) {
            $data = $resource['data'];
            if($page_id == $parent_page_id) {
                return true;
            } elseif($data->page_id == $parent_page_id) {
                return true;
            } else {
                return $this->common_m->invalid_child($data->page_id, $parent_page_id);
            }
        }
    }

    function get_all_parent_pages($page_id) {
        /*$sql = "SELECT * FROM page_self_rel WHERE parent_page_id = {$page_id}";
        $query = $this->db->query($sql);
        if($query->num_rows != 0) {
            $data = $query->result();
            print_r($data);
            return $this->common_m->get_all_parents(36);
        } */

        // $this->db->limit(1);
        //$query = $this->db->get_where('page_self_rel', array('page_id' => $page_id));
        $sql = "SELECT page_self_rel.page_id, page_self_rel.parent_page_id, page.title as page_title
                FROM page
                LEFT JOIN page_self_rel ON page.id = page_self_rel.page_id
                WHERE page_self_rel.page_id = {$page_id} " ;
        $query = $this->db->query($sql);
        
        //$data = $query_1->row();
        
        // if parent of this page has parent then do recursive 
        // else return this one
        if($query->num_rows() == 0) {
            $query = $this->db->get_where('page', array('id' => $page_id));
            $data = $query->row();
            echo $data->title . ' > ';

        } else {
            
            $data = $query->row();
            $this->common_m->get_all_parent_pages($data->parent_page_id);
            
            echo $data->page_title . ' > ';
        }

    }

}

