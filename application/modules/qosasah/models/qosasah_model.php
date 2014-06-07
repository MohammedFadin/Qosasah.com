<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Qosasah_model extends BF_Model {

	protected $table_name	= "qosasah";
	protected $key			= "id";
	protected $soft_deletes	= false;
	protected $date_format	= "datetime";

	protected $log_user 	= FALSE;

	protected $set_created	= false;
	protected $set_modified = false;

	/*
		Customize the operations of the model without recreating the insert, update,
		etc methods by adding the method names to act as callbacks here.
	 */
	protected $before_insert 	= array();
	protected $after_insert 	= array();
	protected $before_update 	= array();
	protected $after_update 	= array();
	protected $before_find 		= array();
	protected $after_find 		= array();
	protected $before_delete 	= array();
	protected $after_delete 	= array();

	/*
		For performance reasons, you may require your model to NOT return the
		id of the last inserted row as it is a bit of a slow method. This is
		primarily helpful when running big loops over data.
	 */
	protected $return_insert_id 	= TRUE;

	// The default type of element data is returned as.
	protected $return_type 			= "object";

	// Items that are always removed from data arrays prior to
	// any inserts or updates.
	protected $protected_attributes = array();

	/*
		You may need to move certain rules (like required) into the
		$insert_validation_rules array and out of the standard validation array.
		That way it is only required during inserts, not updates which may only
		be updating a portion of the data.
	 */
	protected $validation_rules 		= array(
		array(
			"field"		=> "qosasah_snippet_post",
			"label"		=> "snippet",
			"rules"		=> "required|max_length[5000]"
		),
	);
	protected $insert_validation_rules 	= array();
	protected $skip_validation 			= FALSE;

	//--------------------------------------------------------------------

	/**
	 * [add description]
	 * @param array $data [description]
	 */
	public function add($data = array())
	{
		return $this->db->insert('qosasah_snippets', $data);
	}

	/**
	 * [get_categories description]
	 * @return [type] [description]
	 */
	public function get_categories()
	{
		$this->db->order_by('name', 'desc');
		return $this->db->get('qosasah_categories')->result_array();
	}

	/**
	 * [get_by_id description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function get_by_id($id)
	{
		$this->db->select('*');
		$this->db->from('bf_qosasah_snippets');
		$this->db->join('bf_users', 'bf_users.id = bf_qosasah_snippets.created_by');
		$this->db->where('bf_qosasah_snippets.id', $id);
		// Let's get the category
		$this->db->join('bf_qosasah_categories', 'bf_qosasah_categories.id = bf_qosasah_snippets.category');
		return $this->db->get()->row_array();
	}

	/**
	 * [get_latest description]
	 * @return [type] [description]
	 */
	public function get_latest()
	{
		$this->db->select('bf_qosasah_snippets.*');
		$this->db->select('bf_users.username, bf_users.id AS userid');
		$this->db->select('bf_qosasah_categories.id AS catid, bf_qosasah_categories.name AS language');
		$this->db->from('bf_qosasah_snippets');
		$this->db->join('bf_users', 'bf_users.id = bf_qosasah_snippets.created_by');
		$this->db->join('bf_qosasah_categories', 'bf_qosasah_categories.id = bf_qosasah_snippets.category');
		$this->db->limit(10);
		$this->db->order_by('id', 'desc');
		return $this->db->get()->result_array();
	}

	/**
	 * [get_all_status description]
	 * @return [type] [description]
	 */
	public function get_all_status()
	{
		$result['total_users'] = $this->db->count_all('bf_users');
		$result['total_snippets'] = $this->db->count_all('bf_qosasah_snippets');
		return $result;
	}
}
