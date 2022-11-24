<?php
namespace App\DBAL;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class EnumSignificanceType extends Type
{
    const ENUM_SIGNIFICANCE = 'enum_significance';
    const SIGNIFICANCE_PRINCIPAL = 'principal';
    const SIGNIFICANCE_SECONDAIRE = 'secondaire';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return "ENUM('principal', 'secondaire')";
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $value;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (!in_array($value, array(self::SIGNIFICANCE_PRINCIPAL, self::SIGNIFICANCE_SECONDAIRE))) {
            throw new \InvalidArgumentException("Invalid significance");
        }
        return $value;
    }

    public function getName(): string
    {
        return self::ENUM_SIGNIFICANCE;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
