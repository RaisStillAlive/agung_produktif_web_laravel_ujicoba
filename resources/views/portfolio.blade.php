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
                    class="group bg-white rounded-3xl shadow-sm overflow-hidden hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 border border-slate-100">

                    <div class="h-52 bg-slate-200 overflow-hidden relative">
                        @if ($project->image)
                            <img src="{{ asset('uploads/' . $project->image) }}"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        @else
                            <div class="flex items-center justify-center h-full text-slate-400 bg-slate-50">
                                <span class="text-[10px] font-bold tracking-widest uppercase">No Preview</span>
                            </div>
                        @endif

                        <div class="absolute top-4 left-4">
                            <span
                                class="px-3 py-1 bg-white/90 backdrop-blur-sm text-[10px] font-bold uppercase tracking-wider text-blue-600 rounded-full shadow-sm">
                                {{ $project->status }}
                            </span>
                        </div>
                    </div>

                    <div class="p-7">
                        <div class="text-[10px] font-black text-blue-500 uppercase tracking-[0.2em] mb-2">Web
                            Development</div>
                        <h3
                            class="text-xl font-extrabold text-slate-800 mb-2 group-hover:text-blue-600 transition-colors">
                            {{ $project->name }}
                        </h3>

                        <p class="text-slate-500 text-sm mb-6 line-clamp-2 leading-relaxed">
                            {{ $project->description ?? 'Project inovatif yang dibangun dengan dedikasi tinggi untuk memberikan solusi digital.' }}
                        </p>

                        <div class="flex items-center justify-between pt-4 border-t border-slate-50">
                            <span class="text-slate-400 text-[10px] font-medium italic">
                                {{ date('M Y', strtotime($project->created_at)) }}
                            </span>
                            <a href="{{ $project->link ?? '#' }}" target="_blank"
                                class="flex items-center gap-2 text-blue-600 font-bold text-sm hover:gap-3 transition-all">
                                Explore <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </main>

</body>

</html>
