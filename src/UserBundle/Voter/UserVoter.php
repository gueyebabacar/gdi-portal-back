<?php

namespace UserBundle\Voter;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use UserBundle\Entity\User;
use UserBundle\Enum\ContextEnum;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * Class UserVoter
 * @package UserBundle\Voter
 */
class UserVoter extends Voter
{
    const VIEW = 'view';
    const EDIT = 'edit';

    /**
     * @DI\Inject("doctrine.orm.entity_manager")
     * @var EntityManager
     */
    protected $em;

    /**
     * UserVoter constructor.
     * @param EntityManager $em
     *
     * @DI\InjectParams({
     *     "em" = @DI\Inject("doctrine.orm.entity_manager"),
     * })
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

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

        if (!isset($subject['username'])) {
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
            return false;
        }

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
     * @param array|User $userViewed
     * @param User $user
     * @return bool
     */
    private function canView(array $userViewed, User $user)
    {
        if (!$this->canEdit($userViewed, $user)) {
            return false;
        }
        return true;
    }

    /**
     * @param array|User $userViewed
     * @param User $user
     * @return bool
     */
    private function canEdit(array $userViewed, User $user)
    {
        switch ($user->getTerritorialContext()) {
            case ContextEnum::AGENCY_CONTEXT:
                if ($user->getAgency()->getId() !== $userViewed['agencyId']) {
                    return false;
                } elseif ($userViewed['territorialContext'] === ContextEnum::NATIONAL_CONTEXT) {
                    return false;
                }
                return true;
                break;

            case ContextEnum::REGION_CONTEXT:
                if ($userViewed['territorialContext'] === ContextEnum::REGION_CONTEXT &&
                    $user->getRegion()->getId() !== $userViewed['regionId']
                ) {
                    return false;
                } elseif ($userViewed['territorialContext'] === ContextEnum::AGENCY_CONTEXT &&
                    !$user->getRegion()->getAgencies()->contains($this->em->getRepository('PortalBundle:Agency')->find($userViewed['agencyId']))
                ) {
                    return false;
                } elseif ($userViewed['territorialContext'] === ContextEnum::NATIONAL_CONTEXT) {
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