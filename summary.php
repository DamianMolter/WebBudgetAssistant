<?php
session_start();
if (!isset($_SESSION['loggedUserId'])) {
  header('Location: login.php');
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
              <a href="./income.html" class="nav-link py-3">Dodaj przychód</a>
            </button>
          </li>
          <li>
            <button class="dropdown-item" type="button">
              <a href="./expense.html" class="nav-link py-3">Dodaj wydatek</a>
            </button>
          </li>
          <li>
            <button class="dropdown-item" type="button">
              <a href="./summary.html" class="nav-link py-3">Przeglądaj bilans</a>
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
            <a href="./income.html" class="nav-link py-3">Dodaj przychód</a>
          </li>
          <li class="nav-item">
            <a href="./expense.html" class="nav-link py-3">Dodaj wydatek</a>
          </li>
          <li class="nav-item">
            <a href="./summary.html" class="nav-link py-3">Przeglądaj bilans</a>
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

  <header>
    <div class="text-center pt-5">
      <h1>Twój Bilans</h1>
    </div>
  </header>

  <main>
    <div class="container">
      <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          Niestandardowy
        </button>
        <ul class="dropdown-menu">
          <li><a class="nav-link py-3" href="#">Bieżący miesiąc</a></li>
          <li><a class="nav-link py-3" href="#">Poprzedni miesiąc</a></li>
          <li><a class="nav-link py-3" href="#">Bieżący rok</a></li>
          <li>
            <a class="nav-link py-3" href="#" data-bs-toggle="modal" data-bs-target="#customPeriod">Okres
              niestandardowy</a>
          </li>
        </ul>
      </div>

      <div class="modal fade" id="customPeriod" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title fs-5" id="exampleModalLabel">
                Wybierz przedział czasowy
              </h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div>
                <h5>Początek okresu:</h5>
                <input id="startDate" class="form-control" type="date" />
              </div>
              <div>
                <h5>Koniec okresu:</h5>
                <input id="endDate" class="form-control" type="date" />
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                Anuluj
              </button>
              <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                Akceptuj
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container table">
      <div class="text-center">
        <h2>Tabela przychodów</h2>
        <table class="table table-hover">
          <tr class="odd-row col-title">
            <td>Kategoria</td>
            <td>Kwota (PLN)</td>
          </tr>
          <tr class="even-row">
            <td>Wynagrodzenie</td>
            <td>4300</td>
          </tr>
          <tr class="odd-row">
            <td>Odsetki bankowe</td>
            <td>20</td>
          </tr>
          <tr class="even-row">
            <td>Sprzedaż na allegro</td>
            <td>200</td>
          </tr>
          <tr class="odd-row col-title">
            <td>Suma</td>
            <td>4520</td>
          </tr>
        </table>
      </div>
      <div class="text-center">
        <h2>Tabela Wydatków</h2>
        <table class="table table-hover">
          <tr class="odd-row col-title">
            <td>Kategoria</td>
            <td>Kwota (PLN)</td>
          </tr>
          <tr class="even-row">
            <td>Jedzenie</td>
            <td>2000</td>
          </tr>
          <tr class="odd-row">
            <td>Ubrania</td>
            <td>500</td>
          </tr>
          <tr class="even-row">
            <td>Mieszkanie</td>
            <td>1000</td>
          </tr>
          <tr class="odd-row col-title">
            <td>Suma</td>
            <td>3500</td>
          </tr>
        </table>
        <div class="table"></div>
      </div>
    </div>

    <div class="container text-center py-5">
      <h6>
        Twój bilans wynosi 1020 PLN! Gratulacje! Doskonale zarządzasz swoimi
        finansami!
      </h6>
    </div>
  </main>

  <hr />
  <aside>
    <div class="container chart d-flex justify-content-center">
      <div id="income-piechart"></div>
      <div id="expense-piechart"></div>
    </div>
  </aside>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="./index.js"></script>
</body>

</html>