<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Voucher;

class VocherController extends Controller
{
    public function index()
    {
        $data = Voucher::all();

        return view('admin.vocher.index', compact('data'));
    }

    public function create()
    {
        return view('admin.vocher.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'kode' => 'required|unique:vouchers',
            'potongan' => 'required|numeric',
        ]);

        Voucher::create($request->all());

        return redirect()->route('admin.vocher.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function destroy($id)
    {
        Voucher::destroy($id);

        return redirect()->route('admin.vocher.index')->with('success', 'Data berhasil dihapus');
    }
}
