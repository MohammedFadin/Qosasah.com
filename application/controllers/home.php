<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Bonfire
 *
 * An open source project to allow developers get a jumpstart their development of CodeIgniter applications
 *
 * @package   Bonfire
 * @author    Bonfire Dev Team
 * @copyright Copyright (c) 2011 - 2013, Bonfire Dev Team
 * @license   http://guides.cibonfire.com/license.html
 * @link      http://cibonfire.com
 * @since     Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Home controller
 *
 * The base controller which displays the homepage of the Bonfire site.
 *
 * @package    Bonfire
 * @subpackage Controllers
 * @category   Controllers
 * @author     Bonfire Dev Team
 * @link       http://guides.cibonfire.com/helpers/file_helpers.html
 *
 */
class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->helper('application');
		$this->load->library('Template');
		$this->load->library('Assets');
		$this->lang->load('application');
		$this->load->library('events');
		$this->load->helper('form');
		$this->load->library("pagination");

		$this->load->model('qosasah/qosasah_model');

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

		$param['total_snippets'] = $this->qosasah_model->get_latest($paging_config["per_page"], $page);
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
	 * If the Auth lib is loaded, it will set the current user, since users
	 * will never be needed if the Auth library is not loaded. By not requiring
	 * this to be executed and loaded for every command, we can speed up calls
	 * that don't need users at all, or rely on a different type of auth, like
	 * an API or cronjob.
	 *
	 * Copied from Base_Controller
	 */
	protected function set_current_user()
	{
		if (class_exists('Auth'))
		{
			// Load our current logged in user for convenience
			if ($this->auth->is_logged_in())
			{
				$this->current_user = clone $this->auth->user();

				$this->current_user->user_img = gravatar_link($this->current_user->email, 22, $this->current_user->email, "{$this->current_user->email} Profile");

				// if the user has a language setting then use it
				if (isset($this->current_user->language))
				{
					$this->config->set_item('language', $this->current_user->language);
				}
			}
			else
			{
				$this->current_user = null;
			}

			// Make the current user available in the views
			if (!class_exists('Template'))
			{
				$this->load->library('Template');
			}
			Template::set('current_user', $this->current_user);
		}
	}

	/**
	 * [snippets_status description]
	 * @return [type] [description]
	 */
	public function snippets_status()
	{
		return $this->qosasah_model->get_all_status();

	}

	//--------------------------------------------------------------------
}//end class