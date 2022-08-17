<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryCollection extends ResourceCollection {

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        return [
            'data' => [
                'categories' => $this->collection->map(function($data) {
                            return [
                                'id' => $data->id,
                                'title' => $data->title,
                                'description' => $data->description,
                                'parent_id' => $data->parent_id,
                                'created_at' => Carbon::parse($data->created_at)->toDateTimeString(),
                                'updated_at' => Carbon::parse($data->updated_at)->toDateTimeString(),
                                'parent' => $data->parent
                            ];
                        })
            ]
        ];
    }

    public function with($request) {
        return [
            'success' => 1,
            'message' => 'data found'
        ];
    }

}
