<html lang="en">

<head>
  <title>Notes</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">
  <link href="/public/styles.css" rel="stylesheet">
</head>

<body class="body">
  <div class="wrapper">
    <div class="header">
      <h1><i class="far fa-clipboard"></i>My Notes</h1>
    </div>

    <div class="container">
      <div class="menu">
        <ul>
          <li><a href="/">Home Page</a></li>
          <li><a href="/?action=create">New Note</a></li>
        </ul>
      </div>

      <div class="page">
        <?php require_once("templates/pages/$page.php"); ?>
      </div>
    </div>

    <div class="footer">
      <p>Notes - project PHP</p>
    </div>
  </div>
</body>

</html>