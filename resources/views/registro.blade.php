@extends('layouts.app')
@section('content')
<main class="dd-container dd-section"><section class="dd-panel" style="max-width:520px;margin:auto"><h1>Crea tu cuenta</h1><form method="POST" action="{{ route('registrar') }}">@csrf
 <label class="dd-field">Nombre<input name="nombre" value="{{ old('nombre', auth()->user()?->nombre) }}" required maxlength="150"></label>
<label class="dd-field">Correo<input type="email" name="correo" value="{{ old('correo', auth()->user()?->correo) }}" required maxlength="190"></label>
<label class="dd-field">Contraseña<input type="password" name="password" required minlength="8" autocomplete="new-password"></label>
<label class="dd-field">Confirma la contraseña<input type="password" name="password_confirmation" autocomplete="new-password"></label>
<button class="dd-button" type="submit">Guardar</button></form></section></main>
@endsection
