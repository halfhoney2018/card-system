<?php
 namespace Symfony\Component\Translation; use Symfony\Component\Translation\Exception\InvalidArgumentException; interface TranslatorInterface { public function trans($id, array $parameters = array(), $domain = null, $locale = null); public function transChoice($id, $number, array $parameters = array(), $domain = null, $locale = null); public function setLocale($locale); public function getLocale(); } 