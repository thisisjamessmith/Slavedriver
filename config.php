<?php
if (! defined('SLAVEDRIVER_VER'))
{
	define('SLAVEDRIVER_NAME', 'Slavedriver');
	define('SLAVEDRIVER_VER',  '0.2.1');
}

$config['name'] = SLAVEDRIVER_NAME;
$config['version'] = SLAVEDRIVER_VER;

// --------------------------------------------
// To add a new dynamic config item (ie, overrideable via the EE CP) do the following:
// 1. Add it here. NB, numbers should be added as strings.
// 2. Add a corresponding line to lang.whatever.php
// 3. Add a corresponding switch/case section (or add to existing cases) in mcp.whatever.php so it works from the control panel
// 4. (optional) Add a notes section for detailed instructions in both mcp.whatever.php and the lang file
// --------------------------------------------

$config['default_settings'] = array(
	'master_site' => '1',
	'sync_pages_uris' => '',
);