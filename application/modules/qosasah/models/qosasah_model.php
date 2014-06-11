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
	 * This is a bit of haching, instead of having two methods
	 * I merged it into one
	 * @param [type] $id      [description]
	 * @param [type] $user_id [description]
	 */
	public function bookmark($id, $user_id)
	{
		$data = array(
			'user_id' => $user_id,
			'snippet_id' => $id
			);

		// Double check if snippet id is not a number
		if (!is_numeric($id)) return FALSE;

		$this->db->where($data);
		$is_bookmarked = $this->db->get('bf_qosasah_bookmarks')->num_rows();

		if ( !$is_bookmarked )
		{
			$this->db->insert('bf_qosasah_bookmarks', $data);
			$query_status = TRUE;
		}
		else
		{
			$this->db->delete('bf_qosasah_bookmarks', $data);
			$query_status = FALSE;
		}

		return $query_status;
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
		$this->db->select('bf_qosasah_snippets.*', FALSE);
		$this->db->select('bf_users.*', FALSE);				
		$this->db->select('bf_qosasah_categories.name AS language', FALSE);
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
	public function get_latest($limit, $start)
	{
		$this->db->where('bf_qosasah_snippets.private', '0');
		$this->db->select('bf_qosasah_snippets.*');
		$this->db->select('bf_users.username, bf_users.id AS userid');
		$this->db->select('bf_qosasah_categories.id AS catid, bf_qosasah_categories.name AS language');
		$this->db->from('bf_qosasah_snippets');
		$this->db->join('bf_users', 'bf_users.id = bf_qosasah_snippets.created_by');
		$this->db->join('bf_qosasah_categories', 'bf_qosasah_categories.id = bf_qosasah_snippets.category');
		$this->db->limit($limit, $start);
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

	/**
	 * [get_bookmarks description]
	 * @param  [type] $offset  [description]
	 * @param  [type] $user_id [description]
	 * @return [type]          [description]
	 */
	public function get_bookmarks($offset= NULL, $user_id)
	{
		if ( $offset )
		{
			$this->db->where('user_id', $user_id);
			$this->db->where('snippet_id', '19');
		}
		else
		{
			$this->db->where('user_id', $user_id);
			$this->db->select('snippet_id');			
		}
		$this->db->limit(10);
		$this->db->order_by('snippet_id', 'desc');
		
		// Have the snippet ids without keys
		$bookmarked_ids = array();

		foreach ($this->db->get('bf_qosasah_bookmarks')->result() as $bookmark) {
			$bookmarked_ids[] = $bookmark->snippet_id;	
		}	
		return $bookmarked_ids;
	}

	/**
	 * [get_top_snippets description]
	 * @return [type] [description]
	 */
	public function get_top_snippets()
	{
		// $this->db->select('*');
		// $this->db->from('bf_qosasah_snippets');
		// $this->db->where("`id` IN (SELECT count(*) AS top_bookmarks, 'snippet_id' FROM `bf_qosasah_bookmarks`  group by 'snippet_id' order by 'top_bookmarks' DESC LIMIT 5)", NULL, FALSE);
		// // $this->db->select('count(*) AS total_bookmarked, snippet_id');
		// // $this->db->from('bf_qosasah_bookmarks');
		// // $this->db->group_by('snippet_id');
		// // $this->db->order_by('total_bookmarked', 'DESC');
		// // $this->db->limit(5);
		$query = $this->db->query('
			SELECT * FROM 
			(
				(SELECT * FROM bf_qosasah_snippets WHERE private = 0) p1
			 INNER JOIN
			 	(SELECT snippet_id,count(*) AS total_bookmarked FROM bf_qosasah_bookmarks GROUP BY snippet_id
                ) p2
			 ON p1.id = p2.snippet_id
			)
            INNER JOIN
            (SELECT id AS catid, name AS language FROM bf_qosasah_categories) p3
            ON p1.category = p3.catid
			ORDER BY p2.total_bookmarked desc
			LIMIT 10
			');
		return $query->result_array();
	}

	public function get_top_users()
	{
		$query = $this->db->query('
			SELECT * FROM
			(SELECT * FROM bf_users) users_table
			inner join 
			(SELECT count(*) AS total_posted_snippets, created_by FROM bf_qosasah_snippets
			 WHERE private = 0 group by created_by ) snippets_table
			WHERE users_table.id = snippets_table.created_by
			LIMIT 10
			');
		return $query->result_array();
	}

	/**
	 * [get_my_snippets description]
	 * @param  [type] $user_id [description]
	 * @return [type]          [description]
	 */
	public function get_my_snippets($user_id)
	{
		$this->db->where('bf_qosasah_snippets.created_by', $user_id);
		$this->db->select('bf_qosasah_snippets.*', FALSE);				
		$this->db->select('bf_qosasah_categories.id as catid, bf_qosasah_categories.name as language', FALSE);		
		$this->db->from('bf_qosasah_snippets');
		$this->db->join('bf_qosasah_categories', 'bf_qosasah_categories.id = bf_qosasah_snippets.category');
		return $this->db->get()->result_array();

	}

		/**
	 * [get_my_bookmarked_snippets description]
	 * @param  [type] $user_id [description]
	 * @return [type]          [description]
	 */
	public function get_my_bookmarked_snippets($user_id)
	{
		$query = $this->db->query("
			SELECT * FROM
			(SELECT * FROM bf_qosasah_snippets where id IN 
			(
			    SELECT snippet_id FROM bf_qosasah_bookmarks WHERE user_id = {$user_id}
			)) snippets_table
			JOIN 
			(
				SELECT id AS catid, name AS language FROM bf_qosasah_categories
			) categories_table
			ON snippets_table.category = categories_table.catid
			JOIN 
			(SELECT id AS userid, username FROM bf_users) users_table
			ON users_table.userid = snippets_table.created_by
			");
		return $query->result_array();

	}

	/**
	 * [snippets_count description]
	 * @return [type] [description]
	 */
	public function snippets_count()
	{	
		$this->db->where('private', '0');
		return $this->db->count_all_results('bf_qosasah_snippets');
	}
}
