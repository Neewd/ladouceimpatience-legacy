<?php

namespace App\Http\Resources;

use App\Thematic;
use App\Http\Resources\BrandResource;
use App\Http\Resources\ProductImagesResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * //'thematic' => Thematic::where('name', '=', $request->thematic),
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
                'id' => $this->id,
                'name' => $this->name,
                'range' => $this->range,
                'available_stock' => $this->available_stock,
                'image_primary' => new ProductImagesResource($this->images->where('type', '=', 'primary')->first()),
                'image_secondary' => new ProductImagesResource($this->images->where('type', '=', 'secondary')->first()),
                'images' => ProductImagesResource::collection($this->images),
                'brand' => new BrandResource($this->brand),
                'primary_thematic' => $this->primaryThematic->first(),
                'thematics' => $this->thematics,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
        ];
    }
}
