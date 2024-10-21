<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tailwebs";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert or Update student if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['studentName'];
    $subject = $_POST['studentSubject'];
    $marks = $_POST['studentMarks'];

    // Check if a student with the same name and subject already exists
    $checkQuery = "SELECT id FROM students WHERE name = ? AND subject = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("ss", $name, $subject);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Student exists, update the marks
        $updateQuery = "UPDATE students SET marks = ? WHERE name = ? AND subject = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("iss", $marks, $name, $subject);  // Update marks
        if ($updateStmt->execute()) {
          //  toastr.success('Marks updated successfully!');
        } else {
          //  toastr.error('Error updating marks.');
        }
        $updateStmt->close();
    } else {
        // Student does not exist, insert new record
        $insertQuery = "INSERT INTO students (name, subject, marks) VALUES (?, ?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param("ssi", $name, $subject, $marks);
        if ($insertStmt->execute()) {
           // toastr.success('New student added successfully!');
        } else {
           // toastr.error('Error adding new student.');
        }
        $insertStmt->close();
    }
    $stmt->close();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Fetch students from the database
$result = $conn->query("SELECT * FROM students");
if (!$result) {
    die("Error fetching students: " . $conn->error);
}
?>

<!-- Rest of the HTML Code -->




<?php include('header.php'); ?>
<body>

<div class="container-fluid">
  <div class="col-sm-9">
    <div class="text-right" style="margin-bottom: 20px;">
      <img src="img/img_avatar.png" alt="Avatar" class="avatar">
    </div>

    <hr>

    <div id="studentTable">
      <h4>Student List</h4>
      <table id="studentsDataTable" class="table table-bordered">
        <thead>
          <tr>
            <th>Name</th>
            <th>Subject</th>
            <th>Marks</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="studentBody">
          <?php
          if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  echo "<tr data-id='{$row['id']}'>
                          <td class='name'>{$row['name']}</td>
                          <td class='subject'>{$row['subject']}</td>
                          <td class='marks'>{$row['marks']}</td>
                          <td>
                            <button class='btn btn-warning btn-sm editStudent'>Edit</button>
                            <button class='btn btn-danger btn-sm deleteStudent'>Delete</button>
                          </td>
                        </tr>";
              }
          } else {
              echo "<tr><td colspan='4'>No students found</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>

    <button class="btn btn-primary" data-toggle="modal" data-target="#addStudentModal">Add Student</button>
  </div>

  <!-- Modal for Adding Student -->
  <div class="modal fade" id="addStudentModal" tabindex="-1" role="dialog" aria-labelledby="addStudentModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="addStudentModalLabel">Add Student</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="addStudentForm" method="POST" action="">
            <div class="form-group">
              <label for="studentName">Name</label>
              <input type="text" class="form-control" name="studentName" required>
            </div>
            <div class="form-group">
              <label for="studentSubject">Subject</label>
              <input type="text" class="form-control" name="studentSubject" required>
            </div>
            <div class="form-group">
              <label for="studentMarks">Marks</label>
              <input type="text" class="form-control" name="studentMarks" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Student</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Delete Confirmation Modal -->
  <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="deleteModalLabel">Confirm Deletion</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete this student?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
        </div>
      </div>
    </div>
  </div>

</div>

<footer class="container-fluid">
  <p>Footer Text</p>
</footer>

<!-- Include jQuery and DataTables JS & CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
<!-- Initialize DataTable -->
$(document).ready(function() {
    // DataTable initialization
    $('#studentsDataTable').DataTable();

    // Handle Edit functionality
    $(document).on('click', '.editStudent', function() {
        var row = $(this).closest('tr');
        var nameCell = row.find('.name');
        var subjectCell = row.find('.subject');
        var marksCell = row.find('.marks');

        // Convert the cells to input fields for editing
        nameCell.html('<input type="text" class="form-control editName" value="' + nameCell.text() + '">');
        subjectCell.html('<input type="text" class="form-control editSubject" value="' + subjectCell.text() + '">');
        marksCell.html('<input type="text" class="form-control editMarks" value="' + marksCell.text() + '">');

        // Change the button to a Save button
        $(this).removeClass('editStudent btn-warning').addClass('saveStudent btn-success').text('Save');
    });

    // Save updated values
    $(document).on('click', '.saveStudent', function() {
        var row = $(this).closest('tr');
        var name = row.find('.editName').val();
        var subject = row.find('.editSubject').val();
        var marks = row.find('.editMarks').val();

        // Update the cells with the new values
        row.find('.name').text(name);
        row.find('.subject').text(subject);
        row.find('.marks').text(marks);
        toastr.success('Student updated successfully!');
        // Change the button back to Edit
        $(this).removeClass('saveStudent btn-success').addClass('editStudent btn-warning').text('Edit');
    });

    // Handling Delete button click
    var studentIdToDelete = null;
    $(document).on('click', '.deleteStudent', function() {
        studentIdToDelete = $(this).closest('tr').data('id');
        $('#deleteModal').modal('show');
    });

    // Confirm Delete action
    $('#confirmDelete').click(function() {
        if (studentIdToDelete) {
            $.ajax({
                url: 'delete_student.php', // Your PHP script to delete the student
                type: 'POST',
                data: { id: studentIdToDelete }, // Sending the student ID
                success: function(response) {
                    if (response === 'success') {
                        // Remove the student row from the table
                        $('tr[data-id="' + studentIdToDelete + '"]').remove();
                        $('#deleteModal').modal('hide');
                        toastr.danger('Student  Record deleted successfully!');
                    } else {
                      toastr.error('Failed to delete student. Please try again.');
                    }
                },
                error: function() {
                  toastr.error('Error occurred while deleting student.');
                }
            });
        }
    });
});
</script>
</body>
</html>

<?php
$conn->close();
?>
