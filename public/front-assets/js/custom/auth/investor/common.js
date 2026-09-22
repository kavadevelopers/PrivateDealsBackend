"use strict";
$(function () {

    $(document).on('click', '.fav-btn', function(e) {
        e.preventDefault();
        
        if ($(this).hasClass('btn_favrited')) {
            $(this).removeClass('btn_favrited');
            $(this).removeClass('fav_active');
        } else {
            $(this).addClass('btn_favrited');
            $(this).addClass('fav_active');
        }
        let startup = $(this).data('startup');
        let is_refresh = $(this).data('isrefresh') ? true : false;
        
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        showAjaxLoader();
        axios.post($(this).data('action'), {
            _token: csrf_token,
            startup: startup
        })
        .then(function(response) {
            showAjaxLoader(false);
            if(is_refresh){
                location.reload();
            }
        })
        .catch(function(error) {
            showAjaxLoader(false);
            console.error("There was an error!", error);
        });
    });
    // $(document).on("submit", "#addfamily", function (e) {
    //     e.preventDefault();
    //     let $this = $(this);
        
    //     let fundformData = new FormData($this.get(0));

    //     showAjaxLoader();
    //     axios
    //       .post($this.data("action"), fundformData)
    //       .then(function (response) {
    //           console.log(response);
    //           if (response.data.hasOwnProperty("reset")) {
    //               location.reload();
    //               return false;
    //           }
    //           if (!response.data.status) {
    //               showErrorMessage(response.data.message);
    //           } else {
    //               responseManage(response);
    //           }
    //           showAjaxLoader(false);
    //       })
    //       .catch(function (error) {
    //           showErrorMessage(error);
    //           showAjaxLoader(false);
    //       });
    // });
    $(document).on('click', '.btn-redirect', function(e) {
        
        e.preventDefault();
        let route = $(this).data('route');
        
        window.location.href = route;

    });
    
    // function responseManage(response) {
    //     if (response.data.hasOwnProperty("main")) {
    //         $("#main").html(response.data.main);
    //     } else {
    //         $("#dynamicContent").html(response.data.view);
    //     }
    //     window.scroll({
    //         top: 0,
    //         behavior: "smooth",
    //     });
    // }
});