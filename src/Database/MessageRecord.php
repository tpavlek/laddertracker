<?php

namespace Depotwarehouse\LadderTracker\Database;

use Carbon\Carbon;
use Depotwarehouse\Blumba\Domain\DateTimeValue;
use Depotwarehouse\Blumba\Domain\EntityInterface;
use Depotwarehouse\Blumba\Domain\IdValueInterface;
use Depotwarehouse\Blumba\Domain\Traits\AppliesEvents;
use Depotwarehouse\LadderTracker\ValueObjects\Messaging\Message;
use Illuminate\Database\Eloquent\Model;

class MessageRecord extends Model
{
    public $table = "messages";
    protected $fillable = [ "message", "expires" ];

    /**
     * Get the latest message from the database.
     *
     * @return \Depotwarehouse\LadderTracker\ValueObjects\Messaging\Message
     */
    public function latest()
    {
        $today = Carbon::now()->toDateTimeString();
        $latest_message = $this->newQuery()
            ->where('expires', '>=', $today)
            ->orderBy('updated_at', 'DESC')
            ->first();

        if ($latest_message == null) {
            return Message::emptyMessage();
        }

        return $latest_message->message;
    }

    /**
     * Expires all messages in the database
     */
    public function expireAll()
    {
        $this->newQuery()
            ->where('expires', '>=', Carbon::now()->toDateTimeString())
            ->get()
            ->each(function (MessageRecord $messageRecord) {
                $messageRecord->expire();
            });
    }

    /**
     * Expires this single instance
     */
    public function expire()
    {
        $this->expires = Carbon::now()->subMinute();
        $this->save();
    }

    public function getMessageAttribute($value)
    {
        return new Message($value, $this->expires);
    }

    public function getExpiresAttribute($value)
    {
        return new DateTimeValue(new Carbon($value));
    }
}
