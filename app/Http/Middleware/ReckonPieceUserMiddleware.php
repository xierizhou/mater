<?php

namespace App\Http\Middleware;

use Closure;

class ReckonPieceUserMiddleware
{
    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {

        $money = auth()->user()->money;
        if($money < 0){
            throw new \Exception("您已欠费，请先充值后再下载哦");
        }

        return $next($request);
    }
}
