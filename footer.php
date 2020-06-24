<script>
      //This section is for the fancy transition thingy.
      var speed = 'slow';
      $('html, body').hide(); //Hide everything first. Why? Because of the fancy transition stuff...
      $(document).ready(function(){
        //Checking the log session...
        var tester = $(this).checkLog();
        //console.log(tester);
        if(tester == 0){
          window.location.href = "./logout.php"; //Redirect to logout.php, which redirects to login page if session is out.
        }
        // End log session check

        //Begin fancy fade in transition when page loads...
        $('html, body').fadeIn(1500, function() {
        $('a[href], button[href]').click(function(event) {
            var url = $(this).attr('href');
            if (url.indexOf('#') == 0 || url.indexOf('javascript:') == 0) return;
            event.preventDefault();
            $('html, body').fadeOut(speed, function() {
                window.location = url;
            });
          });
        });
        //End fancy transition
      });
</script>
  </body>
</html>