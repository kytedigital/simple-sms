<?php

namespace App\Models;

use Carbon\Carbon;
use App\Http\Helpers\Shopify;
use App\Services\Shopify\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Shop extends Model
{
    private $client;

    protected $fillable = ['name', 'token'];

    /**
     * Get the stores subscription.
     */
    public function hasSubscription()
    {
        if(!$charges = $this->charges()) return null;

        return (bool) $this->charges()->where('status', 'active')->count();
    }

    /**
     * Get the stores subscription or null.
     */
    public function subscription()
    {
        $charges = $this->charges();

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

        return $this->client = $client = (new Client)->oauth($this->getAttribute('token'))
                                        ->setStore(Shopify::nameToUrl($this->getAttribute('name')))
                                        ->getClient();
    }
}
