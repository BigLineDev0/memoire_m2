@php
    $role = Auth::user()->role ?? null;
@endphp

@if ($role === 'admin')
    @include('layouts.partials.sidebar-admin')

@elseif ($role === 'chercheur')
    @include('layouts.partials.sidebar-chercheur')

@elseif ($role === 'technicien')
    @include('layouts.partials.sidebar-technicien')
@endif
