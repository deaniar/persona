<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;

class AddressController extends Controller
{
    public function city(Request $request)
    {
        $cities = City::where('province_id', $request->get('id'))->pluck('name', 'id');

        return response()->json($cities);
    }

    public function district(Request $request)
    {
        $distict = District::where('city_id', $request->get('id'))->pluck('name', 'id');

        return response()->json($distict);
    }
}
