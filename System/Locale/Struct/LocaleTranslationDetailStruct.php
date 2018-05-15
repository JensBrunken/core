<?php declare(strict_types=1);

namespace Shopware\System\Locale\Struct;

use Shopware\Application\Language\Struct\LanguageBasicStruct;

class LocaleTranslationDetailStruct extends LocaleTranslationBasicStruct
{
    /**
     * @var LocaleBasicStruct
     */
    protected $locale;

    /**
     * @var LanguageBasicStruct
     */
    protected $language;

    public function getLocale(): LocaleBasicStruct
    {
        return $this->locale;
    }

    public function setLocale(LocaleBasicStruct $locale): void
    {
        $this->locale = $locale;
    }

    public function getLanguage(): LanguageBasicStruct
    {
        return $this->language;
    }

    public function setLanguage(LanguageBasicStruct $language): void
    {
        $this->language = $language;
    }
}