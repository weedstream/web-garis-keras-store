<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Backend\Product;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $data = Product::query()
            ->get();

        return view('admin.product.index', compact('data'));
    }

    public function create()
    {
        return view('admin.product.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'kategori' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required',
            'harga' => 'required',
        ], [
            'title.required' => 'Judul harus diisi',
            'kategori.required' => 'Kategori harus diisi',
            'image.required' => 'Gambar harus diisi',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'File harus berupa gambar dengan format jpeg, png, jpg, gif, svg',
            'image.max' => 'Ukuran file maksimal 2MB',
            'status.required' => 'Status harus diisi',
            'harga.required' => 'Harga harus diisi',
            'harga.numeric' => 'Harga harus berupa angka',
        ]);

        $imageName = time() . '.' . $request->image->extension();

        Product::create([
            'title' => $request->title,
            'kategori' => $request->kategori,
            'image' => $imageName,
            'status' => $request->status,
            'harga' => $request->harga,
        ]);

        $request->image->move(public_path('images'), $imageName);

        return redirect()->route('admin.product.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = Product::find($id);

        if (empty($data)) {
            return redirect()->route('admin.product.index')->with('error', 'Data tidak ditemukan');
        }

        return view('admin.product.edit', compact('data'));
    }

    public function update(Request $requeset, $id)
    {
        $request->validate([
            'title' => 'required',
            'kategori' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required',
            'harga' => 'required',
        ], [
            'title.required' => 'Judul harus diisi',
            'kategori.required' => 'Kategori harus diisi',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'File harus berupa gambar dengan format jpeg, png, jpg, gif, svg',
            'image.max' => 'Ukuran file maksimal 2MB',
            'status.required' => 'Status harus diisi',
            'harga.required' => 'Harga harus diisi',
            'harga.numeric' => 'Harga harus berupa angka',
        ]);

        $data = Product::find($id);

        if (empty($data)) {
            return redirect()->route('admin.product.index')->with('error', 'Data tidak ditemukan');
        }

        $imageName = $data->image;

        if ($request->image){
            unlink(public_path('img/' . $data->image));

            $imageName = time() . '.' . $request->image->extension();

            $data->update([
                'title' => $request->title,
                'kategori' => $request->kategori,
                'image' => $imageName,
                'status' => $request->status,
                'harga' => $request->harga,
            ]);

            $request->image->move(public_path('img'), $imageName);
        } else {
            $data->update([
                'title' => $request->title,
                'kategori' => $request->kategori,
                'status' => $request->status,
                'harga' => $request->harga,
            ]);
        }

        $data->update([
            'title' => $request->title,
            'kategori' => $request->kategori,
            'image' => $imageName,
            'status' => $request->status,
            'harga' => $request->harga,
        ]);

        return redirect()->route('admin.product.index')->with('success', 'Data berhasil diubah');
    }

    public function destroy($id)
    {
        $data = Product::find($id);

        if (empty($data)) {
            return redirect()->route('admin.product.index')->with('error', 'Data tidak ditemukan');
        }

        unlink(public_path('img/' . $data->image));

        $data->delete();

        return redirect()->route('admin.product.index')->with('success', 'Data berhasil dihapus');
    }
}
