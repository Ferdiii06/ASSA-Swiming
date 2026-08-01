<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AcaraController extends Controller
{
    public function index()
    {
        return view('acara.index', [
            'acaraList' => [], // nanti diganti Acara::all()
        ]);
    }

    public function create()
    {
        return view('acara.create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        return view('acara.show', [
            'acara' => null, // nanti diganti Acara::findOrFail($id)
        ]);
    }

    public function edit($id) {}
    public function update(Request $request, $id) {}
    public function destroy($id) {}
}
