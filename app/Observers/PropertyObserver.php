<?php

namespace App\Observers;

use App\Models\Property;
use Spatie\Geocoder\Facades\Geocoder;
use Throwable;

class PropertyObserver
{


    public function creating(Property $property)
    {

        if (auth()->check()) {
            $property->owner_id = auth()->id();
        }

        if (is_null($property->lat) && is_null($property->long)) {
            $fullAddress = $property->address_street . ', '
                . $property->address_postcode . ', '
                . $property->city->name . ', '
                . $property->city->country->name;

              
            try {

                 $result = Geocoder::getCoordinatesForAddress($fullAddress);
                //  dd($result);
                if (!empty($result)) {
                    $property->lat = $result["lat"];
                    $property->long = $result["lng"];
                }
            } catch (Throwable $e) {
                // report($e);
                return false;
            }


            // $result = app('geocoder')->geocode($fullAddress)->get();
            // $client = new \GuzzleHttp\Client();

            // $geocoder = new Geocoder($client);

            // $geocoder->setApiKey(config('geocoder.key'));

            // $geocoder->setCountry(config('geocoder.country', 'US'));

            // $result = $geocoder->getCoordinatesForAddress('Infinite Loop 1, Cupertino');
            // $result = Geocoder::getCoordinatesForAddress($fullAddress);


            /*
                    This function returns an array with keys
                    "lat" =>  37.331741000000001
                    "lng" => -122.0303329
                    "accuracy" => "ROOFTOP"
                    "formatted_address" => "1 Infinite Loop, Cupertino, CA 95014, USA",
                    "viewport" => [
                        "northeast" => [
                        "lat" => 37.3330546802915,
                        "lng" => -122.0294342197085
                        ],
                        "southwest" => [
                        "lat" => 37.3303567197085,
                        "lng" => -122.0321321802915
                        ]
                    ]
                    */
        }
    }
}
