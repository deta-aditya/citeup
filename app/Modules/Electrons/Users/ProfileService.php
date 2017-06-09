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
     * The path to default profile picture.
     *
     * @var string
     */
    protected $defaultPhoto = 'images/default.jpg';

    /**
     * The path to the profile picture storage.
     *
     * @var string
     */
    protected $storage = 'images/profiles';

    /**
     * The main model for the service.
     *
     * @var Profile
     */
    protected $model = Profile::class;

    /**
     * Create a profile for the user model.
     *
     * @param  User   $user
     * @param  array  $data
     * @return this
     */
    public function makeProfile(User $user, array $data)
    {
        $cleaned = $this->clean($data);

        $cleaned['photo'] = $this->uploadPhoto($user, $cleaned['photo']);

        $user->profile()->create($cleaned);

        return $this;
    }

    /**
     * Upload the profile picture to the storage and returns the path.
     *
     * @param  User          $user
     * @param  UploadedFile  $photo
     * @return string
     */
    public function uploadPhoto(User $user, UploadedFile $photo)
    {
        if (! $photo->isValid()) {
            return $this->defaultPhoto;
        }

        $dir = $this->storage . '/' . $user->id;

        if (! Storage::exists($dir)) {
            Storage::makeDirectory($dir);
        }

        return $photo->store($dir, 'public');
    }
}
