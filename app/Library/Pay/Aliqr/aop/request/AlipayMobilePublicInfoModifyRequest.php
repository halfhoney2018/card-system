<?php
class AlipayMobilePublicInfoModifyRequest { private $appName; private $authPic; private $licenseUrl; private $logoUrl; private $publicGreeting; private $shopPic1; private $shopPic2; private $shopPic3; private $apiParas = array(); private $terminalType; private $terminalInfo; private $prodCode; private $apiVersion = '1.0'; private $notifyUrl; private $returnUrl; private $needEncrypt = false; public function setAppName($spde8c81) { $this->appName = $spde8c81; $this->apiParas['app_name'] = $spde8c81; } public function getAppName() { return $this->appName; } public function setAuthPic($sp2859ac) { $this->authPic = $sp2859ac; $this->apiParas['auth_pic'] = $sp2859ac; } public function getAuthPic() { return $this->authPic; } public function setLicenseUrl($sp8e1362) { $this->licenseUrl = $sp8e1362; $this->apiParas['license_url'] = $sp8e1362; } public function getLicenseUrl() { return $this->licenseUrl; } public function setLogoUrl($sp901017) { $this->logoUrl = $sp901017; $this->apiParas['logo_url'] = $sp901017; } public function getLogoUrl() { return $this->logoUrl; } public function setPublicGreeting($sp6d9c00) { $this->publicGreeting = $sp6d9c00; $this->apiParas['public_greeting'] = $sp6d9c00; } public function getPublicGreeting() { return $this->publicGreeting; } public function setShopPic1($spf3b64a) { $this->shopPic1 = $spf3b64a; $this->apiParas['shop_pic1'] = $spf3b64a; } public function getShopPic1() { return $this->shopPic1; } public function setShopPic2($spc70a32) { $this->shopPic2 = $spc70a32; $this->apiParas['shop_pic2'] = $spc70a32; } public function getShopPic2() { return $this->shopPic2; } public function setShopPic3($spd6b0a5) { $this->shopPic3 = $spd6b0a5; $this->apiParas['shop_pic3'] = $spd6b0a5; } public function getShopPic3() { return $this->shopPic3; } public function getApiMethodName() { return 'alipay.mobile.public.info.modify'; } public function setNotifyUrl($spa494d1) { $this->notifyUrl = $spa494d1; } public function getNotifyUrl() { return $this->notifyUrl; } public function setReturnUrl($sp16dca6) { $this->returnUrl = $sp16dca6; } public function getReturnUrl() { return $this->returnUrl; } public function getApiParas() { return $this->apiParas; } public function getTerminalType() { return $this->terminalType; } public function setTerminalType($sp1a9aed) { $this->terminalType = $sp1a9aed; } public function getTerminalInfo() { return $this->terminalInfo; } public function setTerminalInfo($sp60612e) { $this->terminalInfo = $sp60612e; } public function getProdCode() { return $this->prodCode; } public function setProdCode($sp5fdd78) { $this->prodCode = $sp5fdd78; } public function setApiVersion($spba8ce5) { $this->apiVersion = $spba8ce5; } public function getApiVersion() { return $this->apiVersion; } public function setNeedEncrypt($spd4b745) { $this->needEncrypt = $spd4b745; } public function getNeedEncrypt() { return $this->needEncrypt; } }