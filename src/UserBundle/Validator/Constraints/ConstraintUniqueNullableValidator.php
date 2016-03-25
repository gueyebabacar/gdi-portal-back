<?php

namespace UserBundle\Validator\Constraints;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use UserBundle\Entity\User;

class ConstraintUniqueNullableValidator extends ConstraintValidator
{
    /**
     * @var EntityManager
     */
    public $em;

    /**
     * ConstraintUniqueNullableValidator constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param mixed $value
     * @param Constraint $constraint
     * @throws \Exception
     */
    public function validate($value, Constraint $constraint)
    {
        if(!($value instanceof User)){
            throw new \Exception("Ce n'est pas un utilisateur");
        }
        $user = $value;
        if($user->getNni() !== null && $this->em->getRepository('UserBundle:User')->findOneByNni($user->getNni()) !== $user){
            $this->context->buildViolation("Le NNI %nni% est déjà attribué à un utilisateur")
                ->setParameter('%nni%', $user->getNni())
                ->addViolation();
        }
        if($user->getEmail() !== null && $this->em->getRepository('UserBundle:User')->findOneByEmail($user->getEmail()) !== $user){
            $this->context->buildViolation("L'email %email% est déjà attribué à un utilisateur")
                ->setParameter('%email%', $user->getEmail())
                ->addViolation();
        }

    }
}