<?php
 namespace Symfony\Component\HttpKernel\EventListener; use Symfony\Component\EventDispatcher\EventSubscriberInterface; use Symfony\Component\HttpFoundation\Request; use Symfony\Component\HttpFoundation\RequestStack; use Symfony\Component\HttpKernel\Event\FinishRequestEvent; use Symfony\Component\HttpKernel\Event\GetResponseEvent; use Symfony\Component\HttpKernel\KernelEvents; use Symfony\Component\Translation\TranslatorInterface; class TranslatorListener implements EventSubscriberInterface { private $translator; private $requestStack; public function __construct(TranslatorInterface $translator, RequestStack $requestStack) { $this->translator = $translator; $this->requestStack = $requestStack; } public function onKernelRequest(GetResponseEvent $event) { $this->setLocale($event->getRequest()); } public function onKernelFinishRequest(FinishRequestEvent $event) { if (null === $parentRequest = $this->requestStack->getParentRequest()) { return; } $this->setLocale($parentRequest); } public static function getSubscribedEvents() { return array( KernelEvents::REQUEST => array(array('onKernelRequest', 10)), KernelEvents::FINISH_REQUEST => array(array('onKernelFinishRequest', 0)), ); } private function setLocale(Request $request) { try { $this->translator->setLocale($request->getLocale()); } catch (\InvalidArgumentException $e) { $this->translator->setLocale($request->getDefaultLocale()); } } } 