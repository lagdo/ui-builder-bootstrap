<?php

namespace Lagdo\UiBuilder\Bootstrap\Bootstrap5\Traits;

use Lagdo\UiBuilder\BuilderInterface;

use function array_shift;
use function func_get_args;

trait PanelTrait
{
    abstract protected function createScope(string $name, array $arguments = []): BuilderInterface;

    abstract protected function createWrapper(string $name, array $arguments = []): BuilderInterface;

    abstract protected function prependClass(string $class): BuilderInterface;

    abstract protected function setAttributes(array $attributes): BuilderInterface;

    abstract public function end(): BuilderInterface;

    /**
     * @inheritDoc
     */
    public function panel(string $style = 'default'): BuilderInterface
    {
        $this->options['card-style'] = $style;
        $arguments = func_get_args();
        array_shift($arguments);
        $this->createScope('div', $arguments);
        $this->prependClass("card border-$style w-100");
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function panelHeader(): BuilderInterface
    {
        $style = $this->options['card-style'];
        $this->createScope('div', func_get_args());
        $this->prependClass("card-header border-$style");
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function panelBody(): BuilderInterface
    {
        $style = $this->options['card-style'];
        $this->createScope('div', func_get_args());
        $this->prependClass("card-body text-$style");
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function panelFooter(): BuilderInterface
    {
        $style = $this->options['card-style'];
        $this->createScope('div', func_get_args());
        $this->prependClass("card-footer border-$style");
        return $this;
    }
}
