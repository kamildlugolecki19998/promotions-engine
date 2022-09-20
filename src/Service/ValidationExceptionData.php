<?php

namespace App\Service;

use Symfony\Component\Validator\ConstraintViolationList;

class ValidationExceptionData extends ServiceExceptionData
{
    private ConstraintViolationList $constraintViolationList;

    public function __construct(
        int                     $statusCode,
        string                  $type,
        ConstraintViolationList $constraintViolationList
    ) {
        parent::__construct($statusCode, $type);

        $this->constraintViolationList = $constraintViolationList;
    }

    public function toArray(): array
    {

        return [
            'type'       => 'ConstraintViolationList',
            'violations' => $this->getViolationsArray()
        ];
    }

    public function getViolationsArray(): array
    {
        $violations = [];

        foreach ($this->constraintViolationList as $violation) {
            $violations[] = [
                'propertyPath' => $violation->getPropertyPath(),
                'message'      => $violation->getMessage()
            ];
        }

        return $violations;
    }
}
