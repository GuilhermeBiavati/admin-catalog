<?php

namespace Tests\Feature\Models;

use App\Models\CastMember;
use Error;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class CastMemberTest extends TestCase
{

    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testList()
    {
        factory(CastMember::class, 1)->create();

        $castMembers = CastMember::all();

        $this->assertCount(1, $castMembers);

        $MemberKey = array_keys($castMembers->first()->getAttributes());

        $this->assertEqualsCanonicalizing([
            'id', 'name', 'type', 'created_at', 'updated_at', 'deleted_at'
        ], $MemberKey);
    }

    public function testCreate()
    {
        $castMember = CastMember::create([
            'name' => 'test1',
            'type' => CastMember::TYPE_DIRECTOR
        ]);

        $this->assertEquals('test1', $castMember->name);
        $this->assertTrue(Uuid::isValid($castMember->id));
        $this->assertEquals(CastMember::TYPE_DIRECTOR, $castMember->type);
    }

    public function testUpdate()
    {
        $castMember = factory(CastMember::class)->create(['type' => CastMember::TYPE_DIRECTOR])->first();

        $data = [
            'name' => 'test_name_updated',
            'type' => CastMember::TYPE_ACTOR
        ];

        $castMember->update($data);


        foreach ($data as $key => $value) {
            $this->assertEquals($value, $castMember->{$key});
        }
    }

    public function testDelete()
    {
        $castMember = factory(CastMember::class)->create()->first();

        $castMember->delete();

        $this->assertSoftDeleted($castMember->getTable(), $castMember->toArray());
    }
}
