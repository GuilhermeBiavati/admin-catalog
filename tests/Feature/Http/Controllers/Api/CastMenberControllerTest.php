<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Http\Resources\CastMenberResource;
use App\Models\CastMenber;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Traits\TestValidations;
use Tests\Traits\TestSaves;
use Tests\TestCase;

class CastMenberControllerTest extends TestCase
{

    use DatabaseMigrations, TestValidations, TestSaves;

    private $castMenber;

    private $serializedFields = [
        'id', 'name', 'type', 'created_at', 'updated_at'
    ];


    protected function setUp(): void
    {
        parent::setUp();
        $this->castMenber = factory(CastMenber::class)->create();
    }

    public function testIndex()
    {
        $response = $this->get(route('cast_menbers.index'));

        $response->assertStatus(200)->assertJson([
            'meta' => ['per_page' => 15]
        ])->assertJsonStructure([
            'data' => [
                '*' => $this->serializedFields
            ],
            'links' => [],
            'meta' => []
        ]);
        $response->assertJson(CastMenberResource::collection(collect([$this->castMenber]))->response()->getData(true));
    }

    public function testShow()
    {
        $response = $this->get(route('cast_menbers.show', $this->castMenber->id));
        $response->assertStatus(200)->assertJsonStructure([
            'data' => $this->serializedFields
        ]);;
    }


    public function testInvalidationData()
    {

        $data = [
            'name' => '',
            'type' => ''
        ];

        $this->assertInvalidationInStoreAction($data, 'required');
        $this->assertInvalidationInUpdateAction($data, 'required');


        $data = [
            'name' => str_repeat('a', 256),
        ];

        $this->assertInvalidationInStoreAction($data, 'max.string', ['max' => 255]);
        $this->assertInvalidationInUpdateAction($data, 'max.string', ['max' => 255]);

        $data = ['type' => 'dsfasdf'];

        $this->assertInvalidationInStoreAction($data, 'in');
        $this->assertInvalidationInUpdateAction($data, 'in');
    }

    public function testStore()
    {

        $data = [
            [
                'name' => 'test',
                'type' => CastMenber::TYPE_ACTOR
            ],
            [
                'name' => 'test',
                'type' => CastMenber::TYPE_DIRECTOR
            ]
        ];

        foreach ($data as $key => $value) {
            $response = $this->assertStore($value, $value + ['deleted_at' => null]);

            $response->assertJsonStructure([
                'data' => $this->serializedFields
            ]);

            $response->assertJson((new CastMenberResource(CastMenber::find($response->json('data.id'))))->response()->getData(true));
        }
    }

    public function testUpdate()
    {
        $this->castMenber = factory(CastMenber::class)->create([
            'type' => CastMenber::TYPE_ACTOR

        ]);

        $data = [
            'name' => 'test',
            'type' => CastMenber::TYPE_DIRECTOR
        ];

        $response = $this->assertUpdate($data, $data + ['deleted_at' => null]);

        $response->assertJsonStructure([
            'data' => $this->serializedFields
        ]);

        $response->assertJson((new CastMenberResource(CastMenber::find($response->json('data.id'))))->response()->getData(true));
    }

    public function testDestroy()
    {
        $this->json('DELETE', route('cast_menbers.destroy', $this->castMenber->id));
        $this->assertSoftDeleted($this->castMenber->getTable(), $this->castMenber->toArray());
    }


    protected function routeStore()
    {
        return route('cast_menbers.store');
    }

    protected function routeUpdate()
    {
        return route('cast_menbers.update', $this->castMenber);
    }

    protected function model()
    {
        return CastMenber::class;
    }
}
