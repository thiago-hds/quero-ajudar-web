@props([
'status' => \App\Enums\StatusType::ACTIVE,
'class' => [
\App\Enums\StatusType::ACTIVE => 'success',
\App\Enums\StatusType::INACTIVE => 'danger'
],
'text' => [
\App\Enums\StatusType::ACTIVE => 'ativo',
\App\Enums\StatusType::INACTIVE => 'inativo'
]
])
<span class="badge badge-{{ $class[$status] }}">
    {{ $text[$status] }}
</span>
