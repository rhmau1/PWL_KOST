<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPenghuniApproval
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $panel = Filament::getCurrentPanel();

        if ($panel && $panel->getId() === 'penghuni') {
            /** @var \App\Models\User $user */
            $user = Auth::user();

            if ($user && $user->isPenghuni()) {
                // Get the latest payment
                $latestPayment = $user->pembayarans()->latest()->first();

                // If no successful payment OR no kos_id assigned yet
                if (!$latestPayment || $latestPayment->status !== 'verified' || !$user->penghuni->kos_id) {
                    $waitingRoute = 'filament.penghuni.pages.waiting-approval';
                    
                    if ($request->routeIs($waitingRoute)) {
                        return $next($request);
                    }

                    return redirect()->route($waitingRoute);
                }
            }
        }

        return $next($request);
    }
}
