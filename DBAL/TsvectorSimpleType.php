<?php

namespace Oi\PostgresSearchBundle\DBAL;

use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * Override of the tsvector to have one with only the simple
 * dictionary being used, to prevent unwantingly truncating
 * names. I couldn't find a way to do this with options.
 *
 * @link https://www.postgresql.org/docs/current/textsearch-dictionaries.html#TEXTSEARCH-SIMPLE-DICTIONARY
 */
class TsvectorSimpleType extends TsvectorType
{
    public function getName()
    {
        return 'tsvector_simple';
    }

    public function convertToDatabaseValueSQL($sqlExpr, AbstractPlatform $platform)
    {
        return sprintf('to_tsvector(\'simple\', %s)', $sqlExpr);
    }
}
