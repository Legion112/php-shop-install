<div class="big-menu">
	<div class="big-menu-wrap"><i class="fal fa-times no-display menu-close-btn"></i>
	<span class="menu-back-btn"><i class="fa fa-angle-left" aria-hidden="true"></i> &nbsp; &nbsp; ������� ����</span>
	</div>
</div>
<header class="header-2">
    <div class="hidden-menu visible-xs">
        <button type="button" class="close" data-dismiss="alert">
                    <i class="fal fa-times" aria-hidden="true"></i>
                    <span class="sr-only">Close</span>
                </button>
        <div class="clearfix"></div>
        <a class="back"><i class="fa fa-angle-left" aria-hidden="true"></i>�����</a>
        <div class="solid-menus">
            <ul class="no-border-radius block parent-block">
                @leftCatal@
            </ul>
        </div>
    </div>
    <div class="top-banner @php __hide('sticker_close','cookie'); php@">
        <div class="sticker-text">@sticker_delivery@</div><span class="close sticker-close"><i class="fal fa-times" aria-hidden="true"></i></span>
    </div>
    <div class="top-menu">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-9 col-lg-9 col-sm-9 hidden-xs top-menu-block">
                    <ul class="top-menu-list pull-left">
                       <li><span class="top-name-logo">@name@</span></li> @topMenu@
                    </ul>
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3 col-xs-12">
                    <ul class="nav nav-pills pull-right">
                        <li>
                            <div class="search-open-button">
                                <i class="icons-search"></i>
                            </div>
                        </li>
                        <li class="visible-xs">|</li>
                        <li class="visible-xs" role="presentation">@wishlist@</li>
                        <li class="visible-xs" role="presentation">
                            <a href="/compare/">
                                <span class="icons-compare"></span>
                                <span class="text">{� ���������}</span> <span id="numcompare">@numcompare@</span> ��.
                            </a>
                        </li>
                        <li class="visible-xs">|</li>
                        @usersDisp@
                        <li role="presentation" class="visible-xs">
                            <a href="/order/">
                                <span class="icons-cart"></span>&nbsp;
                                <span class="sum">@sum@</span>&nbsp;
                                <span class="rubznak">@productValutaName@</span>                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="vertical-align header-middle-wrap">
            <div class="header-phone">
                <h4>@telNumMobile@</h4>
                @returncall@
            </div>
            <div class="logo">
                <a href="/">
                    <img src="@logo@" alt="@name@"> </a>
            </div>
            <div class="visible-xs soc-sticker">
                @sticker_social@
            </div>
            <div class="header-search col-md-3 visible-xs">
                <input type="checkbox" id="hmt" class="hidden-menu-ticker ">



            </div>
            <ul class="menu-list hidden-xs">
                <li role="presentation">@wishlist@</li>
                <li role="presentation">
                    <a href="/compare/">
                        <span class="icons-compare"></span>
                        <span class="text">{��������}</span> <span id="numcompare">@numcompare@</span> ��.
                    </a>
                </li>
            </ul>

        </div>
    </div>
    <div class="menu-wrap">
        <div class="container-fluid menu-cont">
		     <ul class="dropdown-menu no-border-radius main-menu-block">
                @leftCatal@ 
            </ul>
			<span class="menu-close"><i class="fal fa-times no-display" style="font-size:30px"></i></span>
		</div>
		
    </div>
</header>
<!--/ Header -->
<!-- Fixed navbar -->
<nav class="navbar top-navbar  menu-1" id="navigation">
    <div class="container-fluid">
        <div class="row">
            <div class="navbar-header"></div>
            <div id="navbar" class="navbar-collapse collapse">
                <input type="checkbox" id="hmt" class="hidden-menu-ticker ">
                <label class="btn-menu visible-xs" for="hmt">
                    <span class="first"></span>
                    <span class="second"></span>
                    <span class="third"></span>
                </label>
                <ul class="nav navbar-nav main-menu">
                    <!-- dropdown catalog menu -->
                    <li>
                        <div class="solid-menus">
                            <nav class="navbar no-border-radius no-margin">
                                <div id="navbar-inner-container">
                                    <div class="navbar-header">
                                        <button type="button" class="navbar-toggle navbar-toggle-left" data-toggle="collapse" data-target="#solidMenu">
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                        </button>
                                    </div>
                                    <div class="collapse navbar-collapse" id="solidMenu">
                                        <ul class="nav navbar-nav">
                                            <li class="dropdown">
                                                <a class="dropdown-toggle open-menu" data-toggle="dropdown" href="javascript:void(0);" data-title="{���� �������}"><span><i
                                                            class="icons-line"></i> {���� �������} </span></a>
                                            </li>
                                            <li class="visible-xs"><a href="/users/wishlist.html">{����������
                                                    ������}</a></li>
                                            <li class="visible-xs"><a href="/price/">{�����-����}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                        </div>
                    </li>
                </ul>
                <!-- �������� � ������� ����-->
                <div class="catalog-menu-wrap">
                    <ul class="catalog-menu-list">
                        @topcatMenu@
                    </ul>
                    <form action="/search/" role="search" method="post">
                        <div class="input-group search-block">
                            <input name="words" maxlength="50" id="search" class="form-control" placeholder="{������}.." required="" type="search" data-trigger="manual" data-container="body" data-toggle="popover" data-placement="bottom" data-html="true" data-content="">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit"><span
                                        class="icons-search"></span></button>
                            </span>
                        </div>
                    </form>
					 <div class="search-open-button">
                                <i class="icons-search"></i>
                            </div>
                    <ul class="nav nav-pills pull-right">
                        <li role="presentation">@wishlist@</li>
                        <li role="presentation">
                            <a href="/compare/">
                                <span class="icons-compare"></span>
                                <span id="numcompare2">@numcompare@</span> ��.
                            </a>
                        </li>
                    </ul>
                </div>
                <!--/ �������� � ������� ����-->
                <ul class="nav navbar-nav navbar-right hidden-xs">
                    <li>
                        <a class="header-cart" id="cartlink" data-trigger="click" data-container="body" data-toggle="popover" data-placement="bottom" data-html="true" data-url="/order/" data-content='@visualcart@'>
                            <span class="icons-cart"></span>

                            <span class="visible-lg-inline"><span id="num">@num@</span> {���.} {�� �����} </span>
                            <span id="sum" class="sum">@sum@</span>
                            <span class="rubznak">@productValutaName@</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
    </div>
</nav>
<!--/ Fixed navbar -->
<!-- VisualCart Mod -->
<div id="visualcart_tmp" class="hide">@visualcart@</div>
<!-- Notification -->
<div id="notification" class="success-notification" style="display:none">
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert"><i class="fal fa-times" aria-hidden="true"></i><span
                class="sr-only">Close</span>
        </button>
        <span class="notification-alert"> </span>
    </div>
</div>
<!--/ Notification -->