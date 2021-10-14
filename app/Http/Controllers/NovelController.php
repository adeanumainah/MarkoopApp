<?php

namespace App\Http\Controllers;

use App\Models\Novel;
use Illuminate\Http\Request;

class NovelController extends Controller
{
    public function createNovel(Request $request)
    {
        $data = $request->all();
        try{
            $novel = new Novel();
            $novel->name = $data['name'];
            $novel->genre = $data['genre'];
            $novel->writer = $data['writer'];
            $novel->sinopsis = $data['sinopsis'];
            $novel->story = $data['story'];

            //save ke database
            $novel->save();
            $status = 'success';
            return response()->json(compact('status', 'novel'), 200);

        } catch(\Throwable $th){
            $status = 'unsuccess';
            return response()->json(compact('status', 'th'), 500);
        }
    }

    public function getAllNovel()
    {
        $novel = Novel::all();
        return response()->json(compact('novel'), 200);
    }

    public function getNovel($id)
    {
        $novel = Novel::find($id);
        return response()->json(compact('novel'), 200);
    }

    public function updateNovel(Request $request, $id)
    {
        $data = $request->all(); 
        try {
            $novel = Novel::findOrFail($id);
            $novel->name = $data['name'];
            $novel->genre = $data['genre'];
            $novel->writer = $data['writer'];
            $novel->sinopsis = $data['sinopsis'];
            $novel->story = $data['story'];

            //save ke database
            $novel->save();
            $status = 'success';
            return response()->json(compact('status', 'novel'), 200);

        } catch (\Throwable $th) {
            $status = 'unsuccess';
            return response()->json(compact('status', 'th'), 500);
        } 
    }

    public function deleteNovel($id)
    {
        $novel = Novel::findOrFail($id);
        $novel->delete();

        $status = 'deleted';
        return response()->json(compact('status'), 200);
    }
}
