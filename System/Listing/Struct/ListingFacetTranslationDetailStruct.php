<?php declare(strict_types=1);

namespace Shopware\System\Listing\Struct;

use Shopware\Application\Language\Struct\LanguageBasicStruct;

class ListingFacetTranslationDetailStruct extends ListingFacetTranslationBasicStruct
{
    /**
     * @var ListingFacetBasicStruct
     */
    protected $listingFacet;

    /**
     * @var LanguageBasicStruct
     */
    protected $language;

    public function getListingFacet(): ListingFacetBasicStruct
    {
        return $this->listingFacet;
    }

    public function setListingFacet(ListingFacetBasicStruct $listingFacet): void
    {
        $this->listingFacet = $listingFacet;
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