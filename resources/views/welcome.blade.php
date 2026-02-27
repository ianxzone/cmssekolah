<x-layout>
    <!-- Hero Section -->
    <div class="relative bg-primary-900 overflow-hidden">
        <div class="absolute inset-0">
            <!-- Abstract Islamic Geometric Pattern Overlay -->
            <div
                class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/arabesque.png')] opacity-10">
            </div>
            <!-- Gradient Overlay -->
            <div class="absolute inset-0 bg-gradient-to-r from-primary-900 via-primary-900/90 to-primary-800/50"></div>
        </div>
        <div
            class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-32 flex flex-col md:flex-row items-center gap-12">
            <div class="md:w-1/2 text-white space-y-6">
                <div
                    class="inline-flex items-center gap-2 px-4 py-2 bg-primary-800/50 rounded-full border border-primary-700/50 backdrop-blur-sm">
                    <span class="w-2 h-2 rounded-full bg-secondary-400 animate-pulse"></span>
                    <span class="text-sm font-medium text-primary-100">Penerimaan Peserta Didik Baru Telah Dibuka</span>
                </div>
                <h1 class="text-4xl md:text-6xl font-bold leading-tight">
                    Mencetak Generasi <br>
                    <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-secondary-400 to-primary-200">Rabbani
                        & Berteknologi</span>
                </h1>
                <p class="text-lg text-primary-100 max-w-xl leading-relaxed">
                    Sinergi sempurna antara nilai-nilai keislaman dan kemajuan teknologi. Membekali anak Anda dengan
                    Imtaq yang kokoh dan Iptek yang mumpuni untuk masa depan gemilang.
                </p>
                <div class="flex flex-wrap gap-4 pt-4">
                    <a href="/formulir/daftar-robotik"
                        class="px-8 py-3.5 bg-secondary-500 hover:bg-secondary-400 text-white font-bold rounded-xl shadow-lg shadow-secondary-500/30 transition transform hover:-translate-y-1">
                        Daftar Ekskul Robotik
                    </a>
                    <a href="/tentang-kami"
                        class="px-8 py-3.5 bg-white/10 hover:bg-white/20 text-white font-semibold rounded-xl backdrop-blur-md border border-white/20 transition">
                        Tentang Sekolah
                    </a>
                </div>
            </div>
            <div class="md:w-1/2 relative">
                <!-- Decorative Elements -->
                <div class="absolute -top-10 -right-10 w-64 h-64 bg-secondary-500/20 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-10 -left-10 w-64 h-64 bg-primary-500/30 rounded-full blur-3xl"></div>

                <div
                    class="relative rounded-2xl overflow-hidden shadow-2xl border-4 border-white/10 rotate-2 hover:rotate-0 transition duration-500">
                    <img src="{{ asset('images/hero-students.png') }}" alt="Students coding"
                        class="w-full h-auto object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-end p-8">
                        <div>
                            <p class="text-white font-bold text-xl">Program Coding Kids</p>
                            <p class="text-gray-200 text-sm">Mengembangkan logika sejak dini</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Wave Separator -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg class="w-full h-12 md:h-24 text-gray-50 fill-current" viewBox="0 0 1440 320"
                preserveAspectRatio="none">
                <path fill-opacity="1"
                    d="M0,224L48,213.3C96,203,192,181,288,181.3C384,181,480,203,576,224C672,245,768,267,864,261.3C960,256,1056,224,1152,197.3C1248,171,1344,149,1392,138.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
                </path>
            </svg>
        </div>
    </div>

    <!-- Prayer Times & Info Widget Bar -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-12 md:-mt-20 relative z-20 mb-16">
        <div
            class="bg-white rounded-2xl shadow-xl p-6 md:p-8 flex flex-col md:flex-row gap-8 items-center divide-y md:divide-y-0 md:divide-x divide-gray-100">
            <!-- Prayer Times Widget -->
            <div class="w-full md:w-1/3 text-center md:text-left" id="prayer-widget">
                <h3 class="text-gray-500 font-medium uppercase tracking-wider text-xs mb-2">Jadwal Sholat Karawang</h3>
                <div class="flex items-end gap-2 justify-center md:justify-start">
                    <span class="text-3xl font-bold text-gray-900" id="next-prayer-name">Loading...</span>
                    <span class="text-3xl font-bold text-primary-600" id="next-prayer-time">--:--</span>
                </div>
                <div class="mt-2 text-xs text-gray-400" id="hijri-date">{{ now()->translatedFormat('l, d F Y') }}</div>
            </div>

            <!-- Quick Info -->
            <div class="w-full md:w-2/3 flex flex-wrap justify-around gap-4 pt-4 md:pt-0 pl-0 md:pl-8">
                <div class="text-center">
                    <div
                        class="flex items-center justify-center w-12 h-12 bg-primary-100 text-primary-600 rounded-full mb-2 mx-auto">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                    </div>
                    <span class="block text-sm font-bold text-gray-900">Tahfidz Quran</span>
                    <span class="text-xs text-gray-500">Program Unggulan</span>
                </div>
                <div class="text-center">
                    <div
                        class="flex items-center justify-center w-12 h-12 bg-secondary-100 text-secondary-600 rounded-full mb-2 mx-auto">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <span class="block text-sm font-bold text-gray-900">Lab Komputer</span>
                    <span class="text-xs text-gray-500">Fasilitas Modern</span>
                </div>
                <div class="text-center">
                    <div
                        class="flex items-center justify-center w-12 h-12 bg-accent-100 text-amber-600 rounded-full mb-2 mx-auto">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                            </path>
                        </svg>
                    </div>
                    <span class="block text-sm font-bold text-gray-900">Ekstrakurikuler</span>
                    <span class="text-xs text-gray-500">Beragam Pilihan</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest News Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <span class="text-primary-600 font-semibold uppercase tracking-wider text-sm">Berita Terkini</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-2">Kabar Sekolah</h2>
                </div>
                <a href="{{ route('posts.index') }}"
                    class="hidden md:inline-flex items-center gap-1 text-primary-600 font-medium hover:text-primary-700">
                    Lihat Semua
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>

            @if($latestPosts->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($latestPosts as $index => $post)
                        <article
                            class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition duration-300 overflow-hidden group border border-gray-100 flex flex-col h-full">
                            <a href="{{ route('posts.show', $post->slug) }}" class="block relative h-48 overflow-hidden">
                                @if($post->image)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($post->image) }}" alt="{{ $post->title }}"
                                        class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                                @else
                                    <img src="{{ asset('images/news-placeholder.png') }}" alt="Placeholder"
                                        class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                                @endif
                                <div class="absolute top-4 left-4">
                                    @if($post->category)
                                        <span
                                            class="bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-primary-700 shadow-sm">
                                            {{ $post->category->name }}
                                        </span>
                                    @endif
                                </div>
                            </a>
                            <div class="p-6 flex-grow flex flex-col">
                                <div class="flex items-center gap-2 text-xs text-gray-500 mb-3">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        {{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}
                                    </span>
                                </div>
                                <h3
                                    class="text-xl font-bold text-gray-900 mb-3 group-hover:text-primary-600 transition line-clamp-2">
                                    <a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
                                </h3>
                                <div class="text-gray-600 text-sm line-clamp-2 flex-grow">
                                    {{ Str::limit(strip_tags($post->content), 100) }}
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 bg-white rounded-xl shadow-sm border border-gray-100">
                    <p class="text-gray-500">Belum ada berita terbaru.</p>
                </div>
            @endif

            <div class="mt-8 text-center md:hidden">
                <a href="{{ route('posts.index') }}"
                    class="inline-block px-6 py-2 border border-primary-600 text-primary-600 font-medium rounded-lg hover:bg-primary-50">
                    Lihat Semua Berita
                </a>
            </div>
        </div>
    </section>

    <!-- Events Section -->
    <section class="py-16 bg-white relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-gray-100 rounded-full blur-3xl opacity-50"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col md:flex-row gap-12">
                <div class="md:w-1/3">
                    <span class="text-secondary-600 font-semibold uppercase tracking-wider text-sm">Agenda</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-2 mb-4">Kegiatan Mendatang</h2>
                    <p class="text-gray-600 mb-6">
                        Jangan lewatkan berbagai kegiatan inspiratif dan bermanfaat yang akan diselenggarakan oleh
                        sekolah.
                    </p>
                    <a href="{{ route('events.index') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-primary-800 text-white font-medium rounded-xl shadow-lg shadow-primary-800/20 hover:bg-primary-900 transition">
                        Lihat Kalender Agenda
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>
                <div class="md:w-2/3 space-y-4">
                    @if($upcomingEvents->count() > 0)
                        @foreach($upcomingEvents as $event)
                            <div
                                class="flex gap-4 md:gap-6 items-start p-4 rounded-2xl hover:bg-gray-50 transition border border-transparent hover:border-gray-100">
                                <div
                                    class="flex-shrink-0 w-16 h-16 md:w-20 md:h-20 bg-primary-100 rounded-xl flex flex-col items-center justify-center text-primary-800 border border-primary-200">
                                    <span class="text-2xl md:text-3xl font-bold">{{ $event->start_time->format('d') }}</span>
                                    <span class="text-xs uppercase font-semibold">{{ $event->start_time->format('M') }}</span>
                                </div>
                                <div>
                                    <h3 class="text-lg md:text-xl font-bold text-gray-900">
                                        <a href="{{ route('events.show', $event->id) }}"
                                            class="hover:text-primary-600 leading-tight block">{{ $event->title }}</a>
                                    </h3>
                                    <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-gray-500 mt-1 mb-2">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $event->start_time->format('H:i') }}
                                        </span>
                                        @if($event->location)
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                    </path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                {{ $event->location }}
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-gray-600 text-sm line-clamp-2">
                                        {{ Str::limit(strip_tags($event->description), 120) }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-8 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                            <p class="text-gray-500">Belum ada agenda kegiatan mendatang.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Prayer Times Logic
            const coords = { latitude: -6.3227, longitude: 107.3075 }; // Karawang Coordinates

            function fetchPrayerTimes() {
                const date = new Date();
                const method = 20; // Kemenag RI mostly matches close to standard methods, or 20 for Kemenag if available in libraries, but Aladhan API supports '11' (Majlis Ugama Islam Singapura) or others. '20' is Kemenag ? No. 
                // Using method 20 (Kemenag) is not directly standard in some APIs, let's use 11 or default. 
                // AlAdhan API: Method 20 is Kemenag.

                fetch(`https://api.aladhan.com/v1/timings/${Math.floor(date.getTime() / 1000)}?latitude=${coords.latitude}&longitude=${coords.longitude}&method=20`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.code === 200) {
                            updatePrayerWidget(data.data);
                        }
                    })
                    .catch(error => console.error('Error fetching prayer times:', error));
            }

            function updatePrayerWidget(data) {
                const timings = data.timings;
                const hijri = data.date.hijri;

                // Update Hijri Date
                document.getElementById('hijri-date').textContent = `${hijri.day} ${hijri.month.en} ${hijri.year}`;

                // Determine next prayer
                const prayers = [
                    { name: 'Subuh', time: timings.Fajr },
                    { name: 'Dzuhur', time: timings.Dhuhr },
                    { name: 'Ashar', time: timings.Asr },
                    { name: 'Maghrib', time: timings.Maghrib },
                    { name: 'Isya', time: timings.Isha }
                ];

                const now = new Date();
                const currentTime = now.getHours() * 60 + now.getMinutes();

                let nextPrayer = prayers[0];
                let minDiff = 24 * 60; // Max minutes in a day

                for (let prayer of prayers) {
                    const [hours, minutes] = prayer.time.split(':').map(Number);
                    const prayerTime = hours * 60 + minutes;

                    let diff = prayerTime - currentTime;
                    if (diff < 0) {
                        // If prayer passed today, consider it for tomorrow (add 24 hours) for finding closest... 
                        // But actually we just want the NEXT one.
                        // If diff is negative, it means this prayer is already passed.
                        continue;
                    }

                    if (diff < minDiff) {
                        minDiff = diff;
                        nextPrayer = prayer;
                    }
                }

                // If all passed today, next is Subuh tomorrow
                if (minDiff === 24 * 60) {
                    nextPrayer = prayers[0];
                }

                document.getElementById('next-prayer-name').textContent = nextPrayer.name;
                document.getElementById('next-prayer-time').textContent = nextPrayer.time;
            }

            fetchPrayerTimes();
        });
    </script>
</x-layout>