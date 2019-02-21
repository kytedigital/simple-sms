<?php

namespace App\Models;

use App\MessageLog;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed plan
 * @property mixed billing_on
 */
class Subscription extends Model
{
    protected $fillable = [
        'id',
        'name',
        'api_client_id',
        'price',
        'status',
        'return_url',
        'decorated_return_url',
        'billing_on',
        'created_at',
        'updated_at',
        'test',
        'activated_on',
        'cancelled_on',
        'trial_days',
        'trial_ends_on'
    ];

    /**
     * Get the user that owns the phone.
     */
    public function plan()
    {
        return $this->hasOne('App\Models\Plan', 'code', 'name');
    }

    /**
     * @param $shop
     * @return array
     */
    public function getUsage($shop)
    {
        return [
            'period_usage' => $this->getPeriodUsage($shop),
            'period_remaining' => $this->getRemainingCredits($shop),
            'total_usage' => $this->getTotalUsageByShop($shop),
        ];
    }

    /**
     * @param $shop
     * @return int
     */
    public function getRemainingCredits($shop)
    {
        return $this->plan->message_limit - $this->getPeriodUsage($shop);
    }

    /**
     * @param $shop
     * @return int
     */
    protected function getPeriodUsage($shop) : int
    {
        $periodStart = Carbon::parse($this->billing_on)->toDateTimeString();
        $periodEnd = Carbon::parse($this->billing_on)->addMonth()->toDateTimeString();

        return MessageLog::where('shop', $shop)
            ->where('created_at', '>', $periodStart)
            ->where('created_at', '<', $periodEnd)
            ->count();
    }

    /**
     * @param $shop
     * @return mixed
     */
    private function getTotalUsageByShop($shop)
    {
        return MessageLog::where('shop', $shop)->count();
    }
}
