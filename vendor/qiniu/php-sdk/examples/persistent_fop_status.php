<?php
require_once __DIR__ . '/../autoload.php'; use Qiniu\Processing\PersistentFop; $pfop = new Qiniu\Processing\PersistentFop(null, null); $persistentId = 'z1.5b8a48e5856db843bc24cfc3'; list($ret, $err) = $pfop->status($persistentId); if ($err) { print_r($err); } else { print_r($ret); } 