<?php

namespace App\Modules\Electrons\Users;

use App\User;
use App\Modules\Models\Profile;
use App\Modules\Nucleons\Service;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProfileService extends Service
{
    /**
     * The URL to the default profile picture.
     *
     * @var Profile
     */
    protected $defaultPhoto = 'storage/images/default.jpg';

    /**
     * The main model for the service.
     *
     * @var Profile
     */
    protected $model = Profile::class;

    /**
     * Create the profile for a user.
     *
     * @param  User   $user
     * @param  array  $data
     * @return this
     */
    public function make(User $user, array $data)
    {
        $cleaned = $this->clean($data);

        if (! array_has($cleaned, 'photo')) {
            $cleaned['photo'] = $this->defaultPhoto;
        }

        $user->profile()->create($cleaned);

        return $this;
    }

    /**
     * Update the profile of a user.
     *
     * @param  User   $user
     * @param  array  $data
     * @return this
     */
    public function update(User $user, array $data)
    {
        $cleaned = $this->clean($data);
        $profile = $user->profile;

        foreach ($cleaned as $field => $value) {
            $profile->{$field} = $value;
        }

        $profile->save();

        return $this;
    }

}
