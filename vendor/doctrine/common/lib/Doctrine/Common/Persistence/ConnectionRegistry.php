<?php
 namespace Doctrine\Common\Persistence; interface ConnectionRegistry { public function getDefaultConnectionName(); public function getConnection($name = null); public function getConnections(); public function getConnectionNames(); } 