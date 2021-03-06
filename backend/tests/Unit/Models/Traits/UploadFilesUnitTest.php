<?php

namespace Tests\Unit\Models\Traits;

use Illuminate\Http\UploadedFile;
use Storage;
use Tests\TestCase;
use Tests\Stubs\Models\UploadFileStub;

class UploadFilesUnitTest extends TestCase
{
    private $object;

    protected function setUp(): void
    {
        parent::setUp();
        $this->object = new UploadFileStub();
    }

    public function testRelativePath()
    {
        $this->assertEquals('1/video.mp4', $this->object->relativeFilePath('video.mp4'));
    }

    public function testUploadFile()
    {
        Storage::fake();
        $file = UploadedFile::fake()->create('video.mp4');
        $this->object->uploadFile($file);
        Storage::assertExists("1/{$file->hashName()}");
    }


    public function testUploadFiles()
    {
        Storage::fake();
        $file = UploadedFile::fake()->create('video.mp4');
        $file2 = UploadedFile::fake()->create('video.mp4');
        $this->object->uploadFiles([$file, $file2]);
        Storage::assertExists("1/{$file->hashName()}");
        Storage::assertExists("1/{$file2->hashName()}");
    }

    public function testDeleteOldFiles()
    {
        Storage::fake();
        $file1 = UploadedFile::fake()->create('video1.mp4')->size(1);
        $file2 = UploadedFile::fake()->create('video2.mp4')->size(1);
        $this->object->uploadFiles([$file1, $file2]);
        $this->object->deleteOldFiles();
        $this->assertCount(2, Storage::allFiles());

        $this->object->oldFiles = [$file1->hashName()];
        $this->object->deleteOldFiles();
        Storage::assertMissing("1/{$file1->hashName()}");
        Storage::assertExists("1/{$file2->hashName()}");
    }


    public function testDeleteFile()
    {
        Storage::fake();
        $file = UploadedFile::fake()->create('video.mp4');
        $this->object->uploadFile($file);
        $fileName = $file->hashName();
        $this->object->deleteFile($fileName);
        Storage::assertMissing("1/{$fileName}");

        $file = UploadedFile::fake()->create('video.mp4');
        $this->object->uploadFile($file);
        $this->object->deleteFile($file);
        Storage::assertMissing("1/{$file->hashName()}");
    }

    public function testDeleteFiles()
    {
        Storage::fake();
        $file = UploadedFile::fake()->create('video.mp4');
        $file2 = UploadedFile::fake()->create('video.mp4');

        $this->object->uploadFiles([$file, $file2]);
        $this->object->deleteFiles([$file->hashName(), $file2]);

        Storage::assertMissing("1/{$file->hashName()}");
        Storage::assertMissing("1/{$file2->hashName()}");
    }

    public function testExtractFiles()
    {
        $attributes = [];
        $files = UploadFileStub::extractFiles($attributes);
        $this->assertCount(0, $attributes);
        $this->assertCount(0, $files);

        $attributes = ['file' => 'test'];
        $files = UploadFileStub::extractFiles($attributes);
        $this->assertCount(1, $attributes);
        $this->assertEquals(['file' => 'test'], $attributes);
        $this->assertCount(0, $files);

        $attributes = ['file' => 'test', 'file2' => 'test'];
        $files = UploadFileStub::extractFiles($attributes);
        $this->assertCount(2, $attributes);
        $this->assertEquals(['file' => 'test', 'file2' => 'test'], $attributes);
        $this->assertCount(0, $files);

        $file1 = UploadedFile::fake()->create('video1.mp4');
        $attributes = ['file' => $file1, 'other' => 'test'];
        $files = UploadFileStub::extractFiles($attributes);
        $this->assertCount(2, $attributes);
        $this->assertEquals(['file' => $file1->hashName(), 'other' => 'test'], $attributes);
        $this->assertEquals([$file1], $files);

        $file2 = UploadedFile::fake()->create('video1.mp4');
        $attributes = ['file' => $file1, 'file2' => $file2, 'other' => 'test'];
        $files = UploadFileStub::extractFiles($attributes);
        $this->assertCount(3, $attributes);
        $this->assertEquals(['file' => $file1->hashName(), 'file2' => $file2->hashName(), 'other' => 'test'], $attributes);
        $this->assertEquals([$file1, $file2], $files);
    }
}
