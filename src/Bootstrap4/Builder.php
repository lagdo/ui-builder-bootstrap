<?php

namespace Lagdo\UiBuilder\Bootstrap\Bootstrap4;

use Lagdo\UiBuilder\AbstractBuilder;
use Lagdo\UiBuilder\BuilderInterface;

use function array_shift;
use function func_get_args;
use function rtrim;
use function ltrim;

class Builder extends AbstractBuilder
{
    /**
     * @var array
     */
    protected $buttonStyles = [
        0 => 'secondary', // The default style is "secondary"
        self::BTN_PRIMARY => 'primary',
        self::BTN_DANGER => 'danger',
    ];

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
        if ($this->scope !== null && $this->scope->isInputGroup) {
            $this->createWrapper('div', ['class' => 'input-group-append']);
            $this->createWrapper('div', ['class' => 'input-group-text', 'style' => 'background-color:white;']);
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
        // Check the parent scope.
        $isInGroup = false;
        if ($this->scope !== null && $this->scope->isInputGroup) {
            $this->createWrapper('div', ['class' => 'input-group-prepend']);
            $isInGroup = true;
        }
        $this->createScope('label', func_get_args());
        if ($isInGroup) {
            $this->prependClass('input-group-text');
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function row(): BuilderInterface
    {
        $this->createScope('div', func_get_args());
        $this->prependClass('row');
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function col(int $width = 12): BuilderInterface
    {
        if ($width < 1 || $width > 12) {
            $width = 12; // Full width by default.
        }
        $arguments = func_get_args();
        array_shift($arguments);
        $this->createScope('div', $arguments);
        $this->prependClass("col-md-$width");
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
    public function buttonGroup(bool $fullWidth): BuilderInterface
    {
        $arguments = func_get_args();
        array_shift($arguments);
        $this->createScope('div', $arguments);
        $this->prependClass($fullWidth ? 'btn-group d-flex' : 'btn-group');
        $this->setAttributes(['role' => 'group']);
        $this->scope->isButtonGroup = true;
        return $this;
    }

    /**
     * @param integer $flags
     * @param boolean $isInButtonGroup
     *
     * @return string
     */
    private function buttonClass(int $flags, bool $isInButtonGroup): string
    {
        $style = 'secondary'; // The default style is "secondary"
        foreach ($this->buttonStyles as $mask => $value) {
            if ($flags & $mask) {
                $style = $value;
                break;
            }
        }
        $btnClass = ($flags & self::BTN_OUTLINE) ? "btn btn-outline-$style " : "btn btn-$style ";
        if (($flags & self::BTN_FULL_WIDTH) && !$isInButtonGroup) {
            $btnClass .= 'w-100 ';
        }
        if ($flags & self::BTN_SMALL) {
            $btnClass .= 'btn-sm ';
        }
        return $btnClass;
    }

    /**
     * @inheritDoc
     */
    public function button(int $flags = 0): BuilderInterface
    {
        // A button in an input group must be wrapped into a div with class "input-group-btn".
        // Check the parent scope.
        $isInButtonGroup = false;
        if ($this->scope !== null) {
            if ($this->scope->isInputGroup) {
                $this->createWrapper('div', ['class' => 'input-group-append']);
            }
            $isInButtonGroup = $this->scope->isButtonGroup;
        }
        $arguments = func_get_args();
        array_shift($arguments);
        $this->createScope('button', $arguments);
        $this->prependClass($this->buttonClass($flags, $isInButtonGroup));
        $this->setAttributes(['type' => 'button']);
        return $this;
    }

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
    public function breadcrumbItem(): BuilderInterface
    {
        $this->createScope('li', func_get_args());
        $this->prependClass('breadcrumb-item');
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function tabHeader(): BuilderInterface
    {
        $this->createScope('ul', func_get_args());
        $this->prependClass('nav nav-pills');
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function tabHeaderItem(string $id, bool $active = false): BuilderInterface
    {
        $arguments = func_get_args();
        array_shift($arguments);
        array_shift($arguments);
        $this->createScope('li', $arguments);
        $this->prependClass('nav-item');
        $this->setAttributes(['role' => 'presentation']);
        // Inner link
        $this->createScope('a', [['class' => $active ? 'nav-link active' : 'nav-link',
            'data-toggle' => 'tab', 'role' => 'tab', 'href' => "#$id"]]);
        $this->end();
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function tabContent(): BuilderInterface
    {
        $this->createScope('div', func_get_args());
        $this->prependClass('tab-content');
        $this->setAttributes(['style' => 'margin-top:10px;']);
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

    /**
     * @inheritDoc
     */
    public function form(bool $horizontal = false, bool $wrapped = false): BuilderInterface
    {
        if ($wrapped) {
            $this->createWrapper('div', ['class' => 'portlet-body form']);
        }
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
        $this->prependClass('form-group row');
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function formRowClass(string $class = ''): string
    {
        return rtrim('form-group row ' . ltrim($class));
    }

    /**
     * @inheritDoc
     */
    protected function _formTagClass(string $tagName): string
    {
        if ($tagName === 'label') {
            return 'col-form-label';
        }
        return 'form-control';
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
        $this->createWrapper('li', ['class' => 'disabled']);
        $this->createScope('span', func_get_args());
        $this->prependClass('page-link');
        return $this;
    }
}
