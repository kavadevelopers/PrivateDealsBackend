<?php

namespace App\Http\Requests;

use App\Enums\GenderEnum;
use App\Enums\InvestorTypeEnum;
use App\Helpers\CommonHelper;
use App\Helpers\UtillsHelper;
use App\Models\InvestorModel;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;

class StartupRequest extends FormRequest
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
        $uuid = false;
        if (request()->_method == 'PUT') {
            $uuid = $this->route('uuid');
        }
        $rules = [
            'investor_type' => ['required', Rule::enum(InvestorTypeEnum::class)],
            'name'          =>  'required|string|max:255',
            'mobile_number' => [
                'required',
                'numeric',
                'digits:10',
                Rule::unique((new InvestorModel)->getTable())->where(function ($query) use ($uuid) {
                    if ($uuid) {
                        return $query->where('is_deleted', '0')->where('uuid', '!=', $uuid);
                    }
                    return $query->where('is_deleted', '0');
                }),
            ],

            'email' => [
                'required',
                'email',
                Rule::unique((new InvestorModel)->getTable())->where(function ($query) use ($uuid) {
                    if ($uuid) {
                        return $query->where('is_deleted', '0')->where('uuid', '!=', $uuid);
                    }
                    return $query->where('is_deleted', '0');
                }),
            ],
            'address'       =>  'required|string',
            'city_id'       =>  'required',
            'pincode'       => 'required|numeric|digits:6',
            'gender'        =>  ['required', Rule::enum(GenderEnum::class)],
            'profile_photo' =>  'nullable|file|mimes:' . CommonHelper::appSettings('file_image_extensions_allowed') . '|max:' . UtillsHelper::maxFileImageSizeInKB(),
        ];
        if (!$uuid) {
            $rules['password'] = 'required';
        }

        return $rules;
    }

    /**
     * Override the response returned when validation fails.
     *
     * @param Validator $validator
     * @return void
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        // $response = redirect()
        //     ->route('admin.app-settings')
        //     ->withErrors($validator)
        //     ->withInput();

        $response =  redirect()->back()->withInput()
            ->with('error', 'Please check form errors.')->withErrors($validator);

        throw new HttpResponseException($response);
    }


    // function messages(): array
    // {
    // }
}
