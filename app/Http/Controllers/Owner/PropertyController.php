<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePropertyRequest;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    //
    public function index()
    {
        $this->authorize('properties-manage');
 
        
        return response()->json(['success' => true]);
    }

    public function store(StorePropertyRequest $request)
    {
        // return auth()->id();
      
        $this->authorize('properties-manage');
 
        return Property::create($request->validated());
    }
}
