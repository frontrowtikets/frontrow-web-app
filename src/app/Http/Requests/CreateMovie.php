<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;


class CreateMovie extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $currentUser = Auth::user();
        $userPermissionDetails = $currentUser->getAllPermissions();
        $permissions = [];
        foreach ($userPermissionDetails as $perm) {
            array_push($permissions, $perm->name);
        }
        $isBeneficiary = in_array('beneficiary', $permissions);
        return $isBeneficiary;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            'title' => 'required',
            'beneficiary_id' => 'numeric',
            'description' => 'string',
            'release_date' => 'date',
            'duration' => 'string',
            'categories' => 'array',
            'language' => 'string',
            'trailer_url' => 'string',
            'is_active' => 'boolean',
            'status' => 'required',
            'maturity_rating' => 'string',
            'bannerImage' => 'file',
            'cardImage' => 'required',
            'tickets' => 'array',
            'rating' => 'numeric',
        ];
    }
}
