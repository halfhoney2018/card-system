<?php
 namespace Doctrine\DBAL\Driver; use Doctrine\DBAL\DBALException; use Doctrine\DBAL\Driver; use Doctrine\DBAL\Exception; use Doctrine\DBAL\Platforms\PostgreSQL91Platform; use Doctrine\DBAL\Platforms\PostgreSQL92Platform; use Doctrine\DBAL\Platforms\PostgreSqlPlatform; use Doctrine\DBAL\Schema\PostgreSqlSchemaManager; use Doctrine\DBAL\VersionAwarePlatformDriver; abstract class AbstractPostgreSQLDriver implements Driver, ExceptionConverterDriver, VersionAwarePlatformDriver { public function convertException($message, DriverException $exception) { switch ($exception->getSQLState()) { case '0A000': if (strpos($exception->getMessage(), 'truncate') !== false) { return new Exception\ForeignKeyConstraintViolationException($message, $exception); } break; case '23502': return new Exception\NotNullConstraintViolationException($message, $exception); case '23503': return new Exception\ForeignKeyConstraintViolationException($message, $exception); case '23505': return new Exception\UniqueConstraintViolationException($message, $exception); case '42601': return new Exception\SyntaxErrorException($message, $exception); case '42702': return new Exception\NonUniqueFieldNameException($message, $exception); case '42703': return new Exception\InvalidFieldNameException($message, $exception); case '42P01': return new Exception\TableNotFoundException($message, $exception); case '42P07': return new Exception\TableExistsException($message, $exception); case '7': if (strpos($exception->getMessage(), 'SQLSTATE[08006]') !== false) { return new Exception\ConnectionException($message, $exception); } break; } return new Exception\DriverException($message, $exception); } public function createDatabasePlatformForVersion($version) { if ( ! preg_match('/^(?P<major>\d+)(?:\.(?P<minor>\d+)(?:\.(?P<patch>\d+))?)?/', $version, $versionParts)) { throw DBALException::invalidPlatformVersionSpecified( $version, '<major_version>.<minor_version>.<patch_version>' ); } $majorVersion = $versionParts['major']; $minorVersion = isset($versionParts['minor']) ? $versionParts['minor'] : 0; $patchVersion = isset($versionParts['patch']) ? $versionParts['patch'] : 0; $version = $majorVersion . '.' . $minorVersion . '.' . $patchVersion; switch(true) { case version_compare($version, '9.2', '>='): return new PostgreSQL92Platform(); case version_compare($version, '9.1', '>='): return new PostgreSQL91Platform(); default: return new PostgreSqlPlatform(); } } public function getDatabase(\Doctrine\DBAL\Connection $conn) { $params = $conn->getParams(); return (isset($params['dbname'])) ? $params['dbname'] : $conn->query('SELECT CURRENT_DATABASE()')->fetchColumn(); } public function getDatabasePlatform() { return new PostgreSqlPlatform(); } public function getSchemaManager(\Doctrine\DBAL\Connection $conn) { return new PostgreSqlSchemaManager($conn); } } 