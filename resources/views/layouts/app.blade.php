<!doctype html>
<html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>The Rock · Pastelería</title><link rel="icon" href="{{ asset('assets/img/logo.png') }}"><link rel="stylesheet" href="{{ asset('assets/css/renovacion.css') }}"></head>
<body class="dd-app">
@php($rol = auth()->user()?->rol)
<header class="dd-header"><div class="dd-header-inner"><div class="dd-brand-side">
@auth<button class="dd-icon-button" onclick="abrirPanel()" aria-label="Abrir menú">☰</button>@endauth
<a class="dd-brand" href="{{ route('home') }}"><img src="{{ asset('assets/img/logo.png') }}" alt="The Rock"><span><strong>The Rock</strong><small>Pastelería artesanal</small></span></a></div>
<nav class="dd-top-links"><a href="{{ route('home') }}">Catálogo</a>
@if($rol === 'usuario')<a href="{{ route('misPedidos') }}">Mis pedidos</a>@endif
@if(in_array($rol,['admin','empleado']))<a href="{{ route('pedidosAdmin') }}">Pedidos</a><a href="{{ route('inventario') }}">Inventario</a>@endif
@if($rol === 'admin')<a href="{{ route('productos') }}">Productos</a>@endif</nav>
<div class="dd-user-side">@auth<details class="dd-account"><summary><span class="dd-avatar">{{ user_initial(auth()->user()->nombre) }}</span>{{ auth()->user()->nombre }}</summary><div class="dd-account-menu"><a href="{{ route('configuracion') }}">Mi perfil</a><form method="POST" action="{{ route('logout') }}">@csrf<button class="dd-button-light">Cerrar sesión</button></form></div></details>@else<a href="{{ route('login') }}" class="dd-link">Iniciar sesión</a><a href="{{ route('registro') }}" class="dd-button dd-button-sm">Crear cuenta</a>@endauth</div></div></header>
<aside id="sidebar" class="sidebar dd-sidebar"><div class="dd-side-head"><strong>Menú</strong><button class="dd-icon-button" onclick="cerrarPanel()">✕</button></div><ul><li><a href="{{ route('home') }}">Inicio / catálogo</a></li>
@if($rol === 'usuario')<li><a href="{{ route('misPedidos') }}">Mis pedidos</a></li>@endif
@if(in_array($rol,['admin','empleado']))<li><a href="{{ route('pedidosAdmin') }}">Gestionar pedidos</a></li><li><a href="{{ route('inventario') }}">Materias primas</a></li>@endif
@if($rol === 'admin')<li><a href="{{ route('productos') }}">Productos y recetas</a></li><li><a href="{{ route('usuarios') }}">Usuarios y empleados</a></li><li><a href="{{ route('restaurar') }}">Respaldos y restauración</a></li>@endif
@auth<li><a href="{{ route('configuracion') }}">Mi perfil</a></li>@endauth</ul></aside><div id="overlay" class="overlay dd-overlay" onclick="cerrarPanel()"></div>
@if(session('success'))<div class="dd-flash is-success" role="status">{{ session('success') }}</div>@endif
@if($errors->any())<div class="dd-flash is-error" role="alert"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
@yield('content')
<script src="{{ asset('assets/js/sidebar.js') }}"></script></body></html>
