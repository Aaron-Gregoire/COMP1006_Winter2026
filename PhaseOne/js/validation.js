//client side validation, give errors for wrong fields, asks to confirm before task deletion


//validates when user clicks save or add
function validateTaskForm() {
    let isValid = true;

    //remove old errors
    clearErrors();

    //check name field
    const taskName = document.getElementById('task_name');
    if (!taskName.value.trim()) {
        showError(taskName, 'Task name is required.');
        isValid = false;
    }

    //check category field
    const category = document.getElementById('category');
    if (!category.value.trim()) {
        showError(category, 'Category is required.');
        isValid = false;
    }

    //check prio
    const priority = document.getElementById('priority');
    if (!priority.value) {
        showError(priority, 'Please select a priority level.');
        isValid = false;
    }

    //check due date
    const dueDate = document.getElementById('due_date');
    if (!dueDate.value) {
        showError(dueDate, 'Due date is required.');
        isValid = false;
    }

    //check time spent
    const timeSpent = document.getElementById('time_spent');
    const timeValue = parseFloat(timeSpent.value);
    if (!timeSpent.value || isNaN(timeValue)) {
        showError(timeSpent, 'Time spent is required.');
        isValid = false;
    } else if (timeValue < 0) {
        showError(timeSpent, 'Time spent cannot be negative.');
        isValid = false;
    }

    //returns if form is valid
    return isValid;
}
//registration and profile.php
function validateRegisterForm() {
    let isValid = true;
    clearErrors();

    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');

    if (!email || !email.value.trim()) {
        showError(email, 'email is required.');
        isValid = false;
    }
    if (!password || password.value.length < 8) {
        showError(password, 'password must be at least 8 characters');
        isValid = false;
    }
    if (!confirmPassword || confirmPassword.value !== password.value) {
        showError(confirmPassword, 'passwords do not match');
        isValid = false;
    }
    return isValid;
}

function validateChangePassword() {
    const newPass = document.getElementById('new_password').value;
    const confirmPass = document.getElementById('confirm_password').value;

    if (newPass.length < 8) {
        alert("new password must be at least 8 characters");
        return false;
    }
    if (newPass !== confirmPass) {
        alert("new passwords do not match");
        return false;
    }
    return true;
}

function showError(field, message) {
    if (!field) return;
    field.classList.add('is-invalid');
    let feedback = field.parentNode.querySelector('.invalid-feedback');
    if (feedback) feedback.remove();
    feedback = document.createElement('div');
    feedback.className = 'invalid-feedback';
    feedback.textContent = message;
    field.parentNode.appendChild(feedback);
}

function clearErrors() {
    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    document.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
}

function confirmDelete() {
    return confirm('are you sure you want to delete this task?\nthis cannot be undone');
}

function confirmDeleteAccount() {
    return confirm('are you sure you want to delete your account?\nthis will permanently delete your account and ALL your tasks.');
}

