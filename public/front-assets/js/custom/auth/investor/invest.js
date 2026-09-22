"use strict";
$(function () {

    $(document).on("submit", "#step1form", function (e) {
        e.preventDefault();
        let $this = $(this);
        
        let fundformData = new FormData($this.get(0));

        showAjaxLoader();
        axios
          .post($this.data("action"), fundformData)
          .then(function (response) {
              console.log(response);
              if (response.data.hasOwnProperty("reset")) {
                  location.reload();
                  return false;
              }
              if (!response.data.status) {
                  showErrorMessage(response.data.message);
              } else {
                  responseManage(response);
              }
              showAjaxLoader(false);
          })
          .catch(function (error) {
              showErrorMessage(error);
              showAjaxLoader(false);
          });
    });
    
        // $(document).on("submit", "#step2form", function (e) {
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
    
    function addMandateToDB(mandateId) {
        alert('addMandateToDB');
        $('input[name=mandateid]').val(mandateId);
        $('input[name=startup]').val($('input[name=startupid]').val());
        
        let formData = $('#step2form').serialize();
        
        axios
          .post("{{ url('investment/step2') }}", formData)
          .then(function (response) {
            console.log(response);
            responseManage(response.data);
          })
          .catch(function (error) {
              console.error("Error occurred:", error);
              // Optionally, add error handling here.
          });
    }


    function responseManage(response) {
        if (response.data.hasOwnProperty("main")) {
            $("#main").html(response.data.main);
        } else {
            $("#dynamicContent").html(response.data.view);
        }
        window.scroll({
            top: 0,
            behavior: "smooth",
        });
    }
});
