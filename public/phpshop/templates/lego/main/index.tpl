<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="windows-1251">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@pageTitl@</title>
        <meta name="description" content="@pageDesc@">
        <meta name="keywords" content="@pageKeyw@">
        <meta name="copyright" content="@pageReg@">
        <link rel="apple-touch-icon" href="@icon@">
        <link rel="icon" href="@icon@" type="image/x-icon">
        <link rel="mask-icon" href="@icon@" >
        
        <!-- Preload -->
        <link rel="preload" href="@php echo $GLOBALS['SysValue']['dir']['templates'].chr(47).$_SESSION['skin']; php@css/bootstrap.min.css" as="style">
        <link rel="preload" href="@pageCss@" as="style">
        <link rel="preload" href="@php echo $GLOBALS['SysValue']['dir']['templates'].chr(47).$_SESSION['skin']; php@css/fontawesome-light.css"  as="font" type="font/woff2" crossorigin>

        <!-- Bootstrap -->
        <link href="@php echo $GLOBALS['SysValue']['dir']['templates'].chr(47).$_SESSION['skin']; php@css/bootstrap.min.css" rel="stylesheet">
    </head>

    <body id="body" data-dir="@ShopDir@" data-path="@php echo $GLOBALS['PHPShopNav']->objNav['path']; php@" data-id="@php echo $GLOBALS['PHPShopNav']->objNav['id']; php@" data-token="@dadataToken@">

        <link id="bootstrap_theme" data-name="@php echo $_SESSION['skin']; php@" href="@php echo $GLOBALS['SysValue']['dir']['templates'].chr(47).$_SESSION['skin']; php@css/@lego_theme@.css" rel="stylesheet">
        <link href="@pageCss@" type="text/css" rel="stylesheet">

        <!-- Header -->
        @header@
        <!--/ Header -->
        
        <!-- jQuery -->
        <script src="@php echo $GLOBALS['SysValue']['dir']['templates'].chr(47).$_SESSION['skin'].chr(47); php@js/jquery-1.11.0.min.js"></script>

        <section class="slider tabs">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 col-xs-12 main">
                        <div class="bar-padding-top-fix visible-md"></div>
                        <div class="template-slider hidden-xs @php __hide('imageSlider'); php@">
                            @imageSlider@
                        </div>
                        <div class="banner text-center hidden-lg hidden-md hidden-sm">
                            @sticker_mobile_slider@
                        </div>
                        <ul class="action-tabs" role="tablist" id="actionTab">
                            <li class="active @php __hide('specMain'); php@ spec "><a data-toggle="tab" href="#panel1">{���������������}</a></li>
                            <li class="@hitMainHidden@ @php __hide('specMain'); php@ @php __hide('hitMain'); php@">|</li>
                            <li class="@hitMainHidden@ @php __hide('hitMain'); php@"><a data-toggle="tab"
                                                                                        href="#panel2">{��� ������}</a></li>
                        </ul>
                        <div class="tab-content action-tab-content ">
                            <div id="panel1" class="tab-pane fade in active action-tab-pane @php __hide('specMain'); php@">
                                <div class="swiper-slider-wrapper">
                                    <div class="swiper-button-prev-block">
                                        <div class="swiper-button-prev btn-prev1">
                                            <i class="fa fa-angle-left" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                    <div class="swiper-button-next-block">
                                        <div class="swiper-button-next btn-next1">
                                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                    <div class="swiper-container spec-hit-slider">
                                        <div class="swiper-wrapper">@specMain@</div>
                                    </div>
                                </div>
                            </div>

                            <div id="panel2" class="tab-pane fade active in action-tab-pane @hitMainHidden@ @php __hide('hitMain'); php@">
                                <div class="swiper-slider-wrapper">
                                    <div class="swiper-button-prev-block">
                                        <div class="swiper-button-prev btn-prev2">
                                            <i class="fa fa-angle-left" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                    <div class="swiper-button-next-block">
                                        <div class="swiper-button-next btn-next2">
                                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                    <div class="swiper-container spec-main-slider">
                                        <div class="swiper-wrapper">
                                            @hitMain@
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="new-arrival @php __hide('specMainIcon'); php@">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 col-xs-12 main">

                        <h2 class="product-head page-header">
                            <a href="/newtip/" title="{��� �������}">{������� ��������}</a>
                        </h2>

                        <div class="swiper-slider-wrapper">
                            <div class="swiper-button-prev-block">
                                <div class="swiper-button-prev btn-prev3">
                                    <i class="fa fa-angle-left" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="swiper-button-next-block">
                                <div class="swiper-button-next btn-next3">
                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="swiper-container spec-main-icon-slider">
                                <div class="swiper-wrapper">
                                    @specMainIcon@
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <section class="">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-md-3 col-lg-3 hidden-sm hidden-xs  sidebar-left @php __hide('productDay'); php@">@productDay@</div>

                    <div class="col-md-9 catalog-table-wrapper main-content ">
                        <div class="row">
                            @leftCatalTable@
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 col-xs-12 main text-center banner">
                        @sticker_banner@
                    </div>
                </div>
            </div>
        </section>
        <section class="main-content">
            <div class="container-fluid">

                <div class="page-header ">
                    <h1>@mainContentTitle@</h1>
                </div>
                <div>@mainContent@</div>

            </div>
        </section>
        <section class="news @php __hide('miniNews'); php@">
            <div class="container-fluid">
                <div class="row"> @miniNews@
                </div>
            </div>
        </section>
        <section class="nowBuy @php __hide('nowBuy'); php@">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 col-xs-12 main">

                        <h2 class="product-head page-header">
                            <b>{������ ��������}</b>
                        </h2>

                        <div class="swiper-slider-wrapper">
                            <div class="swiper-button-prev-block">
                                <div class="swiper-button-prev btn-prev4">
                                    <i class="fa fa-angle-left" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="swiper-button-next-block">
                                <div class="swiper-button-next btn-next4">
                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="swiper-container nowBuy-slider">
                                <div class="swiper-wrapper">
                                    @nowBuy@
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <br>

        <section class="brands @php __hide('brandsList'); php@">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 col-xs-12 main">

                        <div class="swiper-slider-wrapper">
                            <div class="swiper-button-prev-block">
                                <div class="swiper-button-prev btn-prev5">
                                    <i class="fa fa-angle-left" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="swiper-button-next-block">
                                <div class="swiper-button-next btn-next5">
                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="swiper-container brands-slider">
                                <div class="swiper-wrapper">
                                    @brandsList@
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>


        <section class="news @php __hide('miniGbook'); php@">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 col-xs-12 main">

                        <div class="swiper-slider-wrapper">
                            <div class="swiper-button-prev-block">
                                <div class="swiper-button-prev btn-prev6">
                                    <i class="fa fa-angle-left" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="swiper-button-next-block">
                                <div class="swiper-button-next btn-next6">
                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="swiper-container gbook-slider">
                                <div class="swiper-wrapper">
                                    @miniGbook@
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <!-- toTop -->
        <div class="visible-lg visible-md">
            <a href="#" id="toTop"><span id="toTopHover"></span>{������}</a>
        </div>
        <!--/ toTop -->

        <!-- Footer Section Starts -->
        @footer@


        <div class="modal product-number-fix fade bs-example-modal-sm" id="modalProductView" tabindex="-1" role="dialog"
             aria-hidden="true">
            <div class="modal-dialog modal-lg fastViewContent"></div>
        </div>
        <!-- ��������� ���� ���������� ������ -->
        <div class="modal fade bs-example-modal-sm" id="searchModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">x</span><span
                                class="sr-only">Close</span></button>
                        <h4 class="modal-title">{�����}</h4>
                    </div>
                    <div class="modal-body">
                        <form action="/search/" role="search" method="post">
                            <div class="input-group">
                                <input name="words" maxlength="50" class="form-control" placeholder="{������..}" required=""
                                       type="search">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit"><span
                                            class="glyphicon glyphicon-search"></span></button>
                                </span>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <!--/ ��������� ���� ���������� ������ -->

        <!-- ��������� ���� �����������-->
        <div class="modal fade bs-example-modal-sm" id="userModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm auto-modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">{�����������}</h4>
                        <span id="usersError" class="hide">@usersError@</span>
                    </div>
                    <form role="form" method="post" name="user_forma">
                        <div class="modal-body">
                            <div class="form-group">

                                <input type="email" name="login" class="form-control" placeholder="Email" required="">
                                <span class="glyphicon glyphicon-remove form-control-feedback hide" aria-hidden="true"></span>
                                <br>

                                <input type="password" name="password" class="form-control" placeholder="{������}" required="">
                                <span class="glyphicon glyphicon-remove form-control-feedback hide" aria-hidden="true"></span>
                            </div>
                            <div class="flex-row">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="1" name="safe_users" @UserChecked@> {���������}
                                    </label>
                                </div>
                                <a href="/users/sendpassword.html" class="pass">{������ ������}</a>
                            </div>

                            @facebookAuth@ @twitterAuth@
                        </div>
                        <div class="modal-footer flex-row">

                            <input type="hidden" value="1" name="user_enter">
                            <button type="submit" class="btn btn-primary">{�����}</button>
                            <a href="/users/register.html" >{������������������}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--/ ��������� ���� �����������-->

        @editor@
        
        <!--/ ��������� ���� ���������� ������ -->
        <div class="search-big-block">
            <form id="search_form_small" action="/search/" role="search" method="post" class="header-search-form">
                <input class="form-control input-lg" name="words" maxlength="50"  placeholder="{�����}..." required="" type="search" data-trigger="manual" data-container="body" data-toggle="popover" data-placement="bottom" data-html="true"  data-content="">
                <button class="header-search-button" type="submit">
                    <i class="icons-search"></i>
                </button>
            </form>
            <i class="search-close fa fa-times" aria-hidden="true"></i>
        </div>

        <!-- �������� �� ������������� cookie  -->
        <div class="cookie-message hide"><p></p><a href="#" class="btn btn-default btn-sm">��</a></div>
        <link href="@php echo $GLOBALS['SysValue']['dir']['templates'].chr(47).$_SESSION['skin']; php@css/fontawesome-light.css" rel="stylesheet">
        <link href="@php echo $GLOBALS['SysValue']['dir']['templates'].chr(47).$_SESSION['skin']; php@css/swiper.min.css" rel="stylesheet">
        <script src="@php echo $GLOBALS['SysValue']['dir']['templates'].chr(47).$_SESSION['skin'].chr(47); php@js/jquery.lazyloadxt.min.js"></script>
        <link href="@php echo $GLOBALS['SysValue']['dir']['templates'].chr(47).$_SESSION['skin']; php@css/bootstrap-select.min.css" rel="stylesheet">
        <link href="@php echo $GLOBALS['SysValue']['dir']['templates'].chr(47).$_SESSION['skin']; php@css/suggestions.min.css" rel="stylesheet">
        <link href="@php echo $GLOBALS['SysValue']['dir']['templates'].chr(47).$_SESSION['skin']; php@css/bar.css" rel="stylesheet">
        <script src="@php echo $GLOBALS['SysValue']['dir']['templates'].chr(47).$_SESSION['skin'].chr(47); php@js/bootstrap.min.js"></script>
        <script src="@php echo $GLOBALS['SysValue']['dir']['templates'].chr(47).$_SESSION['skin'].chr(47); php@js/swiper.min.js"></script>
        <script src="@php echo $GLOBALS['SysValue']['dir']['templates'].chr(47).$_SESSION['skin'].chr(47); php@js/jquery.elevatezoom.js"></script>
        <script src="@php echo $GLOBALS['SysValue']['dir']['templates'].chr(47).$_SESSION['skin'].chr(47); php@js/lego.js"></script>
        <script src="@php echo $GLOBALS['SysValue']['dir']['templates'].chr(47).$_SESSION['skin'].chr(47); php@js/imagesloaded.pkgd.js"></script>
        <script src="@php echo $GLOBALS['SysValue']['dir']['templates'].chr(47).$_SESSION['skin'].chr(47); php@js/masonry.pkgd.min.js"></script>
        <script src="@php echo $GLOBALS['SysValue']['dir']['templates'].chr(47).$_SESSION['skin'].chr(47); php@js/bootstrap-select.min.js"></script>
        <script src="@php echo $GLOBALS['SysValue']['dir']['templates'].chr(47).$_SESSION['skin'].chr(47); php@js/jquery.maskedinput.min.js"></script>
        <script src="@php echo $GLOBALS['SysValue']['dir']['templates'].chr(47).$_SESSION['skin']; php@/js/jquery.cookie.js"></script>
        <script src="@php echo $GLOBALS['SysValue']['dir']['templates'].chr(47).$_SESSION['skin']; php@/js/phpshop.js"></script>
        <script src="java/jqfunc.js"></script>
        <script src="@php echo $GLOBALS['SysValue']['dir']['templates'].chr(47).$_SESSION['skin'].chr(47); php@js/jquery.waypoints.min.js"></script>
        <script src="@php echo $GLOBALS['SysValue']['dir']['templates'].chr(47).$_SESSION['skin'].chr(47); php@js/jquery.suggestions.min.js"></script>
        @visualcart_lib@
        <div class="visible-lg visible-md">