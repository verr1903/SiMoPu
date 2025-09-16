<div id="sidebar">
    <div class="sidebar-wrapper active d-flex flex-column" style="height: 100vh;">

        <!-- Bagian atas sidebar -->
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <!-- Logo & User Info -->
                <div class="logo" style="margin-left: -10px;">
                    <a href="#" class="fw-bold fs-4 text-primary text-decoration-none d-block" style="text-transform: uppercase;">
                        @if(Auth::check())
                        {{ Auth::user()->username }}
                        <br>
                        <span class="text-muted fw-normal" style="font-size: 0.9rem;">
                            {{ strtoupper(Auth::user()->level_user) }}
                        </span>
                        @else
                        User
                        @endif
                    </a>
                </div>


                <!-- Notifikasi -->
                @auth
                @if(Str::contains(Auth::user()->level_user, ['afdeling', 'administrasi']))
                @php
                $notifications = \App\Models\Notification::where('user_id', auth()->id())
                ->where('status', 'unread')
                ->orderBy('created_at', 'desc')
                ->get();
                @endphp
                <div class="dropdown" style="margin-right: -5px;">
                    <button class="btn btn-sm btn-outline-primary position-relative rounded-circle" type="button" id="notifDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-bell"></i>
                        @if($notifications->count() > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $notifications->count() }}
                            <span class="visually-hidden">unread notifications</span>
                        </span>
                        @endif
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end mt-3" aria-labelledby="notifDropdown" style="width: 300px; max-height: 500px; overflow-y: auto;">
                        @forelse($notifications as $note)
                        <li class="px-3 py-2 border-bottom">
                            {{ $note->message }}<br>
                            <small class="text-muted">{{ $note->created_at->diffForHumans() }}</small>
                        </li>
                        @empty
                        <li class="px-3 py-2 text-center text-muted">Tidak ada notifikasi</li>
                        @endforelse
                    </ul>
                </div>
                @endif
                @endauth


                <div class="d-flex align-items-center gap-1">
                    <div class="theme-toggle d-flex gap-2 align-items-center mt-2">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
                            role="img" class="iconify iconify--system-uicons" width="20" height="20"
                            preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                            <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path
                                    d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"
                                    opacity=".3"></path>
                                <g transform="translate(-210 -1)">
                                    <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                    <circle cx="220.5" cy="11.5" r="4"></circle>
                                    <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2"></path>
                                </g>
                            </g>
                        </svg>
                        <div class="form-check form-switch fs-6">
                            <input class="form-check-input me-0" type="checkbox" id="toggle-dark" style="cursor: pointer">
                            <label class="form-check-label"></label>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
                            role="img" class="iconify iconify--mdi" width="20" height="20" preserveAspectRatio="xMidYMid meet"
                            viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
                            </path>
                        </svg>
                    </div>
                    <div class="sidebar-toggler x">
                        <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Akhir bagian atas sidebar -->

        <!-- Menu -->
        <div class="flex-grow-1" style="margin-top: -25px;">
            <ul class="menu list-unstyled">
                <!-- Dashboard -->
                <li class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" class="sidebar-link">
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- Material -->
                <li class="sidebar-item {{ request()->routeIs('materials') ? 'active' : '' }}">
                    <a href="{{ route('materials') }}" class="sidebar-link">
                        <i class="bi bi-layers"></i>
                        <span>Material</span>
                    </a>
                </li>

                <!-- Penerimaan -->
                <li class="sidebar-item {{ request()->routeIs('penerimaan') ? 'active' : '' }}">
                    <a href="{{ route('penerimaan') }}" class="sidebar-link">
                        <i class="bi bi-box-arrow-in-down"></i>
                        <span>Penerimaan</span>
                    </a>
                </li>

                <!-- Pengeluaran -->
                <li class="sidebar-item {{ request()->routeIs('pengeluaran') ? 'active' : '' }}">
                    <a href="{{ route('pengeluaran') }}" class="sidebar-link">
                        <i class="bi bi-box-arrow-up"></i>
                        <span>Pengeluaran</span>
                    </a>
                </li>

                @auth
                @if(Str::contains(Auth::user()->level_user, ['administrator', 'administrasi']))
                <!-- Realisasi Pengeluaran -->
                <li class="sidebar-item {{ request()->routeIs('realisasiPengeluaran') ? 'active' : '' }}">
                    <a href="{{ route('realisasiPengeluaran') }}" class="sidebar-link">
                        <i class="bi bi-clipboard-check"></i>
                        <span>Realisasi Pengeluaran</span>
                    </a>
                </li>
                @endif
                @endauth

                <!-- Kelola User -->
                @auth
                @if(Auth::user()->level_user === 'administrator')
                <li class="sidebar-item {{ request()->routeIs('users') ? 'active' : '' }}">
                    <a href="{{ route('users') }}" class="sidebar-link">
                        <i class="bi bi-people-fill"></i>
                        <span>Kelola User</span>
                    </a>
                </li>
                @endif
                @endauth


            </ul>
        </div>

        <!-- Logout di bawah -->
        <div class="py-3 px-4 mb-3">
            <a href="{{ route('logout') }}" class="btn btn-danger w-100">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>

    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const notifDropdown = document.getElementById('notifDropdown');

        notifDropdown.addEventListener('show.bs.dropdown', function() {
            fetch("{{ route('notifications.markAsRead') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                }).then(res => res.json())
                .then(data => {
                    if (data.success) {
                        // Hapus badge merah
                        const badge = notifDropdown.querySelector('span.badge');
                        if (badge) badge.remove();
                    }
                });
        });
    });
</script>