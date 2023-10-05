<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    {{-- <link rel="stylesheet" type="text/css" href="{{url('assets/css/style.css')}}"/>  --}}

    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="{{url('assets/bootstrap/css/bootstrap.min.css')}}"/> 
    <link rel="stylesheet" type="text/css" href="{{url('assets/css/bootstrap.min.css')}}"/> 
       <!--STYLESHEET-->
    <!--=================================================-->

    <!--Open Sans Font [ OPTIONAL ]-->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>


    <!--Bootstrap Stylesheet [ REQUIRED ]-->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">


    <!--Nifty Stylesheet [ REQUIRED ]-->
    <link href="{{ asset('assets/css/nifty.min.css') }}" rel="stylesheet">


    <!--Nifty Premium Icon [ DEMONSTRATION ]-->
    <link href="{{ asset('assets/css/demo/nifty-demo-icons.min.css') }}" rel="stylesheet">


    {{-- Menu  --}}
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <!--=================================================-->


    <!--Pace - Page Load Progress Par [OPTIONAL]-->
    <link href="{{ asset('assets/plugins/pace/pace.min.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/plugins/pace/pace.min.js') }}"></script>


    <!--Demo [ DEMONSTRATION ]-->

    {{-- ini aku hapuuus --}}
    <link href="{{ asset('assets/css/demo/nifty-demo.min.css') }}" rel="stylesheet">

    {{-- <link href="{{ asset('assets/plugins/morris-js/morris.min.css') }}" rel="stylesheet"> --}}

    {{-- tambahan --}}

    {{-- bner --}}

    <!--Switchery [ OPTIONAL ]-->
    <link href="{{ asset('assets/plugins/switchery/switchery.min.css') }}" rel="stylesheet">

    <!--Bootstrap Select [ OPTIONAL ]-->
    <link href="{{ asset('assets/plugins/bootstrap-select/bootstrap-select.min.css') }}" rel="stylesheet">


    <!--Bootstrap Tags Input [ OPTIONAL ]-->
    <link href="{{ asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.css') }}" rel="stylesheet">


    <!--Chosen [ OPTIONAL ]-->
    <link href="{{ asset('assets/plugins/chosen/chosen.min.css') }}" rel="stylesheet">


    <!--noUiSlider [ OPTIONAL ]-->
    <link href="{{ asset('assets/plugins/noUiSlider/nouislider.min.css') }}" rel="stylesheet">

    <!--Select2 [ OPTIONAL ]-->
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">


    <!--Bootstrap Timepicker [ OPTIONAL ]-->
    <link href="{{ asset('assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet">


    <!--Bootstrap Datepicker [ OPTIONAL ]-->
    <link href="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet">

    @yield('style')

    @include('layoutsAdmin.header')
    </head>
    <body>
      <div id="container">
        @include('layoutsAdmin.nav')
        <div class="boxed">
          @yield('content')   
          @include('layoutsAdmin.sidebar2')
        
        <footer id="footer">
          @include('layoutsAdmin.footer')
        </footer>
      </div>
      </div>
         <!--JAVASCRIPT-->
    <!--=================================================-->

    <script src="{{ asset('assets/plugins/morris-js/morris.min.js') }}"></script>
  
    <script src="{{ asset('assets/plugins/morris-js/raphael-js/raphael.min.js') }}"></script>
    
  
  
    <!--Morris.js Sample [ SAMPLE ]-->
    <script src="{{ asset('assets/js/demo/morris-js.js') }}"></script>

    <!--jQuery [ REQUIRED ]-->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>


    <!--BootstrapJS [ RECOMMENDED ]-->
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>


    <!--NiftyJS [ RECOMMENDED ]-->
    <script src="{{ asset('assets/js/nifty.min.js') }}"></script>

	<script src="{{url('assets/js/components/bootstrap.js')}}"></script>
    <!--Demo script [ DEMONSTRATION ]-->
    {{-- ini aku komen --}}
    {{-- <script src="{{ asset('assets/js/demo/nifty-demo.min.js') }}"></script> --}}
    
    <!--Flot Chart [ OPTIONAL ]-->
    <script src="{{ asset('assets/plugins/flot-charts/jquery.flot.min.js') }}"></script>
  	<script src="{{ asset('assets/plugins/flot-charts/jquery.flot.resize.min.js') }}"></script>
	  <script src="{{ asset('assets/plugins/flot-charts/jquery.flot.tooltip.min.js') }}"></script>


    <!--Sparkline [ OPTIONAL ]-->
    <script src="{{ asset('assets/plugins/sparkline/jquery.sparkline.min.js') }}"></script>


    <!--Specify page [ SAMPLE ]-->
    <script src="{{ asset('assets/js/demo/dashboard.js') }}"></script>


    {{-- Menu --}}
    <script src="{{ asset('assets/js/menu.js') }}"></script>
  

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>


  

    {{-- tambahan --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!--Demo script [ DEMONSTRATION ]-->
    <script src="{{ asset('assets/js/demo/nifty-demo.min.js') }}"></script>
        
    <!--Switchery [ OPTIONAL ]-->
    <script src="{{ asset('assets/plugins/switchery/switchery.min.js') }}"></script>

    <!--Bootstrap Select [ OPTIONAL ]-->
    <script src="{{ asset('assets/plugins/bootstrap-select/bootstrap-select.min.js') }}"></script>


    <!--Bootstrap Tags Input [ OPTIONAL ]-->
    <script src="{{ asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"></script>


    <!--Chosen [ OPTIONAL ]-->
    <script src="{{ asset('assets/plugins/chosen/chosen.jquery.min.js') }}"></script>

    
    <!--noUiSlider [ OPTIONAL ]-->
    <script src="{{ asset('assets/plugins/noUiSlider/nouislider.min.js') }}"></script>


    <!--Select2 [ OPTIONAL ]-->
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>


    <!--Bootstrap Timepicker [ OPTIONAL ]-->
    <script src="{{ asset('assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.js') }}"></script>

    <!--Bootstrap Datepicker [ OPTIONAL ]-->
    <script src="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>

   

    <script src="{{ asset('assets/js/demo/form-component.js') }}"></script>
    
    {{-- <script>
        $( document ).ready(function() {
    $('#demo-cs-multiselect').chosen({width:'100%'});
});
    </script> --}}

    @yield('script')
      

    <script>
      function validateForm(event) {
          var userName = document.getElementById("user_name").value;
          var userEmail = document.getElementById("user_email").value;
          var userPassword = document.getElementById("user_password").value;
          var userGender = document.getElementById("user_gender").value;
          var userPhoto = document.getElementById("user_photo").value;
          var roleId = document.getElementById("role_id").value;
          var tokenId = document.getElementById("user_token").value;
  
          var isFormValid = true;
  
          if (userName.trim() === "") {
              document.getElementById("usernameError").textContent = "Username tidak boleh kosong!";
              isFormValid = false;
          } else {
              document.getElementById("usernameError").textContent = "";
          }
  
          if (userEmail.trim() === "") {
              document.getElementById("emailError").textContent = "Email tidak boleh kosong!";
              isFormValid = false;
          } else {
              document.getElementById("emailError").textContent = "";
          }
  
          if (userPassword.trim() === "") {
              document.getElementById("passwordError").textContent = "Password tidak boleh kosong!";
              isFormValid = false;
          } else {
              document.getElementById("passwordError").textContent = "";
          }
  
          if (userGender === "") {
              document.getElementById("genderError").textContent = "Silakan pilih gender!";
              isFormValid = false;
          } else {
              document.getElementById("genderError").textContent = "";
          }
      if (userPhoto.trim() === "") {
          document.getElementById("photoError").textContent = "Silakan pilih foto!";
          isFormValid = false;
      } else {
          document.getElementById("photoError").textContent = "";
      }
  
      if (roleId === "") {
          document.getElementById("roleError").textContent = "Silakan pilih role!";
          isFormValid = false;
      } else {
          document.getElementById("roleError").textContent = "";
      }
      if (tokenId === "") {
          document.getElementById("tokenError").textContent = "Token tidak boleh kosong!";
          isFormValid = false;
      } else {
          document.getElementById("tokenError").textContent = "";
      }
  
      if (!isFormValid) {
          event.preventDefault(); // Menghentikan pengiriman form jika ada error
      }
  }
  </script>




{{-- modal --}}
<!-- Letakkan script JavaScript di bagian bawah dokumen HTML -->
<
<script>
    function confirmDelete() {
        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            // If the user clicks "OK" in the confirmation dialog, proceed with the deletion
            // The default link behavior will be triggered, and the delete action will be performed
        } else {
            // If the user clicks "Cancel" in the confirmation dialog, do nothing
            event.preventDefault(); // Prevent the default link behavior
        }
    }
</script>

    <!--=================================================-->
  </body>
</html>