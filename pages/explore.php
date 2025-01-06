<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Vehicles - Drive & Loc</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <?php
            require_once '../commands/header.php';
            require_once '../commands/afficher.php';
            $callFunctions = new VehiculePagination($conn->getConnect());
         ?>

        <!-- Main Content Area -->
        <main class="flex-1 p-6">
            <!-- Explore Section -->
            <section id="explore" class="mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Explore Vehicles</h2>
                
                <!-- Filter Options (Optional) -->
                <div class="mb-6">
                    <form method="POST" class="flex gap-4">
                        <select name="option" class="p-2 border rounded">
                            <option value="">All Categories</option>
                            <?php $callFunctions->getCategories(); ?>
                        </select>

                        <button name="filter" class="flex items-center justify-center px-4 py-2 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-blue-600 hover:text-white transition duration-300">Filter</button>
                    </form>
                </div>

                <!-- Vehicle List -->
                <div id="afficher" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php 
                        $getOffset;
                        if(isset($_GET['page']) && !empty(trim($_GET['page']))){
                            $getOffset = htmlspecialchars(trim($_GET['page']));
                        }else{
                            $getOffset = 0;
                        }
                        $getFilter = '';
                        if(isset($_POST['filter'])){
                            $getFilter = htmlspecialchars(trim($_POST['option']));
                        }
                        $data = $callFunctions->getVehicules(3,$getOffset,$getFilter);
                        $getData = $data['getData'];
                        foreach($getData as $item){
                            echo '<div class="bg-white shadow-lg rounded-lg overflow-hidden">
                             <img src="../img/imgPages/'.$item['imgSrc'].'" alt="SUV" class="w-full h-40 object-cover">
                             <div class="p-4">
                                 <h3 class="text-xl font-bold">'.$item['name'].'</h3>
                                 <p class="text-gray-600">Starting at $'.$item['prix'].'/day</p>
                                 <h6 class="text-lg text-blue-600">'.$item['modele'].'</h6>
                                 <a target="_blank" href="../cars/car.php?car='.$item['id_vehicule'].'" class="mt-4 block text-center py-2 px-4 bg-blue-600 text-white rounded hover:bg-blue-700">Reserve Now</a>
                             </div>
                         </div>';
                        }
                    ?>
                </div>



                <!-- Pagination Section -->
                    <div class="mt-8 flex justify-center">
                        <nav aria-label="Pagination">
                            <ul id="buttonsAffichage" class="flex items-center space-x-4">
                                
                                <?php

                                if(isset($_GET['page'])){
                                    if($_GET['page'] > 1){
                                    echo '<li>
                                    <a href="explore.php?page='.($_GET['page'] - 1).'" class="flex items-center justify-center px-4 py-2 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-blue-600 hover:text-white transition duration-300">
                                        ← Previous
                                    </a>
                                    </li>';
                                    }
                                    

                                        for($i = 1; $i <= $data['totalPages']; $i++){
                                            echo '<li>
                                        <a href="explore.php?page='.$i.'" class="px-4 py-2 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-blue-600 hover:text-white transition duration-300">'.$i.'</a>
                                    </li>';
                                        }

                                        if($_GET['page'] == 1){
                                            echo '<li>
                                        <a href="explore.php?page='.($_GET['page'] + 1).'" class="flex items-center justify-center px-4 py-2 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-blue-600 hover:text-white transition duration-300">
                                            Next →
                                        </a>
                                    </li>';
                                        }
                                
                                }else{
                                    for($i = 1; $i <= $data['totalPages']; $i++){
                                        echo '<li>
                                    <a href="explore.php?page='.$i.'" class="px-4 py-2 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-blue-600 hover:text-white transition duration-300">'.$i.'</a>
                                </li>';
                                    }

                                        echo '<li>
                                    <a href="explore.php?page=2" class="flex items-center justify-center px-4 py-2 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-blue-600 hover:text-white transition duration-300">
                                        Next →
                                    </a>
                                </li>';
                                }
                                
                                
                                ?>
                                <!-- Previous Button -->
                                <!-- <li>
                                    <a href="#" class="flex items-center justify-center px-4 py-2 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-blue-600 hover:text-white transition duration-300">
                                        ← Previous
                                    </a>
                                </li> -->

                                <!-- Page Numbers -->
                                <!-- <li>
                                    <a href="#" class="px-4 py-2 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-blue-600 hover:text-white transition duration-300">1</a>
                                </li>
                                <li>
                                    <a href="#" class="px-4 py-2 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-blue-600 hover:text-white transition duration-300">2</a>
                                </li>
                                <li>
                                    <a href="#" class="px-4 py-2 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-blue-600 hover:text-white transition duration-300">3</a>
                                </li>
                                <li>
                                    <a href="#" class="px-4 py-2 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-blue-600 hover:text-white transition duration-300">4</a>
                                </li> -->

                                <!-- Next Button -->
                                <!-- <li>
                                    <a href="#" class="flex items-center justify-center px-4 py-2 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-blue-600 hover:text-white transition duration-300">
                                        Next →
                                    </a>
                                </li> -->
                            </ul>
                        </nav>
                    </div>

            </section>
        </main>
    </div>
    <script>
    // document.addEventListener("DOMContentLoaded",()=>{
    //     let afficherSection = document.getElementById("afficher");
    //     let buttonsAffichage = document.getElementById("buttonsAffichage");
    //     fetch('../commands/afficher.php')
    //     .then(response => response.json())
    //     .then(data=>{
    //     afficherSection.innerHTML = '';
    //         if(data.getData.length > 0){
    //             data.getData.forEach(element => {
    //             afficherSection.innerHTML += `<div class="bg-white shadow-lg rounded-lg overflow-hidden">
    //                     <img src="../img/imgPages/${element.imgSrc}" alt="SUV" class="w-full h-40 object-cover">
    //                     <div class="p-4">
    //                         <h3 class="text-xl font-bold">${element.name}</h3>
    //                         <p class="text-gray-600">Starting at $${element.prix}/day</p>
    //                         <h6 class="text-lg text-blue-600">${element.modele}</h6>
    //                         <a target="_blank" href="../cars/car.php?car=${element.id_vehicule}" class="mt-4 block text-center py-2 px-4 bg-blue-600 text-white rounded hover:bg-blue-700">Reserve Now</a>
    //                     </div>
    //                 </div>`;
    //             });
    //         }

    //         for(let i = 1; i <= data.totalPages; i++){
    //             buttonsAffichage.innerHTML += `<li>
    //                 <a href="explore.php?page=${i}" class="px-4 py-2 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-blue-600 hover:text-white transition duration-300">${i}</a>
    //             </li>`;
    //         }
            
    //     })
        
    // })

    </script>
</body>
</html>
