<?php
session_start();
if (!isset($_SESSION['loggedUserId'])) {
  header('Location: login.php');
  exit();
} ?>
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
  <nav>
    <div class="container d-flex justify-content-center">
      <div class="dropdown" id="mobile-menu">
        <button class="btn btn-secondary-li dropdown-toggle" type="button" data-bs-toggle="dropdown"
          aria-expanded="false">
          <img src="./images/icons8-hamburger-menu-50.png" alt="dropdown menu icon" />
        </button>
        <ul class="dropdown-menu">
          <li>
            <button class="dropdown-item" type="button">
              <a href="./income.php" class="nav-link py-3">Dodaj przychód</a>
            </button>
          </li>
          <li>
            <button class="dropdown-item" type="button">
              <a href="./expense.php" class="nav-link py-3">Dodaj wydatek</a>
            </button>
          </li>
          <li>
            <button class="dropdown-item" type="button">
              <a href="./summary-current-month.php" class="nav-link py-3">Przeglądaj bilans</a>
            </button>
          </li>
          <li>
            <button class="dropdown-item" type="button">
              <a href="#" class="nav-link py-3">Ustawienia</a>
            </button>
          </li>
          <li>
            <button class="dropdown-item" type="button">
              <a href="./logout.php" class="nav-link py-3">Wyloguj</a>
            </button>
          </li>
        </ul>
      </div>
    </div>
    <div class="container navbar">
      <div class="d-flex justify-content-center align-items-center py-3 dark-green">
        <ul class="nav nav-pills">
          <li class="nav-item">
            <a href="./income.php" class="nav-link py-3">Dodaj przychód</a>
          </li>
          <li class="nav-item">
            <a href="./expense.php" class="nav-link py-3">Dodaj wydatek</a>
          </li>
          <li class="nav-item">
            <a href="./summary-current-month.php" class="nav-link py-3">Przeglądaj bilans</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link py-3">Ustawienia</a>
          </li>
          <li class="nav-item">
            <a href="./logout.php" class="nav-link py-3">Wyloguj</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container">
    <main>
      <div class="py-5 text-center">
        <h2>Dodaj wydatek</h2>
      </div>

      <?php
      if (isset($_SESSION['success'])) {
        echo '<div class = "action-status"><p class = "success">Wydatek został pomyślnie dodany!</p></div>';
        unset($_SESSION['success']);
      }


      if (isset($_SESSION['inputError'])) {
        echo '<div class = "action-status"><p class= "error">Podano błędne lub niekompletne informacje!</p></div>';
        unset($_SESSION['inputError']);
      }
      ?>



      <div class="row g-5">
        <div class="col-md-12 col-lg-12 text-center">
          <h4 class="mb-3">Szczegóły transakcji</h4>
          <form class="needs-validation" novalidate="" action="expense-verify.php" method="post">
            <div class="row g-3 d-flex justify-content-center">
              <div class="col-3">
                <label for="address" class="form-label">Kwota</label>
                <div class="input-group">
                  <input type="number" min="0" step="5" class="form-control"
                    aria-label="Cash amount (with dot and two decimal places)" name="amount" value="<?php
                    if (isset($_SESSION['inputError'])) {
                      echo $_SESSION['givenAmount'];
                      unset($_SESSION['givenAmount']);
                      unset($_SESSION['inputError']);
                    }
                    ?>" />
                  <span class="input-group-text">zł</span>
                </div>
              </div>

              <div class="col-3">
                <label for="address2" class="form-label">Data transakcji</label>
                <input id="startDate" class="form-control" type="date" name="date" />
              </div>

              <div class="col-md-5">
                <label for="country" class="form-label">Sposób płatności</label>
                <select class="form-select" id="country" required="" name="paymentMethod">
                  <option value="0">Wybierz metodę płatności</option>
                  <?php

                  require_once 'connect.php';
                  $loadPaymentMethodsQuery = $db->prepare('SELECT id, name FROM payment_methods_assigned_to_users
                                                                WHERE user_id=:userId');
                  $loadPaymentMethodsQuery->bindValue(':userId', $_SESSION['loggedUserId'], PDO::PARAM_INT);
                  $loadPaymentMethodsQuery->execute();

                  $paymentMethods = $loadPaymentMethodsQuery->fetchAll();

                  foreach ($paymentMethods as $paymentMethod) {
                    echo '<option value = "' . $paymentMethod['id'] . '">' . $paymentMethod['name'] . '</option>';
                  }
                  ?>
                </select>
              </div>

              <div class="col-md-4">
                <label for="state" class="form-label">Kategoria</label>
                <select class="form-select" id="state" required="" name="expenseCategory">
                  <option value="0">Wybierz kategorię</option>
                  <?php

                  require_once 'connect.php';
                  $loadExpenseCategoriesQuery = $db->prepare('SELECT id, name FROM expenses_category_assigned_to_users
                                                                WHERE user_id=:userId');
                  $loadExpenseCategoriesQuery->bindValue(':userId', $_SESSION['loggedUserId'], PDO::PARAM_INT);
                  $loadExpenseCategoriesQuery->execute();

                  $expenseCategories = $loadExpenseCategoriesQuery->fetchAll();

                  foreach ($expenseCategories as $expenseCategory) {
                    echo '<option value = "' . $expenseCategory['id'] . '">' . $expenseCategory['name'] . '</option>';
                  }
                  ?>
                </select>
                <div class="invalid-feedback">Wybierz jedną z opcji</div>
              </div>
            </div>

            <div class="form-group py-5">
              <label for="address" class="form-label">Komentarz(opcjonalnie)</label>
              <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="expenseComment"></textarea>
            </div>
            <button class="w-100 btn btn-primary btn-lg" type="submit">
              Zapisz
            </button>
            <button class="w-100 btn btn-secondary btn-lg" type="reset">
              Anuluj
            </button>
          </form>
        </div>
      </div>
    </main>

    <footer class="my-5 pt-5 text-body-secondary text-center text-small">
      <p class="mb-1">© 2024 By Damian Molter</p>
    </footer>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</body>

</html>