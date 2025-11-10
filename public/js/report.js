document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('report-data-container');
    if (!container) return;

    const labels = JSON.parse(container.dataset.labels);
    const revenue = JSON.parse(container.dataset.revenue);
    const productNames = JSON.parse(container.dataset.products);
    const productSales = JSON.parse(container.dataset.sales);

    // === Biểu đồ Doanh thu ===
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Doanh thu (VNĐ)',
                data: revenue,
                borderWidth: 2,
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.3)',
                fill: true,
                tension: 0.3,
                pointRadius: 5,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                title: { display: true, text: 'Doanh thu theo ngày (Đơn hoàn thành)' }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: value => value.toLocaleString() + ' đ'
                    }
                }
            }
        }
    });

    // === Biểu đồ Top 5 sản phẩm bán chạy (biểu đồ tròn) ===
    const topProductsCtx = document.getElementById('topProductsChart').getContext('2d');
    new Chart(topProductsCtx, {
        type: 'doughnut', // hoặc 'pie' nếu bạn muốn hình tròn đặc
        data: {
            labels: productNames,
            datasets: [{
                label: 'Tỷ lệ bán (%)',
                data: productSales,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(153, 102, 255, 0.7)'
                ],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Tỷ lệ đóng góp doanh số - Top 5 sản phẩm'
                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            const total = context.chart._metasets[0].total;
                            const value = context.parsed;
                            const percentage = ((value / total) * 100).toFixed(1);
                            return `${context.label}: ${value} sản phẩm (${percentage}%)`;
                        }
                    }
                },
                legend: {
                    position: 'right',
                    labels: { boxWidth: 20 }
                }
            }
        }
    });

    // === Xử lý form lọc từ ngày → đến ngày ===
    const filterForm = document.getElementById('filterForm');
    if (filterForm) {
        filterForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const start = document.getElementById('startDate').value;
            const end = document.getElementById('endDate').value;

            // Reload page với query params để controller lọc dữ liệu
            window.location.href = `?start=${start}&end=${end}`;
        });
    }
});
