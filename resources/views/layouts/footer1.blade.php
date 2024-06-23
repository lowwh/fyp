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
        <main class="content">
            <!-- Your main content goes here -->
        </main>
        <footer class="main-footer">
            <div class="py-5 bg-dark">
                <div class="container">
                    <p class="m-0 text-center text-white" style="margin-bottom:auto">
                        Copyright &copy; PLATFORM FOR INDEPENDENT CONTRACTOR COMMUNITIES {{ date('Y') }}
                    </p>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>

<style>
    /* Ensure the body and html are full height */
    html,
    body {
        height: 100%;
        margin: 0;
    }

    /* Wrapper to use flexbox to stretch to full height */
    .wrapper {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    /* Content will take up the remaining space */
    .content {
        flex: 1;
    }

    /* Footer styles */
    .main-footer {
        background-color: #343a40;
        color: white;
        padding: 20px 0;
    }

    .main-footer .container p {
        margin-bottom: auto;
        text-align: center;
    }
</style>