<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::withCount('reserves')->paginate(10);
        return view('clients.index', compact('clients'));
    }

    public function show(Client $client)
    {
        $client->load(['reserves' => function ($query) {
            $query->with('procedure')->orderBy('start_time', 'desc');
        }]);

        return view('clients.show', compact('client'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        try {
            $client = Client::create($request->all());
        }catch (\Exception $exception) {
            session()->flash('message', 'Cliente já cadastrado');
            return back()->withInput();
        }

        return redirect()->route('clients.show', $client);
    }
    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function update(Client $client, Request $request)
    {
        $client->update($request->all());
        return redirect()->route('clients.index');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return back();
    }
}
