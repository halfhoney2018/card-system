<?php
 namespace Doctrine\DBAL\Types; use Doctrine\DBAL\Platforms\AbstractPlatform; class TimeType extends Type { public function getName() { return Type::TIME; } public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform) { return $platform->getTimeTypeDeclarationSQL($fieldDeclaration); } public function convertToDatabaseValue($value, AbstractPlatform $platform) { return ($value !== null) ? $value->format($platform->getTimeFormatString()) : null; } public function convertToPHPValue($value, AbstractPlatform $platform) { if ($value === null || $value instanceof \DateTime) { return $value; } $val = \DateTime::createFromFormat('!' . $platform->getTimeFormatString(), $value); if ( ! $val) { throw ConversionException::conversionFailedFormat($value, $this->getName(), $platform->getTimeFormatString()); } return $val; } } 