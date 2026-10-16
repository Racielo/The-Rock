@extends('layouts.app')
@section('content')

<main class="dd-container dd-section">
<div class="dd-page-head"><div><div class="dd-eyebrow">{{ $gestion ? 'ADMINISTRACIÓN DE SOLICITUDES' : 'TU HISTORIAL' }}</div><h1>{{ $gestion ? 'Bandeja de pedidos' : 'Mis pedidos' }}</h1><p>{{ $gestion ? 'Revisa cada solicitud y acepta solo cuando haya materias primas suficientes.' : 'Consulta el estado de tus encargos y cuándo están listos.' }}</p></div><a class="dd-button-light" href="{{ route('home') }}">← Volver al catálogo</a></div>
<div class="dd-kpi-row"><div class="dd-kpi"><span>Todos los pedidos</span><strong>{{ count($pedidos) }}</strong></div><div class="dd-kpi"><span>Pendientes de aprobación</span><strong>{{ count(array_filter($pedidos, fn($p) => $p['estado']==='Pendiente')) }}</strong></div><div class="dd-kpi"><span>En proceso o listos</span><strong>{{ count(array_filter($pedidos, fn($p) => in_array($p['estado'],['Aceptado','En preparación','Listo']))) }}</strong></div></div>
<div class="dd-filters"><label class="dd-field">Filtrar por estado<select id="filtrar-pedidos"><option value="">Todos los estados</option>@foreach(['Pendiente','Aceptado','En preparación','Listo','Entregado','Rechazado'] as $e)<option value="{{ $e }}">{{ $e }}</option>@endforeach</select></label></div>
<div class="dd-orders-list">
@foreach($pedidos as $p)
  <article class="dd-order-card" data-estado="{{ $p['estado'] }}">
    <div class="dd-order-top"><div><div class="dd-order-number">Pedido #{{ (int)$p['id_pedido'] }}</div><span class="dd-order-date">Solicitado el {{ date('d/m/Y H:i',strtotime($p['fecha_pedido'])) }}</span></div><span class="dd-status {{ match($p['estado']) {'Pendiente'=>'is-waiting','Rechazado'=>'is-rejected','Entregado'=>'is-good',default=>'is-info'} }}">{{ $p['estado'] }}</span></div>
    <div class="dd-order-columns"><div><span class="dd-kicker">Producto</span><h3>{{ $p['nombre_producto'] }}</h3><p>{{ (int)$p['cantidad'] }} unidad(es) · Precio por unidad: ${{ number_format((float)$p['precio_unitario'],2) }}</p></div><div><span class="dd-kicker">Total</span><h3>${{ number_format((float)$p['total'], 2) }}</h3><p>MXN</p></div><div><span class="dd-kicker">Fecha solicitada</span><h3>{{ $p['fecha_entrega'] ? h(date('d/m/Y',strtotime($p['fecha_entrega']))) : 'Por acordar' }}</h3>@if($gestion)<p>Cliente: {{ $p['cliente'] }}</p>@endif</div></div>
    @if($p['indicaciones'])<div class="dd-note">✎ <strong>Indicaciones:</strong> {{ $p['indicaciones'] }}</div>@endif
    @if($gestion)
    <div class="dd-order-actions">
      @php $botones = match($p['estado']) {
          'Pendiente'=>[['aceptar','✓ Aceptar pedido','dd-button'],['rechazar','Rechazar','dd-button-outline-danger']],
          'Aceptado'=>[['preparar','Iniciar preparación →','dd-button']],
          'En preparación'=>[['listo','Marcar como listo →','dd-button']],
          'Listo'=>[['entregar','Marcar como entregado','dd-button']],
          default=>[]
      };
       @endphp
      @foreach($botones as [$accion,$etiqueta,$clase])
      <form method="POST" action="{{ route('accionPedido') }}" @if($accion === 'rechazar') onsubmit="return confirm('¿Rechazar este pedido pendiente?')" @elseif($accion === 'aceptar') onsubmit="return confirm('¿Aceptar y descontar materias primas?')" @endif>
        @csrf<input type="hidden" name="id_pedido" value="{{ (int)$p['id_pedido'] }}"><input type="hidden" name="accion" value="{{ $accion }}"><button type="submit" class="{{ $clase }}">{{ $etiqueta }}</button>
      </form>
      @endforeach
      @if($p['estado']==='Pendiente')<small class="dd-tiny">No se ha descontado inventario.</small>@elseif($p['fecha_aceptacion'])<small class="dd-tiny">Ingredientes descontados al aceptar: {{ date('d/m/Y H:i',strtotime($p['fecha_aceptacion'])) }}</small>@endif
    </div>
    @else<div class="dd-order-actions"><span class="dd-tiny">{{ match($p['estado']) {'Pendiente'=>'Tu solicitud está pendiente de revisión.','Rechazado'=>'El pedido no fue aceptado.','Aceptado'=>'Tu pedido fue aceptado.','En preparación'=>'Estamos preparando tu pedido.','Listo'=>'Tu pedido está listo.','Entregado'=>'Tu pedido se entregó.', default=>''} }}</span></div>@endif
  </article>
@endforeach
@if(!$pedidos)<div class="dd-empty"><h3>{{ $gestion ? 'Sin pedidos registrados' : 'Todavía no has realizado pedidos' }}</h3><p>{{ $gestion ? 'Las solicitudes de los clientes aparecerán aquí.' : 'Explora nuestro catálogo y elige tu primer pastel.' }}</p><a class="dd-button" href="{{ route('home') }}">Ir al catálogo</a></div>@endif
<p id="sin-pedidos" class="dd-empty" hidden>No hay pedidos con ese estado.</p>
</div></main><script>
document.getElementById('filtrar-pedidos').addEventListener('change',function(){let n=0;document.querySelectorAll('.dd-order-card').forEach(e=>{e.hidden=!!this.value&&e.dataset.estado!==this.value;if(!e.hidden)n++});document.getElementById('sin-pedidos').hidden=n>0||!document.querySelectorAll('.dd-order-card').length;});
</script>
@endsection
