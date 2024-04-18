<div>
    <div id="notification"
        class="absolute bottom-0 right-0 flex flex-row items-center gap-2 px-6 py-4 m-10 align-middle transition-all duration-300 bg-white rounded-md shadow-sm ">
        <div class="text-[2rem] text-transparent bg-gradient-to-r from-green-500 via-pink-500 to-red-500 bg-clip-text">
            <i class="ri-thumb-up-fill"></i>
        </div>
        {{ $message }}
        <span class="ml-4 text-lg" id="close-button"><i class="ri-close-large-line"></i></span>
    </div>
</div>
