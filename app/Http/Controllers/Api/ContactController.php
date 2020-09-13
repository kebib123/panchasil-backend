<?php

namespace App\Http\Controllers\Api;

use App\Helper\Pagination;
use App\Http\Controllers\Controller;
use App\Model\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $obj = new Pagination('\App\Model\Contact',['name','email','subject']);
        return response()->json($obj->paginate($request));
    }
    public function store(Request $request)
    {
        $createContact = Contact::create($request->all());
        if($createContact)
        {
            return response()->json(['message'=>'created Successfully','error'=>null]);
        }
    }
    public function update(Request $request , $id)
    {
        $data = $request->all();
        $data = array_filter($data,function($i){
            return $i !='PUT';
        });
        $updateContact = Contact::where("id",$id)->update($data);
        if($updateContact)
        {
            return response()->json(['message'=>'update Successfully','error'=>null]);
        }
    }
    public function destroy($id)
    {
        if(Contact::where("id",$id)->delete())
        {
            return response()->json(['message'=>'delete Successfully','error'=>null]);
        }
    }
}
