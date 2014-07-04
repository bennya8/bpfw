<?php

namespace System\Database;


interface IUtilities
{
     public function showTable();

     public function createTable();

     public function alterTable();

     public function dropTable();

     public function showView();

     public function createView();

     public function alterView();

     public function dropView();

     public function repairTable();

     public function optimizeTable();

     public function renameTable();
}