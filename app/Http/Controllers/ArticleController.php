<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        return Article::all();
    }

    public function store(Request $request)
    {
        return Article::create([
            'name' => $request->input('name'),
            'author' => $request->input('author'),
        ]);
    }

    public function edit($id)
    {
        return Article::find($id);
    }

    public function update(Request $request, $id)
    {
        return Article::where('id', $id)->update([
            'name' => $request->input('name'),
            'author' => $request->input('author'),
        ]);
    }

    public function destroy($id)
    {
        return Article::where('id', $id)->delete();
    }
}
