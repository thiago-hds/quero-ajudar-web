@php
use App\Enums\StatusType;
@endphp

@props([
    'status' => StatusType::ACTIVE,
    'class' => [
        StatusType::ACTIVE => 'success',
        StatusType::INACTIVE => 'danger',
    ],
    'text' => [
        StatusType::ACTIVE => 'ativo',
        StatusType::INACTIVE => 'inativo',
    ],
])
<span class="badge badge-{{ $class[$status] }}">
    {{ $text[$status] }}
</span>
