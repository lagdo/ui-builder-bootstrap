<?php

namespace Lagdo\UiBuilder\Bootstrap\Bootstrap4\Traits;

use Lagdo\UiBuilder\BuilderInterface;

use function array_shift;
use function func_get_args;

trait MenuTrait
{
    abstract protected function createScope(string $name, array $arguments = []): BuilderInterface;

    abstract protected function createWrapper(string $name, array $arguments = []): BuilderInterface;

    abstract protected function prependClass(string $class): BuilderInterface;

    abstract protected function setAttributes(array $attributes): BuilderInterface;

    abstract public function end(): BuilderInterface;

    /**
     * @inheritDoc
     */
    public function menu(): BuilderInterface
    {
        $this->createScope('div', func_get_args());
        $this->prependClass('list-group');
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function menuItem(): BuilderInterface
    {
        $this->createScope('a', func_get_args());
        $this->prependClass('list-group-item list-group-item-action');
        $this->setAttributes(['href' => 'javascript:void(0)']);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function menuActiveItem(): BuilderInterface
    {
        $this->createScope('a', func_get_args());
        $this->prependClass('list-group-item list-group-item-action active');
        $this->setAttributes(['href' => 'javascript:void(0)']);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function menuDisabledItem(): BuilderInterface
    {
        $this->createScope('a', func_get_args());
        $this->prependClass('list-group-item list-group-item-action disabled');
        $this->setAttributes(['href' => 'javascript:void(0)']);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function breadcrumb(): BuilderInterface
    {
        $this->createWrapper('nav', ['aria-label' => 'breadcrumb']);
        $this->createScope('ol', func_get_args());
        $this->prependClass('breadcrumb');
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function breadcrumbItem(bool $active): BuilderInterface
    {
        $arguments = func_get_args();
        array_shift($arguments);
        $this->createScope('li', $arguments);
        $this->prependClass($active ? 'breadcrumb-item active' : 'breadcrumb-item');
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function dropdown(): BuilderInterface
    {
        $this->createScope('div', func_get_args());
        $this->prependClass('btn-group');
        $this->setAttributes(['role' => 'group']);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function dropdownItem(string $style = 'default'): BuilderInterface
    {
        $arguments = func_get_args();
        array_shift($arguments);
        $this->createScope('button', $arguments);
        $this->prependClass("btn btn-$style dropdown-toggle");
        $this->setAttributes(['data-toggle' => 'dropdown', 'aria-haspopup' => 'true', 'aria-expanded' => 'false']);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function dropdownMenu(): BuilderInterface
    {
        $this->createScope('div', func_get_args());
        $this->prependClass('dropdown-menu');
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function dropdownMenuItem(): BuilderInterface
    {
        $this->createScope('a', func_get_args());
        $this->prependClass('dropdown-item');
        $this->setAttributes(['href' => '#']);
        return $this;
    }
}
