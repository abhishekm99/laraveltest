<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$posts = Post::paginate(10);
        //$posts= Post::orderBy('Created_at','desc')->get();
        $posts= Post::orderBy('Created_at','desc')->paginate(13);
        //$posts = Post::orderBy('Created_at','desc')->get();
        return view('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this -> validate($request, [
            'title' => 'required|unique:posts',
            'body' => 'required',
            'cover_image' => 'image|nullable||max:1999',
        ]);

            if($request->hasFile('cover_image'))
            {
                //Get file name with extention
                $fileNamewithext = $request->file('cover_image')->getClientOriginalName();
                //Get just file name
                $fileName = pathinfo($fileNamewithext, PATHINFO_FILENAME);
                //GET extention
                $extension = $request->file('cover_image')->getClientOriginalExtension();
                $filenametoStore = $fileName.'_'.time().'.'.$extension;
                //UPLOAD
                $path = $request->file('cover_image')->storeAs('public/cover_images',$filenametoStore);
            }
            else
            {
                $filenametoStore='Nofile.jpg';
            }
        $post= new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->cover_image = $filenametoStore;
        $post->save();
        return redirect('/posts')->with('success', 'Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post= Post::find($id);
        return view('posts.show')->with('post',$post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post= Post::find($id);
        if(auth()->user()->id !== $post->user_id)
        {
            return redirect('/posts')->with('error', 'Unauthorised access, please edit your own post');
        }
        return view('posts.edit')->with('post', $post);
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
        $this -> validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);

        if($request->hasFile('cover_image'))
            {
                //Get file name with extention
                $fileNamewithext = $request->file('cover_image')->getClientOriginalName();
                //Get just file name
                $fileName = pathinfo($fileNamewithext, PATHINFO_FILENAME);
                //GET extention
                $extension = $request->file('cover_image')->getClientOriginalExtension();
                $filenametoStore = $fileName.'_'.time().'.'.$extension;
                //UPLOAD
                $path = $request->file('cover_image')->storeAs('public/cover_images',$filenametoStore);
            }

        $post= Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        if($request->hasFile('cover_image'))
        {
            $post->cover_image = $filenametoStore;
        }
        $post->save();
        return redirect('/posts')->with('success', 'Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post= Post::Find($id);
        if(auth()->user()->id !== $post->user_id)
        {
            return redirect('/posts')->with('error', 'Unauthorised access, please delete your own post');
        }
        if($post->cover_image != 'noimage.jpg')
        {
            Storage::delete('public/cover_images/'.$post->cover_image);
        }
        $post->delete();
        return redirect('/posts')->with('success', 'Post Deleted');
    }
}
