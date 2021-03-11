<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Parameter;

class RestrictIpAddress
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $blockedListIp = Parameter::where(['p_key' => 'black_list_ip'])->first();
        if ($blockedListIp && in_array($request->ip(), json_decode($blockedListIp->p_value))) {
            /*return response()->json([
                'message' => 'El acceso a la aplicación ha sido restringido. Contacte a soporte.'
            ]);*/
            abort(403);
        }
        return $next($request);
    }
}
