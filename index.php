<?php

include './core/core.php';

echo 'Hello ' . (pengguna()?->getNama() ?? 'world') . '!';
