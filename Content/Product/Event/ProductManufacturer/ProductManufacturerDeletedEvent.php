<?php declare(strict_types=1);

namespace Shopware\Content\Product\Event\ProductManufacturer;

use Shopware\Framework\ORM\Write\DeletedEvent;
use Shopware\Framework\ORM\Write\WrittenEvent;
use Shopware\Content\Product\Definition\ProductManufacturerDefinition;

class ProductManufacturerDeletedEvent extends WrittenEvent implements DeletedEvent
{
    public const NAME = 'product_manufacturer.deleted';

    public function getName(): string
    {
        return self::NAME;
    }

    public function getDefinition(): string
    {
        return ProductManufacturerDefinition::class;
    }
}