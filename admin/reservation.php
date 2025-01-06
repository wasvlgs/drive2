<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Reservations - Drive & Loc</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Header -->
    <?php require_once '../commands/headerAdmin.php';
        require_once '../commands/manageReservation.php';
        $callFunctions = new manageReservation($conn->getConnect());





        if($_SERVER['REQUEST_METHOD'] === "POST"){
            if(isset($_POST['confirm']) && !empty($_POST['confirm'])){
                $getIdReserve = htmlspecialchars(trim($_POST['confirm']));
                $callFunctions->confirmReservation($getIdReserve);
            }

            if(isset($_POST['cancel']) && !empty($_POST['cancel'])){
                $getIdReserve = htmlspecialchars(trim($_POST['cancel']));
                $callFunctions->rejectReservation($getIdReserve);
            }
        }
     ?>


        <!-- Main Content Area -->
        <main class="flex-1 p-6">
            <!-- Manage Reservations Section -->
            <section id="manage-reservations" class="mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-6">Pending Reservations</h2>

                <!-- Reservation Table -->
                <table class="min-w-full bg-white border-collapse shadow-lg rounded-lg">
                    <thead>
                        <tr class="bg-blue-600 text-white">
                            <th class="py-3 px-6">Customer Name</th>
                            <th class="py-3 px-6">Vehicle</th>
                            <th class="py-3 px-6">Reservation Date</th>
                            <th class="py-3 px-6">Status</th>
                            <th class="py-3 px-6">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $callFunctions->showPenReservation();  ?>
                    </tbody>
                </table>
            </section>



            <section id="manage-reservations" class="mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-6">Confirmed Reservations</h2>

                <!-- Reservation Table -->
                <table class="min-w-full bg-white border-collapse shadow-lg rounded-lg">
                    <thead>
                        <tr class="bg-blue-600 text-white">
                            <th class="py-3 px-6">Customer Name</th>
                            <th class="py-3 px-6">Vehicle</th>
                            <th class="py-3 px-6">Reservation Date</th>
                            <th class="py-3 px-6">Status</th>
                            <th class="py-3 px-6">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $callFunctions->showActReservation();  ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>

    <script>
        // Function to handle confirming a reservation
        function confirmReservation(button) {
            let row = button.closest('tr');
            row.querySelector('td:nth-child(4)').textContent = 'Confirmed';
            button.classList.add('bg-gray-600', 'hover:bg-gray-500');
            button.disabled = true; // Disable the button after confirming
        }

        // Function to handle canceling a reservation
        function cancelReservation(button) {
            let row = button.closest('tr');
            row.querySelector('td:nth-child(4)').textContent = 'Cancelled';
            button.classList.add('bg-gray-600', 'hover:bg-gray-500');
            button.disabled = true; // Disable the button after canceling
        }
    </script>
</body>
</html>
