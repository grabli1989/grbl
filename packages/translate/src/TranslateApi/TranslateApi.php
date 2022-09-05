<?php

namespace Translate\TranslateApi;

use Realty\Interfaces\TranslateApiInterface;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Translate\Exceptions\TranslateException;

class TranslateApi implements TranslateApiInterface
{
    public const AVAILABLE_LANGUAGES = [
        self::LANGUAGES['UKRAINE'] => 'ua',
        self::LANGUAGES['ENGLISH'] => 'en',
        self::LANGUAGES['RUSSIAN'] => 'ru',
    ];

    private GoogleTranslate $translate;

    /**
     * @param  GoogleTranslate  $translate
     */
    public function __construct(GoogleTranslate $translate)
    {
        $this->translate = $translate;
    }

    /**
     * @param  string  $source
     * @param  string  $target
     * @param  string  $text
     * @return string
     *
     * @throws TranslateException
     * @throws \ErrorException
     */
    public function translate(string $source, string $target, string $text): string
    {
        if (! $this->available($source, $target)) {
            throw TranslateException::languageNotAvailable();
        }

        return $this->translate
            ->setSource(self::AVAILABLE_LANGUAGES[$source])
            ->setTarget(self::AVAILABLE_LANGUAGES[$target])
            ->translate($text);
    }

    /**
     * @return string[]
     */
    public function getAvailableLanguages(): array
    {
        return self::AVAILABLE_LANGUAGES;
    }

    /**
     * @param  string  ...$languages
     * @return bool
     */
    private function available(string ...$languages): bool
    {
        foreach ($languages as $lang) {
            if (! array_key_exists($lang, $this->getAvailableLanguages())) {
                return false;
            }
        }

        return true;
    }
}
