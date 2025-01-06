<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Drive & Loc</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <?php require_once '../commands/headerAdmin.php';
    require_once '../commands/adminStatique.php';
    $callFunction = new getAdminStatique($conn->getConnect(),$getID);
     ?>
        <!-- Main Content Area -->
        <main class="flex-1 p-6">
            <!-- Dashboard Overview Section -->
            <section id="dashboard-overview" class="mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-6">Admin Dashboard</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Stats Cards -->
                    <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                        <h3 class="text-2xl font-bold text-blue-600">
                            <?php echo $callFunction->getAllVehicule();?>
                        </h3>
                        <p class="text-gray-600">Total Vehicles</p>
                    </div>
                    <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                        <h3 class="text-2xl font-bold text-blue-600">
                            <?php echo $callFunction->getActiveResere(); ?>
                        </h3>
                        <p class="text-gray-600">Active Reservations</p>
                    </div>
                    <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                        <h3 class="text-2xl font-bold text-blue-600">
                            <?php echo $callFunction->getAllReviews(); ?>
                        </h3>
                        <p class="text-gray-600">Total Reviews</p>
                    </div>
                    <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                        <h3 class="text-2xl font-bold text-blue-600">
                            <?php echo $callFunction->getAllCategories(); ?>
                        </h3>
                        <p class="text-gray-600">Categories</p>
                    </div>
                </div>
            </section>

            <!-- Quick Actions Section -->
            <section id="quick-actions" class="mb-12">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Quick Actions</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Add Vehicle -->
                    <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                        <h3 class="text-xl font-bold text-blue-600">+ Add Vehicle</h3>
                        <p class="text-gray-600">Quickly add a new vehicle to the platform</p>
                        <a href="../admin/vehicules.php" class="text-blue-600 hover:underline mt-4 block">Go to Add Vehicle</a>
                    </div>
                    <!-- Manage Reservations -->
                    <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                        <h3 class="text-xl font-bold text-blue-600">Manage Reservations</h3>
                        <p class="text-gray-600">View and manage customer reservations</p>
                        <a href="../admin/reservation.php" class="text-blue-600 hover:underline mt-4 block">Go to Reservations</a>
                    </div>
                    <!-- Manage Reviews -->
                    <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                        <h3 class="text-xl font-bold text-blue-600">Manage Reviews</h3>
                        <p class="text-gray-600">View and moderate customer reviews</p>
                        <a href="../admin/review.php" class="text-blue-600 hover:underline mt-4 block">Go to Reviews</a>
                    </div>
                </div>
            </section>

            <!-- Recent Activity Section -->
            <section id="recent-activity">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Recent Activity</h2>

                <!-- Recent Reservations -->
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Recent Reservations</h3>
                    <table class="w-full bg-white border-collapse">
                        <thead>
                            <tr class="bg-blue-600 text-white">
                                <th class="py-3 px-6">Vehicle</th>
                                <th class="py-3 px-6">Customer</th>
                                <th class="py-3 px-6">Email</th>
                                <th class="py-3 px-6">Reservation Date</th>
                                <th class="py-3 px-6">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo $callFunction->showAllReservation(); ?>
                            <!-- <tr class="border-b">
                                <td class="py-4 px-6">Luxury Sedan</td>
                                <td class="py-4 px-6">John Doe</td>
                                <td class="py-4 px-6">2024-01-10</td>
                                <td class="py-4 px-6 text-green-600">Confirmed</td>
                            </tr>
                            <tr class="border-b">
                                <td class="py-4 px-6">SUV</td>
                                <td class="py-4 px-6">Jane Smith</td>
                                <td class="py-4 px-6">2024-01-12</td>
                                <td class="py-4 px-6 text-yellow-600">Pending</td>
                            </tr> -->
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
