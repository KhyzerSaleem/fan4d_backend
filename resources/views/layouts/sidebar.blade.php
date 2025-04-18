<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="javascript:void(0);" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('build/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('build/images/logo-dark.png') }}" alt="" height="17">
{{--                <h1 style="color: white; font-weight: bolder">@lang('Dashboard')</h1>--}}
            </span>
        </a>
        <!-- Light Logo-->
        <a href="javascript:void(0);" class="logo logo-light">
            <span class="logo-sm">
                <img style="height: 50px; width: 50px;" src="{{ URL::asset('build/images/side_bar_logo_sm.png') }}"
                     alt="" height="22">
            </span>
            <span class="logo-lg">
                <img style="height: 90px; width: 180px;" src="{{ URL::asset('build/images/side_bar_logo.png') }}" alt=""
                     height="37">
{{--                <h1 style="color: white; font-weight: bolder;line-height: 60px;">@lang('FANN')</h1>--}}
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
                id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span>@lang('Dashboard')</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::routeIs('root') ? 'active' : '' }}" href="/">
                        <i class="ri-dashboard-2-line"></i> <span>@lang('Statistics')</span>
                    </a>
                </li>
                {{--                @permission('orders_list')--}}

                {{--                @endpermission--}}
                {{--                @permission('users_list')--}}
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::routeIs('users.*') ? 'active' : '' }}"
                       href="{{ route('users.index') }}">
                        <i class="ri-team-line"></i> <span>@lang('Users')</span>
                    </a>
                </li>
                {{--                @endpermission--}}
                @php
                    $new_orders = \App\Models\Order::where('status','pending')->count();
                    $new_direct_orders = \App\Models\DirectOrder::where('seen_at',null)->count();
                    $new_get_prices = \App\Models\GetPrice::where('seen_at',null)->count();
                @endphp

                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::routeIs('orders.*') ? 'active' : '' }}" href="{{ route('orders.index') }}">
                        <i class="ri-shopping-cart-2-line"></i> <span>الطلبات</span>
                        @if($new_orders > 0)
                            <span class="badge badge-pill bg-danger"
                                  data-key="t-hot">{{$new_orders}}</span>
                        @endif
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::routeIs('direct_orders.*') ? 'active' : '' }}" href="{{ route('direct_orders.index') }}">
                        <i class="ri-shopping-cart-2-line"></i> <span>الطلبات المباشرة</span>
                        @if($new_direct_orders > 0)
                            <span class="badge badge-pill bg-danger"
                                  data-key="t-hot">{{$new_direct_orders}}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::routeIs('get_prices.*') ? 'active' : '' }}" href="{{ route('get_prices.index') }}">
                        <i class="ri-shopping-cart-2-line"></i> <span>طلبات الحصول على تسعيره</span>
                        @if($new_get_prices > 0)
                            <span class="badge badge-pill bg-danger"
                                  data-key="t-hot">{{$new_get_prices}}</span>
                        @endif
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::routeIs('notifications.*') ? 'active' : '' }}"
                       href="{{ route('notifications.renderNotification') }}">
                        <i class="ri-notification-4-fill"></i> <span>@lang('Send Notifications')</span>
                    </a>
                </li>
                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-components">التجهيزات</span></li>
                {{--                @permission('categories_list')--}}
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::routeIs('categories.*') ? 'active' : '' }}"
                       href="{{ route('categories.index') }}">
                        <i class="ri-list-check"></i> <span>@lang('Categories')</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::routeIs('attributes.*') ? 'active' : '' }}"
                       href="{{ route('attributes.index') }}">
                        <i class="ri-list-check"></i> <span>@lang('attributes')</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::routeIs('products.*') ? 'active' : '' }}"
                       href="{{ route('products.index') }}">
                        <i class="ri-list-check"></i> <span>@lang('Products')</span>
                    </a>
                </li>
                {{--                @endpermission--}}

                {{--                @permission('sliders_list')--}}
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::routeIs('sliders.*') ? 'active' : '' }}"
                       href="{{ route('sliders.index') }}">
                        <i class="ri-image-line"></i> <span>@lang('Sliders')</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::routeIs('banners.*') ? 'active' : '' }}"
                       href="{{ route('banners.index') }}">
                        <i class="ri-image-line"></i> <span>@lang('banners')</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::routeIs('steps.*') ? 'active' : '' }}"
                       href="{{ route('steps.index') }}">
                        <i class="ri-image-line"></i> <span>@lang('steps')</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::routeIs('reviews.*') ? 'active' : '' }}"
                       href="{{ route('reviews.index') }}">
                        <i class="ri-image-line"></i> <span>@lang('reviews')</span>
                    </a>
                </li>
                {{--                @endpermission--}}
                {{--                @permission('sliders_list')--}}
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::routeIs('offers.*') ? 'active' : '' }}"
                       href="{{ route('offers.index') }}">
                        <i class="ri-image-line"></i> <span>@lang('offers')</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::routeIs('splashes.*') ? 'active' : '' }}"
                       href="{{ route('splashes.index') }}">
                        <i class="ri-image-line"></i> <span>@lang('splashes')</span>
                    </a>
                </li>
                {{--                @endpermission--}}
                {{--                @permission('sliders_list')--}}
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::routeIs('cities.*') ? 'active' : '' }}"
                       href="{{ route('cities.index') }}">
                        <i class=" ri-map-pin-line"></i> <span>@lang('cities')</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::routeIs('vouchers.*') ? 'active' : '' }}"
                       href="{{ route('vouchers.index') }}">
                        <i class=" ri-price-tag-3-line"></i> <span>@lang('Vouchers')</span>
                    </a>
                </li>
                @php
                    $un_seen_messages = \App\Models\Contact::where('seen_at',null)->count();
                    @endphp
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::routeIs('contacts.*') ? 'active' : '' }}"
                       href="{{ route('contacts.index') }}">
                        <i class=" ri-price-tag-3-line"></i> <span>التواصل معنا</span>
                        @if($un_seen_messages > 0)
                        <span class="badge badge-pill bg-danger"
                              data-key="t-hot">{{$un_seen_messages}}</span>
                            @endif
                    </a>
                </li>

                {{--                @endpermission--}}
                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-components">الإعدادات</span></li>
                {{--                @permission('pages_update')--}}
                @php
                    $pages = \App\Models\Page::all();
                @endphp
                @if($pages && $pages->isNotEmpty())
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ Request::routeIs('pages.*') ? 'active' : '' }}"
                           href="#sidebarAdminPages" data-bs-toggle="collapse" role="button"
                           aria-expanded="{{ Request::routeIs('pages.*') }}" aria-controls="sidebarAdminPages">
                            <i class="ri-pages-line"></i> <span>@lang('translation.pages')</span>
                        </a>
                        <div class="menu-dropdown collapse {{ Request::routeIs('pages.*') ? 'show' : '' }}"
                             id="sidebarAdminPages">
                            <ul class="nav nav-sm flex-column">
                                @foreach($pages as $page)
                                    <li class="nav-item">
                                        <a href="{{ route('pages.edit',$page->type) }}"
                                           class="nav-link {{ request()->segment(3) == $page->type ? 'active' : '' }}">@lang('translation.'.$page->type)</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </li> <!-- end Dashboard Menu -->
                @endif
                {{--                @endpermission--}}
                {{--                @role('super_admin')--}}
                {{--                    <li class="nav-item">--}}
                {{--                        <a class="nav-link menu-link {{ Request::routeIs('roles.*') ? 'active' : '' }}" href="{{ route('roles.index') }}">--}}
                {{--                            <i class="ri-lock-2-fill"></i> <span>@lang('Roles & Permissions')</span>--}}
                {{--                        </a>--}}
                {{--                    </li>--}}
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::routeIs('admins.*') ? 'active' : '' }}"
                       href="{{ route('admins.index') }}">
                        <i class="ri-user-2-fill"></i> <span>@lang('Admins')</span>
                    </a>
                </li>

                {{--                @endrole--}}
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::routeIs('point_settings.*') ? 'active' : '' }}"
                       href="{{ route('point_settings.create') }}">
                        <i class="ri-medal-fill"></i> <span>إعدادات النقاط</span>
                    </a>
                </li>
                {{--                @permission('settings_update')--}}
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::routeIs('settings.*') ? 'active' : '' }}"
                       href="{{ route('settings.edit') }}">
                        <i class="ri-settings-2-fill"></i> <span>@lang('translation.settings')</span>
                        </a>
                    </li>
{{--                @endpermission--}}

            </ul>
            <br>
            <br>
            <br>
            <br>
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
