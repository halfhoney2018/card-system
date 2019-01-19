<?php
 namespace Symfony\Component\HttpFoundation; class ResponseHeaderBag extends HeaderBag { const COOKIES_FLAT = 'flat'; const COOKIES_ARRAY = 'array'; const DISPOSITION_ATTACHMENT = 'attachment'; const DISPOSITION_INLINE = 'inline'; protected $computedCacheControl = array(); protected $cookies = array(); protected $headerNames = array(); public function __construct(array $headers = array()) { parent::__construct($headers); if (!isset($this->headers['cache-control'])) { $this->set('Cache-Control', ''); } if (!isset($this->headers['date'])) { $this->initDate(); } } public function allPreserveCase() { $headers = array(); foreach ($this->all() as $name => $value) { $headers[isset($this->headerNames[$name]) ? $this->headerNames[$name] : $name] = $value; } return $headers; } public function allPreserveCaseWithoutCookies() { $headers = $this->allPreserveCase(); if (isset($this->headerNames['set-cookie'])) { unset($headers[$this->headerNames['set-cookie']]); } return $headers; } public function replace(array $headers = array()) { $this->headerNames = array(); parent::replace($headers); if (!isset($this->headers['cache-control'])) { $this->set('Cache-Control', ''); } if (!isset($this->headers['date'])) { $this->initDate(); } } public function all() { $headers = parent::all(); foreach ($this->getCookies() as $cookie) { $headers['set-cookie'][] = (string) $cookie; } return $headers; } public function set($key, $values, $replace = true) { $uniqueKey = str_replace('_', '-', strtolower($key)); if ('set-cookie' === $uniqueKey) { if ($replace) { $this->cookies = array(); } foreach ((array) $values as $cookie) { $this->setCookie(Cookie::fromString($cookie)); } $this->headerNames[$uniqueKey] = $key; return; } $this->headerNames[$uniqueKey] = $key; parent::set($key, $values, $replace); if (\in_array($uniqueKey, array('cache-control', 'etag', 'last-modified', 'expires'), true)) { $computed = $this->computeCacheControlValue(); $this->headers['cache-control'] = array($computed); $this->headerNames['cache-control'] = 'Cache-Control'; $this->computedCacheControl = $this->parseCacheControl($computed); } } public function remove($key) { $uniqueKey = str_replace('_', '-', strtolower($key)); unset($this->headerNames[$uniqueKey]); if ('set-cookie' === $uniqueKey) { $this->cookies = array(); return; } parent::remove($key); if ('cache-control' === $uniqueKey) { $this->computedCacheControl = array(); } if ('date' === $uniqueKey) { $this->initDate(); } } public function hasCacheControlDirective($key) { return array_key_exists($key, $this->computedCacheControl); } public function getCacheControlDirective($key) { return array_key_exists($key, $this->computedCacheControl) ? $this->computedCacheControl[$key] : null; } public function setCookie(Cookie $cookie) { $this->cookies[$cookie->getDomain()][$cookie->getPath()][$cookie->getName()] = $cookie; $this->headerNames['set-cookie'] = 'Set-Cookie'; } public function removeCookie($name, $path = '/', $domain = null) { if (null === $path) { $path = '/'; } unset($this->cookies[$domain][$path][$name]); if (empty($this->cookies[$domain][$path])) { unset($this->cookies[$domain][$path]); if (empty($this->cookies[$domain])) { unset($this->cookies[$domain]); } } if (empty($this->cookies)) { unset($this->headerNames['set-cookie']); } } public function getCookies($format = self::COOKIES_FLAT) { if (!\in_array($format, array(self::COOKIES_FLAT, self::COOKIES_ARRAY))) { throw new \InvalidArgumentException(sprintf('Format "%s" invalid (%s).', $format, implode(', ', array(self::COOKIES_FLAT, self::COOKIES_ARRAY)))); } if (self::COOKIES_ARRAY === $format) { return $this->cookies; } $flattenedCookies = array(); foreach ($this->cookies as $path) { foreach ($path as $cookies) { foreach ($cookies as $cookie) { $flattenedCookies[] = $cookie; } } } return $flattenedCookies; } public function clearCookie($name, $path = '/', $domain = null, $secure = false, $httpOnly = true) { $this->setCookie(new Cookie($name, null, 1, $path, $domain, $secure, $httpOnly)); } public function makeDisposition($disposition, $filename, $filenameFallback = '') { if (!\in_array($disposition, array(self::DISPOSITION_ATTACHMENT, self::DISPOSITION_INLINE))) { throw new \InvalidArgumentException(sprintf('The disposition must be either "%s" or "%s".', self::DISPOSITION_ATTACHMENT, self::DISPOSITION_INLINE)); } if ('' == $filenameFallback) { $filenameFallback = $filename; } if (!preg_match('/^[\x20-\x7e]*$/', $filenameFallback)) { throw new \InvalidArgumentException('The filename fallback must only contain ASCII characters.'); } if (false !== strpos($filenameFallback, '%')) { throw new \InvalidArgumentException('The filename fallback cannot contain the "%" character.'); } if (false !== strpos($filename, '/') || false !== strpos($filename, '\\') || false !== strpos($filenameFallback, '/') || false !== strpos($filenameFallback, '\\')) { throw new \InvalidArgumentException('The filename and the fallback cannot contain the "/" and "\\" characters.'); } $output = sprintf('%s; filename="%s"', $disposition, str_replace('"', '\\"', $filenameFallback)); if ($filename !== $filenameFallback) { $output .= sprintf("; filename*=utf-8''%s", rawurlencode($filename)); } return $output; } protected function computeCacheControlValue() { if (!$this->cacheControl && !$this->has('ETag') && !$this->has('Last-Modified') && !$this->has('Expires')) { return 'no-cache, private'; } if (!$this->cacheControl) { return 'private, must-revalidate'; } $header = $this->getCacheControlHeader(); if (isset($this->cacheControl['public']) || isset($this->cacheControl['private'])) { return $header; } if (!isset($this->cacheControl['s-maxage'])) { return $header.', private'; } return $header; } private function initDate() { $now = \DateTime::createFromFormat('U', time()); $now->setTimezone(new \DateTimeZone('UTC')); $this->set('Date', $now->format('D, d M Y H:i:s').' GMT'); } } 