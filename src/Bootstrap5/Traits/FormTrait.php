<?php

namespace Lagdo\UiBuilder\Bootstrap\Bootstrap5\Traits;

use Lagdo\UiBuilder\BuilderInterface;

use function array_shift;
use function func_get_args;
use function rtrim;
use function ltrim;

trait FormTrait
{
    abstract protected function createScope(string $name, array $arguments = []): BuilderInterface;

    abstract protected function createWrapper(string $name, array $arguments = []): BuilderInterface;

    abstract protected function prependClass(string $class): BuilderInterface;

    abstract protected function setAttributes(array $attributes): BuilderInterface;

    abstract public function end(): BuilderInterface;

    /**
     * @inheritDoc
     */
    public function form(bool $horizontal = false, bool $wrapped = false): BuilderInterface
    {
        $arguments = func_get_args();
        array_shift($arguments);
        array_shift($arguments);
        $this->createScope('form', $arguments);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function formRow(): BuilderInterface
    {
        $this->createScope('div', func_get_args());
        $this->prependClass('row mb-3');
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function formRowClass(string $class = ''): string
    {
        return rtrim('row ' . ltrim($class));
    }

    /**
     * @inheritDoc
     */
    public function formCol(int $width = 12): BuilderInterface
    {
        if ($width < 1 || $width > 12) {
            $width = 12; // Full width by default.
        }
        $arguments = func_get_args();
        array_shift($arguments);
        $this->createScope('div', $arguments);
        $this->prependClass("col-sm-$width");
        return $this;
    }

    /**
     * @inheritDoc
     */
    protected function _formTagClass(string $tagName): string
    {
        if ($tagName === 'label' || $tagName === 'select') {
            return "form-$tagName";
        }
        return 'form-control';
    }
}
