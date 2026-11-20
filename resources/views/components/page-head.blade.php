{{-- Interior page header for secondary pages --}}
@props(['title', 'lead' => null, 'image' => null])

<header class="page-head" @if ($image) style="--page-head-img: url('{{ asset($image) }}')" @endif>
    <div class="container container-mia">
        <nav aria-label="Breadcrumb" class="page-head__crumbs">
            <a href="{{ route('home') }}">Home</a>
            <x-icon name="chevron-right" />
            <span aria-current="page">{!! $title !!}</span>
        </nav>
        <h1>{!! $title !!}</h1>
        @if ($lead)
            <p class="lead">{!! $lead !!}</p>
        @endif
    </div>
</header>
