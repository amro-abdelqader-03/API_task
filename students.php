<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Students List</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #f4f6f9;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            margin-top: 20px;
        }

        th,
        td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #222;
            color: white;
        }

        tr:nth-child(even) {
            background: #f2f2f2;
        }

        #delete-button {
            text-align: center;
            background-color: red;
            color: #ddd;
        }

        #message {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <h1>Students Management</h1>

    <p id="message">Loading students...</p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Course</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody id="studentsTable">
        </tbody>
    </table>

    <script>
        const apiURL = "http://localhost/student-api/index.php";

        async function loadStudents() {
            const message = document.getElementById("message");
            const tableBody = document.getElementById("studentsTable");

            try {
                const response = await fetch(apiURL);

                const result = await response.json();

                if (!response.ok || !result.success) {
                    throw new Error(
                        result.message || "Failed to load students"
                    );
                }

                tableBody.replaceChildren();

                if (result.data.length === 0) {
                    message.textContent = "No students found.";
                    return;
                }

                result.data.forEach(student => {
                    const row = document.createElement("tr");

                    const values = [
                        student.id,
                        student.name,
                        student.email,
                        student.course,
                        student.created_at
                    ];

                    values.forEach(value => {
                        const cell = document.createElement("td");

                        // Use textContent to safely display API data
                        cell.textContent = value ?? "";

                        row.appendChild(cell);
                    });
                    // Create a table cell to hold the action buttons
                    const actionCell = document.createElement("td");

                    // Create Edit Button
                    const editButton = document.createElement("button");
                    editButton.textContent = "Edit";
                    editButton.name = "edit";
                    editButton.className = "edit-button";
                    editButton.onclick = () => {
                        // Add your edit logic here
                    };

                    // Create Delete Button
                    const deleteButton = document.createElement("button");
                    deleteButton.textContent = "Delete";
                    deleteButton.name = "delete";
                    deleteButton.className = "delete-button";
                    deleteButton.onclick = () => {
                        // Add your delete logic here
                    };

                    // Append buttons to the action cell
                    actionCell.appendChild(editButton);
                    actionCell.appendChild(deleteButton);

                    deleteButton.addEventListener("click", async (event) => {
                        event.preventDefault()

                        try: {
                            await fetch("http://localhost/student-api/index.php?id=${student.id}", {
                                method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json',
                                }
                            });

                        }catch (e) {

                        }
                    })

                    // Append the action cell to the row
                    row.appendChild(actionCell);

                    // Append the row to the table body
                    tableBody.appendChild(row);
                });

                message.textContent =
                    `Total students: ${result.count}`;

            } catch (error) {
                message.textContent =
                    "Error loading students: " + error.message;

                console.error(error);
            }
        }

        loadStudents();
    </script>

</body>

</html>