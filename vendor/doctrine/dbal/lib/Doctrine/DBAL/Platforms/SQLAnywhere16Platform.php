<?php
 namespace Doctrine\DBAL\Platforms; use Doctrine\Common\Proxy\Exception\UnexpectedValueException; use Doctrine\DBAL\Schema\Index; class SQLAnywhere16Platform extends SQLAnywhere12Platform { protected function getAdvancedIndexOptionsSQL(Index $index) { if ($index->hasFlag('with_nulls_distinct') && $index->hasFlag('with_nulls_not_distinct')) { throw new UnexpectedValueException( 'An Index can either have a "with_nulls_distinct" or "with_nulls_not_distinct" flag but not both.' ); } if ( ! $index->isPrimary() && $index->isUnique() && $index->hasFlag('with_nulls_distinct')) { return ' WITH NULLS DISTINCT' . parent::getAdvancedIndexOptionsSQL($index); } return parent::getAdvancedIndexOptionsSQL($index); } protected function getReservedKeywordsClass() { return 'Doctrine\DBAL\Platforms\Keywords\SQLAnywhere16Keywords'; } } 