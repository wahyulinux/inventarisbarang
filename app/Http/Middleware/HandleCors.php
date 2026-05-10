<?php namespace App\Http\Middleware; use Closure; class HandleCors { public function handle($request, Closure $next) { return $next($request); } }
