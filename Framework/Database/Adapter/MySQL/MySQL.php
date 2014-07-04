<?php

namespace System\Database\Adapter\MySQL;

use System\Database\Criteria;
use \System\Database\Database;

class MySQL extends Database
{
    /**
     *
     * @param Criteria $criteria
     */
    public function find(Criteria $criteria)
    {
        // TODO: Implement find() method.
    }

    public function findBySQL($sql, $params = null)
    {
        // TODO: Implement findBySQL() method.
    }

    public function findAll(Criteria $criteria)
    {
        // TODO: Implement findAll() method.
    }

    public function findAllBySQL($sql, $params = null)
    {
        // TODO: Implement findAllBySQL() method.
    }

    public function exec($sql, $params = null)
    {
        // TODO: Implement exec() method.
    }

    public function commitTransaction()
    {
        // TODO: Implement commitTransaction() method.
    }

    public function beginTransaction()
    {
        // TODO: Implement beginTransaction() method.
    }

    public function getAffectedRows()
    {
        // TODO: Implement getAffectedRows() method.
    }

    public function showTable()
    {
        // TODO: Implement showTable() method.
    }

    public function createTable()
    {
        // TODO: Implement createTable() method.
    }

    public function alterTable()
    {
        // TODO: Implement alterTable() method.
    }

    public function dropTable()
    {
        // TODO: Implement dropTable() method.
    }

    public function showView()
    {
        // TODO: Implement showView() method.
    }

    public function createView()
    {
        // TODO: Implement createView() method.
    }

    public function alterView()
    {
        // TODO: Implement alterView() method.
    }

    public function dropView()
    {
        // TODO: Implement dropView() method.
    }

    public function repairTable()
    {
        // TODO: Implement repairTable() method.
    }

    public function optimizeTable()
    {
        // TODO: Implement optimizeTable() method.
    }

    public function renameTable()
    {
        // TODO: Implement renameTable() method.
    }


    public function query($sql, $params = null)
    {
        // TODO: Implement query() method.
    }

    public function rollbackTransaction()
    {
        // TODO: Implement rollbackTransaction() method.
    }

    public function getLastInsertId()
    {
        // TODO: Implement getLastInsertId() method.
    }
}