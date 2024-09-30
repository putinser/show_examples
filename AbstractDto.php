<?php

namespace App\Http\Requests;

use App\Exceptions\ValidationException;
use Illuminate\Contracts\Validation\ValidatesWhenResolved;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidatesWhenResolvedTrait;
use InvalidArgumentException;
use Request;
use Validator;

/**
 * Class AbstractDto
 */
abstract class AbstractDto implements ValidatesWhenResolved
{
    use ValidatesWhenResolvedTrait;

    private $data;

    private $validator;

    /**
     * AbstractDto constructor.
     *
     * @param array $data
     */
    public function __construct($data = [])
    {
        $validate = !!count($data);
        $data = $validate ? $data : Request::all();
        $this->validator = Validator::make(
            $data,
            $this->rules()
        );
        if ($validate) {
            $this->validateResolved();
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array|string[]
     */
    abstract protected function rules(): array;

    /**
     * @param array $data
     *
     * @return bool
     */
    protected function map(array $data): bool
    {
        foreach ($data as $key => $value) {
            $this->{Str::camel($key)} = $value;
        }
        return true;
    }

    /**
     * Get the validator instance for the request.
     *
     * @return \Illuminate\Validation\Validator
     */
    protected function getValidatorInstance()
    {
        return $this->validator;
    }

    /**
     * @throws ValidationException
     */
    protected function passedValidation()
    {
        $success_map = $this->map($this->validator->validated());
        if (!$success_map) {
            throw new InvalidArgumentException('The mapping failed');
        }
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param \Illuminate\Validation\Validator $validator
     *
     * @throws ValidationException
     * @return void
     *
     */
    protected function failedValidation(\Illuminate\Validation\Validator $validator)
    {
        throw new ValidationException($validator);
    }
}
