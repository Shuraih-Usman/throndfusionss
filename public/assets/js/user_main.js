(function () {
    // Initialize menu
    //-----------------
  
    let layoutMenuEl = document.querySelectorAll('#layout-menu');
    layoutMenuEl.forEach(function (element) {
      menu = new Menu(element, {
        orientation: 'vertical',
        closeChildren: false
      });
      // Change parameter to true if you want scroll animation
      window.Helpers.scrollToActive((animate = false));
      window.Helpers.mainMenu = menu;
    });
  
    // Initialize menu togglers and bind click on each
    let menuToggler = document.querySelectorAll('.layout-menu-toggle');
    menuToggler.forEach(item => {
      item.addEventListener('click', event => {
        event.preventDefault();
        window.Helpers.toggleCollapsed();
      });
    });
  
    // Display menu toggle (layout-menu-toggle) on hover with delay
    let delay = function (elem, callback) {
      let timeout = null;
      elem.onmouseenter = function () {
        // Set timeout to be a timer which will invoke callback after 300ms (not for small screen)
        if (!Helpers.isSmallScreen()) {
          timeout = setTimeout(callback, 300);
        } else {
          timeout = setTimeout(callback, 0);
        }
      };
  
      elem.onmouseleave = function () {
        // Clear any timers set to timeout
        document.querySelector('.layout-menu-toggle').classList.remove('d-block');
        clearTimeout(timeout);
      };
    };
    if (document.getElementById('layout-menu')) {
      delay(document.getElementById('layout-menu'), function () {
        // not for small screen
        if (!Helpers.isSmallScreen()) {
          document.querySelector('.layout-menu-toggle').classList.add('d-block');
        }
      });
    }
  
    // Display in main menu when menu scrolls
    let menuInnerContainer = document.getElementsByClassName('menu-inner'),
      menuInnerShadow = document.getElementsByClassName('menu-inner-shadow')[0];
    if (menuInnerContainer.length > 0 && menuInnerShadow) {
      menuInnerContainer[0].addEventListener('ps-scroll-y', function () {
        if (this.querySelector('.ps__thumb-y').offsetTop) {
          menuInnerShadow.style.display = 'block';
        } else {
          menuInnerShadow.style.display = 'none';
        }
      });
    }
  
    // Init helpers & misc
    // --------------------
  
    // Init BS Tooltip
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl);
    });
  
    // Accordion active class
    const accordionActiveFunction = function (e) {
      if (e.type == 'show.bs.collapse' || e.type == 'show.bs.collapse') {
        e.target.closest('.accordion-item').classList.add('active');
      } else {
        e.target.closest('.accordion-item').classList.remove('active');
      }
    };
  
    const accordionTriggerList = [].slice.call(document.querySelectorAll('.accordion'));
    const accordionList = accordionTriggerList.map(function (accordionTriggerEl) {
      accordionTriggerEl.addEventListener('show.bs.collapse', accordionActiveFunction);
      accordionTriggerEl.addEventListener('hide.bs.collapse', accordionActiveFunction);
    });
  
    // Auto update layout based on screen size
    window.Helpers.setAutoUpdate(true);
  
    // Toggle Password Visibility
    window.Helpers.initPasswordToggle();
  
    // Speech To Text
    window.Helpers.initSpeechToText();
  
    // Manage menu expanded/collapsed with templateCustomizer & local storage
    //------------------------------------------------------------------
  
    // If current layout is horizontal OR current window screen is small (overlay menu) than return from here
    if (window.Helpers.isSmallScreen()) {
      return;
    }
  
    // If current layout is vertical and current window screen is > small
  
    // Auto update menu collapsed/expanded based on the themeConfig
    window.Helpers.setCollapsed(true, false);
  })();





  $(document).ready(function() {

    const Paystack_KEY = "pk_test_9549d05f0e7cad7b7a15c166da6d4ccf88bfa865";
    const MONNIFY_API_KEY = "MK_TEST_J6GSNYYQ99";
    const MONNIFY_CONTRACT_CODE = "3199675926";

  

    TinyMce('editor');

    tinymce.init({
        selector: '#edit', 
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
      });
  
    var select_type_id = $("#select_type");
  
    if(select_type_id.length > 0) {
      NiceSelect.bind(document.getElementById("select_type"), {searchable:true});
    }



    $(document).on('submit', '#service_requirement', function(e) {
      e.preventDefault();
  
      const formData = new FormData($(this)[0]);
      Request(ajaxURL, formData, 'service_requirement');
    });
  
    
  
  
    var ajaxURL = "/user/"+$("#model").data('name')+"/ajax";
    var overlay = $(".overlay2");
  
    var dataTable = $("#dataTable");
    var table = $("#model").data('name');
    var csrfToken = $('meta[name="csrf-token"]').attr('content');


    var user_messages = $('#users_message');

    if (user_messages.length > 0) {

      $.ajax({
        url: ajaxURL,
        type: 'POST',
        headers: {
          'X-CSRF-TOKEN': csrfToken 
      },
        data: {
          action: 'list',
        },

        success: (data) => {
          user_messages.html(data);
        },

        error: (xhr,error) => {
          console.error(xhr.responseText);
          console.error(error);
        }
      });
    }

    var real_message = $('#real_message');

    if (real_message.length > 0) {

      $.ajax({
        url: ajaxURL,
        type: 'POST',
        headers: {
          'X-CSRF-TOKEN': csrfToken 
      },
        data: {
          action: 'real_message',
        },

        success: (data) => {
          real_message.html(data);
        },

        error: (xhr,error) => {
          console.error(xhr.responseText);
          console.error(error);
        }
      });
    }


    // Messages by clicking conversations

    $(document).on('click', '.user_message_conversation', function(e) {
      e.preventDefault();
      var conversation_id =  $(this).data('id');


      $.ajax({
        url: ajaxURL,
        type: 'POST',
        data: {
          action: 'get_messages',
          conversation_id: conversation_id,
        },
        headers : {
          'X-CSRF-TOKEN': csrfToken
        },

        success: (data) => {
          real_message.html(data);
        },

        error: (xhr) => {
          console.error(xhr.responseText);
        }
      })
      
    });
    
    
    var selectButtons = table == 'wallets' ? [] : [
      "selectAll",
      "selectNone",];

    var Datatable = dataTable.DataTable({
        "processing": true,
        "serverSide": true,
        "stateSave": true,
        "ajax": {
            "url": ajaxURL,
            "type": "POST",
            "headers": {
              'X-CSRF-TOKEN': csrfToken 
          },
            "data": function (d) {
                d.order = [{ column: d.order[0].column, dir: d.order[0].dir }];
                d.action = "list";
                d.table = table;
                d.filterdata = $("#dataTable").attr('data-filter');
            },
  
            "error": function(xhr, error) {
              console.log(xhr.responseText || error);
          }
        },
        "columns": null,
        "order": [[0, 'desc']],
  
        "initComplete": function (settings, json) {
            if (json.columns) {
                this.api().columns().header().to$().each(function (column, idx) {
                    $(column).text(json.columns[idx]);
                });
            }
        },
        responsive: true,
        dom: "Bflrtip",
        select: {
            style: "os",
            selector: "td:nth-child(2)",
        },


  
        buttons: selectButtons,
  
        createdRow: function (row, data, dataIndex) {
            var selectedRows = Datatable.rows({ selected: true }).data().toArray();
            var ids = selectedRows.map(row => row[0]);
            var count = Datatable.rows({ selected: true }).count();
            if (count > 0) {
                $('td', row).css({'color': 'white', 'background-color': ''});
            } else {
                $('td', row).css({'color': 'black', 'background-color': ''});
  
            }
        },
  
    });

    $(document).on('change', '#select_type', function() {
        var selected = $(this).val();

        if(selected === "2") {
            $('#sharedAmount').show();
            $('#stopDate').show();
            $('#stop_date').prop('disabled', false);
            $('#shared').prop('disabled', false);
        } else {
            $('#sharedAmount').hide();
            $('#stopDate').hide();
            $('#stop_date').prop('disabled', true);
            $('#shared').prop('disabled', true);
        }
    });


    $(document).on('click', '.view', function(e) {
      e.preventDefault();

      var view = $(this);
      $("#viewSModal").modal('show');

      if(table == 'services') {
        $("#view_image").empty();
        $("#view_name").text(view.data('name'));
        $("#view_cat").text(view.data('cat'));
        $("#view_price").text(view.data('price'));
        $("#view_delivery").text(view.data('delivery') + " Days");
        $("#view_desc").html(view.data('desc'));
        var img = new Image();
        img.src = "/images/"+view.data('folder') + view.data('image');
        img.style.maxWidth = '100%';
        $("#view_image").append(img);
      }
      

    });
  


  
    $(document).on("click", ".showAll", function (e) {
        e.preventDefault();
        $(".showingBy").text(`All ${table[0].toUpperCase()+table.slice(1)}`);
        $("#dataTable").attr('data-filter', 'ALL');
        Datatable.ajax.reload();
    });
  
    $(document).on("click", ".showActive", function (e) {
        e.preventDefault();
        $(".showingBy").text(`Active ${table[0].toUpperCase()+table.slice(1)} `);
        $("#dataTable").attr('data-filter', 'Actived');
        Datatable.ajax.reload();
    });

    $(document).on("click", ".showPending", function (e) {
        e.preventDefault();
        $(".showingBy").text(`Pending ${table[0].toUpperCase()+table.slice(1)} `);
        $("#dataTable").attr('data-filter', 'Pending');
        Datatable.ajax.reload();
    });
  
    $(document).on("click", ".showClosed", function (e) {
        e.preventDefault();
        $(".showingBy").text(`Closed ${table[0].toUpperCase()+table.slice(1)} `);
        $("#dataTable").attr('data-filter', 'Closed');
        Datatable.ajax.reload();
    });
  
    $(document).on("click", ".activateAll", function (e) {
        e.preventDefault();
        ActiontoStatus("activateAll");
    });
  
  
    $(document).on("click", ".draftAll", function (e) {
        e.preventDefault();
        ActiontoStatus("closeAll");
    });
  
    $(document).on("click", ".draft", function (e) {
        e.preventDefault();
        var rowId = $(this).data('id');
        ActiontoStatus("close", rowId);
    });
  
    $(document).on("click", ".activate", function (e) {
        e.preventDefault();
        var rowId = $(this).data('id');
        ActiontoStatus("activate", rowId);
    });
  
    $(document).on("click", ".delete", function (e) {
        e.preventDefault();
        var rowId = $(this).data('id');
        ActiontoStatus("delete", rowId);
    });
  
    $(document).on('submit', '#addform', function(e) {
      e.preventDefault();
  
      const formData = new FormData($(this)[0]);
      Request(ajaxURL, formData, 'addform');
    });

    $(document).on('click', '#conver_message', function(e) {
      e.preventDefault();

      console.log("YEDHDH");
      var user_id = $("#messages_user_id").val();
      var conversation_id = $("#messages_conversation_id").val();
      var message = $("#textarea_message").val();


      $.ajax({
        url: ajaxURL,
        type: 'POST',
        data: {
          user_id: user_id,
          conversation_id: conversation_id,
          message: message,
          action: 'add',
        },
        headers : {
          'X-CSRF-TOKEN': csrfToken
        },

        success: (data) => {

          if(data.s == 1) {
            real_message.html(data.m);
          } else {
            Swal.fire('Warning', data.m, 'warning');
          }

        },

        error: (xhr) => {
          console.error(xhr.responseText);
        }
      });
    
    
    });

    $(document).on('click', '#toggleNav', () => {
      var navContainer = document.getElementById("navContainer");
        if (navContainer.classList.contains("d-none")) {
            navContainer.classList.remove("d-none");
        } else {
            navContainer.classList.add("d-none");
        }
    });


  
    $(document).on('submit', '#modaddform', function(e) {
      e.preventDefault();
  
      const formData = new FormData($(this)[0]);
      modRequest(ajaxURL, formData);
    });

    var editor = tinymce.get('edit');

    $(document).on('click', ".edit", function(e) {
        e.preventDefault();
        $('#editmodal').modal('show');
        
        var rowId = $(this).data('id');
        const form = $(this).closest('form');
        const editModal = $("#editModal");
        $("#edit-wish-cats").empty();

        $.ajax({
            url: ajaxURL,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken 
            },
            data: {
                action: "getRow",
                id: rowId
            },
            success: function (data) {
                if(table == 'campaigns') {
                    $("#title").val(data.title);
                    $("#goal").val(data.goal_amount);
                    $("#rowID").val(data.id);
                    if(data.type == 1) {
                        $("#project_type").val('Donation');
                    } else {
                        $("#project_type").val('Investing');
                        $('#sharedAmountEdit').show();
                        $('#stopDateEdit').show();
                        $('#stop_date_edit').val(data.invest_stop_date);
                        $('#edit-shared').val(data.shared_amount);
                    }
                    editor.setContent(data.description);
                    initSelect2('select_project2', 'campaign_type', data.type);
                } else if(table == 'services') {
                  var img = new Image();
                  $("#title").val(data.title);
                  $("#price_edit").val(data.price);
                  $("#delivery_edit").val(data.delivery_day);
                  $("#imghidden").val(data.image);
                  $("#folderhidden").val(data.img_folder);
                  $("#rowID").val(data.id);
                  ;
                  editor.setContent(data.description);
                    initSelect2('service_cat_edit', 'service_cats', data.type);

                  img.src = "/images/"+data.img_folder+data.image;
                  img.style.maxWidth = "50%";
                  $("#img_preview").empty();
                  $("#img_preview").append(img);

                } else if(table == 'wishes') {
                  var img = new Image();
                  $("#title").val(data.title);
                  $("#phone").val(data.phone);
                  $("#address").val(data.address);
                  $("#imghidden").val(data.image);
                  $("#folderhidden").val(data.img_folder);
                  $("#rowID").val(data.id);
                  
                  editor.setContent(data.description);
                    initSelect2('edit-wish-cats', 'wishlists_types', data.wish_cat);

                  img.src = "/images/"+data.img_folder+data.image;
                  img.style.maxWidth = "50%";
                  $("#img_preview").empty();
                  $("#img_preview").append(img);
                  
                }

            },

            error: function (error, status) {
                console.log(xhr.responseText || error);
            }
        })
    });
  
  
    function Request(url, Formdata, id=null) {
      overlay.removeClass('d-none');
      $.ajax({
        url: url,
        method: 'post',
        data: Formdata,
        contentType: false, 
        processData: false, 
  
        success: function(data) {
          overlay.addClass('d-none');
          if(data.s == 1) {
            Swal.fire('Success', data.m, 'success').then((result) => {
              Datatable.draw(false);
              document.getElementById(id).reset();

            });
          }   else {
            Swal.fire('Warning', data.m, 'warning');
          }
        },
  
        error: function(xhr, error, status) {
          overlay.addClass('d-none');
          console.log(xhr.responseText || error);
        }
      });
    }
  
    function modRequest(url, Formdata) {
      overlay.removeClass('d-none');
      $.ajax({
        url: url,
        method: 'post',
        data: Formdata,
        contentType: false, 
        processData: false, 
  
        success: function(data) {
          overlay.addClass('d-none');
          if(data.s == 1) {
            Swal.fire('Success', data.m, 'success').then((result) => {
              Datatable.draw(false);
            });
          }   else {
            Swal.fire('Warning', data.m, 'warning');
  
          }
        },
  
        error: function(xhr, error, status) {
          overlay.addClass('d-none');
          console.log(xhr.responseText || error);
        }
      });
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
  
  
    function ActiontoStatus(type, rowId = '') {
      let title;
  
      if (type == "activateAll") {
          title = "Activate";
          var selectedRows = Datatable.rows({ selected: true }).data().toArray();
          var ids = selectedRows.map(row => row[0]);
          var count = Datatable.rows({ selected: true }).count();
      } else if (type == "showAll") {
          title = "Close";
          var selectedRows = Datatable.rows({ selected: true }).data().toArray();
          var ids = selectedRows.map(row => row[0]);
          var count = Datatable.rows({ selected: true }).count();
      }else if(type == 'close') {
          var ids = rowId;
          var count = 1;
          title = "Close";
      } else if(type == 'activate') {
          var ids = rowId;
          var count = 1;
          title = "Activate";
      }  else if(type == 'delete') {
        var ids = rowId;
        var count = 1;
        title = "Delete";
    }
  
      if (count == 0) {
          Swal.fire("Error", "You Have no Item Selected for " + title, "warning");
          return false;
      }
  
      Swal.fire({
        title: "Are you sure to " + title + " Total: " + count + " Items?",
        icon: "warning",
        showCancelButton: true,
        buttonsStyling: false, // Prevents default button styling
        customClass: {
            confirmButton: "btn btn-danger m-1",
            cancelButton: "btn btn-warning m-1",
        },
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        allowOutsideClick: false,
        allowEscapeKey: false,
        showLoaderOnConfirm: true,
        preConfirm: function () {
            return new Promise(function (resolve) {
                $.ajax({
                    type: "post",
                    url: ajaxURL,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        ids: ids,
                        type: type,
                        action: 'settingStatus',
                    },
                    success: function (datas) {
                        if (datas.s === 1) {
                            resolve(datas); // Resolve the promise if successful
                        } else {
                            Swal.fire("Warning", datas.m, "warning");
                        }
                    },
                    error: function (xhr, status, error) {
                        // Handle error if needed
                    }
                });
            });
        }
    }).then(function (result) {
        if (result.value) {
            Datatable.draw(false);
            Swal.fire("Successfully", result.value.m, "success");
        } else {
            Swal.fire.close();
        }
    });
    
  
  
  }
  
  
  ajaxSelect('select_project', 'get_campaign_types');
  ajaxSelect('cats_services', 'services_cats');
  ajaxSelect('wish_cats', 'wishlists_types');
  
  
  function TinyMce(cl) {
    tinymce.init({
      selector: '.'+cl,
      plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount linkchecker markdown',
      toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    });
  }
  
  
  
  
  
  
  
  $("#select_role").select2();
  $("#select_gender").select2();
  
  
  function ajaxSelect(id, action, itemID = null) {
    
    if($('#'+id).length > 0) {
      $.ajax({
        url: ajaxURL,
        type: 'post',
        headers: {
          'X-CSRF-TOKEN': csrfToken
      },
        data: {
          action: action,
          id: itemID,
        },
        success: function(data) {
          $('#'+id).empty();
      
          $.each(data, function(index, item) {
            $('#'+id).append('<option value="' + item.id + '">' + item.title + '</option>');
        });
      
        NiceSelect.bind(document.getElementById(id), {searchable:true});
      
        },
        error: function(error, xhr) {
          console.log(xhr.responseText || error);
        }
      });
    }
    
  }


  function initSelect2(id, type, pid ='') {
    
    var selectID = $("#"+id);
    let ids = '';
    var isID = pid.length > 0;
    if(isID) {
      ids = pid;
    }
    


    if(selectID) {
        $('#'+id).empty();
        $.ajax({
            type: 'POST',
            url: ajaxURL,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
              action : 'getselect',
              type: type,
              id: ids,
            },
            success: function(html){
              $('#'+id).empty();
                $('#'+id).append(html);
               var instance =  NiceSelect.bind(document.getElementById(id), {searchable:true});

                
            },
            error: function (xhr, status, error) {
              console.log(xhr.responseText || error);
          }
        }); 
    }
}



// INVESTMENT LISTS
var investment_table = $("#investment_table").DataTable({
  "processing": true,
  "serverSide": true,
  "stateSave": true,
  "ajax": {
      "url": ajaxURL,
      "type": "POST",
      "headers": {
        'X-CSRF-TOKEN': csrfToken 
    },
      "data": function (d) {
          d.order = [{ column: d.order[0].column, dir: d.order[0].dir }];
          d.action = "investment_list";
          d.table = table;
          d.filterdata = $("#investment_table").attr('data-filter');
      },

      "error": function(xhr, error) {
        console.log(xhr.responseText || error);
    }
  },
  "columns": null,
  "order": [[0, 'desc']],

  "initComplete": function (settings, json) {
      if (json.columns) {
          this.api().columns().header().to$().each(function (column, idx) {
              $(column).text(json.columns[idx]);
          });
      }

        // INVESTMENT DETAILS MODAL

        var invest_links = document.querySelectorAll('.inv_details');
        invest_links.forEach(function(links) {
    
            links.addEventListener('click', function() {
              
              $("#invest_modal").modal('show');
    
              var title = this.getAttribute('data-title');
              var amount = this.getAttribute('data-amount');
              var goal = this.getAttribute('data-goal');
              var shared = this.getAttribute('data-share');
              var created = this.getAttribute('data-cre_date');
              var stop = this.getAttribute('data-stop');
              var payment_s = this.getAttribute('data-p_status');
              var project_s = this.getAttribute('data-c_status');
    
    
              $("#inv_title").text(title);
              $("#inv_goal").text(goal);
              $("#inv_amount").text(amount);
              $("#inv_shared").text(shared);
              $("#inv_cre_date").text(created);
              $("#inv_end_date").text(stop);
              if(project_s == 1) {
              $("#inv_pr_status").text('Pending');
              } else if(project_s == 2) {
              $("#inv_pr_status").text('Active');
              } else {
                $("#inv_pr_status").text('Close');
              }
              
              if(payment_s == 1) {
                $("#inv_p_status").text('Active');
              } else if(payment_s == 2) {
                $("#inv_p_status").text('Pending');
              } else {
                $("#inv_p_status").text('Closed');
              }
           });
    
        });


        
    
    
  },
  responsive: true,
});

// DONATION TABLE LISTS
var donation_table = $("#donation_table").DataTable({
  "processing": true,
  "serverSide": true,
  "stateSave": true,
  "ajax": {
      "url": ajaxURL,
      "type": "POST",
      "headers": {
        'X-CSRF-TOKEN': csrfToken 
    },
      "data": function (d) {
          d.order = [{ column: d.order[0].column, dir: d.order[0].dir }];
          d.action = "donation_list";
          d.table = table;
          d.filterdata = $("#donation_table").attr('data-filter');
      },

      "error": function(xhr, error) {
        console.log(xhr.responseText || error);
    }
  },
  "columns": null,
  "order": [[0, 'desc']],

  "initComplete": function (settings, json) {
      if (json.columns) {
          this.api().columns().header().to$().each(function (column, idx) {
              $(column).text(json.columns[idx]);
          });
      }

        // DONATION DETAILS MODAL

        var invest_links = document.querySelectorAll('.don_details');
        invest_links.forEach(function(links) {
    
            links.addEventListener('click', function() {
              
              $("#donate_modal").modal('show');
    
              var title = this.getAttribute('data-title');
              var amount = this.getAttribute('data-amount');
              var goal = this.getAttribute('data-goal');
              var created = this.getAttribute('data-cre_date');
              var payment_s = this.getAttribute('data-p_status');
              var project_s = this.getAttribute('data-c_status');
    
    
              $("#don_title").text(title);
              $("#don_goal").text(goal);
              $("#don_amount").text(amount);
              $("#don_cre_date").text(created);
              if(project_s == 1) {
              $("#don_pr_status").text('Pending');
              } else if(project_s == 2) {
              $("#don_pr_status").text('Active');
              } else {
                $("#don_pr_status").text('Close');
              }
              
              if(payment_s == 1) {
                $("#don_p_status").text('Active');
              } else if(payment_s == 2) {
                $("#don_p_status").text('Pending');
              } else {
                $("#don_p_status").text('Closed');
              }
           });
    
        });


        
    
    
  },
  responsive: true,
});

  // ONWORK SERVICES TABLE LISTS
var onwork_services = $("#onwork_services").DataTable({
  "processing": true,
  "serverSide": true,
  "stateSave": true,
  "ajax": {
      "url": ajaxURL,
      "type": "POST",
      "headers": {
        'X-CSRF-TOKEN': csrfToken 
    },
      "data": function (d) {
          d.order = [{ column: d.order[0].column, dir: d.order[0].dir }];
          d.action = "onwork_service_lists";
          d.table = table;
          d.filterdata = $("#onwork_services").attr('data-filter');
      },

      "error": function(xhr, error) {
        console.log(xhr.responseText || error);
    }
  },
  "columns": null,
  "order": [[0, 'desc']],

  "initComplete": function (settings, json) {
      if (json.columns) {
          this.api().columns().header().to$().each(function (column, idx) {
              $(column).text(json.columns[idx]);
          });
      }

        // INVESTMENT DETAILS MODAL

        var invest_links = document.querySelectorAll('.service_details');

        invest_links.forEach(function(links) {
    
            links.addEventListener('click', function() {
              
              $("#service_details_modal").modal('show');
    
              var title = this.getAttribute('data-title');
              var amount = this.getAttribute('data-amount');
              var quantity = this.getAttribute('data-quantity');
              var service_id = this.getAttribute('data-service_id');
              var deliver_day = this.getAttribute('data-delivery_date');
              var created = this.getAttribute('data-date');
              var status = this.getAttribute('data-status');
              var remain = this.getAttribute('data-remain');
              var buyers = this.getAttribute('data-buyer');
              var enroll_id = $("#enroll_id");
              var input_id = this.getAttribute('data-id');
              enroll_id.val(input_id);
    
    
              $("#don_title").text(title);
              $("#don_goal").text(amount);
              $("#don_amount").text(quantity);
              $("#don_cre_date").text(created);
              $("#don_pr_status").text(deliver_day + ' days');
              $("#don_p_status").text(remain + ' days');
              $("#serv_buyer").text(buyers);

              

           });
    
        });


        
    
    
  },
  responsive: true,
});


  // PURCHASES SERVICES TABLE LISTS
  var purchase_services = $("#purchase_services").DataTable({
    "processing": true,
    "serverSide": true,
    "stateSave": true,
    "ajax": {
        "url": ajaxURL,
        "type": "POST",
        "headers": {
          'X-CSRF-TOKEN': csrfToken 
      },
        "data": function (d) {
            d.order = [{ column: d.order[0].column, dir: d.order[0].dir }];
            d.action = "purchase_services";
            d.table = table;
            d.filterdata = $("#purchase_services").attr('data-filter');
        },
  
        "error": function(xhr, error) {
          console.log(xhr.responseText || error);
      }
    },
    "columns": null,
    "order": [[0, 'desc']],
  
    "initComplete": function (settings, json) {
        if (json.columns) {
            this.api().columns().header().to$().each(function (column, idx) {
                $(column).text(json.columns[idx]);
            });
        }
  
          // INVESTMENT DETAILS MODAL
  
          var invest_links = document.querySelectorAll('.service_details');
  
          invest_links.forEach(function(links) {
      
              links.addEventListener('click', function() {
                
                $("#service_proof_modal").modal('show');
      
                var title = this.getAttribute('data-title');
                var service_id = this.getAttribute('data-service_id');
                var deliver_day = this.getAttribute('data-delivery_date');
                var created = this.getAttribute('data-date');
                var status = this.getAttribute('data-status');
                var enroll_id = $("#enroll_id_2");
                var input_id = this.getAttribute('data-id');
                enroll_id.val(input_id);
                var imageLink = this.getAttribute('data-image');
                var proof = this.getAttribute('data-proof');
                
      
      
                $("#don_title").text(title);
                $("#img_preview_service").html('<a href="'+imageLink+'" class="btn btn-primary"> View Image </a>');
                $("#prf_service").text(proof);

  
                
  
             });
      
          });
  
  
          
      
      
    },
    responsive: true,
  });

  
  // Adding funds to user account
  $('#user_add_funds').click(() => {



    Swal.fire({
      title: "Enter the amount you are funding",
      input: "text",
      inputLabel: "Please enter the amount you are funding in Naira",
      showCancelButton: true,
      inputValidator: (value) => {
        if (!value) {
          return "Please enter the amount";
        }
      }
    }).then((amss)=> {


      if(amss.isConfirmed) {
        Swal.fire({
          title: "Payment Type",
          input: "select",
          showCancelButton: true,
          inputOptions: {
            paystack: "Paystack",
            monnify: "Monnify",
            manual: "Manual"
          },
          inputPlaceholder: "Select Payment type"
        }).then((result) => {
          const val = result.value; // Fixed: used result.value instead of val
          const price = parseFloat(amss.value);
          const user_id = $("#user_id").val();
          const user_email = $("#user_email").val();
          const username = $("#fullname").val();
          const reference = Math.floor(Math.random() * 1000000000) + 1;
          
          if(result.isConfirmed) {
            if (val === "paystack") {
              const DECIMAL_FEE = 0.015;
              const FEE_CAP = 2000;
              const FLAT_FEE = 100;
    
              let final_amount = price + FLAT_FEE;
              const application_fees = DECIMAL_FEE * price;
    
              if (application_fees > FEE_CAP) {
                final_amount = price + FEE_CAP;
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
                  if (data.s == 1) {
                    const reference = data.r;
                    const handler = PaystackPop.setup({
                      key: Paystack_KEY,
                      userid: user_id,
                      email: user_email,
                      amount: final_amount * 100,
                      firstname: username,
                      ref: reference,
                      callback: function (response) {
                        const res = response.reference;
                        $.ajax({
                          url: '/ajax/pay',
                          method: "post",
                          data: {
                            action: 'addwallets',
                            reference: res,
                            user_id: user_id,
                            amount: price,
                            payment: 'paystack',
                          },
                          headers: {
                            'X-CSRF-TOKEN': csrfToken
                          },
                          success: function (data) {
                            if (data.s == 1) {
                              Toasting(1, data.m);
                              counter(3, () => {
                                location.reload();
                              });
                            } else {
                              Toasting(0, data.m);
                            }
                          },
                          error: function (xhr, error) {
                            var errorObject = JSON.parse(xhr.responseText);
                            if (errorObject.message == 'Unauthenticated.') {
                              Toasting(0, 'Please login or register first');
                            }
                          }
                        });
                      },
                      onClose: function () {
                        Toasting(0, 'Transaction was not completed, window closed.');
                      },
                    });
                    handler.openIframe();
                  } else {
                    Toasting(0, data.m);
                  }
                },
                error: (xhr) => {
                  console.error(xhr.responseText);
                }
              });
            } else if (val === "monnify") { 
              
              // Fixed: lowercase 'monnify'
              // Handle Monnify payment here


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
                        customerFullName: username,
                        customerEmail: user_email,
                        apiKey: MONNIFY_API_KEY,
                        contractCode: MONNIFY_CONTRACT_CODE,
                        isTestMode: true,
                        paymentDescription: "Adding funds to wallet",
                
                        onComplete: (response) => {
                          var ref = response.transactionReference;
                          
                
                          $.ajax({
                            url : '/ajax/pay',
                            method: "post",
                            data : {
                              action : 'addwallets',
                              reference: ref,
                              detectref: reference,
                              user_id: user_id,
                              payment: 'monnify',
                              amount: price,
                            },
                            headers: {
                              'X-CSRF-TOKEN': csrfToken 
                          },
                
                          success: function(data) {
                
                            if(data.s == 1) {
                              Toasting(1, data.m);
                              counter(3, () => {
                                location.reload();
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

            } else {
    
              Swal.fire(`You selected: ${val} and the ddddamount is ${price} and id is ${user_id}`);
    
            }
          }
  
        });
      }

    });
    
    
    
  });

  // user withdrawal

  $("#user_withdraw").click(() => {

    Swal.fire({
      title: "Amount",
      input: "text",
      inputLabel: "Please enter the amount you are withrawing in Naira",
      showCancelButton: true,
      inputValidator: (value) => {
        if (!value) {
          return "Please enter the amount";
        }
      }
    }).then((amount) => {

     

      if(amount.isConfirmed) {
        const reference = Math.floor(Math.random() * Date.now());
        const user_id = $("#user_id").val();
        const amt = amount.value;

        $.ajax({
          url: "/ajax/pay",
          type: "POST",
          data: {
            action: "user_withdraw",
            amount: amt,
            reference: reference,
            user_id: user_id,
          },
          headers: {
            'X-CSRF-TOKEN': csrfToken,
          },

          success: (data) => {
            Result(data);
            Datatable.draw(false);
          },

          error: (xhr) => {
            console.error(xhr.responseText);
          }
        });

      }

    });


  });







  
  });


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

  function Result(data) {
    if(data.s == 1) {
     return Toasting(1, data.m);
    } else {
     return Toasting(0, data.m);
    }
  }