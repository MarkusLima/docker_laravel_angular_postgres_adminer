<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\LogRequest;
use Carbon\Carbon;

class LogHttpRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $method = $request->method();
        $url = $request->fullUrl();
        $headers = $request->headers->all();
        $body = $request->all();
        $status = $response->getStatusCode();
        $responseBody = json_decode($response->getContent(), true);

        // Opcional: normaliza os dados para comparação
        $now = Carbon::now()->format('Y-m-d H:i:s');

        // Verifica se já existe um log idêntico criado no mesmo segundo
        $alreadyLogged = LogRequest::where('method', $method)
            ->where('url', $url)
            ->where('status_code', $status)
            ->whereDate('created_at', Carbon::now()->toDateString())
            ->whereTime('created_at', Carbon::now()->format('H:i:s'))
            ->exists();

        if (!$alreadyLogged) {
            LogRequest::create([
                'method' => $method,
                'url' => $url,
                'headers' => $headers,
                'body' => $body,
                'status_code' => $status,
                'response_body' => $responseBody,
            ]);
        }

        return $response;
    }
}
