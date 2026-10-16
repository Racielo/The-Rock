@extends('layouts.app')
@section('content')
<main class="dd-container dd-section"><section class="dd-panel" style="max-width:520px;margin:auto"><h1>Bienvenido a The Rock</h1><form method="POST" action="{{ route('verificar') }}">@csrf
<label class="dd-field">Correo<input type="email" name="correo" value="{{ old('correo', auth()->user()?->correo) }}" required maxlength="190"></label>
<label class="dd-field">Contraseña<input type="password" name="password" required minlength="8" autocomplete="current-password"></label>
<button class="dd-button" type="submit">Entrar</button></form><p><a href="{{ route('recuperar') }}">¿Olvidaste tu contraseña?</a></p></section></main>
@endsection
