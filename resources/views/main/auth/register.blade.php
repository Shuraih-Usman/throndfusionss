<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from demo.bootstrapdash.com/lead-ui-kit/demo/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 Mar 2024 23:52:56 GMT -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register | {{APP_NAME}}</title>
    <!-- partial:partials/_head.html -->
    <link rel="stylesheet" href="/main/src/css/lead-ui-kit.css">
    <link rel="stylesheet" href="/main/assets/css/lead-ui-kit-demo.css">
    <link rel="stylesheet" type="text/css" href="/main/src/css/toastify.min.css">
    <link rel="stylesheet" href="/assets/css/nice-select2.css" />
    <!-- partial -->
</head>

<body style="">


    <main class="" style="">
        <div class="container">
            
            <section class="register-section" style="margin-top:30px; margin-bottom:30px;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-card mb-5">
                            <div class="text-center mb-3">
                                <img src="/main/assets/images/logo.svg" alt="logo" class="img-fluid">
                            </div>
                            <p class="small text-gray text-center mb-40px">Let Started by creating your Account</p>
                            <form id="regform" class="row">
                                @csrf
                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="nametForm-1" class="sr-only">Your Name</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Your Name">
                                </div>
                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="nametForm-1" class="sr-only">Username</label>
                                    <input type="text" name="username" id="username" class="form-control" placeholder="Username">
                                </div>

                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="emailForm-1" class="sr-only">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                                </div>

                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="subjectForm-1" class="only">Account Type</label>
                                    <select name="role" id="select_role" class=" wide">
                                        <option value="1"> Normal User </option>
                                        <option value="2"> Creator </option>
                                      </select>
                                </div>
                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="emailForm-1" class="sr-only">Create Password</label>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                                </div>
                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="subjectForm-1" class="sr-only">Confirm Password</label>
                                    <input type="password" name="confirmpassword" id="subjectForm-1" class="form-control" placeholder="Confirm Password">
                                </div>
                               
                                <button type="submit" class="btn btn-block btn-primary">Create Account</button>
                            </form>
                        </div>
                        
                    </div>
                    
                </div>
            </section>
        </div>
    </main>

        <script src="/main/src/vendors/feather-icons/feather.min.js"></script>
        <script src="/main/src/vendors/jquery/jquery.min.js"></script>
        <script src="/main/src/vendors/popper.js/popper.min.js"></script>
        <script src="/main/src/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="/main/src/js/lead-ui-kit.js"></script>
        <script type="text/javascript" src="/main/src/js/toastify-js.js"></script>
        <script src="/assets/js/nice-select2.js"></script>
        <script>
            feather.replace();

            NiceSelect.bind(document.getElementById('select_role'), {searchable:true});

$(document).on('input', '#name', function() {
        const name = $('#name').val();
        const modifiedName = name.toLowerCase().replace(/\s+/g, '');
    $('#username').val(modifiedName);
    });

    $(document).on('submit', '#regform', function(e) {
        e.preventDefault();

        const formData = $(this).serialize();

        $.ajax({
            url: '/main/register',
            method: 'post',
            data : formData,

            success : function(data) {
             if(data.s == 1) {
                Toastify({
  text: data.m,
  className: "success",
  destination: "https://github.com/apvarun/toastify-js",
  newWindow: true,
  duration: 2000,
  close: true,
  style: {
    background: "linear-gradient(to right, #7ACA6E 0%, #39AE32 50%, #6FDC6B 100%)",
  },
  callback: function() {
        window.location.href = "/dashboard";
    }
}).showToast();
             } else {
     Toastify({
    text: data.m,
    className: "warning",
    duration: 2000,
    close: true,
    style: {
        background: "linear-gradient(to right, #CE5937 0%, #A42B0B 50%, #C54313 100%)",
    },
}).showToast();

             }
            },

            error: function(xhr, error) {
                console.log(xhr.responseText || error );
            }
        })
    });

        </script>
        <!-- partial -->
    </body>
    
    </html>