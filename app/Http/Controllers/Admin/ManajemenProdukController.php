<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kopi;
use Illuminate\Support\Facades\Storage;

class ManajemenProdukController extends Controller
{
    // Tampilkan semua produk dengan search & filter kategori
    public function index(Request $request)
    {
        $search = $request->input('q');
        $kategori = $request->input('kategori');

        $produk = Kopi::when($search, function ($query, $search) {
                return $query->where('nama', 'like', '%' . $search . '%');
            })
            ->when($kategori, function ($query, $kategori) {
                return $query->where('kategori', $kategori);
            })
            ->get();

        return view('admin.produk', compact('produk', 'search', 'kategori'));
    }

    // Form tambah produk
    public function create()
    {
        return view('admin.produk_tambah');
    }

    // Simpan produk baru
    public function store(Request $request)
    {
        $request->validate([
            'nama'           => 'required|string|max:100',
            'deskripsi'      => 'nullable|string',
            'asal'           => 'nullable|string|max:100',
            'profil_rasa'    => 'nullable|string|max:255',
            'catatan_seduh'  => 'nullable|string',
            'harga'          => 'required|numeric',
            'stok'           => 'required|integer',
            'kategori'       => 'required|in:Arabika,Robusta,Liberika,Blend',
            'url_gambar'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('url_gambar')) {
            $path = $request->file('url_gambar')->store('kopi', 'public');
            $data['url_gambar'] = $path;
        }

        Kopi::create($data);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    // Tampilkan form edit
    public function edit($id)
    {
        $produk = Kopi::findOrFail($id);
        return view('admin.produk_edit', compact('produk'));
    }

    // Update produk
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'           => 'required|string|max:100',
            'deskripsi'      => 'nullable|string',
            'asal'           => 'nullable|string|max:100',
            'profil_rasa'    => 'nullable|string|max:255',
            'catatan_seduh'  => 'nullable|string',
            'harga'          => 'required|numeric',
            'stok'           => 'required|integer',
            'kategori'       => 'required|in:Arabika,Robusta,Liberika,Blend',
            'url_gambar'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $produk = Kopi::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('url_gambar')) {
            if ($produk->url_gambar && Storage::disk('public')->exists($produk->url_gambar)) {
                Storage::disk('public')->delete($produk->url_gambar);
            }

            $path = $request->file('url_gambar')->store('kopi', 'public');
            $data['url_gambar'] = $path;
        }

        $produk->update($data);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diperbarui.');
    }

    // Hapus produk
    public function destroy($id)
    {
        $produk = Kopi::findOrFail($id);

        if ($produk->url_gambar && Storage::disk('public')->exists($produk->url_gambar)) {
            Storage::disk('public')->delete($produk->url_gambar);
        }

        $produk->delete();

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus.');
    }
}
