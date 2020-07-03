<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;

class BusinessesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $host = env('YELP_API_HOST', 'https://api.yelp.com');
        $version = env('YELP_API_VERSION', 'v3');
        $apiKey = env('YELP_API_KEY', '');

        try {
            $client = new Client(['base_uri' => $host, 'verify' => false]);
            $response = $client->request('GET', $version . substr($request->getRequestUri(), 4), [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiKey
                ]
            ]);

            $body = $response->getBody();
            $data = json_decode($body);

            return response(['yelp' => $data, 'message' => 'Retrieved successfully'], 200);
        } catch (ClientException $e) {
            return response(['error' => $e->getMessage()], $e->getResponse()->getStatusCode());
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 200);
        }
    }
}
