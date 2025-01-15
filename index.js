var barColors = ["red", "green","blue","orange","brown", "yellow", "pink"];
var incomeCategoriesFromTable = document.querySelectorAll("td.icategory")
var incomeAmountsFromTable = document.querySelectorAll("td.icategory-amount");

var expenseCategoriesFromTable = document.querySelectorAll("td.ecategory");
var expenseAmountsFromTable = document.querySelectorAll("td.ecategory-amount");

new Chart("incomesChart", {
  type: "pie",
  data: {
    labels: incomeAmountsFromTable,
    datasets: [{
      backgroundColor: barColors,
      data: incomeAmountsFromTable
    }]
  },
  options: {
    title: {
      display: true,
      text: "Twoje Przychody"
    }
  }
});

new Chart("expensesChart", {
  type: "pie",
  data: {
    labels: expenseCategoriesFromTable,
    datasets: [{
      backgroundColor: barColors,
      data: expenseAmountsFromTable
    }]
  },
  options: {
    title: {
      display: true,
      text: "Twoje Wydatki"
    }
  }
});

