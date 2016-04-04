<?php

namespace Nzo\UrlEncryptorBundle\Annotations;

use Doctrine\Common\Annotations\Reader;
use Nzo\UrlEncryptorBundle\UrlEncryptor\UrlEncryptor;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class AnnotationResolver
{
    private $reader;
    private $decryptor;

    public function __construct(Reader $reader, UrlEncryptor $decryptor)
    {
        $this->reader = $reader;
        $this->decryptor = $decryptor;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        if (!is_array($controller = $event->getController())) {
            return;
        }

        $objectController = new \ReflectionObject($controller[0]);
        $method = $objectController->getMethod($controller[1]);
        foreach ($this->reader->getMethodAnnotations($method) as $configuration) {
            if (isset($configuration->params)) {
                $request = $event->getRequest();
                $params = explode(',', str_replace(' ', '', $configuration->params));
                foreach ($params as $param) {
                    if ($request->attributes->has($param)) {
                        $decrypted = $this->decryptor->decrypt($request->attributes->get($param));
                        $request->attributes->set($param, $decrypted);
                    } elseif ($request->request->has($param)) {
                        $decrypted = $this->decryptor->decrypt($request->request->get($param));
                        $request->request->set($param, $decrypted);
                    }
                }
            }
        }
    }
}
