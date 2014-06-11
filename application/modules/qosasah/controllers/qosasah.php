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
		$this->load->model('users/user_model');
		$this->load->library('users/auth');		
		$this->load->model('qosasah_model', null, true);
		$this->lang->load('qosasah');

		if ( $this->auth->is_logged_in() === TRUE) $this->set_current_user();

		Assets::add_module_js('qosasah', 'qosasah.js');
	}

	//--------------------------------------------------------------------


	/**
	 * Displays a list of form data.
	 *
	 * @return void
	 */
	public function index()
	{

		$records = $this->qosasah_model->find_all();

		Template::set('records', $records);
		Template::render();
	}

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
						'type' => $this->input->post('snippet_type'),
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

		Template::set_view('my_fav');
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
		Template::set('page_title', $param['title']);
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