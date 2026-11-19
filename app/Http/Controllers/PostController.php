<?php
// Menetapkan lokasi namespace untuk controller fitur post.
namespace App\Http\Controllers;
// Mengimpor model untuk mengambil dan menyimpan post.
use App\Models\Post;
// Mengimpor renderer Inertia untuk menampilkan halaman Vue.
use Inertia\Inertia;
// Mengimpor request HTTP untuk menerima input pengguna.
use Illuminate\Http\Request;
// Mengimpor facade redirect untuk navigasi setelah aksi CRUD.
use Illuminate\Support\Facades\Redirect;
// Mengelompokkan aksi CRUD yang tersedia untuk post.
class PostController extends Controller
{
    /** * index*
     * @return void */
    public function index()
    {
        //get all posts from database
        $posts = Post::latest()->get();
        //render with data "posts"
        return Inertia::render('Post/Index', [
            'posts' => $posts
        ]);
    }

    /** * create *
     * @return void */
    public function create()
    {
        return Inertia::render('Post/Create');
    }
    /** * store *
     * @param  mixed $request
     * @return void */
    public function store(Request $request)
    {
        //set validation
        $request->validate([
            'title'   => 'required',
            'content' => 'required',
        ]);
        //create post
        $post = Post::create([
            'title'     => $request->title,
            'content'   => $request->content
        ]);
        if($post) {
            // Mengembalikan pengguna ke daftar post dengan pesan keberhasilan.
            return Redirect::route('posts.index')->with('message', 'Data Berhasil Disimpan!');
        }
    }

    /** * edit  *
     * @param  mixed $post
     * @return void */
    public function edit(Post $post)
    {
        return Inertia::render('Post/Edit', [
            'post' => $post
        ]);
    }
    /** * update  *
     * @param  mixed $request
     * @param  mixed $post
     * @return void */
    public function update(Request $request, Post $post)
    {
        //set validation
        $request->validate([
            'title'   => 'required',
            'content' => 'required',
        ]);
        //update post
        $post->update([
            'title'     => $request->title,
            'content'   => $request->content
        ]);
        if($post) {
            // Mengembalikan pengguna ke daftar post setelah perubahan berhasil.
            return Redirect::route('posts.index')->with('message', 'Data Berhasil Diupdate!');
        }  }
    /** * destroy *
     * @param  mixed $id
     * @return void */
    public function destroy($id)
    {
        //find post by ID
        $post = Post::findOrfail($id);
        //delete post
        $post->delete();
        if($post) {
            // Mengembalikan pengguna ke daftar post setelah penghapusan.
            return Redirect::route('posts.index')->with('message', 'Data Berhasil Dihapus!');
        }    }  }
