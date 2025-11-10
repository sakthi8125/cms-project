-- Create database
CREATE DATABASE IF NOT EXISTS complaint_db;
USE complaint_db;

-- Create complaints table
CREATE TABLE IF NOT EXISTS complaints (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    category VARCHAR(50) NOT NULL,
    subject VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    status ENUM('Open','Resolved') DEFAULT 'Open',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert sample data
INSERT INTO complaints (name, email, phone, category, subject, description) VALUES
('John Doe', 'john@example.com', '1234567890', 'Technical', 'Website not loading', 'The homepage is not loading properly on Chrome browser.'),
('Jane Smith', 'jane@example.com', '9876543210', 'Billing', 'Incorrect charge', 'I was charged twice for my last purchase.'),
('Mike Johnson', 'mike@example.com', '5551234567', 'Service', 'Poor customer service', 'The support agent was rude and unhelpful.');

-- Create admin user (optional - for future authentication)
CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Insert default admin (username: admin, password: admin123)
INSERT INTO admin_users (username, password) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');