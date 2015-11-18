<?php

namespace Depotwarehouse\LadderTracker\Client\Web\Http\Controllers;

use Carbon\Carbon;
use Depotwarehouse\Blumba\Domain\DateTimeValue;
use Depotwarehouse\LadderTracker\Commands\CreateMessageCommand;
use Depotwarehouse\LadderTracker\Commands\ExpireMessagesCommand;
use Depotwarehouse\LadderTracker\ValueObjects\Messaging\Message;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

class Messages extends Controller
{

    public function showCreateForm()
    {
        return view('messages.create');
    }

    public function store(Request $request, CreateMessageCommand $createMessageCommand)
    {
        $messageText = $request->input('message');
        $expiry = $request->input('expires');

        $message = new Message($messageText, new DateTimeValue(new Carbon($expiry)));

        $createMessageCommand->run($message);

        return redirect()->route('admin.messages.create')
            ->withErrors(new MessageBag([
                'success' => "Created new message"
            ]));
    }

    public function showExpireForm()
    {
        return view('messages.expire');
    }

    public function expire(ExpireMessagesCommand $expireMessagesCommand)
    {
        $expireMessagesCommand->run();

        return redirect()->route('admin.messages.create')
            ->withErrors(new MessageBag([
                'success' => "Expired all messages"
            ]));
    }
}
