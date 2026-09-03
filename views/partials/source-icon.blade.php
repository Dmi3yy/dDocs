@if(str_starts_with((string) $sourceIcon, 'data:image/svg+xml;base64,'))
    <img class="ddocs-source-icon" src="{{ $sourceIcon }}" alt="" aria-hidden="true" />
@else
    <x-evo::icon :name="$sourceIcon" />
@endif
