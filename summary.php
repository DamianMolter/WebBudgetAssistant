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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
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

  <header>
    <div class="text-center pt-5">
      <h1><?php

      if (isset($_SESSION['loggedUserName'])) {
        echo 'Witaj ' . $_SESSION['loggedUserName'] . ', ';
      }
      ?>oto twój Bilans</h1>
    </div>
  </header>

  <main>
    <div class="container">
      <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          Niestandardowy
        </button>
        <ul class="dropdown-menu">
          <li><a class="nav-link py-3" href="./summary-current-month.php">Bieżący miesiąc</a></li>
          <li><a class="nav-link py-3" href="./summary-previous-month.php">Poprzedni miesiąc</a></li>
          <li><a class="nav-link py-3" href="./summary-current-year.php">Bieżący rok</a></li>
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
              <form action="./summary-custom-period.php" method="post">
                <div>
                  <h5>Początek okresu:</h5>
                  <input id="startDate" class="form-control" type="date" name="beginDate" />
                </div>
                <div>
                  <h5>Koniec okresu:</h5>
                  <input id="endDate" class="form-control" type="date" name="endDate" />
                </div>


            </div>
            <div class="modal-footer">
              <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">
                Anuluj
              </button>
              <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">
                Akceptuj
              </button>
            </div>
            </form>
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
          <?php
          require_once 'connect.php';
          $incomeSummaryQuery = $db->prepare('SELECT name, SUM(amount) AS amountSum FROM incomes
INNER JOIN incomes_category_assigned_to_users ON incomes_category_assigned_to_users.id=incomes.income_category_assigned_to_user_id
WHERE incomes.user_id = :loggedUserId AND incomes.date_of_income BETWEEN :beginDate AND :endDate
GROUP BY name
ORDER BY amountSUM DESC');
          $incomeSummaryQuery->bindValue(':loggedUserId', $_SESSION['loggedUserId'], PDO::PARAM_INT);
          $incomeSummaryQuery->bindValue(':beginDate', $_SESSION['beginDate'], PDO::PARAM_STR);
          $incomeSummaryQuery->bindValue(':endDate', $_SESSION['endDate'], PDO::PARAM_STR);
          $incomeSummaryQuery->execute();

          $results = $incomeSummaryQuery->fetchAll();
          $howMany = $incomeSummaryQuery->rowCount();

          $oddOrEven = true;
          $incomeCategoriesSum = 0;
          foreach ($results as $result) {
            if ($oddOrEven) {
              echo '<tr class="even-row"><td class="icategory">' . $result['name'] . '</td><td class="icategory-amount">' . $result['amountSum'] . '</td></tr>';
              $oddOrEven = false;
              $incomeCategoriesSum += $result['amountSum'];
            } else {
              echo '<tr class="odd-row"><td class="icategory">' . $result['name'] . '</td><td class="icategory-amount">' . $result['amountSum'] . '</td></tr>';
              $oddOrEven = true;
              $incomeCategoriesSum += $result['amountSum'];
            }
          }
          if ($oddOrEven) {
            echo '<tr class="even-row"><td>Suma</td><td>' . $incomeCategoriesSum . '</td></tr>';
          } else {
            echo '<tr class="odd-row col-title"><td>Suma</td><td>' . $incomeCategoriesSum . '</td></tr>';
          }
          ?>
        </table>
      </div>
      <div class="text-center">
        <h2>Tabela Wydatków</h2>
        <table class="table table-hover">
          <tr class="odd-row col-title">
            <td>Kategoria</td>
            <td>Kwota (PLN)</td>
          </tr>
          <?php
          require_once 'connect.php';
          $expenseSummaryQuery = $db->prepare('SELECT name, SUM(amount) AS amountSum FROM expenses
INNER JOIN expenses_category_assigned_to_users ON expenses_category_assigned_to_users.id=expenses.expense_category_assigned_to_user_id
WHERE expenses.user_id = :loggedUserId AND expenses.date_of_expense BETWEEN :beginDate AND :endDate
GROUP BY name
ORDER BY amountSUM DESC');
          $expenseSummaryQuery->bindValue(':loggedUserId', $_SESSION['loggedUserId'], PDO::PARAM_INT);
          $expenseSummaryQuery->bindValue(':beginDate', $_SESSION['beginDate'], PDO::PARAM_STR);
          $expenseSummaryQuery->bindValue(':endDate', $_SESSION['endDate'], PDO::PARAM_STR);
          $expenseSummaryQuery->execute();

          $results = $expenseSummaryQuery->fetchAll();
          $howMany = $expenseSummaryQuery->rowCount();

          $oddOrEven = true;
          $expenseCategoriesSum = 0;
          foreach ($results as $result) {
            if ($oddOrEven) {
              echo '<tr class="even-row"><td class="ecategory">' . $result['name'] . '</td><td class="ecategory-amount">' . $result['amountSum'] . '</td></tr>';
              $oddOrEven = false;
              $expenseCategoriesSum += $result['amountSum'];
            } else {
              echo '<tr class="odd-row"><td class="ecategory">' . $result['name'] . '</td><td class="ecategory-amount">' . $result['amountSum'] . '</td></tr>';
              $oddOrEven = true;
              $expenseCategoriesSum += $result['amountSum'];
            }
          }
          if ($oddOrEven) {
            echo '<tr class="even-row col-title"><td>Suma</td><td>' . $expenseCategoriesSum . '</td></tr>';
          } else {
            echo '<tr class="odd-row col-title"><td>Suma</td><td>' . $expenseCategoriesSum . '</td></tr>';
          }
          $finalBalance = $incomeCategoriesSum - $expenseCategoriesSum;
          ?>
        </table>
        <div class="table"></div>
      </div>
    </div>

    <div class="container text-center py-5">
      <h6>
        Twój bilans wynosi <?php echo $finalBalance; ?> PLN!
        <?php
        if ($finalBalance >= 0) {
          echo 'Gratulacje! Doskonale zarządzasz swoimi finansami!';
        } else {
          echo 'Musisz popracować nad zarządzaniem finansami';
        }
        ?>

      </h6>
    </div>
  </main>

  <hr />
  <aside>
    <div class="container chart d-flex justify-content-center">
      <canvas id="incomesChart" style="width:100%;max-width:700px"></canvas>
      <canvas id="expensesChart" style="width:100%;max-width:700px"></canvas>
      <script>
        const barColors = ["red", "green", "blue", "orange", "brown"];
        const incomeCategories = document.querySelectorAll("td.icategory");
        const incomeAmounts = document.querySelectorAll("td.icategory-amount");
        const incomeLength = incomeCategories.length;
        var incomeNames = []; 
        var incomeValues = [];
        var singleIncomeName = 0
        var singleIncomeValue = 0;
        for (var i = 0; i < incomeLength; i++) {
          var singleIncomeName =incomeCategories[i].textContent;
          var singleIncomeValue =incomeAmounts[i].textContent;
          incomeNames.push(singleIncomeName);
          incomeValues.push(singleIncomeValue);
        }
        
        const expenseCategories = document.querySelectorAll("td.ecategory");
        const expenseAmounts = document.querySelectorAll("td.ecategory-amount");
        const expenseLength = expenseCategories.length;
        var expenseNames = []; 
        var expenseValues = [];
        var singleExpenseName = 0
        var singleExpenseValue = 0;
        for (var i = 0; i < expenseLength; i++) {
          var singleExpenseName =expenseCategories[i].textContent;
          var singleExpenseValue =expenseAmounts[i].textContent;
          expenseNames.push(singleExpenseName);
          expenseValues.push(singleExpenseValue);
        }

        new Chart("incomesChart", {
          type: "pie",
          data: {
            labels: incomeNames,
            datasets: [{
              backgroundColor: barColors,
              data: incomeValues
            }]
          },
          options: {
            title: {
              display: true,
              text: "Twoje przychody"
            }
          }
        })
        
        new Chart("expensesChart", {
          type: "pie",
          data: {
            labels: expenseNames,
            datasets: [{
              backgroundColor: barColors,
              data: expenseValues
            }]
          },
          options: {
            title: {
              display: true,
              text: "Twoje wydatki"
            }
          }
        })
        ;</script>
    </div>
  </aside>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js">
  </script>
</body>

</html>