<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Api extends BaseController
{
    public function weather()
    {
        // Fetch weather from wttr.in (public API)
        $url = 'https://wttr.in/London?format=j1';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);
        if ($data) {
            $weather = [
                'location' => $data['nearest_area'][0]['areaName'][0]['value'],
                'temperature' => $data['current_condition'][0]['temp_C'],
                'description' => $data['current_condition'][0]['weatherDesc'][0]['value'],
            ];
            return $this->response->setJSON($weather);
        } else {
            return $this->response->setJSON(['error' => 'Unable to fetch weather']);
        }
    }
}
