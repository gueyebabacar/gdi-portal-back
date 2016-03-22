<?php

namespace PortalBundle\Voter;

use PortalBundle\Entity\Region;
use PortalBundle\Enum\VoterEnum;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use UserBundle\Entity\User;
use UserBundle\Enum\ContextEnum;

class RegionVoter extends Voter
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

        if (!$subject instanceof Region) {
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
        /** @var Region $regionViewed */
        $regionViewed = $subject;
        switch ($attribute) {
            case VoterEnum::VIEW:
                return $this->canView($regionViewed, $user);
            case VoterEnum::EDIT:
                return $this->canEdit($regionViewed, $user);
            case VoterEnum::DELETE:
                return $this->canDelete($regionViewed, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    /**
     * @param Region $regionViewed
     * @param User $user
     * @return bool
     */
    private function canView(Region $regionViewed, User $user)
    {
        if (!$this->canEdit($regionViewed, $user)) {
            return false;
        }
        return true;
    }

    /**
     * @param Region $regionViewed
     * @param User $user
     * @return bool
     */
    private function canDelete(Region $regionViewed, User $user)
    {
        // If the user can edit then he can delete
        if (!$this->canEdit($regionViewed, $user)) {
            return false;
        }
        return true;
    }

    /**
     * @param Region $regionViewed
     * @param User $user
     * @return bool
     */
    private function canEdit(Region $regionViewed, User $user)
    {
        switch ($user->getTerritorialContext()) {
            case ContextEnum::AGENCY_CONTEXT:
                if ($user->getAgency()->getRegion() !== $regionViewed) {
                    return false;
                }
                return true;
                break;

            case ContextEnum::REGION_CONTEXT:
                if ($user->getRegion() !== $regionViewed) {
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