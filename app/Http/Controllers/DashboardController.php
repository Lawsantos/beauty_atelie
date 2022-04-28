<?php

namespace App\Http\Controllers;

use App\Models\Reserve;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $reserves = Reserve::on()->whereDate('start_time', '>=', Carbon::today())
            ->whereDate('start_time', '<=', Carbon::today())
            ->with('client')
            ->orderBy('start_time')
            ->get();

        $tomorrowReserves = Reserve::on()->whereDate('start_time', '>', Carbon::today())
            ->whereDate('start_time', '<=', Carbon::today()->addDay())
            ->with('client')
            ->orderBy('start_time')
            ->get();

        return view('dashboard',compact('reserves', 'tomorrowReserves'));
    }
}
