@php
use App\Enums\StatusType;
@endphp

@extends('layout.index', [
'title' => "Voluntários",
'cols' => ['Nome', 'E-mail','Causas','Habilidades', 'Status','Ações'],
'collection' => $volunteers
])

@section('fields')
    <div class="row">
        {{-- name --}}
        <x-adminlte-input
            type="text"
            name="name"
            label="Nome"
            fgroup-class="col-sm-4"
            value="{{ $inputs->name ?? '' }}"
        />

        {{-- email --}}
        <x-email-input
            fgroup-class="col-sm-4"
            value="{{ $inputs->email ?? '' }}"
        />

        {{-- status --}}
        <x-adminlte-select
            name="status"
            label="Status"
            fgroup-class="col-sm-4"
        >
            <option></option>
            <option
                value="active"
                {{ isset($inputs->status) && $inputs->status == StatusType::ACTIVE ? 'selected' : '' }}
            >
                Ativo
            </option>
            <option
                value="inactive"
                {{ isset($inputs->status) && $inputs->status == StatusType::INACTIVE ? 'selected' : '' }}
            >
                Inativo
            </option>
        </x-adminlte-select>
    </div>

    <div class="row">
        {{-- cause --}}
        <x-causes-select fgroup-class="col-sm-6" />

        {{-- skill --}}
        <x-skills-select fgroup-class="col-sm-6" />
    </div>
@endsection

@section('table-rows')
    @foreach ($volunteers as $volunteer)

        <tr>
            <!-- name -->
            <td>
                {{ $volunteer->user->first_name }} {{ $volunteer->user->last_name }}
            </td>

            <!-- email -->
            <td> {{ $volunteer->user->email }} </td>

            <!-- causes -->
            <td>
                @foreach ($volunteer->causes as $cause)
                    <span
                        class="fa-stack fa-1x"
                        title="{{ $cause->name }}"
                    >
                        <i class="fa fa-circle fa-stack-2x category-icon-background"></i>
                        <i class="fa fa-stack-1x category-icon">
                            &#x{{ $cause->fontawesome_icon_unicode }}; </i>
                    </span>
                @endforeach
            </td>
            <!-- skils -->
            <td>
                @foreach ($volunteer->skills as $skill)
                    <span
                        class="fa-stack fa-1x"
                        title="{{ $skill->name }}"
                    >
                        <i class="fa fa-circle fa-stack-2x category-icon-background"></i>
                        <i class="fa fa-stack-1x category-icon">
                            &#x{{ $skill->fontawesome_icon_unicode }}; </i>
                    </span>
                @endforeach
            </td>

            <!-- status -->
            <td>
                <span
                    class="badge badge-{{ $volunteer->user->status == \App\Enums\StatusType::ACTIVE ? 'success' : 'danger' }}"
                >
                    {{ $volunteer->user->status == \App\Enums\StatusType::ACTIVE ? 'ativo' : 'inativo' }}
                </span>
            </td>

            <!-- actions -->
            <td>
                <a
                    class="btn btn-info btn-sm"
                    href="{{ route('volunteers.edit', $volunteer->user->id) }}"
                >
                    <i class="fas fa-pencil-alt"></i> Editar
                </a>
                <button
                    class="btn btn-danger btn-sm"
                    data-toggle="modal"
                    data-target="#modal-delete"
                    onclick="deleteData('volunteers',{{ $volunteer->user->id }})"
                >
                    <i class="fas fa-trash"></i> Excluir
                </button>

            </td>
        </tr>
        </tbody>
    @endforeach
@endsection
