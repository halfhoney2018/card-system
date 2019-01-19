<?php
 namespace Doctrine\DBAL\Driver; use Doctrine\DBAL\Driver; use Doctrine\DBAL\Platforms\DB2Platform; use Doctrine\DBAL\Schema\DB2SchemaManager; abstract class AbstractDB2Driver implements Driver { public function getDatabase(\Doctrine\DBAL\Connection $conn) { $params = $conn->getParams(); return $params['dbname']; } public function getDatabasePlatform() { return new DB2Platform(); } public function getSchemaManager(\Doctrine\DBAL\Connection $conn) { return new DB2SchemaManager($conn); } } 