<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Procedure;
use App\Models\Reserve;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReserveController extends Controller
{
    public function index()
    {
        $reserves = Reserve::with('client')->orderBy('start_time')->paginate();
        return view('reserves.index', compact('reserves'));
    }

    public function create(Client $client)
    {
        $procedures = Procedure::all();
        return view('reserves.create', compact('client', 'procedures'));
    }

    public function store(Client $client, Request $request)
    {
        $startTimeData = "{$request->get('date')} {$request->get('start_time')}";
        $endTimeData = "{$request->get('date')} {$request->get('end_time')}";
        $startTime = Carbon::createFromFormat('Y-m-d H:i', $startTimeData);
        $endTime = Carbon::createFromFormat('Y-m-d H:i', $endTimeData);

        $existsReserve = Reserve::on()
            ->whereDate('start_time', $startTime)
            ->whereTime('start_time', $startTime->format('H:i'))
            ->first();

        if ($existsReserve) {
            session()->flash('message', 'Horário já reservado');
            return back()->withInput();
        }

        try {
            $client->reserves()->create([
                'procedure_id' => $request->get('procedure_id'),
                'start_time' => $startTime,
                'end_time' => $endTime
            ]);
        }catch (\Exception $exception) {
            session()->flash('message', 'Horário já reservado');
            return back()->withInput();
        }

        return redirect()->route('clients.show', $client);
    }

    public function edit(Reserve $reserve)
    {
        $procedures = Procedure::all();
        $reserve->load('client');

        return view('reserves.edit', compact('reserve', 'procedures'));
    }

    public function update(Reserve $reserve, Request $request)
    {
        $startTimeData = "{$request->get('date')} {$request->get('start_time')}";
        $endTimeData = "{$request->get('date')} {$request->get('end_time')}";
        $startTime = Carbon::createFromFormat('Y-m-d H:i', $startTimeData);
        $endTime = Carbon::createFromFormat('Y-m-d H:i', $endTimeData);

        $existsReserve = Reserve::on()
            ->whereDate('start_time', $startTime)
            ->whereTime('start_time', $startTime->format('H:i'))
            ->first();

        if ($existsReserve) {
            session()->flash('message', 'Horário já reservado');
            return back()->withInput();
        }

        try {
            $reserve->update([
                'procedure_id' => $request->get('procedure_id'),
                'start_time' => $startTime,
                'end_time' => $endTime
            ]);
        }catch (\Exception $exception) {
            session()->flash('message', 'Horário já reservado');
            return back()->withInput();
        }

        session()->flash('message', 'Agendamento atualizado.');

        return back();
    }

    public function destroy(Reserve $reserve)
    {
        $reserve->delete();

        session()->flash('message', 'Agendamento removido.');

        return back();
    }
}
