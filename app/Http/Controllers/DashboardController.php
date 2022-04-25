<?php

namespace App\Http\Controllers;

use App\Models\Reserve;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $reserves = Reserve::on()
            ->whereDate('start_time', '>=', Carbon::today())
            ->whereDate('start_time', '<=', Carbon::today())
            ->with(['client', 'procedure'])
            ->orderBy('start_time')
            ->get();

        $tomorrowReserves = Reserve::on()
            ->whereDate('start_time', '>', Carbon::today())
            ->whereDate('start_time', '<=', Carbon::today()->addDay())
            ->with(['client', 'procedure'])
            ->orderBy('start_time')
            ->get();

        return view('dashboard', compact('reserves', 'tomorrowReserves'));
    }
}
