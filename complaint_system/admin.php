<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Complaint System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo">Complaint Management System</div>
                <nav class="nav-links">
                    <a href="index.php">Submit Complaint</a>
                    <a href="admin.php" style="background-color: rgba(255,255,255,0.2);">Admin Dashboard</a>
                </nav>
            </div>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="dashboard-header">
                <h1>Complaints Dashboard</h1>
                <div class="controls">
                    <input type="text" id="searchInput" placeholder="Search complaints...">
                    <select id="statusFilter">
                        <option value="">All Status</option>
                        <option value="Open">Open</option>
                        <option value="Resolved">Resolved</option>
                    </select>
                    <select id="sortSelect">
                        <option value="newest">Newest First</option>
                        <option value="oldest">Oldest First</option>
                    </select>
                    <button class="btn" onclick="exportToCSV()">Export CSV</button>
                </div>
            </div>

            <div class="table-container">
                <table class="complaints-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Category</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="complaintsTableBody">
                        <tr>
                            <td colspan="9" style="text-align: center; padding: 2rem;">
                                Loading complaints...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="pagination" id="pagination"></div>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 Complaint Management System. All rights reserved.</p>
        </div>
    </footer>

    <div class="toast-container" id="toastContainer"></div>

    <script>
        let currentPage = 1;
        const itemsPerPage = 10;
        let currentSort = 'newest';
        let currentSearch = '';
        let currentStatus = '';

        // Load complaints when page loads
        document.addEventListener('DOMContentLoaded', function() {
            loadComplaints();
            
            document.getElementById('searchInput').addEventListener('input', function() {
                currentSearch = this.value;
                currentPage = 1;
                loadComplaints();
            });
            
            document.getElementById('statusFilter').addEventListener('change', function() {
                currentStatus = this.value;
                currentPage = 1;
                loadComplaints();
            });
            
            document.getElementById('sortSelect').addEventListener('change', function() {
                currentSort = this.value;
                currentPage = 1;
                loadComplaints();
            });
        });

        function loadComplaints() {
            const params = new URLSearchParams({
                page: currentPage,
                limit: itemsPerPage,
                search: currentSearch,
                status: currentStatus,
                sort: currentSort
            });
            
            fetch(`get_complaints.php?${params}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayComplaints(data.complaints);
                        setupPagination(data.totalPages);
                    } else {
                        showToast('Error loading complaints', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Network error loading complaints', 'error');
                });
        }

        function displayComplaints(complaints) {
            const tableBody = document.getElementById('complaintsTableBody');
            
            if (complaints.length === 0) {
                tableBody.innerHTML = '<tr><td colspan="9" style="text-align: center; padding: 2rem;">No complaints found</td></tr>';
                return;
            }
            
            tableBody.innerHTML = complaints.map(complaint => `
                <tr>
                    <td>${complaint.id}</td>
                    <td>${complaint.name}</td>
                    <td>${complaint.email}</td>
                    <td>${complaint.phone}</td>
                    <td>${complaint.category}</td>
                    <td>${complaint.subject}</td>
                    <td>
                        <span class="status-${complaint.status.toLowerCase()}">
                            ${complaint.status}
                        </span>
                    </td>
                    <td>${new Date(complaint.created_at).toLocaleDateString()}</td>
                    <td>
                        <div class="action-buttons">
                            ${complaint.status === 'Open' ? 
                                `<button class="action-btn btn-resolve" onclick="updateStatus(${complaint.id}, 'Resolved')">Resolve</button>` :
                                `<button class="action-btn btn-open" onclick="updateStatus(${complaint.id}, 'Open')">Reopen</button>`
                            }
                            <button class="action-btn btn-delete" onclick="deleteComplaint(${complaint.id})">Delete</button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        function setupPagination(totalPages) {
            const pagination = document.getElementById('pagination');
            
            if (totalPages <= 1) {
                pagination.innerHTML = '';
                return;
            }
            
            let paginationHTML = `
                <button onclick="changePage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''}>
                    Previous
                </button>
                <span>Page ${currentPage} of ${totalPages}</span>
                <button onclick="changePage(${currentPage + 1})" ${currentPage === totalPages ? 'disabled' : ''}>
                    Next
                </button>
            `;
            
            pagination.innerHTML = paginationHTML;
        }

        function changePage(page) {
            currentPage = page;
            loadComplaints();
        }

        function updateStatus(complaintId, newStatus) {
            if (!confirm(`Are you sure you want to mark this complaint as ${newStatus}?`)) {
                return;
            }
            
            fetch('update_status.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    id: complaintId,
                    status: newStatus
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast(`Complaint marked as ${newStatus}`, 'success');
                    loadComplaints();
                } else {
                    showToast('Error updating status', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Network error', 'error');
            });
        }

        function deleteComplaint(complaintId) {
            if (!confirm('Are you sure you want to delete this complaint? This action cannot be undone.')) {
                return;
            }
            
            fetch('delete_complaint.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ id: complaintId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('Complaint deleted successfully', 'success');
                    loadComplaints();
                } else {
                    showToast('Error deleting complaint', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Network error', 'error');
            });
        }

        function exportToCSV() {
            window.open('export_csv.php', '_blank');
        }

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