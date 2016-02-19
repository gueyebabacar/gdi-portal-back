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
     * @var \UserBundle\Repository\UserRepository
     */
    public $userRepo;

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
        $this->userRepo = $this->em->getRepository('UserBundle:User');
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
        $users = $this->userRepo->getUserAttributes();
        foreach ($users as $user) {
            $u = new User;
            $u->setId($user['id']);
            $u->setFirstName($user['firstName']);
            $u->setLastName($user['lastName']);
            $u->setEntity($user['entity']);
            $u->setUsername($user['username']);
            $u->setRoles($user['roles']);
            $u->setEnabled($user['enabled']);
            if (isset($user['agencyId'])) {
                $u->setAgency($this->em->getRepository('PortalBundle:Agency')->find($user['agencyId']));
            } elseif (isset($user['regionId'])) {
                $u->setRegion($this->em->getRepository('PortalBundle:Region')->find($user['regionId']));
            } else {
                $u->setTerritorialCode("");
            }

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
        $user = $this->userRepo->getUserAttributes($userId)[0];

        $u = new User;
        $u->setId($user['id']);
        $u->setFirstName($user['firstName']);
        $u->setLastName($user['lastName']);
        $u->setEntity($user['entity']);
        $u->setUsername($user['username']);
        $u->setRoles($user['roles']);
        $u->setEnabled($user['enabled']);
        if (isset($user['agencyId'])) {
            $u->setAgency($this->em->getRepository('PortalBundle:Agency')->find($user['agencyId']));
        } elseif (isset($user['regionId'])) {
            $u->setRegion($this->em->getRepository('PortalBundle:Region')->find($user['regionId']));
        } else {
            $u->setTerritorialCode("");
        }
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
        $user = $this->userRepo->find($userId);
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
        $user = $this->userRepo->find($userId);
        $this->em->remove($user);
        $this->em->flush();
    }

    /**
     * Deletes a User entity.
     */
    public function getProfiles()
    {
        return $this->userRepo->getProfiles();
    }
}