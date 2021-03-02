<?php
/**
 * Part of the Joomla Framework Session Package
 *
 * @copyright  Copyright (C) 2005 - 2021 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Session\Storage;

use Joomla\Session\Storage;

/**
 * APCU session storage handler for PHP
 *
 * @link        https://www.php.net/manual/en/function.session-set-save-handler.php
 * @since       1.4.0
 * @deprecated  2.0  The Storage class chain will be removed.
 */
class Apcu extends Storage
{
	/**
	 * Constructor
	 *
	 * @param   array  $options  Optional parameters
	 *
	 * @since   1.4.0
	 * @throws  \RuntimeException
	 */
	public function __construct($options = array())
	{
		if (!self::isSupported())
		{
			throw new \RuntimeException('APCU Extension is not available', 404);
		}

		parent::__construct($options);
	}

	/**
	 * Read the data for a particular session identifier from the
	 * SessionHandler backend.
	 *
	 * @param   string  $id  The session identifier.
	 *
	 * @return  string  The session data.
	 *
	 * @since   1.4.0
	 */
	public function read($id)
	{
		$sess_id = 'sess_' . $id;

		return (string) apcu_fetch($sess_id);
	}

	/**
	 * Write session data to the SessionHandler backend.
	 *
	 * @param   string  $id           The session identifier.
	 * @param   string  $sessionData  The session data.
	 *
	 * @return  boolean  True on success, false otherwise.
	 *
	 * @since   1.4.0
	 */
	public function write($id, $sessionData)
	{
		$sess_id = 'sess_' . $id;

		return apcu_store($sess_id, $sessionData, ini_get('session.gc_maxlifetime'));
	}

	/**
	 * Destroy the data for a particular session identifier in the SessionHandler backend.
	 *
	 * @param   string  $id  The session identifier.
	 *
	 * @return  boolean  True on success, false otherwise.
	 *
	 * @since   1.4.0
	 */
	public function destroy($id)
	{
		$sess_id = 'sess_' . $id;

		return apcu_delete($sess_id);
	}

	/**
	 * Test to see if the SessionHandler is available.
	 *
	 * @return  boolean  True on success, false otherwise.
	 *
	 * @since   1.4.0
	 */
	public static function isSupported()
	{
		return \extension_loaded('apcu');
	}
}
