<?php

function head($title = 'Darts') {
    ob_start();
    ?>
        <!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width" />
                <title><?= q($title) ?></title>
                <link rel="stylesheet" href="<?= u('/css/normalize.css') ?>">
                <link rel="stylesheet" href="<?= u('/css/foundation.css') ?>">
                <link rel="stylesheet" href="<?= u('/css/') ?>">
                <script src="<?= u('/js/vendor/custom.modernizr.js') ?>"></script>
            </head>
            <body data-url-prefix="<?= q(u('')) ?>">
                <div class="row content">
                    <div class="large-12 columns">
    <?php
    return ob_get_clean();
}

function foot() {
    ob_start();
    ?>
                    </div>
                </div>
                <script>
                document.write('<script src=' +
                ('__proto__' in {} ? '<?= u('/js/vendor/zepto') ?>' : '<?= u('/js/vendor/jquery') ?>') +
                '.js><\/script>')
                </script>
                <script src="<?= u('/js/foundation.min.js') ?>"></script>
                <script>
                    $(document).foundation();
                </script>
                <script src="<?= u('/js/darts.js') ?>"></script>
            </body>
        </html>
    <?php
    return ob_get_clean();
}
