FROM php:8.2-cli

RUN apt update && apt install -y wget ncat

RUN wget -q -O /usr/bin/wait-for https://raw.githubusercontent.com/eficode/wait-for/v2.2.3/wait-for && \
    chmod +x /usr/bin/wait-for

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libonig-dev \
    libzip-dev \
    zip

RUN docker-php-ext-install pdo_mysql mbstring zip

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN php -r "unlink('composer-setup.php');"

RUN useradd -u 1000 -ms /bin/bash php

USER php

WORKDIR /home/php/backend

COPY ./.bash_aliases /home/php/

EXPOSE 8081

CMD [ "/home/php/backend/docker/start.sh" ]
