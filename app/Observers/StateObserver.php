<?php

namespace App\Observers;
use App\Models\State;
use Illuminate\Support\Facades\Cache;

class StateObserver
{
    public function stateCacheClear($state)
    {
        Cache::forget("stateList");
        Cache::forget("stateList_$state->country_id");
    }
    
    public function created(State $state)
    {
        self::stateCacheClear($state);
    }

    /**
     * Handle the State "updated" event.
     *
     * @param  \App\Models\state  $state
     * @return void
     */
    public function updated(State $state)
    {
        self::stateCacheClear($state);
    }

    /**
     * Handle the State "deleted" event.
     *
     * @param  \App\Models\state  $state
     * @return void
     */
    public function deleted(State $state)
    {
        self::stateCacheClear($state);
    }

    /**
     * Handle the State "restored" event.
     *
     * @param  \App\Models\State  $state
     * @return void
     */
    public function restored(State $state)
    {
        self::stateCacheClear($state);
    }

    /**
     * Handle the State "force deleted" event.
     *
     * @param  \App\Models\State  $state
     * @return void
     */
    public function forceDeleted(State $state)
    {
        self::stateCacheClear($state);
    }
}
