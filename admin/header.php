<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  <style>
    .row.content {height: 1500px}
    .sidenav {
      background-color: #f1f1f1;
      height: 100%;
    }
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height: auto;} 
    }
    .avatar {
      vertical-align: middle;
      width: 50px;
      height: 50px;
      border-radius: 50%;
    }
    #studentTable {
     
      margin-top: 20px;
    }
    
  </style>
  <script>
    $(document).ready(function() {
      $("#studentList").click(function() {
        $("#studentTable").toggle(); // Toggle the visibility of the table
      });
    });
  </script>
</head>
<body>
<div class="container-fluid">
  <div class="row content">
    <div class="col-sm-3 sidenav">
      <h4>Teacher Corner</h4>
      <ul class="nav nav-pills nav-stacked">
        <li class="active"><a href="#section1">Home</a></li>
      
        <li><a href="logout.php">Logout</a></li>
      </ul><br>
    </div>