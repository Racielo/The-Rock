@extends('layouts.app')
@section('content')


<main>
  <section class="dd-hero dd-container">
    <div class="dd-hero-copy">
      <div class="dd-eyebrow">HECHO CON CARIÑO, PARA COMPARTIR</div>
      <h1>Momentos dulces,<br><em>recuerdos inolvidables.</em></h1>
      <p>Descubre nuestros pasteles y postres artesanales. Elige tu favorito y realiza tu pedido en unos pasos.</p>
      <div class="dd-hero-actions">
        <a class="dd-button" href="#catalogo">Explorar catálogo →</a>
        @if(($rol ?? null)==='usuario')<a class="dd-button-light" href="{{ route('misPedidos') }}">Ver mis pedidos</a>@endif
      </div>
      <div class="dd-hero-foot">✦ Preparación artesanal &nbsp; ✦ Pedidos por encargo</div>
    </div>
    <div class="dd-hero-picture"><img src="{{ asset('assets/img/otropastel.jpeg') }}" alt="Pastel artesanal de la pastelería"><span>♡ Elaborados con dedicación</span></div>
  </section>
  <section id="catalogo" class="dd-container dd-section">
    <div class="dd-section-heading"><div><div class="dd-eyebrow">NUESTROS FAVORITOS</div><h2>Elige algo delicioso</h2><p>Conoce los ingredientes y la inspiración de cada creación.</p></div>
      @if(($rol ?? null)==='admin')<a class="dd-button" href="{{ route('productos') }}">+ Administrar catálogo</a>@endif
    </div>
    <div class="dd-filters"><input id="buscar-productos" type="search" aria-label="Buscar productos" placeholder="⌕ Buscar un pastel, postre o ingrediente…"><select id="filtro-categoria" aria-label="Filtrar por categoría"><option value="">Todas las categorías</option>@foreach(array_unique(array_column($productos,'categoria')) as $categoria)<option value="{{ utf_lower($categoria) }}">{{ $categoria }}</option>@endforeach</select></div>
    <div class="dd-catalog-grid" id="catalogo-lista">
      @foreach($productos as $p)
      <article class="dd-product-card" data-nombre="{{ utf_lower($p['nombre_producto'].' '.$p['descripcion'].' '.$p['elaboracion']) }}" data-categoria="{{ utf_lower($p['categoria']) }}">
        <div class="dd-product-media"><img loading="lazy" src="{{ $p['imagen'] ? asset(preg_replace('#^public/#', '', $p['imagen'])) : asset('assets/img/pastel-de-chocolate.png') }}" alt="{{ $p['nombre_producto'] }}"><span class="dd-category-pill">{{ $p['categoria'] }}</span></div>
        <div class="dd-product-body"><h3>{{ $p['nombre_producto'] }}</h3><p>{{ $p['descripcion'] }}</p>
          @if($p['elaboracion'])<details class="dd-how"><summary>¿Cómo está elaborado?</summary><p>{!! nl2br(h($p['elaboracion'])) !!}</p></details>@endif
          <div class="dd-product-footer"><span class="dd-price">${{ number_format((float)$p['precio_venta'],2) }} <small>MXN</small></span></div>
          @if(($rol ?? null)==='usuario')
            <details class="dd-order-panel"><summary class="dd-button dd-button-block">Pedir ahora →</summary>
              <form method="POST" action="{{ route('realizarPedido') }}" class="dd-order-form">
                @csrf<input type="hidden" name="id_producto" value="{{ (int)$p['id_producto'] }}">
                <label>Cantidad <input type="number" name="cantidad" min="1" max="50" value="1" required></label>
                <label>Fecha deseada de entrega <input type="date" name="fecha_entrega" min="{{ date('Y-m-d') }}"></label>
                <label>Indicaciones / mensaje para el pastel <textarea name="indicaciones" rows="2" maxlength="500" placeholder="Por ejemplo: Felicidades, Ana"></textarea></label>
                <p class="dd-tiny">Tu pedido quedará pendiente. El inventario se descontará solo al aceptarlo.</p>
                <button class="dd-button dd-button-block" type="submit">Confirmar solicitud</button>
              </form>
            </details>
          @elseif(empty($rol))<a class="dd-button dd-button-block" href="{{ route('login') }}">Inicia sesión para pedir →</a>
          @endif
        </div>
      </article>
      @endforeach
    </div>
    @if(!$productos)<div class="dd-empty"><h3>Pronto habrá nuevas creaciones 🍰</h3><p>El administrador puede comenzar a subir los productos desde su panel.</p></div>@endif
    <p id="sin-resultados" class="dd-empty" hidden>No encontramos productos con ese filtro.</p>
  </section>
</main>
<footer class="dd-footer">The Rock · Pastelería artesanal · Hecho con cariño</footer>

<script>
const buscar = document.getElementById('buscar-productos');
const categoria = document.getElementById('filtro-categoria');
function filtrar() {
 const visibles = [...document.querySelectorAll('.dd-product-card')].filter(card => {
  const coincide = card.dataset.nombre.includes(buscar.value.toLocaleLowerCase().trim()) && (!categoria.value || card.dataset.categoria===categoria.value);
  card.hidden = !coincide; return coincide;
 });
 document.getElementById('sin-resultados').hidden = visibles.length!==0 || document.querySelectorAll('.dd-product-card').length===0;
}
buscar.addEventListener('input',filtrar); categoria.addEventListener('change',filtrar);
</script>

@endsection
