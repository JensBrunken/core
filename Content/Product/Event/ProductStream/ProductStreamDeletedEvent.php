<?php declare(strict_types=1);

namespace Shopware\Content\Product\Event\ProductStream;

use Shopware\Framework\ORM\Write\DeletedEvent;
use Shopware\Framework\ORM\Write\WrittenEvent;
use Shopware\Content\Product\Definition\ProductStreamDefinition;

class ProductStreamDeletedEvent extends WrittenEvent implements DeletedEvent
{
    public const NAME = 'product_stream.deleted';

    public function getName(): string
    {
        return self::NAME;
    }

    public function getDefinition(): string
    {
        return ProductStreamDefinition::class;
    }
}