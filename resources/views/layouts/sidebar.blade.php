<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">

                <li>
                    <a href="{{ route('index') }}">
                        <i data-feather="home"></i>
                        <span class="badge rounded-pill bg-soft-success text-success float-end"></span>
                        <span data-key="t-dashboard">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="align-right"></i>
                        <span data-key="t-contacts">@lang('Brands')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('brands') }}" data-key="t-user-list">@lang('Brands List')</a></li>
                        <li><a href="{{ route('brand-create') }}" data-key="t-user-grid">@lang('Add New Brand')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="align-left"></i>
                        <span data-key="t-contacts">@lang('Category')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('categories') }}" data-key="t-user-list">@lang('Category List')</a></li>
                        <li><a href="{{ route('category-create') }}" data-key="t-user-grid">@lang('Add New Category')</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="check-circle"></i>
                        <span data-key="t-contacts">@lang('Payment Method')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('payment-methods') }}" data-key="t-user-list">@lang('Payment Method List')</a></li>
                        <li><a href="{{ route('payment-method-create') }}" data-key="t-user-grid">@lang('Add New Payment')</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="map-pin"></i>
                        <span data-key="t-contacts">@lang('Country')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('countries') }}" data-key="t-user-list">@lang('Country List')</a></li>
                        <li><a href="{{ route('country-create') }}" data-key="t-user-grid">@lang('Add New Country')</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="map-pin"></i>
                        <span data-key="t-contacts">@lang('State / Region')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('states') }}" data-key="t-user-list">@lang('State List')</a></li>
                        <li><a href="{{ route('state-create') }}" data-key="t-user-grid">@lang('Add New State')</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="map-pin"></i>
                        <span data-key="t-contacts">@lang('Township')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('townships') }}" data-key="t-user-list">@lang('Township List')</a></li>
                        <li><a href="{{ route('township-create') }}" data-key="t-user-grid">@lang('Add New Township')</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="check-circle"></i>
                        <span data-key="t-contacts">@lang('Delivery Time')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('deliverytimes') }}" data-key="t-user-list">@lang('Delivery Time List')</a></li>
                        <li><a href="{{ route('delivery-time-create') }}" data-key="t-user-grid">@lang('Add New Delivery Time')</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="user-check"></i>
                        <span data-key="t-contacts">@lang('Customer')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('customers') }}" data-key="t-user-list">@lang('Customer List')</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="package"></i>
                        <span data-key="t-contacts">@lang('Product')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('products') }}" data-key="t-user-list">@lang('Product List')</a></li>
                        <li><a href="{{ route('product-create') }}" data-key="t-user-grid">@lang('Add New Product')</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="shopping-cart"></i>
                        <span data-key="t-contacts">@lang('Order')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('orders') }}" data-key="t-user-list">@lang('Order List')</a></li>
                        <li><a href="{{ route('order-create') }}" data-key="t-user-list">@lang('Order Create')</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="plus-circle"></i>
                        <span data-key="t-contacts">@lang('Income')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('incomes') }}" data-key="t-user-list">@lang('Income List')</a></li>
                        <li><a href="{{ route('income-create') }}" data-key="t-user-grid">@lang('Add New Income')</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="minus-circle"></i>
                        <span data-key="t-contacts">@lang('Outcome')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('outcomes') }}" data-key="t-user-list">@lang('Outcome List')</a></li>
                        <li><a href="{{ route('outcome-create') }}" data-key="t-user-grid">@lang('Add New Outcome')</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="minus-circle"></i>
                        <span data-key="t-contacts">@lang('Report')</span>
                    </a>
                    @php
                        $start_date = Carbon\Carbon::now()->startOfMonth();
                    @endphp
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('profit-loss') }}?start_date={{ date('Y-m-d', strtotime($start_date)) }}&end_date={{ date('Y-m-d') }}"
                                data-key="t-user-list">@lang('Profit Loss')</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="box"></i>
                        <span data-key="t-contacts">@lang('Admins')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admins') }}" data-key="t-user-list">@lang('Admins List')</a></li>
                        <li><a href="{{ route('admin-create') }}" data-key="t-user-grid">@lang('Add New Admin')</a></li>
                    </ul>
                </li>
            </ul>

        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
