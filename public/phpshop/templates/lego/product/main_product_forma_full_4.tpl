
<style>
    .sidebar-left-inner,
    .brands, 
    .bx-pager {
        display: none
    }

    div.main {
        width: 100%;

        float: none;
        margin: 0 auto;
    }


    @media (max-width: 767px) {
        .row {
            margin: 0
        }
    }

</style>
<div itemscope itemtype="http://schema.org/Product" class="main-product-block product-4">
    <div class="product-info-block visible-xs">
        <h1 itemprop="name" class="page-header">@productName@</h1>
        <span class="sale-icon-content rel-icon">
            @specIcon@
            @newtipIcon@
            @hitIcon@
            @promotionsIcon@
        </span>
    </div>
    <div>
        <div class="row airSticky_stop-block"">

            <div class=" col-md-6 col-sm-6">

                <div id="fotoload" class="type-4">
                    @productFotoList@
                </div>
                <div class="promo-info">@promotionInfo@ @promotionsIcon@</div>
            </div>
            <div class="col-md-6 col-sm-6">

                <div class="airSticky">
                    <div class="product-info-block">
                        <h1 itemprop="name" class="page-header  hidden-xs">@productName@</h1>
                        <div class="flex-block">
                            <span class="sale-icon-content rel-icon">
                                @specIcon@
                                @newtipIcon@
                            </span>
                            <div class="product-block-btn">
                                @ComStartNotice@

                                <a class="btn btn-circle" href="/users/notice.html?productId=@productUid@"
                                   title="@productNotice@" style="font-size:18px;"><span class="icons-mail"></span></a>

                                @ComEndNotice@

                                <button class="btn btn-circle addToCompareList" role="button" data-uid="@productUid@"><span
                                        class="icons-compare"></span></button>


                                <button class="btn btn-circle addToWishList" role="button" data-uid="@productUid@"><span
                                        class="icons-like"></span></button>
                            </div>
                        </div>
                        <div class="product-page-price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                            <span class="new-price" itemprop="price" content="@productSchemaPrice@">@productPrice@</span>
                            <span class="new-price rubznak" itemprop="priceCurrency"
                                  content="RUB">@productValutaName@</span>
                            <div class="old-price">@productPriceOld@ </div>
                            @ComStartNotice@
                            <div class="outStock">@productOutStock@</div>
                            @ComEndNotice@
                        </div>




                        <p><br></p>
                        <div class="flex-block"></div>
                        <div class="flex-block">
                            <div class="flex-block hidden-xs">
                                <div class="hidden-xs rating">
                                    @rateUid@
                                </div>
                                <div class="rating-amount">������: @avgRateNum@ </div>
                            </div>
                            <div class="small">@productArt@</div>
                        </div>



                        <div class="product-page-option-wrapper">
                            @optionsDisp@
                        </div>
                        <div class="odnotip"> @productParentList@</div>
                        <div class="odnotipListWrapper">

                        </div>
                        <div class="clearfix"></div>

                        <div class="flex-block option-block">
                            @sticker_size@ @sticker_shipping@
                            <a class="question" href="/forma/">������ ������ �� ��������</a>
                        </div>

                        <div class="flex-block">
                            <div class="product-sklad" id="items">@productSklad@</div>
                            <a class="best-price" href="/pricemail/UID_@productUid@.html">@productBestPrice@</a>
                        </div>
                    </div>
                    <div class="@elementCartOptionHide@">
                        <div class="input-group addToCart">
                            <div class="quant-main">
                                <div class="quant input-group @elementCartOptionHide@">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn btn-default btn-default_l btn-number"
                                                data-type="minus" data-field="quant[2]">
                                            -
                                        </button>
                                    </span>
                                    <input type="text" name="quant[2]" class="form-control form-control_gr input-number"
                                           value="1" min="1" max="100">
                                    <span class="input-group-btn">
                                        <button type="button" class=" btn btn-default btn-default_r btn-number"
                                                data-type="plus" data-field="quant[2]">
                                            +
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <button class="btn btn-primary addToCartFull two" data-num="1"
                                    data-uid="@productUid@">@productSale@</button>

                        </div>
                        @oneclick@
                    </div>
                    <div class="@elementCartHide@">
                        <div class="input-group addToCart">
                            <div class="quant-main">
                                <div class="quant input-group @elementCartHide@">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn btn-default btn-default_l btn-number"
                                                data-type="minus" data-field="quant[2]">
                                            -
                                        </button>
                                    </span>
                                    <input type="text" name="quant[2]" class="form-control form-control_gr input-number"
                                           value="1" min="1" max="100">
                                    <span class="input-group-btn">
                                        <button type="button" class=" btn btn-default btn-default_r btn-number"
                                                data-type="plus" data-field="quant[2]">
                                            +
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <button class="btn btn-primary addToCartFull one" data-num="1"
                                    data-uid="@productUid@">@productSale@</button>
                        </div>
                        @oneclick@
                    </div>


                    <div class="panel-group product-panel" id="product-info">
                        <div class="panel">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#product-info"
                                       href="#collapseOne" aria-expanded="true">
                                        �������� ������
                                    </a>
                                </div>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse in">
                                <div class="panel-body">@productDes@</div>
                            </div>
                        </div>
                        <div class="panel">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#product-info"
                                       href="#collapseTwo" aria-expanded="false">
                                        ��������������
                                    </a>
                                </div>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse">
                                <div class="panel-body">
                                    @vendorDisp@
                                </div>
                            </div>
                        </div>
                        <div class="panel">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#product-info"
                                       href="#collapseFour" aria-expanded="false">
                                        ������
                                    </a>
                                </div>
                            </div>
                            <div id="collapseFour" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div id="commentList"> </div>


                                    <button role="button" class="btn btn-comment pull-right" onclick="$('#addComment').slideToggle();
                                        $(this).hide();"><span class="glyphicon glyphicon-plus-sign"></span> {����� �����������}</button>

                                    <div id='addComment' class="well well-sm" style='display:none;margin-top:30px;'>

                                        <h3>{�������� ���� �����}</h3>

                                        <textarea id="message" class="commentTextarea form-control"></textarea>
                                        <input type="hidden" id="commentAuthFlag" name="commentAuthFlag"
                                               value="@php if($_SESSION['UsersId']) echo 1; else echo 0; php@">
                                        <br>
                                        <div class="btn-group" data-toggle="buttons">
                                            <label class="btn btn-success btn-sm">
                                                <input type="radio" name="rate" value="1"> +1
                                            </label>
                                            <label class="btn btn-success btn-sm">
                                                <input type="radio" name="rate" value="2"> +2
                                            </label>
                                            <label class="btn btn-success btn-sm">
                                                <input type="radio" name="rate" value="3"> +3
                                            </label>
                                            <label class="btn btn-success btn-sm">
                                                <input type="radio" name="rate" value="4"> +4
                                            </label>
                                            <label class="btn btn-success btn-sm active">
                                                <input type="radio" name="rate" value="5" checked> +5
                                            </label>
                                            <button role="button" class="btn btn-info btn-sm pull-right"
                                                    onclick="commentList('@productUid@', 'add', 1);">{�������������}</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="inner-nowbuy">
            <h2 class="product-head page-header"><a href="/newtip/" title="{��� �������}">{������ ��������}</a></h2>
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

<!--��������� ���� ������� ��������-->
<div class="modal fade bs-example-modal-sm size-modal" id="sizeModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">������� ��������</h4>
            </div>
            <form role="form" method="post" name="user_forma_size_delivery" action="@ShopDir@/returncall/">
                <div class="modal-body">


                    @productOption1@
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-default" data-dismiss="modal">{�������}</button>

                </div>
            </form>
        </div>
    </div>
</div>
<!--��������� ���� ������� ��������-->
<!--��������� ���� ���������� � ��������-->
<div class="modal fade bs-example-modal-sm size-modal" id="shipModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">���������� � ��������</h4>
            </div>
            <form role="form" method="post" name="user_forma_size_delivery" action="@ShopDir@/returncall/">
                <div class="modal-body">

                    @productOption2@

                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-default" data-dismiss="modal">{�������}</button>

                </div>
            </form>
        </div>
    </div>
</div>
<!--��������� ���� ���������� � ��������-->