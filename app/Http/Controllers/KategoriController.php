<?php

namespace App\Http\Controllers;
use App\Http\Requests\StorePostRequest;
use Illuminate\Http\Request;
use App\DataTables\KategoriDataTable;
use App\Models\KategoriModel;
use Illuminate\View\View;
use illuminate\Http\RedirectResponse;
use Yajra\DataTables\Facades\DataTables;

class KategoriController extends Controller
{
    //index
    public function index()
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

        //return $dataTable->render('kategori.index');

        $breadcrumb = (object)[
            'title' => 'Daftar Kategori',
            'list'  => ['Home','Kategori']
        ];
        $page = (object)[
            'title' => 'Daftar kategori yang terdaftar dalam sistem'
        ];

        $activeMenu = 'kategori';

        $kategori = KategoriModel::all();
        return view('kategori.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'kategori' => $kategori]);
    }
    public function list(Request $request)
    {
        $kategoris = KategoriModel::select('kategori_id', 'kode_kategori', 'nama_kategori');
        
        return DataTables::of($kategoris)
            ->addIndexColumn()
            ->addColumn('action', function ($kategori) {
                $btn = '<a href="'.url('/kategori/' . $kategori->kategori_id).'" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="'.url('/kategori/' . $kategori->kategori_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="'.url('/kategori/'.$kategori->kategori_id).'">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure to delete this data?\');">Delete</button></form>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);    }

    //create
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Kategori',
            'list' => ['Home', 'Kategori', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah kategori baru',
        ];

        $activeMenu = 'kategori';

        return view('kategori.create', compact('breadcrumb', 'page', 'activeMenu'));    
    }
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'kode_kategori' => 'required|string|max:10',
            'nama_kategori' => 'required|string|max:100',
        ]);

        KategoriModel::create([
            'kode_kategori' => $request->kode_kategori,
            'nama_kategori' => $request->nama_kategori,
        ]);
        

        return redirect('/kategori')->with('success', 'Data level berhasil disimpan');
    }
    public function show($id)
    {
        $kategori = KategoriModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Kategori',
            'list' => ['Home', 'Kategori', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Kategori',
        ];

        $activeMenu = 'kategori';

        return view('kategori.show', compact('breadcrumb', 'page','kategori', 'activeMenu'));
    }

    public function edit($id)
    {
        $kategori = KategoriModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Kategori',
            'list' => ['Home', 'Kategori', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Kategori',
        ];

        $activeMenu = 'kategori';

        return view('kategori.edit', compact('breadcrumb', 'page','kategori', 'activeMenu'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_kategori' => 'required|string|max:10',
            'nama_kategori' => 'required|string|max:100',
        ]);

        KategoriModel::find($id)->update([
            'kode_kategori' => $request->kode_kategori,
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect('/kategori')->with('success', 'Data kategori berhasil disimpan');
    }

    public function destroy($id)
    {
        $check = KategoriModel::find($id);

        if (!$check) {
            return redirect('/kategori')->with('error', 'Data kategori tidak ditemukan');
        }

        try {
            KategoriModel::destroy($id);
            return redirect('/kategori')->with('success', 'Data kategori berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/kategori')->with('error', 'Data kategori gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
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
    }
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
    }*/
}