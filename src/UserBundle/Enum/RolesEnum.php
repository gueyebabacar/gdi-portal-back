<?php

namespace UserBundle\Enum;

/**
 * @package UserBundle\Enum
 */
class RolesEnum
{
    const ROLE_VISITEUR = 'ROLE_VISITEUR';
    const ROLE_VISITEUR_LABEL = 'Visiteur';

    const ROLE_TECHNICIEN = 'ROLE_TECHNICIEN';
    const ROLE_TECHNICIEN_LABEL = 'Technicien';

    const ROLE_PROGRAMMATEUR = 'ROLE_PROGRAMMATEUR';
    const ROLE_PROGRAMMATEUR_LABEL = 'Programmateur';

    const ROLE_PROGRAMMATEUR_AVANCE = 'ROLE_PROGRAMMATEUR_AVANCE';
    const ROLE_PROGRAMMATEUR_AVANCE_LABEL = 'Programmateur avancé';

    const ROLE_MANAGER_APPO = 'ROLE_MANAGER_APPO';
    const ROLE_MANAGER_APPO_LABEL = 'Manager APPO';

    const ROLE_MANAGER_ATG = 'ROLE_MANAGER_ATG';
    const ROLE_MANAGER_ATG_LABEL = 'Manager ATG';

    const ROLE_REFERENT_EQUIPE = 'ROLE_REFERENT_EQUIPE';
    const ROLE_REFERENT_EQUIPE_LABEL = 'Référent équipe';

    const ROLE_ADMINISTRATEUR_NATIONAL = 'ROLE_ADMINISTRATEUR_NATIONAL';
    const ROLE_ADMINISTRATEUR_NATIONAL_LABEL = 'Administrateur national';

    const ROLE_ADMINISTRATEUR_LOCAL = 'ROLE_ADMINISTRATEUR_LOCAL';
    const ROLE_ADMINISTRATEUR_LOCAL_LABEL = 'Administrateur local';

    const ROLE_ADMINISTRATEUR_SI = 'ROLE_ADMINISTRATEUR_SI';
    const ROLE_ADMINISTRATEUR_SI_LABEL = 'Administrateur SI';

    public static function getRoles()
    {
        return [
            self::ROLE_VISITEUR => self::ROLE_VISITEUR_LABEL,
            self::ROLE_TECHNICIEN => self::ROLE_TECHNICIEN_LABEL,
            self::ROLE_PROGRAMMATEUR => self::ROLE_PROGRAMMATEUR_LABEL,
            self::ROLE_PROGRAMMATEUR_AVANCE => self::ROLE_PROGRAMMATEUR_AVANCE_LABEL,
            self::ROLE_MANAGER_APPO => self::ROLE_MANAGER_APPO_LABEL,
            self::ROLE_MANAGER_ATG => self::ROLE_MANAGER_ATG_LABEL,
            self::ROLE_REFERENT_EQUIPE => self::ROLE_REFERENT_EQUIPE_LABEL,
            self::ROLE_ADMINISTRATEUR_LOCAL => self::ROLE_ADMINISTRATEUR_LOCAL_LABEL,
            self::ROLE_ADMINISTRATEUR_NATIONAL => self::ROLE_ADMINISTRATEUR_NATIONAL_LABEL,
            self::ROLE_ADMINISTRATEUR_SI => self::ROLE_ADMINISTRATEUR_SI_LABEL,
        ];
    }

    public static function roleHierarchy($role){
        return array_search($role ,array_keys(self::getRoles()));
    }
}