<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    public function index()
{
    $users = User::all();
    $posts = Post::all();

    return view('index', compact('posts', 'users'));
}
public function myposts()
{
    $posts = post::where('user_id', Auth()->user()->id)->orderBy('created_at', 'desc')->get();
        return view('myposts')->with('posts', $posts);
        $posts = post::all();
        return $posts;
}

    
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function create()
    {
        return view('post');
    }

    public function store(Request $request)
    {


        //store image
        if($request->hasFile('cover_image')){
            // Get filename with the extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
		
	    // make thumbnails
	    $thumbStore = 'thumb.'.$filename.'_'.time().'.'.$extension;
            $thumb = Image::make($request->file('cover_image')->getRealPath());
            $thumb->resize(80, 80);
            $thumb->save('storage/cover_images/'.$thumbStore);
		
        } else {
            $fileNameToStore = 'noimage.jpg';
        }
        

        $post =  new Post;
        $post->title = $request->get('title');
        $post->body = $request->get('body');
        $post->user_id = auth()->user()->id;
        $post->cover_image = $fileNameToStore;
        $post->save();

        return redirect('posts');

    }
    public function show($id)
    {
    $post = Post::find($id);

    return view('show', compact('post'));
    }

    public function edit($id)
    {
    $post = Post::find($id);
    return view('edit')->with('post', $post);
    }

    public function update(Request $request, $id)
    {
    $post = Post::find($id);
    $post->title = $request->input('title');
    $post->body = $request->input('body');

    if (file_exists($request->file('cover_image'))) {
        $filenamewithExt = $request->file('cover_image')->getClientOriginalName();
        $filename = pathinfo($filenamewithExt, PATHINFO_FILENAME);
        $extension = $request->file('cover_image')->getClientOriginalExtension();
        $fileNameToStore = $filename . '_' . time() . '.' . $extension;
        $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);

        $post->image = $fileNameToStore;
        // File::delete($request->input('existingimg'));
        @unlink('public/cover_images/' . $request->input('existingimg'));
    } else {

        $post->image = $request->input('existingimg');
    }

    $post->save();

    return redirect('posts');
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        
        $post->delete();
        return redirect()->route('posts');
    }
    
    public function likepost($id)
    {
        $post = Post::find($id);
        $post->like();
        $post->save();

        return redirect()->route('posts')->with('message','Post Like successfully!');
    }

    public function unlikepost($id)
    {
        $post = Post::find($id);
        $post->unlike();
        $post->save();
        
        return redirect()->route('posts')->with('message','Post Like undo successfully!');
    }

}
