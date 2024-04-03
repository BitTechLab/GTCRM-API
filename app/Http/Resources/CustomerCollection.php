<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CustomerCollection extends ResourceCollection
{
    // private array $additional;

    // public function __construct($resource, array $additional = []) {
    //     parent::__construct($resource);

    //     $this->additional = $additional;
    // }

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'count' => $this->collection->count(),
            // 'total' => $this->when(!empty($this->additional['total']), $this->additional['total']),
            'data' => $this->collection
        ];
    }
}
