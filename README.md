# Laravel Custom Upload

## Memasang Helper
Setting autoload ```composer.json```
```
"autoload": {
    "files": [
        "helpers/config.php"
    ]
}
```

Lalu jalankan perintah
```
composer dump-autoload
```

## Penggunaan
Gunakan pada controller
```php
$file = doUpload([
    'file'=>$request->file, // Mendapatkan file
    'path'=>'uploads/', // Destinasi upload diluar folder storage
    'allow_type'=>'image/jpeg|image/gif|image/png', // Parameter MIME TYPE
    'allow_size'=>5000 // Ukuran yang dibolehkan
]);
```

Terimakasih
<br> **erick.wp**