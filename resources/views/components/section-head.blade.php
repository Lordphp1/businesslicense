@props(['title', 'subtitle' => null, 'center' => false, 'class' => null])

<div class="section-head {{ $class }}" @if ($center) style="text-align:center" @endif>
    <span class="eyebrow {{ $center ? 'eyebrow--center' : '' }}">{{ $slot ?? '' }}</span>
    <h2>{!! $title !!}</h2>
    @if ($subtitle)
        <p class="lead mb-0">{!! $subtitle !!}</p>
    @endif
</div>
