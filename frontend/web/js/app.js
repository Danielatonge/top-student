var show_mob = 'start';
var cropper;
$('[name="phone"]').mask('+7 (999) 999-99-99');
$('[name="date_start"]').datepicker();
$('[name="date_end"]').datepicker();

$(document).ready(function(){
    $('.events-form').on('submit', function(e) {
       //  e.preventDefault();
       // let data = $(this).serializeArray();
       //  console.log(toObject(data));
    });
    // $('[name="online"]').on('change', function(){
    //     let val = $(this).val();
    //     if (val) {
    //         $('.address-box-wrapper').hide();
    //     } else {
    //         $('.address-box-wrapper').show();
    //     }
    // });

    $('[name="metro[]"]').select2();

    $('[name="closed_registration"]').on('change', function(){
        let val = $(this).is(':checked');
        if (val) {
            $('[name="link"]').attr('required', 'required');
        } else {
            $('[name="link"]').removeAttr('required');
        }
    });

    $('[name="price_sale"]').on('change', function(){
       let sale = parseInt($(this).val());
       let price = parseInt($('[name="price"]').val());
       if (sale >= price) {
           alert('Стоимость со скидкой должна быть ниже стоимости без скидки!');
           $('[name="price_sale"]').val('');
       }
    });
    //
    $('[name="price"]').on('change', function(){
        let price = parseInt($(this).val());
        let sale = parseInt($('[name="price_sale"]').val());
        if (sale >= price) {
            alert('Стоимость со скидкой должна быть ниже стоимости без скидки!');
            $('[name="price_sale"]').val('');
        }
    });

    $('[name="multi_day"]').on('change', function(){
        let val = $(this).val();

        if (val == 1) {
            $('[name="date_end"]').parents('.form-input').show();
        } else {
            $('[name="date_end"]').parents('.form-input').hide();
        }
    });

    $('[name="online"]').on('change', function(){
        let val = $(this).val();
        console.log(val);

        if (val == 1) {
            $('[name="address[]"]').removeAttr('required');
            $('.address-wrapper').hide();

        } else {
            $('[name="address[]"]').attr('required', 'required');
            $('.address-wrapper').show();
        }
    });

    $('[name="free"]').on('change', function(){
        let val = $(this).is(':checked');
        if (val) {
            $('[name="price"]').removeAttr('required');
            $('[name="sales"]').removeAttr('required');
            $('[name="price_sale"]').removeAttr('required');
            $('[name="sales"]').attr('disabled', 'disabled').val('');
            $('[name="price"]').attr('disabled', 'disabled').val('');
            $('[name="price_sale"]').attr('disabled', 'disabled').val('');
        } else {
            $('[name="price"]').attr('required', 'required');
            $('[name="sales"]').attr('required', 'required');
            $('[name="price_sale"]').attr('required', 'required');
            $('[name="price"]').removeAttr('disabled');
            $('[name="sales"]').removeAttr('disabled');
            $('[name="price_sale"]').removeAttr('disabled');
        }
    });

    $('.file-repeater').on('click', function(e) {
        e.preventDefault();
        $('[name="metro[]"]').select2("destroy");
        $(this).siblings('.address-box').append('<div class="col-md-6"> <div class="form-input"> <label>Метро</label> '+ selectMetro+ ' </div> </div><div class="col-md-6"> <div class="form-input"> <label> Адрес (без метро)</label> <input type="text" required placeholder="Введите адрес" name="address[]"> <input type="hidden" name="coords[]"> </div> </div> ');

        $('[name="metro[]"]').select2();
        $('[name="address[]"]').suggestions({
            token: "3d99c0f9e95dc8d10aef69bba346a80db02a30be",
            type: "ADDRESS",
            onSelect: function(suggestion) {
                console.log(suggestion);
            }
        });
    });

    $('.file-repeater1').on('click', function(e) {
        e.preventDefault();
        $(this).siblings('.address-box').append('<div class="col-md-12"> <div class="form-input"> <input type="text" placeholder="Введите адрес филиала" name="filials[]"> </div> </div>');
        $('[name="filials[]"]').suggestions({
            token: "3d99c0f9e95dc8d10aef69bba346a80db02a30be",
            type: "ADDRESS",
            onSelect: function(suggestion) {
                console.log(suggestion);
            }
        });
    });

    if ($(window).width() >= 768 ) {
        $(".content__slider").slick({
            dots: true,
            arrows: false,
            infinite: true,
            speed: 500,
            slidesToShow: 1,
            autoplay: true,
            autoplaySpeed: 5000,
        });
        $('.context-box-tags').slick({
            dots: false,
            arrows: false,
            infinite: true,
            speed: 500,
            slidesToShow: 12,
            slidesToScroll: 4,
            variableWidth: true,
            autoplay: true,
            autoplaySpeed: 5000,
            touchThreshold:100
        });
    } else {
        $(".content__slider").slick({
            dots: false,
            arrows: false,
            infinite: true,
            speed: 300,
            slidesToShow: 1
        });
        $('.context-box-tags').slick({
            dots: false,
            arrows: true,
            infinite: true,
            speed: 300,
            slidesToShow: 3,
            slidesToScroll: 2,
            variableWidth: true
        });
    }

    $(".partner-wrapper").slick({
        dots: false,
        arrows: true,
        infinite: true,
        speed: 300,
        slidesToShow: 5,
        responsive: [
            {
                breakpoint: 1170,
                settings: {
                    slidesToShow: 3,
                    centerMode: true
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    centerMode: true
                }
            },
            {
                breakpoint: 450,
                settings: {
                    slidesToShow: 1,
                    centerMode: true
                }
            }
        ]
        // centerMode: true
    });

    $(".context-slider-wrapper").slick({
        dots: false,
        arrows: true,
        infinite: true,
        speed: 300,
        slidesToShow: 3,
        slidesToScroll: 2,
        responsive: [
            {
                breakpoint: 900,
                settings: {
                    slidesToShow: 1,
                }
            },
            {
                breakpoint: 450,
                settings: {
                    slidesToShow: 1,
                }
            }
        ]
        // centerMode: true
    });
    $(".single-slider").slick({
        dots: false,
        arrows: true,
        infinite: true,
        speed: 300,
        slidesToShow: 1,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 900,
                settings: {
                    slidesToShow: 1,
                }
            },
            {
                breakpoint: 450,
                settings: {
                    slidesToShow: 1,
                }
            }
        ]
        // centerMode: true
    });
    $('.mini-slider').slick({
        slidesToShow: 6,
        slidesToScroll: 1,
        infinite: true,
        asNavFor: '.single-slider',
        dots: false,
        arrows: false,
        focusOnSelect: true
    });
});


$(document).on('click', '.hover__block-organization span', function(e){
    e.preventDefault();
    let href = $(this).attr('href');
    window.location = href;
});
$('.vol-select').on('change', function () {
    let val = $(this).val();
    if (val == 3) {
        $('.vol-field').show();
    } else {
        $('.vol-field').hide();
    }
});

$('[name="type"]').on('change', function(e){
    let val = $(this).val();
    if (val == 1) {
        $('[name="promocode"]').closest('.form-input').show();
    } else {
        $('[name="promocode"]').closest('.form-input').hide();
    }
});
$('[name="closed_registration"]').on('change', function(e){
    let val = $(this).is(':checked');
    if (val) {
        $('.closed-event').show();
    } else {
        $('.closed-event').hide();
    }
});

$('.info-form').on('submit', function(e){
   e.preventDefault();
   var data = $(this).serializeArray();
   var self = $(this);
    $.ajax({
        url: '/site/info',
        method: 'POST',
        dataType: 'json',
        data: data,
        success: function (response) {
            $(self).hide().siblings('.hidden').show().text(response.message);
        }
    });
});


$('.email-form').on('submit', function(e) {
   e.preventDefault();
    let data = $(this).serializeArray();
    var self = $(this);
    $.ajax({
        url: '/site/emails',
        method: 'POST',
        dataType: 'json',
        data: data,
        success: function (response) {
            $(self).hide().siblings('.hidden').show().text(response.message);
        }
    });
});

$('.restore-form').on('submit', function(e){
   e.preventDefault();
   let data = $(this).serializeArray();
    $.ajax({
        url: '/site/restore',
        method: 'POST',
        dataType: 'json',
        data: data,
        success: function (response) {
            console.log(response);
        }
    });
   $(this).hide();
   $(this).siblings('.hidden').show();

});


$('.crop-image').on('click', function(){
    cropper.getCroppedCanvas().toBlob((blob) => {
        const formData = new FormData();

        formData.append('croppedImage', blob/*, 'example.png' */);

        $.ajax('/site/upload-crop', {
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success(response) {
                if ($('[name="logoImage"]').length) {
                    $('[name="logoImage"]').val(response);
                }
                if ($('[name="preview"]').length) {
                    $('[name="preview"]').val(response);
                }

                $('.cropper-container').remove();
                $('.profile-image').attr('src', response).removeClass('cropper-hidden').show();
                $('.crop-image').hide();
            },
            error() {
                alert('Ошибка, попробуйте позже');
            },
        });
    }/*, 'image/png' */);
});
$('[name="image"]').on('change', function(e) {
    self = $(this);
    var file_data = $(this).prop('files')[0];
    var form_data = new FormData();
    form_data.append('file', file_data);
    $.ajax({
        url: '/site/upload-file',
        dataType: 'html',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function (response) {
            self.siblings('img').attr('src', response).show();
            if ($('[name="image_file"]').length) {
                $('[name="image_file"]').val(response);
            }
            var minAspectRatio = 1.63;
            var maxAspectRatio = 1.63;
            var image = document.querySelector('#image_cropper');
            $('.crop-image').show();
            $('.file-btn').hide();

            cropper = new Cropper(image, {
                aspectRatio: 360 / 220,
                minContainerHeight: 220,
                minContainerWidth:360,
                setCropBoxData: {
                    width: 360,
                    height: 220
                },
                ready: function () {
                    var cropper = this.cropper;
                    var containerData = cropper.getContainerData();
                    var cropBoxData = cropper.getCropBoxData();
                    var aspectRatio = 1.63;
                    var newCropBoxWidth;

                        newCropBoxWidth = cropBoxData.height * ((minAspectRatio + maxAspectRatio) / 2);

                        cropper.setCropBoxData({
                            left: (containerData.width - newCropBoxWidth) / 2,
                        });
                }
            });
            self.siblings('[type="text"]').val(response);
        }
    });
});
$('.context-box-tags a').on('click', function(e){
    e.preventDefault();
    e.preventDefault();
    var parent = $(this).closest('.context-box');
    let type = $(this).data('type');
    let category = $(this).data('category');
    let company_id = $(this).data('company-id');
    let is_main = $(this).data('is-main');
    preloaderShow();
    $.ajax({
        url: '/' + type +'/sort',
        method: 'POST',
        dataType: 'html',
        data: {
            'sort' : 'category',
            'category' : category,
            'company_id' : company_id,
            'is_main' : is_main
        },
        success: function (data) {
            if (data) {
                $(parent).find('.context-box-wrapper').html(data);
                // $('.context-box-wrapper').html(data);
            } else {
                $(parent).find('.context-box-wrapper').html('');
            }
            setTimeout(function(){
                preloaderHide();
            }, 500);
        }
    });
})

$('.popup-box-menu').hover(function(){
    $('#registration_popup').show();
}, function(){
    $('#registration_popup').hide();
});
$(document).on('change', '[name="address[]"]', function() {
    var current = $(this);
    let val = $(this).val();
    $.ajax({
        url: 'https://geocode-maps.yandex.ru/1.x/?apikey=21b5bc5d-3721-4578-91e4-e9d11c86c640&geocode=' + val + '&format=json',
        method: 'GET',
        dataType: 'json',
        success: function (response) {

            var coords = response.response.GeoObjectCollection.featureMember[0].GeoObject.Point.pos;
            coords = coords.replace(' ', ',');
            $(current).siblings('[name="coords[]"]').val(coords);
            // $(current).closest('.row').find('.y_link').val(coords[0] + "," + coords[1]);
        }
    });
});
$('.mobile-wrapper-account').on('click', function(){
    $('.menu-mobile-account').show();
    show_mob = true;
});
$('.menu-mobile-account').on('click', function(){
    $('.menu-mobile-account').hide();
})
$('body').on('click', function(){
    // if (show_mob != 'start' && show_mob == true) {
    //     $('.menu-mobile-account').hide();
    //     show_mob = false;
    // }
});
$('.popup-box2').hover(function(){
    $(this).find('#sort_popup').show();
}, function(){
    $(this).find('#sort_popup').hide();
});

$('.file-btn').on('click', function(e){
    e.preventDefault();
    $(this).siblings('[type="file"]').click();
});

$('.popup-block a, .popup-mobile-block a').on('click', function(e){
    e.preventDefault();
    var parent = $(this).closest('.context-box');
    let sort = $(this).data('sort');
    let type = $(this).data('type');
    let company_id = $(this).data('company-id');
    let is_main = $(this).data('is-main');
    preloaderShow();
    $.ajax({
        url: '/' + type +'/sort',
        method: 'POST',
        dataType: 'html',
        data: {
            'sort' : sort,
            'type' : type,
            'company_id' : company_id,
            'is_main' : is_main
        },
        success: function (data) {
            if (data) {
                $(parent).find('.context-box-wrapper').html(data);
                // $('.context-box-wrapper').html(data);
            }
            setTimeout(function(){
                preloaderHide();
            }, 500);
        }
    });
});

$('.mobile-filter .select').on('click', function(e){
    e.preventDefault();
    $(this).toggleClass("active");
    $(this).find('.popup-mobile-block').toggleClass("active");
});

$('.popup-mobile-block').on('click', function(){
   // $(this).removeClass('active');
})

$('.context-box__header-map_online a, .mobile-filter .online').on('click', function(e){
    e.preventDefault();
    let cl = $(this).hasClass('active');
    let type = $(this).data('type');
    $(this).toggleClass("active");
    // let val = $(this).is(':checked');
    let company_id = $(this).data('company-id');
    let is_main = $(this).data('main');
    var parent = $(this).closest('.context-box');
    preloaderShow();
    $.ajax({
        url: '/' + type +'/sort',
        method: 'POST',
        dataType: 'html',
        data: {
            'sort' : 'online',
            'val' : cl,
            'type' : type,
            'company_id' : company_id,
            'is_main' : is_main
        },
        success: function (data) {
            if (data) {
                $(parent).find('.context-box-wrapper').html(data);
            }
            setTimeout(function(){
                preloaderHide();
            }, 500);
        }
    });
});

$(document).on('click', '.like', function(){
    if (guest) {
        $('#registration_popup [href="#registration_student"]').click();
        return;
    }
   let type = $(this).data('type');
   let id = $(this).data('id');
    var self = $(this);
    $.ajax({
        url: '/' + type +'/like',
        method: 'POST',
        dataType: 'json',
        data: {
            'id' : id,
            'type' : type
        },
        success: function (res) {
            $(self).toggleClass('active');
        }
    });
});

$('.submit-btn').on('click', function(){
    let type = $(this).data('type');
    let id = $(this).data('id');
    var self = $(this);
    $.ajax({
        url: '/' + type +'/submit',
        method: 'POST',
        dataType: 'json',
        data: {
            'id' : id,
            'type' : type
        },
        success: function (res) {
            $(self).text(res.text)
        }
    });
});
function preloaderShow()
{
    $('.preloader-layout').show();
}


function preloaderHide()
{
    $('.preloader-layout').hide();
}
$('.shareIcon').on('click', function () {
    let type = $(this).data('type');
    let title = $('[property="og:title"]').attr('content');
    let description = $('[property="og:description"]').attr('content');
    let image = $('[property="og:image"]').attr('content');
    let link = $('[property="og:url"]').attr('content');
    if (type == 'vk') {
        Share.vkontakte(link, title, image, description);
    }
    if (type == 'facebook') {
        Share.facebook(link, title, image, description);
    }
    if (type == 'twitter') {
        Share.twitter(link, title);
    }
    $.ajax({
        url: '/ajax/set-socials',
        method: 'POST',
        dataType: 'json',
        data: {type: type},
        success: function (response) {
            if (response) {
                console.log(response);
            }
        }
    });
});
var Share = {
    vkontakte: function (purl, ptitle, pimg, text) {
        url = 'http://vkontakte.ru/share.php?';
        url += 'url=' + encodeURIComponent(purl);
        url += '&title=' + encodeURIComponent(ptitle);
        url += '&description=' + encodeURIComponent(text);
        url += '&image=' + encodeURIComponent(pimg);
        url += '&noparse=true';
        Share.popup(url);
    },
    odnoklassniki: function (purl, text) {
        url = 'https://connect.ok.ru/dk?st.cmd=WidgetSharePreview&st.';
        url += 'shareUrl=' + encodeURIComponent(purl);
        Share.popup(url);
    },
    facebook: function (purl, ptitle, pimg, text) {
        url = 'http://www.facebook.com/sharer.php?s=100';
        url += '&p[title]=' + encodeURIComponent(ptitle);
        url += '&p[summary]=' + encodeURIComponent(text);
        url += '&p[url]=' + encodeURIComponent(purl);
        url += '&p[images][0]=' + pimg;
        // }
        Share.popup(url);
    },
    twitter: function (purl, ptitle) {
        url = 'http://twitter.com/share?';
        url += 'text=' + encodeURIComponent(ptitle);
        url += '&url=' + encodeURIComponent(purl);
        url += '&counturl=' + encodeURIComponent(purl);
        Share.popup(url);
    },
    mailru: function (purl, ptitle, pimg, text) {
        url = 'http://connect.mail.ru/share?';
        url += 'url=' + encodeURIComponent(purl);
        url += '&title=' + encodeURIComponent(ptitle);
        url += '&description=' + encodeURIComponent(text);
        url += '&imageurl=' + pimg;
        Share.popup(url)
    },

    popup: function (url) {
        window.open(url, '', 'toolbar=0,status=0,width=626,height=436');
    }
};
function toObject(x)
{
    var formData = {};
    var formDataArrays = {};

    $.each(x, function(i, field){
        if(field.value.trim() != ""){
            if (/\[\]$/.test(field.name)) {
                var fName = field.name.substr(0,field.name.length-2);
                if (!formDataArrays[fName]) {
                    formDataArrays[fName] = [];
                }
                formData[fName+"["+formDataArrays[fName].length+"]"] = field.value;
                formDataArrays[fName].push(field.value);
            } else {
                formData[field.name] = field.value;
            }
        }
    });

    return formData;
}
