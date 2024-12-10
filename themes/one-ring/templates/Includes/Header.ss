<!-- BEGIN HEADER -->
<header id="header">
    <div id="top-bar">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <ul id="top-buttons">
                        <li><a href="#"><i class="fa fa-sign-in"></i> Login</a></li>
                        <li><a href="#"><i class="fa fa-pencil-square-o"></i> Register</a></li>
                        <li class="divider"></li>
                        <li>
                            <div class="language-switcher">
                                <span><i class="fa fa-globe"></i> English</span>
                                <ul>
                                    <li><a href="#">Deutsch</a></li>
                                    <li><a href="#">Espa&ntilde;ol</a></li>
                                    <li><a href="#">Fran&ccedil;ais</a></li>
                                    <li><a href="#">Portugu&ecirc;s</a></li>
                                </ul>
                            </div>
                        </li>

                        <!-- BOOTSTRAP SEARCH BEGINS

                        <li>
                        <form id="site-search">
                            <span><i class="fa fa-search"></i></span>
                            <input type="text" name="q" placeholder="Search">
                        </form>
                        </li>

                        BOOTSTRAP SEARCH ENDS -->

                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div id="nav-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <a href="index.html" class="nav-logo"><img src="$ThemeDir/images/logo.png" alt="One Ring Rentals" /></a>
                    <!-- BEGIN SEARCH -->
                    <div id="sb-search" class="sb-search">
                        <form>
                            <input class="sb-search-input" placeholder="Search..." type="text" value="" name="search" id="search">
                            <input class="sb-search-submit" type="submit" value="">
                            <i class="fa fa-search sb-icon-search"></i>
                        </form>
                    </div>
                    <!-- END SEARCH -->
                    <!-- BEGIN MAIN MENU -->
                    <nav class="navbar">
                        <button id="nav-mobile-btn"><i class="fa fa-bars"></i></button>

                        <ul class="nav navbar-nav">
                            <% loop $Menu(1) %>
                                <li><a href="$Link" class="$LinkingMode">$MenuTitle</a></li>
                            <% end_loop %>
                        </ul>

                    </nav>
                    <!-- END MAIN MENU -->

                </div>
            </div>
        </div>
    </div>
</header>
<!-- END HEADER -->
