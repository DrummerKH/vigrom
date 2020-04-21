#!/usr/bin/env sh

echo "eval \$(ssh-agent) > /dev/null && ssh-add /tmp/ssh-key" >> /etc/bash.bashrc

# Create JWT Token if not exists
if [ ! -f ${JWT_PRIVATE_KEY_PATH} ] || [ ! -f ${JWT_PUBLIC_KEY_PATH} ]; then

    echo 'JWT Token is not exists, creating...'

    mkdir -p /var/www/acquiring/jwt
    openssl genrsa -out ${JWT_PRIVATE_KEY_PATH} -aes256 -passout pass:${JWT_PASSPHRASE} 4096
    openssl rsa -pubout -in ${JWT_PRIVATE_KEY_PATH} -out ${JWT_PUBLIC_KEY_PATH}  -passin pass:${JWT_PASSPHRASE}
    chown www-data ${JWT_PRIVATE_KEY_PATH}
    chown www-data ${JWT_PUBLIC_KEY_PATH}
else
    echo 'JWT Token exists'
fi

echo 'Container deployed...'

tail -f /dev/stdout