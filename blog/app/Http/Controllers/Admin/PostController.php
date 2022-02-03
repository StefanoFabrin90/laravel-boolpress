<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Post;
use App\Category;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // paginazione
        $posts = Post::paginate(4);
        //$posts = Post::simplePaginate(3);
        //$posts = Post::all();
        //dump($posts);

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //step category 
        $categories = Category::all();


        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validazione
        // $request->validate([
        //     'title' => 'required|max:255',
        //     'content' => 'required'
        // ], [
        //     'required' => 'The :attribute is wrong',
        //     'max' => 'Max :max characters for the :attribute',
        // ]);
        $request->validate($this->validation_rules(), $this->validation_message());
        $data = $request->all();
        //dump($data);


        // creazione nuovo post
        $new_post = new Post;
        $slug = Str::slug($data['title'], '-');
        $count = 1;
        $base_slug = $slug;

        while (Post::where('slug', $slug)->first()) {
            $slug = $base_slug . '-' . $count;
            $count++;
        }

        $data['slug'] = $slug;

        $new_post->fill($data); //fillable
        $new_post->save();

        return redirect()->route('admin.posts.show', $new_post->slug);
    }

    /**
     * Display the specified resource.
     *
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post = Post::where('slug', '=', $slug)->first();
        //dump($post->category);


        if (!$post) {
            abort(404);
        }

        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        //step category 
        $categories = Category::all();

        if (!$post) {
            abort(404);
        }

        return view('admin.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // validazione
        // $request->validate([
        //     'title' => 'required|max:255',
        //     'content' => 'required'
        // ], [
        //     'required' => 'The :attribute is wrong',
        //     'max' => 'Max :max characters for the :attribute',
        // ]);
        $request->validate($this->validation_rules(), $this->validation_message());

        $data = $request->all();
        //dump($data);

        $post = Post::find($id);

        if ($data['title'] != $post->title) {
            $slug = Str::slug($data['title'], '-');
            $count = 1;
            $base_slug = $slug;
            while (Post::where('slug', $slug)->first()) {
                $slug = $base_slug . '-' . $count;
                $count++;
            }

            $data['slug'] = $slug;
        } else {
            $data['slug'] = $post->slug;
        }

        $post->update($data);

        return redirect()->route('admin.posts.show', $post->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        $post->delete();

        return redirect()->route('admin.posts.index')->with('delete', $post->title);
    }

    // validazione delle regole
    private function validation_rules()
    {
        return [
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'nullable|exists:categories,id',
        ];
    }

    // validazione delle message
    private function validation_message()
    {
        return [
            'required' => 'The :attribute is wrong',
            'max' => 'Max :max characters for the :attribute',
            'category_id.exists' => 'This ID is invalid',
        ];
    }
}
