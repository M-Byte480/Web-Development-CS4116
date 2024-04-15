<?php

setcookie('hashed_password', 'ca978112ca1bbdcafac231b39a23dc4da786eff8147c4e72b9807785afee48bb', time() + 60 * 60 * 24 * 7, '/');
setcookie('email', 'Tadhg963.test@example.com', time() + 60 * 60 * 24 * 7, '/');

header("Location: ./home/");
exit();
