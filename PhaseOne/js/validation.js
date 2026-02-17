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

// red border + error message
function showError(field, message) {
    field.classList.add('is-invalid');          

    const feedback = document.createElement('div');
    feedback.className = 'invalid-feedback';     
    feedback.textContent = message;
    field.parentNode.appendChild(feedback);
}

// gets rid of red 
function clearErrors() {
    //removes invald from fields
    document.querySelectorAll('.is-invalid').forEach(el => {
        el.classList.remove('is-invalid');
    });
    //removes errors
    document.querySelectorAll('.invalid-feedback').forEach(el => {
        el.remove();
    });
}

//delete confimation
function confirmDelete() {
    return confirm('Are you sure you want to delete this task?\nThis cannot be undone.');
}