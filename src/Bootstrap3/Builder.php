<?php

namespace Lagdo\UiBuilder\Bootstrap\Bootstrap3;

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
     * @var array
     */
    protected $buttonStyles = [
        0 => 'default',
        self::BTN_PRIMARY => 'primary',
        self::BTN_DANGER => 'danger',
    ];

    /**
     * @inheritDoc
     */
    public function addIcon(string $icon): BuilderInterface
    {
        return $this->addHtml('<span class="glyphicon glyphicon-' . $icon . '" aria-hidden="true" />');
    }

    /**
     * @inheritDoc
     */
    public function addCaret(): BuilderInterface
    {
        return $this->addHtml('<span class="caret" />');
    }

    /**
     * @inheritDoc
     */
    public function checkbox(bool $checked = false): BuilderInterface
    {
        if ($this->scope !== null && $this->scope->isInputGroup) {
            $this->createWrapper('span', [
                'class' => 'input-group-addon',
                'style' => 'background-color:white;padding:8px;',
            ]);
        }
        $arguments = func_get_args();
        return parent::checkbox(...$arguments);
    }

    /**
     * @inheritDoc
     */
    public function text(): BuilderInterface
    {
        // A label in an input group must be wrapped into a span with class "input-group-addon".
        if ($this->scope !== null && $this->scope->isInputGroup) {
            $this->createWrapper('span', ['class' => 'input-group-addon']);
        }
        $this->createScope('span', func_get_args());
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function inputGroup(): BuilderInterface
    {
        $this->createScope('div', func_get_args());
        $this->prependClass('input-group');
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
