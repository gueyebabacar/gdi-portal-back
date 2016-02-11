<?php

namespace PortalBundle\Controller;

use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class DefaultController extends FOSRestController
{
    /**
     * Homepage
     * @Rest\Get("/")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "Home",
     *      resource = true,
     *      description = "Homepage de portail"
     * )
     */
    public function indexAction()
    {
        $firewall = 'secured_area';

        /** @var EntityManager $em */
        $em = $this->get('doctrine.orm.entity_manager');

        $user = $em->getRepository('UserBundle:User')->findAll();
        $token = new UsernamePasswordToken($user[0], null, $firewall, array('ROLE_ADMIN'));
        $this->get('security.token_storage')->setToken($token);
        return $user[0];
    }
}