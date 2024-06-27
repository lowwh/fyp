<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="wrapper">
        <div class="content">
            <!-- Your main content goes here -->
        </div>
        <footer class="main-footer">
            <strong>Copyright &copy; PLATFORM FOR INDEPENDENT CONTRACTOR COMMUNITIES {{ date('Y') }}</strong> All rights
            reserved.
        </footer>
    </div>
</body>

</html>

<style>
    html,
    body {
        height: 100%;
        margin: 0;
    }

    .wrapper {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    .content {
        flex: 1;
    }

    /* Footer styling */
    .main-footer {
        background-color: #f8f9fa;
        /* Example background color */
        text-align: center;
        padding: 1em;
    }
</style>