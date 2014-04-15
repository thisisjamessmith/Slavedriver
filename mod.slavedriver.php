<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once PATH_THIRD . 'slavedriver/config.php';

/**
 * @author		James Smith
 * @link		http://www.jamessmith.co.uk
 */

class Slavedriver {

	public $return_data;
	public $version = SLAVEDRIVER_VER;

	public function __construct()
	{
		ee()->load->model('slavedriver_model');
	}

	// ----------------------------------------------------------------

	public function something()
	{
		$entry_id = ee()->TMPL->fetch_param('whatever');

		return $entry_id;
	}

	// ----------------------------------------------------------------
}