<?php

namespace App\EventSubscriber;

use App\Entity\Log;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Psr\Container\ContainerInterface;

class HttpLoggerSubscriber implements EventSubscriberInterface
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
            $this->container = $container;
    }

    public function onKernelResponse(ResponseEvent $event)
    {
        $log = new Log(
            $event->getRequest()->getUri(),
            $event->getRequest()->headers->all(),
            $event->getRequest()->getContent(),
            $event->getResponse()->getContent(),
            $this->container->get('security.token_storage')->getToken() ? $this->container->get('security.token_storage')->getToken()->getUser(): null
        );

        $this->container->get('monolog.logger.http_log_database')->info(null, ["log" => $log]);

        $this->container->get('monolog.logger.http_log_file')->info(json_encode($log));
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.response' => 'onKernelResponse',
        ];
    }
}
