<?php

namespace App\Listeners;

use App\Models\Practical;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NewCommetPractical
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {

        if (is_null($event))
            return;

        $practical = Practical::with(["comments"])->find($event->practical_id);

        if (is_null($practical))
            return;

        $comments = $practical->comments;

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
