<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="<?= $imagesPath ?>favicon.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Havana</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?= $imagesPath ?>user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">username</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

               <li class="nav-header">DEPARTMENTS</li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-users-cog nav-icon"></i>

              <p>
                Admins
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="admins.php" class="nav-link">
                  <i class="fas fa-users-cog nav-icon"></i>
                  <p>All Admins</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="admin_operations.php" class="nav-link">
                <i class="fas fa-user-cog nav-icon"></i>
                  <p>Add Admin</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-users nav-icon"></i>

              <p>
                Users
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="users.php" class="nav-link">
                  <i class="fas fa-users nav-icon"></i>
                  <p>All Users</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="user_operations.php" class="nav-link">
                <i class="fas fa-user-plus nav-icon"></i>
                  <p>Add User</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-clipboard-list nav-icon"></i>
              <p>
                Categories
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="categories.php" class="nav-link">
                  <i class="fas fa-clipboard-list nav-icon"></i>

                  <p>All Categories</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="category_operations.php" class="nav-link">
                <i class="fas fa-clipboard-list nav-icon"></i>
                  <p>Add Category</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-sitemap nav-icon"></i>
              <p>
                Sub Categories
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="subCategories.php" class="nav-link">
                <i class="fas fa-network-wired nav-icon"></i>

                  <p>All Sub Categories</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="subCategory_operations.php" class="nav-link">

                <i class="fas fa-network-wired nav-icon"></i>

                  <p>Add Sub Category</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="fas fa-band-aid nav-icon"></i>

              <p>
                Brands
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="brands.php" class="nav-link">
                <i class="fas fa-band-aid nav-icon"></i>
                  <p>All Brands</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="brand_operations.php" class="nav-link">
                <i class="fas fa-band-aid nav-icon"></i>
                  <p>Add Brand</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="fas fa-clipboard-list nav-icon"></i>


              <p>
                Specs
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="specs.php" class="nav-link">
                <i class="fas fa-clipboard-list nav-icon"></i>
                  <p>All Specs</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="specs_operations.php" class="nav-link">
                <i class="fas fa-clipboard-list nav-icon"></i>

                  <p>Add Specs</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="fas fa-shopping-bag nav-icon"></i>


              <p>
                Products
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="products.php" class="nav-link">
                <i class="fas fa-shopping-bag nav-icon"></i>

                  <p>All Products</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="product_operations.php" class="nav-link">
                <i class="fas fa-shopping-bag nav-icon"></i>
                  <p>Add Product</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="fas fa-globe nav-icon"></i>

              <p>
                Rigions
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="regions.php" class="nav-link">
                <i class="fas fa-globe nav-icon"></i>
                  <p>All Regions</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="region_operations.php" class="nav-link">
                <i class="fas fa-flag nav-icon"></i>
                  <p>Add Region</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="fas fa-city nav-icon"></i>

              <p>
                Cities
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="cities.php" class="nav-link">
                <i class="fas fa-city nav-icon"></i>
                  <p>All Cities</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="city_operations.php" class="nav-link">
                <i class="fas fa-building nav-icon"></i>
                  <p>Add City</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="fas fa-map-marked-alt nav-icon"></i>

              <p>
                Addresses
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="addresses.php" class="nav-link">
                <i class="fas fa-map-marked-alt nav-icon"></i>
                  <p>All Addresses</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="address_operations.php" class="nav-link">
                <i class="fas fa-map-pin nav-icon"></i>
                  <p>Add Address</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="fas fa-tags nav-icon"></i>

              <p>
                Offers
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="offers.php" class="nav-link">
                <i class="fas fa-tags nav-icon"></i>
                  <p>All Offers</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="offer_operations.php" class="nav-link">
                <i class="fas fa-tag nav-icon"></i>
                  <p>Add Offer</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="fas fa-receipt nav-icon"></i>

              <p>
                Coupons
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="coupons.php" class="nav-link">
                <i class="fas fa-receipt nav-icon"></i>
                  <p>All Coupons</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="coupon_operations.php" class="nav-link">
                <i class="fas fa-receipt nav-icon"></i>
                  <p>Add Coupon</p>
                </a>
              </li>
            </ul>
          </li>



          <li class="nav-header">Data</li>

          <li class="nav-item">
            <a href="orders.php" class="nav-link">
              <i class="nav-icon far fa-image"></i>
              <p>
                Orders
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="reviews.php" class="nav-link">
              <i class="nav-icon far fa-image"></i>
              <p>
                Reviews
              </p>
            </a>
          </li>





        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
