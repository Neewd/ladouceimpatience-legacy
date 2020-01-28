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
                'available_stock' => $this->available_stock > 0 ? true : false,
                'image_primary' => new ProductImagesResource($this->images->where('type', '=', 'primary')->first()),
                'image_secondary' => new ProductImagesResource($this->images->where('type', '=', 'secondary')->first()),
                'images' => ProductImagesResource::collection($this->images),
                'brand' => new BrandResource($this->brand),
                'primary_thematic' => $this->primaryThematic->first(),
                'thematics' => $this->thematics,
                'description' => $this->description,
                'caracteristics' => $this->caracteristics,
                'labels' => $this->labels,
                'advices' => $this->advices
        ];
    }
}
