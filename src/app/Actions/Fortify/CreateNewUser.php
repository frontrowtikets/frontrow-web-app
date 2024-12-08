<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone_number' => ['required', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $createdUser = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'phone_number' => $input['phone_number'],
            'user_type' => $input['asEventsManager'] == true  || $input['asEventsManager'] == 'true' ? 'beneficiary' : 'ticket_buyer',
            'beneficiary_status' =>  $input['asEventsManager'] == true  || $input['asEventsManager'] == 'true' ? 'inactive' : null,
            'password' => Hash::make($input['password']),
        ]);

        //Assign Ticket Buyer Permission by default
        $createdUser->givePermissionTo('ticket_buyer');


        return $createdUser;
    }
}
