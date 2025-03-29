<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Blog;
use App\Models\Comment;
use App\Models\Document;

class CommunityController extends Controller
{
    public function index(){
        $blogs = Blog::with('user')->latest()->get();
        $documents = Document::with('user')->latest()->paginate(10);
        return view('community.index', compact('blogs', 'documents'));
    }


    public function create(){
        return view('community.create');
    }   

    public function store(Request $request){
        $request->validate([
            'title'   => 'required',
            'content' => 'required',
        ]);

        Blog::create([
            'user_id'  => auth()->id(),
            'title'    => $request->title,
            'slug'     => Str::slug($request->title) . '-' . time(),
            'content'  => $request->content,
            'thumbnail'=> '',
        ]);

        return redirect()->route('home.community')->with('success', 'Đăng blog thành công!');
    }

    public function detail($id){
        $blog = Blog::with([
            'user',
            'comments' => function ($q) {
                $q->whereNull('parent_id')->latest();
            },
            'comments.user',
            'comments.children.user'
        ])->findOrFail($id);

        return view('community.detail', compact('blog'));
    }

    public function toggleLike($id){
        $blog = Blog::findOrFail($id);
        $user = auth()->user();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Bạn cần đăng nhập'], 401);
        }

        $liked = $blog->likes()->where('user_id', $user->id)->first();

        if ($liked) {
            $liked->delete();
            return response()->json(['status' => 'unliked', 'likes_count' => $blog->likes()->count()]);
        } else {
            $blog->likes()->create(['user_id' => $user->id]);
            return response()->json(['status' => 'liked', 'likes_count' => $blog->likes()->count()]);
        }
    }

    public function storeComment(Request $request){
        $request->validate([
            'blog_id'   => 'required|exists:blogs,id',
            'content'   => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id', // Cho phép gửi comment con
        ]);

        $comment = Comment::create([
            'blog_id'   => $request->blog_id,
            'user_id'   => auth()->id(),
            'content'   => $request->content,
            'parent_id' => $request->parent_id ?? null,
        ]);

        return response()->json([
            'message' => 'Bình luận thành công',
            'comment' => $comment,
            'user'    => [
                'name' => auth()->user()->name
            ],
            'parent_id' => $request->parent_id
        ]);
    }

    public function storeTL(Request $request){
        $request->validate([
            'title'         => 'required|string|max:255',
            'subject'  => 'required|string|max:50',
            'file_path'      => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar|max:10240',
            'description'   => 'required|string',
        ]);

        $file = $request->file('file_path');
        $filePath = $file->store('documents', 'public');
        $fileType = $file->getClientOriginalExtension();


        Document::create([
            'user_id'       => auth()->id(),
            'title'         => $request->title,
            'subject'  => $request->subject,
            'file_path'     => $filePath,
            'file_type'   => $fileType,
            'description'   => $request->description,
        ]);

        return redirect()->route('home.community')->with('success', 'Tài liệu đã được đăng thành công!');
    }

    public function show($id){
        $document = Document::with('user')->findOrFail($id);
        $document->increment('views');
        return view('community.show', compact('document'));
    }

    public function download($id){
        $document = Document::findOrFail($id);
        $document->increment('downloads');

        $path = storage_path('app/public/' . $document->file_path);

        if (file_exists($path)) {
            return response()->download($path);
        } else {
            abort(404);
        }
    }
}
