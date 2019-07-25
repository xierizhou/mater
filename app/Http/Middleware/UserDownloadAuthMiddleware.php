<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\UserMaterial;
use App\Services\MaterialUrlAnalysisService;


class UserDownloadAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @throws
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $material = MaterialUrlAnalysisService::getBuildMaterial($request->url);
        if(Auth::check()){
            $user_id = Auth::user()->id;
            $user_material = UserMaterial::where('user_id',$user_id)->where('material_id',$material->id)->where('status',1)->first();
            if($user_material){

                if($user_material->current <= 0){

                    if($user_material->is_daily_reset){
                        throw new \Exception("您当日的{$material->name}下载次数已用完");
                    }else{
                        throw new \Exception("您在{$material->name}的下载次数已用完");
                    }
                }


                return $next($request);
            }

            throw new \Exception("您没有{$material->name}的下载权限，您可以点击下方的增加权限");


        }else{
            throw new \Exception("您的账号出现异常，请重新登录");
        }




    }
}
