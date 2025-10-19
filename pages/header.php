<?php
$columnNumber = 3;
?>
</head>

<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <!-- Menu -->

      <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
        <div class="app-brand demo">
          <a href="/" class="app-brand-link">
            <span class="app-brand-logo demo">
              <img src="/assets/img/icons/logo.jpg" width="50px" />
            </span>
            <span class="app-brand-text demo menu-text fw-bold ms-2">Нэгдсэн судалгаа</span>
          </a>

          <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
          </a>
        </div>

        <div class="menu-inner-shadow"></div>

        <ul class="menu-inner py-1">
          <!-- Dashboard -->
          <li class="menu-item <?php echo $page == '' ? 'active' : '' ?>">
            <a href="/" class="menu-link">
              <i class="menu-icon tf-icons bx bx-home-circle"></i>
              <div data-i18n="Analytics">Эхлэл</div>
            </a>
          </li>

          <!-- Layouts -->
          <?php
          if ($user_role == "admin") { ?>
            <li class="menu-item <?php echo strpos($page, "/shalguur") > -1 ? 'active open' : ''; ?>">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-shuffle"></i>
                <div data-i18n="Layouts">Шалгуур үзүүлэлт</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item <?php echo strpos($page, "/shalguurlist") > -1 ? 'active' : ''; ?>">
                  <a href="/shalguurlist" class="menu-link">
                    <div data-i18n="Without menu">Бүртгэл</div>
                  </a>
                </li>
              </ul>
            </li>
          <?php } ?>
          <li class="menu-item  <?php echo strpos($page, "/statistics") > -1 ? 'active open' : strpos($page, "/statistics") ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
              <i class="menu-icon tf-icons bx bx-bar-chart-alt-2"></i>
              <div data-i18n="Analytics">Статистик</div>
            </a>
            <ul class="menu-sub">
              <?php if ($user_role == "admin" || $user_role == "najiltan") { ?>
                <li class="menu-item <?php echo strpos($page, "/statistics/stschool") > -1 ? 'active' : '' ?>">
                  <a href="/statistics/stschool" class="menu-link">
                    <div data-i18n="Without menu">Байгууллага</div>
                  </a>
                </li>
                <!--
                <li class="menu-item <?php echo strpos($page, "/statistics/stshalguur") > -1 ? 'active' : '' ?>">
                  <a href="/statistics/stshalguur" class="menu-link">
                    <div data-i18n="Without menu">Шалгуур үзүүлэлт</div>
                  </a>
                </li>-->
              <?php } ?>
              <li class="menu-item <?php echo strpos($page, "/statistics/stcompare") > -1 ? 'active' : '' ?>">
                <a href="/statistics/stcompare" class="menu-link">
                  <div data-i18n="Without menu">Харьцуулалт</div>
                </a>
              </li>
              <li class="menu-item <?php echo strpos($page, "/statistics/stnegtgel") > -1 ? 'active' : '' ?>">
                <a href="/statistics/stnegtgel" class="menu-link">
                  <div data-i18n="Without menu">Нэгтгэл</div>
                </a>
              </li>
              <li class="menu-item <?php echo strpos($page, "/statistics/ersdel") > -1 ? 'active' : '' ?>">
                <a href="/statistics/ersdel" class="menu-link">
                  <div data-i18n="Without menu">Эрсдлийн түвшин</div>
                </a>
              </li>
            </ul>
          </li>
          <?php if (/*$user_role == "teacher"*/ 1==1) { ?>
          <li class="menu-item <?php echo strpos($page, "/sudalgaa") > -1 ? 'active' : '' ?>">
            <a href="/sudalgaa/createsudalgaa" class="menu-link">
              <i class="menu-icon tf-icons bx bx-comment-edit"></i>
              <div data-i18n="Analytics">Судалгаа бүртгэх</div>
            </a>
          </li>
          <?php } ?>
          <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Бүртгэл</span>
          </li>
          <?php
          if ($user_role == "admin") {
            echo '<li class="menu-item ';
            echo strpos($page, "/school") > -1 ? 'active open' : "";
            echo '">
              <a href="/school/school" class="menu-link">
                <i class="menu-icon tf-icons bx bx-buildings"></i>
                <div data-i18n="Account Settings">Байгууллага</div>
              </a>
            </li>';
          }
          ?>

          <li class="menu-item <?php echo strpos($page, "/students") > -1 ? 'active open' : strpos($page, "/students") ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
              <i class="menu-icon tf-icons bx bxs-graduation"></i>
              <div data-i18n="Authentications">Сурагч</div>
            </a>
            <ul class="menu-sub">
              <li class="menu-item <?php echo strpos($page, "/students/list") > -1 ? 'active' : '' ?>">
                <a href="/students/list" class="menu-link">
                  <div data-i18n="Without menu">Бүртгэл</div>
                </a>
              </li>
              <li class="menu-item <?php echo strpos($page, "/students/gra") > -1 ? 'active' : '' ?>">
                <a href="/students/gra" class="menu-link">
                  <div data-i18n="Without menu">Төгсөгч</div>
                </a>
              </li>
              <?php
              if ($user_role == "admin") {
                echo '<li class="menu-item ';
                echo strpos($page, "/students/shilj") > -1 ? 'active open' : "";
                echo '">
                  <a href="/students/shilj" class="menu-link">
                    <div data-i18n="Without menu">Шилжилт</div>
                  </a>
                </li>';
              }
              ?>
              <?php
              if ($user_role == "najiltan" || $user_role == "admin") {
                echo '<li class="menu-item ';
                echo strpos($page, "/students/aldaa") > -1 ? 'active open' : "";
                echo '">
                  <a href="/students/aldaa" class="menu-link">
                    <div data-i18n="Without menu">Ангигүй</div>
                  </a>
                </li>';
              }
              if ($user_role == "najiltan" || $user_role == "admin") {
                echo '<li class="menu-item ';
                echo strpos($page, "/students/not-school") > -1 ? 'active open' : "";
                echo '">
                  <a href="/students/not-school" class="menu-link">
                    <div data-i18n="Without menu">Байгууллагагүй</div>
                  </a>
                </li>';
              }
              ?>
              <!--
              <li class="menu-item">
                <a href="/students" class="menu-link">
                  <div data-i18n="Without menu">Шилжилт</div>
                </a>
              </li>
              -->
            </ul>
          </li>
          <li class="menu-item <?php echo strpos($page, "/angilist") > -1 ? 'active' : '' ?> ">
            <a href="/angilist" class="menu-link">
              <i class="menu-icon tf-icons bx bx-user"></i>
              <div data-i18n="Misc">Анги</div>
            </a>
          </li>
          <?php
          if ($user_role == "admin" || $user_role == "najiltan") { ?>
            <li class="menu-item <?php echo strpos($page, "/teacher") > -1 ? 'active' : ""; ?>">
              <a href="/teacher/list" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Misc">Багш</div>
              </a>
            </li>
            <li class="menu-item  <?php echo strpos($page, "/najiltan") > -1 ? 'active' : ""; ?>">
              <a href="/najiltan/list" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-circle"></i>
                <div data-i18n="Misc">Нийгмийн ажилтан</div>
              </a>
            </li>
          <?php } ?>
          
          <li class="menu-header small text-uppercase"><span class="menu-header-text">Тусламж</span></li>
          <li class="menu-item">
            <a href="https://www.youtube.com/playlist?list=PLmsdsy0TbTSHPeYDETPNsRGfh5XavjC6M" target="_blank" class="menu-link">
              <i class="menu-icon tf-icons bx bx-file"></i>
              <div data-i18n="Documentation">Заавар</div>
            </a>
        </ul>
      </aside>