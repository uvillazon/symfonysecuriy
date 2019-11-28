<?php
/**
 * Created by PhpStorm.
 * User: uvillazon
 * Date: 16/07/2015
 * Time: 03:59 PM
 */

namespace Elfec\SgauthBundle\Services;


use Gos\Bundle\WebSocketBundle\Router\WampRequest;
use Gos\Bundle\WebSocketBundle\Topic\PushableTopicInterface;
use Gos\Bundle\WebSocketBundle\Topic\TopicInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Wamp\Topic;

class WebSocketService implements TopicInterface, PushableTopicInterface
{
    protected $em;

    public function __construct(\Doctrine\ORM\EntityManager $em)
    {

        $this->em = $em;
    }


    /**
     * @param  ConnectionInterface $connection
     * @param  Topic $topic
     * @param WampRequest $request
     */
    public function onSubscribe(ConnectionInterface $connection, Topic $topic, WampRequest $request)
    {
        var_dump("onSubscribe11 => autenticacion");
        $res = $this->em->getRepository("ElfecSgauthBundle:Sessiones")->crearSession($connection->WAMP->sessionId);
        var_dump($res);
        var_dump($connection->WAMP->sessionId);

        // TODO: Implement onSubscribe() method.
    }

    /**
     * @param  ConnectionInterface $connection
     * @param  Topic $topic
     * @param WampRequest $request
     */
    public function onUnSubscribe(ConnectionInterface $connection, Topic $topic, WampRequest $request)
    {
        var_dump("onUnSubscribe => autenticacion");
        var_dump($connection->WAMP->sessionId);
        $res = $this->em->getRepository("ElfecSgauthBundle:Sessiones")->eliminarSession($connection->WAMP->sessionId);
        var_dump($res);


    }

    /**
     * @param  ConnectionInterface $connection
     * @param  Topic $topic
     * @param WampRequest $request
     * @param $event
     * @param  array $exclude
     * @param  array $eligible
     */
    public function onPublish(ConnectionInterface $connection, Topic $topic, WampRequest $request, $event, array $exclude, array $eligible)
    {
        var_dump("onPublish => autenticacion");
        var_dump($event);
        var_dump($connection->WAMP->sessionId);
        $res = $this->em->getRepository("ElfecSgauthBundle:Sessiones")->actualizarSession($connection->WAMP->sessionId, $event);
        $topic->broadcast($res);
//        $topic->broadcast(
//            array(
//                'msg' => $res->msg,
//                'sessionId' => $connection->WAMP->sessionId,
//                'success' => $res->success
//            )
//        );
//        $topic->broadcast([
//            'msg' => $res->msg,
//            'sessionId' => $connection->WAMP->sessionId,
//            'success' => rand(1, 100) % 2 == 0 ? true : false
//        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'websockect.autenticacion';
        // TODO: Implement getName() method.
    }

    /**
     * @param Topic $topic
     * @param WampRequest $request
     * @param string|array $data
     * @param string $provider
     */
    public function onPush(Topic $topic, WampRequest $request, $data, $provider)
    {
        var_dump($data);
        var_dump("onPush => autenticacion");
        $topic->broadcast($data);
    }
}