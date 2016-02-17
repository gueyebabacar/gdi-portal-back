<?php

namespace PortalBundle\Voter;

use PortalBundle\Enum\VoterEnum;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use UserBundle\Entity\User;
use UserBundle\Enum\ContextEnum;
use UserBundle\Enum\RolesEnum;

class RoleVoter extends Voter
{
    /**
     * Determines if the attribute and subject are supported by this voter.
     *
     * @param string $attribute An attribute
     * @param mixed $subject The subject to secure, e.g. an object the user wants to access or any other PHP type
     *
     * @return bool True if the attribute and subject are supported, false otherwise
     */
    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, VoterEnum::getActions())) {
            return false;
        }

        if (!is_string($subject) && !preg_match('/ROLE_/',$subject)) {
            return false;
        }
        return true;
    }

    /**
     * Perform a single access check operation on a given attribute, subject and token.
     *
     * @param string $attribute
     * @param mixed $subject
     * @param TokenInterface $token
     *
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        // you know $subject is a Post object, thanks to supports
        /** @var $roleViewed */
        $roleViewed = $subject;
        switch ($attribute) {
            case VoterEnum::VIEW:
                return $this->canView($roleViewed, $user);
            case VoterEnum::EDIT:
                return $this->canEdit($roleViewed, $user);
            case VoterEnum::DELETE:
                return $this->canDelete($roleViewed, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    /**
     * @param $roleViewed
     * @param User $user
     * @return bool
     */
    private function canView($roleViewed, User $user)
    {
        // If the user can edit then he can view
        if (!$this->canEdit($roleViewed, $user)) {
            return false;
        }
        return true;
    }

    /**
     * @param $roleViewed
     * @param User $user
     * @return bool
     */
    private function canDelete($roleViewed, User $user)
    {
        // If the user can edit then he can delete
        if (!$this->canEdit($roleViewed, $user)) {
            return false;
        }
        return true;
    }

    /**
     * @param $roleViewed
     * @param User $user
     * @return bool
     */
    private function canEdit($roleViewed, User $user)
    {
        $userRole = $user->getRoles()[0];
        switch ($userRole) {
            case RolesEnum::ROLE_ADMINISTRATEUR_SI:
                return true;
                break;

            default:
                if(RolesEnum::roleHierarchy($userRole) <= RolesEnum::roleHierarchy($roleViewed)) {
                    return false;
                }
                return true;
                break;
        }
    }
}