<?php

namespace Translate\Http\Controllers;

use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;
use Tests\WithAuthTrait;
use Translate\TranslateApi\TranslateApi;

class TranslateControllerTest extends TestCase
{
    use WithAuthTrait;

    public function testTranslate()
    {
        $token = $this->getToken($this->getUsualTestUser());

        $data = [
            'source' => 'english',
            'target' => 'ukraine',
            'text' => 'hello',
        ];

        $response = $this->post(route('translate.translate'), $data, [
            'Authorization' => "Bearer $token",
        ]);

        $this->assertEquals('success', $response->original['status']);
        $this->assertEquals('привіт', $response->original['result']);
        $response->assertStatus(200);
    }

    public function testShouldThrowTranslateException()
    {
        $token = $this->getToken($this->getUsualTestUser());

        $data = [
            'source' => 'english',
            'target' => 'poland',
            'text' => 'hello',
        ];

        $response = $this->post(route('translate.translate'), $data, [
            'Authorization' => "Bearer $token",
            'Content-type' => 'application/json',
            'Accept' => 'application/json',
        ]);
        $response->assertStatus(422);
    }

    /**
     * @return void
     */
    public function testShouldThrowErrorException(): void
    {
        $data = [
            'source' => 'english',
            'target' => 'ukraine',
            'text' => 'hello',
        ];

        $token = $this->getToken($this->getUsualTestUser());
        $translateApiMock = $this->makeAndConfigureMock($data);
        $this->bindMock(TranslateApi::class, $translateApiMock);

        $response = $this->post(route('translate.translate'), $data, [
            'Authorization' => "Bearer $token",
        ]);

        $this->assertEquals('error', $response->original['status']);
        $this->assertEquals('Something went wrong', $response->original['message']);
        $response->assertStatus(200);
    }

    /**
     * @param  array  $data
     * @return MockObject|TranslateApi
     */
    private function makeAndConfigureMock(array $data): TranslateApi|MockObject
    {
        $translateApiMock = $this->createMock(TranslateApi::class);
        $translateApiMock->expects($this->any())->method('translate')
            ->with($data['source'], $data['target'], $data['text'])
            ->will($this->throwException(new \ErrorException()));

        return $translateApiMock;
    }
}
