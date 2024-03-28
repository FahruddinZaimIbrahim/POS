<?php

namespace App\Http\Controllers;
use App\Http\Requests\StorePostRequest;
use Illuminate\Http\Request;
use App\DataTables\KategoriDataTable;
use App\Models\KategoriModel;
use Illuminate\View\View;
use illuminate\Http\RedirectResponse;

class KategoriController extends Controller
{
    //index
    public function index(KategoriDataTable $dataTable)
    {
        // DB::insert('insert into m_kategori(kategori_nama, kategori_kode, created_at) values(?, ?, ?)', ['permen', '89', now()]);
        // return 'Data berhasil ditambah';

        //update
        // $row = DB::table('m_kategori')->where('kategori_kode', '89')->update(['kategori_nama' => 'Permen']);
        // return 'Data berhasil diupdate. jumlah data yang diupdate: ' . $row;

        //delete
        // $row = DB::table('m_kategori')->where('kategori_kode', '89')->delete();
        // return 'Data berhasil dihapus. jumlah data yang dihapus: ' . $row;

        //select view
        // $data = DB::table('m_kategori')->get();
        // return view('kategori', ['data' => $data]);

        // return $dataTable->render('kategori.index');

        return $dataTable->render('kategori.index');

        //tampilkan data datatable


    }
    //create
    public function create(): View
    {
        return view('kategori.create');
    }

    //store
    /*public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(
              [
                'kode_kategori' => $request->kodeKategori,
                'nama_kategori' => $request->namaKategori,
              ]
       );
       // $validated = $request->validateWithBag('category', [
        //     'kategori_kode' => 'bail|required|unique:m_kategori|max:255',
        //     'kategori_nama' => 'required'
        // ]);

         return redirect('/kategori');
    }*/
    public function store(StorePostRequest $request): RedirectResponse {
        
        $validated = $request->validated();
        
        $validated = $request->safe()->only(['kode_kategori', 'nama_kategori']);
        $validated = $request->safe()->except(['kode_kategori', 'nama_kategori']);
        
        KategoriModel::create($validated);
        
        return redirect('/kategori');
    }

    public function update($id) {
        $data = KategoriModel::find($id);
        return view('kategori.update', ['kategori' => $data]);
    }

    public function update_save(Request $request, $id) {
        $data = KategoriModel::find($id);
        $data->kode_kategori = $request->kodeKategori;
        $data->nama_kategori = $request->namaKategori;
        $data->save();

        return redirect('/kategori');
    }

    public function delete($id) {
        $data = KategoriModel::find($id);
        $data->delete();

        return redirect('/kategori');
    }
}