<?php

namespace App\Controller\EventSubscriber;

use App\Controller\Event\AfterDtoCreatedEvent;
use App\Service\Serializer\ServiceException;
use App\Service\ValidationExceptionData;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DtoSubscriber implements EventSubscriberInterface
{
    public function __construct(private ValidatorInterface $validator)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            AfterDtoCreatedEvent::NAME => [
                ['validateDto', 100],
            ]
        ];
    }

    public function validateDto(AfterDtoCreatedEvent $event): void
    {
        $dto = $event->getDto();


        $errors = $this->validator->validate($dto);

        if (count($errors) > 0) {

            $validationExceptionData = new ValidationExceptionData(422, 'ConstraintViolationsList', $errors);

            throw new ServiceException($validationExceptionData);
        }
    }
}
