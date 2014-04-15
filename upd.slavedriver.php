<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once PATH_THIRD . 'slavedriver/config.php';

/**
 * @author		James Smith
 * @link		http://www.jamessmith.co.uk
 */

class Slavedriver_upd {

	public $version = SLAVEDRIVER_VER;
	private $EE;

	public function __construct()
	{
		//$this->EE =& get_instance();
	}

	// ----------------------------------------------------------------

	public function install()
	{
		$mod_data = array(
			'module_name'			=> 'Slavedriver',
			'module_version'		=> $this->version,
			'has_cp_backend'		=> 'y',
			'has_publish_fields'	=> 'n'
		);

		ee()->db->insert('modules', $mod_data);
		ee()->load->dbforge();

		$fields = array(
			'id' => array('type' => 'int',
				'constraint' => '1',
				'unsigned' => TRUE
				),
    		'settings' => array('type' => 'text'),
    	);

		ee()->dbforge->add_field($fields);
		ee()->dbforge->add_key('id', TRUE);
		ee()->dbforge->create_table('slavedriver');
		ee()->db->set('id', 1);
		ee()->db->insert('slavedriver');

		return TRUE;
	}

	// ----------------------------------------------------------------

	public function uninstall()
	{
		$mod_id = ee()->db->select('module_id')
							->get_where('modules', array('module_name' => 'Slavedriver'))
							->row('module_id');

		ee()->db->where('module_id', $mod_id)
				->delete('module_member_groups');

		ee()->db->where('module_name', 'Slavedriver')
				->delete('modules');

		ee()->load->dbforge();
		ee()->dbforge->drop_table('slavedriver');

		return TRUE;
	}

	// ----------------------------------------------------------------

	public function update($current = '')
	{
		// If you have updates, drop 'em in here.
		return TRUE;
	}
}