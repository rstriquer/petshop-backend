<?php

namespace Tests\Feature;

use Illuminate\Http\Response;
use Tests\TestCase;

class SimpleBrowserTest extends TestCase
{
    /**
     * @group web
     * @test
     */
    public function unauthorized_web_browser_access_ok(): void
    {
        $response = $this->get('/');
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
