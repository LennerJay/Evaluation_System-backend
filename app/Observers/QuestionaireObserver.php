<?php

namespace App\Observers;

use App\Models\Questionaire;

class QuestionaireObserver
{
    /**
     * Handle the Questionaire "created" event.
     */
    public function created(Questionaire $questionaire): void
    {
        //
    }

    /**
     * Handle the Questionaire "updated" event.
     */
    public function updated(Questionaire $questionaire): void
    {
        //
    }

    /**
     * Handle the Questionaire "deleted" event.
     */
    public function deleted(Questionaire $questionaire): void
    {
        //
    }

    /**
     * Handle the Questionaire "restored" event.
     */
    public function restored(Questionaire $questionaire): void
    {
        //
    }

    /**
     * Handle the Questionaire "force deleted" event.
     */
    public function forceDeleted(Questionaire $questionaire): void
    {
        //
    }
}
