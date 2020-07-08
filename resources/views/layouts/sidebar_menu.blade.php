 <!-- Sidebar Holder -->
<nav id="sidebar">
<div class="sidebar-header">
    <h3>{{config('app.name')}}</h3>
</div>
  <user-data></user-data>
  <!-- sidebar-user-header  -->
  <user-modules></user-modules>
  <ul class="list-unstyled components">
     <p></p>
     <p></p>
       <li class="" href="{{ route('logout') }}">
       <a href="#"
        onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
        <i class="fas fa-power-off"></i>Cerrar Sesión
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
      </form>
    </li>
  </ul>
</nav>
