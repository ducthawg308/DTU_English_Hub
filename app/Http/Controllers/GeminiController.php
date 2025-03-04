<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeminiController extends Controller
{
    public function callGemini(){

        $apiKey = "AIzaSyCjJJ-XSRaFaPGXYFuufefNeiE74tKxlhI";
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=$apiKey";

        $data = [
            "contents" => [
                ["parts" => [["text" => "Hãy tạo danh sách gồm 10 từ vựng thuộc chủ đề life. Mỗi từ vựng cần có:
        1. Từ tiếng Anh
        2. Phát âm IPA
        3. Nghĩa tiếng Việt
        4. Một câu ví dụ bằng tiếng Anh"]]]
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