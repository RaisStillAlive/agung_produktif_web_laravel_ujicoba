<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function (Request $request) {
    // Ambil input pencarian dari URL (misal: ?search=Web)
    $search = $request->query('search');

    // Ambil daftar proyek (Filter jika ada pencarian, urutkan yang terbaru)
    $allProjects = DB::table('projects')
        ->when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })
        ->latest() // Data terbaru muncul di atas
        ->get();

    // Statistik tetap dihitung dari semua data di database
    $total = DB::table('projects')->count();
    $completed = DB::table('projects')->where('status', 'Completed')->count();
    $ongoing = DB::table('projects')->where('status', 'Ongoing')->count();

    return view('welcome', compact('total', 'completed', 'ongoing', 'allProjects'));
});

Route::post('/add-project', function (Illuminate\Http\Request $request) {
    // 1. Validasi dulu semua input
    $request->validate([
        'name' => 'required|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Tambahkan nullable
    ]);

    $imageName = null;

    // 2. Jika valid, baru proses upload gambarnya
    if ($request->hasFile('image')) {
        $imageName = time() . '.' . $request->image->extension();  
        $request->image->move(public_path('uploads'), $imageName);
    }

    // 3. Simpan ke database
    DB::table('projects')->insert([
    'name' => $request->name,
    'description' => $request->description, // Simpan deskripsi
    'status' => $request->status,
    'image' => $imageName,
    'link' => $request->link, // Simpan link
    'created_at' => now(),
    'updated_at' => now(),
]);

    return redirect('/')->with('success', 'Proyek berhasil ditambah!');
});

Route::delete('/delete-project/{id}', function ($id) {
    DB::table('projects')->where('id', $id)->delete();
    return redirect('/')->with('danger', 'Proyek telah dihapus!');
});

Route::patch('/complete-project/{id}', function ($id) {
    // Perintah untuk mengubah status menjadi Completed
    DB::table('projects')->where('id', $id)->update([
        'status' => 'Completed',
        'updated_at' => now(),
    ]);

    return redirect('/')->with('success', 'Status proyek berhasil diperbarui!');
});

Route::get('/portfolio', function () {
    // Kita hanya ambil proyek yang sudah selesai (Completed)
    // supaya yang tampil adalah karya terbaik kamu
    $projects = DB::table('projects')
        ->where('status', 'Completed')
        ->latest()
        ->get();

    return view('portfolio', compact('projects'));
});

use Illuminate\Support\Facades\File; // Tambahkan ini di paling atas file

Route::delete('/delete-project/{id}', function ($id) {
    $project = DB::table('projects')->where('id', $id)->first();

    // Hapus file fisik dari folder uploads jika ada
    if ($project->image) {
        File::delete(public_path('uploads/' . $project->image));
    }

    DB::table('projects')->where('id', $id)->delete();
    return redirect('/')->with('danger', 'Proyek dan fotonya telah dihapus!');
});

Route::post('/update-project/{id}', function (Illuminate\Http\Request $request, $id) {
    $project = DB::table('projects')->where('id', $id)->first();
    $imageName = $project->image;

    if ($request->hasFile('image')) {
        // Hapus foto lama agar tidak menumpuk
        if ($project->image) {
            File::delete(public_path('uploads/' . $project->image));
        }
        
        $imageName = time() . '.' . $request->image->extension();  
        $request->image->move(public_path('uploads'), $imageName);
    }

    DB::table('projects')->where('id', $id)->update([
        'name' => $request->name,
        'status' => $request->status,
        'image' => $imageName,
        'updated_at' => now(),
    ]);

    return redirect('/')->with('success', 'Proyek berhasil diperbarui!');
});