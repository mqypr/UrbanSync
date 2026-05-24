<?php $is_dark = ($_COOKIE['dark_mode'] ?? '0') === '1'; ?>

<header>
  <!-- hidden light/dark -->
  <label class="switch" style="display:none">
    <input type="checkbox" <?= $is_dark ? 'checked' : '' ?>>
    <span class="slider round"></span>
  </label>

  <nav class="navbar">
    <div class="navbar-container">

      <!-- Logo -->
      <div class="navbar-logo">
        <a href="index.php">
          <img src="./images/logo.png" class="logo-pic" alt="logo-pic">
        </a>
      </div>

      <!-- Desktop nav links -->
      <div class="navbar-link">
        <a href="./jobs.php" class="navbar-link-item">JOB DESCRIPTION</a>
        <a href="./apply.php" class="navbar-link-item">APPLY</a>
        <a href="./about.php" class="navbar-link-item">ABOUT</a>
        <div class="navbar-settings"> <!-- settings dropdown -->
          <div class="navbar-link-item navbar-settings-trigger">SETTINGS</div>
          <div class="navbar-settings-dropdown">
            <form method="POST" action="./toggle_theme.php">
              <button type="submit" class="navbar-settings-toggle">
                <?= $is_dark ? 'Light Mode' : 'Dark Mode' ?>
              </button>
            </form>
          </div>
        </div>
      </div>

      <!-- account / login -->
      <?php if (isset($_SESSION['first_name'])): ?>
        <a href="./account.php" class="navbar-link-item">
          <?= htmlspecialchars(strtoupper($_SESSION['first_name'])) ?>
        </a>
      <?php else: ?>
        <a href="./login.php" class="navbar-link-item">LOGIN</a>
      <?php endif; ?>

      <!-- Mobile menu -->
      <div class="navbar-link-vert">
        <input type="checkbox" id="menu-toggle" class="menu-toggle-input">
        <label class="navbar-link-vert-item" for="menu-toggle" style="font-size: 33px;">=</label>
        <div class="navbar-link-vert-dropdown">
          <a href="./index.php" class="navbar-link-vert-item">HOME</a>
          <a href="./jobs.php" class="navbar-link-vert-item">JOB DESCRIPTION</a>
          <a href="./apply.php" class="navbar-link-vert-item">APPLY</a>
          <a href="./about.php" class="navbar-link-vert-item">ABOUT</a>
          <?php if (isset($_SESSION['first_name'])): ?>
            <a href="./account.php" class="navbar-link-vert-item">
              <?= htmlspecialchars(strtoupper($_SESSION['first_name'])) ?>
            </a>
          <?php else: ?>
            <a href="./login.php" class="navbar-link-vert-item">LOGIN</a>
          <?php endif; ?>
          <form method="POST" action="./toggle_theme.php" class="navbar-theme-form">
            <button type="submit" class="navbar-theme-btn">
              <?= $is_dark ? 'Light Mode' : 'Dark Mode' ?>
            </button>
          </form>
        </div>
      </div>

    </div>
  </nav>
</header>