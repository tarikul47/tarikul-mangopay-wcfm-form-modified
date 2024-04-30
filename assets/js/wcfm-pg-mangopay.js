(function ($) {
  "use strict";

  /**
   * All of the code for your public-facing JavaScript source
   * should reside in this file.
   *
   * Note: It has been assumed you will write jQuery code here, so the
   * $ function reference has been prepared for usage within the scope
   * of this function.
   *
   * This enables you to define handlers, for when the DOM is ready:
   *
   * $(function() {
   *
   * });
   *
   * When the window is loaded:
   *
   * $( window ).load(function() {
   *
   * });
   *
   * ...and/or other possibilities.
   *
   * Ideally, it is not considered best practise to attach more than a
   * single DOM-ready or window-load handler for a particular page.
   * Although scripts in the WordPress core, Plugins and Themes may be
   * practising this, we should strive to set a better example in our own work.
   */

  let app = {
    init: function () {
      this.setup();
      this.bindEvents();
      this.showHideRelevantFields();
      this.showHideMpStatusFileds();
      this.defaultMpStatusFileds();
      this.createUboHtml();
      //this.setPaymentMode(); // payment method set change event
      //this.uncheckbox();
    },

    setup: function () {
      this.document = $(document);
      this.bank_type = ".mangopay-type";
      this.dependent_class = ".bank-type";
      this.user_mp_status = "#mangopay_user_mp_status";
      this.user_business_type = "#mangopay_user_business_type";
      this.submit_mp = "#submit_mp";
      this.mangopay_update_bi = "#update_business_information";
      this.create_ubo_declaration = "#create_ubo_declaration";
      this.mangopay_add_bank = "#mangopay_add_bank";
      this.mangopay_upload_kyc = "#mangopay_upload_kyc";
      this.mangopay_section_options = "#mangopay_wrapper_section_options";
      this.mangopay_section_menu_item =
        "#mangopay_wrapper_section_options ul li a";
      this.payment_mode_button = "#payment_mode";
      this.mangopay_payment_mode = "#mangopay_payment_mode";
      this.mangopay_billing_country = "#mangopay_billing_country";
    },

    bindEvents: function () {
      this.document.on(
        "change",
        this.bank_type,
        this.showHideRelevantFields.bind(this)
      );
      this.document.on(
        "change",
        this.user_mp_status,
        this.showHideMpStatusFileds.bind(this)
      );
      this.document.on(
        "change",
        this.user_business_type,
        this.showHideMpBusinessTypeFileds.bind(this)
      );
      this.document.on(
        "click",
        this.submit_mp,
        this.createMangopayAcount.bind(this)
      );
      this.document.on(
        "click",
        this.mangopay_update_bi,
        this.updateBusinessInformation.bind(this)
      );
      this.document.on(
        "click",
        this.create_ubo_declaration,
        this.createUboDeclaration.bind(this)
      );
      this.document.on(
        "change",
        this.mangopay_upload_kyc,
        this.changeUploadKyc.bind(this)
      );
      this.document.on(
        "change",
        this.mangopay_add_bank,
        this.changeAddBankCheckbox.bind(this)
      );
      this.document.on(
        "click",
        this.mangopay_section_menu_item,
        this.changeMangopaySection
      );
      this.document.on(
        "change",
        this.payment_mode_button,
        this.changePaymentMode
      );
      this.document.on(
        "change",
        this.mangopay_billing_country,
        function (event) {
          const countrySelect = $("#mangopay_billing_country");
          const stateSelect = $("#mangopay_billing_state");
          // console.log("wecoder_mg_settings", wecoder_mg_settings);
          stateSelect.empty();
          app.changeBillingCountry(event, countrySelect, stateSelect);
        }
      );
    },

    showHideRelevantFields: function (event) {
      let type;

      if (undefined == event) {
        if (!$(this.bank_type).length) return;
        type = $(this.bank_type).val();
      } else {
        type = $(event.currentTarget).val();
      }

      let dependent_field = {
        show: this.dependent_class + ".bank-type-" + type.toLowerCase(),
        hide:
          this.dependent_class + ":not(.bank-type-" + type.toLowerCase() + ")",
      };

      $(dependent_field.show).each(function (key, value) {
        $(value).show().prev("label").show().prev("p").show();
      });

      $(dependent_field.hide).each(function (key, value) {
        $(value).hide().prev("label").hide().prev("p").hide();
      });
    },

    showHideMpStatusFileds: function (event) {
      let user_type;

      if (undefined == event) {
        if (!$(this.user_mp_status).length) return;
        user_type = $(this.user_mp_status).val();
      } else {
        user_type = $(event.currentTarget).val();
      }

      if ("individual" === user_type) {
        $(this.user_business_type).hide().prev("label").hide().prev("p").hide();
      } else {
        $(this.user_business_type).show().prev("label").show().prev("p").show();
      }
    },

    showHideMpBusinessTypeFileds: function (event) {
      let user_business_type;
      if (undefined == event) {
        if (!$(this.user_business_type).length) return;
        user_business_type = $(this.user_business_type).val();
      } else {
        user_business_type = $(event.currentTarget).val();
      }

      if ("businesses" === user_business_type) {
      }
      console.log("event", user_business_type);
    },

    // showHideMpStatusFileds: function (event) {
    //   /**
    //    * Let's catch all input id
    //    */

    //   // Get references to the hidden input fields
    //   const default_vendor_status = $("#mangopay_default_vendor_status");
    //   const default_business_type = $("#mangopay_default_business_type").val();

    //   // Get references to the input fields
    //   const user_mp_status = $("#mangopay_user_mp_status");
    //   const user_business_type = $("#mangopay_user_business_type");

    //   let selected_mp_status;

    //   if (undefined == event) {
    //     if (!$(this.user_mp_status).length) return;
    //     selected_mp_status = $(this.user_mp_status).val();
    //   } else {
    //     selected_mp_status = $(event.currentTarget).val();
    //   }

    //   /**
    //    * User status field need to hide when it's value not either on first time
    //    */

    //   if ("either" !== $("#mangopay_default_vendor_status").val()) {
    //     $("#mangopay_user_mp_status")
    //       .hide()
    //       .prev("label")
    //       .hide()
    //       .prev("p")
    //       .hide();
    //   }

    //   if (selected_mp_status == "business") {
    //     /**
    //      * Business type field show or not
    //      */

    //     // We use the field
    //     $("#mangopay_user_business_type")
    //       .show()
    //       .prev("label")
    //       .show()
    //       .prev("p")
    //       .show();

    //     // get default business type
    //     //   console.log("default_business_type", default_business_type);

    //     if ("either" === $("#mangopay_default_business_type").val()) {
    //       // show it
    //       $("#mangopay_user_business_type")
    //         .show()
    //         .prev("label")
    //         .show()
    //         .prev("p")
    //         .show();
    //     } else {
    //       // hide it
    //       $("#mangopay_user_business_type")
    //         .hide()
    //         .prev("label")
    //         .hide()
    //         .prev("p")
    //         .hide();
    //     }

    //     //    console.log("user type =", selected_mp_status);
    //   } else {
    //     /** Is not business: should not be here neither have a value **/
    //     $("#mangopay_user_business_type")
    //       .val("")
    //       .hide()
    //       .prev("label")
    //       .hide()
    //       .prev("p")
    //       .hide();
    //   }
    // },

    defaultMpStatusFileds: function () {
      console.log("heee", "defaultMpStatusFileds");
      /**
       * User type field need to hide when
       * default_business_type value either and  mangopay_default_vendor_status value not either
       */

      if (
        "either" === $("#mangopay_default_business_type").val() &&
        "either" !== $("#mangopay_default_vendor_status").val()
      ) {
        $("#mangopay_user_business_type")
          .show()
          .prev("label")
          .show()
          .prev("p")
          .show();
      }

      //  $("#message").text("");
      // business type selected wise messge shwoing
      $("#mangopay_user_business_type").on("change", function () {
        var selectedOption = $(this).val();
        var message;
        $("#mc_message").text("");
        console.log("heee", message, selectedOption);

        switch (selectedOption) {
          case "organisations":
            message = "Organisation message";
            break;
          case "business":
            message = "Business message";
            break;
          case "soletrader":
            message = "Soletrader message";
            break;
          default:
            message = "";
        }
        $("#mc_message").text(message);
      });
    },

    changeCountryOptions: function () {
      var option = $("<option selected></option>").val("1").text("Pick me");
      $("#billing_country").empty().append(option).trigger("change");
    },

    createMangopayAcount: function (event) {
      event.preventDefault();

      var errorMessages = $("#mangopay_error_messages");
      // Clear any existing error messages
      errorMessages.empty();

      let $loader = $("#ajax_loader");
      let $updated = $("#mp_submit");
      $loader.show();

      /**
       * Mangopay form validation
       */
      var isValid = true;

      // Fields validation message defined
      const validationFields = [
        {
          fieldId: "#mangopay_firstname",
          errorMessage: "Please select your first name",
        },
        {
          fieldId: "#mangopay_lastname",
          errorMessage: "Please select your last name",
        },
        {
          fieldId: "#mangopay_birthday",
          errorMessage: "Please select your birthday",
        },
        {
          fieldId: "#mangopay_nationality",
          errorMessage: "Please select your nationality",
        },
        {
          fieldId: "#mangopay_billing_country",
          errorMessage:
            "Please enter your legal representative country of residence",
        },
        {
          fieldId: "#mangopay_user_mp_status",
          errorMessage: "Please select your User status!",
        },
        // Add more fields as needed
      ];

      const userMpStatusValue = $("#mangopay_user_mp_status").val();

      if (userMpStatusValue === "business") {
        // Add additional field for business type
        validationFields.push({
          fieldId: "#mangopay_user_business_type",
          errorMessage: "Please select your business type!",
        });
      }

      // validation process
      for (const field of validationFields) {
        const value = $(field.fieldId).val();

        isValid = app.validateField(
          value,
          field.fieldId,
          field.errorMessage,
          function () {
            // Additional logic to execute on successful validation for this field
          }
        );
        if (!isValid) {
          $loader.hide();
          break;
        }
      }

      if (isValid) {
        $.ajax({
          type: "POST",
          dataType: "json",
          url: woodmart_settings.ajaxurl,
          data: {
            action: "create_mp_account",
            payment_method: $("#payment_mode").val(),
            vendor_id: $("#mangopay_vendor_id").val(),
            billing_first_name: $("#mangopay_firstname").val(),
            billing_last_name: $("#mangopay_lastname").val(),
            user_birthday: $("#mangopay_birthday").val(),
            user_nationality: $("#mangopay_nationality").val(),
            billing_country: $("#mangopay_billing_country").val(),
            billing_state: $("#mangopay_billing_state").val(),
            user_mp_status: $("#mangopay_user_mp_status").val(),
            user_business_type: $("#mangopay_user_business_type").val(),
          },
          success: function (response) {
            console.log("submitt6ed", response);

            if (!response.success && response.data.errors) {
              // Loop through the error messages in the data object
              $.each(response.data.errors, function (key, value) {
                // Create a new error message element
                var errorMessage = $("<div>").addClass("error").text(value);

                // Append the error message to the container element
                errorMessages
                  .append(errorMessage)
                  .css({ color: "red", padding: "10px 0px" })
                  .show();
              });

              // Show the error messages container element
              errorMessages.show();
            }

            if (response.success && response.data.msg) {
              $updated
                .html(response.data.msg)
                .css({ color: "green", padding: "10px 0px" })
                .show();
              setTimeout(function () {
                $updated.fadeOut(1000, function () {
                  // Redirect the user after the message fades out
                  //window.location.href = "/store-manager/";
                  window.location.href = "/my-office/settings";
                });
              }, 5000);
              // console.log("success", response.success);
              // console.log("msg", response.msg);
            } else {
              $updated.html(response.data.msg).css({ color: "red" }).show();
              setTimeout(function () {
                $updated.fadeOut(2000);
              }, 5000);
            }
          },
          complete: function () {
            $loader.hide();
          },
        });
      }
    },

    updateBusinessInformation: function (event) {
      event.preventDefault();
      let $loader = $("#ajax_loader");
      let $updated = $("#bi_updated");
      $loader.show();

      var isValid = true;

      // Fields validation message defined
      const validationBusinessFields = [
        {
          fieldId: "#mangopay_birthday",
          errorMessage: "Please select your birthday",
        },
        {
          fieldId: "#mangopay_nationality",
          errorMessage: "Please select your nationality",
        },
        {
          fieldId: "#mangopay_billing_country",
          errorMessage: "Please select your billing country",
        },
        {
          fieldId: "#mangopay_legal_email",
          errorMessage: "Please enter legal representative email",
        },
        {
          fieldId: "#mangopay_compagny_number",
          errorMessage: "Please enter compagny number",
        },
        {
          fieldId: "#mangopay_hq_address",
          errorMessage: "Please enter headquarters address",
        },
        {
          fieldId: "#mangopay_hq_city",
          errorMessage: "Please enter headquarters city",
        },
        {
          fieldId: "#mangopay_hq_region",
          errorMessage: "Please enter headquarters region",
        },
        {
          fieldId: "#mangopay_hq_postalcode",
          errorMessage: "Please enter headquarters postalcode",
        },
        {
          fieldId: "#mangopay_hq_country",
          errorMessage: "Please enter headquarters country",
        },
        // Add more fields as needed
      ];

      // validation process
      for (const field of validationBusinessFields) {
        const value = $(field.fieldId).val();

        isValid = app.validateField(
          value,
          field.fieldId,
          field.errorMessage,
          function () {
            // Additional logic to execute on successful validation for this field
          }
        );
        if (!isValid) {
          $loader.hide();
          break;
        }
      }

      if (isValid) {
        if ($("#mangopay_termsAndConditionsAccepted").prop("checked")) {
          console.log("ajax call");
          $("#_termsAndConditions").removeClass("wcfm_validation_failed");
          $("#mangopay_termsAndConditionsAccepted_error_msg")
            .find("#error-message")
            .text("");

          console.log("terms yes");
          //return;
          $.ajax({
            type: "POST",
            dataType: "json",
            url: woodmart_settings.ajaxurl,
            data: {
              action: "update_mp_business_information",
              vendor_id: $("#mangopay_vendor_id").val(),
              user_birthday: $("#mangopay_birthday").val(),
              user_nationality: $("#mangopay_nationality").val(),
              billing_country: $("#mangopay_billing_country").val(),
              legal_email: $("#mangopay_legal_email").val(),
              compagny_number: $("#mangopay_compagny_number").val(),
              headquarters_addressline1: $("#mangopay_hq_address").val(),
              headquarters_addressline2: $("#mangopay_hq_address2").val(),
              headquarters_city: $("#mangopay_hq_city").val(),
              headquarters_region: $("#mangopay_hq_region").val(),
              headquarters_postalcode: $("#mangopay_hq_postalcode").val(),
              headquarters_country: $("#mangopay_hq_country").val(),
              termsconditions: $("#mangopay_termsAndConditionsAccepted").prop(
                "checked"
              ),
            },
            success: function (response) {
              if (response.success) {
                $updated.html(response.msg).css({ color: "green" }).show();
                setTimeout(function () {
                  $updated.fadeOut(2000);
                }, 5000);
              }
            },
            error: function (jqXHR, textStatus, errorThrown) {
              // Handle other errors
              $updated
                .html("Error: " + textStatus)
                .css({ color: "red" })
                .show();
              setTimeout(function () {
                $updated.fadeOut(2000);
              }, 5000);
            },
            complete: function () {
              $loader.hide();
            },
          });
        } else {
          $("#_termsAndConditions").addClass("wcfm_validation_failed");
          $("#mangopay_termsAndConditionsAccepted_error_msg")
            .find("#error-message")
            .text("Please agree terms conditions of Mangopay!")
            .css({ color: "red" });
          $loader.hide();
          isValid = false;
          console.log("terms no");
        }
      }
    },

    createUboDeclaration: function (event) {
      event.preventDefault();
      let mp_id = $("#ubo_mp_id").val();
      if (mp_id != "") {
        $.ajax({
          type: "POST",
          dataType: "json",
          url: ajax_object.ajax_url,
          data: {
            action: "create_ubo",
            userid: mp_id,
          },
          success: function (response) {
            if (response.error) {
              /* $updated.html('Successfully updated!').css({'color': 'green'}).show();
							setTimeout(function(){ $updated.fadeOut(2000) }, 5000); */
              console.log(response.error);
            } else {
              /* $updated.html(response.msg).css({'color': 'red'}).show();
							setTimeout(function(){ $updated.fadeOut(2000) }, 5000); */
              console.log("UBO Successfully created!");
            }
          },
          complete: function () {
            //$loader.hide();
          },
        });
      }
    },

    createUboHtml: function () {
      var data = {
        action: "create_ubo_html",
        existing_account_id: $("#mangopay_id").val(),
      };
      $.post(ajax_object.ajax_url, data, function (theajaxresponse) {
        $("#ubo_data").html(theajaxresponse);
      });
    },

    changeAddBankCheckbox: function () {
      if ($("#mangopay_add_bank_status").val() == "no") {
        $("#mangopay_add_bank_status").val("yes");
      } else {
        $("#mangopay_add_bank_status").val("no");
      }
    },

    changeUploadKyc: function () {
      if ($("#mangopay_upload_kyc_status").val() == "no") {
        $("#mangopay_upload_kyc_status").val("yes");
      } else {
        $("#mangopay_upload_kyc_status").val("no");
      }
    },

    changeMangopaySection: function (event) {
      event.preventDefault();
      console.log(this);
      $("#mangopay_wrapper_section_options ul li a").removeClass("active");
      $(this).addClass("active");
      var link = $(this).attr("data-link");
      $(".mangopay_information_section").hide();
      console.log(link);
      $("#" + link).show();
    },

    changePaymentMode: function () {
      if ($(this).attr("data-status") == "set") {
        if ($(this).val() == "mangopay")
          $("#wcfm_settings_save_button").trigger("click");
      }
    },

    // setPaymentMode: function () {
    //   setTimeout(function () {
    //     $("#payment_mode").attr("data-status", "set");
    //    }, 5000);
    //  },

    changeBillingCountry: function (event, countrySelect, stateSelect) {
      event.preventDefault();

      // selected country
      const selectedCountry = countrySelect.val();

      // gettting all states
      const states = wecoder_mg_settings.states;

      // Clear the current state options
      //  $stateSelect.empty();

      // Get the states for the selected country
      var countryStates = states[selectedCountry];

      // Add the states as options to the state select element
      if (countryStates && Object.keys(countryStates).length > 0) {
        $(".mangopay_billing_state").show();
        stateSelect.show();
        $.each(countryStates, function (stateCode, stateName) {
          console.log("in", stateCode, stateName);
          stateSelect.append(
            $("<option>", {
              value: stateCode,
              text: stateName,
            })
          );
        });
      } else {
        stateSelect.hide();
        $(".mangopay_billing_state").hide();
      }
    },

    validateField: function (value, elementId, errorMessage, callback = null) {
      const element = $(elementId);
      const errorContainer = element.next().find("#error-message");
      if (value !== "") {
        element.removeClass("wcfm_validation_failed");
        errorContainer.text("");
        if (callback) {
          callback();
        }
        return true; // Validation passed
      } else {
        element.addClass("wcfm_validation_failed");
        errorContainer.text(errorMessage).css({ color: "red" });
        return false; // Validation failed
      }
    },

    // uncheckbox: function () {
    //   console.log("submitjhgghjjhuted");
    //   // Assuming your form has an ID of 'wcfm_settings_form'
    //   $("#wcfm_settings_form").submit(function (event) {
    //     // Listen for the form submission event

    //     console.log("submitted");

    //     // Uncheck the checkbox with the ID 'mangopay_upload_kyc_status'
    //     $("#mangopay_upload_kyc_status").prop("checked", false);
    //     $("#mangopay_upload_kyc").prop("checked", false);

    //     // Prevent the form from submitting if needed
    //     // Remove the following line if you want the form to submit
    //     event.preventDefault();
    //   });
    // },
  };

  $(app.init.bind(app));
})(jQuery);
