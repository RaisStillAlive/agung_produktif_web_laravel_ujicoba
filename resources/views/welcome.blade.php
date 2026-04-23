<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rais Produktif</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-slate-100 font-sans text-slate-900">

    <div class="flex min-h-screen">
        <aside class="w-64 bg-slate-900 text-white flex flex-col">
            <div class="p-6 text-2xl font-bold border-b border-slate-800 text-blue-400">
                Rais Produktif
            </div>
            <nav class="flex-1 p-4 space-y-2">
                <a href="#" class="block p-3 rounded bg-blue-600">Dashboard</a>
                <a href="/portfolio" class="block p-3 rounded hover:bg-slate-800 transition">Portfolio</a>
                <a href="#" class="block p-3 rounded hover:bg-slate-800 transition">Settings</a>
            </nav>
        </aside>

        <main class="flex-1 p-8">
            <header class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold">Progress Proyek Kamu</h1>
                <div class="bg-white px-4 py-2 rounded shadow-sm text-sm font-medium">
                    {{ date('l, d F Y') }}
                </div>
            </header>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-blue-500">
                    <p class="text-slate-500 text-sm uppercase font-semibold">Total Projects</p>
                    <p class="text-3xl font-bold mt-1">{{ $total }}</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-green-500">
                    <p class="text-slate-500 text-sm uppercase font-semibold">Completed</p>
                    <p class="text-3xl font-bold mt-1">{{ $completed }}</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-orange-500">
                    <p class="text-slate-500 text-sm uppercase font-semibold">Ongoing</p>
                    <p class="text-3xl font-bold mt-1">{{ $ongoing }}</p>
                </div>
            </div>

            <div class="mb-8 p-8 bg-white rounded-2xl shadow-sm border border-slate-100">
                <h3 class="font-bold mb-6 text-xl text-slate-800 flex items-center gap-2">
                    <span class="w-2 h-6 bg-blue-600 rounded-full"></span>
                    Tambah Proyek Baru
                </h3>
                <form action="/add-project" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-500 ml-1">NAMA PROYEK</label>
                            <input type="text" name="name" placeholder="Contoh: Web BPS" required
                                class="w-full px-4 py-3 rounded-xl bg-slate-50 border-transparent focus:bg-white focus:ring-2 focus:ring-blue-400 outline-none transition">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-500 ml-1">LINK PROYEK (URL)</label>
                            <input type="url" name="link" placeholder="https://github.com/RaisStillAlive/..."
                                class="w-full px-4 py-3 rounded-xl bg-slate-50 border-transparent focus:bg-white focus:ring-2 focus:ring-blue-400 outline-none transition">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 ml-1">DESKRIPSI PROYEK</label>
                        <textarea name="description" rows="3" placeholder="Ceritakan sedikit tentang teknologi yang digunakan..."
                            class="w-full px-4 py-3 rounded-xl bg-slate-50 border-transparent focus:bg-white focus:ring-2 focus:ring-blue-400 outline-none transition"></textarea>
                    </div>

                    <div class="flex flex-col md:flex-row gap-6 items-center">
                        <div class="flex-1 w-full space-y-2">
                            <label class="text-xs font-bold text-slate-500 ml-1">SCREENSHOT</label>
                            <input type="file" name="image"
                                class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>
                        <div class="w-full md:w-48 space-y-2">
                            <label class="text-xs font-bold text-slate-500 ml-1">STATUS</label>
                            <select name="status"
                                class="w-full px-4 py-3 rounded-xl bg-slate-50 border-transparent focus:bg-white focus:ring-2 focus:ring-blue-400 outline-none">
                                <option value="Ongoing">Ongoing</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>
                        <button type="submit"
                            class="w-full md:w-auto px-8 py-3 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-200 self-end">
                            Simpan Proyek
                        </button>
                    </div>
                </form>
            </div>

            <form action="/" method="GET" class="mb-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama proyek..."
                    class="px-4 py-2 rounded-lg border focus:ring-2 focus:ring-blue-400 outline-none transition">
            </form>

            <div class="bg-white p-6 rounded-xl shadow-sm border">
                <h3 class="font-bold mb-4 text-lg">Daftar Proyek Terbaru</h3>
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-slate-400 border-b">
                            <th class="pb-3">Nama Proyek</th>
                            <th class="pb-3">Status</th>
                            <th class="pb-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($allProjects as $project)
                            <tr class="border-b last:border-0 hover:bg-slate-50 transition">
                                <td class="py-4">{{ $project->name }}</td>
                                <td class="py-4">
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-semibold {{ $project->status == 'Completed' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                                        {{ $project->status }}
                                    </span>
                                </td>
                                <td class="py-4 text-right flex justify-end gap-3">
                                    @if ($project->status !== 'Completed')
                                        <form action="/complete-project/{{ $project->id }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="text-green-500 hover:text-green-700 font-medium text-sm transition">
                                                Selesai
                                            </button>
                                        </form>
                                    @endif

                                    <form action="/delete-project/{{ $project->id }}" method="POST"
                                        id="delete-form-{{ $project->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete({{ $project->id }})"
                                            class="text-red-500 hover:text-red-700 font-medium text-sm transition">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                        <script>
                            function confirmDelete(id) {
                                Swal.fire({
                                    title: 'Apakah kamu yakin?',
                                    text: "Data proyek ini akan dihapus permanen!",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Ya, Hapus!',
                                    cancelButtonText: 'Batal'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // Jika user klik Ya, jalankan submit form
                                        document.getElementById('delete-form-' + id).submit();
                                    }
                                })
                            }
                        </script>

                        @if (session('success'))
                            <script>
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: "{{ session('success') }}",
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                            </script>
                        @endif

                    </tbody>
                </table>
            </div>
        </main>
    </div>

</body>

</html>
