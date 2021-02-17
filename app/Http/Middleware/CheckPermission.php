<?php

namespace App\Http\Middleware;

use Closure;

class CheckPermission
{
    public function handle($request, Closure $next)
    {
        //$response = $next($request);
        $account = \Auth::user()->account;
        if (!$account)
            return redirect('/');
        //الرابط المطلوب
        //App\Http\Controllers\Admin\CategoryController@index
        $currentAction = \Route::currentRouteAction();
        if ($account != NULL) {
            //الرابط المطلوب
            //example  App\Http\Controllers\FooBarController@index
            list($controller, $method) = explode('@', $currentAction);
            // $controller now is "App\Http\Controllers\FooBarController"
            $controller = strtolower(preg_replace('/.*\\\/', '', $controller));
            $controller = str_replace("controller", "", $controller);
            if ($method == "index")
                $method = "";
            else
                $method = "/$method";
            $url = "/account/$controller" . $method;
            $url = parse_url($url);
            $url = $url["path"];


            if (strpos($url, 'active') !== false) {
                $url = parse_url($url);
                $url = str_replace('active', '', $url);
                $url = substr($url["path"], 0, -1);
                $url=$url."/edit";

            }
             if (strpos($url, 'accept') !== false) {
                $url = parse_url($url);
                $url = str_replace('accept', '', $url);
                $url = substr($url["path"], 0, -1);
                $url=$url."/edit";

            }
            $link = \DB::table("links")->where('url', $url)->first();

            //معناه انه الرابط عليه صلاحيات
            if ($link != NULL) {
//                $haveAdminThisLink = $account->links->contains($link->id);
//                if (!$haveAdminThisLink) {
                if (!check_permission_by_id($link->id)) {
                    return redirect('/account/home/noaccess');
                }
            }
        }
        return $next($request);
    }
}
