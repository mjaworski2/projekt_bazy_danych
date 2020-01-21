<?php
function getHeader()
{
?>
    <html>

    <head>
        <title>Biblioteka</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="./">YourLibrary</a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="./books.php">Ksiażki</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./search.php">Szukaj</a>
                    </li>
                </ul>
            </div>
        </nav>
    <?php
}

function getFooter(){
    ?>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>
<?php
}
    ?>

<?php
function getStyles()
{
?>
<style>
        .row .basicInfo,
        .bookLend {
            margin-bottom: 2em;
            padding: 1em;
            padding-bottom: 0;
        }

        .row .bookLend {
            align-self: center;
        }

        .bookTitle {
            font-size: 140%;
        }

        .bookAuthor {
            color: #555;
        }

        .bookGenre {
            font-style: italic;
            color: #555;
        }

        .bookAdditionalInfo {
        }

        .main {
            margin-left: 2em;
            margin-top: 2em;
            margin-right: 2em;
        }
        .links{
            padding-top: 0.5em;
        }

    </style>
<?php
}
?>