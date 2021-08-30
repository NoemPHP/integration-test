<?php

declare(strict_types=1);


namespace Noem\IntegrationTest;


trait NoProviderTrait
{
    protected function getFactories(): array
    {
        return [];
    }

    protected function getExtensions(): array
    {
        return [];
    }
}
