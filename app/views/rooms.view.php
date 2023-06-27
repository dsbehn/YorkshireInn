<?php

$db = new Database;
$conn = $db->connect();

$submit_btn = isset($_POST['submit']);

if ($submit_btn) {
  $arrive_date = $_POST['arrive_date'];
  $depart_date = $_POST['depart_date'];
  $guest_num = $_POST['guest_num'];
  
  $query = "SELECT * FROM Rooms where RoomID not in(SELECT RoomID from Bookings WHERE CheckInDate < '$depart_date' AND CheckOutDate > '$arrive_date') and Sleeps >= '$guest_num'";
  $result = $db->query($query);

} else {
  $query = "SELECT * FROM Rooms";
  $result = $db->query($query);
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?=ROOT?>assets/css/style.css">
  <script src="<?=ROOT?>assets/js/script.js" defer></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Roboto+Slab:wght@400;700&display=swap" rel="stylesheet">
  <link rel="icon" type="image/x-icon" href="<?=ROOT?>assets/images/icons/favicon.png">
  <title>Rooms - The Yorkshire Inn</title>
    <style>
        #num_rooms {
            text-align: center;
            font-size: 1.5rem;
            font-weight: 700;
            margin: 2rem 0;
        }
    </style>
</head>

<body>

  <header>

    <div class="contact-info">
      <div class="social-icons">
        <a href="https://www.facebook.com/theyorkshireinn/"><img src="<?=ROOT?>assets/images/icons/facebook.svg" alt="facebook"></a>
        <a href="https://www.instagram.com/the_yorkshire_inn/"><img src="<?=ROOT?>assets/images/icons/instagram.svg" alt="instagram"></a>
        <a href="https://www.yelp.com/biz/the-yorkshire-inn-phelps"><img src="<?=ROOT?>assets/images/icons/yelp.svg" alt="yelp"></a>
      </div>
      <div class="phone-number">
        <img class="phone-icon" src="<?=ROOT?>assets/images/icons/phone.svg" alt="phone">
        <p>315-548-9675</p>
      </div>
    </div>

    <nav class="navbar">
      <div class="logo">
        <a href="<?=ROOT?>">
          <img src="<?=ROOT?>assets/images/icons/logo.svg" alt="The Yorkshire Inn">
        </a>
      </div>

      <div class="navbar-links">
        <ul>
          <li><a href="rooms">Rooms</a></li>
          <li><a href="history">History</a></li>
          <li><a href="gallery">Gallery</a></li>
          <li><a href="fingerlakes">Finger Lakes</a></li>
          <li><a href="contact">Contact & Policies</a></li>
        </ul>
      </div>
      <img src="<?=ROOT?>assets/images/icons/menu.svg" alt="menu icon" class="menu-icon">
    </nav>

  </header>

  <div class="container">

  <section class="rooms section-title">
        <h2>Rooms</h2>

        <div class="calendar full-bleed">

            <div class="arrival">

                <form method="POST" action="">
                <p>Arrival</p>
                    <input class="date-picker" name="arrive_date" type="date" >
                <p>Departure</p>
                    <input class="date-picker departure" name="depart_date" type="date" >

                    <div class="guests">
                <p>Guests</p>
                    <select name="guest_num" id="guest_num">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                    </select>
                </div>


                    <button class="login-button" name="submit" type="submit">Search Rooms</button>
                </form>

            </div>

        </div>

      <h3 id="num_rooms">
          <?php if (isset($arrive_date) && isset($depart_date)){
              if ($guest_num == 1){
                  echo "Available Rooms from $arrive_date to $depart_date for $guest_num Guest";
              } else {
              echo "Available Rooms from $arrive_date to $depart_date for $guest_num Guests";
              }
          }?>
      </h3>

      <?php foreach ($result as $row): ?>

        <div class="room-preview">

            <div class="room-preview-img">
                <img src="<?=ROOT?><?=$row->Picture?>" alt="<?=$row->RoomName?>">
            </div>

            <div class="room-preview-info">
                <h3><?=$row->RoomName?></h3>
                <p class="room-preview-price">$<?=$row->PricePerNight?>/ night</p>
                <p class="room-preview-description"><?=$row->Description?>
                </p>

                <?php if($row->RoomName == "Blue Room"): ?>
                <a href="blueroom" class="underline">More info</a>
                <?php endif; ?>
                <?php if($row->RoomName == "Bolero Room"): ?>
                <a href="boleroroom" class="underline">More info</a>
                <?php endif; ?>
                <?php if($row->RoomName == "Rose Suite"): ?>
                <a href="rosesuite" class="underline">More info</a>
                <?php endif; ?>
                <?php if($row->RoomName == "Lodge Suite"): ?>
                <a href="lodgesuite" class="underline">More info</a>
                <?php endif; ?>
                <div class="room-preview-icons">
                    <img src="<?=ROOT?>assets/images/icons/wifi-grey.svg" alt="Icon">
                    <img src="<?=ROOT?>assets/images/icons/tv-grey.svg" alt="Icon">
                    <?php if($row->RoomName == "Blue Room"): ?>
                        <img src="<?=ROOT?>assets/images/icons/wheelchair-grey.svg" alt="Icon">
                    <?php endif; ?>
                    <img src="<?=ROOT?>assets/images/icons/heat-grey.svg" alt="Icon">
                    <img src="<?=ROOT?>assets/images/icons/bath-grey.svg" alt="Icon">
                </div>

                <form action="oneroom" method="POST">
                    <input type="hidden" name="arrive_date" value="<?php echo $arrive_date ?>">
                    <input type="hidden" name="depart_date" value="<?php echo $depart_date ?>">
                    <input type="hidden" name="room_id" value="<?php echo $row->RoomID ?>">

                    <button class="search_rooms_btn" <?php if (!$submit_btn){ echo "disabled"; }?>>BOOK NOW</button>
                </form>

            </div>
        </div>

      <?php endforeach; ?>

    </section>

    <footer class="full-bleed">

      <div class="footer-container">

        <div class="footer-socials">
          <p class="footer-title">Follow the Yorkshire Inn</p>
          <div class="footer-socials-icons">
            <a href="https://www.facebook.com/theyorkshireinn/"><img src="<?=ROOT?>assets/images/icons/facebook-white.svg" alt="facebook"></a>
            <a href="https://www.instagram.com/the_yorkshire_inn/"><img src="<?=ROOT?>assets/images/icons/instagram-white.svg" alt="instagram"></a>
            <a href="https://www.yelp.com/biz/the-yorkshire-inn-phelps"><img src="<?=ROOT?>assets/images/icons/yelp-white.svg" alt="yelp"></a>
          </div>
        </div>

        <div class="footer-contact">
          <p class="footer-title">Contact us</p>
          <p>315-548-9675</p>
          <p>innkeeper@theyorkshireinn.com</p>
        </div>

    </div>

    <p class="copyright">© 2023 THE YORKSHIRE INN - ALL RIGHTS RESERVED</p>

    </footer>

  </div>

<script>
    const date = new Date();
    const today = date.toISOString().substr(0, 10);
    document.querySelector(".date-picker").value = today;
    document.querySelector(".date-picker").min = today;
    document.querySelector(".date-picker").addEventListener("change", function() {
        document.querySelector(".departure").min = this.value;
    });

    const tomorrow = new Date(date);
    tomorrow.setDate(tomorrow.getDate() + 1);
    const tomorrowString = tomorrow.toISOString().substr(0, 10);
    document.querySelector(".departure").value = tomorrowString;
    document.querySelector(".departure").min = tomorrowString;

</script>

</body>

</html>
