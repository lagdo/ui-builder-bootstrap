<?php

namespace Lagdo\UiBuilder\Bootstrap\Bootstrap4\Traits;

use Lagdo\UiBuilder\AbstractBuilder;
use Lagdo\UiBuilder\BuilderInterface;

use function array_shift;
use function func_get_args;

trait ButtonTrait
{
    /**
     * @var array
     */
    protected $buttonStyles = [
        0 => 'secondary', // The default style is "secondary"
        AbstractBuilder::BTN_PRIMARY => 'primary',
        AbstractBuilder::BTN_DANGER => 'danger',
    ];

    abstract protected function createScope(string $name, array $arguments = []): BuilderInterface;

    abstract protected function createWrapper(string $name, array $arguments = []): BuilderInterface;

    abstract protected function prependClass(string $class): BuilderInterface;

    abstract protected function setAttributes(array $attributes): BuilderInterface;

    abstract public function end(): BuilderInterface;

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
     *
     * @return string
     */
    private function buttonStyle(int $flags): string
    {
        foreach ($this->buttonStyles as $mask => $value) {
            if ($flags & $mask) {
                return $value;
            }
        }
        return 'secondary'; // The default style is "secondary"
    }

    /**
     * @param integer $flags
     * @param boolean $isInButtonGroup
     *
     * @return string
     */
    private function buttonClass(int $flags, bool $isInButtonGroup): string
    {
        $style = $this->buttonStyle($flags);
        $btnClass = ($flags & AbstractBuilder::BTN_OUTLINE) ? "btn btn-outline-$style" : "btn btn-$style";
        if (($flags & AbstractBuilder::BTN_FULL_WIDTH) && !$isInButtonGroup) {
            $btnClass .= ' w-100';
        }
        if ($flags & AbstractBuilder::BTN_SMALL) {
            $btnClass .= ' btn-sm';
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
}
