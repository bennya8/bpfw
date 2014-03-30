<?php

namespace Wiicode\Database;

/**
 * DAO 接口
 * @namespace System\Database
 * @package system.database
 * @author Benny <benny_a8@live.com>
 * @copyright ©2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
interface IDAO
{

	/**
	 *
	 * @param Criteria $criteria
	 */
	public function findOne(Criteria $criteria);

	public function findOneBySQL($sql);

	public function findAll(Criteria $criteria);

	public function findAllBySQL($sql);

	public function query($sql);

	public function exec($sql);

	public function commitTransaction();

	public function rollbackTransaction();

	public function beginTransaction();

	public function getLastInsertId();

	public function getAffectedRows();
}

?>