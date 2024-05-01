<div>
    @if (!empty($fileContents))
        @php
            $lines = explode("\n", $fileContents);
        @endphp

        <div class="max-sm:text-xs mockup-code">
            @foreach ($lines as $key => $line)
                @if (!empty($line))
                    <pre data-prefix="{{ $key }}"><code>{{ $line }}</code></pre>
                @endif
            @endforeach
        </div>
    @endif
</div>
