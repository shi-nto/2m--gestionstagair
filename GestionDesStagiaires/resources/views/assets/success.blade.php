<style>
    .notification-card {
        position: fixed;
        top: 105px;
        left: 55%;
        transform: translate(-50%, -50%);
        z-index: 1000;
        display: none;
        width: 300px;
        padding: 20px;
    }
</style>
@if (session('success'))
<div class="notification-card bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert" id="success-message">
    <strong class="font-bold">Success!</strong>
    <span class="block sm:inline">{{ session('success') }}</span>
    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
        <svg class="fill-current h-6 w-6 text-green-500" role="button" onclick="closeNotification('success-message')" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 5.652a1 1 0 00-1.414 0L10 8.586 7.066 5.652a1 1 0 10-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 11.414l2.934 2.934a1 1 0 001.414-1.414L11.414 10l2.934-2.934a1 1 0 000-1.414z"/></svg>
    </span>
</div>
@endif

<!-- Error message -->
@if (session('error'))
<div class="notification-card bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert" id="error-message">
    <strong class="font-bold">Error!</strong>
    <span class="block sm:inline">{{ session('error') }}</span>
    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
        <svg class="fill-current h-6 w-6 text-red-500" role="button" onclick="closeNotification('error-message')" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 5.652a1 1 0 00-1.414 0L10 8.586 7.066 5.652a1 1 0 10-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 11.414l2.934 2.934a1 1 0 001.414-1.414L11.414 10l2.934-2.934a1 1 0 000-1.414z"/></svg>
    </span>
</div>
@endif


<script>
    function closeNotification(notificationId) {
        document.getElementById(notificationId).style.display = 'none';
    }

    document.addEventListener('DOMContentLoaded', function() {
        var successMessage = document.getElementById('success-message');
        var errorMessage = document.getElementById('error-message');

        if (successMessage) {
            successMessage.style.display = 'block';
            setTimeout(function() {
                successMessage.style.display = 'none';
            }, 1500); // Hide after 5 seconds
        }

        if (errorMessage) {
            errorMessage.style.display = 'block';
            setTimeout(function() {
                errorMessage.style.display = 'none';
            }, 5000); // Hide after 5 seconds
        }
    });
</script>
