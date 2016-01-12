<?php

namespace PortalBundle\Service;

use Doctrine\ORM\EntityManager;
use PortalBundle\Entity\Role;
use PortalBundle\Form\RoleType;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * Class RolService
 * @package PortalBundle\Service
 *
 * @DI\Service("portal.service.role", public=true)
 */
class RoleService
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
     * Lists all TranscoNatureInter entities.
     */
    public function getAll()
    {
        return $this->em->getRepository('PortalBundle:Role')->findAll();
    }

    /**
     * Finds and displays a Role.
     * @param $id
     * @return null|object|Role
     */
    public function get($id)
    {
        return $this->em->getRepository('PortalBundle:Role')->find($id);
    }

    /**
     * Creates a new Role.
     * @param Request $request
     * @return Role
     */
    public function create(Request $request)
    {
        $role = new Role();
        $form = $this->formFactory->create(RoleType::class, $role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($role);
            $this->em->flush();
        }
        return $role;
    }

    /**
     * Displays a form to edit an existing Role.
     * @param Request $request
     * @param $id
     * @return Role
     */
    public function edit(Request $request, $id)
    {
        /** @var Role $role */
        $role = $this->em->getRepository('PortalBundle:Role')->find($id);
        $form = $this->formFactory->create(RoleType::class, $role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($role);
            $this->em->flush();
        }

        return $role;
    }

    /**
     * Deletes a Role entity.
     * @param $id
     */
    public function delete($id)
    {
        /** @var Role $role */
        $role = $this->em->getRepository('PortalBundle:Role')->find($id);
        $this->em->remove($role);
        $this->em->flush();
    }
}