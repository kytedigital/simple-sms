<?php

namespace App\Http\Controllers\Api;

use App\Models\Plan;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

class PlanController extends Controller
{
    /**
     * Get all plans.
     *
     * @return Collection
     */
    public function index() : Collection
    {
        return Plan::with('features')->get();
    }
}
