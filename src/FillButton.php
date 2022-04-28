<?php

namespace Upline\FillButton;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

class FillButton extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'fill-button';

    private $fillFunction = null;

    private $sourceFields = [];

    public function __construct($name, $attribute = null, callable $resolveCallback = null)
    {
        $this->hideFromIndex();
        $this->hideFromDetail();
        parent::__construct($name, $attribute, $resolveCallback);
    }

    public function setFillFunction(callable $fillFunction): self
    {
        $this->fillFunction = $fillFunction;
        return $this;
    }

    public function setSourceFields(array $fields): self
    {
        $this->sourceFields = $fields;
        $this->withMeta([
            'sourceFields' => $fields
        ]);
        return $this;
    }

    public function resolve($resource, $attribute = null)
    {
        $this->withMeta(['calculateUrl' => $this->getUrl()]);
        $values = collect($this->sourceFields)->mapWithKeys(fn($sourceField) => [
            $sourceField => $this->resolveAttribute($resource, $sourceField)
        ]);
        $this->withMeta(['initialValues' => $values]);
        parent::resolve($resource, $attribute);
    }

    private function getUrl()
    {
        $request = app(NovaRequest::class);
        return route('upline.fill-button.calculate', ['resource' => $request->route('resource'), 'field' => $this->attribute]);
    }

    /**
     * @return null
     */
    public function getFillFunction()
    {
        return $this->fillFunction;
    }
}
