<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Vehicles - Drive & Loc</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Header -->
    <?php require_once '../commands/headerAdmin.php'; 
        require_once '../commands/vehicule.php';
        $callFunctions = new manageVehicle($conn->getConnect());
    ?>

        <!-- Main Content Area -->
        <main class="flex-1 p-6">
            <!-- Manage Vehicles Section -->
            <section id="manage-vehicles" class="mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-6">Manage Vehicles</h2>

                <!-- Button to Add New Vehicle -->
                <div class="mb-6">
                    <button onclick="openAddModal()" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-500">+ Add New Vehicle</button>
                </div>

                <table class="min-w-full bg-white border-collapse shadow-lg rounded-lg">
                    <thead>
                        <tr class="bg-blue-600 text-white">
                            <th class="py-3 px-6">Vehicle Name</th>
                            <th class="py-3 px-6">Category</th>
                            <th class="py-3 px-6">Price per Day</th>
                            <th class="py-3 px-6">Availability</th>
                            <th class="py-3 px-6">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $callFunctions->showVehicle(); ?>
                        
                    </tbody>
                </table>
            </section>
        </main>
    </div>

    <!-- Add Vehicle Modal -->
    <div id="addVehicleModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 hidden">
        <div class="bg-white p-6 rounded-lg w-96">
            <h3 class="text-2xl font-semibold text-gray-800 mb-4">Add New Vehicle</h3>
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-4">
                    <label for="vehicle-image" class="block text-gray-700">Upload Image</label>
                    <input name="imgVehicle" type="file" id="vehicle-image" class="w-full p-2 border border-gray-300 rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="vehicle-name" class="block text-gray-700">Vehicle Name</label>
                    <input name="vehicleName" type="text" id="vehicle-name" class="w-full p-2 border border-gray-300 rounded-md" placeholder="Enter vehicle name" required>
                </div>
                <div class="mb-4">
                    <label for="vehicle-Modele" class="block text-gray-700">Vehicle Modele</label>
                    <input name="vehicleModele" type="text" id="vehicle-Modele" class="w-full p-2 border border-gray-300 rounded-md" placeholder="Enter vehicle Medele" required>
                </div>
                <div class="mb-4">
                    <label for="vehicle-category" class="block text-gray-700">Category</label>
                    <select name="vehicleCategory" id="vehicle-category" class="w-full p-2 border border-gray-300 rounded-md">
                        <option value="" disabled selected>   -- Select Categorie --  </option>
                        <!-- <option value="Not Available">Sport</option> -->
                         <?php echo $callFunctions->getCategories(); ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="vehicle-price" class="block text-gray-700">Price per Day</label>
                    <input name="vehiclePrice" type="number" id="vehicle-price" class="w-full p-2 border border-gray-300 rounded-md" placeholder="Enter price" required>
                </div>
                <div class="mb-4">
                    <label for="vehicle-availability" class="block text-gray-700">Availability</label>
                    <select name="vehicleType" id="vehicle-availability" class="w-full p-2 border border-gray-300 rounded-md">
                        <option value="1">Available</option>
                        <option value="0">Not Available</option>
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="closeAddModal()" class="px-4 py-2 mr-4 bg-gray-400 text-white rounded-md">Cancel</button>
                    <button name="addVehicule" type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Add Vehicle</button>
                </div>
            </form>
        </div>
    </div>


    <?php

        if($_SERVER['REQUEST_METHOD'] === "POST"){
            if(isset($_POST['addVehicule'])){
                $getVehicleName = htmlspecialchars(trim($_POST['vehicleName']));
                $getvehicleModele = htmlspecialchars(trim($_POST['vehicleModele']));
                $getvehicleCategory = htmlspecialchars(trim($_POST['vehicleCategory']));
                $getvehiclePrice = htmlspecialchars(trim($_POST['vehiclePrice']));
                $getvehicleType = htmlspecialchars(trim($_POST['vehicleType']));
                $getType;
                $getImg = $_FILES['imgVehicle'];
                if(!empty($getVehicleName) && !empty($getvehicleModele) && !empty($getvehicleCategory) && !empty($getvehiclePrice) && ($getvehicleType == "1" || $getvehicleType == "0") && !empty($getImg)){
                    if($getvehicleType == '1'){
                        $getType = true;
                    }else if($getvehicleType == '0'){
                        $getType = false;
                    }
                    $callFunctions->addVehicle($getVehicleName,$getvehicleModele,$getvehicleCategory,$getvehiclePrice,$getType,$getImg);
                }else{
                    echo '<script>alert("Ivalid information!")</script>';
                }
            }

            if(isset($_POST['editVehicle']) && !empty($_POST['editVehicle'])){
                $getName = htmlspecialchars(trim($_POST['getName']));
                $getNewModele = htmlspecialchars(trim($_POST['newModele']));
                $getNewCategory = htmlspecialchars(trim($_POST['NewCategory']));
                $getNewPrix = htmlspecialchars(trim($_POST['newPrix']));
                $getNewType = htmlspecialchars(trim($_POST['newType']));
                $getId = htmlspecialchars(trim($_POST['editVehicle']));

                if(!empty($getName) && !empty($getNewCategory) && !empty($getNewPrix) && !empty($getNewType) && !empty($getId)){
                    $callFunctions->editVehicle($getName,$getNewModele,$getNewCategory,$getNewPrix,$getNewType,$getId);
                }else{
                    echo '<script>alert("Invalid information!")</script>';
                }
            }

            if(isset($_POST['delete']) && !empty($_POST['delete'])){
                $getId = htmlspecialchars(trim($_POST['delete']));
                if(!empty($getId)){
                    $callFunctions->removeVehicle($getId);
                }else{
                    echo '<script>alert("Invalid information!")</script>';
                }
            }
        }
    
    
    ?>

    <!-- Edit Vehicle Modal -->
    <div id="editVehicleModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 hidden">
        <div class="bg-white p-6 rounded-lg w-96">
            <h3 class="text-2xl font-semibold text-gray-800 mb-4">Edit Vehicle</h3>
            <form method="POST">
                <div class="mb-4">
                    <label for="edit-vehicle-name" class="block text-gray-700">Vehicle Name</label>
                    <input name="getName" type="text" id="edit-vehicle-name" class="w-full p-2 border border-gray-300 rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="edit-vehicle-modele" class="block text-gray-700">Vehicle Modele</label>
                    <input name="newModele" type="text" id="edit-vehicle-modele" class="w-full p-2 border border-gray-300 rounded-md" required>
                </div>
                <div class="mb-4">
                <label for="edit-vehicle-category" class="block text-gray-700">Category</label>
                <select name="NewCategory" id="edit-vehicle-category" class="w-full p-2 border border-gray-300 rounded-md">
                        <option value="" disabled selected>   -- Select Categorie --  </option>
                        <!-- <option value="Not Available">Sport</option> -->
                         <?php echo $callFunctions->getCategories(); ?>
                </select>
                </div>
                <div class="mb-4">
                    <label for="edit-vehicle-price" class="block text-gray-700">Price per Day</label>
                    <input name="newPrix" type="number" id="edit-vehicle-price" class="w-full p-2 border border-gray-300 rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="edit-vehicle-availability" class="block text-gray-700">Availability</label>
                    <select name="newType" id="edit-vehicle-availability" class="w-full p-2 border border-gray-300 rounded-md">
                        <option value="1">Available</option>
                        <option value="0">Not Available</option>
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 mr-4 bg-gray-400 text-white rounded-md">Cancel</button>
                    <button id="editVehicle" name="editVehicle" type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Update Vehicle</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Open Add Vehicle Modal
        function openAddModal() {
            document.getElementById('addVehicleModal').classList.remove('hidden');
        }

        // Close Add Vehicle Modal
        function closeAddModal() {
            document.getElementById('addVehicleModal').classList.add('hidden');
        }

        // Open Edit Vehicle Modal
        function openEditModal(name, modele, category, prix, availability,getId) {
            document.getElementById('edit-vehicle-name').value = name;
            document.getElementById('edit-vehicle-modele').value = modele;
            document.getElementById('edit-vehicle-category').value = category;
            document.getElementById('edit-vehicle-price').value = prix;
            document.getElementById('edit-vehicle-availability').value = availability;
            document.getElementById('editVehicle').value = getId;
            document.getElementById('editVehicleModal').classList.remove('hidden');
        }

        // Close Edit Vehicle Modal
        function closeEditModal() {
            document.getElementById('editVehicleModal').classList.add('hidden');
        }

        // Delete Vehicle
        function deleteVehicle(name) {
            alert('Vehicle ' + name + ' has been deleted.');
            // Add logic for deleting vehicle from the backend
        }
    </script>
</body>
</html>
