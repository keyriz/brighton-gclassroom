(function ($) {
    $(function () {

        function initAsset() {
            if ($('select').length) {
                $("select").chosen({
                    allow_single_deselect: true,
                    disable_search_threshold: 12
                });
            }


            if ($('input[type="checkbox"]').length) {
                $('input[type="checkbox"]').checkbox({
                    checkedClass: 'fa fa-check-square-o',
                    uncheckedClass: 'fa fa-square-o'
                });
            }


            if ($('[data-datepicker]').length) {
                $('[data-datepicker]').datetimepicker({
                    pickTime: false
                });
            }


            var $tis = this,
                $wrapper = $('#wrapper'),
                $navMobile,
                etype = $.browser.mobile ? 'touchstart' : 'click';
            w = $(window).innerWidth();


            if (w <= 975 && !$tis.mobMenuFlag) {

                $('body').prepend('<nav class="nav-mobile"><i class="fa fa-times"></i><h2><i class="fa fa-bars"></i>' + $tis.mobileMenuTitle + '</h2><ul></ul></nav>');

                $('.nav-mobile > ul').html($('.nav').html());

                $('.nav-mobile b').remove();

                $('.nav-mobile ul.dropdown-menu').removeClass().addClass("dropdown-mobile");

                //$('.nav-mobile').css({'min-height': ($('#wrapper').height() + 270) + 'px' });

                $navMobile = $(".nav-mobile");

                $("#nav-mobile-btn").bind(etype, function (e) {
                    e.stopPropagation();
                    e.preventDefault();

                    setTimeout(function () {
                        $wrapper.addClass('open');
                        $navMobile.addClass('open');
                        $navMobile.getNiceScroll().show();
                    }, 25);

                    $(document).bind(etype, function (e) {
                        if (!$(e.target).hasClass('nav-mobile') && !$(e.target).parents('.nav-mobile').length) {
                            $wrapper.removeClass('open');
                            $navMobile.removeClass('open');
                            $(document).unbind(etype);
                            $.waypoints('enable');
                        }
                    });

                    $('>i', $navMobile).bind(etype, function () {
                        $navMobile.getNiceScroll().hide();
                        $wrapper.removeClass('open');
                        $navMobile.removeClass('open');
                        $(document).unbind(etype);
                        $.waypoints('enable');
                    });
                });

                $navMobile.niceScroll({
                    autohidemode: true,
                    cursorcolor: "#c2c2c2",
                    cursoropacitymax: "0.7",
                    cursorwidth: 10,
                    cursorborder: "0px solid #000",
                    horizrailenabled: false,
                    zindex: "1"
                });

                $navMobile.getNiceScroll().hide();

                $tis.mobMenuFlag = true;
            }
        }

        initAsset();

        // Pagination
        if ($('.pagination').length) {
            var paginate = function (url) {
                var param = '&ajax=1',
                    ajaxUrl = (url.indexOf(param) === -1) ?
                        url + '&ajax=1' :
                        url,
                    cleanUrl = url.replace(new RegExp(param + '$'), '');

                $.ajax(ajaxUrl)
                    .done(function (response) {
                        $('.main').html(response);
                        $('html, body').animate({
                            scrollTop: $('.main').offset().top
                        });
                        initAsset();
                        window.history.pushState(
                            {url: cleanUrl},
                            document.title,
                            cleanUrl
                        );
                    })
                    .fail(function (xhr) {
                        alert('Error: ' + xhr.responseText);
                    });
            };

            $('.main').on('click', '.pagination a', function (e) {
                e.preventDefault();
                paginate($(this).attr('href'));
            });

            window.onpopstate = function (e) {
                if (e.state.url) {
                    paginate(e.state.url);
                } else {
                    e.preventDefault();
                }
            }
        }

        // /** begin scrolling div **/
        // const stickyDiv = document.getElementById("stickyDiv");
        // const parentContainer = document.querySelector(".parent-container");
        // const stopTop = document.getElementById("stopTop").offsetTop;
        // const stopBottom = document.getElementById("stopBottom").offsetTop;
        //
        // window.addEventListener("scroll", () => {
        //     const parentTop = parentContainer.offsetTop;
        //     const parentBottom = parentTop + parentContainer.offsetHeight;
        //     const scrollY = window.scrollY;
        //
        //     // Check if scrollY is within the range of the parent container
        //     if (scrollY >= parentTop && scrollY + window.innerHeight <= parentBottom) {
        //         stickyDiv.style.position = "sticky";  // Sticky behavior
        //     } else {
        //         stickyDiv.style.position = "absolute"; // Let it stop when out of parent bounds
        //     }
        //
        //     // Check if sticky div should stop at the bottom
        //     if (scrollY + window.innerHeight >= stopBottom) {
        //         stickyDiv.style.transform = `translateY(${stopBottom - scrollY - window.innerHeight}px)`;
        //     } else {
        //         stickyDiv.style.transform = "translateY(0)";
        //     }
        // });
        // /** end scrolling div **/
    })
})(jQuery);
