<?php

namespace Tests\Stubs\Controllers;

use App\Http\Controllers\Api\BasicCrudController;
use Tests\Stubs\Models\GenreStub;
use Tests\Stubs\Resources\GenreResourceStub;

class GenreControllerStub extends BasicCrudController
{

    private $rules = [
        'name' => 'required|max:255',
        'is_active' => 'boolean'
    ];

    protected function model()
    {
        return GenreStub::class;
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
        return GenreResourceStub::class;
    }
}
