$(document).ready(function () {
    $.ajax({
        url: url(), // Replace with the actual path to your PHP script
        method: 'post',
        data:{
            fetchTop: "fetchTop"
        },
        dataType: 'json',
        success: function (data) {
            // alert(data)
            var productNames = [];
            var salesCounts = [];

            data.forEach(function (item) {
                productNames.push(item.item_name);
                salesCounts.push(item.frequency);
            });

            var ctx = document.getElementById('barChart').getContext('2d');
            var barChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: productNames,
                    datasets: [{
                        label: 'Sales Count',
                        data: salesCounts,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        },
        error: function (xhr, status, error) {
            // alert(error)
            console.error('Error: ' + error);
        }
    });
});