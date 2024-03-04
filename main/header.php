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
    <a href="logout.php" class="btn btn-danger">
      <i class='bx bx-log-out nav_icon'></i>
      <span class="nav_name">Sign Out</span>
    </a>
  </div>
</header>
<div class="l-navbar" id="nav-bar">
  <nav class="nav">
    <div>
      <a href="index.php" class="nav_logo">
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
        <?php

        if ($_SESSION['userPo'] == "1") {

          ?>
          <a href="purchase_order.php" class="nav_link ">
            <i><img src="image/icon/menu.png" alt="menu" style="width: 30px;color:white;"></i>
            <span class="nav_name">Purchase Orders</span>
          </a>
          <?php
        }
        if ($_SESSION['userInvoice'] == "1") {

          ?>
          <a href="invoice.php" class="nav_link ">
            <i><img src="image/icon/menu.png" alt="menu" style="width: 30px;color:white;"></i>
            <span class="nav_name">Invoice</span>
          </a>
          <?php
        }
        if ($_SESSION['userDn'] == "1") {

          ?>
          <a href="delivery_note.php" class="nav_link ">
            <i><img src="image/icon/menu.png" alt="menu" style="width: 30px;color:white;"></i>
            <span class="nav_name">Delivery Note</span>
          </a>
          <?php
        }
        if ($_SESSION['userRole'] == "Admin" || $_SESSION['userRole'] == "Manager") {

          ?>
          <a href="customerLogin.php" class="nav_link ">
            <i><img src="image/icon/menu.png" alt="menu" style="width: 30px;color:white;"></i>
            <span class="nav_name">Manage <br>Customer Login</span>
          </a>
          <?php
        }


        if ($_SESSION['userRole'] == "Admin") {


          ?>
          <a href="users.php" class="nav_link ">
            <i><img src="image/icon/menu.png" alt="menu" style="width: 30px;color:white;"></i>
            <span class="nav_name">Manage Users</span>
          </a>

          <a href="organisation.php" class="nav_link ">
            <i><img src="image/icon/menu.png" alt="menu" style="width: 30px;color:white;"></i>
            <span class="nav_name">Manage <br>Organisation</span>
          </a>

          <?php
        }

        ?>
      </div>
    </div>

  </nav>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function (event) {
    // Event listener for when the DOM content is fully loaded
    //change active class
    const navBar = document.getElementById('nav-bar'); // Selecting the navigation bar element
    const navLinks = document.querySelectorAll('.nav_link'); // Selecting all navigation links
    const currentUrl = window.location.href; // Getting the current URL of the page

    if (navBar && navLinks) { // Checking if both navigation bar and navigation links are found
      navLinks.forEach(link => {
        const linkUrl = link.getAttribute('href'); // Getting the href attribute of each link
        if (currentUrl.includes(linkUrl)) { // Checking if the current URL includes the link's URL
          link.classList.add('active'); // Adding 'active' class to the link if it matches the current URL
        }
      });
    }

    // Selecting elements for toggling navigation bar visibility
    const nav = document.querySelector('.l-navbar'); // Selecting the navigation bar
    const toggle = document.getElementById('header-toggle'); // Selecting the toggle button
    const bodypd = document.getElementById('body-pd'); // Selecting the body element
    const headerpd = document.getElementById('header'); // Selecting the header element

    if (navBar && nav && toggle && bodypd && headerpd) { // Checking if all required elements are found
      // Adding event listeners for mouse enter and mouse leave events to toggle navigation bar visibility
      navBar.addEventListener('mouseenter', () => {
        nav.classList.add('show1'); // Adding 'show1' class to expand the navigation bar
        toggle.classList.add('bx-x'); // Adding 'bx-x' class to change the toggle button icon
        bodypd.classList.add('body-pd'); // Adding padding to the body
        headerpd.classList.add('body-pd'); // Adding padding to the header
      });

      navBar.addEventListener('mouseleave', () => {
        nav.classList.remove('show1'); // Removing 'show1' class to collapse the navigation bar
        toggle.classList.remove('bx-x'); // Removing 'bx-x' class to change the toggle button icon back
        bodypd.classList.remove('body-pd'); // Removing padding from the body
        headerpd.classList.remove('body-pd'); // Removing padding from the header
      });
    }

    /*===== LINK ACTIVE =====*/
    const linkColor = document.querySelectorAll('.nav_link'); // Selecting all navigation links again

    function colorLink() { // Function to handle link click event
      if (linkColor) {
        linkColor.forEach(l => l.classList.remove('active')); // Removing 'active' class from all links
        this.classList.add('active'); // Adding 'active' class to the clicked link
      }
    }

    linkColor.forEach(l => l.addEventListener('click', colorLink)); // Adding click event listener to each link
  });

</script>