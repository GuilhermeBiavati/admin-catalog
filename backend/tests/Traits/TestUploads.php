<?php

declare(strict_types=1);

namespace Tests\Traits;

use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Http\UploadedFile;
use Lang;
use Storage;

trait TestUploads
{


  protected function assertInvalidationFile($field, $extension, $maxSize, $rule, array $ruleParams = [])
  {
    $routes = [
      [
        'method' => 'POST',
        'route' => $this->routeStore()
      ],
      [
        'method' => 'PUT',
        'route' => $this->routeUpdate(),
      ]
    ];
    foreach ($routes as $route) {
      $file = UploadedFile::fake()->create("$field.1$extension");
      $response = $this->json($route['method'], $route['route'], [
        $field => $file
      ]);
      $this->assertInvalidationFields($response, [$field], $rule, $ruleParams);
      $file = UploadedFile::fake()->create("$field.$extension")->size($maxSize + 1);
      $response = $this->json($route['method'], $route['route'], [
        $field => $file
      ]);
      $this->assertInvalidationFields($response, [$field], 'max.file', ['max' => $maxSize]);
    }
  }

  protected function assertFilesExistsInStorage($model, array $files)
  {
    foreach ($files as $file) {
      Storage::assertExists($model->relativeFilePath($file->hashName()));
    }
  }
}
