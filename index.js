      // Load google charts
      google.charts.load("current", { packages: ["corechart"] });
      google.charts.setOnLoadCallback(drawChartIncome);
      google.charts.setOnLoadCallback(drawChartExpense);

        // Draw the chart and set the chart values
      function drawChartIncome() {
          var data = google.visualization.arrayToDataTable([
            ["Tytuł", "Kwota"],
            ["Wynagrodzenie", 4300],
            ["Odsetki bankowe", 50],
            ["Sprzedaż na allegro", 200],
          ]);

          // Optional; add a title and set the width and height of the chart
          var options = { title: "Przychody", width: 550, height: 400 };

          // Display the chart inside the <div> element with id="piechart"
          var chart = new google.visualization.PieChart(
            document.getElementById("income-piechart")
          );
          chart.draw(data, options);
        }

      function drawChartExpense() {
          var data = google.visualization.arrayToDataTable([
            ["Tytuł", "Kwota"],
            ["Jedzenie", 2000],
            ["Ubrania", 500],
            ["Mieszkanie", 1000],
          ]);

          // Optional; add a title and set the width and height of the chart
          var options = { title: "Wydatki", width: 550, height: 400 };

          // Display the chart inside the <div> element with id="piechart"
          var chart = new google.visualization.PieChart(
            document.getElementById("expense-piechart")
          );
          chart.draw(data, options);
        }