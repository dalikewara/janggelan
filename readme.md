# Introduction

"Just an unexpected PHP Framework!" ~ Dali Kewara.

### Language Support

All documentations of the Framework for the time is only available for Indonesian. We'll updated for
English as soon as we can.

### Features (0.0.2 Z Rev 5)

- Some new free tools already to use. (Rev2/Rev3/Rev5)

- 2 new configuration files: /config/request.php, force.config. (Rev2)

- 2 new configuration files: /config/services.php, /config/cache.php (Rev5)

- New providers registration (Rev5)

- .secrets directory, saved place to config database informations (Rev5)

- Added Janggelan Default Cache System. Support: Memcache, Memcached (Rev5)

- Providers directory, easy way to use providers services (Rev5)

- Added new provider: [PhpFastCache](https://github.com/PHPSocialNetwork/phpfastcache) (Rev5)

- Tools directory (Rev5)

- Requests cached (Rev5)

- Request redirect system. You can redirect to specified view when the url user request doesn't registered yet. (Rev5)

- Some new info files (Rev5)

- Included HTML caching and compression in .htaccess file (Rev5)

- System improvement for protected_rule. (Rev2)

- System improvement for Database. (Rev2/Rev3)

- New worksheet directory. Worksheet is a place for you to do all works. You don't have to care about the system, just enjoy working in the worksheet. Configuration files still inside backend directory. (Rev4)

### Bugs Fixed

- Database Overload because too many active connections already repaired. (Rev3)

- Model $this return doesn't displayed fatal informations anymore. (Rev3)

### System Requirements

- PHP 7

- PDO PHP Extension

- Memcache/Memcached (Optional)

### How To Install

- You just have to download the Janggelan, extract it, copy the contents and place them into your
  application directory.

- If you want to publish or install Janggelan for shared hosting, the safest way to do is placed Janggelan's files and directories in the root, and moved all contents of the public folder into public_html or www.

- You will run your application from 'public/public_html/www' folder.

### Author

[Dali Kewara](http://dalikewara.com) | [<dalikewara@windowslive.com>](mailto:dalikewara@windowslice.com)

### License

[Janggelan](http://dalikewara.com/project/janggelan) is an open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
