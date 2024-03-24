<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Bootstrap 4 Carousel with Rows</title>
	<!-- Bootstrap CSS -->
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
	<!-- Swiper CSS -->
	<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">

</head>
<body>

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-2">
			<div class="card my-3">
				<img src="https://via.placeholder.com/800x400" class="card-img-top" alt="Service Provider Image">
				<div class="card-body">
					<h5 class="card-title">Service Provider Name</h5>
					<p class="card-text">Brief description of the service offered.</p>
					<a href="#" class="btn btn-primary">Get a Quote</a>
				</div>
			</div>
		</div>
	</div>
	
	<style>
		.card-img-top {
			object-fit: cover;
			height: 200px;
		}
		
		.card {
			transition: all 0.3s ease-in-out; /* Smooth transition on hover */
			border: none; /* Remove default card border */
			border-radius: 10px; /* Add border radius */
			box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); /* Add subtle shadow */
		}
		
		.card:hover {
			transform: translateY(-5px); /* Lift the card on hover */
			box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Enhance shadow on hover */
		}
		
		.btn-primary {
			background-color: #007bff; /* Update primary button color */
			border-color: #007bff; /* Update primary button border color */
		}
		
		.btn-primary:hover {
			background-color: #0056b3; /* Darker shade on hover */
			border-color: #0056b3; /* Darker shade border on hover */
		}
	</style>
	
	
	<h2>Bootstrap 4 Carousel with Rows</h2>
	<div class="swiper-container">
		<div class="swiper-wrapper">
			<!-- PHP loop to populate the carousel with rows -->
      <?php
        
        // Simulated array of carousel items with short tags
        $carouselItems = [
          [
            'title' => 'Item 1',
            'image' => 'https://via.placeholder.com/800x400',
            'description' => 'Description for Item 1'
          ],
          [
            'title' => 'Item 2',
            'image' => 'https://via.placeholder.com/800x400',
            'description' => 'Description for Item 2'
          ],
          [
            'title' => 'Item 3',
            'image' => 'https://via.placeholder.com/800x400',
            'description' => 'Description for Item 3'
          ],
          [
            'title' => 'Item 4',
            'image' => 'https://via.placeholder.com/800x400',
            'description' => 'Description for Item 4'
          ],
          [
            'title' => 'Item 5',
            'image' => 'https://via.placeholder.com/800x400',
            'description' => 'Description for Item 5'
          ],
          [
            'title' => 'Item 6',
            'image' => 'https://via.placeholder.com/800x400',
            'description' => 'Description for Item 6'
          ],
          [
            'title' => 'Item 7',
            'image' => 'https://via.placeholder.com/800x400',
            'description' => 'Description for Item 7'
          ]
        ];
        
        // Initialize variables
        $numItems = count($carouselItems);
        $rows     = ceil($numItems / 2); // Calculate number of rows based on 2 items per row
        // Loop through the rows
        for ($row = 0; $row < $rows; $row++) {
          echo '<div class="swiper-slide"><div class="row">';
          // Loop through the columns (items) per row
          for ($col = 0; $col < 2; $col++) { // 2 items per row
            $index = $row * 2 + $col;        // Calculate the index of the item in the array
            // Check if the index is within the range of items
            if ($index < $numItems) {
              // Display the item
              echo '<div class="col-md-6">';
              echo '<img class="d-block w-100" src="' . $carouselItems[$index]['image'] . '" alt="' . $carouselItems[$index]['title'] . '">';
              echo '<div class="carousel-caption d-none d-md-block">';
              echo '<h5>' . $carouselItems[$index]['title'] . '</h5>';
              echo '<p>' . $carouselItems[$index]['description'] . '</p>';
              echo '</div>';
              echo '</div>';
            }
          }
          echo '</div></div>';
        }
      ?>
		</div>
		<!-- Add Pagination -->
		<div class="swiper-pagination"></div>
		<!-- Add Navigation -->
		<div class="swiper-button-prev"></div>
		<div class="swiper-button-next"></div>
	</div>
</div>


<!-- Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Swiper JS -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<script>
  var swiper = new Swiper('.swiper-container', {
    slidesPerView: 'auto', // Number of slides per view
    spaceBetween: 10, // Space between slides (optional)
    loop: false, // Enable loop mode
    pagination: {
      el: '.swiper-pagination', // Pagination container (optional)
      clickable: true, // Enable clickable pagination (optional)
    }, navigation: {
      nextEl: '.swiper-button-next', // Next button selector (optional)
      prevEl: '.swiper-button-prev', // Previous button selector (optional)
    },
  });
</script>

</body>
</html>
