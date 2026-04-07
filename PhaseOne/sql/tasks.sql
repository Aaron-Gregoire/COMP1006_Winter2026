CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    task_name VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    priority VARCHAR(10) NOT NULL,
    due_date DATE NOT NULL,
    time_spent DECIMAL(5,2) NOT NULL,
    user_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

