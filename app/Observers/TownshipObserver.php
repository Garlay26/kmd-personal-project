<?php

namespace App\Observers;
use App\Models\Township;
use Illuminate\Support\Facades\Cache;

class TownshipObserver
{
    public function townshipCacheClear($township)
    {
        Cache::forget("townshipList");
        Cache::forget("townshipList_$township->state_id");
    }
    
    public function created(Township $township)
    {
        self::townshipCacheClear($township);
    }

    /**
     * Handle the Township "updated" event.
     *
     * @param  \App\Models\township  $township
     * @return void
     */
    public function updated(Township $township)
    {
        self::townshipCacheClear($township);
    }

    /**
     * Handle the Township "deleted" event.
     *
     * @param  \App\Models\township  $township
     * @return void
     */
    public function deleted(Township $township)
    {
        self::townshipCacheClear($township);
    }

    /**
     * Handle the Township "restored" event.
     *
     * @param  \App\Models\Township  $township
     * @return void
     */
    public function restored(Township $township)
    {
        self::townshipCacheClear($township);
    }

    /**
     * Handle the Township "force deleted" event.
     *
     * @param  \App\Models\Township  $township
     * @return void
     */
    public function forceDeleted(Township $township)
    {
        self::townshipCacheClear($township);
    }
}
