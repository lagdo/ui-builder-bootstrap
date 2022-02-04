<?php

namespace Lagdo\UiBuilder\Bootstrap\Bootstrap5;

use Lagdo\UiBuilder\AbstractBuilder;
use Lagdo\UiBuilder\BuilderInterface;

use function array_shift;
use function func_get_args;

class Builder extends AbstractBuilder
{
    use Traits\LayoutTrait;
    use Traits\ButtonTrait;
    use Traits\PanelTrait;
    use Traits\FormTrait;
    use Traits\MenuTrait;
    use Traits\TabTrait;
    use Traits\PaginationTrait;

    /**
     * @inheritDoc
     */
    public function addIcon(string $icon): BuilderInterface
    {
        if ($icon === 'remove') {
            $icon = 'x';
        } elseif ($icon === 'edit') {
            $icon = 'pencil';
        } elseif ($icon === 'ok') {
            $icon = 'check';
        }
        return $this->addHtml('<i class="bi bi-' . $icon . '"></i>');
    }

    /**
     * @inheritDoc
     */
    public function addCaret(): BuilderInterface
    {
        // Nothing to do.
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function checkbox(bool $checked = false): BuilderInterface
    {
        $class = 'form-check-input';
        if ($this->scope !== null && $this->scope->isInputGroup) {
            $this->createWrapper('div', ['class' => 'input-group-text']);
            $class .= ' mt-0';
        }
        $arguments = func_get_args();
        parent::checkbox(...$arguments);
        $this->prependClass($class);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function radio(bool $checked = false): BuilderInterface
    {
        $class = 'form-check-input';
        if ($this->scope !== null && $this->scope->isInputGroup) {
            $this->createWrapper('div', ['class' => 'input-group-text']);
            $class .= ' mt-0';
        }
        $arguments = func_get_args();
        parent::radio(...$arguments);
        $this->prependClass($class);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function text(): BuilderInterface
    {
        // A label in an input group must be wrapped into a span with class "input-group-addon".
        // Check the parent scope.
        $isInGroup = ($this->scope !== null && $this->scope->isInputGroup);
        $this->createScope('span', func_get_args());
        if ($isInGroup) {
            $this->prependClass('input-group-text');
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function inputGroup(): BuilderInterface
    {
        $this->createScope('div', func_get_args());
        $this->prependClass('input-group mb-3');
        $this->scope->isInputGroup = true;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function table(bool $responsive, string $style = ''): BuilderInterface
    {
        if ($responsive) {
            $this->createWrapper('div', ['class' => 'table-responsive']);
        }
        $arguments = func_get_args();
        array_shift($arguments);
        array_shift($arguments);
        $this->createScope('table', $arguments);
        $this->prependClass($style ? "table table-$style" : 'table');
        return $this;
    }
}
