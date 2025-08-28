FROM httpd:2.4.59

# PHP + mod_php 설치
RUN apt-get update && \
    apt-get install -y apache2 libapache2-mod-php8.2 php8.2-cli apache2-bin apache2-utils && \
    rm -rf /var/lib/apt/lists/*

# MPM: prefork 로 교체 (mod_php는 스레드세이프가 아님)
RUN sed -i 's/LoadModule mpm_event_module/#LoadModule mpm_event_module/' /usr/local/apache2/conf/httpd.conf && \
    echo "LoadModule mpm_prefork_module /usr/lib/apache2/modules/mod_mpm_prefork.so" >> /usr/local/apache2/conf/httpd.conf

# rewrite 모듈 활성화
RUN sed -i 's/^#LoadModule rewrite_module/LoadModule rewrite_module/' /usr/local/apache2/conf/httpd.conf

# mod_php 연결
RUN echo "LoadModule php_module /usr/lib/apache2/modules/libphp8.2.so" >> /usr/local/apache2/conf/httpd.conf && \
    echo "AddType application/x-httpd-php .php" >> /usr/local/apache2/conf/httpd.conf && \
    echo "DirectoryIndex index.php index.html" >> /usr/local/apache2/conf/httpd.conf && \
    echo "ServerName localhost" >> /usr/local/apache2/conf/httpd.conf

# 취약한 conf 추가
COPY vulnerable.conf /usr/local/apache2/conf/extra/vulnerable.conf
RUN echo "Include conf/extra/vulnerable.conf" >> /usr/local/apache2/conf/httpd.conf

WORKDIR /var/www/html
EXPOSE 80
CMD ["httpd-foreground"]
