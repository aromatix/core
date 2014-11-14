<?php
/**
 * ownCloud
 *
 * @author Joas Schilling
 * @copyright 2014 Joas Schilling nickvergessen@owncloud.com
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU AFFERO GENERAL PUBLIC LICENSE for more details.
 *
 * You should have received a copy of the GNU Affero General Public
 * License along with this library.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace Test;

abstract class TestCase extends \PHPUnit_Framework_TestCase {
	protected function getUniqueID($prefix = '', $length = 13) {
		// Do not use dots and slashes as we use the value for file names
		return $prefix . \OC::$server->getSecureRandom()->getLowStrengthGenerator()->generate(
			$length,
			'0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
		);
	}

	protected static $rootMountStorageId;

	public static function setUpBeforeClass() {
		parent::setUpBeforeClass();

		self::$rootMountStorageId = \OC\Files\Filesystem::getStorage('/')->getId();
		var_dump(self::$rootMountStorageId);
	}

	public static function tearDownAfterClass() {
		if (\OC_Util::runningOnWindows()) {
			$rootDirectory = \OC::$server->getConfig()->getSystemValue('datadirectory', \OC::$SERVERROOT . '/data-autotest');
			$mapper = new \OC\Files\Mapper($rootDirectory);
			$mapper->removePath($rootDirectory, true, true);
		}

		var_dump(get_called_class());
		var_dump(
			\OC\Files\Filesystem::getStorage('/')->getId(),
			\OC\Files\Filesystem::getStorage('/')->getId() === self::$rootMountStorageId
		);
		parent::tearDownAfterClass();
	}
}
