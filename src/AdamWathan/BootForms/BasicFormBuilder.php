<?php namespace AdamWathan\BootForms;

use AdamWathan\Form\FormBuilder;
use AdamWathan\BootForms\Elements\FormGroup;
use AdamWathan\BootForms\Elements\CheckGroup;
use AdamWathan\BootForms\Elements\HelpBlock;
use AdamWathan\BootForms\Elements\GroupWrapper;

class BasicFormBuilder
{
	protected $builder;

	public function __construct(FormBuilder $builder)
	{
		$this->builder = $builder;
	}

	protected function formGroup($name, $label, $control)
	{
		$label = $this->builder->label($label)->addClass('control-label')->forId($name);
		$control->id($name)->addClass('form-control');

		$formGroup = new FormGroup($label, $control);

		if ($this->builder->hasError($name)) {
			$formGroup->helpBlock($this->builder->getError($name));
			$formGroup->addClass('has-error');
		}

		return $this->wrap($formGroup);
	}

	protected function wrap($group)
	{
		return new GroupWrapper($group);
	}

	public function text($name, $label, $value = null)
	{
		$control = $this->builder->text($name)->value($value);

		return $this->formGroup($name, $label, $control);
	}

	public function password($name, $label)
	{
		$control = $this->builder->password($name);

		return $this->formGroup($name, $label, $control);
	}

	public function submit($value = "Submit", $type = "btn-default")
	{
		return $this->builder->submit($value)->addClass('btn')->addClass($type);
	}

	public function select($name, $label, $options = array())
	{
		$control = $this->builder->select($name, $options);

		return $this->formGroup($name, $label, $control);
	}

	public function checkbox($name, $label)
	{
		$control = $this->builder->checkbox($name);

		return $this->checkGroup($name, $label, $control);
	}

	protected function checkGroup($name, $label, $control)
	{
		$checkGroup = $this->buildCheckGroup($name, $label, $control);
		return $this->wrap($checkGroup->addClass('checkbox'));
	}

	protected function buildCheckGroup($name, $label, $control)
	{
		$label = $this->builder->label($label)->after($control)->addClass('control-label');

		$checkGroup = new CheckGroup($label);

		if ($this->builder->hasError($name)) {
			$checkGroup->helpBlock($this->builder->getError($name));
			$checkGroup->addClass('has-error');
		}
		return $checkGroup;
	}

	public function radio($name, $label, $value = null)
	{
		if (is_null($value)) {
			$value = $label;
		}

		$control = $this->builder->radio($name, $value);

		return $this->radioGroup($name, $label, $control);
	}

	protected function radioGroup($name, $label, $control)
	{
		$checkGroup = $this->buildCheckGroup($name, $label, $control);
		return $this->wrap($checkGroup->addClass('radio'));
	}

	public function textarea($name, $label)
	{
		$control = $this->builder->textarea($name);

		return $this->formGroup($name, $label, $control);
	}

	public function inlineCheckbox($name, $label)
	{
		$label = $this->builder->label($label)->addClass('checkbox-inline');
		$control = $this->builder->checkbox($name);

		return $label->after($control);
	}

	public function inlineRadio($name, $label, $value = null)
	{
		$value = $value ?: $label;
		$label = $this->builder->label($label)->addClass('radio-inline');
		$control = $this->builder->radio($name, $value);

		return $label->after($control);
	}

	public function date($name, $label, $value = null)
	{
		$control = $this->builder->date($name)->value($value);

		return $this->formGroup($name, $label, $control);
	}

	public function email($name, $label, $value = null)
	{
		$control = $this->builder->email($name)->value($value);

		return $this->formGroup($name, $label, $control);
	}

	public function file($name, $label, $value = null)
	{
		$control = $this->builder->file($name)->value($value);
		$label = $this->builder->label($label)->addClass('control-label')->forId($name);
		$control->id($name);

		$formGroup = new FormGroup($label, $control);

		if ($this->builder->hasError($name)) {
			$formGroup->helpBlock($this->builder->getError($name));
			$formGroup->addClass('has-error');
		}

		return $this->wrap($formGroup);
	}

	public function __call($method, $parameters)
	{
		return call_user_func_array(array($this->builder, $method), $parameters);
	}
}
