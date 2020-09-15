<?php

namespace App\Http\Controllers\Api;

use App\Helper\Pagination;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Model\Category;
use App\Repositories\Contracts\CategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $category;

    public function __construct(CategoryRepository $category)
    {
        $this->middleware("jwt.verify")->except(["index", "show"]);
        $this->category = $category;
    }

    public function index(Request $request)
    {
        $obj = new Pagination("\App\Model\Category", ["name", "status"]);
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
    public function store(CategoryRequest $request)
    {
        try {
            $this->category->store($request);
        } catch (\Exception $exception) {
            throw new \PDOException('Error in saving NewsCategory' . $exception->getMessage());
        }
        return response()->json([
            'message' => 'News Category Successfully Added',
        ], 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cat = $this->category->getbyId($id);

        return response()->json([
            'news_category' => $cat,
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
        $data = $request->all();
        $data = array_filter($data, function ($i) {
            return $i != 'PUT';
        });
        try {
            Category::where("id", $id)->update($data);
        } catch (\Exception $exception) {
            throw new \PDOException('Error in updating NewsCategory' . $exception->getMessage());
        }
        return response()->json([
            'message' => 'updated successfully',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->category->delete($id);
        } catch (\Exception $exception) {
            throw new \PDOException('Error in deleting NewsCategory' . $exception->getMessage());
        }
        return response()->json([
            'message' => 'deleted successfully',
        ], 200);
    }
}
