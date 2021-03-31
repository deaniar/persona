<?php

use App\Models\User;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Province;


function getAddress($id, $field = null)
{
    $users_data = User::where('id', $id)->first();
    $prov_data = Province::where('id', $users_data['provinces_id'])->first();
    $city_data = City::where('id', $users_data['cities_id'])->first();
    $dist_data = District::where('id', $users_data['districts_id'])->first();
    if (
        empty($prov_data) or empty($city_data)  or
        empty($dist_data)
    ) {
        return null;
    } else {
        return $prov_data[$field] . ',' . $city_data[$field] . ',' . $dist_data[$field];
    }
}

function getProv($id, $field = null)
{

    if (empty($field)) {
        $data = Province::where('id', $id)->first();
        return (!empty($data)) ? $data : null;
    } else {
        $data = Province::where('id', $id)->select($field)->first();
        return (!empty($data)) ? $data[$field] : null;
    }
}
function getCity($id, $field = null)
{

    if (empty($field)) {
        $data = City::where('id', $id)->first();
        return (!empty($data)) ? $data : null;
    } else {
        $data = City::where('id', $id)->select($field)->first();
        return (!empty($data)) ? $data[$field] : null;
    }
}
function getDistrict($id, $field = null)
{

    if (empty($field)) {
        $data = District::where('id', $id)->first();
        return (!empty($data)) ? $data : null;
    } else {
        $data = District::where('id', $id)->select($field)->first();
        return (!empty($data)) ? $data[$field] : null;
    }
}
