<?php

namespace UserBundle\Enum;

/**
 * @package UserBundle\Enum
 */
class EntityEnum
{
    const APPI_ENTITY = 'APPI';
    const AI_ENTITY = 'AI';
    const VISITOR_ENTITY = 'VISITEUR';

    /**
     * @return array
     */
    public static function getEntities()
    {
        return [
            self::APPI_ENTITY,
            self::ATI_ENTITY,
            self::VISITOR_ENTITY,
        ];
    }
}