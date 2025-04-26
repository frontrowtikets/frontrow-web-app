<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;


class CreateEvent extends FormRequest
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
            'location_name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'cardImage' => '',
            'status' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'access_type' => 'required',
            'bannerImage' => '',
            'tickets' => 'required',
            'description' =>'string',
            'gps_location' => '',
            'categories' => 'array',
            'beneficiary_id' => 'numeric',
            'tickets'=> 'array',
            'trailer_url'=> '',
            'id' =>''
               ];
    }
}
