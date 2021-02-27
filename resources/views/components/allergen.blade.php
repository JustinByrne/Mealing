@props([
    'icon',
    'name',
    'level' => null,
])

@switch($level)
    @case('may')
        <span {!! $attributes->merge(['class' => "allergen-level-may"]) !!}>
            <i class="{{ $icon }}" title="May Contain {{ $name }}"></i>
        </span>
        @break
    @case('yes')
        <span {!! $attributes->merge(['class' => "allergen-level-yes"]) !!}>
            <i class="{{ $icon }}" title="Contains {{ $name }}"></i>
        </span>
        @break
    @default
        <span {!! $attributes->merge(['class' => "allergen-level-no"]) !!}>
            <i class="{{ $icon }}" title="Doesn't Contain {{ $name }}"></i>
        </span>
@endswitch