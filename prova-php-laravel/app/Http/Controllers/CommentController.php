<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{

    //lista todos os comentarios
    public function list(Request $request) {
        if ((Post::where('id', $request->id)->exists())) {
            if (Comment::where('postID', $request->id)->count()>0) {
                return Comment::where('postID', $request->id)->get();
            } else { return response()->json(["message"=>"Nenhum Comentario Encontrado!"],404); }
        } else { return response()->json(["message"=>"ERRO: Post Nao Encontrado!"],404); }
    }

    //cria o comentario
    public function make(Request $request) {
        $validated = Validator::make($request->all(),[
            'user'=>['required','max:30'],
            'descript'=>['required','max:255'],]);
        if(!$validated->fails()){
            $comment = new Comment;
            $comment->id = $request->id_c;
            $comment->user = $request->user;
            $comment->descript = $request->descript;
            $comment->postID = $request->id;
            $comment->save();
            return response()->json(["message"=>"SUCESSO: Comentario Criado!"],201);
        } return response()->json(["message"=>$validated->errors()->all()],500);
    }

    //mostra o comentario
    public function show(Request $request) {
        if ((Post::where('id', $request->id)->exists())) {
            if (Comment::where('id', $request->id_c)->exists()) {
                $comment = Comment::where('id', $request->id_c)->get()->toJson(JSON_PRETTY_PRINT);
                return response($comment, 200);
            } else { return response()->json(["message"=>"ERRO: Comentario Nao Encontrado!"],404); }
        } else { return response()->json(["message"=>"ERRO: Post Nao Encontrado!"],404); }
    }

    //edita o comentario
    public function edit(Request $request) {
        if ((Post::where('id', $request->id)->exists())) {
            if (Comment::where('id', $request->id_c)->exists()) {
                $comment = Comment::find($request->id_c);
                $comment->descript = is_null($request->descript) ? $comment->descript : $request->descript;
                $comment->save();
                return response()->json(["message"=>"SUCESSO: Comentario Atualizado!"],200);
                } else { return response()->json(["message"=>"ERRO: Comentario Nao Encontrado!"],404); }
        } else { return response()->json(["message"=>"ERRO: Post Nao Encontrado!"],404); }
    }

    //deleta o comentario
    public function delete(Request $request) {
        if ((Post::where('id', $request->id)->exists())) {
            if (Comment::where('id', $request->id_c)->exists()) {
                $comment = Comment::find($request->id_c);
                $comment->delete();
                return response()->json(["message"=>"SUCESSO: Comentario Deletado!"],202);
                } else { return response()->json(["message"=>"ERRO: Comentario Nao Encontrado!"],404); }
        } else { return response()->json(["message"=>"ERRO: Post Nao Encontrado!"],404); }
    }

}
