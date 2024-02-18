<style>
  .sub_nav_link_2 {
    opacity: 0;
    transition: opacity 0.5s;
  }

  .show-nav_link_2 .sub_nav_link_2 {
    opacity: 1;
  }
</style>
<header class="header" id="header">
  <div class="header_toggle">
    <i class='bx bx-menu' id="header-toggle"></i>
  </div>
  <div class="title">AutoInvoice+</div>
  <div>
    <a href="logout.php" class="nav_link">
      <i class='bx bx-log-out nav_icon'></i>
      <span class="nav_name">Sign Out</span>
    </a>
  </div>
</header>
<div class="l-navbar" id="nav-bar">
  <nav class="nav">
    <div>
      <a href="#" class="nav_logo">
        <i class='bx bx-layer nav_logo-icon'>
          <img src="image/logo/logo-icon.png" alt="menu" style="width: 30px;">
        </i>
        <span class="nav_logo-name">AutoInvoice+</span> </a>
      <div class="nav_list">
        <a href="index.php" class="nav_link ">
          <i><img src="image/icon/menu.png" alt="menu" style="width: 30px;color:white;"></i>
          <span class="nav_name">Dashboard</span>
        </a>
        <a href="supplier.php" class="nav_link ">
          <i><img src="image/icon/menu.png" alt="menu" style="width: 30px;color:white;"></i>
          <span class="nav_name">Suppliers</span>
        </a> <a href="client.php" class="nav_link ">
          <i><img src="image/icon/menu.png" alt="menu" style="width: 30px;color:white;"></i>
          <span class="nav_name">Client</span>
        </a>

        <a href="purchase_order.php" class="nav_link ">
          <i><img src="image/icon/menu.png" alt="menu" style="width: 30px;color:white;"></i>
          <span class="nav_name">Purchase Orders</span>
        </a>


        <a href="invoice.php" class="nav_link ">
          <i><img src="image/icon/menu.png" alt="menu" style="width: 30px;color:white;"></i>
          <span class="nav_name">Invoice</span>
        </a>



        <a href="delivery_note.php" class="nav_link ">
          <i><img src="image/icon/menu.png" alt="menu" style="width: 30px;color:white;"></i>
          <span class="nav_name">delivery Note</span>
        </a>



        <a href="users.php" class="nav_link ">
          <i><img src="image/icon/menu.png" alt="menu" style="width: 30px;color:white;"></i>
          <span class="nav_name">Manage Users</span>
        </a>
        <a href="organisation.php" class="nav_link ">
          <i><img src="image/icon/menu.png" alt="menu" style="width: 30px;color:white;"></i>
          <span class="nav_name">Manage Organisation</span>
        </a>





        <!-- <a href="#" class="nav_link" onclick="showNavLink2()">
          <i>
            <img src="image/icon/menu.png" alt="menu" style="width: 30px;">
          </i> <span class="nav_name">Purchase Order</span>
        </a>

        <div class=" nav_link sub_container">
          <a href="users.php" class="nav_link sub_nav_link_2">
            <i>
              <img src="image/icon/menu.png" alt="menu" style="width: 30px;">
            </i> <span class="nav_name">Purchase Order 1</span>
          </a>
          <br>
          <a href="add_user.php" class="nav_link sub_nav_link_2">
            <i>
              <img src="image/icon/menu.png" alt="menu" style="width: 30px;">
            </i> <span class="nav_name">Add Users</span>
          </a>
        </div>
        <script>function showNavLink2() {
            const navLink2Container = document.querySelector('.sub_container');
            navLink2Container.classList.toggle('show-nav_link_2');
          }
        </script> -->

      </div>
    </div>

  </nav>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function (event) {
    //change active class
    const navBar = document.getElementById('nav-bar');
    const navLinks = document.querySelectorAll('.nav_link');
    const currentUrl = window.location.href;

    if (navBar && navLinks) {
      navLinks.forEach(link => {
        const linkUrl = link.getAttribute('href');
        if (currentUrl.includes(linkUrl)) {
          link.classList.add('active');
        }
      });
    }



    const nav = document.querySelector('.l-navbar');
    const toggle = document.getElementById('header-toggle');
    const bodypd = document.getElementById('body-pd');
    const headerpd = document.getElementById('header');

    if (navBar && nav && toggle && bodypd && headerpd) {
      navBar.addEventListener('mouseenter', () => {
        nav.classList.add('show1');
        toggle.classList.add('bx-x');
        bodypd.classList.add('body-pd');
        headerpd.classList.add('body-pd');
      });

      navBar.addEventListener('mouseleave', () => {
        nav.classList.remove('show1');
        toggle.classList.remove('bx-x');
        bodypd.classList.remove('body-pd');
        headerpd.classList.remove('body-pd');
      });
    }

    /*===== LINK ACTIVE =====*/
    const linkColor = document.querySelectorAll('.nav_link');

    function colorLink() {
      if (linkColor) {
        linkColor.forEach(l => l.classList.remove('active'));
        this.classList.add('active');
      }
    }

    linkColor.forEach(l => l.addEventListener('click', colorLink));
  });

</script>