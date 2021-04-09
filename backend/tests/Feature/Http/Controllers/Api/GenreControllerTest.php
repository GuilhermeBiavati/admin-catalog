<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Http\Controllers\Api\GenreController;
use App\Http\Requests\GenreRequest;
use App\Http\Resources\GenreResource;
use App\Models\Category;
use App\Models\Genre;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Request;
use Tests\Exceptions\TestException;
use Tests\TestCase;
use Tests\Traits\TestSaves;
use Tests\Traits\TestValidations;

class GenreControllerTest extends TestCase
{

    use DatabaseMigrations, TestValidations, TestSaves;

    private $genre;
    private $category;

    private $serializedFields = [
        'id',
        'name',
        'is_active',
        'created_at',
        'updated_at',
        'categories' => [
            '*' => [
                'id',
                'name',
                'description',
                'is_active',
                'created_at',
                'updated_at'
            ]
        ]
    ];


    protected function setUp(): void
    {
        parent::setUp();
        $this->genre = factory(Genre::class)->create();
        $this->category = factory(Category::class)->create();
    }

    public function testIndex()
    {

        $response = $this->get(route('genres.index'));
        $response->assertStatus(200)->assertJson([
            'meta' => ['per_page' => 15]
        ])
            ->assertJsonStructure([
                'data' => [
                    '*' => $this->serializedFields
                ],
                'links' => [],
                'meta' => []
            ]);

        $response->assertJson(GenreResource::collection(collect([$this->genre]))->response()->getData(true));
    }

    public function testShow()
    {
        $response = $this->get(route('genres.show', $this->genre->id));
        $response->assertStatus(200)->assertJsonStructure([
            'data' => $this->serializedFields
        ]);
    }


    public function testInvalidationData()
    {

        $data = [
            'name' => '',
            'categories_id' => ''
        ];

        $this->assertInvalidationInStoreAction($data, 'required');
        $this->assertInvalidationInUpdateAction($data, 'required');

        $data = [
            'name' => str_repeat('a', 256)
        ];

        $this->assertInvalidationInStoreAction($data, 'max.string', ['max' => 255]);
        $this->assertInvalidationInUpdateAction($data, 'max.string', ['max' => 255]);

        $data = ['is_active' => 'a'];

        $this->assertInvalidationInStoreAction($data, 'boolean');
        $this->assertInvalidationInUpdateAction($data, 'boolean');

        $data = [
            'categories_id' => 'a',
        ];

        $this->assertInvalidationInStoreAction($data, 'array');
        $this->assertInvalidationInUpdateAction($data, 'array');

        $data = [
            'categories_id' => [100],
        ];

        $this->assertInvalidationInStoreAction($data, 'exists');
        $this->assertInvalidationInUpdateAction($data, 'exists');

        $category = factory(Category::class)->create();
        $category->delete();

        $data = [
            'categories_id' => [$category->id],
        ];

        $this->assertInvalidationInStoreAction($data, 'exists');
        $this->assertInvalidationInUpdateAction($data, 'exists');
    }

    public function testStore()
    {
        $data = [
            'name' => 'test',
        ];

        $response = $this->assertStore($data + ['categories_id' => [$this->category->id]],  $data + ['is_active' => true, 'deleted_at' => null]);

        $this->assertHasCategory($response->json('data.id'), $this->category->id);

        $response->assertJsonStructure([
            'data' => $this->serializedFields
        ]);

        $response->assertJson((new GenreResource(Genre::find($response->json('data.id'))))->response()->getData(true));


        $data = [
            'name' => 'test',
            'is_active' => false
        ];

        $this->assertStore($data + ['categories_id' => [$this->category->id]],  $data + ['is_active' => false]);
    }

    public function testUpdate()
    {

        $data = [
            'name' => 'test',
            'is_active' => true
        ];

        $response = $this->assertUpdate($data + ['categories_id' => [$this->category->id]], $data + ['deleted_at' => null]);

        $this->assertHasCategory($response->json('data.id'), $this->category->id);

        $response->assertJsonStructure([
            'data' => $this->serializedFields
        ]);

        $response->assertJson((new GenreResource(Genre::first()))->response()->getData(true));
    }

    public function assertHasCategory($genreId, $categoryId)
    {
        $this->assertDatabaseHas('category_genre', [
            'genre_id' => $genreId,
            'category_id' => $categoryId
        ]);
    }

    public function testSyncCategories()
    {
        $categoriesId = factory(Category::class, 3)->create()->pluck('id')->toArray();
        $sendData = [
            'name' => 'test',
            'categories_id' => [$categoriesId[0]]
        ];
        $response = $this->json('POST', $this->routeStore(), $sendData);
        $this->assertDatabaseHas('category_genre', ['category_id' => $categoriesId[0], 'genre_id' => $response->json('data.id')]);
        $sendData = [
            'name' => 'test',
            'categories_id' => [$categoriesId[1], $categoriesId[2]]
        ];
        $response = $this->json('PUT', route('genres.update', ['genre' => $response->json('data.id')]), $sendData);
        $this->assertDatabaseMissing('category_genre', [
            'category_id' => $categoriesId[0],
            'genre_id' => $response->json('data.id')
        ]);

        $this->assertDatabaseHas('category_genre', [
            'category_id' => $categoriesId[1],
            'genre_id' => $response->json('data.id')
        ]);

        $this->assertDatabaseHas('category_genre', [
            'category_id' => $categoriesId[2],
            'genre_id' => $response->json('data.id')
        ]);
    }

    public function testRollbackStore()
    {
        $request = \Mockery::mock(Request::class);
        $controller = \Mockery::mock(GenreController::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $controller->shouldReceive('validate')->withAnyArgs()->andReturn(['name' => 'test']);
        $controller->shouldReceive('rulesStore')->withAnyArgs()->andReturn([]);

        $controller->shouldReceive('handleRelations')->once()->andThrow(new TestException());

        $hasError = false;
        try {
            $controller->store($request);
        } catch (TestException $exception) {
            $this->assertCount(1, Genre::all());
            $hasError = true;
        }

        $this->assertTrue($hasError);
    }

    public function testRollbackUpdate()
    {
        $request = \Mockery::mock(Request::class);
        $controller = \Mockery::mock(GenreController::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $controller->shouldReceive('findOrFail')->withAnyArgs()->andReturn($this->genre);
        $controller->shouldReceive('validate')->withAnyArgs()->andReturn(['name' => 'test', 'is_active' => false]);
        $controller->shouldReceive('rulesUpdate')->withAnyArgs()->andReturn([]);
        $controller->shouldReceive('handleRelations')->once()->andThrow(new TestException());
        $hasError = false;
        try {
            $controller->update($request, 10);
        } catch (TestException $exception) {
            $this->assertCount(1, Genre::all());
            $hasError = true;
        }
        $this->assertTrue($hasError);
    }

    public function testDestroy()
    {
        $this->json('DELETE', route('genres.destroy', $this->genre->id));
        $this->assertSoftDeleted($this->genre->getTable(), $this->genre->toArray());
    }


    protected function routeStore()
    {
        return route('genres.store');
    }

    protected function routeUpdate()
    {
        return route('genres.update', $this->genre);
    }

    protected function model()
    {
        return Genre::class;
    }
}
