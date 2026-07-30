<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:3|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'နာမည် ထည့်ဖို့လိုသည်',
            'name.max' => 'နာမည် စာလုံး အများဆုံး ၁၀၀ ထိပဲလက်ခံသည်',
            'email.required' => 'အီးမေး ထည့်ဖို့လိုသည်',
            'email.email' => 'အီးမေး ထည့်ရန် ပုံစံမှန်ဖို့လိုသည်',
            'email.unique' => 'တူညီသည့် အီးမေး ထည့်လို့မရပါ',
            'password.required' => 'ပတ်ဝေါ့ ထည့်ရန်လိုအပ်သည်',
            'password.min' => 'ပတ်ဝေါ့ အနည်းဆုံး ၈လုံးလိုအပ်သည်'
        ];
    }
}
