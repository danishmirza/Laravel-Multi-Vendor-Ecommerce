<?php


use App\Models\City;

function checkPolygon($city_id, $area_id, $long, $lat)
{
    $city = City::where('id', $area_id)->where('parent_id', $city_id)->first();
    $polygon = json_decode($city->polygon);
//        dd($polygon);
    $polygon_y = [];
    $polygon_x = [];
    $count_point = count($polygon) - 1;
    foreach ($polygon as $item) {
        array_push($polygon_y, $item->lat);
        array_push($polygon_x, $item->lng);
    }
    $i = $j = $c = 0;
    for ($i = 0, $j = $count_point; $i < $count_point; $j = $i++) {
        if ((($polygon_y[$i] > $lat != ($polygon_y[$j] > $lat)) &&
            ($long < ($polygon_x[$j] - $polygon_x[$i]) * ($lat - $polygon_y[$i]) / ($polygon_y[$j] - $polygon_y[$i]) + $polygon_x[$i])))
            $c = !$c;
    }
    return $c;
}
