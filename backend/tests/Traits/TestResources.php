<?php

declare(strict_types=1);

namespace Tests\Traits;

use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Lang;

trait TestResources
{

  protected function assertInvalidationInStoreAction(TestResponse $response, JsonResource $resource)
  {
    $response->assertJson($resource->response()->getData(true));
  }
}
