<?php
class Product_type_model extends CI_Model {
 
    /**
    * Responsable for auto load the database
    * @return void
    */
    public function __construct()
    {
        $this->load->database();
    }

    /**
    * Get product by his is
    * @param int $product_id 
    * @return array
    */
    public function get_product_type_by_id($id)
    {
		$this->db->select('*');
		$this->db->from('product_type');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->result_array(); 
    }    

    /**
    * Fetch product_type data from the database
    * possibility to mix search, filter and order
    * @param string $search_string 
    * @param strong $order
    * @param string $order_product_type 
    * @param int $limit_start
    * @param int $limit_end
    * @return array
    */
    public function get_product_type($search_string=null, $order=null, $order_product_type='Asc', $limit_start=null, $limit_end=null)
    {
	    
		$this->db->select('*');
		$this->db->from('product_type');

		if($search_string){
			$this->db->like('name', $search_string);
		}
		$this->db->group_by('id');

		if($order){
			$this->db->order_by($order, $order_product_type);
		}else{
		    $this->db->order_by('id', $order_product_type);
		}

        if($limit_start && $limit_end){
          $this->db->limit($limit_start, $limit_end);	
        }

        if($limit_start != null){
          $this->db->limit($limit_start, $limit_end);    
        }
        
		$query = $this->db->get();
		
		return $query->result_array(); 	
    }

    /**
    * Count the number of rows
    * @param int $search_string
    * @param int $order
    * @return int
    */
    function count_product_type($search_string=null, $order=null)
    {
		$this->db->select('*');
		$this->db->from('product_type');
		if($search_string){
			$this->db->like('name', $search_string);
		}
		if($order){
			$this->db->order_by($order, 'Asc');
		}else{
		    $this->db->order_by('id', 'Asc');
		}
		$query = $this->db->get();
		return $query->num_rows();        
    }

    /**
    * Store the new item into the database
    * @param array $data - associative array with data to store
    * @return boolean 
    */
    function store_product_type($data)
    {
		$insert = $this->db->insert('product_type', $data);
	    return $insert;
	}

    /**
    * Update product_type
    * @param array $data - associative array with data to store
    * @return boolean
    */
    function update_product_type($id, $data)
    {
		$this->db->where('id', $id);
		$this->db->update('product_type', $data);
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
			return true;
		}else{
			return false;
		}
	}

    /**
    * Delete product_typer
    * @param int $id - product_type id
    * @return boolean
    */
	function delete_product_type($id){
		$this->db->where('id', $id);
		$this->db->delete('product_type'); 
	}
 
}
?>	
