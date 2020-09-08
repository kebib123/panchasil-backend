<?php

namespace App\Repositories\Eloquent;

use App\News;
use App\Repositories\Contracts\NewsRepository;

use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

class EloquentNewsRepository extends AbstractRepository implements NewsRepository
{
    public function entity()
    {
        return \App\Model\News::class;
    }

    public function store($request)
    {
        $data['title']=$request->title;
        $data['author']=$request->author;
        $data['status']=$request->status;
        $data['taja_khabar']=$request->taja_khabar;
        $data['headline']=$request->headline;
        $data['related']=$request->related;
        $data['description']=$request->description;
        $data['category_id']=$request->category_id;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/news');
            $image->move($destinationPath, $name);
            $data['image'] = $name;
        }


        $create=$this->entity()::create($data);
        return $create;
    }

    public function getAll()
    {
        $news=$this->entity()::all();

        return $news;
    }

    public function update($request,$id)
    {
        $find=$this->entity()::find($id);
        $data['title']=$request->title;
        $data['author']=$request->author;
        $data['status']=$request->status;
        $data['taja_khabar']=$request->taja_khabar;
        $data['headline']=$request->headline;
        $data['related']=$request->related;
        $data['description']=$request->description;
        $data['category_id']=$request->category_id;
        if ($request->hasFile('image')) {
            $this->delete_file($id);
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/news');
            $image->move($destinationPath, $name);
            $data['image'] = $name;
        }
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
        $deletePath = public_path('images/news/' . $fileName);
        if (file_exists($deletePath) && is_file($deletePath)) {
            unlink($deletePath);
        }
        return true;
    }

    public function getbyId($id)
    {
        $news=$this->entity()::find($id);
        return $news;
    }
}
