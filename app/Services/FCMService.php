<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FCMService
{
    protected $messaging;

    public function __construct()
    {
        $factory = (new Factory)->withServiceAccount(config('firebase.credentials.file'));
        $this->messaging = $factory->createMessaging();
    }

    public function sendNotification($deviceToken, $desc, $img, $active, $data = [])
    {
        // FCM requires title and body for notifications
        $notification = Notification::create('New Notification', $desc, $img);

        // Add extra data (active flag, etc.)
        $data = array_merge($data, [
            'active' => (string) $active,
        ]);

        $message = CloudMessage::withTarget('token', $deviceToken)
            ->withNotification($notification)
            ->withData($data);

        return $this->messaging->send($message);
    }
}
