<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use App\Http\Requests\BrandRequest;

class BrandsController extends Controller {

    public function __construct() {
        $this->middleware('super_admin_check:store-update-destroy');
    }

    public function index(Request $request) {
        $brands = $this->filterAndResponse($request);

        return response()->json(['brands' => $brands], Response::HTTP_OK);
    }

    public function store(Request $request) {
        $rules = [
            'title' => 'required'
        ];
        $validator = Validator::make($request->only('title'), $rules);

        if ($validator->fails()) {
            return response()->json(['success' => 0, 'message' => 'Please fix these errors', 'errors' => $validator->errors()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $brand = Brand::create($request->all());

        return response()->json(['success' => 1, 'message' => 'Created successfully', 'brand' => $brand], Response::HTTP_CREATED);
    }

    public function show($id) {
        $brand = Brand::findOrFail($id);

        return response()->json(['brand' => $brand], Response::HTTP_OK);
    }

    public function update(Request $request, $id) {
//        echo "<pre>";print_r($request->all());exit;
        $brand = Brand::findOrFail($id);

        $validator = Validator::make($request->only('title'), [
                    'title' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => 0, 'message' => 'Please fix these errors', 'errors' => $validator->errors()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $brand->title = $request->input('title');
        if ($brand->save()) {
            return response()->json(['success' => 1, 'message' => 'Updated successfully', 'brand' => $brand], Response::HTTP_OK);
        }
    }

    public function destroy($id) {
        $brand = Brand::findOrFail($id);
        if ($brand->delete()) {
            return response()->json(['success' => 1, 'message' => 'Deleted successfully'], Response::HTTP_OK);
        }
    }

    /**
     * @param Request $request
     */
    protected function filterAndResponse(Request $request) {
        $query = Brand::whereRaw("1=1");

        if ($request->has('all')) {
            return $query->get();
        }

        if ($request->id) {
            $query->where('id', $request->id);
        }

        if ($request->title) {
            $query->where('title', 'like', "%" . $request->title . "%");
        }

        $brands = $query->paginate(5);

        return $brands;
    }

}
