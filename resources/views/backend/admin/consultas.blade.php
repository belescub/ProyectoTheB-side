@extends('plantilla')
@section('contenido')

<div class="container my-5 text-white">
    <h2 class="mb-4" style="color: #77c040;">Gestión de Consultas de Clientes</h2>

    @if(session('success'))
        <div class="alert alert-success bg-dark text-success border-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive bg-dark p-3 rounded border border-secondary">
        <table class="table table-dark table-hover align-middle mb-0">
            <thead>
                <tr class="text-secondary border-bottom border-secondary">
                    <th>Cliente</th>
                    <th>Contacto</th>
                    <th>Mensaje</th>
                    <th>Estado</th>
                    <th>Respuesta</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($consultas as $consulta)
                <tr class="border-bottom border-secondary">
                    <td>
                        <strong>{{ $consulta->nombre }}</strong><br>
                        <small class="text-secondary">{{ $consulta->created_at->format('d/m/Y H:i') }}</small>
                    </td>
                    <td>
                        {{ $consulta->email }}<br>
                        <small class="text-secondary">{{ $consulta->telefono ?? 'Sin teléfono' }}</small>
                    </td>
                    <td>
                        <p class="mb-0 text-wrap" style="max-width: 300px;">{{ $consulta->mensaje }}</p>
                    </td>
                    <td>
                        @if($consulta->leido)
                            <span class="badge bg-success text-dark">Leído</span>
                        @else
                            <span class="badge bg-warning text-dark">No Leído</span>
                        @endif
                    </td>
                    <td>
                        @if($consulta->respuesta)
                            <small class="text-info d-block text-truncate" style="max-width: 200px;" title="{{ $consulta->respuesta }}">
                                <strong>Rda:</strong> {{ $consulta->respuesta }}
                            </small>
                        @else
                            <span class="text-muted small" style="color: #6c757d !important;">Sin responder</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                            
                            {{-- Botón 1: Marcar como Leído / No Leído --}}
                            <form action="{{ route('admin.consultas.leido', $consulta) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $consulta->leido ? 'btn-outline-secondary' : 'btn-outline-success' }}" title="Cambiar estado de lectura">
                                    <i class="bi {{ $consulta->leido ? 'bi-envelope' : 'bi-envelope-open' }}"></i>
                                </button>
                            </form>

                            {{-- Botón 2: Responder (Dispara el Modal) --}}
                            <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#responderModal{{ $consulta->id }}" title="Responder consulta">
                                <i class="bi bi-reply-fill"></i>
                            </button>

                            {{-- Botón 3: Borrado Lógico (Soft Delete) --}}
                            <form action="{{ route('admin.consultas.destroy', $consulta) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas mover esta consulta a la papelera?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                    <i class="bi bi-trash3-fill"></i>
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>

                {{-- MODAL PARA RESPONDER A ESTA CONSULTA ESPECÍFICA --}}
                <div class="modal fade" id="responderModal{{ $consulta->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content bg-dark text-white border-secondary">
                            <div class="modal-header border-secondary">
                                <h5 class="modal-title">Responder a {{ $consulta->nombre }}</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('admin.consultas.responder', $consulta) }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3 bg-secondary bg-opacity-10 p-2 rounded border border-secondary">
                                        <strong>Consulta original:</strong>
                                        <p class="mb-0 text-secondary mt-1">{{ $consulta->mensaje }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label for="respuesta" class="form-label text-success">Escribe tu respuesta:</label>
                                        <textarea class="form-control bg-transparent text-white border-secondary" name="respuesta" rows="4" required>{{ $consulta->respuesta }}</textarea>
                                    </div>
                                </div>
                                <div class="modal-footer border-secondary">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-success text-dark fw-bold">Guardar Respuesta</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">No hay consultas de clientes registradas en este momento.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection