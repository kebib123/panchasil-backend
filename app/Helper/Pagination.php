<?php
namespace App\Helper;

class Pagination
{
    public $model;
    public $searchableFields;
    public $select;
    public function __construct($model, $searchableFields, $select = "*")
    {
        $this->model = $model;
        $this->searchableFields = $searchableFields;
        $this->select = $select;
    }
    public function paginate($request)
    {
        //http://localhost:3000/api/medicine?limit=1&page=1&sortBy=manufacturer&order=desc&searchText=cet
        $page = intval($request->page) ?: 1;
        $limit = intval($request->limit) ?: 10;
        $startIndex = ($page - 1) * $limit;
        $endIndex = $page * $limit;
        $retriveFromDb = $this
            ->model::whereLike($this->searchableFields, $request->searchText ? $request->searchText : '')
            ->offset($startIndex)
            ->limit($limit)
            ->select($this->select)
            ->orderBy($request->sortBy ? $request->sortBy : 'id',$request->order ? $request->order : 'asc');
        $queryResult = $retriveFromDb->get()->toArray();
        $numberOfData = $this->model::all()->count();
        $totalNumberOfPage = ceil($numberOfData / $limit);
        $result = [];
        if ($startIndex > 0) {
            $results["prevPage"] = $page - 1;
        }
        $result["currentPage"] = $page;
        if ($endIndex < $numberOfData) {
            $result["nextPage"] = $page + 1;
        }
        $result["totalNumberOfPage"] = $totalNumberOfPage;
        $result["currentPageData"] = count($queryResult);
        $result["totalData"] = $numberOfData;
        $result["data"] = $queryResult;
        if ($totalNumberOfPage < $page) {
            $result["data"] = [];
        }
        return $result;
    }
}
