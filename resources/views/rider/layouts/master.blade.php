<!DOCTYPE html>
<html lang="en">

@include('rider.layouts.head')

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    @include('rider.layouts.sidebar')
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        @include('rider.layouts.header')
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        @yield('main-content')
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
      @include('rider.layouts.footer')
      <script>


//         var pusher = new Pusher('35588b00755613bedb1b', {
//             cluster: 'mt1',
//             encrypted: true
//         });

//         var channel = pusher.subscribe('private-App');
//         channel.bind('ride.created', function(data) {
//           var rideData = data.rideData;
//           console.log('New ride request received:', data);  // Ensure this prints the received data

// // alert(data.rideData);
//             // Create new notification list item
//             var notificationElement = document.createElement('li');
//             notificationElement.classList.add('notification');
//             notificationElement.innerHTML = `
//                   <li class="notification-item today">
//               <span class="notification-time"></span>
//               <div class="notification-info">
//               <div class="notification-details">
//               <span class="notification-title"><a href="/admin/notification/${data.id}">New Ride Request</a></span>
//               <span class="notification-text">${rideData.carinfo.name}</span>
//               </div>
//               </div>
//               </li>
//             `;

//             // Add new notification to the list
//             var notificationsList = document.getElementById('notifications');
//             notificationsList.prepend(notificationElement);
//             console.log('New ride request received:', data);  // Ensure this prints the received data
//             // Display notification data on the dashboard
//         });


function fetchNotifications() {
  $.ajax({
    url: '/admin/notifications',
    method: 'GET',
    success: function(notifications) {
      const notificationList = $('#notifications');
      notificationList.empty();

      // notifications.forEach(notification => {
                    notificationList.append(notifications); // Adjust according to your notification structure
                // });
            },
            error: function(error) {
                console.error('Error fetching notifications:', error);
            }
        });
    }

    function fetchNotificationscount() {
    $.ajax({
    url: '/admin/notifications-count',
    method: 'GET',
    success: function(notifications) {
      const notificationList = $('#notifications-count');
      notificationList.empty();

      // notifications.forEach(notification => {
      if(notifications == 0)
      {
        notificationList.empty(); // Adjust according to your notification structure
      }
      else
      {
        notificationList.append(notifications); // Adjust according to your notification structure
      }
                  // });
                },
            error: function(error) {
                console.error('Error fetching notifications:', error);
            }
        });
    }

    setInterval(fetchNotifications, 1000);
    setInterval(fetchNotificationscount, 1000);

    // Fetch notifications immediately on page load
    fetchNotifications();
    fetchNotificationscount();


    </script>
</body>

</html>
