<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Blog;
use App\Models\Comment;

class CommunityController extends Controller
{
    public function index(){
        $blogs = Blog::with('user')->latest()->get();
        return view('community.index', compact('blogs'));
    }


    public function create(){
        return view('community.create');
    }   

    public function store(Request $request){
        // Validate dữ liệu
        $request->validate([
            'title'   => 'required',
            'content' => 'required',
        ]);

        // Lưu blog
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
}
