<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint Management System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo">Complaint Management System</div>
                <nav class="nav-links">
                    <a href="index.php">Submit Complaint</a>
                    <a href="admin.php">Admin Dashboard</a>
                </nav>
            </div>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="form-container">
                <h1 style="text-align: center; margin-bottom: 2rem; color: #333;">Submit Your Complaint</h1>
                
                <form id="complaintForm">
                    <div class="form-group">
                        <label for="name">Full Name *</label>
                        <input type="text" id="name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address *</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number *</label>
                        <input type="tel" id="phone" name="phone" required>
                    </div>

                    <div class="form-group">
                        <label for="category">Category *</label>
                        <select id="category" name="category" required>
                            <option value="">Select a category</option>
                            <option value="Technical">Technical Issue</option>
                            <option value="Billing">Billing Problem</option>
                            <option value="Service">Customer Service</option>
                            <option value="Product">Product Quality</option>
                            <option value="Delivery">Delivery Issue</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="subject">Subject *</label>
                        <input type="text" id="subject" name="subject" placeholder="Brief description of your complaint" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description *</label>
                        <textarea id="description" name="description" placeholder="Please provide detailed information about your complaint..." required></textarea>
                    </div>

                    <button type="submit" class="btn" style="width: 100%;">
                        Submit Complaint
                    </button>
                </form>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 Complaint Management System. All rights reserved.</p>
        </div>
    </footer>

    <div class="toast-container" id="toastContainer"></div>

    <script>
        // Form submission handling
        document.getElementById('complaintForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            
            // Show loading state
            submitBtn.innerHTML = 'Submitting...';
            submitBtn.disabled = true;
            
            fetch('submit_complaint.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showToast('Complaint submitted successfully!', 'success');
                    this.reset();
                } else {
                    showToast(data.message || 'Error submitting complaint', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Network error. Please try again.', 'error');
            })
            .finally(() => {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            });
        });

        function showToast(message, type = 'success') {
            const toastContainer = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;
            toast.textContent = message;
            
            toastContainer.appendChild(toast);
            
            setTimeout(() => {
                toast.remove();
            }, 5000);
        }
    </script>
</body>
</html>