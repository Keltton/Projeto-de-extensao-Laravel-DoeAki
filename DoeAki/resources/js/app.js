import './bootstrap';
import Chart from 'chart.js/auto';

const ctx = document.getElementById('eventosChart');

// Estes códigos são apenas a base, quando tivermos tudo acertado é só ir importando os dados diretos do DB (não é TÃO dificil, mas pega um pouco).

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho'],
        datasets: [{
            label: 'Doações por mês',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
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

