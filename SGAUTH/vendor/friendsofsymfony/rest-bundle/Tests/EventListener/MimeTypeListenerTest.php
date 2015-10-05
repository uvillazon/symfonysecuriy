<?php

/*
 * This file is part of the FOSRestBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\RestBundle\Tests\EventListener;

use FOS\RestBundle\EventListener\MimeTypeListener;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * Request listener test.
 *
 * @author Lukas Kahwe Smith <smith@pooteeweet.org>
 */
class MimeTypeListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testOnKernelRequest()
    {
        $listener = new MimeTypeListener(['enabled' => true, 'formats' => ['jsonp' => ['application/javascript+jsonp']]]);

        $request = new Request();
        $event = $this->getMockBuilder('Symfony\Component\HttpKernel\Event\GetResponseEvent')
            ->disableOriginalConstructor()->getMock();
        $event->expects($this->any())
              ->method('getRequest')
              ->will($this->returnValue($request));

        $this->assertNull($request->getMimeType('jsonp'));

        $listener->onKernelRequest($event);

        $this->assertNull($request->getMimeType('jsonp'));

        $event->expects($this->once())
              ->method('getRequestType')
              ->will($this->returnValue(HttpKernelInterface::MASTER_REQUEST));

        $listener->onKernelRequest($event);

        $this->assertEquals('application/javascript+jsonp', $request->getMimeType('jsonp'));
    }
}
