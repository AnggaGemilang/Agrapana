@php
if(\Request::is('admin')) {
    @$dashboard = 'active';
} else if(\Request::is('admin/manage')) {
    @$manage = 'active';
}
@endphp

<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <a href="/monitoring" style="padding-left: 15px; padding-top: 20px; margin-bottom: -20px;"><h4 style="color: #558558; font-weight: 700;"><b>Meet Agrapana</b></h4></a>
                <div class="sidebar-toggler x">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>
                <li class="sidebar-item {{ @$dashboard }}">
                    <a href="/admin" class='sidebar-link'>
                        <i class="bi bi-grid-fill" style="line-height: 0px !important;"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item {{ @$manage }}">
                    <a href="/admin/manage" class='sidebar-link'>
                        <i class="bi-bar-chart-fill" style="line-height: 0px !important;"></i>
                        <span>Manage</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="/admin/logout/post" class='sidebar-link'>
                        <i class="bi bi-box-arrow-right" style="line-height: 0px !important;"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
