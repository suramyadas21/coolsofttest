<?php
class Products_image_model extends CI_Model {
 
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
    * @param int $product_imageid 
    * @return array
    */
    public function get_product_imageby_id($id)
    {
		$this->db->select('*');
		$this->db->from('product_image');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->result_array(); 
    }

    /**
    * Fetch products data from the database
    * possibility to mix search, filter and order
    * @param int $manufacuture_id 
    * @param string $search_string 
    * @param strong $order
    * @param string $order_type 
    * @param int $limit_start
    * @param int $limit_end
    * @return array
    */
    public function get_products($product_imagetype_id=null, $search_string=null, $order=null, $order_type='Asc', $limit_start, $limit_end)
    {
	    
		$this->db->select('products.id');
		$this->db->select('products.name');
		$this->db->select('products.stock');
		$this->db->select('products.cost_price');
		$this->db->select('products.sell_price');
		$this->db->select('products.product_imagetype_id');
		$this->db->select('product_imagetype.name as product_imagetype_name');
		$this->db->from('product_image');
		if($product_imagetype_id != null && $product_imagetype_id != 0){
			$this->db->where('product_imagetype_id', $product_imagetype_id);
		}
		if($search_string){
			$this->db->like('name', $search_string);
		}

		$this->db->join('product_imagetype', 'products.product_imagetype_id = product_imagetype.id', 'left');

		$this->db->group_by('products.id');

		if($order){
			$this->db->order_by($order, $order_type);
		}else{
		    $this->db->order_by('id', $order_type);
		}


		$this->db->limit($limit_start, $limit_end);
		//$this->db->limit('4', '4');


		$query = $this->db->get();
		
		return $query->result_array(); 	
    }

    /**
    * Count the number of rows
    * @param int $product_imagetype_id
    * @param int $search_string
    * @param int $order
    * @return int
    */
    function count_products($product_imagetype_id=null, $search_string=null, $order=null)
    {
		$this->db->select('*');
		$this->db->from('product_image');
		if($product_imagetype_id != null && $product_imagetype_id != 0){
			$this->db->where('product_imagetype_id', $product_imagetype_id);
		}
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
    function store_product($data)
    {
		$insert = $this->db->insert('product_image', $data);
	    return $insert;
	}

    /**
    * Update product
    * @param array $data - associative array with data to store
    * @return boolean
    */
    function update_product($id, $data)
    {
		$this->db->where('id', $id);
		$this->db->update('product_image', $data);
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
    * Delete product
    * @param int $id - product id
    * @return boolean
    */
	function delete_product($id){
		$this->db->where('id', $id);
		$this->db->delete('products'); 
	}
	
	
 
}
?>	
