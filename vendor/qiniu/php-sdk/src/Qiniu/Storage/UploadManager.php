<?php
namespace Qiniu\Storage; use Qiniu\Config; use Qiniu\Http\HttpClient; use Qiniu\Storage\ResumeUploader; use Qiniu\Storage\FormUploader; final class UploadManager { private $config; public function __construct(Config $config = null) { if ($config === null) { $config = new Config(); } $this->config = $config; } public function put( $upToken, $key, $data, $params = null, $mime = 'application/octet-stream', $fname = null ) { $params = self::trimParams($params); return FormUploader::put( $upToken, $key, $data, $this->config, $params, $mime, $fname ); } public function putFile( $upToken, $key, $filePath, $params = null, $mime = 'application/octet-stream', $checkCrc = false ) { $file = fopen($filePath, 'rb'); if ($file === false) { throw new \Exception("file can not open", 1); } $params = self::trimParams($params); $stat = fstat($file); $size = $stat['size']; if ($size <= Config::BLOCK_SIZE) { $data = fread($file, $size); fclose($file); if ($data === false) { throw new \Exception("file can not read", 1); } return FormUploader::put( $upToken, $key, $data, $this->config, $params, $mime, basename($filePath) ); } $up = new ResumeUploader( $upToken, $key, $file, $size, $params, $mime, $this->config ); $ret = $up->upload(basename($filePath)); fclose($file); return $ret; } public static function trimParams($params) { if ($params === null) { return null; } $ret = array(); foreach ($params as $k => $v) { $pos1 = strpos($k, 'x:'); $pos2 = strpos($k, 'x-qn-meta-'); if (($pos1 === 0 || $pos2 === 0) && !empty($v)) { $ret[$k] = $v; } } return $ret; } } 