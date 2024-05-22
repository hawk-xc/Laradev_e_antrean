<div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    {{-- <h2 class="text-xl font-semibold">Hello {{ Auth::user()->name }}</h2> --}}
    @if (
        \App\Helpers\RoleHelper::isAdmin() ||
            \App\Helpers\RoleHelper::isTechnician() ||
            \App\Helpers\RoleHelper::isHelpdesk())
        <div class="flex flex-row w-full p-10 max-sm:p-0 justify-evenly max-sm:flex-wrap max-sm:gap-3 max-sm:text-xs">
            <div class="flex items-center h-32 align-middle bg-center bg-cover rounded-md shadow-md w-52 max-sm:w-full max-sm:p-3 max-sm:h-20"
                style="background-image: url({{ asset('images/card-background.png') }})">
                <!-- Content goes here -->
                <div class="stat">
                    <div class="text-white translate-x-3 stat-figure">
                        <i class="text-4xl shadow-sm ri-team-fill"></i>
                    </div>
                    <div class="stat-title">Total Team</div>
                    <div class="stat-value">
                        {{ $users->count() > 1 && $users->where('role_id', '==', 4)->count() > 1 ? $users->where('role_id', '<=', 3)->count() : 0 }}
                    </div>
                    <div class="stat-desc">
                        pengguna khusus
                    </div>
                </div>
            </div>
            <div class="flex items-center h-32 align-middle bg-center bg-cover rounded-md shadow-md w-52 max-sm:w-full max-sm:p-3 max-sm:h-20"
                style="background-image: url({{ asset('images/card-background.png') }})">
                <!-- Content goes here -->
                <div class="stat">
                    <div class="text-white translate-x-3 stat-figure">
                        <i class="text-4xl shadow-sm ri-coupon-line"></i>
                    </div>
                    <div class="stat-title">Total tiket</div>
                    <div class="stat-value">{{ \App\Models\Ticket::all()->count() }}</div>
                    <div class="stat-desc">
                        selesai
                        @if (\App\Models\Proces::count() > 0 && \App\Models\Ticket::count() > 0)
                            {{ ceil((\App\Models\Proces::where('status_id', '4')->count() / \App\Models\Ticket::count()) * 100) }}%
                        @else
                            0
                        @endif
                    </div>
                </div>
            </div>
            <div class="flex items-center h-32 align-middle bg-center bg-cover rounded-md shadow-md w-52 max-sm:w-full max-sm:p-3 max-sm:h-20"
                style="background-image: url({{ asset('images/card-background.png') }})">
                <!-- Content goes here -->
                <div class="stat">
                    <div class="text-white translate-x-3 stat-figure">
                        <i class="text-4xl shadow-sm ri-user-5-line"></i>
                    </div>
                    <div class="stat-title">Total pelanggan</div>
                    <div class="stat-value">
                        {{ $users->count() > 1 && $users->where('role_id', '==', 4)->count() > 1 ? $users->where('role_id', '==', 4)->count() : 0 }}
                    </div>
                    <div class="stat-desc">
                        pengguna reguler
                    </div>
                </div>
            </div>
            <div class="flex items-center h-32 align-middle bg-center bg-cover rounded-md shadow-md w-52 max-sm:w-full max-sm:p-3 max-sm:h-20"
                style="background-image: url({{ asset('images/card-background.png') }})">
                <!-- Content goes here -->
                <div class="stat">
                    <div class="text-white translate-x-3 stat-figure">
                        <i class="text-4xl shadow-sm ri-team-fill"></i>
                    </div>
                    <div class="stat-title">Tiket diproses</div>
                    <div class="stat-value">{{ \App\Models\Proces::count() > 1 ? \App\Models\Proces::count() : 0 }}
                    </div>
                    <div class="stat-desc">
                        telah diproses
                        @if (\App\Models\Proces::count() > 0 && \App\Models\Ticket::count() > 0)
                            {{ ceil((\App\Models\Proces::where('status_id', '3')->count() / \App\Models\Ticket::count()) * 100) }}%
                        @else
                            0
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div style="position: relative; height:40vh; width:90vw"
            class="flex items-center justify-center mb-11 max-sm:flex-col md:-translate-x-20 max-sm:mt-40 max-sm:mb-40 max-sm:gap-5">
            <canvas id="myChart" class="flex"></canvas>
            <canvas id="myDoughnut" class="flex"></canvas>
        </div>
    @endif
    @if (\App\Helpers\RoleHelper::isUser())
        @if ($tickets->isEmpty())
            <div class="container flex justify-center w-full p-5 align-middle max-sm:flex-col max-sm:gap-5 md:flex-row">
                <ul class="flex flex-col items-center justify-center flex-1 align-middle timeline timeline-vertical">
                    <li>
                        <div
                            class="transition-all duration-150 shadow-lg cursor-pointer active:bg-slate-800 active:text-white timeline-start timeline-box hover:bg-slate-50">
                            Register and Login</div>
                        <div class="timeline-middle">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                class="w-5 h-5">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <hr />
                    </li>
                    <li>
                        <hr />
                        <div class="timeline-middle">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                class="w-5 h-5">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <a href="{{ route('device') }}"
                            class="transition-all duration-150 shadow-lg cursor-pointer active:bg-slate-800 active:text-white timeline-end timeline-box hover:bg-slate-50">
                            Add your device</a>
                        <hr />
                    </li>
                    <li>
                        <hr />
                        <a href="{{ route('ticket') }}"
                            class="transition-all duration-150 shadow-lg cursor-pointer active:bg-slate-800 active:text-white timeline-start timeline-box hover:bg-slate-50">
                            Registering new
                            ticket</a>
                        <div class="timeline-middle">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                class="w-5 h-5">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <hr />
                    </li>
                    <li>
                        <hr />
                        <div
                            class="transition-all duration-150 shadow-lg cursor-pointer active:bg-slate-800 active:text-white timeline-end timeline-box hover:bg-slate-50">
                            Get notification</div>
                        <div class="timeline-middle">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                class="w-5 h-5">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </li>
                </ul>
                <div class="flex-1">
                    <div id="my-accordion" class="border collapse collapse-arrow border-base-300">
                        <input type="radio" name="my-accordion-2" checked="checked" />
                        <div class="text-xl font-medium collapse-title">
                            Register and Login
                        </div>
                        <div class="collapse-content">
                            <p>
                                Before you can add devices and add ticket queues, you need to register an account and
                                create
                                an
                                account with valid credentials, we will not share your data.
                            </p>
                        </div>
                    </div>
                    <div id="my-accordion" class="border collapse collapse-arrow border-base-300">
                        <input type="radio" name="my-accordion-2" />
                        <div class="text-xl font-medium collapse-title">
                            Add your device
                        </div>
                        <div class="collapse-content">
                            <p>
                                You need to add the device you have to be able to create a new ticket queue, make sure
                                the
                                data
                                you input is correct
                            </p>
                        </div>
                    </div>
                    <div id="my-accordion" class="border collapse collapse-arrow border-base-300">
                        <input type="radio" name="my-accordion-2" />
                        <div class="text-xl font-medium collapse-title">
                            Registering new ticket
                        </div>
                        <div class="collapse-content">
                            <p>
                                If you have registered your device, the next step is to register a ticket, where this
                                ticket
                                will then be processed by our helpdesk team and technicians, you can also see activity
                                history
                                and other information on the ticket page, please remember the processing rules are 3x24
                                hours
                                from the start of the ticket made
                            </p>
                        </div>
                    </div>
                    <div id="my-accordion" class="border collapse collapse-arrow border-base-300">
                        <input type="radio" name="my-accordion-2" />
                        <div class="text-xl font-medium collapse-title">
                            Get notification
                        </div>
                        <div class="collapse-content">
                            <p>
                                When the repair process is complete, our team will send a notification to the customer
                                via
                                WhatsApp number and email address, make sure to always regularly check notifications if
                                the
                                ticket status goes into repair.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="flex flex-row w-full gap-3 p-5 mt-2 shadow border-slate-400">
                <div class="avatar @if ($notifications->whereIn('is_read', false)->count() > 0) online @endif placeholder">
                    <div class="h-10 text-white rounded-full shadow-sm aspect-square bg-neutral">
                        @if (Auth::user()->user_image && !Auth::user()->user_image == 'default.png')
                            <img src="{{ Auth::user()->user_image }}" />
                        @else
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        @endif
                    </div>
                </div>
                <div class="flex justify-between w-full px-3">
                    <div class="flex flex-col text-sm">
                        <span class="font-bold">Selamat datang</span>
                        <span>{{ Auth::user()->name }}</span>
                    </div>
                    <div>
                        <div class="drawer">
                            <input id="my-drawer" type="checkbox" class="drawer-toggle" />
                            <div class="drawer-content">
                                <!-- Page content here -->
                                <label for="my-drawer" class="drawer-button btn btn-neutral"><i
                                        class="ri-message-3-line"></i> kotak pesan</label>
                            </div>

                            {{-- drawer message --}}
                            <div class="drawer-side z-50">
                                <label for="my-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
                                <ul class="menu p-4 w-96 max-sm:w-80 min-h-full bg-base-200 text-base-content gap-3">
                                    <span class="text-2xl font-semibold text-slate-700"><i
                                            class="ri-notification-2-line"></i>
                                        Notifikasi</span>
                                    <!-- Sidebar content here -->
                                    @forelse ($notifications as $notification)
                                        <li class="" onclick="my_modal_2.showModal()"
                                            wire:click="notification({{ $notification->id }})">
                                            <div
                                                class="p-4 rounded-lg shadow-sm border cursor-pointer hover:bg-slate-100 w-full flex flex-row gap-4 items-center align-middle {{ !$notification->is_read ? 'border-r-8 border-r-sky-400' : '' }}">
                                                <div class="avatar placeholder">
                                                    <div
                                                        class="h-10 text-white rounded-full shadow-sm aspect-square bg-neutral">
                                                        H
                                                    </div>
                                                </div>
                                                <div class="flex flex-col">
                                                    <span class="font-light"><i class="ri-message-3-line"></i> pesan {{ !$notification->is_read ? 'belum dibaca' : 'sudah dibaca' }}</span>
                                                    </span>
                                                    <span>{{ substr($notification->message, 0, 10) }} <span
                                                            class="italic text-sky-700">...klik
                                                            selengkapnya</span></span>
                                                </div>
                                            </div>
                                        </li>
                                    @empty
                                        <div class="flex justify-center px-5 py-20 border border-base-300">
                                            belum ada notifikasi untuk saat ini!
                                        </div>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($process->count() > 1)
                <div class="my-3">
                    @if (!$isVisible)
                        <button wire:click='hideAllData' wire:loading.attr="disabled" id="showallbutton"
                            class="btn btn-xs btn-outline"><i class="ri-stack-line"></i>
                            total
                            {{ $process->count() }} proses :
                            sembunyikan</button>
                    @else
                        <button wire:click.live='showAllData' wire:loading.attr="disabled" id="showallbutton"
                            class="btn btn-xs btn-outline"><i class="ri-stack-line"></i>
                            total
                            {{ $process->count() }} proses :
                            tampilkan semua</button>
                    @endif
                </div>
            @endif

            @php
                $now = Illuminate\Support\Carbon::now();
            @endphp

            <div id="singleCard" class="w-full my-5 shadow border-slate-400 stats">
                <div class="flex items-center justify-center align-middle stat">
                    @if ($process->first()->status_id == 1)
                        <div class="lg:tooltip" data-tip="currently registered">
                            <button class="w-32 btn btn-secondary btn-sm"><i class="ri-flag-line max-sm:hidden"></i>
                                registrasi</button>
                        </div>
                    @elseif ($process->first()->status_id == 2)
                        <div class="lg:tooltip" data-tip="vertified your ticket">
                            <button class="w-32 btn btn-accent btn-sm"><i class="ri-flag-line"></i>
                                vertifikasi</button>
                        </div>
                    @elseif ($process->first()->status_id == 3)
                        <div class="lg:tooltip" data-tip="process by team">
                            <button class="w-32 btn btn-info btn-sm"><i class="ri-flag-line"></i>
                                pengerjaan</button>
                        </div>
                    @elseif ($process->first()->status_id == 4)
                        <div class="lg:tooltip" data-tip="done">
                            <button class="w-32 btn btn-success btn-sm"><i class="ri-flag-line"></i>
                                selesai</button>
                        </div>
                    @elseif ($process->first()->status_id == 5)
                        <div class="lg:tooltip" data-tip="rejected">
                            <button class="w-32 btn btn-error btn-sm"><i class="ri-flag-line"></i>
                                ditolak</button>
                        </div>
                    @endif
                </div>

                <div class="stat">
                    <div class="stat-figure text-secondary">
                        <i class="text-3xl ri-coupon-3-line"></i>
                    </div>
                    <div class="stat-title">Tiket</div>
                    <div class="text-2xl font-semibold">tiket#{{ $tickets->first()->id_ticket }}</div>
                    <div class="stat-desc">ditambahkan {{ $tickets->first()->created_at->diffForHumans() }}</div>
                </div>

                <div class="stat">
                    <div class="stat-figure text-secondary">
                        <i class="text-3xl ri-macbook-line"></i>
                    </div>
                    <div class="stat-title">Perangkat</div>
                    <div class="text-2xl">{{ $tickets->first()->device->device_name }}</div>
                    <div class="stat-desc">ditambahkan {{ $tickets->first()->device->created_at->diffForHumans() }}
                    </div>
                </div>

                @if ($process->first()->status_id == 5)
                    <div class="flex flex-row items-center justify-center w-full align-middle">
                        <span class="font-light text-red-700">ditolak</span>
                    </div>
                @else
                    <div class="flex items-center justify-center align-middle stat">
                        <div class="grid grid-flow-col gap-5 text-center auto-cols-max">
                            <div class="flex flex-col">
                                <span class="font-mono text-5xl countdown">
                                    <span
                                        style="--value:{{ Illuminate\Support\Carbon::parse($process->first()->ticket->closed_at)->diff($now)->d }};"
                                        wire:poll></span>
                                </span>
                                hari
                            </div>
                            <div class="flex flex-col">
                                <span class="font-mono text-5xl countdown">
                                    <span
                                        style="--value:{{ Illuminate\Support\Carbon::parse($process->first()->ticket->closed_at)->diff($now)->h }};"
                                        wire:poll></span>
                                </span>
                                jam
                            </div>
                            <div class="flex flex-col">
                                <span class="font-mono text-5xl countdown">
                                    <span
                                        style="--value:{{ Illuminate\Support\Carbon::parse($process->first()->ticket->closed_at)->diff($now)->i }};"
                                        wire:poll.1s></span>
                                </span>
                                menit
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- <div class="allItem" class="hidden"> --}}
            @if (!$isVisible)
                @foreach ($process->skip(1) as $proces)
                    <div id="allItem" wire:after='hidden' class="w-full my-5 shadow border-slate-400 stats">
                        <div class="flex items-center justify-center align-middle stat">
                            @if ($proces->status_id == 1)
                                <div class="lg:tooltip" data-tip="currently registered">
                                    <button class="w-32 btn btn-secondary btn-sm"><i
                                            class="ri-flag-line max-sm:hidden"></i>
                                        registrasi</button>
                                </div>
                            @elseif ($proces->status_id == 2)
                                <div class="lg:tooltip" data-tip="vertified your ticket">
                                    <button class="w-32 btn btn-accent btn-sm"><i class="ri-flag-line"></i>
                                        vertifikasi</button>
                                </div>
                            @elseif ($proces->status_id == 3)
                                <div class="lg:tooltip" data-tip="process by team">
                                    <button class="w-32 btn btn-info btn-sm"><i class="ri-flag-line"></i>
                                        proses</button>
                                </div>
                            @elseif ($proces->status_id == 4)
                                <div class="lg:tooltip" data-tip="done">
                                    <button class="w-32 btn btn-success btn-sm"><i class="ri-flag-line"></i>
                                        selesai</button>
                                </div>
                            @elseif ($proces->status_id == 5)
                                <div class="lg:tooltip" data-tip="rejected">
                                    <button class="w-32 btn btn-error btn-sm"><i class="ri-flag-line"></i>
                                        ditolak</button>
                                </div>
                            @endif
                        </div>
                        <div class="stat">
                            <div class="stat-figure text-secondary">
                                <i class="text-3xl ri-coupon-3-line"></i>
                            </div>
                            <div class="stat-title">Tiket</div>
                            <div class="text-2xl font-semibold">ticket#{{ $proces->ticket->id_ticket }}</div>
                            <div class="stat-desc">ditambahkan {{ $proces->ticket->created_at->diffForHumans() }}
                            </div>
                        </div>

                        <div class="stat">
                            <div class="stat-figure text-secondary">
                                <i class="text-3xl ri-macbook-line"></i>
                            </div>
                            <div class="stat-title">Perangkat</div>
                            <div class="text-2xl">{{ $proces->ticket->device->device_name }}</div>
                            <div class="stat-desc">ditambahkan
                                {{ $proces->ticket->device->created_at->diffForHumans() }}
                            </div>
                        </div>

                        @if ($proces->status_id == 5)
                            <div class="flex flex-row items-center justify-center w-full align-middle">
                                <span class="font-light text-red-700">ditolak</span>
                            </div>
                        @else
                            <div class="flex items-center justify-center align-middle stat">
                                <div class="grid grid-flow-col gap-5 text-center auto-cols-max">
                                    <div class="flex flex-col">
                                        <span class="font-mono text-5xl countdown">
                                            <span
                                                style="--value:{{ Illuminate\Support\Carbon::parse($proces->ticket->closed_at)->diff($now)->d }};"
                                                wire:poll></span>
                                        </span>
                                        hari
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-mono text-5xl countdown">
                                            <span
                                                style="--value:{{ Illuminate\Support\Carbon::parse($proces->ticket->closed_at)->diff($now)->h }};"
                                                wire:poll></span>
                                        </span>
                                        jam
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-mono text-5xl countdown">
                                            <span
                                                style="--value:{{ Illuminate\Support\Carbon::parse($proces->ticket->closed_at)->diff($now)->i }};"
                                                wire:poll.1s></span>
                                        </span>
                                        menit
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            @endif
        @endif
    @endif

    @if ($message !== null)
        <dialog id="my_modal_2" class="modal" wire:ignore.self>
            <div class="modal-box">
                <h3 class="font-bold text-lg">Pesan!</h3>
                <div class="chat chat-start">
                    <div class="avatar placeholder">
                        <div class="h-10 text-white rounded-full shadow-sm aspect-square bg-neutral">
                            H
                        </div>
                    </div>
                    <div class="chat-header">
                        Admin Helpdesk
                        <time class="text-xs opacity-50">
                            {{ $message->created_at }}
                        </time>
                    </div>
                    <div class="chat-bubble bg-lime-100 text-slate-900 -translate-y-3">
                        {!! $message->message !!}
                    </div>
                    <div class="chat-footer opacity-50">
                        Delivered
                    </div>
                </div>
            </div>
            <form method="dialog" class="modal-backdrop">
                <button>close</button>
            </form>
        </dialog>
    @endif

    @php
        $jumlahDataUserPerBulan = array_fill(0, 12, 0);
        $jumlahDataTicketPerBulan = array_fill(0, 12, 0);
        $totalTicket = \App\Models\Ticket::count();
        $totalProces = \App\Models\Proces::count();
        $totalSelesai = \App\Models\Proces::where('status_id', 4)->count();

        foreach (\App\Models\User::all() as $user) {
            $bulanPembuatan = Carbon\Carbon::parse($user->created_at)->month; // Ambil nomor bulan (1 untuk Januari, 2 untuk Februari, dst.)
            $jumlahDataUserPerBulan[$bulanPembuatan - 1]++; // Tambahkan jumlah data pada bulan yang sesuai (indeks dimulai dari 0)
        }

        foreach (\App\Models\Ticket::all() as $ticket) {
            $bulanPembuatan = Carbon\Carbon::parse($ticket->created_at)->month; // Ambil nomor bulan (1 untuk Januari, 2 untuk Februari, dst.)
            $jumlahDataTicketPerBulan[$bulanPembuatan - 1]++; // Tambahkan jumlah data pada bulan yang sesuai (indeks dimulai dari 0)
        }

        $jumlahDataUserPerBulan = json_encode($jumlahDataUserPerBulan);

        $jumlahDataTicketPerBulan = json_encode($jumlahDataTicketPerBulan);
    @endphp
    <script type="text/javascript">
        $(document).ready(function() {
            const week = ['senin', 'selasa', 'rabu', 'kamis', 'jum\'at', 'sabtu', 'minggu'];

            const month = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus',
                'September', 'Oktober', 'November', 'Desember'
            ];

            const ctx = $('#myChart');
            const doughnut = $('#myDoughnut');

            new Chart(ctx, {
                data: {
                    labels: month,
                    datasets: [{
                        type: 'line',
                        label: 'statistik pengguna',
                        data: {!! $jumlahDataUserPerBulan !!},
                        borderColor: 'lightgreen',
                        borderWidth: 2,
                        tension: 0.5,
                        backgroundColor: (ctx) => {
                            const canvas = ctx.chart.ctx;
                            const gradient = canvas.createLinearGradient(0, -160, 0, 120);

                            gradient.addColorStop(0, '#8E24AA');
                            gradient.addColorStop(1, 'rgba(187, 222, 251, 0.15)');

                            return gradient;
                        },
                        fill: 'start',
                    }, {
                        type: 'line',
                        label: 'statistik tiket',
                        data: {!! $jumlahDataTicketPerBulan !!},
                        borderColor: '#7F56D9',
                        borderWidth: 2,
                        tension: 0.5,
                        backgroundColor: (ctx) => {
                            const canvas = ctx.chart.ctx;
                            const gradient = canvas.createLinearGradient(0, -160, 0, 120);

                            gradient.addColorStop(0, '#F44336');
                            gradient.addColorStop(1, '#fff');

                            return gradient;
                        },
                        fill: true,
                    }],
                },
                options: {
                    scales: {
                        // y: {
                        //     beginAtZero: true, // Mulai sumbu y dari 0
                        //     suggestedMin: 0, // Nilai minimum yang direkomendasikan
                        //     suggestedMax: 10, // Nilai maksimum yang direkomendasikan
                        //     // Atur jarak (gap) pada sumbu y secara manual
                        //     ticks: {
                        //         stepSize: 1 // Langkah (step) antar nilai sumbu y
                        //     }
                        // }
                    },
                    layout: {
                        // padding: 20
                    }
                }
            })

            new Chart(doughnut, {
                type: 'doughnut',
                data: {
                    labels: ['total tiket', 'total proses', 'total selesai'],
                    datasets: [{
                        data: [{!! $totalTicket !!}, {!! $totalProces !!},
                            {!! $totalSelesai !!}
                        ],
                        backgroundColor: ['#BBDEFB', '#FFCDD2', '#FF9800'],
                        fill: 'start',
                    }]
                },
                options: {
                    layout: {
                        // padding: 20
                    }
                }
            })
        })
    </script>
</div>
