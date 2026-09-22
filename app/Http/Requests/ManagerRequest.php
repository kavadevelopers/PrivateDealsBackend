<?php

namespace App\Http\Requests;

use App\Enums\AdminTypeEnum;
use App\Helpers\CommonHelper;
use App\Helpers\UtillsHelper;
use App\Models\UserAdminModel;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ManagerRequest extends FormRequest
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
            'role' => ['required', Rule::enum(AdminTypeEnum::class)],
            'name'              =>  'required|string|max:255',
            'profile_photo'     =>  'nullable|image|mimes:' . CommonHelper::appSettings('file_image_extensions_allowed') . '|max:' . UtillsHelper::maxFileImageSizeInKB(),
            'username' => [
                'required',
                'alpha_dash',
                'min:2',
                'max:30',
                Rule::unique((new UserAdminModel())->getTable())->where(function ($query) use ($uuid) {
                    if ($uuid) {
                        return $query->where('is_deleted', '0')->where('uuid', '!=', $uuid);
                    }
                    return $query->where('is_deleted', '0');
                }),
            ],
            'mobile_no' => [
                'required',
                'numeric',
                'digits:10',
                Rule::unique((new UserAdminModel())->getTable())->where(function ($query) use ($uuid) {
                    if ($uuid) {
                        return $query->where('is_deleted', '0')->where('uuid', '!=', $uuid);
                    }
                    return $query->where('is_deleted', '0');
                }),
            ],

            'email' => [
                'required',
                'email',
                Rule::unique((new UserAdminModel)->getTable())->where(function ($query) use ($uuid) {
                    if ($uuid) {
                        return $query->where('is_deleted', '0')->where('uuid', '!=', $uuid);
                    }
                    return $query->where('is_deleted', '0');
                }),
            ],
        ];
        if (!$uuid) {
            $rules['password'] = 'required';
        }

        return $rules;
    }

    protected function failedValidation(Validator $validator)
    {
        $response =  redirect()->back()->withInput()
            ->with('error', 'Please check form errors.')->withErrors($validator);

        throw new HttpResponseException($response);
    }
}
