<div class="flex flex-row mt-3">
    <div id="user_list" class="flex flex-col gap-1 w-3/12 h-[30rem] overflow-y-scroll px-2">
        @forelse ($notifications as $notification)
            <div id="messageCard"
                class="border border-slate-200 even:bg-slate-50 rounded-lg flex flex-row justify-between align-middle items-center pl-1 pr-5 cursor-pointer hover:bg-slate-200 duration-150 transition-all"
                wire:click="selectMessage({{ $notification->id }})">
                <div class="flex flex-row p-1 gap-3 align-middle items-center">
                    <div
                        class="h-10 text-white rounded-full shadow-sm aspect-square bg-neutral flex justify-center align-middle items-center">
                        {{ strtoupper(substr($notification->name, 0, 1)) }}
                    </div>
                    <span>
                        <h3>{{ $notification->name }}</h3>
                        <span class="text-xs">{{ $notification->created_at->diffForHumans() }}</span>
                    </span>
                </div>
                <span><i class="ri-circle-fill text-green-500"></i></span>
            </div>
        @empty
            <span>Belum ada pesan</span>
        @endforelse
    </div>
    <div class="w-9/12">
        <div id="message"
            class="h-[30rem] mb-5 overflow-y-scroll p-5 text-xs border border-slate-200 rounded-lg shadow-sm">
            @foreach ($selectedMessage as $notification)
                <div class="chat {{ $notification->is_user ? 'chat-start' : 'chat-end' }}" wire:poll.1s>
                    <div class="chat-header font-semibold mb-1">
                        {{ $notification->is_user ? $notification->user->name : 'Helpdesk' }}
                    </div>
                    <div class="chat-bubble bg-slate-100 text-slate-800 text-wrap max-w-[43rem] max-sm:max-w-[20rem]">
                        <p class="break-words">{!! $notification->message !!}</p>
                    </div>
                    <div class="chat-footer text-slate-900">
                        <time class="text-xs opacity-50">{{ $notification->created_at->diffForHumans() }}</time>
                    </div>
                </div>
            @endforeach
        </div>
        <div id="chatpadd" class="w-full flex flex-row gap-2 justify-center align-middle items-center {{ $openTextEditor ? null : 'hidden' }}">
            <textarea id="expandingTextarea"
                class="w-full h-[43px] p-2 text-base border border-gray-300 rounded-md resize-none overflow-hidden"
                placeholder="Type your text here..." wire:ignore.self wire:model.live="Message"></textarea>
            <button id="sendButton" class="btn btn-neutral" wire:click="sendMessage">kirim</button>
        </div>
        @error('Message')
            <span class="label-text-alt text-red-500">{{ $message }}</span>
        @enderror
    </div>
</div>
<script>
    const textarea = document.getElementById('expandingTextarea');
    const chatpadd = document.getElementById('chatpadd');
    const sendButton = document.getElementById('sendButton');

    sendButton.addEventListener('click', function() {
        textarea.value = '';
    })

    // document.getElementById('messageCard').addEventListener('click', function() {
    //     chatpadd.classList.remove("hidden");
    // });

    textarea.addEventListener('input', autoResize);

    function autoResize() {
        this.style.height = 'auto';
        this.style.height = this.scrollHeight + 'px';
    }
</script>
</div>
