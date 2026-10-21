<?php
    return[
        "encryption_mode"   => config('app.cipher'),
        "encryption_key"    => config('app.key'),
        "path"              => base_path("storage/sessions"),
        "expiration_timeout"=> 86400,
        "session_driver"    => "file", //file|database,
        "prefix"    => "elframework"
    ];