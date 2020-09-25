<?php

namespace App\Http\Controllers\Api;

use App\Helper\Pagination;
use App\Http\Controllers\Controller;
use App\Model\SubCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $obj = new Pagination("\App\Model\SubCategory", ['name','category_id']);
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
            'category_id'=>'required|exists:categories,id',
             'name'=>'required|unique:sub_categories',
        ]);
        if ($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $data['name']=$request->name;
        $data['category_id']=$request->category_id;
        if (SubCategory::create($data))
        {
            return response()->json(["message" => "Subcategory created successfully", "error" => null]);
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
        $sub = SubCategory::findOrFail($id);
        return response()->json([
            'sub_category' => $sub,
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
            'category_id'=>'required|exists:categories,id',
            'name'=>'required',
        ]);
        if ($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        $data['name']=$request->name;
        $data['category_id']=$request->category_id;
        $update=SubCategory::where('id',$id)->update($data);
        if ($update) {
            return response()->json(["message" => "subcategory successfully updated", "error" => null]);
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
        $destroy = SubCategory::where('id', $id)->delete();
        if ($destroy) {
            return response()->json(["message" => "deleted", "error" => null]);
        }
    }
}
