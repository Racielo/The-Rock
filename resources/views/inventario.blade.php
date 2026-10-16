@extends('layouts.app')
@section('content')

@php $esAdmin = (auth()->user()?->rol ?? '') === 'admin';
$editarId = (int)(request('editar', 0));
$editInsumo = null;
foreach ($inventario as $ins) if ($esAdmin && $editarId && (int)$ins['id_insumo'] === $editarId) $editInsumo = $ins;
 @endphp
<main class="dd-container dd-section">
  <div class="dd-page-head"><div><div class="dd-eyebrow">CONTROL DE INVENTARIO</div><h1>Materias primas</h1><p>Consulta existencias, niveles mínimos y fechas de caducidad.</p></div>@if($esAdmin)<a class="dd-button-light" href="{{ route('productos') }}">Gestionar recetas →</a>@endif</div>
  <div class="dd-kpi-row"><div class="dd-kpi"><span>Insumos registrados</span><strong>{{ count($inventario) }}</strong></div><div class="dd-kpi"><span>Por debajo del mínimo</span><strong>{{ count(array_filter($inventario,fn($i) => (float)$i['cantidad_actual'] <= (float)$i['stock_minimo'])) }}</strong></div><div class="dd-kpi"><span>Caducados</span><strong>{{ count(array_filter($inventario,fn($i) => $i['fecha_caducidad'] && $i['fecha_caducidad'] < date('Y-m-d'))) }}</strong></div></div>
  <div class="dd-editor-layout">
    <section class="dd-panel"><div class="dd-panel-title"><span class="dd-round-icon">📦</span><div><h2>Existencias</h2><p>Inventario actualizado</p></div></div>
      <div class="dd-inventory-list">
      @foreach($inventario as $ins)
      @php
        $cantidad=(float)$ins['cantidad_actual']; $min=(float)$ins['stock_minimo'];
        $caducado=$ins['fecha_caducidad'] && $ins['fecha_caducidad'] < date('Y-m-d');
        $bajo=$cantidad<=$min;
       @endphp
      <article class="dd-stock-item"><div class="dd-stock-top"><div><h3>{{ $ins['nombre'] }}</h3><span>{{ $ins['unidad_medida'] }} · Mínimo {{ number_format($min, 3) }}</span></div><strong>{{ number_format($cantidad,3) }} {{ $ins['unidad_medida'] }}</strong></div>
        <div class="dd-stock-bar"><span style="width:{{ $min>0 ? min(100, max(0,$cantidad/($min*2)*100)) : ($cantidad>0?100:0) }}%;background:{{ $bajo ? '#bc6666' : '#74a68c' }}"></span></div>
        <div class="dd-stock-footer"><div>@if($caducado)<span class="dd-status is-rejected">Caducado</span>@elseif($bajo)<span class="dd-status is-waiting">Stock bajo</span>@else<span class="dd-status is-good">Disponible</span>@endif
@if($ins['estado']==='Inactivo') <span class="dd-status is-muted">Inactivo</span>@endif</div>
          @if($esAdmin)<div class="dd-stock-actions"><a href="{{ route('inventario', ['editar'=>$ins['id_insumo']]) }}">Editar</a><form method="POST" action="{{ route('borrarInventario') }}" onsubmit="return confirm('¿Eliminar este insumo? No se puede eliminar si se usa en alguna receta o pedido.')">@csrf<input type="hidden" name="id" value="{{ (int)$ins['id_insumo'] }}"><button type="submit">Eliminar</button></form></div>@endif
        </div><small class="dd-tiny">Caducidad: {{ $ins['fecha_caducidad'] ? h($ins['fecha_caducidad']) : 'No especificada' }}</small></article>
      @endforeach
      @if(!$inventario)<p>No hay materias primas registradas.</p>@endif
      </div></section>
    @if($esAdmin)
    <section class="dd-panel"><div class="dd-panel-title"><span class="dd-round-icon">✍</span><div><h2>{{ $editInsumo ? 'Editar materia prima' : 'Agregar materia prima' }}</h2><p>Usa la misma unidad que emplearás en la receta.</p></div></div>
      <form method="POST" action="{{ $editInsumo ? route('editarInventario', ['id'=>$editInsumo['id_insumo']]) : route('crearInventario') }}">@csrf
        <label class="dd-field">Nombre del insumo<input type="text" name="nombre" value="{{ $editInsumo['nombre'] ?? '' }}" required placeholder="Ej. Harina de trigo"></label>
        <div class="dd-field-grid"><label class="dd-field">Cantidad disponible<input name="cantidad_actual" type="number" min="0" step="0.001" value="{{ $editInsumo['cantidad_actual'] ?? '' }}" required></label>
        <label class="dd-field">Unidad de medida<select name="unidad_medida" required>@foreach (['g','kg','ml','litros','piezas'] as $un)<option value="{{ $un }}" {{ ($editInsumo['unidad_medida'] ?? 'g')===$un?'selected':'' }}>{{ $un }}</option>@endforeach
@if($editInsumo && !in_array($editInsumo['unidad_medida'],['g','kg','ml','litros','piezas']))<option selected value="{{ $editInsumo['unidad_medida'] }}">{{ $editInsumo['unidad_medida'] }}</option>@endif</select></label>
        <label class="dd-field">Stock mínimo<input type="number" min="0" step="0.001" name="stock_minimo" value="{{ $editInsumo['stock_minimo'] ?? 0 }}" required></label>
        <label class="dd-field">Fecha de ingreso<input type="date" name="fecha_ingreso" value="{{ $editInsumo['fecha_ingreso'] ?? date('Y-m-d') }}" required></label>
        <label class="dd-field">Fecha de caducidad<input type="date" name="fecha_caducidad" value="{{ $editInsumo['fecha_caducidad'] ?? '' }}"></label>
        @if($editInsumo)<label class="dd-field">Estado<select name="estado">@foreach(['Disponible','Por caducar','Agotado','Inactivo'] as $est)<option {{ $editInsumo['estado']===$est?'selected':'' }}>{{ $est }}</option>@endforeach</select></label>@endif
        </div>
        <p class="dd-tiny">Ejemplo: para harina registra 5000 g y en la receta 350 g, no 0.35 kg. No mezcles unidades de un mismo insumo.</p>
        <div class="dd-form-actions"><button class="dd-button" type="submit">{{ $editInsumo ? 'Guardar cambios' : 'Agregar insumo' }}</button>@if($editInsumo)<a class="dd-button-light" href="{{ route('inventario') }}">Cancelar</a>@endif</div>
      </form></section>
    @else<section class="dd-panel"><h2>Solo lectura</h2><p>Como empleado puedes consultar el inventario. Solo un administrador puede modificarlo.</p><a href="{{ route('pedidosAdmin') }}" class="dd-button">Revisar pedidos</a></section>@endif
  </div>
</main>
@endsection
