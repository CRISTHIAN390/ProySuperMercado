@extends('dashboard')

@section('titulo', 'Editar Promoción')

@section('contenido')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Editar Promoción</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('promocion.update', $promocion->id_promocion) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="descripcion">Descripción:</label>
                    <input type="text" class="form-control" id="descripcion" name="descripcion" value="{{ $promocion->descripcion }}" required>
                </div>
                <div class="form-group">
                    <label for="producto">Producto:</label>
                    <select class="form-control" id="producto" name="producto" required>
                        @foreach($productos as $producto)
                            <option value="{{ $producto->id }}" {{ $producto->id == $promocion->producto_id ? 'selected' : '' }}>{{ $producto->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="fecha_inicio">Fecha de Inicio:</label>
                    <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="{{ $promocion->fecha_inicio }}" required>
                </div>
                <div class="form-group">
                    <label for="fecha_fin">Fecha de Fin:</label>
                    <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="{{ $promocion->fecha_fin }}" required>
                </div>
                <div class="form-group">
                    <label for="precio_promocional">Precio Promocional:</label>
                    <input type="number" step="0.01" class="form-control" id="precio_promocional" name="precio_promocional" value="{{ $promocion->precio_promocional }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar Promoción</button>
            </form>
        </div>
    </div>
@endsection
