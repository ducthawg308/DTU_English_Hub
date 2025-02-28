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
                ["parts" => [["text" => 'tôi đang học tiếng anh cơ bản, ở mức độ vstep b1. hãy tạo cho tôi 50 từ vựng liên quan đến chủ đề "học đường, sinh viên, tình yêu, thể thao", kèm theo đó là phần ngữ âm, ngữ nghĩa, từ đồng nghĩa, các câu ví dụ. Và chỉ cần xuất ra kết quả với định dạng được bố trí theo dạng JSON. VD {["word":"footbal","meaning":"môn đá banh","synonym":"soccer","example":"I like playing football"],....}']]]
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