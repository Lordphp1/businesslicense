@props([
    'name',
    'size' => null,
    'class' => 'icon',
])

@php
    $file = public_path('assets/icons/' . $name . '.svg');
    $svg = is_file($file) ? file_get_contents($file) : '';

    if ($svg !== '') {
        // Strip the xml prolog and hardcode presentational attributes.
        $svg = preg_replace('/<\?xml[^>]*\?>/', '', $svg);
        $svg = str_replace(
            '<svg',
            '<svg aria-hidden="true" focusable="false"',
            $svg
        );

        // Apply sizing via class so CSS controls dimensions.
        if ($class !== null && $class !== '') {
            $svg = preg_replace('/<svg /', '<svg class="' . e($class) . '" ', $svg, 1);
        }
        if (!empty($size)) {
            $svg = preg_replace('/<svg /', '<svg width="' . e($size) . '" height="' . e($size) . '" ', $svg, 1);
        }
    }
@endphp

{!! $svg !!}
