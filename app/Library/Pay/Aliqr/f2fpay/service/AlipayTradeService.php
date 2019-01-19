<?php
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . './../../AopSdk.php'; require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . './../model/result/AlipayF2FPayResult.php'; require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '../model/result/AlipayF2FQueryResult.php'; require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '../model/result/AlipayF2FRefundResult.php'; require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '../model/result/AlipayF2FPrecreateResult.php'; require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '../model/builder/AlipayTradeQueryContentBuilder.php'; require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '../model/builder/AlipayTradeCancelContentBuilder.php'; require dirname(__FILE__) . DIRECTORY_SEPARATOR . '../config/config.php'; class AlipayTradeService { public $gateway_url = 'https://openapi.alipay.com/gateway.do'; public $notify_url; public $sign_type; public $alipay_public_key; public $private_key; public $appid; public $charset = 'UTF-8'; public $token = NULL; private $MaxQueryRetry; private $QueryDuration; public $format = 'json'; function __construct($spcef7af) { $this->gateway_url = $spcef7af['gatewayUrl']; $this->appid = $spcef7af['app_id']; $this->sign_type = $spcef7af['sign_type']; $this->private_key = $spcef7af['merchant_private_key']; $this->alipay_public_key = $spcef7af['alipay_public_key']; $this->charset = $spcef7af['charset']; $this->MaxQueryRetry = $spcef7af['MaxQueryRetry']; $this->QueryDuration = $spcef7af['QueryDuration']; $this->notify_url = $spcef7af['notify_url']; if (empty($this->appid) || trim($this->appid) == '') { throw new Exception('appid should not be NULL!'); } if (empty($this->private_key) || trim($this->private_key) == '') { throw new Exception('private_key should not be NULL!'); } if (empty($this->alipay_public_key) || trim($this->alipay_public_key) == '') { throw new Exception('alipay_public_key should not be NULL!'); } if (empty($this->charset) || trim($this->charset) == '') { throw new Exception('charset should not be NULL!'); } if (empty($this->QueryDuration) || trim($this->QueryDuration) == '') { throw new Exception('QueryDuration should not be NULL!'); } if (empty($this->gateway_url) || trim($this->gateway_url) == '') { throw new Exception('gateway_url should not be NULL!'); } if (empty($this->MaxQueryRetry) || trim($this->MaxQueryRetry) == '') { throw new Exception('MaxQueryRetry should not be NULL!'); } if (empty($this->sign_type) || trim($this->sign_type) == '') { throw new Exception('sign_type should not be NULL'); } } function AlipayWapPayService($spcef7af) { $this->__construct($spcef7af); } public function barPay($sp6399bd) { $sp69f75e = $sp6399bd->getOutTradeNo(); $spe0aa15 = $sp6399bd->getBizContent(); $sp1400b4 = $sp6399bd->getAppAuthToken(); $this->writeLog($spe0aa15); $sp2f63b0 = new AlipayTradePayRequest(); $sp2f63b0->setBizContent($spe0aa15); $spf1d2fd = $this->aopclientRequestExecute($sp2f63b0, NULL, $sp1400b4); $spf1d2fd = $spf1d2fd->alipay_trade_pay_response; $sp594fbb = new AlipayF2FPayResult($spf1d2fd); if (!empty($spf1d2fd) && '10000' == $spf1d2fd->code) { $sp594fbb->setTradeStatus('SUCCESS'); } elseif (!empty($spf1d2fd) && '10003' == $spf1d2fd->code) { $sp45a2b0 = new AlipayTradeQueryContentBuilder(); $sp45a2b0->setOutTradeNo($sp69f75e); $sp45a2b0->setAppAuthToken($sp1400b4); $spab9640 = $this->loopQueryResult($sp45a2b0); return $this->checkQueryAndCancel($sp69f75e, $sp1400b4, $sp594fbb, $spab9640); } elseif ($this->tradeError($spf1d2fd)) { $sp45a2b0 = new AlipayTradeQueryContentBuilder(); $sp45a2b0->setOutTradeNo($sp69f75e); $sp45a2b0->setAppAuthToken($sp1400b4); $sp803139 = $this->query($sp45a2b0); return $this->checkQueryAndCancel($sp69f75e, $sp1400b4, $sp594fbb, $sp803139); } else { $sp594fbb->setTradeStatus('FAILED'); } return $sp594fbb; } public function queryTradeResult($sp6399bd) { $spf1d2fd = $this->query($sp6399bd); $sp594fbb = new AlipayF2FQueryResult($spf1d2fd); if ($this->querySuccess($spf1d2fd)) { $sp594fbb->setTradeStatus('SUCCESS'); } elseif ($this->tradeError($spf1d2fd)) { $sp594fbb->setTradeStatus('UNKNOWN'); } else { $sp594fbb->setTradeStatus('FAILED'); } return $sp594fbb; } public function refund($sp6399bd) { $spe0aa15 = $sp6399bd->getBizContent(); $this->writeLog($spe0aa15); $sp2f63b0 = new AlipayTradeRefundRequest(); $sp2f63b0->setBizContent($spe0aa15); $spf1d2fd = $this->aopclientRequestExecute($sp2f63b0, NULL, $sp6399bd->getAppAuthToken()); $spf1d2fd = $spf1d2fd->alipay_trade_refund_response; $sp594fbb = new AlipayF2FRefundResult($spf1d2fd); if (!empty($spf1d2fd) && '10000' == $spf1d2fd->code) { $sp594fbb->setTradeStatus('SUCCESS'); } elseif ($this->tradeError($spf1d2fd)) { $sp594fbb->setTradeStatus('UNKNOWN'); } else { $sp594fbb->setTradeStatus('FAILED'); } return $sp594fbb; } public function qrPay($sp6399bd) { $spe0aa15 = $sp6399bd->getBizContent(); $this->writeLog($spe0aa15); $sp2f63b0 = new AlipayTradePrecreateRequest(); $sp2f63b0->setBizContent($spe0aa15); $sp2f63b0->setNotifyUrl($this->notify_url); $spf1d2fd = $this->aopclientRequestExecute($sp2f63b0, NULL, $sp6399bd->getAppAuthToken()); $spf1d2fd = $spf1d2fd->alipay_trade_precreate_response; $sp594fbb = new AlipayF2FPrecreateResult($spf1d2fd); if (!empty($spf1d2fd) && '10000' == $spf1d2fd->code) { $sp594fbb->setTradeStatus('SUCCESS'); } elseif ($this->tradeError($spf1d2fd)) { $sp594fbb->setTradeStatus('UNKNOWN'); } else { $sp594fbb->setTradeStatus('FAILED'); } return $sp594fbb; } public function query($sp45a2b0) { $sp80ac20 = $sp45a2b0->getBizContent(); $this->writeLog($sp80ac20); $sp2f63b0 = new AlipayTradeQueryRequest(); $sp2f63b0->setBizContent($sp80ac20); $spf1d2fd = $this->aopclientRequestExecute($sp2f63b0, NULL, $sp45a2b0->getAppAuthToken()); return $spf1d2fd->alipay_trade_query_response; } protected function loopQueryResult($sp45a2b0) { $sp31d422 = NULL; for ($sp3deb2c = 1; $sp3deb2c < $this->MaxQueryRetry; $sp3deb2c++) { try { sleep($this->QueryDuration); } catch (Exception $spa9e936) { print $spa9e936->getMessage(); die; } $sp803139 = $this->query($sp45a2b0); if (!empty($sp803139)) { if ($this->stopQuery($sp803139)) { return $sp803139; } $sp31d422 = $sp803139; } } return $sp31d422; } protected function stopQuery($spf1d2fd) { if ('10000' == $spf1d2fd->code) { if ('TRADE_FINISHED' == $spf1d2fd->trade_status || 'TRADE_SUCCESS' == $spf1d2fd->trade_status || 'TRADE_CLOSED' == $spf1d2fd->trade_status) { return true; } } return false; } private function checkQueryAndCancel($sp69f75e, $sp1400b4, $sp594fbb, $sp803139) { if ($this->querySuccess($sp803139)) { $sp594fbb->setTradeStatus('SUCCESS'); $sp594fbb->setResponse($sp803139); return $sp594fbb; } elseif ($this->queryClose($sp803139)) { $sp594fbb->setTradeStatus('FAILED'); return $sp594fbb; } $spc6edc6 = new AlipayTradeCancelContentBuilder(); $spc6edc6->setAppAuthToken($sp1400b4); $spc6edc6->setOutTradeNo($sp69f75e); $sp96e276 = $this->cancel($spc6edc6); if ($this->tradeError($sp96e276)) { $sp594fbb->setTradeStatus('UNKNOWN'); } else { $sp594fbb->setTradeStatus('FAILED'); } return $sp594fbb; } protected function querySuccess($sp803139) { return !empty($sp803139) && $sp803139->code == '10000' && ($sp803139->trade_status == 'TRADE_SUCCESS' || $sp803139->trade_status == 'TRADE_FINISHED'); } protected function queryClose($sp803139) { return !empty($sp803139) && $sp803139->code == '10000' && $sp803139->trade_status == 'TRADE_CLOSED'; } protected function tradeError($spf1d2fd) { return empty($spf1d2fd) || $spf1d2fd->code == '20000'; } public function cancel($spc6edc6) { $sp80ac20 = $spc6edc6->getBizContent(); $this->writeLog($sp80ac20); $sp2f63b0 = new AlipayTradeCancelRequest(); $sp2f63b0->setBizContent($sp80ac20); $spf1d2fd = $this->aopclientRequestExecute($sp2f63b0, NULL, $spc6edc6->getAppAuthToken()); return $spf1d2fd->alipay_trade_cancel_response; } private function aopclientRequestExecute($sp2f63b0, $sp8eb6a2 = NULL, $sp1400b4 = NULL) { $sp75825c = new AopClient(); $sp75825c->gatewayUrl = $this->gateway_url; $sp75825c->appId = $this->appid; $sp75825c->signType = $this->sign_type; $sp75825c->rsaPrivateKey = $this->private_key; $sp75825c->alipayrsaPublicKey = $this->alipay_public_key; $sp75825c->apiVersion = '1.0'; $sp75825c->postCharset = $this->charset; $sp75825c->format = $this->format; $sp75825c->debugInfo = true; $sp594fbb = $sp75825c->execute($sp2f63b0, $sp8eb6a2, $sp1400b4); return $sp594fbb; } function writeLog($sp30dc6c) { file_put_contents(dirname(__FILE__) . '/../log/log.txt', date('Y-m-d H:i:s') . '  ' . $sp30dc6c . '
', FILE_APPEND); } function create_erweima($sp154c4a, $spca33a2 = '200', $sp2e5ee4 = 'L', $spe232b0 = '0') { $sp154c4a = urlencode($sp154c4a); $sp189aa0 = '<img src="http://chart.apis.google.com/chart?chs=' . $spca33a2 . 'x' . $spca33a2 . '&amp;cht=qr&chld=' . $sp2e5ee4 . '|' . $spe232b0 . '&amp;chl=' . $sp154c4a . '"  widht="' . $spca33a2 . '" height="' . $spca33a2 . '" />'; return $sp189aa0; } function create_erweima_url($sp154c4a, $spca33a2 = '200', $sp2e5ee4 = 'L', $spe232b0 = '0') { $sp154c4a = urlencode($sp154c4a); $sp189aa0 = 'http://chart.apis.google.com/chart?chs=' . $spca33a2 . 'x' . $spca33a2 . '&amp;cht=qr&chld=' . $sp2e5ee4 . '|' . $spe232b0 . '&amp;chl=' . $sp154c4a; return $sp189aa0; } }