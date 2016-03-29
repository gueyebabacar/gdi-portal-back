<?php

namespace UserBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class ConstraintUniqueNullable extends Constraint
{
    public function validatedBy()
    {
        return 'unique_nullable_constraint';
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}