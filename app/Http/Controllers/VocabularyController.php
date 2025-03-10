<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Models\TopicVocabulary;
use App\Models\Wordnote;
use App\Models\TypeVocabulary;
use App\Models\Vocabulary;
use Illuminate\Support\Facades\Auth;

class VocabularyController extends Controller
{
    function home(){
        return view('vocabulary.home');
    }
    
    function topic() {
        $isCustoms = false;
        $topics = TopicVocabulary::whereNull('user_id')->get();
        return view('vocabulary.topic', compact('topics','isCustoms'));
    }

    function topiccustom(){
        $isCustoms = true;
        $userId = Auth::id();
        $topics = TopicVocabulary::where('user_id', $userId)->get();
        return view('vocabulary.topic',compact('topics','isCustoms'));
    }

    function custom(){
        $userId = Auth::id();

        $vocabularys = Vocabulary::whereHas('topicVocabulary', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->with(['typeVocabulary', 'topicVocabulary'])->get();
        return view('vocabulary.custom',compact('vocabularys'));
    }       

    function default($id){
        $topic = TopicVocabulary::findOrFail($id);
        $vocabularys = Vocabulary::where('topic_id', $id)->with('typeVocabulary')->get();
        return view('vocabulary.default',compact(['vocabularys','topic']));
    }

    function learncustom($id){
        $topic = TopicVocabulary::findOrFail($id);
        $vocabularys = Vocabulary::where('topic_id', $id)->with('typeVocabulary')->get();
        return view('vocabulary.default',compact(['vocabularys','topic']));
    }

    function addtopic(){
        return view('vocabulary.custom.addtopic');
    }
    
    function storetopic(Request $request){
        $userId = Auth::id();
        TopicVocabulary::create([
            'name' => $request->input('nameTopic'),
            'user_id' => $userId,
        ]);

        return redirect('home/vocabulary/custom')->with('status','Thêm topic thành công!');
    }

    function addvocab(){
        $userId = Auth::id();
        $topics = TopicVocabulary::where('user_id', $userId)->get();
        $types = TypeVocabulary::all();
        return view('vocabulary.custom.addvocab', compact(['topics','types']));
    }

    function storevocab(Request $request){
        Vocabulary::create([
            'word' => $request->input('word'),
            'pronounce' => $request->input('pronounce'),
            'meaning' => $request->input('meaning'),
            'example' => $request->input('example'),
            'topic_id' => $request->input('topic'),
            'type_id' => $request->input('type'),
        ]);
        return redirect('home/vocabulary/custom')->with('status','Thêm từ vựng thành công!');
    }   

    function edit($id){
        $vocab = Vocabulary::findOrFail($id);
        $userId = Auth::id();
        $topics = TopicVocabulary::where('user_id', $userId)->get();
        $types = TypeVocabulary::all();
    
        return view('vocabulary.custom.edit', compact('vocab', 'topics', 'types'));
    }

    function update(Request $request, $id){
        $vocabulary = Vocabulary::findOrFail($id);
        
        $vocabulary->update([
            'word' => $request->input('word'),
            'pronounce' => $request->input('pronounce'),
            'meaning' => $request->input('meaning'),
            'example' => $request->input('example'),
            'topic_id' => $request->input('topic'),
            'type_id' => $request->input('type'),
        ]);
    
        return redirect('home/vocabulary/custom')->with('status', 'Cập nhật từ vựng thành công!');
    }

    function delete($id){
        $vocabulary = Vocabulary::find($id);
        if ($vocabulary) {
            $vocabulary->delete();

            return redirect('home/vocabulary/custom')->with('status', 'Xóa bài từ vựng thành công!');
        }

        return redirect('home/vocabulary/custom')->with('error', 'Từ vựng không tồn tại!');
    }

    function review($id){
        $topic = TopicVocabulary::findOrFail($id);
        $vocabularys = Vocabulary::where('topic_id', $id)->with('typeVocabulary')->get();
        return view('vocabulary.review',compact(['vocabularys','topic'])); 
    }

    function ai(){
        return view('vocabulary.custom.ai');
    }

    function generateVocabulary(Request $request){
        $apiKey = env('GEMINI_API_KEY');
        if (!$apiKey) {
            return response()->json(['error' => 'Missing API Key'], 500);
        }

        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=$apiKey";
        $topic = $request->input('topic', 'Life');
        $wordCount = $request->input('word_count', 10);

        $prompt = "
        Hãy tạo danh sách gồm $wordCount từ vựng thuộc chủ đề '$topic'.
        Trả về JSON với cấu trúc sau:

        ```json
        {
            \"vocabularies\": [
                {
                    \"word\": \"Existence\",
                    \"pronounce\": \"/ɪɡˈzɪstəns/\",
                    \"meaning\": \"Sự tồn tại, cuộc sống\",
                    \"example\": \"The meaning of human existence is a question philosophers have pondered for centuries.\",
                    \"type_id\": \"1\",
                    \"exercise\": {
                        \"question\": \"What is the correct meaning of the word 'Existence'?\",
                        \"options\": [
                            \"A. Life\",
                            \"B. Death\",
                            \"C. Wealth\",
                            \"D. Success\"
                        ],
                        \"answer\": \"A\"
                    }
                }
            ]
        }
        ```

        ⚠ **Yêu cầu quan trọng:**  
        - Không cần giải thích, chỉ trả về JSON.
        - Hãy đảm bảo đáp án đúng được random `options` và `answer  `.  
        - Đáp án đúng phải khớp với một trong các lựa chọn trong `options`.  
        - Phân loại type_id như sau: 1 (Noun), 2 (Verb), 3 (Adjective), 4 (Adverb), 5 (Preposition), 6 (Conjunction), 7 (Interjection), 8 (Pronoun), 9 (Determiner).
        - Ví dụ:
            - Từ 'Book' (quyển sách) là danh từ, type_id là 1.
            - Từ 'Write' (viết) là động từ, type_id là 2.
            - Từ 'Happy' (vui vẻ) là tính từ, type_id là 3.
        ";


        $data = [
            "contents" => [
                ["parts" => [["text" => $prompt]]]
            ]
        ];

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => ["Content-Type: application/json"],
            CURLOPT_POSTFIELDS => json_encode($data),
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($httpCode !== 200) {
            return response()->json([
                'error' => 'Lỗi khi gọi API AI',
                'http_code' => $httpCode,
                'response' => json_decode($response, true),
                'curl_error' => $curlError
            ], 500);
        }

        $result = json_decode($response, true);
        $responseText = $result['candidates'][0]['content']['parts'][0]['text'] ?? '';

        // Bóc tách JSON từ nội dung AI trả về
        $jsonStart = strpos($responseText, '{');
        $jsonEnd = strrpos($responseText, '}');
        if ($jsonStart === false || $jsonEnd === false) {
            return response()->json(["error" => "Phản hồi không hợp lệ từ AI"], 500);
        }

        $jsonData = substr($responseText, $jsonStart, $jsonEnd - $jsonStart + 1);
        $parsedData = json_decode($jsonData, true);

        if (!isset($parsedData['vocabularies'])) {
            return response()->json(["error" => "Không tìm thấy dữ liệu từ vựng"], 500);
        }

        return response()->json($parsedData);
    }

    public function saveVocabulary(Request $request) {
        $userId = Auth::id();
        $topicName = $request->input('topic');
        $vocabularies = $request->input('vocabularies');

        if (!$userId || !$topicName || empty($vocabularies)) {
            return response()->json(['error' => 'Dữ liệu không hợp lệ!'], 400);
        }

        // Thêm chủ đề vào bảng topic_vocabulary
        $topic = TopicVocabulary::create([
            'name' => $topicName,
            'user_id' => $userId
        ]);

        // Thêm danh sách từ vựng vào bảng vocabulary
        foreach ($vocabularies as $word) {
            Vocabulary::create([
                'word' => $word['word'],
                'pronounce' => $word['pronounce'],
                'meaning' => $word['meaning'],
                'example' => $word['example'],
                'topic_id' => $topic->id,
                'type_id' => $word['type_id'],
            ]);
        }

        return response()->json(['success' => true]);
    }
}
