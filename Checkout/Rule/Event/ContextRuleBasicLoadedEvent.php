<?php declare(strict_types=1);

namespace Shopware\Core\Checkout\Rule\Event;

use Shopware\Core\Framework\Context;
use Shopware\Core\Checkout\Rule\Collection\ContextRuleBasicCollection;
use Shopware\Core\Framework\Event\NestedEvent;

class ContextRuleBasicLoadedEvent extends NestedEvent
{
    public const NAME = 'context_rule.basic.loaded';

    /**
     * @var \Shopware\Core\Framework\Context
     */
    protected $context;

    /**
     * @var \Shopware\Core\Checkout\Rule\Collection\ContextRuleBasicCollection
     */
    protected $contextRules;

    public function __construct(ContextRuleBasicCollection $contextRules, Context $context)
    {
        $this->context = $context;
        $this->contextRules = $contextRules;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getContext(): Context
    {
        return $this->context;
    }

    public function getContextRules(): ContextRuleBasicCollection
    {
        return $this->contextRules;
    }
}