<?php

namespace System\Database\Driver;

use System\Database\Database;


class AccessHelper extends Database {
	private $conn = null;

	public function __construct($setting) {
		$this->conn = $this->_connect($setting);
		$filepath = realpath($setting['source']);
		$this->conn = odbc_connect("Driver={Microsoft Access Driver (*.mdb)};Dbq=$filepath", $setting['username'], $setting['password']);
	}
	
	/* (non-PHPdoc)
	 * @see DAO::beginTransaction()
	 */
	public function beginTransaction() {}
	
	/* (non-PHPdoc)
	 * @see DAO::commitTransaction()
	 */
	public function commitTransaction() {}
	
	/* (non-PHPdoc)
	 * @see DAO::exec()
	 */
	public function exec($sql) {}
	
	/* (non-PHPdoc)
	 * @see DAO::findAll()
	 */
	public function findAll(DBHelper $dbhelper) {}
	
	/* (non-PHPdoc)
	 * @see DAO::findAllBySQL()
	 */
	public function findAllBySQL($sql) {}
	
	/* (non-PHPdoc)
	 * @see DAO::findOne()
	 */
	public function findOne(DBHelper $dbhelper) {}
	
	/* (non-PHPdoc)
	 * @see DAO::findOneBySQL()
	 */
	public function findOneBySQL($sql) {}
	
	/* (non-PHPdoc)
	 * @see DAO::getAffectedRows()
	 */
	public function getAffectedRows() {}
	
	/* (non-PHPdoc)
	 * @see DAO::getLastInsertId()
	 */
	public function getLastInsertId() {}
	
	/* (non-PHPdoc)
	 * @see DAO::rollbackTransaction()
	 */
	public function rollbackTransaction() {}

	public function query($sql) {
		$result = odbc_do($this->conn, $sql);
		while($row = odbc_fetch_array($result)){
			$list[] = $row;
		}
		return $list;
	}

	public function tables() {
		$result = odbc_tables($this->conn);
		while($row = odbc_fetch_array($result)){
			$list[] = $row;
		}
		return $list;
	}
}

?>





?>