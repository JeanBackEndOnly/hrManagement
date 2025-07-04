$(document).ready(function () {

   if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
      navigator.serviceWorker.register('service-worker.js').then((registration) => {
        console.log('ServiceWorker registration successful with scope: ', registration.scope);
      }, (error) => {
        console.log('ServiceWorker registration failed: ', error);
      });
    });
  }

 $("body").on("submit", "#install-form", function (e) {
  e.preventDefault();
  const $this = $(this);
  const data = new FormData(this); 
  data.append("action", "save_installation_data");

  if (!$this.hasClass("processing")) {
    $this.addClass("processing");

    $.ajax({
      url: base_url + "/auth/ajax.php",
      method: "POST",
      data: data,
      processData: false,
      contentType: false,
      beforeSend: function () {
        $this.find("button").text("Processing...");
      },
      success: function (response) {
        $this.removeClass("processing");
        try {
          const res = typeof response === 'string' ? JSON.parse(response) : response;

          if (res.success) {
            $this.find("button").text("Success!");

            Swal.fire({
              toast: true,
              position: 'top-end',
              icon: 'success',
              title: res.message,
              showConfirmButton: false,
              timer: 5000,
              timerProgressBar: true,
              customClass: {
                popup: 'swal2-row-toast'
              }
            });

            setTimeout(() => {
              window.location.href = base_url + "/src/";
            }, 5000);

          } else {
            $this.find("button").text("Failed to save!");

            Swal.fire({
              toast: true,
              position: 'top-end',
              icon: 'error',
              title: res.message,
              showConfirmButton: false,
              timer: 3000,
              timerProgressBar: true,
              customClass: {
                popup: 'swal2-row-toast'
              }
            });
          }
        } catch (err) {
          console.error("JSON Parse Error", err);
          $this.find("button").text("Try Again!");
        }
      },
      error: function (xhr, status, error) {
        $this.removeClass("processing");
        $this.find("button").text("Please try again!");
        console.error("AJAX Error:", status, error);
        console.error("Response Text:", xhr.responseText);

        Swal.fire({
          toast: true,
          position: 'top-end',
          icon: 'error',
          title: 'Something went wrong. Try again!',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          customClass: {
            popup: 'swal2-row-toast'
          }
        });
      }
    });
  }
});


});
