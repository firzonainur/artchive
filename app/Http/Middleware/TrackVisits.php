<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackVisits
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if visit already exists for today IP
        $ip = $request->ip();
        $today = now()->startOfDay();
        
        $exists = \App\Models\Visit::where('ip_address', $ip)
            ->where('created_at', '>=', $today)
            ->exists();

        if (!$exists) {
            \App\Models\Visit::create([
                'ip_address' => $ip,
                'user_agent' => $request->header('User-Agent'),
                'user_id' => auth()->id(), // Optional
                'url' => $request->fullUrl()
            ]);
        }

        return $next($request);
    }
}
