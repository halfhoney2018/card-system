<?php
class AlipayEcardEduPublicBindRequest { private $agentCode; private $agreementId; private $alipayUserId; private $cardName; private $cardNo; private $publicId; private $apiParas = array(); private $terminalType; private $terminalInfo; private $prodCode; private $apiVersion = '1.0'; private $notifyUrl; private $returnUrl; private $needEncrypt = false; public function setAgentCode($sp4f6c1e) { $this->agentCode = $sp4f6c1e; $this->apiParas['agent_code'] = $sp4f6c1e; } public function getAgentCode() { return $this->agentCode; } public function setAgreementId($spea6432) { $this->agreementId = $spea6432; $this->apiParas['agreement_id'] = $spea6432; } public function getAgreementId() { return $this->agreementId; } public function setAlipayUserId($spcbf953) { $this->alipayUserId = $spcbf953; $this->apiParas['alipay_user_id'] = $spcbf953; } public function getAlipayUserId() { return $this->alipayUserId; } public function setCardName($sp29458d) { $this->cardName = $sp29458d; $this->apiParas['card_name'] = $sp29458d; } public function getCardName() { return $this->cardName; } public function setCardNo($sp547991) { $this->cardNo = $sp547991; $this->apiParas['card_no'] = $sp547991; } public function getCardNo() { return $this->cardNo; } public function setPublicId($sp52f8d7) { $this->publicId = $sp52f8d7; $this->apiParas['public_id'] = $sp52f8d7; } public function getPublicId() { return $this->publicId; } public function getApiMethodName() { return 'alipay.ecard.edu.public.bind'; } public function setNotifyUrl($spa494d1) { $this->notifyUrl = $spa494d1; } public function getNotifyUrl() { return $this->notifyUrl; } public function setReturnUrl($sp16dca6) { $this->returnUrl = $sp16dca6; } public function getReturnUrl() { return $this->returnUrl; } public function getApiParas() { return $this->apiParas; } public function getTerminalType() { return $this->terminalType; } public function setTerminalType($sp1a9aed) { $this->terminalType = $sp1a9aed; } public function getTerminalInfo() { return $this->terminalInfo; } public function setTerminalInfo($sp60612e) { $this->terminalInfo = $sp60612e; } public function getProdCode() { return $this->prodCode; } public function setProdCode($sp5fdd78) { $this->prodCode = $sp5fdd78; } public function setApiVersion($spba8ce5) { $this->apiVersion = $spba8ce5; } public function getApiVersion() { return $this->apiVersion; } public function setNeedEncrypt($spd4b745) { $this->needEncrypt = $spd4b745; } public function getNeedEncrypt() { return $this->needEncrypt; } }