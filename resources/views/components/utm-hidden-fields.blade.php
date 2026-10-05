@php
    $utms = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content', 'fbclid', 'gclid', 'ttclid'];
@endphp

@foreach($utms as $utm)
    @if(request()->has($utm) || request()->cookie($utm))
        <input type="hidden" name="{{ $utm }}" value="{{ request()->input($utm) ?? request()->cookie($utm) }}">
    @endif
@endforeach
