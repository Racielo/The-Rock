@extends('layouts.app')
@section('content')

@php $editarId = (int)(request('editar', 0)); $editarUsuario = null;
foreach ($usuarios as $u) if ((int)$u['id']===$editarId) $editarUsuario = $u;
 @endphp
<main class="dd-container dd-section">
<div class="dd-page-head"><div><div class="dd-eyebrow">ADMINISTRACIÓN DE ACCESOS</div><h1>Clientes y empleados</h1><p>Administra cuentas de clientes y asigna permisos de empleado sin otorgar acceso de administrador.</p></div><a class="dd-button-light" href="{{ route('pedidosAdmin') }}">Ir a pedidos →</a></div>
<div class="dd-kpi-row"><div class="dd-kpi"><span>Cuentas registradas</span><strong>{{ count($usuarios) }}</strong></div><div class="dd-kpi"><span>Empleados</span><strong>{{ count(array_filter($usuarios,fn($u)=>$u['rol']==='empleado')) }}</strong></div><div class="dd-kpi"><span>Clientes</span><strong>{{ count(array_filter($usuarios,fn($u)=>$u['rol']==='usuario')) }}</strong></div></div>
<div class="dd-editor-layout">
<section class="dd-panel"><div class="dd-panel-title"><span class="dd-round-icon">👥</span><div><h2>Cuentas registradas</h2><p>Solo las cuentas activas pueden iniciar sesión.</p></div></div>
  <label class="dd-field">Buscar usuario<input id="buscar-usuarios" type="search" placeholder="Nombre, correo o rol"></label>
  <div class="dd-user-list">
  @foreach($usuarios as $u)<article class="dd-user-row" data-busqueda="{{ utf_lower($u['nombre'].' '.$u['correo'].' '.$u['rol']) }}"><span class="dd-avatar">{{ user_initial($u['nombre']) }}</span><div class="dd-user-details"><h3>{{ $u['nombre'] }}</h3><p>{{ $u['correo'] }}</p><span class="dd-status {{ $u['estado']==='Activo'?'is-good':'is-muted' }}">{{ $u['estado'] }}</span> <span class="dd-status is-info">{{ $u['rol']==='empleado'?'Empleado':'Cliente' }}</span></div><div class="dd-manage-actions"><a href="{{ route('usuarios', ['editar'=>$u['id']]) }}">Editar</a>@if($u['estado']==='Activo')<form method="POST" action="{{ route('borrar') }}" onsubmit="return confirm('¿Desactivar esta cuenta?')">@csrf<input type="hidden" name="id" value="{{ (int)$u['id'] }}"><button type="submit">Desactivar</button></form>@endif</div></article>@endforeach
  @if(!$usuarios)<p>No hay cuentas registradas.</p>@endif
  </div>
</section>
<section class="dd-panel"><div class="dd-panel-title"><span class="dd-round-icon">✍</span><div><h2>{{ $editarUsuario ? 'Editar cuenta' : 'Nueva cuenta' }}</h2><p>{{ $editarUsuario ? 'Actualiza datos, estado y permisos.' : 'Crea una cuenta para un cliente o empleado.' }}</p></div></div>
<form method="POST" action="{{ $editarUsuario ? route('editar', ['id'=>$editarUsuario['id']]) : route('crear') }}">@csrf
<label class="dd-field">Nombre completo<input type="text" name="nombre" value="{{ $editarUsuario['nombre'] ?? '' }}" required></label>
<label class="dd-field">Correo electrónico<input type="email" name="correo" value="{{ $editarUsuario['correo'] ?? '' }}" required></label>
<label class="dd-field">{{ $editarUsuario ? 'Nueva contraseña (opcional)' : 'Contraseña temporal (mínimo 8 caracteres)' }}<input type="password" name="pass" minlength="8" @required(!$editarUsuario)></label>
<div class="dd-field-grid"><label class="dd-field">Rol<select name="rol"><option value="usuario" {{ ($editarUsuario['rol'] ?? 'usuario')==='usuario'?'selected':'' }}>Cliente</option><option value="empleado" {{ ($editarUsuario['rol'] ?? '')==='empleado'?'selected':'' }}>Empleado</option></select></label>
@if($editarUsuario)<label class="dd-field">Estado<select name="estado"><option {{ $editarUsuario['estado']==='Activo'?'selected':'' }}>Activo</option><option {{ $editarUsuario['estado']==='Inactivo'?'selected':'' }}>Inactivo</option></select></label>@endif</div>
<p class="dd-tiny">Los empleados podrán consultar existencias y gestionar pedidos, pero no editar productos ni inventario.</p>
<div class="dd-form-actions"><button type="submit" class="dd-button">{{ $editarUsuario?'Guardar cambios':'Crear cuenta' }}</button>@if($editarUsuario)<a href="{{ route('usuarios') }}" class="dd-button-light">Cancelar</a>@endif</div></form></section>
</div></main>
<script>document.getElementById('buscar-usuarios').addEventListener('input',function(){const q=this.value.toLocaleLowerCase();document.querySelectorAll('.dd-user-row').forEach(e=>{e.hidden=!e.dataset.busqueda.includes(q)})});</script>

@endsection
