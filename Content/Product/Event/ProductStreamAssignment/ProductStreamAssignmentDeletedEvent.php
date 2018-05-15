<?php declare(strict_types=1);

namespace Shopware\Content\Product\Event\ProductStreamAssignment;

use Shopware\Framework\ORM\Write\DeletedEvent;
use Shopware\Framework\ORM\Write\WrittenEvent;
use Shopware\Content\Product\Definition\ProductStreamAssignmentDefinition;

class ProductStreamAssignmentDeletedEvent extends WrittenEvent implements DeletedEvent
{
    public const NAME = 'product_stream_assignment.deleted';

    public function getName(): string
    {
        return self::NAME;
    }

    public function getDefinition(): string
    {
        return ProductStreamAssignmentDefinition::class;
    }
}