
    <?php

        use Core\ConfigController;

        require './vendor/autoload.php';

        $url = new ConfigController;
        $url->loadPage();
    ?>
