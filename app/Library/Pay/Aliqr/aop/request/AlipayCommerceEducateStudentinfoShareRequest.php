<?php
class AlipayCommerceEducateStudentinfoShareRequest { private $apiParas = array(); private $terminalType; private $terminalInfo; private $prodCode; private $apiVersion = '1.0'; private $notifyUrl; private $returnUrl; private $needEncrypt = false; public function getApiMethodName() { return 'alipay.commerce.educate.studentinfo.share'; } public function setNotifyUrl($spa494d1) { $this->notifyUrl = $spa494d1; } public function getNotifyUrl() { return $this->notifyUrl; } public function setReturnUrl($sp16dca6) { $this->returnUrl = $sp16dca6; } public function getReturnUrl() { return $this->returnUrl; } public function getApiParas() { return $this->apiParas; } public function getTerminalType() { return $this->terminalType; } public function setTerminalType($sp1a9aed) { $this->terminalType = $sp1a9aed; } public function getTerminalInfo() { return $this->terminalInfo; } public function setTerminalInfo($sp60612e) { $this->terminalInfo = $sp60612e; } public function getProdCode() { return $this->prodCode; } public function setProdCode($sp5fdd78) { $this->prodCode = $sp5fdd78; } public function setApiVersion($spba8ce5) { $this->apiVersion = $spba8ce5; } public function getApiVersion() { return $this->apiVersion; } public function setNeedEncrypt($spd4b745) { $this->needEncrypt = $spd4b745; } public function getNeedEncrypt() { return $this->needEncrypt; } }