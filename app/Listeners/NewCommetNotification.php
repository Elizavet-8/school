<?php

namespace App\Listeners;

use App\Events\CommetCreated;
use App\Models\Theme;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NewCommetNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    /**
     * Handle the event.
     *
     * @param  CommetCreated  $event
     * @return void
     */
    public function handle($event)
    {

        if (is_null($event))
            return;

        $theme = Theme::with(["comments"])->find($event->theme_id);

        if (is_null($theme))
            return;

        $comments = $theme->comments;

        if (empty($comments))
            return;

        foreach ($comments as $comment)
        {
            if (!is_null($comment->read_at))
                continue;

            $comment->read_at = Carbon::now("+3:00");
            $comment->save();
        }

    }
}
