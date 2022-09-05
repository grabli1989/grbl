<?php

namespace Translate\Http\Requests;

use Realty\Interfaces\TranslateApiInterface;
use Tests\TestCase;

class TranslateRequestTest extends TestCase
{
    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->sut = new TranslateRequest();
    }

    public function testRules()
    {
        $expected = [
            'source' => 'required|in:'.implode(',', TranslateApiInterface::LANGUAGES),
            'target' => 'required|in:'.implode(',', TranslateApiInterface::LANGUAGES),
            'text' => 'required',
        ];
        $this->assertEquals($expected, $this->sut->rules());
    }

    public function testAuthorize()
    {
        $this->assertTrue($this->sut->authorize());
    }
}
