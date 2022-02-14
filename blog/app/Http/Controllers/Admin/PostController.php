<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Post;
use App\Tag;
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
        //$posts = Post::paginate(4);
        //$posts = Post::simplePaginate(3);
        $posts = Post::all();
        $tags = Tag::all();

        //dump($posts);

        return view('admin.posts.index', compact('posts', 'tags'));
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
        $tags = Tag::all();


        return view('admin.posts.create', compact('categories', 'tags'));
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
        //dd($data);

        //aggiunta immagine se presente per il post
        if (array_key_exists('cover', $data)) {
            //salvare l imaggine in storage
            //ottenere l url in termini di posizione e sia di nome file da salvare poi su db
            $image = Storage::put('posts-cover', $data['cover']);
            $data['cover'] = $image;
        }


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

        //salva in pivot relazione tra nuovo post con tags selzionati dalla form
        if (array_key_exists('tags', $data)) {
            $new_post->tags()->attach($data['tags']);
        }

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
        $tags = Tag::all();

        if (!$post) {
            abort(404);
        }

        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
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

        //dopo post, perche mi serve il post di controllo
        //aggiornamento image
        if (array_key_exists('cover', $data)) {
            //rimozione immagine se gia presente
            if ($post->cover) {
                Storage::delete($post->cover);
            }

            //aggiornamneto image (stesso passaggio di prima ma acorcio senza creare una variabile)
            $data['cover'] = Storage::put('posts-cover', $data['cover']);
        }

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

        //relazioni con la cartella pivot - aggiornamento 
        if (array_key_exists('tags', $data)) {
            $post->tags()->sync($data['tags']); // update(aggiornamento) dei tags 
        } else {
            $post->tags()->detach(); //nessun check selazione della form quindi pulizia
        }

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
            'tags' => 'nullable|exists:tags,id',
            'cover' => 'nullable|file|mimes:jpeg,bmp,png',
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
