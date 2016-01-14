<?php

namespace TranscoBundle\Service;


use Doctrine\ORM\EntityManager;
use TranscoBundle\Entity\TranscoDiscOpticGmao;
use TranscoBundle\Form\TranscoDiscOpticGmaoType;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * Class TranscoDidscOpticGmaoService
 * @package TranscoBundle\Service
 *
 * @DI\Service("portal.service.transcodiscopticgmao", public=true)
 */
class TranscoDiscOpticGmaoService
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
     * Lists all TranscoDiscOpticGmao entities.
     */
    public function getAll()
    {
        return $this->em->getRepository('TranscoBundle:TranscoDiscOpticGmao')->findAll();
    }

    /**
     * Creates a new TranscoDiscOpticGmao  entity.
     * @param Request $request
     * @return TranscoDiscOpticGmao
     */
    public function create(Request $request)
    {
        $transcoDiscOpticGmao = new TranscoDiscOpticGmao();
        $form = $this->formFactory->create(TranscoDiscOpticGmaoType::class, $transcoDiscOpticGmao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($transcoDiscOpticGmao);
            $this->em->flush();
        }
        return $transcoDiscOpticGmao;
    }

    /**
     * Finds and displays a  entity.
     * @param $transcoDiscOpticId
     * @return null|object|TranscoDiscOpticGmao
     */
    public function get($transcoDiscOpticId)
    {
        return $this->em->getRepository('TranscoBundle:TrancoDiscOpticGmao')->find($transcoDiscOpticId);
    }

    /**
     * Displays a form to edit an existing TranscoDiscoOpticGmao entity.
     * @param Request $request
     * @param $transcoDiscOpticId
     * @return \SvnLastRevisionTask
     */
    public function edit(Request $request, $transcoDiscOpticId)
    {
        /** @var TranscoDiscOpticGmao $transcoDiscOpticGmao */
        $transcoDiscOpticGmao = $this->em->getRepository('TranscoBundle:TranscoDiscOpticGmao')->find($transcoDiscOpticId);
        $form = $this->formFactory->create(TranscoNatureInterType::class, $transcoDiscOpticGmao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($transcoDiscOpticGmao);
            $this->em->flush();
        }
        return $transcoDiscOpticGmao;
    }

    /**
     * Deletes a TranscoDiscOpticGmao entity.
     * @param $transcoDiscOpticId
     */
    public function delete($transcoDiscOpticId)
    {
        /** @var TranscoDiscOpticGmao $transcoDiscOpticGmao */
        $transcoDiscOpticGmao = $this->em->getRepository('TranscoBundle:TranscoDiscOpticGmao')->find($transcoDiscOpticId);
        $this->em->remove($transcoDiscOpticGmao);
        $this->em->flush();
    }

    /**
     * Return NatIntCode from NatOpCode
     * @param array $data
     * @return mixed
     */
    public function getCodeNatIntFromCodeNatOp(array $data){
        $response = $this->em->getRepository('TranscoBundle:TranscoDiscOpticGmao')->findCodeNatIntFromCodeNatOp($data);
        if(sizeof($response) !== 1){
            return $response;
        }
        return reset($response[0]);
    }

    /**
     * Return NatOpCode from NatIntCode
     * @param array $data
     * @return mixed
     */
    public function getCodeNatOpFromCodeNatInt(array $data){
        $response =  $this->em->getRepository('TranscoBundle:TranscoDiscOpticGmao')->findCodeNatopFromCodeNatInt($data);
        if(sizeof($response) !== 1){
            return $response;
        }
        return reset($response[0]);
    }
}