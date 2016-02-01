<?php

namespace UserBundle\Service;

use Doctrine\ORM\EntityManager;
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
     * @DI\Inject("doctrine.orm.entity_manager")
     * @var \Doctrine\ORM\EntityManager
     */
    public $em;

    /**
     * @DI\Inject("form.factory")
     * @var \Symfony\Component\Form\FormFactory
     */
    public $formFactory;

    /**
     * ControlService constructor.
     * @param EntityManager $em
     * @param FormFactory $formFactory
     *
     * @DI\InjectParams({
     *     "em" = @DI\Inject("doctrine.orm.entity_manager"),
     *     "formFactory" = @DI\Inject("form.factory")
     * })
     */
    public function __construct($em, $formFactory)
    {
        $this->em = $em;
        $this->formFactory = $formFactory;
    }

    /**
     * Lists all User entities.
     */
    public function getAll()
    {
        return $this->em->getRepository('UserBundle:User')->findAll();
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
            $this->em->persist($user);
            $this->em->flush();
        }
        return $user;
    }

    /**
     * Finds and displays a User entity.
     * @param $idRefStructureOp
     * @return null|object|User
     */
    public function get($idRefStructureOp)
    {
        return $this->em->getRepository('UserBundle:User')->find($idRefStructureOp);
    }

    /**
     * Displays a form to edit an existing User entity.
     * @param Request $request
     * @param $idRefStructureOp
     * @return User
     */
    public function edit(Request $request, $idRefStructureOp)
    {
        /** @var  $user */
        $user = $this->em->getRepository('UserBundle:User')->find($idRefStructureOp);
        $form = $this->formFactory->create(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($user);
            $this->em->flush();
        }
        return $user;
    }

    /**
     * Deletes a User entity.
     * @param $idRefStructureOp
     */
    public function delete($idRefStructureOp)
    {
        /** @var  $user */
        $user = $this->em->getRepository('UserBundle:User')->find($idRefStructureOp);
        $this->em->remove($user);
        $this->em->flush();
    }
}

