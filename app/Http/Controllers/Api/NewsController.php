<?php

namespace App\Http\Controllers\Api;

use App\Helper\Pagination;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NewsRequest;
use App\Http\Resources\News;
use App\Model\News as ModelNews;
use App\Repositories\Contracts\NewsRepository;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $news;

    public function __construct(NewsRepository $news)
    {
        $this->middleware("jwt.verify")->except(["index", "show"]);
        $this->news = $news;
    }
    public function index(Request $request)
    {
        $obj = new Pagination("\App\Model\News", ["author", "title", "id"]);
        $paginateResult = $obj->paginate($request);
        return response()->json($paginateResult);
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
    public function store(NewsRequest $request)
    {
        try {
            $this->news->store($request);
        } catch (\Exception $exception) {
            throw new \PDOException('Error in saving News' . $exception->getMessage());
        }
        return response()->json([
            'message' => 'News Successfully Added',
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
        $all = $this->news->getbyId($id);

        return new News($all);
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

    public function getByType($type, $category, Request $request)
    {
        $query = $category == 'all' ? ['type' => $type] : ['category_id' => $category, 'type' => $type];
        $obj = new Pagination("\App\Model\News", ["author", "title", "id"]);
        $paginateResult = $obj->paginate($request, $query);
        return $paginateResult;
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
            ModelNews::where("id", $id)->update($data);
        } catch (\Exception $exception) {
            throw new \PDOException('Error in updating News' . $exception->getMessage());
        }
        return response()->json([
            'message' => 'Updated Successfully',
        ], 200);}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->news->delete($id);
        } catch (\Exception $exception) {
            throw new \PDOException('Error in deleting News' . $exception->getMessage());
        }
        return response()->json([
            'message' => 'news deleted successfully',
        ], 200);
    }
}
