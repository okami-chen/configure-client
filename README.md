## 使用说明

## 配置发布

```php
php artisan vendor:publish
```
> 选择`configure-clent`进行发布

## 守护进程

1、使用`crontab`执行

2、使用`supervisor`

```php
php aratisan configure:client:daemon
```

## 事件

1、获取配置失败

`OkamiChen\ConfigureClient\Event\ConfigFailed`

2、获取配置成功

`OkamiChen\ConfigureClient\Event\ConfigSuccess`
