<?php
namespace App\Services\Push;

use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

/**
 *
 */
class PushNotifications
{
    private $firebase;

    function __construct() {
        $this->connectServiceAccount();
    }

    private function connectServiceAccount() {
        // $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'config/firebase.json');
        $this->firebase = (new Factory)
            ->withServiceAccount(__DIR__.'/config/firebase.json')
            ->withDatabaseUri('https://myportfel-768d4-default-rtdb.europe-west1.firebasedatabase.app/');
            // ->create();
    }

    public function sendPush($deviceToken, $send, $adt = []) {
        $messaging = $this->firebase->createMessaging();
        $adt['key'] = 'priority';
        $adt['value'] = 'hight';
        $adt['body'] = $send['body'];
        $adt['title'] = $send['title'];
        $message = CloudMessage::withTarget('token', $deviceToken)
            // ->withDefaultSounds()
            ->withNotification(Notification::create($send['title'], $send['body']))
            ->withData($adt);
        $messaging->send($message);
    }

    public function sendPushMulticast($deviceTokens, $send, $adt = []) {
        $messaging = $this->firebase->createMessaging();
        // $adt['key'] = 'priority';
        // $adt['value'] = 'hight';
        $adt['body'] = $send['body'];
        $adt['title'] = $send['title'];
        $message = CloudMessage::new();
	$message->withNotification(Notification::create($send['title'], $send['body']));
        $message->withData($adt);
	$message->withDefaultSounds();
	$send['sound'] = 'default';
	/* $message = CloudMessage::fromArray([
	     'priority' => 'normal',
	     'notification' => [
		'title' => $send['title'],
		'body' => $send['body']
	     'data' => $adt
	]); */
	app('log')->info(json_encode($send));
        $messaging->sendMulticast($message, $deviceTokens);
    }

}
