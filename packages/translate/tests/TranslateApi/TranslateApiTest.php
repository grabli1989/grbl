<?php

namespace Translate\TranslateApi;

use ErrorException;
use Realty\Interfaces\TranslateApiInterface;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Tests\TestCase;
use Translate\Exceptions\TranslateException;

class TranslateApiTest extends TestCase
{
    private TranslateApi $sut;

    protected function setUp(): void
    {
        parent::setUp();
        $googleApiTranslate = $this->createMock(GoogleTranslate::class);
        $this->sut = new TranslateApi($googleApiTranslate);
    }

    /**
     * @throws ErrorException
     */
    public function testTranslateWillBeThrowNotAvailableLanguage()
    {
        $this->expectException(TranslateException::class);
        $this->expectExceptionMessage('Language not available');
        $this->sut->translate(TranslateApiInterface::LANGUAGES['ENGLISH'], 'qwerty', 'hello');
    }

    /**
     * @group external-service
     *
     * @return void
     *
     * @throws TranslateException
     * @throws ErrorException
     */
    public function testTranslate(): void
    {
        $this->sut = $this->app->make(TranslateApiInterface::class);

        $expectPhrase = 'Привіт';
        $actualPhrase = $this->sut->translate(
            TranslateApiInterface::LANGUAGES['ENGLISH'],
            TranslateApiInterface::LANGUAGES['UKRAINE'],
            'Hello'
        );

        $this->assertEquals($expectPhrase, $actualPhrase);
    }
}
