<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Log;

class CreateWordFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|unique:words',
            'genre'=> 'required|numeric|between:1,3'
        ];
    }

    // when validation is passed, ひらがなをかたかなに変換
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $validatedData = $this->validated();
            $blockWord = $validatedData['name'];
            if (strlen($blockWord) >= 4 && isHiragana($blockWord)) {
                $this->merge(['name' => hiragana_to_katakana($blockWord)]);
            }
        });
    }

}
