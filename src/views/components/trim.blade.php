@php
$slot = trim($slot);
if (isset($prefixOverrides) && $prefixOverrides !== '') {
    $slot = preg_replace(sprintf('/^(%s)\s*/i', $prefixOverrides), '', $slot);
}
if (isset($suffixOverrides) && $suffixOverrides !== '') {
    $slot = preg_replace(sprintf('/\s*(%s)$/i', $suffixOverrides), '', $slot);
}
@endphp
{!! $slot === '' ? '' : sprintf('%s %s %s', $prefix ?? '', $slot, $suffix ?? '') !!}
