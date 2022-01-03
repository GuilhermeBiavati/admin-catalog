<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Http\Resources\CastMemberResource;
use App\Models\CastMember;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Traits\TestValidations;
use Tests\Traits\TestSaves;
use Tests\TestCase;

class CastMemberControllerTest extends TestCase
{

    use DatabaseMigrations, TestValidations, TestSaves;

    private $castMember;

    private $serializedFields = [
        'id', 'name', 'type', 'created_at', 'updated_at'
    ];


    protected function setUp(): void
    {
        parent::setUp();
        $this->castMember = factory(CastMember::class)->create();
    }

    public function testIndex()
    {
        $response = $this->get(route('cast_members.index'));

        $response->assertStatus(200)->assertJson([
            'meta' => ['per_page' => 15]
        ])->assertJsonStructure([
            'data' => [
                '*' => $this->serializedFields
            ],
            'links' => [],
            'meta' => []
        ]);
        $response->assertJson(CastMemberResource::collection(collect([$this->castMember]))->response()->getData(true));
    }

    public function testShow()
    {
        $response = $this->get(route('cast_members.show', $this->castMember->id));
        $response->assertStatus(200)->assertJsonStructure([
            'data' => $this->serializedFields
        ]);
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
                'type' => CastMember::TYPE_ACTOR
            ],
            [
                'name' => 'test',
                'type' => CastMember::TYPE_DIRECTOR
            ]
        ];

        foreach ($data as $key => $value) {
            $response = $this->assertStore($value, $value + ['deleted_at' => null]);

            $response->assertJsonStructure([
                'data' => $this->serializedFields
            ]);

            $response->assertJson((new CastMemberResource(CastMember::find($response->json('data.id'))))->response()->getData(true));
        }
    }

    public function testUpdate()
    {
        $this->castMember = factory(CastMember::class)->create([
            'type' => CastMember::TYPE_ACTOR

        ]);

        $data = [
            'name' => 'test',
            'type' => CastMember::TYPE_DIRECTOR
        ];

        $response = $this->assertUpdate($data, $data + ['deleted_at' => null]);

        $response->assertJsonStructure([
            'data' => $this->serializedFields
        ]);

        $response->assertJson((new CastMemberResource(CastMember::find($response->json('data.id'))))->response()->getData(true));
    }

    public function testDestroy()
    {
        $this->json('DELETE', route('cast_members.destroy', $this->castMember->id));
        $this->assertSoftDeleted($this->castMember->getTable(), $this->castMember->toArray());
    }


    protected function routeStore()
    {
        return route('cast_members.store');
    }

    protected function routeUpdate()
    {
        return route('cast_members.update', $this->castMember);
    }

    protected function model()
    {
        return CastMember::class;
    }
}
