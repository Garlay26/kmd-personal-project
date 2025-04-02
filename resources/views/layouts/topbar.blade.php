@php
    $user = Auth::user();
@endphp
<header id="page-topbar" style="background: linear-gradient(to right bottom,#1e92e0,#1e92e0);">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box" style="background-color: #1e92e0;border-color:#1e92e0">
                <a href="{{ route('index') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ URL::asset('assets/images/kmd_logo.png') }}" alt="" height="30">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ URL::asset('assets/images/kmd_logo.png') }}" alt="" height="auto" width="100px">
                    </span>
                </a>

                <a href="{{ route('index') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ URL::asset('assets/images/kmd_logo.png') }}" alt="" height="30"
                            width="auto">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ URL::asset('assets/images/kmd_logo.png') }}" alt="" height="auto" width="100px">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>
        </div>

        <div class="d-flex">

            {{-- <div class="dropdown d-inline-block d-lg-none ms-2">
                <button type="button" class="btn header-item" id="page-header-search-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i data-feather="search" class="icon-lg"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-search-dropdown">

                    <form class="p-3">
                        <div class="form-group m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search ..."
                                    aria-label="Search Result">

                                <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div> --}}



            {{-- <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <i data-feather="grid" class="icon-lg"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <div class="p-2">
                        <div class="row g-0">
                            <div class="col">
                                <a class="dropdown-icon-item" href="{{route('index')}}">
                                    <i data-feather="home"></i>
                                    <span>Dasboard</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="{{route('index')}}">
                                    <i data-feather="dollar-sign"></i>
                                    <span>Points</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="{{route('index')}}">
                                    <i data-feather="users"></i>
                                    <span>Customers</span>
                                </a>
                            </div>
                        </div>

                        <div class="row g-0">
                            <div class="col">
                                <a class="dropdown-icon-item" href="{{route('index')}}">
                                    <i data-feather="gift"></i>
                                    <span>Rewards</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="{{route('index')}}">
                                    <i data-feather="box"></i>
                                    <span>Orders</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="{{route('index')}}">
                                    <i data-feather="trello"></i>
                                    <span>Banners</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon position-relative"
                    id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <i data-feather="bell" class="icon-lg"></i>
                    @php
                        $notiCount = 0;
                        $notifications =  [];
                    @endphp
                    <span class="badge bg-danger rounded-pill" id="noti-count">{{$notiCount}}</span>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0"> Notifications </h6>
                            </div>
                            <div class="col-auto">
                                <a href="#" class="small text-reset text-decoration-underline"> Unread ({{$notiCount}})</a>
                            </div>
                        </div>
                    </div>
                    <div data-simplebar style="max-height: 230px;" id="append-noti">
                        @foreach ($notifications as $notification)
                            @php
                                $noti_user = App\Models\User::where('id',$notification->created_by)->first();
                            @endphp
                        <a href="#!" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="avatar-sm me-3">
                                    <img src="{{ URL::asset(optional($noti_user)->avatar) }}" class="rounded-circle avatar-sm"
                                    alt="user-pic">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{$notification->title}}</h6>
                                    <div class="font-size-13 text-muted">
                                        <p class="mb-1">{{$notification->message}}</p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span>{{$notification->created_at}}</span></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endforeach
                        
                    </div>
                    
                    <div class="p-2 border-top d-grid">
                        <a class="btn btn-sm btn-link font-size-14 text-center" href="">
                            <i class="mdi mdi-arrow-right-circle me-1"></i> <span>View More..</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item bg-soft-light border-start border-end"
                    id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <img class="rounded-circle header-profile-user"
                        src="{{asset('assets/images/kmd_logo.png')}}" alt="Image">
                    {{-- <span class="d-none d-xl-inline-block ms-1 fw-medium">{{ \Auth::user()->username }}</span> --}}
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href=""><i
                            class="mdi mdi-face-profile font-size-16 align-middle me-1"></i> Profile</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item " href="javascript:void();"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                            class="bx bx-power-off font-size-16 align-middle me-1"></i> <span
                            key="t-logout">Logout</span></a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>

        </div>
    </div>
</header>
