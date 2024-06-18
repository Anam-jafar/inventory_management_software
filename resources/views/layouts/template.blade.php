<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags --> {{asset('materials/assets')}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>AmarFactory</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{asset('materials/assets/vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('materials/assets/vendors/flag-icon-css/css/flag-icon.min.css')}}">
    <link rel="stylesheet" href="{{asset('materials/assets/vendors/css/vendor.bundle.base.css')}}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{asset('materials/assets/vendors/font-awesome/css/font-awesome.min.css')}}" />
    <link rel="stylesheet" href="{{asset('materials/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css')}}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{asset('materials/assets/css/style.css')}}">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{asset('materials/assets/images/favicon.png')}}" />
    <link rel="stylesheet" href="{{asset('custom/css/custom.css')}}">
    @notifyCss
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  </head>
  <body>
    <div class="container-scroller">

      <!-- partial:partials/_navbar.html -->
      <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
          <a class="navbar-brand brand-logo" href=""><img src="{{asset('materials/assets/images/logo.svg')}}" alt="logo" /></a>
          <a class="navbar-brand brand-logo-mini" href=""><img src="{{asset('materials/assets/images/logo-mini.svg')}}" alt="logo" /></a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-stretch">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
          </button>

          
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </nav>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper pt-4">
    <!-- partial:partials/_sidebar.html -->
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
            <li class="nav-item nav-category"></li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboardView') }}">
                    <span class="icon-bg"><i class="mdi mdi-cube menu-icon"></i></span>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>
            <!-- Category -->
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#category-collapse" aria-expanded="false" aria-controls="category-collapse">
                    <span class="icon-bg"><i class="mdi menu-icon mdi-format-list-bulleted-type"></i></span>
                    <span class="menu-title">Category</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="category-collapse">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="{{route('allCategory')}}">Categories List</a></li>
                        <li class="nav-item"> <a class="nav-link" href="{{route('addCategory')}}">Add Category</a></li>
                    </ul>
                </div>
            </li>
            <!-- Category end -->

            <!-- Product -->
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#product-collapse" aria-expanded="false" aria-controls="product-collapse">
                    <span class="icon-bg"><i class="mdi menu-icon mdi-format-list-bulleted-type"></i></span>
                    <span class="menu-title">Product</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="product-collapse">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="{{route('allProduct')}}">Product List</a></li>
                        <li class="nav-item"> <a class="nav-link" href="{{route('addProduct')}}">Add Product</a></li>
                        <li class="nav-item"> <a class="nav-link" href="{{route('restockProduct')}}">Restock Product</a></li>
                        <li class="nav-item"> <a class="nav-link" href="{{route('addExtraIncome')}}">Add Extra Income</a></li>
                        <li class="nav-item"> <a class="nav-link" href="{{route('allExtraIncome')}}">Extra Income List</a></li>
                    </ul>
                </div>
            </li>
            <!-- Product end -->

            <!-- Employee -->
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#employee-collapse" aria-expanded="false" aria-controls="employee-collapse">
                    <span class="icon-bg"><i class="mdi mdi-lock menu-icon"></i></span>
                    <span class="menu-title">Employee</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="employee-collapse">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="{{route('allEmployee')}}"> Employee List </a></li>
                        <li class="nav-item"> <a class="nav-link" href="{{route('addEmployee')}}"> Add Employee </a></li>
                        <li class="nav-item"> <a class="nav-link" href="{{route('paySalary')}}"> Pay Salary </a></li>
                    </ul>
                </div>
            </li>
            <!-- Employee end -->

            <!-- Customer -->
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#customer-collapse" aria-expanded="false" aria-controls="customer-collapse">
                    <span class="icon-bg"><i class="mdi mdi-lock menu-icon"></i></span>
                    <span class="menu-title">Customer</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="customer-collapse">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="{{route('allCustomer')}}"> Customer List </a></li>
                        <li class="nav-item"> <a class="nav-link" href="{{route('addCustomer')}}"> Add Customer </a></li>
                    </ul>
                </div>
            </li>
            <!-- Customer end -->

            <!-- Supplier -->
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#supplier-collapse" aria-expanded="false" aria-controls="supplier-collapse">
                    <span class="icon-bg"><i class="mdi mdi-lock menu-icon"></i></span>
                    <span class="menu-title">Supplier</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="supplier-collapse">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="{{route('allSupplier')}}"> Supplier List </a></li>
                        <li class="nav-item"> <a class="nav-link" href="{{route('addSupplier')}}"> Add Supplier </a></li>
                    </ul>
                </div>
            </li>
            <!-- Supplier end -->

            <!-- Expense -->
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#expense-collapse" aria-expanded="false" aria-controls="expense-collapse">
                    <span class="icon-bg"><i class="mdi mdi-lock menu-icon"></i></span>
                    <span class="menu-title">Expense</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="expense-collapse">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="{{route('allExpense')}}"> Expense List </a></li>
                        <li class="nav-item"> <a class="nav-link" href="{{route('addExpense')}}"> Add Expense </a></li>
                    </ul>
                </div>
            </li>
            <!-- Expense end -->

            <!-- Order -->
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#order-collapse" aria-expanded="false" aria-controls="order-collapse">
                    <span class="icon-bg"><i class="mdi mdi-lock menu-icon"></i></span>
                    <span class="menu-title">Order</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="order-collapse">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="{{route('allOrder')}}"> Order List </a></li>
                        <li class="nav-item"> <a class="nav-link" href="{{route('addOrder')}}"> Create Order </a></li>
                    </ul>
                </div>
            </li>
            <!-- Order end -->
            <li class="nav-item sidebar-user-actions">
              <div class="sidebar-user-menu">
                <a href="#" class="nav-link"><i class="mdi mdi-settings menu-icon"></i>
                  <span class="menu-title">Settings</span>
                </a>
              </div>
            </li>
            <li class="nav-item sidebar-user-actions">
              <div class="sidebar-user-menu">
                <a href="#" class="nav-link"><i class="mdi mdi-speedometer menu-icon"></i>
                  <span class="menu-title">Take Tour</span></a>
              </div>
            </li>
            <li class="nav-item sidebar-user-actions">
              <div class="sidebar-user-menu">
                <a href="#" class="nav-link"><i class="mdi mdi-logout menu-icon"></i>
                  <span class="menu-title">Log Out</span></a>
              </div>
            </li>

          </ul>
        </nav>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            @yield('content')
          </div>

          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <footer class="footer">
            <div class="footer-inner-wraper">
              <div class="d-sm-flex justify-content-center justify-content-sm-between py-2">
                <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © <a href="https://www.bootstrapdash.com/" target="_blank">bootstrapdash.com </a>2021</span>
                <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Only the best <a href="https://www.bootstrapdash.com/" target="_blank"> Bootstrap dashboard </a> templates</span>
              </div>
            </div>
          </footer>
          <!-- partial -->
        </div>

        <!-- main-panel ends -->
      </div>

      <!-- page-body-wrapper ends -->
    </div>
    <x-notify::notify />
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{asset('materials/assets/vendors/js/vendor.bundle.base.js')}}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{asset('materials/assets/vendors/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('materials/assets/vendors/jquery-circle-progress/js/circle-progress.min.js')}}"></script>
    <script src="{{asset('materials/assets/js/jquery.cookie.js')}}" type="text/javascript"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{asset('materials/assets/js/off-canvas.js')}}"></script>
    <script src="{{asset('materials/assets/js/hoverable-collapse.js')}}"></script>
    <script src="{{asset('materials/assets/js/misc.js')}}"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="{{asset('materials/assets/js/dashboard.js')}}"></script>
    <script src="{{asset('custom/js/custom.js')}}"></script>
    <script src="{{asset('custom/js/dashboard.js')}}"></script>
    <!-- End custom js for this page -->
    @notifyJs
  </body>
</html>