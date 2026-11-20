@props([
    'light' => false,
    'href' => null,
    'label' => null,
    'tag' => 'Investment & Business Development',
])

<a href="{{ $href ?? route('home') }}" class="brand {{ $light ? 'brand--light' : '' }}" aria-label="{{ $label ?? config('app.name').' — Investment & Business Development — home' }}">
    {{-- Meridian mark: compass/meridian motif on navy field --}}
    <svg class="brand__mark" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true">
        <rect width="44" height="44" rx="6" fill="#102A43"/>
        <circle cx="22" cy="22" r="14.5" stroke="#C8A45D" stroke-width="1.5"/>
        <ellipse cx="22" cy="22" rx="6.5" ry="14.5" stroke="#C8A45D" stroke-width="1.2" opacity="0.85"/>
        <path d="M22 7.5V36.5" stroke="#C8A45D" stroke-width="1.2" opacity="0.85"/>
        <path d="M22 12L27 22L22 32L17 22L22 12Z" fill="#C8A45D"/>
        <circle cx="22" cy="22" r="2" fill="#0B1F33"/>
    </svg>
    <span>
        <span class="brand__name">{{ config('app.name') }}</span>
        <span class="brand__tag">{{ $tag ?? 'Investment & Business Development' }}</span>
    </span>
</a>
