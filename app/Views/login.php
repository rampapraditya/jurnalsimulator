<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>JURNAL SIMULATOR</title>
        <link rel="stylesheet" href="<?php echo base_url(); ?>/vendors/feather/feather.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/vendors/mdi/css/materialdesignicons.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/vendors/ti-icons/css/themify-icons.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/vendors/typicons/typicons.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/vendors/simple-line-icons/css/simple-line-icons.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/vendors/css/vendor.bundle.base.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/css/vertical-layout-light/style.css">
    </head>

    <body>
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
                <div class="content-wrapper d-flex align-items-center auth px-0" style="background-image: url('<?php echo base_url(); ?>/images/loginback.jpg'); background-repeat: no-repeat; background-size: 100% 100%;">
                    <div class="row w-100 mx-0">
                        <div class="col-lg-4 mx-auto">
                            <div class="auth-form-light text-left py-5 px-4 px-sm-5" style="border-style: solid; border-color: #E8E7ED;">
                                <div class="brand-logo">
                                    <center>
                                        <img src="<?php echo $logo; ?>" alt="logo">
                                    </center>
                                </div>
                                <h4 style="text-align: center;">SISTEM INFORMASI ADMINISTRASI<br>JURNAL OPERASIONAL OPERATOR<br>PUSLATLEKDALSEN</h4>
                                
                                <div class="pt-3">
                                    <form id="form">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-lg" name="nrp" id="nrp" placeholder="NRP" autofocus autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-lg" name="pass" id="pass" placeholder="Password" autocomplete="off">
                                        </div>
                                    </form>
                                    <div class="mt-3">
                                        <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" onclick="login();">SIGN IN</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="<?php echo base_url(); ?>/js/jquery-3.5.1.js"></script>
        <script src="<?php echo base_url(); ?>/vendors/js/vendor.bundle.base.js"></script>
        <script src="<?php echo base_url(); ?>/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
        <script src="<?php echo base_url(); ?>/js/off-canvas.js"></script>
        <script src="<?php echo base_url(); ?>/js/hoverable-collapse.js"></script>
        <script src="<?php echo base_url(); ?>/js/template.js"></script>
        <script src="<?php echo base_url(); ?>/js/settings.js"></script>
        <script src="<?php echo base_url(); ?>/js/todolist.js"></script>
        
        <script type="text/javascript">
            
            $(document).ready(function (){
                $('#nrp').keypress(function (e){
                    var keycode = e.which;
                    if(keycode === 13){
                        $('#pass').focus();
                        $('#pass').select();
                    }
                });
                
                $('#pass').keypress(function (e){
                    var keycode = e.which;
                    if(keycode === 13){
                        login();
                    }
                });
            });
            
            function login() {
                var nrp = document.getElementById('nrp').value;
                var pass = document.getElementById('pass').value;
                if (nrp === '') {
                    alert("NRP tidak boleh kosong");
                } else if (pass === '') {
                    alert("Password tidak boleh kosong");
                } else {
                    $.ajax({
                        url: "<?php echo base_url(); ?>/login/proses",
                        type: "POST",
                        data: $('#form').serialize(),
                        dataType: "JSON",
                        success: function (data) {
                            if (data.status === "ok") {
                                window.location.href = "<?php echo base_url(); ?>/home";
                            } else {
                                alert(data.status);
                            }
                        }, error: function (jqXHR, textStatus, errorThrown) {
                            alert("Error json " + errorThrown);
                        }
                    });
                }
            }

        </script>
    </body>

</html>
