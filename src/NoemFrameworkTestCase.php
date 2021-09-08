<?php

declare(strict_types=1);

namespace Noem\IntegrationTest;

use Composer\Autoload\ClassLoader;
use Invoker\Invoker;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Noem\Container\Container;
use Noem\Container\ServiceProvider;

use function Noem\Framework\bootstrap;

abstract class NoemFrameworkTestCase extends MockeryTestCase
{
    private Container $container;
    private Invoker $invoker;

    public function setUp(): void
    {
        $classLoaderRef = new \ReflectionClass(ClassLoader::class);
        $vendorDir = dirname($classLoaderRef->getFileName(), 2);
        $providers = require $vendorDir . '/noem.php';
        assert(is_array($providers));
        $providers['noem/integration-test'] = new ServiceProvider($this->getFactories(), $this->getExtensions());
        bootstrap(...$providers)(function (Container $c, Invoker $i) {
            $this->container = $c;
            $this->invoker = $i;
        })();
        parent::setUp();
    }

    protected abstract function getFactories(): array;

    protected abstract function getExtensions(): array;

    /**
     * @return Invoker
     */
    public function getInvoker(): Invoker
    {
        return $this->invoker;
    }

    /**
     * @return Container
     */
    protected function getContainer(): Container
    {
        return $this->container;
    }
}
