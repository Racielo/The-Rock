@extends('layouts.app')
@section('content')


<main class="dd-container dd-section">
  <div class="dd-page-head"><div><div class="dd-eyebrow">PANEL ADMINISTRATIVO</div><h1>Productos y recetas</h1><p>Administra fotografías, descripciones y las materias primas que utiliza cada producto.</p></div><a href="{{ route('pedidosAdmin') }}" class="dd-button-light">Ver solicitudes →</a></div>
  <div class="dd-kpi-row"><div class="dd-kpi"><span>Productos registrados</span><strong>{{ count($productos) }}</strong></div><div class="dd-kpi"><span>Materias primas</span><strong>{{ count($ingredientes) }}</strong></div><div class="dd-kpi"><span>Recetas pendientes</span><strong>{{ count(array_filter($productos,fn($p)=>!(int)$p['numero_ingredientes'])) }}</strong></div></div>
  <div class="dd-editor-layout">
    <section class="dd-panel dd-editor">
      <div class="dd-panel-title"><span class="dd-round-icon">🍰</span><div><h2>{{ $producto ? 'Editar producto' : 'Nuevo producto' }}</h2><p>Información que verán tus clientes.</p></div></div>
      <form method="POST" enctype="multipart/form-data" action="{{ $producto ? route('editarProducto', ['id'=>$producto['id_producto']]) : route('crearProducto') }}">
      @csrf
      <label class="dd-field">Nombre del producto<input name="nombre_producto" value="{{ $producto['nombre_producto'] ?? '' }}" maxlength="255" required placeholder="Ej. Pastel de tres leches"></label>
      <label class="dd-field">Descripción breve<textarea name="descripcion" rows="2" required placeholder="Sabor, relleno, cobertura…">{{ $producto['descripcion'] ?? '' }}</textarea></label>
      <label class="dd-field">¿Cómo está elaborado?<textarea name="elaboracion" rows="3" placeholder="Ej. Bizcocho de vainilla, relleno cremoso y cubierta de crema batida…">{{ $producto['elaboracion'] ?? '' }}</textarea></label>
      <label class="dd-upload"><span>📷 Fotografía del pastel</span><input id="cargar-imagen" type="file" name="imagen" accept="image/jpeg,image/png,image/webp"><small>JPG, PNG o WEBP · máximo 5 MB. Al editar, dejar vacío conserva la anterior.</small></label>
      <div id="preview-box" class="dd-preview" {{ empty($producto['imagen']) ? 'hidden' : '' }}><img id="preview-imagen" src="{{ !empty($producto['imagen']) ? asset(preg_replace('#^public/#', '', $producto['imagen'])) : '' }}" alt="Vista previa"></div>
      <div class="dd-field-grid">
        <label class="dd-field">Precio de venta (MXN)<input type="number" name="precio_venta" step="0.01" min="0" value="{{ $producto['precio_venta'] ?? '' }}" required></label>
        <label class="dd-field">Categoría<select name="categoria" required>@foreach(['Pasteles','Pasteles para eventos','Galletas','Panadería','Postres','Bebidas','Otro'] as $cat)<option value="{{ $cat }}" {{ ($producto['categoria'] ?? 'Pasteles')===$cat?'selected':'' }}>{{ $cat }}</option>@endforeach</select></label>
        <label class="dd-field">Días de vida útil<input type="number" min="0" max="3650" name="dias_vida_util" value="{{ $producto['dias_vida_util'] ?? 3 }}" required></label>
        <label class="dd-field">Estado<select name="estado_producto">@foreach(['Activo','Temporada','Inactivo'] as $estado)<option {{ ($producto['estado_producto'] ?? 'Activo')===$estado?'selected':'' }}>{{ $estado }}</option>@endforeach</select></label>
      </div>
      <div class="dd-recipe-head"><h3>Receta por unidad</h3><p>Ingresa cuánto de cada materia prima utiliza <strong>una unidad</strong> del producto. Deja en blanco los ingredientes que no se usan.</p></div>
      <div class="dd-ingredients">
        @if(!$ingredientes)<p>Aún no hay insumos. <a href="{{ route('inventario') }}">Registrar materias primas</a>.</p>@endif
        @foreach($ingredientes as $ins)
        <label class="dd-ingredient"><span>{{ $ins['nombre'] }}<small>Disponible: {{ $ins['cantidad_actual'] }} {{ $ins['unidad_medida'] }}</small></span><span class="dd-ingredient-input"><input type="number" min="0" step="0.001" name="ingredientes[{{ (int)$ins['id_insumo'] }}]" value="{{ $receta[$ins['id_insumo']] ?? '' }}" placeholder="0"> <small>{{ $ins['unidad_medida'] }}</small></span></label>
        @endforeach
      </div>
      <p class="dd-tiny">Importante: los pedidos no se pueden aceptar sin receta configurada.</p>
      <div class="dd-form-actions"><button type="submit" class="dd-button">{{ $producto ? 'Guardar cambios' : 'Publicar producto' }}</button>@if($producto)<a class="dd-button-light" href="{{ route('productos') }}">Cancelar edición</a>@endif</div>
      </form>
    </section>
    <section class="dd-panel"><div class="dd-panel-title"><span class="dd-round-icon">📚</span><div><h2>Catálogo registrado</h2><p>{{ count($productos) }} productos en la base de datos</p></div></div>
    <div class="dd-manage-list">
      @foreach($productos as $p)
      <article class="dd-manage-item"><img src="{{ $p['imagen'] ? asset(preg_replace('#^public/#', '', $p['imagen'])) : asset('assets/img/pastel-de-chocolate.png') }}" alt="{{ $p['nombre_producto'] }}"><div><h3>{{ $p['nombre_producto'] }}</h3><small>{{ $p['categoria'] }} · ${{ number_format((float)$p['precio_venta'],2) }}</small><p>{{ (int)$p['numero_ingredientes'] ? ((int)$p['numero_ingredientes']).' ingredientes configurados' : '⚠ Falta configurar la receta' }}</p><span class="dd-status {{ $p['estado_producto']==='Inactivo'?'is-muted':'is-good' }}">{{ $p['estado_producto'] }}</span></div><div class="dd-manage-actions"><a href="{{ route('productos', ['editar'=>$p['id_producto']]) }}">Editar</a>@if($p['estado_producto']!=='Inactivo')<form method="POST" action="{{ route('borrarProducto') }}" onsubmit="return confirm('¿Ocultar este producto del catálogo?')">@csrf<input type="hidden" name="id" value="{{ (int)$p['id_producto'] }}"><button type="submit">Ocultar</button></form>@endif</div></article>
      @endforeach
      @if(!$productos)<div class="dd-empty">Aún no hay productos. Usa el formulario para crear el primero.</div>@endif
    </div></section>
  </div>
</main>
<script>
const imgField=document.getElementById('cargar-imagen');
imgField.addEventListener('change',()=>{const file=imgField.files[0];if(!file)return;const preview=document.getElementById('preview-imagen');preview.src=URL.createObjectURL(file);document.getElementById('preview-box').hidden=false;});
</script>

@endsection
