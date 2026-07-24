<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;

class BarangController extends Controller
{
    // GET all
    public function index()
    {
        return response()->json(Barang::all());
    }

    // POST
    public function store(Request $request)
    {
        $barang = Barang::create($request->all());
        return response()->json($barang, 201);
    }

    // GET by ID
    public function show($id)
    {
        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json(['message' => 'Barang ga ada'], 404);
        }

        return response()->json($barang);
    }

    // PUT
    public function update(Request $request, $id)
    {
        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        $barang->update($request->all());

        return response()->json($barang);
    }

    // DELETE
    public function destroy($id)
    {
        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        $barang->delete();

        return response()->json(['message' => 'Deleted']);
    }

}
