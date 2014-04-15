<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once PATH_THIRD . 'slavedriver/config.php';

// ------------------------------------------------------------------------

class Slavedriver_ext {

	public $settings 		= array();
	public $description		= '';
	public $docs_url		= '';
	public $name			= '';
	public $settings_exist	= 'n';
	public $version			= SLAVEDRIVER_VER;
	public $required_by = array('module');

	public function __construct($settings = '')
	{
		ee()->load->model('slavedriver_model');
		$this->settings = ee()->slavedriver_model->get_settings();
	}

	// ----------------------------------------------------------------------

	public function sessions_start()
	{
		// --------------------------------------------
		// SYNC PAGES URIS
		// --------------------------------------------

		if ($this->settings['sync_pages_uris'])
		{
			ee()->slavedriver_model->sync_pages_uris($this->settings['master_site']);
		}
	}

	// ----------------------------------------------------------------------
	// ----------------------------------------------------------------------
	// ----------------------------------------------------------------------
	// ----------------------------------------------------------------------

	public function activate_extension()
	{
		// Setup custom settings in this array.
		$this->settings = array();

		$data = array(
			'class'		=> __CLASS__,
			'method'	=> 'sessions_start',
			'hook'		=> 'sessions_start',
			//'settings'	=> serialize($this->settings),
			'settings'	=> '',
			'version'	=> $this->version,
			'enabled'	=> 'y'
		);

		ee()->db->insert('extensions', $data);
	}

	// ----------------------------------------

	function disable_extension()
	{
		ee()->db->where('class', __CLASS__);
		ee()->db->delete('extensions');
	}

	// ----------------------------------------

	function update_extension($current = '')
	{
		if ($current == '' OR $current == $this->version)
		{
			return FALSE;
		}
	}

}
// EOF