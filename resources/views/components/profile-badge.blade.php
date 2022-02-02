@php
use App\Enums\ProfileType;
@endphp

@props([
    'profile' => ProfileType::ADMIN,
    'class' => [
        ProfileType::ADMIN => 'warning',
        ProfileType::ORGANIZATION => 'info',
    ],
    'text' => [
        ProfileType::ADMIN => 'administrador',
        ProfileType::ORGANIZATION => 'instituição',
    ],
])
<span class="badge badge-{{ $class[$profile] }}">
    {{ $text[$profile] }}
</span>
