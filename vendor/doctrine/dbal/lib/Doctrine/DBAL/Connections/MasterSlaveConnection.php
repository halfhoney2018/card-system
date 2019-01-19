<?php
 namespace Doctrine\DBAL\Connections; use Doctrine\DBAL\Connection; use Doctrine\DBAL\Driver; use Doctrine\DBAL\Configuration; use Doctrine\Common\EventManager; use Doctrine\DBAL\Event\ConnectionEventArgs; use Doctrine\DBAL\Events; class MasterSlaveConnection extends Connection { protected $connections = array('master' => null, 'slave' => null); protected $keepSlave = false; public function __construct(array $params, Driver $driver, Configuration $config = null, EventManager $eventManager = null) { if ( !isset($params['slaves']) || !isset($params['master'])) { throw new \InvalidArgumentException('master or slaves configuration missing'); } if (count($params['slaves']) == 0) { throw new \InvalidArgumentException('You have to configure at least one slaves.'); } $params['master']['driver'] = $params['driver']; foreach ($params['slaves'] as $slaveKey => $slave) { $params['slaves'][$slaveKey]['driver'] = $params['driver']; } $this->keepSlave = isset($params['keepSlave']) ? (bool) $params['keepSlave'] : false; parent::__construct($params, $driver, $config, $eventManager); } public function isConnectedToMaster() { return $this->_conn !== null && $this->_conn === $this->connections['master']; } public function connect($connectionName = null) { $requestedConnectionChange = ($connectionName !== null); $connectionName = $connectionName ?: 'slave'; if ($connectionName !== 'slave' && $connectionName !== 'master') { throw new \InvalidArgumentException("Invalid option to connect(), only master or slave allowed."); } if ($this->_conn && !$requestedConnectionChange) { return false; } $forceMasterAsSlave = false; if ($this->getTransactionNestingLevel() > 0) { $connectionName = 'master'; $forceMasterAsSlave = true; } if ($this->connections[$connectionName]) { $this->_conn = $this->connections[$connectionName]; if ($forceMasterAsSlave && ! $this->keepSlave) { $this->connections['slave'] = $this->_conn; } return false; } if ($connectionName === 'master') { if ($this->connections['slave'] && ! $this->keepSlave) { unset($this->connections['slave']); } $this->connections['master'] = $this->_conn = $this->connectTo($connectionName); if ( ! $this->keepSlave) { $this->connections['slave'] = $this->connections['master']; } } else { $this->connections['slave'] = $this->_conn = $this->connectTo($connectionName); } if ($this->_eventManager->hasListeners(Events::postConnect)) { $eventArgs = new ConnectionEventArgs($this); $this->_eventManager->dispatchEvent(Events::postConnect, $eventArgs); } return true; } protected function connectTo($connectionName) { $params = $this->getParams(); $driverOptions = isset($params['driverOptions']) ? $params['driverOptions'] : array(); $connectionParams = $this->chooseConnectionConfiguration($connectionName, $params); $user = isset($connectionParams['user']) ? $connectionParams['user'] : null; $password = isset($connectionParams['password']) ? $connectionParams['password'] : null; return $this->_driver->connect($connectionParams, $user, $password, $driverOptions); } protected function chooseConnectionConfiguration($connectionName, $params) { if ($connectionName === 'master') { return $params['master']; } return $params['slaves'][array_rand($params['slaves'])]; } public function executeUpdate($query, array $params = array(), array $types = array()) { $this->connect('master'); return parent::executeUpdate($query, $params, $types); } public function beginTransaction() { $this->connect('master'); parent::beginTransaction(); } public function commit() { $this->connect('master'); parent::commit(); } public function rollBack() { $this->connect('master'); return parent::rollBack(); } public function delete($tableName, array $identifier, array $types = array()) { $this->connect('master'); return parent::delete($tableName, $identifier, $types); } public function close() { unset($this->connections['master']); unset($this->connections['slave']); parent::close(); $this->_conn = null; $this->connections = array('master' => null, 'slave' => null); } public function update($tableName, array $data, array $identifier, array $types = array()) { $this->connect('master'); return parent::update($tableName, $data, $identifier, $types); } public function insert($tableName, array $data, array $types = array()) { $this->connect('master'); return parent::insert($tableName, $data, $types); } public function exec($statement) { $this->connect('master'); return parent::exec($statement); } public function createSavepoint($savepoint) { $this->connect('master'); parent::createSavepoint($savepoint); } public function releaseSavepoint($savepoint) { $this->connect('master'); parent::releaseSavepoint($savepoint); } public function rollbackSavepoint($savepoint) { $this->connect('master'); parent::rollbackSavepoint($savepoint); } public function query() { $this->connect('master'); $args = func_get_args(); $logger = $this->getConfiguration()->getSQLLogger(); if ($logger) { $logger->startQuery($args[0]); } $statement = call_user_func_array(array($this->_conn, 'query'), $args); if ($logger) { $logger->stopQuery(); } return $statement; } public function prepare($statement) { $this->connect('master'); return parent::prepare($statement); } } 