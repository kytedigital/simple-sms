<?php

namespace App\Models;

use App\Http\Helpers\Shopify;
use App\Services\Shopify\Client;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    private $client;

    protected $fillable = ['name', 'token'];

    /**
     * Get the stores subscription.
     */
    public function hasSubscription()
    {
        return (bool) $this->charges()->where('status', 'active')->count();
    }

    /**
     * Get the stores subscription or null.
     */
    public function subscription()
    {
        $activeCharges = $this->charges()->where('status', 'active');

        if($this->charges()->where('status', 'active')->count()) {
            $data = (array) $activeCharges->first();

            // Parse these otherwise laravel spins out.
            $data['created_at'] = Carbon::parse($data['created_at']);
            $data['updated_at'] = Carbon::parse($data['updated_at']);

            return new Subscription($data);
        }

        return null;
    }

    /**
     * Retrieve all charges for this Shop from Shopify API.
     *
     * @return \Illuminate\Support\Collection
     */
    public function charges()
    {
        $charges = collect(json_decode(
            $this->client()
                ->get("/admin/recurring_application_charges.json")
                ->getBody()
                ->getContents())->recurring_application_charges
        );

        return $charges;
    }

    /**
     * Retrieve shop detail from Shopify API.
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
