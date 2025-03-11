    <script src="js/main.min.js"></script>
    <script src="js/jquery-stories.js"></script>
    <script src="js/toast-notificatons.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.2/TweenMax.min.js"></script>
    <!-- For timeline slide show -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA8c55_YHLvDHGACkQscgbGLtLRdxBDCfI"></script>
    <!-- for location picker map -->
    <script
      src="https://kit.fontawesome.com/e156841cf0.js"
      crossorigin="anonymous"
    ></script>
    <!--for fontawesome icons  -->
    <script src="js/locationpicker.jquery.js"></script>
    <!-- for loaction picker map -->
    <script src="js/map-init.js"></script>
    <!-- map initilasition -->

    <script src="js/script.js"></script>
    <script>
      jQuery(document).ready(function ($) {
        $("#us3").locationpicker({
          location: {
            latitude: -8.681013,
            longitude: 115.23506410000005,
          },
          radius: 0,
          inputBinding: {
            latitudeInput: $("#us3-lat"),
            longitudeInput: $("#us3-lon"),
            radiusInput: $("#us3-radius"),
            locationNameInput: $("#us3-address"),
          },
          enableAutocomplete: true,
          onchanged: function (currentLocation, radius, isMarkerDropped) {
            // Uncomment line below to show alert on each Location Changed event
            //alert("Location changed. New location (" + currentLocation.latitude + ", " + currentLocation.longitude + ")");
          },
        });

        if ($.isFunction($.fn.toast)) {
          $.toast({
            heading: "Welcome To Socio",
            text: "",
            showHideTransition: "slide",
            icon: "success",
            loaderBg: "#2283ff",
            position: "bottom-right",
            hideAfter: 3000,
          });

          $.toast({
            heading: "Information",
            text: "Now you can full demo of Socio and hope you like",
            showHideTransition: "slide",
            icon: "info",
            hideAfter: 5000,
            loaderBg: "#2283ff",
            position: "bottom-right",
          });
          $.toast({
            heading: "Support & Help",
            text: 'Report any <a href="#">issues</a> by email',
            showHideTransition: "fade",
            icon: "error",
            hideAfter: 7000,
            loaderBg: "#2283ff",
            position: "bottom-right",
          });
        }
      });
    </script>
  </body>
</html>
