<?php

namespace PortalBundle\Enum;

class VoterEnum
{
    const VIEW = 'view';
    const EDIT = 'edit';
    const DELETE = 'delete';

    public static function getActions()
    {
        return [
            self::VIEW,
            self::EDIT,
            self::DELETE
        ];
    }
}