import './bootstrap';
import '../css/app.css';

// CSS base do admin (reset + componentes)
import '../css/admin/app.css';

// CSS específico de cada view (dinamicamente pelo body class)
const bodyClass = document.body.dataset.page; // vamos definir data-page no Blade
if (bodyClass) {
    import(`../css/admin/views/${bodyClass}.css`);
}
