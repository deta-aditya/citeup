<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\User' => 'App\Modules\Electrons\Users\UserPolicy',
        'App\Modules\Models\Key' => 'App\Modules\Electrons\Keys\KeyPolicy',
        'App\Modules\Models\Alert' => 'App\Modules\Electrons\Alerts\AlertPolicy',
        'App\Modules\Models\Activity' => 'App\Modules\Electrons\Activities\ActivityPolicy',
        'App\Modules\Models\Schedule' => 'App\Modules\Electrons\Activities\SchedulePolicy',
        'App\Modules\Models\Entry' => 'App\Modules\Electrons\Entries\EntryPolicy',
        'App\Modules\Models\Submission' => 'App\Modules\Electrons\Submissions\SubmissionPolicy',
        'App\Modules\Models\Document' => 'App\Modules\Electrons\Documents\DocumentPolicy',
        'App\Modules\Models\Testimonial' => 'App\Modules\Electrons\Testimonials\TestimonialPolicy',
        'App\Modules\Models\Attempt' => 'App\Modules\Electrons\Attempts\AttemptPolicy',
        'App\Modules\Models\Question' => 'App\Modules\Electrons\Questions\QuestionPolicy',
        'App\Modules\Models\Choice' => 'App\Modules\Electrons\Questions\ChoicePolicy',
        'App\Modules\Models\Answer' => 'App\Modules\Electrons\Questions\AnswerPolicy',
        'App\Modules\Models\Gallery' => 'App\Modules\Electrons\Galleries\GalleryPolicy',
        'App\Modules\Models\News' => 'App\Modules\Electrons\News\NewsPolicy',
        'App\Modules\Models\Sponsor' => 'App\Modules\Electrons\Sponsors\SponsorPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();
    }
}
