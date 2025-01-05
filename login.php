<?php
session_start();

if(isset($_SESSION['isUserLogged']) && $_SESSION['isUserLogged']==true){
  header('Location: summary.php');
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Twój Zaufany Asystent Budżetowy</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <link rel="stylesheet" href="./style.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Charm:wght@400;700&family=IBM+Plex+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet" />
</head>

<body>
  <header>
    <div class="text-center">
      <h1>Zaloguj się</h1>
    </div>
  </header>

  <main>
    <div class="container col-xl-10 col-xxl-8 px-4 py-2">
      <div class="row align-items-center g-lg-5 py-5">
        <div class="col-lg-7 text-center text-lg-start">
          <blockquote class="blockquote">
            <p class="mb-0">
              „Najpewniejszą drogą do sukcesu jest próbować,
              jeszcze ten jeden raz.”
            </p>
          </blockquote>
        </div>
        <div class="col-md-10 mx-auto col-lg-5">
          <form action="login-verify.php" class="p-4 p-md-5 border rounded-5 bg-body-tertiary" method="post">
            <div class="form-floating mb-3">
              <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email" value="<?php 
              if (isset($_SESSION['loginError'])) {
                echo $_SESSION['givenEmail'];
              }
              ?>" />
              <label for="floatingInput">Email</label>
            </div>
            <div class="form-floating mb-3">
              <input type="password" class="form-control" id="floatingPassword" placeholder="Hasło" name="password" value="<?php 
              if (isset($_SESSION['loginError'])) {
                echo $_SESSION['givenPassword'];
              }
              ?>" />
              <label for="floatingPassword">Hasło</label>
            </div>
            <?php
            if (isset($_SESSION['loginError'])) {
              echo "<span class='error'>Błędne dane logowania!</span>";
            }
            ?>
            <button class="btn btn-primary px-5 btn-lg rounded-pill text-center mx-3" type="submit">
              Zaloguj się
            </button>




          </form>
        </div>
      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script src="./index.js"></script>
</body>

</html>