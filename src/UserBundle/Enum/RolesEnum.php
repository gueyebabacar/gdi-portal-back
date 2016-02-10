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

    const ROLE_ADMINISTRATEUR_REGIONAL = 'ROLE_ADMINISTRATEUR_REGIONAL';
    const ROLE_ADMINISTRATEUR_REGIONAL_LABEL = 'Administrateur régional';

    const ROLE_ADMINISTRATEUR_SI = 'ROLE_ADMINISTRATEUR_SI';
    const ROLE_ADMINISTRATEUR_SI_LABEL = 'Administrateur SI';

    public function getRoles()
    {
        return [
            $this::ROLE_VISITEUR => $this::ROLE_VISITEUR_LABEL,
            $this::ROLE_TECHNICIEN => $this::ROLE_TECHNICIEN_LABEL,
            $this::ROLE_PROGRAMMATEUR => $this::ROLE_PROGRAMMATEUR_LABEL,
            $this::ROLE_PROGRAMMATEUR_AVANCE => $this::ROLE_PROGRAMMATEUR_AVANCE_LABEL,
            $this::ROLE_MANAGER_APPO => $this::ROLE_MANAGER_APPO_LABEL,
            $this::ROLE_MANAGER_ATG => $this::ROLE_MANAGER_ATG_LABEL,
            $this::ROLE_REFERENT_EQUIPE => $this::ROLE_REFERENT_EQUIPE_LABEL,
            $this::ROLE_ADMINISTRATEUR_NATIONAL => $this::ROLE_ADMINISTRATEUR_NATIONAL_LABEL,
            $this::ROLE_ADMINISTRATEUR_REGIONAL => $this::ROLE_ADMINISTRATEUR_REGIONAL_LABEL,
            $this::ROLE_ADMINISTRATEUR_SI => $this::ROLE_ADMINISTRATEUR_SI_LABEL,
        ];
    }
}