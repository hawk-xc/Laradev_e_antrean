<div class="flex flex-row gap-5 m-4">
    <div class="w-4/12 py-5 border rounded-md shadow-md px-7 border-slate-200">
        <span class="font-semibold text-md">Our Team</span>
        <div class="divider"></div>
        <ul class="flex flex-col gap-2">
            @foreach ($coreUsers as $user)
                <div
                    class="flex items-center gap-5 p-2 transition-all duration-150 rounded-md cursor-pointer hover:bg-slate-100">
                    <div class="avatar">
                        <div class="w-12 h-12 shadow-sm mask mask-squircle">
                            <img src="{{ asset('images/computercat.jpeg') }}" alt="{{ $user->username . 'image' }}" />
                        </div>
                    </div>
                    <div>
                        <div class="font-semibold text-md">{{ $user->name }}</div>
                        <div class="text-sm opacity-90">
                            <div
                                class="flex items-center justify-center gap-2 align-middle badge badge-accent badge-outline">
                                <i class="ri-heart-2-line"></i> {{ $user->role->name }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </ul>
    </div>

    <div class="w-full p-5 border rounded-md shadow-md border-slate-200">
        <div class="overflow-x-auto">
            <table class="table">
                <!-- head -->
                <thead>
                    <tr class="p-2 rounded-md bg-slate-200">
                        <th>Client Name</th>
                        <th>Joined</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($clientUsers as $user)
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="avatar">
                                        <div class="w-12 h-12 mask mask-squircle">
                                            <img src="{{ asset('images/user-guest.png') }}  "
                                                alt="Avatar Tailwind CSS Component" />
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-bold">{{ $user->name }}</div>
                                        <div class="text-sm opacity-50">{{ '@' . $user->username }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-ghost badge-sm">{{ $user->created_at->format('d M Y') }}</span>
                            </td>
                            <th>
                                <button class="btn btn-ghost btn-xs">
                                    <i class="ri-search-2-line"></i>
                                    details
                                </button>
                                <button class="btn btn-warning btn-xs">
                                    <i class="ri-delete-bin-line"></i>
                                    delete
                                </button>
                            </th>
                        </tr>
                    @empty
                        <span>tidak ada data</span>
                    @endforelse
            </table>
        </div>
        <div class="flex flex-col items-center justify-center w-full gap-3 mt-4 align-middle lg:flex-row">
            <div class="w-3/4">
                <label class="flex items-center gap-2 input input-bordered">
                    <input wire:model.live='search' type="text" class="grow" placeholder="Search" />
                    <kbd class="kbd kbd-sm">ctrl</kbd>
                    <kbd class="kbd kbd-sm">shift</kbd>
                    <kbd class="kbd kbd-sm">K</kbd>
                </label>
            </div>
            <div class="w-1/4">
                {{ $clientUsers->links(data: ['scrollTo' => false]) }}
            </div>
        </div>
    </div>
</div>
