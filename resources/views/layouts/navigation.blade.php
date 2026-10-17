<style>
    .fixit-navbar {
        background-color: #1e3a8a;
        color: white;
        padding: 15px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        box-sizing: border-box;
    }
    .fixit-navbar h1 {
        margin: 0;
        font-size: 18px;
        font-weight: bold;
        color: white;
    }
    .fixit-navbar a {
        color: white;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
    }
    .fixit-navbar a:hover {
        text-decoration: underline;
    }
    .fixit-navbar .nav-active {
        text-decoration: underline;
        font-weight: 700;
    }
    .fixit-navbar .badge-role {
        background-color: #3b82f6;
        color: white;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 12px;
        text-transform: uppercase;
        font-weight: bold;
        margin-right: 15px;
    }
    .fixit-navbar .btn-logout {
        background: none;
        border: none;
        color: white;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        padding: 0;
        margin: 0;
        font-family: inherit;
    }
    .fixit-navbar .btn-logout:hover {
        text-decoration: underline;
    }
</style>

<!-- Navbar Sederhana Seragam FixIt -->
<div class="fixit-navbar">
    <h1>FixIt - @if(request()->routeIs('admin.laporan.*')) Kelola Laporan Masuk @elseif(request()->routeIs('kategori.*')) Manajemen Kategori @else Dashboard @endif</h1>
    <div style="display: flex; align-items: center;">
        @auth
            <span class="badge-role">{{ Auth::user()->role }}</span>
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'nav-active' : '' }}" style="margin-right: 20px;">Dashboard</a>
            
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('kategori.index') }}" class="{{ request()->routeIs('kategori.*') ? 'nav-active' : '' }}" style="margin-right: 20px;">Kelola Kategori</a>
                <a href="{{ route('admin.laporan.index') }}" class="{{ request()->routeIs('admin.laporan.*') ? 'nav-active' : '' }}" style="margin-right: 20px;">Laporan Masuk</a>
            @endif

            <form action="{{ route('logout') }}" method="POST" style="display: inline; margin: 0;">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        @endauth
    </div>
</div>
