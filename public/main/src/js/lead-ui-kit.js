$('.dropdown').on('show.bs.dropdown', function(e){
    $(this).find('.dropdown-menu').first().stop(true, true).slideDown(400);
  });
  
  $('.dropdown').on('hide.bs.dropdown', function(e){
    $(this).find('.dropdown-menu').first().stop(true, true).slideUp(400);
  });

  $(function(){



    /* Instantiating iziModal */
    $("#modal-custom").iziModal({
        overlayClose: false,
        overlayColor: 'rgba(0, 0, 0, 0.6)'
    });

              /* Instantiating iziModal */
              $("#login-custom").iziModal({
                overlayClose: false,
                overlayColor: 'rgba(0, 0, 0, 0.6)'
            });
          
            /*$(document).on('click', '.trigger-custom', function (event) {
                event.preventDefault();
                $('#login-custom').iziModal('open');
            });*/
          
            /* JS inside the modal */
          
            $("#login-custom").on('click', 'header a', function(event) {
                event.preventDefault();
                var index = $(this).index();
                $(this).addClass('active').siblings('a').removeClass('active');
                $(this).parents("div").find("section").eq(index).removeClass('hide').siblings('section').addClass('hide');
          
                if( $(this).index() === 0 ){
                    $("#login-custom .iziModal-content .icon-close").css('background', '#ddd');
                } else {
                    $("#login-custom .iziModal-content .icon-close").attr('style', '');
                }
            });
          
            $("#login-custom").on('click', '.submit', function(event) {
                event.preventDefault();
          
                var fx = "wobble",  //wobble shake
                    $modal = $(this).closest('.iziModal');
          
                if( !$modal.hasClass(fx) ){
                    $modal.addClass(fx);
                    setTimeout(function(){
                        $modal.removeClass(fx);
                    }, 1500);
                }
            }); 


        });

          
        
  $(document).ready(function() {


    // const modally = new Modally();
    // modally.add('cprojects');

    $('.select_campaign').click(function(e) {
      e.preventDefault();
  
      var title = $(this).data('title');
      var goal = $(this).data('goal');
      var type = $(this).data('type');
      var description = $(this).data('description');
      var category = $(this).data('category');
      var _date = $(this).data('date');
      var id = $(this).data('id');
  
      $("#c_title").text(title);
      $("#c_goal").text(goal);
      if (type == 1) {
          $("#c_type").text("Donation");
          $("#_capm_submit").text("Donate");
      } else {
          $("#c_type").text("Investing");
          $("#c_shared").text($(this).data('shared'));
          $("#c_stop").text($(this).data('stop'));
          $("#cc_shared").removeClass('d-none');
          $("#cc_stop").removeClass('d-none');
          $("#_capm_submit").text("Invest");
      }
      $("#c_category").text(category);
      $("#c_date").text(_date);
      $("#c_description").html(toHtml(description));


        
 
  
  
      $('#modal-one').iziModal('open');
      $('#modal-one').iziModal({
          title: title,
          subtitle: 'Invest / Donate to this project',
          theme: '',
          headerColor: '#348CD2',
          overlayColor: 'rgba(0, 0, 0, 0.4)',
          bodyOverflow: false,
      });
      
  
      $('#_capm_submit').click(function(e) {
          e.preventDefault();
  
          $.ajax({
              url: '/ajax/select_project',
              type: 'post',
              headers: {
                  'X-CSRF-TOKEN': csrfToken
              },
              data: {
                  id: id,
                  amount: $("#c_amount").val(),
              },
              success: function(data) {
                  if (data.s == 1) {
                      Toasting(1, data.m);
                  } else {
                      Toasting(0, data.m);
                  }
              },
              error: function(xhr, status, error) {
                  var errorObject = JSON.parse(xhr.responseText);
                  if (errorObject.message == 'Unauthenticated.') {
                      Toasting(0, 'Pls login or register first');
                  } else {
                      console.log(xhr.responseText);
                  }
              }
          });
      });
  });
  

  $(".iziModal").iziModal({
    width: 700,
    radius: 5,
    padding: 20,
    headerColor: '#348CD2',
    loop: true
  });



  
    var overlay = $(".overlay2");
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    $("#service_message").submit(function(e) {
      e.preventDefault();
      var formData = new FormData(this);
      overlay.removeClass("d-none");
      $.ajax({
          url: '/ajax/action',
          type: 'post',
          data: formData,
          processData: false, // Prevent jQuery from automatically processing the data
          contentType: false, // Prevent jQuery from automatically setting the Content-Type header
  
          success: function(data) {
            overlay.addClass("d-none");
            if(data.s == 1) {
              Toasting(1, data.m);
            } else {
              Toasting(0, data.m);
            }
              console.log(data);
          },
  
          error: function(xhr, status, error) {
            overlay.addClass("d-none");
              console.error(xhr.responseText);
          }
      });
  });
  

    $(document).on('input', '#service_quantity', function() {
      var quantity = parseInt($("#service_quantity").val()) || 0; // Parse input value to an integer or default to 0 if not a valid number
      var price = parseFloat($("#service_price").val()) || 0; // Parse input value to a float or default to 0 if not a valid number
      var total = quantity * price;
      var totalID = $("#total_service");
  
      totalID.text(total.toFixed(2)); // Display total with 2 decimal places
  });
  
  
  $(document).on('click', '#service_checkout', function(e) {
    e.preventDefault();
  
    var id = $("#service_id").val();
    var quantity = $("#service_quantity").val();
    var price = $("#service_price").val();
    var user_id = $("#user_id_pay").val();
    var user_fullname = $("#user_fullname").val();
    var user_email = $("#user_email").val();
    var title = $("#tite_name").val();
    overlay.removeClass("d-none");    

    $('#service_pay_user').iziModal('open');
    $('#service_pay_user').iziModal({
        title: "Paying sum of ",
        subtitle: 'Pls select your payment method',
        theme: '',
        headerColor: '#348CD2',
        overlayColor: 'rgba(0, 0, 0, 0.4)',
        bodyOverflow: false,
    });

    var reference = '' + Math.floor((Math.random() * 1000000000) + 1);
    $('#pay_service_monnify').click((event) => {
      event.preventDefault();

      $.ajax({
        url: '/ajax/pay',
        type: 'POST',
        headers: {
          'X-CSRF-TOKEN': csrfToken,
        },
        data: {
          action: 'insert_payment',
          price: price,
          user_id: user_id,
          reference: reference,
          payment_type: 'monnify',
        },

        success: (data) => {
          if(data.s == 1) {
            var reference = data.r;

            MonnifySDK.initialize({
              amount: price,
              currency: "NGN",
              reference: reference,
              customerFullName: user_fullname,
              customerEmail: user_email,
              apiKey: "MK_TEST_J6GSNYYQ99",
              contractCode: "3199675926",
              isTestMode: true,
              paymentDescription: title,
      
              onComplete: (response) => {
                var ref = response.transactionReference;
                var id = $("#service_id").val();
                var quantity = $("#service_quantity").val();
                var price = $("#service_price").val();
                var user_id = $("#user_id_pay").val();
      
                $.ajax({
                  url : '/ajax/pay',
                  method: "post",
                  data : {
                    action : 'services',
                    id: id,
                    quantity: quantity,
                    reference: ref,
                    detectref: reference,
                    user_id: user_id,
                    payment: 'monnify',
                  },
                  headers: {
                    'X-CSRF-TOKEN': csrfToken 
                },
      
                success: function(data) {
      
                  if(data.s == 1) {
                    Toasting(1, data.m);
                    counter(3, () => {
                      window.location.href = '/user/service-requirement?trans='+data.t;
                    });
                  } else {
                    Toasting(0, data.m);
                  }
                },
                
                error: function(xhr, error) {
                  console.error(xhr.responseText);
                  var errorObject = JSON.parse(xhr.responseText);
                  if (errorObject.message == 'Unauthenticated.') {
                    Toasting(0, 'Pls login or register first');
                  }
                }
      
                });
      
              },
      
              onClose: () => {
                
              },
      
            });

          }
        },

        error: (xhr) => {
          console.error(xhr.responseText);
        }
      });

      

      

      

    });

    $('#pay_service_paystack').click((e) => {
      e.preventDefault();

      const DECIMAL_FEE = 0.0150;
      const FEE_CAP = 2000;
      const FLAT_FEE = 100;

      var application_fees = DECIMAL_FEE * price;

      if(application_fees > FEE_CAP) {
        var final_amount = price + FEE_CAP;
      } else if(application_fees < FEE_CAP) {
        var final_amount = (price / (1 - DECIMAL_FEE)) + 0.01;
      }

      $.ajax({
        url: '/ajax/pay',
        type: 'POST',
        headers: {
          'X-CSRF-TOKEN': csrfToken,
        },
        data: {
          action: 'insert_payment',
          price: price,
          user_id: user_id,
          reference: reference,
          payment_type: 'paystack',
        },

        success: (data) => {
          if(data.s == 1) {
            var reference = data.r;
            var handler = PaystackPop.setup({
              key: 'pk_test_9549d05f0e7cad7b7a15c166da6d4ccf88bfa865',
              userid: user_id,
              email: user_email,
              amount: final_amount * 100,
              firstname: user_fullname,
              ref: reference,
    
              callback: function(response) {

                var id = $("#service_id").val();
                var quantity = $("#service_quantity").val();
                var price = $("#service_price").val();
                var user_id = $("#user_id_pay").val();
                var user_fullname = $("#user_fullname").val();
                var user_email = $("#user_email").val();
                var title = $("#tite_name").val();
                  const res = response.reference;
                  $.ajax({
                      url : '/ajax/pay',
                      method: "post",
                      data : {
                        action : 'services',
                        id: id,
                        quantity: quantity,
                        reference: res,
                        user_id: user_id,
                        payment: 'paystack',
                      },
                      headers: {
                        'X-CSRF-TOKEN': csrfToken 
                    },

                    success: function(data) {
                      overlay.addClass("d-none");

                      if(data.s == 1) {
                        Toasting(1, data.m);
                        counter(3, () => {
                          window.location.href = '/user/service-requirement?trans='+data.t;
                        });
                      } else {
                        Toasting(0, data.m);
                      }
                      console.log(data);
                    },
                    
                    error: function(xhr, error) {
                      overlay.addClass("d-none");
                      var errorObject = JSON.parse(xhr.responseText);
                      if (errorObject.message == 'Unauthenticated.') {
                        Toasting(0, 'Pls login or register first');
                      }
                    }

                    })
              },
    
              onClose: function() {
                Toasting(0, 'Transaction was not completed, window closed.');
              },
          });
          handler.openIframe();
          }
        },

        error: (xhr) => {
          console.error(xhr.responseText);
        }
      });





    });






  });

  var customLogin = document.getElementById('submit-custom-login');

  customLogin.addEventListener('click', (e) => {
    e.preventDefault();
    console.log("YES");
    var email = document.getElementById('custom-login-email');
    var password = document.getElementById('custom-login-password');

    $.ajax({
      url: '/main/mainlogin',
      type: 'POST',
      data : {
        email: email.value,
        password: password.value,
      },
      headers: {
            'X-CSRF-TOKEN': csrfToken 
        },
      success : (data) => {
        console.log(data);
        if(data.s == 1) {
          Toasting(1, data.m);
          counter(3, () => {
            location.reload();
          });
        } else {
          Toasting(0, data.m);
        }
      },

      error: (xhr) => {
        console.error(xhr.responseText);
      }
    })

  } );

  function Toasting(type, message) {

    if(type == 1) {
      Toastify({
        text: message,
        className: "success",
        duration: 2000,
        close: true,
        style: {
          background: "linear-gradient(to right, #7ACA6E 0%, #39AE32 50%, #6FDC6B 100%)",
        },
      }).showToast();
    } else if(type == 0) {
      Toastify({
        text: message,
        className: "warning",
        duration: 2000,
        close: true,
        style: {
            background: "linear-gradient(to right, #CE5937 0%, #A42B0B 50%, #C54313 100%)",
        },
    }).showToast();
    }
  }

  function toHtml(text) {
    var temp = document.createElement('div');
    temp.innerHTML = text;
    return temp.innerText;
}

function counter(duration, work) {
  let count = duration;

  const timer = setInterval(() => {
      count--;

      if (count <= 0) {
          clearInterval(timer);
          work();
      }
  }, 1000); 
}


  });

