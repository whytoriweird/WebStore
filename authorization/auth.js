document.addEventListener('DOMContentLoaded', () => {
    const messageBox = document.getElementById('messageBox');

    // Form switching
    const tabs = document.querySelectorAll('.tab');
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const formId = tab.dataset.form;
            
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            
            document.querySelectorAll('.form').forEach(form => {
                form.classList.remove('active');
            });
            document.getElementById(formId + 'Form').classList.add('active');
            
            // Clear messages
            messageBox.innerHTML = '';
        });
    });

    // Form submission
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const formData = new FormData(form);
            formData.append('ajax', true);

            try {
                const response = await fetch('auth.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();
                
                if (data.success) {
                    messageBox.innerHTML = `<div class="success">${data.success}</div>`;
                    if (form.id === 'loginForm') {
                        window.location.href = '../index.php';
                    }
                } else if (data.error) {
                    messageBox.innerHTML = `<div class="error">${data.error}</div>`;
                }
            } catch (error) {
                messageBox.innerHTML = '<div class="error">Помилка сервера</div>';
            }
        });
    });
});