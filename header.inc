  <header>
    <nav class="navbar">
      <div class="navbar-container">
        <!--navbar logo links to index page-->
        <div class="navbar-logo">
          <a href="index.php"><img src="./images/logo.png" class="logo-pic" alt="logo-pic"></a>
        </div>
        <!--navbar links to other pages-->
        <div class="navbar-link">
          <a href="./jobs.php" class="navbar-link-item">JOB DESCRIPTION</a>
          <a href="./apply.php" class="navbar-link-item">APPLY</a>
          <a href="./about.php" class="navbar-link-item">ABOUT</a>
          <!--
          <div class="navbar-settings">
            <div class="navbar-link-item">SETTINGS</div>
            <div class="navbar-settings-dropdown-content">
              <label class="switch">
                <input type="checkbox">
                <span class="slider round"></span>
              </label>
            </div>
          </div> -->
        </div>
        <div class="navbar-link-vert">
          <input type="checkbox" id="menu-toggle" class="menu-toggle-input">
          <label class="navbar-link-vert-item" for="menu-toggle" style="font-size: 33px;">=</label>
          <div class="navbar-link-vert-dropdown">
            <a href="./index.php" class="navbar-link-vert-item">HOME</a>
            <a href="./jobs.php" class="navbar-link-vert-item">JOB DESCRIPTION</a>
            <a href="./apply.php" class="navbar-link-vert-item">APPLY</a>
            <a href="./about.php" class="navbar-link-vert-item">ABOUT</a>
            <?php
            if (isset($_SESSION['first_name'])): ?>
              <a href="./account.php" class="navbar-link-vert-item">
                <?= htmlspecialchars(strtoupper($_SESSION['first_name'] ?? 'ACCOUNT')) ?>
              </a>
            <?php else: ?>
              <a href="./login.php" class="navbar-link-item-settings">LOGIN</a>
            <?php endif; ?>
          </div>
        </div>
        <?php
        if (isset($_SESSION['first_name'])): ?>
          <a href="./account.php" class="navbar-link-item">
            <?= htmlspecialchars(strtoupper($_SESSION['first_name'] ?? 'ACCOUNT')) ?>
          </a>
        <?php else: ?>
          <a href="./login.php" class="navbar-link-item-settings">LOGIN</a>
        <?php endif; ?>
      </div>
    </nav>
  </header>