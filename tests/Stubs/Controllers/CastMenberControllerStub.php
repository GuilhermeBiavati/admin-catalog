<?php

namespace Tests\Stubs\Controllers;

use App\Http\Controllers\Api\BasicCrudController;
use App\Http\Resources\CastMenberResource;
use App\Models\CastMenber;
use Tests\Stubs\Models\CastMenberStub;

class CastMenberControllerStub extends BasicCrudController
{

    private $rules;

    public function __construct()
    {
        $this->rules = [
            'name' => 'required|max:255',
            'type' => 'required|in:' . implode(',', [CastMenber::TYPE_ACTOR, CastMenber::TYPE_DIRECTOR])
        ];
    }

    protected function model()
    {
        return CastMenberStub::class;
    }

    protected function rulesStore()
    {
        return $this->rules;
    }

    protected function rulesUpdate()
    {
        return $this->rules;
    }

    protected function resourceCollection()
    {
        return $this->resource();
    }

    protected function resource()
    {
        return CastMenberResource::class;
    }
}
