<?php

namespace App\Actions\Fortify;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update($user, array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'image', 'max:1024'],
            'presentation' => ['required', 'string', 'max:255', 'min:5'],
            'description' => ['required', 'string', 'max:1000'],
            'rate' => ['required', 'integer'],

            // 'phone' => ['required', 'string'],
            // 'fax' => ['required', 'string'],
            // 'postal_address' => ['required', 'string'],
            // 'decrees_establishing' => ['required', 'string'],
            // 'authorization_to_open' => ['required', 'string'],
            // 'web_site' => ['required', 'string'],
            // 'state' => ['required', 'string'],
            // 'region' => ['required', 'string'],
            // 'department' => ['required', 'string'],
            // 'location_site' => ['required', 'string'],

        ])->validateWithBag('updateProfileInformation');
        // dd($input);

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            // $user->forceFill([
            //     'name' => $input['name'],
            //     'email' => $input['email'],
            //     'presentation' => $input['presentation'],
            //     'description' => $input['description'],
            //     'rate' => $input['rate'],
                
            // ]);
            // dd($user);

            $user->update([
                'name' => $input['name'],
                'email' => $input['email'],
                'presentation' => $input['presentation'],
                'description' => $input['description'],
                'rate' => $input['rate'],
            ]);
            // dd($user);
            
            // ->save();

            // $insert = auth()->user()->university()->update(request()->all());
            // $insert = auth()->user()->university()->updateOrCreate([
            //     'phone' => $input['phone'],
            //     'fax' => $input['fax'],
            //     'postal_address' => $input['postal_address'],
            //     'decrees_establishing' => $input['decrees_establishing'],
            //     'authorization_to_open' => $input['authorization_to_open'],
            //     'web_site' => $input['web_site'],
            //     // 'state' => $input['state'],
            //     'region' => $input['region'],
            //     'department' => $input['department'],
            //     'location_site' => $input['location_site'],
    
            // ]);

                // dd($insert);
            
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
