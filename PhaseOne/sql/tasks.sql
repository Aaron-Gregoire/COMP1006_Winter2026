CREATE TABLE tasks (
    id          INT AUTO_INCREMENT PRIMARY KEY, --unique task ids
    task_name   VARCHAR(255)  NOT NULL, -- name of task
    category    VARCHAR(100)  NOT NULL, -- school, work, chores just any type of task
    priority    VARCHAR(10)   NOT NULL, -- high medium or low
    due_date    DATE          NOT NULL, -- self explanitory
    time_spent  DECIMAL(5,2)  NOT NULL, -- hours spent on task
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- it auto sets the time created when a task is inserted into the db
);