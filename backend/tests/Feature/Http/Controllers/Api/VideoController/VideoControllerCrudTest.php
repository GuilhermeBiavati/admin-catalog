<?php

namespace Tests\Feature\Http\Controllers\Api\VideoController;

use App\Http\Resources\VideoResource;
use App\Models\Video;
use Arr;
use Tests\Traits\TestValidations;
use Tests\Traits\TestSaves;

class VideoControllerCrudTest extends BaseVideoControllerTestCase
{

    use TestValidations, TestSaves;

    private $serializedFields = [
        'id',
        'title',
        'description',
        'year_lauched',
        'opened',
        'rating',
        'duration',
        'video_file_url',
        'thumb_file_url',
        'banner_file_url',
        'trailer_file_url',
        'created_at',
        'updated_at',
        'categories' => [
            '*' => [
                'id', 'name', 'description', 'is_active', 'created_at', 'updated_at'
            ]
        ],
        'genres' => [
            '*' => [
                'id', 'name', 'is_active', 'created_at', 'updated_at'
            ]
        ]
    ];

    public function testIndex()
    {
        $response = $this->get(route('videos.index'));
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
        $response->assertJson(VideoResource::collection(collect([$this->video]))->response()->getData(true));
        // $this->assertIfFilesUrlExists($this->video, $response);
    }

    public function testShow()
    {
        $response = $this->get(route('videos.show', $this->video->id));
        $response->assertStatus(200)->assertJsonStructure([
            'data' => $this->serializedFields
        ]);
        // $this->assertIfFilesUrlExists($this->video, $response);
    }


    public function testInvalidationRequired()
    {
        $data = [
            'title' => '',
            'description' => '',
            'year_lauched' => '',
            'rating' => '',
            'duration' => '',
            'categories_id' => '',
            'genres_id' => '',
        ];

        $this->assertInvalidationInStoreAction($data, 'required');
        $this->assertInvalidationInUpdateAction($data, 'required');
    }

    public function testInvalidationMax()
    {
        $data = [
            'title' => str_repeat('a', 256),
        ];

        $this->assertInvalidationInStoreAction($data, 'max.string', ['max' => 255]);
        $this->assertInvalidationInUpdateAction($data, 'max.string', ['max' => 255]);
    }

    public function testInvalidationInteger()
    {
        $data = [
            'duration' => 'fsdaf',
        ];

        $this->assertInvalidationInStoreAction($data, 'integer');
        $this->assertInvalidationInUpdateAction($data, 'integer');
    }


    public function testInvalidationLauchedField()
    {
        $data = [
            'year_lauched' => 'fsdaf',
        ];

        $this->assertInvalidationInStoreAction($data, 'date_format', ['format' => 'Y']);
        $this->assertInvalidationInUpdateAction($data, 'date_format', ['format' => 'Y']);
    }

    public function testInvalidationOpenedField()
    {
        $data = [
            'opened' => 'fsdaf',
        ];

        $this->assertInvalidationInStoreAction($data, 'boolean');
        $this->assertInvalidationInUpdateAction($data, 'boolean');
    }

    public function testInvalidationRatingField()
    {
        $data = [
            'rating' => 'fsdaf',
        ];

        $this->assertInvalidationInStoreAction($data, 'in');
        $this->assertInvalidationInUpdateAction($data, 'in');
    }

    public function testInvalidationCategoriesIdField()
    {
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
    }

    public function testInvalidationGenresIdField()
    {
        $data = [
            'genres_id' => 'a'
        ];

        $this->assertInvalidationInStoreAction($data, 'array');
        $this->assertInvalidationInUpdateAction($data, 'array');

        $data = [
            'genres_id' => [100]
        ];

        $this->assertInvalidationInStoreAction($data, 'exists');
        $this->assertInvalidationInUpdateAction($data, 'exists');
    }

    public function testStore()
    {
        $testData = Arr::except($this->sendData, ['categories_id', 'genres_id']);

        $response = $this->assertStore($this->sendData, $testData);

        $response->assertJsonStructure([
            'data' => $this->serializedFields
        ]);

        $response->assertJson((new VideoResource(Video::find($response->json('data.id'))))->response()->getData(true));
        // $this->assertIfFilesUrlExists($this->video, $response);

        $this->assertStore($this->sendData + ['opened' => true], $testData + ['opened' => true]);
        $this->assertStore($this->sendData + ['rating' => Video::RATING_LIST[1]], $testData + ['rating' => Video::RATING_LIST[1]]);
    }

    public function testUpdate()
    {
        $testData = Arr::except($this->sendData, ['categories_id', 'genres_id']);
        $response = $this->assertUpdate($this->sendData, $testData);
        $response->assertJsonStructure([
            'data' => $this->serializedFields
        ]);
        $response->assertJson((new VideoResource(Video::find($response->json('data.id'))))->response()->getData(true));
        // $this->assertIfFilesUrlExists($this->video, $response);
        $this->assertUpdate($this->sendData + ['opened' => true], $testData + ['opened' => true]);
        $this->assertUpdate($this->sendData + ['rating' => Video::RATING_LIST[1]], $testData + ['rating' => Video::RATING_LIST[1]]);
    }

    public function testDestroy()
    {
        $this->json('DELETE', route('videos.destroy', $this->video->id));
        $this->assertSoftDeleted($this->video->getTable(), $this->video->toArray());
    }
}
