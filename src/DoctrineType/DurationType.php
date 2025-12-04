<?php

namespace App\DoctrineType;

use App\DataType\Duration;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class DurationType extends Type
{
    public const TYPE = 'duration';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getIntegerTypeDeclarationSQL($column);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Duration
    {
        if (is_null($value)) {
            return null;
        }

        return new Duration($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (is_null($value)) {
            return null;
        }

        if (!$value instanceof Duration) {
            throw new \InvalidArgumentException(sprintf('Value must be an instance of %s', Duration::class));
        }

        return $value->toInt();
    }
}
