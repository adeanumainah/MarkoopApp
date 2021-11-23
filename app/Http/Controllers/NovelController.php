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
            // $data = new Novel();
            // $novel->name = $data['name'];
            // $novel->genre = $data['genre'];
            // $novel->writer = $data['writer'];
            // $novel->sinopsis = $data['sinopsis'];
            // $novel->story = $data['story'];

            $request->validate([
                'name' => 'required',
                'genre' => 'required',
                'writer' => 'required',
                'sinopsis' => 'required',
                'story' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
    
            if ($image = $request->file('image')) {
                $destinationPath = 'image/';
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $data['image'] = "$profileImage";
            }

            Novel::create($data);

            //save ke database 
            // $data->save();
            $status = 'success';
            return response()->json(compact('status', 'data'), 200);

        } catch(\Throwable $th){
            $status = 'unsuccess';
            return response()->json(compact('status', 'th'), 500);
        }
    }

    public function getAllNovel(Request $request)
    {
        $novel = Novel::all();
        $status = 'success';
        return response()->json(compact('status', 'novel'), 200);

    }

    public function getGenre($genre)
    {
        return Novel::where("genre","like","%".$genre."%")->get();
    }

    public function getNovel($id)
    {
        $novel = Novel::find($id);
        return response()->json(compact('novel'), 200);
    }


    public function genreFiltering(Request $request)
    {

    // $novel_query = Novel::query();

    // $genre = request()->query("genre");

    // if(request()->has("genre")&& strlen(request()->query("genre"))>=1){


    //     $Novel = $novel_query->where(
    //         "genre","like","%".$genre."%")->get();
    //      }

    $novel_query= Novel::with(['category']);

    if($request->keyword){
        $novel_query->where('name','LIKE', '%'.$request->keyword.'%');
    }

    if($request->category){
        $novel_query->whereHas('genre',function($query) use($request){
            $query->where('genre', $request->category);
        });
    }

    $novels=$novel_query->get();
    return response()->json([
        'message' => 'Novel Success',
        'data'=>$novels
    ],200);

    // return response()->json(compact('Novel'), 200);

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

    public function searchNovel(Request $request)
{
    $novel = Novel::query();

    $search = request()->query("search");

if(request()->has("search")&& strlen(request()->query("search"))>=1){


    $Novel = $novel->where(
        "name","like","%".$search."%")->get();
     }


     //query pagination
    //  $pagination = 5;
    //  $Data = $Data->orderBy('created_at','desc')
    //  ->paginate($pagination);

    return response()->json(compact('Novel'), 200);

}

    public function deleteNovel($id)
    {
        $novel = Novel::findOrFail($id);
        $novel->delete();

        $status = 'deleted';
        return response()->json(compact('status'), 200);
    }
}
