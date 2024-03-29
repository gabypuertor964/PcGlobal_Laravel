<!-- Barra de Navegación -->
<header class="h-24 bg-indigo-600">
  <nav class="mx-4 sm:mx-12 flex font-medium text-white h-full items-center text-sm gap-x-6 gap-y-3">
    <div class="nav-1 flex flex-col sm:flex-row items-center justify-between w-full h-full">

      <!-- Logo #1 (Para pantallas más grandes que las de celular) -->
      <div class="nav-logo-pag pe-10 py-2 hidden sm:flex">
        <a href="{{route('index')}}" class="text-white hover:text-gray-400">
          <img src="{{ asset('storage/others/logotype.png') }}" class="w-24" alt="Logo PcGlobal">
        </a>
      </div>

      {{-- Buscador --}}
      <div class="search-content">
        <div class="search-panel flex nav-search">
          <div class="search-panel__results">
            <div id="searchbox"></div>
            <div id="hits"></div>
          </div>
        </div>
      </div>

      <div class="nav-right flex gap-12 w-full sm:w-fit">
        <!-- Enlaces de productos -->
        <div class="nav-productos justify-evenly hidden lg:flex gap-4 ps-3">
          <p><a class="hover:text-gray-200" href="{{route('index',"#categories")}}">Categorías</a></p>

          @if (!Auth::check())
            <p><a class="hover:text-gray-200" href="{{route('login')}}">PQRS</a></p>
          @else
            @if (Auth::user()->hasRole('cliente'))
              <p><a class="hover:text-gray-200" href="{{route('clients.pqrs.index')}}">PQRS</a></p>
            @elseif(Auth::user()->hasRole(["gerente","gestor_PQRS"]))
              <p><a class="hover:text-gray-200" href="{{route('admin.pqrs.index')}}">PQRS</a></p>
            @endif
          @endif
                  
        </div>

        <!-- Enlaces de login y carrito -->
        <div class="nav-login hidden lg:flex gap-4">

          {{-- Si el usuario no está autenticado o si está autenticado y es cliente, se muestra el carrito --}}
          @if(!Auth::check() || (Auth::check() && Auth::user()->hasRole('cliente')))
            <div class="relative">
              <a href="{{route("cart.checkout")}}" role="button" aria-label="Link for shopping cart" class="hover:text-gray-200">
                @if (Cart::count() > 0)
                <span class="absolute -top-1/4 left-1/2 transform -translate-x-1/2 -translate-y-1/2 pointer-events-none text-xs font-semibold">{{ Cart::count() }}</span>
                @endif
                <i class="fa-solid fa-cart-shopping"></i>
              </a>
            </div>
            <div class="border"></div>
          @endif

          <div class="dropdown" tabindex="0">
            <button class="hover:text-gray-200" id="dropdownButton">
              <i class="fa-regular fa-user"></i>
            </button>
            <div class="dropdown-menu-l" id="dropdownMenu" tabindex="-1">
              @if (auth()->check())                
                <a href="{{route("redirect")}}" aria-label="Link for dashboard" class="item">Mi Cuenta</a>

                {{-- Formulario de cierre de sesion --}}
                <form action="{{route('logout')}}" method="post">
                  {{-- Token de seguridad--}}
                  @csrf

                  <button type="submit" aria-label="Link for logout" class="item">Cerrar Sesión</button>
                </form>
              @else
                <a href="{{route("login")}}" aria-label="Link for login" class="item">Inicia Sesión</a>
                <a href="{{route("register")}}" aria-label="Link for registration" class="item">Regístrate</a>
              @endif
            </div>
          </div>
        </div>
        
        <!-- Logo #2 (Este es para el responsive) -->
        <div class="nav-logo-pag py-2 flex lg:hidden gap-3 w-full justify-between mt-1 items-center">
          <a href="{{route('index')}}" class="text-white flex sm:hidden hover:text-gray-400">
            <img src="{{ asset('storage/others/logotype.png') }}" class="w-16" alt="Logo PcGlobal">
          </a>
          {{-- Ícono del menú --}}
          <button id="menu-responsive" aria-label="Deploy menu">
            <i class="fa-solid fa-bars text-md bg-indigo-700 p-2 rounded-md"></i>
          </button>
        </div>
      </div>
    </div>
  </nav>
</header>
{{-- Links a diferentes sitios de la página usando los coponentes de blade--}}
<div class="py-2 bg-indigo-600 text-white" id="menu">
  <div class="flex flex-col gap-y-1 w-4/5 mx-auto">
    <x-responsive-nav-links href="{{route('index')}}" :active="request()->routeIs('index')">
      Inicio
    </x-responsive-nav-links>
    <x-responsive-nav-links href="{{route('index','#categories')}}" :active="request()->routeIs('categoria')">
      Categorías
    </x-responsive-nav-links>
    <x-responsive-nav-links href="{{route('login')}}">
      Inicia sesión
    </x-responsive-nav-links>
    <x-responsive-nav-links href="{{route('register')}}">
      Crea una cuenta
    </x-responsive-nav-links>
  </div>
</div>