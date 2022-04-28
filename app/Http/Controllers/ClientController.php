<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::paginate(10);
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        Client::create($request->all());
        return redirect()->route('clients.index');
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

    public function show(Client $client)
    {
        $client->load('reserves');
        return view('clients.show', compact('client'));
    }

}
