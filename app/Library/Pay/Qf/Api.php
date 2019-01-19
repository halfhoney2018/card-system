<?php
namespace App\Library\Pay\Qf; use App\Library\CurlRequest as Request; use App\Library\Pay\ApiInterface; use Illuminate\Support\Facades\Log; class Api implements ApiInterface { private $url_notify = ''; private $url_return = ''; public function __construct($spae6a5b) { $this->url_notify = SYS_URL_API . '/pay/notify/' . $spae6a5b; $this->url_return = SYS_URL . '/pay/return/' . $spae6a5b; } function goPay($sp42f333, $sp79d97c, $spf49dcd, $spa1a573, $sp39c1e2) { $sp5daeb8 = strtolower($sp42f333['payway']); if (!isset($sp42f333['id'])) { throw new \Exception('请设置 id'); } $sp71f60e = array(); if ($sp5daeb8 == 'qq') { $sp71f60e = array('User-Agent' => 'Mozilla/5.0 Mobile MQQBrowser/6.2 QQ/7.2.5.3305'); } elseif ($sp5daeb8 == 'alipay') { $sp71f60e = array('User-Agent' => 'Mozilla/5.0 AlipayChannelId/5136 AlipayDefined(nt:WIFI,ws:411|0|2.625) AliApp(AP/10.1.10.1226101) AlipayClient/10.1.10.1226101'); } $spf4f2b2 = ''; $sp3321a5 = Request::get('https://o2.qfpay.com/q/info?code=&huid=' . $sp42f333['id'] . '&opuid=&reqid=' . $sp79d97c, $spf4f2b2, $sp71f60e); $spb06c2a = static::str_between($sp3321a5, 'reqid":"', '"'); $spe74dfd = static::str_between($sp3321a5, 'currency":"', '"'); if ($spb06c2a == '' || $spe74dfd == '') { Log::error('qfpay pay, 获取支付金额失败 - ' . $sp3321a5); throw new \Exception('获取支付请求id失败'); } $spac1284 = Request::post('https://o2.qfpay.com/q/payment', 'txamt=' . $sp39c1e2 . '&openid=&appid=&huid=' . $sp42f333['id'] . '&opuid=&reqid=' . $spb06c2a . '&balance=0&currency=' . $spe74dfd, $spf4f2b2, $sp71f60e); $sp594fbb = json_decode($spac1284, true); $sp3618bd = static::str_between($spac1284, 'syssn":"', '"'); if (!$sp594fbb || $sp3618bd == '') { Log::error('qfpay pay, 生成支付单号失败#1 - ' . $spac1284); throw new \Exception('生成支付单号失败#1'); } if ($sp594fbb['respcd'] !== '0000') { if (isset($sp594fbb['respmsg']) && $sp594fbb['respmsg'] !== '') { throw new \Exception($sp594fbb['respmsg']); } Log::error('qfpay pay, 生成支付单号失败#2 - ' . $spac1284); throw new \Exception('生成支付单号失败#2'); } \App\Order::whereOrderNo($sp79d97c)->update(array('pay_trade_no' => $sp3618bd)); header('location: /qrcode/pay/' . $sp79d97c . '/qf_' . $sp5daeb8 . '?url=' . urlencode(json_encode($sp594fbb['data']['pay_params']))); } function verify($sp42f333, $sp7b72fc) { $sp871a53 = \App\Order::whereOrderNo($sp42f333['out_trade_no'])->firstOrFail(); $sp3618bd = $sp871a53->pay_trade_no; $spc2442c = Request::get('https://marketing.qfpay.com/v1/mkw/activity?syssn=' . $sp3618bd); $sp203cf1 = json_decode($spc2442c, true); if (!$spc2442c) { throw new \Exception('query error'); } if (!isset($sp203cf1['respcd'])) { Log::error('qfpay query, 获取支付结果失败 - ' . $spc2442c); throw new \Exception('获取支付结果失败'); } if ($sp203cf1['respcd'] !== '0000') { return false; } $sp5d3a7c = (int) static::str_between($spc2442c, 'trade_amt":', ','); if ($sp5d3a7c === 0) { $sp5d3a7c = (int) static::str_between($spc2442c, 'txamt":', ','); if ($sp5d3a7c === 0) { Log::error('qfpay query, 获取支付金额失败 - ' . $spc2442c); throw new \Exception('获取支付金额失败'); } } if ($sp203cf1['respcd'] === '0000') { $sp7b72fc($sp42f333['out_trade_no'], $sp5d3a7c, $sp3618bd); return true; } return false; } public static function str_between($spf2d586, $sp7f5952, $spdeaedc) { $sp19a9aa = stripos($spf2d586, $sp7f5952); if ($sp19a9aa === false) { return ''; } $sp9c71e0 = stripos($spf2d586, $spdeaedc, $sp19a9aa + strlen($sp7f5952)); if ($sp9c71e0 === false || $sp19a9aa >= $sp9c71e0) { return ''; } $sp20213c = strlen($sp7f5952); $sp7210a9 = substr($spf2d586, $sp19a9aa + $sp20213c, $sp9c71e0 - $sp19a9aa - $sp20213c); return $sp7210a9; } }