<?php declare(strict_types=1);

namespace Shopware\Core\Checkout\Shipping;

use Shopware\Core\Framework\Context;
use Shopware\Core\Checkout\Shipping\Collection\ShippingMethodBasicCollection;
use Shopware\Core\Checkout\Shipping\Collection\ShippingMethodDetailCollection;
use Shopware\Core\Checkout\Shipping\Event\ShippingMethodAggregationResultLoadedEvent;
use Shopware\Core\Checkout\Shipping\Event\ShippingMethodBasicLoadedEvent;
use Shopware\Core\Checkout\Shipping\Event\ShippingMethodDetailLoadedEvent;
use Shopware\Core\Checkout\Shipping\Event\ShippingMethodIdSearchResultLoadedEvent;
use Shopware\Core\Checkout\Shipping\Event\ShippingMethodSearchResultLoadedEvent;
use Shopware\Core\Checkout\Shipping\Struct\ShippingMethodSearchResult;
use Shopware\Core\Framework\ORM\Read\EntityReaderInterface;
use Shopware\Core\Framework\ORM\RepositoryInterface;
use Shopware\Core\Framework\ORM\Search\AggregatorResult;
use Shopware\Core\Framework\ORM\Search\Criteria;
use Shopware\Core\Framework\ORM\Search\EntityAggregatorInterface;
use Shopware\Core\Framework\ORM\Search\EntitySearcherInterface;
use Shopware\Core\Framework\ORM\Search\IdSearchResult;
use Shopware\Core\Framework\ORM\Version\Service\VersionManager;
use Shopware\Core\Framework\ORM\Write\GenericWrittenEvent;
use Shopware\Core\Framework\ORM\Write\WriteContext;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ShippingMethodRepository implements RepositoryInterface
{
    /**
     * @var EntityReaderInterface
     */
    private $reader;

    /**
     * @var EntitySearcherInterface
     */
    private $searcher;

    /**
     * @var EntityAggregatorInterface
     */
    private $aggregator;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var VersionManager
     */
    private $versionManager;

    public function __construct(
       EntityReaderInterface $reader,
       VersionManager $versionManager,
       EntitySearcherInterface $searcher,
       EntityAggregatorInterface $aggregator,
       EventDispatcherInterface $eventDispatcher
   ) {
        $this->reader = $reader;
        $this->searcher = $searcher;
        $this->aggregator = $aggregator;
        $this->eventDispatcher = $eventDispatcher;
        $this->versionManager = $versionManager;
    }

    public function search(Criteria $criteria, Context $context): ShippingMethodSearchResult
    {
        $ids = $this->searchIds($criteria, $context);

        $entities = $this->readBasic($ids->getIds(), $context);

        $aggregations = null;
        if ($criteria->getAggregations()) {
            $aggregations = $this->aggregate($criteria, $context);
        }

        $result = ShippingMethodSearchResult::createFromResults($ids, $entities, $aggregations);

        $event = new ShippingMethodSearchResultLoadedEvent($result);
        $this->eventDispatcher->dispatch($event->getName(), $event);

        return $result;
    }

    public function aggregate(Criteria $criteria, Context $context): AggregatorResult
    {
        $result = $this->aggregator->aggregate(ShippingMethodDefinition::class, $criteria, $context);

        $event = new ShippingMethodAggregationResultLoadedEvent($result);
        $this->eventDispatcher->dispatch($event->getName(), $event);

        return $result;
    }

    public function searchIds(Criteria $criteria, Context $context): IdSearchResult
    {
        $result = $this->searcher->search(ShippingMethodDefinition::class, $criteria, $context);

        $event = new ShippingMethodIdSearchResultLoadedEvent($result);
        $this->eventDispatcher->dispatch($event->getName(), $event);

        return $result;
    }

    public function readBasic(array $ids, Context $context): ShippingMethodBasicCollection
    {
        /** @var ShippingMethodBasicCollection $entities */
        $entities = $this->reader->readBasic(ShippingMethodDefinition::class, $ids, $context);

        $event = new ShippingMethodBasicLoadedEvent($entities, $context);
        $this->eventDispatcher->dispatch($event->getName(), $event);

        return $entities;
    }

    public function readDetail(array $ids, Context $context): ShippingMethodDetailCollection
    {
        /** @var ShippingMethodDetailCollection $entities */
        $entities = $this->reader->readDetail(ShippingMethodDefinition::class, $ids, $context);

        $event = new ShippingMethodDetailLoadedEvent($entities, $context);
        $this->eventDispatcher->dispatch($event->getName(), $event);

        return $entities;
    }

    public function update(array $data, Context $context): GenericWrittenEvent
    {
        $affected = $this->versionManager->update(ShippingMethodDefinition::class, $data, WriteContext::createFromContext($context));
        $event = GenericWrittenEvent::createWithWrittenEvents($affected, $context, []);
        $this->eventDispatcher->dispatch(GenericWrittenEvent::NAME, $event);

        return $event;
    }

    public function upsert(array $data, Context $context): GenericWrittenEvent
    {
        $affected = $this->versionManager->upsert(ShippingMethodDefinition::class, $data, WriteContext::createFromContext($context));
        $event = GenericWrittenEvent::createWithWrittenEvents($affected, $context, []);
        $this->eventDispatcher->dispatch(GenericWrittenEvent::NAME, $event);

        return $event;
    }

    public function create(array $data, Context $context): GenericWrittenEvent
    {
        $affected = $this->versionManager->insert(ShippingMethodDefinition::class, $data, WriteContext::createFromContext($context));
        $event = GenericWrittenEvent::createWithWrittenEvents($affected, $context, []);
        $this->eventDispatcher->dispatch(GenericWrittenEvent::NAME, $event);

        return $event;
    }

    public function delete(array $ids, Context $context): GenericWrittenEvent
    {
        $affected = $this->versionManager->delete(ShippingMethodDefinition::class, $ids, WriteContext::createFromContext($context));
        $event = GenericWrittenEvent::createWithDeletedEvents($affected, $context, []);
        $this->eventDispatcher->dispatch(GenericWrittenEvent::NAME, $event);

        return $event;
    }

    public function createVersion(string $id, Context $context, ?string $name = null, ?string $versionId = null): string
    {
        return $this->versionManager->createVersion(ShippingMethodDefinition::class, $id, WriteContext::createFromContext($context), $name, $versionId);
    }

    public function merge(string $versionId, Context $context): void
    {
        $this->versionManager->merge($versionId, WriteContext::createFromContext($context));
    }
}