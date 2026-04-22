<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio | Agung Produktif</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-slate-50 font-sans">

    <nav class="bg-white shadow-sm py-6">
        <div class="max-w-6xl mx-auto px-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-blue-600">Agung<span class="text-slate-800">produktif</span></h1>
            <a href="/" class="text-sm text-slate-500 hover:text-blue-600 transition">Ke Dashboard</a>
        </div>
    </nav>

    <header class="py-16 bg-white border-b">
        <div class="max-w-4xl mx-auto text-center px-4">
            <h2 class="text-4xl font-extrabold text-slate-900 mb-4">My Completed Projects</h2>
            <p class="text-slate-600 text-lg">Kumpulan karya yang telah saya selesaikan sebagai Junior Web Programmer.
            </p>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($projects as $project)
                <div
                    class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition duration-300 border border-slate-100">

                    <div class="h-48 bg-slate-100 flex items-center justify-center overflow-hidden">
                        @if ($project->image)
                            <img src="{{ asset('uploads/' . $project->image) }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-slate-300 font-bold uppercase text-xs">No Preview Available</span>
                        @endif
                    </div>

                    <div class="p-6">
                        <div class="text-xs font-bold text-blue-500 uppercase mb-2">Web Development</div>
                        <h3 class="text-xl font-bold text-slate-800 mb-1">{{ $project->name }}</h3>

                        <p class="text-slate-600 text-sm mb-4 line-clamp-2 h-10">
                            {{ $project->description }}
                        </p>

                        <p class="text-slate-400 text-[11px] mb-4">
                            Diselesaikan pada {{ date('F Y', strtotime($project->created_at)) }}
                        </p>

                        <a href="{{ $project->link ?? '#' }}" target="_blank"
                            class="inline-block bg-slate-900 text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-blue-600 transition">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </main>

</body>

</html>
