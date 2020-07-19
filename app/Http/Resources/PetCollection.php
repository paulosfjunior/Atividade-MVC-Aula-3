<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PetCollection extends ResourceCollection
{
    public $collects = 'App\Http\Resources\Pet';

    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
