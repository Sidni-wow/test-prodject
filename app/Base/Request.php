<?php

namespace App\Base;

use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Returns the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * Create the validator instance.
     *
     * @param \Illuminate\Contracts\Validation\Factory $factory
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(ValidationFactory $factory): Validator
    {
        $rules = $this->container->call([$this, 'rules']);

        if ($this->method() === 'PATCH') {
            foreach ($rules as &$rule) {
                if (! is_array($rule)) {
                    $rule = explode('|', $rule);
                }

                array_unshift($rule, 'sometimes');
            }
        }

        return $factory->make(
            $this->validationData(), $rules,
            $this->messages(), $this->attributes()
        );
    }

    /**
     * Run afterValidation stuff.
     */
    public function validateResolved(): void
    {
        parent::validateResolved();

        $this->merge($this->processAll(parent::all()));
    }

    /**
     * {@inheritdoc}
     */
    public function validated($key = null)
    {
        $validated = $this->processValidated(parent::validated());

        if (! is_null($key)) {
            return $validated[$key];
        }

        return $validated;
    }

    /**
     * Performs after successful validation.
     *
     * @param Validator $validator
     *
     * @return void
     */
    public function afterValidationSuccess(Validator $validator): void
    {
    }

    /**
     * Performs after failed validation.
     *
     * @param Validator $validator
     *
     * @return void
     */
    public function afterValidationFail(Validator $validator): void
    {
    }

    /**
     * {@inheritdoc}
     */
    protected function getValidatorInstance()
    {
        return parent::getValidatorInstance()->after(function (Validator $validator) {
            if (! $validator->errors()->count()) {
                $this->afterValidationSuccess($validator);
            } else {
                $this->afterValidationFail($validator);
            }
        });
    }

    /**
     * Allows to make changes into validated data.
     *
     * @param array $validated
     *
     * @return array
     */
    protected function processValidated(array $validated): array
    {
        return $validated;
    }

    /**
     * Allows to make changes into validated data.
     *
     * @param array $data
     *
     * @return array
     */
    protected function processAll(array $data): array
    {
        return $data;
    }
}
