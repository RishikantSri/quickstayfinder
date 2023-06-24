<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertySearchController extends Controller
{
    //
    public function __invoke(Request $request)
    {
        return Property::with('city')
            // conditions will come here
            ->when($request->city_id, function($query) use ($request) {
                $query->where('city_id', $request->city_id);
            })
            ->get();
    }
}
