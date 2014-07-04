<?php

/**
 * Database Interface
 * @namespace System\Database
 * @package system.database
 * @author Benny <benny_a8@live.com>
 * @copyright ©2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Database;

interface IResult
{

    /**
     *
     * @param Criteria $criteria
     */
    public function find(Criteria $criteria);

    public function findBySQL($sql,$params = null);

    public function findAll(Criteria $criteria);

    public function findAllBySQL($sql,$params = null);

    public function query($sql,$params = null);

    public function exec($sql,$params = null);

    public function commitTransaction();

    public function rollbackTransaction();

    public function beginTransaction();

    public function getLastInsertId();

    public function getAffectedRows();
}