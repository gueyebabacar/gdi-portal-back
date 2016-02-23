<?php

namespace UserBundle\Enum;

/**
 * @package UserBundle\Enum
 */
class EntityEnum
{
    const APPO_ENTITY = 'APPO';
    const ATG_ENTITY = 'ATG';
    const VISITOR_ENTITY = 'VISITEUR';

    /**
     * @return array
     */
    public static function getEntities()
    {
        return [
            self::APPO_ENTITY,
            self::ATG_ENTITY,
            self::VISITOR_ENTITY,
        ];
    }
}