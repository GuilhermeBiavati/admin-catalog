<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\GenreResource;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GenreController extends BasicCrudController
{
    private $rules = [
        'name' => 'required|max:255',
        'is_active' => 'boolean',
        'categories_id' => 'required|array|exists:categories,id,deleted_at,NULL'
    ];

    protected function model()
    {
        return Genre::class;
    }

    public function store(Request $request)
    {
        $validated = $this->validate($request, $this->rulesStore());
        $self = $this;
        $genre = DB::transaction(function () use ($validated, $self) {
            $genre = Genre::create($validated);
            $self->handleRelations($genre, $validated);
            return $genre;
        });

        return new GenreResource($genre->refresh());
    }

    public function update(Request $request, $id)
    {
        $genre = $this->findOrFail($id);
        $validated = $this->validate($request, $this->rulesUpdate());
        $self = $this;
        $genre = DB::transaction(function () use ($validated, $self, $genre) {
            $genre->update($validated);
            $self->handleRelations($genre, $validated);
            return $genre;
        });
        return new GenreResource($genre);
    }

    protected function handleRelations($video, $validated)
    {
        $video->categories()->sync($validated['categories_id']);
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
        return GenreResource::class;
    }
}
