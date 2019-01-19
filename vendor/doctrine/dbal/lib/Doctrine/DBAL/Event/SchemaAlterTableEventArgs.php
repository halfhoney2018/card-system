<?php
 namespace Doctrine\DBAL\Event; use Doctrine\DBAL\Platforms\AbstractPlatform; use Doctrine\DBAL\Schema\TableDiff; class SchemaAlterTableEventArgs extends SchemaEventArgs { private $_tableDiff; private $_platform; private $_sql = array(); public function __construct(TableDiff $tableDiff, AbstractPlatform $platform) { $this->_tableDiff = $tableDiff; $this->_platform = $platform; } public function getTableDiff() { return $this->_tableDiff; } public function getPlatform() { return $this->_platform; } public function addSql($sql) { if (is_array($sql)) { $this->_sql = array_merge($this->_sql, $sql); } else { $this->_sql[] = $sql; } return $this; } public function getSql() { return $this->_sql; } } 