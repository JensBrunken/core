<?php

namespace Shopware\Framework\ORM\Exception;

use Shopware\Framework\ShopwareException;
use Throwable;

class MappingEntityRepositoryException extends \RuntimeException implements ShopwareException
{
    public function __construct(int $code = 0, Throwable $previous = null)
    {
        $message = 'Mapping definition do not have a repository.';

        parent::__construct($message, $code, $previous);
    }

}