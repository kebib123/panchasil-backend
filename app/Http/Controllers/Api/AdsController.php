<?php

namespace App\Http\Controllers\Api;

use App\Helper\Pagination;
use App\Http\Controllers\Controller;
use App\Model\Ads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class AdsController extends Controller
{
    public function index(Request $request)
    {
        $obj = new Pagination("\App\Model\Ads", ['placeholder']);
        return response()->json($obj->paginate($request));
    }

    public function show($id)
    {
        $ad = Ads::findOrFail($id);
        return response()->json([
            'ad' => $ad,
        ], 200);
    }

    public function store(Request $request)
    {
        $data['placeholder'] = $request->placeholder;
        if ($request->hasFile('ads_image')) {
            $image = $request->file('ads_image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/ads');
            $image->move($destinationPath, $name);
            $data['ads_image'] = URL::to('/') . "/images/ads/" . $name;
        }
        $createAds = Ads::create($data);
        if ($createAds) {
            return response()->json(["message" => "successfully ads created", "error" => null]);
        }
    }
    public function update(Request $request, $id)
    {
        $data['placeholder'] = $request->placeholder;
        if ($request->hasFile('ads_image')) {
            $image = $request->file('ads_image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/ads');
            $image->move($destinationPath, $name);
            $data['ads_image'] = URL::to('/') . "/images/ads/" . $name;
        }
        $updateAds = Ads::where('id', $id)->update($data);
        if ($updateAds) {
            return response()->json(["message" => "successfully ads updated", "error" => null]);
        }
    }
    public function destroy($id)
    {
        $destroyAds = Ads::where('id', $id)->delete();
        if ($destroyAds) {
            return response()->json(["message" => "deleted", "error" => null]);
        }
    }
}
