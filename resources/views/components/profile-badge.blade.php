@props([
'profile' => \App\Enums\ProfileType::ADMIN,
'class' => [
\App\Enums\ProfileType::ADMIN => 'warning',
\App\Enums\ProfileType::ORGANIZATION => 'info'
],
'text' => [
\App\Enums\ProfileType::ADMIN => 'administrador',
\App\Enums\ProfileType::ORGANIZATION => 'instituição'
]
])
<span class="badge badge-{{ $class[$profile] }}">
    {{ $text[$profile] }}
</span>
