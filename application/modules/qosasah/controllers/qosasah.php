<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * qosasah controller
 */
class qosasah extends Front_Controller
{

	//--------------------------------------------------------------------


	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->library("pagination");		
		$this->load->model('users/user_model');
		$this->load->library('users/auth');		
		$this->load->model('qosasah_model', null, true);
		$this->lang->load('qosasah');

		if ( $this->auth->is_logged_in() === TRUE) $this->set_current_user();

		Assets::add_module_js('qosasah', 'qosasah.js');
	}

	//--------------------------------------------------------------------


	/**
	 * Displays the homepage of the Bonfire app
	 *
	 * @return void
	 */
	public function index()
	{
		$this->load->library('installer_lib');
		$this->load->library('users/auth');
		$this->set_current_user();

		if (!$this->installer_lib->is_installed())
		{
			redirect( site_url('install') );
		}

       	$paging_config = array();
        $paging_config["base_url"] = site_url() . '/p/';
        $paging_config["total_rows"] = $this->qosasah_model->snippets_count();
        $paging_config["per_page"] = 10;
        $paging_config["uri_segment"] = 2;
        $paging_config['use_page_numbers']  = FALSE;

		/* This Application Must Be Used With BootStrap 3 *  */
		$paging_config['full_tag_open'] = "<ul class='pagination pagination-right'>";
		$paging_config['full_tag_close'] ="</ul>";
		$paging_config['num_tag_open'] = '<li>';
		$paging_config['num_tag_close'] = '</li>';
		$paging_config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$paging_config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$paging_config['next_link'] = 'أمام';
		$paging_config['prev_link'] = 'خلف';		
		$paging_config['next_tag_open'] = "<li>";
		$paging_config['next_tagl_close'] = "</li>";
		$paging_config['prev_tag_open'] = "<li>";
		$paging_config['prev_tagl_close'] = "</li>";
		$paging_config['first_link'] = 'الأولى';		
		$paging_config['first_tag_open'] = "<li>";
		$paging_config['first_tagl_close'] = "</li>";
		$paging_config['last_link'] = 'الأخيرة';		
		$paging_config['last_tag_open'] = "<li>";
		$paging_config['last_tagl_close'] = "</li>";


        $this->pagination->initialize($paging_config);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;

        // Get all the required data
		$param['total_snippets'] = $this->qosasah_model->get_latest($paging_config["per_page"], $page);
		$param['top_snippets'] = $this->qosasah_model->get_top_snippets();
		$param['top_users'] = $this->qosasah_model->get_top_users();
		$param_total_status = $this->qosasah_model->get_all_status(); 
		
		// If user is logged get all the bookmarks
		if ( class_exists('Auth') )
		{
			if ($this->auth->is_logged_in())
			{
				$param['is_bookmarked'] = $this->qosasah_model->get_bookmarks(NULL, $this->current_user->id);
			}
		}
			

		Template::set('snippets', $param);
		Template::set('status', $param_total_status);
		// Template::set('bookmarks', $param_bookmarks);
		Template::render();
	}//end index()

	//--------------------------------------------------------------------

	/**
	 * [add description]
	 */
	public function add()
	{
		if ( $this->auth->is_logged_in() === FALSE )
		{
			redirect('login');
		}
		
		// Lets check if there is a creation
		if ( isset( $_POST['snippet_create'] ) )
		{
			$this->form_validation->set_rules('snippet_title', 'snippet title', 'trim|required|min_length[5]|max_length[200]|xss_clean');
			$this->form_validation->set_rules('snippet_desc', 'snippet description', 'trim|required|min_length[5]|max_length[400]|xss_clean');
			$this->form_validation->set_rules('snippet_lang', 'snippet langauge', 'trim|required|xss_clean');
			$this->form_validation->set_rules('snippet_data', 'snippet', 'max_length[5000]');
			$this->form_validation->set_rules('snippet_url', 'snippet url', 'trim|min_length[5]|max_length[200]|xss_clean');

			if ( $this->form_validation->run() !== FALSE )
			{
				$data = array(
						'title'			=> $this->input->post('snippet_title'),
						'description'		=> $this->input->post('snippet_desc'),
						'snippet'		=> $this->input->post('snippet_data'),						
						'category'		=> $this->input->post('snippet_lang'),
						'url'	=> $this->input->post('snippet_url'),
						'created_by' => $this->current_user->id,
						'private' => $this->input->post('snippet_type'),
					);

				// Time to add the data
				if ( $id = $this->qosasah_model->add($data) )
				{
					redirect('');
				}
				else
				{
					Template::set_message('Problem While creating the snippet', 'error');
					redirect('qosasah/add');					
				}

			}
		}

		$param['categories'] = $this->qosasah_model->get_categories();

		Template::set_view('add_snippet');
		Template::set($param);
		Template::render('');
	}

	/**
	 * [FunctionName description]
	 * @param string $value [description]
	 */
	public function my_snippets()
	{
		if ( $this->auth->is_logged_in() === FALSE)
		{
			redirect('login');
		}

		$param = $this->qosasah_model->get_my_snippets($this->current_user->id);

		Template::set_view('my_snippets');
		Template::set('snippets', $param);
		Template::render('');	
	}

	public function my_favorite()
	{
		if ( $this->auth->is_logged_in() === FALSE)
		{
			redirect('login');
		}

		$param = $this->qosasah_model->get_my_bookmarked_snippets($this->current_user->id);
		Template::set_view('my_fav');
		Template::set('snippets', $param);
		Template::render();
	}

	public function view($id = NULL)
	{
		if ( !$id )
		{
			redirect('');
		}

		$param = $this->qosasah_model->get_by_id( $id );
		$param = isset( $param ) ? $param : null;

		if ( !$param )
		{
			redirect('');
		}

		Template::set_view('snippet_view');
		Template::set('page_title', '('.$param["language"].')'.$param['title']);
		Template::set('snippet',$param);
		Template::render('');
	}

	public function bookmark($id)
	{
		// if (!isset($id) OR !$this->auth->is_logged_in() ) echo "error"; exit;

		if ( $this->qosasah_model->bookmark($id, $this->current_user->id) )
		{
			echo "bookmarked";
		}
		else
		{
			echo "unbookmarked";
		}
	}

	public function get_snippet_ajaxed($id=NULL)
	{
		if ( !$id ) echo 'error';

		if ( $snippet_code = $this->qosasah_model->get_by_id($id) ) echo $snippet_code['snippet'];
	}

}