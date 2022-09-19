<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{

    //lista todos os posts
    public function list(Request $request) {
        if ((Post::all()->count()>0)) {
            return Post::all();
        } else { return response()->json(["message"=>"Nao Ha Nenhum Post Na DB!"],404); }
    }

    //cria o post
    public function make(Request $request) {
        $validated = Validator::make($request->all(),[
            'user'=>['required','max:30'],
            'title'=>['required','max:30'],
            'descript'=>['required','max:255'],]);
        if(!$validated->fails()){
            $post = new Post;
            $post->id = $request->id;
            $post->user = $request->user;
            $post->title = $request->title;
            $post->descript = $request->descript;
            $post->save();
            return response()->json(["message"=>"SUCESSO: Post Criado!"],201);
        } return response()->json(["message"=>$validated->errors()->all()],500);
    }

    //mostra o post
    public function show(Request $request) {
        if (Post::where('id', $request->id)->exists()) {
            $post = Post::where('id', $request->id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($post, 200);
        } else { return response()->json(["message"=>"ERRO: Post Nao Encontrado!"],404); }
    }

    //edita o post
    public function edit(Request $request) {
        if (Post::where('id', $request->id)->exists()) {
            $post = Post::find($request->id);
            $post->title = is_null($request->title) ? $post->title : $request->title;
            $post->descript = is_null($request->descript) ? $post->descript : $request->descript;
            $post->save();
            return response()->json(["message"=>"SUCESSO: Post Atualizado!"],200);
            } else { return response()->json(["message"=>"ERRO: Post Nao Encontrado!"],404); }
    }

    //deleta o post
    public function delete(Request $request) {
        if(Post::where('id', $request->id)->exists()) {
            if (Comment::where('postID', $request->id)->count()>0) {
                $comment = Comment::where('postID', $request->id);
                $comment->delete();
            }
            $post = Post::find($request->id);
            $post->delete();
            return response()->json(["message"=>"SUCESSO: Post Deletado!"],202);
          } else { return response()->json(["message"=>"ERRO: Post Nao Encontrado!"],404); }
    }

}
