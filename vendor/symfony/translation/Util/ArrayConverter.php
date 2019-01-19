<?php
 namespace Symfony\Component\Translation\Util; class ArrayConverter { public static function expandToTree(array $messages) { $tree = array(); foreach ($messages as $id => $value) { $referenceToElement = &self::getElementByPath($tree, explode('.', $id)); $referenceToElement = $value; unset($referenceToElement); } return $tree; } private static function &getElementByPath(array &$tree, array $parts) { $elem = &$tree; $parentOfElem = null; foreach ($parts as $i => $part) { if (isset($elem[$part]) && \is_string($elem[$part])) { $elem = &$elem[implode('.', \array_slice($parts, $i))]; break; } $parentOfElem = &$elem; $elem = &$elem[$part]; } if (\is_array($elem) && \count($elem) > 0 && $parentOfElem) { self::cancelExpand($parentOfElem, $part, $elem); } return $elem; } private static function cancelExpand(array &$tree, $prefix, array $node) { $prefix .= '.'; foreach ($node as $id => $value) { if (\is_string($value)) { $tree[$prefix.$id] = $value; } else { self::cancelExpand($tree, $prefix.$id, $value); } } } } 