<?php declare(strict_types=1);

namespace Shopware\Core\System\Configuration\Event;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\Event\NestedEvent;
use Shopware\Core\Framework\Event\NestedEventCollection;
use Shopware\Core\System\Configuration\Aggregate\ConfigurationGroupOption\Event\ConfigurationGroupOptionBasicLoadedEvent;
use Shopware\Core\System\Configuration\Aggregate\ConfigurationGroupTranslation\Event\ConfigurationGroupTranslationBasicLoadedEvent;
use Shopware\Core\System\Configuration\Collection\ConfigurationGroupDetailCollection;

class ConfigurationGroupDetailLoadedEvent extends NestedEvent
{
    public const NAME = 'configuration_group.detail.loaded';

    /**
     * @var Context
     */
    protected $context;

    /**
     * @var ConfigurationGroupDetailCollection
     */
    protected $configurationGroups;

    public function __construct(ConfigurationGroupDetailCollection $configurationGroups, Context $context)
    {
        $this->context = $context;
        $this->configurationGroups = $configurationGroups;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getContext(): Context
    {
        return $this->context;
    }

    public function getConfigurationGroups(): ConfigurationGroupDetailCollection
    {
        return $this->configurationGroups;
    }

    public function getEvents(): ?NestedEventCollection
    {
        $events = [];
        if ($this->configurationGroups->getOptions()->count() > 0) {
            $events[] = new ConfigurationGroupOptionBasicLoadedEvent($this->configurationGroups->getOptions(), $this->context);
        }
        if ($this->configurationGroups->getTranslations()->count() > 0) {
            $events[] = new ConfigurationGroupTranslationBasicLoadedEvent($this->configurationGroups->getTranslations(), $this->context);
        }

        return new NestedEventCollection($events);
    }
}