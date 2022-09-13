<?php

namespace App\Http\Controllers;

use DOMDocument;
use DOMXPath;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $client = new Client();

        $response = $client->post('https://sinoptik.ua/redirector', [
            'form_params' => [
                'search_city' => $request->city,
            ]
        ]);
        $body = $response->getBody();
        $remainingBytes = $body->getContents();

        $dom = new DOMDocument();

        $dom->loadHTML($remainingBytes);

        $xpath = new DOMXPath($dom);
        $divContent = $xpath->query('//*[@id="bd1c"]/div[1]/div[1]/div[1]/p[2]');


        if($divContent->count()){
            foreach ($divContent as $div){
                $message['response'] = $div->nodeValue;
            }
        }else{
            $message['response'] = 'bad';
        }

        return response()->json($message);
    }
}
