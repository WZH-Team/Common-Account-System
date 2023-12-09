# Common-Account-System
通用账号系统

## 该内源项目遵循[Read-Me](https://github.com/WZH-Team/Read-Me)
此项目为内源项目的开源版本，最新版本为1.3（内源），此版本为1.1（开源）
此项目依赖Mysql数据库，请自行安装并配置好数据库后使用。相关安全问题将在内源版本解决，开源版本可自行提交issues要求团队更新

## SQL初始化
``` sql
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```