<?php

namespace App\Http\Controllers;

use App\Services\GoogleAccountService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class GoogleSyncController extends Controller
{
    public function sync(Request $request)
    {
        $user = Auth::user();
        $service = new GoogleAccountService($user);
        $count = $service->sincronizzaCalendario();

        return back()->with('success', "Sincronizzate {$count} lezioni.");
    }

    public function reset(Request $request)
    {
        $user = Auth::user();
        $service = new GoogleAccountService($user);
        $count = $service->resetCalendario();

        return back()->with('success', "Cancellati {$count} eventi dal calendario.");
    }
}
