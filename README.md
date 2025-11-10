# 🧩 Complaint Management System  
A simple web application to submit and manage complaints easily.  
This project was developed by **Sakthi**, a final-year **B.Sc. Computer Science with AI** student as part of a college mini/final-year project.  

---

## 📘 About the Project
The **Complaint Management System** is a web-based project that helps users register complaints online and allows the admin to manage them easily.  
It replaces manual paper work with a digital system that stores, tracks, and updates complaints in real time.

This project mainly focuses on **improving communication** between users and the admin through a simple and user-friendly interface.

---

## ⚙️ How the System Works

### 👩‍💻 User Side (index.php)
- The user opens the complaint form page.  
- Enters their **name**, **email**, and **complaint details**.  
- Once submitted, the data is stored in a **MySQL database** using PHP.

### 🧑‍💼 Admin Side (admin/index.php)
- The admin can **view all submitted complaints**.  
- Update the **status** (Pending / Resolved).  
- **Delete** unnecessary complaints.  
- **Export complaints** as a CSV file for records.

### 🔄 Real-Time Updates
- All updates (status changes, deletions) happen using **AJAX**, so there’s no page reload — the changes appear instantly.

---

## 💡 Key Features
- 📝 Complaint submission form  
- 👨‍💼 Admin dashboard  
- 🔄 Update complaint status  
- 🗑️ Delete or export data  
- ⚡ Fast and responsive interface  
- 💾 Data stored securely in MySQL  

---

## 🛠️ Technologies Used

| Part | Technology |
|------|-------------|
| Frontend | HTML5, CSS3, JavaScript |
| Backend | PHP (Core PHP) |
| Database | MySQL |
| Tools | XAMPP / WAMP |
| Others | AJAX, CSV Export |

---

## 🚀 How to Run the Project

### 🔹 Using XAMPP
1. Install **XAMPP** on your computer.  
2. Copy this project folder into:  
C:\xampp\htdocs\

markdown
Copy code
3. Open **phpMyAdmin** → Create a new database named `complaint_db`.  
4. Import the file `complaint_db.sql` (if included).  
5. Start **Apache** and **MySQL** in XAMPP.  
6. Open your browser and go to:  
http://localhost/Complaint_Management_System/

perl
Copy code

### 🔹 Using PHP Built-in Server (Optional)
If PHP is installed on your system, open the terminal in your project folder and type:
```bash
php -S localhost:8000
Then visit http://localhost:8000 in your browser.

📁 Folder Structure
bash
Copy code
Complaint_Management_System/
│
├── admin/               # Admin dashboard files
├── db/                  # Database connection file
├── styles/              # CSS styling
├── script.js            # Frontend script for AJAX
│
├── index.php            # User complaint form
├── submit_complaint.php # Save complaints
├── get_complaints.php   # Fetch data for admin
├── update_status.php    # Update status
├── delete_complaint.php # Delete a record
├── export_csv.php       # Export records
└── README.md            # Project documentation


👩‍🎓 Project Details
Project Title: Complaint Management System

Developed By: Sakthi

Course: B.Sc. Computer Science with AI

Year: Final Year

College: Sathyabama University

🏷️ License
This project is created for educational purposes.
You can use or modify it for learning and project submissions.

⭐ Support
If you like this project, please give it a ⭐ on GitHub — it will motivate me to build more projects! 💫
