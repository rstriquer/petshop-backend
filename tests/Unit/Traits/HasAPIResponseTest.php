<?php

namespace Tests\Unit\Traits;

use App\Models\User;
use App\Traits\HasAPIResponse;
use App\Transformers\AdminUserList;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Mockery;
use Tests\TestCase;

class HasAPIResponseTest extends TestCase
{
    public $test;

    public function setUp() : void
    {
        parent::setUp();

        $this->test = new class {
            use HasAPIResponse;
        };
    }
    /**
     * @group APIBaseResponse
     * @test
     */
    public function replyNoContentOk()
    {
        $exp = null;

        $this->test = new class {
            use HasAPIResponse;
        };

        $resp = $this->test->replyNoContent();

        $result = $resp->getOriginalContent();

        $this->assertEquals($exp, $result);
        $this->assertEquals(Response::HTTP_NO_CONTENT, $resp->getStatusCode());
    }
    /**
     * @group APIBaseResponse
     * @test
     */
    public function replyCreatedOk()
    {
        $exp = null;

        $resp = $this->test->replyCreated();

        $result = $resp->getOriginalContent();

        $this->assertEquals($exp, $result);
        $this->assertEquals(Response::HTTP_CREATED, $resp->getStatusCode());
    }
    /**
     * @group APIBaseResponse
     * @test
     */
    public function replyOkCollectionWhenListIsEmptyOk()
    {
        $exp = null;

        $payload = Mockery::mock(Collection::class)->makePartial();
        $payload->shouldReceive('isEmpty')->andReturn(true);

        $resp = $this->test->replyOkCollection($payload, app(AdminUserList::class));

        $result = $resp->getOriginalContent();
        $this->assertEquals($exp, $result);
        $this->assertEquals(Response::HTTP_NO_CONTENT, $resp->getStatusCode());
    }
    /**
     * @group APIBaseResponse
     * @test
     */
    public function replyOkCollectionWhenListWithDataOk()
    {
        
        $payload = User::factory(2)->make();

        // $payload = app(Collection::Class);

        // $payload->push($users[0]);
        // $payload->push($users[1]);

        $exp = ['users' => [
            0 => $payload[0]->toArray(),
            1 => $payload[1]->toArray(),
        ]];

        $resp = $this->test->replyOkCollection(
            $payload,
            app(AdminUserList::class)
        );
        $result = $resp->getOriginalContent();

        $this->assertEquals($exp, $result);
        $this->assertEquals(Response::HTTP_OK, $resp->getStatusCode());
    }
}
