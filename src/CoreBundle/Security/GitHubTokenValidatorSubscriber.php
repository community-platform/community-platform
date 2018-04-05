<?php

namespace CoreBundle\Security;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class GitHubTokenValidatorSubscriber implements EventSubscriberInterface
{
    private $signatureValidator;
    private $token;

    public function __construct(SignatureValidatorInterface $signatureValidator, $expectedToken)
    {
        $this->signatureValidator = $signatureValidator;
        $this->token = $expectedToken;
    }

    public static function getSubscribedEvents()
    {
        return [KernelEvents::REQUEST => [['onKernelRequest', 100]]];
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if (!$request->isMethod('POST')) {
            return;
        }

        $signature = $request->headers->get('X-Hub-Signature');

        if (null === $signature) {
            throw new AccessDeniedException('Invalid GitHub token: not provided');
        }

        if (!$this->signatureValidator->validate($request, $this->token)) {
            throw new AccessDeniedException('Invalid GitHub token');
        }
    }
}
