<?php

namespace UserBundle\Service;

use Doctrine\ORM\EntityManager;
use PortalBundle\Enum\ErrorEnum;
use PortalBundle\Enum\ErrorLevelEnum;
use PortalBundle\Enum\VoterEnum;
use PortalBundle\Service\ErrorService;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use UserBundle\Entity\User;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use JMS\DiExtraBundle\Annotation as DI;
use UserBundle\Enum\ContextEnum;
use UserBundle\Form\UserType;

/**
 * Class UserService
 * @package User\Service
 *
 * @DI\Service("portal.service.user", public=true)
 */
class UserService
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    public $em;

    /**
     * @var \Symfony\Component\Form\FormFactory
     */
    public $formFactory;

    /**
     * @var ErrorService
     */
    public $errorService;

    /**
     * @var AuthorizationChecker
     */
    public $authorizationChecker;

    /**
     * ControlService constructor.
     * @param EntityManager $em
     * @param FormFactory $formFactory
     * @param AuthorizationChecker $authorizationChecker
     * @param $errorService
     *
     * @DI\InjectParams({
     *     "em" = @DI\Inject("doctrine.orm.entity_manager"),
     *     "formFactory" = @DI\Inject("form.factory"),
     *     "authorizationChecker" = @DI\Inject("security.authorization_checker"),
     *     "errorService" = @DI\Inject("portal.service.error")
     * })
     */
    public function __construct($em, $formFactory, $authorizationChecker, $errorService)
    {
        $this->em = $em;
        $this->formFactory = $formFactory;
        $this->authorizationChecker = $authorizationChecker;
        $this->errorService = $errorService;
    }

    /**
     * Lists all User entities.
     */
    public function getAll()
    {
        $usersSent = [];
        $users = $this->em->getRepository('UserBundle:User')->getUserAttributes();
        foreach ($users as $user) {
            $u = $this->formatUser($user);

            if (false !== $this->authorizationChecker->isGranted(VoterEnum::VIEW, $u)) {
                $usersSent[] = $u;
            }
        }
        return $usersSent;
    }

    /**
     * Creates a new User entity.
     * @param Request $request
     * @return User
     */
    public function create(Request $request)
    {
        $user = new User();
        $form = $this->formFactory->create(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setEnabled(true);
            $this->em->persist($user);
            $this->em->flush();
        }

        if ($form->getErrors(true) !== null) {
            foreach ($form->getErrors(true) as $error) {
                $this->errorService->addError(ErrorEnum::INTERNAL, ErrorLevelEnum::CRITIC, $error->getMessage());
            }
            return array_merge($this->errorService->getErrors(), ['result' => $user]);
        } else {
            return ['result' => $user];
        }
    }

    /**
     * Finds and displays a User entity.
     * @param $userId
     * @return null|object|User
     */
    public function get($userId)
    {
        $userSent = null;
        $user = $this->em->getRepository('UserBundle:User')->getUserAttributes($userId)[0];
        $u = $this->formatUser($user);
        if (false !== $this->authorizationChecker->isGranted(VoterEnum::VIEW, $u)) {
            $userSent = $u;
        }
        return $userSent;
    }

    /**
     * Displays a form to edit an existing User entity.
     * @param Request $request
     * @param $userId
     * @return User
     */
    public function edit(Request $request, $userId)
    {
        /** @var  $user */
        $user = $this->em->getRepository('UserBundle:User')->find($userId);
        $form = $this->formFactory->create(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($user);
            $this->em->flush();
        }
        if ($form->getErrors(true) !== null) {
            foreach ($form->getErrors(true) as $error) {
                $this->errorService->addError(ErrorEnum::INTERNAL, ErrorLevelEnum::CRITIC, $error->getMessage());
            }
            return array_merge($this->errorService->getErrors(), ['result' => $user]);
        } else {
            return ['result' => $user];
        }
    }

    /**
     * Deletes a User entity.
     * @param $userId
     */
    public function delete($userId)
    {
        /** @var  $user */
        $user = $this->em->getRepository('UserBundle:User')->find($userId);
        $this->em->remove($user);
        $this->em->flush();
    }

    /**
     * Deletes a User entity.
     */
    public function getProfiles()
    {
        return $this->em->getRepository('UserBundle:User')->getProfiles();
    }

    /**
     * @param User $user
     * @return array
     */
    public function getProfile(User $user)
    {
        $maille = $user->getTerritorialContext();
        $code_maille = null;
        $nni = null;
        $code_maille = $user->getTerritorialCode();

        $profile = [
            'gaia' => $user->getUsername(),
            'nni' => $user->getNni(),
            'nom' => $user->getLastName(),
            'prenom' => $user->getFirstName(),
            'role' => $user->getRoles()[0],
            'maille' => $maille,
            'code_maille' => $code_maille
        ];

        return $profile;
    }

    /**
     * @param $userArray
     * @return User
     */
    private function formatUser($userArray)
    {
        $u = new User;
        $u->setId($userArray['id']);
        $u->setFirstName($userArray['firstName']);
        $u->setLastName($userArray['lastName']);
        $u->setEntity($userArray['entity']);
        $u->setUsername($userArray['username']);
        $u->setRoles($userArray['roles']);
        $u->setEnabled($userArray['enabled']);
        $u->setSalt(null);
        if (isset($userArray['agencyId'])) {
            $u->setAgency($this->em->getRepository('PortalBundle:Agency')->find($userArray['agencyId']));
            return $u;
        } elseif (isset($userArray['regionId'])) {
            $u->setRegion($this->em->getRepository('PortalBundle:Region')->find($userArray['regionId']));
            return $u;
        } else {
            $u->setTerritorialCode("");
            return $u;
        }
    }
}