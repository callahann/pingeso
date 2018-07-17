<?php

return array(


    'pdf' => array(
        'enabled' => true,
        'binary'  => '/usr/local/bin/wkhtmltopdf-amd64',
        'timeout' => false,
        'options' => array(
            'footer-center' => 'Pagina [page] de [toPage]',
            'footer-font-size' => 8,
            'footer-left' => 'Documento de uso confidencial'
        ),
        'env'     => array(),
    ),
    'image' => array(
        'enabled' => true,
        'binary'  => '/usr/local/bin/wkhtmltoimage-amd64',
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),


);
