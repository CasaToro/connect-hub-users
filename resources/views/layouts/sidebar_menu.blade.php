 <!-- Sidebar Holder -->
<nav id="sidebar">
<div class="sidebar-header">
    <h3>{{config('app.name')}}</h3>
</div>
  <info-user></info-user>
  <!-- sidebar-user-header  -->
  <ul class="list-unstyled components">
    <p></p>
      <info-modules></info-modules>
      <li class="" href="{{ route('logout') }}">
       <a href="#"
        onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
        <i class="fas fa-power-off"></i>{{ __(' Cerrar Sesiòn') }}
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
      </form>
    </li>
  </ul>
</nav>
