<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeminiController extends Controller
{
    public function callGemini(){

        $apiKey = "AIzaSyDf5C-IKRtxQqs3IvFThTK6GvKHKItFwsY";
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=$apiKey";

        $data = [
            "contents" => [
                ["parts" => [["text" => "Viết bài thơ về mùa xuân"]]]
            ]
        ];

        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => ["Content-Type: application/json"],
            CURLOPT_POSTFIELDS => json_encode($data),
        ];

        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        curl_close($ch);
        echo $response;
    }
}