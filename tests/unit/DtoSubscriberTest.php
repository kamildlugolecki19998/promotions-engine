<?php

namespace App\Tests\unit;

use App\Controller\Event\AfterDtoCreatedEvent;
use App\Controller\EventSubscriber\DtoSubscriber;
use App\DTO\LowestPriceEnquiry;
use App\Service\Serializer\ServiceException;
use App\Tests\ServiceTestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;

class DtoSubscriberTest extends ServiceTestCase
{
    public function testEventSubscription(): void
    {
        $this->assertArrayHasKey(AfterDtoCreatedEvent::NAME, DtoSubscriber::getSubscribedEvents());
    }

    /** @test */
    public function testValidateDto(): void
    {
        // Given
        $dto = new LowestPriceEnquiry();
        $dto->setQuantity(-5);
        $event = new AfterDtoCreatedEvent($dto);

        /** @var EventDispatcherInterface $eventDispatcher */
        $eventDispatcher = $this->container->get('debug.event_dispatcher');

        //Expect
        $this->expectException(ServiceException::class);
        $this->expectDeprecationMessage('ConstraintViolationsList');


        $eventDispatcher->dispatch($event, $event::NAME);
    }
}
