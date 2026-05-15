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
          <div class="navbar-settings">
            <button class="navbar-link-item">ACCOUNT</button>
            <div class="navbar-settings-dropdown-content">
              <label class="switch">
                <input type="checkbox" <?= ($_SESSION['dark_mode'] ?? 0) ? 'checked' : '' ?>>
                <span class="slider round"></span>
              </label>
            </div>
          </div>
        </div>
        <a href="./login.php" class="navbar-link-item-settings">LOGIN</a>
      </div>
    </nav>
  </header>