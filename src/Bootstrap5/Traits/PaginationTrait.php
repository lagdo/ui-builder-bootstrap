<?php

namespace Lagdo\UiBuilder\Bootstrap\Bootstrap5\Traits;

use Lagdo\UiBuilder\BuilderInterface;

use function func_get_args;

trait PaginationTrait
{
    abstract protected function createScope(string $name, array $arguments = []): BuilderInterface;

    abstract protected function createWrapper(string $name, array $arguments = []): BuilderInterface;

    abstract protected function prependClass(string $class): BuilderInterface;

    abstract protected function setAttributes(array $attributes): BuilderInterface;

    abstract public function end(): BuilderInterface;

    /**
     * @inheritDoc
     */
    public function pagination(): BuilderInterface
    {
        $this->createWrapper('nav', ['aria-label' => '']);
        $this->createScope('ul', func_get_args());
        $this->prependClass('pagination');
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function paginationItem(): BuilderInterface
    {
        $this->createWrapper('li', ['class' => 'page-item']);
        $this->createScope('a', func_get_args());
        $this->prependClass('page-link');
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function paginationActiveItem(): BuilderInterface
    {
        $this->createWrapper('li', ['class' => 'page-item active']);
        $this->createScope('a', func_get_args());
        $this->prependClass('page-link');
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function paginationDisabledItem(): BuilderInterface
    {
        $this->createWrapper('li', ['class' => 'page-item disabled']);
        $this->createScope('span', func_get_args());
        $this->prependClass('page-link');
        return $this;
    }
}
