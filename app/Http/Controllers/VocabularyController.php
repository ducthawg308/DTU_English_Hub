<?php

namespace App\Http\Controllers;

use App\Models\TopicVocabulary;
use App\Models\TypeTopic;
use App\Models\Vocabulary;
use App\Models\TypeVocabulary;
use App\Models\UserVocabularyBox;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class VocabularyController extends Controller
{
    function home(){
        return view('vocabulary.home');
    }
    
    function topic() {
        $isCustoms = false;
        $topics = TopicVocabulary::whereNull('user_id')->get();
        $levels = TypeTopic::all();
        return view('vocabulary.topic', compact('topics','isCustoms', 'levels'));
    }

    function learnVocab($type_id) {
        $topics = TopicVocabulary::whereNull('user_id')->where('type_id', $type_id)->get();
        return view('vocabulary.topicDetail', compact('topics'));
    }

    function topiccustom(){
        $isCustoms = true;
        $userId = Auth::id();
        $topics = TopicVocabulary::where('user_id', $userId)->get();
        return view('vocabulary.list',compact('topics','isCustoms'));
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
        $apiKey = config('services.gemini.api_key');
        if (!$apiKey) {
            return response()->json(['error' => 'Missing API Key'], 500);
        }

        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=$apiKey";
        $topic = $request->input('topic');
        $wordCount = $request->input('word_count');

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
                    \"type_id\": \"1\"
                }
            ]
        }
        ```

        **Yêu cầu quan trọng:**  
        - Không cần giải thích, chỉ trả về JSON.
        - Phân loại type_id như sau: 1 (Noun), 2 (Verb), 3 (Adjective), 4 (Adverb), 5 (Preposition), 6 (Conjunction), 7 (Interjection), 8 (Pronoun), 9 (Determiner).
        - guiltyVí dụ:
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

    public function storeMemorization(Request $request)
    {
        $request->validate([
            'vocabulary_id' => 'required|exists:vocabularys,id',
            'level' => 'required|in:1,2,3',
        ]);

        $userId = Auth::id();
        $vocabularyId = $request->input('vocabulary_id');
        $boxType = $request->input('level');

        // Update or create a record in user_vocabulary_box
        UserVocabularyBox::updateOrCreate(
            [
                'user_id' => $userId,
                'vocabulary_id' => $vocabularyId,
            ],
            [
                'box_type' => $boxType,
                'last_review_at' => Carbon::now(),
                'review_count' => DB::raw('review_count + 1'),
                'next_review_at' => $this->calculateNextReview($boxType),
            ]
        );

        return response()->json(['message' => 'Memorization level saved successfully']);
    }

    protected function calculateNextReview($boxType)
    {
        // Example spaced repetition logic (customize as needed)
        $intervals = [
            1 => 7, // Dễ nhớ: Review after 7 days
            2 => 3, // Dễ quên: Review after 3 days
            3 => 1,  // Rất dễ quên: Review after 1 day
        ];

        return Carbon::now()->addDays($intervals[$boxType]);
    }

    public function showbox()
    {
        $userId = Auth::id();

        // Lấy số lượng từ theo từng box_type cho user hiện tại
        $boxCounts = UserVocabularyBox::select('box_type', DB::raw('count(*) as total'))
            ->where('user_id', $userId)
            ->whereIn('box_type', [1, 2, 3])
            ->groupBy('box_type')
            ->pluck('total', 'box_type')
            ->toArray();

        // Đảm bảo có đủ key cho box_type 1, 2, 3
        $box1 = $boxCounts[1] ?? 0;
        $box2 = $boxCounts[2] ?? 0;
        $box3 = $boxCounts[3] ?? 0;

        return view("vocabulary.SpacedRepetition.index", compact('box1', 'box2', 'box3'));
    }

    public function learnBox($box_type)
    {
        $userId = Auth::id();

        // Lấy danh sách vocabulary thuộc box_type của user
        $vocabularys = UserVocabularyBox::where('user_id', $userId)
            ->where('box_type', $box_type)
            ->join('vocabularys', 'user_vocabulary_boxes.vocabulary_id', '=', 'vocabularys.id')
            ->with(['vocabulary.typeVocabulary'])
            ->get()
            ->pluck('vocabulary');

        // Lấy topic đầu tiên để hiển thị (hoặc có thể để null nếu không cần)
        $topic = TopicVocabulary::first(); // Điều chỉnh nếu cần lấy topic cụ thể

        return view('vocabulary.SpacedRepetition.learn', compact('vocabularys', 'topic', 'box_type'));
    }
}