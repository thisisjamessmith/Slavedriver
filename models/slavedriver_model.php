<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author		James Smith
 * @link		http://www.jamessmith.co.uk
 */

class Slavedriver_model extends CI_Model {

	protected $settings = NULL;
	protected $default_settings;
	private $EE;

	public function __construct()
	{
		parent::__construct();
		include PATH_THIRD.'slavedriver/config.php';
		$this->default_settings = $config['default_settings'];
	}

// ----------------------------------------------------------------------
// MODEL BOILERPLATE STUFF...
// ----------------------------------------------------------------------

	public function default_settings()
	{
		return $this->default_settings;
	}

	// return either the defaults from our config.php file or a combination of previously saved database values and those config settings
	public function get_settings()
	{
		// this is not active record on purpose, leave it alone!
		$query = $this->db->query('SELECT `settings` FROM '.$this->db->dbprefix('slavedriver').' LIMIT 1');

		if ($query->row('settings') && $settings = @unserialize($query->row('settings')))
		{
			return array_merge($this->default_settings, $settings);
		}

		return $this->default_settings;
	}

	public function set_settings($settings)
	{
		if (is_array($settings))
		{
			$this->settings = array_merge($this->default_settings, $settings);
		}

		return $this;
	}

	public function settings($key = FALSE)
	{
		if (is_null($this->settings))
		{
			$this->settings = $this->get_settings();
		}

		if ($key === FALSE)
		{
			return $this->settings;
		}

		return (isset($this->settings[$key])) ? $this->settings[$key] : FALSE;
	}

// ----------------------------------------------------------------------
// ----------------------------------------------------------------------
// GET THIS PARTY STARTED...
// ----------------------------------------------------------------------
// ----------------------------------------------------------------------

	// This is a bit drastic... no need to overwrite in the DB, can instead
	// reset the config item in session.
	//
	// public function overwrite_pages_uris($master_site)
	// {
	// 	$slaves = array();

	// 	$query = ee()->db->select('site_pages, site_name, site_id')
	// 					 ->get('sites');

	// 	if ($query->num_rows() > 0)
	// 	{
	// 		foreach ($query->result() as $row)
	// 		{
	// 			if ( $row->site_id == $master_site )
	// 			{
	// 				$master_site_pages = unserialize(base64_decode( $row->site_pages ));
	// 			} else {
	// 				$slaves[] = $row->site_id;
	// 			}
	// 		}

	// 		foreach ($slaves as $slave)
	// 		{
	// 			$slave_site_pages = array($slave => $master_site_pages[$master_site]);
	// 			$slave_site_pages = base64_encode(serialize( $slave_site_pages ));

	// 			$data = array( 'site_pages' => $slave_site_pages );
	// 			ee()->db->where('site_id',$slave)
	// 					->update('sites',$data);
	// 		}
	// 	}
	// }

// ----------------------------------------------------------------

	public function sync_pages_uris($master_site)
	{
		$current_site = ee()->config->item('site_id');

		if ($current_site != $master_site)
		{
			$query = ee()->db->select('site_pages, site_name, site_id')
							 ->where('site_id',$master_site)
							 ->get('sites');
			if ($query->num_rows() > 0)
			{
				$master_site_pages = unserialize(base64_decode( $query->row('site_pages') ));
			}

			// the old switcheroo
			$slave_site_pages = array($current_site => $master_site_pages[$master_site]);
		}

		// save to the session config
		ee()->config->set_item('site_pages', $slave_site_pages);
	}

// ----------------------------------------------------------------
}