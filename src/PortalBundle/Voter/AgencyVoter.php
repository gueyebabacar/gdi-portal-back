<?php

namespace PortalBundle\Voter;

use PortalBundle\Entity\Agency;
use PortalBundle\Enum\VoterEnum;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use UserBundle\Entity\User;
use UserBundle\Enum\ContextEnum;

class AgencyVoter extends Voter
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
        if (!$subject instanceof Agency) {
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
        /** @var Agency $agencyViewed */
        $agencyViewed = $subject;
        switch ($attribute) {
            case VoterEnum::VIEW:
                return $this->canView($agencyViewed, $user);
            case VoterEnum::EDIT:
                return $this->canEdit($agencyViewed, $user);
            case VoterEnum::DELETE:
                return $this->canDelete($agencyViewed, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    /**
     * @param Agency $agencyViewed
     * @param User $user
     * @return bool
     */
    private function canView(Agency $agencyViewed, User $user)
    {
        if (!$this->canEdit($agencyViewed, $user)) {
            return false;
        }
        return true;
    }

    /**
     * @param Agency $agencyViewed
     * @param User $user
     * @return bool
     */
    private function canDelete(Agency $agencyViewed, User $user)
    {
        // If the user can edit then he can delete
        if (!$this->canEdit($agencyViewed, $user)) {
            return false;
        }
        return true;
    }

    /**
     * @param Agency $agencyViewed
     * @param User $user
     * @return bool
     */
    private function canEdit(Agency $agencyViewed, User $user)
    {
        switch ($user->getTerritorialContext()) {
            case ContextEnum::AGENCY_CONTEXT:
                if ($user->getAgency() !== $agencyViewed) {
                    return false;
                }
                return true;
                break;

            case ContextEnum::REGION_CONTEXT:
                if (!$user->getRegion()->getAgencies()->contains($agencyViewed)) {
                    return false;
                }
                return true;
                break;

            case ContextEnum::NATIONAL_CONTEXT:
                return true;
                break;

            default:
                return false;
                break;
        }
    }
}