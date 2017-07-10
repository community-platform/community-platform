# Installation

## PHP

The minimal requirements for this application is `PHP 7.0+`.

## Composer

Composer is required to install all the dependencies, the installation
is well described in the documentation: https://getcomposer.org/doc/00-intro.md#globally

When installed, use ``composer install`` command to install dependencies.

## Apache

The application needs ``mod_rewrite`` to be enabled and the following configuration file:

```
# /etc/apache2/sites-enabled/community-platform.conf
<VirtualHost <your-domain.com>:80>
    ServerName <your-domain.com>
    ServerAlias <www.your-domain.com>

    DocumentRoot /path/to/community-platform/web
    <Directory /path/to/community-platform/web>
        AllowOverride None
        Order Allow,Deny
        Allow from All

        <IfModule mod_rewrite.c>
            Options -MultiViews
            RewriteEngine On
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteRule ^(.*)$ app.php [QSA,L]
        </IfModule>
    </Directory>

    # uncomment the following lines if you install assets as symlinks
    # or run into problems when compiling LESS/Sass/CoffeScript assets
    # <Directory /path/to/community-platform/>
    #     Options FollowSymlinks
    # </Directory>

    # optionally disable the RewriteEngine for the asset directories
    # which will allow apache to simply reply with a 404 when files are
    # not found instead of passing the request into the full symfony stack
    <Directory /path/to/community-platform/web/bundles>
        <IfModule mod_rewrite.c>
            RewriteEngine Off
        </IfModule>
    </Directory>
    ErrorLog /var/log/apache2/community-platform_error.log
    CustomLog /var/log/apache2/community-platform_access.log combined
</VirtualHost>
```

> Don't forget to change domain name and path to `web` folder!

## Routing

There are actualy 2 routes/urls defined:

* / [GET]
* /webhooks/github [POST]

Only the **last one** MUST be totaly public to everyone, because this is the url needed
by GitHub to send information.

> Note that the application already return 404 or 405 (method not allowed) when needed.

## SMTP

We need an smtp port to be open in order to send mails. The port should be set up in `app/config/config.yml` file:

instead of:

```yaml
swiftmailer:
    transport: "%mailer_transport%"
    host:      "%mailer_host%"
    username:  "%mailer_user%"
    password:  "%mailer_password%"
    spool:     { type: memory }
```

we should see:

```yaml
swiftmailer:
    transport: "%mailer_transport%"
    host:      "%mailer_host%"
    username:  "%mailer_user%"
    password:  "%mailer_password%"
    port:      25 # the port used
    spool:     { type: memory }
```

> Note: indent using spaces instead of tab here, this is realy important.

## Cron task

we also need a cron task in order to "daily" executes a mail sending:

```
bin/console p:r:s
```

## Docker installation

Complete the environements variables in the `docker-compose.yml` file and execute `docker-compose up -d` command. The platform will be available at `http://127.0.0.1`.