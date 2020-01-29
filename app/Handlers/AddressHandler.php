<?php

namespace App\Handlers;

use App\Models\Address;
use App\Models\Service;
use GuzzleHttp\Client;

class AddressHandler
{
    /**
     * @param Address $address
     * @return array
     * @throws \Exception
     */
    public static function calculate_distance(Address $address)
    {
        $client = new Client();
        $services = Service::all();

        $to = '';
        foreach ($services as $service) {
            $to .= $service->latitude . ',' . $service->longitude . ';';
        }
        $to = substr($to, 0, -1);

        $base_url = 'https://apis.map.qq.com/ws/distance/v1/';

        $params = [
            'mode' => 'driving',
            'from' => $address->latitude . ',' . $address->longitude,
            'to' => $to,
            'key' => config('map.key'),
        ];

        $url = $base_url . '?' . http_build_query($params);

        $response = $client->get($url);

        $distances = json_decode($response->getBody(), 'true');

        if ($distances['status'] != 0) {
            abort(500, '请求距离计算借口失败');
        }

        $distances = collect($distances['result']['elements']);

        $distances = $distances->sortBy(function ($distance) {
            return $distance['distance'];
        });

        $distance = $distances->first();
        foreach ($services as $service) {
            if ($service->longitude == $distance['to']['lng'] && $service->latitude == $distance['to']['lat'] ) {
                return [$service->id, $distance['distance']];
            }
        }

        throw new \Exception("返回数据无法匹配服务点");
    }
}
