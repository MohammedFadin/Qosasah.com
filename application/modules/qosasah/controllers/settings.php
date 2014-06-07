<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * settings controller
 */
class settings extends Admin_Controller
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

		$this->auth->restrict('Qosasah.Settings.View');
		$this->load->model('qosasah_model', null, true);
		$this->lang->load('qosasah');
		
		Template::set_block('sub_nav', 'settings/_sub_nav');

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

		// Deleting anything?
		if (isset($_POST['delete']))
		{
			$checked = $this->input->post('checked');

			if (is_array($checked) && count($checked))
			{
				$result = FALSE;
				foreach ($checked as $pid)
				{
					$result = $this->qosasah_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('qosasah_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('qosasah_delete_failure') . $this->qosasah_model->error, 'error');
				}
			}
		}

		$records = $this->qosasah_model->find_all();

		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage qosasah');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a qosasah object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Qosasah.Settings.Create');

		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_qosasah())
			{
				// Log the activity
				log_activity($this->current_user->id, lang('qosasah_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'qosasah');

				Template::set_message(lang('qosasah_create_success'), 'success');
				redirect(SITE_AREA .'/settings/qosasah');
			}
			else
			{
				Template::set_message(lang('qosasah_create_failure') . $this->qosasah_model->error, 'error');
			}
		}
		Assets::add_module_js('qosasah', 'qosasah.js');

		Template::set('toolbar_title', lang('qosasah_create') . ' qosasah');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of qosasah data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('qosasah_invalid_id'), 'error');
			redirect(SITE_AREA .'/settings/qosasah');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Qosasah.Settings.Edit');

			if ($this->save_qosasah('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('qosasah_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'qosasah');

				Template::set_message(lang('qosasah_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('qosasah_edit_failure') . $this->qosasah_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Qosasah.Settings.Delete');

			if ($this->qosasah_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('qosasah_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'qosasah');

				Template::set_message(lang('qosasah_delete_success'), 'success');

				redirect(SITE_AREA .'/settings/qosasah');
			}
			else
			{
				Template::set_message(lang('qosasah_delete_failure') . $this->qosasah_model->error, 'error');
			}
		}
		Template::set('qosasah', $this->qosasah_model->find($id));
		Template::set('toolbar_title', lang('qosasah_edit') .' qosasah');
		Template::render();
	}

	//--------------------------------------------------------------------

	//--------------------------------------------------------------------
	// !PRIVATE METHODS
	//--------------------------------------------------------------------

	/**
	 * Summary
	 *
	 * @param String $type Either "insert" or "update"
	 * @param Int	 $id	The ID of the record to update, ignored on inserts
	 *
	 * @return Mixed    An INT id for successful inserts, TRUE for successful updates, else FALSE
	 */
	private function save_qosasah($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['snippet_post']        = $this->input->post('qosasah_snippet_post');

		if ($type == 'insert')
		{
			$id = $this->qosasah_model->insert($data);

			if (is_numeric($id))
			{
				$return = $id;
			}
			else
			{
				$return = FALSE;
			}
		}
		elseif ($type == 'update')
		{
			$return = $this->qosasah_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------


}