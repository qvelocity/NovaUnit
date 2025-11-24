<?php

namespace JoshGaber\NovaUnit\Traits;

use JoshGaber\NovaUnit\Constraints\HasField;
use Illuminate\Support\Arr;
use JoshGaber\NovaUnit\Constraints\HasValidFields;
use JoshGaber\NovaUnit\Fields\FieldHelper;
use JoshGaber\NovaUnit\Fields\FieldNotFoundException;
use JoshGaber\NovaUnit\Fields\MockFieldElement;
use JoshGaber\NovaUnit\Lenses\MockLens;
use JoshGaber\NovaUnit\Resources\MockResource;
use Laravel\Nova\Http\Requests\NovaRequest;
use PHPUnit\Framework\Assert as PHPUnit;
use PHPUnit\Framework\Constraint\IsType;

trait FieldAssertions
{
    /**
     * Checks that this Nova component has a field with the same name or attribute.
     *
     * @param  string  $field  The name or attribute of the field
     * @param  string  $message
     * @param  NovaRequest|null $request
     * @return $this
     */
    public function assertHasField(string $field, string $message = '', ?NovaRequest $request = null): self
    {
        PHPUnit::assertThat(
            $this->fieldsForComponent($request),
            new HasField($field, $this->allowPanels()),
            $message
        );

        return $this;
    }

    /**
     * Checks that this Nova component has all the fields with the same name or attribute.
     *
     * @param  string[]  $fields
     * @param  string  $message
     * @param  NovaRequest|null  $request
     * @return $this
     */
    public function assertHasFields(array $fields, string $message = '', ?NovaRequest $request = null): self
    {
        foreach ($fields as $field) {
            $this->assertHasField($field, $message, $request);
        }

        return $this;
    }

    /**
     * Checks that no field on this Nova component has a name or attribute matching
     * the given parameter.
     *
     * @param  string  $field
     * @param  string  $message
     * @return $this
     */
    public function assertFieldMissing(string $field, string $message = '', ?NovaRequest $request = null): self
    {
        PHPUnit::assertThat(
            $this->fieldsForComponent($request),
            PHPUnit::logicalNot(new HasField($field, $this->allowPanels())),
            $message
        );

        return $this;
    }

    /**
     * Checks that no fields on this Nova component has a name or attribute matching
     * the given parameter.
     *
     * @param  string[]  $fields
     * @param  string  $message
     * @param  NovaRequest|null  $request
     * @return $this
     */
    public function assertFieldsMissing(array $fields, string $message = '', ?NovaRequest $request = null): self
    {
        foreach ($fields as $field) {
            $this->assertFieldMissing($field, $message, $request);
        }

        return $this;
    }

    /**
     * Asserts that this Nova Action has no fields defined.
     *
     * @param  string  $message
     * @param  NovaRequest|null $request
     * @return $this
     */
    public function assertHasNoFields(string $message = '', ?NovaRequest $request = null): self
    {
        PHPUnit::assertCount(0, $this->fieldsForComponent($request), $message);

        return $this;
    }

    /**
     * Asserts that all fields defined on this Nova Action are valid fields.
     *
     * @param  string  $message
     * @param  NovaRequest|null $request
     * @return $this
     */
    public function assertHasValidFields(string $message = '', ?NovaRequest $request = null): self
    {
        PHPUnit::assertThat(
            $this->fieldsForComponent($request),
            PHPUnit::logicalAnd(
                function_exists('\PHPUnit\Framework\isArray')
                    ? \PHPUnit\Framework\isArray()
                    : new IsType(constant('PHPUnit\Framework\Constraint\IsType::TYPE_ARRAY') ?? 'array'),
                new HasValidFields($this->allowPanels())
            ),
            $message
        );

        return $this;
    }

    /**
     * Searches for a matching field instance on this component for testing.
     *
     * @param  string  $fieldName  The name or attribute of the field to return
     * @param  NovaRequest|null $request
     * @return MockFieldElement
     *
     * @throws FieldNotFoundException
     */
    public function field(string $fieldName, ?NovaRequest $request = null): MockFieldElement
    {
        $field = FieldHelper::findField(
            $this->fieldsForComponent($request),
            $fieldName,
            $this->allowPanels()
        );

        if (is_null($field)) {
            throw new FieldNotFoundException();
        }

        return new MockFieldElement($field);
    }

    private function allowPanels(): bool
    {
        return $this instanceof MockLens || $this instanceof MockResource;
    }

    /**
     * Get the fields defined on this component.
     *
     * @param  NovaRequest|null  $request
     * @return array<int, \Laravel\Nova\Fields\Field>
     */
    private function fieldsForComponent(?NovaRequest $request = null): array
    {
        $request ??= NovaRequest::createFromGlobals();

        /*
         * Nova Resource uses the ConditionallyLoadsAttributes trait which requires filtering out MergeValue and
         * MissingValue instances. To do this, we use the `availableFields` method when it's defined on the component.
         * If not available (like in `Action` classes), we fall back to the standard `fields` method.
         */
        return Arr::wrap(
            method_exists($this->component, 'availableFields')
                ? $this->component->availableFields($request)->all()
                : $this->component->fields($request)
        );
    }
}
