<?php

namespace App\Models;

use Carbon\Carbon;
use App\Http\Helpers\Shopify;
use App\Services\Shopify\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shop extends Model
{
    use SoftDeletes;

    private $client;

    protected $fillable = [
        'name',
        'shop_id',
        'token',
        'burst_sms_client_id',
        'burst_sms_client_api_token',
        'burst_sms_client_api_secret'
    ];

    /**
     * @param $name
     * @return mixed
     */
    public static function byNameOrFail($name)
    {
        return self::where(['name' => $name])->firstOrFail();
    }

    /**
     * @param $name
     * @return mixed
     */
    public static function byName($name) : Shop
    {
        return self::firstOrCreate(['name' => $name]);
    }

    /**
     * @param $token
     * @return $this
     */
    public function saveShopifyToken(string $token) : Shop
    {
        $this->token = $token;
        $this->save();

        return $this;
    }

    /**
     * Get the stores subscription.
     */
    public function hasSubscription() : bool
    {
        if(!$charges = $this->charges()) return null;

        return (bool) $this->charges()->where('status', 'active')->count();
    }

    /**
     * Get the stores subscription or null.
     */
    public function subscription()
    {
        if(!$charges = $this->charges()) return null;

        $activeCharges = $charges->where('status', 'active');

        if($activeCharges->count()) {
            $data = (array) $activeCharges->first();

            // Parse these otherwise laravel spins out.
            $data['created_at'] = Carbon::parse($data['created_at']);
            $data['updated_at'] = Carbon::parse($data['updated_at']);

            return new Subscription($data);
        }

        return null;
    }

    /**
     * Retrieve all charges for this Shop from Shopify ApiService.
     *
     * @return \Illuminate\Support\Collection
     */
    public function charges()
    {
        try {
            $charges = json_decode($this->client()
                ->get("/admin/recurring_application_charges.json")
                ->getBody()
                ->getContents())->recurring_application_charges;

            return collect($charges);
        } catch(\Exception $exception) {
            Log::error($exception->getMessage());
            return null;
        }
    }

    /**
     * Retrieve shop detail from Shopify ApiService.
     *
     * @return \Illuminate\Support\Collection
     */
    public function shopDetails()
    {
        $charges = json_decode(
            $this->client()
                ->get("/admin/shop.json")
                ->getBody()
                ->getContents())->shop;

        return $charges;
    }

    /**
     * @return \GuzzleHttp\Client
     */
    private function client()
    {
        if(isset($this->client)) return $this->client;

        return $this->client = (new Client)->oauth($this->getAttribute('token'))
                                        ->setStore(Shopify::nameToUrl($this->getAttribute('name')))
                                        ->getClient();
    }
}
