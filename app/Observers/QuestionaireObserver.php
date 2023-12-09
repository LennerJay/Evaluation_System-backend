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
        cache()->forget('questionaires');
        cache()->forget('maxRespondents');
        cache()->flush('questionaires*');
    }

    /**
     * Handle the Questionaire "updated" event.
     */
    public function updated(Questionaire $questionaire): void
    {
        cache()->forget('questionaires');
        cache()->forget('maxRespondents');
        cache()->flush('questionaires*');
    }

    /**
     * Handle the Questionaire "deleted" event.
     */
    public function deleted(Questionaire $questionaire): void
    {
        cache()->forget('questionaires');
        cache()->forget('maxRespondents');
        cache()->flush('questionaires*');
    }

    /**
     * Handle the Questionaire "restored" event.
     */
    public function restored(Questionaire $questionaire): void
    {
        cache()->forget('questionaires');
        cache()->forget('maxRespondents');
        cache()->flush('questionaires*');
    }

    /**
     * Handle the Questionaire "force deleted" event.
     */
    public function forceDeleted(Questionaire $questionaire): void
    {
        cache()->forget('questionaires');
        cache()->forget('maxRespondents');
        cache()->flush('questionaires*');
    }
}
