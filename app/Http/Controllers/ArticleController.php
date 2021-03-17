<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ArticleController extends Controller
{
    public function index()
    {
        return Article::all();
    }

    public function store(Request $request)
    {
        $article = Article::create($request->all());

        if ($article) {
            return response()->json($article, Response::HTTP_OK);
        }

        return response()->json($article, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function edit($id)
    {
        return Article::find($id);
    }

    public function update(Request $request, $id)
    {
        $success = Article::findOrFail($id)->update($request->except('id'));

        if ($success) {
            return response()->json($request->all(), Response::HTTP_OK);
        }

        return response()->json($request->all(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function destroy($id)
    {
        $success = Article::findOrFail($id)->delete();

        if ($success) {
            return response()->json([], Response::HTTP_OK);
        }

        return response()->json([], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
