/**
 * Main
 */

'use strict';

let menu, animate;

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

  TinyMce('editor');

  var select_type_id = $("#select_type");

  if(select_type_id.length > 0) {
    NiceSelect.bind(document.getElementById("select_type"), {searchable:true});
  }
  


  var ajaxURL = "/admin/"+$("#model").data('name')+"/process";
  var overlay = $(".overlay2");

  var dataTable = $("#dataTable");
  var table = $("#model").data('name');
  var csrfToken = $('meta[name="csrf-token"]').attr('content');


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

      buttons: [
          "selectAll",
          "selectNone",
          'csv', 'excel', 'pdf', 'print',
          {
              text: "Delete",
              className: "btn btn-danger waves-effect waves-light",
              action: function () {
                  var selectedRows = Datatable.rows({ selected: true }).data().toArray();
                  var ids = selectedRows.map(row => row[0]);
                  var count = Datatable.rows({ selected: true }).count();
                  if (count > 0) {
                      ActiontoStatus("deleteAll");
                  } else {
                      Swal.fire("Error", "You did not select any item on" + table, "warning");
                  }
              },
          },
      ],

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

  $(document).on("click", ".showDraft", function (e) {
      e.preventDefault();
      $(".showingBy").text(`Draft ${table[0].toUpperCase()+table.slice(1)} `);
      $("#dataTable").attr('data-filter', 'Draft');
      Datatable.ajax.reload();
  });

  $(document).on("click", ".activateAll", function (e) {
      e.preventDefault();
      ActiontoStatus("activateAll");
  });


  $(document).on("click", ".draftAll", function (e) {
      e.preventDefault();
      ActiontoStatus("draftAll");
  });

  $(document).on("click", ".draft", function (e) {
      e.preventDefault();
      var rowId = $(this).data('id');
      ActiontoStatus("draft", rowId);
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
    Request(ajaxURL, formData);
  });


  $(document).on('submit', '#modaddform', function(e) {
    e.preventDefault();

    const formData = new FormData($(this)[0]);
    modRequest(ajaxURL, formData);
  });


  function Request(url, Formdata) {
    overlay.removeClass('d-none');
    $.ajax({
      url: url,
      method: 'post',
      data: Formdata,
      contentType: false, 
      processData: false, 

      success: function(data) {
        overlay.addClass('d-none');
        console.log(data);
        if(data.s == 1) {
          Swal.fire('Success', data.m, 'success').then((result) => {
            location.reload();
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
        console.log(data);
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


    $(document).on('click', ".edit", function(e) {
        e.preventDefault();
        $('#editmodal').modal('show');
        var editor = tinymce.get('desc');

        var rowId = $(this).data('id');
        const form = $(this).closest('form');
        const editModal = $("#editModal");

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
              
                var img = new Image();
                if(table == 'service_cats') {
                    $("#titleedit").val(data.title);
                    $("#rowID").val(data.id);
                  
                    editor.setContent(data.description);
                } else if(table == 'wishlists_types') {
                  $("#titleedit").val(data.title);
                  $("#rowID").val(data.id);
                } else if(table == 'wishlist_items') {
                  console.log(data);
                  $("#titleedit").val(data.name);
                  $("#price").val(data.price);
                  $("#rowID").val(data.id);
                  $("#hiddenimg").val(data.img);
                  $("#hiddenfolder").val(data.img_folder);
                  editor.setContent(data.description || " ");

                  img.src = "/images/"+data.img_folder+data.img;
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


            // Campaigns DETAILS MODAL

            $(document).on('click', '.inv_details', function(e) {
              e.preventDefault();
          
              var type  = $(this).attr('data-type');
              if(type == 2) {
                  $("#invest_modal").modal('show');
          
                  var title = $(this).data('title');
                  var amount = $(this).data('amount');
                  var goal = $(this).data('goal');
                  var shared = $(this).data('share');
                  var created = $(this).data('date');
                  var stop = $(this).data('stop');
                  var description = $(this).data('description');
                  var category = $(this).data('category');
                  var status = $(this).data('status');
                  
                  $("#inv_title").text(title);
                  $("#inv_goal").text(goal);
                  $("#inv_amount").text(amount);
                  $("#inv_shared").text(shared);
                  $("#inv_cre_date").text(created);
                  $("#inv_end_date").text(stop);
                  if(status == 1) {
                      $("#inv_pr_status").text('Pending');
                  } else if(status == 2) {
                      $("#inv_pr_status").text('Active');
                  } else {
                      $("#inv_pr_status").text('Close');
                  }
                  $("#inv_description").html(description);
                  $("#inv_category").text(category);
              } else {
                  // Do something else if type is not 2

                  $("#donate_modal").modal('show');

                  var title = $(this).data('title');
                  var amount = $(this).data('amount');
                  var goal = $(this).data('goal');
                  var created = $(this).data('date');
                  var description = $(this).data('description');
                  var category = $(this).data('category');
                  var status = $(this).data('status');
                  var username = $(this).data('username');

                  $("#don_title").text(title);
                  $("#don_goal").text(goal);
                  $("#don_amount").text(amount);
                  $("#don_category").text(category);
                  $("#don_cre_date").text(created);

                    if(status == 1) {
                      $("#don_pr_status").text('Pending');
                  } else if(status == 2) {
                      $("#don_pr_status").text('Active');
                  } else {
                      $("#don_pr_status").text('Close');
                  }

                  $("#don_p_status").html(description);
                  $("#don_username").text(username);
              }
          });

          // Services Details

          $(document).on('click', '.service_details', function(e) {
            e.preventDefault();

            $("#service_details_modal").modal('show');
            var title = $(this).data('title');
            var price = $(this).data('price');
            var username = $(this).data('username');
            var date = $(this).data('date');
            var delivery = $(this).data('delivery');
            var status = $(this).data('status');
            var cat_title = $(this).data('cat_title');
            var description = $(this).data('description');
            var acquire = $(this).data('acquire');
            var image = $(this).data('image');
            var img = new Image();
            $("#inv_title").text(title);
            $("#inv_goal").text(price);
            $("#inv_amount").text(acquire);
            $("#inv_shared").text(username);
            $("#inv_cre_date").text(date);
            $("#inv_end_date").text(delivery);
            if(status == 1) {
                $("#inv_pr_status").text('Active');
            } else if(status == 0) {
                $("#inv_pr_status").text('Inactive');
            } else {
                $("#inv_pr_status").text('Close');
            }
            $("#inv_description").html(description);
            $("#inv_category").text(cat_title);
            img.src = image;
            img.style.maxWidth = "100%";
            $("#sd_img").empty();
            $("#sd_img").append(img);


          } );

          // SERVICE PROOF
          $(document).on('click', '.admin_proof', function(e) {

            var text = $(this).data('proof');
            console.log(text);
            var img = new Image();
            img.src = $(this).data('image');
            img.style.maxWidth = "100%";
            $("#proof_img").empty();
            $("#proof_img").append(img);
            $("#proof_title").text($(this).data('title'));
            $("#proof_text").text(text);
            
            $("#proof_details").modal('show');
          });

          // SERVICE REQUIREMENT
          $(document).on('click', '.admin_requirement', function(e) {

            var img = new Image();
            img.src = $(this).data('image');
            img.style.maxWidth = "100%";
            $("#require_img").empty();
            $("#require_img").append(img);
            $("#require_title").text($(this).data('title'));
            $("#require_text").text($(this).data('requirement'));
            $("#require_details").modal('show');
          });

          // SERVICE ENROLLED 
          $(document).on('click', '.enroll_service_details', function(e) {

            var img = new Image();
            img.src = $(this).data('image');
            img.style.maxWidth = "100%";

            var status = $(this).data('status');
            $("#se_img").empty();
            $("#se_img").append(img);
            $("#se_title").text($(this).data('title'));
            $("#se_price").text($(this).data('price'));
            $("#se_quantity").text($(this).data('quantity'));
            $("#se_total").text($(this).data('total'));
            $("#se_title").text($(this).data('title'));
            $("#se_user").text($(this).data('username'));
            $("#se_buyer").text($(this).data('buyername'));
            $("#se_transactionid").text($(this).data('transactionid'));
            $("#se_delivery").text($(this).data('delivery'));
            if(status == 1) {
              $("#se_status").text('Completed');
            } else {
              $("#se_status").text('On Progress');
            }
            $("#se_desc").html($(this).data('description'));
            $("#se_date").text($(this).data('date'));
            $("#service_enroll_modal").modal('show');
          });
          


  function ActiontoStatus(type, rowId = '') {
    let title;

    if (type == "activateAll") {
        title = "Activate";
        var selectedRows = Datatable.rows({ selected: true }).data().toArray();
        var ids = selectedRows.map(row => row[0]);
        var count = Datatable.rows({ selected: true }).count();
    } else if(type == 'deleteAll') {
        var selectedRows = Datatable.rows({ selected: true }).data().toArray();
        var ids = selectedRows.map(row => row[0]);
        var count = Datatable.rows({ selected: true }).count();
        title = "Delete";
    } else if (type == "draftAll") {
        title = "Draft";
        var selectedRows = Datatable.rows({ selected: true }).data().toArray();
        var ids = selectedRows.map(row => row[0]);
        var count = Datatable.rows({ selected: true }).count();
    }else if(type == 'draft') {
        var ids = rowId;
        var count = 1;
        title = "Draft";
    } else if(type == 'activate') {
        var ids = rowId;
        var count = 1;
        title = "Activate";
    } else if(type == 'delete') {
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
    console.log('ERROR');
    $.ajax({
      url: Userajax,
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

});
