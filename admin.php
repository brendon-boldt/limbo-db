<head>
<title>Limbo - Admin</title>
<link rel="stylesheet" type="text/css" href="limbo.css">
</head>
<?php include 'header.html' ?>

<div id='content'>
<h1>Admin Login</h1>

  <form id='loginForm' action='admin.php' method='POST'>
  <table id="formTable">
    <tr>
      <td>
       	Username 
      </td>
      <td>
        <input type="text" name="username" placeholder="Username"/ required>
      </td>
    </tr>
    <tr>
      <td>
      	Password
      </td>
      <td>
        <input type="text" name="password" placeholder="Password"/ required>
      </td>
    </tr>

    <tr>
      <td>
      </td>
      <td>
        <input type="submit" value="Login" />
      </td>
    </tr>
  </table>
  </form>
</div>



<?php include 'footer.html' ?>
