<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\CityModel as City;
use App\Models\CountryModel as Country;
use App\Models\CommentModel as Comment;
use App\Contracts\PostContract;
use App\Models\RequestModel as Post;
use App\Models\PostImage;
use App\Models\UserBlocked;

class PostController extends Controller
{
    public function __construct()
    {
        $this->contract = new PostContract();
    }

    public function posts(Request $req) {
        // dd(public_pa());
        $user = Auth::guard('api')->user();
	if ($user) {
          $blocked_users = $user
            ->blocked_users
            ->pluck('blocked_user_id')
            ->toArray();
          $blocked_me_users = $user
                ->blocked_me_users
                ->pluck('user_id')
                ->toArray();
            $block_users = array_merge(
                $blocked_users,
                $blocked_me_users
            );
	}

        $params = [
            ['requests.status', 1]
        ];
        // $params[] = ['requests.city_id', $req->user()->native_country_id ?? 1];
        if ($req->category_id) $params[] = ['requests.category_id', (int) $req->category_id];
        if ($req->search) {
            $params[] = ['requests.title', 'like','%'.$req->search.'%'];
        }

        $posts = Post::select($this->contract::POST_SELECT_DATA)
            ->leftJoin('users', 'requests.user_id', '=', 'users.id')
            ->where($params)
            ->whereNotIn('users.id', $block_users ?? [])
            ->withCount('comments');
            // ->get();

        if ($user) {
			if ($user->native_country_id) {
				// $posts->where('requests.city_id', $user->native_country_id);
				$native_country = City::select('id', 'country_id')
					->where('id', $user->native_country_id)
					->first();

				$cities = City::select('id')
					->where('country_id', $native_country->country_id)
					->where('id', '!=', $native_country->id)
					->get()
					->pluck('id')
					->toArray();
				array_unshift($cities, $native_country->id);
				$other_cities = City::select('id')
					->whereNotIn('id', $cities)
					->get()
					->pluck('id')
					->toArray();
				$cities += $other_cities;

				$posts->whereIn('requests.city_id', $cities)
					->orderBy(DB::raw('FIELD(requests.city_id, '.implode(',', $cities).')'))
                    ->orderBy('requests.created_at', 'desc');

				// $posts = $posts->sortBy(function($model) use ($cities) {
				//     return array_search( $model->city_id, $cities );
				// })->values();
			}
        }

        $posts = $posts->get();

        foreach ($posts as $post) {
            $post->last_comment = $post->comments()
                ->select($this->contract::POST_SELECT_COMMENTS)
                ->leftJoin('users', 'comments.user_id', '=', 'users.id')
                ->orderBy('comments.created_at', 'desc')
                ->first();
            if ($user) {
                $favourite_params = [
                    ['user_id', $user->id],
                    ['post_id', $post->id]
                ];
                if ( DB::table('favourite_user_posts')->where($favourite_params)->exists() ) {
                    $post->is_favourite = true;
                } else $post->is_favourite = false;
            }
        }
        return $posts;
    }

    public function postShow(Request $req) {
        if ($req->id) {
            $post = Post::where('requests.id', $req->id)
                ->select($this->contract::POST_SELECT_DATA)
                ->leftJoin('users', 'requests.user_id', '=', 'users.id')
                ->with('post_images')
                ->withCount('comments')
                ->first();

            // dd($post);
            if ($post) {
                $user = Auth::guard('api')->user();
                
                $where_params = [
                    ['user_id', $post->user_id],
                    ['blocked_user_id', $user->id]
                ];
                if ( UserBlocked::where($where_params)->exists() ) {
                    $post->is_user_blocked_you = true;
                } else $post->is_user_blocked_you = false;

                $where_params = [
                    ['user_id', $user->id],
                    ['blocked_user_id', $post->user_id]
                ];
                if ( UserBlocked::where($where_params)->exists() ) {
                    $post->my_blocked_user = true;
                } else $post->my_blocked_user = false;

                $data['post'] = $post;
                $data['comments'] = $post->comments()
                    ->select($this->contract::POST_SELECT_COMMENTS)
                    ->leftJoin('users', 'comments.user_id', '=', 'users.id')
                    ->orderBy('comments.created_at', 'desc')
                    ->get();

                if ($user) {
                    $favourite_params = [
                        ['user_id', $user->id],
                        ['post_id', $post->id]
                    ];
                    if ( DB::table('favourite_user_posts')->where($favourite_params)->exists() ) {
                        $data['post']['is_favourite'] = true;
                    } else $data['post']['is_favourite'] = false;
                }
            }
        }
        return $data ?? [];
    }

    public function commentsList(Request $req) {
        $params = $this->contract::POST_SELECT_COMMENTS;
        $params[] = 'requests.id as post_id';
        return Comment::where('requests.user_id', $req->user()->id)
            ->select($params)
            ->leftJoin('users', 'comments.user_id', '=', 'users.id')
            ->leftJoin('requests', 'comments.post_id', '=', 'requests.id')
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

    // Favourite
    public function likedPosts(Request $req) {
        $params = [
            ['requests.status', 1]
        ];
        // $params[] = ['requests.city_id', $req->user()->native_country_id ?? 1];
        // if (Auth::guard('api')->user()) $params[] = ['favourite_user_posts.user_id', $req->user()->id];
        // if ($req->category_id) $params[] = ['requests.category_id', (int) $req->category_id];
        // $params[] = ['favourite_user_posts.user_id', $req->user()->id];
        $favourite_post_id_list = DB::table('favourite_user_posts')
            ->where('user_id', $req->user()->id)
            ->get()
            ->pluck('post_id');

        // dd($favourite_post_id_list);

        $posts = Post::select($this->contract::POST_SELECT_DATA)
            ->leftJoin('users', 'requests.user_id', '=', 'users.id')
            // ->leftJoin('favourite_user_posts', 'favourite_user_posts.post_id', '=', 'requests.id')
            ->whereIn('requests.id', $favourite_post_id_list)
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
            $post->is_favourite = true;
        }
        return $posts;
    }

    public function likedPostCreate(Request $req) {
        if ($req->post_id) {
            $favourite_params = [
                ['user_id', $req->user()->id],
                ['post_id', $req->post_id]
            ];
            if ( DB::table('favourite_user_posts')->where($favourite_params)->exists() ) {
                return ['message' => false];
            }
            DB::table('favourite_user_posts')->insert([
                'user_id' => $req->user()->id,
                'post_id' => $req->post_id,
            ]);
        }
        return ['message' => true];
    }

    public function likedPostDestroy(Request $req) {
        if ($req->post_id) {
            $favourite_params = [
                ['user_id', $req->user()->id],
                ['post_id', $req->post_id]
            ];
            // dd($favourite_params);
            DB::table('favourite_user_posts')
                ->where($favourite_params)
                ->delete();
        }
        return ['message' => true];
    }

    // CRUD Post
    public function postCreate(Request $req) {
        if ($req->file('post_images')) {
            $photo_path = \App\Services\ImageService::saveImages($req->file('post_images'), 'public/post_images');
        }

        $data = [
            'user_id' => $req->user()->id,
            'phone' => $req->phone ?? $req->user()->phone_number,
            'email' => $req->email ?? $req->user()->email,
            'photo_path' => $req->post_images
                                        ? str_replace('public', 'storage', $photo_path)
                                        : '',
            'title' => $req->title,
            'description' => $req->description,
            'category_id' => (int) $req->category_id,
            'city_id' => (int) $req->city_id,
            'seen' => 0,
        ];
        $post = Post::create($data);

        // $post_images = [];
        // if (count($post_images) > 1) {
        //     for ($i=1; $i < count($photo_path); $i++) {
        //         $post_images[] = [
        //             'post_id' => $post->id,
        //             'image' => $photo_path[$i],
        //         ];
        //     }
        //     PostImage::insert($post_images);
        // }

        return $post;
    }

    public function postEdit(Request $req) {
        $post = Post::find((int) $req->post_id);
        if ($post) {
            $post->user_id          = $req->user()->id ?? $post->user_id;
            $post->title            = $req->title ?? $post->title;
            $post->description      = $req->description ?? $post->description;
            $post->category_id      = (int) $req->category_id ?? $post->category_id;
            $post->city_id          = (int) $req->city_id ?? $post->city_id;
            $post->phone            = $req->phone ?? $post->phone;
            $post->email            = $req->email ?? $post->email;
        }
        $post->save();
        return $post;
    }

    public function postDelete(Request $req) {
        Post::where('id', $req->post_id)
            ->where('user_id', $req->user()->id)
            ->delete();
        return ['message' => true];
    }

    public function postSeenIncr(Request $req) {
        if ($req->post_id) {
            $post = Post::where('id', (int) $req->post_id)->first();
            $post->seen += 1;
            $post->save();
        }
    }

    // Post images
    public function postAvatarChange(Request $req) { // post_id, image
        if ($req->file('image')) {
            $photo_path = \App\Services\ImageService::saveImages($req->file('image'), 'public/post_images');
        }

        if ($photo_path) {
            $post = Post::find((int) $req->post_id);
            if ($post->photo_path != 'storage/default_images/default_post_icon.png') {
                unlink(storage_path().'/app/'.str_replace('storage', 'public', $post->photo_path));
            }
            $post->photo_path = str_replace('public', 'storage', $photo_path);
            $post->save();
        }
        return $post;
    }

    public function postImageAdd(Request $req) { // post_id, image
        if ($req->file('image')) {
            $photo_path = \App\Services\ImageService::saveImages($req->file('image'), 'public/post_images');
        }

        if ($photo_path) {
            $post_image = PostImage::create([
                'post_id' => $req->post_id,
                'image' => str_replace('public', 'storage', $photo_path),
            ]);
        }

        return $post_image ?? ['message' => false];
    }

    public function postImageDelete(Request $req) { // image_id
        $post_image = PostImage::find((int) $req->image_id);
        unlink(storage_path().'/app/'.str_replace('storage', 'public', $post_image->image));
        $post_image->delete();
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
            'favourite_posts' => DB::table('favourite_user_posts')
                ->leftJoin('requests', 'requests.id', '=', 'favourite_user_posts.post_id')
                ->where('favourite_user_posts.user_id', $req->user()->id)
                ->count()
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
