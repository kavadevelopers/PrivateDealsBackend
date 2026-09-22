"use strict";
function setSectorNumberChart(sectorData) {
  var ctx = document.getElementById("kycNonKycChart").getContext("2d");

  new Chart(ctx, {
    type: "doughnut",
    data: {
      labels: sectorData.map((sector) => sector.name),
      datasets: [
        {
          label: "My First Dataset",
          data: sectorData.map((sector) => sector.total_investment),
          backgroundColor: getRandomColorCodes(
            sectorData.map((sector) => sector.name).length
          ),
          hoverOffset: 4,
        },
      ],
    },
    options: {
      plugins: {
        legend: {
          display: false,
        },
      },
      onClick: function (e, activeEls) {
        if (activeEls.length > 0) {
          let datasetIndex = activeEls[0].datasetIndex;
          let dataIndex = activeEls[0].index;
          // console.log("In click", datasetLabel, label, value,sectorData.ids[dataIndex]);

          console.log(
            "In click",
            sectorData.map((sector) => sector.startups)[dataIndex]
          );
        }
      },
    },
  });
}
