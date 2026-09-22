"use strict";
$(function () {
  $(document).on("submit", "#register-phone", function (e) {
    e.preventDefault();
    let $this = $(this);
    let mobile = $(this).find("input[name=mobile_number]").val();
    if (mobile == "") {
      showErrorMessage("Mobile number is required");
      return false;
    }
    showAjaxLoader();
    axios
      .post($this.data("action"), new FormData($this.get(0)))
      .then(function (response) {
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
        showErrorMessage("Something went wrong");
        showAjaxLoader(false);
      });
  });

  $(document).on("click", "#resend-otp-btn", function (e) {
    e.preventDefault();
    showAjaxLoader();
    axios
      .post($(this).data("action"))
      .then(function (response) {
        // console.log(response);
        if (response.data.hasOwnProperty("reset")) {
          location.reload();
          return false;
        }

        if (!response.data.status) {
          showErrorMessage(response.data.message);
        } else {
          showErrorMessage(response.data.message, "success");
        }
        showAjaxLoader(false);
      })
      .catch(function (error) {
        showErrorMessage("Something went wrong");
        showAjaxLoader(false);
      });
  });

  $(document).on("submit", "#verify-otp-form", function (event) {
    let otp = $("#verify-otp-form input[name=otp]").val();
    event.preventDefault();
    if (otp == "") {
      showErrorMessage("Verification code is required");
      return false;
    }
    showAjaxLoader();
    axios
      .post($(this).data("action"), new FormData($(this).get(0)))
      .then(function (response) {
        // console.log(response);
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
        showErrorMessage("Something went wrong");
        showAjaxLoader(false);
      });
  });

  $(document).on("submit", "#change-password-form", function (event) {
    let password = $("#change-password-form input[name=password]").val();
    let cpassword = $("#change-password-form input[name=cpassword]").val();
    event.preventDefault();
    if (password == "") {
      showErrorMessage("Password is required");
      return false;
    } else if (cpassword == "") {
      showErrorMessage("Confirm Password is required");
      return false;
    } else if (!regxForPassword.test(password)) {
      showErrorMessage(
        "Password should contain at least 1 upper case, 1 lower case, 1 numeric character, 1 special character and 8 characters long."
      );
      return false;
    } else if (password != cpassword) {
      showErrorMessage("Password and confirm password must be same.");
      return false;
    }

    showAjaxLoader();
    axios
      .post($(this).data("action"), new FormData($(this).get(0)))
      .then(function (response) {
        // console.log(response);
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
        showErrorMessage("Something went wrong");
        showAjaxLoader(false);
      });
  });

  $(document).on("submit", "#startup-registration-form", function (e) {
    e.preventDefault();
    let $this = $(this);
    let Company = $(this).find("input[name=company_name]").val();
    if (Company == "") {
      showErrorMessage("Company Name is required");
      return false;
    }
    let Brand = $(this).find("input[name=brand_name]").val();
    if (Brand == "") {
      showErrorMessage("Brand Name is required");
      return false;
    }
    let Description = $(this).find("textarea[name=brief_description]").val();
    if (Description == "") {
      showErrorMessage("Description is required");
      return false;
    }
    let Address = $(this).find("textarea[name=registered_address]").val();
    if (Address == "") {
      showErrorMessage("Address is required");
      return false;
    }
    // let City = $(this).find("select[name=city_id]").val();
    // if (City == "") {
    //   showErrorMessage("City is required");
    //   return false;
    // }
    let Email = $(this).find("input[name=email]").val();
    if (Email == "") {
      showErrorMessage("Email is required");
      return false;
    }
    // let Industry = $(this).find("select[name=industry_segment]").val();
    // if (Industry == "") {
    //   showErrorMessage("Industry is required");
    //   return false;
    // }
    // let Sector = $(this).find("select[name=sector_id]").val();
    // if (Sector == "") {
    //   showErrorMessage("Sector is required");
    //   return false;
    // }
    let formData = new FormData($this.get(0));
    showAjaxLoader();
    axios
      .post($this.data("action"), formData)
      .then(function (response) {
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
        showErrorMessage("Something went wrong");
        showAjaxLoader(false);
      });
  });

  $(document).on("submit", "#startup-fund-detail-form", function (e) {
    e.preventDefault();
    let $this = $(this);
    let FundRequirement = $(this).find("input[name=fund_requirement]").val();
    if (FundRequirement == "") {
      showErrorMessage("Fund Requirement Field is required");
      return false;
    }
    let CommittedInvestors = $(this)
      .find("input[name=committed_investors]")
      .val();
    if (CommittedInvestors == "") {
      showErrorMessage("Committed Investors Name is required");
      return false;
    }
    let committedInvestorsArray = CommittedInvestors.split(",").map((item) =>
      item.trim()
    );
    let committedInvestorsJson = JSON.stringify(committedInvestorsArray);

    let PreMoneyValuation = $(this)
      .find("label[name=pre_money_valuation]")
      .val();
    if (PreMoneyValuation == "") {
      showErrorMessage("Pre Money Valuation is required");
      return false;
    }

    let CurrentFundRaise = $(this)
      .find("textarea[name=current_fund_raise]")
      .val();
    if (CurrentFundRaise == "") {
      showErrorMessage("Current Fund Raise is required");
      return false;
    }
    let FundsRequiredFromShuru = $(this)
      .find("input[name=funds_required_from_shuru]")
      .val();
    if (FundsRequiredFromShuru == "") {
      showErrorMessage("Funds Required From PrivateDeals is required");
      return false;
    }
    let MinTicketSize = $(this).find("input[name=min_ticket_size]").val();
    if (MinTicketSize == "") {
      showErrorMessage("Min Ticket Size is required");
      return false;
    }
    let PreMoneyValuationBasis = $(this)
      .find("textarea[name=pre_money_valuation_basis]")
      .val();
    if (PreMoneyValuationBasis == "") {
      showErrorMessage("Pre Money Valuation Basis is required");
      return false;
    }
    let InstrumentAndConversionCondition = $(this)
      .find("textarea[name=instrument_and_conversion_condition]")
      .val();
    if (InstrumentAndConversionCondition == "") {
      showErrorMessage("Instrument And Conversion Condition is required");
      return false;
    }

    let FundUtilisationDetails = $(this)
      .find("textarea[name=fund_utilisation_details]")
      .val();
    if (FundUtilisationDetails == "") {
      showErrorMessage("Fund Utilisation Details is required");
      return false;
    }

    let fundformData = new FormData($this.get(0));
    fundformData.set("committed_investors", committedInvestorsJson);
    showAjaxLoader();
    axios
      .post($this.data("action"), fundformData)
      .then(function (response) {
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
        showErrorMessage("Something went wrong");
        showAjaxLoader(false);
      });
  });

  $(document).on("submit", "#startup-key-metrics-form", function (e) {
    e.preventDefault();
    let $this = $(this);
    let FounderCapitalContribution = $(this)
      .find("input[name=founder_capital_contribution]")
      .val();
    if (FounderCapitalContribution == "") {
      showErrorMessage("Founder Capital Contribution is required");
      return false;
    }
    let MonthlyRevenueRunRate = $(this)
      .find("input[name=monthly_revenue_run_rate]")
      .val();
    if (MonthlyRevenueRunRate == "") {
      showErrorMessage("Monthly Revenue Run Rate is required");
      return false;
    }
    let annualized_revenue_run_rate = $(this)
      .find("input[name=annualized_revenue_run_rate]")
      .val();
    if (annualized_revenue_run_rate == "") {
      showErrorMessage("Annualized Revenue Run Rate is required");
      return false;
    }
    let CurrentMonthlyBurn = $(this)
      .find("input[name=current_monthly_burn]")
      .val();
    if (CurrentMonthlyBurn == "") {
      showErrorMessage("Current Monthly Burn is required");
      return false;
    }
    let CurrentCashBalance = $(this)
      .find("input[name=current_cash_balance]")
      .val();
    if (CurrentCashBalance == "") {
      showErrorMessage("Current Cash Balance is required");
      return false;
    }
    let RunwayMonths = $(this).find("input[name=runway_months]").val();
    if (RunwayMonths == "") {
      showErrorMessage("Runway Months is required");
      return false;
    }
    let TractionMetrics = $(this).find("textarea[name=traction_metrics]").val();
    if (TractionMetrics == "") {
      showErrorMessage("Traction Metrics is required");
      return false;
    }
    let KeyUspDifferentiatorEntryBarrier = $(this)
      .find("textarea[name=key_usp_differentiator_entry_barrier]")
      .val();
    if (KeyUspDifferentiatorEntryBarrier == "") {
      showErrorMessage("Key Usp Differentiator Entry Barrier is required");
      return false;
    }
    let Competitors = $(this).find("input[name=competitors]").val();
    if (Competitors == "") {
      showErrorMessage("Competitors is required");
      return false;
    }
    let fundformData = new FormData($this.get(0));
    showAjaxLoader();
    axios
      .post($this.data("action"), fundformData)
      .then(function (response) {
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
  

  $(document).on("submit", "#startup-financial-detail-form", function (e) {
    e.preventDefault();
    let $this = $(this);
    
    let fundformData = new FormData($this.get(0));
    showAjaxLoader();
    axios
      .post($this.data("action"), fundformData)
      .then(function (response) {
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
  $(document).on("submit", "#other-details-form", function (e) {
    e.preventDefault();
    let $this = $(this);
    
    let fundformData = new FormData($this.get(0));
    showAjaxLoader();
    axios
      .post($this.data("action"), fundformData)
      .then(function (response) {
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
  $(document).on("submit", "#startup-document-detail-form", function (e) {
    e.preventDefault();
    let $this = $(this);
    
    let fundformData = new FormData($this.get(0));
    showAjaxLoader();
    axios
      .post($this.data("action"), fundformData)
      .then(function (response) {
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

  function responseManage(response) {
    if (response.data.hasOwnProperty("main")) {
      $("#mainRegisterContainer").html(response.data.main);
    } else {
      $("#registerFormContent").html(response.data.view);
    }
    window.scroll({
      top: 0,
      behavior: "smooth",
    });
  }
});
