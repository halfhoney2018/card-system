<?php
namespace App\Library\Pay\Youzan\Open; class Http { private static $boundary = ''; public static function get($spaf19c1, $sp5e6808) { $spaf19c1 = $spaf19c1 . '?' . http_build_query($sp5e6808); return self::http($spaf19c1, 'GET'); } public static function post($spaf19c1, $sp5e6808, $sp9dc227 = array()) { $sp71f60e = array(); if (!$sp9dc227) { $spa1a573 = http_build_query($sp5e6808); } else { $spa1a573 = self::buildHttpQueryMulti($sp5e6808, $sp9dc227); $sp71f60e[] = 'Content-Type: multipart/form-data; boundary=' . self::$boundary; } return self::http($spaf19c1, 'POST', $spa1a573, $sp71f60e); } private static function http($spaf19c1, $spd92fdb, $spd72efa = NULL, $sp71f60e = array()) { $sp1bd74a = curl_init(); curl_setopt($sp1bd74a, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0); curl_setopt($sp1bd74a, CURLOPT_USERAGENT, 'X-YZ-Client 2.0.0 - PHP'); curl_setopt($sp1bd74a, CURLOPT_CONNECTTIMEOUT, 30); curl_setopt($sp1bd74a, CURLOPT_TIMEOUT, 30); curl_setopt($sp1bd74a, CURLOPT_RETURNTRANSFER, TRUE); curl_setopt($sp1bd74a, CURLOPT_ENCODING, ''); curl_setopt($sp1bd74a, CURLOPT_SSL_VERIFYPEER, false); curl_setopt($sp1bd74a, CURLOPT_SSL_VERIFYHOST, 2); curl_setopt($sp1bd74a, CURLOPT_HEADER, FALSE); switch ($spd92fdb) { case 'POST': curl_setopt($sp1bd74a, CURLOPT_POST, TRUE); if (!empty($spd72efa)) { curl_setopt($sp1bd74a, CURLOPT_POSTFIELDS, $spd72efa); } break; } curl_setopt($sp1bd74a, CURLOPT_URL, $spaf19c1); curl_setopt($sp1bd74a, CURLOPT_HTTPHEADER, $sp71f60e); curl_setopt($sp1bd74a, CURLINFO_HEADER_OUT, TRUE); $spf1d2fd = curl_exec($sp1bd74a); $sp666afe = curl_getinfo($sp1bd74a, CURLINFO_HTTP_CODE); $sp43496c = curl_getinfo($sp1bd74a); curl_close($sp1bd74a); return $spf1d2fd; } private static function buildHttpQueryMulti($sp5e6808, $sp9dc227) { if (!$sp5e6808) { return ''; } $sp2f1eff = array(); self::$boundary = $sp5ede47 = uniqid('------------------'); $sp2a420b = '--' . $sp5ede47; $spf972a7 = $sp2a420b . '--'; $sp586df2 = ''; foreach ($sp5e6808 as $spb5c5a0 => $spd77a65) { $sp586df2 .= $sp2a420b . '
'; $sp586df2 .= 'content-disposition: form-data; name="' . $spb5c5a0 . '"

'; $sp586df2 .= $spd77a65 . '
'; } foreach ($sp9dc227 as $spb5c5a0 => $spd77a65) { if (!$spd77a65) { continue; } if (is_array($spd77a65)) { $spaf19c1 = $spd77a65['url']; if (isset($spd77a65['name'])) { $sp52f712 = $spd77a65['name']; } else { $sp1eb8dd = explode('?', basename($spd77a65['url'])); $sp52f712 = $sp1eb8dd[0]; } $sp2041c7 = isset($spd77a65['field']) ? $spd77a65['field'] : $spb5c5a0; } else { $spaf19c1 = $spd77a65; $sp1eb8dd = explode('?', basename($spaf19c1)); $sp52f712 = $sp1eb8dd[0]; $sp2041c7 = $spb5c5a0; } $sp154c4a = file_get_contents($spaf19c1); $sp586df2 .= $sp2a420b . '
'; $sp586df2 .= 'Content-Disposition: form-data; name="' . $sp2041c7 . '"; filename="' . $sp52f712 . '"' . '
'; $sp586df2 .= 'Content-Type: image/unknown

'; $sp586df2 .= $sp154c4a . '
'; } $sp586df2 .= $spf972a7; return $sp586df2; } }