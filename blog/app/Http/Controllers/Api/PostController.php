<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    public function index()

    {
        // $posts = Post::all(); //senza paginazione

        $posts = Post::paginate(3); //con paginazione

        return response()->json($posts);
    }

    //dettagli per il post
    public function show($slug)
    {
        //$post = Post::where('slug', $slug)->first(); // A) prendere il post tramite slug,  senza categoira e tag
        $post = Post::where('slug', $slug)->with(['category', 'tags'])->first(); // B) prendere il post tramite slug, con categoira e tag

        if (!$post) {
            $post['not_found'] = true;
        }

        return response()->json($post); // ritorno dati in json
    }
}
