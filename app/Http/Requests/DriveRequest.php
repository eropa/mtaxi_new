<?php

namespace App\Http\Requests;


use App\Rules\UniqueNameAddress;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use Illuminate\Validation\Rule;

class DriveRequest extends FormRequest
{
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
        //dump($this->request);
        $data=$this->request;
        return [
            'name' => [ 'required',
                        new UniqueNameAddress,
                        'max:255'],
        ];
    }


    public function messages()
    {
        return [
            'name.unique' => 'Уникальное имя Ф.И.О.',
        ];

    }
}
