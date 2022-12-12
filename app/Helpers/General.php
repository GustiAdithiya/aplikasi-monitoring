<?php

namespace App\Helpers;

use GuzzleHttp\Client;

class General
{
    public static function getDataParticipant($idpackage, $idparticipant)
    {
        try {
            $client = new Client();
            $url = "http://expro.polindra.ac.id/api/trust-score/" . $idpackage . "/" . $idparticipant;
            $response = $client->request('GET', $url, [
                'verify'  => false,
            ]);
            $responseBody = json_decode($response->getBody(), true);
            // dd($responseBody['data']['trust_score']);
            return $responseBody['data']['trust_score'];
        } catch (\Throwable $th) {
            return "0";
        }
    }

    public static function getObjDet($idpackage, $idparticipant)
    {
        try {
            $client = new Client();
            $url = "http://expro.polindra.ac.id/api/object-detection/" . $idpackage . "/" . $idparticipant;
            $response = $client->request('GET', $url, [
                'verify'  => false,
            ]);
            $responseBody = json_decode($response->getBody(), true);
            return $responseBody['data'];
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public static function getHeadGest($idpackage, $idparticipant)
    {
        try {
            $client = new Client();
            $url = "http://expro.polindra.ac.id/api/head-gesture/" . $idpackage . "/" . $idparticipant;
            $response = $client->request('GET', $url, [
                'verify'  => false,
            ]);
            $responseBody = json_decode($response->getBody(), true);
            return $responseBody['data'];
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public static function getLog($idpackage, $idparticipant)
    {
        try {
            $datas = json_encode(array_merge(General::getObjDet($idpackage, $idparticipant), General::getHeadGest($idpackage, $idparticipant)));
        $datas = json_decode($datas, true);
        $datas = collect($datas)->sortBy('timestamp');
        $array = json_encode($datas);
        $array = json_decode($array, true);
        // dd($array);
        return $array;
        } catch (\Throwable $th) {
            return [];
        }
        
    }
}
