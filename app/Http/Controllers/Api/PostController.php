<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CommentModel as Comment;
use App\Contracts\PostContract;
use App\Models\RequestModel as Post;

class PostController extends Controller
{
    public function __construct()
    {
        $this->contract = new PostContract();
    }

    public function posts(Request $req) {
        $params = [
            ['requests.status', 1]
        ];
        $params[] = ['requests.city_id', $req->user()->native_country_id ?? 1];
        if ($req->category_id) $params[] = ['requests.category_id', (int) $req->category_id];
        $posts = Post::select($this->contract::POST_SELECT_DATA)
            ->leftJoin('users', 'requests.user_id', '=', 'users.id')
            ->where($params)
            ->orderBy('requests.created_at', 'desc')
            ->withCount('comments')
            ->get();
        foreach ($posts as $post) {
            $post->last_comment = $post->comments()
                ->select($this->contract::POST_SELECT_COMMENTS)
                ->leftJoin('users', 'comments.user_id', '=', 'users.id')
                ->orderBy('comments.created_at', 'desc')
                ->first();
        }
        return $posts;
    }

    public function postShow(Request $req) {
        if ($req->id) {
            $post = Post::find($req->id);
            $data['post'] = $post->select($this->contract::POST_SELECT_DATA)
                ->leftJoin('users', 'requests.user_id', '=', 'users.id')
                ->withCount('comments')
                ->first();
            $data['comments'] = $post->comments()
                ->select($this->contract::POST_SELECT_COMMENTS)
                ->leftJoin('users', 'comments.user_id', '=', 'users.id')
                ->orderBy('comments.created_at', 'desc')
                ->get();
            return $data;
        } else return [];
    }

    public function commentsList(Request $req) {
        $params = $this->contract::POST_SELECT_COMMENTS;
        $params[] = 'requests.id as post_id';
        return Comment::where('comments.user_id', $req->user()->id)
            ->select($params)
            ->leftJoin('users', 'comments.user_id', '=', 'users.id')
            ->leftJoin('requests', 'comments.user_id', '=', 'requests.id')
            ->orderBy('comments.created_at', 'desc')
            ->get();
    }

    public function postCommentCreate(Request $req) {
        $data = [
            'user_id' => $req->user()->id,
            'post_id' => (int) $req->post_id,
            'comment' => (string) $req->comment,
        ];
        Comment::create($data);
        return ['message' => true];
    }

    public function postCreate(Request $req) {
        $data = [
            'user_id' => $req->user()->id,
            'photo_path' => $req->post_images ? $req->file('image')->store('post_images') : null,
            'title' => $req->title,
            'description' => $req->description,
            'category_id' => (int) $req->category_id,
            'city_id' => (int) $req->city_id,
            'seen' => 0,
        ];
        Post::create($data);
        return ['message' => true];
    }

    public function postEdit(Request $req) {
        $post = Post::find((int) $req->post_id);
        if ($post) {
            $post->user_id          = $req->user()->id ?? $post->user_id;
            $post->photo_path       = $req->image ? $req->file('image')->store('post_images') : $post->photo_path;
            $post->title            = $req->title ?? $post->title;
            $post->description      = $req->description ?? $post->description;
            $post->category_id      = (int) $req->category_id ?? $post->category_id;
            $post->city_id          = (int) $req->city_id ?? $post->city_id;
        }
        $post->save();
        return ['message' => true];
    }

    public function countPosts(Request $req) {
        $posts = Post::select('id', 'status')
            ->where('user_id', (int) $req->user()->id)
            ->get();
        return [
            'wait' => $posts->where('status', 0)->count(),
            'active' => $posts->where('status', 1)->count(),
            'not_active' => $posts->where('status', 404)->count(),
        ];
    }

    public function waitedPosts(Request $req) {
        $params = [
            ['user_id', $req->user()->id],
            ['status', 0],
        ];
        return Post::select($this->contract::POST_SHOW_SELECT_DATA)
            ->where($params)
            ->withCount('comments')
            ->get();
    }

    public function notActivePosts(Request $req) {
        $params = [
            ['user_id', $req->user()->id],
            ['status', 404],
        ];
        return Post::select($this->contract::POST_SHOW_SELECT_DATA)
            ->where($params)
            ->withCount('comments')
            ->get();
    }

    public function activePosts(Request $req) {
        $params = [
            ['user_id', $req->user()->id],
            ['status', 1],
        ];
        return Post::select($this->contract::POST_SHOW_SELECT_DATA)
            ->where($params)
            ->withCount('comments')
            ->get();
    }

    public function activatePost(Request $req) {
        Post::where('id', $req->id)->update(['status' => 1]);
        return ['message' => true];
    }

    public function deactivatePost(Request $req) {
        Post::where('id', $req->id)->update(['status' => 404]);
        return ['message' => true];
    }

}
