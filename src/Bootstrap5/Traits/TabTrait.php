<?php

namespace Lagdo\UiBuilder\Bootstrap\Bootstrap5\Traits;

use Lagdo\UiBuilder\BuilderInterface;

use function array_shift;
use function func_get_args;

trait TabTrait
{
    abstract protected function createScope(string $name, array $arguments = []): BuilderInterface;

    abstract protected function createWrapper(string $name, array $arguments = []): BuilderInterface;

    abstract protected function prependClass(string $class): BuilderInterface;

    abstract protected function setAttributes(array $attributes): BuilderInterface;

    abstract public function end(): BuilderInterface;

    /**
     * @inheritDoc
     */
    public function tabNav(string $id = ''): BuilderInterface
    {
        $this->createScope('ul', func_get_args());
        $this->prependClass('nav nav-pills mb-3');
        if (($id)) {
            $this->setAttributes(['id' => $id]);
            $this->options['tab-nav-id'] = $id;
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function tabNavItem(string $target, bool $active = false): BuilderInterface
    {
        $arguments = func_get_args();
        array_shift($arguments);
        array_shift($arguments);
        $this->createWrapper('li', ['class' => 'nav-item', 'role' => 'presentation']);
        $this->createScope('button', $arguments);
        $this->prependClass($active ? 'nav-link active' : 'nav-link');
        $this->setAttributes(['id' => "$target-tab", 'type' => 'button', 'role' => 'tab',
            'aria-selected' => $active ? 'true' : 'false', 'data-bs-toggle' => 'tab', 'data-bs-target' => "#$target"]);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function tabContent(): BuilderInterface
    {
        $this->createScope('div', func_get_args());
        $this->prependClass('tab-content');
        if (isset($this->options['tab-nav-id'])) {
            $this->setAttributes(['id' => $this->options['tab-nav-id'] . 'Content']);
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function tabContentItem(string $id, bool $active = false): BuilderInterface
    {
        $arguments = func_get_args();
        array_shift($arguments);
        array_shift($arguments);
        $this->createScope('div', $arguments);
        $this->prependClass($active ? 'tab-pane fade show active' : 'tab-pane fade');
        $this->setAttributes(['id' => $id]);
        return $this;
    }
}
