<?php

namespace App\Http\Middleware;

use Carbon\CarbonTimeZone;
use Closure;
use Config;
use DateTime;
use DB;
use Illuminate\Http\Request;

class TimezoneMiddleware
{
    private static $TIMEZONE_HEADER = 'The-Timezone-IANA';

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @throws \Exception
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $timezone = $request->header(self::$TIMEZONE_HEADER);
        if (!$timezone) {
            $timezone = config('app.fallback_timezone');
        }
        if ($timezone) {
            $timezoneObj = new CarbonTimeZone($timezone);
            $timezone_str = (new DateTime('now', $timezoneObj->toOffsetTimeZone()))->format('P');
            config(['app.timezone' => $timezone]);
            Config::set('database.connections.mysql.timezone', $timezone_str);
            DB::reconnect('mysql');
            date_default_timezone_set($timezone);
        }

        return $next($request);
    }
}
