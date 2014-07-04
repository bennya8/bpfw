<?php

namespace System\Core;

use \System\Database\DAO;


class Model implements DAO {
    public $db = null;
    public $autoValidate = array();
    public $autoComplete = array();
    public $errorMessage = '';



    public function __construct() {
        $this->db = Web::create()->db;
    }

    /* (non-PHPdoc)
     * @see DAO::beginTransaction()
     */
    public function beginTransaction() {
        return $this->db->beginTransaction();
    }

    /* (non-PHPdoc)
     * @see DAO::commitTransaction()
     */
    public function commitTransaction() {
        return $this->db->commitTransaction();
    }

    /* (non-PHPdoc)
     * @see DAO::exec()
     */
    public function exec($sql) {
        return $this->db->exec($sql);
    }

    /* (non-PHPdoc)
     * @see DAO::findAll()
     */
    public function findAll(DBHelper $dbhelper) {
        // TODO Auto-generated method stub
    }

    /* (non-PHPdoc)
     * @see DAO::findAllBySQL()
     */
    public function findAllBySQL($sql) {
        // TODO Auto-generated method stub
    }

    /* (non-PHPdoc)
     * @see DAO::findOne()
     */
    public function findOne(DBHelper $dbhelper) {
        // TODO Auto-generated method stub
    }

    /* (non-PHPdoc)
     * @see DAO::findOneBySQL()
     */
    public function findOneBySQL($sql) {
        // TODO Auto-generated method stub
    }

    /* (non-PHPdoc)
     * @see DAO::getAffectedRows()
     */
    public function getAffectedRows() {
        // TODO Auto-generated method stub
    }

    /* (non-PHPdoc)
     * @see DAO::getLastInsertId()
     */
    public function getLastInsertId() {
        // TODO Auto-generated method stub
    }

    /* (non-PHPdoc)
     * @see DAO::query()
     */
    public function query($sql) {
        // TODO Auto-generated method stub
    }

    /* (non-PHPdoc)
     * @see DAO::rollbackTransaction()
     */
    public function rollbackTransaction() {
        // TODO Auto-generated method stub
    }
}
