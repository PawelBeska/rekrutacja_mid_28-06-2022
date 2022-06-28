<?php

namespace App\Listeners;

use App\Events\OrderChangedStatusEvent;
use App\Http\Integrations\Sms\Requests\SendMessageRequest;
use App\Http\Integrations\Sms\SmsConnector;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderChangedStatusListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(public SendMessageRequest $sendMessageRequest)
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param \App\Events\OrderChangedStatusEvent $event
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(OrderChangedStatusEvent $event): void
    {
        try {
            $this->sendMessageRequest->send($event->order);
        } catch (Exception $e) {
            //
        }
    }
}
