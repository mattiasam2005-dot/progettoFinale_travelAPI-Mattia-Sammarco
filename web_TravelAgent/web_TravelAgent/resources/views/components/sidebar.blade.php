<!-- Navbar Mobile superiore (Pulita e minimal) -->
<div class="d-flex align-items-center justify-content-between p-3 border-bottom d-md-none bg-body-tertiary">
    <a href="{{ route('chat.index') }}" class="d-flex align-items-center gap-2 text-decoration-none link-body-emphasis">
        <img class="logo" src="/RagsAI-LOGO.png" alt="Logo" style="height: 32px; width: auto;">
        <span class="fs-4 fw-bold tracking-tight">RagsAI</span>
    </a>
    <button class="btn btn-light btn-icon rounded-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasResponsive" aria-controls="offcanvasResponsive">
        <i class="bi bi-list fs-3"></i>
    </button>
</div>

<!-- Offcanvas / Sidebar Container -->
<div class="offcanvas-md offcanvas-start border-end bg-body-emerald" tabindex="-1" id="offcanvasResponsive" aria-labelledby="offcanvasResponsiveLabel" style="--bs-offcanvas-width: 280px;">
    
    <!-- Header Offcanvas (Solo Mobile) -->
    <div class="offcanvas-header border-bottom px-4 py-3 d-md-none">
        <a href="{{ route('chat.index') }}" class="d-flex align-items-center gap-2 text-decoration-none link-body-emphasis">
            <img class="logo" src="/RagsAI-LOGO.png" alt="Logo" style="height: 32px; width: auto;">
            <span class="fs-4 fw-bold">RagsAI</span>
        </a>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#offcanvasResponsive" aria-label="Close"></button>
    </div>

    <!-- Corpo della Sidebar -->
    <div class="offcanvas-body p-0">
        <div class="d-flex flex-column flex-shrink-0 p-4 w-100 vh-100 bg-body-tertiary">
            
            <!-- Header Sidebar (Solo Desktop) -->
            <a href="{{ route('chat.index') }}" class="d-none d-md-flex align-items-center gap-2 mb-4 text-decoration-none link-body-emphasis">
                <img class="logo" src="/RagsAI-LOGO.png" alt="Logo" style="height: 36px; width: auto;">
                <span class="fs-3 fw-bolder tracking-tight">RagsAI</span>
            </a>

            <!-- Sezione di Mezzo / Navigazione (Es: Storico chat o Link) -->
            <div class="flex-grow-1 overflow-y-auto mb-3">
                <ul class="nav nav-pills flex-column gap-1">
                    <!-- Esempio di link attivo moderno -->
                    <li class="nav-item">
                        <a href="#" class="nav-item-link nav-link active d-flex align-items-center gap-3 py-2 px-3 rounded-3 fw-medium" aria-current="page">
                            <i class="bi bi-chat-left-text fs-5"></i> Nuova Chat
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-item-link nav-link link-body-emphasis d-flex align-items-center gap-3 py-2 px-3 rounded-3 fw-medium">
                            <i class="bi bi-clock-history fs-5"></i> Cronologia
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Profilo Utente (Dropdown in stile Widget moderno) -->
            <div class="dropdown pt-3 border-top">
                <a href="#" class="d-flex align-items-center p-2 rounded-3 text-decoration-none link-body-emphasis dropdown-toggle justify-content-between profile-trigger" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="d-flex align-items-center min-w-0">
                        <img src="/user.png" alt="Avatar" width="36" height="36" class="rounded-circle me-2 border border-2 border-primary-subtle object-fit-cover">
                        <div class="text-truncate">
                            <div class="fw-semibold text-truncate lh-sm" style="max-width: 140px;">Mattia Sammarco</div>
                        </div>
                    </div>
                </a>
                
                <!-- Menu Dropdown curato nei dettagli -->
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border border-translucent rounded-3 p-2 p-md-1" style="min-width: 220px;">
                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2 py-2 px-3 rounded-2" href="#">
                            <i class="bi bi-gear text-muted"></i> Settings
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2 py-2 px-3 rounded-2" href="#">
                            <i class="bi bi-person text-muted"></i> Profile
                        </a>
                    </li>
                    <li><hr class="dropdown-divider my-2 opacity-50"></li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2 py-2 px-3 rounded-2 text-danger" href="#">
                            <i class="bi bi-box-arrow-right"></i> Sign out
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</div>
