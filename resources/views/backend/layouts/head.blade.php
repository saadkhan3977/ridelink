<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Car Rental || DASHBOARD</title>

    <!-- Custom fonts for this template-->
    <link href="{{asset('backend/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('backend/css/sb-admin-2.min.css')}}" rel="stylesheet">
    @stack('styles')
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <style>
        .notification-bell {
    position: relative;
    display: inline-block;
}

.bell-icon {
    font-size: 24px;
    cursor: pointer;
    position: relative;
}

.notification-count {
    background-color: #dc3545;
    color: #fff;
    border-radius: 50%;
    font-size: 12px;
    padding: 2px 6px;
    position: absolute;
    top: -8px;
    right: -8px;
}

.notification-panel {
    width: 300px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    position: absolute;
    right: 0;
    top: 40px;
    display: none;  /* Initially hidden */
    font-size: 14px;
    z-index: 100;
}

.notification-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.notification-header h3 {
    margin: 0;
    font-size: 16px;
}

.clear-all {
    font-size: 12px;
    color: #007bff;
    text-decoration: none;
}

.clear-all:hover {
    text-decoration: underline;
}

.notification-content {
    max-height: 250px;
    overflow-y: auto;
}

.notification-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.notification-item {
    display: flex;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid #f1f1f1;
}

.notification-item:last-child {
    border-bottom: none;
}

.notification-avatar {
    border-radius: 50%;
    margin-right: 10px;
}

.notification-info {
    flex: 1;
}

.notification-details {
    display: flex;
    flex-direction: column;
}

.notification-title {
    font-weight: bold;
}

.notification-text {
    color: #6c757d;
    font-size: 12px;
}

.notification-time {
    font-size: 10px;
    color: #adb5bd;
    margin-right: 10px;
}

.remove-notification {
    font-size: 16px;
    color: #adb5bd;
    text-decoration: none;
    padding-left: 10px;
}

.remove-notification:hover {
    color: #dc3545;
}

.notification-footer {
    text-align: center;
    margin-top: 10px;
}

.view-all {
    color: #007bff;
    font-size: 12px;
    text-decoration: none;
}

.view-all:hover {
    text-decoration: underline;
}
    </style>
</head>
