<?php

namespace App\Modules\Electrons\Documents;

use App\User;
use App\Modules\Models\Document;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentPolicy
{
    use HandlesAuthorization;

    /**
     * The before hook.
     *
     * @param  User    $user
     * @param  string  $ability
     * @return bool
     */
    public function before($user, $ability)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the document list.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function get(User $user)
    {
        return $user->hasKey('get-documents') || 
            $user->entry->id == request('entry', $user->entry->id);
    }

    /**
     * Determine whether the user can view the document.
     *
     * @param  \App\User  $user
     * @param  Document  $document
     * @return mixed
     */
    public function view(User $user, Document $document)
    {
        return $user->hasKey('view-documents') || $user->entry->id === $document->entry->id;
    }

    /**
     * Determine whether the user can create document.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function post(User $user)
    {
        return $user->hasKey('post-documents') || $user->isEntrant();
    }

    /**
     * Determine whether the user can update the document.
     *
     * @param  \App\User  $user
     * @param  Document  $document
     * @return mixed
     */
    public function put(User $user, Document $document)
    {
        return $user->hasKey('put-documents') || (
                $user->isEntrant() && 
                ($user->entry->id === $document->entry->id)
            );
    }

    /**
     * Determine whether the user can delete the document.
     *
     * @param  \App\User  $user
     * @param  Document  $document
     * @return mixed
     */
    public function delete(User $user, Document $document)
    {
        return $user->hasKey('delete-documents');
    }
}
