<?php

namespace App\Filter\Modifier\Factory;

use App\Filter\Modifier\PriceModifierInterface;
use Symfony\Component\VarExporter\Exception\ClassNotFoundException;

class PriceModifierFactory implements PriceModifierFactoryInterface
{
    /**
     * @throws ClassNotFoundException
     */
    public function create(string $modifierType): PriceModifierInterface
    {
        $baseModifierClassName = str_replace('_','', ucwords($modifierType, '_'));

        $modifierName  = self::BASE_MODIFIER_NAMESPACE . $baseModifierClassName;

        if(!class_exists($modifierName)){
            throw new ClassNotFoundException($modifierName);
        }

        return new $modifierName();
    }
}
