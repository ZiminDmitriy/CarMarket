<?php
declare(strict_types=1);

namespace App\EventDispatcher\EventSubscriber;

use App\EventDispatcher\Event\Exception\NotCatchingExceptionEvent;
use App\Exception\Controller\Api\ApiException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\KernelInterface;

final class KernelEventSubscriber implements EventSubscriberInterface          // registered with auto-configuring
{
    private KernelInterface $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'createResponse',
        ];
    }

    public function createResponse(ExceptionEvent $exceptionEvent, string $name, EventDispatcherInterface $eventDispatcher): void
    {
        $eventDispatcher->dispatch(new NotCatchingExceptionEvent($exceptionEvent, []), NotCatchingExceptionEvent::EVENT_NAME);

        $throwable = $exceptionEvent->getThrowable();

        $response = new Response('Internal server error', 500, []);
        if (($isApiException = $throwable instanceof ApiException)
            || $this->kernel->getEnvironment() != 'prod') {
            $response->setContent($throwable->getMessage());

            $code = (($code = (int)$throwable->getCode()) >= 400 && $code < 500) ? $code : 400;
            $isApiException ? $response->setStatusCode($code): null;
        }

        $exceptionEvent->allowCustomResponseCode();
        $exceptionEvent->setResponse($response);
    }
}