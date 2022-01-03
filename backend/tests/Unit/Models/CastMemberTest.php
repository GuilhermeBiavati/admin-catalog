<?php

namespace Tests\Unit\Models;

use App\Models\CastMember;
use PHPUnit\Framework\TestCase;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\Uuid;

class CastMemberTest extends TestCase
{
    private $Member;

    protected function setUp(): void
    {
        parent::setUp();
        $this->Member = new CastMember();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testFillableAttribute()
    {
        $fillable = ['name', 'type'];

        $this->assertEquals($fillable, $this->Member->getFillable());
    }

    public function testIfUseTraitsAttribute()
    {
        $traits = [
            SoftDeletes::class, Uuid::class
        ];

        $MemberTraits = array_keys(class_uses(CastMember::class));
        $this->assertEquals($traits, $MemberTraits);
    }

    public function testCastsAttribute()
    {
        $casts = ['id' => 'string'];

        $this->assertEquals($casts, $this->Member->getCasts());
    }

    public function testIncrementingAttribute()
    {

        $this->assertFalse($this->Member->incrementing);
    }

    public function testDatesAttribute()
    {
        $dates = ['created_at', 'updated_at', 'deleted_at'];
        foreach ($dates as $date) {
            $this->assertContains($date, $this->Member->getDates());
        }
        $this->assertCount(count($dates), $this->Member->getDates());
    }
}
