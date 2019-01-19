<?php
 namespace Doctrine\Common\Reflection; class Psr0FindFile implements ClassFinderInterface { protected $prefixes; public function __construct($prefixes) { $this->prefixes = $prefixes; } public function findFile($class) { $lastNsPos = strrpos($class, '\\'); if ('\\' == $class[0]) { $class = substr($class, 1); } if (false !== $lastNsPos) { $classPath = str_replace('\\', DIRECTORY_SEPARATOR, substr($class, 0, $lastNsPos)) . DIRECTORY_SEPARATOR; $className = substr($class, $lastNsPos + 1); } else { $classPath = null; $className = $class; } $classPath .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php'; foreach ($this->prefixes as $prefix => $dirs) { if (0 === strpos($class, $prefix)) { foreach ($dirs as $dir) { if (is_file($dir . DIRECTORY_SEPARATOR . $classPath)) { return $dir . DIRECTORY_SEPARATOR . $classPath; } } } } return null; } } 