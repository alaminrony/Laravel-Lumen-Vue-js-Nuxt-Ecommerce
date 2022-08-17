<?php

namespace App\Http\Resources;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class SingleCategory extends JsonResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
       
        return [
            "data" => [
                "category" => [
                    'id' => $this->id,
                    'title' => $this->title,
                    'description' => $this->description,
                    'parent_id' => $this->parent_id,
                    'created_at' => Carbon::parse($this->created_at)->toDateTimeString(),
                    'updated_at' => Carbon::parse($this->updated_at)->toDateTimeString(),
                    'parent' => $this->parent,
                    'features' => $this->features
                ]
            ]
        ];
    }
    
    public function with($request){
        return [
            "success" => 1,
            "message" => 'data found'
        ];
    }

}
