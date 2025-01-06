<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Reviews - Drive & Loc</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Header -->
    <?php require_once '../commands/headerAdmin.php'; 
        require_once '../commands/manageReview.php';
        $callFunctions = new manageReview($conn->getConnect());


        if($_SERVER['REQUEST_METHOD'] === "POST"){
            if(isset($_POST['delete']) && !empty($_POST['delete'])){
                $getIdReview = htmlspecialchars(trim($_POST['delete']));
                if(!empty($getIdReview)){
                    $callFunctions->deleteReview($getIdReview);
                }else{
                    echo 'Invalid review!';
                }
            }
        }
    ?>

        <!-- Main Content Area -->
        <main class="flex-1 p-6">
            <!-- Manage Reviews Section -->
            <section id="manage-reviews" class="mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-6">Manage Reviews</h2>

                <!-- Reviews Table -->
                <table class="min-w-full bg-white border-collapse shadow-lg rounded-lg">
                    <thead>
                        <tr class="bg-blue-600 text-white">
                            <th class="py-3 px-6">Customer Name</th>
                            <th class="py-3 px-6">Vehicle</th>
                            <th class="py-3 px-6">Rating</th>
                            <th class="py-3 px-6">Review</th>
                            <th class="py-3 px-6">Date</th>
                            <th class="py-3 px-6">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo $callFunctions->showReviews(); ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>

    <script>
        // Function to handle approving a review
        function approveReview(reviewId) {
            let statusCell = document.getElementById('status-' + reviewId);
            statusCell.textContent = 'Approved';
            statusCell.classList.add('text-green-600');
            statusCell.classList.remove('text-red-600');
            
            // Disable approve button and change color after approval
            let approveButton = statusCell.closest('tr').querySelector('.bg-green-600');
            approveButton.classList.add('bg-gray-600', 'hover:bg-gray-500');
            approveButton.disabled = true;
        }

        // Function to handle deleting a review
        function deleteReview(reviewId) {
            let reviewRow = document.getElementById('status-' + reviewId).closest('tr');
            reviewRow.remove(); // Removes the review row from the table
            
            alert('Review deleted!');
        }
    </script>
</body>
</html>
