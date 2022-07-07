<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseParamsRequest extends FormRequest
{

    protected function failedValidation(Validator $validator){
        $transformed = [
            'status'    => \Illuminate\Http\Response::HTTP_BAD_REQUEST,
            'message'   => 'Dữ liệu truyền lên không hợp lệ',
            'data'      => [],
        ];
        $errors = $validator->errors();
        foreach ($errors->keys() as $key) {
            $transformed['data'][$key] = $errors->get($key, [])[0];
        }
        // throw new ValidationErrorExcerption('1003', 'invalid Params', $transformed);
        throw new HttpResponseException($this->response($transformed));
    }
    /**
    * Determine if the user is authorized to make this request.
    *
    * @return bool
    */
    public function authorize()
    {
        return true;
    }
    /**
    * Get the validation rules that apply to the request.
    *
    * @return array
    */
    public function rules()
    {
        return [];
    }
    public function messages()
    {
        return [];
    }
    public function onlyExists($keys)
    {
        $keys = is_array($keys) ? $keys : func_get_args();
        $results = [];
        foreach ($keys as $key) {
            if ($this->has($key)) {
            $results[$key] = $this->get($key);
            }
        }
        return $results;
    }

    /**
     * Get the proper failed validation response for the request.
     *
     * @param  array  $errors
     * @return \Illuminate\Http\JsonResponse
     */
    public function response(array $errors)
    {
        return new JsonResponse([
            'data' => $errors,
        ], \Illuminate\Http\Response::HTTP_BAD_REQUEST);
    }
}