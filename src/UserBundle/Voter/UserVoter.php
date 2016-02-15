<?php

namespace UserBundle\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use UserBundle\Entity\User;
use UserBundle\Enum\ContextEnum;

class UserVoter extends Voter
{
    const VIEW = 'view';
    const EDIT = 'edit';

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
        if (!in_array($attribute, array(self::VIEW, self::EDIT))) {
            return false;
        }

        if (!$subject instanceof User) {
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
        /** @var User $userViewed */
        $userViewed = $subject;
        switch ($attribute) {
            case self::VIEW:
                return $this->canView($userViewed, $user);
            case self::EDIT:
                return $this->canEdit($userViewed, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    /**
     * @param User $userViewed
     * @param User $user
     * @return bool
     */
    private function canView(User $userViewed, User $user)
    {
        if (!$this->canEdit($userViewed, $user)) {
            return false;
        }
        return true;
    }

    /**
     * @param User $userViewed
     * @param User $user
     * @return bool
     */
    private function canEdit(User $userViewed, User $user)
    {
        switch ($user->getTerritorialContext()) {
            case ContextEnum::AGENCY_CONTEXT:
                if ($user->getAgency() !== $userViewed->getAgency()) {
                    return false;
                } elseif ($userViewed->getTerritorialContext() === ContextEnum::NATIONAL_CONTEXT) {
                    return false;
                }
                return true;
                break;

            case ContextEnum::REGION_CONTEXT:
                if ($userViewed->getTerritorialContext() === ContextEnum::REGION_CONTEXT &&
                    $user->getRegion()->getId() !== $userViewed->getRegion()->getId()
                ) {
                    return false;
                } elseif ($userViewed->getTerritorialContext() === ContextEnum::AGENCY_CONTEXT &&
                    !$user->getRegion()->getAgencies()->contains($userViewed->getAgency())
                ) {
                    return false;
                } elseif ($userViewed->getTerritorialContext() === ContextEnum::NATIONAL_CONTEXT) {
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