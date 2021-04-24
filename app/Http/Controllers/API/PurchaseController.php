<?php

namespace App\Http\Controllers\Api;

use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

class PurchaseController extends Controller
{
    /**
     * Get all plans.
     *
     * @param Request $request
     * @return Collection
     */
    public function index(Request $request) : Collection
    {
        return Purchase::where('shop', $request->get('shop'))->with('usages')->get();
    }
}
