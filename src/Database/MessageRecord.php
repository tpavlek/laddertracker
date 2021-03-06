<?php

namespace Depotwarehouse\LadderTracker\Database;

use Carbon\Carbon;
use Depotwarehouse\BattleNetSC2Api\Region;
use Depotwarehouse\Blumba\Domain\DateTimeValue;
use Depotwarehouse\Blumba\Domain\EntityInterface;
use Depotwarehouse\Blumba\Domain\IdValueInterface;
use Depotwarehouse\Blumba\Domain\Traits\AppliesEvents;
use Depotwarehouse\LadderTracker\ValueObjects\Messaging\Message;
use Illuminate\Database\Eloquent\Model;

class MessageRecord extends Model
{
    public $table = "messages";
    protected $fillable = [ "message", "expires", "region" ];

    public static function createFrom(Message $message, \Depotwarehouse\LadderTracker\ValueObjects\Region $region)
    {
        return self::create([
            'message' => $message->toString(),
            'expires' => $message->expiry()->toString(),
            'region' => $region->toString()
        ]);
    }

    /**
     * Get the latest message from the database for given region.
     *
     * @param string $region
     * @return Message
     */
    public function latest($region = Region::America)
    {
        $today = Carbon::now()->toDateTimeString();
        $latest_message = $this->newQuery()
            ->where('expires', '>=', $today)
            ->where('region', '=', $region)
            ->orderBy('updated_at', 'DESC')
            ->first();

        if ($latest_message == null) {
            return Message::emptyMessage();
        }

        return $latest_message->message;
    }

    /**
     * Expires all messages in the database for a region
     *
     * @param string $region
     */
    public function expireAll($region = Region::America)
    {
        $this->newQuery()
            ->where('expires', '>=', Carbon::now()->toDateTimeString())
            ->where('region', '=', $region)
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
