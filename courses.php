﻿<!DOCTYPE html>
<?php
session_start();
if (!isset($_SESSION["name"])) {
    header("Location: index.php?error=none");
}else {
include_once "classes/db.classes.php";
include_once "classes/user.classes.php";
$user = new User();
if(isset($_SESSION['lesson_id'])){
    $lesson_id = $_SESSION['lesson_id'];
}else{
    $lesson_id = 1;
}
?>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" charset="utf-8"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="css/styles.css" />

    <title></title>
    <style>
        .open-button {
            background-color: #555;
            color: white;
            padding: 12px 12px;
            border: none;
            cursor: pointer;
            opacity: 0.8;
            position: fixed;
            bottom: 23px;
            right: 28px;
            width: 280px;
        }

        /* The popup chat - hidden by default */
        .chat-popup {
        color: white;
            display: none;
            position: fixed;
            bottom: 0;
            right: 15px;
            border: 3px solid #f1f1f1;
            z-index: 9;
        }

        /* Add styles to the form container */
        .form-container {

            max-width: 300px;
            padding: 10px;
            background-color: black;
        }

        /* Full-width textarea */
        .form-container textarea {
            width: 100%;
            padding: 15px;
            margin: 5px 0 22px 0;
            border: none;
            background: #f1f1f1;
            resize: none;
            min-height: 200px;
        }

        /* When the textarea gets focus, do something */
        .form-container textarea:focus {
            background-color: #ddd;
            outline: none;
        }

        /* Set a style for the submit/send button */
        .form-container .btn {
            background-color: #04AA6D;
            color: white;
            padding: 16px 20px;
            border: none;
            cursor: pointer;
            width: 100%;
            margin-bottom:10px;
            opacity: 0.8;
        }

        /* Add a red background color to the cancel button */
        .form-container .cancel {
            background-color: red;
        }

        /* Add some hover effects to buttons */
        .form-container .btn:hover, .open-button:hover {
            opacity: 1;
        }
    </style>
</head>
<body>
<!--Preloader start-->



<!--Preloader end-->

<header class="header">
    <div class="header__container">


        <a href="index.php" class="header__logo">CRYPTO</a>

        <div class="header__search">

        </div>
        <a  href="account.php" style="text-decoration:none;">Go to User Page</a>
        <div class="header__toggle">
            <i class="fas fa-bars"id="header-toggle"></i>

        </div>
    </div>
</header>

<!--========== NAV ==========-->
<div class="nav" id="navbar">
    <nav class="nav__container">
        <div>
            <a href="index.php" class="nav__link nav__logo">
                <i class='bx bx-bitcoin' ></i>
                <span class="nav__logo-name">CRYPTO</span>
            </a>
            <div class="nav__list">
                <div class="nav__items">
                    <a href="index.php" class="nav__link active">
                        <i class="fas fa-home"></i>
                        <span class="nav__name">Home</span>
                    </a>
                </div>
                <?php
                $result = $user->Get_All_Sections_Lessons();
                $sl = $result[0];
                $sql = $result[1];
                $current_section = '';
                for($i = 0; $i < $sql->rowCount(); $i++){

                    if ($sl[$i]['section_title'] != $current_section) {
                        echo '<div class="nav__link active">';
                        echo '<i class="fa fa-caret-down"></i><span class="nav__name">'.$sl[$i]['section_title'].'</span></div>';
                        $current_section = $sl[$i]['section_title'];


                    }
                    echo '<a href="parts/lesson_redirect.php?lesson_id='.$sl[$i]['lesson_id'].'" class="nav__dropdown-item" id="les1-1"> <i class="fa fa-long-arrow-right"></i> '.$sl[$i]['lesson_title'].'</a>';
                }
                ?>
                <a href="contact.php" class="nav__link active">
                    <i class="fas fa-phone"></i>
                    <span class="nav__name">Contact us</span>
                </a>
                <a href="notes.php" class="nav__link active">
                    <i class="fas fa-pencil"></i>
                    <span class="nav__name">Notes</span>
                </a>
                <a href="includes/logout.inc.php" class="nav__link nav__logout">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="nav__name">Log Out</span>
                </a>
    </nav>
</div>

<!--========== CONTENTS ==========-->
<main>
    <section>
        <div class="videoWrapper">
            <!-- Copy & Pasted from YouTube -->
            <?php
            if(isset($_SESSION['video_link'])){
                echo '<iframe width="560" height="315" src="'.$_SESSION['video_link'].'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="ifr"></iframe>';
            }else{
                echo '<iframe width="560" height="315" src="https://www.youtube.com/embed/AMcXbvZuLrg" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="ifr"></iframe>';
            }
            ?>
        </div>
    </section>
    <button class="open-button" onclick="openForm()">Add Notes</button>

    <div class="chat-popup" id="myForm">
        <form action="includes/notes.inc.php" method="post" class="form-container">
            <h3>Add Notes</h3>
            <input type="hidden" name="add_note">
            <input type="hidden" name="add_note_main">
            <?php
            echo '<input type="hidden" name="lesson_id" value = "'.$lesson_id.'">';
            echo '<input type="hidden" name="user_id" value="'.$_SESSION["id"].'">';
            ?>
            <input type="text" name="title_note" placeholder="Title">
                <br>
            <textarea placeholder="Your note" name="note_text" required></textarea>

            <button type="submit" class="btn">Add</button>
            <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
        </form>
    </div>
    <div class="lesson-overview">
        <div class="overview">
            <p>Overview</p>
        </div>
        <div class="description"><p>About this lesson</p></div>
        <?php
        if(isset($_SESSION['lesson_description'])){
            echo '<div class="description-p"><p>'.$_SESSION['lesson_description'].'</p></div>';
        }else{
            echo '<div class="description-p"><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Natus ut voluptate deserunt maxime aliquid ullam ducimus, provident doloribus aspernatur assumenda atque odit! Nemo repellat nisi dolorem ipsum unde tempore, tempora ducimus placeat aspernatur voluptatem laborum, odit quam. Consequatur, perspiciatis nulla quia porro corrupti voluptates adipisci laboriosam consequuntur neque earum? Veniam?</p></div>';
        }
        ?>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-5 col-md-6 col-12 pb-4">
                    <h1>Comments</h1>

                    <?php

                    $comments = $user->Get_Comments($lesson_id);
                    $comment = $comments[0];
                    $sql = $comments[1];
                    if($sql->rowCount()==0){
                        echo '<div class="comment mt-4 text-justify">';
                        echo '<h4>Be first to leave a comment!</h4>';
                        echo '</div>';
                    }else{
                        for($i = 0; $i < $sql->rowCount(); $i++){
                            echo '<div class="comment mt-4 text-justify"> ';
                            echo '<h4>'. $comment[$i]["name"] . " " . $comment[$i]["surname"] .'</h4> ';
                            echo '<span>-'.$comment[$i]["date"]. " Replies: ". $comment[$i]["amount"].'</span>';
                            echo '<br>';
                            echo '<p>'. $comment[$i]["comment"] .'</p>';
                            echo '</div>';
                            echo '<form action="reply.php" method="get" style="display: inline;">';
                            echo '<input type="hidden" name="reply_comment">';
                            echo '<input type="hidden" name="comment_id" value = "'.$comment[$i]['comment_id'].'">';
                            echo '<input type="submit"  value="Reply" class="btn" style="background-color: white; display: inline; margin-right: 20px;">';
                            echo '</form>';
                            if($_SESSION['id'] == $comment[$i]["user_id"] || $_SESSION['admin'] == 1){
                                echo '<form action="includes/comments.inc.php" method="post" style="display: inline;">';
                                echo '<input type="hidden" name="delete_comment">';
                                echo '<input type="hidden" name="comment_id" value = "'.$comment[$i]["comment_id"].'">';
                                echo '<input type="submit"  value="Delete Comment" class="btn" style="background-color: white; display: inline; margin-right: 20px;">';
                                echo '</form>';
                            }
                        }
                    }

                    ?>
                </div>
                <div class="col-lg-4 col-md-5 col-sm-4 offset-md-1 offset-sm-1 col-12 mt-4">
                    <form action="includes/comments.inc.php" id="align-form" class="form-comments" method="post">
                        <input type="hidden" name="add_comment">
                        <?php
                        echo '<input type="hidden" name="lesson_id" value = "'.$lesson_id.'">';
                        echo '<input type="hidden" name="user_id" value = "'.$_SESSION['id'].'">';
                        ?>

                        <div class="form-group">
                            <h4>Leave a comment</h4>
                            <textarea name="message" id=""msg cols="30" rows="5" class="form-control" style="background-color: white;"></textarea>
                        </div>
                        <br>

                        <div class="form-group">
                            <input type="submit" id="post" value="Post Comment" class="btn" style="background-color: white">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

<!--========== MAIN JS ==========-->
<script src="js/main-courses.js"></script>
<script src="js/app.js"></script>
<script src="js/lessons.js"></script>
<script>
    function openForm() {
        document.getElementById("myForm").style.display = "block";
    }

    function closeForm() {
        document.getElementById("myForm").style.display = "none";
    }
</script>
</body>
</html>
<?php
}
unset($_SESSION['lesson_description']);
unset($_SESSION['video_link']);
?>