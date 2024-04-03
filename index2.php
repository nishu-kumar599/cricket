<!DOCTYPE html>
<html lang="en">

<head>
    <?php require 'head.php'; ?>
    <style>
        /* Custom styling */

        .main-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .sports-news {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
        }

        h2 {
            color: #333;
            margin-bottom: 30px;
        }

        .options {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 20px;
        }

        .option {
            background-color: #fd1e50;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .option:hover {
            background-color: #d90c3f;
            color: #fff;
        }
    </style>
</head>

<body>
    <?php require 'header.php'; ?>
    <div class="main-content">
        <section style="margin-bottom: 20px" class="wf100 p80 sports-news">
            <h2>Cricket Association Registration</h2>
            <div class="options">
                <a href="club/register_club.php" class="option">Register as a Club</a>
                <a href="player/register_player.php" class="option">Register as a Player</a>
                <a href="club/login_club.php" class="option">Club Login</a>
                <a href="player/login_player.php" class="option">Player Login</a>
            </div>
        </section>
    </div>
    <?php require 'footer.php'; ?>
</body>

</html>