<?php

namespace App\Modules\Api\V1\Requests\Sponsors;

use App\Modules\Models\Sponsor;
use Illuminate\Foundation\Http\FormRequest;

class SponsorInsertRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('post', Sponsor::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:191',
            'picture' => 'required|string|max:191',
        ];
    }
}
