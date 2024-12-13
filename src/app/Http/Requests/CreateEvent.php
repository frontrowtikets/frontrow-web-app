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
        if (!is_null($currentUser)) {
            return true;
        }
        return false;
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
            'description' => 'required',
            'location_name' => 'required',
            // 'gps_location' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            // 'thumbnail_url' => 'required',
            // 'currency' => 'required',
            // 'access_type' => 'required',
            // 'categories' => 'required',
            'cardImage' => 'required',
            'tickets' => 'required',
        ];
    }
}
