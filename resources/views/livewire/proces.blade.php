<div>
    {{-- <input type="text" wire:model="nama" placeholder="nama">
    <button wire:click='send'>Send</button> --}}
    <form wire:submit='send'>
        <input type="text" wire:model="nama" placeholder="nama">
        <button wire:click='send'>Send</button>
    </form>
    {{-- <x-wawan></x-wawan> --}}
    <x-testing></x-testing>
    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nemo numquam, natus libero dolorem eveniet cum distinctio perspiciatis eligendi! Voluptates aspernatur illum cum accusantium obcaecati numquam, animi ducimus dolorem. Quos, facilis!</p>
</div>
