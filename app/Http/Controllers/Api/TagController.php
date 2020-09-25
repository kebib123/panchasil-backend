<?php

namespace App\Http\Controllers\Api;

use App\Helper\Pagination;
use App\Http\Controllers\Controller;
use App\Model\NewsTag;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $obj = new Pagination("\App\Model\NewsTag", ['name','news_id']);
        return response()->json($obj->paginate($request));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(),[
            'news_id'=>'required|exists:news,id',
            'name'=>'required|unique:news_tags',
        ]);
        if ($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $data['name']=$request->name;
        $data['news_id']=$request->news_id;
        if (NewsTag::create($data))
        {
            return response()->json(["message" => "NewsTag created successfully", "error" => null]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sub = NewsTag::findOrFail($id);
        return response()->json([
            'news_tags' => $sub,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(),[
            'news_id'=>'required|exists:news,id',
            'name'=>'required',
        ]);
        if ($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        $data['name']=$request->name;
        $data['news_id']=$request->news_id;
        $update=NewsTag::where('id',$id)->update($data);
        if($update)
        {
            return response()->json(["message" => "newstags successfully updated", "error" => null]);

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $destroy = NewsTag::where('id', $id)->delete();
        if ($destroy) {
            return response()->json(["message" => "deleted", "error" => null]);
        }
    }
}
