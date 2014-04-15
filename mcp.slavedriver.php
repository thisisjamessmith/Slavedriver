<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once PATH_THIRD . 'slavedriver/config.php';

/**
 * @author		James Smith
 * @link		http://www.jamessmith.co.uk
 */

class Slavedriver_mcp {

	public $return_data;
	private $_base_url;

	public function __construct()
	{
		$this->_base_url = BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=slavedriver';
		ee()->load->model('slavedriver_model');
		ee()->cp->set_right_nav(array(
			'module_home'	=> $this->_base_url,
			// Add more right nav items here.
		));
	}

	// ----------------------------------------------------------------

	public function index()
	{
		ee()->cp->set_variable('cp_page_title', lang('slavedriver_module_name'));
		ee()->load->helper('form');
		ee()->load->library('table');
		ee()->lang->loadfile('admin');

		$output = form_open('C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=slavedriver'.AMP.'method=save_settings');

		ee()->table->set_template(array(
			'table_open' => '<table class="mainTable" border="0" cellspacing="0" cellpadding="0">',
			'row_start' => '<tr class="even">',
			'row_alt_start' => '<tr class="odd">',
		));

		ee()->table->set_caption('Slavedriver Settings');

		// build each table row from the settings as defined in our add-on's config.php file
		$settings = ee()->slavedriver_model->default_settings();
		if ($settings)
			{
			foreach ($settings as $key => $value)
			{
				$this->settings_row($key, ee()->slavedriver_model->settings($key));
			}

			$output .= ee()->table->generate();
			$output .= form_submit('', lang('submit'), 'class="submit"');
			$output .= form_close();
			return $output;
		} else {
			return 'No settings have been defined';
		}
	}
	// ----------------------------------------------------------------

	private function settings_row($key, $value)
	{
		$row = array(form_label(lang($key), $key));

		// add some extra instructions
		$notes = array(
			// 'a_config_key_from_config_file' => lang('a_key_from_the_lang_file'),
		);

		if (isset($notes[$key]))
		{
			$row[0] .= '<div class="subtext">'.$notes[$key].'</div>';
		}

		// output different field types for different config keys
		switch ($key)
		{
			// --------------------------------------------
			// Site Selector (single)
			// --------------------------------------------

			case 'master_site' :
				$options = array('' => '---');

				$query = ee()->db->select('site_id,site_label')
								 ->get('sites');

				foreach ($query->result() as $site)
				{
					$options[$site->site_id] = $site->site_label;
				}

				$query->free_result();
				$row[] = form_dropdown($key, $options, $value, 'id="'.$key.'"');
				break;

			// --------------------------------------------
			// Channel Selector (single)
			// --------------------------------------------

			// case 'societies_channel' :
			// case 'profiles_channel' :
			// case 'events_channel' :
			// case 'purchased_items_channel' :
			// 	$options = array('' => '---');

			// 	$query = ee()->db->select('channels.channel_id, channels.channel_title')
			// 							->get('channels');

			// 	foreach ($query->result() as $channel)
			// 	{
			// 		$options[$channel->channel_id] = $channel->channel_title;
			// 	}

			// 	$query->free_result();
			// 	$row[] = form_dropdown($key, $options, $value, 'id="'.$key.'"');
			// 	break;

			// --------------------------------------------
			// Member groups selector (multiple)
			// --------------------------------------------

			// case 'admin_groups':
			// 	$options = array();

			// 	$query = ee()->db->select('group_id, group_title')
			// 			      ->where('group_id >', 5)
			// 			      ->get('member_groups');

			// 	foreach ($query->result() as $group)
			// 	{
			// 		$options[$group->group_id] = $group->group_title;
			// 	}

			// 	$query->free_result();

			// 	$row[] = form_multiselect($key.'[]', $options, $value, 'id="'.$key.'"');
			// 	break;

			// --------------------------------------------
			// Member groups selector (single)
			// --------------------------------------------

			// case 'society_members_group':
			// case 'suspended_members_group':
			// 	$options = array();

			// 	$query = ee()->db->select('group_id, group_title')
			// 			      ->where('group_id >', 5)
			// 			      ->get('member_groups');

			// 	foreach ($query->result() as $group)
			// 	{
			// 		$options[$group->group_id] = $group->group_title;
			// 	}

			// 	$query->free_result();

			// 	$row[] = form_dropdown($key, $options, $value, 'id="'.$key.'"');
			// 	break;


			// --------------------------------------------
			// Entry Selector (single)
			// --------------------------------------------

			// case 'admin_default_society':
			// 	$options = array('' => '---');

			// 	$query = ee()->db->select('channel_data.entry_id, channel_titles.title')
			// 							->join('channel_titles','channel_data.entry_id = channel_titles.entry_id')
			// 							->where('channel_data.channel_id',ee()->scm->settings('societies_channel'))
			// 							->get('channel_data');

			// 	foreach ($query->result() as $entry)
			// 	{
			// 		$options[$entry->entry_id] = $entry->title;
			// 	}

			// 	$query->free_result();
			// 	$row[] = form_dropdown($key, $options, $value, 'id="'.$key.'"');
			// 	break;

			// --------------------------------------------
			// Status Selector (single)
			// --------------------------------------------

			// case 'suspended_entries_status':
			// 	$options = array();

			// 	$query = ee()->db->select('status_id, status')
			// 			      ->get('statuses');

			// 	foreach ($query->result() as $status)
			// 	{
			// 		$options[$status->status_id] = $status->status;
			// 	}

			// 	$query->free_result();

			// 	$row[] = form_dropdown($key, $options, $value, 'id="'.$key.'"');
			// 	break;

			// --------------------------------------------
			// Checkboxes
			// --------------------------------------------

			case 'sync_pages_uris':
				$row[] = form_label(form_checkbox($key, 1, (bool) $value, 'id="'.$key.'"').NBS.lang('yes'), $key);
				break;

			// --------------------------------------------
			// Fields selector (multiple)
			// --------------------------------------------

			// case 'fields':
			// 	$options = array();

			// 	$query = ee()->db->select('field_id, field_name')
			// 			      		  ->get('channel_fields');

			// 	foreach ($query->result() as $field)
			// 	{
			// 		$options[$field->field_id] = $field->field_name;
			// 	}

			// 	$query->free_result();

			// 	$row[] = form_multiselect($key.'[]', $options, $value, 'id="'.$key.'"');
			// 	break;

			// --------------------------------------------
			// Default to text
			// --------------------------------------------

			default:

				$row[] = form_input($key, $value, 'id="'.$key.'"');
		}

		ee()->table->add_row($row);
	}

	// ----------------------------------------------------------------

	public function save_settings()
	{
		$settings = array();

		foreach (array_keys(ee()->slavedriver_model->settings()) as $key)
		{
			$settings[$key] = ee()->input->post($key);
		}

		ee()->db->update('slavedriver', array('settings' => serialize($settings)));
		ee()->session->set_flashdata('message_success', lang('settings_saved'));
		ee()->functions->redirect(BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=slavedriver');
	}

}