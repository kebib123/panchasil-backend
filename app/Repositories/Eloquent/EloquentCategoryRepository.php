<?php

namespace App\Repositories\Eloquent;

use App\Category;
use App\Repositories\Contracts\CategoryRepository;

use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

class EloquentCategoryRepository extends AbstractRepository implements CategoryRepository
{
    public function entity()
    {
        return \App\Model\Category::class;
    }

    public function getAll()
    {
        $category=$this->entity()::paginate(10);
        return $category;
    }

    public function getbyId($id)
    {
        $category=$this->entity()::find($id);
        return $category;
    }

    public function store($request)
    {
        $data['name']=$request->name;
        $data['status']=$request->status;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/category');
            $image->move($destinationPath, $name);
            $data['image'] = $name;
        }
        $create=$this->entity()::create($data);
        return $create;
    }

    public function update($request,$id)
    {
        $find=$this->entity()::find($id);
        if ($request->hasFile('image')) {
            $this->delete_file($id);
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/category');
            $image->move($destinationPath, $name);
            $data['image'] = $name;
        }
        $data['name']=$request->name;
        $data['status']=$request->status;
        $update=$find->update($data);

        return $update;
    }

    public function delete($id)
    {

        $find=$this->entity()::find($id);
        $del=$this->delete_file($id) && $find->delete() ;
        return $del;
    }

    public function delete_file($id)
    {
        $findData = $this->entity()::find($id);
        $fileName = $findData->image;
        $deletePath = public_path('images/category/' . $fileName);
        if (file_exists($deletePath) && is_file($deletePath)) {
            unlink($deletePath);
        }
        return true;
    }



}
