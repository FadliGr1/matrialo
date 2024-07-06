<ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link {{ Request::is('setting/app') ? 'active' : '' }}" href="/setting/app">App</a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{ Request::is('setting/profile') ? 'active' : '' }}" aria-current="page" href="/setting/profile">Profile</a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{ Request::is('setting/security') ? 'active' : '' }}" href="/setting/security">Keamanan</a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{ Request::is('setting/integration') ? 'active' : '' }}" href="/setting/integration">Integrasi</a>
    </li>
</ul>