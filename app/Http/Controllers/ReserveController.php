<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Reserve;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReserveController extends Controller
{
    public function index()
    {
        $reserves = Reserve::with('client')->orderBy('start_time')->paginate();
        return view('reserves.index', compact('reserves'));
    }

    public function create(Client $client)
    {
        return view('reserves.create', compact('client'));
    }

    public function store(Client $client, Request $request)
    {
        $startTimeData = "{$request->get('date')} {$request->get('start_time')}";
        $endTimeData = "{$request->get('date')} {$request->get('end_time')}";
        $startTime = Carbon::createFromFormat('Y-m-d H:i', $startTimeData);
        $end_time =Carbon::createFromFormat('Y-m-d H:i', $endTimeData);

        $existReserve = Reserve::on()
            ->whereDate('start_time', $startTime)
            ->whereTime('start_time', $startTime->format('H:i'))
            ->first();

        if ($existReserve) {
            session()->flash('message', 'Horário já reservado.');
            return back()->withInput();
        }

        try {
            $client->reserves()->create([
                'start_time' => $startTime,
                'end_time' => $end_time,
                ]);

        }catch (\Exception $exception) {
            session()->flash('message', 'Horário já reservado.');
            return back()->withInput();
        }

        return redirect()->route('clients.show', $client);
    }
}
