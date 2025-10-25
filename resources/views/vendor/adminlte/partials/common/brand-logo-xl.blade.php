@php
    use Illuminate\Support\Facades\Auth;

    $user = Auth::user();
    $role = $user ? ucfirst($user->role->nombre ?? 'Invitado') : 'Invitado';

    // 🎨 Configuración de color e ícono según rol
    $roleData = [
        'Admin' => ['color' => 'text-primary', 'icon' => 'fas fa-crown'],
        'Coordinador' => ['color' => 'text-warning', 'icon' => 'fas fa-compass'],
        'Docente' => ['color' => 'text-success', 'icon' => 'fas fa-graduation-cap'],
        'Tutorado' => ['color' => 'text-info', 'icon' => 'fas fa-users'],
        'Invitado' => ['color' => 'text-muted', 'icon' => 'fas fa-user']
    ];

    $colorClass = $roleData[$role]['color'] ?? 'text-muted';
    $iconClass = $roleData[$role]['icon'] ?? 'fas fa-user';

    // 📍 Redirección al dashboard correspondiente
    switch (strtolower($role)) {
        case 'admin':
            $dashboardRoute = route('admin.dashboard');
            break;
        case 'coordinador':
            $dashboardRoute = route('coordinador.dashboard');
            break;
        case 'docente':
            $dashboardRoute = route('docente.dashboard');
            break;
        case 'tutorado':
            $dashboardRoute = route('tutorado.dashboard');
            break;
        default:
            $dashboardRoute = url('/');
    }
@endphp

<a href="{{ $dashboardRoute }}" class="brand-link d-flex align-items-center">
    <i class="{{ $iconClass }} fa-2x {{ $colorClass }} ml-2 mr-2"></i>
    
    <div class="d-flex flex-column">
        <span class="brand-text font-weight-bold {{ $colorClass }}">
            TutoriasTECNM<span class="text-dark"></span>
        </span>
        <small class="text-muted" style="margin-top:-2px; font-size: 0.75rem;">
            {{ $role }}
        </small>
    </div>
</a>
