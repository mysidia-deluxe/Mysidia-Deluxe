RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
#RewriteCond %{HTTP_HOST} ^www\.(.*) [NC]
#RewriteRule ^ http://%1%{REQUEST_URI} [L,R=301]
RewriteCond %{REQUEST_URI} !\.(js|css|gif|jpg|png|ico)$ [NC]
RewriteRule ^(.*)$ index.php [QSA,L]
RewriteRule ^get/([0-9]+).gif$ /click/siggy/$1 [L]
